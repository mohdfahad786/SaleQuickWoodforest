<?php 
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory_report_ajax extends CI_Controller {
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

		$this->load->view('merchant/inventoryreport_dash_new', $data);
	}

	public function pdf_parent_report() {
		// echo '<pre>';print_r($_POST);die;
		$start_date = $_POST['start_date'];
		$end_date =  $_POST['end_date'];
		$main_items = $_POST['main_items'];
		$merchant_id = $this->session->userdata('merchant_id');

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));

		$start_date1 = $start_date.' 00:00:01';
		$end_date1 = $end_date.' 23:59:59';
		$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

   		$start_date2 = date('Y-m-d', strtotime($start_date));
    	$end_date2 = date('Y-m-d', strtotime($end_date));

		// echo $start_date.','.$end_date;die;
		$package_data_no_main_item=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date1, $end_date1,$merchant_id,$main_items);

		$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date1, $end_date1,$merchant_id,$main_items);

		$textcolors = '';
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

		$data = array(
			'parent_data' => $textcolors,
			'total_item_s' => $total_item_s,
			'total_item_m' => $total_item_m,
		);

		echo json_encode($data);die;
	}

	public function pdf_child_report() {
		$start_date = $_POST['start_date'];
		$end_date =  $_POST['end_date'];
		$main_items = $_POST['main_items'];
		$merchant_id = $this->session->userdata('merchant_id');

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));

		$start_date1 = $start_date.' 00:00:01';
		$end_date1 = $end_date.' 23:59:59';
		$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

   		$start_date2 = date('Y-m-d', strtotime($start_date));
    	$end_date2 = date('Y-m-d', strtotime($end_date));

    	$package_data = $this->Inventory_model->get_full_inventory_spreportdata_array($start_date1, $end_date1,$main_items,$merchant_id);

    	$i = 1;
		$total_item = 0;
		$total_paid = 0;
		$sold_price = 0;
		$tax_value = 0;
		$discount = 0;
		$textcolors = '';
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

		$data = array(
			'child_data' => $textcolors,
			'total_item' => $total_item
		);

		echo json_encode($data);die;
	}

	public function pdf_summary_sale_report() {
		$start_date = $_POST['start_date'];
		$end_date =  $_POST['end_date'];
		$main_items = $_POST['main_items'];
		$merchant_id = $this->session->userdata('merchant_id');

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));

		$start_date1 = $start_date.' 00:00:01';
		$end_date1 = $end_date.' 23:59:59';
		$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

   		$start_date2 = date('Y-m-d', strtotime($start_date));
    	$end_date2 = date('Y-m-d', strtotime($end_date));
		
		//Pdf html
		$parent_sale1 = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);
		$parent_sale2 = $this->Inventory_model->get_full_inventory_reportdata_sale_split($start_date1,$end_date1,$merchant_id,$main_items);
	
		$text_Sale_html = '';
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

        echo json_encode($text_Sale_html);die;
	}

	public function generate_pdf() {
		// echo '<pre>';print_r($_POST);die;
		$start_date = $_POST['start_date'];
		$end_date =  $_POST['end_date'];
		$main_items = $_POST['main_items'];

		$response_parent = $_POST['response_parent'];
		$response_child = $_POST['response_child'];
		$response_sale = $_POST['response_sale'];

		$merchant_id = $this->session->userdata('merchant_id');
		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));

		$start_date1 = $start_date.' 00:00:01';
		$end_date1 = $end_date.' 23:59:59';
		$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

   		$start_date2 = date('Y-m-d', strtotime($start_date));
    	$end_date2 = date('Y-m-d', strtotime($end_date));

		$startdate = date('M  jS, Y', strtotime($start_date));
		$enddate = date('M  jS, Y', strtotime($end_date));
		$enddatee = date("M  jS, Y h:i A");

		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
			$data['merchantdata'] = $getQuery1->result_array();

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
		
		// $text_Sale = $text_Sale_html;

		if(!empty($response_parent)) {
			$response_parent = json_decode($response_parent);
			// echo '<pre>';print_r($response_parent);die;

			$parent_data1 = $response_parent->parent_data;
			$total_item_s = $response_parent->total_item_s;
			$total_item_m = $response_parent->total_item_m;
		} else {
			$parent_data1 = '';
			$total_item_s = 0;
			$total_item_m = 0;
		}

		if(!empty($response_child)) {
			$response_child = json_decode($response_child);
			// echo '<pre>';print_r($response_child);die;

			$child_data1 = $response_child->child_data;
			$total_item = $response_child->total_item;
		} else {
			$child_data1 = '';
			$total_item = 0;
		}

		if(!empty($response_sale)) {
			$response_sale = json_decode($response_sale);
			// echo '<pre>';print_r($response_sale);die;

			$sale_data1 = $response_sale;
		} else {
			$sale_data1 = '';
		}

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
			'.$parent_data1.' '.$child_data1.'
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
			'.$sale_data1.'
		</table>';

		// $full_html = $html .' '. $html_Sale;

		// echo $full_html;die;
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

	public function inventoryreport_ExcelDownload() {
		$fileName = 'Inventory Report Excel.xlsx';
		
		$this->load->library('Excel');
		$data = array();
		$mem = array();
		$member = array();

		$start_date = $_POST['start_date'];
		$end_date =  $_POST['end_date'];
		$main_items = $_POST['main_items'];
		$merchant_id = $this->session->userdata('merchant_id');

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));

		$start_date1 = $start_date.' 00:00:01';
		$end_date1 = $end_date.' 23:59:59';
		$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

   		$start_date2 = date('Y-m-d', strtotime($start_date));
    	$end_date2 = date('Y-m-d', strtotime($end_date));
		
		$merchant_id = $this->session->userdata('merchant_id');
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
		$data['merchantdata'] = $getQuery1->result_array();

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

		$parent_sale1 = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);
		$parent_sale2 = $this->Inventory_model->get_full_inventory_reportdata_sale_split($start_date1,$end_date1,$merchant_id,$main_items);

		//print_r($parent_sale2); die();
	
    	$parent_sale= array_merge($parent_sale1,$parent_sale2);

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
			} else {
			  	$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
			}

			if($a_data['bill_discount']>0){
				$discount_fixed = $a_data['bill_discount'];
			} else {
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
		   	} else {
		   		$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
		   	}
			
           	if($a_data['bill_discount']>0){
				$discount_fixed = $a_data['bill_discount'];
		   	} else {
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
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
			$rowCount++;
			
			$parent = $this->Inventory_model->get_full_inventory_reportdata($start_date1,$end_date1,$merchant_id,$a_data['main_item_id']);

			foreach ($parent as $parent_Data) {
                if($parent_Data['bill_tax']>0){   
					$tax_fixed = $parent_Data['bill_tax'];
				} else {
			   		$tax_fixed = ($parent_Data['tax_value1'] > 0) ? (($parent_Data['sold_price']*$parent_Data['tax_value1'])/100) : '0';
			   	}

                if($parent_Data['bill_discount']>0){
					$discount_fixed = $parent_Data['bill_discount'];
			   	} else {
				   	//$discount_fixed = $parent_Data['discount'];
				   	$discount_fixed =0;
			   	}
				// echo '<pre>';print_r($parent_Data);die;
				

				$export_sold_price = number_format(($parent_Data['sold_price']),2);
				
				$export_discount = number_format(str_replace("-",'',$parent_Data['discount']),2);

				$export_tax = $parent_Data['tax_value1'] ? number_format($parent_Data['tax_value1'],2) : '0.00';
				$export_tax = $export_tax.'%';

				

				
				$export_grand_total = number_format(($parent_Data['sold_price']+$tax_fixed)-$discount_fixed,2);
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];



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
		$fileName = 'Inventory Report CSV.csv';
		
		$this->load->library('Excel');
		$data = array();
		$mem = array();
		$member = array();

		$start_date = $_POST['start_date'];
		$end_date =  $_POST['end_date'];
		$main_items = $_POST['main_items'];
		$merchant_id = $this->session->userdata('merchant_id');

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));

		$start_date1 = $start_date.' 00:00:01';
		$end_date1 = $end_date.' 23:59:59';
		$start_date1 = date('Y-m-d H:i:s', strtotime($start_date1.' +5 hours'));
		$end_date1 = date('Y-m-d H:i:s', strtotime($end_date1.' +5 hours'));

   		$start_date2 = date('Y-m-d', strtotime($start_date));
    	$end_date2 = date('Y-m-d', strtotime($end_date));
		
		$merchant_id = $this->session->userdata('merchant_id');
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
		$data['merchantdata'] = $getQuery1->result_array();

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

		$parent_sale1 = $this->Inventory_model->get_full_inventory_reportdata_sale($start_date1,$end_date1,$merchant_id,$main_items);
		$parent_sale2 = $this->Inventory_model->get_full_inventory_reportdata_sale_split($start_date1,$end_date1,$merchant_id,$main_items);

		//print_r($parent_sale2); die();
	
    	$parent_sale= array_merge($parent_sale1,$parent_sale2);

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
			} else {
			  	$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
			}

			if($a_data['bill_discount']>0){
				$discount_fixed = $a_data['bill_discount'];
			} else {
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
		   	} else {
		   		$tax_fixed = ($a_data['tax_value1'] > 0) ? (($a_data['sold_price']*$a_data['tax_value1'])/100) : '0';
		   	}
			
           	if($a_data['bill_discount']>0){
				$discount_fixed = $a_data['bill_discount'];
		   	} else {
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
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
			$rowCount++;
			
			$parent = $this->Inventory_model->get_full_inventory_reportdata($start_date1,$end_date1,$merchant_id,$a_data['main_item_id']);

			foreach ($parent as $parent_Data) {
                if($parent_Data['bill_tax']>0){   
					$tax_fixed = $parent_Data['bill_tax'];
				} else {
			   		$tax_fixed = ($parent_Data['tax_value1'] > 0) ? (($parent_Data['sold_price']*$parent_Data['tax_value1'])/100) : '0';
			   	}

                if($parent_Data['bill_discount']>0){
					$discount_fixed = $parent_Data['bill_discount'];
			   	} else {
				   	//$discount_fixed = $parent_Data['discount'];
				   	$discount_fixed =0;
			   	}
				// echo '<pre>';print_r($parent_Data);die;
				

				$export_sold_price = number_format(($parent_Data['sold_price']),2);
				
				$export_discount = number_format(str_replace("-",'',$parent_Data['discount']),2);

				$export_tax = $parent_Data['tax_value1'] ? number_format($parent_Data['tax_value1'],2) : '0.00';
				$export_tax = $export_tax.'%';

				

				
				$export_grand_total = number_format(($parent_Data['sold_price']+$tax_fixed)-$discount_fixed,2);
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];



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

}