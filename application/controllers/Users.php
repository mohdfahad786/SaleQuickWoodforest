<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct(){
		parent::__construct();

		// load base_url
		$this->load->helper('url');

		// Load Model
		$this->load->model('Main_model');
        $this->load->model('session_checker_model');
        $this->load->library('csvimport');
        $this->load->library('Excel');
        ini_set('precision', '15');

        if (!$this->session_checker_model->chk_session()) {
            redirect('admin');
        }
        // ini_set('display_errors', 1);
        // error_reporting(E_ALL);
        date_default_timezone_set("America/Chicago");
	}
	
	public function index(){
        // Check form submit or not 
        if($this->input->post('upload') != NULL) {
            // echo 1;die;
            $data = array();

            $csv_year = $_POST['csv_year'];
            $csv_month = $_POST['csv_month'];

            $log_arr = array(
                'csv_year' => $csv_year,
                'csv_month' => $csv_month
            );
            $log_data = $this->db->where($log_arr)->get('csv_uploads_log')->result_array();
            // echo '<pre>';print_r(count($log_data));die;

            if(count($log_data) > 0) {
                // echo 1;die;
                $data['meta'] = 'Upload Revenue CSV';
                $error_response = 'Error! Selected year and month data already exists. Try another.';
                $this->session->set_flashdata('error', $error_response);
                redirect('users');
            
            } else {
                // echo 2;die;
                if(!empty($_FILES['file']['name'])) {
                    $new_error = '';
                    // echo 3;die;
                    // echo '<pre>';print_r($_FILES);die;
                    $data['meta'] = 'Upload Revenue CSV';
                    // Set preference 
                    $config['upload_path'] = 'uploads/attachment/'; 
                    $config['allowed_types'] = 'csv';
                    $config['max_size'] = 1000; // max_size in kb 
                    $config['file_name'] = $_FILES['file']['name']; 

                    // Load upload library 
                    $this->load->library('upload',$config); 
       
                    // File upload
                    if($this->upload->do_upload('file')) {
                        // echo 5;die;
                        // Get data about the file
                        $uploadData = $this->upload->data(); 
                        $filename = $uploadData['file_name']; 

                        // $fp = file($filename);

                        // Reading file
                        $file = fopen("uploads/attachment/".$filename,"r");
                        // $fileData=@file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        // $noOfLines = count($fileData);
                        // echo count($noOfLines);die;

                        $i = 0;
                        $numberOfFields = 9; // Total number of fields
                        $importData_arr = array();
                           
                        while (($filedata = fgetcsv($file, 1000000, ",")) !== FALSE) {
                            $num = count($filedata);
                            // echo $numberOfFields.','.$num;die;

                            if(!empty($filedata[2])) {
                                if($numberOfFields == $num){
                                    for ($c=0; $c < $num; $c++) {
                                        // echo '<pre>';print_r($filedata[3]);
                                        // echo '<pre>';print_r(number_format($filedata[3],0,'',''));
                                        
                                        if(($filedata[0] == $csv_month) && ($filedata[1] == $csv_year)) {
                                            $importData_arr[$i][] = $filedata[$c];
                                        }
                                    }
                                } else {
                                    $error_response = 'Error! Number of columns does not match with original format.';
                                    $this->session->set_flashdata('error', $error_response);
                                    redirect('users');
                                }
                                $i++;
                            }
                        }
                        // echo $i;die;
                        if(sizeof($importData_arr) < 1) {
                            $error_response = 'Error! Please upload selected month and year data only.';
                            $this->session->set_flashdata('error', $error_response);
                            redirect('users');
                        }

                        $totalRowCount = $i-1;
                        $importDataArrCount = sizeof($importData_arr);
                        // echo $importDataArrCount.','.$totalRowCount;die;
                        if($importDataArrCount != $totalRowCount) {
                            $new_error = 'Success! Selected month and year data uploaded only.';
                        }

                        fclose($file);

                        $skip = 0;
                        // die;
                        // insert import data
                        // echo '<pre>';print_r($importData_arr);die;
                        $non_upload_count = 0;
                        foreach($importData_arr as $userdata) {
                            $merchant = $this->db->select('id, pax_pos_mid')->where('pax_pos_mid', $userdata[2])->get('merchant')->row();

                            $userdata[5] = str_replace('$', '', $userdata[5]);
                            $userdata[5] = str_replace(',', '', $userdata[5]);

                            $userdata[6] = str_replace('$', '', $userdata[6]);
                            $userdata[6] = str_replace(',', '', $userdata[6]);

                            $userdata[7] = str_replace('$', '', $userdata[7]);
                            $userdata[7] = str_replace(',', '', $userdata[7]);

                            $userdata[8] = str_replace('$', '', $userdata[8]);
                            $userdata[8] = str_replace(',', '', $userdata[8]);

                            // $userdata[9] = str_replace('$', '', $userdata[9]);
                            // $userdata[9] = str_replace(',', '', $userdata[9]);
                            $userdata[9] = !empty($merchant) ? $merchant->id : '0';

                            if($this->Main_model->insertRecord($userdata)) {

                            } else {
                                $non_upload_count++;
                            }
                            $skip ++;
                        }
                        // die;
                        
                        $this->db->insert('csv_uploads_log', $log_arr);

                        // $data['meta'] = 'Upload Revenue CSV';
                        if(empty($new_error)) {
                            if($non_upload_count > 0) {
                                $error_response = 'Success! Data uploaded. Some data are not uploaded due to insertion error.';
                            } else {
                                $error_response = 'Success! '.$filename.' Uploaded Successfully';
                            }

                        } else {
                            $error_response = $new_error;
                        }
                        $this->session->set_flashdata('success_new1', $error_response);
                        redirect('users/csv_upload_success');

                    } else {
                        // echo $this->upload->display_errors();die;
                        // $data['meta'] = 'Upload Revenue CSV';
                        $error_response = 'Error!<br>'.$this->upload->display_errors();
                        $this->session->set_flashdata('error', $error_response);
                    }

                } else {
                    // echo 4;die;
                    // $data['meta'] = 'Upload Revenue CSV';
                    $error_response = 'Error! No file selected';
                    $this->session->set_flashdata('error', $error_response);
                }
                $data['meta'] = 'Upload Revenue CSV';
                // load view 
                $this->load->view('admin/users_view', $data);
            }

        } else {
            // echo 2;die;
            $data['meta'] = 'Upload Revenue CSV';
            // load view 
            $this->load->view('admin/users_view', $data); 
        }
    }

    public function csv_upload_success() {
        $data['meta'] = 'CSV Upload';
        $this->load->view('admin/csv_upload_success', $data);
    }

    public function get_update_revenue() {
        $upload_log = $this->db->from('csv_uploads_log')->order_by('id','desc')->get()->row();
        $month = $upload_log->csv_month;
        $year = $upload_log->csv_year;

        $recent_uploaded = $this->db->query("SELECT * FROM csv_details WHERE month = '".$month. "' AND year = '".$year."'")->result_array();
        // echo '<pre>';print_r($recent_uploaded);die;

        foreach ($recent_uploaded as $key => $recent) {
            // echo $recent['merchant_id'].',';
            if($recent['merchant_id'] != 0) {
                $agent = $this->db->query("SELECT * FROM `sub_admin` WHERE user_type='agent' and find_in_set('".$recent['merchant_id']."',assign_merchant)")->row();

                if(!empty($agent)) {
                    // echo '<pre>';print_r($agent);
                    // echo $agent->buyrate_volume.','.$agent->commission_p_transaction.','.$agent->buy_rent.'<br>';
                    $buy_rate = number_format(($recent['Transaction']*$agent->buy_rent),2);

                    $Payment_Volume_percent = ($agent->buyrate_volume/100)*$recent['Payment_Volume'];

                    $buy_rate_volume = number_format($Payment_Volume_percent,2);

                    $this->db->query("UPDATE `csv_details` SET `buy_rate`='".$buy_rate."',`gateway_fee`= '".$agent->commission_p_transaction."',`buy_rate_valume`='".$buy_rate_volume."' WHERE id = '".$recent['id']."'");
                }
            }
        }
        // echo $this->db->last_query();die;
    }

	public function show() {
        $this->load->model('Main_model');
        $users=$this->Main_model->all();
        $data=array();
        $data['users']=$users;
        $this->load->view('admin/list_view', $data);
    }

}