<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Broadcast extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->model('profile_model');
        $this->load->library('email');
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
        } else if( $action == 'd' ) {
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
        return $output;
    }

    public function send_mail_original() {
        $mail_arr = $this->db->get_where('merchant', array('status' => 'active', 'user_type' => 'merchant'))->result_array();
        //echo '<pre>';print_r($mail_arr);die();
        if($this->input->post()) {
            // echo '<pre>';print_r($this->input->post());die();
            $subject = $this->input->post('subject') ? $this->input->post('subject') : '';
            $description = $this->input->post('description') ? $this->input->post('description') : '';
            $mail_to_arr = $this->input->post('framework');
            $footer_quote = $this->input->post('footer_msg');
            $footer_text = $this->input->post('footer_text');
            $website_name = $this->input->post('website_name');
            $website_link = $this->input->post('website_link');

            $data['subject'] = $subject;
            $data['description'] = $description;
            $data['footer_quote'] = $footer_quote;
            $data['footer_text'] = $footer_text;
            $data['website_name'] = $website_name;
            $data['website_link'] = $website_link;
            $mail_temp = $msg = $this->load->view('broadcast_mail_template', $data, true);

            if (!empty($mail_to_arr)) {
                $this->email->from('info@salequick.com', 'Admin - Salequick');
                $this->email->to($mail_to_arr);
                $this->email->subject($subject);
                $this->email->message($mail_temp);
                $this->email->send();
            }
        }
        $data['meta'] = 'Broadcast Mail';
        $data['mail_arr'] = $mail_arr;
        $this->load->view('admin/broadcast_mail', $data);
    }

    public function send_mail() {
        $mail_arr = $this->db->get_where('merchant', array('status' => 'active', 'user_type' => 'merchant'))->result_array();
        //echo '<pre>';print_r($mail_arr);die();
        if($this->input->post()) {
            // echo '<pre>';print_r($this->input->post());die();
            $subject = $this->input->post('subject') ? $this->input->post('subject') : '';
            $description = $this->input->post('description') ? $this->input->post('description') : '';
            $mail_to_arr = $this->input->post('framework');
            $footer_quote = $this->input->post('footer_msg');
            $footer_text = $this->input->post('footer_text');
            $website_name = $this->input->post('website_name');
            $website_link = $this->input->post('website_link');

            $data['subject'] = $subject;
            $data['description'] = $description;
            $data['footer_quote'] = $footer_quote;
            $data['footer_text'] = $footer_text;
            $data['website_name'] = $website_name;
            $data['website_link'] = $website_link;
            $mail_temp = $msg = $this->load->view('broadcast_mail_template', $data, true);

            if (!empty($mail_to_arr)) {
                foreach ($mail_to_arr as $key => $mail_id) {
                    $this->email->from('info@salequick.com', 'Admin - Salequick');
                    $this->email->to($mail_id);
                    $this->email->subject($subject);
                    $this->email->message($mail_temp);
                    $this->email->send();
                }
            }
        }
        $data['meta'] = 'Broadcast Mail';
        $data['mail_arr'] = $mail_arr;
        $this->load->view('admin/broadcast_mail_dash', $data);
    }
    
}		