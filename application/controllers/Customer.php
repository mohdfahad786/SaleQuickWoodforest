<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 

class Customer extends CI_Controller

{

 public function __construct() 

     {

          parent::__construct();

          $this->load->helper('form');

          $this->load->helper('url');

          $this->load->helper('html');

          $this->load->library('form_validation');

      $this->load->model('admin_model');

        $this->load->model('session_checker_model');

    if(!$this->session_checker_model->chk_session())

    redirect('admin');

  date_default_timezone_set("America/Chicago");

     }



     public function all_support()
     { 
       $data = array();
       if (isset($_POST['mysubmit']))
        {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $package_data = $this->admin_model->get_package_details_merchant1a($start_date,$end_date);
          $data["start_date"] = $_POST['start_date'];
          $data["end_date"] = $_POST['end_date'];
        
        }
      else{
        $package_data = $this->admin_model->get_package_support(""); 
        }
        
        $mem = array();
        $member = array();
        foreach($package_data as $each)
        {
            $package['id'] = $each->id;
            $package['name'] = $each->name;
            $package['email'] = $each->email;
            $package['date_c'] = $each->date_c;
            $package['phone'] = $each->phone;
            $package['subject'] = $each->subject;
            $package['message'] = $each->message;
            $package['add_date'] = $each->add_date;
            $mem[] = $package;
        }
    
        $data['mem'] = $mem;
        $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
        $this->session->unset_userdata('mymsg');
        $this->load->view('admin/all_support', $data);
    
     }
    
    
    
    
    
     public function all_request()
     {
        $data = array();
        if (isset($_POST['mysubmit']))
        {
          $start_date = $_POST['start_date'];
          $end_date = $_POST['end_date'];
          // $status = $_POST['status'];
          // $package_data = $this->admin_model->get_package_details_merchant2($start_date,$end_date,$status);
          $package_data = $this->admin_model->get_package_details_merchant2a($start_date,$end_date);
          $data["start_date"] = $_POST['start_date'];
          $data["end_date"] = $_POST['end_date'];
          // $status = $_POST['status'];
        }
        else{
          $package_data = $this->admin_model->get_package_request_aa(""); 
         }
    
        $mem = array();
       
        $member = array();
        foreach($package_data as $each)
        {
          $package['id'] = $each->id;
          $package['name'] = $each->name;
          $package['phone'] = $each->phone;
          $package['estimatedmonthluvolume'] = $each->estimatedmonthluvolume;
          $package['email'] = $each->email;
          $package['time'] = $each->time;
          $package['add_date'] = $each->add_date;
          $mem[] = $package;
        }
        $data['mem'] = $mem;
        $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";
        $this->session->unset_userdata('mymsg');
        $this->load->view('admin/all_request', $data);
     }





 public function all_customer_request()

 {

       

    $data = array();

    



    if($this->input->post('mysubmit'))

  {

  

  $curr_payment_date = $_POST['curr_payment_date'];

  $status = $_POST['status'];

  $package_data = $this->admin_model->get_package_details_admin($curr_payment_date,$status);

  }

  

  else{

  

    $package_data = $this->admin_model->get_full_details_admin('customer_payment_request');

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



      

      $mem[] = $package;

    }

    $data['mem'] = $mem;

    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";

    $this->session->unset_userdata('mymsg');

       

    



 $this->load->view('admin/all_customer_request', $data);

 }









public function merchant_detail()

 {

       

    $data = array();

       $id = $this->uri->segment(3);



    if($this->input->post('mysubmit'))

  {

  

  $start_date = $_POST['start_date'];

  $end_date = $_POST['end_date'];

  $status = $_POST['status'];

  $package_data = $this->admin_model->get_search($start_date,$end_date,$status,'customer_payment_request');

  }

  

  else{

  

    $package_data = $this->admin_model->data_get_where('customer_payment_request',array("merchant_id" => $id));

    $merchant_data = $this->admin_model->data_get_where_1('merchant',array("id" => $id));

    }

    $mem = array();

    $member = array();

    foreach($package_data as $each)

    {

       

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

    foreach($merchant_data as $each1)

    {

       

      $package1['id'] = $each->id;

      $package1['merchant_name'] = $each->name;

      



      

      $member[] = $package1;

    }

    $data['mem'] = $mem;



    $data['member'] = $member;

    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";

    $this->session->unset_userdata('mymsg');

       

    



 $this->load->view('admin/merchant_detail', $data);

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

      $package['status'] = $each->status;

      $package['payment_type'] = $each->payment_type;

      $package['recurring_payment'] = $each->recurring_payment;



      

      $mem[] = $package;

    }

    $data['mem'] = $mem;

    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";

    $this->session->unset_userdata('mymsg');

       

      

    



 $this->load->view('admin/all_customer_request_recurring', $data);

 }



public function stop_recurring($id)

  {

    $this->admin_model->stop_recurring($id);

    echo json_encode(array("status" => TRUE));

  }







  public function start_recurring($id)

  {

      $this->admin_model->start_recurring($id);

  echo json_encode(array("status" => TRUE));

  }

  

public function stop_package()

  {

      $pak_id = $this->uri->segment(3);

    

    

    

    if($this->admin_model->stop_recurring($pak_id))

      $this->session->set_userdata("mymsg",  "Recurring Has Been Stop.");

    

  }



  public function start_package() 

  {

      $pak_id = $this->uri->segment(3);

    

    if($this->admin_model->start_recurring($pak_id))

  

  

    $this->session->set_userdata("mymsg",  "Recurring Has Been Start.");

    

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

    $data['msg'] = "<h3>".$this->session->userdata('mymsg')."</h3>";

    $this->session->unset_userdata('mymsg');

       

    

    



 $this->load->view('admin/all_recurrig_request', $data);

 }





 public function delete_package()

  {

      $pak_id = $this->uri->segment(3);

    

    if($this->admin_model->delete_package($pak_id))

  

  

    $this->session->set_userdata("mymsg",  "Data Has Been Deleted.");

   

  }



   public function search_record_credntl() {



        $var = $this->input->post('id');

        

        $data = $this->admin_model->data_get_where_serch("d_online", array("id" => $var));

        echo json_encode($data);

        die();

    }

  

     public function search_record_column() {

        $searchby = $this->input->post('id');

    

       

            $data['pay_report'] = $this->admin_model->search_record_un($searchby,'merchant');

           echo $this->load->view('admin/show_result', $data,true);

        

    }





       public function search_record_column1() {

        $searchby = $this->input->post('id');

    

       $data['item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" => $searchby));



           // $data['item'] = $this->admin_model->search_item($searchby);

            $data['pay_report'] = $this->admin_model->search_record($searchby);

           echo $this->load->view('admin/show_result1', $data,true);

        

    }





      public function search_record_payment() {

        $searchby = $this->input->post('id');

    

       

            $data['pay_report'] = $this->admin_model->search_record($searchby);

           echo $this->load->view('admin/show_result_payment', $data,true);

        

    }



    public function merchant_delete($id)

  {

    $this->admin_model->delete_by_id($id,'d_online');

    echo json_encode(array("status" => TRUE));

  }



  public function subadmin_delete($id)

  {

    $this->admin_model->delete_by_id($id,'r_call');

    echo json_encode(array("status" => TRUE));

  }



  public function block_merchant($id)

  {

      $this->admin_model->block_by_id($id,'merchant');

    echo json_encode(array("status" => TRUE));



  }



  public function active_merchant($id)

  {

      $this->admin_model->active_by_id($id,'merchant');

    echo json_encode(array("status" => TRUE));



  }





}



?>