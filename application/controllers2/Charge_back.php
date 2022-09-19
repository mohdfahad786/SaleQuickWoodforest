<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Charge_back extends CI_Controller
{ 

     public function __construct() 
     {
          parent::__construct();
        
          $this->load->model('admin_model');
          $this->load->model('Home_model');
          $this->load->model('customers_model','customers');
           date_default_timezone_set("America/Chicago");
           $this->load->model('session_checker_model');
            if(!$this->session_checker_model->chk_session())
    redirect('admin');
    
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
        redirect('charge_back/all_charge_back');

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
  


  public function all_charge_back()
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
    

 

  
$this->load->view('admin/all_charge_back', $data);
  

 }


  
public function charge_back_delete($id)
  {
    $this->admin_model->delete_by_id($id,'refund');
    echo json_encode(array("status" => TRUE));
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
      $row[] = $customers->owner_name;
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
  
    $merchant_id = $this->session->userdata('merchant_id');
    
    //$package_data = $this->admin_model->get_data('tax',$merchant_id);
 if($this->session->userdata('user_type')=='admin')
    {
$package_data = $this->admin_model->data_get_where_2('pos');
    }
    else
    {
    $package_data = $this->admin_model->data_get_where_1('pos', array('merchant_id' => $merchant_id));
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
    


  
$this->load->view('admin/all_pos', $data);
  

 }




 }