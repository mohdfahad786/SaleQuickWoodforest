<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Inventory_model');
		$this->load->model('Inventory_graph_model');
		$this->load->helper('pdf_helper');
		$this->load->model('profile_model');
		$this->load->model('admin_model');
		$this->load->model('home_model');
		$this->load->library('email');
		$this->load->library('twilio');

		date_default_timezone_set("America/Chicago");
		
	}
	public function dateTimeConvertTimeZone($Adate) {
			if($this->session->userdata('time_zone')) {
				$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'';
				date_default_timezone_set('America/Chicago');
				if($time_Zone!='America/Chicago'){
					$datetime = new DateTime($Adate);
					$la_time = new DateTimeZone($time_Zone);
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				} else {
					$convertedDateTime=$Adate;
				}
				
				
			} else {
				$convertedDateTime=$Adate;
			}
			return $convertedDateTime; 
		}
		
		
		
		public function allreportpdf() {
		$data = array();
		$merchant_id = $this->uri->segment(3);
		$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		// echo "<pre>";print_r($merchant_data);die;

		
			
			$start_date = $id = $this->uri->segment(2); 
      
		if( !empty($this->uri->segment(4)) )
		{  $end_date=$this->uri->segment(4); } else { $end_date=$this->uri->segment(2);  }
			$status = '';
			$employee=0;
			
			$package_data_cash = $this->Inventory_graph_model->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CASH');
			$package_data_check = $this->Inventory_graph_model->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CHECK');
			//$package_data_online = $this->Inventory_graph_model->get_search_merchant_pos_type($start_date, $end_date, $status, $merchant_id,$employee, 'pos','ONLINE');
			$package_data_splite = $this->Inventory_graph_model->get_search_merchant_pos_type_split($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			
			$package_data_online = $this->Inventory_graph_model->get_search_merchant_pos_type_online($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_card = $this->Inventory_graph_model->get_search_merchant_pos_type_card($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_card_invoice = $this->Inventory_graph_model->get_search_merchant_pos_type_card_invoice($start_date, $end_date, $status, $merchant_id,$employee, 'customer_payment_request');
			$package_data_card_invoice_re = $this->Inventory_graph_model->get_search_merchant_pos_type_card_invoice_re($start_date, $end_date, $status, $merchant_id,$employee, 'recurring_payment');
			
			$package_data_cash_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CASH');
			
			$package_data_total_count = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_total_count_invoice = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'customer_payment_request');
			$package_data_total_count_invoice_re = $this->Inventory_graph_model->get_search_merchant_pos_total_count($start_date, $end_date, $status, $merchant_id,$employee, 'recurring_payment');
			
			//$package_data_total_pending = $this->Inventory_graph_model->get_search_merchant_pending_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			$package_data_total_pos_tip = $this->Inventory_graph_model->get_search_merchant_tip_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			$package_data_total_invoice_tip = $this->Inventory_graph_model->get_search_merchant_tip_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');
			
			$package_data_total_pos_tax = $this->Inventory_graph_model->get_search_merchant_tax_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			$package_data_total_invoice_tax = $this->Inventory_graph_model->get_search_merchant_tax_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');

			$package_data_total_pos_other_charges = $this->Inventory_graph_model->get_search_merchant_other_charges_total($start_date, $end_date,$merchant_id,$employee, 'pos');
			$package_data_total_invoice_other_charges = $this->Inventory_graph_model->get_search_merchant_other_charges_total($start_date, $end_date,$merchant_id,$employee, 'customer_payment_request');

			
			$package_data_check_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','CHECK');
			//$package_data_online_total = $this->Inventory_graph_model->get_search_merchant_pos_total($start_date, $end_date, $status, $merchant_id,$employee, 'pos','ONLINE');
			$package_data_online_total = $this->Inventory_graph_model->get_search_merchant_pos_total_online($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$package_data_card_total = $this->Inventory_graph_model->get_search_merchant_pos_total_card($start_date, $end_date, $status, $merchant_id,$employee, 'pos');
			$refund_data_search = $this->Inventory_graph_model->get_full_refund_data_search_pdf($start_date, $end_date,'pos', $merchant_id);



			$refund_data_search_invoice = $this->Inventory_graph_model->get_full_refund_data_search_pdf($start_date, $end_date,'customer_payment_request', $merchant_id);
			$refund_data_search_invoice_rec = $this->Inventory_graph_model->get_full_refund_data_search_pdf($start_date, $end_date,'recurring_payment', $merchant_id);
			
		$refund_data_cash = $this->Inventory_graph_model->get_full_refund_cash_check($start_date, $end_date,'pos',$merchant_id,'CASH');

$refund_data_check = $this->Inventory_graph_model->get_full_refund_cash_check($start_date, $end_date,'pos',$merchant_id,'CHECK');

$refund_data_card = $this->Inventory_graph_model->get_full_refund_card($start_date, $end_date,'pos',$merchant_id);

$refund_data_online = $this->Inventory_graph_model->get_full_refund_online($start_date, $end_date,'pos',$merchant_id);	
			
			
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];
			$data["status"] = $_POST['status'];
	
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
				//$each->add_date=$this->dateTimeConvertTimeZone($each->add_date);

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
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$datetime = new DateTime($each->add_date,new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');
				    $TransactiondateTime=$this->dateTimeConvertTimeZone($convertedDateTime);
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
        
		if (isset($refund_data)) {
			// print_r($refund_data);die;
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
                    // $each->refund_dt=$this->dateTimeConvertTimeZone($each->refund_dt);
					$datetime = new DateTime($each->refund_dt,new DateTimeZone('America/Vancouver'));
					$la_time = new DateTimeZone('America/Chicago'); // dggdgh
					$datetime->setTimezone($la_time);
					$convertedDateTime=$datetime->format('Y-m-d H:i:s');

					$newdate=$this->dateTimeConvertTimeZone($convertedDateTime);
					
					$package['id'] = $each->id;
					$package['refund_row_id'] = $each->refund_row_id;
					// $package['refund_row_id'] = "ABCD";
					$package['payment_id'] = $each->invoice_no;
					$package['name'] = $each->name;
					$package['email'] = $each->email_id;
					$package['mobile'] = $each->mobile_no;
					$package['repeiptmethod'] = $repeiptmethod;
					$package['c_type'] = $each->c_type;
					$package['transaction_id'] = $each->refund_transaction;
					// $package['amount'] = $each->amount;
					$package['amount'] = $each->refund_amount?$each->refund_amount:$each->amount;
					//$package['amount'] = $each->refund_amount;
					$package['date'] =$newdate;
					$package['status'] = "Refund";
					$package['card_no'] = $each->card_no;
					$package['card_type'] = $each->card_type;
					$mem[] = $package; 
				}
			}
		}
		array_multisort(array_column($mem, 'date'), SORT_DESC, $mem);
		//echo '<pre>'; print_r($mem) ; die; 
		$data['mem'] = $mem;
		
	

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Transaction Report";
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
	
		 $i = 0;
		 $total_item = 0;
		 $total_paid = 0;
		//foreach ($package_data_array as $aa_data) 
		//{
		//	$total = $aa_data['amount'];
			//$total_item = 	$i++;
			//$total_paid+= number_format(($total),2);
		//}
		
		 $j = 0;
		 $total_item_refund = 0;
		 $total_paid_refund = 0;
		foreach ($refund_data_search as $ab_data) 
		{
			$total = number_format(($ab_data['refund_amount']),2);
			$total_item_refund = 	$j++;
			$total_paid_refund+= $ab_data['refund_amount'];
		}
		
		$jj = 0;
		 $total_item_refund_invoice = 0;
		 $total_paid_refund_invoice = 0;
		foreach ($refund_data_search_invoice as $ab_data) 
		{
			$total = number_format(($ab_data['refund_amount']),2);
			$total_item_refund_invoice = 	$j++;
			$total_paid_refund_invoice+= $ab_data['refund_amount'];
		}
		$jjj = 0;
		 $total_item_refund_invoice_rec = 0;
		 $total_paid_refund_invoice_rec = 0;
		foreach ($refund_data_search_invoice_rec as $abc_data) 
		{
			$total = number_format(($abc_data['refund_amount']),2);
			$total_item_refund_invoice_rec = 	$j++;
			$total_paid_refund_invoice_rec+= $abc_data['refund_amount'];
		}
		
		 $k = 0;
		 $total_item_cash = 0;
		 $total_paid_cash = 0;
			foreach ($package_data_cash as $a_data) 
			{
				
			$total = number_format(($a_data['amount']),2);
			$total_item_cash = 	$k++;
			$total_paid_cash+= $total;
			
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				
			
		$count++;
		
			$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					
				     $TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));		
			  $textcolors .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }else
											 {
				$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
				$textcolors .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
				
			</tr>';
			
		}
		
		foreach ($package_data_splite as $a_data) 
			{
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				 	$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Split .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['invoice_no'].'</td>
				
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				
				<td width="10%" style="border-bottom:1px solid grey"></td>';
				
				
				
			
				$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
		
			
		if ($a_data['transaction_type'] == "split") {	
		$merchant_id = $this->session->userdata('merchant_id');
		$this->db->where('invoice_no', $a_data['invoice_no']);
		$this->db->where('merchant_id ', $merchant_id);
		$query = $this->db->get('pos');
		$split_payment = $query->result_array();
			
			//$parent = $this->Inventory_model->get_full_inventory_reportdata($data['start_date'],$data['end_date'],$merchant_id,$a_data['main_item_id']);
				foreach ($split_payment as $split_payment_Data) 
                        {
							
							 if ($split_payment_Data['status'] == 'pending') {
				$status =  ucfirst($split_payment_Data['status']) ;
			} elseif ($split_payment_Data['status'] == 'confirm' ||  $split_payment_Data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($split_payment_Data['status'] == 'declined') {
				$status = ucfirst($split_payment_Data['status']) ;
			} elseif ($split_payment_Data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($split_payment_Data['repeiptmethod']) && !empty($split_payment_Data['repeiptmethod']))? $split_payment_Data['repeiptmethod'] : 'No Receipt';	
				 	$pyadate=str_replace("-","",$split_payment_Data['express_transactiondate']);
				$paytime=str_replace(":","",$split_payment_Data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));

						 if($split_payment_Data['reference_numb_opay']!='0' && $split_payment_Data['reference_numb_opay']!=''){
                                   $split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']).'('.$split_payment_Data['reference_numb_opay'].')';
						 }	
						 else
						 {
                   $split_payment_Data['card_type'] = ucfirst($split_payment_Data['card_type']);
						 }
				 
							$textcolors_Split .= '<tr>
							
				<td width="21%" align="centre"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$split_payment_Data['transaction_id'].'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.($split_payment_Data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['transaction_type']).'</td>
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($split_payment_Data['amount'], 2).'</td>
				';
				
                                if ($merchant_data[0]->csv_Customer_name > 0) {
					$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$split_payment_Data['name'].'</td>';
											 }else
											 {
											$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				$textcolors_Split .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style=" border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($split_payment_Data['name']).'</td>
				
                
                      </tr>';
						 }
		 } 
						 
		  
		}
		
		$l = 0;
        $total_item_check = 0;
		$total_paid_check = 0;
		
		foreach ($package_data_check as $a_data) 
			{
				
			$total = number_format(($a_data['amount']),2);
            $total_item_check = 	$l++;
			$total_paid_check+= $total;
				
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
                 
				 	$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Check .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }else
											 {
				$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
				$textcolors_Check .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Check .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
		
		$m = 0;
        $total_item_online = 0;
		$total_paid_online = 0;
		
		foreach ($package_data_online as $a_data) 
			{
				$total = number_format(($a_data['amount']),2);
                $total_item_online = 	$m++;
			    $total_paid_online+= $total;
				
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
				 	$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
						if($a_data['reference_numb_opay']!='0' && $a_data['reference_numb_opay']!=''){
                                  // $a_data['card_type'] = $a_data['reference_numb_opay'];

                                    $a_data['card_type'] = ucfirst($a_data['card_type']).'('.$a_data['reference_numb_opay'].')';
						 }	
						 else
						 {
                   $a_data['card_type'] = ucfirst($a_data['card_type']);
						 }		
			  $textcolors_Online .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }else
											 {
				$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
				$textcolors_Online .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
					<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Online .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
	
		
		$n = 0;
        $total_item_card = 0;
		$total_paid_card = 0;
		
		foreach ($package_data_card as $a_data) 
			{
				$total = number_format(($a_data['amount']),2);
                $total_item_card = 	$n++;
			    $total_paid_card+= $total;
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';	
					$pyadate=str_replace("-","",$a_data['express_transactiondate']);
				$paytime=str_replace(":","",$a_data['express_transactiontime']);
				$each->express_transactiontimezone; //  UTC-05:00:00
      
				$PayYear=substr($pyadate,0,4); 
				$PayMonth=substr($pyadate,4,2); 
				$PayDay=substr($pyadate,6,2); 

				$PayHours=substr($paytime,0,2); 
				$PayMinut=substr($paytime,2,2); 
				$PaySecond=substr($paytime,4,2);
				
				if(!empty($PayYear) && !empty($PayMonth) && !empty($PayDay) &&  !empty($PayHours) && !empty($PayMinut) &&!empty( $PaySecond)){
				$payDateTime=$PayYear.'-'.$PayMonth.'-'.$PayDay.' '.$PayHours.':'.$PayMinut.':'.$PaySecond;  
				// $date = new DateTime($payDateTime, new DateTimeZone('UTC'));
                // $date->setTimezone(new DateTimeZone('America/Chicago'));
                // $convertedDatetime=$date->format('Y-m-d H:i:s'); 
			    $TransactiondateTime=$this->dateTimeConvertTimeZone($payDateTime); 
				}
				else {
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				}
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Card .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
		
		foreach ($package_data_card_invoice as $a_data) 
			{
				
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
               
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Card .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">Invoice</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
		
				foreach ($package_data_card_invoice_re as $a_data) 
			{
				
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
               
					$TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['add_date']);
				
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Card .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['transaction_id'].'</td>
				
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">R-Invoice</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Card .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Card .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Card .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}
		
				$o = 0;
        $total_item_card = 0;
		$total_paid_card = 0;
		
		foreach ($refund_data_search as $a_data) 
			{
				$total = number_format(($a_data['refund_amount']),2);
                $total_item_card = 	$o++;
			    $total_paid_card+= $total;
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
                 
                 $TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
				
						 $newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
			
								
			  $textcolors_Refund .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
				
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['transaction_type']).'</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}


		
		foreach ($refund_data_search_invoice as $a_data) 
			{
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
                 
                $TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
				
				$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
								
			  $textcolors_Refund .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
				
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">Invoice</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}

		foreach ($refund_data_search_invoice_rec as $a_data) 
			{
			
				if(!empty($a_data)) {
			 if ($a_data['status'] == 'pending') {
				$status =  ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm' ) {
				 $status = 'Paid';
			} elseif ($a_data['status'] == 'declined') {
				$status = ucfirst($a_data['status']) ;
			} elseif ($a_data['status'] == 'Refund') {
				 $status = ' Refund ';
			}		
                 $receipt = (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod']))? $a_data['repeiptmethod'] : 'No Receipt';
                 
                 $TransactiondateTime=$this->dateTimeConvertTimeZone($a_data['refund_dt']);
				
				$newdate = date("M d Y h:i A", strtotime($TransactiondateTime));
								
			  $textcolors_Refund .= '<tr>
				<td width="21%"  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" >'.$a_data['refund_transaction'].'</td>
				
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['card_type']).'</td>
				<td width="12%" style="border-bottom:1px solid grey;font-size: 10px;">R-Invoice</td>
				
				<td width="10%" style="border-bottom:1px solid grey">$ '.number_format($a_data['refund_amount'], 2).'</td>';
				
				if ($merchant_data[0]->csv_Customer_name > 0) {
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$a_data['name'].'</td>';
											 }
											 else
											 {
				$textcolors_Refund .= '<td  width="14%" style="border-bottom:1px solid grey;font-size: 10px;"></td>';	 
											 }
				
			
				$textcolors_Refund .= '<td width="14%" style="border-bottom:1px solid grey;font-size: 10px;">'.$newdate.'</td>
				<td width="8%" style="border-bottom:1px solid grey;font-size: 10px;">'.$status.'</td>
				<td width="9%" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">'.ucfirst($a_data['mname']).'</td>
			</tr>';
				}
				else{
					$textcolors_Refund .= '<tr> <td colspan="7">No Data</td>  </tr>';
				}
						 
		  
		}

		$html = '
		<style>
		.borderr {
  border: 2px solid red;
  padding: 10px;
  border-radius: 25px;
}
		</style>
		<table   cellpadding="3">
			<tr>
				
  <td align="left" colspan="4">
  <span style="font-size: 25px;font-weight:900;">'.ucfirst($data['merchantdata'][0]['business_name']).'</span> 
  <br >&nbsp;&nbsp;<span style="font-size: 15px;font-weight:800;">Transactions across all terminals  </span> 
 
				 </td>
				 <td>
				 </td>
				<td  align="left" colspan="3"> 
				</td>
			</tr>
			<tr>
				
					<td  align="left" colspan="5"> 
				&nbsp;Report Period: '.$enddate.', 12:00 am -- '.$startdate.', 11:59 pm
				<br>&nbsp;&nbsp; Generated -   '.$enddatee.'
				
				</td>
				
       <td align="left" colspan="2">
 
				 </td>
				 <td>
				 </td>
				 
			</tr>
			<tr>
				
					<td  align="left" colspan="4"> 
				&nbsp;Total # Transactions: '.(($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'])-($j+$jj+$jjj)).'
				
				</td>
				
       <td align="left" colspan="3">
 
				 </td>
				 <td>
				 </td>
				 
			</tr>
		</table>
		
		
		
		<hr style="padding-top:20px;padding-bottom:20px;">
		<h2>Summary</h2>
		<table   cellpadding="2" style="border: 1px solid grey;">
		<tr>
			<td style="border-bottom:1px solid grey;padding: 10px; border-radius: 10px;" align="left"> <h3>Net Total</h3> </td>
			<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount'])),2).'</h3> </td>
				
			</tr>
			<tr>
			<td style="border-bottom:1px solid grey;padding: 10px; border-radius: 10px;" align="left"> <h3>Other Charges</h3> </td>
			<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format(($package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount']),2).' </h3> </td>
				
			</tr>
			<tr>
				<td style="border-bottom:1px solid grey;padding: 10px; border-radius: 10px;" align="left"> <h3>Gross Total</h3> </td>
			<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($refund_data_total_new[0]['amount']+$package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount'])),2).'</h3> </td>
				
			</tr>
			
	
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Purchases ('.($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id']).')</h3> </td>
				<td align="right">  <h3> $'.number_format((($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']) -($package_data_total_pos_tax[0]['amount']+$package_data_total_invoice_tax[0]['amount'])),2).' </h3> </td>
				
			</tr>
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Refunds ('.($j+$jj+$jjj).')</h3> </td>
				<td align="right" > <h3>$'.number_format(($total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2).' </h3> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Tips ('.($package_data_total_pos_tip[0]['id']+$package_data_total_invoice_tip[0]['id']).')</h3> </td>
				<td align="right" > <h3>$'.number_format(($package_data_total_pos_tip[0]['amount']+$package_data_total_invoice_tip[0]['amount']),2).' </h3> </td>
				
			</tr>

			<tr>
				<td style="padding: 10px;" align="left"> <h3>Tax ('.($package_data_total_pos_tax[0]['id']+$package_data_total_invoice_tax[0]['id']).')</h3> </td>
				<td align="right" > <h3>$'.number_format(($package_data_total_pos_tax[0]['amount']+$package_data_total_invoice_tax[0]['amount']),2).' </h3> </td>
				
			</tr>

			<tr>
				<td style="padding: 10px;" align="left"> <h3>Other Charges ('.($package_data_total_pos_other_charges[0]['id']+$package_data_total_invoice_other_charges[0]['id']).')</h3> </td>
				<td align="right" > <h3>$'.number_format(($package_data_total_pos_other_charges[0]['amount']+$package_data_total_invoice_other_charges[0]['amount']),2).' </h3> </td>
				
			</tr>
		</table>
		
		
		
		<hr style="padding-top:20px;padding-bottom:20px;">
		<h2>Breakdown</h2>
		<table    cellpadding="2" style="border: 1px solid grey;">
		<tr >
			<td  style="border-bottom:1px solid grey;padding: 10px; border-radius:10px;" align="left"> <h3>Net Total</h3> </td>
			<td align="right" style="border-bottom:1px solid grey;"> <h3>$'.number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount'])-($total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2).'</h3> </td>
				
			</tr>
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Total Purchases ('.($package_data_total_count[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id']-$j+$jj+$jjj).')</h3> </td>
				<td align="right">  <h3> $'.number_format(($package_data_total_count[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2).' </h3></td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Cash Purchases ('.($package_data_cash_total[0]['id']-$refund_data_cash[0]['id']).')</span> </td>
				<td align="right"> <span style="font-size: 8px;"> $'.number_format(($package_data_cash_total[0]['amount']-$refund_data_cash[0]['amount']),2).' </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Card Purchases ('.($package_data_card_total[0]['id']+$package_data_total_count_invoice[0]['id']+$package_data_total_count_invoice_re[0]['id'] -$refund_data_card[0]['id']).')</span> </td>
				<td align="right">  <span style="font-size: 8px;"> $'.number_format(($package_data_card_total[0]['amount']+$package_data_total_count_invoice[0]['amount']+$package_data_total_count_invoice_re[0]['amount']-$refund_data_card[0]['amount']),2).' </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Check Purchases ('.($package_data_check_total[0]['id']-$refund_data_check[0]['id']).')</span> </td>
				<td align="right">  <span style="font-size: 8px;"> $'.number_format(($package_data_check_total[0]['amount']-$refund_data_check[0]['amount']),2).' </span> </td>
				
			</tr>
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Other Purchases ('.($package_data_online_total[0]['id']-$refund_data_online[0]['id']).')</span> </td>
				<td align="right">  <span style="font-size: 8px;"> $'.number_format(($package_data_online_total[0]['amount']-$refund_data_online[0]['amount']),2).' </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <h3>Refunds ('.($j+$jj+$jjj).')</h3> </td>
				<td align="right" > <h3>$'.number_format(($total_paid_refund+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2).' </h3> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Cash Refunds ('.$refund_data_cash[0]['id'].')</span> </td>
				<td align="right" > <span style="font-size: 8px;">$'.number_format($refund_data_cash[0]['amount'],2).'  </span> </td>
				
			</tr>
			
			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Card Refunds ('.($refund_data_card[0]['id']+$jj+$jjj).')</span> </td>
				<td align="right" > <span style="font-size: 8px;">$'.number_format(($refund_data_card[0]['amount']+$total_paid_refund_invoice+$total_paid_refund_invoice_rec),2).' </span> </td>
				
			</tr>

			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Check Refunds ('.$refund_data_check[0]['id'].')</span> </td>
				<td align="right" > <span style="font-size: 8px;">$'.number_format($refund_data_check[0]['amount'],2).'  </span> </td>
				
			</tr>

			<tr>
				<td style="padding: 10px;" align="left"> <span style="font-size: 8px;">Other Refunds ('.$refund_data_online[0]['id'].')</span> </td>
				<td align="right" > <span style="font-size: 8px;">$'.number_format($refund_data_online[0]['amount'],2).'  </span> </td>
				
			</tr>
		</table>
		
		
		
		
		
		
		<h3 style="padding: 10px;">Cash Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
				
			</tr>

			'.$textcolors.'
		   
		</table> ';
		
				$html_Check = '
		<h3 style="padding: 10px;">Check Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Check.'
		   
		</table> ';
		
		$html_Online = '
		<h3 style="padding: 10px;">Other Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Online.'
		   
		</table> ';
		
		$html_Card = '
		<h3 style="padding: 10px;">Card Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Card.'
		   
		</table> ';
		
			$html_Split= '
		<h3 style="padding: 10px;">Split Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Split.'
		   
		</table> ';
		
		$html_Refund= '
		<h3 style="padding: 10px;">Refund Purchases</h3>
		<table   cellpadding="2">
			<tr >
				<th width="21%" bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Transaction id</th>
               <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Payment Type</th>
			   <th width="12%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Transaction Type</th>
				<th width="10%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Amount</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Name on Card</th>
				<th width="14%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Date</th>
				<th width="8%" bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;">Status</th>
				<th  width="9%" bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;">Employee</th>
			</tr>

			'.$textcolors_Refund.'
		   
		</table> ';

		
		ob_end_clean();
		$obj_pdf->writeHTML($html, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Check, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Online, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Card, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Split, true, false, true, false, '');
		$obj_pdf->writeHTML($html_Refund, true, false, true, false, '');
		$obj_pdf->setDestination('Transaction Report', 0, '');
		$obj_pdf->Bookmark('Transaction Report', 0, 0, '', 'BI', array(128,0,0), -1, '#Transaction Report');
		$obj_pdf->Cell(0, 10, 'Transaction Report', 0, 1, 'L');
		$obj_pdf->Output();

				
				
		
	}

	public function allreportpdf_2() {
		$this->load->helper('pdf_helper');
		// $last_date = $id = $this->uri->segment(2);
		// $date = $id = $this->uri->segment(2);
		// $merchant_id = $this->uri->segment(3);

		$reporttype = $id = $this->uri->segment(1); 
		$last_date = $id = $this->uri->segment(2); 
        $merchant_id = $this->uri->segment(3);
		if( !empty($this->uri->segment(4)) )
		{  $date=$this->uri->segment(4); } else { $date=$this->uri->segment(2);  }


		// echo '<pre>';print_r($package_data);die;
		tcpdf();
		ob_start();
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetTitle('Transaction Report');
		$pdf->AddPage();

		$subject = 'Transaction Report';
		$pdf->SetFont('times', 'B', 16, '', 'false');
		$pdf->MultiCell(0, 5, $subject, 0, 'C', 0, 2, '', '', true);

		$tbl = '<html>
            <body>
                <table border="1" cellpading="5">
                    <tr>
                        <th><b>Amount</b></th>
						<th><b>Tax</b></th>
						<th><b>Refund</b></th>
                        <th><b>Card</b></th>
                        <th><b>Type</b></th>
                        <th><b>Date</b></th>
                        <th><b>Reference</b></th>
                    </tr>';

		$refund_amount = 0;
		$sum_amount = 0;
		$cash_amount=0;
		$card_amount=0;
		$package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
		foreach ($package_data as $each) {
			$pdf->SetFont('times', '', 12);
			$pdf->Ln(5);

			// if ($each->status == 'Chargeback_Confirm') {
			// 	$refund_amount += $each->amount;
			// }
			 $sum_amount += $each->amount;
			if($each->c_type=='CASH') { $cash_amount+= $each->amount;  } else {  $card_amount+= $each->amount; }
			$tbl .= '<tr>
                        <td>$' . $each->amount . '</td>
						<td>$' . $each->tax . '</td>
						<td>$0.00</td>
                        <td>' . Ucfirst($each->card_type) . '</td>
                        <td>' . (($each->type == 'straight') ? 'Invoice' : $each->type) . '</td>
                        <td>' . $each->date_c . '</td>
                        <td>' . $each->reference . '</td>
                    </tr>';

			// $pdf->writeHTML($tbl, true, false, false, false, '');
			// $pdf->Ln(15);
		}
		

		$refund_amount1 = 0;
		$sum_amount1 = 0;
		$cash_amount1=0;
		$card_amount1=0;
		$package_data1 = $this->admin_model->data_get_where_down("recurring_payment", $date, $last_date, $merchant_id);
		foreach ($package_data1 as $each) {
			$pdf->SetFont('times', '', 12);
			$pdf->Ln(5);

			if ($each->status == 'Chargeback_Confirm') {
				$refund_amount1 += $each->amount;
			} $sum_amount1 += $each->amount;
			if($each->c_type=='CASH') { $cash_amount1+= $each->amount;  } else {  $card_amount1+= $each->amount; }
			$tbl .= '<tr>
                        <td>$' . $each->amount . '</td>
						<td>$' . $each->tax . '</td>
						<td>$0.00</td>
                        <td>' . Ucfirst($each->card_type) . '</td>
                        <td>' . (($each->type == 'straight') ? 'INV' : $each->type) . '</td>
                        <td>' . $each->date_c . '</td>
                        <td>' . $each->reference . '</td>
                    </tr>';

			// $pdf->writeHTML($tbl, true, false, false, false, '');
			// $pdf->Ln(15);
		}

		$refund_amount2 = 0;
		$sum_amount2 = 0;
		$cash_amount2=0;
		$card_amount2=0;
		$package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
		foreach ($package_data2 as $each) {
			$pdf->SetFont('times', '', 12);
			// $pdf->Ln(5);
			if ($each->status == 'Chargeback_Confirm') {
				$refund_amount2 += $each->amount;
			} $sum_amount2 += $each->amount;
			if($each->c_type=='CASH') { $cash_amount2+= $each->amount;  } else {  $card_amount2+= $each->amount; }
			$tbl .= '<tr>
                        <td>$' . $each->amount . '</td>
						<td>$' . $each->tax . '</td>
						<td>$0.00</td>
                        <td>' . Ucfirst($each->card_type) . '</td>
                        <td>' . strtoupper($each->type) . '</td>
                        <td>' . $each->date_c . '</td>
                        <td>' . $each->reference . '</td>
                    </tr>';
		}


		if($this->uri->segment(1)=='monthlyreport')
		{
			$refund_amount3 = 0;
			$sum_amount3 = 0;
			$package_data_cr1 = $this->admin_model->get_report_refund_data("customer_payment_request", $last_date, $date, $merchant_id);
			//echo $this->db->last_query(); die("last query hy"); 
			foreach ($package_data_cr1 as $each) {
				$pdf->SetFont('times', '', 12);
				$pdf->Ln(5);
	
				if ($each->status == 'Chargeback_Confirm') {
					$refund_amount3 += $each->refund_amount;
				} 
				//$sum_amount3 += $each->amount;
				$returnAmount=($each->status == 'Chargeback_Confirm') ? number_format($each->refund_amount,2) : '0.00';
				$tbl .= '<tr>
							<td>$0.00</td>
							<td>$0.00</td>
							<td>$' . $returnAmount . '</td>
							<td>' . Ucfirst($each->card_type) . '</td>
							<td>' . (($each->type == 'straight') ? 'Invoice' : strtoupper($each->type)) . '</td>
							<td>' .date('Y-m-d', strtotime($each->refund_dt)). '</td>
							<td>' . $each->reference . '</td>
						</tr>';
	
				// $pdf->writeHTML($tbl, true, false, false, false, '');
				// $pdf->Ln(15);
			}
	// echo $refund_amount3;  die("refund Data"); 
			$refund_amount4 = 0;
			$sum_amount4 = 0;
			$package_data_cr2 = $this->admin_model->get_report_refund_data("pos",$last_date, $date, $merchant_id);
			foreach ($package_data_cr2 as $each) {
				$pdf->SetFont('times', '', 12); 
				$pdf->Ln(5);
	
				if ($each->status == 'Chargeback_Confirm') {
					$refund_amount4 += $each->refund_amount;
				} 
				//$sum_amount4 += $each->amount;
				$returnAmount=($each->status == 'Chargeback_Confirm' && $each->refund_amount ) ? number_format($each->refund_amount,2) : '0.00';  //  $each->refund_amount.  
				$tbl .= '<tr>
							<td>$0.00</td>
							<td>$0.00</td>
							<td>$ '.$returnAmount.'</td>  
							<td>' . Ucfirst($each->card_type) . '</td>
							<td>' . (($each->type == 'straight') ? 'Invoice' : strtoupper($each->type)) . '</td>
							<td>' .date('Y-m-d', strtotime($each->refund_dt)). '</td>
							<td>' . $each->reference . '</td>
						</tr>';
	
				// $pdf->writeHTML($tbl, true, false, false, false, '');
				// $pdf->Ln(15);
			}
		}
		else
		{
                    $refund_amount3 = 0;
					$sum_amount3 = 0;
					$package_data_cr = $this->admin_model->get_report_refund_data("customer_payment_request", $date, $last_date, $merchant_id);
					foreach ($package_data_cr as $each) {
						$pdf->SetFont('times', '', 12);
						$pdf->Ln(5);

						if ($each->status == 'Chargeback_Confirm') {
							$refund_amount3 += $each->refund_amount;
						} 
						//$sum_amount3 += $each->amount;
						$returnAmount=($each->refund_amount ) ? number_format($each->refund_amount,2) : '0.00'; 
						$tbl .= '<tr>
									<td>$0.00</td>
									<td>$0.00</td>
									<td>$' .$returnAmount. '</td>
									<td>' . Ucfirst($each->card_type) . '</td>
									<td>' . (($each->type == 'straight') ? 'Invoice' : strtoupper($each->type)) . '</td>
									<td>' . date('Y-m-d', strtotime($each->refund_dt)) . '</td>
									<td>' . $each->reference . '</td>
								</tr>';

						// $pdf->writeHTML($tbl, true, false, false, false, '');
						// $pdf->Ln(15);
					}
					$refund_amount4 = 0;
					$sum_amount4 = 0;
					$package_data_cr = $this->admin_model->get_report_refund_data("pos", $date, $last_date, $merchant_id);
					foreach ($package_data_cr as $each) {
						$pdf->SetFont('times', '', 12);
						$pdf->Ln(5);

						if ($each->status == 'Chargeback_Confirm') {
							$refund_amount4 += $each->refund_amount;
						} 
						//$sum_amount4 += $each->amount;
						$returnAmount=($each->refund_amount) ? number_format($each->refund_amount,2) : '0.00'; 
						$tbl .= '<tr>
									<td>$0.00</td>
									<td>$0.00</td>
									<td>$ '.$returnAmount.'</td>
									<td>' . Ucfirst($each->card_type) . '</td>
									<td>' . (($each->type == 'straight') ? 'Invoice' :strtoupper($each->type)) . '</td>
									<td>' . date('Y-m-d', strtotime($each->refund_dt)) . '</td>
									<td>' . $each->reference . '</td>
								</tr>';

						// $pdf->writeHTML($tbl, true, false, false, false, '');
						// $pdf->Ln(15);
					}
		}
		

		$total_sum_amount = ($sum_amount + $sum_amount1 + $sum_amount2+$sum_amount3+$sum_amount4);
		//$total_refund_amount = (float)($refund_amount + $refund_amount1 + $refund_amount2+$refund_amount3+$refund_amount4);
		$total_refund_amount = (float)($refund_amount3+$refund_amount4);
       
		$total_amount=$total_sum_amount-$total_refund_amount; 
		$cashAmount=$cash_amount+$cash_amount1+$cash_amount2;
		$cardAmount=$card_amount+$card_amount1+$card_amount2;

		$tbl .= '

				<tr>
				     <td colspan="3"><b>Total Card Amount</b> = $ ' . number_format($cardAmount,2). '</td>
				</tr>
				<tr>
				    <td colspan="3"><b>Total Cash Amount</b> = $ ' . number_format($cashAmount,2). '</td>
				</tr>
				<tr>
                    <td colspan="3"><b>Sum Amount</b> = $ ' . number_format($total_sum_amount,2) . '</td>
                </tr>
                <tr>
                    <td colspan="3"><b>Refund Amount</b> = $ ' .number_format( $total_refund_amount,2) . '</td>
				</tr>
				<tr>
                    <td colspan="3"><b>Total Amount</b> = $ ' .number_format($total_amount,2). '</td>
                </tr>
            </table>
            </body>
            </html>';
		$pdf->Ln(5);
		$pdf->writeHTML($tbl, true, false, false, false, '');
		$pdf->output();

		ob_end_flush();
	}

	public function  myreport() {
		$data = array();
		$get_merchant_data = $this->admin_model->get_merchant_data();
		if (!empty($get_merchant_data)) {
			$i=1; 
			foreach ($get_merchant_data as $key => $value) {
				 $merchant_id = $value->id; 
				$report_type = $value->report_type;
				echo "<h3>".$report_type."</h3>";
				$arraydata = explode(',', $report_type); 
				$report_email = $value->report_email;
				$email = $value->email;
				if (in_array("daily", $arraydata)) {  //   $report_type == 'daily' 
					echo "<br/>".'Daily Report <br/>';
				}
				if (in_array("monthly", $arraydata)) {  // $report_type == 'monthly' 
					echo "<br/>".'Monthly Report <br/>'; 
				}
			    if (in_array("weekly", $arraydata)) {  // $report_type == 'weekly' 
				   echo "<br/>".'Weekly Report <br/>'; 
				}
				echo "--".$i."<br/>"; 

				$i++; 
			}
		}
	}
  

	public function rm() {
		$data = array();
		// echo "this is the report";die;
		$get_merchant_data = $this->admin_model->get_merchant_data();
		// echo "<pre>";print_r($get_merchant_data);die;
		if (!empty($get_merchant_data)) {  $i=1;  $dailyCount=0;  $monthlyCount=0;
			foreach ($get_merchant_data as $key => $value) {
				// $merchant_id = $this->session->userdata('merchant_id');
				
				 $merchant_id = $value->id;
				 $report_type = $value->report_type; //die("oki"); 
				 echo "<h3>".$report_type."</h3>";
				$reportsType=explode(",",$report_type);  
                
				$report_email =$value->report_email;
				$email = $value->email;
				if (in_array("daily",$reportsType)) { 
					$dailyCount++; 
					echo "<br/>".'Daily Report <br/>';
					  

				}
				if (in_array("monthly", $reportsType)) {  //$report_type == 'monthly'  
					$monthlyCount++; 
					echo "<br/>".'Monthly Report <br/>'; 
					
				}
			    // if (in_array("weekly", $reportsType)) {  //$report_type == 'weekly' 
				//    echo "<br/>".'Weekly Report <br/>'; 
				// }
				echo "--".$i."<br/>"; 
				$i++; 

			}

			echo "dailyCount : ".$dailyCount;
			echo "monthlyCount : ".$monthlyCount; 

		}

	}

		


	public function email_report1() {
		$data = array();
		// echo "this is the report";die;
		$get_merchant_data = $this->admin_model->get_merchant_data_new();
		// echo "<pre>";print_r($get_merchant_data);die;
		if (!empty($get_merchant_data)) { 
			foreach ($get_merchant_data as $key => $value) {
				// $merchant_id = $this->session->userdata('merchant_id');
				 $merchant_id = $value->id;
				 $report_type = $value->report_type; 
				 $reportsType=explode(",",$report_type);
				// echo "d<pre>";print_r($report_type);
				 if (in_array("daily",$reportsType)) {

				 	echo "d<pre>";print_r($merchant_id);
				 }


				}}}


				public function email_report2() {
		$data = array();
		// echo "this is the report";die;
		$get_merchant_data = $this->admin_model->get_merchant_data_new();
		// echo "<pre>";print_r($get_merchant_data);die;
		if (!empty($get_merchant_data)) { 
			foreach ($get_merchant_data as $key => $value) {
				// $merchant_id = $this->session->userdata('merchant_id');
				 $merchant_id = $value->id;
				 $report_type = $value->report_type; 
				 $reportsType=explode(",",$report_type);
				// echo "d<pre>";print_r($report_type);
				 if (in_array("monthly",$reportsType)) {

				 	echo "m<pre>";print_r($merchant_id);
				 }


				}}}

	public function email_report() {
		$data = array();
		// echo "this is the report";die;
		$get_merchant_data = $this->admin_model->get_merchant_data_new();
		// echo "<pre>";print_r($get_merchant_data);die;
		if (!empty($get_merchant_data)) { 
			foreach ($get_merchant_data as $key => $value) {
				// $merchant_id = $this->session->userdata('merchant_id');
				 $merchant_id = $value->id;
				 $report_type = $value->report_type; 
				 echo "d<pre>";print_r($report_type);
				// die("oki"); 
				$reportsType=explode(",",$report_type);
                
				$report_email =$value->report_email;
				$email = $value->email;
				if (in_array("daily",$reportsType)) {
					$last_date = date("Y-m-d", strtotime("-1 days"));
					$date = date("Y-m-d", strtotime("-1 days"));
					$package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
					// echo "<pre>";print_r($package_data);
					// die;
					$mem = array();
					$member = array();
					$sum = 0;
					$sum_ref = 0;
					if (!empty($package_data)) {
						foreach ($package_data as $key => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package['Amount'] = '-$' . $each->amount;
								$sum_ref += $each->amount;
							} else {
								$package['Amount'] = '$' . $each->amount;
								
							}$sum += $each->amount;
							$package['Tax'] = $each->tax;
							$package['Card'] = Ucfirst($each->card_type);
							if ($each->type = 'straight') {
								$package['Type'] = 'INV';
							} else {
								$package['Type'] = $each->type;
							}
							$package['Date'] = $each->date_c;
							$package['Referece'] = $each->reference;
							$mem[] = $package;
						}
						$data['item'] = $mem;
						$invoice_count = $key + 1;
						// echo "<br>";
					} else {
						$invoice_count = 0;
					}
					$package_data1 = $this->admin_model->data_get_where_down("recurring_payment", $date, $last_date, $merchant_id);
					// echo "<pre>";print_r($package_data1);
					$mem1 = array();
					$member1 = array();
					$sum1 = 0;
					$sum_ref1 = 0;
					if (!empty($package_data1)) {
						foreach ($package_data1 as $key1 => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package1['Amount'] = '-$' . $each->amount;
								$sum_ref1 += $each->amount;
							} else {
								$package1['Amount'] = '$' . $each->amount;
								
							}$sum1 += $each->amount;
							$package1['Tax'] = '$' . $each->tax;
							$package1['Card'] = Ucfirst($each->card_type);
							if ($each->type = 'recurring') {
								$package1['Type'] = 'INV';
							} else {
								$package1['Type'] = $each->type;
							}
							$package1['Date'] = $each->date_c;
							$package1['Referece'] = $each->reference;
							$mem1[] = $package1;
						}
						$data['item1'] = $mem1;
						$recurring_payment_count = $key1 + 1;
					} else {
						$recurring_payment_count = 0;
					}
					$package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
					// echo "<pre>";print_r($package_data2);
					$mem2 = array();
					$member2 = array();
					$sum2 = 0;
					$sum_ref2 = 0;
					if (!empty($package_data2)) {
						foreach ($package_data2 as $key2 => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package2['Amount'] = '-$' . $each->amount;
								$sum_ref2 += $each->amount;
							} else {
								$package2['Amount'] = '$' . $each->amount;
								
							}$sum2 += $each->amount;
							$package2['Tax'] = '$' . $each->tax;
							$package2['Card'] = Ucfirst($each->card_type);
							$package2['Type'] = strtoupper($each->type);
							$package2['Date'] = $each->date_c;
							$package2['Referece'] = $each->reference;
							$mem2[] = $package2;
						}
						$data['item2'] = $mem2;
						$pos_count = $key2 + 1;
						// echo "<br>";
					} else {
						$pos_count = 0;
					}
                    ####################################
					$package_data3 = $this->admin_model->get_report_refund_data("pos", $date, $last_date, $merchant_id);
					$sum_ref3 = 0;
					if (!empty($package_data3)) {
						foreach ($package_data3 as $key2 => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package2['Amount'] = '-$' . $each->refund_amount;
								$sum_ref3 = $sum_ref3+$each->refund_amount;
							} 
							
						}
					} 
					
					$package_dat5 = $this->admin_model->get_report_refund_data("customer_payment_request", $date, $last_date, $merchant_id);
					$sum_ref5 = 0;
					if (!empty($package_data5)) {
						foreach ($package_data5 as $key2 => $each) {
							if ($each->status == 'Chargeback_Confirm') {
								$package2['Amount'] = '-$' . $each->refund_amount;
								$sum_ref5 = $sum_ref5+$each->refund_amount;
							} 
							
						}
					} 

					
					$totalsum=($sum + $sum1 + $sum2);
					// $totalsumr=(float)($sum_ref + $sum_ref1 + $sum_ref2+$sum_ref3+$sum_ref5);
					$totalsumr=(float)($sum_ref3+$sum_ref5);
					$totalamount=$totalsum-$totalsumr; 

					$reporting_data['invoice_count'] = $invoice_count;
					$reporting_data['recurring_payment_count'] = $recurring_payment_count;
					$reporting_data['pos_count'] = $pos_count;
					$reporting_data['total_transaction'] = ($invoice_count + $recurring_payment_count + $pos_count);
					$reporting_data['totalsum'] = '$' . number_format($sum + $sum1 + $sum2, 2);
					$reporting_data['totalsumr'] = '$' . number_format($sum_ref3+$sum_ref5, 2);
					$reporting_data['totalamount'] = '$' . number_format($totalamount,2);
					$reporting_data['business_dba_name'] = $value->business_dba_name;
					$reporting_data['mob_no'] = $value->mob_no;
					$reporting_data['email'] = $value->email;
					$reporting_data['logo'] = $value->logo;
					$reporting_data['address1'] = $value->address1;
					$reporting_data['report_type'] = "Daily";
					$reporting_data['report_email'] = $report_email;
					$reporting_data['totalsum_email'] = number_format($sum + $sum1 + $sum2, 2);
					$reporting_data['pdf_link'] = 'https://salequick.com/dailyreport/' . $last_date . '/' . $merchant_id;
					// echo "<pre>";print_r($reporting_data);die;
					// die;
					// $data['msgData'] = $data;

					//$msg = $this->load->view('email/reporting', $reporting_data, true);

					// if($reporting_data['totalsum_email'] > 0) {

					if (!empty($email) && empty($report_email)) {  
						$this->email->from('info@salequick.com', 'SaleQuick');
						//$this->email->to($email);
					    $this->email->to('vaibhav.angad@gmail.com');
						$this->email->subject('Salequick Reporting');
						$this->email->message($msg);
						//$this->email->send();
					} else {  
						$this->email->from('info@salequick.com', 'SaleQuick');
						//$this->email->to($report_email);
						$this->email->to('vaibhav.angad@gmail.com');
						$this->email->subject('Salequick Reporting');
						$this->email->message($msg);
						//$this->email->send();
					}
					 
					

				}
				// else if($report_type == 'weekly'){
				//     $last_date = date("Y-m-d",strtotime("-1 days"));
				//     $date = date("Y-m-d",strtotime("-1 days"));
				//     $package_data = $this->admin_model->data_get_where_down("customer_payment_request",$date,$last_date,$merchant_id);
				//     // echo "<pre>";print_r($package_data);
				//     // die;
				//     $mem = array();
				//     $member = array();
				//     $sum = 0;
				//     $sum_ref = 0;
				//     if(!empty($package_data)){
				//         foreach($package_data as $key => $each){
				//             if($each->status=='Chargeback_Confirm'){
				//                 $package['Amount'] = '-$'.$each->amount;
				//                 $sum_ref+= $each->amount;
				//             }else{
				//                 $package['Amount'] = '$'.$each->amount;
				//                 $sum+= $each->amount;
				//             }
				//             $package['Tax'] = $each->tax;
				//             $package['Card'] = Ucfirst($each->card_type);
				//             if($each->type='straight'){
				//                 $package['Type'] = 'INV';
				//             }else{
				//                 $package['Type'] = $each->type;
				//             }
				//             $package['Date'] = $each->date_c;
				//             $package['Referece'] = $each->reference;
				//             $mem[] = $package;
				//         }
				//         $data['item'] = $mem;
				//         $invoice_count =  $key+1;
				//         // echo "<br>";
				//     }else{
				//         $invoice_count = 0;
				//     }
				//     $package_data1 = $this->admin_model->data_get_where_down("recurring_payment",$date,$last_date,$merchant_id);
				//     // echo "<pre>";print_r($package_data1);
				//     $mem1 = array();
				//     $member1 = array();
				//     $sum1 = 0;
				//     $sum_ref1 = 0;
				//     if(!empty($package_data1)){
				//         foreach($package_data1 as $key1 => $each){
				//             if($each->status=='Chargeback_Confirm'){
				//                 $package1['Amount'] = '-$'.$each->amount;
				//                 $sum_ref1+= $each->amount;
				//             }else{
				//                 $package1['Amount'] = '$'.$each->amount;
				//                 $sum1+= $each->amount;
				//             }
				//             $package1['Tax'] = '$'.$each->tax;
				//             $package1['Card'] = Ucfirst($each->card_type);
				//             if($each->type='recurring'){
				//                 $package1['Type'] = 'INV';
				//             }else{
				//                 $package1['Type'] = $each->type;
				//             }
				//             $package1['Date'] = $each->date_c;
				//             $package1['Referece'] = $each->reference;
				//             $mem1[] = $package1;
				//         }
				//         $data['item1'] = $mem1;
				//         $recurring_payment_count =  $key1+1;
				//     }else{
				//         $recurring_payment_count = 0;
				//     }
				//     $package_data2 = $this->admin_model->data_get_where_down("pos",$date,$last_date,$merchant_id);
				//     // echo "<pre>";print_r($package_data2);
				//     $mem2 = array();
				//     $member2 = array();
				//     $sum2 = 0;
				//     $sum_ref2 = 0;
				//     if(!empty($package_data2)){
				//         foreach($package_data2 as $key2  => $each){
				//             if($each->status=='Chargeback_Confirm'){
				//                 $package2['Amount'] = '-$'.$each->amount;
				//                 $sum_ref2+= $each->amount;
				//             }else{
				//                 $package2['Amount'] = '$'.$each->amount;
				//                 $sum2+= $each->amount;
				//             }
				//             $package2['Tax'] = '$'.$each->tax;
				//             $package2['Card'] = Ucfirst($each->card_type);
				//             $package2['Type'] = strtoupper($each->type);
				//             $package2['Date'] = $each->date_c;
				//             $package2['Referece'] = $each->reference;
				//             $mem2[] = $package2;
				//         }
				//         $data['item2'] = $mem2;
				//         $pos_count =  $key2+1;
				//         // echo "<br>";
				//     }else{
				//         $pos_count = 0;
				//     }
				//     $reporting_data['invoice_count'] = $invoice_count;
				//     $reporting_data['recurring_payment_count'] = $recurring_payment_count;
				//     $reporting_data['pos_count'] = $pos_count;
				//     $reporting_data['total_transaction'] = ($invoice_count+$recurring_payment_count+$pos_count);
				//     $reporting_data['totalsum'] = '$'.number_format($sum + $sum1 + $sum2,2);
				//     $reporting_data['totalsumr'] = '$'.number_format($sum_ref + $sum_ref1 + $sum_ref2,2);
				//     $reporting_data['business_dba_name'] = $value->business_dba_name;
				//     $reporting_data['mob_no'] = $value->mob_no;
				//     $reporting_data['email'] = $value->email;
				//     $reporting_data['logo'] = $value->logo;
				//     $reporting_data['address1'] = $value->address1;
				//     $reporting_data['report_type'] = $report_type;
				//     // echo "<pre>";print_r($reporting_data);die;
				//     // die;
				//     // $data['msgData'] = $data;
				//     $msg = $this->load->view('email/reporting', $reporting_data, true);
				//     if(!empty($email) && empty($report_email)){
				//         $this->email->from('info@salequick.com', 'SaleQuick');
				//         $this->email->to($email);
				//         $this->email->subject('Salequick Reporting');
				//         $this->email->message($msg);
				//         $this->email->send();
				//     }else{
				//         $this->email->from('info@salequick.com', 'SaleQuick');
				//         $this->email->to($report_email);
				//         $this->email->subject('Salequick Reporting');
				//         $this->email->message($msg);
				//         $this->email->send();
				//     }
				// }
				   
				if (in_array("monthly", $reportsType)) {
					$Currentdate = date("Y-m-d");    
					// First day of the month.
					$Starting_date=date('Y-m-01', strtotime($Currentdate));
				if( $Currentdate == $Starting_date  ) //   $Currentdate == $Starting_date
				{
					
					    $month_ini = new DateTime("first day of last month");
						$month_end = new DateTime("last day of last month");
						$last_date=$month_ini->format('Y-m-d'); // 2012-02-01
						$date=$month_end->format('Y-m-d'); // 2012-02-29

						 //die("in the condition "); 
						 //$package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
						 $package_data = $this->admin_model->data_get_where_down("customer_payment_request", $date, $last_date, $merchant_id);
						 //echo $this->db->last_query();  die("okl"); 
						 // echo "<pre>";print_r($package_data);
						 // die;
						 $mem = array();
						 $member = array();
						 $sum = 0;
						 $sum_ref = 0;
						 if (!empty($package_data)) {
							 foreach ($package_data as $key => $each) {
								 if ($each->status == 'Chargeback_Confirm') {
									 $package['Amount'] = '-$' . $each->amount;
									 $sum_ref += $each->amount;
								 } else {
									 $package['Amount'] = '$' . $each->amount;
									 
								 }$sum += $each->amount;
								 $package['Tax'] = $each->tax;
								 $package['Card'] = Ucfirst($each->card_type);
								 if ($each->type = 'straight') {
									 $package['Type'] = 'INV';
								 } else {
									 $package['Type'] = $each->type;
								 }
								 $package['Date'] = $each->date_c;
								 $package['Referece'] = $each->reference;
								 $mem[] = $package;
							 }
							 $data['item'] = $mem;
							 $invoice_count = $key + 1;
							 // echo "<br>";
						 } else {
							 $invoice_count = 0;
						 }
	 
						 
						 $package_data1 = $this->admin_model->data_get_where_down("recurring_payment", $date, $last_date, $merchant_id);
						 // echo "<pre>";print_r($package_data1);
						 $mem1 = array();
						 $member1 = array();
						 $sum1 = 0;
						 $sum_ref1 = 0;
						 if (!empty($package_data1)) {
							 foreach ($package_data1 as $key1 => $each) {
								 if ($each->status == 'Chargeback_Confirm') {
									 $package1['Amount'] = '-$' . $each->amount;
									 $sum_ref1 += $each->amount;
								 } else {
									 $package1['Amount'] = '$' . $each->amount;
									 
								 }$sum1 += $each->amount;
								 $package1['Tax'] = '$' . $each->tax;
								 $package1['Card'] = Ucfirst($each->card_type);
								 if ($each->type = 'recurring') {
									 $package1['Type'] = 'INV';
								 } else {
									 $package1['Type'] = $each->type;
								 }
								 $package1['Date'] = $each->date_c;
								 $package1['Referece'] = $each->reference;
								 $mem1[] = $package1;
							 }
							 $data['item1'] = $mem1;
							 $recurring_payment_count = $key1 + 1;
						 } else {
							 $recurring_payment_count = 0;
						 }
						 $package_data2 = $this->admin_model->data_get_where_down("pos", $date, $last_date, $merchant_id);
						 // echo "<pre>";print_r($package_data2);
						 $mem2 = array();
						 $member2 = array();
						 $sum2 = 0;
						 $sum_ref2 = 0;
						 if (!empty($package_data2)) {
							 foreach ($package_data2 as $key2 => $each) {
								 if ($each->status == 'Chargeback_Confirm') {
									 $package2['Amount'] = '-$' . $each->amount;
									 $sum_ref2 += $each->amount;
								 } else {
									 $package2['Amount'] = '$' . $each->amount;
									 
								 }$sum2 += $each->amount;
								 $package2['Tax'] = '$' . $each->tax;
								 $package2['Card'] = Ucfirst($each->card_type);
								 $package2['Type'] = strtoupper($each->type);
								 $package2['Date'] = $each->date_c;
								 $package2['Referece'] = $each->reference;
								 $mem2[] = $package2;
							 }
							 $data['item2'] = $mem2;
							 $pos_count = $key2 + 1;
							 // echo "<br>";
						 } else {
							 $pos_count = 0;
						 }
							 ####################################
						 
						 
						 $package_data5 = $this->admin_model->get_report_refund_data("customer_payment_request", $last_date, $date,  $merchant_id);
						 
						 $sum_ref5 = 0;
						 if (count($package_data5) > 0 ) {
							 
							 foreach ($package_data5 as $key2 => $each) {
								 $sum_ref5 =$sum_ref5+$each->refund_amount;
								 //echo $each->refund_amount; 
								 //echo "hello";
							 }
						 }  
						 
						 $package_data3 = $this->admin_model->get_report_refund_data("pos", $last_date,$date,  $merchant_id);
						 $sum_ref3 = 0;
						 if (count($package_data3) > 0) {
							 foreach ($package_data3 as $key2 => $each) {
								 $sum_ref3 = $sum_ref3+$each->refund_amount;
							 }
						 } 
	 
						 
	 
						 $totalsum=($sum + $sum1 + $sum2);   
						 // $totalsumr=(float)($sum_ref + $sum_ref1 + $sum_ref2+$sum_ref3+$sum_ref5);
						 $totalsumr=(float)($sum_ref3+$sum_ref5);  
						 $totalamount=$totalsum-$totalsumr; 
						 
					
					

					$reporting_data['invoice_count'] = $invoice_count;
					$reporting_data['recurring_payment_count'] = $recurring_payment_count;
					$reporting_data['pos_count'] = $pos_count;
					$reporting_data['total_transaction'] = ($invoice_count + $recurring_payment_count + $pos_count);
					$reporting_data['totalsum'] = '$' . number_format($sum + $sum1 + $sum2, 2);
					$reporting_data['totalsumr'] = '$' . number_format($sum_ref3+$sum_ref5, 2);
					$reporting_data['totalamount'] = '$' . number_format($totalamount,2);

					$reporting_data['business_dba_name'] = $value->business_dba_name;
					$reporting_data['mob_no'] = $value->mob_no;
					$reporting_data['email'] = $value->email;
					$reporting_data['logo'] = $value->logo;
					$reporting_data['address1'] = $value->address1;
					$reporting_data['report_type'] = "Monthly";
					$reporting_data['pdf_link'] = base_url().'monthlyreport/' . $last_date . '/'. $merchant_id.'/'.$date;
					// echo "<pre>";print_r($reporting_data);die;
					// die;
					// $data['msgData'] = $data;

					//$msg = $this->load->view('email/reporting', $reporting_data, true);

					if (!empty($email) && empty($report_email)) { 
						$this->email->from('info@salequick.com', 'SaleQuick');
						//$this->email->to($email);
						 $this->email->to("vaibhav.angad@gmail.com");
						$this->email->subject('Salequick Reporting');
						$this->email->message($msg);
					    //$this->email->send();
					} else {   
						$this->email->from('info@salequick.com', 'SaleQuick');
						//$this->email->to($report_email);
						 $this->email->to("vaibhav.angad@gmail.com");
						$this->email->subject('Salequick Reporting');
						$this->email->message($msg);
						//$this->email->send();
					}
					

				 }

				}
			}

			

		}
	}
}