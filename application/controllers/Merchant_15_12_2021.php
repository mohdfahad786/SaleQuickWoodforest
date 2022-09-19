<?php 
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }
  class Merchant extends CI_Controller {
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
      $this->load->library('twilio');
      
      //$this->load->model('sendmail_model');
      $this->load->model('session_checker_model');
      if (!$this->session_checker_model->chk_session_merchant()) {
        redirect('login');
      }
      if($this->session->userdata('time_zone')) {
        $time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
        date_default_timezone_set($time_Zone);
      }
      else
      {
        date_default_timezone_set('America/Chicago');
      }
         // ini_set('display_errors', 1);
         // error_reporting(E_ALL);
    }
    public function readallnotofication() {  
      if($merchantid=$this->input->post('merchantid') ) {
        $updatedata=array('status'=>'read'); 
        $this->db->where('merchant_id',$merchantid); 
        $m=$this->db->update('notification',$updatedata);
        echo '200';
          }
     
    }
    
    public function qb_test()
    {
        //$id = 3471;
        //$merchant_id = $this->session->userdata('merchant_id');
        //$this->quickbook->get_invoice_detail($id);
        //die();
        //$data_string = http_build_query($data);
        $url ="https://salequick.com/quickbook/get_invoice_detail_live_payment2";
        //$url ="https://salequick.com/quickbook/get_invoice_detail?id=".$id."&merchnat_id=".$merchant_id;
        $qbdata =array(
            'id' => 84,
            'merchant_id' => 413
            
          );
          
        //$id = 3316;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result,true);
        print_r($result);
    }
    
    public function readnotofication($id) {    
      if(isset($id)) {
        $this->db->where('id',$id); 
        $result=$this->db->get('notification')->row_array(); 
        $transaction_id=$result['transaction_id'];  
        $invoice_no=$result['invoice_no'];  
        $merchant_id=$result['merchant_id']; 
        $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
          $data['merchantdata'] = $getQuery1->result_array();
    
        if($transaction_id ||  $invoice_no) {
          $this->db->where('transaction_id',$transaction_id); 
          $this->db->or_where('invoice_no=',$invoice_no);
          // $this->db->where("(transaction_id='$transaction_id' OR invoice_no='$invoice_no')");
            // //$this->db->where('status','confirm'); 
          // $data['gettransaction']=$this->db->get('customer_payment_request')->row_array();
          $res=$this->db->get('customer_payment_request')->row_array(); 
          if(count($res) > 0 ) {
            $data['gettransaction']=$res; 
          } else {
            $this->db->where('transaction_id',$transaction_id); 
              $this->db->or_where('invoice_no=',$invoice_no);
               //$this->db->where('status','confirm'); 
              $res=$this->db->get('pos')->row_array(); 
              $data['gettransaction']=$res; 
          }
        }
            
        $notificationId=$id;
        $updatedata=array('status'=>'read'); 
        $this->db->where('id',$notificationId); 
        $m=$this->db->update('notification',$updatedata);
        
              $data["title"] ='Paid Payment Details';
              $data["meta"] ='Notification';
        $this->load->view('merchant/notification_dash',$data);
        // $this->load->view('merchant/notification',$data);
      }
    }

    public function index_original() {
        $data["title"] = "Merchant Panel";
        $data["meta"] ='Dashboard';
        
        if( $this->session->userdata('employee_id') ) {
            $merchant_id = $this->session->userdata('employee_id');
        } else {
            $merchant_id = $this->session->userdata('merchant_id');
        }
        
        $today2 = date("Y");
        $last_year = date("Y", strtotime("-1 year"));
        $last_date = date("Y-m-d", strtotime("-29 days"));
        $date = date("Y-m-d");
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
        $getDashboard = $this->db->query("SELECT 
            ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = CURDATE() and merchant_id = '" . $merchant_id . "' ) as NewTotalOrders,  ( SELECT count(id) as NewTotalOrders_p from pos where date_c = CURDATE() and merchant_id = '" . $merchant_id . "' ) as NewTotalOrders_p,  ( SELECT count(id) as TotalOrders from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' ) as TotalOrders, ( SELECT count(id) as TotalOrders_P from pos where status='confirm' and merchant_id = '" . $merchant_id . "' ) as TotalOrders_p, ( SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending'  and merchant_id = '" . $merchant_id . "') as TotalpendingOrders,
            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
        ");

        //echo $this->db->last_query();die;
        $getDashboardData = $getDashboard->result_array();
        //print_r($getDashboardData);  die(); 
        $data['getDashboardData'] = $getDashboardData;

        $getSaleByYear = $this->db->query("SELECT * from merchant_year_graph where merchant_id = ".$merchant_id." order by id desc limit 0,1");
        $getSaleByYearData = $getSaleByYear->result_array();
        // echo '<pre>';print_r($getSaleByYearData);die;
        $data['getSaleByYearData'] = $getSaleByYearData;
    
        $DashboardCountData = $this->db->query("SELECT 
            ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalPOSConfirm,
            ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
            ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
            ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoicePending,
            ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringPending,
            ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
            ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
        "); 
        //echo $this->db->last_query(); 
        //print_r(); 
        $DashboardCountData=$DashboardCountData->result_array();
   
        //print_r($DashboardCountData[0]['TotalPOSConfirm']);  die(); 
        $widgets_data = array(
            'NewTotalOrders'=>$DashboardCountData[0]['TotalPOSConfirm'], 
            'TotalOrders'=>$DashboardCountData[0]['TotalInvoiceConfirm']+$DashboardCountData[0]['TotalRecurringConfirm'], 
            'TotalpendingOrders'=>$DashboardCountData[0]['TotalInvoicePending']+$DashboardCountData[0]['TotalRecurringPending'], 
            'TotalAmount'=>0, 
            
            'TotalLate' => $DashboardCountData[0]['TotalInvoicePendingDueOver']+$DashboardCountData[0]['TotalRecurringPendingDueOver'],
        ); 
    
        $data['widgets_data'] = $widgets_data;
        $data1 = array();
        // $data['item'] = $this->admin_model->data_get_where_gg($last_date, $date,'confirm',$merchant_id,$employee,'customer_payment_request' );
        $package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
        $mem = array();
        $member = array();
        foreach ($package_data as $each) {
          $package['Amount'] = '$' . $each->amount;
          $package['Tax'] = '$' . $each->tax;
          $package['Card'] = Ucfirst($each->card_type);
          if ($each->type = 'straight') {
            $package['Type'] = 'Invoice';
          } else {
            $package['Type'] = $each->type;
          }
          $package['Date'] = $each->date_c;
          $package['Reference'] = $each->reference;
          $mem[] = $package;
        }
        $data['item'] = $mem;
        $package_data1 = $this->admin_model->data_get_where_down("recurring_payment", $date, $last_date, $merchant_id);
        $mem1 = array();
        $member1 = array();
        foreach ($package_data1 as $each) {
          $package1['Amount'] = '$' . $each->amount;
          $package1['Tax'] = '$' . $each->tax;
          $package1['Card'] = Ucfirst($each->card_type);
          if ($each->type = 'recurring') {
            $package1['Type'] = 'INV';
          } else {
            $package1['Type'] = $each->type;
          }
          $package1['Date'] = $each->date_c;
          $package1['Reference'] = $each->reference;
          $mem1[] = $package1;
        }
        $data['item1'] = $mem1;
        $package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
        $mem2 = array();
        $member2 = array();
        foreach ($package_data2 as $each) {
          if ($each->status == 'Chargeback_Confirm') {
            $package2['Amount'] = '-$' . $each->amount;
          } else {
            $package2['Amount'] = '$' . $each->amount;
          }
          $package2['Tax'] = '$' . $each->tax;
          $package2['Card'] = Ucfirst($each->card_type);
          $package2['Type'] = strtoupper($each->type);
          $package2['Date'] = $each->date_c;
          $package2['Reference'] = $each->reference;
          $mem2[] = $package2;
        }
        $data['item2'] = $mem2;
        $data['item3'] = json_encode(array_merge($data['item'], $data['item1'], $data['item2']));
        //  $data['highchart'] = $this->admin_model->get_details($merchant_id);
        // echo json_encode($data['highchart']);
        if ($this->input->post('start') != '') {
          echo json_encode($data);
          die();
        } else {
          // return $this->load->view('merchant/dashboard', $data);
          return $this->load->view('merchant/label_dashboard', $data);
        }
    }

    public function index() {
        $data["title"] = "Merchant Panel";
        $data["meta"] ='Dashboard';
        $month = date("m");
        $today2 = date("Y");
        
        
        if( $this->session->userdata('employee_id') ) {
            $merchant_id = $this->session->userdata('employee_id');
            $p_merchant_id = $this->session->userdata('merchant_id');
        } else {
            $merchant_id = $this->session->userdata('merchant_id');
             $p_merchant_id = $this->session->userdata('merchant_id');
        }

if($month=='07' ){
         $amount = $this->db->query("SELECT sum(amount) as Totaljuly from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '07' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '07' and year = '" . $today2 . "' and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totaljulyf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '07' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '07' and year = '" . $today2 . "' and status='confirm' )x group by month  ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totaljulytax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '07' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $p_merchant_id . "' and month = '07' and year = '" . $today2 . "' and status='confirm' )x group by month  ");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE merchant_year_graph SET Totaljuly='".$getamount[0]['Totaljuly']."' ,Totaljulyf='".$getfee[0]['Totaljulyf']."',Totaljulytax='".$gettax[0]['Totaljulytax']."' where merchant_id= '" . $p_merchant_id . "' ");


 }

 else if($month=='08'){
         $amount = $this->db->query("SELECT sum(amount) as Totalaugust from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '08' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '08' and year = '" . $today2 . "' and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totalaugustf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '08' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '08' and year = '" . $today2 . "' and status='confirm' )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totalaugusttax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '08' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $p_merchant_id . "' and month = '08' and year = '" . $today2 . "' and status='confirm' )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE merchant_year_graph SET Totalaugust='".$getamount[0]['Totalaugust']."' ,Totalaugustf='".$getfee[0]['Totalaugustf']."',Totalaugusttax='".$gettax[0]['Totalaugusttax']."'   where merchant_id= '" . $p_merchant_id . "' ");


}

else if($month=='09' ){
         $amount = $this->db->query("SELECT sum(amount) as Totalsep from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '09' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '09' and year = '" . $today2 . "' and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totalsepf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '09' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '09' and year = '" . $today2 . "' and status='confirm' )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totalseptax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '09' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $p_merchant_id . "' and month = '09' and year = '" . $today2 . "' and status='confirm' )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE merchant_year_graph SET Totalsep='".$getamount[0]['Totalsep']."' ,Totalsepf='".$getfee[0]['Totalsepf']."',Totalseptax='".$gettax[0]['Totalseptax']."'   where merchant_id= '" . $p_merchant_id . "' ");


}

else if($month=='10' ){
         $amount = $this->db->query("SELECT sum(amount) as Totaloct from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '10' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '10' and year = '" . $today2 . "' and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totaloctf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '10' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '10' and year = '" . $today2 . "' and status='confirm' )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totalocttax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '10' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $p_merchant_id . "' and month = '10' and year = '" . $today2 . "' and status='confirm' )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE merchant_year_graph SET Totaloct='".$getamount[0]['Totaloct']."' ,Totaloctf='".$getfee[0]['Totaloctf']."',Totalocttax='".$gettax[0]['Totalocttax']."'   where merchant_id= '" . $p_merchant_id . "' ");


}
else if($month=='11'){
         $amount = $this->db->query("SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totalnovf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totalnovtax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE merchant_year_graph SET Totalnov='".$getamount[0]['Totalnov']."' ,Totalnovf='".$getfee[0]['Totalnovf']."',Totalnovtax='".$gettax[0]['Totalnovtax']."'   where merchant_id= '" . $p_merchant_id . "' ");


}
else if($month=='12'){

  //
   $amount = $this->db->query("SELECT sum(amount) as Totalnov from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totalnovf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totalnovtax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $p_merchant_id . "' and month = '11' and year = '" . $today2 . "' and status='confirm' )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE merchant_year_graph SET Totalnov='".$getamount[0]['Totalnov']."' ,Totalnovf='".$getfee[0]['Totalnovf']."',Totalnovtax='".$gettax[0]['Totalnovtax']."'   where merchant_id= '" . $p_merchant_id . "' ");
           //
         $amount = $this->db->query("SELECT sum(amount) as Totaldec from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '12' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '12' and year = '" . $today2 . "' and status='confirm' )x group by month  ");
          
      $getamount = $amount->result_array();

          $fee = $this->db->query("SELECT avg(amount) as Totaldecf from ( SELECT month,amount from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '12' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,amount from pos where merchant_id = '" . $p_merchant_id . "' and month = '12' and year = '" . $today2 . "' and status='confirm' )x group by month ");

         $getfee = $fee->result_array();

           $tax = $this->db->query("SELECT sum(tax) as Totaldectax from ( SELECT month,tax from customer_payment_request where merchant_id = '" . $p_merchant_id . "' and month = '12' and year = '" . $today2 . "' and status='confirm'    union all SELECT month,tax from pos where merchant_id = '" . $p_merchant_id . "' and month = '12' and year = '" . $today2 . "' and status='confirm' )x group by month");

           $gettax = $tax->result_array();
          
           $amount = $this->db->query("UPDATE merchant_year_graph SET Totaldec='".$getamount[0]['Totaldec']."' ,Totaldecf='".$getfee[0]['Totaldecf']."',Totaldectax='".$gettax[0]['Totaldectax']."'   where merchant_id= '" . $p_merchant_id . "' ");


}

        $getSaleByYear = $this->db->query("SELECT * from merchant_year_graph where merchant_id = ".$p_merchant_id." order by id desc limit 0,1");
        $getSaleByYearData = $getSaleByYear->result_array();
        // echo '<pre>';print_r($getSaleByYearData);die;
        $data['getSaleByYearData'] = $getSaleByYearData;
    
        return $this->load->view('merchant/label_dashboard', $data);
    }

    public function getGraphData() {
        // echo '<pre>';print_r($_POST);die;
        $response = array();
        $user = array();

        if( $this->session->userdata('employee_id') ) {
            $merchant_id = $this->session->userdata('employee_id');
        } else {
            $merchant_id = $this->session->userdata('merchant_id');
        }
        
        $date_c = date("Y-m-d", strtotime($_POST['start']));
        $date_cc = date('Y-m-d', strtotime($this->input->post('end') . ' +1 day'));
        $employee = $_POST['employee'];
        $date = date("Y-m-d");
        $last_date = date("Y-m-d", strtotime("-29 days"));
        // $last_date = date('Y-m-d', strtotime($this->input->post('end') . ' +1 day'));

       if($_POST['employee'] == 'all') {
            $stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(`amount`-`p_ref_amount`) as amount,sum(tax) as tax,avg(amount) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and (status='confirm' or partial_refund=1) and merchant_id= '".$merchant_id."' union all SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and (status='confirm' or partial_refund=1) and merchant_id= '".$merchant_id."'  ) x group by date_c");
    
        } else {
            $stmt = $this->db->query("SELECT id,merchant_id,invoice_no ,sum(`amount`-`p_ref_amount`) as amount,sum(tax) as tax,avg(amount) as fee,name,date_c from ( SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from customer_payment_request where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and (status='confirm' or partial_refund=1) and sub_merchant_id='".$employee."' and merchant_id= '".$merchant_id."' union all SELECT id,merchant_id,invoice_no,amount,p_ref_amount,tax,fee,name,date_c from pos where date_c >= '".$date_c."' and date_c <= '".$date_cc."' and (status='confirm' or partial_refund=1) and sub_merchant_id='".$employee."' and merchant_id= '".$merchant_id."'  ) x group by date_c");
        }
        // echo $this->db->last_query();die;

        if ($stmt->num_rows() > 0) {
            foreach ($stmt->result_array() as $result) {
                $temp = array(
                    'date'              => $result['date_c'],
                    'amount'            => $result['amount'],
                    'clicks'            => !empty($result['tax']) ? $result['tax'] : '0.00',
                    'cost'              => number_format($result['fee'],2),
                    'tax'               => !empty($result['tax']) ? $result['tax'] : '0.00',
                    'converted_people'  => !empty($result['tax']) ? $result['tax'] : '0.00',
                    'revenue'           => !empty($result['tax']) ? $result['tax'] : '0.00',
                    'linkcost'          => !empty($result['tax']) ? $result['tax'] : '0.00'
                );
                array_push($user, $temp);
            }

        } else {
            $user = array();
            $temp = array(
                'date'              => $date_c,
                'amount'            => "0",
                'clicks'            => "0",
                'cost'              => "0",
                'tax'               => "0",
                'converted_people'  => "0",
                'revenue'           => "0",
                'linkcost'          => "0"
            );
            array_push($user, $temp);
        }
        $responseData['saleData'] = $user;

        if ($employee == 'all') {
            $sub_merchant_id = $merchant_id;
        } else {
            $sub_merchant_id = $employee;
        }
        $getDashboard = $this->db->query("SELECT 
            ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = CURDATE() and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "' ) as NewTotalOrders,
            ( SELECT count(id) as NewTotalOrders_p from pos where date_c = CURDATE() and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "' ) as NewTotalOrders_p,
            ( SELECT count(id) as TotalOrders from customer_payment_request where status='confirm' and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "' ) as TotalOrders,
            ( SELECT count(id) as TotalOrders_P from pos where status='confirm' and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "' ) as TotalOrders_p,
            ( SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending'  and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "' ) as TotalpendingOrders,
            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "'  ) as TotalAmount ,
            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "') as TotalAmountRe ,
            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $sub_merchant_id . "' and date_c >= '" . $date_c . "' and date_c <= '" . $date_cc . "') as TotalAmountPOS
        ");
        $getDashboardData = $getDashboard->result_array();
        $responseData['getDashboardData'] = $getDashboardData;
        
        $DashboardCountData = $this->db->query("SELECT 
            ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$date_c' AND '$date_cc' and merchant_id = $sub_merchant_id ) as TotalPOSConfirm,
            ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$date_c' AND '$date_cc' and merchant_id = $sub_merchant_id ) as TotalInvoiceConfirm,
            ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$date_c' AND '$date_cc' and merchant_id = $sub_merchant_id ) as TotalRecurringConfirm,
            ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$date_c' AND '$date_cc' and merchant_id = $sub_merchant_id ) as TotalInvoicePending,
            ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$date_c' AND '$date_cc' and merchant_id = $sub_merchant_id ) as TotalRecurringPending,
            ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$date_c' AND '$date_cc' and merchant_id = $sub_merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
            ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$date_c' AND '$date_cc' and merchant_id = $sub_merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
        "); 
        //echo $this->db->last_query(); 
        //print_r(); 
        $DashboardCountData=$DashboardCountData->result_array();
        // $responseData['DashboardCountData'] = $DashboardCountData;
   
        //print_r($DashboardCountData[0]['TotalPOSConfirm']);  die(); 
        $widgets_data = array(
            'NewTotalOrders' => $DashboardCountData[0]['TotalPOSConfirm'], 
            'TotalOrders' => $DashboardCountData[0]['TotalInvoiceConfirm']+$DashboardCountData[0]['TotalRecurringConfirm'], 
            'TotalpendingOrders' => $DashboardCountData[0]['TotalInvoicePending']+$DashboardCountData[0]['TotalRecurringPending'], 
            'TotalAmount' => 0,
            'TotalLate' => $DashboardCountData[0]['TotalInvoicePendingDueOver']+$DashboardCountData[0]['TotalRecurringPendingDueOver'],
        );
        $responseData['widgets_data'] = $widgets_data;

        $response = $responseData;
        echo json_encode($response);
    }

  public function index2() {
     // print_r( $this->session->userdata());
    $data["title"] = "Merchant Panel";
    $merchant_id = $this->session->userdata('merchant_id');
    $today2 = date("Y");
    $last_year = date("Y", strtotime("-1 year"));
    $last_date = date("Y-m-d", strtotime("-29 days"));
    $date = date("Y-m-d");
    $start = $this->input->post('start');
    $end = $this->input->post('end');
    $employee = $this->input->post('employee');
    //$last_date1 = date("Y-m-d",strtotime("-29 days"));
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
      $getDashboard = $this->db->query("SELECT
                            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
                            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
                            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
                   ");
        $DashboardCountData = $this->db->query("SELECT 
      ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalPOSConfirm,
      ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
      ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
      ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoicePending,
      ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringPending,
      ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
      ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
          
          "); 
    } elseif ($employee == 'merchant') {
      $getDashboard = $this->db->query("SELECT
                            (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
                            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
                            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
                   ");
      $DashboardCountData = $this->db->query("SELECT 
      ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalPOSConfirm,
      ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
      ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
      ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoicePending,
      ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringPending,
      ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
      ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
          
          "); 
    } else {
      $getDashboard = $this->db->query("SELECT
                      (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and sub_merchant_id ='" . $employee . "' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
                            (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and sub_merchant_id ='" . $employee . "'  and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
                            (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and sub_merchant_id ='" . $employee . "'  and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
                   ");
      $DashboardCountData = $this->db->query("SELECT 
      ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalPOSConfirm,
      ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
      ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
      ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalInvoicePending,
      ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalRecurringPending,
      ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
      ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
          
          ");
        
    }
    $getDashboardData = $getDashboard->result_array();
    $data['getDashboardData'] = $getDashboardData;
    $DashboardCountData=$DashboardCountData->result_array();
       //print_r($DashboardCountData[0]['TotalPOSConfirm']);  die(); 
     $widgets_data = array(
    'NewTotalOrders'=>$DashboardCountData[0]['TotalPOSConfirm'], 
    'TotalOrders'=>$DashboardCountData[0]['TotalInvoiceConfirm']+$DashboardCountData[0]['TotalRecurringConfirm'], 
    'TotalpendingOrders'=>$DashboardCountData[0]['TotalInvoicePending']+$DashboardCountData[0]['TotalRecurringPending'], 
    'TotalAmount'=>0, 
    'TotalLate' => $DashboardCountData[0]['TotalInvoicePendingDueOver']+$DashboardCountData[0]['TotalRecurringPendingDueOver'],
          ); 
     $data['widgets_data'] = $widgets_data;
     
     $getA_merchantData=$this->admin_model->select_request_id('merchant',$merchant_id); 
     if($getA_merchantData->csv_Customer_name > 0 ){ $name='name';}else{$name='';}; 
     // echo  $name; die('lk'); 
     $data1 = array();
     $package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
     $mem = array();
     $member = array();
     $sum = 0;
     $sum_ref = 0;
     foreach ($package_data as $each) {
       $package['Amount'] = '$' . $each->amount;
       $sum += $each->amount;
       $package['Tax'] = '$' . $each->tax;
        $package['Tip'] = '$' . $each->tip_amount;
       $package['Card'] = Ucfirst($each->card_type);
       if ($each->type == 'straight') {
         $package['Type'] = 'INV';
       } else {
         $package['Type'] = $each->type;
       }
       $package['Date'] = $each->add_date;
       $package['Reference'] = $each->reference;
      if($getA_merchantData->csv_Customer_name > 0 ){ $package['Name'] = "--";} 
       $package['Items'] =   $each->items;
       $mem[] = $package;
       
     }
     $data['item'] = $mem;
     $package_data1 = $this->admin_model->data_get_where_down("recurring_payment", $date, $last_date, $merchant_id);
     $mem1 = array();
     $member1 = array();
     $sum1 = 0;
     $sum_ref1 = 0;
     foreach ($package_data1 as $each) {
       if ($each->status == 'Chargeback_Confirm') {
         $package1['Amount'] = '-$' . $each->amount;
         $sum_ref1 += $each->amount;
       } else {
         $package1['Amount'] = '$' . $each->amount;
         $sum1 += $each->amount;
       }
        $package['Tax'] = '$' . $each->tax;
       $package1['Tip'] = '$0.00';
       $package1['Card'] = Ucfirst($each->card_type);
       if ($each->type = 'recurring') {
         $package1['Type'] = 'INV';
       } else {
         $package1['Type'] = $each->type;
       }
       $package1['Date'] = $each->add_date;
       $package1['Reference'] = $each->reference;
       if($getA_merchantData->csv_Customer_name > 0 ){ $package1['Name'] = "--";} 
       $package1['Items'] =   $each->items;
       $mem1[] = $package1;
     }
     $data['item1'] = $mem1;
     $package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
     $mem2 = array();
     $member2 = array();
     $sum2 = 0;
     $sum_ref2 = 0;
     
     foreach ($package_data2 as $each) {
       $package2['Amount'] = '$' . $each->amount;
       $sum2 += $each->amount;
       $package2['Tax'] = '$' . $each->tax;
        $package['Tip'] = '$' . $each->tip_amount;
       $package2['Card'] = Ucfirst($each->card_type);
       $package2['Type'] = strtoupper($each->type);
       $package2['Date'] = $each->add_date;
       $package2['Reference'] = $each->reference;
       if($getA_merchantData->csv_Customer_name > 0 ){ $package2['Name'] = $each->name;} 
       $package2['Items'] = $each->items;
       $mem2[] = $package2;
       // if ($each->status == 'Chargeback_Confirm') {
       //   $refund['Amount'] = '-$' . $each->amount;
       //   $refund['Tax'] = '$' . $each->tax;
       //   $refund['Card'] = Ucfirst($each->card_type);
       //   $refund['Type'] = strtoupper($each->type) . "-Refunded";
       //   $refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
       //   $refund['Reference'] = $each->reference;
       //   $mem2[] = $refund;
       //   $sum_ref2 += $each->amount;
       // }
     }
     $data['item2'] = $mem2;
// for refund
     $package_data3 = $this->admin_model->get_refund_data($date, $last_date, $merchant_id);
     $mem3 = array();
     $member3 = array();
     $sum3 = 0;
     $sum_ref3 = 0;
     foreach ($package_data3 as $each) {
       if ($each->status == 'Chargeback_Confirm') {
         $refund['Amount'] = '-$' . $each->amount;
         $refund['Tax'] = '$' . $each->tax;
          $package['Tip'] = '-$' . $each->tip_amount;
         $refund['Card'] = Ucfirst($each->card_type);
         if ($each->type == 'straight') {
           $refund['Type'] = 'INV-Refunded';
         } else {
           $refund['Type'] = strtoupper($each->type) . "-Refunded";
         }
         $refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
         $refund['Reference'] = $each->reference;
         if($getA_merchantData->csv_Customer_name > 0 ){ $refund['Name'] ="--";} 
         $refund['Items'] =  '--';
         $mem3[] = $refund;
         $sum_ref3 += $each->amount;
       }
     }
     $data['item_refund'] = $mem3;
     $totalsum = number_format($sum + $sum1 + $sum2, 2);
     $totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3, 2);
     if($getA_merchantData->csv_Customer_name > 0 ){ 
        $data['item4'] = [
          [
            "Amount" => "",
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Name"=>'',
            "Items" => '',
          ],
          [
            "Amount" => "Sum Amount = $ " . $totalsum,
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Name"=>'',
            "Items" => '',
          ],
    
          [
            "Amount" => "Refund Amount = $ " . $totalsumr,
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Name"=>'',
            "Items" => '',
          ],
          [
            "Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Name"=>'',
            "Items" => '',
          ],
        ];
    }
    else
    {
      $data['item4'] = [
        [
          "Amount" => "",
          "Tax" => '',
          "Tax" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Items" => '',
        ],
        [
          "Amount" => "Sum Amount = $ " . $totalsum,
          "Tax" => '',
          "Tax" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Items" => '',
        ],
   
        [
          "Amount" => "Refund Amount = $ " . $totalsumr,
          "Tax" => '',
          "Tax" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Items" => '',
        ],
        [
          "Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
          "Tax" => '',
          "Tax" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Items" => '',
        ],
      ];
    }
     
    $data['item5'] = [
      [
        "Sum_Amount" => $totalsum,
        "is_Customer_name"=>$getA_merchantData->csv_Customer_name,
        "Refund_Amount" => $totalsumr,
        "Total_Amount" => number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2)
      ]
    ]; 
     
     
     $arr = array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund']);
     array_multisort(array_column($arr, 'Date'), SORT_DESC, $arr);    
    
     $data['item3']=json_encode(array_merge($arr, $data['item4']));
     $data['item5']=json_encode($data['item5']);
    //$data['item3'] = json_encode(array_merge($data['item'], $data['item1'], $data['item2'], $data['item4']));
    if ($this->input->post('start') != '') {
      echo json_encode($data);
      die();
    } else {
      return $this->load->view('merchant/dashboard', $data);
    }
  }
  public function index1() {
    $data["title"] = "Merchant Panel";
    // $merchant_id = $this->session->userdata('merchant_id');
    if( $this->session->userdata('employee_id') ) {
        $merchant_id = $this->session->userdata('employee_id');
    } else {
        $merchant_id = $this->session->userdata('merchant_id');
    }
    
    $today2 = date("Y");
    $last_year = date("Y", strtotime("-1 year"));
    $last_date = date("Y-m-d", strtotime("-29 days"));
    $date = date("Y-m-d");
    $start = $this->input->post('start');
    $end = $this->input->post('end');
    $employee = $this->input->post('employee');
    //$last_date1 = date("Y-m-d",strtotime("-29 days"));
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
      $getDashboard = $this->db->query("SELECT
      (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
      (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
      (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
      ");
        $DashboardCountData = $this->db->query("SELECT 
      ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalPOSConfirm,
      ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
      ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
      ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoicePending,
      ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringPending,
      ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
      ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
      "); 
    } elseif ($employee == 'merchant') {
      $getDashboard = $this->db->query("SELECT
      (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
      (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
      (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
      ");
      $DashboardCountData = $this->db->query("SELECT 
      ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalPOSConfirm,
      ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
      ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
      ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalInvoicePending,
      ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id ) as TotalRecurringPending,
      ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
      ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
      "); 
    } else {
      $getDashboard = $this->db->query("SELECT
      (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' and sub_merchant_id ='" . $employee . "' and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "'  ) as TotalAmount ,
      (SELECT sum(amount) as TotalAmountRe from recurring_payment where status='confirm' and sub_merchant_id ='" . $employee . "'  and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountRe ,
      (SELECT sum(amount) as TotalAmountPOS from pos where status='confirm' and sub_merchant_id ='" . $employee . "'  and merchant_id = '" . $merchant_id . "' and date_c >= '" . $last_date . "' and date_c <= '" . $date . "') as TotalAmountPOS
      ");
      $DashboardCountData = $this->db->query("SELECT 
      ( SELECT count(id) as TotalPOSConfirm from pos where status='confirm'AND date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalPOSConfirm,
      ( SELECT count(id) as TotalInvoiceConfirm from customer_payment_request where status='confirm' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalInvoiceConfirm,
      ( SELECT count(id) as TotalRecurringConfirm from recurring_payment where status='confirm' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalRecurringConfirm,
      ( SELECT count(id) as TotalInvoicePending from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalInvoicePending,
      ( SELECT count(id) as TotalRecurringPending from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id ) as TotalRecurringPending,
      ( SELECT count(id) as TotalInvoicePendingDueOver from customer_payment_request where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id AND due_date< CURDATE()) as TotalInvoicePendingDueOver,
      ( SELECT count(id) as TotalRecurringPendingDueOver from recurring_payment where status='pending' and date_c BETWEEN '$last_date' AND '$date' AND sub_merchant_id ='" . $employee . "' and merchant_id = $merchant_id AND due_date< CURDATE() ) as TotalRecurringPendingDueOver
      ");
        
    }
    $getDashboardData = $getDashboard->result_array();
    $data['getDashboardData'] = $getDashboardData;
      $DashboardCountData=$DashboardCountData->result_array();
        //print_r($DashboardCountData[0]['TotalPOSConfirm']);  die(); 
      $widgets_data = array(
    'NewTotalOrders'=>$DashboardCountData[0]['TotalPOSConfirm'], 
    'TotalOrders'=>$DashboardCountData[0]['TotalInvoiceConfirm']+$DashboardCountData[0]['TotalRecurringConfirm'], 
    'TotalpendingOrders'=>$DashboardCountData[0]['TotalInvoicePending']+$DashboardCountData[0]['TotalRecurringPending'], 
    'TotalAmount'=>0, 
    'TotalLate' => $DashboardCountData[0]['TotalInvoicePendingDueOver']+$DashboardCountData[0]['TotalRecurringPendingDueOver'],
          ); 
     $data['widgets_data'] = $widgets_data;
     $getA_merchantData=$this->admin_model->select_request_id('merchant',$merchant_id); 
     if($getA_merchantData->csv_Customer_name > 0 ){ $name='name';}else{$name='';}; 
     // echo  $name; die('lk'); 
     $data1 = array();
     $package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
     $mem = array();
     $member = array();
     $sum = 0;
     $sum_ref = 0;
     $sum_discount=0;
     $sum_tip1=0;
     foreach ($package_data as $each) {
       $package['Amount'] = '$' . $each->amount;
       $sum += $each->amount;
       $sum_tip1 += $each->tip_amount;
       $package['Tax'] = '$' . $each->tax;
       $package['Tip'] = '$' . $each->tip_amount;
       $package['Card'] = Ucfirst($each->card_type);
       if ($each->type == 'straight') {
         $package['Type'] = 'INV';
       } else {
         $package['Type'] = $each->type;
       }
       $package['Date'] = $each->add_date;
       $package['Reference'] = $each->reference;
       $package['Discount'] =0;
      if($getA_merchantData->csv_Customer_name > 0 ){ $package['Name'] = "--";} 
       $package['Items'] =   $each->items;
       $sum_discount+=0;
       $mem[] = $package;
       
     }
     $data['item'] = $mem;
     $package_data1 = $this->admin_model->data_get_where_down("recurring_payment", $date, $last_date, $merchant_id);
     $mem1 = array();
     $member1 = array();
     $sum1 = 0;
     $sum_ref1 = 0;
     $sum_discount1=0;
     foreach ($package_data1 as $each) {
       if ($each->status == 'Chargeback_Confirm') {
         $package1['Amount'] = '-$' . $each->amount;
         $sum_ref1 += $each->amount;
       } else {
         $package1['Amount'] = '$' . $each->amount;
         $sum1 += $each->amount;
       }
       $package1['Tip'] = '$0.00' ;
       $package1['Tax'] = '$' . $each->tax;
       $package1['Card'] = Ucfirst($each->card_type);
       if ($each->type = 'recurring') {
         $package1['Type'] = 'INV';
       } else {
         $package1['Type'] = $each->type;
       }
       $package1['Date'] = $each->add_date;
       $package1['Reference'] = $each->reference;
       $package1['Discount'] =0;
       
       if($getA_merchantData->csv_Customer_name > 0 ){ $package1['Name'] = "--";} 
       $package1['Items'] =   $each->items;
       $sum_discount1+=0;
       $mem1[] = $package1;
     }
     $data['item1'] = $mem1;
     $package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
     
     $mem2 = array();
     $member2 = array();
     $sum2 = 0;
     $sum_ref2 = 0;
     $sum_discount2=0;
     foreach ($package_data2 as $each) {
       $package2['Amount'] = '$' . $each->amount;
       $sum2 += $each->amount;
       $sum_tip1 += $each->tip_amount;
       $package2['Tax'] = '$' . $each->tax;
       $package2['Tip'] = '$' . $each->tip_amount;
       $package2['Card'] = Ucfirst($each->card_type);
       $package2['Type'] = strtoupper($each->type);
       $package2['Date'] = $each->add_date;
       $package2['Reference'] = $each->reference;
       $package2['Discount'] = $each->discount; 
       $sum_discount2+=number_format($each->discount);
       if($getA_merchantData->csv_Customer_name > 0 ){ $package2['Name'] = $each->name;} 
       $package2['Items'] = $each->items;
       $mem2[] = $package2;
       
     }
     $data['item2'] = $mem2;
     //print_r($mem2);  die; 
    // for refund
     $package_data3 = $this->admin_model->get_refund_data($date, $last_date, $merchant_id);
     $mem3 = array();
     $member3 = array();
     $sum3 = 0;
     $sum_ref3 = 0;
     $sum_discount3=0;
     $sum_refund_tip=0;
     foreach ($package_data3 as $each) {
       if ($each->status == 'Chargeback_Confirm') {
         $refund['Amount'] = '-$' .$each->refund_amount;
         $refund['Tax'] = '$' . $each->tax;
         $sum_refund_tip += $each->tip_amount;
         $refund['Tip'] = '-$' . $each->tip_amount;
         $refund['Card'] = Ucfirst($each->card_type);
         if($each->type == 'straight') {
           $refund['Type'] = 'INV-Refunded';
         } else {
           $refund['Type'] = strtoupper($each->type)."-Refunded";
         }
         $refund['Date'] = (!empty($each->refund_dt)) ? $each->refund_dt : $each->date_c;
         $refund['Reference'] = $each->reference;
         $refund['Discount'] =0;
         if($getA_merchantData->csv_Customer_name > 0 ){ $refund['Name'] ="--";} 
         $refund['Items'] =  '--';
         $mem3[] = $refund;
         $sum_ref3 += $each->refund_amount;
         $sum_discount3+=0;
       }
     }
     $data['item_refund'] = $mem3;
     $totalDiscountsum = number_format($sum_discount + $sum_discount1 + $sum_discount2+$sum_discount3, 2);
     $totalsum = number_format($sum + $sum1 + $sum2, 2);
     $totalsumr = number_format($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3, 2);
     $totalTip= $sum_tip1 - $sum_refund_tip;
     if($getA_merchantData->csv_Customer_name > 0 ){ 
        $data['item4'] = [
          [
            "Amount" => "",
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Discount"=>'',
            "Name"=>'',
            "Items" => '',
          ],
          [
            "Amount" => "Sum Amount = $ " . $totalsum,
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Discount"=>'',
            "Name"=>'',
            "Items" => '',
          ],
    
          [
            "Amount" => "Refund Amount = $ " . $totalsumr,
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Discount"=>'',
            "Name"=>'',
            "Items" => '',
          ],
          [
            "Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Discount"=>'',
            "Name"=>'',
            "Items" => '',
          ],
          [
            "Amount" => "Total Tip Amount = $ " . $totalTip,
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Discount"=>'',
            "Name"=>'',
            "Items" => '',
          ],
          [
            "Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
            "Tax" => '',
            "Tip" => '',
            "Card" => '',
            "Type" => '',
            "Date" => '',
            "Reference" => '',
            "Discount"=>'',
            "Name"=>'',
            "Items" => '',
          ]
        ];
    }
    else
    {
      $data['item4'] = [
        [
          "Amount" => "",
          "Tax" => '',
          "Tip" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Discount"=>'',
          "Items" => '',
        ],
        [
          "Amount" => "Sum Amount = $ " . $totalsum,
          "Tax" => '',
          "Tip" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Discount"=>'',
          "Items" => '',
        ],
   
        [
          "Amount" => "Refund Amount = $ " . $totalsumr,
          "Tax" => '',
          "Tip" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Discount"=>'',
          "Items" => '',
        ],
        [
          "Amount" => "Total Amount = $ " . number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
          "Tax" => '',
          "Tip" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Discount"=>'',
          "Items" => '',
        ],
        [
          "Amount" => "Total Tip Amount = $ " . $totalTip,
          "Tax" => '',
          "Tip" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Discount"=>'',
          "Items" => '',
        ],
        [
          "Amount" => "Total Discount Amount = $ " . $totalDiscountsum,
          "Tax" => '',
          "Tip" => '',
          "Card" => '',
          "Type" => '',
          "Date" => '',
          "Reference" => '',
          "Discount"=>'',
          "Items" => '',
        ]
      ];
    }
     
    $data['item5'] = [
      [
        "Sum_Amount" => $totalsum,
        "is_Customer_name"=>$getA_merchantData->csv_Customer_name,
        "Refund_Amount" => $totalsumr,
        "Total_Amount" => number_format(($sum + $sum1 + $sum2) - ($sum_ref + $sum_ref1 + $sum_ref2 + $sum_ref3),2),
        "Total_Discount_Amount"=>$totalDiscountsum
      ]
    ]; 
     
     
     $arr = array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund']);
     array_multisort(array_column($arr, 'Date'), SORT_DESC, $arr);    
    
     $data['item3']=json_encode(array_merge($arr, $data['item4']));  
    // $data['item3']=json_encode($data['item']);
     $data['item5']=json_encode($data['item5']);
    //$data['item3'] = json_encode(array_merge($data['item'], $data['item1'], $data['item2'], $data['item_refund'], $data['item4']));
    // if ($this->input->post('start') != '') {
    //  echo json_encode($data);
    //  die();
    // } else {
    //  return $this->load->view('merchant/dashboard', $data);
    // }
     echo json_encode($data);
    die();
  }
  public function my_encrypt($string, $action = 'e') {
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
  public function add_employee() {
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
      $password = $this->my_encrypt($password1, 'e');
      if(isset($_POST['emp_refund'])) {
        $emp_refund = '1';
      } else {
        $emp_refund = '0';
      }
      // echo $emp_refund;die;
      $view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
      $edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
      $create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') : '0' . "";
      
       $view_menu_permissions='';
            $view_menu_permissions .=$this->input->post('ViewPermissions') ? $this->input->post('ViewPermissions').',' : "";  
            $view_menu_permissions .=$this->input->post('AddPermissions') ? $this->input->post('AddPermissions').',' : "";  
      $view_menu_permissions .=$this->input->post('EditPermissions') ? $this->input->post('EditPermissions').',' : "";  
      $view_menu_permissions .=$this->input->post('DeletePermissions') ? $this->input->post('DeletePermissions').',' : ""; 
            $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
            $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
      $view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
            $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
            $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
      $view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
      $view_menu_permissions .= $this->input->post('VirtualTerminal') ? $this->input->post('VirtualTerminal').',' : "";  
            $view_menu_permissions .= $this->input->post('IInvoicing') ? $this->input->post('IInvoicing').',' : "";  
      $view_menu_permissions .= $this->input->post('IRecurring') ? $this->input->post('IRecurring').',' : "";  
      $view_menu_permissions .= $this->input->post('RInstoreMobile') ? $this->input->post('RInstoreMobile').',' : "";
      $view_menu_permissions .= $this->input->post('RInvoice') ? $this->input->post('RInvoice').',' : "";
            $view_menu_permissions .= $this->input->post('ItemsManagement') ? $this->input->post('ItemsManagement').',' : "";  
      $view_menu_permissions .= $this->input->post('Reports') ? $this->input->post('Reports').',' : "";  
      $view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";
      
      if ($this->form_validation->run() == FALSE) {
        // $this->load->view("merchant/add_employee", $data);
        $this->load->view("merchant/add_employee_dash", $data);
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
          'view_menu_permissions'=>$view_menu_permissions,
          'status' => 'active',
          'date_c' => $today2,
          'emp_refund' => $emp_refund,
        );
        $this->db->where('email',$email); 
        $this->db->where('user_type ','employee'); 
        $getresultdata=$this->db->get('merchant')->row_array();
        // echo '<pre>';print_r($getresultdata);die;
        if(count($getresultdata) <= '0'){
          $id = $this->admin_model->insert_data("merchant", $data);
        }
        
        redirect(base_url() . 'merchant/all_employee');
      }
    } else {
      // $this->load->view("merchant/add_employee", $data);
      $this->load->view("merchant/add_employee_dash", $data);
    }
  }
  public function edit_employee() {
    $data['meta'] = "Edit Employee Details";
    $data['action'] = "Update Employee";
    $data['loc'] = "edit_employee";
    $bct_id = $this->uri->segment(3);
    if (!$bct_id && !$this->input->post('submit')) {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->get_employee_details($bct_id);
    if ($this->input->post('submit')) {

      //$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[merchant.email]');
      $this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[merchant.mob_no]');
      $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
      $email = $this->input->post('email') ? $this->input->post('email') : "";
      $name = $this->input->post('name') ? $this->input->post('name') : "";
      $mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
      $password = $this->input->post('password') ? $this->input->post('password') : "";
      $status = $this->input->post('status') ? $this->input->post('status') : "";
      $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
      if(isset($_POST['emp_refund'])) {
        $emp_refund = '1';
      } else {
        $emp_refund = '0';
      }
      $view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
      $edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
      $create_pay_permissions = $this->input->post('create_pay_permissions') ? $this->input->post('create_pay_permissions') : '0' . "";
      
      $view_menu_permissions='';
            $view_menu_permissions .=$this->input->post('ViewPermissions') ? $this->input->post('ViewPermissions').',' : "";  
            $view_menu_permissions .=$this->input->post('AddPermissions') ? $this->input->post('AddPermissions').',' : "";  
      $view_menu_permissions .=$this->input->post('EditPermissions') ? $this->input->post('EditPermissions').',' : "";  
      $view_menu_permissions .=$this->input->post('DeletePermissions') ? $this->input->post('DeletePermissions').',' : ""; 
            $view_menu_permissions .=$this->input->post('Dashboard') ? $this->input->post('Dashboard').',' : "";  
            $view_menu_permissions .=$this->input->post('TransactionSummary') ? $this->input->post('TransactionSummary').',' : "";  
      $view_menu_permissions .=$this->input->post('SalesTrends') ? $this->input->post('SalesTrends').',' : "";  
            $view_menu_permissions .= $this->input->post('TInstoreMobile') ? $this->input->post('TInstoreMobile').',' : "";  
            $view_menu_permissions .= $this->input->post('TInvoice') ? $this->input->post('TInvoice').',' : "";  
      $view_menu_permissions .= $this->input->post('TRecurring') ? $this->input->post('TRecurring').',' : "";  
      $view_menu_permissions .= $this->input->post('VirtualTerminal') ? $this->input->post('VirtualTerminal').',' : "";  
            $view_menu_permissions .= $this->input->post('IInvoicing') ? $this->input->post('IInvoicing').',' : "";  
      $view_menu_permissions .= $this->input->post('IRecurring') ? $this->input->post('IRecurring').',' : "";  
      $view_menu_permissions .= $this->input->post('RInstoreMobile') ? $this->input->post('RInstoreMobile').',' : "";
      $view_menu_permissions .= $this->input->post('RInvoice') ? $this->input->post('RInvoice').',' : "";
            $view_menu_permissions .= $this->input->post('ItemsManagement') ? $this->input->post('ItemsManagement').',' : "";  
      $view_menu_permissions .= $this->input->post('Reports') ? $this->input->post('Reports').',' : "";  
      $view_menu_permissions .= $this->input->post('Settings') ? $this->input->post('Settings') : "";
      
      $password1 = $this->my_encrypt($cpsw, 'e');
      if ($cpsw != '') {
        $psw1 = $password1;
      } else {
        $psw1 = $password;
      }
      $data = array(
        'name' => $name,
        // 'email' => $email,
        'mob_no' => $mobile,
        'password' => $psw1,
        'view_permissions' => $view_permissions,
        'edit_permissions' => $edit_permissions,
        'create_pay_permissions' => $create_pay_permissions,
        'view_menu_permissions'=>$view_menu_permissions,
        'status' => $status,
        'emp_refund' => $emp_refund,
      );
      $this->admin_model->update_data('merchant', $data, array('id' => $id));
      $this->session->set_userdata("mymsg", "Data Has Been Updated.");
      redirect(base_url() . 'merchant/all_employee');
    } else {
      foreach ($branch as $sub) {
        $data['bct_id'] = $sub->id;
        $data['email'] = $sub->email;
        $data['name'] = $sub->name;
        $data['mobile'] = $sub->mob_no;
        $data['password'] = $sub->password;
        $data['status'] = $sub->status;
        $data['view_permissions'] = $sub->view_permissions;
        $data['edit_permissions'] = $sub->edit_permissions;
        $data['create_pay_permissions'] = $sub->create_pay_permissions;
        $data['view_menu_permissions'] = $sub->view_menu_permissions;
        $data['emp_refund'] = $sub->emp_refund;
        break;
      }
    }
    $this->load->view('merchant/add_employee_dash', $data);
    // $this->load->view('merchant/add_employee', $data);
  }
  public function all_employee() {
    $data = array();
    $data["meta"] ='Employee';
    $merchant_id = $this->session->userdata('merchant_id');
    $package_data = $this->admin_model->get_full_details_employee('merchant', $merchant_id);
    $merchant_status = $this->session->userdata('merchant_status');
    $Activate_Details = $this->session->userdata('Activate_Details');
    if ($merchant_status == 'active') {
      $mem = array();
      $member = array();
      foreach ($package_data as $each) {
        $package['id'] = $each->id;
        $package['name'] = $each->name;
        $package['email'] = $each->email;
        $package['mob_no'] = $each->mob_no;
        $package['view_permissions'] = $each->view_permissions;
        $package['edit_permissions'] = $each->edit_permissions;
        $package['create_pay_permissions'] = $each->create_pay_permissions;
        $package['show_inventory'] = $each->updateInventoryPermission;
        $package['status'] = $each->status;
        $mem[] = $package;
      }
      $data['mem'] = $mem;
      // echo '<pre>';print_r($mem);die;
      // $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      // $this->session->unset_userdata('mymsg');
      $this->load->view('merchant/all_employee_dash', $data);
      // $this->load->view('merchant/all_employee', $data);
    } elseif ($merchant_status == 'block') {
      $data['meta'] = "Your Account Is Block";
      $data['loc'] = "";
      $data['resend'] = "";
      $this->load->view("merchant/block", $data);
    } elseif ($merchant_status == 'confirm') {
      $data['meta'] = "Your Account Is Not Active";
      $data['loc'] = "";
      $data['resend'] = "";
      $this->load->view("merchant/block", $data);
    } elseif ($merchant_status == "Activate_Details") {
      $urlafterSign = 'https://salequick.com/merchant/after_signup';
      $data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
      $data['loc'] = "";
      $data['resend'] = "";
      $this->load->view("merchant/blockactive", $data);
    } elseif ($merchant_status == "Waiting_For_Approval") {
      $urlafterSign = 'https://salequick.com/merchant/after_signup';
      $data['meta'] = "Waiting For Admin Approval, <a href='" . $urlafterSign . "'>Activate Link</a>";
      $data['loc'] = "";
      $data['resend'] = "";
      $this->load->view("merchant/blockactive", $data);
    } else {
      $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
      $data['loc'] = "resend";
      $data['resend'] = "resend";
      $this->load->view("merchant/block", $data);
    }
  }

  public function updateShowInvStatus() {
    if(isset($_POST)) {
      $ShowInv=$_POST['ShowInv'];
      $id=$_POST['id']; 
      if($ShowInv=='true') { 
        $data = array('updateInventoryPermission' => 1);
        $up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
        echo '200';
      }else if($ShowInv=='false') { 
        $data = array('updateInventoryPermission' =>0);
        $up=$this->admin_model->update_data('merchant', $data, array('id' => $id));
        echo '200';
      }
    }
  }

  public function employee_delete($id) {
    $this->admin_model->delete_by_id($id, 'merchant');
    echo json_encode(array("status" => TRUE));
  }
  public function pending_delete($id) {
    $this->admin_model->delete_by_id($id, 'customer_payment_request');
    echo json_encode(array("status" => TRUE));
  }
  public function add_user() {
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
        $this->load->view("merchant/add_user_dash", $data);
        // $this->load->view("merchant/add_user", $data);
      } else {
        $merchant_id = $this->session->userdata('merchant_id');
        $merchant_auth_key = $this->session->userdata('merchant_auth_key');
        $today1 = 'SL_' . date("Ymdhms");
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
          'date_c' => $today2,
        );
        $id = $this->admin_model->insert_data("user", $data);
        redirect(base_url() . 'merchant/all_user');
      }
    } else {
      $this->load->view("merchant/add_user_dash", $data);
      // $this->load->view("merchant/add_user", $data);
    }
  }
  public function updateAfetrsignupformdata()
  {
    
    
    if (isset($_POST)) {
      
      $merchant_id = $this->session->userdata('merchant_id');
      $merchant_auth_key = $this->session->userdata('merchant_auth_key');
      $today1 = 'SL_' . date("Ymdhms");
      $today2 = date("Y-m-d");
      $data = Array(
        
        
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
      'o_email' => $this->input->post('fo_email') ? $this->input->post('fo_email') : "",
      "o_phone" => $this->input->post('fo_phone') ? $this->input->post('fo_phone') : "",
      'o_dob_d' => $this->input->post('fodobd') ? $this->input->post('fodobd') : "",
      'o_dob_m' => $this->input->post('fodobm') ? $this->input->post('fodobm') : "",
      'o_dob_y' => $this->input->post('fodoby') ? $this->input->post('fodoby') : "",
      // // 'dob' => $DOB,
      'o_address1' => $this->input->post('fohadd_1') ? $this->input->post('fohadd_1') : "",
      'o_address2' => $this->input->post('fohadd_2') ? $this->input->post('fohadd_2') : "",
      'o_city' => $this->input->post('fohadd_city') ? $this->input->post('fohadd_city') : "",
      'o_country' => $this->input->post('fohadd_cntry') ? $this->input->post('fohadd_cntry') : "",
      'o_state' => $this->input->post('fohadd_state') ? $this->input->post('fohadd_state') : "",
      'o_zip' => $this->input->post('fohadd_zip') ? $this->input->post('fohadd_zip') : "",
      'o_ss_number' => $this->input->post('fossn') ? $this->input->post('fossn') : "",
      'o_name' => $this->input->post('foname1') ? $this->input->post('foname1') : "",
      'name' => $this->input->post('foname1') ? $this->input->post('foname1') : "",
      'm_name' => $this->input->post('foname2') ? $this->input->post('foname2') : "",
      'l_name' => $this->input->post('foname3') ? $this->input->post('foname3') : "",
                
      "bank_dda" => $this->input->post('bank_dda_type') ? $this->input->post('bank_dda_type') : '',
      "bank_ach" => $this->input->post('baccachtype') ? $this->input->post('baccachtype') : '',
      "bank_routing" => $this->input->post('routeNo') ? $this->input->post('routeNo') : '',
      "bank_account" => $this->input->post('accno') ? $this->input->post('accno') : '',
      //'status' => 'Waiting_For_Approval',
      //'date_c' => $today2,
      );
      
      $merchant_id = $this->session->userdata('merchant_id');
      $id = $this->admin_model->update_data("merchant", $data, array("id" => $merchant_id));
      // echo $this->db->last_query();  die;   
      $sessiondata = array(
        'merchant_id' =>  $this->session->userdata('merchant_id'),
        'merchant_name' => $this->input->post('foname1') ? $this->input->post('foname1') : "",
        'm_business_number' => $this->input->post('bsns_phone') ? $this->input->post('bsns_phone') : "",
        'business_dba_name' => $this->input->post('bsns_dbaname') ? $this->input->post('bsns_dbaname') : "",
       );
       $this->session->set_userdata($sessiondata);
      echo '200';
      // $this->session->set_userdata("merchant_status", 'Waiting_For_Approval');
      // redirect(base_url() . 'merchant/index');
    }
  }
  public function after_signup() {
    $data['meta'] = "Add New User";
    $data['loc'] = "add_user";
    $data['action'] = "Add New User";
    if (isset($_POST['submit'])) {
      //$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[user.email]');
      $this->form_validation->set_rules('business_number', 'Business Phone Number', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[user.mob_no]');
      $merchant_id = $this->session->userdata('merchant_id');
      $merchant_auth_key = $this->session->userdata('merchant_auth_key');
      $today1 = 'SL_' . date("Ymdhms");
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
        'business_name' => $this->input->post('business_name'),
        'ien_no' => $this->input->post('ien_no'),
        'address1' => $this->input->post('address1'),
        'city' => $this->input->post('city'),
        'country' => $this->input->post('country'),
        'o_name' => $this->input->post('o_name') . ' ' . $this->input->post('o_last_name'),
        'o_dob' => $this->input->post('o_dob'),
        'o_ss_number' => $this->input->post('o_ss_number'),
        'percentage_of_ownership' => $this->input->post('percentage_of_ownership'),
        'o_address' => $this->input->post('o_address'),
        'cc_business_name' => $this->input->post('cc_business_name'),
        'bank_routing' => $this->input->post('bank_routing'),
        'bank_account' => $this->input->post('bank_account'),
        'bank_name' => $this->input->post('bank_name'),
        'funding_time' => $this->input->post('funding_time'),
        'zip' => $this->input->post('zip'),
        'bank_country' => $this->input->post('bank_country'),
        'bank_street' => $this->input->post('bank_street'),
        'bank_city' => $this->input->post('bank_city'),
        'bank_zip' => $this->input->post('bank_zip'),
        'status' => 'Waiting_For_Approval',
        'date_c' => $today2,
      );
      $merchant_id = $this->session->userdata('merchant_id');
      $id = $this->admin_model->update_data("merchant", $data, array("id" => $merchant_id));
      $this->session->set_userdata("merchant_status", 'Waiting_For_Approval');
      redirect(base_url() . 'merchant/index');  
    } else {
      $merchant_id = $this->session->userdata('merchant_id'); 
      $mearchent = $this->admin_model->data_get_where_serch("merchant", array("id" => $merchant_id)); 
      $data["mearchent"] = json_decode(json_encode($mearchent[0]), true);
      $this->load->view("merchant/after_signup_dash", $data);
    }
  }
  public function edit_user() {
    $data['meta'] = "Edit User Details";
    $data['action'] = "Update User";
    $data['loc'] = "edit_user";
    $bct_id = $this->uri->segment(3);
    if (!$bct_id && !$this->input->post('submit')) {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->get_user_details($bct_id);
    if ($this->input->post('submit')) {
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
        'status' => $status,
      );
      $this->admin_model->update_data('user', $data, array('id' => $id));
      $this->session->set_userdata("mymsg", "Data Has Been Updated.");
      redirect(base_url() . 'merchant/all_user');
    } else {
      foreach ($branch as $sub) {
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
    $this->load->view('merchant/add_user_dash', $data);
    // $this->load->view('merchant/add_user', $data);
  }
  public function all_user() {
    $data = array();
    $data["meta"] ='User List';
    $merchant_id = $this->session->userdata('merchant_id');
    $package_data = $this->admin_model->get_full_details_employee('user', $merchant_id);
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
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
    // $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    // $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/all_user_dash', $data);
    // $this->load->view('merchant/all_user', $data);
  }
  public function user_delete($id) {
    $this->admin_model->delete_by_id($id, 'user');
    echo json_encode(array("status" => TRUE));
  }
  public function add_tax() {
    $data['meta'] = "Add New Tax";
    $data['loc'] = "add_tax";
    $data['action'] = "Add New Tax";
    if (isset($_POST['submit'])) {
      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('percentage', 'Percentage', 'required');
      $title = $this->input->post('title') ? $this->input->post('title') : "";
      $percentage = $this->input->post('percentage') ? $this->input->post('percentage') : "";
      if ($this->form_validation->run() == FALSE) {
        $this->load->view("merchant/add_tax_dash", $data);
        // $this->load->view("merchant/add_tax", $data);
      } else {
        $merchant_id = $this->session->userdata('merchant_id');
        $today1 = date("Ymdhms");
        $today2 = date("Y-m-d");
        $data = Array(
          'title' => $title,
          'percentage' => $percentage,
          'merchant_id' => $merchant_id,
          'status' => 'active',
          'date_c' => $today2,
        );
        $id = $this->admin_model->insert_data("tax", $data);
        redirect(base_url() . 'merchant/tax_list');
      }
    } else {
      $this->load->view("merchant/add_tax_dash", $data);
      // $this->load->view("merchant/add_tax", $data);
    }
  }
  public function edit_tax() {
    $bct_id = $this->uri->segment(3);
    if (!$bct_id && !$this->input->post('submit')) {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->data_get_where('tax', array('id' => $bct_id));
    if ($this->input->post('submit')) {
      $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
      $title = $this->input->post('title') ? $this->input->post('title') : "";
      $percentage = $this->input->post('percentage') ? $this->input->post('percentage') : "";
      $branch_info = array(
        'title' => $title,
        'percentage' => $percentage,
      );
      $this->admin_model->update_data('tax', $branch_info, array('id' => $id));
      $this->session->set_userdata("mymsg", "Data Has Been Updated.");
      redirect('merchant/tax_list');
    } else {
      foreach ($branch as $sub) {
        $data['bct_id'] = $sub->id;
        $data['title'] = $sub->title;
        $data['percentage'] = $sub->percentage;
        break;
      }
    }
    $data['meta'] = "Edit Tax Details";
    $data['action'] = "Update Tax";
    $data['loc'] = "edit_tax";
    $this->load->view('merchant/add_tax_dash', $data);
    // $this->load->view('merchant/add_tax', $data);
  }
  public function tax_list() {
    $data = array();
    $data["meta"] ='Tax';
    $merchant_id = $this->session->userdata('merchant_id');
    //$package_data = $this->admin_model->get_data('tax',$merchant_id);
    $package_data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
      $mem[] = $each;
    }
    $data['mem'] = $mem;
    // $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    // $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/tax_list_dash', $data);
    // $this->load->view('merchant/tax_list', $data);
  }
  public function tax_delete($id) {
    $this->admin_model->delete_by_id($id, 'tax');
    echo json_encode(array("status" => TRUE));
  }
  public function deletecard()
  {
    if(!empty( $this->input->post('tokenId') ) )
    {
      $tokenId=$this->input->post('tokenId');
      $this->admin_model->delete_by_id($tokenId, 'token');
        echo json_encode(array("status" => TRUE));
    }
    else
    {
      echo json_encode(array("status"=>FALSE)); 
    }
  }
  public function add_payment_mode() {
    $data['meta'] = "Add New Payment Type";
    $data['loc'] = "add_payment_mode";
    $data['action'] = "Add New Payment Type";
    if (isset($_POST['submit'])) {
      $this->form_validation->set_rules('title', 'Title', 'required');
      
      $title = $this->input->post('title') ? $this->input->post('title') : "";
      if ($this->form_validation->run() == FALSE) {
        $this->load->view("merchant/add_payment_mode_dash", $data);
        // $this->load->view("merchant/add_payment_mode", $data);
      } else {
        $merchant_id = $this->session->userdata('merchant_id');
        $today1 = date("Ymdhms");
        $today2 = date("Y-m-d");
        $data = Array(
          'name' => $title,
          'merchant_id' => $merchant_id,
          'user_id' => $merchant_id,
          'status' => '1'
          //'add_date'=>date("Y-m-d H:i:s")
        );
        $id = $this->admin_model->insert_data("payment_mode", $data);
        
        redirect(base_url() . 'merchant/payment_mode');
      }
    } else {
      $this->load->view("merchant/add_payment_mode_dash", $data);
      // $this->load->view("merchant/add_payment_mode", $data);
    }
  }
  public function edit_payment_mode() {
    $bct_id = $this->uri->segment(3);
    if (!$bct_id && !$this->input->post('submit')) {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->data_get_where('payment_mode', array('id' => $bct_id));
    
    if ($this->input->post('submit')) {
      $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
      $title = $this->input->post('title') ? $this->input->post('title') : "";
      
      $branch_info = array(
        'name' => $title,
      );
      $this->admin_model->update_data('payment_mode', $branch_info, array('id' => $id));
      $this->session->set_userdata("mymsg", "Payment Type has been updated.");
      redirect('merchant/payment_mode');
    } else {
      foreach ($branch as $sub) {
        $data['bct_id'] = $sub->id;
        $data['title'] = $sub->name;
        break;
      }
    }
    $data['meta'] = "Edit Payment Type";
    $data['action'] = "Update Payment Type";
    $data['loc'] = "edit_payment_mode";
    
    $this->load->view('merchant/add_payment_mode_dash', $data);
    // $this->load->view('merchant/add_payment_mode', $data);
  }
  public function payment_mode() {
    $data = array();
    $data["meta"] ='Payment Types';
    $merchant_id = $this->session->userdata('merchant_id');
    //$package_data = $this->admin_model->get_data('tax',$merchant_id);
    $package_data = $this->admin_model->data_get_where_1('payment_mode', array('merchant_id' => $merchant_id));
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
      $mem[] = $each;
    }
    $data['mem'] = $mem;
    // $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    // $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/payment_mode_dash', $data);
    // $this->load->view('merchant/payment_mode', $data);
  }
  function delete_payment_mode()
  {
    if(!empty($this->uri->segment(3)))
    {
      $id=$this->uri->segment(3); 
      $this->admin_model->delete_by_id($id, 'payment_mode');
      $this->session->set_userdata("mymsg", "Payment Type deleted...");
      redirect(base_url('merchant/payment_mode')); 
    }
    else
    {
      redirect(base_url('merchant/payment_mode'));
    }
  }
  
  public function resend() {
    if (isset($_POST['submit'])) {
      $unique = $this->session->userdata('merchant_auth_key');
      $merchant_name = $this->session->userdata('merchant_name');
      $email = $this->session->userdata('m_email');
      // echo "<pre>";print_r($email);die;
      $url = base_url()."confirm/" . $unique;
      set_time_limit(3000);
      $verification_data['merchant_name'] = $merchant_name;
      $verification_data['email'] = $email;
      $verification_data['url'] = $url;
      // echo "<pre>";print_r($email);die;
      $MailTo = $email;
      //$MailSubject = 'Confirm Email';
      //$header = "From: Salequick<info@salequick.com >\r\n".
      //"MIME-Version: 1.0" . "\r\n" .
      //"Content-type: text/html; charset=UTF-8" . "\r\n";
      // $msg = " Click this Url: : ".$url.".";
      $msg = $this->load->view('email/verification_email', $verification_data, true);
      //ini_set('sendmail_from', $email);
      //mail($MailTo, $MailSubject, $msg, $header);
      $MailSubject = 'Salequick Registration Confirmation';
      $this->email->from('info@salequick.com', 'Confirm Email');
      $this->email->to($email);
      $this->email->subject($MailSubject);
      $this->email->message($msg);
      $this->email->send();
      $this->session->set_userdata("mymsge", "Please Check Your Email-Id For Confirm Account Link.");
      $data['msg'] = "<h3>" . $this->session->userdata('mymsge') . "</h3>";
      $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
      $data['loc'] = "resend";
      $data['resend'] = "resend";
      $this->session->unset_userdata('mymsg');
      $this->load->view("merchant/block", $data);
    } else {
      redirect("merchant/add_customer_request");
    }
  }
    public function add_straight_request() {
      $data = array();
      $merchant_id = $this->session->userdata('merchant_id');
      $merchant_name = $this->session->userdata('merchant_name');
      $t_fee = $this->session->userdata('t_fee');
      $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
      $s_fee = $merchantdetails['0']['s_fee']; 
      $t_fee = $this->session->userdata('t_fee');
      $fee_invoice = $merchantdetails['0']['invoice'];
      $fee_swap = $merchantdetails['0']['f_swap_Invoice'];
      $fee_email = $merchantdetails['0']['text_email'];
      $names = substr($merchant_name, 0, 3);
      $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
      $getDashboardData = $getDashboard->result_array();
      $getDashboardNum = $getDashboard->num_rows();
      $data['getDashboardNum'] = $getDashboardNum;
      if ($getDashboardData == false) {
        $data['getDashboardData'] = '0';
        $inv = '1';
      } else {
        $data['getDashboardData'] = $getDashboardData;
        $inv1 = $getDashboardData[0]['TotalOrders'];
        $inv = $inv1 + 1;
      }
      $merchant_status = $this->session->userdata('merchant_status'); 
      $Activate_Details = $this->session->userdata('Activate_Details');
      if ($merchant_status == 'active') {
        $data['meta'] = "Direct Invoice Request";
        $data['loc'] = "add_straight_request";
        $data['action'] = "Send Request";
        if (isset($_POST['submit'])) {
          $merchant_id = $this->session->userdata('merchant_id');
          $this->form_validation->set_rules('amount', 'amount', 'required');
          $this->form_validation->set_rules('name', 'Name', 'required');
          $this->form_validation->set_rules('email', 'Email', 'required');
          //$this->form_validation->set_rules('reverence', 'Reference', 'required');
          $this->form_validation->set_rules('mobile', 'Phone Number', 'required');
          $this->form_validation->set_rules('due_date', 'Due  Date', 'required');
          $this->form_validation->set_rules('title', 'Title', 'required');
          $this->form_validation->set_rules('Item_Name[]', 'Item Name', 'required');
          $this->form_validation->set_rules('Quantity[]', 'Quantity', 'required');
          $this->form_validation->set_rules('Price[]', 'Price', 'required');
          
          if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error','<div class="alert alert-danger text-center">Name, Email,Phone Number, Due  Date,Title , Item Name, Quantity, Price Fields Are Required..</div>'); 
          
            redirect(base_url().'merchant/add_straight_request'); 
          } else {
            //$amount = $this->input->post('amount') ? $this->input->post('amount') : "";
                        $amount_ss = htmlspecialchars($this->input->post('amount') ? $this->input->post('amount') : "");
            $b = str_replace(",","",$amount_ss);
                        $a = number_format($b,2);
                        $amount = str_replace(",","",$a);
            $other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
            $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
            $title = $this->input->post('title') ? $this->input->post('title') : "";
            $remark = $this->input->post('remark') ? $this->input->post('remark') : "";
            $name = $this->input->post('name') ? $this->input->post('name') : "";
            $email_id = $this->input->post('email') ? $this->input->post('email') : "";
            $mobile_no = $this->input->post('mobile') ? $this->input->post('mobile') : "";
            $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
            $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
            $note = $this->input->post('note') ? $this->input->post('note') : "";
            $reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
            $file = $this->input->post('file') ? $this->input->post('file') : '0' . "";
            $myfile=$_FILES['file']['name'];
            if($myfile!="")
            {
              $new_name = date().time().$_FILES['file']['name'];
                          $config['file_name'] = $new_name; 
              $config['upload_path']          = './uploads/attachment/';
              $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
              $config['max_size']             = 1000;
              $config['max_width']            = 3024;
              $config['max_height']           = 3068;
              $this->load->library('upload', $config);
              if ($this->upload->do_upload('file'))
              {
                $data = array('upload_data' => $this->upload->data());
                 // $this->load->view('upload_success', $data);
                  $uploadedFileName=$data['upload_data']['file_name']; 
              }
              
            }
            else
            {
              $uploadedFileName="";
            }
            $attachment=$uploadedFileName;
            if (!empty($this->session->userdata('subuser_id'))) {
              $sub_merchant_id = $this->session->userdata('subuser_id');
            } else {
              $sub_merchant_id = '0';
            }
            $fee = ($amount / 100) * $fee_invoice;
            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
            $fee_email = ($fee_email != '') ? $fee_email : 0;
            $fee = $fee + $fee_swap + $fee_email;
            
            $recurring_type = 'false';
            $recurring_count = '0';
            $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
            $recurring_payment = 'stop';
            // $invoice_no = 'INV'.strtoupper($names).'000'. $sub_merchant_id.rand(10,1000000).$inv;
            //$invoice_no = 'INV' . strtoupper($names) . $sub_merchant_id . rand(10, 1000000) . $inv;
           // $invoice_no_1 = 'INV' . strtoupper($names) . date("ymdhisu");
            $invoice_no_1= 'INV' .  date("ymdhisu");
            $invoice_no = str_replace("000000", "", $invoice_no_1);
            $today1 = date("ymdhisu");
            $url = base_url().'payment/PY' . $today1 . '/' . $merchant_id;
            $today2 = date("Y-m-d");
            $p_date = date('F j, Y', strtotime($today2));
            $year = date("Y");
            $month = date("m");
            $time11 = date("H");
            if ($time11 == '00') {
              $time1 = '01';
            } else {
              $time1 = date("H");
            }
            $day1 = date("N");
            $today3 = date("Y-m-d H:i:s");
            $amountaa = $sub_amount + $fee;
            $unique = "PY" . $today1;
            $data = array(
              'name' => $name,
              'other_charges' => $other_charges,
              'otherChargesName' => $other_charges_title,
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
              'attachment'=>$attachment,
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
              'date_c' => $today2
            );
            $id = $this->admin_model->insert_data("customer_payment_request", $data);
            // $id1 = $this->admin_model->insert_data("graph", $data);
            $item_name = json_encode($this->input->post('Item_Name'));
            $quantity = json_encode($this->input->post('Quantity'));
            $price = json_encode($this->input->post('Price'));
            $tax = json_encode($this->input->post('Tax_Amount'));
            $tax_id = json_encode($this->input->post('Tax'));
            $total_amount = json_encode($this->input->post('Total_Amount'));
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
            $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
            $getDashboardData_m = $getDashboard_m->result_array();
            $data['getDashboardData_m'] = $getDashboardData_m;
            $data['business_name'] = $getDashboardData_m[0]['business_name'];
            $data['address1'] = $getDashboardData_m[0]['address1'];
            $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
            $data['logo'] = $getDashboardData_m[0]['logo'];
            $data['business_number'] = $getDashboardData_m[0]['business_number'];
            $data['color'] = $getDashboardData_m[0]['color'];
            $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
            $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
            $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
            $data['payment_type'] = 'straight';
            $data['recurring_type'] = $recurring_type;
            $data['no_of_invoice'] = 1;
            $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
            $this->admin_model->insert_data("order_item", $item_Detail_1);
            $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
            $data['item_detail'] = $item_Detail_1;  
            $data['msgData'] = $data;
            // echo "<pre>";print_r($data);die;

            //Satrt QuickBook sync
             $bct_id2 = $this->session->userdata('merchant_id');
            $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $bct_id2 and status='1' and inv_status='1' ";
            $result_setting = $this->db->query($query_qb_setting)->result();
            $intuit_realm_id = trim($result_setting[0]->realm_id);
            
            if(!empty($intuit_realm_id)){
                    $Qurl ="https://salequick.com/quickbook/get_invoice_detail_live";
                    $qbdata =array(
                    'id' => $id,
                    'merchant_id' => $bct_id2
                    
                    );
                    
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL, $Qurl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $result = json_decode($result,true);
                    //print_r($result);
                    curl_close($ch);
                    }
                     //End QuickBook sync
                    
            //Send Mail Code
            $msg = $this->load->view('email/invoice', $data, true);
            $email = $email_id;
            if (!empty($mobile_no)) {
              $sms_reciever = $mobile_no;
              //$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
              $sms_message = trim(" '" . $getDashboardData_m[0]['business_dba_name'] . "' is requesting  payment .  '".$url."' ");

              //$sms_message = trim('Payment Url : '.$url);
              $from = '+18325324983'; //trial account twilio number
              // $to = '+'.$sms_reciever; //sms recipient number
              $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
              $to = '+1' . $mob;
              $response = $this->twilio->sms($from, $to, $sms_message);
            }
            $MailTo = $email;
            $MailSubject = 'Invoice from '.$getDashboardData_m[0]['business_dba_name'];
            if (!empty($email)) {
              $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
              $this->email->to($MailTo);
              $this->email->subject($MailSubject);
              $this->email->message($msg);
              $this->email->send();
            }
            //mail($MailTo, $MailSubject, $msg, $headers);
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
            $this->session->set_userdata("mymsg", "New payment request add successfully.");
            // redirect("merchant/all_straight_request");
            redirect("pos/all_customer_request");
          }
        } else {
          $data['invoice_type'] = $merchantdetails['0']['invoice_type'];
          $data["meta"] = "Create Invoice";
          $this->load->view("merchant/add_straight_request_dash", $data);
          // $this->load->view("merchant/add_straight_request", $data);
        }
      } elseif ($merchant_status == 'block') {
        $data['meta'] = "Your Account Is Block";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/block", $data);
      } elseif ($merchant_status == 'confirm') {
        $data['meta'] = "Your Account Is Not Active";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/block", $data);
      } elseif ($merchant_status == "Activate_Details") {
        $urlafterSign = base_url().'merchant/after_signup';
        $data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/blockactive", $data);
      } elseif ($merchant_status == "Waiting_For_Approval") {
        $urlafterSign = base_url().'merchant/after_signup';
        $data['meta'] = "Waiting For Admin Approval, <a href='" . $urlafterSign . "'>Activate Link</a>";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/blockactive", $data);
      } else {
        $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
        $data['loc'] = "resend";
        $data['resend'] = "resend";
        $this->load->view("merchant/block", $data);
      }
    }
      public function simple_invoice2() {
      $data = array();
      //echo '<pre>';print_r($_POST);die();
      $merchant_id = $this->session->userdata('merchant_id');
      $merchant_name = $this->session->userdata('merchant_name');
      $t_fee = $this->session->userdata('t_fee');
      $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
      $s_fee = $merchantdetails['0']['s_fee']; 
      $t_fee = $this->session->userdata('t_fee');
      $fee_invoice = $merchantdetails['0']['invoice'];
      $fee_swap = $merchantdetails['0']['f_swap_Invoice'];
      $fee_email = $merchantdetails['0']['text_email'];
      $names = substr($merchant_name, 0, 3);
      $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
      $getDashboardData = $getDashboard->result_array();
      $getDashboardNum = $getDashboard->num_rows();
      $data['getDashboardNum'] = $getDashboardNum;
      if ($getDashboardData == false) {
        $data['getDashboardData'] = '0';
        $inv = '1';
      } else {
        $data['getDashboardData'] = $getDashboardData;
        $inv1 = $getDashboardData[0]['TotalOrders'];
        $inv = $inv1 + 1;
      }
      $merchant_status = $this->session->userdata('merchant_status'); 
      $Activate_Details = $this->session->userdata('Activate_Details');
      if ($merchant_status == 'active') {
        $data['meta'] = "Simple Invoice Request";
        $data['loc'] = "simple_invoice";
        $data['action'] = "Send Request";
        if (isset($_POST['submit'])) {
          $merchant_id = $this->session->userdata('merchant_id');
          //$this->form_validation->set_rules('amount', 'amount', 'required');
          $this->form_validation->set_rules('name', 'Name', 'required');
          //$this->form_validation->set_rules('email', 'Email', 'required');
        //  $this->form_validation->set_rules('mobile', 'Phone Number', 'required');
          //$this->form_validation->set_rules('due_date', 'Due  Date', 'required');
        
          
          if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error','<div class="alert alert-danger text-center">Name, Email,Phone Number, Due  Date, Price Fields Are Required..</div>'); 
          
                        //echo 'ss'; die();
            //redirect(base_url().'merchant/simple_invoice'); 
          } else {
            $amount_ss = htmlspecialchars($this->input->post('s_amount') ? $this->input->post('s_amount') : "");
            $full_amount = htmlspecialchars($this->input->post('full_amount') ? $this->input->post('full_amount') : "");
            if($full_amount !=''){
              $amount_ss =  $full_amount;
            }
            else
            {
                $amount_ss =  $amount_ss;
            }
            
            $b = str_replace(",","",$amount_ss);
                        $a = number_format($b,2);
                        $amount = str_replace(",","",$a);
            $detail = htmlspecialchars($this->input->post('s_detail') ? $this->input->post('s_detail') : "");
            $name = htmlspecialchars($this->input->post('name') ? $this->input->post('name') : "");
            $email_id = htmlspecialchars($this->input->post('s_email') ? $this->input->post('s_email') : "");
            $mobile_no = htmlspecialchars($this->input->post('s_mobile') ? $this->input->post('s_mobile') : "");
            $sub_amount = htmlspecialchars($this->input->post('amount') ? $this->input->post('amount') : "");
            $total_tax = htmlspecialchars($this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "");
                        $other_charges = $this->input->post('other_charges_s') ? $this->input->post('other_charges_s') : "";
            $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
            
            if (!empty($this->session->userdata('subuser_id'))) {
              $sub_merchant_id = $this->session->userdata('subuser_id');
            } else {
              $sub_merchant_id = '0';
            }
            $fee = ($amount / 100) * $fee_invoice;
            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
            $fee_email = ($fee_email != '') ? $fee_email : 0;
            $fee = $fee + $fee_swap + $fee_email;
            
            $recurring_type = 'false';
            $recurring_count = '0';
            $due_date = $this->input->post('s_due_date') ? $this->input->post('s_due_date') : "";
            $recurring_payment = 'stop';
            //$invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
            $invoice_no_1= 'INV' .  date("ymdhisu");
            $invoice_no = str_replace("000000", "", $invoice_no_1);
            $today1 = date("ymdhisu");
            $url = base_url().'spayment/PY' . $today1 . '/' . $merchant_id;
            $today2 = date("Y-m-d");
            $p_date = date('F j, Y', strtotime($today2));
            $year = date("Y");
            $month = date("m");
            $time11 = date("H");
            if ($time11 == '00') {
              $time1 = '01';
            } else {
              $time1 = date("H");
            }
            $day1 = date("N");
            $today3 = date("Y-m-d H:i:s");
            $amountaa = $sub_amount + $fee;
            $unique = "PY" . $today1;
            $data = array(
              'name' => $name,
              'other_charges' => $other_charges,
              'otherChargesName' => $other_charges_title,
              'invoice_no' => $invoice_no,
              'sub_total' => $sub_amount,
              'tax' => $total_tax,
              'fee' => $fee,
              's_fee' => $s_fee,
              'invoice_type' => 'simple',
              'email_id' => $email_id,
              'mobile_no' => $mobile_no,
              'amount' => $amount,
              'detail' => $detail,
              'url' => $url,
              'payment_type' => 'straight',
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
              'date_c' => $today2
            );
           // print_r($data); die();
            $id = $this->admin_model->insert_data("customer_payment_request", $data);
            
            $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
            $getDashboardData_m = $getDashboard_m->result_array();
            $data['getDashboardData_m'] = $getDashboardData_m;
            $data['business_name'] = $getDashboardData_m[0]['business_name'];
            $data['address1'] = $getDashboardData_m[0]['address1'];
            $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
            $data['logo'] = $getDashboardData_m[0]['logo'];
            $data['business_number'] = $getDashboardData_m[0]['business_number'];
            $data['color'] = $getDashboardData_m[0]['color'];
            $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
            $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
            $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
            $data['payment_type'] = 'straight';
            $data['recurring_type'] = $recurring_type;
            $data['no_of_invoice'] = 1;
            $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
             
            $data['msgData'] = $data;
     
     //Satrt QuickBook sync
             $bct_id2 = $this->session->userdata('merchant_id');
               $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $bct_id2 and status='1' and inv_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                    $Qurl ="https://salequick.com/quickbook/get_invoice_detail_live";
                    $qbdata =array(
                    'id' => $id,
                    'merchant_id' => $bct_id2
                    
                    );
                    
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL, $Qurl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $result = json_decode($result,true);
                    //print_r($result);
                    curl_close($ch);
                    }
                     //End QuickBook sync

            // echo "<pre>";print_r($data);die;
            //Send Mail Code
            $msg = $this->load->view('email/simple_invoice', $data, true);
            $email = $email_id;
            if (!empty($mobile_no)) {
              $sms_reciever = $mobile_no;
              //$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");
              //$sms_message = trim(" Hello '" . $name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");
              $sms_message = trim(" '" . $getDashboardData_m[0]['business_dba_name'] . "' is requesting  payment .  '".$url."' ");

              //$sms_message = trim('Payment Url : '.$url);
              $from = '+18325324983'; //trial account twilio number
              // $to = '+'.$sms_reciever; //sms recipient number
              $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
              $to = '+1' . $mob;
              $response = $this->twilio->sms($from, $to, $sms_message);
            }
            $MailTo = $email;
            $MailSubject = 'Salequick Simple Invoice from '.$getDashboardData_m[0]['business_dba_name'];
            if (!empty($email)) {
              $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
              $this->email->to($MailTo);
              $this->email->subject($MailSubject);
              $this->email->message($msg);
              $this->email->send();
            }
            $this->session->set_userdata("mymsg", "New payment request add successfully.");
            // redirect("merchant/all_straight_request");
            redirect("pos/all_customer_request");
          }
        } else {
          $this->load->view("merchant/add_straight_request_dash", $data);
        }
      } elseif ($merchant_status == 'block') {
        $data['meta'] = "Your Account Is Block";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/block", $data);
      } elseif ($merchant_status == 'confirm') {
        $data['meta'] = "Your Account Is Not Active";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/block", $data);
      } elseif ($merchant_status == "Activate_Details") {
        $urlafterSign = base_url().'merchant/after_signup';
        $data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/blockactive", $data);
      } elseif ($merchant_status == "Waiting_For_Approval") {
        $urlafterSign = base_url().'merchant/after_signup';
        $data['meta'] = "Waiting For Admin Approval, <a href='" . $urlafterSign . "'>Activate Link</a>";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/blockactive", $data);
      } else {
        $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
        $data['loc'] = "resend";
        $data['resend'] = "resend";
        $this->load->view("merchant/block", $data);
      }
    }
 public function simple_invoice() {
      $data = array();
      // echo '<pre>';print_r($_FILES);die();
      $merchant_id = $this->session->userdata('merchant_id');
      $merchant_name = $this->session->userdata('merchant_name');
      $t_fee = $this->session->userdata('t_fee');
      $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
      $s_fee = $merchantdetails['0']['s_fee']; 
      $t_fee = $this->session->userdata('t_fee');
      $fee_invoice = $merchantdetails['0']['invoice'];
      $fee_swap = $merchantdetails['0']['f_swap_Invoice'];
      $fee_email = $merchantdetails['0']['text_email'];
      $names = substr($merchant_name, 0, 3);
      $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
      $getDashboardData = $getDashboard->result_array();
      $getDashboardNum = $getDashboard->num_rows();
      $data['getDashboardNum'] = $getDashboardNum;
      if ($getDashboardData == false) {
        $data['getDashboardData'] = '0';
        $inv = '1';
      } else {
        $data['getDashboardData'] = $getDashboardData;
        $inv1 = $getDashboardData[0]['TotalOrders'];
        $inv = $inv1 + 1;
      }
      $merchant_status = $this->session->userdata('merchant_status'); 
      $Activate_Details = $this->session->userdata('Activate_Details');
      if ($merchant_status == 'active') {
        $data['meta'] = "Simple Invoice Request";
        $data['loc'] = "simple_invoice";
        $data['action'] = "Send Request";
        if (isset($_POST['submit'])) {
          $merchant_id = $this->session->userdata('merchant_id');
          //$this->form_validation->set_rules('amount', 'amount', 'required');
          $this->form_validation->set_rules('name', 'Name', 'required');
          //$this->form_validation->set_rules('email', 'Email', 'required');
        //  $this->form_validation->set_rules('mobile', 'Phone Number', 'required');
          //$this->form_validation->set_rules('due_date', 'Due  Date', 'required');
        
          
          if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error','<div class="alert alert-danger text-center">Name, Email,Phone Number, Due  Date, Price Fields Are Required..</div>'); 
          
                        //echo 'ss'; die();
            //redirect(base_url().'merchant/simple_invoice'); 
          } else {
            $amount_ss = htmlspecialchars($this->input->post('s_amount') ? $this->input->post('s_amount') : "");
            $full_amount = htmlspecialchars($this->input->post('full_amount') ? $this->input->post('full_amount') : "");
            if($full_amount !=''){
              $amount_ss =  $full_amount;
            }
            else
            {
                $amount_ss =  $amount_ss;
            }
            
            $b = str_replace(",","",$amount_ss);
                        $a = number_format($b,2);
                        $amount = str_replace(",","",$a);
            $detail = htmlspecialchars($this->input->post('s_detail') ? $this->input->post('s_detail') : "");
            $name = htmlspecialchars($this->input->post('name') ? $this->input->post('name') : "");
            $email_id = htmlspecialchars($this->input->post('s_email') ? $this->input->post('s_email') : "");
            $mobile_no = htmlspecialchars($this->input->post('s_mobile') ? $this->input->post('s_mobile') : "");
            $sub_amount = htmlspecialchars($this->input->post('amount') ? $this->input->post('amount') : "");
            $total_tax = htmlspecialchars($this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "");
                        $other_charges = $this->input->post('other_charges_s') ? $this->input->post('other_charges_s') : "";
            $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
            
            if (!empty($this->session->userdata('subuser_id'))) {
              $sub_merchant_id = $this->session->userdata('subuser_id');
            } else {
              $sub_merchant_id = '0';
            }
            $fee = ($amount / 100) * $fee_invoice;
            $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
            $fee_email = ($fee_email != '') ? $fee_email : 0;
            $fee = $fee + $fee_swap + $fee_email;
            
            $recurring_type = 'false';
            $recurring_count = '0';
            $due_date = $this->input->post('s_due_date') ? $this->input->post('s_due_date') : "";
            $recurring_payment = 'stop';
            //$invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
            $invoice_no_1= 'INV' .  date("ymdhisu");
            $invoice_no = str_replace("000000", "", $invoice_no_1);
            $today1 = date("ymdhisu");
            $url = base_url().'spayment/PY' . $today1 . '/' . $merchant_id;
            $today2 = date("Y-m-d");
            $p_date = date('F j, Y', strtotime($today2));
            $year = date("Y");
            $month = date("m");
            $time11 = date("H");
            if ($time11 == '00') {
              $time1 = '01';
            } else {
              $time1 = date("H");
            }
            $day1 = date("N");
            $today3 = date("Y-m-d H:i:s");
            $amountaa = $sub_amount + $fee;
            $unique = "PY" . $today1;

            $myfile=$_FILES['attached_file']['name'];
            if($myfile!="") {
                $new_name = date().time().$_FILES['attached_file']['name'];
                $config['file_name']            = $new_name; 
                $config['upload_path']          = './uploads/attachment/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
                $config['max_size']             = 1000;
                $config['max_width']            = 3024;
                $config['max_height']           = 3068;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('attached_file')) {
                    $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);
                    $uploadedFileName=$data['upload_data']['file_name']; 
                }
            } else {
                $uploadedFileName="";
            }
            $attachment=$uploadedFileName;

            $data = array(
              'name' => $name,
              'other_charges' => $other_charges,
              'otherChargesName' => $other_charges_title,
              'invoice_no' => $invoice_no,
              'sub_total' => $sub_amount,
              'tax' => $total_tax,
              'fee' => $fee,
              's_fee' => $s_fee,
              'invoice_type' => 'simple',
              'email_id' => $email_id,
              'mobile_no' => $mobile_no,
              'amount' => $amount,
              'detail' => $detail,
              'url' => $url,
              'payment_type' => 'straight',
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
              'attachment'=>$attachment,
              'date_c' => $today2
            );
           // print_r($data); die();
            $id = $this->admin_model->insert_data("customer_payment_request", $data);
            
            $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
            $getDashboardData_m = $getDashboard_m->result_array();
            $data['getDashboardData_m'] = $getDashboardData_m;
            $data['business_name'] = $getDashboardData_m[0]['business_name'];
            $data['address1'] = $getDashboardData_m[0]['address1'];
            $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
            $data['logo'] = $getDashboardData_m[0]['logo'];
            $data['business_number'] = $getDashboardData_m[0]['business_number'];
            $data['color'] = $getDashboardData_m[0]['color'];
            $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
            $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
            $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
            $data['payment_type'] = 'straight';
            $data['recurring_type'] = $recurring_type;
            $data['no_of_invoice'] = 1;
            $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
             
            $data['msgData'] = $data;
     
     //Satrt QuickBook sync
             $bct_id2 = $this->session->userdata('merchant_id');
               $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $bct_id2 and status='1' and inv_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                    $Qurl ="https://salequick.com/quickbook/get_invoice_detail_live";
                    $qbdata =array(
                    'id' => $id,
                    'merchant_id' => $bct_id2
                    
                    );
                    
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL, $Qurl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $result = json_decode($result,true);
                    //print_r($result);
                    curl_close($ch);
                    }
                     //End QuickBook sync

            // echo "<pre>";print_r($data);die;
            //Send Mail Code
            $msg = $this->load->view('email/simple_invoice', $data, true);
            $email = $email_id;
            if (!empty($mobile_no)) {
              $sms_reciever = $mobile_no;
              //$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");

             // $sms_message = trim(" Hello '" . $name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");
            $sms_message = trim(" '" . $getDashboardData_m[0]['business_dba_name'] . "' is requesting  payment .  '".$url."' ");


              //$sms_message = trim('Payment Url : '.$url);

              $from = '+18325324983'; //trial account twilio number
              // $to = '+'.$sms_reciever; //sms recipient number
              $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
              $to = '+1' . $mob;
              $response = $this->twilio->sms($from, $to, $sms_message);
            }
            $MailTo = $email;
            $MailSubject = 'Salequick Simple Invoice from '.$getDashboardData_m[0]['business_dba_name'];
            if (!empty($email)) {
              $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
              $this->email->to($MailTo);
              $this->email->subject($MailSubject);
              $this->email->message($msg);
              $this->email->send();
            }
            $this->session->set_userdata("mymsg", "New payment request add successfully.");
            // redirect("merchant/all_straight_request");
            redirect("pos/all_customer_request");
          }
        } else {
          $this->load->view("merchant/add_straight_request_dash", $data);
        }
      } elseif ($merchant_status == 'block') {
        $data['meta'] = "Your Account Is Block";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/block", $data);
      } elseif ($merchant_status == 'confirm') {
        $data['meta'] = "Your Account Is Not Active";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/block", $data);
      } elseif ($merchant_status == "Activate_Details") {
        $urlafterSign = base_url().'merchant/after_signup';
        $data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/blockactive", $data);
      } elseif ($merchant_status == "Waiting_For_Approval") {
        $urlafterSign = base_url().'merchant/after_signup';
        $data['meta'] = "Waiting For Admin Approval, <a href='" . $urlafterSign . "'>Activate Link</a>";
        $data['loc'] = "";
        $data['resend'] = "";
        $this->load->view("merchant/blockactive", $data);
      } else {
        $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
        $data['loc'] = "resend";
        $data['resend'] = "resend";
        $this->load->view("merchant/block", $data);
      }
    }

  public function autocallfunction()
  {
        $getallRecurringRecord = $this->db->query("SELECT  * FROM customer_payment_request WHERE  payment_type='recurring' AND ( recurring_payment='start' OR recurring_payment='stop' ) AND recurring_type!='' AND recurring_count_remain >0  AND recurring_pay_type='1' AND  status='pending'   ");
    $reptdata['getEmail']=$getallRecurringRecord = $getallRecurringRecord->result_array();
        //print_r($getallRecurringRecord);  die(); 
     if(count($getallRecurringRecord))
     {
    foreach ($getallRecurringRecord as $key => $row) {
    
           // $a=$row['recurring_payment'];
            $a=$row['status'];
            $c=$row['recurring_count_remain'];
        $e=$row['recurring_next_pay_date'];
      $b=$row['recurring_pay_type'];
      $d=date('Y-m-d'); 
       //echo $d.'---'.$e;  
       
       
       ///die(); 
    if($a=='pending' && $b=='1' &&  $c >0 && $d==$e)
    {           
            $id=$row['id'];
            
            $transaction_id=$row['transaction_id']; 
            $merchant_id=$row['merchant_id']; 
            $card_type=$row['card_type']; 
            $mobile_no=$row['mobile_no'];
            $email_id=$row['email_id'];
            $amount=$row['amount'];
            $getMerchantdata = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
            $Merchantdata = $getMerchantdata->row_array();
            $reptdata['getEmail1']=$getMerchantdata->result_array();
                         //print_r($Merchantdata); die(); 
            $account_id=$Merchantdata['account_id_cnp']; 
            $account_token=$Merchantdata['account_token_cnp']; 
            $acceptor_id=$Merchantdata['acceptor_id_cnp']; 
            $application_id=$Merchantdata['application_id_cnp']; 
            $terminal_id=$Merchantdata['terminal_id']; 
            $TicketNumber =  (rand(100000,999999));
                        
                        $mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);   
            $getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  mobile  ='".$mob."' group by card_no ");
            $token_data = $getQuery_t->row_array();
            $paymentcard=$token_data['token']; 
                         //print_r($token_data); die(); 
            $soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
            //$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
            $xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'>
      <Credentials>
      <AccountID>".$account_id."</AccountID>
      <AccountToken>".$account_token."</AccountToken>
      <AcceptorID>".$acceptor_id."</AcceptorID>
      </Credentials>
      <Application>
      <ApplicationID>".$application_id."</ApplicationID>
      <ApplicationVersion>2.2</ApplicationVersion>
      <ApplicationName>SaleQuick</ApplicationName>
      </Application>
      <Transaction>
      <TransactionAmount>".$amount."</TransactionAmount>
      <ReferenceNumber>84421174091</ReferenceNumber>
      <TicketNumber>".$TicketNumber."</TicketNumber>
      <MarketCode>3</MarketCode>
      <PaymentType>3</PaymentType>
      <SubmissionType>2</SubmissionType>
      <NetworkTransactionID>000001051388332</NetworkTransactionID>
      </Transaction>
      <Terminal>
      <TerminalID>".$terminal_id."</TerminalID>
      <CardPresentCode>3</CardPresentCode>
      <CardholderPresentCode>7</CardholderPresentCode>
      <CardInputCode>4</CardInputCode>
      <CVVPresenceCode>2</CVVPresenceCode>
      <TerminalCapabilityCode>5</TerminalCapabilityCode>
      <TerminalEnvironmentCode>6</TerminalEnvironmentCode>
      <MotoECICode>7</MotoECICode>
      </Terminal>
      <PaymentAccount>
      <PaymentAccountID>".$paymentcard."</PaymentAccountID>
      </PaymentAccount>
      </CreditCardSale>";   // data from the form, e.g. some ID number
      //print_r($xml_post_string); die();   
      $headers = array(
      "Content-type: text/xml;charset=\"utf-8\"",
      "Accept: text/xml",
      "Method:POST"
      ); //SOAPAction: your op URL
      $url = $soapUrl;
      // PHP cURL  for https connection with auth
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      // converting
      $response = curl_exec($ch); 
      $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
      $json = json_encode($xml);
      $arrayy = json_decode($json,TRUE);
      //print_r($arrayy);   die(); 
       
      curl_close($ch);
          if($arrayy['Response']['ExpressResponseMessage']=='Approved' or $arrayy['Response']['ExpressResponseMessage']=='Declined')  
          {
                $card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
                $trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
                $card_a_type = $arrayy['Response']['Card']['CardLogo'];
                $message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
                $message_complete =  $arrayy['Response']['ExpressResponseMessage'];  
                //print_r($arrayy); die();
                $TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
                $TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
                $Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
                $Address ="";
                if(isset($arrayy['Response']['Address']['BillingAddress1']))
                {
                $Address =$arrayy['Response']['Address']['BillingAddress1'];
                }
                $Ttime=substr($TransactionTime,0,2).':'.substr($TransactionTime,2,2).':'.substr($TransactionTime,4,2); 
                $Tdate=substr($TransactionDate,0,4).'-'.substr($TransactionDate,4,2).'-'.substr($TransactionDate,6,2);  
                //die(); //2019-07-04 12:05:41
                $rt=$Tdate.' '.$Ttime;
                $transaction_date=date($rt); 
                if($message_complete=='Declined')
                {
                $staus = 'declined';
                }
                //elseif($message_a=='Approved' or $message_a=='Duplicate'
                elseif($message_complete=='Approved') 
                { 
                $staus = 'confirm';  
                }
                else 
                {
                $staus = 'pending'; 
                }
                $day1 = date("N");  $today2_a = date("Y-m-d"); $year = date("Y");  $month = date("m");  $time11 = date("H");
                if($time11=='00'){  $time1 = '01';  }else{  $time1 = date("H");  }
                                $type=$row['payment_type'];
                $recurring_type=$row['recurring_type'];
                $recurring_count=$row['recurring_count'];
                $paid=$row['recurring_count_paid']+1;
                //$remain=$row['recurring_count_remain']-1;   ///  before constant feature
                $remain=($recurring_count >0)?$row['recurring_count_remain']-1:1; 
                $recurring_pay_start_date=$row['recurring_pay_start_date'];
                $recurring_next1=$row['recurring_next_pay_date'];
                
                $sub_total=$row['sub_total']+$amount;
                $paytype=$row['recurring_pay_type'];
                $recurring_payment=$row['recurring_payment'];     //   start, stop,  complete
                
              
                if($remain =='0') 
                {
                  $recurring_payment='complete'; 
                }
                else{
                  $recurring_payment='start'; 
                }
                $today1 = date("Ymdhisu");
                $url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
                $unique = "PY" . $today1;
                $today2=date('Y-m-d'); 
                if($type=='recurring'){
                  $info = array(
        
                    'status' => $staus,
        
                    'year' => $year,
        
                    'month' => $month,
        
                    'time1' => $time1,
        
                    'day1' => $day1,
        
                    'date_c' => $today2_a,
        
                    'payment_date' => $today2,
                    // 'payment_id'=>$unique,
                    'recurring_count_paid'=>$paid, 
                    'recurring_count_remain'=>$remain,
                    'transaction_id'=>$trans_a_no,
                    'sub_total' =>$sub_total,
                    'recurring_payment'=> 'complete',
                    'message'=>$message_a,
                    'ip_a' => $_SERVER['REMOTE_ADDR'],
        
                    'order_type' => 'a'
        
                  );
        
                }
                
             // print_r($info);  die(); 
              //print_r($id);  die(); 
            
                         //print_r($remain);  die(); 
            // if($remain >0 && $row['recurring_payment']=='start')
            // {
            //  $recurring_next=date($recurring_next1); 
            //  switch($recurring_type)
            //  {
            //    case 'daily':
            //      $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
            //    break;  
            //    case 'weekly':
            //      $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_next)));
            //    break;
            //    case 'biweekly':
            //       $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_next)));
            //    break;
            //    case 'monthly':
            //      $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_next)));
            //    break;
            //    case 'quarterly':
            //      $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_next)));
            //    break;
            //    case 'yearly':
            //    $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_next)));
            //    break;
            //    default :
            //      $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_next)));
            //    break; 
                    //    } 
            //  //print_r($recurring_pay_start_date);  die();
            //      $today2=date('Y-m-d'); 
            //      if($type=='recurring'){
  
            //        $data2=$info2 = Array(
            //          'reference' => $row['reference'],
            //          'name' => $row['name'],
            //          'invoice_no' => $row['invoice_no'],
            //          'email_id' => $row['email_id'],
            //          'mobile_no' => $row['mobile_no'],
            //          'amount' => $row['amount'],
            //          'sub_total' => $sub_total,
            //          'tax' => $row['tax'],
            //          'fee' => $row['fee'],
            //          's_fee' => $row['s_fee'],
            //          // 'title' => $row['title'],
            //          'detail' => $row['detail'],
            //          'note' => $row['note'],
            //          'url' => $url,    /// 
            //          'payment_type' => 'recurring',
            //          'recurring_type' => $row['recurring_type'],
            //          'recurring_count' => $row['recurring_count'],
            //          // 'due_date' => $row['due_date'],
            //          'merchant_id' => $row['merchant_id'],
            //          'sub_merchant_id' => $row['sub_merchant_id'],
            //          'payment_id'=>$unique,
            //          'recurring_payment' => $recurring_payment,
                      
            //          'recurring_pay_start_date' => $recurring_pay_start_date,
            //          'recurring_next_pay_date' => $recurring_next_pay_date,
            //          'recurring_pay_type' => $paytype,
            //          'add_date' => $today2,  ///fffff
            //          'status' => 'pending',
            //          'year' => $year,
            //          'month' => $month,
            //          'time1' => $time1,
            //          'day1' => $day1,
            //          'date_c' => '',
            //          'payment_date' => '',
            //          'recurring_count_paid' => $paid,   //fdgdfg
            //          'recurring_count_remain' => $remain, //sfsfs
            //          'transaction_id' => "",
            //          'message' =>  "",
            //          'card_type' =>  $row['card_type'],
            //          'card_no' =>  $row['card_no'],
            //          'sign' =>  "",
            //          'address' =>  $row['address'],
            //          'name_card' =>  $row['name_card'],
            //          'l_name' => "",
            //          'address_status' =>  $row['address_status'],
            //          'zip_status' =>  $row['zip_status'],
            //          'cvv_status' =>$row['cvv_status'] ,
            //          'ip_a' => $_SERVER['REMOTE_ADDR'],
            //          'order_type' => 'a'
            //        );
          
            //      }
                  
            //  //print_r($info2);  die("po"); 
              
            //     $id1 = $this->admin_model->insert_data("customer_payment_request", $info2);
            //    //$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
                        //         $orderitem=$this->db->query("SELECT * FROM order_item WHERE p_id ='$id' ")->row_array(); 
                 
            //    $data['resend'] = "";
                
            //    $item_Detail_1 = array(
            //      "p_id" => $id1,
            //      "item_name" => $orderitem['item_name'], 
            //      "quantity" => $orderitem['quantity'],
            //      "price" => $orderitem['price'],
            //      "tax" => $orderitem['tax'],
            //      "tax_id" => $orderitem['tax_id'],
            //      "tax_per" => $orderitem['tax_per'],
            //      "total_amount" => $orderitem['total_amount'],
      
            //    );
            //           $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color FROM merchant WHERE id = '" . $merchant_id . "' ");
            //        $getDashboardData_m = $getDashboard_m->result_array();
            //        //print_r($getDashboardData_m); die();  
            //        $data2['getDashboardData_m'] = $getDashboardData_m;
            //        $data2['business_name'] = $getDashboardData_m[0]['business_name'];
            //        $data2['address1'] = $getDashboardData_m[0]['address1'];
            //        $data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
            //        $data2['logo'] = $getDashboardData_m[0]['logo'];
            //        $data2['business_number'] = $getDashboardData_m[0]['business_number'];
            //        $data2['color'] = $getDashboardData_m[0]['color'];
            //        $this->admin_model->insert_data("order_item", $item_Detail_1);
            //        $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id1));
            //        $data2['item_detail'] = $item_Detail_1;  
                          
            //        $data['msgData'] = $data2;
            //        $msg = $this->load->view('email/invoice', $data, true);
            //        $MailSubject = 'Payment  Invoice';
            //        $header = "From:Salequick<info@salequick.com >\r\n" .
            //           "MIME-Version: 1.0" . "\r\n" .
            //           "Content-type: text/html; charset=UTF-8" . "\r\n";
            
            //         if(!empty($email_id)){ 
              
            //         $this->email->from('info@salequick.com', 'SaleQuick Receipt');
                
            //         $this->email->to($email_id);
                
            //         $this->email->subject($MailSubject);
                
            //         $this->email->message($msg);
                
            //         $this->email->send();
                
            //         }
            // }
            $m=$this->home_model->update_payment_single($id, $info);
            
            
                        $getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='".$id."' ");
            $getEmail = $getQuery->result_array();
            $data['getEmail'] = $getEmail;
            $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."' ");
            $getEmail1 = $getQuery1->result_array();  //print_r($getEmail1);  die(); 
            $data['getEmail1'] = $getEmail1; 
     
            $data['resend'] = "";
            
            $email = $email_id; 
            $amount = $amount;  
            $sub_total =$sub_total;
            $tax = $row['tax']; 
            $originalDate = $row['date_c'];
            $newDate = date("F d,Y", strtotime($originalDate)); 
            $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
            //Email Process
            $data['email'] = $row['email_id'];
            $data['color'] = $Merchantdata['color'];
            $data['amount'] = $amount;  
            $data['sub_total'] = $sub_total;
            $data['tax'] = $row['tax']; 
            $data['originalDate'] = $row['date_c'];
            $data['card_a_no'] = $card_a_no;
            $data['trans_a_no'] = $trans_a_no;
            $data['card_a_type'] = $card_a_type;
            $data['message_a'] = $message_a;
            $data['msgData'] = $data;
              
            
            
            $msg = $this->load->view('email/receipt', $data, true);
            
            $email = $row['email_id'];  
            //echo  $email;   die("ok"); 
               $MailSubject = 'Receipt from '.$Merchantdata['business_dba_name']; 
                   if(!empty($email)){ 
                 $this->email->from('info@salequick.com', $Merchantdata['business_dba_name']);
                 $this->email->to($email);
                 $this->email->subject($MailSubject);
                 $this->email->message($msg);
                 $this->email->send();
                   }
            $url=$row['url'];   
            $purl = str_replace('rpayment', 'reciept', $url); 
            
            if(!empty($row['mobile_no']))
            { 
            $sms_reciever = $row['mobile_no'];
            $sms_message = trim('Payment Receipt : '.$purl);
            // $sms_message = trim(' Receipt from '.$Merchantdata['business_dba_name'].' : '.$purl);
            $from = '+18325324983'; //trial account twilio number
            $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
            $to = '+1'.$mob;
            $response = $this->twilio->sms($from, $to,$sms_message);
              
            }
            
            //print_r($token_data); die; 
              $save_notificationdata = array(
              'merchant_id'=>$row['merchant_id'], 
              'name' => $row['name'],
              'mobile' => $row['mobile_no'],
              'email' => $row['email_id'],
              'card_type' =>  $token_data['card_type'],
              'card_expiry_month'=> $token_data['card_expiry_month'],
              'card_expiry_year'=> $token_data['card_expiry_year'],
              'card_no' => $token_data['card_no'],
              'amount'  =>$amount,
              'address' =>$row['address'],
              'transaction_id'=>$trans_a_no,
              'transaction_date'=>$transaction_date,
              'notification_type' => 'payment',
              'invoice_no'=>$row['invoice_no'],
              'status'   =>'unread'
              );
              //print_r($save_notificationdata); die(); 
              $this->db->insert('notification',$save_notificationdata);
              echo "All Auto Payment Complete of This date"; 
          }
          else
          {    
            $id=$arrayy['Response']['ExpressResponseMessage'];
               echo 'payment_error/'.$id;
            //redirect('payment_error/'.$id);
      
          }  
       }
       else
       {
        echo "Today is No  Auto Payment <br/>"; 
       }
      //print_r($Merchantdata); 
      //echo $this->db->last_query();  
       
    }
    //print_r($getallRecurringRecord);
  }
  else
  {
    echo "Today is No  Auto Payment <br/>"; 
  }
     
}
  public function add_customer_request() {       
    $merchant_id = $this->session->userdata('merchant_id');
    $merchant_name = $this->session->userdata('merchant_name');
    $t_fee = $this->session->userdata('t_fee');
    $aa = $this->admin_model->s_fee("merchant", $merchant_id);
    $merchantdetails = $this->admin_model->s_fee("merchant", $merchant_id);
    $s_fee = $merchantdetails['0']['s_fee'];
    $t_fee = $this->session->userdata('t_fee');
    $fee_invoice = $merchantdetails['0']['invoice'];
    $fee_swap = $merchantdetails['0']['f_swap_Recurring'];
    $fee_email = $merchantdetails['0']['text_email'];
    $names = substr($merchant_name, 0, 3); 
    $getDashboard = $this->db->query("SELECT   ( SELECT count(id) as TotalOrders from customer_payment_request where   merchant_id = '" . $merchant_id . "' ) as TotalOrders ");
    $getDashboardData = $getDashboard->result_array();
    $getDashboardNum = $getDashboard->num_rows();
    $data['getDashboardNum'] = $getDashboardNum;
    if ($getDashboardData == false) {
      $data['getDashboardData'] = '0';
      $inv = '1';
    } else {
      $data['getDashboardData'] = $getDashboardData;
      $inv1 = $getDashboardData[0]['TotalOrders'];
      $inv = $inv1 + 1;
    }
    $merchant_status = $this->session->userdata('merchant_status');
    if ($merchant_status == 'active') {
      
      $data['meta'] = "Send Recurring Payment Request";
      $data['loc'] = "add_customer_request";
      $data['action'] = "Send Request";
      if (isset($_POST['submit'])) {
      //print_r($_POST);  die(); 
        
      // $this->form_validation->set_rules('amount', 'amount', 'required');
      $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
      if($pd__constant!='on') { $this->form_validation->set_rules('recurring_count', 'Payments Duration', 'required'); }
      $this->form_validation->set_rules('paytype', 'Payment Type', 'required');
      $this->form_validation->set_rules('amount', 'amount', 'required');
      $this->form_validation->set_rules('name', 'Name', 'required');
      
      // $this->form_validation->set_rules('reverence', 'Reverence', 'required');
      // $this->form_validation->set_rules('mobile', 'Phone Number', 'required');
      // $this->form_validation->set_rules('due_date', 'Due  Date', 'required');
      $this->form_validation->set_rules('recurring_pay_start_date', 'Recurring Start  Date', 'required');
      
      // $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('Item_Name[]', 'Item Name', 'required');
      $this->form_validation->set_rules('Quantity[]', 'Quantity', 'required');
      $this->form_validation->set_rules('Price[]', 'Price', 'required');
      
      $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
      if (!empty($this->session->userdata('subuser_id'))) {
        $sub_merchant_id = $this->session->userdata('subuser_id');
      } else {
        $sub_merchant_id = '0';
      }
      $fee = ($amount / 100) * $fee_invoice;
      $fee_swap = ($fee_swap != '') ? $fee_swap : 0;
      $fee_email = ($fee_email != '') ? $fee_email : 0;
      $fee = $fee + $fee_swap + $fee_email;
      $sub_amount = $this->input->post('sub_amount') ? $this->input->post('sub_amount') : "";
      $total_tax = $this->input->post('total_tax') ? $this->input->post('total_tax') : '0' . "";
     // $invoice_no = 'INV' . strtoupper($names) . $sub_merchant_id . rand(10, 1000000) . $inv;
     // $invoice_no_1= 'INV' . strtoupper($names) . date("ymdhisu");
      $invoice_no_1= 'INV' .  date("ymdhisu");
      $invoice_no = str_replace("000000", "", $invoice_no_1);
      // $invoice_no = 'INV'.strtoupper($names).'000'.$inv;
      $recurring_payment = 'start';
      $merchant_id = $this->session->userdata('merchant_id'); 
      if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error','<div class="alert alert-danger text-center">Name,Email,Phone Number, Item Name, Quantity, Price,Payments Duration, Payment Interval  Are Required ..</div>'); 
        //$this->load->view('merchant/add_customer_request');
        redirect(base_url('merchant/add_customer_request_dash')); 
      } else {
          
        
         //print_r($_POST);  die(); 
        $other_charges = $this->input->post('other_charges') ? $this->input->post('other_charges') : "";
        $other_charges_title = $this->input->post('other_charges_title') ? $this->input->post('other_charges_title') : "";
        $paytype = $this->input->post('paytype') ? $this->input->post('paytype') : "0";
         //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
        $remark = $this->input->post('remark') ? $this->input->post('remark') : "";
        $name = $this->input->post('name') ? $this->input->post('name') : "";
        $email_id = $this->input->post('email') ? $this->input->post('email') : "";
        $phone=$mobile_no = $this->input->post('mobile') ? $this->input->post('mobile') : "";
        $recurring_type = $this->input->post('recurring_type') ? $this->input->post('recurring_type') : "";
        $recurring_count = $this->input->post('recurring_count') ? $this->input->post('recurring_count') : "";
        $pd__constant = $this->input->post('pd__constant') ? $this->input->post('pd__constant') : "";
         
        // $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : "";
        $recurring_pay_start_date = $this->input->post('recurring_pay_start_date') ? $this->input->post('recurring_pay_start_date') : "";
        $note = $this->input->post('note') ? $this->input->post('note') : "";
        $reference = $this->input->post('reverence') ? $this->input->post('reverence') : '0' . "";
         
        $address = $this->input->post('address') ? $this->input->post('address') : "";
        $country = $this->input->post('country') ? $this->input->post('country') : "";
        $city = $this->input->post('city') ? $this->input->post('city') : "";
        $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
        $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
        $name_card = $this->input->post('nameoncard') ? $this->input->post('nameoncard') : "";
        $expiry_month = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
        $expiry_year = $this->input->post('exp_year') ? $this->input->post('exp_year') : "";
        $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
        $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : ""; 
         //echo $pd__constant;   // pd__constant
          //   here :  0 i.e.  called :  MenualPay and   value 1 i.e. Called:  Auto Pay
         if($pd__constant=='on' &&  $recurring_count=="")
         {
           $recurring_count=-1; 
         }   
         // echo $recurring_count;  die();
        if($paytype=='1' && 3 > 7)    //   condition break 
        {
            
          // echo "Helllo  Its Auto Pay Mode";  die(); 
           //echo $recurring_count;  die(); 
           //$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL live 
           $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL   sandbox 
           $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'  ");
           $getEmail_a = $getQuery_a->result_array();
           $data['$getEmail_a'] = $getEmail_a;
           if(count($getEmail_a))
           {
             $merchant_email = $getEmail_a[0]['email'];
           }
          // print_r($getEmail_a);  die("Auto");
          if(!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id']))
          {     //if($account_id && $acceptor_id && $account_token && $application_id && $terminal_id)
            
            $account_id = $getEmail_a[0]['account_id_cnp']; 
            $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
            $account_token = $getEmail_a[0]['account_token_cnp']; 
            $application_id = $getEmail_a[0]['application_id_cnp'];
            $terminal_id = $getEmail_a[0]['terminal_id'];
            // $account_id = 1196211; 
            // $acceptor_id = 4445029890514;
            // $account_token = D737D32F8674BF81780A6F259DE66080F984048E249A9DB4DA01C93DC6F733A2F2535101; 
            // $application_id = 9726;
            // $terminal_id = '4374N000101';
             
            
            
            $xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken><AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>";   // data from the form, e.g. some ID number
            $headers = array(
              "Content-type: text/xml;charset=\"utf-8\"",
              "Accept: text/xml",
              "Cache-Control: no-cache",
              "Pragma: no-cache",
              "SOAPAction: https://transaction.elementexpress.com/",
              "Content-length: ".strlen($xml_post_string),
            ); //SOAPAction: your op URL 
             // print_r($xml_post_string);  die(); 
            //die("end");
            $url = $soapUrl;
            //print_r($url); die("ok"); 
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);  
            
            $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            //print_r($array); die("ok");
            curl_close($ch);
            //die("okok");
            $TicketNumber =  (rand(100000,999999));
            if ($array['Response']['ExpressResponseMessage']='ONLINE') {
              $xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken>
                 <AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
                 <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>".$amount."</TransactionAmount><ReferenceNumber>".$payment_id."</ReferenceNumber>
                 <TicketNumber>".$TicketNumber."</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>".$terminal_id."</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
                 <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
                 </Terminal><Card><CardNumber>".$card_no."</CardNumber><ExpirationMonth>".$expiry_month."</ExpirationMonth><ExpirationYear>".$expiry_year."</ExpirationYear><CVV>".$cvv."</CVV></Card><Address><BillingZipcode>".$zip."</BillingZipcode>
                  <BillingAddress1>".$address."</BillingAddress1></Address></CreditCardSale>";   // data from the form, e.g. some ID number
      
                  $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: https://transaction.elementexpress.com/", 
                    "Content-length: ".strlen($xml_post_string),
                  ); //SOAPAction: your op URL
                $url = $soapUrl;
                
                // PHP cURL  for https connection with auth
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword);
                // username and password - declared at the top of the doc
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                // converting
                $response = curl_exec($ch); 
                $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $arrayy = json_decode($json,TRUE);
                //    print_r($arrayy);
                //  die();
                curl_close($ch);
                if($arrayy['Response']['ExpressResponseMessage']=='Approved' or $arrayy['Response']['ExpressResponseMessage']=='Declined')   
                {   
                  $card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
                  $trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
                  $card_a_type = $arrayy['Response']['Card']['CardLogo'];
           
                  //print_r($card_a_type);  die(); 
                  $message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
                  $message_complete =  $arrayy['Response']['ExpressResponseMessage']; 
                  $AVSResponseCode = $arrayy['Response']['Card']['AVSResponseCode'];
                  $CVVResponseCode = $arrayy['Response']['Card']['CVVResponseCode'];
                  
                  if($AVSResponseCode=='A')
                  {
           
                    $address_status = 'Address match';
           
                    $zip_status = 'Zip does not match';
           
                  }
       
              
       
                  elseif($AVSResponseCode=='G')
           
                  {
           
                    $address_status = 'Global non-AVS participant';
           
                    $zip_status = 'Global non-AVS participant';
           
                  }
           
                  elseif($AVSResponseCode=='N')
           
                  {
           
                    $address_status = 'Address  not match';
           
                    $zip_status = 'Zip  not match';
           
                  }
           
                  elseif($AVSResponseCode=='R')
           
                  {
           
                    $address_status = 'Retry, system unavailable or timed out';
           
                    $zip_status = 'Retry, system unavailable or timed out';
           
                  }
           
                  elseif($AVSResponseCode=='S')
           
                  {
           
                    $address_status = 'Service not supported: Issuer does not support AVS and Visa';
           
                    $zip_status = 'Service not supported: Issuer does not support AVS and Visa';
           
                  }
           
                  elseif($AVSResponseCode=='U')
           
                  {
           
                    $address_status = 'Unavailable: Address information not verified for domestic transactions';
           
                    $zip_status = 'Unavailable: Address information not verified for domestic transactions';
           
                  }
           
                  elseif($AVSResponseCode=='W')
           
                  {
       
                    $address_status = 'Address does not match';
           
                    $zip_status = 'Zip matches';
           
                  }
           
                  elseif($AVSResponseCode=='X')
           
                  {
           
                    $address_status = 'Address match';
           
                    $zip_status = 'Zip matches';
           
                  }
           
                  elseif($AVSResponseCode=='Y')
           
                  {
           
                    $address_status = 'address match';
           
                    $zip_status = 'zip match';
           
                  }
           
                  elseif($AVSResponseCode=='Z')
           
                  {
           
                    $address_status = 'Address does not match';
           
                    $zip_status = 'zip match';
           
                  }
           
                  elseif($AVSResponseCode=='E')
           
                  {
           
                    $address_status = 'AVS service not supported';
           
                    $zip_status = 'AVS service not supported';
           
                  }
           
                  elseif($AVSResponseCode=='D')
           
                  {
           
                    $address_status = 'Address match (International)';
           
                    $zip_status = 'Zip  match (International)';
           
                  }
           
                  elseif($AVSResponseCode=='M')
           
                  {
           
                    $address_status = 'Address match (International)';
           
                    $zip_status = 'Zip  match (International)';
           
                  }
           
                  elseif($AVSResponseCode=='P')
           
                  {
           
                    $address_status = 'Address not verified because of incompatible formats';
           
                    $zip_status = 'Zip matches';
           
                  }
           
                  elseif($AVSResponseCode=='N')
           
                  {
           
                    $address_status = 'Address  not match';
           
                    $zip_status = 'Zip not matches';
           
                  }
           
           
           
                  if($CVVResponseCode=='M')
           
                  {
           
                    $cvv_status = 'Match';
           
                    
           
                  }
                  
                  elseif($CVVResponseCode=='P')
           
                  {
           
                    $cvv_status = 'Not Processed';
           
                  }
           
                  elseif($CVVResponseCode=='N')
           
                  {
           
                    $cvv_status = 'No Match';
           
                  }
           
           
           
                  elseif($CVVResponseCode=='S')
           
                  {
           
                    $cvv_status = 'CVV value should be on the card, but the merchant has indicated that it is not present (Visa & Discover)';
           
                  }
           
                  elseif($CVVResponseCode=='U')
           
                  {
           
                    $cvv_status = 'Issuer not certified for CVV processing';
           
                  }
                  if($arrayy['Response']['Card']['CVVResponseCode']!='M')
                  {
                      $id='CVV-Number-Error';
                      redirect('payment_error/'.$id);
                  }
                   //print_r($cvv_status);  die(); 
                  $today2 = date("Y-m-d H:i:s");
                  if($message_complete=='Declined')
                    {
                    $staus = 'declined';
                    }
                    //elseif($message_a=='Approved' or $message_a=='Duplicate') 
                  elseif($message_complete=='Approved') 
                    {
                    $staus = 'confirm'; 
                }
                else 
                {
                $staus = 'pending';  
                }
                $day1 = date("N");
                $today2_a = date("Y-m-d");
                $year = date("Y");
                $month = date("m");
                $time11 = date("H");
                if($time11=='00'){
                  $time1 = '01';
                }else{
                  $time1 = date("H");
                }
                 
             
              
              $today1 = date("ymdhisu");
              $url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
              $today2 = date("Y-m-d");
              $year = date("Y");
              $month = date("m");
              $today3 = date("Y-m-d H:i:s");
              $unique = "PY" . $today1;
              $time11 = date("H");
              if ($time11 == '00') {
                $time1 = '01';
              } else {
                $time1 = date("H");
              }
              $day1 = date("N");
              $amountaa = $sub_amount + $fee;
              $paid = 1;
              if($recurring_count >0)
              {
                $remain = $recurring_count - 1;
              }
              else
              {
                $remain=1; 
                $recurring_count= -1;   
              }
              if($remain <= 0) 
              {
                $recurring_payment='complete'; 
              }
              else{
                $recurring_payment='start'; 
              }
                 
              $recurring_pay_start_date=date($recurring_pay_start_date); 
                switch($recurring_type)
                {
                  case 'daily':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'weekly':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'biweekly':
                     $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
                  break;
                  case 'monthly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'quarterly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'yearly':
                  $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
                  break;
                  default :
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break; 
                  
                }
                
              $data1 = Array(
                'reference' => $reference,
                'name' => $name,
                'other_charges' => $other_charges,
                'otherChargesName' => $other_charges_title,
                'invoice_no' => $invoice_no,
                'email_id' => $email_id,
                'mobile_no' => $mobile_no,
                'amount' => $amount,
                'sub_total' => $sub_amount,
                'tax' => $total_tax,
                'fee' => $fee,
                's_fee' => $fee_swap,
                // 'title' => $title,
                'detail' => $remark,
                'note' => $note,
                'url' => $url,
                'payment_type' => 'recurring',
                'recurring_type' => $recurring_type,
                'recurring_count' => $recurring_count,
                // 'due_date' => $due_date,
                'merchant_id' => $merchant_id,
                'sub_merchant_id' => $sub_merchant_id,
                'payment_id' => $unique,
                'recurring_payment' => $recurring_payment,
                'recurring_pay_start_date' => $recurring_pay_start_date,
                'recurring_next_pay_date' => $recurring_next_pay_date,
                'recurring_pay_type' => $paytype,
                'status' => $staus,                
                'year' => $year,
                'month' => $month,
                'time1' => $time1,
                'day1' => $day1,
                'date_c' => $today2_a,
                'payment_date' => $today2,
                'recurring_count_paid' => $paid,
                'recurring_count_remain' => $remain,
                'transaction_id' => $trans_a_no,
                'message' =>  $message_a,
                'card_type' =>  $card_a_type,
                'card_no' =>  $card_a_no,
                'sign' =>  "",
                'address' =>  $address,
                'name_card' =>  $name_card,
                'l_name' => "",
                'address_status' =>  $address_status,
                'zip_status' =>  $zip_status,
                'cvv_status' =>  $cvv_status,
                'ip_a' => $_SERVER['REMOTE_ADDR'],
                'order_type' => 'a'
              );
                
              $id1 = $this->admin_model->insert_data("customer_payment_request", $data1);
                ///first insertion /
              $data['resend'] = "";
              $item_name = json_encode($this->input->post('Item_Name'));
              $quantity = json_encode($this->input->post('Quantity'));
              $price = json_encode($this->input->post('Price'));
              $tax = json_encode($this->input->post('Tax_Amount'));
              $tax_id = json_encode($this->input->post('Tax'));
              $tax_per = json_encode($this->input->post('Tax_Per'));
              $total_amount = json_encode($this->input->post('Total_Amount'));
              $item_Detail_1 = array(
                "p_id" => $id1,
                "item_name" => ($item_name), 
                "quantity" => ($quantity),
                "price" => ($price),
                "tax" => ($tax),
                "tax_id" => ($tax_id),
                "tax_per" => ($tax_per),
                "total_amount" => ($total_amount),
    
              );
              //print_r($item_Detail_1);  die(); 
              $this->admin_model->insert_data("order_item", $item_Detail_1);
              /*if($remain  >0 && $recurring_payment=='start') 
              {
                $recurring_pay_start_date=date($recurring_pay_start_date); 
                switch($recurring_type)
                {
                  case 'daily':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'weekly':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'biweekly':
                     $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
                  break;
                  case 'monthly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'quarterly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'yearly':
                  $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
                  break;
                  default :
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break; 
                  
                }
                $dfg = date("Ymdhisu");
                $url2 = base_url().'rpayment/PY' . $dfg . '/' . $merchant_id;
                $unique2 = "PY" . $dfg;
                 
                $data2 = Array(
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
                  // 'title' => $title,
                  'detail' => $remark,
                  'note' => $note,
                  'url' => $url2,
                  'payment_type' => 'recurring',
                  'recurring_type' => $recurring_type,
                  'recurring_count' => $recurring_count,
                  // 'due_date' => $due_date,
                  'merchant_id' => $merchant_id,
                  'sub_merchant_id' => $sub_merchant_id,
                  'payment_id' => $unique2,
                  'recurring_payment' => $recurring_payment,
                  'recurring_pay_start_date' => $recurring_pay_start_date,
                  'recurring_next_pay_date' => $recurring_next_pay_date,
                  'recurring_pay_type' => $paytype,
                  
                  'add_date' => $today3,
                  'status' => 'pending',
                  'year' => $year,
                  'month' => $month,
                  'time1' => $time1,
                  'day1' => $day1,
                  'date_c' => $today2_a,
                  'payment_date' => $today2,
                  'recurring_count_paid' => $paid,
                  'recurring_count_remain' => $remain, 
                  'transaction_id' => "",
                  'message' =>  "",
                  'card_type' =>  $card_a_type,
                  'card_no' =>  $card_a_no,
                  'sign' =>  "",
                  'address' =>  $address,
                  'name_card' =>  $name_card,
                  'l_name' => "",
                  'address_status' =>  $address_status,
                  'zip_status' =>  $zip_status,
                  'cvv_status' =>  $cvv_status,
                  'ip_a' => $_SERVER['REMOTE_ADDR'],
                  'order_type' => 'a'
                );
                //print_r($data2);   die(); 
                   $id2 = $this->admin_model->insert_data("customer_payment_request", $data2);
                  $data['resend'] = "";
                  $item_name = json_encode($this->input->post('Item_Name'));
                  $quantity = json_encode($this->input->post('Quantity'));
                  $price = json_encode($this->input->post('Price'));
                  $tax = json_encode($this->input->post('Tax_Amount'));
                  $tax_id = json_encode($this->input->post('Tax'));
                  $tax_per = json_encode($this->input->post('Tax_Per'));
                  $total_amount = json_encode($this->input->post('Total_Amount'));
                  $item_Detail_1 = array(
                    "p_id" => $id2,
                    "item_name" => ($item_name), 
                    "quantity" => ($quantity),
                    "price" => ($price),
                    "tax" => ($tax),
                    "tax_id" => ($tax_id),
                    "tax_per" => ($tax_per),
                    "total_amount" => ($total_amount),
        
                  );
                  $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color FROM merchant WHERE id = '" . $merchant_id . "' ");
                  $getDashboardData_m = $getDashboard_m->result_array();
                  //print_r($getDashboardData_m); die();  
                  $data2['getDashboardData_m'] = $getDashboardData_m;
                  $data2['business_name'] = $getDashboardData_m[0]['business_name'];
                  $data2['address1'] = $getDashboardData_m[0]['address1'];
                  $data2['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
                  $data2['logo'] = $getDashboardData_m[0]['logo'];
                  $data2['business_number'] = $getDashboardData_m[0]['business_number'];
                  $data2['color'] = $getDashboardData_m[0]['color'];
                  $this->admin_model->insert_data("order_item", $item_Detail_1);
                  $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id2));
                  $data2['item_detail'] = $item_Detail_1;  
                        
                  $data['msgData'] = $data2;
                   $msg = $this->load->view('email/invoice', $data, true);
          
                  
                   
                   $MailSubject = 'Payment  Invoice';
                   $header = "From:Salequick<info@salequick.com >\r\n" .
                     "MIME-Version: 1.0" . "\r\n" .
                     "Content-type: text/html; charset=UTF-8" . "\r\n";
          
                   if(!empty($email_id)){ 
            
                   $this->email->from('info@salequick.com', 'SaleQuick Receipt');
              
                   $this->email->to($email_id);
              
                   $this->email->subject($MailSubject);
              
                   $this->email->message($msg);
              
                   $this->email->send();
              
                   }
                   
              }  */ 
               
              $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
              $this->db->where('status','confirm'); 
              $this->db->where('id',$id1); 
              $data['getEmail']=$getEmail=$this->db->get('customer_payment_request')->result_array();
              $data['getEmail1']=$getEmail_a; 
              
              $email = $email_id; 
              $amount = $amount;
              $sub_total = $sub_amount;
              $tax = $total_tax; 
              $originalDate = $today2_a;
              $merchant_email=$getEmail_a[0]['email'];
              $newDate = date("F d,Y", strtotime($originalDate)); 
              //Email Process
              $data['email'] = $email_id;
              $data['color'] = $getEmail_a[0]['color'];
              $data['amount'] = $amount;
              $data['sub_total'] = $sub_amount;
              $data['tax'] = $total_tax; 
              $data['originalDate'] = $today2_a;
              $data['card_a_no'] = $card_a_no;
              $data['trans_a_no'] = $trans_a_no;
              $data['card_a_type'] = $card_a_type;
              $data['message_a'] = $message_a;
              $data['late_fee_status'] = $merchantdetails[0]['late_fee_status'];
              $data['late_fee'] = $getEmail[0]['late_fee'];
              $data['payment_type'] = 'recurring';
              $data['recurring_type'] = $recurring_type;
              $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
              $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
              $data['msgData'] = $data;
              $msg = $this->load->view('email/new_receipt', $data, true);
              //echo $msg;  die(); 
              $merchnat_msg = $this->load->view('email/merchnat_receipt', $data, true);
          
               $email = $email; 
       
               $MailSubject = ' Receipt from '.$getEmail_a[0]['business_dba_name']; 
               $MailSubject2= ' Receipt to '.$getEmail[0]['name']?$getEmail[0]['name']:$getEmail[0]['email_id'];
       
              if(!empty($email)){ 
       
                  $this->email->from('info@salequick.com', $getEmail_a[0]['business_dba_name']);
       
                  $this->email->to($email);
       
                  $this->email->subject($MailSubject);
       
                  $this->email->message($msg);
       
                  $this->email->send();
       
              }
                 
              if(!empty($merchant_email)){ 
       
                $this->email->from('info@salequick.com', $getEmail_a[0]['business_dba_name']);
       
                $this->email->to($merchant_email);
       
                  $this->email->subject($MailSubject2);
       
                $this->email->message($merchnat_msg);
       
                  $this->email->send();
       
              }
       
              
              if(3 > 4) {
                $url=$getEmail[0]['url']; 
                //$purl = str_replace('payment', 'reciept', $url);
                $purl = str_replace('rpayment', 'reciept', $url);
                if(!empty($mobile_no)){ 
                  //$sms_sender = trim($this->input->post('sms_sender'));
                  $sms_reciever = $getEmail[0]['mobile_no'];
                  //$sms_message = trim('Payment Receipt : '.$purl);
                  //$sms_message = trim(' Receipt from '.$getEmail_a[0]['business_dba_name'].' : '.$purl);
                   $sms_message = trim('Payment Receipt : '.$purl);
                  $from = '+18325324983'; //trial account twilio number
                  // $to = '+'.$sms_reciever; //sms recipient number
                  $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
                  $to = '+1'.$mob; 
                  $response = $this->twilio->sms($from, $to,$sms_message);
                }
              }
              $savecard=0; 
              if($savecard == '0'  )   //  card Save Condition
              {
                   // Start create Token
                $soapUrl1 = "https://certservices.elementexpress.com/";
                $referenceNumber =  (rand(1000,9999));
                 $xml_post_string = "<PaymentAccountCreateWithTransID xmlns='https://services.elementexpress.com'>
            
                  <Credentials>
            
                    <AccountID>".$account_id."</AccountID>
            
                    <AccountToken>".$account_token."</AccountToken>
            
                    <AcceptorID>".$acceptor_id."</AcceptorID>
            
                  </Credentials>
            
                  <Application>
            
                    <ApplicationID>".$application_id."</ApplicationID>
            
                    <ApplicationVersion>2.2</ApplicationVersion>
            
                    <ApplicationName>SaleQuick</ApplicationName>
            
                  </Application>
            
                  <PaymentAccount>
            
                    <PaymentAccountType>0</PaymentAccountType>
            
                    <PaymentAccountReferenceNumber>".$referenceNumber."</PaymentAccountReferenceNumber>
            
                  </PaymentAccount>
            
                  <Transaction>
            
                    <TransactionID>".$trans_a_no."</TransactionID>
            
                  </Transaction>
            
                  </PaymentAccountCreateWithTransID>";   // data from the form, e.g. some ID number
            
                  $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Method:POST"
                  ); //SOAPAction: your op URL
            
                  $url = $soapUrl1;
                  // PHP cURL  for https connection with auth
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                  curl_setopt($ch, CURLOPT_URL, $url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
                  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                  curl_setopt($ch, CURLOPT_POST, true);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                  // converting
                  $response = curl_exec($ch); 
                  $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                  $json = json_encode($xml);
                  $arrrayy = json_decode($json,TRUE);
                  // print_r($arrrayy); die(); 
                  //print_r($arrayy['Response']['PaymentAccount']['PaymentAccountReferenceNumber']);
                  curl_close($ch);
                  $tokenId=$arrrayy['Response']['PaymentAccount']['PaymentAccountID']; 
                  $mob = str_replace(array( '(', ')','-',' ' ), '', $phone);
                  $my_toke = array(
                    'name' => $name,
            
                    'mobile' => $mob,
            
                    // 'email' => $email,
            
                    'card_type' => $card_a_type,
            
                    'card_expiry_month'=>$expiry_month,
            
                    'card_expiry_year'=>$expiry_year,
            
                    'card_no' => $card_a_no,
                    // 'transaction_id'=>$trans_a_no,
                    
                    'token' => $tokenId,
            
                    );
                    $gettoken=$this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND mobile='$mob' ")->result_array();
                    if(count($gettoken) <= 0)
                    {
                      $this->db->insert('token',$my_toke);
                    }
              }
              /// print_r($my_toke);  die(); 
             // $this->db->insert('token',$my_toke);
              //print_r($response); die();
              $TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
              $TransactionDate = $arrayy['Response']['ExpressTransactionDate']; 
              //print_r($arrayy);  die(); 
              $Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
              $Address = $arrayy['Response']['Address']['BillingAddress1'];
      
              $Ttime=substr($TransactionTime,0,2).':'.substr($TransactionTime,2,2).':'.substr($TransactionTime,4,2); 
              $Tdate=substr($TransactionDate,0,4).'-'.substr($TransactionDate,4,2).'-'.substr($TransactionDate,6,2);  
              //die(); //2019-07-04 12:05:41
              $rt=$Tdate.' '.$Ttime;
              $transaction_date=date($rt); 
             
              $save_notificationdata = array(
              'merchant_id'=>$merchant_id,
              'name' => $name,
              'mobile' => $phone,
              'email' => $email,
              'card_type' => $card_a_type,
              'card_expiry_month'=>$expiry_month,
              'card_expiry_year'=>$expiry_year,
              'card_no' => $card_a_no,
              'amount'  =>$Amount,
              'address' =>$Address,
              'transaction_id'=>$trans_a_no,
              'transaction_date'=>$transaction_date,
              'notification_type' => 'payment',
              'invoice_no'=>$invoice_no,
              'status'   =>'unread'
              );
              //print_r($save_notificationdata); die(); 
               $this->db->insert('notification',$save_notificationdata);
              
               $this->session->set_userdata("succss", '<div class="alert alert-danger text-center"> New payment Add Successfully</div>');
               //redirect("merchant/add_customer_request");
              // redirect(base_url('merchant/add_customer_request'));
              //$this->session->set_userdata("mymsg", "New payment Request Add Successfully.");
              // redirect("merchant/add_customer_request");
              redirect(base_url("pos/all_customer_request_recurring"));
              //die("Aprove here"); 
            }
            else
            {
                $id=$arrayy['Response']['ExpressResponseMessage'];
                $this->session->set_flashdata("error", '<div class="alert alert-danger text-center">'.$id.'</div>');
                redirect(base_url("merchant/add_customer_request"));
            }
            }
            else{
               $id=$array['Response']['ExpressResponseMessage'];
               $this->session->set_flashdata("error", '<div class="alert alert-danger text-center">'.$id.'</div>');
               redirect(base_url("merchant/add_customer_request"));
       
            }
            
          }
          else{
              $id='CNP-Credential-Not-available';
              $this->session->set_flashdata("error", '<div class="alert alert-danger text-center">'.$id.'</div>');
              redirect(base_url("merchant/add_customer_request"));
            }
        }
        else if($paytype=='0' ||  $paytype=='1')
         {  
                  //echo $recurring_count;  die(); 
                  //print_r($merchant_id);  die("manual");  
                  
                  $today1 = date("Ymdhisu");
                  $url = base_url().'rpayment/PY' . $today1 . '/' . $merchant_id;
                  $today2 = date("Y-m-d");
                  $year = date("Y");
                  $month = date("m");
                  $today3 = date("Y-m-d H:i:s");
                  $unique = "PY" . $today1;
                  
                  $time11 = date("H");
                  if ($time11 == '00') {
                    $time1 = '01';
                  } else {
                    $time1 = date("H");
                  }
                  
                  
                  $recurring_pay_start_date=date($recurring_pay_start_date); 
                  
                  //echo $recurring_type;  die(); 
                  if($recurring_count > 0)
                  {
                    $remain = $recurring_count;
                  }
                  else
                  {
                    $remain=1; 
                    $recurring_count= -1; 
                  }
        
          switch($recurring_type)
                {
                  case 'daily':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'weekly':
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
                  break;
                  case 'biweekly':
                     $recurring_next_pay_date=date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
                  break;
                  case 'monthly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'quarterly':
                    $recurring_next_pay_date=date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
                  break;
                  case 'yearly':
                  $recurring_next_pay_date=date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
                  break;
                  default :
                    $recurring_next_pay_date=Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
                  break; 
                  
                }
          
          // print_r($recurring_pay_start_date);
          // echo "<br/><br/>"; 
          // print_r($recurring_next_pay_date); 
           //die("ok"); 
          $day1 = date("N");
          $amountaa = $sub_amount + $fee;
          $data = Array(
            'reference' => $reference,
            'name' => $name,
            'other_charges' => $other_charges,
            'otherChargesName' => $other_charges_title,
            'invoice_no' => $invoice_no,
            'email_id' => $email_id,
            'mobile_no' => $mobile_no,
            'amount' => $amount,
            'sub_total' => $sub_amount,
            'tax' => $total_tax,
            'fee' => $fee,
            's_fee' => $fee_swap,
            // 'title' => $title,
            'detail' => $remark,
            'note' => $note,
            'url' => $url,
            'payment_type' => 'recurring',
            'recurring_type' => $recurring_type,
            'recurring_count' => $recurring_count,
            'recurring_count_paid' => '0',
            'recurring_count_remain' => $remain,
            'recurring_pay_start_date' => $recurring_pay_start_date,
            'recurring_next_pay_date' => $recurring_next_pay_date,
            'recurring_pay_type' => $paytype,
            'no_of_invoice' => 1,
            // 'due_date' => $due_date,
            'merchant_id' => $merchant_id,
            'sub_merchant_id' => $sub_merchant_id,
            'payment_id' => $unique,
            'recurring_payment' => $recurring_payment,
            'year' => $year,
            'month' => $month,
            'time1' => $time1,
            'day1' => $day1,
            'status' => 'pending',
            'date_c' => $today2
            
          );
          //print_r($data); die();  
          $id = $this->admin_model->insert_data("customer_payment_request", $data);
          //  $id1 = $this->admin_model->insert_data("graph", $data);
          $item_name = json_encode($this->input->post('Item_Name'));
          $quantity = json_encode($this->input->post('Quantity'));
          $price = json_encode($this->input->post('Price'));
          $tax = json_encode($this->input->post('Tax_Amount'));
          $tax_id = json_encode($this->input->post('Tax'));
          $tax_per = json_encode($this->input->post('Tax_Per'));
          $total_amount = json_encode($this->input->post('Total_Amount'));
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
          
          
          $MailTo = $email_id;
          $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchant_id . "' ");
          $getDashboardData_m = $getDashboard_m->result_array();
          $data['getDashboardData_m'] = $getDashboardData_m;
          $data['business_name'] = $getDashboardData_m[0]['business_name'];
          $data['address1'] = $getDashboardData_m[0]['address1'];
          $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
          $data['logo'] = $getDashboardData_m[0]['logo'];
          $data['business_number'] = $getDashboardData_m[0]['business_number'];
          $data['color'] = $getDashboardData_m[0]['color'];
          $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
          $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
          $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
          $data['payment_type'] = 'recurring';
          $data['recurring_type'] = $recurring_type;
          $data['no_of_invoice'] = 1;
          $data['recurring_count'] = $recurring_count ? $recurring_count : '&infin;';
          $this->admin_model->insert_data("order_item", $item_Detail_1);
          $item = $this->admin_model->data_get_where_1("order_item", array("p_id" => $id));
          $data['item_detail'] = $item_Detail_1;  
          
          $data['msgData'] = $data;
          $msg = $this->load->view('email/invoice', $data, true);
          $MailSubject = ' Invoice from '.$getDashboardData_m[0]['business_dba_name'];
          $header = "From: ".$getDashboardData_m[0]['business_dba_name']."<info@salequick.com >\r\n" .
            "MIME-Version: 1.0" . "\r\n" .
            "Content-type: text/html; charset=UTF-8" . "\r\n";
            if($recurring_pay_start_date <= $today2) {
            if(!empty($email_id)){ 
              $this->email->from('info@salequick.com',$getDashboardData_m[0]['business_dba_name']);
              $this->email->to($email_id);
                $this->email->subject($MailSubject);
              $this->email->message($msg);
                $this->email->send();
            }
            if (!empty($mobile_no)) {
              $sms_reciever = $mobile_no;
             // $sms_message = "Hello ".$name." from ".$getDashboardData_m[0]['business_dba_name']."  is requesting  ".$amount."  payment from you <a href='".$url."'>CONTINUE TO PAYMENT</a>";
            $sms_message = trim(" '" . $getDashboardData_m[0]['business_dba_name'] . "' is requesting  payment .  '".$url."' ");


             // $sms_message = trim('Payment Url : '.$url);
              $from = '+18325324983'; //trial account twilio number
              $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
              $to = '+1' . $mob;
              $this->twilio->sms($from, $to, $sms_message);
            }
          }
        
          $this->session->set_userdata("mymsg", " New payment request add successfully.");
          // redirect("merchant/all_customer_request");
          redirect("pos/all_customer_request_recurring"); 
        }
      }
      
    } else {
      $data['meta'] = 'Recurring';
      $this->load->view("merchant/add_customer_request_dash", $data);
      // $this->load->view("merchant/add_customer_request", $data);
    }
  } elseif ($merchant_status == 'block') {
    $data['meta'] = "Your Account Is Block";
    $data['loc'] = "";
    $data['resend'] = "";
    $this->load->view("merchant/block", $data);
  } elseif ($merchant_status == 'confirm') {
    $data['meta'] = "Your Account Is Not Active";
    $data['loc'] = "";
    $data['resend'] = "";
    $this->load->view("merchant/block", $data);
  } elseif ($merchant_status == "Activate_Details") {
    $urlafterSign = base_url('merchant/after_signup');
    $data['meta'] = "Please Activate Your Account <a href='" . $urlafterSign . "'>Activate Link</a>";
    $data['loc'] = "";
    $data['resend'] = "";
    $this->load->view("merchant/blockactive", $data);
  } elseif ($merchant_status == "Waiting_For_Approval") {
    $urlafterSign = base_url('merchant/after_signup');
    $data['meta'] = "Waiting For Admin Approval, <a href='" . $urlafterSign . "'>Activate Link</a>";
    $data['loc'] = "";
    $data['resend'] = "";
    $this->load->view("merchant/blockactive", $data);
  } else {
    $data['meta'] = "Your Email Is Not Confirm First Confirm Email";
    $data['loc'] = "resend";
    $data['resend'] = "resend";
    $this->load->view("merchant/block", $data);
  }
}
  
  public function all_customer_request() {
    $data = array();
    $merchant_id = $this->session->userdata('merchant_id');
    if ($this->input->post('mysubmit')) {
      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
      $status = $_POST['status'];
      $package_data = $this->admin_model->get_package_details_customer_r($start_date, $end_date, $status, $merchant_id);
    } else {
      $package_data = $this->admin_model->get_full_details_payment_r('customer_payment_request', $merchant_id);
    }
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
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
    $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/all_customer_request', $data);
  }
  public function all_straight_request() {
    $data = array();
    $data["meta"] ='View All Straight Payment Request';
    $merchant_id = $this->session->userdata('merchant_id');
    if ($this->input->post('mysubmit')) {
      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
      $status = $_POST['status'];
      $package_data = $this->admin_model->get_search_merchant_type($start_date, $end_date, $status, $merchant_id, 'customer_payment_request', 'straight');
    } else {
      $package_data = $this->admin_model->get_full_details_payment('customer_payment_request', $merchant_id);
    }
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
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
    $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/all_straight_request', $data);
  }
  public function stop_recurring($id) {
    $this->admin_model->stop_recurring($id);
    echo json_encode(array("status" => TRUE));
  }
  public function start_recurring($id) {
    $this->admin_model->start_recurring($id);
    echo json_encode(array("status" => TRUE));
  }
  public function stop_tex($id) {
    $this->admin_model->stop_tex($id);
    echo json_encode(array("status" => TRUE));
  }
  public function start_tex($id) {
    $this->admin_model->start_tex($id);
    echo json_encode(array("status" => TRUE));
  }
  public function all_recurrig_request() {
    $data = array();
    $merchant_id = $this->session->userdata('merchant_id');
    $id = $this->uri->segment(3);
    if ($this->input->post('mysubmit')) {
      $curr_payment_date = $_POST['curr_payment_date'];
      $status = $_POST['status'];
      $package_data = $this->admin_model->get_recurring_details_payment_search($curr_payment_date, $status, $merchant_id);
    } else {
      $package_data = $this->admin_model->get_recurring_details_payment($merchant_id, $id);
    }
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
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
    $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/all_recurrig_request', $data);
  }
  public function delete_package() {
    $pak_id = $this->uri->segment(3);
    if ($this->admin_model->delete_package($pak_id)) {
      $this->session->set_userdata("mymsg", "Data Has Been Deleted.");
    }
  }
  public function active_package() {
    $pak_id = $this->uri->segment(3);
    if ($this->admin_model->active_order($pak_id)) {
      $this->session->set_userdata("mymsg", "Merchant Active.");
    }
  }
  public function add_new_request() {
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
        $url = 'py' . $today1;
        $today2 = date("Y-m-d");
        $today3 = date("Y-m-d H:i:s");
        $unique = "OH" . $today1;
        $data = Array(
          'amount' => $amount,
          'title' => $title,
          'detail' => $remark,
          'url' => $url,
          'merchant_id' => $merchant_id,
          'status' => 'pending',
          'date_c' => $today2,
        );
        $id = $this->admin_model->insert_data("payment_request", $data);
        $this->session->set_userdata("mymsg", "New payment Request Add Successfully.");
        redirect("merchant/all_payment_request");
      }
    } else {
      $this->load->view("merchant/add_request", $data);
    }
  }
  public function all_payment_request() {
    $data = array();
    if ($this->input->post('mysubmit')) {
      $curr_payment_date = $_POST['curr_payment_date'];
      $status = $_POST['status'];
      $package_data = $this->admin_model->get_package_details_new($curr_payment_date, $status);
    } else {
      $package_data = $this->admin_model->get_full_details('payment_request');
    }
    $mem = array();
    $member = array();
    foreach ($package_data as $each) {
      $package['id'] = $each->id;
      $package['amount'] = $each->amount;
      $package['title'] = $each->title;
      $package['date'] = $each->add_date;
      $package['status'] = $each->status;
      $mem[] = $package;
    }
    $data['mem'] = $mem;
    $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
    $this->session->unset_userdata('mymsg');
    $this->load->view('merchant/all_payment_request', $data);
  }
  public function edit_employee_profile() {
    if($this->input->post('mysubmit')) 
    { 
        $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $name = $this->input->post('name') ? $this->input->post('name') : "";
          $email = $this->input->post('email') ? $this->input->post('email') : "";
          $mob_no = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
        $opsw = $this->input->post('opsw') ? $this->input->post('opsw') : "";
        $npsw = $this->input->post('npsw') ? $this->input->post('npsw') : "";
        $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
        $package = $this->profile_model->get_merchant_details($id);
                $oldpsw = $this->my_encrypt($opsw, 'e');
        
        if($package[0]->password==$oldpsw)
        {
           if($npsw!="" && $cpsw!="")
            {    
            if($npsw==$cpsw)
            {
              $password=$this->my_encrypt($npsw, 'e');
              $pswMsg='<span style="color:green; "> and  password successfully changed.</span>'; 
            }
            else
            {
              $password=$package[0]->password;
              $pswMsg="";
            }
            }
            else
            {
            $password=$package[0]->password;
            
            $pswMsg="";
            }
        }
        else{
          $password=$package[0]->password;
          $pswMsg="";
        }
        $package_info = array( 'name'=>$name, 'mob_no'=>$mob_no, 'email'=>$email, 'password'=>$password );
        $this->admin_model->update_data('merchant', $package_info, array('id' => $id));
        
        $sessiondata=array( 'employee_id'=>$id,'employee_email'=>$email,'employee_username'=>$name,'employee_password'=>$password,'employee_mobile'=>$mob_no);
      
        $this->session->set_userdata($sessiondata);
            $this->session->set_flashdata('success', '<div class="alert alert-success text-center"> Profile has been updated . </div>');
    } 
    $package = $this->profile_model->get_merchant_details($this->session->userdata('employee_id'));
        $data['employeedata']=$package;
        $data['meta'] = 'Edit Profile';
    $this->load->view('merchant/edit_employee_profile', $data);
  }
    public function edit_profile() {
      // $data['emymsg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      // $this->session->unset_userdata('mymsg');
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $data['upload_loc'] = base_url('logo');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      // print_r($this->session->userdata('merchant_id'));die;
      if ($this->input->post('mysubmit')) {  
        if (!empty($sub_merchant_id)) {    
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $title = $this->input->post('title') ? $this->input->post('title') : "";
          //$is_tokenized = $this->input->post('is_tokenized') ? $this->input->post('is_tokenized') : "";
          $csv_Customer_name = $this->input->post('csv_Customer_name') ? $this->input->post('csv_Customer_name') : "";
          $late_fee_status = $this->input->post('late_fee_status') ? $this->input->post('late_fee_status') : "";
          $late_fee = $this->input->post('late_fee') ? $this->input->post('late_fee') : "";
          $late_grace_period = $this->input->post('late_grace_period') ? $this->input->post('late_grace_period') : "";
          $signature_status = $this->input->post('signature_status')=='on' ? 1 : 2;
          //echo  $is_tokenized; echo "<br/>"; echo $csv_Customer_name;  die('okjhuy'); 
          $opsw = $this->input->post('opsw') ? $this->input->post('opsw') : "";
          $npsw = $this->input->post('npsw') ? $this->input->post('npsw') : "";
          $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
           //  business  info 
          $city = $this->input->post('city') ? $this->input->post('city') : "";
          $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
          $state = $this->input->post('state') ? $this->input->post('state') : "";
          $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          $address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
          $address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
                  //  personal info 
          $o_city = $this->input->post('o_city') ? $this->input->post('o_city') : "";
          $o_zip = $this->input->post('o_zip') ? $this->input->post('o_zip') : "";
          $o_state = $this->input->post('o_state') ? $this->input->post('o_state') : "";
          $o_phone = $this->input->post('o_phone') ? $this->input->post('o_phone') : "";
          $o_address1 = $this->input->post('o_address1') ? $this->input->post('o_address1') : "";
          $o_address2 = $this->input->post('o_address2') ? $this->input->post('o_address2') : "";
          $time_zone = $this->input->post('time_zone') ? $this->input->post('time_zone') : "";
          $mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
          $color = $this->input->post('color') ? $this->input->post('color') : "";
          $api_type = $this->input->post('api_type') ? $this->input->post('api_type') : "";
          $report_type = $this->input->post('report_type') ? $this->input->post('report_type') : array();
          $report_type=implode(",",$report_type); 
          $report_email = $this->input->post('report_email') ? $this->input->post('report_email') : "";
          $notification_email = $this->input->post('notification_email') ? $this->input->post('notification_email') : "";
          
                  $package = $this->profile_model->get_merchant_details($sub_merchant_id);
                  $oldpsw = $this->my_encrypt($opsw, 'e');
          
          if($package[0]->password==$oldpsw) {
            if($npsw!="" && $cpsw!="") {    
              if($npsw==$cpsw) {
                $password=$this->my_encrypt($npsw, 'e');
                $pswMsg='<span style="color:green; "> and  password successfully changed.</span>'; 
              } else {
                $password=$package[0]->password;
                //$pswMsg='<span style="color:red; ">  Your New Password And Confirm Password Are Not Match.</span>';
                $pswMsg="";
              }
              } else {
              $password=$package[0]->password;
              //$pswMsg='<span style="color:red; ">  Your New Password And Confirm Password can`t be Blank!...</span>';
              $pswMsg="";
              }
          } else {
            $password=$package[0]->password;
            //$pswMsg=' <span style="color:red; ">  Your old Password Are Not Match.</span>';
            $pswMsg="";
          }
                  $package_info = array(
            //'business_dba_name' => $business_dba_name,
            'email'=>$title,
            'password'=>$password,
            'color' => $color,
            //   business info
            'state' => $state,
            'city' => $city,
            'zip' => $zip,
            'business_number' => $business_number,
            'address1' => $address1,
            'address2' => $address2,
            //   Personal info 
            'o_state' => $o_state,
            'o_city' => $o_city,
            'o_zip' => $o_zip,
            'o_phone' => $o_phone,
            'o_address1' => $o_address1,
            'o_address2' => $o_address2,
            'api_type' => $api_type,
            'report_type' => $report_type,
            'report_email' => $report_email,
            'notification_email' => $notification_email,
            'signature_status'=>$signature_status,
            //'is_tokenized' => $is_tokenized,
            'csv_Customer_name' => $csv_Customer_name,
            'late_fee_status' => $late_fee_status,
            'late_fee' => number_format($late_fee, 2),
            'late_grace_period' => $late_grace_period,
            'time_zone'    =>$time_zone
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
            //print_r($package_info);  die("if"); 
            //$this->session->set_userdata('merchant_name',$name);
            $this->session->set_userdata('time_zone',$time_zone);
          if($_FILES['mypic']['name']) {
                      $path = $_FILES['mypic']['name'];
                      $ext = pathinfo($path, PATHINFO_EXTENSION);
                      $filename='image_'.date('YmdHi').'.'.$ext; 
                      $_FILES['mypic']['name']=$filename;
            $config['upload_path'] = 'logo/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_width'] = 70000;
            $config['max_height'] =70000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('mypic')) {
              $fInfo = $this->upload->data();
              $mypic = $fInfo['file_name'];
              $this->session->set_userdata('merchant_logo',$mypic);
              
              $data['mypic'] =$mypic;
              $package_info = array(
            'logo' => $mypic ); 
                          $this->admin_model->update_data('merchant', $package_info, array('id' =>$sub_merchant_id));
            }
          }
          $this->session->set_flashdata('success', '<div class="alert alert-success text-center"> Profile has been updated . '.$pswMsg.'</div>');
          redirect(base_url('merchant/edit_profile'));
        } else {
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $title = $this->input->post('title') ? $this->input->post('title') : "";
          
          //$is_tokenized = $this->input->post('is_tokenized') ? $this->input->post('is_tokenized') : "";
          $csv_Customer_name = $this->input->post('csv_Customer_name') ? $this->input->post('csv_Customer_name') : "";
          $late_fee_status = $this->input->post('late_fee_status') ? $this->input->post('late_fee_status') : "";
          $late_fee = $this->input->post('late_fee') ? $this->input->post('late_fee') : "";
          $late_grace_period = $this->input->post('late_grace_period') ? $this->input->post('late_grace_period') : "";
          $signature_status = $this->input->post('signature_status')=='on' ? 1 : 2;
          //echo  $is_tokenized; echo "<br/>"; echo $csv_Customer_name;  die('okjhuy'); 
          $opsw = $this->input->post('opsw') ? $this->input->post('opsw') : "";
          $npsw = $this->input->post('npsw') ? $this->input->post('npsw') : "";
          $cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
           //  business  info 
          $city = $this->input->post('city') ? $this->input->post('city') : "";
          $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
          $state = $this->input->post('state') ? $this->input->post('state') : "";
          $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          $address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
          $address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
          //  personal info 
          $o_city = $this->input->post('o_city') ? $this->input->post('o_city') : "";
          $o_zip = $this->input->post('o_zip') ? $this->input->post('o_zip') : "";
          $o_state = $this->input->post('o_state') ? $this->input->post('o_state') : "";
          $o_phone = $this->input->post('o_phone') ? $this->input->post('o_phone') : "";
          $o_address1 = $this->input->post('o_address1') ? $this->input->post('o_address1') : "";
          $o_address2 = $this->input->post('o_address2') ? $this->input->post('o_address2') : "";
          $time_zone = $this->input->post('time_zone') ? $this->input->post('time_zone') : "";
                  $mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
          $color = $this->input->post('color') ? $this->input->post('color') : "";
          $api_type = $this->input->post('api_type') ? $this->input->post('api_type') : "";
          $report_type = $this->input->post('report_type') ? $this->input->post('report_type') : array();
          $report_type=implode(",",$report_type); 
                      
          $report_email = $this->input->post('report_email') ? $this->input->post('report_email') : "";
          $notification_email = $this->input->post('notification_email') ? $this->input->post('notification_email') : "";
          //print_r($reg); die(); 
          $oldpsw = $this->my_encrypt($opsw, 'e');
          if($package[0]->password==$oldpsw) {
            if($npsw!="" && $cpsw!="") {    
                if($npsw==$cpsw) {
                  $password=$this->my_encrypt($npsw, 'e');
                  $pswMsg='<span style="color:green; "> and  password successfully changed.</span>'; 
                } else {
                  $password=$package[0]->password;
                // $pswMsg='<span style="color:red; ">  Your New Password And Confirm Password Are Not Match.</span>';
                $pswMsg="";
                }
            } else {
                $password=$package[0]->password;
                //$pswMsg='<span style="color:red; ">  Your New Password And Confirm Password can`t be Blank!...</span>';
                $pswMsg="";
            }
          } else {
            $password=$package[0]->password;
            //$pswMsg=' <span style="color:red; ">  Your old Password Are Not Match.</span>';
            $pswMsg=""; 
          }
          
          $package_info = array(
            //'business_dba_name' => $business_dba_name,
            'email'=>$title,
            'password'=>$password,
            'color' => $color,
                      //   business info
            'state' => $state,
            'city' => $city,
            'zip' => $zip,
            'business_number' => $business_number,
            'address1' => $address1,
            'address2' => $address2,
            //   Personal info 
            'o_state' => $o_state,
            'o_city' => $o_city,
            'o_zip' => $o_zip,
            'o_phone' => $o_phone,
            'o_address1' => $o_address1,
            'o_address2' => $o_address2,
            
            'api_type' => $api_type,
            'report_type' => $report_type,
            'report_email' => $report_email,
            'notification_email' => $notification_email,
            'signature_status'=>$signature_status,
            //'is_tokenized' => $is_tokenized,
            'csv_Customer_name' => $csv_Customer_name,
            'late_fee_status' => $late_fee_status,
            'late_fee' => number_format($late_fee, 2),
            'late_grace_period' => $late_grace_period,
            'time_zone'    =>$time_zone
          );  
            $m=$this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
            // echo $this->db->last_query(); 
            //print_r($package_info);  die; 
            // $this->session->set_userdata('merchant_name',$name);
          if($_FILES['mypic']['name']) {
                      $path = $_FILES['mypic']['name'];
                      $ext = pathinfo($path, PATHINFO_EXTENSION);
                      $filename='image_'.date('YmdHi').'.'.$ext; 
                      $_FILES['mypic']['name']=$filename;
            $config['upload_path'] = 'logo/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_width'] = 70000;
            $config['max_height'] =70000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('mypic')) {
              $fInfo = $this->upload->data();
              $mypic = $fInfo['file_name'];
              $this->session->set_userdata('merchant_logo',$mypic);
              $data['mypic'] =$mypic;
              $package_info = array(
            'logo' => $mypic ); 
                          $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
            }
          }
          
          $this->session->set_userdata('time_zone',$time_zone);
          $this->session->set_userdata('merchant_id',$package[0]->id);
          $this->session->set_flashdata('success', '<div class="alert alert-success text-center"> Profile has been updated . '.$pswMsg.'</div>');
          redirect(base_url('merchant/edit_profile'));
        }
      } else {   //print_r($package);  die();
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          $data['auth_key'] = $pak->auth_key;
          $data['merchant_key'] = $pak->merchant_key;
          $data['title'] = $pak->email;
          $data['name'] = $pak->name;
          $data['psw'] = $pak->password;
          $data['color'] = $pak->color;
          $data['mypic'] = $pak->logo;
          $data['mob_no'] = $pak->o_phone;
          $data['business_dba_name'] = $pak->business_dba_name;
          //  business info 
          $data['city'] = $pak->city;
          $data['zip'] = $pak->zip;
          $data['state'] = $pak->state;
          $data['business_number'] = $pak->business_number;
          $data['address1'] = $pak->address1;
          $data['address2'] = $pak->address2;
                   //  Personal info
          $data['o_city'] = $pak->o_city;
          $data['o_zip'] = $pak->o_zip;
          $data['o_state'] = $pak->o_state;
          $data['o_phone'] = $pak->o_phone;
          $data['o_address1'] = $pak->o_address1;
          $data['o_address2'] = $pak->o_address2;
          $data['time_zone'] = $pak->time_zone;
          $data['status'] = $pak->status;
          $data['register_type'] = $pak->register_type;
          $data['api_type'] = $pak->api_type;
          $data['account_id_cnp'] = $pak->account_id_cnp;
          $data['acceptor_id_cnp'] = $pak->acceptor_id_cnp;
          $data['account_token_cnp'] = $pak->account_token_cnp;
          $data['application_id_cnp'] = $pak->application_id_cnp;
          $data['terminal_id'] = $pak->terminal_id;
          $data['signature_status'] = $pak->signature_status;
          $data['is_tokenized'] = $pak->is_tokenized;
          $data['csv_Customer_name'] = $pak->csv_Customer_name;
          $data['late_fee_status'] = $pak->late_fee_status;
          $data['late_fee'] = $pak->late_fee;
          $data['late_grace_period'] = $pak->late_grace_period;
          $data['is_token_system_permission'] = $pak->is_token_system_permission;
          $data['report_type'] = !empty($pak->report_type) ? $pak->report_type : '';
          $data['report_email'] = !empty($pak->report_email) ? $pak->report_email : '';
          $data['notification_email'] = !empty($pak->notification_email) ? $pak->notification_email : '';
          break;
        }
      } 
      //print_r($data);  die(); 
      //$package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      $data['loc'] = "edit_profile";
      $data['meta'] = 'Update Profile';
      $data['action'] = 'Update';
      //print_r($data);  die(); 
      $this->load->view('merchant/edit_profile', $data);
    }
    public function search_record_column() {
      $searchby = $this->input->post('id');
      $data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));
      // $data['item'] = $this->admin_model->search_item($searchby);
      $data['pay_report'] = $this->admin_model->search_record($searchby);
      echo $this->load->view('merchant/show_result', $data, true);
    }
    public function search_record_column_pos() {
      //echo '<pre>'; print_r();die();
      $merchant_id = $this->session->userdata('merchant_id');
      $merchant_details = $this->db->get_where('merchant', ['id' => $merchant_id])->result_array();
      $data['merchant_details'] = $merchant_details;
      //echo '<pre>'; print_r($merchant_details);die();
      $searchby = $this->input->post('id');
      $data['item'] = $this->admin_model->data_get_where_pos_itemsList("pos", $searchby);
      $data['pay_report'] = $this->admin_model->search_record_pos($searchby);
      //echo '<pre>';print_r($data['pay_report']);die();
      $data['refundData'] = $this->admin_model->data_get_refund("pos", $searchby);
       
      echo $this->load->view('merchant/show_result_pos_dash', $data, true);
      // echo $this->load->view('merchant/show_result_pos', $data, true);
    }
  public function search_record_column_pos_copy() {
    $searchby = $this->input->post('id');
    $pos = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
        $invoice_no=$pos[0]['invoice_no']; 
    $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$invoice_no'");
        $itemslist = $getQuery1->result_array();
    $data['item'] = $itemslist;
    $data['pay_report'] = $this->admin_model->search_record_pos($searchby);  
    $data['refundData'] = $this->admin_model->data_get_refund("pos", $searchby);  
     
    echo $this->load->view('merchant/show_result_pos', $data, true);
  }
  public function search_record_column_pos_refund() {
    $searchby = $this->input->post('id');
    $row_id = $this->input->post('row_id');
    $pos = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
        $invoice_no=$pos[0]['invoice_no']; 
    $transaction_type=$pos[0]['transaction_type']; 
      
      if ($transaction_type == "split") {
        $getQuery1 = $this->db->query("SELECT c.quantity,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id where c.status='2' and c.transaction_id='" . $invoice_no . "'");
        
        } else {
        $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status='2' and p.invoice_no='" . $invoice_no . "'");
        }
        $itemslist = $getQuery1->result_array();
    $data['item'] = $itemslist;
    $data['pay_report'] = $this->admin_model->search_record_pos($searchby);
    // print_r($this->db->last_query());
    // print_r($data['pay_report']);
    //  die('jo');  
    $data['refundData'] = $this->admin_model->get_refund_by_id($row_id);
    // echo $this->load->view('merchant/show_result_pos_refund', $data, true);
    echo $this->load->view('merchant/show_result_pos_refund_dash', $data, true);
  }
  public function search_invoice_detail_receipt() {
    $merchant_id = $this->session->userdata('merchant_id');
    $searchby = $this->input->post('id');
    $data['invoice_detail_receipt_item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));
    $data['invoice_detail_receipt'] = $this->admin_model->search_record($searchby);
    $data['refundData'] = $this->admin_model->data_get_refund("customer_payment_request", $searchby);
    $data['merchant_data'] = $this->profile_model->get_merchant_details($merchant_id);
     
    // echo $this->load->view('admin/show_invoice_detail_receipt', $data, true);
    echo $this->load->view('admin/show_invoice_detail_receipt_dash', $data, true);
  }
  public function search_invoice_detail_receipt_refund() {
    $searchby = $this->input->post('id');  
    $row_id = $this->input->post('row_id');  
    $data['invoice_detail_receipt_item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));
    $data['invoice_detail_receipt'] = $this->admin_model->search_record($searchby);
    $data['refundData'] = $this->admin_model->get_refund_by_id($row_id);
    echo $this->load->view('admin/show_invoice_detail_receipt_refund', $data, true);
  }
  public function search_record_payment() {
    $searchby = $this->input->post('id');
    $data['pay_report'] = $this->admin_model->search_record($searchby);
    echo $this->load->view('admin/show_result_payment', $data, true);
  }
  public function search_record_pos() {
    $searchby = $this->input->post('id');
    $data['item'] = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
    $data['pay_report'] = $this->admin_model->search_pos($searchby);
    echo $this->load->view('merchant/show_pos', $data, true);
  }
  public function search_record_column_recurring() {
    $searchby = $this->input->post('id');
    $data['pay_report'] = $this->admin_model->search_record($searchby);
    echo $this->load->view('merchant/show_result_recurring', $data, true);
  }
  public function print_reciept() {
    $user = $this->uri->segment(3);
    $file = $user . '_reciept.html';
    $cont = file_get_contents('reciepts/' . $file);
    $data['reciept'] = $cont;
    $this->load->view('registration/reciept.php', $data);
  }
  public function print_welcome() {
    $user = $this->uri->segment(3);
    $file = $user . '_welcome.html';
    $cont = file_get_contents('reciepts/' . $file);
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
    echo $this->load->view('admin/show_result1_dash', $data, true);
    // echo $this->load->view('admin/show_result1', $data, true);
  }
  
  
  public function re_receipt_pos()
  {
       $rowid = $this->input->post('rowid');
     $type = $this->input->post('type');
     if($type=='request')
     {
       $table1='customer_payment_request'; 
      
     }
     else if($type=='all_request')
     {
      $table1='pos'; 
      
     }
    if($rowid)
    {
          $this->db->where('status','confirm'); 
        $this->db->where('id',$rowid); 
        $data['getEmail']=$getEmail=$this->db->get($table1)->result_array();
        //print_r($getEmail);  die();  
        if(count($getEmail)) 
        {
          $merchantid=$getEmail[0]['merchant_id'];  
          $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchantid."'  ");
          $getEmail1 =$getQuery_a->result_array();
          $data['getEmail1'] = $getEmail1;  
          //print_r($getEmail1);  die(); 
        }
        //print_r($getEmail);  die(); 
        if($getEmail && $getEmail1)
        {
                    $itemslist=array(); 
          if($type=='all_request')
            {
              $invoice_no=$getEmail[0]['invoice_no'];
              $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$invoice_no'");
              $itemslist = $getQuery1->result_array();
              $data['invoice_detail_receipt_item'] = $itemslist;
              $data['itemlisttype'] = 'pos';
            }elseif($type=='request')
            { 
              $data['invoice_detail_receipt_item']=$this->db->query("SELECT * FROM order_item WHERE  p_id='$rowid' ")->result_array();
              $data['itemlisttype'] = 'request';
            }
            else
            {
              $data['pos_item'] =array();
              $data['itemlisttype'] = '';
            }
            $data['itemdata'] = $itemslist;
          $data['email'] = $getEmail[0]['email_id'];
          $data['color'] = $getEmail1[0]['color']?$getEmail1[0]['color']: '#000';
          $data['amount'] = $getEmail[0]['amount'];
          $data['sub_total'] = $getEmail[0]['sub_total'];
            $data['tax'] = $getEmail[0]['tax']; 
            $data['tip'] = $getEmail[0]['tip_amount']; 
          
          $data['originalDate'] = $getEmail[0]['date_c'];
          $data['card_a_no'] = $getEmail[0]['card_no'];
          $data['trans_a_no'] = $getEmail[0]['transaction_id'];
          $data['card_a_type'] = $getEmail[0]['card_type'];
          $data['message_a'] = $getEmail[0]['status'];
          $data['msgData'] = $data;
           
                    // print_r($data);  die();  
          $msg = $this->load->view('email/receipt', $data, true);   
             
          $merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
          $email=$getEmail[0]['email_id'];
          $merchant_email=$getEmail1[0]['email']; 
          //echo $email;  echo $merchant_email;  die();
           
          //$email='vaibhav.angad@gmail.com'; 
          //$merchant_email='vaibhav.angad@gmail.com'; 
                   
          $MailSubject = ' Receipt from '.$getEmail1[0]['business_dba_name']; 
          $MailSubject2 =  ' Receipt to '.$getEmail[0]['name'] ? $getEmail[0]['name']:$getEmail[0]['email_id']; 
          if(!empty($email)){ 
            $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
            $this->email->to($email);
              $this->email->subject($MailSubject);
            $this->email->message($msg);
              $this->email->send();
             }
                    //echo "200";  die(); 
              if(!empty($merchant_email)){ 
             $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
             $this->email->to($merchant_email);
             $this->email->subject($MailSubject2);
             $this->email->message($merchnat_msg);
             $this->email->send();
             }
           
            
             if($type=='request')
             {
                $url=$getEmail[0]['url'];
                $purl = str_replace('payment', 'reciept', $url);
             }
             else if($type=='all_request')
             {
              $business_dba_name=$getEmail1[0]['business_dba_name']; 
              $invoice_no=$getEmail[0]['invoice_no'];
              $purl=" '" . $business_dba_name . "' POS Invoice No :: '" . $invoice_no . "' Your Amount ::'" . $data['amount'] . "' Payment date :: '" . $data['originalDate'] . "' Transaction id ::'" . $data['trans_a_no'] . "' Card type :: '" . $data['card_a_type'] . "' ";
            }
            //print_r($getEmail[0]['mobile_no']);  die(); 
             if(!empty($getEmail[0]['mobile_no'])){ 
              //$sms_sender = trim($this->input->post('sms_sender'));
       
              $sms_reciever = $getEmail[0]['mobile_no'];
                      
              $sms_message = trim('Payment Receipt : '.$purl);
                      // $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
              $from = '+18325324983'; //trial account twilio number
       
              // $to = '+'.$sms_reciever; //sms recipient number
       
              $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
       
              $to = '+1'.$mob;
       
              $response = $this->twilio->sms($from, $to,$sms_message);
       
              }
                         
           echo "200";
        }
    }
  }
    public function re_receipt() {
      //echo '100000'; die(); 
        $rowid = $this->input->post('rowid');   
      $type = $this->input->post('type');
      if($type=='request'){
             $table1='customer_payment_request'; 
      } else if($type=='all_request') {
        $table1='pos'; 
      }
      if($rowid){
         // $this->db->where('status','confirm'); 
         //  $this->db->where('id',$rowid);  
        $data['getEmail']=$getEmail=$this->db->query("SELECT * FROM $table1 WHERE ( `status`='confirm' OR `status`='Chargeback_Confirm')  AND  id='$rowid'   ")->result_array();
          //print_r($getEmail);  die();  
        if(count($getEmail)) {
          $merchantid=$getEmail[0]['merchant_id'];  
          $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchantid."'  ");
          $getEmail1 =$getQuery_a->result_array();
          $data['getEmail1'] = $getEmail1;  
          //print_r($getEmail1);  die(); 
        }
        //print_r($getEmail);  die(); 
        //Get split payment transactions data
        $invoice_no = $getEmail[0]['invoice_no'];
        $data['split_payment_data'] = $this->db->query("SELECT * FROM `pos` WHERE merchant_id=$merchantid AND invoice_no = '$invoice_no'")->result_array();
        // echo "<pre>";print_r($data['split_payment_data']);  die();
        if($getEmail && $getEmail1) {
          $data['email'] = $getEmail[0]['email_id'];  
          $data['color'] = $getEmail1[0]['color'] ? $getEmail1[0]['color'] : '#000';
          $data['amount'] = $getEmail[0]['amount'];
          $data['full_amount'] = $getEmail[0]['full_amount'];
          $data['sub_total'] = $getEmail[0]['sub_total'];
          $data['tax'] = $getEmail[0]['tax']; 
          $data['originalDate'] = $getEmail[0]['date_c'];
          $data['card_a_no'] = $getEmail[0]['card_no'];
          $data['trans_a_no'] = $getEmail[0]['transaction_id'];
          $data['card_a_type'] = $getEmail[0]['card_type'];
          $data['message_a'] = $getEmail[0]['status'];
          $data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
          $data['late_fee'] = $getEmail[0]['late_fee'];
          $data['payment_type'] = 'recurring';
          $data['recurring_type'] = $getEmail[0]['recurring_type'];
          $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
          $data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
          $data['msgData'] = $data;
          $itemslist=array(); 
          if($type=='all_request') {
            // $invoice_no=$getEmail[0]['invoice_no'];
            // $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$invoice_no'");
            $invoice_no = $getEmail[0]['invoice_no'];
            $transaction_type = $getEmail[0]['transaction_type'];
            if ($transaction_type == "split") {
              $getQuery1 = $this->db->query("SELECT c.quantity,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id where c.status=2 and c.transaction_id='" . $invoice_no . "'");
            } else {
              $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $invoice_no . "'");
            }
            $itemslist = $getQuery1->result_array();
            $data['invoice_detail_receipt_item'] = $itemslist;
            $data['itemlisttype'] = 'pos';
          } elseif($type=='request') { 
            $data['invoice_detail_receipt_item']=$this->db->query("SELECT * FROM order_item WHERE  p_id='$rowid' ")->result_array();
            $data['itemlisttype'] = 'request';
          } else {
            $data['pos_item'] =array();
            $data['itemlisttype'] = '';
          }
          $msg = $this->load->view('email/receipt', $data, true); 
          $merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
          $email=$getEmail[0]['email_id'];
          $merchant_email=$getEmail1[0]['email'];  
          $MailSubject = ' Receipt from '.$getEmail1[0]['business_dba_name']; 
          $subject2=$getEmail[0]['name'] ? $getEmail[0]['name']:$getEmail[0]['email_id']; 
          $MailSubject2 =  ' Receipt to '.$subject2;
            
          
           //$email='vaibhav.angad@gmail.com';
         
          if(!empty($email)){ 
            $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
            $this->email->to($email);
            //$this->email->attach($filename);
              $this->email->subject($MailSubject); 
            $this->email->message($msg);
              $this->email->send();
          }
        
              if(!empty($merchant_email)){  
            $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
            $this->email->to($merchant_email);
            $this->email->subject($MailSubject2);
            $this->email->message($merchnat_msg);
            $this->email->send();
          }
          $merchant_notification_email=$getEmail1[0]['notification_email'];
          if(!empty($merchant_notification_email)){  
            $notic_emails=explode(",",$merchant_notification_email);
            $length=count($notic_emails); 
            $i=0; $arraydata=array(); 
            for( $i=0; $i < $length; $i++)
            {
              $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
              $this->email->to($notic_emails[$i]);
              $this->email->subject($MailSubject2);
              $this->email->message($merchnat_msg);
              $this->email->send();
              //array_push($arraydata,$notic_emails[$i]);
              }
          } 
          if($type=='request') {
              $url=$getEmail[0]['url'];     
              $purl = str_replace('payment','reciept', $url);
          } else if($type=='all_request') {
            $business_dba_name=$getEmail1[0]['business_dba_name']; 
            $invoice_no=$getEmail[0]['invoice_no'];
            $purl=" '" . $business_dba_name . "' POS Invoice No :: '" . $invoice_no . "' Your Amount ::'" . $data['amount'] . "' Payment date :: '" . $data['originalDate'] . "' Transaction id ::'" . $data['trans_a_no'] . "' Card type :: '" . $data['card_a_type'] . "' ";
          }
          //print_r($getEmail[0]['mobile_no']);  die(); 
          if(!empty($getEmail[0]['mobile_no'])){
            //$sms_sender = trim($this->input->post('sms_sender'));
            $sms_reciever = $getEmail[0]['mobile_no'];
            //$sms_message = trim('Payment Receipt : '.$purl);
                    //$sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
                    $sms_message = trim('Payment Receipt : '.$purl);
            $from = '+18325324983'; //trial account twilio number
            // $to = '+'.$sms_reciever; //sms recipient number
            $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
            $to = '+1'.$mob;
            //$response = $this->twilio->sms($from, $to,$sms_message);
          }
                           
          echo "200";
        } else {
          echo "500";
        }
      } else {
        echo "500";
      }
    }
    public function re_invoice() {
      $rowid = $this->input->post('rowid'); 
      if($rowid) {
         // $this->db->where('status','pending'); 
        $this->db->where('id',$rowid); 
        $getrequest=$this->db->get('customer_payment_request')->result_array();
        // if(count($getrequest) <= 0 )
        // {
        //  $this->db->where('id',$rowid); 
        //     $getrequest=$this->db->get('pos')->result_array();
        // }
        $data = array(
          'name' => $getrequest[0]['name'],
          'invoice_no' => $getrequest[0]['invoice_no'],
          'sub_total' => $getrequest[0]['sub_total'],
          'tax' => $getrequest[0]['tax'],
          'fee' => $getrequest[0]['fee'],
          's_fee' => $getrequest[0]['s_fee'],
          'email_id' => $getrequest[0]['email_id'],
          'mobile_no' => $getrequest[0]['mobile_no'],
          'amount' => $getrequest[0]['amount'],
          'title' => $getrequest[0]['title'],
          'detail' => $getrequest[0]['detail'],
          'note' => $getrequest[0]['note'],
          'url' => $getrequest[0]['url'],
          'payment_type' => 'straight',
          'recurring_type' => $getrequest[0]['recurring_type']?$getrequest[0]['recurring_type']:'',
          'recurring_count' => $getrequest[0]['recurring_count']?$getrequest[0]['recurring_count']:'',
          'recurring_count_paid' => '0',
          'recurring_count_remain' => $getrequest[0]['recurring_count_remain']?$getrequest[0]['recurring_count_remain']:'',
          'due_date' => $getrequest[0]['due_date'],
          'reference' => $getrequest[0]['reference'],
          'merchant_id' => $getrequest[0]['merchant_id'],
          'sub_merchant_id' => $getrequest[0]['sub_merchant_id'],
          'payment_id' => $getrequest[0]['payment_id'],
          'recurring_payment' => $getrequest[0]['recurring_payment'],
          'recurring_pay_start_date' => $getrequest[0]['recurring_pay_start_date'],
          'year' => $getrequest[0]['year'],
          'month' => $getrequest[0]['month'],
          'time1' => $getrequest[0]['time1'],
          'day1' => $getrequest[0]['day1'],
          'status' => 'pending',
          'date_c' => $getrequest[0]['date_c'],
          'add_date' => $getrequest[0]['add_date']
        );        
        if(count($getrequest)) { 
            $merchantid=$getrequest[0]['merchant_id'];  
            $getDashboard_m = $this->db->query(" SELECT business_name,logo,address1,business_dba_name,business_number,color,late_fee,late_fee_status,late_grace_period FROM merchant WHERE id = '" . $merchantid . "' ");
          $getDashboardData_m = $getDashboard_m->result_array();
        }
        //print_r($getrequest);  die(); 
        if($getrequest && $getDashboardData_m) {
                    $data['getDashboardData_m'] = $getDashboardData_m;
          $data['business_name'] = $getDashboardData_m[0]['business_name'];
          $data['address1'] = $getDashboardData_m[0]['address1'];
          $data['business_dba_name'] = $getDashboardData_m[0]['business_dba_name'];
          $data['logo'] = $getDashboardData_m[0]['logo'];
          $data['business_number'] = $getDashboardData_m[0]['business_number'];
          $data['color'] = $getDashboardData_m[0]['color'];
          $data['late_grace_period'] = $getDashboardData_m[0]['late_grace_period'];
          $data['late_fee_status'] = $getDashboardData_m[0]['late_fee_status'];
          $data['late_fee'] = $getDashboardData_m[0]['late_fee'];
          $data['payment_type'] = 'recurring';
          $data['recurring_type'] = $getrequest[0]['recurring_type'];
          $data['no_of_invoice'] = $getrequest[0]['no_of_invoice'];
          $data['recurring_count'] = $getrequest[0]['recurring_count'] ? $getrequest[0]['recurring_count'] : '&infin;';
          $getitem = $this->admin_model->data_get_where_1("order_item", array("p_id" => $getrequest[0]['id']));
          $item_Detail_1 = array(
            "p_id" => $getitem[0]['p_id'],
            "item_name" => ($getitem[0]['item_name']),
            "quantity" => ($getitem[0]['quantity']),
            "price" => ($getitem[0]['price']),
            "tax" => ($getitem[0]['tax']),
            "tax_id" => ($getitem[0]['tax_id']),
            "tax_per" => ($getitem[0]['tax_per']),
            "total_amount" => ($getitem[0]['total_amount']),
          );
          $data['item_detail'] = $item_Detail_1;
          $data['msgData'] = $data;
          $msg = $this->load->view('email/invoice', $data, true); 
            
          $email = $getrequest[0]['email_id'];
          $mobile_no=$getrequest[0]['mobile_no']; 
          $name=$getrequest[0]['name']; 
          $url=$getrequest[0]['url'];
          $amount=$getrequest[0]['amount'];
          $MailTo = $email;
          // $MailTo = 'vaibhav.angad@gmail.com';
            $MailSubject = 'Invoice  from  '.$getDashboardData_m[0]['business_dba_name'];
          if (!empty($email)) {
            $this->email->from('info@salequick.com', $getDashboardData_m[0]['business_dba_name']);
            $this->email->to($MailTo);
            $this->email->subject($MailSubject);
            $this->email->message($msg);
            $this->email->send();
          }
          if (!empty($mobile_no)) {
            $sms_reciever = $mobile_no;
            //$sms_message = trim(" Hello '".$name."' . ('".$getDashboardData_m[0]['business_dba_name']."') is requesting  payment from you.  ('".$amount."')('".$p_date."') $url ");

            //$sms_message = trim(" Hello '" .$name . "' . ('" . $getDashboardData_m[0]['business_dba_name'] . "') is requesting  payment from you.  ('" . $amount . "') $url ");
            $sms_message = trim(" '" . $getDashboardData_m[0]['business_dba_name'] . "' is requesting  payment .  '".$url."' ");


            //$sms_message = trim('Payment Url : '.$url);
            $from = '+18325324983'; //trial account twilio number
            // $to = '+'.$sms_reciever; //sms recipient number
            $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
            $to = '+1' . $mob;
            $response = $this->twilio->sms($from, $to, $sms_message);
          }
                    echo "200"; 
        }
      }
    }
    public function edit_business_info() {
      $data['emymsg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      $this->session->unset_userdata('mymsg');
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      // print_r($this->session->userdata('merchant_id'));die;
      if ($this->input->post('mysubmit')) {
        if (!empty($sub_merchant_id)) {    
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          //  business  info 
          $city = $this->input->post('city') ? $this->input->post('city') : "";
          $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
          $state = $this->input->post('state') ? $this->input->post('state') : "";
          $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          $address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
          $address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
                  
                  $package_info = array(
            //   business info
            'state' => $state,
            'city' => $city,
            'zip' => $zip,
            'business_number' => $business_number,
            'address1' => $address1,
            'address2' => $address2
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
          
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Business Info has been updated.</div>');
          redirect(base_url('merchant/edit_business_info'));
        } else {
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          //  business  info 
          $city = $this->input->post('city') ? $this->input->post('city') : "";
          $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
          $state = $this->input->post('state') ? $this->input->post('state') : "";
          $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          $address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
          $address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
          
          $package_info = array(
            //   business info
            'state' => $state,
            'city' => $city,
            'zip' => $zip,
            'business_number' => $business_number,
            'address1' => $address1,
            'address2' => $address2
          );  
            $m=$this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
            // echo $this->db->last_query(); 
            //print_r($package_info);  die; 
            // $this->session->set_userdata('merchant_name',$name);
          $this->session->set_userdata('merchant_id',$package[0]->id);
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Business Info has been updated.</div>');
          redirect(base_url('merchant/edit_business_info'));
        }
      } else {   //print_r($package);  die();
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          //  business info 
          $data['city'] = $pak->city;
          $data['zip'] = $pak->zip;
          $data['state'] = $pak->state;
          $data['business_number'] = $pak->business_number;
          $data['address1'] = $pak->address1;
          $data['address2'] = $pak->address2;
                  break;
        }
      } 
      //print_r($data);  die(); 
      //$package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      $data['meta'] = 'Update Business Info';
      $data['action'] = 'Update';
      //print_r($data);  die(); 
      $this->load->view('merchant/edit_business_info_dash', $data);
      // $this->load->view('merchant/edit_business_info', $data);
    }
    public function edit_report_notification() {
      $data['emymsg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      $this->session->unset_userdata('mymsg');
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      // print_r($this->session->userdata('merchant_id'));die;
      if ($this->input->post('mysubmit')) {  
        if (!empty($sub_merchant_id)) {    
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $report_email = $this->input->post('report_email') ? $this->input->post('report_email') : "";
          $report_type = $this->input->post('report_type') ? $this->input->post('report_type') : array();
          $report_type=implode(",",$report_type); 
          
                  $package_info = array(
            'report_type' => $report_type,
            'report_email' => $report_email,
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Report Notification Settings has been updated.</div>');
          redirect(base_url('merchant/edit_report_notification'));
        } else {
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $report_email = $this->input->post('report_email') ? $this->input->post('report_email') : "";
          $report_type = $this->input->post('report_type') ? $this->input->post('report_type') : array();
          $report_type=implode(",",$report_type);
          
          $package_info = array(
            'report_type' => $report_type,
            'report_email' => $report_email,
          );  
            $m=$this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
          $this->session->set_userdata('merchant_id',$package[0]->id);
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Report Notification Settings has been updated.</div>');
          redirect(base_url('merchant/edit_report_notification'));
        }
      } else {   //print_r($package);  die();
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          $data['report_type'] = !empty($pak->report_type) ? $pak->report_type : '';
          $data['report_email'] = !empty($pak->report_email) ? $pak->report_email : '';
          break;
        }
      }
      $data['meta'] = 'Update Report Notification';
      $data['action'] = 'Update';
      //print_r($data);  die(); 
      $this->load->view('merchant/edit_notification_reports_dash', $data);
      // $this->load->view('merchant/edit_notification_reports', $data);
    }
    public function edit_permissions() {
      $data['emymsg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      $this->session->unset_userdata('mymsg');
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      
      if ($this->input->post('mysubmit')) {  
        if (!empty($sub_merchant_id)) {    
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $csv_Customer_name = $this->input->post('csv_Customer_name') ? $this->input->post('csv_Customer_name') : "";
          $time_zone = $this->input->post('time_zone') ? $this->input->post('time_zone') : "";
          
                  $package_info = array(
            'csv_Customer_name' => $csv_Customer_name,
            'time_zone'    =>$time_zone
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
            $this->session->set_userdata('time_zone',$time_zone);
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Permissions has been updated.</div>');
          redirect(base_url('merchant/edit_permissions'));
        } else {
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $csv_Customer_name = $this->input->post('csv_Customer_name') ? $this->input->post('csv_Customer_name') : "";
          $time_zone = $this->input->post('time_zone') ? $this->input->post('time_zone') : "";
          
          $package_info = array(
            'csv_Customer_name' => $csv_Customer_name,
            'time_zone'    =>$time_zone
          );  
            $m=$this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
            
          $this->session->set_userdata('time_zone',$time_zone);
          $this->session->set_userdata('merchant_id',$package[0]->id);
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Permissions has been updated.</div>');
          redirect(base_url('merchant/edit_permissions'));
        }
      } else {   //print_r($package);  die();
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          $data['csv_Customer_name'] = $pak->csv_Customer_name;
          $data['is_token_system_permission'] = $pak->is_token_system_permission;
          $data['is_tokenized'] = $pak->is_tokenized;
          $data['time_zone'] = $pak->time_zone;
          break;
        }
      } 
      //print_r($data);  die(); 
      //$package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      $data['meta'] = 'Update Permissions';
      $data['action'] = 'Update';
      //print_r($data);  die(); 
      $this->load->view('merchant/edit_permissions_dash', $data);
      // $this->load->view('merchant/edit_permissions', $data);
    }
    public function edit_status() {
      $data['emymsg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      $this->session->unset_userdata('mymsg');
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      if ($this->input->post('mysubmit')) {  
        if (!empty($sub_merchant_id)) {    
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $api_type = $this->input->post('api_type') ? $this->input->post('api_type') : "";
                  $package_info = array(
            'api_type' => $api_type
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Status has been updated.</div>');
          redirect(base_url('merchant/edit_status'));
        } else {
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $api_type = $this->input->post('api_type') ? $this->input->post('api_type') : "";
          
          $package_info = array(
            'api_type' => $api_type
          );  
            $m=$this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
            
            $this->session->set_userdata('merchant_id',$package[0]->id);
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Status has been updated.</div>');
          redirect(base_url('merchant/edit_status'));
        }
      } else {   //print_r($package);  die();
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          $data['status'] = $pak->status;
          $data['api_type'] = $pak->api_type;
          break;
        }
      } 
      $data['meta'] = 'Update Status';
      $data['action'] = 'Update';
      $this->load->view('merchant/edit_status_setting', $data);
    }
    public function change_password() {
      $data['emymsg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      $this->session->unset_userdata('mymsg');
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      // print_r($this->session->userdata('merchant_id'));die;
      // echo '<pre>';print_r($_POST);die;
      if ($this->input->post('mysubmit')) {  
        if (!empty($sub_merchant_id)) {
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $opsw = $this->input->post('opsw') ? trim($this->input->post('opsw')) : "";
          $npsw = $this->input->post('npsw') ? trim($this->input->post('npsw')) : "";
          $cpsw = $this->input->post('cpsw') ? trim($this->input->post('cpsw')) : "";
          
          $package = $this->profile_model->get_merchant_details($sub_merchant_id);
                  $oldpsw = $this->my_encrypt($opsw, 'e');
          
          if($package[0]->password == $oldpsw) {
            if($npsw != "" && $cpsw != "") {    
              if($npsw == $cpsw) {
                $password = $this->my_encrypt($npsw, 'e');
                $package_info = array(
                  'password'=>$password
                );
                $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
                  $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Password has been updated.</div>');
                redirect(base_url('merchant/change_password'));
              } else {
                $this->session->set_flashdata('success', '<div class="alert alert-danger"><strong>Warning!</strong> New password and confirm password are different. Try another.</div>');
                redirect(base_url('merchant/change_password'));
              }
              } else {
              $this->session->set_flashdata('success', '<div class="alert alert-danger"><strong>Warning!</strong> New Password And Confirm Password can not be blank. Try another.</div>');
              redirect(base_url('merchant/change_password'));
              }
          } else {
            $this->session->set_flashdata('success', '<div class="alert alert-danger"><strong>Warning!</strong> Old Password does not matched. Try another.</div>');
            redirect(base_url('merchant/change_password'));
          }
                  
            
        } else {
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $opsw = $this->input->post('opsw') ? trim($this->input->post('opsw')) : "";
          $npsw = $this->input->post('npsw') ? trim($this->input->post('npsw')) : "";
          $cpsw = $this->input->post('cpsw') ? trim($this->input->post('cpsw')) : "";
          // echo $opsw.', '.$npsw.', '.$cpsw;die;
          $oldpsw = $this->my_encrypt($opsw, 'e');
          if($package[0]->password == $oldpsw) {
            if($npsw != "" && $cpsw != "") {
                if($npsw == $cpsw) {
                  $password = $this->my_encrypt($npsw, 'e');
                  $package_info = array(
                  'password'=>$password
                );  
                  $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
                  $this->session->set_userdata('merchant_id',$package[0]->id);
                $this->session->set_flashdata('success', '<div class="alert alert-success"><strong>Success!</strong> Password has been updated.</div>');
                redirect(base_url('merchant/change_password'));
                } else {
                  $this->session->set_flashdata('success', '<div class="alert alert-danger"><strong>Warning!</strong> New password and confirm password are different. Try another.</div>');
                redirect(base_url('merchant/change_password'));
                }
            } else {
              $this->session->set_flashdata('success', '<div class="alert alert-danger"><strong>Warning!</strong> New Password And Confirm Password can not be blank. Try another.</div>');
              redirect(base_url('merchant/change_password'));
            }
          } else {
            $this->session->set_flashdata('success', '<div class="alert alert-danger"><strong>Warning!</strong> Old Password does not matched. Try another.</div>');
            redirect(base_url('merchant/change_password'));
          }
        }
      } else {
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          $data['psw'] = $pak->password;
          break;
        }
      }
      $data['meta'] = 'Update Profile';
      $data['action'] = 'Update';
      $this->load->view('merchant/change_password_dash', $data);
      // $this->load->view('merchant/change_password', $data);
    }
    public function invoice_settings() {
      // $data['emymsg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
      // $this->session->unset_userdata('mymsg');
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      $data['upload_loc'] = base_url('logo');
      // print_r($this->session->userdata('merchant_id'));die;
      if ($this->input->post('mysubmit')) {
        if (!empty($sub_merchant_id)) {
          // echo 'sub_merchant_id';die;
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $signature_status = $this->input->post('signature_status')=='on' ? 1 : 2;
          $late_fee_status = $this->input->post('late_fee_status') ? $this->input->post('late_fee_status') : "";
          
          // $title = $this->input->post('user_name') ? $this->input->post('user_name') : "";
          $notification_email = $this->input->post('notification_email') ? $this->input->post('notification_email') : "";
          $late_fee = $this->input->post('late_fee') ? $this->input->post('late_fee') : "";
          $late_grace_period = $this->input->post('late_grace_period') ? $this->input->post('late_grace_period') : "";
          $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          $o_address1 = $this->input->post('o_address1') ? $this->input->post('o_address1') : "";
          $mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
          $color = $this->input->post('color') ? $this->input->post('color') : "";
          
          $package_info = array(
            'color' => $color,
            'business_number' => $business_number,
            'o_address1' => $o_address1,
            'signature_status'=>$signature_status,
            'late_fee_status' => $late_fee_status,
            // 'email'=>$title,
            'notification_email' => $notification_email,
            'late_fee' => number_format($late_fee, 2),
            'late_grace_period' => $late_grace_period
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
            if($_FILES['mypic']['name']) {
                      $path = $_FILES['mypic']['name'];
                      $ext = pathinfo($path, PATHINFO_EXTENSION);
                      $filename='image_'.date('YmdHi').'.'.$ext; 
                      $_FILES['mypic']['name']=$filename;
            $config['upload_path'] = 'logo/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_width'] = 70000;
            $config['max_height'] =70000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('mypic')) {
              $fInfo = $this->upload->data();
              $mypic = $fInfo['file_name'];
              $this->session->set_userdata('merchant_logo',$mypic);
              
              $data['mypic'] =$mypic;
              $package_info = array(
            'logo' => $mypic ); 
                          $this->admin_model->update_data('merchant', $package_info, array('id' =>$sub_merchant_id));
            }
          }
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Invoice Settings has been updated.</div>');
          redirect(base_url('merchant/invoice_settings'));
        } else {
          // echo 'else';die;
          // echo '<pre>';print_r($_POST);die;
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $signature_status = $this->input->post('signature_status')=='on' ? 1 : 2;
          $late_fee_status = $this->input->post('late_fee_status') ? $this->input->post('late_fee_status') : "";
          
          // $title = $this->input->post('user_name') ? $this->input->post('user_name') : "";
          $notification_email = $this->input->post('notification_email') ? $this->input->post('notification_email') : "";
          $late_fee = $this->input->post('late_fee') ? $this->input->post('late_fee') : "";
          $late_grace_period = $this->input->post('late_grace_period') ? $this->input->post('late_grace_period') : "";
          $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          $o_address1 = $this->input->post('o_address1') ? $this->input->post('o_address1') : "";
          $mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
          $color = $this->input->post('color') ? $this->input->post('color') : "";
          
          $package_info = array(
            'color' => $color,
            'business_number' => $business_number,
            'o_address1' => $o_address1,
            'signature_status'=>$signature_status,
            'late_fee_status' => $late_fee_status,
            // 'email'=>$title,
                      'notification_email' => $notification_email,
            'late_fee' => number_format($late_fee, 2),
            'late_grace_period' => $late_grace_period
          );  
            $m=$this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
            if($_FILES['mypic']['name']) {
                      $path = $_FILES['mypic']['name'];
                      $ext = pathinfo($path, PATHINFO_EXTENSION);
                      $filename='image_'.date('YmdHi').'.'.$ext; 
                      $_FILES['mypic']['name']=$filename;
            $config['upload_path'] = 'logo/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_width'] = 70000;
            $config['max_height'] =70000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('mypic')) {
              $fInfo = $this->upload->data();
              $mypic = $fInfo['file_name'];
              $this->session->set_userdata('merchant_logo',$mypic);
              $data['mypic'] =$mypic;
              $package_info = array(
            'logo' => $mypic ); 
                          $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
            }
          }
          $this->session->set_userdata('merchant_id',$package[0]->id);
          $this->session->set_flashdata('success', '<div class="alert alert-warning"><strong>Success!</strong> Invoice Settings has been updated.</div>');
          redirect(base_url('merchant/invoice_settings'));
        }
      } else {
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          $data['user_name'] = $pak->email; //title
          $data['color'] = $pak->color;
          $data['mypic'] = $pak->logo;
          $data['business_number'] = $pak->business_number;
          $data['address1'] = $pak->address1;
          $data['business_dba_name'] = $pak->business_dba_name;
          $data['signature_status'] = $pak->signature_status;
          $data['late_fee_status'] = $pak->late_fee_status;
          $data['late_fee'] = $pak->late_fee;
          $data['late_grace_period'] = $pak->late_grace_period;
          $data['notification_email'] = !empty($pak->notification_email) ? $pak->notification_email : '';
          break;
        }
      } 
      //print_r($data);  die(); 
      //$package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      $data['upload_loc'] = base_url('logo');
      $data['meta'] = 'Invoice & Receipt';
      $data['action'] = 'Update';
      $this->load->view('merchant/invoice_settings_dash', $data);
      // $this->load->view('merchant/invoice_settings', $data);
    }
    
    public function general_settings() {
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      // echo '<pre>';print_r($package);die;
      if ($this->input->post('mysubmit')) {  
        if (!empty($sub_merchant_id)) {    
          $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          // $csv_Customer_name = $this->input->post('csv_Customer_name') ? $this->input->post('csv_Customer_name') : "";
          
          $opsw = $this->input->post('old_pswd') ? trim($this->input->post('old_pswd')) : "";
          $npsw = $this->input->post('npsw') ? trim($this->input->post('npsw')) : "";
          $cpsw = $this->input->post('cpsw') ? trim($this->input->post('cpsw')) : "";
          
          // $city = $this->input->post('city') ? $this->input->post('city') : "";
          // $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
          // $state = $this->input->post('state') ? $this->input->post('state') : "";
          // $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          // $address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
          // $address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
                  
                  // $time_zone = $this->input->post('time_zone') ? $this->input->post('time_zone') : "";
          // $report_type = $this->input->post('report_type') ? $this->input->post('report_type') : array();
          // $report_type=implode(",",$report_type); 
          // $report_email = $this->input->post('report_email') ? $this->input->post('report_email') : "";
          
          $package = $this->profile_model->get_merchant_details($sub_merchant_id);
                  $oldpsw = $this->my_encrypt($opsw, 'e');
                  if(!empty($opsw)) {
                    if($package[0]->password == $oldpsw) {
              if($npsw != "" && $cpsw != "") {    
                if($npsw == $cpsw) {
                  $password = $this->my_encrypt($npsw, 'e');
                  $package_info = array(
                    'password'=>$password
                  );
                  $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
                    $this->session->set_flashdata('success', '<strong>Success!</strong> Password has been updated.');
                  redirect(base_url('merchant/general_settings'));
                } else {
                  $this->session->set_flashdata('error', '<strong>Warning!</strong> New password and confirm password are different. Try another.');
                  redirect(base_url('merchant/general_settings'));
                }
                } else {
                $this->session->set_flashdata('error', '<strong>Warning!</strong> New Password And Confirm Password can not be blank. Try another.');
                redirect(base_url('merchant/general_settings'));
                }
            } else {
              $this->session->set_flashdata('error', '<strong>Warning!</strong> Incorrect Old Password. Try another.');
              redirect(base_url('merchant/general_settings'));
            }
                  }
            //        else {
            //         $package_info = array(
            //   'address1' => $address1,
            //   'address2' => $address2,
            //   'city' => $city,
            //   'state' => $state,
            //   'zip' => $zip,
            //   'business_number' => $business_number,
              
            //   'report_type' => $report_type,
            //   'report_email' => $report_email,
            //   'csv_Customer_name' => $csv_Customer_name,
            //   'time_zone'    =>$time_zone
            // );
            //   $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
            //   $this->session->set_userdata('time_zone',$time_zone);
            // $this->session->set_flashdata('success', '<strong>Success!</strong> General Settings has been updated successfully.');
            // redirect(base_url('merchant/general_settings'));
            //       }
        } else {
                  $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
          $csv_Customer_name = $this->input->post('csv_Customer_name') ? $this->input->post('csv_Customer_name') : "";
          
          $opsw = $this->input->post('old_pswd') ? trim($this->input->post('old_pswd')) : "";
          $npsw = $this->input->post('npsw') ? trim($this->input->post('npsw')) : "";
          $cpsw = $this->input->post('cpsw') ? trim($this->input->post('cpsw')) : "";
          
          $city = $this->input->post('city') ? $this->input->post('city') : "";
          $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
          $state = $this->input->post('state') ? $this->input->post('state') : "";
          $business_number = $this->input->post('business_number') ? $this->input->post('business_number') : "";
          $address1 = $this->input->post('address1') ? $this->input->post('address1') : "";
          $address2 = $this->input->post('address2') ? $this->input->post('address2') : "";
          $ecom_transaction_mode = $this->input->post('ecom_transaction_mode') ? $this->input->post('ecom_transaction_mode') : "";
          
          $time_zone = $this->input->post('time_zone') ? $this->input->post('time_zone') : "";
          //$batch_report_time = $this->input->post('batch_report_time') ? $this->input->post('batch_report_time') : "";
          $this->session->unset_userdata('time_zone');
          $this->session->set_userdata('time_zone', $time_zone);
            $report_type = $this->input->post('report_type') ? $this->input->post('report_type') : array();
            
          $report_type=implode(",",$report_type); 
                      
          $report_email = $this->input->post('report_email') ? $this->input->post('report_email') : "";
          
          $oldpsw = $this->my_encrypt($opsw, 'e');
          
          if(!empty($opsw)) {
            if($package[0]->password == $oldpsw) {
              if($npsw != "" && $cpsw != "") {
                  if($npsw == $cpsw) {
                    $password = $this->my_encrypt($npsw, 'e');
                    $package_info = array(
                    'password'=>$password
                  );  
                    $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
                    $this->session->set_userdata('merchant_id',$package[0]->id);
                  $this->session->set_flashdata('success', '<strong>Success!</strong> Password has been updated.');
                  redirect(base_url('merchant/general_settings'));
                  } else {
                    $this->session->set_flashdata('error', '<strong>Warning!</strong> New password and confirm password are different. Try another.');
                  redirect(base_url('merchant/general_settings'));
                  }
              } else {
                $this->session->set_flashdata('error', '<strong>Warning!</strong> New Password And Confirm Password can not be blank. Try another.');
                redirect(base_url('merchant/general_settings'));
              }
            } else {
              $this->session->set_flashdata('error', '<strong>Warning!</strong> Incorrect Old Password. Try another.');
              redirect(base_url('merchant/general_settings'));
            }
          } else {
            $package_info = array(
              'address1' => $address1,
              'address2' => $address2,
              'city' => $city,
              'state' => $state,
              'zip' => $zip,
              'business_number' => $business_number,
              'report_type' => $report_type,
              'report_email' => $report_email,
              'csv_Customer_name' => $csv_Customer_name,
              'time_zone'    =>$time_zone,
              'ecom_transaction_mode'    =>$ecom_transaction_mode 
            );  
              $m=$this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
              
            $this->session->set_userdata('time_zone',$time_zone);
            $this->session->set_userdata('merchant_id',$package[0]->id);
            
            $this->session->set_flashdata('success', '<strong>Success!</strong> General Settings has been updated successfully.');
            redirect(base_url('merchant/general_settings'));
          }
          
        }
      } else {
        foreach ($package as $pak) {
          $data['pak_id'] = $pak->id;
          $data['auth_key'] = $pak->auth_key;
          $data['merchant_key'] = $pak->merchant_key;
          $data['title'] = $pak->email;
          $data['name'] = $pak->name;
          $data['psw'] = $pak->password;
          $data['color'] = $pak->color;
          $data['mypic'] = $pak->logo;
          $data['mob_no'] = $pak->o_phone;
          $data['business_dba_name'] = $pak->business_dba_name;
          $data['batch_report_time'] = $pak->batch_report_time;
          //  business info 
          $data['city'] = $pak->city;
          $data['zip'] = $pak->zip;
          $data['state'] = $pak->state;
          $data['business_number'] = $pak->business_number;
          $data['address1'] = $pak->address1;
          $data['address2'] = $pak->address2;
          $data['time_zone'] = $pak->time_zone;
          $data['status'] = $pak->status;
          $data['register_type'] = $pak->register_type;
          $data['api_type'] = $pak->api_type;
          $data['account_id_cnp'] = $pak->account_id_cnp;
          $data['acceptor_id_cnp'] = $pak->acceptor_id_cnp;
          $data['account_token_cnp'] = $pak->account_token_cnp;
          $data['application_id_cnp'] = $pak->application_id_cnp;
          $data['terminal_id'] = $pak->terminal_id;
          $data['signature_status'] = $pak->signature_status;
          $data['is_tokenized'] = $pak->is_tokenized;
          $data['csv_Customer_name'] = $pak->csv_Customer_name;
          $data['late_fee_status'] = $pak->late_fee_status;
          $data['late_fee'] = $pak->late_fee;
          $data['late_grace_period'] = $pak->late_grace_period;
          $data['is_token_system_permission'] = $pak->is_token_system_permission;
          $data['report_type'] = !empty($pak->report_type) ? $pak->report_type : '';
          $data['report_email'] = !empty($pak->report_email) ? $pak->report_email : '';
          $data['notification_email'] = !empty($pak->notification_email) ? $pak->notification_email : '';
          $data['ecom_transaction_mode'] = $pak->ecom_transaction_mode;
          
          break;
        }
      } 
      $data['meta'] = 'General';
      $this->load->view('merchant/edit_business_info_dash', $data);
    }
    public function re_receipt_instore_on_phone() {
      $rowid = $this->input->post('rowid');
      $type = $this->input->post('type');
      $phone_formated = !empty($this->input->post('phone_formated')) ? $this->input->post('phone_formated') : '';
      $phone = !empty($this->input->post('phone')) ? $this->input->post('phone') : '';
      
      $table1='pos';
      if(empty($phone_formated)) {
        echo "500";die;
      }
      if($rowid){
         $data['getEmail']=$getEmail=$this->db->query("SELECT * FROM $table1 WHERE ( `status`='confirm' OR `status`='Chargeback_Confirm')  AND  id='$rowid'   ")->result_array();
        if(count($getEmail)) {
          $merchantid=$getEmail[0]['merchant_id'];
          $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchantid."'  ");
          $getEmail1 =$getQuery_a->result_array();
          $data['getEmail1'] = $getEmail1;
        }
        //Get split payment transactions data
        $invoice_no = $getEmail[0]['invoice_no'];
        $data['split_payment_data'] = $this->db->query("SELECT * FROM `pos` WHERE merchant_id=$merchantid AND invoice_no = '$invoice_no'")->result_array();
        if($getEmail && $getEmail1) {
          $data['email'] = !empty($email_id) ? $email_id : $getEmail[0]['email_id'];
          $data['color'] = $getEmail1[0]['color'] ? $getEmail1[0]['color'] : '#000';
          $data['amount'] = $getEmail[0]['amount'];
          $data['full_amount'] = $getEmail[0]['full_amount'];
          $data['sub_total'] = $getEmail[0]['sub_total'];
          $data['tax'] = $getEmail[0]['tax']; 
          $data['originalDate'] = $getEmail[0]['date_c'];
          $data['card_a_no'] = $getEmail[0]['card_no'];
          $data['trans_a_no'] = $getEmail[0]['transaction_id'];
          $data['card_a_type'] = $getEmail[0]['card_type'];
          $data['message_a'] = $getEmail[0]['status'];
          $data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
          $data['late_fee'] = $getEmail[0]['late_fee'];
          $data['payment_type'] = 'recurring';
          $data['recurring_type'] = $getEmail[0]['recurring_type'];
          $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
          $data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
          $data['msgData'] = $data;
          $itemslist=array(); 
          if($type=='all_request') {
            $invoice_no = $getEmail[0]['invoice_no'];
            $transaction_type = $getEmail[0]['transaction_type'];
            if ($transaction_type == "split") {
              $getQuery1 = $this->db->query("SELECT c.quantity,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id where c.status=2 and c.transaction_id='" . $invoice_no . "'");
            } else {
              $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $invoice_no . "'");
            }
            $itemslist = $getQuery1->result_array();
            $data['invoice_detail_receipt_item'] = $itemslist;
            $data['itemlisttype'] = 'pos';
          }
          $msg = $this->load->view('email/receipt', $data, true); 
          $merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
          $merchant_email=$getEmail1[0]['email'];
          $MailSubject = ' Receipt from '.$getEmail1[0]['business_dba_name']; 
          $subject2=$getEmail[0]['name'] ? $getEmail[0]['name']:$getEmail[0]['email_id']; 
          $MailSubject2 =  ' Receipt to '.$subject2;
          
          // if(!empty($email_id)){
          //  $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
          //  $this->email->to($email_id);
          //  $this->email->subject($MailSubject); 
          //  $this->email->message($msg);
          //     $this->email->send();
          //     $package_info = array(
          //    're_email_id' => $email_id
          //  );
          //     $this->admin_model->update_data($table1, $package_info, array('id' => $rowid));
         //   }
          
          $merchant_notification_email=$getEmail1[0]['notification_email'];
          if($type=='all_request') {
            $business_dba_name=$getEmail1[0]['business_dba_name']; 
            $invoice_no=$getEmail[0]['invoice_no'];
            $purl=" '" . $business_dba_name . "' POS Invoice No :: '" . $invoice_no . "' Your Amount ::'" . $data['amount'] . "' Payment date :: '" . $data['originalDate'] . "' Transaction id ::'" . $data['trans_a_no'] . "' Card type :: '" . $data['card_a_type'] . "' ";
          }
          if(!empty($phone)){
                      $getEmail[0]['pos_type'];
        if( $getEmail[0]['pos_type']==1){
        $purll = 'https://salequick.com/adv_pos_reciept/' . $invoice_no . '/' . $merchantid;
        }
        else
        {
        $purll = 'https://salequick.com/pos_reciept/' . $invoice_no . '/' . $merchantid;
        }
 
       // $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purll);
       $sms_message = trim(" Payment  Receipt: $purll");
          
            $from = '+18325324983'; //trial account twilio number
             $to = '+'.$phone; //sms recipient number
             $mob = str_replace(array( '(', ')','-',' ' ), '', $phone);
              $to = '+1'.$mob;
           // $this->twilio->sms($from, $phone,$sms_message);
             $response_2 = $this->twilio->sms($from, $to, $sms_message);
                     
             $response_2->HttpStatus;
            $package_info = array(
              're_mobile_no' => $phone_formated
            );
              $this->admin_model->update_data($table1, $package_info, array('id' => $rowid));
          }
                           
          echo "200";
        } else {
          echo "500";
        }
      } else {
        echo "500";
      }
    }
    public function re_receipt_instore_on_email() {
      $rowid = $this->input->post('rowid');
      $type = $this->input->post('type');
      $email_id = !empty($this->input->post('email_id')) ? $this->input->post('email_id') : '';
      
      $table1='pos';
      if(empty($email_id)) {
        echo "500";die;
      }
      if($rowid){
         $data['getEmail']=$getEmail=$this->db->query("SELECT * FROM $table1 WHERE ( `status`='confirm' OR `status`='Chargeback_Confirm')  AND  id='$rowid'   ")->result_array();
        if(count($getEmail)) {
          $merchantid=$getEmail[0]['merchant_id'];
          $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchantid."'  ");
          $getEmail1 =$getQuery_a->result_array();
          $data['getEmail1'] = $getEmail1;
        }
        //Get split payment transactions data
        $invoice_no = $getEmail[0]['invoice_no'];
        $data['split_payment_data'] = $this->db->query("SELECT * FROM `pos` WHERE merchant_id=$merchantid AND invoice_no = '$invoice_no'")->result_array();
        if($getEmail && $getEmail1) {
          $data['email'] = !empty($email_id) ? $email_id : $getEmail[0]['email_id'];
          $data['color'] = $getEmail1[0]['color'] ? $getEmail1[0]['color'] : '#000';
          $data['amount'] = $getEmail[0]['amount'];
          $data['full_amount'] = $getEmail[0]['full_amount'];
          $data['sub_total'] = $getEmail[0]['sub_total'];
          $data['tax'] = $getEmail[0]['tax']; 
          $data['originalDate'] = $getEmail[0]['date_c'];
          $data['card_a_no'] = $getEmail[0]['card_no'];
          $data['trans_a_no'] = $getEmail[0]['transaction_id'];
          $data['card_a_type'] = $getEmail[0]['card_type'];
          $data['message_a'] = $getEmail[0]['status'];
          $data['late_fee_status'] = $getEmail1[0]['late_fee_status'];
          $data['late_fee'] = $getEmail[0]['late_fee'];
          $data['payment_type'] = 'recurring';
          $data['recurring_type'] = $getEmail[0]['recurring_type'];
          $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
          $data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
          $data['msgData'] = $data;
          $itemslist=array(); 
          if($type=='all_request') {
            $invoice_no = $getEmail[0]['invoice_no'];
            $transaction_type = $getEmail[0]['transaction_type'];
            if ($transaction_type == "split") {
              $getQuery1 = $this->db->query("SELECT c.quantity,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id where c.status=2 and c.transaction_id='" . $invoice_no . "'");
            } else {
              $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $invoice_no . "'");
            }
            $itemslist = $getQuery1->result_array();
            $data['invoice_detail_receipt_item'] = $itemslist;
            $data['itemlisttype'] = 'pos';
          }
          $msg = $this->load->view('email/receipt', $data, true); 
          $merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
          $merchant_email=$getEmail1[0]['email'];
          $MailSubject = ' Receipt from '.$getEmail1[0]['business_dba_name']; 
          $subject2=$getEmail[0]['name'] ? $getEmail[0]['name']:$getEmail[0]['email_id']; 
          $MailSubject2 =  ' Receipt to '.$subject2;
          
          if(!empty($email_id)){
            $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
            $this->email->to($email_id);
            $this->email->subject($MailSubject); 
            $this->email->message($msg);
              $this->email->send();
              $package_info = array(
              're_email_id' => $email_id
            );
              $this->admin_model->update_data($table1, $package_info, array('id' => $rowid));
          }
          
          $merchant_notification_email=$getEmail1[0]['notification_email'];
          if($type=='all_request') {
            $business_dba_name=$getEmail1[0]['business_dba_name']; 
            $invoice_no=$getEmail[0]['invoice_no'];
            $purl=" '" . $business_dba_name . "' POS Invoice No :: '" . $invoice_no . "' Your Amount ::'" . $data['amount'] . "' Payment date :: '" . $data['originalDate'] . "' Transaction id ::'" . $data['trans_a_no'] . "' Card type :: '" . $data['card_a_type'] . "' ";
          }
          // if(!empty($phone)){
          //  $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
          //  $from = '+18325324983'; //trial account twilio number
          //  // $to = '+'.$sms_reciever; //sms recipient number
          //  // $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);
          //  // $to = '+1'.$mob;
          //  $this->twilio->sms($from, $phone,$sms_message);
          //  $package_info = array(
          //    're_mobile_no' => $phone_formated
          //  );
          //     $this->admin_model->update_data($table1, $package_info, array('id' => $rowid));
          // }
                           
          echo "200";
        } else {
          echo "500";
        }
      } else {
        echo "500";
      }
    }
    function get_phone_email_info() {
      $rowid = $this->input->post('rowid');
      // echo $rowid;die;
      // $data = array();
      $get_email_info = $this->db->get_where('pos', array('id' => $rowid))->result_array();
      // echo $get_email_info[0]['re_email_id'];die;
      // print_r($get_email_info[0]);die;
      // echo $get_email_info[0]['email_id'].','.$get_email_info[0]['re_email_id'];die;
      $email_id = !empty($get_email_info[0]['re_email_id']) ? $get_email_info[0]['re_email_id'] : $get_email_info[0]['email_id'];
      $phone_no = !empty($get_email_info[0]['re_mobile_no']) ? $get_email_info[0]['re_mobile_no'] : $get_email_info[0]['mobile_no'];
      // echo $email_id.','.$phone_no;die;
      $data = array(
        'email_id' => $email_id,
        'phone_no' => $phone_no
      );
      // print_r($data);die;
      echo json_encode($data);
    }
    public function update_profile_picture() {
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      // echo 'hello';print_r($_FILES);die;
      if (!empty($sub_merchant_id)) {
        $path = $_FILES['mypic']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $filename='image_'.date('YmdHi').'.'.$ext; 
                $_FILES['mypic']['name']=$filename;
        $config['upload_path'] = 'logo/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_width'] = 70000;
        $config['max_height'] =70000;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('mypic')) {
          $fInfo = $this->upload->data();
          $mypic = $fInfo['file_name'];
          $this->session->set_userdata('merchant_logo',$mypic);
          
          $data['mypic'] =$mypic;
          $package_info = array(
            'logo' => $mypic ); 
                    $this->admin_model->update_data('merchant', $package_info, array('id' =>$sub_merchant_id));
        }
          echo $mypic;
      } else {
        $path = $_FILES['mypic']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $filename='image_'.date('YmdHi').'.'.$ext; 
                $_FILES['mypic']['name']=$filename;
        $config['upload_path'] = 'logo/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_width'] = 70000;
        $config['max_height'] =70000;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('mypic')) {
          $fInfo = $this->upload->data();
          $mypic = $fInfo['file_name'];
          $this->session->set_userdata('merchant_logo',$mypic);
          $data['mypic'] =$mypic;
          $package_info = array(
        'logo' => $mypic ); 
                    $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
        }
          echo $mypic;
      }
    }
    public function update_invoice_color() {
      // echo '<pre>';print_r($_POST);die;
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      if(!empty($this->input->post('invoice_color'))) {
        if (!empty($sub_merchant_id)) {
          $invoice_color = $this->input->post('invoice_color');
                  $package_info = array(
            'color' => $invoice_color
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
        } else {
                  $invoice_color = $this->input->post('invoice_color');
          $package_info = array(
            'color' => $invoice_color
          );
          $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
        }
        echo $invoice_color;
      }
    }
    public function update_business_number() {
      // echo '<pre>';print_r($_POST);die;
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      if(!empty($this->input->post('business_number'))) {
        if (!empty($sub_merchant_id)) {
          $business_number = $this->input->post('business_number');
                  $package_info = array(
            'business_number' => $business_number
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
        } else {
                  $business_number = $this->input->post('business_number');
          $package_info = array(
            'business_number' => $business_number
          );
          $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
        }
        echo $business_number;
      }
    }
    public function update_o_address1() {
      // echo '<pre>';print_r($_POST);die;
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      if(!empty($this->input->post('address1'))) {
        if (!empty($sub_merchant_id)) {
          $address1 = $this->input->post('address1');
                  $package_info = array(
            'address1' => $address1
          );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
        } else {
                  $address1 = $this->input->post('address1');
          $package_info = array(
            'address1' => $address1
          );
          $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
        }
        echo $address1;
      }
    }
    public function update_signature_late_fee_status() {
      // echo '<pre>';print_r($_POST);die;
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      if (!empty($sub_merchant_id)) {
        $signature_status = $this->input->post('signature_status');
        $late_fee_status = $this->input->post('late_fee_status');
                $package_info = array(
          'signature_status' => $signature_status,
          'late_fee_status' => $late_fee_status
        );
          $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
      } else {
                $signature_status = $this->input->post('signature_status');
        $late_fee_status = $this->input->post('late_fee_status');
                $package_info = array(
          'signature_status' => $signature_status,
          'late_fee_status' => $late_fee_status
        );
        $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
      }
      echo $signature_status;
    }
    public function update_late_grace_fee() {
      // echo '<pre>';print_r($_POST);die;
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      if (!empty($sub_merchant_id)) {
        $late_fee = $this->input->post('late_fee') ? $this->input->post('late_fee') : "";
        $late_grace_period = $this->input->post('late_grace_period') ? $this->input->post('late_grace_period') : "";
                $package_info = array(
          'late_fee' => number_format($late_fee, 2),
          'late_grace_period' => $late_grace_period
        );
          $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
      } else {
                $late_fee = $this->input->post('late_fee') ? $this->input->post('late_fee') : "";
        $late_grace_period = $this->input->post('late_grace_period') ? $this->input->post('late_grace_period') : "";
                $package_info = array(
          'late_fee' => number_format($late_fee, 2),
          'late_grace_period' => $late_grace_period
        );
        $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
      }
      // echo $signature_status;
    }
    public function remove_profile_picture() {
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      // echo 'hello';print_r($_FILES);die;
      $mypic = '';
      $package_info = array('logo' => $mypic);
      $this->session->set_userdata('merchant_logo',$mypic);
      
      if (!empty($sub_merchant_id)) {
                $this->admin_model->update_data('merchant', $package_info, array('id'=>$sub_merchant_id));
      } else {
        $this->admin_model->update_data('merchant', $package_info, array('id' =>$package[0]->id));
      }
      echo $mypic;
    }
    public function update_invoice_type() {
      $merchant_id = $this->session->userdata('merchant_id');
      $invoice_type = $this->input->post('invoice_type');
      
      $package_info = array('invoice_type' => $invoice_type);
      $this->session->set_userdata('invoice_type', $invoice_type);
      
      $this->admin_model->update_data('merchant', $package_info, array('id' =>$merchant_id));
    }
    public function update_multiple_email() {
      // echo '<pre>';print_r($_POST);die;
      $sub_merchant_id = $this->session->userdata('subuser_id');
      $merchant_id = $this->session->userdata('merchant_id');
      $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
      if (!empty($sub_merchant_id)) {
        $notification_email = $this->input->post('notification_email') ? $this->input->post('notification_email') : "";
                $package_info = array(
          'notification_email' => $notification_email
        );
          $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));
      } else {
                $notification_email = $this->input->post('notification_email') ? $this->input->post('notification_email') : "";
                $package_info = array(
          'notification_email' => $notification_email
        );
        $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
      }
      // echo $signature_status;
    }

    public function update_late_fee_mail_status() {
        // echo '<pre>';print_r($_POST);die;
        $sub_merchant_id = $this->session->userdata('subuser_id');
        $merchant_id = $this->session->userdata('merchant_id');
        $package = $this->profile_model->get_merchant_details($this->session->userdata('merchant_id'));
        if (!empty($sub_merchant_id)) {
            $late_fee_mail_status = $this->input->post('late_fee_mail_status');
            $package_info = array(
                'late_fee_mail_status' => $late_fee_mail_status
            );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $sub_merchant_id));

        } else {
            $late_fee_mail_status = $this->input->post('late_fee_mail_status');
            $package_info = array(
                'late_fee_mail_status' => $late_fee_mail_status
            );
            $this->admin_model->update_data('merchant', $package_info, array('id' => $package[0]->id));
        }
        echo $late_fee_mail_status;
    }

    public function tip_setting_original() {
        $merchant_id = $this->session->userdata('merchant_id');
        
        if ($_POST) {
            // echo '<pre>';print_r($_POST);die;
            $tip = $this->input->post('tip') ? 1 : 0;
            $tip_val_1 = $this->input->post('tip_val_1') ? $this->input->post('tip_val_1') : "";
            $tip_val_2 = $this->input->post('tip_val_2') ? $this->input->post('tip_val_2') : "";
            $tip_val_3 = $this->input->post('tip_val_3') ? $this->input->post('tip_val_3') : "";
            $tip_val_4 = $this->input->post('tip_val_4') ? $this->input->post('tip_val_4') : "";

            $updata = array(
                'tip' => $tip,
                'tip_val_1' => $tip_val_1,
                'tip_val_2' => $tip_val_2,
                'tip_val_3' => $tip_val_3,
                'tip_val_4' => $tip_val_4,
            );
            $this->db->where('id', $merchant_id);
            $this->db->update('merchant', $updata);
            $this->session->set_flashdata('success', 'Tip settings updated successfully.');
            redirect(base_url('merchant/tip_setting'));

        } else {
            $package = $this->db->select('tip,tip_val_1,tip_val_2,tip_val_3,tip_val_4')->where('id', $merchant_id)->get('merchant')->row();
            $data['tip'] = $package->tip;
            $data['tip_val_1'] = $package->tip_val_1;
            $data['tip_val_2'] = $package->tip_val_2;
            $data['tip_val_3'] = $package->tip_val_3;
            $data['tip_val_4'] = $package->tip_val_4;
        }
        // echo '<pre>';print_r($data);die;
        $data['meta'] = 'Tip Settings';
        $this->load->view('merchant/tip_setting', $data);
    }

    public function tip_setting() {
        $merchant_id = $this->session->userdata('merchant_id');
        
        if ($_POST) {
            // echo '<pre>';print_r($_POST);die;
            $tip = $this->input->post('tip') ? 1 : 0;
            $tip_type = $this->input->post('tip_type') ? $this->input->post('tip_type') : "";
            $tip_val_1 = $this->input->post('tip_val_1') ? $this->input->post('tip_val_1') : "";
            $tip_val_2 = $this->input->post('tip_val_2') ? $this->input->post('tip_val_2') : "";
            $tip_val_3 = $this->input->post('tip_val_3') ? $this->input->post('tip_val_3') : "";
            $tip_val_4 = $this->input->post('tip_val_4') ? $this->input->post('tip_val_4') : "";

            $updata = array(
                'tip' => $tip,
                'tip_type' => $tip_type,
                'tip_val_1' => $tip_val_1,
                'tip_val_2' => $tip_val_2,
                'tip_val_3' => $tip_val_3,
                'tip_val_4' => $tip_val_4,
            );
            $this->db->where('id', $merchant_id);
            $this->db->update('merchant', $updata);
            $this->session->set_flashdata('success', 'Tip settings updated successfully.');
            redirect(base_url('merchant/tip_setting'));

        } else {
            $package = $this->db->select('tip,tip_type,tip_val_1,tip_val_2,tip_val_3,tip_val_4')->where('id', $merchant_id)->get('merchant')->row();
            $data['tip'] = $package->tip;
            $data['tip_type'] = $package->tip_type;
            $data['tip_val_1'] = $package->tip_val_1;
            $data['tip_val_2'] = $package->tip_val_2;
            $data['tip_val_3'] = $package->tip_val_3;
            $data['tip_val_4'] = $package->tip_val_4;
        }
        // echo '<pre>';print_r($data);die;
        $data['meta'] = 'Tip Settings';
        $this->load->view('merchant/tip_setting', $data);
    }
}
?>
