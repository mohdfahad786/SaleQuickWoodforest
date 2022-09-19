<?php 
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Settlement_list extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('pos_model');
		$this->load->model('pos_settlement_model');
		$this->load->model('session_checker_model');
		if (!$this->session_checker_model->chk_session()) {
			redirect('admin');
		}
       
		date_default_timezone_set("America/Chicago");
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);
		
		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	}

	public function index() {
		$data["title"] = "Admin Panel";

		$getDashboard = $this->db->query("SELECT ( SELECT count(id) as NewTotalOrders from customer_payment_request where date_c = CURDATE()  ) as NewTotalOrders,  ( SELECT count(id) as TotalOrders from customer_payment_request where status='confirm' ) as TotalOrders, ( SELECT count(id) as TotalpendingOrders from customer_payment_request where status='pending' ) as TotalpendingOrders, (SELECT sum(amount) as TotalAmount from customer_payment_request where status='confirm' ) as TotalAmount ");

		$getDashboardData = $getDashboard->result_array();
		$data['getDashboardData'] = $getDashboardData;

		return $this->load->view('admin/dashboard', $data);

	}

	function my_encrypt($string, $action = 'e') {
		// you may change these values to your own
		$secret_key = '1@#$%^&s6*';
		$secret_iv = '`~ @hg(n5%';

		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if ($action == 'e') {
			$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
		} else if ($action == 'd') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}

	public function dateTimeConvertTimeZone($Adate) {
			
			date_default_timezone_set("UTC");
				$time_Zone='America/Chicago';
				//date_default_timezone_set('America/Chicago');
				//if($time_Zone!='America/Chicago'){
					$datetime = new DateTime($Adate);
					$la_time = new DateTimeZone($time_Zone);
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				// } else {
				// 	$convertedDateTime=$Adate;
				// }
				
				
			
			return $convertedDateTime; 
		}

	public function create_new_subadmin() {
		$data['meta'] = "Create New Subadmin";
		$data['loc'] = "create_new_subadmin";
		$data['action'] = "Create New Subadmin";

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[sub_admin.email]');
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|numeric|regex_match[/^[0-9]{10}$/]|is_unique[merchant.mob_no]');

			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password1 = $this->input->post('password') ? $this->input->post('password') : "";

			$password = $this->my_encrypt($password1, 'e');

			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			if ($this->form_validation->run() == FALSE) {
				$this->load->view("admin/add_subadmin", $data);
			} else {
				$today1 = date("Ymdhms");
				$today2 = date("Y-m-d");
				$unique = "OH" . $today1;
				$data = Array(

					'name' => $name,
					'email' => $email,
					'mob_no' => $mobile,
					'password' => md5($password),
					'view_permissions' => $view_permissions,
					'edit_permissions' => $edit_permissions,
					'delete_permissions' => $delete_permissions,
					'active_permissions' => $active_permissions,
					'status' => 'active',
				);

				$id = $this->admin_model->insert_data("sub_admin", $data);

				redirect("dashboard/all_subadmin");
			}
		} else {
			$this->load->view("admin/add_subadmin", $data);
		}

	}

	public function edit_subadmin() {

		$bct_id = $this->uri->segment(3);
		if (!$bct_id && !$this->input->post('submit')) {
			echo "<h2>Critical error.</h1><h3>No Data specified to edit</h3>";
			die;
		}
		$branch = $this->admin_model->get_subadmin_details($bct_id);
		if ($this->input->post('submit')) {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$email = $this->input->post('email') ? $this->input->post('email') : "";
			$name = $this->input->post('name') ? $this->input->post('name') : "";
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";
			$password = $this->input->post('password') ? $this->input->post('password') : "";
			$cpsw = $this->input->post('cpsw') ? $this->input->post('cpsw') : "";

			$view_permissions = $this->input->post('view_permissions') ? $this->input->post('view_permissions') : '0' . "";
			$edit_permissions = $this->input->post('edit_permissions') ? $this->input->post('edit_permissions') : '0' . "";
			$delete_permissions = $this->input->post('delete_permissions') ? $this->input->post('delete_permissions') : '0' . "";
			$active_permissions = $this->input->post('active_permissions') ? $this->input->post('active_permissions') : '0' . "";

			$password1 = $this->my_encrypt($cpsw, 'e');

			if ($cpsw != '') {
				$psw1 = $password1;
			} else {
				$psw1 = $password;
			}
			// echo md5($password);
			$branch_info = array(
				'name' => $name,
				'email' => $email,
				'mob_no' => $mobile,
				'password' => $psw1,
				'view_permissions' => $view_permissions,
				'edit_permissions' => $edit_permissions,
				'delete_permissions' => $delete_permissions,
				'active_permissions' => $active_permissions,

			);
			if ($this->form_validation->run() == FALSE) {
				//  $this->load->view("merchant/add_employee/" , $data);

				redirect(base_url() . 'admin/edit_subadmin/' . $id);
			} else {

				$this->admin_model->update_date_single($id, $branch_info);
				$this->session->set_userdata("mymsg", "Data Has Been Updated.");
				redirect('dashboard/all_subadmin');

				//  $this->load->view('admin/add_subadmin/'.$bct_id);
			}
		} else {
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email;
				$data['name'] = $sub->name;
				$data['mobile'] = $sub->mob_no;
				$data['password'] = $sub->password;

				$data['view_permissions'] = $sub->view_permissions;
				$data['edit_permissions'] = $sub->edit_permissions;
				$data['delete_permissions'] = $sub->delete_permissions;
				$data['active_permissions'] = $sub->active_permissions;

				break;
			}
		}
		$data['meta'] = "Update SubAdmin";
		$data['action'] = "Update Subadmin";
		$data['loc'] = "edit_subadmin";
		$this->load->view('admin/add_subadmin', $data);

	}

	public function all_subadmin() {

		$data = array();

		$package_data = $this->admin_model->get_full_details('sub_admin');

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;

			$package['view_permissions'] = $each->view_permissions;
			$package['edit_permissions'] = $each->edit_permissions;
			$package['delete_permissions'] = $each->delete_permissions;
			$package['active_permissions'] = $each->active_permissions;

			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$this->load->view('admin/all_subadmin', $data);
	}

	public function all_merchant() {

		$data = array();
		if ($this->input->post('mysubmit')) {

			$curr_payment_date = $_POST['curr_payment_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_package_details_merchant($curr_payment_date, $status);

		} else {

			$package_data = $this->admin_model->get_package_details("");
		}
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {

			$package['id'] = $each->id;
			$package['name'] = $each->name;
			$package['email'] = $each->email;
			$package['mob_no'] = $each->mob_no;

			//$package['date'] = $each->date;
			$package['status'] = $each->status;

			$mem[] = $package;
		}
		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$data['extraHeadContent'] = "
            <script language=\"javascript\">
            var XMLHttpRequestObject = false;
            if(window.XMLHttpRequest)
            {
              XMLHttpRequestObject = new XMLHttpRequest;
            }
            else if(window.ActiveXObject)
            {
              XMLHttpRequestObject = new ActiveXObject;
            }

            function delete_pak(sites_id)
            {
              var url = '" . base_url('dashboard/delete_package') . "/'+sites_id;
              XMLHttpRequestObject.open(\"POST\", url);
              XMLHttpRequestObject.onreadystatechange = function()
              {
                window.location.reload();
              }
              XMLHttpRequestObject.send();
            }

            function active_pak(sites_id)
            {
              var url = '" . base_url('dashboard/active_package') . "/'+sites_id;
              XMLHttpRequestObject.open(\"POST\", url);
              XMLHttpRequestObject.onreadystatechange = function()
              {
                window.location.reload();
              }
              XMLHttpRequestObject.send();
            }


</script>
          ";

		$this->load->view('admin/all_merchant', $data);
	}

	public function delete_package() {
		$pak_id = $this->uri->segment(3);

		if ($this->admin_model->delete_package($pak_id)) {
			$this->session->set_userdata("mymsg", "Data Has Been Deleted.");
		}

	}

	public function active_package() {
		$pak_id = $this->uri->segment(3);

		if ($this->admin_model->active_order($pak_id)) {
			$this->session->set_userdata("mymsg", "Merchant Active.");
		}

	}

	public function search_record_column() {
		$searchby = $this->input->post('id');

		$data['pay_report'] = $this->admin_model->search_record_un($searchby, 'merchant');
		echo $this->load->view('admin/show_result', $data, true);

	}

	public function pos_list_test() {
		$data = array();
		$_result = $this->pos_model->get_datatables_test();
		$_query = $_result['query'];
		echo $_query;die;
	}

	public function all_pos() {
		//echo date("Y-m-d");
		$data = array();
		$data['meta'] = 'Settlement List';
		$this->load->view('admin/all_pos_settlement', $data);
	}

	


	public function pos_list() {
		$data = array();
		$_result = $this->pos_settlement_model->get_datatables();
	   	 //echo '<pre>';print_r($_result);die;

		$pos_list = $_result['result'];
        
        $no = $_POST['start'];
		foreach ($pos_list as $pos) {
		 	$pos_transaction_id=$pos->transaction_id;
			$pos_invoice_no = $pos->invoice_no;
		 	if($pos->transaction_type == "split") {
		 		$get_item_data = $this->db->where('transaction_id', $pos_invoice_no)->get('adv_pos_cart_item')->num_rows();

		 		$transaction_id = $pos->invoice_no;
				$amount = $pos->full_amount;
				$card_no = "";
				$card_type = "SPLIT";
		 	} else {
				$get_item_data = $this->db->where('transaction_id', $pos_transaction_id)->get('adv_pos_cart_item')->num_rows();

				$transaction_id = $pos->transaction_id;
				$amount = $pos->amount;
				$card_no = $pos->card_no;
				$card_type = $pos->card_type;
		 	}

			if($get_item_data > 0) {
		 		$receipt_type='adv_pos_reciept';
		 		$refund_receipt_type='adv_pos_refund_reciept';
		 	} else {
		 		$receipt_type='pos_reciept';
		 		$refund_receipt_type='pos_refund_reciept';
		 	}

			$typeOfCard = strtolower($card_type);
			switch($typeOfCard) {
			   	case 'discover':
				 	$card_image='discover.png';
				 	break;
			   	case 'mastercard':
				 	$card_image='mastercard.png';
				 	break;
			   	case 'visa':
				 	$card_image='visa.png';
				 	break;
			   	case 'jcb':
				 	$card_image='jcb.png';
				 	break;
			   	case 'maestro':
				 	$card_image='maestro.png';
				 	break;
			   	case 'dci':
				 	$card_image = 'dci.png';
				 	break;
			   	case 'amex':
				 	$card_image='amx.png';
				 	break;
				case 'american express':
                    $card_image = 'amx.png';
                    break;
			   	default :
				 	$card_image='other.png';
			}
			if ($card_image == 'other.png') {
				if ($typeOfCard == "check") {
					$card_image = '<img src="'.base_url().'new_assets/img/check.png" alt="'.$card_type.'" style="display: inline; max-width: 35px;" >';
					$card_image .= ' ('.$pos->card_no.')';
				} else if($typeOfCard == "cash") {
					$card_image = '<img src="'.base_url().'new_assets/img/cash.png" alt="'.$card_type.'"  style="display: inline; max-width: 35px;">';
				} else {
					$card_image = $card_type;
				}
			} else {
				$card_image = '<img src="'.base_url().'new_assets/img/'.$card_image.'" alt="'.$card_type.'" style="display: inline; max-width: 35px;" > ';
				$card_image .= !empty($pos->card_no) ? ('****' . substr($pos->card_no, -4)) : '********';
			}
                				//for refund tarnsections
				if ($pos->status == 'Chargeback_Confirm') {
					$row = array();

					$merchant_name = $this->db->select('business_dba_name')->from('merchant')->where('id', $pos->merchant_id)->get()->row();
					$name = $merchant_name->business_dba_name;

					$row[] = $pos->refund_transaction_id;
					// $row[] = $pos->card_type;
					$row[] = '<span class="card-type-image" >'.$card_image.'</span>';
					$row[] = $name;
					// $row[] = $pos->mobile_no;
					$row[] = '<span class="status_success" >$' . number_format($pos->refund_amount, 2) . '</span>';

					$status = '<span class="status_refund"> Refund </span>';

					$row[] = $status;
					//$row[] = $pos->refund_date;
					//$row[] = date("M d Y h:i A", strtotime($pos->refund_date));
					//$row[] = date('M d Y h:i A', strtotime($pos->refund_date) - 60 * 60 * 6);

					$new_date=$this->dateTimeConvertTimeZone($pos->refund_date);
					//$row[] = date("M d Y h:i A", strtotime($new_date));
					$row[] = date("M d Y", strtotime($new_date));

					//$row[] = $this->dateTimeConvertTimeZone($pos->refund_date);
					if ($pos->status == 'pending') {
						$invoice_no = ' <a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank" class="dropdown-item"><i class="ti-receipt"></i> Invoice</a>';
					} elseif ($pos->status == 'confirm') {
						$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>';
					} elseif ($pos->status == 'Chargeback_Confirm') {
						$invoice_no = '<a href="'.base_url().$refund_receipt_type.'/'. $pos->invoice_no . '/' . $pos->merchant_id .'" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>
	                        </a>';
					} else {
						$invoice_no = '';
					}

					if($invoice_no != '') {
						$row[] = '<div class="dropdown dt-vw-del-dpdwn"> <button type="button" data-toggle="dropdown"> <i class="material-icons"> more_vert </i> </button> <div class="dropdown-menu dropdown-menu-right">'
							.$invoice_no.
							'<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="dropdown-item"><i class="ti-eye"></i> Detail</a>'
							.'</div> </div>';
					} else {
						// $row[] = $invoice_no;
						$row[] = '<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="pos_Status_c badge-btn"><i class="ti-eye"></i> Detail</a>';
					}
					$data[] = $row;
				}
			// if($pos->merchant_id != '413') {
				if ($this->input->post('status') != "Chargeback_Confirm") {
					$row = array();
					// $merchant_name = $this->admin_model->data_get_where_1('merchant', array('id' => $pos->merchant_id));
					
					$row[] = $transaction_id;
					// $row[] = $pos->card_type;
					$row[] = '<span class="card-type-image" >'.$card_image.'</span>';
					$row[] = $pos->business_dba_name;
					// $row[] = $pos->mobile_no;
					$row[] = '<span class="status_success" >$' . number_format($amount, 2) . '</span>';
					if ($pos->status == 'pending') {
						$status = '<span class="status_refund"> ' . $pos->status . '  </span>';
					} elseif ($pos->status == 'confirm' || $pos->status == 'Chargeback_Confirm') {
						$status = '<span class="pos_Status_c"> Confirm </span>';
					} elseif ($pos->status == 'declined') {
						$status = '<span class="pos_Status_cncl"> Declined </span>';
					} else {
						$status = '';
					}
					$row[] = $status;
					$new_date=$this->dateTimeConvertTimeZone($pos->add_date);
					//$row[] = date("M d Y h:i A", strtotime($new_date));
					$row[] = date("M d Y", strtotime($new_date));

					//$row[] = date("M d Y h:i A", strtotime($newdate));
					//$row[] = date('M d Y h:i A', strtotime($pos->add_date) - 60 * 60 * 6);
					
					//$row[] ='ee';
	                
					if ($pos->status == 'pending') {
						$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank"  class="dropdown-item"><i class="fa fa-eye"></i> Invoice
	                         </a>';
					} elseif ($pos->status == 'confirm') {
						$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank"  class="dropdown-item"><i class="fa fa-eye"></i> Receipt
	                        </a>';
					}
					elseif ($pos->status == 'Chargeback_Confirm') {
						$invoice_no = '<a href="'.base_url().$receipt_type.'/'. $pos->invoice_no . '/' . $pos->merchant_id .'" target="_blank"  class="dropdown-item"><i class="fa fa-eye"></i> Receipt
					        </a>';
					} 
					else {
						$invoice_no = '';
					}
					if($invoice_no != ''){
						$row[] = '<div class="dropdown dt-vw-del-dpdwn"> <button type="button" data-toggle="dropdown"> <i class="material-icons"> more_vert </i> </button> <div class="dropdown-menu dropdown-menu-right">'
							.$invoice_no.
							'<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="dropdown-item"><i class="fa fa-eye"></i> Detail</a>'
							.'</div> </div>';
					}
					else{
						$row[] = '<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="pos_Status_c badge-btn"><i class="fa fa-eye"></i> Detail</a>';
					}
					$data[] = $row;
				}


			// }
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pos_settlement_model->count_all(),
			"recordsFiltered" => $this->pos_settlement_model->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	//POS Listing
	public function pos_list_original() {
	   // echo '<pre>';print_r($_POST);die;
		$data = array();
		$_result = $this->pos_model->get_datatables();
		$pos_list = $_result['result'];
        // echo json_encode($_result['query']); die; 
          //echo '<pre>';print_r($pos_list);die; //echo json_encode($pos_list);die;
		$no = $_POST['start'];
		foreach ($pos_list as $pos) {
                        //echo $pos->refund_amount;die;
		 	$pos_transaction_id=$pos->transaction_id;
			$pos_invoice_no = $pos->invoice_no;
		 	if($pos->transaction_type == "split") {
		 		$get_item_data = $this->admin_model->check_pos_optimized_inv('adv_pos_cart_item',$pos_invoice_no);
		 	} else {
				$get_item_data = $this->admin_model->check_pos_optimized_inv('adv_pos_cart_item',$pos_transaction_id);
		 	}
			if(count($get_item_data)  > 0 ){ $receipt_type='adv_pos_reciept'; }else{ $receipt_type='pos_reciept'; }
			if(count($get_item_data)  > 0 ){ $refund_receipt_type='adv_pos_refund_reciept'; }else{ $refund_receipt_type='pos_refund_reciept'; }
			if ($pos->transaction_type == "split") {
				$transaction_id = $pos->invoice_no;
				$amount = $pos->full_amount;
				$card_no = "";
				$card_type = "SPLIT";

			} else {
				$transaction_id = $pos->transaction_id;
				$amount = $pos->amount;
				$card_no = $pos->card_no;
				$card_type = $pos->card_type;
			}
			$typeOfCard = strtolower($card_type); 
			switch($typeOfCard) {
			   	case 'discover':
				 	$card_image='discover.png';
				 	break;
			   	case 'mastercard':
				 	$card_image='mastercard.png';
				 	break;
			   	case 'visa':
				 	$card_image='visa.png';
				 	break;
			   	case 'jcb':
				 	$card_image='jcb.png';
				 	break;
			   	case 'maestro':
				 	$card_image='maestro.png';
				 	break;
			   	case 'dci':
				 	$card_image = 'dci.png';
				 	break;
			   	case 'amex':
				 	$card_image='amx.png';
				 	break;
			   	default :
				 	$card_image='other.png';
			}
			if ($card_image == 'other.png') {
				if ($typeOfCard == "check") {
					$card_image = '<img src="'.base_url().'new_assets/img/check.png" alt="'.$card_type.'" style="display: inline; max-width: 35px;" >';
					$card_image .= ' ('.$pos->card_no.')';
				} else if($typeOfCard == "cash") {
					$card_image = '<img src="'.base_url().'new_assets/img/cash.png" alt="'.$card_type.'"  style="display: inline; max-width: 35px;">';
				} else {
					$card_image = $card_type;
				}
			} else {
				$card_image = '<img src="'.base_url().'new_assets/img/'.$card_image.'" alt="'.$card_type.'" style="display: inline; max-width: 35px;" > ';
				$card_image .= !empty($pos->card_no) ? ('****' . substr($pos->card_no, -4)) : '********';
			}
			if ($this->input->post('status') != "Chargeback_Confirm") {
				$row = array();
				$merchant_name = $this->admin_model->data_get_where_1('merchant', array('id' => $pos->merchant_id));
				// echo "<pre>";print_r($merchant_name);
				foreach ($merchant_name as $key => $value) {
					$name = $value['business_dba_name'];
				}
				
				$row[] = $transaction_id;
				// $row[] = $pos->card_type;
				$row[] = '<span class="card-type-image" >'.$card_image.'</span>';
				$row[] = $name;
				// $row[] = $pos->mobile_no;
				$row[] = '<span class="status_success" >$' . number_format($amount, 2) . '</span>';
				if ($pos->status == 'pending') {
					$status = '<span class="status_refund"> ' . $pos->status . '  </span>';
				} elseif ($pos->status == 'confirm' || $pos->status == 'Chargeback_Confirm') {
					$status = '<span class="pos_Status_c"> Confirm </span>';
				} elseif ($pos->status == 'declined') {
					$status = '<span class="pos_Status_cncl"> Declined </span>';
				} else {
					$status = '';
				}
				$row[] = $status;
				//$newdate = $this->dateTimeConvertTimeZone($pos->add_date);
				//$row[] = date("M d Y h:i A", strtotime($newdate));
				$row[] = date('M d Y h:i A', strtotime($pos->add_date) - 60 * 60 * 5);
				
				//$row[] ='ee';
                
				if ($pos->status == 'pending') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank"  class="dropdown-item"><i class="	ti-receipt"></i> Invoice
                         </a>';
				} elseif ($pos->status == 'confirm') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank"  class="dropdown-item"><i class="fa fa-eye"></i> Receipt
                        </a>';
				}
				elseif ($pos->status == 'Chargeback_Confirm') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/'. $pos->invoice_no . '/' . $pos->merchant_id .'" target="_blank"  class="dropdown-item"><i class="fa fa-eye"></i> Receipt
				        </a>';
				} 
				else {
					$invoice_no = '';
				}
				if($invoice_no != ''){
					$row[] = '<div class="dropdown dt-vw-del-dpdwn"> <button type="button" data-toggle="dropdown"> <i class="material-icons"> more_vert </i> </button> <div class="dropdown-menu dropdown-menu-right">'
						.$invoice_no.
						'<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="dropdown-item"><i class="ti-eye"></i> Detail</a>'
						.'</div> </div>';
				}
				else{
					$row[] = '<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="pos_Status_c badge-btn"><i class="ti-eye"></i> Detail</a>';
				}
				$data[] = $row;
			}

			//for refund tarnsections

			if ($pos->status == 'Chargeback_Confirm') {
				$row = array();
				$merchant_name = $this->admin_model->data_get_where_1('merchant', array('id' => $pos->merchant_id));
				// echo "<pre>";print_r($merchant_name);
				foreach ($merchant_name as $key => $value) {
					$name = $value['business_dba_name'];
				}
				$row[] = $pos->refund_transaction_id;
				// $row[] = $pos->card_type;
				$row[] = '<span class="card-type-image" >'.$card_image.'</span>';
				$row[] = $name;
				// $row[] = $pos->mobile_no;
				$row[] = '<span class="status_success" >$' . number_format($pos->refund_amount, 2) . '</span>';

				$status = '<span class="status_refund"> Refund </span>';

				$row[] = $status;
				//$row[] = $pos->refund_date;
				//$row[] = date("M d Y h:i A", strtotime($pos->refund_date));
				$row[] = date('M d Y h:i A', strtotime($pos->refund_date) - 60 * 60 * 5);
				if ($pos->status == 'pending') {
					$invoice_no = ' <a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank" class="dropdown-item"><i class="ti-receipt"></i> Invoice</a>';
				} elseif ($pos->status == 'confirm') {
					$invoice_no = '<a href="'.base_url().$receipt_type.'/' . $pos->invoice_no . '/' . $pos->merchant_id . '" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>';
				}
				elseif ($pos->status == 'Chargeback_Confirm') {
					$invoice_no = '<a href="'.base_url().$refund_receipt_type.'/'. $pos->invoice_no . '/' . $pos->merchant_id .'" target="_blank" class="dropdown-item"><i class="fa fa-eye"></i> Receipt</a>
                        </a>';
				}
				else {
					$invoice_no = '';
				}
				if($invoice_no != ''){
					$row[] = '<div class="dropdown dt-vw-del-dpdwn"> <button type="button" data-toggle="dropdown"> <i class="material-icons"> more_vert </i> </button> <div class="dropdown-menu dropdown-menu-right">'
						.$invoice_no.
						'<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="dropdown-item"><i class="ti-eye"></i> Detail</a>'
						.'</div> </div>';
				}
				else{
					// $row[] = $invoice_no;
					$row[] = '<a href="#" data-toggle="modal" data-target="#view-modal" data-id="' . $pos->id . '" id="getUser" class="pos_Status_c badge-btn"><i class="ti-eye"></i> Detail</a>';
				}
				$data[] = $row;
			}
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pos_model->count_all(),
			"recordsFiltered" => $this->pos_model->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	public function dateTimeConvertTimeZone11($Adate) {
			if($this->session->userdata('time_zone'))
			{
			$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
			date_default_timezone_set('America/Chicago');
				
			$datetime = new DateTime($Adate);
			$la_time = new DateTimeZone($time_Zone);
			$datetime->setTimezone($la_time);
			$convertedDateTime=$datetime->format('Y-m-d H:i:s');
			
			}
			else
			{
			$convertedDateTime=$Adate;
			}
			return $convertedDateTime; 
	}

	public function all_pos_original() {
		$data = array();
		$data['meta'] = 'Point Of Sale List';

		if ($this->input->post('mysubmit')) {
			$start_date1 = $_POST['start_date'];
			$end_date1 = $_POST['end_date'];

			if (!empty($start_date1)) {
				$start_date = $_POST['start_date'];
			} else {
				$start_date = date("Y-m-d", strtotime("-29 days"));
			}
			if (!empty($end_date1)) {
				$end_date = $_POST['end_date'];
			} else {
				$end_date = date("Y-m-d");
			}
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_search_merchant_pos_new_admin($start_date, $end_date, $status, 'pos');
			
                        
		} else {
			$package_data = $this->admin_model->get_full_details_pos_new_admin('pos');
            //echo '<pre>';print_r($package_data);die;
		}

		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			$package['id'] = $each->id;
			$package['payment_id'] = $each->invoice_no;
			$package['name'] = $each->name;
			$package['merchant_id'] = $each->merchant_id;
			$package['email'] = $each->email_id;
			$package['mobile'] = $each->mobile_no;
			$package['amount'] = $each->amount;
			$package['date'] = $this->dateTimeConvertTimeZone($each->add_date);
			$package['status'] = $each->status;
			$package['transaction_id'] = $each->transaction_id;
			$package['card_type'] = $each->card_type;

			$mem[] = $package;
            //echo '<pre>';print_r($package);die;
		}
		//array_multisort(array_column($mem, 'date'), SORT_ASC, $mem);
		$data['mem'] = $mem;
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');

		// $this->load->view('admin/all_pos_new', $data);
		$this->load->view('admin/all_pos_dash', $data);
	}

	public function all_pos_new() {

		$data = array();
		//$merchant_id = $this->session->userdata('merchant_id');
		if (isset($_POST['mysubmit'])) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->admin_model->get_search_merchant_pos($start_date, $end_date, $status,"", 'pos');
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		} else {
			
             $refund_data = $this->admin_model->get_full_refund_data('pos',"");
			// $refund_data = $this->admin_model->get_full_re_data('pos');
			$package_data = $this->admin_model->get_full_details_pos('pos',""); 
			
		}

		// echo $this->db->last_query();  die; 
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			if( $each->receipt_type==null )  // no-cepeipt
			{
				if($each->mobile_no && $each->email_id)
				{
                     $repeiptmethod=$each->mobile_no;
				} 	
				else if($each->mobile_no!="" &&  $each->email_id=="")
				{
					$repeiptmethod=$each->mobile_no;
				}
				else if($each->mobile_no=="" &&  $each->email_id!="")
				{
					$repeiptmethod=$each->email_id;
				}
				else{
					$repeiptmethod='no-receipt';
				}
			        
			}
			else  if($each->receipt_type=='no-cepeipt')
			{
				$repeiptmethod='no-receipt';
			}
			else 
			{
				$repeiptmethod=$each->receipt_type; 
			}
            $each->add_date=$this->dateTimeConvertTimeZone($each->add_date);
			$package['id'] = $each->id;
			$package['transaction_id'] = $each->transaction_id;
			$package['mpayment_id'] = $each->payment_id;
			$package['invoice_no'] = $each->invoice_no;
			$package['merchant_id'] = $each->merchant_id;
			$package['name'] = $each->name;
			$package['email'] = $each->email_id;
			$package['repeiptmethod'] = $repeiptmethod;
			$package['c_type'] = $each->c_type;
			$package['amount'] = $each->amount;
			$package['date'] = $each->add_date;
			$package['status'] = $each->status;
			$package['card_no'] = $each->card_no;
			$package['card_type'] = $each->card_type;
			$mem[] = $package;

		}

		if (isset($refund_data)) {
			foreach ($refund_data as $each) {
				$each->refund_dt=$this->dateTimeConvertTimeZone($each->refund_dt);
				if ($each->status == 'Chargeback_Confirm') {

					$package['id'] = $each->id;
					$package['transaction_id'] = $each->refund_transaction;
					$package['mpayment_id'] = $each->payment_id;
					$package['invoice_no'] = $each->invoice_no;
					$package['merchant_id'] = $each->merchant_id;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['repeiptmethod'] = $each->mobile_no;
					$package['c_type'] = $each->c_type;
					$package['refund_row_id']=$each->refund_row_id;
					//$package['transaction_id'] = $each->transaction_id;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					$package['date'] = $each->refund_dt;
					$package['status'] = "Refund";
					$mem[] = $package;
				}
			}
		}
		array_multisort(array_column($mem, 'date'), SORT_DESC, $mem);

		//print_r(count($mem));  die('j'); 

		$data['mem'] = $mem;
		$data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		$this->session->unset_userdata('mymsg');

		$this->load->view('admin/all_pos_transaction', $data);
	}

	public function search_record_column_pos() {
		$searchby = $this->input->post('id');

		//$data['item'] = $this->admin_model->data_get_where_1("pos", array("id" => $searchby));
		// $data['item'] = $this->admin_model->search_item($searchby);
		$data['pay_report'] = $this->admin_model->search_record_pos($searchby);
		echo $this->load->view('admin/show_result_pos', $data, true);
	}


	public function all_ecommerce() {
		$data = array();
		// $merchant_id = $this->session->userdata('merchant_id');
		// $merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		if ($this->input->post('mysubmit')) {

			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			
			if ($status == "Chargeback_Confirm") {
				// $refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
				$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount,r.id as refund_row_id, r.transaction_id as refund_transaction');
				$this->db->from("refund r");
				$this->db->where('r.date_c >=', $start);
				$this->db->where('r.date_c <=', $end);
				$this->db->where('mt.status', $status);
				// $this->db->where('r.merchant_id', $merchant_id);
				$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
				$this->db->order_by("r.id", "desc");
				$refund_data = $this->db->get()->result();

			} else {
				// $package_data = $this->admin_model->get_search_merchant_pos_paid_list_wb($start_date, $end_date, $status, $merchant_id, 'pos','yes');
				if ($start_date != '') {
					$this->db->where('date_c >=', $start_date);
					$this->db->where('date_c <=', $end_date);
				} else if ($start_date==$end_date) {
					$this->db->where('date_c', $end_date);
				} else {
					$date = date('Y-m-d', strtotime('-30 days'));
					$this->db->where('date_c >=', $date);
					$this->db->where('date_c <=', date('Y-m-d'));
				}

				if ($status != '') {
					//$this->db->where('status', $status OR status ='Chargeback_Confirm');
					$this->db->where("(status ='" .trim($status)."' OR status ='Chargeback_Confirm' )");
					//$this->db->or_where('status', 'Chargeback_Confirm');
				}
				$this->db->where('woocommerce', 'yes');
				// if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
				$this->db->order_by("id", "desc");
				$package_data = $this->db->get('pos')->result();

				if($status==''){
				    $refund_data = [];
			    }   
			}
						
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
					
		} elseif ($this->input->post('search_Submit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			
			if ($status == "Chargeback_Confirm") {
				// $refund_data = $this->admin_model->get_search_refund_data('pos', $merchant_id, $start_date, $end_date, $status);
				$this->db->select('mt.*,r.add_date as refund_dt,r.amount as refund_amount,r.id as refund_row_id, r.transaction_id as refund_transaction');
				$this->db->from("refund r");
				$this->db->where('r.date_c >=', $start);
				$this->db->where('r.date_c <=', $end);
				$this->db->where('mt.status', $status);
				// $this->db->where('r.merchant_id', $merchant_id);
				$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
				$this->db->order_by("r.id", "desc");
				$refund_data = $this->db->get()->result();

			} else {
				// $package_data = $this->admin_model->get_search_merchant_pos_wb($start_date, $end_date, $status, $merchant_id, 'pos','yes');
				if ($start_date != '') {
					$this->db->where('date_c >=', $start_date);
					$this->db->where('date_c <=', $end_date);
				} else if ($start_date==$end_date) {
					$this->db->where('date_c', $end_date);
				} else {
					$date = date('Y-m-d', strtotime('-30 days'));
					$this->db->where('date_c >=', $date);
					$this->db->where('date_c <=', date('Y-m-d'));
				}
				if ($status != '') {
					$this->db->where('status', $status);
				}
				$this->db->where('woocommerce', 'yes');
				// if($merchant_id!=""){ $this->db->where('merchant_id', $merchant_id); }
				$this->db->order_by("id", "desc");
				$package_data = $this->db->get('pos')->result();

				if($status=='') {
				    $refund_data = [];
			    }   
			}
		
			// $refund_data_search = $this->Inventory_model->get_full_refund_data_search_pdf($start_date, $end_date,'pos', $merchant_id);
			$this->db->select('mt.*,r.id as refund_row_id,r.add_date as refund_dt,r.amount as refund_amount, r.transaction_id as refund_transaction');
			$this->db->from("refund r");
			$this->db->where('r.date_c >=', $start_date);
			$this->db->where('r.date_c <=', $end_date);
			// if($merchant_id!=""){ $this->db->where('r.merchant_id', $merchant_id); }
			$this->db->join('pos mt', 'mt.invoice_no = r.invoice_no');
			$refund_data_search = $this->db->get()->result_array();
			
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
		
		} else {
			// $package_data = $this->admin_model->get_full_details_pos_wb('pos', $merchant_id,'yes');
			$date = date('Y-m-d', strtotime('-30 days'));
			// if($merchant_id!="") {
			// 	$this->db->where('merchant_id', $merchant_id);
			// }
			$this->db->where('status !=', 'pending');
			$this->db->where('date_c >=', $date);
			$this->db->where('woocommerce', 'yes');
			$this->db->order_by("id", "desc");
			$this->db->group_by("invoice_no");
			$package_data = $this->db->get('pos')->result();

			$refund_data = [];
			$data['status'] = 'confirm';
		}
		
		$mem = array();
		$member = array();
		if (isset($package_data)) {
			foreach ($package_data as $each) {
				if ($each->receipt_type == null) // no-cepeipt
				{
					if ($each->mobile_no && $each->email_id) {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no != "" && $each->email_id == "") {
						$repeiptmethod = $each->mobile_no;
					} else if ($each->mobile_no == "" && $each->email_id != "") {
						$repeiptmethod = $each->email_id;
					} else {
						$repeiptmethod = 'no-receipt';
					}

				} else if ($each->receipt_type == 'no-cepeipt') {
					$repeiptmethod = 'no-receipt';
				} else {
					$repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
				}

				$pyadate=str_replace("-","",$each->express_transactiondate);
				$paytime=str_replace(":","",$each->express_transactiontime);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				
					$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;
			    	//$TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
			    		$TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date);
				} else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($each->add_date);
				}
				
				$package['id'] = $each->id;
				$package['refund_row_id'] = "";
				$package['transaction_id'] = $each->transaction_id;
				$package['name'] = $each->name;
				$package['email'] = $each->email_id;
				$package['repeiptmethod'] = $repeiptmethod;
				$package['c_type'] = $each->c_type;
				$package['amount'] = $each->amount;
				//$package['amount'] = $each->refund_amount;
				$package['date'] =  $TransactiondateTime;  // $TransactiondateTime; 
				$package['status'] = $each->status;
				$package['card_no'] = $each->card_no;
				$package['card_type'] = $each->card_type;
				$package['transaction_type'] = $each->transaction_type;
				if ($each->transaction_type == "split") {
					$package['transaction_id'] = $each->invoice_no;
					$package['amount'] = $each->full_amount;
					$package['card_no'] = "";
					$package['card_type'] = "SPLIT";

				} else {
					$package['transaction_id'] = $each->transaction_id;
					$package['amount'] = $each->amount;
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
				}
				$mem[] = $package;

			}
		}

		// echo '1111';print_r($refund_data);
        
		if (isset($refund_data)) {
			foreach ($refund_data as $each) {
				if ($each->status == 'Chargeback_Confirm') {
					if ($each->receipt_type == null) // no-cepeipt
					{
						if ($each->mobile_no && $each->email_id) {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no != "" && $each->email_id == "") {
							$repeiptmethod = $each->mobile_no;
						} else if ($each->mobile_no == "" && $each->email_id != "") {
							$repeiptmethod = $each->email_id;
						} else {
							$repeiptmethod = 'no-receipt';
						}

					} else if ($each->receipt_type == 'no-cepeipt') {
						$repeiptmethod = 'no-receipt';
					} else {
						$repeiptmethod = (!empty($each->mobile_no)) ? $each->mobile_no : $each->email_id;
					}

					$newdate=$this->dateTimeConvertTimeZone($each->refund_dt);
					
					$package['id'] = $each->id;
					$package['refund_row_id'] = $each->refund_row_id;
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['repeiptmethod'] = $repeiptmethod;
					$package['c_type'] = $each->c_type;
					$package['transaction_id'] = $each->refund_transaction;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					$package['date'] =$newdate;
					$package['status'] = "Refund";
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
					$mem[] = $package; 
				}
			}
		}
		array_multisort(array_column($mem, 'date'), SORT_DESC, $mem);
		// echo '<pre>'; print_r($mem) ; die; 
		$data['mem'] = $mem;
	
		// $data['merchant_data'] = $merchant_data;
		$data['meta'] = 'Ecommerce Transactions';
		
		$this->load->view('merchant/header_dash_list', $data);
		$this->load->view('admin/all_pos_ecom_dash', $data);
		$this->load->view('merchant/footer_dash_list', $data);
	}

}

?>
