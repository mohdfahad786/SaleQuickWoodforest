<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Email_template extends CI_Controller {
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
        $this->load->model('session_checker_model');
        if(!$this->session_checker_model->chk_session())
            redirect('admin');
    
        date_default_timezone_set("America/Chicago");
    }

    public function registration() {
        $data['meta'] = 'Registration Template';
        $data['upload_loc'] = base_url('logo');
    
        $package = $this->profile_model->get_templete('5');
        if($this->input->post('mysubmit')) {
            $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
            $templete = $this->input->post('templete') ? $this->input->post('templete') : "";
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
    
            $package_info = array(             
                'templete' => $templete,
            );
            $this->admin_model->update_data('email_template',$package_info,array('id' => $id));
            $this->session->set_flashdata("success",  "Registration Template updated successfully.");
            redirect('email_template/registration');

        } else {
            foreach($package as $pak) {
                $data['pak_id'] = $pak->id;
                $data['type'] = $pak->type;
                $data['templete'] = $pak->templete;
                $data['status'] = $pak->status;
                break;
            }
        }
        $data['loc'] = "registration";
        $data['action'] = 'Update';
        $this->load->view('admin/email_template_dash', $data);
    }

    public function invoice() {
        $data['meta'] = 'Invoice Template';
        $data['upload_loc'] = base_url('logo');
        $package = $this->profile_model->get_templete('1');

        if($this->input->post('mysubmit')) {
            $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
            $templete = $this->input->post('templete') ? $this->input->post('templete') : "";
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
      
            $package_info = array(
                'templete' => $templete,
            );
            $this->admin_model->update_data('email_template',$package_info,array('id' => $id));
            $this->session->set_flashdata("success",  "Invoice Template updated successfully.");
            redirect('email_template/invoice');

        } else {
            foreach($package as $pak) {
                $data['pak_id'] = $pak->id;
                $data['type'] = $pak->type;
                $data['templete'] = $pak->templete;
                $data['status'] = $pak->status;
                break;
            }
        }
        $data['loc'] = "invoice";
        $data['action'] = 'Update';
        $this->load->view('admin/email_template_dash', $data);
    }


    public function pos() {
        $data['meta'] = 'POS Template';
        $data['upload_loc'] = base_url('logo');
    
        $package = $this->profile_model->get_templete('2');
        if($this->input->post('mysubmit')) {
            $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
            $templete = $this->input->post('templete') ? $this->input->post('templete') : "";
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

            $package_info = array(
                'templete' => $templete,
            );
            $this->admin_model->update_data('email_template',$package_info,array('id' => $id));
            $this->session->set_flashdata("success", "POS Template updated successfully.");
            redirect('email_template/pos');

        } else {
            foreach($package as $pak) {
                $data['pak_id'] = $pak->id;
                $data['type'] = $pak->type;
                $data['templete'] = $pak->templete;
                $data['status'] = $pak->status;
                break;
            }
        }
        $data['loc'] = "pos";
        $data['action'] = 'Update';
        $this->load->view('admin/email_template_dash', $data);
    }

    public function reciept() {
        $data['meta'] = 'Reciept Template';
        $data['upload_loc'] = base_url('logo');
    
        $package = $this->profile_model->get_templete('3');
        if($this->input->post('mysubmit')) {
            $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
            $templete = $this->input->post('templete') ? $this->input->post('templete') : "";
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

            $package_info = array(
                'templete' => $templete,
            );
            $this->admin_model->update_data('email_template',$package_info,array('id' => $id));
            $this->session->set_flashdata("success", "Reciept Template updated successfully.");
            redirect('email_template/reciept');
        } else {
            foreach($package as $pak) {
                $data['pak_id'] = $pak->id;
                $data['type'] = $pak->type;
                $data['templete'] = $pak->templete;
                $data['status'] = $pak->status;
                break;
            }
        }
        $data['loc'] = "reciept";
        $data['action'] = 'Update';
        $this->load->view('admin/email_template_dash', $data);
    }

    public function recurring() {
        $data['meta'] = 'Recurring Template';
        $data['upload_loc'] = base_url('logo');
    
        $package = $this->profile_model->get_templete('4');
        if($this->input->post('mysubmit')) {
            $id = $this->input->post('pak_id') ? $this->input->post('pak_id') : "";
            $templete = $this->input->post('templete') ? $this->input->post('templete') : "";
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

            $package_info = array(
                'templete' => $templete,
            );
            $this->admin_model->update_data('email_template',$package_info,array('id' => $id));
            $this->session->set_flashdata("success", "Recurring Template updated successfully.");
            redirect('email_template/recurring');
        } else {
            foreach($package as $pak) {
                $data['pak_id'] = $pak->id;
                $data['type'] = $pak->type;
                $data['templete'] = $pak->templete;
                $data['status'] = $pak->status;
                break;
            }
        }
        $data['loc'] = "recurring";
        $data['action'] = 'Update';
        $this->load->view('admin/email_template_dash', $data);
    }

  }   