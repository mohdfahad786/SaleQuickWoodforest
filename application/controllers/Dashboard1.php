<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dashboard1 extends CI_Controller
{
 public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->database();
           date_default_timezone_set("America/Chicago");
          $this->load->library('form_validation');
         $this->load->model('session_checker_model');
		if(!$this->session_checker_model->chk_session1())
		redirect('subadmin');
     }



  public function index(){
	 
            $data["title"] ="Subadmin Panel";
            $this->load->model("subadmin_model");
				$id = $this->uri->segment(3);
				$name = $this->session->userdata('branch_name');
          
$loginuser1 = $this->session->userdata('loginuser1');
$date =  date('Y-m-d');
$date1 =  date('Y-m');

$branch_id = $this->session->userdata('id');

 	$getDashboard = $this->db->query("SELECT (SELECT count(Id)  from `student_detail` where    date_c='".$date."' and 
	branch_id='".$branch_id."')
	as reistration,(SELECT count(Id)  from `student_detail` where  month='".$date1."' and 
	branch_id='".$branch_id."') as monthregistration,
	(SELECT count(Id) FROM `fee_details` WHERE CURDATE()=next_installment_date  ) as delNotifications ");

$getDashboardData = $getDashboard->result_array();
$data['getDashboardData'] = $getDashboardData;

		 $usr_result = $this->subadmin_model->get_logo();
                 
					 if (!empty($usr_result))
					 
                    {
                         $sessiondata = array(
							   
							   'name' => $usr_result['name'],
							   'image' => $usr_result['image']
                              
                         );
                         $this->session->set_userdata($sessiondata);
                    }
					
       return $this->load->view('subadmin/dashboard',$data);

    }


}

?>
