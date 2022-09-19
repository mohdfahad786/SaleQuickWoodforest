<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pos_employee extends CI_Controller
{ 
     public function __construct() 
     {
          parent::__construct();
        
          $this->load->model('admin_model');
          $this->load->model('Home_model');
           $this->load->library('email');
          $this->load->model('customers_model','customers');
          date_default_timezone_set("America/Chicago");
     }
public function all_customer_request()
 {
    $data = array();
    $merchant_id = $this->session->userdata('p_merchant_id');
    if($this->input->post('mysubmit'))
  {
   $employee = '';
  $status = $_POST['status'];
  $date1 = $_POST['start_date'];
  $date2 = $_POST['end_date'];
  $package_data = $this->admin_model->get_full_details_admin_report_search('customer_payment_request',$date1,$date2,$employee,$status);
  }else{
    $package_data = $this->admin_model->get_full_details_admin_a('customer_payment_request',$merchant_id);
    }
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
      $package['id'] = $each->id;
      $package['name'] = $each->name;
      $package['merchant_id'] = $each->merchant_id;  
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
      $mem[] = $package;
    }
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
 $this->load->view('employee/all_customer_request', $data);
 }
 public function add_charge_back()
  {
    //   $data['meta'] = "Add New Charge Back";
    // $data['loc'] = "add_charge_back";
    // $data['action'] = "Add New Charge Back";
      
   $bct_id = $this->uri->segment(3);
    
    if(!$bct_id && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->data_get_where('customer_payment_request', array('id' => $bct_id));
    if($this->input->post('submit'))
    {
       $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
         $email = $this->input->post('email') ? $this->input->post('email') : "";
             $name = $this->input->post('name') ? $this->input->post('name') : "";
            $mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
            $invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
              $payment_id = $this->input->post('payment_id') ? $this->input->post('payment_id') : "";
               $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
      $reason = $this->input->post('reason') ? $this->input->post('reason') : "";
    $merchant_id = $this->session->userdata('merchant_id');
   $date_c = date("Y-m-d");
                              
      $branch_info = array(
                'name' => $name,
                        'email' => $email,
                        'mobile_no' => $mobile,
                         'amount' => $amount,
                        'payment_id' => $payment_id,
                         'invoice_no' => $invoice,
                         'reason' => $reason,
                        'merchant_id' => $merchant_id,
                         'date_c' => $date_c,
                        'type' => 'straight',
                        'status' => 'confirm'
                
                          );
        $branch_inf = array(
             
                        'status' => 'Chargeback_Confirm'
                
                          );
      
    $id1 = $this->admin_model->insert_data("refund", $branch_info);
    $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));
     $this->admin_model->update_data('graph',$branch_inf , array('id' => $id));
          $this->session->set_userdata("mymsg",  "Successfully Refund.");
        redirect(base_url().'pos/all_charge_back');
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['invoice'] = $sub->invoice_no;
        $data['payment_id'] = $sub->payment_id;
         $data['amount'] = $sub->amount;
          $data['name'] = $sub->name;
           $data['email'] = $sub->email_id;
          $data['mob_no'] = $sub->mobile_no;
           
         
        
        break;
      } 
    } 
    $data['meta'] = "Add Charge Back";
    $data['action'] = "Add Charge Back";
    $data['loc'] = "add_charge_back";
    if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/add_charge_back', $data);
    }
else
{
    $this->load->view('merchant/add_charge_back', $data);
}
    
  }
  public function add_charge_back_recuuring()
  {
    //   $data['meta'] = "Add New Charge Back";
    // $data['loc'] = "add_charge_back";
    // $data['action'] = "Add New Charge Back";
      $merchant_id = $this->session->userdata('merchant_id');  
   $bct_id = $this->uri->segment(3);
    
    if(!$bct_id && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->get_recurring_details_payment_rr($merchant_id, $bct_id);
    if($this->input->post('submit'))
    {
       $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
         $email = $this->input->post('email') ? $this->input->post('email') : "";
             $name = $this->input->post('name') ? $this->input->post('name') : "";
            $mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
            $invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
              $payment_id = $this->input->post('payment_id') ? $this->input->post('payment_id') : "";
      $reason = $this->input->post('reason') ? $this->input->post('reason') : "";
   $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
  $date_c = date("Y-m-d");
                              
      $branch_info = array(
                'name' => $name,
                        'email' => $email,
                        'mobile_no' => $mobile,
                        'payment_id' => $payment_id,
                         'amount' => $amount,
                         'invoice_no' => $invoice,
                         'reason' => $reason,
                        'merchant_id' => $merchant_id,
                         'date_c' => $date_c,
                        'type' => 'recurring',
                        'status' => 'confirm'
                
                          );
      
   $branch_inf = array(
             
                        'status' => 'Chargeback_Confirm'
                
                          );
      
    $id1 = $this->admin_model->insert_data("refund", $branch_info);
    $this->admin_model->update_data('recurring_payment',$branch_inf , array('id' => $id));
   $this->admin_model->update_data('graph',$branch_inf , array('id' => $id));
          $this->session->set_userdata("mymsg",  "successfully charge Back Has Been Added.");
        redirect(base_url().'pos/all_charge_back');
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->rid;
        $data['invoice'] = $sub->invoice_no;
        $data['payment_id'] = $sub->payment_id;
         $data['amount'] = $sub->amount;
          $data['name'] = $sub->name;
           $data['email'] = $sub->email_id;
          $data['mob_no'] = $sub->mobile_no;
           
         
        
        break;
      } 
    } 
    $data['meta'] = "Add Charge Back";
    $data['action'] = "Add Charge Back";
    $data['loc'] = "add_charge_back_recuuring";
    if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/add_charge_back', $data);
    }
else
{
    $this->load->view('merchant/add_charge_back', $data);
}
    
  }
  
  
    public function add_charge_back_pos()
  {
    //   $data['meta'] = "Add New Charge Back";
    // $data['loc'] = "add_charge_back";
    // $data['action'] = "Add New Charge Back";
      $merchant_id = $this->session->userdata('merchant_id');  
   $bct_id = $this->uri->segment(3);
    
    if(!$bct_id && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
   // $branch = $this->admin_model->get_recurring_details_payment_rr($merchant_id, $bct_id);
 $branch = $this->admin_model->data_get_where('pos', array('id' => $bct_id));
    if($this->input->post('submit'))
    {
       $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
         $email = $this->input->post('email') ? $this->input->post('email') : "";
             $name = $this->input->post('name') ? $this->input->post('name') : "";
            $mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
            $invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
              $payment_id = $this->input->post('payment_id') ? $this->input->post('payment_id') : "";
      $reason = $this->input->post('reason') ? $this->input->post('reason') : "";
   $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
  $date_c = date("Y-m-d");
                              
      $branch_info = array(
                'name' => $name,
                        'email' => $email,
                        'mobile_no' => $mobile,
                        'payment_id' => $payment_id,
                         'amount' => $amount,
                         'invoice_no' => $invoice,
                         'reason' => $reason,
                        'merchant_id' => $merchant_id,
                         'date_c' => $date_c,
                        'type' => 'pos',
                        'status' => 'confirm'
                
                          );
      
   $branch_inf = array(
             
                        'status' => 'Chargeback_Confirm'
                
                          );
      
    $id1 = $this->admin_model->insert_data("refund", $branch_info);
    $this->admin_model->update_data('pos',$branch_inf , array('id' => $id));
$this->admin_model->update_data('graph',$branch_inf , array('id' => $id));
          $this->session->set_userdata("mymsg",  "successfully charge Back Has Been Added.");
        redirect(base_url().'pos/all_charge_back');
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['invoice'] = $sub->invoice_no;
       
         $data['amount'] = $sub->amount;
          $data['name'] = $sub->name;
           $data['email'] = $sub->email_id;
          $data['mob_no'] = $sub->mobile_no;
           
         
        
        break;
      } 
    } 
    $data['meta'] = "Add Charge Back";
    $data['action'] = "Add Charge Back";
    $data['loc'] = "add_charge_back_pos";
    if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/add_charge_back', $data);
    }
else
{
    $this->load->view('merchant/add_charge_back', $data);
}
    
  }
  public function add_charge_back_r()
  {
    //   $data['meta'] = "Add New Charge Back";
    // $data['loc'] = "add_charge_back";
    // $data['action'] = "Add New Charge Back";
      $merchant_id = $this->session->userdata('merchant_id');
      
    $bct_id = $this->uri->segment(3);
    
    if(!$bct_id && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->get_recurring_details_payment_rr($merchant_id,$bct_id);
    if($this->input->post('submit'))
    {
       $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
         $email = $this->input->post('email') ? $this->input->post('email') : "";
             $name = $this->input->post('name') ? $this->input->post('name') : "";
            $mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
            $invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
      $reason = $this->input->post('reason') ? $this->input->post('reason') : "";
   
 
                              
      $branch_info = array(
                'name' => $name,
                        'email' => $email,
                        'mobile_no' => $mobile,
                        'payment_id' => $payment_id,
                         'invoice_no' => $invoice,
                         'reason' => $reason,
                       
                
                          );
      
    $id = $this->admin_model->insert_data("refund", $branch_info);
          $this->session->set_userdata("mymsg",  "successfully charge Back Has Been Added.");
        redirect(base_url().'pos/all_charge_back');
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->rid;
       $data['invoice'] = $sub->invoice_no;
        $data['payment_id'] = $sub->payment_id;
        
          $data['name'] = $sub->name;
           $data['email'] = $sub->email_id;
         $data['mob_no'] = $sub->mobile_no;
           
         
        
        break;
      } 
    } 
    $data['meta'] = "Add Charge Back";
    $data['action'] = "Add Charge Back";
    $data['loc'] = "add_charge_back";
  
     if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/add_charge_back', $data);
    }
else
{
    $this->load->view('merchant/add_charge_back', $data);
}
    
  }
  
     public function add_charge_back1()
  {
     $data['meta'] = "Add New Charge Back";
    $data['loc'] = "add_charge_back";
    $data['action'] = "Add New Charge Back";
     
      if (isset($_POST['submit'])) {
           $this->form_validation->set_rules('email', 'Email Address', 'required');
            $email = $this->input->post('email') ? $this->input->post('email') : "";
             $name = $this->input->post('name') ? $this->input->post('name') : "";
            $mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
            $invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
      $reason = $this->input->post('reason') ? $this->input->post('reason') : "";
   
           
            if ($this->form_validation->run() == FALSE) {
                $this->load->view("merchant/add_charge_back" , $data);
            } else {
              $merchant_id = $this->session->userdata('merchant_id');
      $today1 = date("Ymdhms");
      $today2 = date("Y-m-d");
      
                $data = Array(
                   
                        'name' => $name,
                        'email' => $email,
                        'mobile_no' => $mobile,
                        
                        'invoice_no' => $invoice,
                        'payment_id' => $invoice,
                         'reason' => $reason,
                      //  'user_type' => 'employee',
                        'merchant_id' => $merchant_id,
                        
                        'status' => 'pending'
                        // 'date_c' => $today2
          );
                   
                $id = $this->admin_model->insert_data("refund", $data);
        
        redirect(base_url().'pos/all_charge_back');
              
            }
        } 
     else {
            $this->load->view("merchant/add_charge_back" , $data);
        }
     
    
  
  }
  public function edit_charge_back()
  {
      
    $bct_id = $this->uri->segment(3);
    
    if(!$bct_id && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->data_get_where('refund', array('id' => $bct_id));
    if($this->input->post('submit'))
    {
       $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
         $email = $this->input->post('email') ? $this->input->post('email') : "";
             $name = $this->input->post('name') ? $this->input->post('name') : "";
            $mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
            $invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
      $reason = $this->input->post('reason') ? $this->input->post('reason') : "";
   
 
                              
      $branch_info = array(
                'name' => $name,
                        'email' => $email,
                        'mobile_no' => $mobile,
                        'payment_id' => $invoice,
                         'reason' => $reason,
                       
                
                          );
      
     $this->admin_model->update_data('refund',$branch_info, array('id' => $bct_id));
          $this->session->set_userdata("mymsg",  "Data Has Been Updated.");
        redirect('pos/all_charge_back');
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['invoice'] = $sub->invoice_no;
        $data['payment_id'] = $sub->payment_id;
        
          $data['name'] = $sub->name;
           $data['email'] = $sub->email;
          $data['mob_no'] = $sub->mobile_no;
           $data['reason'] = $sub->reason;
         
        
        break;
      } 
    } 
    $data['meta'] = "Update Charge Back";
    $data['action'] = "Update Charge Back";
    $data['loc'] = "edit_charge_back";
  
    
     if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/add_charge_back', $data);
    }
else
{
    $this->load->view('merchant/add_charge_back', $data);
}
  }
  public function edit_charge_back_admin()
  {
      
    $bct_id = $this->uri->segment(3);
    
    if(!$bct_id && !$this->input->post('submit'))
    {
      echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
      die;
    }
    $branch = $this->admin_model->data_get_where('refund', array('id' => $bct_id));
    if($this->input->post('submit'))
    {
       $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
         $email = $this->input->post('email') ? $this->input->post('email') : "";
             $name = $this->input->post('name') ? $this->input->post('name') : "";
            $mobile = $this->input->post('mob_no') ? $this->input->post('mob_no') : "";
            $invoice = $this->input->post('invoice') ? $this->input->post('invoice') : "";
      $reason = $this->input->post('reason') ? $this->input->post('reason') : "";
       $detail = $this->input->post('detail') ? $this->input->post('detail') : "";
        $status = $this->input->post('status') ? $this->input->post('status') : "";
   
 
                              
     $branch_info = array(
              
                        'detail' => $detail,
                         'status' => $status                       
                
                          );
      
     $this->admin_model->update_data('refund',$branch_info, array('id' => $id));
          $this->session->set_userdata("mymsg",  "Data Has Been Updated.");
        redirect('pos/all_charge_back');
    }
    else
    {
      foreach($branch as $sub)
      {
        $data['bct_id'] = $sub->id;
        $data['invoice'] = $sub->invoice_no;
        $data['payment_id'] = $sub->payment_id;
        
          $data['name'] = $sub->name;
           $data['email'] = $sub->email;
          $data['mob_no'] = $sub->mobile_no;
           $data['reason'] = $sub->reason;
           $data['status'] = $sub->status;
           $data['detail'] = $sub->detail;
         
        
        break;
      } 
    } 
    $data['meta'] = "Update Charge Back status";
    $data['action'] = "Update Charge Back";
    $data['loc'] = "edit_charge_back_admin";
  
  
    $this->load->view('admin/add_charge_back', $data);
  }
  
  public function all_charge_back1()
 {
       
    $data = array();
  
    $merchant_id = $this->session->userdata('merchant_id');
    
    //$package_data = $this->admin_model->get_data('tax',$merchant_id);
    if($this->session->userdata('user_type')=='admin')
    {
$package_data = $this->admin_model->data_get_where_2('refund');
    }
    else
    {
    $package_data = $this->admin_model->data_get_where_1('refund', array('merchant_id' => $merchant_id));
  }
    
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
       
      
      $mem[] = $each;
    }
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
    
 
  if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/all_charge_back', $data);
    }
  
else
{
    $this->load->view('merchant/all_charge_back', $data);
}
 }
public function all_charge_back()
 {
       
    $data = array();
       $mem = array();
    $member = array();
     $merchant_id = $this->session->userdata('merchant_id');
    if($this->input->post('mysubmit'))
  {
  
    $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $status = $_POST['status'];
if($status == 'straight') {
  $package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'confirm',$merchant_id,'refund');
   $data['meta'] = "View All Straight Refund Payment ";
  
}
else if($status == 'recurring')
{
$package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'confirm',$merchant_id,'refund');
 $data['meta'] = "View All Recurring Refund Payment ";
}
else if($status == 'pos')
{
$package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'confirm',$merchant_id,'refund');
  $data['meta'] = "View All Pos Refund Payment ";
 
}
  }
  
  else{
     $data['meta'] = "View All  Refund Payment ";
  
    $package_data = $this->admin_model->get_full_details_payment_rr('refund',$merchant_id);
   
    }
      foreach($package_data as $each)
    {
       
      $package['id'] = $each->id;
      $package['payment_id'] = $each->invoice_no;
      $package['name'] = $each->name;
      $package['email'] = $each->email; 
      $package['mobile_no'] = $each->mobile_no;
      $package['amount'] = $each->amount;
      $package['reason'] = $each->reason; 
      // $package['date'] = $each->add_date; 
      // $package['due_date'] = $each->due_date; 
      // $package['payment_date'] = $each->payment_date; 
     $package['status'] = $each->status;
      $package['type'] = $each->type;
   //   $package['payment_type'] = $each->payment_type;
       //     $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
 
   
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
       
     
   
  if($this->session->userdata('merchant_user_type')=='employee')
    {
   $this->load->view('employee/all_charge_back', $data);
    }
else
{
   
  $this->load->view('merchant/all_charge_back', $data);
}
 }
  
public function charge_back_delete($id)
  {
    $this->admin_model->delete_by_id($id,'refund');
    echo json_encode(array("status" => TRUE));
  }
  
 public function add_pos()
     {
         
$merchant_id = $this->session->userdata('p_merchant_id');
       $data['meta'] = "Point Of Sale";
    $data['loc'] = "add_pos";
    $data['action'] = "Charge";
    $getDashboard = $this->db->query("SELECT ( SELECT sum(percentage) as TotalTax from tax where status='active' and merchant_id = '".$merchant_id."' ) as TotalTax
             "); 
            $getDashboardData = $getDashboard->result_array();
            $data['getDashboardData'] = $getDashboardData; 
   
     
      if (isset($_POST['submit'])) {
           $this->form_validation->set_rules('amount', 'Amount', 'required');
            $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
              $tax = $this->input->post('totaltax') ? $this->input->post('totaltax') : "";
           
           
            if ($this->form_validation->run() == FALSE) {
 if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/pos', $data);
    }
else
{
    $this->load->view('merchant/pos', $data);
}
            } else {
              
      $today1 = date("Ymdhms");
      $today2 = date("Y-m-d");
      
                $data = Array(
                   
                        'amount' => $amount,
                        'tax' => $tax,
                        
          );
        
   $this->load->view("employee/card1" , $data);
              
            }
        } 
     else {
           
         if($this->session->userdata('merchant_user_type')=='employee')
    {
$this->load->view('employee/pos', $data);
    }
else
{
    $this->load->view('employee/pos', $data);
}
        }
     
    
     }
     
       public function refund()
     {
       
         // print_r(($_POST)); die();
        
         $merchant_id = $this->session->userdata('p_merchant_id');
     //Data, connection, auth
       # $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL
       
               $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'  ");
                $getEmail_a = $getQuery_a->result_array();
                $data['$getEmail_a'] = $getEmail_a;
                
                //print_r($getEmail_a);
                
                $account_id = $getEmail_a[0]['account_id_cnp'];
                $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
                $account_token = $getEmail_a[0]['account_token_cnp'];
                $application_id = $getEmail_a[0]['application_id_cnp'];
                  $terminal_id = $getEmail_a[0]['terminal_id'];
                  
                   $id  = $_POST['id'] ;
                   $invoice_no  = $_POST['invoice_no'] ;
                  $amount  = $_POST['amount'] ;
                 $transaction_id  = $_POST['transaction_id'] ;
                  
                   // xml post structure
        $xml_post_string = "<CreditCardReturn xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID>
        <AccountToken>".$account_token."</AccountToken><AcceptorID>".$acceptor_id."</AcceptorID>
        </Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationName>SaleQuick</ApplicationName><ApplicationVersion>1.1</ApplicationVersion></Application>
        <Terminal><TerminalID>0001</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode><CardInputCode>4</CardInputCode>
        <TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode></Terminal><Transaction>
        <TransactionID>".$transaction_id."</TransactionID><TransactionAmount>".$amount."</TransactionAmount><ReferenceNumber>6365015481134138</ReferenceNumber><TicketNumber>328299</TicketNumber>
        </Transaction></CreditCardReturn>";   // data from the form, e.g. some ID number

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
$arraya = json_decode($json,TRUE);
		//	print_r($arraya);
            curl_close($ch);
         $trans_a_no = $arraya['Response']['Transaction']['TransactionID']; 
            $card_type = $arraya['Response']['Card']['CardLogo'];
             $card_no = $arraya['Response']['Card']['CardNumberMasked'];
          //  die();
             $date_c = date("Y-m-d");
             $merchant_id = $this->session->userdata('merchant_id'); 
             
              $branch_info = array(
               // 'name' => $name,
                        //'email' => $email,
                       // 'mobile_no' => $mobile,
                         'amount' => $amount,
                         'transaction_id' => $trans_a_no,
                         'card_type' => $card_type,
                         'card_no' => $card_no,
                       // 'payment_id' => $payment_id,
                       'invoice_no' => $invoice_no,
                       //  'reason' => $reason,
                        'merchant_id' => $merchant_id,
                         'date_c' => $date_c,
                        'type' => 'straight',
                        'status' => 'confirm',
                        'c_type' => 'CNP'
                
                          );
        $branch_inf = array(
             
                        'status' => 'Chargeback_Confirm'
                
                          );
      
    
    
     if(empty($trans_a_no)){
        $id='Refund Fail';
                  redirect('payment_error/'.$id);
    }
     else
     {
         $id1 = $this->admin_model->insert_data("refund", $branch_info);
    $this->admin_model->update_data('customer_payment_request',$branch_inf , array('id' => $id));
                  
     redirect(base_url().'pos/all_customer_request');
     }
     
     
       
     }
     
     
     public function refund_pos()
     {
       
         // print_r(($_POST)); die();
        
         $merchant_id = $this->session->userdata('p_merchant_id');
     //Data, connection, auth
       # $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL
       
               $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'  ");
                $getEmail_a = $getQuery_a->result_array();
                $data['$getEmail_a'] = $getEmail_a;
                
                //print_r($getEmail_a);
                
                $account_id = $getEmail_a[0]['account_id_cnp'];
                $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
                $account_token = $getEmail_a[0]['account_token_cnp'];
                $application_id = $getEmail_a[0]['application_id_cnp'];
                  $terminal_id = $getEmail_a[0]['terminal_id'];
                  
                   $id  = $_POST['id'] ;
                   $invoice_no  = $_POST['invoice_no'] ;
                  $amount  = $_POST['amount'] ;
                 $transaction_id  = $_POST['transaction_id'] ;
                  
                   // xml post structure
        $xml_post_string = "<CreditCardReturn xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID>
        <AccountToken>".$account_token."</AccountToken><AcceptorID>".$acceptor_id."</AcceptorID>
        </Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationName>SaleQuick</ApplicationName><ApplicationVersion>1.1</ApplicationVersion></Application>
        <Terminal><TerminalID>0001</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode><CardInputCode>4</CardInputCode>
        <TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode></Terminal><Transaction>
        <TransactionID>".$transaction_id."</TransactionID><TransactionAmount>".$amount."</TransactionAmount><ReferenceNumber>6365015481134138</ReferenceNumber><TicketNumber>328299</TicketNumber>
        </Transaction></CreditCardReturn>";   // data from the form, e.g. some ID number

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
$arraya = json_decode($json,TRUE);
	//	print_r($arraya);
            curl_close($ch);
         $trans_a_no = $arraya['Response']['Transaction']['TransactionID']; 
        //    $card_type = $arraya['Response']['Card']['CardLogo'];
         //   $card_no = $arraya['Response']['Card']['CardNumberMasked'];
          //  die();
             $date_c = date("Y-m-d");
             $merchant_id = $this->session->userdata('merchant_id'); 
             
              $branch_info = array(
               // 'name' => $name,
                        //'email' => $email,
                       // 'mobile_no' => $mobile,
                         'amount' => $amount,
                         'transaction_id' => $trans_a_no,
                    //     'card_type' => $card_type,
                     //    'card_no' => $card_no,
                       // 'payment_id' => $payment_id,
                       'invoice_no' => $invoice_no,
                       //  'reason' => $reason,
                        'merchant_id' => $merchant_id,
                         'date_c' => $date_c,
                        'type' => 'pos',
                        'status' => 'confirm',
                        'c_type' => 'CNP'
                
                          );
        $branch_inf = array(
             
                        'status' => 'Chargeback_Confirm'
                
                          );
  if(empty($trans_a_no)){    
    
    
    
        $id='Refund Fail';
                  redirect('payment_error/'.$id);
    }
     else
     {
         $id1 = $this->admin_model->insert_data("refund", $branch_info);
    $this->admin_model->update_data('pos',$branch_inf , array('id' => $id));
                  
     redirect(base_url().'pos/all_pos');
     }
       
     }
     
     public function card_payment()
     {
        $data['meta'] = "Add New Pos";
        $data['loc'] = "add_pos";
        $data['action'] = "Charge";
   
        // print_r(($_POST)); die();
        
         $merchant_id = $this->session->userdata('p_merchant_id');
     //Data, connection, auth
       # $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL
       
               $getQuery_a = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'  ");
                $getEmail_a = $getQuery_a->result_array();
                $data['$getEmail_a'] = $getEmail_a;
                
                //print_r($getEmail_a);
                
                $account_id = $getEmail_a[0]['account_id_cnp'];
                $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
                $account_token = $getEmail_a[0]['account_token_cnp'];
                $application_id = $getEmail_a[0]['application_id_cnp'];
                  $terminal_id = $getEmail_a[0]['terminal_id'];
              $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
               $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
                $cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
            $name = $this->input->post('name') ? $this->input->post('name') : "";
           
            $expiry_month = $this->input->post('expiry_month') ? $this->input->post('expiry_month') : "";
            $expiry_year = $this->input->post('expiry_year') ? $this->input->post('expiry_year') : "";
              $payment_id = "POS_".date("Ymdhms");  
        // xml post structure

        $xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken><AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>";   // data from the form, e.g. some ID number

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
			//print_r($array);
            curl_close($ch);
            
         //   die();
   
   
    if ($array['Response']['ExpressResponseMessage']='ONLINE') {
            
        $xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>".$account_id."</AccountID><AccountToken>".$account_token."</AccountToken>
        <AcceptorID>".$acceptor_id."</AcceptorID></Credentials><Application><ApplicationID>".$application_id."</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
        <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>".$amount."</TransactionAmount><ReferenceNumber>".$payment_id."</ReferenceNumber>
        <TicketNumber>125300</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>0001</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
        <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
        </Terminal><Card><CardNumber>".$card_no."</CardNumber><ExpirationMonth>".$expiry_month."</ExpirationMonth><ExpirationYear>".$expiry_year."</ExpirationYear></Card></CreditCardSale>";   // data from the form, e.g. some ID number

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
	//	print_r($arrayy);
            curl_close($ch);

              
            $card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
           $trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
          $card_type = $arrayy['Response']['Card']['CardLogo'];
          $message_a =  $arrayy['Response']['Transaction']['TransactionStatus']; 
             
//         $arrayy['Response']['Transaction']['TransactionStatus']; 
//   $arrayy['Response']['Transaction']['ApprovedAmount']; 
                 
                 
       //   }


  
   
     
      //  if (isset($_POST['message'])) {
            $this->form_validation->set_rules('amount', 'Amount', 'required');
          //  $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
            $mobile_no = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
            $email_id = $this->input->post('email_id') ? $this->input->post('email_id') : "";
            $amount = $this->input->post('amount') ? $this->input->post('amount') : "";
            $tax = $this->input->post('tax') ? $this->input->post('tax') : "";
            $cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
            $name = $this->input->post('name') ? $this->input->post('name') : "";
            $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
            $expiry_month = $this->input->post('expiry_month') ? $this->input->post('expiry_month') : "";
            $expiry_year = $this->input->post('expiry_year') ? $this->input->post('expiry_year') : "";
            $transaction_id = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : "";
            $merchant_id = $this->session->userdata('merchant_id');

          //  $tax_id = $this->input->post('TAX_ID') ? $this->input->post('TAX_ID') : "";
          //  $tax_per = $this->input->post('TAX_PER') ? $this->input->post('TAX_PER') : "";

              $tax_id = json_encode($this->input->post('TAX_ID'));
            $tax_per =  json_encode($this->input->post('TAX_PER'));

            //   echo $this->input->post('TAX_ID') ; die();

            if ($this->form_validation->run() == FALSE) {

                if($this->session->userdata('merchant_user_type')=='employee')
                {
                    $this->load->view('employee/pos', $data);
                }
                else
                {
                    $this->load->view('employee/pos', $data);
                }
            } else {
                $merchant_id = $this->session->userdata('merchant_id');
                $merchantdetails = $this->admin_model->s_fee("merchant",$merchant_id);  
                $s_fee = $merchantdetails['0']['s_fee'];      
                $t_fee = $this->session->userdata('t_fee');

                $fee_invoice = $merchantdetails['0']['point_sale'];
                // $fee_swap =$merchantdetails['0']['f_swap_Recurring'];
                $fee_swap =$merchantdetails['0']['text_email'];
                $fee_email =$merchantdetails['0']['f_swap_Text'];

                $fee1 = ($amount/100)*$fee_invoice;
                $fee_swap=($fee_swap!='')?$fee_swap:0;
                $fee_email=($fee_email!='')?$fee_email:0;
                $fee=$fee1+$fee_swap+$fee_email;
                $today1 = date("Ymdhms");
                //$payment_id = "POS_".date("Ymdhms");
                $today2 = date("Y-m-d");
                $year = date("Y");
                $month = date("m");
                $time11 = date("H");

            if($time11=='00')
            {
                $time1 = '01';
            }
            else
            {
            $time1 = date("H");
            }
                $day1 = date("N");

                $data = Array( 
                    'amount' => $amount,
                    'tax' => $tax,
                    'tax_id' => $tax_id,
                    'tax_per' => $tax_per,
                    'fee' => $fee,
                    'merchant_id' => $merchant_id,
                    'invoice_no' => $payment_id,
                    'cvv' => $cvv,
                    'name' => $name,
                    'mobile_no' => $mobile_no,
                    'email_id' => $email_id,
                    'card_no' => $card_a_no,
                    'card_no1' => $card_no,
                    'expiry_month' => $expiry_month,
                    'expiry_year' => $expiry_year,
                    'year' => $year,
                    'month' => $month,
                    'time1' => $time1,
                    'day1' => $day1,
                    'date_c' => $today2,
                    'status' => 'confirm',
                    'transaction_id' => $trans_a_no, 
                    'c_type' => 'CP',
                    'payment_type' => 'web',
                    'card_type' => $card_type,
                    'transaction_status' => $message_a,
                    
                );
                
          // print_r($data);  die();

                $id = $this->admin_model->insert_data("pos", $data);

                $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'  ");
                $getEmail1 = $getQuery1->result_array();
                $data['getEmail1'] = $getEmail1;
               
                // $this->load->view("merchant/confirm_payment" , $data);
                $htmlContent = '<!DOCTYPE html>
                <html>
                <head>
                <title></title>
                <meta charset="utf-8">
                <title></title>
                <meta charset="utf-8" />
                <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet" />
                </head>
                <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">
                <div style="max-width: 900px;margin: 0 auto;">
                <div style="color:#fff;">
                <div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">
                <div style="width:80%;margin:0 auto;">
 <div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 10px;">
                        <img src="https://salequick.com/logo/'.$getEmail1[0]['logo'].'" style="width: 100%; height: 100%;;margin-top: 0px;     border-radius: 50%;" />
                      </div>                <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center;font-weight:600">$'.$amount.'<br />
                <span style="font-size:24px;color: #076547;">Payment Complete</span></h3>
                </div>
                </div>
                <div style="background-color: #437ba8;overflow: hidden;">
                <div style="width:80%;text-align:right;margin:20px auto;">
                <div style="display:block;margin-bottom:10px;overflow: hidden;margin-top:0px;">
                <div style="width:33.3%;float:left;text-align:center"><span>Invoice No</span></div>
                <div style="width:33.3%;float:left;text-align:center"><span>Date </span></div>
                <div style="width:33.3%;float:left;text-align:center"><span>Amount</span></div>
                <!--<span style="float:left">Start Date </span>
                <span style="float:right">January 8,2020</span>--></div>
                <div style="clear:both">&nbsp;</div>
                <hr style="margin-top: 5px; margin-bottom: 10px; border: 0; border-top: 1px solid #eee;" />
                <div style="display:block;margin-bottom:25px;overflow: hidden;">
                <div style="width:33.3%;float:left;text-align:center"><span>'.$payment_id.'</span></div>
                <div style="width:33.3%;float:left;text-align:center"><span>'.$today2.'</span></div>
                <div style="width:33.3%;float:left;text-align:center"><span>$'.$amount.' </span></div>
                </div>
                </div>
                </div>
                </div>
                <div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
                <footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
                <div style="text-align:center;width:80%;margin:0 auto">
                <h3 style="margin-top: 10px; margin-bottom: 10px;font-size:22px;font-weight:400;">APPROVED</h3>

                <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</h5>

                <h4 style="margin-top: 10px; margin-bottom: 10px;font-size:20px;font-weight:400;">Customer Copy</h4>

                <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">IMPORTANT - Please retain this copy for your records .</h5>
                <p><a style="color:#4a91f9;cursor:pointer;">'.$this->session->userdata('m_email').'</a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;">'.$this->session->userdata('m_business_number').'</a></p>
                &nbsp;
                <p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>
                <p style="color: #868484;">You are receiving something because purchased something at Company name</p>
                <p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
                </div>
                </footer>
                </div>
                </body>
                </html>
                ';
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->to($email_id);
                $this->email->from('info@salequick.com','Point Of Sale Invoice');
                $this->email->subject('Invoice');
                $this->email->message($htmlContent);
                //$this->email->attach('files/attachment.pdf');
                $this->email->send();
                redirect(base_url().'pos/confirm_payment/'.$id );

                }
        } else {
            if($this->session->userdata('merchant_user_type')=='employee')
            {
                $this->load->view('employee/pos', $data);
            }
            else
            {
                $this->load->view('employee/pos', $data);
            }
        }


        }
        
public function search_record_update() {
 $id = $this->input->post('id');
 $auth_code = $this->input->post('auth_code') ? $this->input->post('auth_code') : "";
 $api_key = $this->input->post('api_key') ? $this->input->post('api_key') : "";
 $connection_id = $this->input->post('connection_id') ? $this->input->post('connection_id') : "";
 $min_shop_supply = $this->input->post('min_shop_supply') ? $this->input->post('min_shop_supply') : "";
 $max_shop_supply = $this->input->post('max_shop_supply') ? $this->input->post('max_shop_supply') : "";
 $shop_supply_percent = $this->input->post('shop_supply_percent') ? $this->input->post('shop_supply_percent') : "";
 $protractor_tax_percent = $this->input->post('protractor_tax_percent') ? $this->input->post('protractor_tax_percent') : "";
 $b_code = $this->input->post('b_code') ? $this->input->post('b_code') : "";
 $d_code = $this->input->post('d_code') ? $this->input->post('d_code') : "";
 $t_code = $this->input->post('t_code') ? $this->input->post('t_code') : "";
 $t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
 $t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
 $t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
 $t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
 $a_code_name = $this->input->post('a_code_name') ? $this->input->post('a_code_name') : "";
 $a_code_value = $this->input->post('a_code_value') ? $this->input->post('a_code_value') : "";
 $a_min_value = $this->input->post('a_min_value') ? $this->input->post('a_min_value') : "";
 $a_max_value = $this->input->post('a_max_value') ? $this->input->post('a_max_value') : "";
 $a_fixed = $this->input->post('a_fixed') ? $this->input->post('a_fixed') : "";
 $c_code_name = $this->input->post('c_code_name') ? $this->input->post('c_code_name') : "";
 $c_code_value = $this->input->post('c_code_value') ? $this->input->post('c_code_value') : "";
 $c_min_value = $this->input->post('c_min_value') ? $this->input->post('c_min_value') : "";
 $c_max_value = $this->input->post('c_max_value') ? $this->input->post('c_max_value') : "";
 $c_fixed = $this->input->post('c_fixed') ? $this->input->post('c_fixed') : "";
 $e_code_name = $this->input->post('e_code_name') ? $this->input->post('e_code_name') : "";
 $e_code_value = $this->input->post('e_code_value') ? $this->input->post('e_code_value') : "";
 $e_min_value = $this->input->post('e_min_value') ? $this->input->post('e_min_value') : "";
 $e_max_value = $this->input->post('e_max_value') ? $this->input->post('e_max_value') : "";
 $e_fixed = $this->input->post('e_fixed') ? $this->input->post('e_fixed') : "";
 $f_code_name = $this->input->post('f_code_name') ? $this->input->post('f_code_name') : "";
 $f_code_value = $this->input->post('f_code_value') ? $this->input->post('f_code_value') : "";
 $f_min_value = $this->input->post('f_min_value') ? $this->input->post('f_min_value') : "";
 $f_max_value = $this->input->post('f_max_value') ? $this->input->post('f_max_value') : "";
 $f_fixed = $this->input->post('f_fixed') ? $this->input->post('f_fixed') : "";
 $g_code_name = $this->input->post('g_code_name') ? $this->input->post('g_code_name') : "";
 $g_code_value = $this->input->post('g_code_value') ? $this->input->post('g_code_value') : "";
 $g_min_value = $this->input->post('g_min_value') ? $this->input->post('g_min_value') : "";
 $g_max_value = $this->input->post('g_max_value') ? $this->input->post('g_max_value') : "";
 $g_fixed = $this->input->post('g_fixed') ? $this->input->post('g_fixed') : "";
 $t1_code_name = $this->input->post('t1_code_name') ? $this->input->post('t1_code_name') : "";
 $t1_code_value = $this->input->post('t1_code_value') ? $this->input->post('t1_code_value') : "";
 $t1_min_value = $this->input->post('t1_min_value') ? $this->input->post('t1_min_value') : "";
 $t1_max_value = $this->input->post('t1_max_value') ? $this->input->post('t1_max_value') : "";
 $t1_fixed = $this->input->post('t1_fixed') ? $this->input->post('t1_fixed') : "";
 $t2_code_name = $this->input->post('t2_code_name') ? $this->input->post('t2_code_name') : "";
 $t2_code_value = $this->input->post('t2_code_value') ? $this->input->post('t2_code_value') : "";
 $t2_min_value = $this->input->post('t2_min_value') ? $this->input->post('t2_min_value') : "";
 $t2_max_value = $this->input->post('t2_max_value') ? $this->input->post('t2_max_value') : "";
 $t2_fixed = $this->input->post('t2_fixed') ? $this->input->post('t2_fixed') : "";
 $t3_code_name = $this->input->post('t3_code_name') ? $this->input->post('t3_code_name') : "";
 $t3_code_value = $this->input->post('t3_code_value') ? $this->input->post('t3_code_value') : "";
 $t3_min_value = $this->input->post('t3_min_value') ? $this->input->post('t3_min_value') : "";
 $t3_max_value = $this->input->post('t3_max_value') ? $this->input->post('t3_max_value') : "";
 $t3_fixed = $this->input->post('t3_fixed') ? $this->input->post('t3_fixed') : "";
 $url_cr = $this->input->post('url_cr') ? $this->input->post('url_cr') : "";
 $username_cr = $this->input->post('username_cr') ? $this->input->post('username_cr') : "";
 $password_cr = $this->input->post('password_cr') ? $this->input->post('password_cr') : "";
 $api_key_cr = $this->input->post('api_key_cr') ? $this->input->post('api_key_cr') : "";
 $account_id = $this->input->post('account_id') ? $this->input->post('account_id') : "";
 $account_token = $this->input->post('account_token') ? $this->input->post('account_token') : "";
 $application_id = $this->input->post('application_id') ? $this->input->post('application_id') : "";
 $acceptor_id = $this->input->post('acceptor_id') ? $this->input->post('acceptor_id') : "";
 $terminal_id = $this->input->post('terminal_id') ? $this->input->post('terminal_id') : "";
 
   
      $branch_info = array(
                'connection_id' => $connection_id,
                        'api_key' => $api_key,
                        'auth_code' => $auth_code,
                         'min_shop_supply' => $min_shop_supply,
                        'max_shop_supply' => $max_shop_supply,
                        'shop_supply_percent' => $shop_supply_percent,
                         'protractor_tax_percent' => $protractor_tax_percent,
                         'b_code' => $b_code,
                         'd_code' => $d_code,
                         't_code' => $t_code,
                          't1_code_name' => $t1_code_name,
                         't1_code_value' => $t1_code_value,
                         't2_code_name' => $t2_code_name,
                         't2_code_value' => $t2_code_value,
                         'a_code_name' => $a_code_name,
                         'a_code_value' => $a_code_value,
                         'a_min_value' => $a_min_value,
                         'a_max_value' => $a_max_value,
                         'a_fixed' => $a_fixed,
                         'c_code_name' => $c_code_name,
                         'c_code_value' => $c_code_value,
                         'c_min_value' => $c_min_value,
                         'c_max_value' => $c_max_value,
                         'c_fixed' => $c_fixed,
                         'e_code_name' => $e_code_name,
                         'e_code_value' => $e_code_value,
                         'e_min_value' => $e_min_value,
                         'e_max_value' => $e_max_value,
                         'e_fixed' => $e_fixed,
                         'f_code_name' => $f_code_name,
                         'f_code_value' => $f_code_value,
                         'f_min_value' => $f_min_value,
                         'f_max_value' => $f_max_value,
                         'f_fixed' => $f_fixed,
                         'g_code_name' => $g_code_name,
                         'g_code_value' => $g_code_value,
                         'g_min_value' => $g_min_value,
                         'g_max_value' => $g_max_value,
                         'g_fixed' => $g_fixed,
                         't1_code_name' => $t1_code_name,
  't1_code_value' => $t1_code_value,
  't1_min_value' => $t1_min_value,
  't1_max_value' => $t1_max_value,
  't1_fixed' => $t1_fixed,
    't2_code_name' => $t2_code_name,
  't2_code_value' => $t2_code_value,
  't2_min_value' => $t2_min_value,
  't2_max_value' => $t2_max_value,
  't2_fixed' => $t2_fixed,
    't3_code_name' => $t3_code_name,
  't3_code_value' => $t3_code_value,
  't3_min_value' => $t3_min_value,
  't3_max_value' => $t3_max_value,
  't3_fixed' => $t3_fixed,
  'url_cr' => $url_cr,
  'username_cr' => $username_cr,
  'password_cr' => $password_cr,
  'api_key_cr' => $api_key_cr,
  'account_id_cnp' => $account_id,
  'account_token_cnp' => $account_token,
  'application_id_cnp' => $application_id,
  'acceptor_id_cnp' => $acceptor_id,
  'terminal_id' => $terminal_id
  
  
                         
                
                          );
    
    $this->admin_model->update_data('merchant',$branch_info , array('id' => $id));
  }
  
public function search_record_card() {
        $var = $this->input->post('id');
        
        $data = $this->admin_model->data_get_where_serch("pos", array("card_no1" => $var));
        echo json_encode($data);
        die();
    }
    
    public function search_record_credntl() {
        $var = $this->input->post('id');
        
        $data = $this->admin_model->data_get_where_serch("merchant", array("id" => $var));
        echo json_encode($data);
        die();
    }
      public function confirm_payment(){
              $bct_id = $this->uri->segment(3);
             $merchant_id = $this->session->userdata('merchant_id');
 
          $data = array();
  
    $merchant_id = $this->session->userdata('merchant_id');
    
    //$package_data = $this->admin_model->get_data('tax',$merchant_id);
    $package_data = $this->admin_model->data_get_where_1('pos', array('id' => $bct_id,'merchant_id' => $merchant_id));
    
    $mem = array();
  
    foreach($package_data as $each)
    {
       
      
      $mem[] = $each;
    }
    $data['mem'] = $mem;
 
        if($this->session->userdata('merchant_user_type')=='employee')
    {
  return $this->load->view('employee/confirm_payment' ,$data);
    }
else
{
     return $this->load->view('merchant/confirm_payment' ,$data);
}
        
    }
public function all_pos3()
  {
   
    $this->load->view('merchant/all_pos');
  }
    public function ajax_list()
  {
    $list = $this->customers->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $customers) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $customers->name;
      $row[] = $customers->card_no;
      $row[] = $customers->amount;
      $row[] = '<span class="label label-danger"> '.$customers->status.'  </span>';
      //$row[] = '<a>edit</a>';
      // $row[] = $customers->LastName;
      // $row[] = $customers->phone;
      // $row[] = $customers->address;
      // $row[] = $customers->city;
      // $row[] = $customers->country;
      $data[] = $row;
    }
    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all(),
            "recordsFiltered" => $this->customers->count_filtered(),
            "data" => $data,
        );
    //output to json format
    echo json_encode($output);
  }
   public function all_pos()
 {
       
    $data = array();
     $merchant_id = $this->session->userdata('p_merchant_id');
    if($this->input->post('mysubmit'))
  {
  
    $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $status = $_POST['status'];
  $package_data = $this->admin_model->get_search_merchant_pos($start_date,$end_date,$status,$merchant_id,'pos');
  }
  
  else{
  
    $package_data = $this->admin_model->get_full_details_pos('pos',$merchant_id);
    }
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
       
      $package['id'] = $each->id;
      $package['payment_id'] = $each->invoice_no;
      $package['name'] = $each->name;
      $package['email'] = $each->email_id; 
      $package['mobile'] = $each->mobile_no;
      $package['amount'] = $each->amount;
    
      $package['date'] = $each->add_date; 
    
      $package['status'] = $each->status;
     
      
      $mem[] = $package;
    }
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
       
     
    
 $this->load->view('employee/all_pos', $data);
 }
public function all_customer_request_recurring()
 {
       
    $data = array();
     $merchant_id = $this->session->userdata('merchant_id');
    if($this->input->post('mysubmit'))
  {
  
  $curr_payment_date = $_POST['curr_payment_date'];
  $status = $_POST['status'];
  $package_data = $this->admin_model->get_package_details_customer_admin($curr_payment_date,$status);
  }
  
  else{
  
    $package_data = $this->admin_model->get_full_details_payment_admin('customer_payment_request');
    }
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
        
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
      $package['date_c'] = $each->date_c; 
      $package['status'] = $each->status;
      $package['payment_type'] = $each->payment_type;
      $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
       
      
    
 $this->load->view('merchant/all_customer_request_recurring', $data);
 }
public function all_confirm_payment()
 {
       
    $data = array();
       $mem = array();
    $member = array();
     $merchant_id = $this->session->userdata('merchant_id');
    if($this->input->post('mysubmit'))
  {
  
    $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $status = $_POST['status'];
if($status == 'straight') {
  $package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'confirm',$merchant_id,'customer_payment_request');
   $data['meta'] = "View All Straight Confirm Payment ";
   foreach($package_data as $each)
    {
       
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
      $package['type'] = $each->type;
   //   $package['payment_type'] = $each->payment_type;
       //     $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
}
else if($status == 'recurring')
{
$package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'confirm',$merchant_id,'recurring_payment');
 $data['meta'] = "View All Recurring Confirm Payment ";
 foreach($package_data as $each)
    {
       
      $package['id'] = $each->id;
       $package['p_id'] = $each->p_id;
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
      $package['type'] = $each->type;
   //   $package['payment_type'] = $each->payment_type;
       //     $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
}
else if($status == 'pos')
{
$package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'confirm',$merchant_id,'pos');
  $data['meta'] = "View All Pos Confirm Payment ";
 foreach($package_data as $each)
    {
       
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
      $package['type'] = $each->type;
   //   $package['payment_type'] = $each->payment_type;
       //     $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
}
  }
  
  else{
     $data['meta'] = "View All Straight Confirm Payment ";
  
    $package_data = $this->admin_model->get_full_details_payment_rr('customer_payment_request',$merchant_id);
     foreach($package_data as $each)
    {
       
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
      $package['type'] = $each->type;
   //   $package['payment_type'] = $each->payment_type;
       //     $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
    }
  
   
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
       
     
   
  if($this->session->userdata('merchant_user_type')=='employee')
    {
   $this->load->view('employee/all_confirm_payment', $data);
    }
else
{
   
  $this->load->view('merchant/all_confirm_payment', $data);
}
 }
 public function all_pending_payment()
 {
       
    $data = array();
       $mem = array();
    $member = array();
     $merchant_id = $this->session->userdata('merchant_id');
    if($this->input->post('mysubmit'))
  {
  
    $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $status = $_POST['status'];
if($status == 'straight') {
  $package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'pending',$merchant_id,'customer_payment_request');
   $data['meta'] = "View All Straight Pending Payment ";
   foreach($package_data as $each)
    {
       
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
      $package['type'] = $each->type;
   $package['payment_type'] = $each->payment_type;
           $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
}
else if($status == 'recurring')
{
$package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'pending',$merchant_id,'recurring_payment');
 $data['meta'] = "View All Recurring Pending Payment ";
 foreach($package_data as $each)
    {
       
      $package['id'] = $each->id;
       $package['p_id'] = $each->p_id;
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
      $package['type'] = $each->type;
     //$package['payment_type'] = $each->payment_type;
         // $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
}
else if($status == 'pos')
{
$package_data = $this->admin_model->get_search_merchant($start_date,$end_date,'pending',$merchant_id,'pos');
  $data['meta'] = "View All Pos Pending Payment ";
 foreach($package_data as $each)
    {
       
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
      $package['type'] = $each->type;
   //   $package['payment_type'] = $each->payment_type;
       //     $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
}
  }
  
  else{
     $data['meta'] = "View All Straight Pending Payment ";
  
    $package_data = $this->admin_model->get_full_details_payment_rr_p('customer_payment_request',$merchant_id);
     foreach($package_data as $each)
    {
       
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
      $package['type'] = $each->type;
    $package['payment_type'] = $each->payment_type;
         $package['recurring_payment'] = $each->recurring_payment;
      
      $mem[] = $package;
    }
    }
 
   
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
       
     
   
  if($this->session->userdata('merchant_user_type')=='employee')
    {
   $this->load->view('employee/all_pending_payment', $data);
    }
else
{
   
  $this->load->view('merchant/all_pending_payment', $data);
}
 }
public function all_confirm_recurring()
 {
       
    $data = array();
     $merchant_id = $this->session->userdata('merchant_id');
    if($this->input->post('mysubmit'))
  {
  
    $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $status = $_POST['status'];
  $package_data = $this->admin_model->get_search_merchant($start_date,$end_date,$status,$merchant_id,'customer_payment_request');
  }
  
  else{
  
    $package_data = $this->admin_model->get_recurring_details_payment_rrr($merchant_id);
    }
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
       
      $package['id'] = $each->rid;
      $package['payment_id'] = $each->invoice_no;
      $package['name'] = $each->name;
      $package['email'] = $each->email_id; 
      $package['mobile'] = $each->mobile_no;
      $package['amount'] = $each->amount;
      $package['title'] = $each->title; 
      $package['date'] = $each->add_date; 
    
      $package['payment_date'] = $each->payment_date; 
      $package['status'] = $each->status;
     
      
      $mem[] = $package;
    }
    $data['mem'] = $mem;
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
       
     
   
  if($this->session->userdata('merchant_user_type')=='employee')
    {
   $this->load->view('employee/all_confirm_recurring', $data);
    }
else
{
   
  $this->load->view('merchant/all_confirm_recurring', $data);
}
 }
 public function all_recurrig_request()
 {
       
    $data = array();
     $merchant_id = $this->session->userdata('merchant_id');
    if($this->input->post('mysubmit'))
  {
  
  $curr_payment_date = $_POST['curr_payment_date'];
  $status = $_POST['status'];
  $package_data = $this->admin_model->get_recurring_details_payment_admin($curr_payment_date,$status);
  }
  
  else{
  
    $package_data = $this->admin_model->get_recurring_details_payment_admin1();
    }
    $mem = array();
    $member = array();
    foreach($package_data as $each)
    {
       
      $package['rid'] = $each->rid;
      $package['cid'] = $each->cid;
      $package['name'] = $each->name;
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
    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
    $this->session->unset_userdata('mymsg');
       
    
    
 $this->load->view('admin/all_recurrig_request', $data);
 }
 
 
  
 }