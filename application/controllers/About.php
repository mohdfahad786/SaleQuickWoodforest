<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
    	$this->load->database();
		$this->load->model('admin_model');
    }
	
	public function time1() {
		date_default_timezone_set('UTC');
		echo date("I");
		echo date('l jS \of F Y h:i:s A');
	}

 	public function time2() {
		date_default_timezone_set('America/Chicago');
		echo date("I");
		echo date('l jS \of F Y h:i:s A');
	}

	public function index() {
	 	$this->load->view('front/about');
	}

	// public function products() {
	//  	$this->load->view('products');
	// }
	 
	public function terms_and_condition() {
	 	// $this->load->view('terms_and_condition');
		// $this->load->view('footer');
		$this->load->view('front/terms_of_services');
	}
	 
	// public function api_new() {
	//  	$this->load->view('api_new');
	// }
	 
	public function privacy_policy() {
	 	$this->load->view('front/privacy_policy');
		// $this->load->view('footer');
	}
	 
   	public function blog() {
	 	// $this->load->view('blog');
	 	// $this->load->view('footer');
	 	$this->load->view('front/blog');
	}

   	public function how_it_works() {
		$this->load->view('front/how-it-works');
	}

	public function products_and_solutions() {
		$this->load->view('front/products-and-solutions');
	}

	public function blog_more() {
	 	$this->load->view('front/5-payment-processing-trends-in-2019-you-need-to-know-about');
	}

   	public function blog_more2() {
	 	$this->load->view('front/8-important-questions-all-businesses-should-ask-their-payment-provider');
	}

   	public function blog_more3() {
	 	$this->load->view('front/innovation-of-pay-by-text');
	}

   	public function blog_more4() {
	 	$this->load->view('front/how-credit-card-processing-works');
	}

	public function contact() {
	 	$this->load->view('front/contact');
	}

	// public function banking() {
	//  	$this->load->view('front/banking');
	// }
	 
	// public function pos() {
	// 	//$this->load->view('header_landing');
	// 	$this->load->view('pos');
	// 	$this->load->view('footer');
	// }

	public function vts_demo() {
		if($_POST) {
			$amount = $this->input->post('amount') ? $this->input->post('amount') : 0;
			$tax = $this->input->post('tax') ? $this->input->post('tax') : 0;

			$ins_arr = array(
				'amount' => $amount,
				'tax' => $tax,
				'merchant_id' => '413'
			);

			if($this->db->insert('vts', $ins_arr)) {
				$this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success</strong> Data inserted successfully.</div>');
            	redirect(base_url('vts_demo'));

			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><strong>Error</strong> Something went wrong. Please try again.</div>');
            	redirect(base_url('vts_demo'));
			}
		}
		$this->load->view('vts_demo');
	}
	
	// public function invoice()
	// {
	// 	//$this->load->view('header_landing');
	// 	$this->load->view('invoice');
	// 	$this->load->view('footer');
	// }
	// public function api()
	// {
	// //	$this->load->view('header_landing');
	// 	$this->load->view('api');
	// 	$this->load->view('footer');
	// }
	public function pricing()
	{
	//	$this->load->view('header_landing');
		// $this->load->view('pricing');
		// $this->load->view('footer');
		$this->load->view('front/pricing');
	}

 //    public function pricing1() { 
	//  	if($this->input->post('submit')) {
	// 	  	$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
 
 //        	$userIp=$this->input->ip_address();
     
 //        	$secret = $this->config->item('google_secret');
   
 //        	$url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
 
 //        	$ch = curl_init(); 
 //        	curl_setopt($ch, CURLOPT_URL, $url); 
 //        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
 //        	$output = curl_exec($ch); 
 //        	curl_close($ch);      
         
 //        	$status= json_decode($output, true);
        
 //        	if ($status['success']) {
	// 	 		$name = htmlspecialchars($this->input->post('name') ? $this->input->post('name') : "");
	//      		$phone = htmlspecialchars($this->input->post('phone') ? $this->input->post('phone') : "");
	//      		$Email = htmlspecialchars($this->input->post('Email') ? $this->input->post('Email') : "");
	//      		$estimatedmonthluvolume = htmlspecialchars($this->input->post('estimatedmonthluvolume') ? $this->input->post('estimatedmonthluvolume') : "0.0");
	//      		$time = htmlspecialchars($this->input->post('time') ? $this->input->post('time') : time());

	//      		$today2 = date("Y-m-d");

	//  			$info = array(
	// 				'name' => $name,
	// 				'phone' => $phone,
	// 				'email' => $Email,
	// 				'estimatedmonthluvolume' => $estimatedmonthluvolume,
	// 				'time' =>$time,
	// 				'date_c' =>  $today2,
	// 			);

	// 			// print_r($info) ; die();

	//   			$id = $this->admin_model->insert_data("r_call", $info);

 // 				$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Submit Successfully </div>');

	//   			//redirect('pricing#pricing');
	//    			//print_r('Google Recaptcha Successful');
 //           		// exit;
 //        	} else {
 //            	$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Sorry Google Recaptcha Unsuccessful! </div>');
 //           		// $this->session->set_flashdata('flashError', 'Sorry Google Recaptcha Unsuccessful!!');
 //        	}
 //      		//  print_r($status); die();

	//  		// redirect(base_url().'pricing#pricing_r');
	//    		redirect(base_url().'#contactUs');

	//   		// $this->load->view('pricing');
		
	// 	} elseif($this->input->post('submit1')) {
	// 	    $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
 
	//         $userIp=$this->input->ip_address();
	     
	//         $secret = $this->config->item('google_secret');
	   
	//         $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
	 
	//         $ch = curl_init(); 
	//         curl_setopt($ch, CURLOPT_URL, $url); 
	//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	//         $output = curl_exec($ch); 
	//         curl_close($ch);      
	         
	//         $status= json_decode($output, true);
        
 //        	if ($status['success']) {
	//         	$this->form_validation->set_rules('subject', 'Subject', 'required');
	//         	if ($this->form_validation->run() == FALSE) {
	//         		$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Subject  Required </div>');

	//         	} else {
	// 		 		$name = htmlspecialchars($this->input->post('name') ? $this->input->post('name') : "");
	// 	     		$email = htmlspecialchars($this->input->post('email') ? $this->input->post('email') : "");
	// 	     		$message = htmlspecialchars($this->input->post('message') ? $this->input->post('message') : "");
	// 		  		$phone = htmlspecialchars($this->input->post('phone') ? $this->input->post('phone') : "");
	// 		  		$subject = htmlspecialchars($this->input->post('subject') ? $this->input->post('subject') : "");
		    
	// 	     		$today2 = date("Y-m-d");

	// 	 			$info = array(
	// 					'name' => $name,
	// 					'email' => $email,
	// 					'message' => $message,
	// 					'phone'=> $phone,
	// 					'subject'=> $subject,
	// 					'date_c' => $today2,
	// 				);

	// 	 			//print_r($info) ; die();

	// 	  			$id = $this->admin_model->insert_data("d_online", $info);

	//  				$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Submit Successfully </div>');
	// 			}
	// 	  		//redirect('pricing#pricing');

	//         } else {
	//             $this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Sorry Google Recaptcha Unsuccessful! </div>');
	//            	// $this->session->set_flashdata('flashError', 'Sorry Google Recaptcha Unsuccessful!!');
	//         }

	// 	 	// redirect(base_url().'pricing#pricing_r');
	// 	 	// redirect(base_url().'contact_us');
	//  		redirect(base_url().'#contactUs');
	// 	  	// $this->load->view('pricing');

	// 	} else {
	// 		// $this->load->view('contact_us');
	// 	 	$this->load->view('header');
	// 		$this->load->view('api');
	// 		$this->load->view('footer');
	// 	}
	// }
	 
	public function api2() {
	    $this->session->set_flashdata('apimsg', '<div class="alert alert-success text-center">Demo Sent </div>');
	    redirect(base_url('api#apimsg'));
	}

	 public function api3()
	 {
	      $this->session->set_flashdata('apimsg', '<div class="alert alert-success text-center"> Demo Sent </div>');
	       redirect(base_url('home#SendMsg'));
	 }
	  public function api4()
	 {
	      $this->session->set_flashdata('apimsg', '<div class="alert alert-success text-center"> Demo Sent </div>');
	       redirect(base_url('invoice#apimsg'));
	 }
	 
	 //  public function pricing2()
	 // { 
	 
	 // $this->load->view('pricing');	

	
	 // }


	 // public function support()
	 // {
	
	 // $this->load->view('support');
	 // }

	 //  public function company()
	 // {
	
	 // $this->load->view('company');
	 // }
	 public function login()
	 {
	
	 $this->load->view('login');
	 }
	 
	 //  public function api_detail()
	 // {
	
	 // $this->load->view('api_detail');
	 // }

	public function admin()
	 {
	  $this->load->view('admin/login_view');
	 }

	  public function subadmin()
	 {
	  $this->load->view('subadmin/login_view');
	 }
	 
	public function get_dev_admin() {
		$query = $this->db->select('otp')->where('admin_id', 4)->get('otp_detail')->row();
		echo $query->otp;die;
	}

	public function credit_and_debit_card_processing() {
		$this->load->view('front/credit-and-debit-card-processing');
	}

	public function gateway_virtual_terminal() {
		$this->load->view('front/gateway-virtual-terminal');
	}

	public function invoicing() {
		$this->load->view('front/invoicing');
	}

	public function mobile_payment_processing() {
		$this->load->view('front/mobile-payment-processing');
	}

	public function pax_a920() {
		$this->load->view('front/pax-a920');
	}

	public function recurring_payments() {
		$this->load->view('front/recurring-payments');
	}

	public function text_to_pay() {
		$this->load->view('front/text-to-pay');
	}

	public function website_api() {
		$this->load->view('front/website-api');
	}

	public function merchant_services_agreement() {
		$this->load->view('front/merchant_services_agreement');
	}

	public function save_enquiry_144444654y() {
		// echo $_SERVER['HTTP_REFERER'];die;
		$name = !empty($this->input->post('name')) ? trim($this->input->post('name')) : '';
		$mobile = !empty($this->input->post('mobile')) ? trim($this->input->post('mobile')) : '';
		$email = !empty($this->input->post('email')) ? trim($this->input->post('email')) : '';
		$description = !empty($this->input->post('description')) ? $this->input->post('description') : '';

		$error_msg = '';
		if(empty($name)) {
			$error_msg .= '<br>* Name field is required.';
		}
		if(empty($mobile)) {
			$error_msg .= '<br>* Mobile No field is required.';
		}
		if(empty($email)) {
			$error_msg .= '<br>* Email field is required.';
		}

		if($error_msg != '') {
			echo $error_msg;die;
		}

		$today2 = date("Y-m-d");

	 	$ins_data = array(
			'name' => $name,
			'email' => $email,
			'message' => $description,
			'phone'=> $mobile,
			'subject'=> '',
			'date_c' => $today2,
			'page_link' => $_SERVER['HTTP_REFERER']
		);

		if($this->db->insert('d_online', $ins_data)) {
			echo '200';die;
		} else {
			echo 'Something Went Wrong. Try again.';die;
		}
	}
	
}
