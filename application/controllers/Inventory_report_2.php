<?php 
	ini_set('MAX_EXECUTION_TIME', '-1');
	ini_set('memory_limit','2048M');
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Inventory_report extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('profile_model'); 
			$this->load->model('admin_model');
			$this->load->model('Inventory_model');
			$this->load->model('Inventory_graph_model');
			$this->load->model('Home_model');
			$this->load->library('email');
			$this->load->helper('pdf_helper');
			$this->load->model('customers_model', 'customers');

			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'America/Chicago';
				date_default_timezone_set($time_Zone);
			}
			else
			{
				date_default_timezone_set('America/Chicago');
			}
			// ini_set('display_errors', 1);
          	// error_reporting(E_ALL);
		    //ini_set('max_execution_time', -1);
		}

		public function dateTimeConvertTimeZone($Adate) {
			date_default_timezone_set("UTC");
			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'America/Chicago';
					$datetime = new DateTime($Adate);
					$la_time = new DateTimeZone($time_Zone);
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
			
				
			} else {
				$convertedDateTime=$Adate;
			}
			return $convertedDateTime; 
		}

		public function index() {
			$data['title']='Merchant || Inventory Report';
			$data['meta']='Inventory Report';
			$merchant_id = $this->session->userdata('merchant_id');
			$data['getInventry_main_items']= $this->admin_model->get_all_inventry_category($merchant_id);
			// echo $this->db->last_query();die;
			// echo '<pre>';print_r($data['getInventry_main_items']);die;

			$this->load->view('merchant/inventoryreport_dash', $data);
		}

		public function get_inventory_list() {
			// echo '<pre>';print_r($_POST);die;

	        $data = $row = array();
			$this->load->model('Inventory_report_model');
			$merchant_id = $this->session->userdata('merchant_id');
			// $data["start_date"] = $_POST['start_date'];
			// $data["end_date"] =  $_POST['end_date'];
			$main_items = $_POST['main_items'];

			$start_date = $_POST['start_date'];
			$end_date =  $_POST['end_date'];
			if( ($start_date != '') ) {
				$start_date = date('Y-m-d', strtotime($start_date));
				$end_date = date('Y-m-d', strtotime($end_date));
				
			} else {
				$start_date = '';
				$end_date = '';
			}
			// echo $start_date.','$end_date;die;

			$data = array();
			// $merchant_id = $this->session->userdata('merchant_id');
			// $getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
			// $data['merchantdata'] = $getQuery1->result_array();

			// echo '<pre>';print_r($memData);die;
			// $start_date = $_POST['start_date'];
			// $end_date = $_POST['end_date'];
			// $main_items = $_POST['main_items'];

			$start_date1 = $start_date.' 00:00:01';
			$end_date1 = $end_date.' 23:59:59';
			$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
    	    $end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

			$package_data = $this->Inventory_report_model->get_full_inventory_spreportdata($start_date1, $end_date1,$main_items,$merchant_id);
			//print_r($package_data);
			// echo $this->db->last_query();
			//die;

			$package_data_no_main_item = $this->Inventory_report_model->get_full_inventory_reportdata_main_no_main_item($start_date1, $end_date1,$merchant_id,$main_items);
			$package_data_mis_item = $this->Inventory_report_model->get_full_inventory_reportdata_mis_item($start_date1, $end_date1,$merchant_id,$main_items);
			// echo '<pre>';print_r($package_data_mis_item);die;

			$mem = array();
			foreach ($package_data as $each) {
				if(count($each) > 0) {
		            $each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
					
					$package['item_id'] = $each->item_id;
					$package['main_item_id'] = $each->main_item_id;
					$package['mname'] = $each->mname;
					$package['merchant_id'] = $merchant_id;
					$package['price'] = $each->price;
					$package['tax_value'] = $each->tax_value;
					$package['tax_value1'] = $each->tax_value1;
					$package['sku'] = $each->sku;
					$package['new_price'] = $each->new_price;
					$package['quantity'] = $each->quantity;
					$package['cat_name'] = $each->cat_name;
					$package['status'] = $each->status;
					$package['discount'] = $each->discount;
					$package['date'] = $each->created_at;
					$package['updated_at'] = $each->updated_at;
					$package['rowtype'] ="parent";
					$package['sold_price'] = $each->sold_price;
					// $package['tax'] = $each->tax;
					$package['item_name'] = $each->item_name;
					$package['base_price'] = $each->base_price;
					$package['item_image'] = $each->item_image;
					$package['item_title'] = $each->item_title;
					$mem[] = $package;
				}
			}
			// $data['mem'] = $mem;
	        
	        $i = $_POST['start'];
	        if(!empty($package_data_no_main_item)) {
	        	foreach ($package_data_no_main_item as $a_data) {
	        		$i++;
		        	$row = array();
		        	$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';

		            if($a_data['item_image']!='') {
                        $image = 'https://salequick.com/uploads/item_image/'.$a_data['item_image'];
                    } else {
                    	$image = base_url('new_assets/img/no-image.png');
                    }
		            $row[] = '<img src="'.$image.'" style="width:40px !important;height:40px !important;border-radius: 10px !important;">';
		            $row[] = Ucfirst($a_data['mname']);
		            $row[] = $a_data['sku'];
		            $row[] = ($a_data['quantity']=='I') ? "<span style='font-size:20px;'><b> &infin; </b></span>" : $a_data['quantity'];
		            $row[] = (!empty($a_data['sold_price'])) ? '$ '.number_format(($a_data['sold_price']),2) : '$ 0.00';
		            $row[] = ($a_data["discount"]!="") ? '$ '.number_format(str_replace("-",'', $a_data['discount']),2) : '$ 0.00';
		            $row[] = $a_data['tax_value1'] ? number_format($a_data['tax_value1'],2).'%' : '0.00%';
		            $row[] = $a_data['sold_price'] ? '$ '.number_format(($a_data['sold_price']+$tax_fixed)-$a_data['discount'],2) : '$ 0.00';

		            $data[] = $row;
	        	}
	        }

	        if(!empty($package_data_mis_item)) {
	        	foreach ($package_data_mis_item as $a_data) {
	        		$row = array();
	        		$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';

		            if($a_data['item_image']!='') {
                        $image = 'https://salequick.com/uploads/item_image/'.$a_data['item_image'];
                    } else {
                    	$image = base_url('new_assets/img/no-image.png');
                    }
		            $row[] = '<img src="'.$image.'" style="width:40px !important;height:40px !important;border-radius: 10px !important;">';
		            $row[] = Ucfirst($a_data['mname']);
		            $row[] = $a_data['sku'];
		            $row[] = ($a_data['quantity']=='I') ? "<span style='font-size:20px;'><b> &infin; </b></span>" : $a_data['quantity'];
		            $row[] = (!empty($a_data['sold_price'])) ? '$ '.number_format(($a_data['sold_price']),2) : '$ 0.00';
		            $row[] = ($a_data["discount"]!="") ? '$ '.number_format(str_replace("-",'', $a_data['discount']),2) : '$ 0.00';
		            $row[] = $a_data['tax_value1'] ? number_format($a_data['tax_value1'],2).'%' : '0.00%';
		            $row[] = $a_data['sold_price'] ? '$ '.number_format(($a_data['sold_price']+$tax_fixed)-$a_data['discount'],2) : '$ 0.00';

		            $data[] = $row;
	        	}
	        }

	        if(!empty($mem)) {
	        	foreach ($mem as $a_data) {
	        		$row = array();

		            if($a_data['item_image']!='') {
                        $image = 'https://salequick.com/uploads/item_image/'.$a_data['item_image'];
                    } else {
                    	$image = base_url('new_assets/img/no-image.png');
                    }

                    $tax_fixed1 = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
                    $tax_fixed =  $tax_fixed1*$a_data['quantity'];

		            $row[] = '<img src="'.$image.'" style="width:40px !important;height:40px !important;border-radius: 10px !important;">';
		            $row[] = Ucfirst($a_data['mname']);
		            $row[] = $a_data['sku'];
		            $row[] = ($a_data['quantity']=='I') ? "<span style='font-size:20px;'><b> &infin; </b></span>" : $a_data['quantity'];

		             $row[] = '';

		           // $row[] = (!empty($a_data['sold_price'])) ? '$ '.number_format(($a_data['sold_price']),2) : '$ 0.00';
		            $row[] = '';
		            $row[] = '';

		            $row[] = '';

		            $data[] = $row;

		            $parent = $this->Inventory_model->get_full_inventory_reportdata($start_date1, $end_date1,$a_data['merchant_id'],$a_data['main_item_id']);

		            if(!empty($parent)) {
		            	foreach ($parent as $parent_Data) {
			            	if(strtolower($parent_Data['item_title'])!='regular') {
			            		$row = array();
			            		$tax_fixed = ($parent_Data['tax_value1'] > 0) ? (($parent_Data['sold_price']*$parent_Data['tax_value1'])/100) : '0';

			            		$row[] = '';
					            $row[] = (Ucfirst($parent_Data['item_title'])!='Regular') ? '<span style="margin-left:20px;">-</span>'.Ucfirst($parent_Data['item_title']) : ( (Ucfirst($parent_Data['item_title'])=='Regular') ? '<span style="margin-left:20px;">-</span>'.Ucfirst($parent_Data['item_name']) : '' );
					            $row[] = '';
					            $row[] = ($parent_Data['quantity']=='I') ? "<span style='font-size:20px;'><b> &infin; </b></span>" : $parent_Data['quantity'];
					            $row[] = (!empty($parent_Data['sold_price'])) ? '$ '.number_format(($parent_Data['sold_price']),2) : '$ 0.00';
					            $row[] = ($parent_Data["discount"]!="") ? '$ '.number_format(str_replace("-",'', $parent_Data['discount']),2) : '$ 0.00';
					            $row[] = $parent_Data['tax_value1'] ? number_format($parent_Data['tax_value1'],2).'%' : '0.00%';
					            $row[] = $parent_Data['sold_price'] ? '$ '.number_format(($parent_Data['sold_price']+$tax_fixed)-$parent_Data['discount'],2) : '$ 0.00';

					            $data[] = $row;
			            	}
			            }
		            }
	        	}
	        }

	        
	        
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => '',
	            "recordsFiltered" => '',
	            "data" => $data,
	        );
	        echo json_encode($output);
		}

		public function inventoryreport() {
			$data = array();
			$merchant_id = $this->session->userdata('merchant_id');
			$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
			$data['merchantdata'] = $getQuery1->result_array();

			//$data['getInventry_main_items']= $this->admin_model->get_all_inventry_main_items($merchant_id);
			$data['getInventry_main_items']= $this->admin_model->get_all_inventry_category($merchant_id);
			
			$this->db->get('adv_pos_item_main');
			if ($this->input->post('search_Submit')) {
				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				$main_items = $_POST['main_items'];

				$start_date1 = $start_date.' 00:00:01';
				$end_date1 = $end_date.' 23:59:59';
				$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
	    		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

           		$start_date2 = date('Y-m-d', strtotime($start_date));
    	    	$end_date2 = date('Y-m-d', strtotime($end_date));

				$package_data = $this->Inventory_model->get_full_inventory_spreportdata_array($start_date1, $end_date1,$main_items,$merchant_id);

				$package_data_no_main_item=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date1, $end_date1,$merchant_id,$main_items);

				$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date1, $end_date1,$merchant_id,$main_items);


				

				$package_data_total_tax_discount = $this->Inventory_model->get_search_merchant_pos_total_tax_discount($start_date2, $end_date2,'confirm', $merchant_id,'pos');

				$package_data_total_tax_discount_split_refund = $this->Inventory_model->get_search_merchant_pos_total_tax_discount_split_refund($start_date2, $end_date2, $merchant_id,'pos');
				$package_data_total_tax_discount_full_refund = $this->Inventory_model->get_search_merchant_pos_total_tax_discount_full_refund($start_date2, $end_date2, $merchant_id,'pos');

				
	            $new_discount = $package_data_total_tax_discount[0]['discount'];
				$new_tax = $package_data_total_tax_discount[0]['tax'];
				$new_amount= $package_data_total_tax_discount[0]['amount'];
				$total_order = $package_data_total_tax_discount[0]['id'];
				$total_order_split=0;
				
				$new_amount_split= $package_data_total_tax_discount_split_refund[0]['amount'];
				$new_amount_full= $package_data_total_tax_discount_full_refund[0]['amount'];
				
		
				
		

			//Pdf html
			$parent_sale1 = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);
			$parent_sale2 = $this->Inventory_model->get_full_inventory_reportdata_sale_split($start_date1,$end_date1,$merchant_id,$main_items);
		
        	$parent_sale= array_merge($parent_sale1,$parent_sale2);
			//print_r($parent_sale); die();
			foreach ($parent_sale as $a_sale) {
				$text_Sale_html .= '<tr>
                <td style="border-left: 1px solid grey; border-bottom:1px solid grey">'.date("Y-m-d", strtotime($a_sale['updated_at'])).'</td>
				 <td style=" border-bottom:1px solid grey">'.$a_sale['transaction_id'].'</td>
				 <td style=" border-bottom:1px solid grey">'.$a_sale['order_id'].'</td>
				  <td style=" border-bottom:1px solid grey" >'.ucfirst($a_sale['item_name']).'/'.ucfirst($a_sale['item_title']).'</td>
				<td style="border-bottom:1px solid grey">'.$a_sale['quantity'].'</td>
				
				<td style=" border-bottom:1px solid grey">$ '.number_format($a_sale['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format(str_replace("-",'',$a_sale['discount']),2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format($a_sale['tax_value'],2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format(($a_sale['sold_price']+$a_sale['tax_value']),2).'</td>
                    <td style="border-right: 1px solid grey; border-bottom:1px solid grey">Paid</td> 
				</tr>';
			}

			$getDiscount = $this->db->query("SELECT id,transaction_id,invoice_no,amount,tax,discount from pos where merchant_id = ".$merchant_id." and date_c >='".$start_date2."' and date_c  <='".$end_date2."' and discount >'0' and pos_type='1' and transaction_type='full' order by id desc ");
			 $getDiscountData = $getDiscount->result_array();
    		// echo '<pre>';print_r($getDiscountData);
    		// die();   

      		foreach ($getDiscountData as $a_sale) {
				$text_Sale_html .= '<tr>
                <td style="border-left: 1px solid grey; border-bottom:1px solid grey"></td>
				 <td style=" border-bottom:1px solid grey"></td>
				 <td style=" border-bottom:1px solid grey"></td>
				  <td style=" border-bottom:1px solid grey" ></td>
				<td style="border-bottom:1px solid grey"></td>
				
				<td style=" border-bottom:1px solid grey"></td>
				<td style="border-bottom:1px solid grey">$ '.number_format(str_replace("-",'',$a_sale['discount']),2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format($a_sale['tax'],2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format(($a_sale['amount']),2).'</td>
                <td style="border-right: 1px solid grey; border-bottom:1px solid grey">Paid</td> 
				</tr>';

				$parent_sale_discount = $this->Inventory_model->get_full_inventory_reportdata_sale_discount($start_date1,$end_date1,$merchant_id,$main_items,$a_sale['transaction_id']);

     			foreach ($parent_sale_discount as $a_sale_ds) {

					$text_Sale_html .= '<tr>
	                 <td style="border-left: 1px solid grey; border-bottom:1px solid grey">'.date("Y-m-d", strtotime($a_sale_ds['updated_at'])).'</td>
					 <td style=" border-bottom:1px solid grey">'.$a_sale['transaction_id'].'</td>
					 <td style=" border-bottom:1px solid grey">'.$a_sale['invoice_no'].'</td>
					 <td style=" border-bottom:1px solid grey" >'.ucfirst($a_sale_ds['item_name']).'/'.ucfirst($a_sale_ds['item_title']).'</td>
					<td style="border-bottom:1px solid grey"></td>
					
					<td style=" border-bottom:1px solid grey">$ '.number_format($a_sale_ds['sold_price'],2).'</td>
					<td style="border-bottom:1px solid grey"></td>
					<td style="border-bottom:1px solid grey"></td>
					<td style="border-bottom:1px solid grey"></td>
	                <td style="border-right: 1px solid grey; border-bottom:1px solid grey">Paid</td> 
					</tr>';
				}
	        }

	        $getDiscount_split = $this->db->query("SELECT id,transaction_id,invoice_no,amount,tax,discount from pos where merchant_id = ".$merchant_id." and date_c >='".$start_date2."' and date_c  <='".$end_date2."' and discount >'0' and transaction_type='split' order by id desc "); 
	        $getDiscountData_split = $getDiscount_split->result_array();

	        foreach ($getDiscountData_split as $a_sale_split) {
	        	$text_Sale_html .= '<tr>
                <td style="border-left: 1px solid grey; border-bottom:1px solid grey"></td>
				<td style=" border-bottom:1px solid grey"></td>
				<td style=" border-bottom:1px solid grey"></td>
				<td style=" border-bottom:1px solid grey" ></td>
				<td style="border-bottom:1px solid grey"></td>
				
				<td style=" border-bottom:1px solid grey"></td>
				<td style="border-bottom:1px solid grey">$ '.number_format(str_replace("-",'',$a_sale_split['discount']),2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format($a_sale_split['tax'],2).'</td>
				<td style="border-bottom:1px solid grey">$ '.number_format(($a_sale_split['amount']),2).'</td>
                <td style="border-right: 1px solid grey; border-bottom:1px solid grey">Paid</td> 
				</tr>';

				$parent_sale_discount = $this->Inventory_model->get_full_inventory_reportdata_sale_discount($start_date1,$end_date1,$merchant_id,$main_items,$a_sale_split['invoice_no']);

     			foreach ($parent_sale_discount as $a_sale_ds) {
					$text_Sale_html .= '<tr>
	                <td style="border-left: 1px solid grey; border-bottom:1px solid grey">'.date("Y-m-d", strtotime($a_sale_ds['updated_at'])).'</td>
					<td style=" border-bottom:1px solid grey">'.$a_sale['transaction_id'].'</td>
					<td style=" border-bottom:1px solid grey">'.$a_sale['invoice_no'].'</td>
					 <td style=" border-bottom:1px solid grey" >'.ucfirst($a_sale_ds['item_name']).'/'.ucfirst($a_sale_ds['item_title']).'</td>
					<td style="border-bottom:1px solid grey"></td>
					<td style=" border-bottom:1px solid grey">$ '.number_format($a_sale_ds['sold_price'],2).'</td>
					<td style="border-bottom:1px solid grey"></td>
					<td style="border-bottom:1px solid grey"></td>
					<td style="border-bottom:1px solid grey"></td>
	                <td style="border-right: 1px solid grey; border-bottom:1px solid grey">Paid</td> 
					</tr>';
				}
	        }


          //Start envtry html

	        $j = 1;
				$total_item_s = 0;
				$total_paid_s = 0;
				$sold_price_s = 0;
				$tax_value_s = 0;
				$discount_s = 0;
				foreach ($package_data_no_main_item as $a_data) {
					$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
					$sold_price2 = $a_data['sold_price'];
				  
					$textcolors .= '<tr>
						<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
						 <td style=" border-bottom:1px solid grey" width="10%">'.($a_data['sku']).'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
						<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($sold_price2,2).'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['discount'],2).'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.number_format($a_data['tax_value1'],2).'%</td>
						<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$tax_fixed)-$a_data['discount'],2).'</td>
					</tr>';
					
					$total_item_s+= $a_data['quantity'];
					
				}
				
				$k = 1;
				$total_item_m = 0;
				$total_paid_m = 0;
				$sold_price_m = 0;
				$tax_value_m = 0;
				$discount_m = 0;
				foreach ($package_data_mis_item as $a_data) {
					$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
				  	$sold_price2 = $a_data['sold_price'];
					$textcolors .= '<tr>
						<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
						 <td style=" border-bottom:1px solid grey" width="10%"></td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
						<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($sold_price2,2).'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['discount'],2).'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.number_format($a_data['tax_value1'],2).'%</td>
						<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$tax_fixed)-$a_data['discount'],2).'</td>
					</tr>';
					
					$total_item_m+= $a_data['quantity'];
					
					
				}
			
				$i = 1;
				$total_item = 0;
				$total_paid = 0;
				$sold_price = 0;
				$tax_value = 0;
				$discount = 0;
				foreach ($package_data as $a_data) {
					$tax_fixed1 = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
                    $tax_fixed =  $tax_fixed1*$a_data['quantity'];

				  	$sold_price2 = $a_data['sold_price'];
					$textcolors .= '<tr >
						<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
						<td style=" border-bottom:1px solid grey" width="10%"></td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
						<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($sold_price2,2).'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(str_replace("-",'', $a_data['discount']),2).'</td>
						<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.number_format($a_data['tax_value1'],2).'%</td>
						<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$tax_fixed)-$a_data['discount'],2).'</td>
					</tr>';
					
					$parent = $this->Inventory_model->get_full_inventory_reportdata($start_date1,$end_date1,$merchant_id,$a_data['main_item_id']);
					foreach ($parent as $parent_Data) {
						$tax_fixed = ($parent_Data['tax_value1'] > 0) ? (($parent_Data['sold_price']*$parent_Data['tax_value1'])/100) : '0';
						$parent_name= Ucfirst($parent_Data['item_title']);
						$sold_price2 = $parent_Data['sold_price'];
									$textcolors .= '<tr>
		                <td style="border-left: 1px solid grey; border-bottom:1px solid grey;" width="30%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;'.$parent_name.'</td>
						<td style=" border-bottom:1px solid grey" width="10%">'.$parent_Data['sku'].'</td>
						<td style="border-bottom:1px solid grey" width="10%">'.$parent_Data['quantity'].'</td>
						<td style="border-bottom:1px solid grey" width="10%">0</td>
						<td style=" border-bottom:1px solid grey" width="10%">$ '.number_format($sold_price2,2).'</td>
						<td style="border-bottom:1px solid grey" width="10%">$ '.number_format(str_replace("-",'',$parent_Data['discount']),2).'</td>
						<td style="border-bottom:1px solid grey" width="10%">'.number_format($parent_Data['tax_value1'],2).'%</td>
						<td style="border-right: 1px solid grey; border-bottom:1px solid grey" width="10%">$ '.number_format(($parent_Data['sold_price']+$tax_fixed)-$parent_Data['discount'],2).'</td>
		                </tr>';	
					}			 
					
					$total_item+= $a_data['quantity'];
					
				}


			//End html
		

			
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "Inventory Report";
		        $title_head = '';
				 
				$obj_pdf->SetTitle($title);
				//$obj_pdf->SetHeaderData($data['merchantdata'][0]['logo'], PDF_HEADER_LOGO_WIDTH, $title,$title_head);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->AddPage();
				
				//$obj_pdf->SetPrintHeader(false);
				//$obj_pdf->setHeaderTemplateAutoreset(true);
				ob_start();

				$startdate = date('M  jS, Y', strtotime($start_date));
				$enddate = date('M  jS, Y', strtotime($end_date));
				$enddatee = date("M  jS, Y h:i A");
				
			    
				
				$text_Sale = $text_Sale_html;
								
				$html = '
				<table cellpadding="2">
					<tr >
						<td align="left">
				    		<img src="https://salequick.com/logo/'.$data['merchantdata'][0]['logo'].'"  width="60">
				  		</td>
				  		<td align="left" colspan="3">
				  			<span style="font-size: 12px;font-weight:900;">'.ucfirst($data['merchantdata'][0]['business_name']).'</span> 
				  			<br>&nbsp;&nbsp;<span>'.ucfirst($data['merchantdata'][0]['business_dba_name']).' </span> 
				  			<br>&nbsp;&nbsp;<span>'.ucfirst($data['merchantdata'][0]['address1']).'</span>
						</td>
						<td>
						</td>
						<td>
						</td>
						<td align="right" colspan="3"> 
						Report Period: '.$enddate.', 12:00 am <br>-'.$startdate.', 11:59 pm
						<br> Generated -   '.$enddatee.'
						</td>
					</tr>
				</table>
				
				<table cellpadding="2">
					<tr >
						<td> <h2>'.($total_item+$total_item_s+$total_item_m).'</h2> <br> Total Item Sold </td>
						<td> <h2>$ '.number_format(($new_amount)-($new_amount_split+$new_amount_full),2).'</h2> <br> Total Paid  </td>
						<td> 
						<h2>'.($total_order_split+$total_order).'</h2> <br>Number Of Orders 
						</td>
						<td> <h2>$ '.number_format(($new_amount_split+$new_amount_full),2).'</h2> <br> Total Refund  </td>
						
						<td colspan="2">
						</td>
					</tr>
				</table>
				<h3>Summary</h3>
				<table cellpadding="2">
					<tr>
						<th bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%">Item Name</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;"  width="10%">Sku</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Total Sold</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Total Refund</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">SubTotal</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Discount</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Tax</th>
						<th bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">Grand Total</th>
					</tr>
					'.$textcolors.'
				</table> ';

				$html_Sale = '<h3>Item Sale</h3>
				<table cellpadding="2">
					<tr >
						<th bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%" >Date</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="15%" >Transaction id</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;"  width="15%">Order Id </th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="15%">Item Name</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="5%">Qty</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="9%">SubTotal</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="8%">Discount</th>
						<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="7%">Tax</th>
						<th bgcolor="#cccccc" style="border-bottom:1px solid grey;font-size: 9px;" width="10%">Grand Total</th>
						<th bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 9px;" width="7%">Status</th>
										  
					</tr>
					'.$text_Sale.'
				</table>';
				$content = $textcolors;
				ob_end_clean();
				//$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->setDestination('Summary', 0, '');
				$obj_pdf->Bookmark('Summary', 0, 0, '', 'BI', array(128,0,0), -1, '#Summary');
				$obj_pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
				$obj_pdf->writeHTML($html, true, false, true, false, '');
				$obj_pdf->AddPage();
				$obj_pdf->setDestination('Item Sale', 0, '');
				$obj_pdf->Bookmark('Item Sale', 0, 0, '', 'BI', array(128,0,0), -1, '#Item Sale');
				$obj_pdf->Cell(0, 10, 'Item Sale', 0, 1, 'L');
				$obj_pdf->writeHTML($html_Sale, true, false, true, false, '');
				$obj_pdf->Output('Inventory Report.pdf', 'D');

			}
		}

		public function inventoryreport_ExcelDownload() {
			// create file name
	        $fileName = 'Inventory Report Excel.xlsx';
			// load excel library
	        $this->load->library('Excel');
			$data = array();
			$mem = array();
			$member = array();
			
			$merchant_id = $this->session->userdata('merchant_id');
			$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
			$data['merchantdata'] = $getQuery1->result_array();
			
			if ($_POST) {
				// echo '<pre>';print_r($_POST);die;
				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				// $main_items = $_POST['main_items'];
				$main_items = '';

				$start_date1 = $start_date.' 00:00:01';
				$end_date1 = $end_date.' 23:59:59';
				$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
	    		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

           		$start_date2 = date('Y-m-d', strtotime($start_date));
    	    	$end_date2 = date('Y-m-d', strtotime($end_date));

				// echo $start_date.','.$end_date.','.$main_items;die;
				// $package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);

				// $package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
				// $package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);

				$package_data = $this->Inventory_model->get_full_inventory_spreportdata_array($start_date1, $end_date1,$main_items,$merchant_id);

				$package_data_no_main_item=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date1, $end_date1,$merchant_id,$main_items);

				$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date1, $end_date1,$merchant_id,$main_items);


				$package_data_total_count_confirm = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'confirm', $merchant_id,'pos');

				$package_data_total_count_refund = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'Chargeback_Confirm', $merchant_id,'pos');

				$package_data_total_tax_discount = $this->Inventory_model->get_search_merchant_pos_total_tax_discount($start_date2, $end_date2,'confirm', $merchant_id,'pos');

				$package_data_total_tax_discount_split_refund = $this->Inventory_model->get_search_merchant_pos_total_tax_discount_split_refund($start_date2, $end_date2, $merchant_id,'pos');
				$package_data_total_tax_discount_full_refund = $this->Inventory_model->get_search_merchant_pos_total_tax_discount_full_refund($start_date2, $end_date2, $merchant_id,'pos');

				
	            $new_discount = $package_data_total_tax_discount[0]['discount'];
				$new_tax = $package_data_total_tax_discount[0]['tax'];
				$new_amount= $package_data_total_tax_discount[0]['amount'];
				$total_order = $package_data_total_tax_discount[0]['id'];
				$total_order_split=0;
				
				$new_amount_split= $package_data_total_tax_discount_split_refund[0]['amount'];
				$new_amount_full= $package_data_total_tax_discount_full_refund[0]['amount'];
				
				// $package_data_invoice_refund = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund($start_date1, $end_date1,$main_items,$merchant_id);
				// $total_order = count($package_data_invoice_refund);
				// $refund_amount=0;

				// // foreach($package_data_invoice_refund as $invoice_refund)
				// // {
				// // 	$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				// // 	$refund_amount+= $refund_check['amount'];
				// // }

				// $package_data_invoice_refund_split = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund_split($start_date1, $end_date1,$main_items,$merchant_id);
				// $total_order_split = count($package_data_invoice_refund_split);
				// $refund_amount_split=0;
				
				// //print_r($package_data_invoice_refund_split); die();
				// // foreach($package_data_invoice_refund_split as $invoice_refund_split)
				// // {
				// // 	$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				// // 	$refund_amount_split+= $refund_check['amount'];
				// // }

			} else {
				// echo 'no data';die;
				$start_date = date('Y-m-d', strtotime('-30 days'));
				$end_date = date('Y-m-d');
				$data["start_date"] = $start_date;
				$data["end_date"] =  $end_date;
				$main_items = '';
				$package_data = $this->Inventory_model->get_full_inventory_reportdata_main($start_date, $end_date,$merchant_id);
				$package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
				$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			}

			$parent_sale1 = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);
			$parent_sale2 = $this->Inventory_model->get_full_inventory_reportdata_sale_split($start_date1,$end_date1,$merchant_id,$main_items);
		
        	$parent_sale= array_merge($parent_sale1,$parent_sale2);
			
			// foreach ($package_data as $each) {
			// 	if($each) {
			// 		$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
			// 		$package['item_id'] = $each->item_id;
			// 		$package['main_item_id'] = $each->main_item_id;
			// 		$package['mname'] = $each->mname;
			// 		$package['merchant_id'] = $merchant_id;
			// 		// $package['price'] = $each->price;
			// 		$package['tax_value'] = $each->tax_value;
			// 		$package['tax_value1'] = $each->tax_value1;
			// 		$package['sku'] = $each->sku;
			// 		// $package['new_price'] = $each->new_price;
			// 		$package['quantity'] = $each->quantity;
			// 		$package['cat_name'] = $each->cat_name;
			// 		$package['status'] = $each->status;
			// 		$package['discount'] = $each->discount;
			// 		$package['date'] = $each->created_at;
			// 		$package['updated_at'] = $each->updated_at;
			// 		$package['rowtype'] = "parent";
			// 		$package['sold_price'] = $each->sold_price;
			// 		$package['item_name'] = $each->item_name;
			// 		$package['base_price'] = $each->base_price;
			// 		$package['item_image'] = $each->item_image;
			// 		$package['item_title'] = $each->item_title;
			// 		$mem[] = $package;
			// 	}
			// }

			$startdate = date('M  jS, Y', strtotime($start_date));
			$enddate = date('M  jS, Y', strtotime($end_date));
			$enddatee = date("M  jS, Y h:i A");

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Column Width
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

			$objPHPExcel->getActiveSheet()->SetCellValue('A1', ucfirst($data['merchantdata'][0]['business_name']));
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Report Period: '.$enddate.', 12:00 am');
			$rowCount = 2;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['business_dba_name']));
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-'.$startdate.', 11:59 pm');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['address1']));
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Generated - '.$enddatee);
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Total Item Sold');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total Paid');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Number Of Orders');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Total Refund');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Summary');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Item Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'SKU');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Sold');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Refund');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'SubTotal');
	        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Discount');       
	        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Tax');       
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Grand Total');
			$rowCount++;
			
			$j = 1;
			$total_item_s = 0;
			$total_paid_s = 0;
			$sold_price_s = 0;
			$tax_value_s = 0;
			$discount_s = 0;
			foreach ($package_data_no_main_item as $a_data) {

				if($a_data['bill_tax']>0){
						$tax_fixed = $a_data['bill_tax'];
					
				   } else
				   {
				  $tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
				   }

				   if($a_data['bill_discount']>0){
						$discount_fixed = $a_data['bill_discount'];
					
				   } else
				   {
				   	//$discount_fixed = $a_data['discount'];
				   	$discount_fixed = '0';
				   }

				$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

				$export_sold_price = $a_data['sold_price'] ? number_format(($a_data['sold_price']),2) : '0.00';
				
				$export_discount = ($a_data["discount"]!="") ? number_format(str_replace("-",'', $a_data['discount']),2) : '0.00';

				$export_tax = $a_data['tax_value1'] ? number_format($a_data['tax_value1'],2) : '0.00';
				$export_tax = $export_tax.'%';

				$export_grand_total = number_format(($a_data['sold_price']+$tax_fixed)-$discount_fixed,2);

				$export_sold_price = '$'.$export_sold_price;
				$export_discount = '$'.$export_discount;
				$export_grand_total = '$'.$export_grand_total;

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['sku']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
	            $rowCount++;
				$j++;

				$total_item_s+= $a_data['quantity'];
			}
			
			$k = 1;
			$total_item_m = 0;
			$total_paid_m = 0;
			$sold_price_m = 0;
			$tax_value_m = 0;
			$discount_m = 0;
			foreach ($package_data_mis_item as $a_data) {

					if($a_data['bill_tax']>0){
						$tax_fixed = $a_data['bill_tax'];
					
				   } else
				   {
				   	$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
				   }
	               if($a_data['bill_discount']>0){
						$discount_fixed = $a_data['bill_discount'];
					
				   } else
				   {
				   	//$discount_fixed = $a_data['discount'];
				   	$discount_fixed = '0';
				   }


				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(ucfirst($a_data['mname'])));
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['quantity']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '$ '.number_format(($a_data['sold_price']),2));
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$ '.number_format($a_data['discount'],2));
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, number_format($a_data['tax_value1'],2).'%');
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$ '.number_format(($a_data['sold_price']+$tax_fixed)-$discount_fixed,2));
	            $rowCount++;
				
				$total_item_m+= $a_data['quantity'];
				$sold_price_m+= $a_data['sold_price'];
				
				if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0) {
	              $tax_value_m+= $a_data['bill_tax'];
				} else {
					$tax_value_m+= $a_data['tax_value'];
				}

				if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0) {
	              $discount_m+= $a_data['bill_discount'];
				} else {
					$discount_m+= $a_data['discount'];
				}
				$k++; 
			}

			$i = 1;
			$total_item = 0;
			foreach ($package_data as $a_data) {

				// $tax_fixed1 = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
    //             $tax_fixed =  $tax_fixed1*$a_data['quantity'];
                    
				// $export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

				// $export_sold_price = $a_data['sold_price'] ? ($a_data['sold_price']-$tax_fixed1) : '0.00';
				// // echo $export_sold_price.'<br>';
				
				// $export_discount = number_format(str_replace("-",'', $a_data['discount']),2);

				// $export_tax = $a_data['tax_value1'] ? number_format($a_data['tax_value1'],2) : '0.00';

				// // echo $export_sold_price.' , '.$export_tax.' , '.$export_discount.'<br>';
				// $export_grand_total = number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2);

				// $export_sold_price = '$'.number_format($export_sold_price, 2);
				// $export_discount = '$'.$export_discount;
				// $export_grand_total = '$'.$export_grand_total;
				// $export_tax = $export_tax.'%';

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
	            // $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
				// $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
				// $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
	            // $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
	            // $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
	            // $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
				// $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
				$rowCount++;
				
				$parent = $this->Inventory_model->get_full_inventory_reportdata($start_date1,$end_date1,$merchant_id,$a_data['main_item_id']);

				foreach ($parent as $parent_Data) {

                      if($parent_Data['bill_tax']>0){   
						$tax_fixed = $parent_Data['bill_tax'];
					
				   } else
				   {
				   	$tax_fixed = ($parent_Data['tax_value1'] > 0) ? (($parent_Data['sold_price']*$parent_Data['tax_value1'])/100) : '0';
				   }

                     if($parent_Data['bill_discount']>0){   
						$discount_fixed = $parent_Data['bill_discount'];
					
				   } else
				   {
				   	//$discount_fixed = $parent_Data['discount'];
				   	$discount_fixed =0;
				   }
					// echo '<pre>';print_r($parent_Data);die;
					$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];

					$export_sold_price = number_format(($parent_Data['sold_price']),2);
					
					$export_discount = number_format(str_replace("-",'',$parent_Data['discount']),2);

					$export_tax = $parent_Data['tax_value1'] ? number_format($parent_Data['tax_value1'],2) : '0.00';
					$export_tax = $export_tax.'%';

					$export_grand_total = number_format(($parent_Data['sold_price']+$tax_fixed)-$discount_fixed,2);

					$export_sold_price = '$'.$export_sold_price;
					$export_discount = '$'.$export_discount;
					$export_grand_total = '$'.$export_grand_total;

					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '  -'.htmlentities(Ucfirst($parent_Data['item_title'])) );
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['sku']);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
					$rowCount++;
				}
				$total_item+= $a_data['quantity'];
			}
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Item Sale');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Transaction ID');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Order ID');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Item Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Qty');
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'SubTotal');
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Discount');
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Tax');
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Grand Total');
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Status');
			$rowCount++;

			$start_date1 = $start_date.' 00:00:01';
			$end_date1 = $end_date.' 23:59:59';
			$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
    	    $end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));
		 

			// $parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);

			//$parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date,$end_date,$merchant_id,$main_items);

			foreach ($parent_sale as $a_sale) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale['updated_at'])));
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['order_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale['item_name']).'/'.ucfirst($a_sale['item_title']));
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $a_sale['quantity']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale['sold_price'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale['discount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale['tax_value'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale['sold_price']+$a_sale['tax_value']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
				$rowCount++;
			}

			$getDiscount = $this->db->query("SELECT id,transaction_id,invoice_no,amount,tax,discount from pos where merchant_id = ".$merchant_id." and date_c >='".$start_date2."' and date_c  <='".$end_date2."' and discount >'0' and pos_type='1' and transaction_type='full' order by id desc ");
			 $getDiscountData = $getDiscount->result_array();

		    foreach ($getDiscountData as $a_sale) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale['discount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale['tax'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale['amount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
				$rowCount++;

				$parent_sale_discount = $this->Inventory_model->get_full_inventory_reportdata_sale_discount($start_date1,$end_date1,$merchant_id,$main_items,$a_sale['transaction_id']);

				foreach ($parent_sale_discount as $a_sale_ds) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale_ds['updated_at'])) );
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['invoice_no']);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale_ds['item_name']).'/'.ucfirst($a_sale_ds['item_title']));
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale_ds['sold_price'],2) );
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
					$rowCount++;
				}
			}

			$getDiscount_split = $this->db->query("SELECT id,transaction_id,invoice_no,amount,tax,discount from pos where merchant_id = ".$merchant_id." and date_c >='".$start_date2."' and date_c  <='".$end_date2."' and discount >'0' and transaction_type='split' order by id desc "); 
	        $getDiscountData_split = $getDiscount_split->result_array();

	        foreach ($getDiscountData_split as $a_sale_split) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale_split['discount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale_split['tax'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale_split['amount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
				$rowCount++;

				$parent_sale_discount = $this->Inventory_model->get_full_inventory_reportdata_sale_discount($start_date1,$end_date1,$merchant_id,$main_items,$a_sale_split['invoice_no']);

				foreach ($parent_sale_discount as $a_sale_ds) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale_ds['updated_at'])) );
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['invoice_no']);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale_ds['item_name']).'/'.ucfirst($a_sale_ds['item_title']));
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale_ds['sold_price'],2) );
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
					$rowCount++;
				}
			}

			// $styleArray = array(
		    	// 'font'  => array(
			//         'bold'  => true,
			//         'size'  => 36
			//     )
		    // );

			// $objPHPExcel->getActiveSheet()->getCell('A5')->SetCellValue('A5', ' '.($total_item+$total_item_s+$total_item_m));
			// $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->SetCellValue('A5', ' '.($total_item+$total_item_s+$total_item_m));
			$objPHPExcel->getActiveSheet()->SetCellValue('B5', '$ '.number_format(($new_amount)-($new_amount_split+$new_amount_full),2));
			$objPHPExcel->getActiveSheet()->SetCellValue('C5', ' '.($total_order_split+$total_order));
			$objPHPExcel->getActiveSheet()->SetCellValue('D5', '$ '.number_format(($new_amount_split+$new_amount_full),2));

	        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	        $objWriter->save($fileName);
			// download file
	        header("Content-Type: application/vnd.ms-excel");
	        redirect(site_url().$fileName);  
		}

		public function inventoryreport_CSVDownload() {
			// load excel library
	        $this->load->library('Excel');
			$data = array();
			$mem = array();
			$member = array();
			
			$merchant_id = $this->session->userdata('merchant_id');
			$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
			$data['merchantdata'] = $getQuery1->result_array();
			
			if ($_POST) {
				// echo '<pre>';print_r($_POST);die;
				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				// $main_items = $_POST['main_items'];
				$main_items = '';

				$start_date1 = $start_date.' 00:00:01';
				$end_date1 = $end_date.' 23:59:59';
				$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
	    		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

           		$start_date2 = date('Y-m-d', strtotime($start_date));
    	    	$end_date2 = date('Y-m-d', strtotime($end_date));

				// echo $start_date.','.$end_date.','.$main_items;die;
				// $package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);

				// $package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
				// $package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);

				$package_data = $this->Inventory_model->get_full_inventory_spreportdata_array($start_date1, $end_date1,$main_items,$merchant_id);

				$package_data_no_main_item=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date1, $end_date1,$merchant_id,$main_items);

				$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date1, $end_date1,$merchant_id,$main_items);


				$package_data_total_count_confirm = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'confirm', $merchant_id,'pos');

				$package_data_total_count_refund = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'Chargeback_Confirm', $merchant_id,'pos');

				$package_data_total_tax_discount = $this->Inventory_model->get_search_merchant_pos_total_tax_discount($start_date2, $end_date2,'confirm', $merchant_id,'pos');

				$package_data_total_tax_discount_split_refund = $this->Inventory_model->get_search_merchant_pos_total_tax_discount_split_refund($start_date2, $end_date2, $merchant_id,'pos');
				$package_data_total_tax_discount_full_refund = $this->Inventory_model->get_search_merchant_pos_total_tax_discount_full_refund($start_date2, $end_date2, $merchant_id,'pos');

				
	            $new_discount = $package_data_total_tax_discount[0]['discount'];
				$new_tax = $package_data_total_tax_discount[0]['tax'];
				$new_amount= $package_data_total_tax_discount[0]['amount'];
				$total_order = $package_data_total_tax_discount[0]['id'];
				$total_order_split=0;
				
				$new_amount_split= $package_data_total_tax_discount_split_refund[0]['amount'];
				$new_amount_full= $package_data_total_tax_discount_full_refund[0]['amount'];
				
				// $package_data_invoice_refund = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund($start_date1, $end_date1,$main_items,$merchant_id);
				// $total_order = count($package_data_invoice_refund);
				// $refund_amount=0;

				// // foreach($package_data_invoice_refund as $invoice_refund)
				// // {
				// // 	$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				// // 	$refund_amount+= $refund_check['amount'];
				// // }

				// $package_data_invoice_refund_split = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund_split($start_date1, $end_date1,$main_items,$merchant_id);
				// $total_order_split = count($package_data_invoice_refund_split);
				// $refund_amount_split=0;
				
				// //print_r($package_data_invoice_refund_split); die();
				// // foreach($package_data_invoice_refund_split as $invoice_refund_split)
				// // {
				// // 	$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				// // 	$refund_amount_split+= $refund_check['amount'];
				// // }

			} else {
				// echo 'no data';die;
				$start_date = date('Y-m-d', strtotime('-30 days'));
				$end_date = date('Y-m-d');
				$data["start_date"] = $start_date;
				$data["end_date"] =  $end_date;
				$main_items = '';
				$package_data = $this->Inventory_model->get_full_inventory_reportdata_main($start_date, $end_date,$merchant_id);
				$package_data_no_main_item = $this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
				$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			}

			$parent_sale1 = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);
			$parent_sale2 = $this->Inventory_model->get_full_inventory_reportdata_sale_split($start_date1,$end_date1,$merchant_id,$main_items);
		
        	$parent_sale= array_merge($parent_sale1,$parent_sale2);
			
			// foreach ($package_data as $each) {
			// 	if($each) {
			// 		$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
			// 		$package['item_id'] = $each->item_id;
			// 		$package['main_item_id'] = $each->main_item_id;
			// 		$package['mname'] = $each->mname;
			// 		$package['merchant_id'] = $merchant_id;
			// 		// $package['price'] = $each->price;
			// 		$package['tax_value'] = $each->tax_value;
			// 		$package['tax_value1'] = $each->tax_value1;
			// 		$package['sku'] = $each->sku;
			// 		// $package['new_price'] = $each->new_price;
			// 		$package['quantity'] = $each->quantity;
			// 		$package['cat_name'] = $each->cat_name;
			// 		$package['status'] = $each->status;
			// 		$package['discount'] = $each->discount;
			// 		$package['date'] = $each->created_at;
			// 		$package['updated_at'] = $each->updated_at;
			// 		$package['rowtype'] = "parent";
			// 		$package['sold_price'] = $each->sold_price;
			// 		$package['item_name'] = $each->item_name;
			// 		$package['base_price'] = $each->base_price;
			// 		$package['item_image'] = $each->item_image;
			// 		$package['item_title'] = $each->item_title;
			// 		$mem[] = $package;
			// 	}
			// }

			$startdate = date('M  jS, Y', strtotime($start_date));
			$enddate = date('M  jS, Y', strtotime($end_date));
			$enddatee = date("M  jS, Y h:i A");

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Column Width
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

			$objPHPExcel->getActiveSheet()->SetCellValue('A1', ucfirst($data['merchantdata'][0]['business_name']));
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Report Period: '.$enddate.', 12:00 am');
			$rowCount = 2;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['business_dba_name']));
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-'.$startdate.', 11:59 pm');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, ucfirst($data['merchantdata'][0]['address1']));
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Generated - '.$enddatee);
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Total Item Sold');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total Paid');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Number Of Orders');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Total Refund');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Summary');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Item Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'SKU');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Sold');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Refund');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'SubTotal');
	        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Discount');       
	        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Tax');       
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Grand Total');
			$rowCount++;
			
			$j = 1;
			$total_item_s = 0;
			$total_paid_s = 0;
			$sold_price_s = 0;
			$tax_value_s = 0;
			$discount_s = 0;
			foreach ($package_data_no_main_item as $a_data) {
				$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';

				$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

				$export_sold_price = $a_data['sold_price'] ? number_format(($a_data['sold_price']),2) : '0.00';
				
				$export_discount = ($a_data["discount"]!="") ? number_format(str_replace("-",'', $a_data['discount']),2) : '0.00';

				$export_tax = $a_data['tax_value1'] ? number_format($a_data['tax_value1'],2) : '0.00';
				$export_tax = $export_tax.'%';

				$export_grand_total = number_format(($a_data['sold_price']+$tax_fixed)-$a_data['discount'],2);

				$export_sold_price = '$'.$export_sold_price;
				$export_discount = '$'.$export_discount;
				$export_grand_total = '$'.$export_grand_total;

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['sku']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
	            $rowCount++;
				$j++;

				$total_item_s+= $a_data['quantity'];
			}
			
			$k = 1;
			$total_item_m = 0;
			$total_paid_m = 0;
			$sold_price_m = 0;
			$tax_value_m = 0;
			$discount_m = 0;
			foreach ($package_data_mis_item as $a_data) {
				$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(ucfirst($a_data['mname'])));
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['quantity']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '$ '.number_format(($a_data['sold_price']),2));
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$ '.number_format($a_data['discount'],2));
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, number_format($a_data['tax_value1'],2).'%');
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$ '.number_format(($a_data['sold_price']+$tax_fixed)-$a_data['discount'],2));
	            $rowCount++;
				
				$total_item_m+= $a_data['quantity'];
				$sold_price_m+= $a_data['sold_price'];
				
				if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0) {
	              $tax_value_m+= $a_data['bill_tax'];
				} else {
					$tax_value_m+= $a_data['tax_value'];
				}

				if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0) {
	              $discount_m+= $a_data['bill_discount'];
				} else {
					$discount_m+= $a_data['discount'];
				}
				$k++; 
			}

			$i = 1;
			$total_item = 0;
			foreach ($package_data as $a_data) {
				$tax_fixed1 = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
                $tax_fixed =  $tax_fixed1*$a_data['quantity'];
                    
				$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];

				$export_sold_price = $a_data['sold_price'] ? ($a_data['sold_price']-$tax_fixed1) : '0.00';
				// echo $export_sold_price.'<br>';
				
				$export_discount = number_format(str_replace("-",'', $a_data['discount']),2);

				$export_tax = $a_data['tax_value1'] ? number_format($a_data['tax_value1'],2) : '0.00';

				// echo $export_sold_price.' , '.$export_tax.' , '.$export_discount.'<br>';
				$export_grand_total = number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2);

				$export_sold_price = '$'.number_format($export_sold_price, 2);
				$export_discount = '$'.$export_discount;
				$export_grand_total = '$'.$export_grand_total;
				$export_tax = $export_tax.'%';

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
	            // $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
				// $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
				// $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
	            // $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
	            // $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
	            // $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
				// $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
				$rowCount++;
				
				$parent = $this->Inventory_model->get_full_inventory_reportdata($start_date1,$end_date1,$merchant_id,$a_data['main_item_id']);

				foreach ($parent as $parent_Data) {
					$tax_fixed = ($parent_Data['tax_value1'] > 0) ? (($parent_Data['sold_price']*$parent_Data['tax_value1'])/100) : '0';
					// echo '<pre>';print_r($parent_Data);die;
					$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];

					$export_sold_price = number_format(($parent_Data['sold_price']),2);
					
					$export_discount = number_format(str_replace("-",'',$parent_Data['discount']),2);

					$export_tax = $parent_Data['tax_value1'] ? number_format($parent_Data['tax_value1'],2) : '0.00';
					$export_tax = $export_tax.'%';

					$export_grand_total = number_format(($parent_Data['sold_price']+$tax_fixed)-$parent_Data['discount'],2);

					$export_sold_price = '$'.$export_sold_price;
					$export_discount = '$'.$export_discount;
					$export_grand_total = '$'.$export_grand_total;

					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '  -'.htmlentities(Ucfirst($parent_Data['item_title'])) );
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['sku']);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $export_quantity);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '0');
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_sold_price);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_discount);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_tax);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_grand_total);
					$rowCount++;
				}
				$total_item+= $a_data['quantity'];
			}
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Item Sale');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Transaction ID');
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Order ID');
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Item Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Qty');
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'SubTotal');
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Discount');
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Tax');
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Grand Total');
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Status');
			$rowCount++;

			$start_date1 = $start_date.' 00:00:01';
			$end_date1 = $end_date.' 23:59:59';
			$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
    	    $end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));
		 

			// $parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);

			//$parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date,$end_date,$merchant_id,$main_items);

			foreach ($parent_sale as $a_sale) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale['updated_at'])));
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['order_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale['item_name']).'/'.ucfirst($a_sale['item_title']));
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $a_sale['quantity']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale['sold_price'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale['discount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale['tax_value'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale['sold_price']+$a_sale['tax_value']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
				$rowCount++;
			}

			$getDiscount = $this->db->query("SELECT id,transaction_id,invoice_no,amount,tax,discount from pos where merchant_id = ".$merchant_id." and date_c >='".$start_date2."' and date_c  <='".$end_date2."' and discount >'0' and pos_type='1' and transaction_type='full' order by id desc ");
			 $getDiscountData = $getDiscount->result_array();

		    foreach ($getDiscountData as $a_sale) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale['discount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale['tax'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale['amount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
				$rowCount++;

				$parent_sale_discount = $this->Inventory_model->get_full_inventory_reportdata_sale_discount($start_date1,$end_date1,$merchant_id,$main_items,$a_sale['transaction_id']);

				foreach ($parent_sale_discount as $a_sale_ds) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale_ds['updated_at'])) );
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['invoice_no']);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale_ds['item_name']).'/'.ucfirst($a_sale_ds['item_title']));
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale_ds['sold_price'],2) );
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
					$rowCount++;
				}
			}

			$getDiscount_split = $this->db->query("SELECT id,transaction_id,invoice_no,amount,tax,discount from pos where merchant_id = ".$merchant_id." and date_c >='".$start_date2."' and date_c  <='".$end_date2."' and discount >'0' and transaction_type='split' order by id desc "); 
	        $getDiscountData_split = $getDiscount_split->result_array();

	        foreach ($getDiscountData_split as $a_sale_split) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '$'.number_format(str_replace("-",'',$a_sale_split['discount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '$'.number_format($a_sale_split['tax'],2));
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '$'.number_format(($a_sale_split['amount']),2));
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
				$rowCount++;

				$parent_sale_discount = $this->Inventory_model->get_full_inventory_reportdata_sale_discount($start_date1,$end_date1,$merchant_id,$main_items,$a_sale_split['invoice_no']);

				foreach ($parent_sale_discount as $a_sale_ds) {
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("Y-m-d", strtotime($a_sale_ds['updated_at'])) );
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, " ".$a_sale['transaction_id']." ");
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_sale['invoice_no']);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucfirst($a_sale_ds['item_name']).'/'.ucfirst($a_sale_ds['item_title']));
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format($a_sale_ds['sold_price'],2) );
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Paid');
					$rowCount++;
				}
			}

			// $styleArray = array(
		    	// 'font'  => array(
			//         'bold'  => true,
			//         'size'  => 36
			//     )
		    // );

			// $objPHPExcel->getActiveSheet()->getCell('A5')->SetCellValue('A5', ' '.($total_item+$total_item_s+$total_item_m));
			// $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->SetCellValue('A5', ' '.($total_item+$total_item_s+$total_item_m));
			$objPHPExcel->getActiveSheet()->SetCellValue('B5', '$ '.number_format(($new_amount)-($new_amount_split+$new_amount_full),2));
			$objPHPExcel->getActiveSheet()->SetCellValue('C5', ' '.($total_order_split+$total_order));
			$objPHPExcel->getActiveSheet()->SetCellValue('D5', '$ '.number_format(($new_amount_split+$new_amount_full),2));

			// create file name
			$fileName = 'Inventory Report CSV';
			
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}

	}