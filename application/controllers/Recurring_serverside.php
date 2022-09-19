<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Recurring_serverside extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->model('admin_model');
        $this->load->model('recurring_serverside_model');
        //$this->load->model('sendmail_model');
        $this->load->model('session_checker_model');
        if (!$this->session_checker_model->chk_session_merchant()) {
            redirect('login');
        }
        if ($this->session->userdata('time_zone')) {
            $time_Zone = $this->session->userdata('time_zone') ? $this->session->userdata('time_zone') : '';
            date_default_timezone_set($time_Zone);
        } else {
            date_default_timezone_set('America/Chicago');
        }
        // ini_set('display_errors', 1);
        // error_reporting(E_ALL);
    }

    public function index() {
        $data = array();
        $merchant_id = $this->session->userdata('merchant_id');
        $curentDate=date('Y-m-d');
        $status = $this->input->post('status');
        $_result = $this->recurring_serverside_model->get_datatables();

        $package = $_result['result'];
        // echo '<pre>';print_r($package);die;

        $mem=array();
        $a=1; 
        foreach ($package as $row) {
            $invoice_id=$row->invoice_no;
            $merchant_id=$row->merchant_id;
            $row_id=$row->id;
            if($row->recurring_count  > 0){
                $row->recurring_count =$row->recurring_count;
            } elseif($row->recurring_count < 0) {
                $row->recurring_count=-1;
            } else {
                $row->recurring_count=1;
            }
            $this->db->where('id', $row_id);
            $table='customer_payment_request'; 
            $this->db->get($table)->row();

            if ($status != '') {
                switch($status){
                    case "confirm":
                        $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
                        $DGetAllpaidRecord=$GetAllpaidRecord->result();
                        $AllPaidRequest=count($DGetAllpaidRecord);

                        $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
                        $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
                        $AllUnPaidRequest=count($DGetAllUnpaidRecord);


                        $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
                        $df=$GetPrevResult->result_array(); 
                        $is_prev_paid=count($df); 

                        if( $row->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ( $row->recurring_payment=='stop' ||  $row->recurring_payment=='complete')   && $is_prev_paid <='0') { 
                            array_push($mem, $row); 
                        } else {
                            $each=array();
                        }
                    break;

                    case "pending":
                        $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
                        $DGetAllpaidRecord=$GetAllpaidRecord->result();
                        $AllPaidRequest=count($DGetAllpaidRecord);
            
                        $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
                        $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
                        $AllUnPaidRequest=count($DGetAllUnpaidRecord);
            
            
                        $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
                        $df=$GetPrevResult->result_array(); 
                        $is_prev_paid=count($df);  

                        if( $is_prev_paid <='0' &&  $AllUnPaidRequest >='0' && $row->recurring_payment=='start' && $row->recurring_count > $AllPaidRequest){
                            array_push($mem, $row); 
                        } else {
                            $each=array();
                        }
                    break; 
                    
                    case "late":
                        $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC "); 
                        $DGetAllpaidRecord=$GetAllpaidRecord->result();
                        $AllPaidRequest=count($DGetAllpaidRecord);
            
                        $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
                        $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
                        $AllUnPaidRequest=count($DGetAllUnpaidRecord);
            
            
                        $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
                        $df=$GetPrevResult->result_array(); 
                        $is_prev_paid=count($df);  

                        if($AllUnPaidRequest > '0' &&  $is_prev_paid >'0'  ){
                            array_push($mem, $row); 
                        } else {
                            $each=array();
                        }
                    break; 
                    
                    default :
                        $each=array();
                        array_push($mem, $row); 
                    break; 
                }

            } else {
                array_push($mem, $row);
            }
        }
        // return $mem;

        $recur_list = $_result['result'];
        
        $no = $_POST['start'];
        $count = 0;
        $i = 1;
        foreach ($recur_list as $val) {
            $recurring_pay_start_date=$val->recurring_pay_start_date; 
            $recurring_type=$val->recurring_type;
            $recurring_pay_type=$val->recurring_pay_type;
            $payment_type=$val->payment_type;
            $recurring_count_remain=$val->recurring_count_remain;
            $pay_status=$val->status;
            $invoice_id=$val->invoice_no;
            // echo $invoice_id;
            // echo '<br>';
            $recurring_count=$val->recurring_count;

            $row = array();

            $row[] = ucfirst($val->name);

            $amount = $val->amount - $val->late_fee;
            $row[] = '<span class="status_success">$'.number_format($amount,2).'</span>';

            $this->db->where('invoice_no',$invoice_id); 
            $curentDate=date('Y-m-d');
            $GetPrevResult=$this->db->query("SELECT * FROM customer_payment_request WHERE invoice_no='$invoice_id' AND ( `status`='$pay_status' OR `status`='pending' OR `status`='block' ) AND `recurring_pay_start_date` < '$curentDate' ORDER BY id DESC"); 
            $df=$GetPrevResult->result_array(); 
            $is_prev_paid=count($df);      

            $this->db->where('invoice_no',$invoice_id); 
            $GetFirstRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  invoice_no='$invoice_id'  ORDER BY id ASC  LIMIT 0,1 "); 
            $DGetFirstRecord=$GetFirstRecord->row_array();
            
            $merchant_id=$val->merchant_id;
            $GetlastRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE merchant_id='$merchant_id' AND  invoice_no='$invoice_id'  ORDER BY id DESC  LIMIT 0,1 "); 
            $lastRecord=$GetlastRecord->row();

            $GetAllpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND ( `status`='Chargeback_Confirm' OR  `status`='confirm')  ORDER BY id DESC ");

            $DGetAllpaidRecord=$GetAllpaidRecord->result();
            $AllPaidRequest=count($DGetAllpaidRecord);

            $GetAllUnpaidRecord=$this->db->query("SELECT * FROM customer_payment_request WHERE  merchant_id='$merchant_id' AND  invoice_no='$invoice_id' AND `status`!='Chargeback_Confirm' AND  `status`!='confirm'  ORDER BY id DESC "); 
            $DGetAllUnpaidRecord=$GetAllUnpaidRecord->result();
            $AllUnPaidRequest=count($DGetAllUnpaidRecord);

            $count++;

            // echo $AllPaidRequest.','.$val->recurring_count.','.$AllUnPaidRequest;
            // echo '<br>';
            if( $val->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($val->recurring_payment=='stop' || $val->recurring_payment=='complete' )  && $is_prev_paid <='0') { 
                $status_td = '<span class="status_success">Complete</span>';
            } else if( $val->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0'  && ($val->recurring_payment=='stop' || $val->recurring_payment=='complete' ) ) {
                $status_td = '<span class="badge badge-success">Complete</span>';


            } else if( $AllPaidRequest > 0  &&  $val->recurring_count != $AllPaidRequest && $AllUnPaidRequest == 0) {
                $status_td = '<span class="badge badge-secondary">Good Standing</span>';


            } else if($AllUnPaidRequest > '0' &&  $is_prev_paid >'0'){
                $status_td = '<span class="badge badge-danger">Late</span>';
            } else if($val->status == 'declined'){
                $status_td = '<span class="badge badge-danger">Declined</span>';
            } else {
                $status_td = '<span class="badge badge-warning">Pending</span>';
            }
            // echo $status_td;
            $row[] = $status_td;

            $row[] = date("M d Y", strtotime($val->recurring_pay_start_date));
            $row[] = date("M d Y", strtotime($val->recurring_next_pay_date));

            if($val->recurring_count < 0) {
                $row[] = '<span style="font-size: 25px;">&infin; </span>';

            } else {
                $recurring_count = $val->recurring_count-1;
                $recurring_type = $val->recurring_type;
                switch($recurring_type) {
                    case 'daily':
                        $new_recur_count = $recurring_count*1;
                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$new_recur_count." days", strtotime($val->recurring_next_pay_date)));
                    break;

                    case 'weekly':
                        $new_recur_count = $recurring_count*7;
                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$new_recur_count."days", strtotime($val->recurring_next_pay_date)));
                    break;

                    case 'biweekly':
                        $new_recur_count = $recurring_count*14; 
                        $recurring_next_pay_date=date('Y-m-d', strtotime('+'.$new_recur_count.' days', strtotime($val->recurring_next_pay_date)));
                    break;

                    case 'monthly':
                        $new_recur_count = $recurring_count*1; 
                        $recurring_next_pay_date=date('Y-m-d', strtotime('+'.$new_recur_count.' month', strtotime($val->recurring_next_pay_date)));
                    break;

                    case 'quarterly':
                        $new_recur_count = $recurring_count*3; 
                        $recurring_next_pay_date=date('Y-m-d', strtotime("+".$new_recur_count." month", strtotime($val->recurring_next_pay_date)));
                    break;

                    case 'yearly':
                        $new_recur_count = $recurring_count*12; 
                        $recurring_next_pay_date=date('Y-m-d', strtotime("+".$new_recur_count." month", strtotime($val->recurring_next_pay_date)));
                    break;

                    default :
                        $new_recur_count = $recurring_count*1; 
                        $recurring_next_pay_date=Date('Y-m-d', strtotime("+".$new_recur_count." days", strtotime($val->recurring_next_pay_date)));
                    break;
                }
                $row[] = date("M d Y", strtotime($recurring_next_pay_date));
            }

            $upcomming = ($val->recurring_count == -1) ? '<span style="font-size: 25px;">&infin; </span>' : $val->recurring_count_remain;

            $recurring_td = '<div style="display: flex;"><span class="status_success">'.$val->recurring_count_paid .'</span><span class="num_seprater" style="margin: 0 5px;">|</span><span class="pos_Status_pend">'.$upcomming.'</span></div>';

            $row[] = $recurring_td;

            if($val->recurring_count == $AllPaidRequest && $AllUnPaidRequest =='0' && ($val->recurring_payment=='stop' || $val->recurring_payment=='complete') && $is_prev_paid <='0') {
                $toggle_btn = '<a class="btn btn-sm payment_clear_btn"><i class="fa fa-check"></i> Done</a>';
            } else {
                $is_active = ($val->recurring_payment == 'start') ? 'active' : '';
                $is_checked = ($val->recurring_payment=='start') ? 'checked' : '';

                $toggle_btn = '<div class="start_stop_tax '.$is_active.'" rel="'.$val->id.'">
                    <label class="switch switch_type1" role="switch">
                        <input type="checkbox" class="switch__toggle" '.$is_checked.'>
                        <span class="switch__label">|</span>
                    </label>
                </div>';
            }

            $row[] = $toggle_btn;
            $row[] = ($val->recurring_pay_type == '1') ? 'Auto' : 'Manual';

            if($val->recurring_count_remain =='0') {
                $action_btn = '<a class="pos_vw_refund pos_Status_c badge-btn" href="'.base_url().'pos/invoice_details/'.$val->invoice_no.'"><span class="fa fa-eye"></span> Transactions</a>';
            } else {
                $edit_link = base_url().'editRecurring/edit_customer_request/'.$val->id;
                $refund_link = base_url().'pos/invoice_details/'.$val->invoice_no;

                $action_btn = '<div class="dropdown dt-vw-del-dpdwn">
                    <button type="button" data-toggle="dropdown">
                        <i class="material-icons"> more_vert </i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item pos_vw_refund" data-id="'.$val->id.'" href="'.$edit_link.'"><span class="fa fa-edit"></span> Edit</a>
                        <a class="dropdown-item pos_vw_refund" href="'.$refund_link.'"><span class="fa fa-exchange"></span> Transactions</a>
                    </div>
                </div>';
            }

            $row[] = $action_btn;

            $data[] = $row;
        }

        $recordsTotal = $this->recurring_serverside_model->count_all();
        $recordsFiltered = $this->recurring_serverside_model->count_filtered();

        // echo $recordsTotal.','.$recordsFiltered;die;

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}