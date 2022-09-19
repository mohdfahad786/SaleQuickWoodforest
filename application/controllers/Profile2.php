<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->model('profile_model');
		$this->load->model('session_checker_model');
		if(!$this->session_checker_model->chk_session())
		redirect('admin');
		 date_default_timezone_set("America/Chicago");
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

	public function edit_profile() {
		$data = array();
		$data['meta'] = 'Edit Profile';

		$this->load->library('form_validation');
		$data['upload_loc'] = base_url('logo');
			
		$pak_id = '1';
		if(!$pak_id && !$this->input->post('mysubmit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";die;
		}
		$package = $this->profile_model->get_package_details($pak_id);
		if($this->input->post('mysubmit')) {
			$id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
			$title = $this->input->post('title') ? $this->input->post('title') : "";
	    	$url = $this->input->post('url') ? $this->input->post('url') : "";
			$psw = $this->input->post('psw') ? $this->input->post('psw') : "";
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";
			$language = $this->input->post('language') ? $this->input->post('language') : "";
			$mypic = $this->input->post('mypic') ? $this->input->post('mypic') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			
			if($cpsw!='') {
				$psw1 =  $this->my_encrypt($cpsw, 'e' );
			} else {
				$psw1 = $psw;
			}
												 
			$this->_validation();
			if($this->form_validation->run() != FALSE) {
				$cou = 0;
				$config['upload_path'] = 'logo/';  
        		$config['allowed_types'] = 'gif|jpg|jpeg|png';  
        		$config['max_size'] = '0';  
        		$this->load->library('upload', $config);
				if($this->upload->do_upload('mypic')) {
					$fInfo = $this->upload->data();
					$mypic = $fInfo['file_name'];
					$package_info = array(
						'username' => $title,
						'name' => $name,
						'email_id' => $url,
						'password' => $psw1,
						'image'   => $mypic
					);
				} else {
					$package_info = array(
						'username' => $title,
						'name' => $name,
						'email_id' => $url,
						'password' => $psw1
					);
				}
				$this->profile_model->update_package($id, $package_info);
				$this->session->set_flashdata("success", "Profile Info updated successfully.");
				redirect('profile/edit_profile');
			}

		} else {
			foreach($package as $pak) {
				$data['pak_id'] = $pak->id;
				$data['title'] = $pak->username;
				$data['url'] = $pak->email_id;
				$data['psw'] = $pak->password;
				$data['mypic'] = $pak->image;
				$data['name'] = $pak->name;
				break;
			}
		}
		$data['loc'] = "edit_profile";
		// $data['meta'] = 'Update_Profile';
        $data['action'] = 'Update';
		$this->load->view('admin/edit_profile_dash', $data);
	}
	
	public function _validation() {
		$rules = array(
        array('field' => 'title',
              'label' => '<b style="color:blue;text-decoration: blink;">Title</b>',
              'rules' => 'trim|required|max_length[75]|htmlspecialchars') ,
        array('field' => 'url',
              'label' => '<b style="color:blue;text-decoration: blink;">Url</b>',
              'rules' => 'trim|required|max_length[75]|htmlspecialchars')  
	       
        	  ) ;
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');
	}
	
}
