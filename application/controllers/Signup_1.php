<?php 
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}
	class Signup extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->library('form_validation');
			$this->load->model('Home_model');
			$this->load->model('login_model');
			$this->load->model('Admin_model');
			$this->load->library('email');
			$this->load->library('twilio');
			date_default_timezone_set("America/Chicago");
		}
		
		  
		public function newsignup() {
			if ($this->session->userdata('last_merchantId')) {
				$last_merchantId = $this->session->userdata('last_merchantId');
				$this->db->where('id', $last_merchantId);
				$data['Merchant'] = $this->db->get('merchant')->row_array();
			} else {
				$data['Merchant'] = array();
			}

			$this->load->view('newsignup', $data);
		}
		public function index2() {
			if ($this->session->userdata('last_merchantId')) {
				$last_merchantId = $this->session->userdata('last_merchantId');
				$this->db->where('id', $last_merchantId);
				$data['Merchant'] = $this->db->get('merchant')->row_array();
			} else {
				$data['Merchant'] = array();
			}
			$this->load->view('signup', $data);
		}

		public function index() {
			if ($this->session->userdata('last_merchantId')) {
				$last_merchantId = $this->session->userdata('last_merchantId');
				$this->db->where('id', $last_merchantId);
				$data['Merchant'] = $this->db->get('merchant')->row_array();
				$data['business_owner'] = $this->db->where('merchant_id_arr', $last_merchantId)->get('business_owner')->result_array();
				// echo '<pre>';print_r($data['business_owner']);die;
			} else {
				$data['Merchant'] = array();
			}
			$this->load->view('signup', $data);
		}
		// sign up step new change

		public function stepfour_signup_new() {

			//$name = $this->input->post('mbname') ? $this->input->post('mbname') : "";
			//$mobile = $this->input->post('mphone') ? $this->input->post('mphone') : "";
			//$email = $this->input->post('memail') ? $this->input->post('memail') : "";
			$last_merchantId = $this->session->userdata('last_merchantId');
			$this->db->where('id', $last_merchantId);
			$getresult = $this->db->get('merchant')->row_array();
			// print_r($getresult['mob_no']); die();
			$name = $getresult['name'];
			$mobile = $getresult['mob_no'] ? $getresult['mob_no'] : $getresult['business_number'];
			$email = $getresult['email'];

			$routeNo = htmlspecialchars($this->input->post('routeNo') ? $this->input->post('routeNo') : '');
			$confrouteNo = htmlspecialchars($this->input->post('confrouteNo') ? $this->input->post('confrouteNo') : "");
			if ($routeNo == $confrouteNo) {
				$routingno = $this->input->post('routeNo');
			} else {
				echo '400';
			}

			$accountnumber_one = htmlspecialchars($this->input->post('accno') ? $this->input->post('accno') : '');
			$caccountnumber = htmlspecialchars($this->input->post('confaccno') ? $this->input->post('confaccno') : "");
			if ($accountnumber_one == $caccountnumber) {
				$accountnumber = $this->input->post('accno');
			} else {
				echo '400';
			}
			$bank_dda = $this->input->post('bank_dda_type') ? $this->input->post('bank_dda_type') : '';
			$bank_ach = $this->input->post('baccachtype') ? $this->input->post('baccachtype') : '';

			// start infinicept api

          // $activation_id =$this->input->post('activation_id')? $this->input->post('activation_id'):'';
			$address1 = $getresult['address1'] ? $getresult['address1']:'';
			$amexrate ='2.70';
			$annual_cc_sales_vol = $getresult['annual_processing_volume'] ? $getresult['annual_processing_volume']:'0';
			$annual_processing_volume = $getresult['annual_processing_volume'] ? $getresult['annual_processing_volume']:'';
			$bank_account = $accountnumber ? $accountnumber :'';
			$bank_ach = $bank_ach ? $bank_ach:'';
			$bank_dda = $bank_dda ? $bank_dda:'';
			$bank_routing = $routingno ? $routingno :'';

			$billing_descriptor = $getresult['billing_descriptor'] ? $getresult['billing_descriptor']:'dvs';
			$business_dba_name = $getresult['business_dba_name'] ? $getresult['business_dba_name']:'';
			$business_email = $getresult['business_email'] ? $getresult['business_email']:'';
			$business_name = $getresult['business_name'] ? $getresult['business_name']:'';
			$business_number = $getresult['business_number'] ? $getresult['business_number']:'';
			$business_type = $getresult['business_type'] ? $getresult['business_type']:'';

			$chargeback ='25';

			$city = $getresult['city'] ? $getresult['city']:'';
			$country = $getresult['country'] ? $getresult['country']:'';
			$customer_service_email = $getresult['customer_service_email'] ? $getresult['customer_service_email']:'';
			$customer_service_phone = $getresult['customer_service_phone'] ? $getresult['customer_service_phone']:'';
			$dis_trans_fee = '0.15';
            $establishmentdate = $getresult['year_business'].'-'.$getresult['month_business'] .'-'.$getresult['day_business'];

			$key = $last_merchantId;
			$monthly_fee ='5';
			$monthly_gateway_fee ='25';
			$checkbox ='1';
			$name = $name ? $name :'';
			$o_address = $getresult['o_address1'] ? $getresult['o_address1']:'';
			$o_dob = $getresult['dob'] ? $getresult['dob']:'';
			$o_email = $getresult['o_email'] ? $getresult['o_email']:'';
			$o_phone = $getresult['o_phone'] ? $getresult['o_phone']:'';
			$o_ss_number = $getresult['o_ss_number'] ? $getresult['o_ss_number']:'';
			$ownershiptype = $getresult['ownershiptype'] ? $getresult['ownershiptype']:'';
			$pc_address = $getresult['o_address1'] ? $getresult['o_address1']:'';
			$pc_email = $getresult['o_email'] ? $getresult['o_email']:'';
			$pc_name = $getresult['o_name'] ? $getresult['o_name']:'';
			$pc_phone = $getresult['o_phone'] ? $getresult['o_phone']:'';
			$pc_title = $getresult['business_dba_name'] ? $getresult['business_dba_name']:'';

			$question = $getresult['question'] ? $getresult['question']:'Question';
			$taxid = $getresult['taxid'] ? $getresult['taxid']:'';
			$vm_cardrate ='2.70';
			$website = $getresult['website'] ? $getresult['website']:'';

          
			if($address1  && $amexrate >=0 &&  $annual_cc_sales_vol >=0 && $annual_processing_volume && $bank_account && 
		  $bank_ach && $bank_dda  && $bank_routing && $billing_descriptor &&  $business_dba_name &&  $business_email && $business_name 
		  && $business_number && $business_type && $chargeback >=0 && $city && $country && $customer_service_email
		   && $customer_service_phone &&  $dis_trans_fee >=0  && $establishmentdate && $key && $monthly_fee >=0  && $monthly_gateway_fee >=0 &&
			$checkbox  && $name && $o_address && $o_dob && $o_email && $o_phone  && $o_ss_number && $ownershiptype && $pc_address 
			&& $pc_email && $pc_name && $pc_phone  &&  $pc_title && $question && $taxid && $vm_cardrate >=0 &&  $website ) 

		{
		  			  	//ech//o json_encode(array('Status'=>4000)); 
		  	//echo 'ahmad';
		  	 //die();

			   $data=array(
				'address1' =>$address1,
				'amexrate' =>$amexrate,
				'annual_cc_sales_vol' =>$annual_cc_sales_vol,
				'annual_processing_volume' =>$annual_processing_volume,
				'bank_account' =>$bank_account,
				'bank_ach' =>$bank_ach,
				'bank_dda' =>$bank_dda,
				'bank_routing' =>$bank_routing,
				'billing_descriptor' =>$billing_descriptor,
				'business_dba_name' =>$business_dba_name,
				'business_email' =>$business_email,
				'business_name' =>$business_name,
				'business_number' =>$business_number,
				'business_type' =>$business_type,
				'chargeback' =>$chargeback,
				'city' =>$city,
				'country' =>$country,
				'customer_service_email' =>$customer_service_email,
				'customer_service_phone' =>$customer_service_phone,
				'dis_trans_fee' =>$dis_trans_fee,

				'year_business' =>substr($establishmentdate,0,4),
				'month_business' =>substr($establishmentdate,5,2),
				'day_business' =>substr($establishmentdate,8,2),
				// 'key' =>$key,
				'monthly_fee' =>$monthly_fee,
				'monthly_gateway_fee'=> $monthly_gateway_fee,
				'checkbox' => $checkbox ? 'true':'false',
				'name' =>$name,
				'o_name'=>$name,
				'o_address' =>$o_address,

				'dob' =>$o_dob,
				'o_dob_y' =>substr($o_dob,0,4),
				'o_dob_m' =>substr($o_dob,5,2),
				'o_dob_d' =>substr($o_dob,8,2),

				'o_email' =>$o_email,
				'o_phone' =>$o_phone,
				'o_ss_number' =>$o_ss_number,
				'ownershiptype' =>$ownershiptype,
				'pc_address' =>$pc_address, 
				'pc_email' =>$pc_email,
				'pc_name' =>$pc_name,
				'pc_phone' =>$pc_phone,
				'pc_title' =>$pc_title,
				'question' =>$question,
				'taxid' =>$taxid,
				'vm_cardrate' =>$vm_cardrate,
				'website' =>$website
			   ); 
				$id= $last_merchantId;
				$this->db->where('id', $id);

				$up=$this->db->update('merchant', $data);
				//echo json_encode($up);  die(); 
				//echo json_encode($id);  die(); 
				if($up)
				{
					
					$this->db->where('id', $id);
					$getdata=$this->db->get('merchant')->row();
					// echo json_encode($getdata); die(); 
                    $inputRawData=array (
						'AuthenticationKeyId' => 'a626be59-d58b-4f33-8050-104107dfb68f',
						'AuthenticationKeyValue' => 'Q8n1!RGbn-5YAEA^s0s6AMrKZoPRuqLoBx2GKW15huKXOvwLq~*vJQqC7REdXviE',

						//'AuthenticationKeyId' => 'db49cf35-fb92-4ae2-8a27-b2483365ae7d',
						//'AuthenticationKeyValue' => 'DPshMn0i~wM!jZPYTTnj!-.Mve^wwkw_c1qPT_WGmdyFgIYWFk9GgvM9agYEJfk3',
						
						"Merchant_IPAddress"=> $_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR'] :'',
						"Merchant_IPDateTime"=> date("l j F Y  g:ia", time() - date("Z")) ? date("l j F Y  g:ia", time() - date("Z")) :'',
						"Merchant_BrowserUserAgentString"=> $_SERVER['HTTP_USER_AGENT']?$_SERVER['HTTP_USER_AGENT']:'',
						"ExternalApplicationId"=> $getdata->business_name ? $getdata->business_name :'',
						'CustomFieldAnswers' => 
						array (
						  0 => 
						  array (
							'Id' => 6161,
							'UserDefinedId' => 'legal.name',
							'Value' => 
							array (
							  '#' => $getdata->business_name,
							),
						  ),
						  1 => 
						  array (
							'Id' => 6162,
							'UserDefinedId' => 'legal.dba',
							'Value' => 
							array (
							  '#' => $getdata->business_dba_name,
							),
						  ),
						  2 => 
						  array (
							'Id' => 6163,
							'UserDefinedId' => 'legal.address',
							'Value' => 
							array (
							  'Country' => $getdata->country,
							  'Street1' => $getdata->address1,
							  'Street2' => $getdata->address2,
							  'City' => $getdata->city,
							  'State' => $getdata->state,
							  'Zip' => $getdata->zip,
							),
						  ),
						  3 => 
						  array (
							'Id' => 6164,
							'UserDefinedId' => 'legal.ownershiptype',
							'Value' => 
							array (
							  '#' => $getdata->ownershiptype,
							),
						  ),
						  4 => 
						  array (
							'Id' => 6165,
							'UserDefinedId' => 'legal.taxid',
							'Value' => 
							array (
							  '#' => str_replace("-","",$getdata->taxid),
							),
						  ),
						  5 => 
						  array (
							'Id' => 6166,
							'UserDefinedId' => 'Legal.DateofIncorporation',
							'Value' => 
							array (
							  'Month' => $getdata->month_business,
							  'Day' =>   $getdata->day_business,
							  'Year' =>  $getdata->year_business,
							),
						  ),
						  6 => 
						  array (
							'Id' => 6167,
							'UserDefinedId' => 'legal.phone',
							'Value' => 
							array (
							  '#' => $getdata->business_number,
							),
						  ),
						  7 => 
						  array (
							'Id' => 6168,
							'UserDefinedId' => 'legal.email',
							'Value' => 
							array (
							  '#' => $getdata->business_email,
							),
						  ),
						  8 => 
						  array (
							'Id' => 6169,
							'UserDefinedId' => 'legal.website',
							'Value' => 
							array (
							  '#' => $getdata->website,
							),
						  ),
						  9 => 
						  array (
							'Id' => 6170,
							'UserDefinedId' => 'bank.routingnumber',
							'Value' => 
							array (
							  '#' => $getdata->bank_routing,
							),
						  ),
						  10 => 
						  array (
							'Id' => 6171,
							'UserDefinedId' => 'bank.routingnumber.confirm',
							'Value' => 
							array (
							  '#' => $getdata->bank_routing,
							),
						  ),
						  11 => 
						  array (
							'Id' => 6172,
							'UserDefinedId' => 'bank.acctnumber',
							'Value' => 
							array (
							  '#' => $getdata->bank_account,
							),
						  ),
						  12 => 
						  array (
							'Id' => 6173,
							'UserDefinedId' => 'bank.acctnumber.confirm',
							'Value' => 
							array (
							  '#' => $getdata->bank_account,
							),
						  ),
						  13 => 
						  array (
							'Id' => 6174,
							'UserDefinedId' => 'owner1.name',
							'Value' => 
							array (
							  'FirstName' => $getdata->o_name,
							  'MiddleName' => $getdata->m_name,
							  'LastName' => $getdata->l_name,
							),
						  ),
						  14 => 
						  array (
							'Id' => 6175,
							'UserDefinedId' => 'owner1.dob',
							'Value' => 
							array (
							  'Month' => $getdata->o_dob_m,
							  'Day' => $getdata->o_dob_d,
							  'Year' => $getdata->o_dob_y,
							),
						  ),
						  15 => 
						  array (
							'Id' => 6176,
							'UserDefinedId' => 'owner1.address',
							'Value' => 
							array (
							  'Country' => $getdata->o_country,
							  'Street1' => $getdata->o_address1,
							  'Street2' => $getdata->o_address2,
							  'City' => $getdata->o_city,
							  'State' => $getdata->o_state,
							  'Zip' => $getdata->o_zip,
							),
						  ),
						  16 => 
						  array (
							'Id' => 6178,
							'UserDefinedId' => 'owner1.ssn',
							'Value' => 
							array (
							  '#' =>$getdata->o_ss_number,
							),
						  ),
						  17 => 
						  array (
							'Id' => 6200,
							'UserDefinedId' => 'pc.name',
							'Value' => 
							array (
							  'FirstName' => $getdata->pc_name,
							  'MiddleName' =>  $getdata->pc_name,
							  'LastName' => $getdata->pc_name,
							),
						  ),
						  18 => 
						  array (
							'Id' => 6201,
							'UserDefinedId' => 'pc.title',
							'Value' => 
							array (
							//   '#' => 'true',
							  '#' => $getdata->pc_title ? 'true' :'false',
							),
						  ),
						  19 => 
						  array (
							'Id' => 6202,
							'UserDefinedId' => 'pc.address',
							'Value' => 
							array (
							  'Country' => $getdata->pc_address,
							  'Street1' => '11',
							  'Street2' => '12',
							  'City' => 'HongCong',
							  'State' =>'california',
							  'Zip' => '23233',
							),
						  ),
						  20 => 
						  array (
							'Id' => 6203,
							'UserDefinedId' => 'pc.email',
							'Value' => 
							array (
							  '#' => $getdata->pc_email,
							),
						  ),
						  21 => 
						  array (
							'Id' => 6204,
							'UserDefinedId' => 'pc.phone',
							'Value' => 
							array (
							  '#' => $getdata->pc_phone,
							),
						  ),
						  22 => 
						  array (
							'Id' => 6205,
							'UserDefinedId' => 'bank.ach',
							'Value' => 
							array (
							  '#' => $getdata->bank_ach,
							),
						  ),
						  23 => 
						  array (
							'Id' => 6206,
							'UserDefinedId' => 'legal.annualprocessing',
							'Value' => 
							array (
							  '#' => $getdata->annual_cc_sales_vol,
							),
						  ),
						  24 => 
						  array (
							'Id' => 6208,
							'UserDefinedId' => 'feeprofile.monthlyfee',
							'Value' => 
							array (
							  '#' => $getdata->monthly_fee,
							),
						  ),
						  25 => 
						  array (
							'Id' => 6209,
							'UserDefinedId' => 'feeprofile.vmcardrate',
							'Value' => 
							array (
							  '#' => $getdata->vm_cardrate,
							),
						  ),
						  26 => 
						  array (
							'Id' => 6212,
							'UserDefinedId' => 'feeprofile.distransfee',
							'Value' => 
							array (
							  '#' => $getdata->dis_trans_fee,
							),
						  ),
						  27 => 
						  array (
							'Id' => 6213,
							'UserDefinedId' => 'feeprofile.amexrate',
							'Value' => 
							array (
							  '#' => $getdata->amexrate,
							),
						  ),
						  28 => 
						  array (
							'Id' => 6215,
							'UserDefinedId' => 'feeprofile.chargebackfee',
							'Value' => 
							array (
							  '#' => $getdata->chargeback,
							),
						  ),
						  29 => 
						  array (
							'Id' => 6216,
							'UserDefinedId' => 'feeprofile.monthlygatewayfee',
							'Value' => 
							array (
							  '#' => $getdata->monthly_gateway_fee,
							),
						  ),
						  30 => 
						  array (
							'Id' => 6217,
							'UserDefinedId' => 'feeprofile.annualccsalesvol',
							'Value' => 
							array (
							  '#' => $getdata->annual_cc_sales_vol,
							),
						  ),
						  31 => 
						  array (
							'Id' => 6226,
							'UserDefinedId' => 'owner1.checkbox',
							'Value' => 
							array (
							  '#' => $getdata->business_name ? 'true':'false',
							),
						  ),
						  32 => 
						  array (
							'Id' => 6230,
							'UserDefinedId' => 'legal.question',
							'Value' => 
							array (
							  '#' => $getdata->question,
							),
						  ),
						  33 => 
						  array (
							'Id' => 6231,
							'UserDefinedId' => 'legal.billingdescriptor',
							'Value' => 
							array (
							  '#' => $getdata->billing_descriptor,
							),
						  ),
						  34 => 
						  array (
							'Id' => 6232,
							'UserDefinedId' => 'cs.phone',
							'Value' => 
							array (
							  '#' => $getdata->customer_service_phone,
							),
						  ),
						  35 => 
						  array (
							'Id' => 6233,
							'UserDefinedId' => 'cs.email',
							'Value' => 
							array (
							  '#' => $getdata->customer_service_email,
							),
						  ),
						  36 => 
						  array (
							'Id' => 6237,
							'UserDefinedId' => 'legal.businesstype',
							'Value' => 
							array (
							  '#' => $getdata->business_type,
							),
						  ),
						  37 => 
						  array (
							'Id' => 6238,
							'UserDefinedId' => 'bank.dda',
							'Value' => 
							array (
							  '#' => $getdata->bank_dda,
							),
						  ),
						),
					);
			      //print_r($inputRawData);  
				//    echo json_encode($inputRawData); 
				// 	die;
					
				   $purl='https://merchantapp.io/salequicktest/api/v1/MerchantApplication/Submit'; 
					$ch = curl_init();
					$headers = array("Accept-Encoding: gzip", "Content-Type: application/json" );
					curl_setopt($ch, CURLOPT_URL,$purl);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($inputRawData));           
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$response     = curl_exec ($ch);
					$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $err = curl_error($ch);
					 //$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
					 //$jsondata = json_encode($response);
					 $responceArrayData =json_decode($response, true); 
					curl_close($ch);
                    // print_r($response); echo $err;  die();  
					//echo  $statusCode;
					if ($err) {
					  //echo json_encode("cURL Error #:" . $err);
					  echo json_encode(array('Status'=>600,'StatusMessage'=>'cURL Error #'.$err));
					} else {
						//print_r($responceArrayData['Status']); 
						if($responceArrayData['Status']=='30')
						{
                           $apidata=array(
							
							'merchant_id'=>$getdata->id,
							'merchant_application_id'=>$responceArrayData['MerchantApplicationId'],
							'external_merchant_application_id'=>$responceArrayData['ExternalMerchantApplicationId'],
							'infinicept_application_id'=>$responceArrayData['InfiniceptApplicationId'],
							'status'=>$responceArrayData['Status'],
							'status_message'=>$responceArrayData['StatusMessage']
							
							
						   );
                           $getdataOfApi=$this->db->query("SELECT * FROM  merchant_api WHERE merchant_id='$getdata->id'  ")->result_array(); 
						   if(count($getdataOfApi) == '0')
						   {
							     $this->db->insert('merchant_api',$apidata);
						   }
           $getdauth_key=$this->db->query("SELECT auth_key FROM  merchant WHERE id='$last_merchantId'  ")->row_array();

				// end infincept api

			//print_r($email);  die();
			$today1 = date("Ymdhisu");
			 $unique = $getdauth_key['auth_key'];
			//$unique = "SAL" . $today1;
			$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
			$data = array(
				"bank_dda" => $bank_dda,
				"bank_ach" => $bank_ach,
				"bank_routing" => $routingno,
				"bank_account" => $accountnumber,
				//"auth_key" => $unique,
				//"merchant_key" => $merchant_key,
				"amexrate" =>$amexrate,
				'monthly_fee'=> $monthly_fee,
				'monthly_gateway_fee'=> $monthly_gateway_fee,
				'vm_cardrate'=> $vm_cardrate,
				'dis_trans_fee' =>$dis_trans_fee,
				//   'status' => 'block',
				// 'status' => 'Waiting_For_Approval',
				'status' => 'pending',
			);

			if ($routingno && $accountnumber) {
				//$result=$this->Home_model->insert_data("merchant", $data);
				$this->db->where('id', $last_merchantId);
				$this->db->update('merchant', $data);
				$this->session->unset_userdata('last_merchantId');
				$this->session->unset_userdata('step');
				$url = base_url() . "confirm/" . $unique;
				set_time_limit(3000);

				$MailTo = $email;
				$htmlContent = '<!DOCTYPE html>
				<html>
				<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<title></title>
				
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
				</head>
				<body style="padding: 0px;margin: 0;font-family:Open Sans, sans-serif;font-size: 14px !important;color: #333;">
				<div style="max-width: 751px;margin: 0 auto;background:#fafafa;">
				<div style="color:#fff;padding-top: 30px;padding-bottom: 5px;background-color: #2273dc;border-top-left-radius: 10px;border-top-right-radius: 10px;">
				<div style="width:80%;margin:0 auto;">
				<div style="width: 245px;text-align: center;height: 70px;border-radius: 50%;margin: 10px auto 20px;padding: 10px;box-shadow: 0px 0px 5px 10px #438cec8c;"><img src="https://salequick.com/front/images/logo-w.png" style="max-width: 90%;width: 100%;margin: 8px auto 0;display: block;"></div>
				</div>
				</div>
				<div style="max-width: 563px;text-align:right;margin: 0px auto 0;clear: both;width: 100%;display: table;">
				<p style="text-align: center !important;font-size: 20px !important;font-family: fantasy !important;letter-spacing: 3px;color: #3c763d;">Your registration is complete.</p>
    			<p style="font-size: 16px !important;text-align: center !important;font-weight: 600;">Registration Details:</p>
				<table style="border-collapse: separate; border-spacing: 0;width: 100%; max-width: 100%;clear: both;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;font-size: 14px;"> 
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Name
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'. $name . '</td>
					</tr>
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Email
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'.$email.'</td>
					</tr>
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Phone
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'.$mobile.'</td>
					</tr>
				</table>
				</div>
				<div style="padding: 25px 0;overflow:hidden;">
				<div style="width: 100%;margin:0 auto;overflow:hidden;max-width: 80%;">
				<div style="width: 100%;margin:10px auto 20px;text-align:center;">
				<p style="line-height: 1.432;">
				<span style="display: block;margin-bottom: 11px;font-weight: 600;color: #3c763d !important;">Verify Email</span>
				<a href="'.$url.'" style="max-height: 40px;padding: 10px 20px;display: inline-flex;justify-content: center;align-items: center;font-size: 0.875rem;font-weight: 600;letter-spacing: 0.03rem;color: #fff;background-color: #696ffb;text-decoration: none;border-radius: 20px;">Click Here</a>
				</p> 
				
				</div>
				</div>
				<footer style="width:100%;padding: 35px 0 21px;background: #414141;margin-top: 0px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
				<div style="text-align:center;width:80%;margin:0 auto;color: rgba(255, 255, 255, 0.75);">
				<h5 style="margin-top: 0;margin-bottom: 10px;font-size: 16px;font-weight:400;line-height: 1.432;">Feel free to contact us any time with question and concerns.</h5>
				<p style="color: rgba(255, 255, 255, 0.55);">You are receiving something because purchased something at Company name</p>
				<p style="text-align:center"><a href="https://salequick.com/" style="color: #6ea9ff;cursor:pointer;text-decoration:none !important;"><span style="color: rgba(255, 255, 255, 0.55);">Powered by:</span> SaleQuick.com</a></p>
				</div>
				</footer>
				</div>
				</body>
				</html>
	    	';
				//print_r($htmlContent); die();
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$MailSubject = 'Salequick Registration Confirmation ';
				$this->email->from('info@salequick.com', 'Confirm Email');
				$this->email->to($email);
				$this->email->subject($MailSubject);
				$this->email->message($htmlContent);
				$this->email->send();
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Member Business Registration Successfully.. </div>');
				//echo $this->session->flashdata('success'); die();
				//redirect(base_url("signup"));
				//redirect(base_url("login"));
				//echo '200';
				echo json_encode(array('Status'=>200)); 
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Somthing Event Wrong!..</div>');
				//echo $this->session->flashdata('error'); die();
				//redirect(base_url("signup"));
				//echo '500';
				echo json_encode(array('Status'=>500)); 
			}
// start infinicpt api

						//echo $response;
						} 
						else
						{
							echo json_encode(array('Status'=>200));
							//echo $response;   
						}
						
					}
                    //die("okay"); 
					//echo "update"; 
					}
				else
				{
	                echo json_encode(array('Status'=>600));   
				}  


			}else
			{
				echo json_encode(array('Status'=>40)); 

			}



			// 
		}
		public function stepfour_signup() {

			//$name = $this->input->post('mbname') ? $this->input->post('mbname') : "";
			//$mobile = $this->input->post('mphone') ? $this->input->post('mphone') : "";
			//$email = $this->input->post('memail') ? $this->input->post('memail') : "";
			$last_merchantId = $this->session->userdata('last_merchantId');
			$this->db->where('id', $last_merchantId);
			$getresult = $this->db->get('merchant')->row_array();
			// print_r($getresult['mob_no']); die();
			$name = $getresult['name'];
			$mobile = $getresult['mob_no'] ? $getresult['mob_no'] : $getresult['business_number'];
			$email = $getresult['email'];

			$routeNo = htmlspecialchars($this->input->post('routeNo') ? $this->input->post('routeNo') : '');
			$confrouteNo = htmlspecialchars($this->input->post('confrouteNo') ? $this->input->post('confrouteNo') : "");
			if ($routeNo == $confrouteNo) {
				$routingno = $this->input->post('routeNo');
			} else {
				echo '400';
			}

			$accountnumber_one = htmlspecialchars($this->input->post('accno') ? $this->input->post('accno') : '');
			$caccountnumber = htmlspecialchars($this->input->post('confaccno') ? $this->input->post('confaccno') : "");
			if ($accountnumber_one == $caccountnumber) {
				$accountnumber = $this->input->post('accno');
			} else {
				echo '400';
			}

			//print_r($email);  die();
			$today1 = date("Ymdhisu");
			$unique = "SAL" . $today1;
			$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);
			$data = array(
				"bank_dda" => $this->input->post('bank_dda_type') ? $this->input->post('bank_dda_type') : '',
				"bank_ach" => $this->input->post('baccachtype') ? $this->input->post('baccachtype') : '',
				"bank_routing" => $routingno,
				"bank_account" => $accountnumber,
				"auth_key" => $unique,
				"merchant_key" => $merchant_key,
				//   'status' => 'block',
				// 'status' => 'Waiting_For_Approval',
				'status' => 'pending',
			);

			if ($routingno && $accountnumber) {
				//$result=$this->Home_model->insert_data("merchant", $data);
				$this->db->where('id', $last_merchantId);
				$this->db->update('merchant', $data);
				$this->session->unset_userdata('last_merchantId');
				$this->session->unset_userdata('step');
				$url = base_url() . "confirm/" . $unique;
				set_time_limit(3000);

				$MailTo = $email;
				$htmlContent = '<!DOCTYPE html>
				<html>
				<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<title></title>
				
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
				</head>
				<body style="padding: 0px;margin: 0;font-family:Open Sans, sans-serif;font-size: 14px !important;color: #333;">
				<div style="max-width: 751px;margin: 0 auto;background:#fafafa;">
				<div style="color:#fff;padding-top: 30px;padding-bottom: 5px;background-color: #2273dc;border-top-left-radius: 10px;border-top-right-radius: 10px;">
				<div style="width:80%;margin:0 auto;">
				<div style="width: 245px;text-align: center;height: 70px;border-radius: 50%;margin: 10px auto 20px;padding: 10px;box-shadow: 0px 0px 5px 10px #438cec8c;"><img src="https://salequick.com/front/images/logo-w.png" style="max-width: 90%;width: 100%;margin: 8px auto 0;display: block;"></div>
				</div>
				</div>
				<div style="max-width: 563px;text-align:right;margin: 0px auto 0;clear: both;width: 100%;display: table;">
				<p style="text-align: center !important;font-size: 20px !important;font-family: fantasy !important;letter-spacing: 3px;color: #3c763d;">Your registration is complete.</p>
    			<p style="font-size: 16px !important;text-align: center !important;font-weight: 600;">Registration Details:</p>
				<table style="border-collapse: separate; border-spacing: 0;width: 100%; max-width: 100%;clear: both;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;font-size: 14px;"> 
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Name
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'. $name . '</td>
					</tr>
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Email
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'.$email.'</td>
					</tr>
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Phone
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">'.$mobile.'</td>
					</tr>
				</table>
				</div>
				<div style="padding: 25px 0;overflow:hidden;">
				<div style="width: 100%;margin:0 auto;overflow:hidden;max-width: 80%;">
				<div style="width: 100%;margin:10px auto 20px;text-align:center;">
				<p style="line-height: 1.432;">
				<span style="display: block;margin-bottom: 11px;font-weight: 600;color: #3c763d !important;">Verify Email</span>
				<a href="'.$url.'" style="max-height: 40px;padding: 10px 20px;display: inline-flex;justify-content: center;align-items: center;font-size: 0.875rem;font-weight: 600;letter-spacing: 0.03rem;color: #fff;background-color: #696ffb;text-decoration: none;border-radius: 20px;">Click Here</a>
				</p> 
				
				</div>
				</div>
				<footer style="width:100%;padding: 35px 0 21px;background: #414141;margin-top: 0px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
				<div style="text-align:center;width:80%;margin:0 auto;color: rgba(255, 255, 255, 0.75);">
				<h5 style="margin-top: 0;margin-bottom: 10px;font-size: 16px;font-weight:400;line-height: 1.432;">Feel free to contact us any time with question and concerns.</h5>
				<p style="color: rgba(255, 255, 255, 0.55);">You are receiving something because purchased something at Company name</p>
				<p style="text-align:center"><a href="https://salequick.com/" style="color: #6ea9ff;cursor:pointer;text-decoration:none !important;"><span style="color: rgba(255, 255, 255, 0.55);">Powered by:</span> SaleQuick.com</a></p>
				</div>
				</footer>
				</div>
				</body>
				</html>
	    	';
				//print_r($htmlContent); die();
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$MailSubject = 'Salequick Registration Confirmation ';
				$this->email->from('info@salequick.com', 'Confirm Email');
				$this->email->to($email);
				$this->email->subject($MailSubject);
				$this->email->message($htmlContent);
				$this->email->send();
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Member Business Registration Successfully.. </div>');
				//echo $this->session->flashdata('success'); die();
				//redirect(base_url("signup"));
				//redirect(base_url("login"));
				echo '200';
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Somthing Event Wrong!..</div>');
				//echo $this->session->flashdata('error'); die();
				//redirect(base_url("signup"));
				echo '500';
			}
		}
		public function stepthree_signup() {
			$dobYear = $this->input->post('fodoby') ? $this->input->post('fodoby') : "";
			$dobMonth = $this->input->post('fodobm') ? $this->input->post('fodobm') : "";
			$dobDate = $this->input->post('fodobd') ? $this->input->post('fodobd') : "";
			$DOB = $dobYear . '-' . $dobMonth . '-' . $dobDate;

			$data = array(
				'o_email' => $this->input->post('fo_email') ? $this->input->post('fo_email') : "",
				"o_phone" => $this->input->post('fo_phone') ? $this->input->post('fo_phone') : "",
				'o_dob_d' => $dobDate,
				'o_dob_m' => $dobMonth,
				'o_dob_y' => $dobYear,
				'dob' => $DOB,
				'o_address1' => htmlspecialchars($this->input->post('fohadd_1') ? $this->input->post('fohadd_1') : ""),
				'o_address2' => htmlspecialchars($this->input->post('fohadd_2') ? $this->input->post('fohadd_2') : ""),
				'o_city' => $this->input->post('fohadd_city') ? $this->input->post('fohadd_city') : "",
				'o_country' => $this->input->post('fohadd_cntry') ? $this->input->post('fohadd_cntry') : "",
				'o_state' => $this->input->post('fohadd_state') ? $this->input->post('fohadd_state') : "",
				'o_zip' => $this->input->post('fohadd_zip') ? $this->input->post('fohadd_zip') : "",
				'o_ss_number' => $this->input->post('fossn') ? $this->input->post('fossn') : "",
				'o_name' => $this->input->post('foname1') ? $this->input->post('foname1') : "",
				'name' => htmlspecialchars($this->input->post('foname1') ? $this->input->post('foname1') : ""),
				'm_name' => htmlspecialchars($this->input->post('foname2') ? $this->input->post('foname2') : ""),
				'l_name' => htmlspecialchars($this->input->post('foname3') ? $this->input->post('foname3') : ""),

			);

			// echo json_encode($data);  die();
			$last_merchantId = $this->session->userdata('last_merchantId');
			if (
				isset($_POST['fo_email']) && isset($_POST['fo_phone']) && isset($_POST['fodobd']) && isset($_POST['fodobm']) &&
				isset($_POST['fodoby']) && isset($_POST['fohadd_1']) && isset($_POST['fohadd_2']) && isset($_POST['fohadd_city']) &&
				isset($_POST['fohadd_cntry']) &&
				isset($_POST['fohadd_state']) && isset($_POST['fohadd_zip']) && isset($_POST['foname1']) && isset($_POST['foname2']) && isset($_POST['foname3']) &&
				isset($_POST['fossn'])
			) {
				//$result=$this->Home_model->insert_data("merchant", $data);
				$this->db->where('id', $last_merchantId);
				$this->db->update('merchant', $data);
				// echo $this->db->last_query();  die();
				$this->session->set_userdata('last_merchantId', $last_merchantId);
				$this->session->set_userdata('step', 'three');
				echo json_encode($data);
			}
		}
		public function steptwo_signup() {
			$data = array(
				'business_dba_name' => $this->input->post('bsns_dbaname') ? $this->input->post('bsns_dbaname') : "",
				"business_email" => $this->input->post('bsns_email') ? $this->input->post('bsns_email') : "",
				'business_name' => $this->input->post('bsns_name') ? $this->input->post('bsns_name') : "",
				'ownershiptype' => $this->input->post('bsns_ownrtyp') ? $this->input->post('bsns_ownrtyp') : "",
				'business_number' => $this->input->post('bsns_phone') ? $this->input->post('bsns_phone') : "",
				'day_business' => $this->input->post('bsns_strtdate_d') ? $this->input->post('bsns_strtdate_d') : "",
				'month_business' => $this->input->post('bsns_strtdate_m') ? $this->input->post('bsns_strtdate_m') : "",
				'year_business' => $this->input->post('bsns_strtdate_y') ? $this->input->post('bsns_strtdate_y') : "",
				'taxid' => $this->input->post('bsns_tin') ? $this->input->post('bsns_tin') : "",
				'business_type' => $this->input->post('bsns_type') ? $this->input->post('bsns_type') : "",
				'website' => $this->input->post('bsns_website') ? $this->input->post('bsns_website') : "",
				'address1' => $this->input->post('bsnspadd_1') ? $this->input->post('bsnspadd_1') : "",
				'address2' => $this->input->post('bsnspadd_2') ? $this->input->post('bsnspadd_2') : "",
				'city' => $this->input->post('bsnspadd_city') ? $this->input->post('bsnspadd_city') : "",
				'country' => $this->input->post('bsnspadd_cnttry') ? $this->input->post('bsnspadd_cnttry') : "",
				'state' => $this->input->post('bsnspadd_state') ? $this->input->post('bsnspadd_state') : "",
				'zip' => $this->input->post('bsnspadd_zip') ? $this->input->post('bsnspadd_zip') : "",
				'customer_service_email' => $this->input->post('custServ_email') ? $this->input->post('custServ_email') : "",
				'customer_service_phone' => $this->input->post('custServ_phone') ? $this->input->post('custServ_phone') : "",
				'annual_processing_volume' => $this->input->post('mepvolume') ? $this->input->post('mepvolume') : "",

			);

			//echo json_encode($data);  die();
			$last_merchantId = $this->session->userdata('last_merchantId');
			if (isset($_POST['bsns_dbaname']) && isset($_POST['bsns_email']) && isset($_POST['bsns_name']) && isset($_POST['bsns_ownrtyp']) && isset($_POST['bsns_phone']) &&
				isset($_POST['bsns_strtdate_d']) && isset($_POST['bsns_strtdate_m']) && isset($_POST['bsns_strtdate_y']) && isset($_POST['bsns_tin']) &&
				isset($_POST['bsns_type']) && isset($_POST['bsns_website']) && isset($_POST['bsnspadd_1']) && isset($_POST['bsnspadd_2']) && isset($_POST['bsnspadd_city']) &&
				isset($_POST['bsnspadd_cnttry']) && isset($_POST['bsnspadd_state']) && isset($_POST['bsnspadd_zip']) && isset($_POST['custServ_email']) && isset($_POST['custServ_phone']) &&
				isset($_POST['mepvolume'])
			) {
				//$result=$this->Home_model->insert_data("merchant", $data);
				$this->db->where('id', $last_merchantId);
				$this->db->update('merchant', $data);
				$this->session->set_userdata('last_merchantId', $last_merchantId);
				$this->session->set_userdata('step', 'two');
				echo json_encode($data);
			}
		}
		public function stepone_signup_original() {

			$email = $this->input->post('email') ? $this->input->post('email') : '';
			$password_one = $this->input->post('password') ? $this->input->post('password') : '';
			$cpassword = $this->input->post('mconfpass') ? $this->input->post('mconfpass') : '';

			

			if ($password_one == $cpassword) {
				$password1 = $this->input->post('password');
			} else {
				// return
				// $password1=$this->input->post('password');
				echo json_encode(600);
			}
			//$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);

			$today1 = date("Ymdhisu");
			$unique = "SAL" . $today1;
			$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);


			$password = $this->my_encrypt($password1, 'e');
			
			
			$usr_result = $this->db->query("SELECT * FROM merchant WHERE email='$email'")->row_array();
			
			if(count($usr_result) =='0')
			{
				$data = array(

					"email" => $this->input->post('email'),
					"password" => $password,
					"auth_key" => $unique,
				    "merchant_key" => $merchant_key,
					'status' => 'pending_signup',
					'is_token_system_permission' => '1',
					'is_tokenized' => '1'
				);
				if ($email && $password_one && $cpassword) {
					$result = $this->Home_model->insert_data("merchant", $data);
					$this->session->set_userdata('last_merchantId', $result);
					$this->session->set_userdata('merchant_key', $merchant_key);
					$this->session->set_userdata('step', 'one');
					//echo json_encode($data);
					// echo 'run';
					echo json_encode(200);
				} else {
					echo json_encode(400); 
				}
			}
			else
			{
				echo json_encode(700); 
			}
		}

		public function stepone_signup() {
			$allData = $_POST['allData'];
			$dataArr = explode('/', $allData);
			
			$email = $dataArr[0];
			$password_one = $dataArr[1];
			$cpassword = $dataArr[2];
			// echo $email.','.$password_one.','.$cpassword;die;

			if ($password_one == $cpassword) {
				$password1 = $password_one;
			} else {
				// return
				// $password1=$this->input->post('password');
				echo json_encode(600);
			}
			//$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);

			$today1 = date("Ymdhisu");
			$unique = "SAL" . $today1;
			$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);


			$password = $this->my_encrypt($password1, 'e');
			
			
			$usr_result = $this->db->query("SELECT * FROM merchant WHERE email='$email'")->row_array();
			
			if(count($usr_result) =='0')
			{
				$data = array(

					"email" => $email,
					"password" => $password,
					"auth_key" => $unique,
				    "merchant_key" => $merchant_key,
					'status' => 'pending_signup',
					'is_token_system_permission' => '1',
					'is_tokenized' => '1'
				);
				if ($email && $password_one && $cpassword) {
					$result = $this->Home_model->insert_data("merchant", $data);
					$this->session->set_userdata('last_merchantId', $result);
					$this->session->set_userdata('merchant_key', $merchant_key);
					$this->session->set_userdata('step', 'one');
					//echo json_encode($data);
					// echo 'run';
					echo json_encode(200);
				} else {
					echo json_encode(400); 
				}
			}
			else
			{
				echo json_encode(700); 
			}
		}
		// sign up step new change

		public function card_payment() {
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
			$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
			$color = $this->input->post('color') ? $this->input->post('color') : "";
			$data['amount'] = $this->input->post('amount') ? $this->input->post('amount') : '';
			if ($id && $bct_id1 && $bct_id2) {
				$today2 = date("Y-m-d H:i:s");
				$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
				$getEmail = $getQuery->result_array();
				$data['getEmail'] = $getEmail;
				$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'   ");  //   and 	is_token_system_permission=1
				$getEmail1 = $getQuery1->result_array();
				$data['getEmail1'] = $getEmail1;
				if ($getEmail1) {
					$email = empty($getEmail[0]['email_id'])?"NA":$getEmail[0]['email_id'];
					$amount = $getEmail[0]['amount'];
					$sub_total = $getEmail[0]['sub_total'];
					$tax = $getEmail[0]['tax'];
					$data['color'] = $color;
					$name = $getEmail[0]['name'];
					$mobile_no = empty($getEmail[0]['mobile_no'])?"NA":$getEmail[0]['mobile_no'];
					$invoice_no = $getEmail[0]['invoice_no'];
					$mob = str_replace(array('(', ')', '-', ' '), '', $mobile_no);
					// if($getEmail[0]['payment_type']=='recurring')
					// {
                    //   $getQuery_t = $this->db->query(" SELECT token.*,invoice_token.invoice_no FROM token INNER JOIN invoice_token on token.id=invoice_token.token_id  WHERE token.mobile='$mob'  AND invoice_token.invoice_no='$invoice_no' group by card_no");
					//   $token_data = $getQuery_t->result_array();
					// }
					//if($getEmail[0]['payment_type']=='straight')
					
				 $getQuery_t = $this->db->query("SELECT * FROM  token WHERE  ( mobile='" . $mob . "' || email='$email') AND `status` ='1' AND merchant_id='$bct_id2'  group by card_no ");
				
					$token_data = $getQuery_t->result_array();
                    // echo $this->db->last_query();die;
				} else {
					$token_data = array();
				}
				// print_r($mob); die();
				// $token_data=array();
				$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
				$data['itemm'] = $itemm;
				$data['token_data'] = $token_data;
				$data['logo'] = "logo";if ($getEmail1[0]['logo']) {$data['logo'] = $getEmail1[0]['logo'];}
				$branch = $this->Home_model->get_payment_details_1($bct_id1);
				$data['branch'] = $branch;
				// echo"<pre>";print_r($data);   die();
				$this->load->view('card_payment', $data);

			} else {
				$this->load->view('errors/cli/page_not_found');
			}
		}

		public function updatecard() {
			$id = $this->uri->segment(3);
			$this->db->where('id', $id);
			$result = $this->db->get('customer_payment_request')->row_array();
			$data['getResult'] = $result;
			$email=$result['email_id']; 
			$invoice_no=$result['invoice_no'];
			$mob = str_replace(array('(', ')', '-', ' '), '', $result['mobile_no']);
			$card_type = $result['card_type'];
			$getQuery_t = $this->db->query(" SELECT token.*,invoice_token.invoice_no FROM token INNER JOIN invoice_token on token.id=invoice_token.token_id  WHERE  invoice_token.invoice_no='$invoice_no' group by card_no"); 
			//$getQuery_t = $this->db->query("SELECT * FROM  token WHERE  card_type='$card_type' AND  ( mobile='" . $mob . "' || email='$email') group by card_no ");
			$data['token_data'] = $getQuery_t->row_array();
			//print_r($data['token_data'] );  die();
			if (isset($_POST['updatecard'])) {

				$this->form_validation->set_rules('cardname', 'Name On Card', 'required');
				$this->form_validation->set_rules('cardnumber', 'Card No', 'required');
				$this->form_validation->set_rules('savecard', 'savecard', 'required');
				$this->form_validation->set_rules('city', 'city', 'required');
				$this->form_validation->set_rules('expyear', ' Expiry Year', 'required');
				$this->form_validation->set_rules('expmonth', 'Expiry  Month', 'required');
				$this->form_validation->set_rules('cvv', 'CVC', 'required');
				$this->form_validation->set_rules('zip', 'Zip', 'required');
				$this->form_validation->set_rules('country', 'State', 'required');

				$this->form_validation->set_rules('rowid', 'rowid', 'required');
				$this->form_validation->set_rules('tokenid', 'rowid', 'required');

				$rowid = $this->input->post('rowid') ? $this->input->post('rowid') : "";
				$tokenid = $this->input->post('tokenid') ? $this->input->post('tokenid') : "";

				if (!empty($this->session->userdata('subuser_id'))) {
					$sub_merchant_id = $this->session->userdata('subuser_id');
				} else {
					$sub_merchant_id = '0';
				}

				$sub_amount = $result['sub_total'];
				$total_tax = $result['tax'];
				$invoice_no = $result['invoice_no'];
				$recurring_payment = $result['recurring_payment'];
				$merchant_id = $this->session->userdata('merchant_id');
				if ($this->form_validation->run() == false) {

					$this->session->set_flashdata('error', '<div class="alert alert-danger text-center">All (*)  Fields Are Required ..</div>');
					// $this->load->view('merchant/update_card',$data);
					redirect(base_url('signup/updatecard/' . $rowid));

				} else {
					//   new card info : Update card :  New card For Auto payment
					$name_card = $this->input->post('cardname') ? $this->input->post('cardname') : "";
					$card_no = $this->input->post('cardnumber') ? $this->input->post('cardnumber') : "";
					$city = $this->input->post('city') ? $this->input->post('city') : "";
					$expiry_year = $this->input->post('expyear') ? $this->input->post('expyear') : "";
					$expiry_month = $this->input->post('expmonth') ? $this->input->post('expmonth') : "";
					$cvv = $this->input->post('cvv') ? $this->input->post('cvv') : "";
					$zip = $this->input->post('zip') ? $this->input->post('zip') : "";
					$country = $this->input->post('country') ? $this->input->post('country') : "";
					//  new card info : Update card :  New card For Auto payment

					$this->db->where('id', $rowid);
					$getRow = $this->db->get('customer_payment_request')->result_array();
					$merchant_id = $getRow[0]['merchant_id'];
					$amount = $getRow[0]['amount'];
					$payment_id = $getRow[0]['invoice_no'];
					$address = $getRow[0]['address'];
					$recurring_count = $getRow[0]['recurring_count'];

					$getRow[0]['recurring_next_pay_date'];

					$today = date('Y-m-d'); //print_r($today.'-----'.$getRow[0]['recurring_next_pay_date']); die();
					if ($today == $getRow[0]['recurring_next_pay_date']) {

						$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of WSDL live

						// $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL   sandbox

						$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
						$getEmail_a = $getQuery_a->result_array();
						$data['$getEmail_a'] = $getEmail_a;
						if (count($getEmail_a)) {
							$merchant_email = $getEmail_a[0]['email'];
						}
						//print_r($getEmail_a);  die("Auto");
						if (!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id'])) {
							//if($account_id && $acceptor_id && $account_token && $application_id && $terminal_id)

							$account_id = $getEmail_a[0]['account_id_cnp'];
							$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
							$account_token = $getEmail_a[0]['account_token_cnp'];
							$application_id = $getEmail_a[0]['application_id_cnp'];
							$terminal_id = $getEmail_a[0]['terminal_id'];
							// $account_id = 1196211;
							// $acceptor_id = 4445029890514;
							// $account_token = D737D32F8674BF81780A6F259DE66080F984048E249A9DB4DA01C93DC6F733A2F2535101;
							// $application_id = 9726;
							// $terminal_id = '4374N000101';

							$xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>"; // data from the form, e.g. some ID number
							$headers = array(
								"Content-type: text/xml;charset=\"utf-8\"",
								"Accept: text/xml",
								"Cache-Control: no-cache",
								"Pragma: no-cache",
								"SOAPAction: https://transaction.elementexpress.com/",
								"Content-length: " . strlen($xml_post_string),
							); //SOAPAction: your op URL
							//print_r($xml_post_string);  die();
							//die("end");

							$url = $soapUrl;
							//print_r($url); die("ok");
							// PHP cURL  for https connection with auth
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
							curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
							curl_setopt($ch, CURLOPT_TIMEOUT, 10);
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							$response = curl_exec($ch);

							$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
							$json = json_encode($xml);
							$array = json_decode($json, true);
							//print_r($array); die("ok");
							curl_close($ch);
							//die("okok");
							$TicketNumber = (rand(100000, 999999));
							if ($array['Response']['ExpressResponseMessage'] = 'ONLINE') {
								$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken>

	                                  <AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>

	                                  <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>" . $amount . "</TransactionAmount><ReferenceNumber>" . $payment_id . "</ReferenceNumber>

	                                  <TicketNumber>" . $TicketNumber . "</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>

	                                  <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>

	                                  </Terminal><Card><CardNumber>" . $card_no . "</CardNumber><ExpirationMonth>" . $expiry_month . "</ExpirationMonth><ExpirationYear>" . $expiry_year . "</ExpirationYear><CVV>" . $cvv . "</CVV></Card><Address><BillingZipcode>" . $zip . "</BillingZipcode>

	                      <BillingAddress1>" . $address . "</BillingAddress1></Address></CreditCardSale>"; // data from the form, e.g. some ID number
								// print_r($xml_post_string); die;
								$headers = array(
									"Content-type: text/xml;charset=\"utf-8\"",
									"Accept: text/xml",
									"Cache-Control: no-cache",
									"Pragma: no-cache",
									"SOAPAction: https://transaction.elementexpress.com/",
									"Content-length: " . strlen($xml_post_string),
								); //SOAPAction: your op URL
								$url = $soapUrl;

								// PHP cURL  for https connection with auth
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword);
								// username and password - declared at the top of the doc
								curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
								curl_setopt($ch, CURLOPT_TIMEOUT, 10);
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								// converting
								$response = curl_exec($ch);
								$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
								$json = json_encode($xml);
								$arrayy = json_decode($json, true);
								// print_r($arrayy);
								// die();
								curl_close($ch);
								if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved') {
									$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
									$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
									$card_a_type = $arrayy['Response']['Card']['CardLogo'];

									//print_r($card_a_type);  die();
									$message_a = $arrayy['Response']['Transaction']['TransactionStatus'];
									$message_complete = $arrayy['Response']['ExpressResponseMessage'];
									$AVSResponseCode = $arrayy['Response']['Card']['AVSResponseCode'];
									$CVVResponseCode = $arrayy['Response']['Card']['CVVResponseCode'];

									$TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
									$TransactionDate = $arrayy['Response']['ExpressTransactionDate'];

									$Ttime = substr($TransactionTime, 0, 2) . ':' . substr($TransactionTime, 2, 2) . ':' . substr($TransactionTime, 4, 2);
									$Tdate = substr($TransactionDate, 0, 4) . '-' . substr($TransactionDate, 4, 2) . '-' . substr($TransactionDate, 6, 2);
									//die(); //2019-07-04 12:05:41
									$rt = $Tdate . ' ' . $Ttime;
									$transaction_date = date($rt);

									if ($AVSResponseCode == 'A') {
										$address_status = 'Address match';
										$zip_status = 'Zip does not match';
									} elseif ($AVSResponseCode == 'G') {
										$address_status = 'Global non-AVS participant';
										$zip_status = 'Global non-AVS participant';
									} elseif ($AVSResponseCode == 'N') {
										$address_status = 'Address  not match';
										$zip_status = 'Zip  not match';
									} elseif ($AVSResponseCode == 'R') {
										$address_status = 'Retry, system unavailable or timed out';
										$zip_status = 'Retry, system unavailable or timed out';
									} elseif ($AVSResponseCode == 'S') {
										$address_status = 'Service not supported: Issuer does not support AVS and Visa';
										$zip_status = 'Service not supported: Issuer does not support AVS and Visa';
									} elseif ($AVSResponseCode == 'U') {
										$address_status = 'Unavailable: Address information not verified for domestic transactions';
										$zip_status = 'Unavailable: Address information not verified for domestic transactions';
									} elseif ($AVSResponseCode == 'W') {

										$address_status = 'Address does not match';

										$zip_status = 'Zip matches';

									} elseif ($AVSResponseCode == 'X') {

										$address_status = 'Address match';

										$zip_status = 'Zip matches';

									} elseif ($AVSResponseCode == 'Y') {

										$address_status = 'address match';

										$zip_status = 'zip match';

									} elseif ($AVSResponseCode == 'Z') {

										$address_status = 'Address does not match';

										$zip_status = 'zip match';

									} elseif ($AVSResponseCode == 'E') {

										$address_status = 'AVS service not supported';

										$zip_status = 'AVS service not supported';

									} elseif ($AVSResponseCode == 'D') {

										$address_status = 'Address match (International)';

										$zip_status = 'Zip  match (International)';

									} elseif ($AVSResponseCode == 'M') {

										$address_status = 'Address match (International)';

										$zip_status = 'Zip  match (International)';

									} elseif ($AVSResponseCode == 'P') {

										$address_status = 'Address not verified because of incompatible formats';

										$zip_status = 'Zip matches';

									} elseif ($AVSResponseCode == 'N') {

										$address_status = 'Address  not match';

										$zip_status = 'Zip not matches';

									}

									if ($CVVResponseCode == 'M') {

										$cvv_status = 'Match';

									} elseif ($CVVResponseCode == 'P') {

										$cvv_status = 'Not Processed';

									} elseif ($CVVResponseCode == 'N') {

										$cvv_status = 'No Match';

									} elseif ($CVVResponseCode == 'S') {

										$cvv_status = 'CVV value should be on the card, but the merchant has indicated that it is not present (Visa & Discover)';

									} elseif ($CVVResponseCode == 'U') {

										$cvv_status = 'Issuer not certified for CVV processing';

									}
									if ($arrayy['Response']['Card']['CVVResponseCode'] != 'M') {
										$id = 'CVV-Number-Error'; 
										$this->session->set_flashdata('card_message', $id); 
										redirect('payment_error/'.$getEmail[0]['id']); 
									}
									//print_r($cvv_status);  die();
									$today2 = date("Y-m-d H:i:s");
									if ($message_complete == 'Declined') {
										$staus = 'declined';
									}
									//elseif($message_a=='Approved' or $message_a=='Duplicate')
									elseif ($message_complete == 'Approved') {
										$staus = 'confirm';
									} else {
										$staus = 'pending';
									}

									$day1 = date("N");

									$today2_a = date("Y-m-d");

									$year = date("Y");

									$month = date("m");

									$time11 = date("H");

									if ($time11 == '00') {

										$time1 = '01';

									} else {

										$time1 = date("H");

									}

									$today1 = date("Ymdhisu");
									$url = base_url() . 'rpayment/PY' . $today1 . '/' . $merchant_id;
									$today2 = date("Y-m-d");
									$year = date("Y");
									$month = date("m");
									$today3 = date("Y-m-d H:i:s");
									$unique = "PY" . $today1;
									$time11 = date("H");
									if ($time11 == '00') {
										$time1 = '01';
									} else {
										$time1 = date("H");
									}
									$day1 = date("N");
									//$amountaa = $sub_amount + $fee;

									$type = $getRow[0]['payment_type'];
									$recurring_type = $getRow[0]['recurring_type'];
									$recurring_count = $getRow[0]['recurring_count'];

									$paid = $getRow[0]['recurring_count_paid'] + 1;
									///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value
									$remain = ($recurring_count > 0) ? $getRow[0]['recurring_count_remain'] - 1 : 1;
									$recurring_pay_start_date = $getRow[0]['recurring_pay_start_date'];
									$recurring_next1 = $getRow[0]['recurring_next_pay_date'];
									$sub_total = $getRow[0]['sub_total'] + $amount;
									$paytype = $getRow[0]['recurring_pay_type'];
									$recurring_payment = $getRow[0]['recurring_payment']; //   start, stop,  complete
									if ($remain <= '0') {
										$recurring_payment = 'complete';
									} else {
										$recurring_payment = 'start';
									}

									$recurring_pay_start_date = date($recurring_next1);
									switch ($recurring_type) {
									case 'daily':
										$recurring_next_pay_date = Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
										break;

									case 'weekly':
										$recurring_next_pay_date = Date('Y-m-d', strtotime("+7 days", strtotime($recurring_pay_start_date)));
										break;

									case 'biweekly':
										$recurring_next_pay_date = date('Y-m-d', strtotime('+14 days', strtotime($recurring_pay_start_date)));
										break;

									case 'monthly':
										$recurring_next_pay_date = date('Y-m-d', strtotime('+1 month', strtotime($recurring_pay_start_date)));
										break;

									case 'quarterly':
										$recurring_next_pay_date = date('Y-m-d', strtotime('+3 month', strtotime($recurring_pay_start_date)));
										break;

									case 'yearly':
										$recurring_next_pay_date = date('Y-m-d', strtotime('+12 month', strtotime($recurring_pay_start_date)));
										break;

									default:
										$recurring_next_pay_date = Date('Y-m-d', strtotime("+1 days", strtotime($recurring_pay_start_date)));
										break;

									}

									$data = array(
										'reference' => $getRow[0]['reference'],
										'name' => $getRow[0]['name'],
										'invoice_no' => $getRow[0]['invoice_no'],
										'email_id' => $getRow[0]['email_id'],
										'mobile_no' => $getRow[0]['mobile_no'],
										'amount' => $getRow[0]['amount'],
										'sub_total' => $getRow[0]['sub_total'],
										'tax' => $getRow[0]['tax'],
										'fee' => $getRow[0]['fee'],
										's_fee' => $getRow[0]['s_fee'],
										// 'title' => $title,
										'detail' => $getRow[0]['detail'],
										'note' => $getRow[0]['note'],
										'url' => $url,
										'payment_type' => 'recurring',
										'recurring_type' => $recurring_type,
										'recurring_count' => $recurring_count,
										// 'due_date' => $due_date,
										'merchant_id' => $getRow[0]['merchant_id'],
										'sub_merchant_id' => $getRow[0]['sub_merchant_id'],
										'payment_id' => $unique,
										'recurring_payment' => $recurring_payment,

										'recurring_pay_start_date' => $recurring_pay_start_date,
										'recurring_next_pay_date' => $recurring_next_pay_date,
										'recurring_pay_type' => $paytype,

										'status' => $staus,

										'year' => $year,
										'month' => $month,
										'time1' => $time1,
										'day1' => $day1,
										'date_c' => $today2_a,
										'payment_date' => $today2,
										'recurring_count_paid' => $paid,
										'recurring_count_remain' => $remain,
										'transaction_id' => $trans_a_no,
										'message' => $message_a,
										'card_type' => $card_a_type,
										'card_no' => $card_a_no,
										'sign' => "",
										'address' => $address,
										'name_card' => $name_card,
										'l_name' => "",
										'address_status' => $address_status,
										'zip_status' => $zip_status,
										'cvv_status' => $cvv_status,
										'ip_a' => $_SERVER['REMOTE_ADDR'],
										'order_type' => 'a',
									);

									//print_r($data1);  die();

									$id1 = $this->Admin_model->insert_data("customer_payment_request", $data);
									$orderitem = $this->db->query("SELECT * FROM order_item WHERE p_id ='$rowid' ")->row_array();
									$data['resend'] = "";

									$item_Detail_1 = array(
										"p_id" => $id1,
										"item_name" => $orderitem['item_name'],
										"quantity" => $orderitem['quantity'],
										"price" => $orderitem['price'],
										"tax" => $orderitem['tax'],
										"tax_id" => $orderitem['tax_id'],
										"tax_per" => $orderitem['tax_per'],
										"total_amount" => $orderitem['total_amount'],

									);
									$this->Admin_model->insert_data("order_item", $item_Detail_1);

									$getQuery = $this->db->query("SELECT * from customer_payment_request where id  ='" . $id1 . "' ");
									$getEmail = $getQuery->result_array();
									$data['getEmail'] = $getEmail;

									$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "' ");
									$getEmail1 = $getQuery1->result_array(); //print_r($getEmail1);  die();
									$data['getEmail1'] = $getEmail1;

									$data['resend'] = "";

									$email = $getRow[0]['email_id'];

									$amount = $amount;

									$sub_total = $sub_total;

									$tax = $getRow[0]['tax'];

									$originalDate = $getRow[0]['date_c'];

									$newDate = date("F d,Y", strtotime($originalDate));

									$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));

									//Email Process

									$data['email'] = $getRow[0]['email_id'];

									$data['color'] = $getEmail1[0]['color'];

									$data['amount'] = $amount;

									$data['sub_total'] = $sub_total;

									$data['tax'] = $getRow[0]['tax'];

									$data['originalDate'] = $getRow[0]['date_c'];

									$data['card_a_no'] = $card_a_no;

									$data['trans_a_no'] = $trans_a_no;

									$data['card_a_type'] = $card_a_type;

									$data['message_a'] = $message_a;

									$data['msgData'] = $data;

									$msg = $this->load->view('email/receipt', $data, true);

									$email = $getRow[0]['email_id'];

									//echo  $email;   die("ok");

									$MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];

									if (!empty($email)) {

										$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
										// $this->email->set_header('Content-Transfer-Encoding','base64');
										// $this->email->set_header('Content-Transfer-Encoding','base64');

										$this->email->to($email);

										$this->email->subject($MailSubject);

										$this->email->message($msg);

										$this->email->send();

									}
									$url = $url;
									$purl = str_replace('rpayment', 'reciept', $url);

									// if(!empty($row['mobile_no']))
									// {

									// $sms_reciever = $row['mobile_no'];

									// $sms_message = trim('Payment Receipt : '.$purl);

									// $from = '+18325324983'; //trial account twilio number

									// $mob = str_replace(array( '(', ')','-',' ' ), '', $sms_reciever);

									// $to = '+1'.$mob;

									// $response = $this->twilio->sms($from, $to,$sms_message);

									// }
									$soapUrl1 = "https://services.elementexpress.com/"; //  live
									// $soapUrl1 = "https://certservices.elementexpress.com/";  //  demo 

									$referenceNumber = (rand(1000, 9999));
									$xml_post_string = "<PaymentAccountCreateWithTransID xmlns='https://services.elementexpress.com'>

	                                <Credentials>

	                                  <AccountID>" . $account_id . "</AccountID>

	                                  <AccountToken>" . $account_token . "</AccountToken>

	                                  <AcceptorID>" . $acceptor_id . "</AcceptorID>

	                                </Credentials>

	                                <Application>

	                                  <ApplicationID>" . $application_id . "</ApplicationID>

	                                  <ApplicationVersion>2.2</ApplicationVersion>

	                                  <ApplicationName>SaleQuick</ApplicationName>

	                                </Application>

	                                <PaymentAccount>

	                                  <PaymentAccountType>0</PaymentAccountType>

	                                  <PaymentAccountReferenceNumber>" . $referenceNumber . "</PaymentAccountReferenceNumber>

	                                </PaymentAccount>

	                                <Transaction>

	                                  <TransactionID>" . $trans_a_no . "</TransactionID>

	                                </Transaction>

	                              </PaymentAccountCreateWithTransID>"; // data from the form, e.g. some ID number
									//  print_r($xml_post_string);  die();
									$headers = array(

										"Content-type: text/xml;charset=\"utf-8\"",

										"Accept: text/xml",

										"Method:POST",

									); //SOAPAction: your op URL

									$url = $soapUrl1;

									// PHP cURL  for https connection with auth

									$ch = curl_init();

									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

									curl_setopt($ch, CURLOPT_URL, $url);

									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

									#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc

									curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

									curl_setopt($ch, CURLOPT_TIMEOUT, 10);

									curl_setopt($ch, CURLOPT_POST, true);

									curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request

									curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

									// converting

									$response = curl_exec($ch);

									$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);

									$json = json_encode($xml);

									$arrrayy = json_decode($json, true);

									// print_r($arrrayy); die();
									//print_r($arrayy['Response']['PaymentAccount']['PaymentAccountReferenceNumber']);
									//print_r($arrayy['Response']['PaymentAccount']['PaymentAccountID']);

									curl_close($ch);

									$my_toke = array(
										'name' => $name_card,
										//'mobile' => $getRow[0]['mobile_no'],
										// 'email' => $email,
										'card_type' => $card_a_type,
										'card_expiry_month' => $expiry_month,
										'card_expiry_year' => $expiry_year,
										'card_no' => $card_a_no,
										// 'transaction_id'=>$trans_a_no,
										'merchant_id'=>$merchant_id,
										'status'=>'1',
										'token' => $arrrayy['Response']['PaymentAccount']['PaymentAccountID']
									);

									//print_r($my_toke);   die();
									//$mob = str_replace(array( '(', ')','-',' ' ), '', $mobile_no);
									//$gettoken=$this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND mobile='$cardphone'  ")->result_array();

									if ($tokenid) {
										//$m=$this->db->insert('token',$my_toke); tokenid
										//$m=$this->db->update('token',$my_toke);
										$this->db->where('id', $tokenid);
										$rest = $this->db->update('token', $my_toke);
									}

									if ($rest) {
										$html = '<!DOCTYPE html>
	                                  <html>
	                                  <head>
	                                    <title>New Card updated  Payment</title>
	                                  </head>
	                                  <body>
	                                    <div><center> Your card is updated.  Today. </center></div>
	                                    <div class="row"> <table>
	                                    <tr>
	                                       <th>Name</th>
	                                       <th>' . $name_card . '</th>
	                                    </tr>
	                                    <tr>
	                                       <th>Card type</th>
	                                       <th>' . $card_a_type . '</th>
	                                    </tr>
	                                    <tr>
	                                       <th>Card No</th>
	                                       <th>' . $card_a_no . '</th>
	                                    </tr>
	                                    <tr>
	                                       <th>Exp Month</th>
	                                       <th>' . $expiry_month . '</th>
	                                    </tr>
	                                    <tr>
	                                       <th>Exp Year</th>
	                                       <th>' . $expiry_year . '</th>
	                                    </tr>


	                                    </table></div>
	                                  </body>
	                                  </html>';

										$MailSubject_merchant = 'Salequick : Update New Card  Payment';
										if (!empty($merchant_email)) {
											$this->email->from('info@salequick.com', 'SaleQuick Payment');
											$this->email->to($email);
											$this->email->subject($MailSubject_merchant);
											$this->email->message($html);
											$this->email->send();
										}
									}

									//print_r($token_data); die;
									$save_notificationdata = array(
										'merchant_id' => $getRow[0]['merchant_id'],
										'name' => $name_card,
										'mobile' => $getRow[0]['mobile_no'],
										'email' => $getRow[0]['email_id'],
										'card_type' => $card_a_type,
										'card_expiry_month' => $expiry_month,
										'card_expiry_year' => $expiry_year,
										'card_no' => $card_a_no,
										'amount' => $amount,
										'address' => $getRow[0]['address'],
										'transaction_id' => $trans_a_no,
										'transaction_date' => $transaction_date,
										'notification_type' => 'payment',
										'invoice_no' => $getRow[0]['invoice_no'],
										'status' => 'unread',
									);
									//print_r($save_notificationdata); die();
									$this->db->insert('notification', $save_notificationdata);

									//$this->session->set_flashdata('success','<div class="alert alert-success text-center">Your New card Updated...</div>');
									$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Your New card Updated... </div>');
									// $this->load->view('merchant/update_card',$data);
									//redirect(base_url('signup/updatecard/'.$rowid));
									redirect(base_url() . 'rpayment/' . $unique . '/' . $merchant_id);

								} else if ($arrayy['Response']['ExpressResponseMessage'] == 'Declined') {
									$error_msg = $arrayy['Response']['ExpressResponseMessage'];
									$this->session->set_flashdata('error', '<div class="alert alert-danger text-center">' . $error_msg . '</div>');
									redirect(base_url('signup/updatecard/' . $getRow[0]['id']));
								} else {
									$error_msg = $arrayy['Response']['ExpressResponseMessage'];
									$this->session->set_flashdata('error', '<div class="alert alert-danger text-center">' . $error_msg . '</div>');
									redirect(base_url('signup/updatecard/' . $getRow[0]['id']));
								}

							} else {
								$error_msg = $array['Response']['ExpressResponseMessage'];
								$this->session->set_flashdata('error', '<div class="alert alert-danger text-center">' . $error_msg . '</div>');
								redirect(base_url('signup/updatecard/' . $getRow[0]['id']));
							}

						} else {

							$this->session->set_flashdata('error', '<div class="alert alert-danger text-center">Invalid Account Token Id. </div>');
							redirect(base_url('signup/updatecard/' . $getRow[0]['id']));

						}
					} else {

						$this->session->set_flashdata('error', '<div class="alert alert-danger text-center">Today is No Payment.</div>');
						redirect(base_url('signup/updatecard/' . $getRow[0]['id']));
					}
				}

			}
			$this->load->view('merchant/update_card', $data);
		}
		public function confirm() {

			$id = $this->uri->segment(2);

			$getQuery = $this->db->query("SELECT * from merchant where auth_key='" . $id . "' ");

			$getEmail = $getQuery->result_array();

			$getEmailCount = $getQuery->num_rows();

			$data['getEmailCount'] = $getEmailCount;

			if ($getEmailCount > 0) {
				//print_r($getEmail); die();
				if ($getEmail[0]['status'] == 'pending' || $getEmail[0]['status'] == 'block' || $getEmail[0]['status'] == 'Waiting_For_Approval') {

					$bct_id1 = $this->uri->segment(4);

					$info = array(

						// 'status' => 'confirm'
						//'status' => 'active'

						//'status' => 'Activate_Details'
						'status' => 'Waiting_For_Approval',
					);

					$this->Home_model->update_date_single($id, $info);

					$this->session->set_flashdata('cmsg', '<div class="alert alert-success text-center" style="max-width: 60%; margin: 0 auto 20px;"> Your Email  Confirm Successfully </div>');

				} elseif ($getEmail[0]['status'] == 'confirm') {

					$this->session->set_flashdata('cmsg', '<div class="alert alert-success text-center" style="max-width: 60%; margin: 0 auto 20px;"> Your Email Already Confirm  </div>');

				}

			} else {

				$this->session->set_flashdata('cmsg', '<div class="alert alert-danger text-center" style="max-width: 60%; margin: 0 auto 20px;">  Email  Not Available </div>');

			} // redirect("confirm");

			// $this->load->view('confirm');
                        $this->load->view('confirm_dash');

		}

		public function payment_cnp() {
			$paymentcard = $this->input->post('card_selection_radio') ? $this->input->post('card_selection_radio') : "";
			$issavecard = $this->input->post('issavecard') ? $this->input->post('issavecard') : "0";
			if ($paymentcard == 'newcard') {
				$signImg = $this->input->post('sign') ? $this->input->post('sign') : "";
			} else {
				$signImg = $this->input->post('signImg') ? $this->input->post('signImg') : "";
				$verify_phone_on_cp = $this->input->post('verify_phone_on_cp') ? $this->input->post('verify_phone_on_cp') : "";

			}
			// echo 'Sign Image :  <br/>'.$signImg ; die('this');
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
			$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
			$transaction_id = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : "";
			$message = $this->input->post('message') ? $this->input->post('message') : "";
			$card_type = $this->input->post('card_type') ? $this->input->post('card_type') : "";
			$card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
			$address = $this->input->post('address') ? $this->input->post('address') : "";
			$zip = $this->input->post('zip') ? $this->input->post('zip') : "";
			$today2 = date("Y-m-d H:i:s");
			$purl = base_url() . "reciept/$bct_id1/$bct_id2";
			//print_r($bct_id2.'--'.$bct_id1); die();
			$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
			$getEmail = $getQuery->result_array();
			$data['getEmail'] = $getEmail;
			$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "' ");
			$getEmail1 = $getQuery1->result_array(); //print_r($getEmail1);  die();
			$data['getEmail1'] = $getEmail1;
			$late_grace_period = $getEmail1[0]['late_grace_period'];
			if($getEmail[0]['payment_type'] == 'recurring') {
				$payment_date = date('Y-m-d', strtotime($getEmail[0]['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
			} else {
				$payment_date = date('Y-m-d', strtotime($getEmail[0]['due_date']. ' + '.$late_grace_period.' days'));
			}
			$late_fee = $getEmail1[0]['late_fee_status'] > 0 && date('Y-m-d') > $payment_date ? $getEmail1[0]['late_fee'] : 0 ;
			
			$merchant_id = $bct_id2;
			if (count($getEmail)) {
				$type = $getEmail[0]['payment_type'];
				$paid = $getEmail[0]['recurring_count_paid'] + 1;
				$remain = $getEmail[0]['recurring_count_remain'] - 1;
				$amount = $getEmail[0]['amount'];
				
				
				$total_amount_with_late_fee_new = number_format(($getEmail[0]['amount'] + $late_fee),2);
				
			$b = str_replace(",","",$total_amount_with_late_fee_new);
            $a = number_format($b,2);
            $total_amount_with_late_fee = str_replace(",","",$a);
            
            //print_r($total_amount_with_late_fee);

					
				$name = $getEmail[0]['name'];
				$phone = $getEmail[0]['mobile_no'];
				$invoice_no = $getEmail[0]['invoice_no'];
				
			}
			if ($paymentcard != 'newcard') {
				if (isset($verify_phone_on_cp)) {
					if (count($getEmail)) {
						if ($verify_phone_on_cp != $getEmail[0]['mobile_no']) {
							$id = "Mobile-Number-Not-Matched";
							$id=strtolower(urldecode($id)); 
							echo 'payment_error/' . $id;die();
						}
					} else {
						$id = "Something went wrong, please try again!!";
						$this->session->set_flashdata('error', $id);
						echo base_url('card_payment/');
					}
				} else {
					$id = "Mobile-Number-Not-Matched";
					$id=strtolower(urldecode($id)); 
					echo 'payment_error/' . $id;die();
				}
			}
			//die("its mateched");
			//Data, connection, auth
			# $dataFromTheForm = $_POST['fieldName']; // request data from the form
			$soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
			// $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
			$getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
			$getEmail_a = $getQuery_a->result_array();
			$data['$getEmail_a'] = $getEmail_a;
			if (count($getEmail_a)) {
				$merchant_email = $getEmail_a[0]['email'];
			}
			// $account_id = $getEmail_a[0]['account_id_cnp'];
			// $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
			// $account_token = $getEmail_a[0]['account_token_cnp'];
			// $application_id = $getEmail_a[0]['application_id_cnp'];
			// $terminal_id = $getEmail_a[0]['terminal_id'];

			// $account_id = '1070806';
			// $acceptor_id = '3928907';
			// $account_token = '1A928FD287607C9B1B68E4CB1F52AFF914C37FA6E291FCEF79A199F41A3DBA20858BD901';
			// $application_id = '10049';
			// $terminal_id='4374N000101';
			//print_r($getEmail_a);  die();
			if (!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id'])) {
				//if($account_id && $acceptor_id && $account_token && $application_id && $terminal_id)
				$account_id = $getEmail_a[0]['account_id_cnp'];
				$acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
				$account_token = $getEmail_a[0]['account_token_cnp'];
				$application_id = $getEmail_a[0]['application_id_cnp'];
				$terminal_id = $getEmail_a[0]['terminal_id'];

				$card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
				$cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
				$name_card = $this->input->post('name_card') ? $this->input->post('name_card') : "";

				$mmyy = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
				//print_r($mmyy);
				$pos = strpos($mmyy, '/');
				$expiry_month = substr($mmyy, 0, $pos);
				$expiry_year = substr($mmyy, $pos + 1, 2);
				$payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
				// xml post structure
				$xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>"; // data from the form, e.g. some ID number
				$headers = array(
					"Content-type: text/xml;charset=\"utf-8\"",
					"Accept: text/xml",
					"Cache-Control: no-cache",
					"Pragma: no-cache",
					"SOAPAction: https://transaction.elementexpress.com/",
					"Content-length: " . strlen($xml_post_string),
				); //SOAPAction: your op URL
				//print_r($xml_post_string); die("ok");
				$url = $soapUrl;
				
				// PHP cURL  for https connection with auth
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$response = curl_exec($ch);

				$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
				$json = json_encode($xml);
				$array = json_decode($json, true);
				//print_r($array); die("ok");
				curl_close($ch);
			
				$TicketNumber = (rand(100000, 999999));
				if ($array['Response']['ExpressResponseMessage'] = 'ONLINE') {
					if ($paymentcard == 'newcard') {
						$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken>
	               		<AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
	               		<ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>" . $total_amount_with_late_fee . "</TransactionAmount><ReferenceNumber>" . $payment_id . "</ReferenceNumber>
	               		<TicketNumber>" . $TicketNumber . "</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
	               		<CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
	               		</Terminal><Card><CardNumber>" . $card_no . "</CardNumber><ExpirationMonth>" . $expiry_month . "</ExpirationMonth><ExpirationYear>" . $expiry_year . "</ExpirationYear><CVV>" . $cvv . "</CVV></Card><Address><BillingZipcode>" . $zip . "</BillingZipcode>
	   					<BillingAddress1>" . $address . "</BillingAddress1></Address></CreditCardSale>"; // data from the form, e.g. some ID number
						$headers = array(
							"Content-type: text/xml;charset=\"utf-8\"",
							"Accept: text/xml",
							"Cache-Control: no-cache",
							"Pragma: no-cache",
							"SOAPAction: https://transaction.elementexpress.com/",
							"Content-length: " . strlen($xml_post_string),
						); //SOAPAction: your op URL
						$url = $soapUrl;
						//print_r($xml_post_string); die();
						// PHP cURL  for https connection with auth
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword);
						// username and password - declared at the top of the doc
						curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
						curl_setopt($ch, CURLOPT_TIMEOUT, 10);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						// converting
						$response = curl_exec($ch);
						$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
						$json = json_encode($xml);
						$arrayy = json_decode($json, true);
						curl_close($ch);
						//print_r($arrayy);  die(' ExpressResponseMessage '); 
						// $arrayy['Response']['ExpressResponseMessage'] ='Declined';  
						// $arrayy['Response']['ExpressResponseCode']='20';

						if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved' ){
							$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
							$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
							$card_a_type = $arrayy['Response']['Card']['CardLogo'];

							//print_r($card_a_type);  die();
							$message_a = $arrayy['Response']['Transaction']['TransactionStatus'];
							$message_complete = $arrayy['Response']['ExpressResponseMessage'];
							$AVSResponseCode = $arrayy['Response']['Card']['AVSResponseCode'];
							$CVVResponseCode = $arrayy['Response']['Card']['CVVResponseCode'];
							//$arrayy['Response']['Transaction']['ApprovedAmount'];
							//  print_r($CVVResponseCode);
							//  die();
							if ($AVSResponseCode == 'A') {
								$address_status = 'Address match';
								$zip_status = 'Zip does not match';
							} elseif ($AVSResponseCode == 'G') {
								$address_status = 'Global non-AVS participant';
								$zip_status = 'Global non-AVS participant';
							} elseif ($AVSResponseCode == 'N') {
								$address_status = 'Address  not match';
								$zip_status = 'Zip  not match';
							} elseif ($AVSResponseCode == 'R') {
								$address_status = 'Retry, system unavailable or timed out';
								$zip_status = 'Retry, system unavailable or timed out';
							} elseif ($AVSResponseCode == 'S') {
								$address_status = 'Service not supported: Issuer does not support AVS and Visa';
								$zip_status = 'Service not supported: Issuer does not support AVS and Visa';
							} elseif ($AVSResponseCode == 'U') {
								$address_status = 'Unavailable: Address information not verified for domestic transactions';
								$zip_status = 'Unavailable: Address information not verified for domestic transactions';
							} elseif ($AVSResponseCode == 'W') {
								$address_status = 'Address does not match';
								$zip_status = 'Zip matches';
							} elseif ($AVSResponseCode == 'X') {
								$address_status = 'Address match';
								$zip_status = 'Zip matches';
							} elseif ($AVSResponseCode == 'Y') {
								$address_status = 'address match';
								$zip_status = 'zip match';
							} elseif ($AVSResponseCode == 'Z') {
								$address_status = 'Address does not match';
								$zip_status = 'zip match';
							} elseif ($AVSResponseCode == 'E') {
								$address_status = 'AVS service not supported';
								$zip_status = 'AVS service not supported';
							} elseif ($AVSResponseCode == 'D') {
								$address_status = 'Address match (International)';
								$zip_status = 'Zip  match (International)';
							} elseif ($AVSResponseCode == 'M') {
								$address_status = 'Address match (International)';
								$zip_status = 'Zip  match (International)';
							} elseif ($AVSResponseCode == 'P') {
								$address_status = 'Address not verified because of incompatible formats';
								$zip_status = 'Zip matches';
							} elseif ($AVSResponseCode == 'N') {
								$address_status = 'Address  not match';
								$zip_status = 'Zip not matches';
							}
							if ($CVVResponseCode == 'M') {
								$cvv_status = 'Match';
							} elseif ($CVVResponseCode == 'P') {
								$cvv_status = 'Not Processed';
							} elseif ($CVVResponseCode == 'N') {
								$cvv_status = 'No Match';
							} elseif ($CVVResponseCode == 'S') {
								$cvv_status = 'CVV value should be on the card, but the merchant has indicated that it is not present (Visa & Discover)';
							} elseif ($CVVResponseCode == 'U') {
								$cvv_status = 'Issuer not certified for CVV processing';
							}
							//print_r($arrayy['Response']['Card']['CVVResponseCode']);  die("tgfgg");
							if ($arrayy['Response']['Card']['CVVResponseCode'] != 'M') {
								$id = 'CVV-Number-Error';
								$this->session->set_flashdata('card_message', $id);
								redirect('payment_error/'.$getEmail[0]['id']);
							}
							//print_r($cvv_status);  die();
							if ($message_complete == 'Declined') {
								$staus = 'declined';
							}
							//elseif($message_a=='Approved' or $message_a=='Duplicate')
							elseif ($message_complete == 'Approved') {
								$staus = 'confirm';
							} else {
								$staus = 'pending';
							}
							//print_r($staus);  die();
							$day1 = date("N");
							$today2_a = date("Y-m-d");
							$year = date("Y");
							$month = date("m");
							$time11 = date("H");
							if ($time11 == '00') {
								$time1 = '01';
							} else {
								$time1 = date("H");
							}
							$type = $getEmail[0]['payment_type'];
							$recurring_type = $getEmail[0]['recurring_type'];
							$recurring_count = $getEmail[0]['recurring_count'];

							$paid = $getEmail[0]['recurring_count_paid'] + 1;
							$remain = ($recurring_count > 0) ? $getEmail[0]['recurring_count_remain'] - 1 : 1;
							$recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
							$recurring_next1 = $getEmail[0]['recurring_next_pay_date'];
							$sub_total = $getEmail[0]['sub_total'] + $amount;
							$paytype = $getEmail[0]['recurring_pay_type'];
							$recurring_payment = $getEmail[0]['recurring_payment']; //   start, stop,  complete
							$lastRecord = $this->Admin_model->getlast_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
							$AllPaidRequest = $this->Admin_model->getAllpaid_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
							//print_r($lastRecord->recurring_count); echo "<br/>";
							// print_r($AllPaidRequest);
							if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
								$recurring_payment = 'complete';
							} else {
								$recurring_payment = $getEmail[0]['recurring_payment'];
							}
							//echo 'recurring_payment '.$recurring_payment.' paid'.$paid.' remain'.$remain.' paytype'.$paytype.' recurring_payment'.$recurring_payment;
							// die();
							if ($type == 'straight') {
								$info = array(
									'status' => $staus,
									'late_fee' => $late_fee,
									'amount' => $total_amount_with_late_fee,
									'year' => $year,
									'month' => $month,
									'time1' => $time1,
									'day1' => $day1,
									'date_c' => $today2_a,
									'payment_date' => $today2,
									'transaction_id' => $trans_a_no,
									'message' => $message_a,
									'card_type' => $card_a_type,
									'card_no' => $card_a_no,
									'sign' => $signImg,
									'address' => $address,
									'name_card' => $name_card,
									'l_name' => "",
									'address_status' => $address_status,
									'zip_status' => $zip_status,
									'cvv_status' => $cvv_status,
									'ip_a' => $_SERVER['REMOTE_ADDR'],
									'order_type' => 'a',
								);
							} elseif ($type == 'recurring') {
								$info = array(
									'status' => $staus,
									'late_fee' => $late_fee,
									'amount' => $total_amount_with_late_fee,
									'year' => $year,
									'month' => $month,
									'time1' => $time1,
									'day1' => $day1,
									'date_c' => $today2_a, // $today2_a
									'payment_date' => $today2,
									'recurring_count_paid' => $paid,
									'recurring_count_remain' => $remain,
									'transaction_id' => $trans_a_no,
									'message' => $message_a,
									'card_type' => $card_a_type,
									'card_no' => $card_a_no,
									'sub_total' => $amount,
									'recurring_payment' => $recurring_payment,
									'address' => $address,
									'sign' => $signImg,
									'name_card' => $name_card,
									'l_name' => "",
									'address_status' => $address_status,
									'zip_status' => $zip_status,
									'cvv_status' => $cvv_status,
									'ip_a' => $_SERVER['REMOTE_ADDR'],
									'order_type' => 'a',
								);
							}
							//print_r($info);  die("op");
							if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
								$up = $this->Stop_recurring($getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
							}
							// print_r($info);
							$m = $this->Home_model->update_payment_single($id, $info);
							// echo $m; die();
							//echo  $this->db->last_query();  die("my query");
							$this->session->set_flashdata('pmsg', '<div class="text-success text-center">  Payment  Complete </div>');
							$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
							$getEmail = $getQuery->result_array();
							$data['getEmail'] = $getEmail;
							$data['resend'] = "";
							$email = $getEmail[0]['email_id'];
							$amount = $getEmail[0]['amount'];
							$sub_total = $getEmail[0]['sub_total'];
							$tax = $getEmail[0]['tax'];
							$originalDate = $getEmail[0]['date_c'];
							$newDate = date("F d,Y", strtotime($originalDate));
							$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
							//Email Process
							$data['email'] = $getEmail[0]['email_id'];
							$data['color'] = $getEmail1[0]['color'];
							$data['amount'] = $getEmail[0]['amount'];
							$data['sub_total'] = $getEmail[0]['sub_total'];
							$data['tax'] = $getEmail[0]['tax'];
							$data['originalDate'] = $getEmail[0]['date_c'];
							$data['card_a_no'] = $card_a_no;
							$data['invoice_detail_receipt_item'] = $item;
							$data['trans_a_no'] = $trans_a_no;
							$data['card_a_type'] = $card_a_type;
							$data['message_a'] = $message_a;
							$data['late_grace_period'] = $getEmail_a[0]['late_grace_period'];
							$data['late_fee_status'] = $getEmail_a[0]['late_fee_status'];
							$data['late_fee'] = $getEmail[0]['late_fee'];
							$data['recurring_type'] = $getEmail[0]['recurring_type'];
							$data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
							$data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
							$data['msgData'] = $data;
							//Send Mail Code
							$msg = $this->load->view('email/new_receipt', $data, true);
							$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
							$email = $email;
							$name_of_customer = $getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id'];
							$MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];
							$MailSubject2 = ' Receipt to ' . $name_of_customer;
							if (!empty($email)) {
								$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
								$this->email->to($email);
								$this->email->subject($MailSubject);
								$this->email->message($msg);
								$this->email->send();
							}
	                        $merchant_email = $getEmail1[0]['email'];
							
							if (!empty($merchant_email)) {
								$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
								$this->email->to($merchant_email);
								$this->email->subject($MailSubject2);
								$this->email->message($merchnat_msg);
								$this->email->send();
							}
							$merchant_notification_email=$getEmail1[0]['notification_email'];
							if(!empty($merchant_notification_email)){  
								$notic_emails=explode(",",$merchant_notification_email);
								$length=count($notic_emails); 
								$i=0; $arraydata=array(); 
								for( $i=0; $i < $length; $i++) {
									$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
									$this->email->to($notic_emails[$i]);
									$this->email->subject($MailSubject2);
									$this->email->message($merchnat_msg);
									$this->email->send();
									//array_push($arraydata,$notic_emails[$i]);
							    }
							}
							//    die('its Ok');
							if ($type != 'recurring') {
								if (!empty($getEmail[0]['mobile_no'])) {
									//$sms_sender = trim($this->input->post('sms_sender'));
									$sms_reciever = $getEmail[0]['mobile_no'];
									//$sms_message = trim(' Receipt from ' . $getEmail1[0]['business_dba_name'] . ' : ' . $purl);
									 $sms_message = trim('Payment Receipt : '.$purl);
									$from = '+18325324983'; //trial account twilio number
									// $to = '+'.$sms_reciever; //sms recipient number
									$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
									$to = '+1' . $mob;
									$response = $this->twilio->sms($from, $to, $sms_message);
								}
							}
							if (($getEmail1[0]['is_token_system_permission'] == '1' && $issavecard == '1') || $paytype == '1') {
								$soapUrl1 = "https://services.elementexpress.com/"; //  live
								// $soapUrl1 = "https://certservices.elementexpress.com/"; //   test
								$referenceNumber = (rand(1000, 9999));
								$xml_post_string = "<PaymentAccountCreateWithTransID xmlns='https://services.elementexpress.com'>
	                                <Credentials>
	                                <AccountID>" . $account_id . "</AccountID>
	                                <AccountToken>" . $account_token . "</AccountToken>
	                                <AcceptorID>" . $acceptor_id . "</AcceptorID>
	                                </Credentials>
	                                <Application>
	                                <ApplicationID>" . $application_id . "</ApplicationID>
	                                <ApplicationVersion>2.2</ApplicationVersion>
	                                <ApplicationName>SaleQuick</ApplicationName>
	                                </Application>
	                                <PaymentAccount>
	                                <PaymentAccountType>0</PaymentAccountType>
	                                <PaymentAccountReferenceNumber>" . $referenceNumber . "</PaymentAccountReferenceNumber>
	                                </PaymentAccount>
	                                <Transaction>
	                                <TransactionID>" . $trans_a_no . "</TransactionID>
	                                </Transaction>
	                            </PaymentAccountCreateWithTransID>"; // data from the form, e.g. some ID number
								$headers = array(
									"Content-type: text/xml;charset=\"utf-8\"",
									"Accept: text/xml",
									"Method:POST",
								); //SOAPAction: your op URL
								$url = $soapUrl1;
								// PHP cURL  for https connection with auth
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
								curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
								curl_setopt($ch, CURLOPT_TIMEOUT, 10);
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								// converting
								$response = curl_exec($ch);
								$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
								$json = json_encode($xml);
								$arrrayy = json_decode($json, true);
								curl_close($ch);
								$mob = str_replace(array('(', ')', '-', ' '), '', $phone);
								$merchant_id=$getEmail[0]['merchant_id'];
								$my_toke = array(
									'name' => $name_card,
									'mobile' => $mob,
									'email' => $email,
									'card_type' => $card_a_type,
									'card_expiry_month' => $expiry_month,
									'card_expiry_year' => $expiry_year,
									'card_no' => $card_a_no,
									// 'transaction_id'=>$trans_a_no,
									'merchant_id'=>$merchant_id,
									'status'=>$issavecard,
									'token' => $arrrayy['Response']['PaymentAccount']['PaymentAccountID'],
								);

								if($email!="" && $mob!="" &&  $merchant_id!="")
								{
									$gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND  ( mobile='$mob' or  email='$email' )  AND merchant_id='$merchant_id' ")->result_array();

								}
								else if($email="" && $mob!="" &&  $merchant_id!="")
								{
									$gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND mobile='$mob'  AND merchant_id='$merchant_id' ")->result_array();

								}
								else if($email!="" && $mob="" &&  $merchant_id!="")
								{

									$gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND email='$email'  AND merchant_id='$merchant_id' ")->result_array();
								}

								if (count($gettoken) <= 0) {
									$this->db->insert('token', $my_toke);
									$m = $this->db->insert_id();
									$invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $m,'merchant_id'=>$merchant_id);
								} else {
									$invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $gettoken[0]['id'],'merchant_id'=>$merchant_id);
								}
								$this->db->insert('invoice_token', $invoice_tokenData);
							}
							//print_r($m); die();
							$TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
							$TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
							//print_r($arrayy);  die();
							$Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
							$Address = $arrayy['Response']['Address']['BillingAddress1'];

							$Ttime = substr($TransactionTime, 0, 2) . ':' . substr($TransactionTime, 2, 2) . ':' . substr($TransactionTime, 4, 2);
							$Tdate = substr($TransactionDate, 0, 4) . '-' . substr($TransactionDate, 4, 2) . '-' . substr($TransactionDate, 6, 2);
							//die(); //2019-07-04 12:05:41
							$rt = $Tdate . ' ' . $Ttime;
							$transaction_date = date($rt);
							$save_notificationdata = array(
								'merchant_id' => $merchant_id,
								'name' => $name,
								'mobile' => $phone,
								'email' => $email,
								'card_type' => $card_a_type,
								'card_expiry_month' => $expiry_month,
								'card_expiry_year' => $expiry_year,
								'card_no' => $card_a_no,
								'amount' => $Amount,
								'address' => $Address,
								'transaction_id' => $trans_a_no,
								'transaction_date' => $transaction_date,
								'notification_type' => 'payment',
								'invoice_no' => $invoice_no,
								'status' => 'unread',
							);
							//print_r($save_notificationdata); die();
							$this->db->insert('notification', $save_notificationdata);
							if ($getEmail[0]['payment_type'] == 'recurring') {
								redirect(base_url() . 'rpayment/' . $bct_id1 . '/' . $bct_id2);
							} else {
								redirect(base_url() . 'payment/' . $bct_id1 . '/' . $bct_id2);
							}
							// End Token
							//print_r($response); die();
						} else {
							if($arrayy['Response']['ExpressResponseMessage'] == 'Declined') {   
								if($getEmail[0]["recurring_pay_type"] == '1'){
									$paytyps='Auto';
								} else {
									$paytyps='Manual';
								}
								if($late_fee > 0) {
									$declined_late_fee = '<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
										<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Late Fee:</span>
										<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">$ '.$late_fee.'</span>
										</p>';
								} else {
									$declined_late_fee = '';
								}
								$msg='<!DOCTYPE html>
									<html>
										<head>
											<title>Decline Payment</title>
											<meta name="viewport" content="width=device-width,initial-scale=1">
											<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
										</head>
										<body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 14px !important;background:#f4f7fc">
											<div style="max-width: 100%;margin: 0;padding: 0;clear: both;">
												<div style="padding: 25px 15px;background-color: #357fdf;border-bottom: 1px solid #3f86e1;clear:both;">
													<a href="https://salequick.com/" style="max-width: 251px;text-align: center;margin: 10px auto 20px;width: 100%;display: block;">   
														<img src="https://salequick.com/email/images/logo-w.png" style="width: 100%;max-width: 100%;margin-top: 10px;">
													</a>
													<h3 style="margin-top: 25px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">Card Declined </h3>
												</div>
												<div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
													<div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
														<div style="width: auto;font-weight: 600;color: #656565;text-align: center;display: inline-block;max-width: 623px;margin: 0 auto;background-color: rgba(53, 127, 223, 0.05);border: 1px solid rgba(53, 127, 223, 0.2);">
															<p style="font-size: 21px;float: left;width: 100%;clear: both;color: #444">Card <span style="color: #d0021b;">Declined</span> </p>
															<div style="float: left;width: 100%;clear: both;">
															<br>
														</div>
														<br>
														<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Card Number:</span>
															<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.('****'.substr($card_no, -4)).' </span>
														</p>
														<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Invoice No:</span>
															<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["invoice_no"].' </span>
														</p>
														<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Total Amount:</span>
															<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">$ '.$total_amount_with_late_fee.'</span>
														</p>
														'.$declined_late_fee.'
														<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Payment Type:</span>
															<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$paytyps.' </span>
														</p>
														<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Name:</span>
															<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["name"].'</span>
														</p>
														<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Email:</span>
															<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["email_id"].'</span>
														</p>
														<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
															<span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Phone:</span>
															<span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["mobile_no"].'</span>
														</p>
														
														<br>
													</div>
												</div>
											</div>
											<div style="float: left;width: 100%;clear: both;">
												<br>
											</div>
											<div style="float: left;width:100%;text-align:center;clear: both;max-width: 100%;">
												<div style="max-width: 970px;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 0 auto;display: table;padding: 15px;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
													<div style="width:100%;padding-top: 7px;color:#666;float: left;margin: 0 0 10px;">
														<a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
														<a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
													</div>
													<div style="float: left;width:100%;text-align:center;margin: 0 0 10px;">
														<a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
															<img src="https://salequick.com/front/invoice/img/foot_icon1.jpg">
														</a>
														<a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
															<img src="https://salequick.com/front/invoice/img/foot_icon2.jpg">
														</a>
														<a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
															<img src="https://salequick.com/front/invoice/img/foot_icon3.jpg">
														</a>
														<a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
															<img src="https://salequick.com/front/invoice/img/foot_icon4.jpg">
														</a>
													</div>
												</div>
											</div>
										</div>
									</body>
								</html>'; 
		 
								
								$customername=$getEmail[0]['name'] ? $getEmail[0]['name']:$getEmail[0]['email_id']; 
								$MailSubject = ' Declined   Payment form '.$getEmail1[0]['business_dba_name'];
								$MailSubject2 = ' Declined   Payment of '.$customername;
								   
							 	$email=$getEmail[0]['email_id'];
							 	if(!empty($email)) { 
									$this->email->from('info@salequick.com',   $getEmail1[0]['business_dba_name']);
									$this->email->to($email);
									$this->email->subject($MailSubject);
									$this->email->message($msg);
									$this->email->send();
								}
								// $merchant_email=$getEmail1[0]['email'];
								// if(!empty($merchant_email)){ 
				
								// 	$this->email->from('info@salequick.com',   $getEmail1[0]['business_dba_name']);
								// 	$this->email->to($merchant_email);
								// 	$this->email->subject($MailSubject2);
								// 	$this->email->message($msg);
								// 	$this->email->send();
								// 	}
							}
							$this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
							$id = $arrayy['Response']['ExpressResponseMessage'];
							$this->session->set_flashdata('card_message', $id);
							redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
								
						}
					} else {
						//$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
					 	$xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'>

								<Credentials>

								<AccountID>" . $account_id . "</AccountID>

								<AccountToken>" . $account_token . "</AccountToken>

								<AcceptorID>" . $acceptor_id . "</AcceptorID>

								</Credentials>

								<Application>

								<ApplicationID>" . $application_id . "</ApplicationID>

								<ApplicationVersion>2.2</ApplicationVersion>

								<ApplicationName>SaleQuick</ApplicationName>

								</Application>

								<Transaction>

								<TransactionAmount>" . $amount . "</TransactionAmount>

								<ReferenceNumber>84421174091</ReferenceNumber>

								<TicketNumber>" . $TicketNumber . "</TicketNumber>

								<MarketCode>3</MarketCode>

								<PaymentType>3</PaymentType>

								<SubmissionType>2</SubmissionType>

								<NetworkTransactionID>000001051388332</NetworkTransactionID>

								</Transaction>

								<Terminal>

								<TerminalID>" . $terminal_id . "</TerminalID>

								<CardPresentCode>3</CardPresentCode>

								<CardholderPresentCode>7</CardholderPresentCode>

								<CardInputCode>4</CardInputCode>

								<CVVPresenceCode>2</CVVPresenceCode>

								<TerminalCapabilityCode>5</TerminalCapabilityCode>

								<TerminalEnvironmentCode>6</TerminalEnvironmentCode>

								<MotoECICode>7</MotoECICode>

								</Terminal>

								<PaymentAccount>

								<PaymentAccountID>" . $paymentcard . "</PaymentAccountID>

								</PaymentAccount>

								</CreditCardSale>"; // data from the form, e.g. some ID number
								//print_r($xml_post_string); die();
								$headers = array(

									"Content-type: text/xml;charset=\"utf-8\"",

									"Accept: text/xml",

									"Method:POST",

								); //SOAPAction: your op URL

								$url = $soapUrl;

								// PHP cURL  for https connection with auth

								$ch = curl_init();

								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

								curl_setopt($ch, CURLOPT_URL, $url);

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								#curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc

								curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

								curl_setopt($ch, CURLOPT_TIMEOUT, 10);

								curl_setopt($ch, CURLOPT_POST, true);

								curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request

								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

								// converting

								$response = curl_exec($ch);

								$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);

								$json = json_encode($xml);

								$arrayy = json_decode($json, true);

								//print_r($arrayy);   die();
								

								//print_r($arrayy);

								curl_close($ch);

						if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved') {

							$card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];

							$trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];

							$card_a_type = $arrayy['Response']['Card']['CardLogo'];

							$message_a = $arrayy['Response']['Transaction']['TransactionStatus'];

							$message_complete = $arrayy['Response']['ExpressResponseMessage'];

							//print_r($arrayy); die();
							$TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
							$TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
							$Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
							$Address = "";
							if (isset($arrayy['Response']['Address']['BillingAddress1'])) {
								$Address = $arrayy['Response']['Address']['BillingAddress1'];
							}
							$Ttime = substr($TransactionTime, 0, 2) . ':' . substr($TransactionTime, 2, 2) . ':' . substr($TransactionTime, 4, 2);
							$Tdate = substr($TransactionDate, 0, 4) . '-' . substr($TransactionDate, 4, 2) . '-' . substr($TransactionDate, 6, 2);
							//die(); //2019-07-04 12:05:41
							$rt = $Tdate . ' ' . $Ttime;
							$transaction_date = date($rt);
							if ($message_complete == 'Declined') {$staus = 'declined';} //elseif($message_a=='Approved' or $message_a=='Duplicate'
							elseif ($message_complete == 'Approved') {$staus = 'confirm';} else { $staus = 'pending';}

							$type = $getEmail[0]['payment_type'];
							$recurring_type = $getEmail[0]['recurring_type'];
							$recurring_count = $getEmail[0]['recurring_count'];

							$paid = $getEmail[0]['recurring_count_paid'] + 1;
							///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value
							$remain = ($recurring_count > 0) ? $getEmail[0]['recurring_count_remain'] - 1 : 1;
							$recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
							$recurring_next1 = $getEmail[0]['recurring_next_pay_date'];

							$sub_total = $getEmail[0]['sub_total'] + $amount;
							$paytype = $getEmail[0]['recurring_pay_type'];

							$recurring_payment = $getEmail[0]['recurring_payment']; //   start, stop,  complete

							$lastRecord = $this->Admin_model->getlast_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);

							$AllPaidRequest = $this->Admin_model->getAllpaid_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
							//print_r($lastRecord->recurring_count); echo "<br/>";
							// print_r($AllPaidRequest);
							if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
								$recurring_payment = 'complete';
							} else {
								$recurring_payment = $getEmail[0]['recurring_payment'];
							}

							// if ($remain <= '0') {
							//     $recurring_payment = 'complete';
							// } else {
							//     $recurring_payment = 'start';
							// }
							$day1 = date("N");
							$today2_a = date("Y-m-d");
							$today2 = date("Y-m-d H:i:s");
							$year = date("Y");
							$month = date("m");
							$time11 = date("H");
							if ($time11 == '00') {$time1 = '01';} else { $time1 = date("H");}
							//print_r($type);  die();
							if ($type == 'straight') {
								$info = array(
									'status' => $staus,
									'late_fee' => $late_fee,
									'amount' => $amount,
									'year' => $year,
									'month' => $month,
									'time1' => $time1,
									'day1' => $day1,
									'date_c' => $today2_a,
									'payment_date' => $today2,
									'transaction_id' => $trans_a_no,
									'message' => $message_a,
									'card_type' => $card_a_type,
									'card_no' => $card_a_no,
									'sign' => $signImg,
									'address' => $address,
									'name_card' => $name_card,
									'l_name' => "",
									'ip_a' => $_SERVER['REMOTE_ADDR'],
									'order_type' => 'a',
								);
							} elseif ($type == 'recurring') {
								$info = array(
									'status' => $staus,
									'late_fee' => $late_fee,
									'amount' => $total_amount_with_late_fee,
									'year' => $year,
									'month' => $month,
									'time1' => $time1,
									'day1' => $day1,
									'date_c' => $today2_a,
									'payment_date' => $today2,
									'recurring_count_paid' => $paid,
									'recurring_count_remain' => $remain,
									'transaction_id' => $trans_a_no,
									'message' => $message_a,
									'sign' => $signImg,
									'card_type' => $card_a_type,
									'card_no' => $card_a_no,
									'name_card' => $name_card ? $name_card : $getEmail[0]['name_card'],
									'sub_total' => $amount, //
									'recurring_payment' => $recurring_payment,
									'ip_a' => $_SERVER['REMOTE_ADDR'],
									'order_type' => 'a',
								);
							}
							//print_r($id); die();
							if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
								$up = $this->Stop_recurring($getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
							}
							$n = $this->Home_model->update_payment_single($id, $info);
							//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
							//redirect('dashboard/all_subadmin');
							$this->session->set_flashdata('pmsg', '<div class="text-success text-center">  Payment  Complete </div>');
							//$this->load->view('admin/add_subadmin/'.$bct_id);
							$invId = $getEmail[0]['id'];
							$getQuery = $this->db->query("SELECT * from customer_payment_request where id='$invId' ");
							$getEmail = $getQuery->result_array();
							$data['getEmail'] = $getEmail;
							$data['resend'] = "";
							//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
							// $this->load->view('payment' , $data);
							$email = $getEmail[0]['email_id'];
							$amount = $getEmail[0]['amount'];
							$sub_total = $getEmail[0]['sub_total'];
							$tax = $getEmail[0]['tax'];
							$originalDate = $getEmail[0]['date_c'];
							$newDate = date("F d,Y", strtotime($originalDate));
							$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
							//Email Process
							$data['email'] = $getEmail[0]['email_id'];
							$data['color'] = $getEmail1[0]['color'];
							$data['amount'] = $getEmail[0]['amount'];
							$data['sub_total'] = $getEmail[0]['sub_total'];
							$data['tax'] = $getEmail[0]['tax'];
							$data['originalDate'] = $getEmail[0]['date_c'];
							$data['card_a_no'] = $card_a_no;
							$data['invoice_detail_receipt_item'] = $item;
							$data['trans_a_no'] = $trans_a_no;
							$data['card_a_type'] = $card_a_type;
							$data['message_a'] = $message_a;
							$data['late_fee_status'] = $getEmail_a[0]['late_fee_status'];
							$data['late_fee'] = $getEmail[0]['late_fee'];
							$data['msgData'] = $data;
							$msg = $this->load->view('email/new_receipt', $data, true);
							$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
							$email = $email;
							$MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];
							$nameoFCustomer = $getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id'];
							$MailSubject2 = ' Receipt to ' . $nameoFCustomer;
							if (!empty($email)) {
								$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
								$this->email->to($email);
								$this->email->subject($MailSubject);
								$this->email->message($msg);
								$this->email->send();
							}
							
							$merchant_email = $getEmail1[0]['email'];
							if (!empty($merchant_email)) {
								$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
								$this->email->to($merchant_email);
								$this->email->subject($MailSubject2);
								$this->email->message($merchnat_msg);
								$this->email->send();
							}
							$merchant_notification_email=$getEmail1[0]['notification_email'];
							if(!empty($merchant_notification_email)) {  
								$notic_emails=explode(",",$merchant_notification_email);
								$length=count($notic_emails); 
								$i=0; $arraydata=array(); 
								for( $i=0; $i < $length; $i++) {
									$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
									$this->email->to($notic_emails[$i]);
									$this->email->subject($MailSubject2);
									$this->email->message($merchnat_msg);
									$this->email->send();
									//array_push($arraydata,$notic_emails[$i]);
							    }
							}
							$url = $getEmail[0]['url'];
							$getEmail[0]['email_id'];
							$checkurl = strpos($url, 'rpayment');
							if ($checkurl !== false) {
								$purl = str_replace('rpayment', 'reciept', $url);
							} else {
								$checkurl = strpos($url, 'payment');
								if ($checkurl !== false) {
									$purl = str_replace('payment', 'reciept', $url);
								}
							}
							//$purl = str_replace('payment', 'reciept', $url);
							if (!empty($getEmail[0]['mobile_no'])) {
								$sms_reciever = $getEmail[0]['mobile_no'];
								//$sms_message = trim('Payment Receipt : ' . $purl);
								//$sms_message = trim(' Receipt from ' . $getEmail1[0]['business_dba_name'] . ' : ' . $purl);
								 $sms_message = trim('Payment Receipt : '.$purl);
								$from = '+18325324983'; //trial account twilio number
								$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
								$to = '+1' . $mob;
								$response = $this->twilio->sms($from, $to, $sms_message);
							}

							$gettoken = $this->db->query("SELECT * FROM token WHERE token='$paymentcard' ")->result_array();
							$merchant_id=$getEmail[0]['merchant_id'];  
							if (count($gettoken) > 0 && $getEmail[0]['recurring_pay_type']=='1' && $getEmail[0]['payment_type']=='recurring' ) {
								$invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $gettoken[0]['id'],'merchant_id'=>$merchant_id);
								$this->db->insert('invoice_token', $invoice_tokenData);
							} 

							$save_notificationdata = array(
								'merchant_id' => $merchant_id,
								'name' => $name ? $name : $getEmail[0]['name'],
								'mobile' => $phone,
								'email' => $email,
								'card_type' => $card_a_type,
								'card_expiry_month' => $expiry_month,
								'card_expiry_year' => $expiry_year,
								'card_no' => $card_a_no,
								'amount' => $Amount,
								'address' => $Address,
								'transaction_id' => $trans_a_no,
								'transaction_date' => $transaction_date,
								'notification_type' => 'payment',
								'invoice_no' => $invoice_no,
								'status' => 'unread',
							);
							//print_r($save_notificationdata); die();
							$this->db->insert('notification', $save_notificationdata);
							if ($getEmail[0]['payment_type'] == 'recurring') {
								echo base_url() . 'rpayment/' . $bct_id1 . '/' . $bct_id2;
							} else {
								echo base_url() . 'payment/' . $bct_id1 . '/' . $bct_id2;
							}
						} else {
							if ($paymentcard != 'newcard') {
								$id = $arrayy['Response']['ExpressResponseMessage'];
								$id=strtolower(urldecode($id)); 
								echo 'payment_error/' . $id;
							} else {
								$this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
								$id = $arrayy['Response']['ExpressResponseMessage'];
								$this->session->set_flashdata('card_message', $id);
								redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
							}
						}
					}
				} else {
					if ($paymentcard != 'newcard') {
						$id = $array['Response']['ExpressResponseMessage'];
						$id=strtolower(urldecode($id)); 
						echo 'payment_error/' . $id;
					} else {
						$this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
						$id = $arrayy['Response']['ExpressResponseMessage'];
						$this->session->set_flashdata('card_message', $id);
						redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
					}
				}
			} else {
				if ($paymentcard == 'newcard') {
					$this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
					$id = 'CNP-Credential-Not-available';
					$this->session->set_flashdata('card_message', $id);
					redirect('payment_error/' .$getEmail[0]['id']);   //  $bct_id2
				} else {
					$id = 'CNP-Credential-Not-available';
					$id=strtolower(urldecode($id)); 
					echo 'payment_error/' . $id;
				}
			}
		}


		public function payment_error() {
			$id = $this->session->flashdata('card_message');
			//$id = ucfirst(strtolower(urldecode($this->uri->segment(2))));
			$rowid = ucfirst(strtolower(urldecode($this->uri->segment(2))));
                        //echo $rowid;die();
			if (!empty($this->session->flashdata('errorCode'))) {
				$errorcode = $this->session->flashdata('errorCode');
				//$errorcode='20'; 
				switch ($errorcode) {
				case "20":
					$id = "Card issuer has declined the transaction. Return the card and instruct the cardholder to call the card issuer for more information on the status of the account.Please update Your card information.Your transaction has been declined.";
					break;
				case "21":
					$id = "Card is expired or expiration date is invalid. ";
					break;
				case "101":
					$id = "Invalid Card details.";
					break;
				default:
					$id = $id;
					break;
				}
			}
			if ($rowid) {
				$this->db->where('id',$rowid); 
				$getRowdata=$this->db->get('customer_payment_request')->row_array(); 
//echo '<pre>';print_r($getRowdata);die();
				$data['paymentdata']=$getRowdata; 
				$merchant_id=$getRowdata['merchant_id'];
				$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $merchant_id));
				$data['itemm'] = $itemm;
			} else {
				$data['itemm'] = array();
			}
			// 15px
			$this->session->set_flashdata('cmsg', '<span class="text-danger" style="font-size:15px; "> ' . $id . ' </span>');
                        $data['response_msg'] = $rowid;
			$this->load->view('payment_error_dash', $data);
			// $this->load->view('payment_error', $data);
		}

		public function payment() {
			if ($this->input->post('submit')) {
				$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
				$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
				if (!$bct_id2 && !$this->input->post('submit')) {
					echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
					die;
				}
				$branch = $this->Home_model->get_payment_details_1($bct_id1);
				if ($this->input->post('submit')) {
					$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
					$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
					$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
					$today2 = date("Y-m-d H:i:s");
					$purl = base_url() . "reciept/$bct_id1/$bct_id2";
					$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
					$getEmail = $getQuery->result_array();
					$data['getEmail'] = $getEmail;
					$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
					$getEmail1 = $getQuery1->result_array();
					$data['getEmail1'] = $getEmail1;
					$type = $getEmail[0]['payment_type'];
					$paid = $getEmail[0]['recurring_count_paid'] + 1;
					$remain = $getEmail[0]['recurring_count_remain'] - 1;
					if ($type == 'straight') {
						$info = array(
							'status' => 'confirm', 
							'payment_date' => $today2
						);
					} elseif ($type == 'recurring') {
						$info = array(
							'status' => 'confirm', 
							'payment_date' => $today2, 
							'recurring_count_paid' => $paid, 
							'recurring_count_remain' => $remain
						);
					}
					$this->Home_model->update_payment_single($id, $info);
					$this->Home_model->update_payment_graph($bct_id1, $info);
					//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
					//redirect('dashboard/all_subadmin');
					$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
					//  $this->load->view('admin/add_subadmin/'.$bct_id);
					$data['resend'] = "";
					//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
					// $this->load->view('payment' , $data);

					$email = $getEmail[0]['email_id'];
					$amount = $getEmail[0]['amount'];
					$sub_total = $getEmail[0]['sub_total'];
					$tax = $getEmail[0]['tax'];
					$originalDate = $getEmail[0]['date_c'];
					$newDate = date("F d,Y", strtotime($originalDate));
					$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
					$htmlContent = '  <!DOCTYPE html>
						<html>
							<head>
								<title>Receipt</title>
								<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
							</head>
							<body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">
								<div style="max-width: 900px;margin: 0 auto;">
								<div style="color:#fff;">
									<div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">
										<div class="" style="width:80%;margin:0 auto;">
	      									<div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 10px;">
	  											<img src="' . base_url() . 'logo/' . $getEmail1[0]['logo'] . '" style="width: 100%; height: 100%;;margin-top: 0px;     border-radius: 50%;" />
											</div>
	        								<h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center">$' . number_format($amount, 2) . '  at ' . $getEmail1[0]['business_name'] . '</h3>
	      									<hr style="margin-top: 20px;  margin-bottom: 20px; border: 0;border-top: 1px solid #eee;" />
	    									<div style="float:left;width:45%;padding:0 15px;text-align:right;">

					                      	<span>' . $getEmail[0]['invoice_no'] . '</span>
											</div>
	  									<div style="float:left;width:45%;padding:0 15px;text-align:left;">
	    									<span>' . $newDate . '</span>
											</div>
	    							</div>
								</div>
								<div style="background-color: #437ba8;overflow: hidden;">
									<h2 class="m-b-20" style="font-size:30px;margin:20px 0;text-align:center">
										<img src="https://salequick.com/email/images/payment_icon.png" style="margin-bottom:-5px;" />
										$ ' . number_format($amount, 2) . '</h2>
								</div>
							</div>
			              	<div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
			                	<div style="width:80%;margin:0 auto;overflow:hidden">
			                  		<div style="float:left;width:50%;">
			                    		<h5 style="text-align:left;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Description</h5>
			                		</div>
										<div style="float:left;width:50%;">
										<h5  style="text-align:right;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Price</h5>
									</div>
										<div style="clear:both"></div>
											<hr style="border: 0; border-top: 1px solid #d6d1d1;" />';
										foreach ($item as $rowp) {
											$item_name = str_replace(array('\\', '/'), '', $rowp['item_name']);
											$quantity = str_replace(array('\\', '/'), '', $rowp['quantity']);
											$price = str_replace(array('\\', '/'), '', $rowp['price']);
											$tax2 = str_replace(array('\\', '/'), '', $rowp['tax']);
											$tax_id = str_replace(array('\\', '/'), '', $rowp['tax_id']);
											$total_amount = str_replace(array('\\', '/'), '', $rowp['total_amount']);
											$item_name1 = json_decode($item_name);
											$quantity1 = json_decode($quantity);
											$price1 = json_decode($price);
											$tax1 = json_decode($tax2);
											$tax_id1 = json_decode($tax_id);
											$total_amount1 = json_decode($total_amount);
											$i = 0;
											foreach ($item_name1 as $rowpp) {
												if ($quantity1[$i] > 0 && $item_name1[$i] != 'Labor') {
													$htmlContent .= '<div style="float:left;width:50%;">
														<h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">' . $item_name1[$i] . '</h5>
													</div>
														<div style="float:left;width:50%;">
														<h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ ' . number_format($price1[$i], 2) . '</b></h5>
													</div>
														<div class="clearfix" style="clear:both"></div>
															<hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';
												}$i++;
											}
											$j = 0;
											$qun = 0;
											$prc = 0;
											$tax = 0;
											$total = 0;
											foreach ($item_name1 as $rowpp) {
												if ($item_name1[$j] == 'Labor' && $quantity1[$j] > 0) {
													$qun += $quantity1[$j];
													$prc += $price1[$j];
													$tax += $tax1[$j];
													$total += $total_amount1[$j];
												}
												$j++;
											}
											$k = 0;
											foreach ($item_name1 as $rowpp) {
												if ($item_name1[$k] == 'Labor') {
													$htmlContent .= '<div style="float:left;width:50%;">
														<h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">Labor</h5>
													</div>
														<div style="float:left;width:50%;">
														<h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ ' . number_format($prc, 2) . '</b></h5>
													</div>
														<div class="clearfix" style="clear:both"></div>
															<hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';
														break;
													$k++;
												}
											}
										}
										$htmlContent .= '<div style="float:left;width:50%;text-align:right;margin-left:50%;">
												<div style="display:block;margin-bottom:20px;overflow: hidden;margin-top:0px;">
	  											<span style="float:left">Tax </span>
	  											<span style="float:right">$ ' . number_format($tax, 2) . '</span>
												</div>
												<div style="clear:both"></div>
													<hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />
													<div style="display:block;margin-bottom:25px;overflow: hidden;">
	  												<span style="float:left;">Total </span>
	  												<span style="float:right;"><b> $ ' . number_format($amount, 2) . '</b></span>
												</div>
												</div>
											</div>
									</div>
									<footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
											<div style="text-align:center;width:80%;margin:0 auto">
												<h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">Feel free to contact us any time with  question and concerns.</h5>
											<p><a style="color:#4a91f9;cursor:pointer;">' . $getEmail1[0]['email'] . '</a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;">' . $getEmail1[0]['mob_no'] . '</a></p>
												<br />
											<p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>
											<p style="color: #868484;">You are receiving something because purchased something at Company name</p>
											<p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
											</div>
										</footer>
									</div>
								</body>
						</html>';
						$MailSubject = " Receipt from  " . $getEmail1[0]['business_dba_name'];
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->to($email);
						$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						$this->email->subject($MailSubject);
						$this->email->message($htmlContent);
						//$this->email->attach('files/attachment.pdf');
						$this->email->send();
						//$sms_sender = trim($this->input->post('sms_sender'));
						$sms_reciever = $getEmail[0]['mobile_no'];
						$sms_message = trim('Payment Receipt : ' . $purl);
						// $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
						$from = '+18325324983'; //trial account twilio number
						// $to = '+'.$sms_reciever; //sms recipient number
						$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
						$to = '+1' . $mob;
						$response = $this->twilio->sms($from, $to, $sms_message);
						//print_r($response); die();
						redirect(base_url() . 'payment/' . $bct_id1 . '/' . $bct_id2);
						//break;
				} else {
					foreach ($branch as $sub) {
						$data['bct_id'] = $sub->id;
						$data['email'] = $sub->email_id;
						$data['name'] = $sub->name;
						$data['mobile'] = $sub->mobile_no;
						$data['amount'] = $sub->amount;
						$data['title'] = $sub->title;
						$data['detail'] = $sub->detail;
						$data['status'] = $sub->status;
						$data['bct_id1'] = $bct_id1;
						$data['bct_id2'] = $bct_id2;
						break;
					}
				}
				$data['loc'] = "payment";
				$data['resend'] = "resend";
				$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
				$data['itemm'] = $itemm;
				$data['logo'] = "logo";

				$this->load->view('payment_dash', $data);
				// $this->load->view('payment', $data);
			} else {
				//die("ok");
				$bct_id2 = $this->uri->segment(3);
				$bct_id1 = $this->uri->segment(2);
				$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
				$getEmail = $getQuery->result_array();
				$getEmailCount = $getQuery->num_rows();
				$data['getEmailCount'] = $getEmailCount;
				if ($getEmailCount > 0) {
					if ($getEmail[0]['status'] == 'confirm' || $getEmail[0]['status'] == 'Chargeback_Confirm') {
						$Tstatus = "success";
						$Tmount = $getEmail[0]['amount'];
					} else {
						$Tstatus = "error";
						$Tmount = '';
					}
				} else {
					$Tstatus = "error";
					$Tmount = '';
				}
				$data['Tstatus'] = $Tstatus;
				$data['Tamount'] = $Tmount;
				// print_r($getEmail[0]['status']);   die();
				// print_r($getEmail); die;
				if ($getEmailCount > 0) {
					//print_r($getEmail[0]);   die();
					if ($getEmail[0]['status'] == 'pending' or $getEmail[0]['status'] == 'declined') {
						if (!$bct_id2 && !$this->input->post('submit')) {
							echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
							die;
						}
						$branch = $this->Home_model->get_payment_details_1($bct_id1);
						// print_r($branch);  die();
						if ($this->input->post('submit')) {
							$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
							$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
							$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
							$info = array('status' => 'confirm');
							$this->Home_model->update_payment_single($bct_id1, $info);
							$this->Home_model->update_payment_graph($bct_id1, $info);
							//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
							//redirect('dashboard/all_subadmin');
							$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
							// $this->session->unset_userdata('pmsg');
							// $this->load->view('admin/add_subadmin/'.$bct_id);
							$data['resend'] = "";
							//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
							// $this->load->view('payment' , $data);
							redirect('payment/' . $bct_id1 . '/' . $bct_id2);
						} else {
							foreach ($branch as $sub) {
								$data['other_charges'] = $sub->other_charges;
								$data['otherChargesName'] = $sub->otherChargesName;
								$data['sub_total'] = $sub->sub_total;
								$data['total_tax'] = $sub->tax;
								$data['bct_id'] = $sub->id;
								$data['email'] = $sub->email_id;
								$data['name'] = $sub->name;
								$data['invoice_no'] = $sub->invoice_no;
								$data['color'] = $sub->color;
								$data['due_date'] = $sub->due_date;
								$data['date_c'] = $sub->date_c;
								$data['mobile'] = $sub->mobile_no;
								$data['amount'] = $sub->amount;
								$data['attachment'] = $sub->attachment;
								$data['title'] = $sub->title;
								$data['detail'] = $sub->detail;
								$data['status'] = $sub->status;
								$data['payment_type'] = $sub->payment_type;
								$data['recurring_type'] = $sub->recurring_type;
								$data['recurring_count'] = $sub->recurring_count;
								$data['recurring_count_paid'] = $sub->recurring_count_paid;
								$data['recurring_count_remain'] = $sub->recurring_count_remain;
								$data['recurring_pay_start_date'] = $sub->recurring_pay_start_date;
								$data['recurring_next_pay_date'] = $sub->recurring_next_pay_date;
								$data['recurring_pay_type'] = $sub->recurring_pay_type;
								$data['recurring_payment'] = $sub->recurring_payment;
								$data['bct_id1'] = $bct_id1;
								$data['bct_id2'] = $bct_id2;
								break;
							}
						}
						$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $data['bct_id']));
						//print_r($item); die(); //Her  are twoitems
						$data['item'] = $item;
						$data['loc'] = "payment";
						$data['resend'] = "resend";
						$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
						$data['itemm'] = $itemm;
						$data['logo'] = "logo";
						if ($itemm) {$data['logo'] = $itemm[0]['logo'];}
                                                //echo '1<pre>';print_r($data);die;
						$this->load->view('payment_dash', $data);
						// $this->load->view('payment', $data);
					} elseif ($getEmail[0]['status'] == 'confirm' || $getEmail[0]['status'] == 'Chargeback_Confirm') {
						//die("else if");
						$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Payment  Complete   </div>');
						//$this->session->unset_userdata('pmsg');
						$data['resend'] = "";
						$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
						$data['itemm'] = $itemm;
						$data['logo'] = "logo";if ($itemm) {$data['logo'] = $itemm[0]['logo'];}
						$this->load->view('payment_dash', $data);
						// $this->load->view('payment', $data);
					}
				} else {
					//die("out of counter");
					$this->session->set_flashdata('pmsg', '<div class="alert alert-danger text-center">  Payment   Not Available </div>');
					$data['resend'] = "";
					$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
					$data['itemm'] = $itemm;
					$data['logo'] = "logo";if ($itemm) {$data['logo'] = $itemm[0]['logo'];}
					//print_r($data);   die();
					//$this->session->unset_userdata('pmsg');
                                        
					$this->load->view('payment_dash', $data);
					// $this->load->view('payment', $data);
				}
				// echo "<pre>"; print_r($data);   die();
			}
		}
		
		

		public function spayment() {
			if ($this->input->post('submit')) {
				$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
				$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
				if (!$bct_id2 && !$this->input->post('submit')) {
					echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
					die;
				}
				$branch = $this->Home_model->get_payment_details_1($bct_id1);
				if ($this->input->post('submit')) {
					$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
					$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
					$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
					$today2 = date("Y-m-d H:i:s");
					$purl = base_url() . "reciept/$bct_id1/$bct_id2";
					$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
					$getEmail = $getQuery->result_array();
					$data['getEmail'] = $getEmail;
					$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
					$getEmail1 = $getQuery1->result_array();
					$data['getEmail1'] = $getEmail1;
					$type = $getEmail[0]['payment_type'];
					$paid = $getEmail[0]['recurring_count_paid'] + 1;
					$remain = $getEmail[0]['recurring_count_remain'] - 1;
					if ($type == 'straight') {
						$info = array(
							'status' => 'confirm', 
							'payment_date' => $today2
						);
					} elseif ($type == 'recurring') {
						$info = array(
							'status' => 'confirm', 
							'payment_date' => $today2, 
							'recurring_count_paid' => $paid, 
							'recurring_count_remain' => $remain
						);
					}
					$this->Home_model->update_payment_single($id, $info);
					$this->Home_model->update_payment_graph($bct_id1, $info);
					//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
					//redirect('dashboard/all_subadmin');
					$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
					//  $this->load->view('admin/add_subadmin/'.$bct_id);
					$data['resend'] = "";
					//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
					// $this->load->view('payment' , $data);

					$email = $getEmail[0]['email_id'];
					$amount = $getEmail[0]['amount'];
					$sub_total = $getEmail[0]['sub_total'];
					$tax = $getEmail[0]['tax'];
					$originalDate = $getEmail[0]['date_c'];
					$newDate = date("F d,Y", strtotime($originalDate));
					$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
					$htmlContent = '  <!DOCTYPE html>
						<html>
							<head>
								<title>Receipt</title>
								<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
							</head>
							<body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">
								<div style="max-width: 900px;margin: 0 auto;">
								<div style="color:#fff;">
									<div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">
										<div class="" style="width:80%;margin:0 auto;">
	      									<div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 10px;">
	  											<img src="' . base_url() . 'logo/' . $getEmail1[0]['logo'] . '" style="width: 100%; height: 100%;;margin-top: 0px;     border-radius: 50%;" />
											</div>
	        								<h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center">$' . number_format($amount, 2) . '  at ' . $getEmail1[0]['business_name'] . '</h3>
	      									<hr style="margin-top: 20px;  margin-bottom: 20px; border: 0;border-top: 1px solid #eee;" />
	    									<div style="float:left;width:45%;padding:0 15px;text-align:right;">

					                      	<span>' . $getEmail[0]['invoice_no'] . '</span>
											</div>
	  									<div style="float:left;width:45%;padding:0 15px;text-align:left;">
	    									<span>' . $newDate . '</span>
											</div>
	    							</div>
								</div>
								<div style="background-color: #437ba8;overflow: hidden;">
									<h2 class="m-b-20" style="font-size:30px;margin:20px 0;text-align:center">
										<img src="https://salequick.com/email/images/payment_icon.png" style="margin-bottom:-5px;" />
										$ ' . number_format($amount, 2) . '</h2>
								</div>
							</div>
			              	<div style="padding: 40px 0 40px;overflow:hidden;background:#fff">
			                	<div style="width:80%;margin:0 auto;overflow:hidden">
			                  		<div style="float:left;width:50%;">
			                    		<h5 style="text-align:left;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Description</h5>
			                		</div>
										<div style="float:left;width:50%;">
										<h5  style="text-align:right;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Price</h5>
									</div>
										<div style="clear:both"></div>
											<hr style="border: 0; border-top: 1px solid #d6d1d1;" />';
										foreach ($item as $rowp) {
											$item_name = str_replace(array('\\', '/'), '', $rowp['item_name']);
											$quantity = str_replace(array('\\', '/'), '', $rowp['quantity']);
											$price = str_replace(array('\\', '/'), '', $rowp['price']);
											$tax2 = str_replace(array('\\', '/'), '', $rowp['tax']);
											$tax_id = str_replace(array('\\', '/'), '', $rowp['tax_id']);
											$total_amount = str_replace(array('\\', '/'), '', $rowp['total_amount']);
											$item_name1 = json_decode($item_name);
											$quantity1 = json_decode($quantity);
											$price1 = json_decode($price);
											$tax1 = json_decode($tax2);
											$tax_id1 = json_decode($tax_id);
											$total_amount1 = json_decode($total_amount);
											$i = 0;
											foreach ($item_name1 as $rowpp) {
												if ($quantity1[$i] > 0 && $item_name1[$i] != 'Labor') {
													$htmlContent .= '<div style="float:left;width:50%;">
														<h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">' . $item_name1[$i] . '</h5>
													</div>
														<div style="float:left;width:50%;">
														<h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ ' . number_format($price1[$i], 2) . '</b></h5>
													</div>
														<div class="clearfix" style="clear:both"></div>
															<hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';
												}$i++;
											}
											$j = 0;
											$qun = 0;
											$prc = 0;
											$tax = 0;
											$total = 0;
											foreach ($item_name1 as $rowpp) {
												if ($item_name1[$j] == 'Labor' && $quantity1[$j] > 0) {
													$qun += $quantity1[$j];
													$prc += $price1[$j];
													$tax += $tax1[$j];
													$total += $total_amount1[$j];
												}
												$j++;
											}
											$k = 0;
											foreach ($item_name1 as $rowpp) {
												if ($item_name1[$k] == 'Labor') {
													$htmlContent .= '<div style="float:left;width:50%;">
														<h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">Labor</h5>
													</div>
														<div style="float:left;width:50%;">
														<h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ ' . number_format($prc, 2) . '</b></h5>
													</div>
														<div class="clearfix" style="clear:both"></div>
															<hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';
														break;
													$k++;
												}
											}
										}
										$htmlContent .= '<div style="float:left;width:50%;text-align:right;margin-left:50%;">
												<div style="display:block;margin-bottom:20px;overflow: hidden;margin-top:0px;">
	  											<span style="float:left">Tax </span>
	  											<span style="float:right">$ ' . number_format($tax, 2) . '</span>
												</div>
												<div style="clear:both"></div>
													<hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />
													<div style="display:block;margin-bottom:25px;overflow: hidden;">
	  												<span style="float:left;">Total </span>
	  												<span style="float:right;"><b> $ ' . number_format($amount, 2) . '</b></span>
												</div>
												</div>
											</div>
									</div>
									<footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">
											<div style="text-align:center;width:80%;margin:0 auto">
												<h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">Feel free to contact us any time with  question and concerns.</h5>
											<p><a style="color:#4a91f9;cursor:pointer;">' . $getEmail1[0]['email'] . '</a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;">' . $getEmail1[0]['mob_no'] . '</a></p>
												<br />
											<p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>
											<p style="color: #868484;">You are receiving something because purchased something at Company name</p>
											<p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>
											</div>
										</footer>
									</div>
								</body>
						</html>';
						$MailSubject = " Receipt from  " . $getEmail1[0]['business_dba_name'];
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->to($email);
						$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
						$this->email->subject($MailSubject);
						$this->email->message($htmlContent);
						//$this->email->attach('files/attachment.pdf');
						$this->email->send();
						//$sms_sender = trim($this->input->post('sms_sender'));
						$sms_reciever = $getEmail[0]['mobile_no'];
						$sms_message = trim('Payment Receipt : ' . $purl);
						// $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
						$from = '+18325324983'; //trial account twilio number
						// $to = '+'.$sms_reciever; //sms recipient number
						$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
						$to = '+1' . $mob;
						$response = $this->twilio->sms($from, $to, $sms_message);
						//print_r($response); die();
						redirect(base_url() . 'spayment/' . $bct_id1 . '/' . $bct_id2);
						//break;
				} else {
					foreach ($branch as $sub) {
						$data['bct_id'] = $sub->id;
						$data['email'] = $sub->email_id;
						$data['name'] = $sub->name;
						$data['mobile'] = $sub->mobile_no;
						$data['amount'] = $sub->amount;
						$data['title'] = $sub->title;
						$data['detail'] = $sub->detail;
						$data['status'] = $sub->status;
						$data['bct_id1'] = $bct_id1;
						$data['bct_id2'] = $bct_id2;
						break;
					}
				}
				$data['loc'] = "payment";
				$data['resend'] = "resend";
				$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
				$data['itemm'] = $itemm;
				$data['logo'] = "logo";
				$this->load->view('spayment_dash', $data);
				// $this->load->view('spayment', $data);
			} else {
				//die("ok");
				// echo '123';die;
				$bct_id2 = $this->uri->segment(3);
				$bct_id1 = $this->uri->segment(2);
				$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
				$getEmail = $getQuery->result_array();
				$getEmailCount = $getQuery->num_rows();
				$data['getEmailCount'] = $getEmailCount;
				if ($getEmailCount > 0) {
					if ($getEmail[0]['status'] == 'confirm' || $getEmail[0]['status'] == 'Chargeback_Confirm') {
						$Tstatus = "success";
						$Tmount = $getEmail[0]['amount'];
					} else {
						$Tstatus = "error";
						$Tmount = '';
					}
				} else {
					$Tstatus = "error";
					$Tmount = '';
				}
				$data['Tstatus'] = $Tstatus;
				$data['Tamount'] = $Tmount;
				// print_r($getEmail[0]['status']);   die();
				// print_r($getEmail); die;
				if ($getEmailCount > 0) {
					//print_r($getEmail[0]);   die();
					if ($getEmail[0]['status'] == 'pending' or $getEmail[0]['status'] == 'declined') {
						if (!$bct_id2 && !$this->input->post('submit')) {
							echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";
							die;
						}
						$branch = $this->Home_model->get_payment_details_1($bct_id1);
						// print_r($branch);  die();
						if ($this->input->post('submit')) {
							$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
							$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
							$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
							$info = array('status' => 'confirm');
							$this->Home_model->update_payment_single($bct_id1, $info);
							$this->Home_model->update_payment_graph($bct_id1, $info);
							//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
							//redirect('dashboard/all_subadmin');
							$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');
							// $this->session->unset_userdata('pmsg');
							// $this->load->view('admin/add_subadmin/'.$bct_id);
							$data['resend'] = "";
							//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
							// $this->load->view('payment' , $data);
							redirect('spayment/' . $bct_id1 . '/' . $bct_id2);
						} else {
							foreach ($branch as $sub) {
								$data['other_charges'] = $sub->other_charges;
								$data['otherChargesName'] = $sub->otherChargesName;
								$data['bct_id'] = $sub->id;
								$data['email'] = $sub->email_id;
								$data['name'] = $sub->name;
								$data['invoice_no'] = $sub->invoice_no;
								$data['color'] = $sub->color;
								$data['due_date'] = $sub->due_date;
								$data['date_c'] = $sub->date_c;
								$data['mobile'] = $sub->mobile_no;
								$data['tax'] = $sub->tax;
								$data['amount'] = $sub->amount;
								$data['attachment'] = $sub->attachment;
								$data['title'] = $sub->title;
								$data['detail'] = $sub->detail;
								$data['status'] = $sub->status;
								$data['payment_type'] = $sub->payment_type;
								$data['recurring_type'] = $sub->recurring_type;
								$data['recurring_count'] = $sub->recurring_count;
								$data['recurring_count_paid'] = $sub->recurring_count_paid;
								$data['recurring_count_remain'] = $sub->recurring_count_remain;
								$data['recurring_pay_start_date'] = $sub->recurring_pay_start_date;
								$data['recurring_next_pay_date'] = $sub->recurring_next_pay_date;
								$data['recurring_pay_type'] = $sub->recurring_pay_type;
								$data['recurring_payment'] = $sub->recurring_payment;
								$data['bct_id1'] = $bct_id1;
								$data['bct_id2'] = $bct_id2;
								break;
							}
						}
						$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $data['bct_id']));
						//print_r($item); die(); //Her  are twoitems
						$data['item'] = $item;
						$data['loc'] = "payment";
						$data['resend'] = "resend";
						$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
						$data['itemm'] = $itemm;
						$data['logo'] = "logo";
						if ($itemm) {$data['logo'] = $itemm[0]['logo'];}
						// $this->load->view('spayment', $data);
						$this->load->view('spayment_dash', $data);
					} elseif ($getEmail[0]['status'] == 'confirm' || $getEmail[0]['status'] == 'Chargeback_Confirm') {
						//die("else if");
						$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Payment  Complete   </div>');
						//$this->session->unset_userdata('pmsg');
						$data['resend'] = "";
						$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
						$data['itemm'] = $itemm;
						$data['logo'] = "logo";if ($itemm) {$data['logo'] = $itemm[0]['logo'];}
						
						$this->load->view('spayment_dash', $data);
						// $this->load->view('spayment', $data);
					}
				} else {
					//die("out of counter");
					$this->session->set_flashdata('pmsg', '<div class="alert alert-danger text-center">  Payment   Not Available </div>');
					$data['resend'] = "";
					$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
					$data['itemm'] = $itemm;
					$data['logo'] = "logo";if ($itemm) {$data['logo'] = $itemm[0]['logo'];}
					//print_r($data);   die();
					//$this->session->unset_userdata('pmsg');
					$this->load->view('spayment_dash', $data);
					// $this->load->view('spayment', $data);
				}
				// echo "<pre>"; print_r($data);   die();
			}
		}
	
		public function reciept() {
			// if($this->session->userdata('user_type') != 'admin') {
			// 	redirect(base_url('admin'));
			// }
			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$bct_id2 = $this->uri->segment(3);
			$bct_id1 = $this->uri->segment(2);
			$today2 = date("Y-m-d H:i:s");
			$branch = $this->Home_model->get_payment_details_1($bct_id1);
			$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
			$getEmail = $getQuery->result_array();
			$data['getEmail'] = $getEmail;
			$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
			$getEmail1 = $getQuery1->result_array();
			$data['getEmail1'] = $getEmail1;
			$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
			$data['itemm'] = $itemm;
			$data['logo'] = "logo";
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email_id;
				$data['name'] = $sub->name;
				$data['invoice_no'] = $sub->invoice_no;
				$data['transaction_id'] = $sub->transaction_id;
				$data['message'] = $sub->message;
				$data['reference'] = $sub->reference;
				$data['card_type'] = $sub->card_type;
				$data['card_no'] = $sub->card_no;
				$data['name_card'] = $sub->name_card;
				$data['due_date'] = $sub->due_date;
				$data['mobile'] = $sub->mobile_no;
				$data['amount'] = $sub->amount;
				$data['tax'] = $sub->tax;
				$data['sign'] = $sub->sign;
				$data['color'] = $sub->color;
				$data['title'] = $sub->title;
				$data['detail'] = $sub->detail;
				$data['status'] = $sub->status;
				$data['bct_id1'] = $bct_id1;
				$data['bct_id2'] = $bct_id2;
				$data['recurring_count'] = $sub->recurring_count;
				$data['recurring_type'] = $sub->recurring_type;
				$data['date_c'] = $sub->date_c;
				break;
			}
			$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $data['bct_id']));
			$data['item'] = $item;
			// echo '<pre>';print_r($data);die;
			$this->load->view('reciept_dash', $data);
		}

		public function refund_reciept() {

			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
			$bct_id1 = $this->uri->segment(2);
			$bct_id2 = $this->uri->segment(3);
			$bct_id3 = $this->uri->segment(4);
			$today2 = date("Y-m-d H:i:s");
			$branch = $this->Home_model->get_payment_details_1($bct_id1);
			$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
			$getEmail = $getQuery->result_array();
			$data['getEmail'] = $getEmail;
			$data['refundData'] = $this->db->query("SELECT *,count(amount) FROM refund WHERE merchant_id='$bct_id2'  AND invoice_no='$bct_id3' ")->result_array();
			//print_r($data['refundData']); die("okyr");
			$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
			$getEmail1 = $getQuery1->result_array();
			$data['getEmail1'] = $getEmail1;
			$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
			$data['itemm'] = $itemm;
			$data['logo'] = "logo";
			foreach ($branch as $sub) {
				$data['bct_id'] = $sub->id;
				$data['email'] = $sub->email_id;
				$data['name'] = $sub->name;
				$data['invoice_no'] = $sub->invoice_no;
				$data['transaction_id'] = $sub->transaction_id;
				$data['message'] = $sub->message;
				$data['reference'] = $sub->reference;
				$data['card_type'] = $sub->card_type;
				$data['card_no'] = $sub->card_no;
				$data['name_card'] = $sub->name_card;
				$data['due_date'] = $sub->due_date;
				$data['mobile'] = $sub->mobile_no;
				$data['amount'] = $sub->amount;
				$data['tax'] = $sub->tax;
				$data['sign'] = $sub->sign;
				$data['color'] = $sub->color;
				$data['title'] = $sub->title;
				$data['detail'] = $sub->detail;
				$data['status'] = $sub->status;
				$data['bct_id1'] = $bct_id1;
				$data['bct_id2'] = $bct_id2;
				$data['recurring_count'] = $sub->recurring_count;
				$data['recurring_type'] = $sub->recurring_type;
				$data['date_c'] = $sub->date_c;
				break;
			}
			$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $data['bct_id']));
			$data['item'] = $item;
			$this->load->view('refund_reciept', $data);
		}

	public function pos_refund_reciept() {
		// if($this->session->userdata('user_type') != 'admin') {
		// 	redirect(base_url('admin'));
		// }
		$bct_id1 = $this->uri->segment(2);
		$bct_id2 = $this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$branch = $this->Home_model->get_payment_details_1_pos($bct_id1);
		$data['$branch'] = $branch;
		$getQuery = $this->db->query("SELECT * from pos where merchant_id ='" . $bct_id2 . "' and invoice_no  ='" . $bct_id1 . "' ");
		$getEmail = $getQuery->result_array();
		$data['getEmail'] = $getEmail;
		$data['refundData'] = $this->db->query("SELECT *,count(amount) FROM refund WHERE merchant_id='$bct_id2'  AND invoice_no='$bct_id1' ")->result_array();
		// echo $this->db->last_query();die;
		//  $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$bct_id1'");
		//     $itemslist = $getQuery1->result_array();
		// $data['item'] = $itemslist;
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$getEmail1 = $getQuery1->result_array();
		$data['getEmail1'] = $getEmail1;
		$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		$data['itemm'] = $itemm;
		$data['logo'] = "logo";
		foreach ($branch as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			// $data['detail'] = $sub->detail;
			//  $data['status'] = $sub->status;
			$data['bct_id1'] = $bct_id1;
			$data['bct_id2'] = $bct_id2;
			$data['sign'] = $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = $sub->reference;
			$data['card_no'] = $sub->card_no;
			break;
		}
		// echo "<pre>";print_r($data);die;
		$this->load->view('pos_refund_reciept_dash', $data);
	}
	public function adv_pos_refund_reciept() {
		// if($this->session->userdata('user_type') != 'admin') {
		// 	redirect(base_url('admin'));
		// }
		$bct_id2 = $this->uri->segment(3);
		$bct_id1 = $this->uri->segment(2);
		$today2 = date("Y-m-d H:i:s");
		$branch = $this->Home_model->get_payment_details_1_pos($bct_id1);
		$data['$branch'] = $branch;
		$getQuery = $this->db->query("SELECT * from pos where merchant_id ='" . $bct_id2 . "' and invoice_no  ='" . $bct_id1 . "' ");
		$getEmail = $getQuery->result_array();
		$data['getEmail'] = $getEmail;
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$getEmail1 = $getQuery1->result_array();
		$data['getEmail1'] = $getEmail1;
		$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		$data['itemm'] = $itemm;
		$data['logo'] = "logo";
		$data['refundData'] = $this->db->query("SELECT *,count(amount) FROM refund WHERE merchant_id='$bct_id2'  AND invoice_no='$bct_id1' ")->result_array();
		$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name,p.tip_amount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		$advPos = $getQuery1->result_array();
		$data['advPos'] = $advPos;
		foreach ($branch as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			// $data['detail'] = $sub->detail;
			//  $data['status'] = $sub->status;
			$data['bct_id1'] = $bct_id1;
			$data['bct_id2'] = $bct_id2;
			$data['sign'] = $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = $sub->reference;
			$data['card_no'] = $sub->card_no;
			break;
		}

		$this->load->view('pos_refund_reciept_dash', $data);
	}

	public function pos_reciept() {
		// if($this->session->userdata('user_type') != 'admin') {
		// 	redirect(base_url('admin'));
		// }
		$bct_id2 = $this->uri->segment(3);
		$bct_id1 = $this->uri->segment(2);
		$today2 = date("Y-m-d H:i:s");
		$branch = $this->Home_model->get_payment_details_1_pos($bct_id1);
		$data['branch'] = $branch;
		$getQuery = $this->db->query("SELECT * from pos where merchant_id ='" . $bct_id2 . "' and invoice_no  ='" . $bct_id1 . "' ");
		$getEmail = $getQuery->result_array();
		$data['getEmail'] = $getEmail;
		//  $getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='$bct_id1'");
		//     $itemslist = $getQuery1->result_array();
		// $data['item'] = $itemslist;
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$getEmail1 = $getQuery1->result_array();
		$data['getEmail1'] = $getEmail1;
		$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		$data['itemm'] = $itemm;
		$data['logo'] = "logo";
		foreach ($branch as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['full_amount'] = $sub->full_amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['transaction_type'] = $sub->transaction_type;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			// $data['detail'] = $sub->detail;
			//  $data['status'] = $sub->status;
			$data['bct_id1'] = $bct_id1;
			$data['bct_id2'] = $bct_id2;
			$data['sign'] = $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = $sub->reference;
			$data['card_no'] = $sub->card_no;
			break;
		}
		$this->load->view('pos_reciept_dash', $data);
	}

	public function adv_pos_reciept() {
		// if($this->session->userdata('user_type') != 'admin') {
		// 	redirect(base_url('admin'));
		// }
		$bct_id2 = $this->uri->segment(3);
		$bct_id1 = $this->uri->segment(2);
		$today2 = date("Y-m-d H:i:s");
		$branch = $this->Home_model->get_payment_details_1_pos($bct_id1);
		$data['branch'] = $branch;
		$getQuery = $this->db->query("SELECT * from pos where merchant_id ='" . $bct_id2 . "' and invoice_no  ='" . $bct_id1 . "' ");
		// echo $this->db->last_query();die;
		$getEmail = $getQuery->result_array();
		$data['getEmail'] = $getEmail;
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$getEmail1 = $getQuery1->result_array();
		$data['getEmail1'] = $getEmail1;
		$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		$data['itemm'] = $itemm;
		$data['logo'] = "logo";
		$transaction_type = $getEmail[0]['transaction_type'];
		if($transaction_type == 'split') {
			$getQuery1 = $this->db->query("SELECT c.quantity,c.price,c.discount_amount,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
		} else {
			$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,c.discount_amount,i.name,p.tip_amount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		}
		$advPos = $getQuery1->result_array();
		$data['advPos'] = $advPos;
		foreach ($branch as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = preg_replace('/[^A-Za-z0-9\-]/', '', $sub->name);
			// $data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['full_amount'] = $sub->full_amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['transaction_type'] = $sub->transaction_type;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			// $data['detail'] = $sub->detail;
			//  $data['status'] = $sub->status;
			$data['bct_id1'] = $bct_id1;
			$data['bct_id2'] = $bct_id2;
			$data['sign'] = $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = $sub->reference;
			$data['card_no'] = $sub->card_no;
			break;
		}
		// echo "<pre>";print_r($data);die;
		$this->load->view('pos_reciept_dash', $data);
	}

	public function pos_reciept_json($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
		// print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$transaction_type = $invoiceData[0]->transaction_type;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		$splited_bill = "";
		$totalAmu = 0;
		
	    
		foreach ($invoiceData as $invoice) {
		    
		    	if( $invoice->reference_numb_opay!='0' ){
					$card_no_reference = ($invoice->reference_numb_opay) ?  $invoice->reference_numb_opay : "N/A" ;
				}
				else
				{
				    	$card_no_reference = ($invoice->card_no) ? $invoice->card_no : "N/A";
				}
				
			if ($invoice->transaction_type == "split") {
				$splited_bill[] = array(
					'amount' => $invoice->amount,
					'c_type' => $invoice->c_type,
					'transaction_id' => $invoice->transaction_id,
					'split_payment_id' => $invoice->split_payment_id,
					'card_type' => $invoice->card_type,
			
				    	'card_no' => $card_no_reference,
				
					
					'date_c' => $invoice->date_c,
					'status' => ($invoice->status == 'Chargeback_Confirm') ? true : false,
					'sign' => !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "",
				);
				$totalAmu = $totalAmu + $invoice->amount;
				$sign = !empty($invoice->sign) ? "https://salequick.com/logo/" . $invoice->sign : "";
			}

		}

		foreach ($invoiceData as $sub) {
		    
		    
				
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			if($sub->transaction_type== "split"){
			$data['reference_numb_opay'] = "n/a";
			}
			else
			{
				$data['reference_numb_opay'] = ($sub->reference_numb_opay) ? $sub->reference_numb_opay: "n/a";
			}
			
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = ($totalAmu == 0) ? $sub->amount : $totalAmu;
			$data['discount'] = $sub->discount;
			$data["discounted_amount"] = $sub->total_amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			$data['tip'] = ($sub->tip_amount != 0 || $sub->tip_amount != 0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['split_sign'] = $sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no;
			$data["ip"] = $sub->ip;
			$data["c_type"] = $sub->c_type;
			$data["splitted_bill"] = $splited_bill;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name;
			$data['business_dba_name'] = $sub->business_dba_name;
			$data['business_number'] = $sub->business_number;
			$data['address'] = $sub->address1;
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}
		if ($transaction_type == "split") {
			$getQuery1 = $this->db->query("SELECT c.quantity,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id  where c.status=2 and c.transaction_id='" . $bct_id1 . "'");
		} else {
			$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");
		}

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	public function pos_reciept_json_01_02_2020($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
		// $data['invoiceData'] = $invoiceData;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['discount'] = $sub->discount;
			$data["discounted_amount"] = $sub->total_amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			$data['tip'] = ($sub->tip_amount !=0 || $sub->tip_amount !=0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no;
			$data["ip"] = $sub->ip;
			$data["c_type"]= $sub->c_type;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name;
			$data['business_dba_name'] = $sub->business_dba_name;
			$data['business_number'] = $sub->business_number;
			$data['address'] = $sub->address1;
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}

		$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	public function pos_reciept_json_v3($invoice, $id) {
		//echo $invoice;
		$bct_id1 = $invoice; //$this->uri->segment(2);
		$bct_id2 = $id; //$this->uri->segment(3);
		$today2 = date("Y-m-d H:i:s");
		$invoiceData = $this->Home_model->get_payment_details_1_pos($bct_id1);
// 		print_r($invoiceData);die;
		// $data['invoiceData'] = $invoiceData;
		$data = [];

		$merchantInfo = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");
		$merchantData = $merchantInfo->result_object();
		// $data['merchantData'] = $merchantData;
		// $itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));
		// $data['itemm'] = $itemm;
		// $data['logo'] = "logo";
		foreach ($invoiceData as $sub) {
			$data['email'] = $sub->email_id;
			$data['name'] = $sub->name;
			// $data['message'] = $sub->message;
			$data['invoice_no'] = $sub->invoice_no;
			$data['due_date'] = $sub->due_date;
			$data['mobile'] = $sub->mobile_no;
			$data['amount'] = $sub->amount;
			$data['discount'] = $sub->discount;
			$data["discounted_amount"] = $sub->total_amount;
			$data['transaction_id'] = $sub->transaction_id;
			$data['card_type'] = $sub->card_type;
			$data['tax'] = $sub->tax;
			$data['tip'] = ($sub->tip_amount !=0 || $sub->tip_amount !=0.00) ? $sub->tip_amount : "n/a";
			$data['sign'] = "https://salequick.com/logo/" . $sub->sign;
			$data['date_c'] = $sub->date_c;
			$data['reference'] = ($sub->reference) ? $sub->reference : "n/a";
			$data['card_no'] = $sub->card_no;
			$data["ip"] = $sub->ip;
			$data["c_type"]= $sub->c_type;
			break;

		}
		foreach ($merchantData as $sub) {
			$data['email'] = ($sub->email_id) ? $sub->email_id : "";
			$data['business_name'] = $sub->business_name;
			$data['business_dba_name'] = $sub->business_dba_name;
			$data['business_number'] = $sub->business_number;
			$data['address'] = $sub->address1;
			$data['logo'] = "https://salequick.com/logo/" . $sub->logo;
			break;

		}

		$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name, i.title, IFNULL(c.discount,0) as discount FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");

		$advPos = $getQuery1->result_object();

		$data['advPos'] = sizeof($advPos) ? $advPos : "";
		$jsonObj["error_msg"] = 0;
		$jsonObj["data"] = $data;

		echo json_encode($jsonObj);

	}
	public function adv_pos_reciept_copy() {
		$bct_id2 = $this->uri->segment(3);

		$bct_id1 = $this->uri->segment(2);

		$today2 = date("Y-m-d H:i:s");

		$branch = $this->Home_model->get_payment_details_1_pos($bct_id1);

		$data['$branch'] = $branch;

		$getQuery = $this->db->query("SELECT * from pos where merchant_id ='" . $bct_id2 . "' and invoice_no  ='" . $bct_id1 . "' ");

		$getEmail = $getQuery->result_array();

		$data['getEmail'] = $getEmail;

		$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");

		$getEmail1 = $getQuery1->result_array();

		$data['getEmail1'] = $getEmail1;

		$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

		$data['itemm'] = $itemm;

		$data['logo'] = "logo";

		$getQuery1 = $this->db->query("SELECT c.quantity,p.tax,c.price,i.name FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.invoice_no='" . $bct_id1 . "'");

		$advPos = $getQuery1->result_array();

		$data['advPos'] = $advPos;

		foreach ($branch as $sub) {

			$data['email'] = $sub->email_id;

			$data['name'] = $sub->name;

			// $data['message'] = $sub->message;

			$data['invoice_no'] = $sub->invoice_no;

			$data['due_date'] = $sub->due_date;

			$data['mobile'] = $sub->mobile_no;

			$data['amount'] = $sub->amount;

			$data['transaction_id'] = $sub->transaction_id;

			$data['card_type'] = $sub->card_type;

			$data['tax'] = $sub->tax;

			// $data['detail'] = $sub->detail;

			//  $data['status'] = $sub->status;

			$data['bct_id1'] = $bct_id1;

			$data['bct_id2'] = $bct_id2;

			$data['sign'] = $sub->sign;

			$data['date_c'] = $sub->date_c;

			$data['reference'] = $sub->reference;

			$data['card_no'] = $sub->card_no;

			break;

		}

		$this->load->view('pos_reciept', $data);

	}

	public function rpayment() {

		if ($this->input->post('submittt')) {

			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";

			$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

			$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

			$today2 = date("Y-m-d H:i:s");

			if (!$bct_id2 && !$this->input->post('submit')) {

				echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";

				die;

			}

			$branch = $this->Home_model->get_payment_details_1($bct_id1);

			$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");

			$getEmail = $getQuery->result_array();

			$data['getEmail'] = $getEmail;

			$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");

			$getEmail1 = $getQuery1->result_array();

			$data['getEmail1'] = $getEmail1;

			$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

			$data['itemm'] = $itemm;

			$data['logo'] = "logo";

			foreach ($branch as $sub) {

				$data['bct_id'] = $sub->id;

				$data['email'] = $sub->email_id;

				$data['name'] = $sub->name;

				$data['invoice_no'] = $sub->invoice_no;

				$data['due_date'] = $sub->due_date;

				$data['mobile'] = $sub->mobile_no;

				$data['amount'] = $sub->amount;

				$data['title'] = $sub->title;

				$data['detail'] = $sub->detail;

				$data['status'] = $sub->status;

				$data['bct_id1'] = $bct_id1;

				$data['bct_id2'] = $bct_id2;

				$data['recurring_count'] = $sub->recurring_count;

				$data['recurring_type'] = $sub->recurring_type;

				$data['date_c'] = $sub->date_c;

				break;

			}

			$this->load->view('rpayment2', $data);

		} elseif ($this->input->post('submitt')) {

			$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";

			$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

			$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

			$today2 = date("Y-m-d H:i:s");

			if (!$bct_id2 && !$this->input->post('submit')) {

				echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";

				die;

			}

			$branch = $this->Home_model->get_payment_details_1($bct_id1);

			$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");

			$getEmail = $getQuery->result_array();

			$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");

			$getEmail1 = $getQuery1->result_array();

			$data['getEmail1'] = $getEmail1;

			$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

			$data['itemm'] = $itemm;

			$data['logo'] = "logo";

			foreach ($branch as $sub) {

				$data['bct_id'] = $sub->id;

				$data['email'] = $sub->email_id;

				$data['name'] = $sub->name;

				$data['invoice_no'] = $sub->invoice_no;

				$data['due_date'] = $sub->due_date;

				$data['mobile'] = $sub->mobile_no;

				$data['amount'] = $sub->amount;

				$data['title'] = $sub->title;

				$data['detail'] = $sub->detail;

				$data['status'] = $sub->status;

				$data['bct_id1'] = $bct_id1;

				$data['bct_id2'] = $bct_id2;

				$data['recurring_count'] = $sub->recurring_count;

				$data['recurring_type'] = $sub->recurring_type;

				$data['date_c'] = $sub->date_c;

				break;

			}

			$this->load->view('rpayment1', $data);

		} elseif ($this->input->post('submit')) {

			$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

			$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

			if (!$bct_id2 && !$this->input->post('submit')) {

				echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";

				die;

			}

			$branch = $this->Home_model->get_payment_details_1($bct_id1);

			if ($this->input->post('submit')) {

				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";

				$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

				$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

				$sign = $this->input->post('sign') ? $this->input->post('sign') : "";

				$ip_a = $this->input->post('ip_a') ? $this->input->post('ip_a') : "";

				$today2 = date("Y-m-d H:i:s");

				$purl = "https://salequick.com/reciept/$bct_id1/$bct_id2";

				$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");

				$getEmail = $getQuery->result_array();

				$getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "'  ");

				$getEmail1 = $getQuery1->result_array();

				$type = $getEmail[0]['payment_type'];

				$paid = $getEmail[0]['recurring_count_paid'] + 1;

				$remain = $getEmail[0]['recurring_count_remain'] - 1;

				if ($type == 'straight') {

					$info = array(

						'status' => 'confirm',

						'payment_date' => $today2,

					);

				} elseif ($type == 'recurring') {

					$info = array(

						'status' => 'confirm',

						'payment_date' => $today2,

						'recurring_count_paid' => $paid,

						'recurring_count_remain' => $remain,

						'sign' => $sign,

						'ip_a' => $ip_a,

					);

				}

				$this->Home_model->update_payment_single($id, $info);

				// $this->Home_model->update_payment_graph($bct_id1, $info);

				//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");

				//redirect('dashboard/all_subadmin');

				$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');

				//  $this->load->view('admin/add_subadmin/'.$bct_id);

				$data['resend'] = "";

				//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);

				// $this->load->view('payment' , $data);

				$email = $getEmail[0]['email_id'];

				$amount = $getEmail[0]['amount'];

				$sub_total = $getEmail[0]['sub_total'];

				$tax = $getEmail[0]['tax'];

				$originalDate = $getEmail[0]['date_c'];

				$newDate = date("F d,Y", strtotime($originalDate));

				$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));

				$htmlContent = '   <!DOCTYPE html>

<html>

<head>



    

    <title>Receipt</title>

    

    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">

    </head>

<body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 16px !important;border: 1px solid #f7f7f7;background:#f5f5f5">

    <div style="max-width: 900px;margin: 0 auto;">

              <div style="color:#fff;">

              <div style="padding-top: 40px;  padding-bottom: 40px; background-color: #7aabd4;">

                  <div class="" style="width:80%;margin:0 auto;">

                            <div class="circle" style="width: 84px;text-align: center; height: 84px;border-radius: 50%; margin: 10px auto 20px; background: #fff;padding: 10px;">

                        <img src="https://salequick.com/logo/' . $getEmail1[0]['logo'] . '" style="width: 100%; height: 100%;margin-top: 0px;    border-radius: 50%;;" />

                      </div>

                              <h3 style="margin-top: 20px; margin-bottom: 10px;font-size: 26px;text-align:center">$' . number_format($amount, 2) . '  at ' . $getEmail1[0]['business_name'] . '</h3>

                            <hr style="margin-top: 20px;  margin-bottom: 20px; border: 0;border-top: 1px solid #eee;" />

                          <div style="float:left;width:45%;padding:0 15px;text-align:right;">

                        <span>

                            ' . $getEmail[0]['invoice_no'] . '

                        </span>

                    </div>

                        <div style="float:left;width:45%;padding:0 15px;text-align:left;">

                          <span>

                            ' . $newDate . '

                        </span>

                    </div>

                          </div>

              </div>

              <div style="background-color: #437ba8;overflow: hidden;">

                      <h2 class="m-b-20" style="font-size:30px;margin:20px 0;text-align:center">



                <img src="https://salequick.com/email/images/payment_icon.png" style="margin-bottom:-5px;" />



                     $ ' . number_format($amount, 2) . '</h2>

                  </div>

          </div>

                <div style="padding: 40px 0 40px;overflow:hidden;background:#fff">

                  <div style="width:80%;margin:0 auto;overflow:hidden">

                    <div style="float:left;width:50%;">

                      <h5 style="text-align:left;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Description</h5>

                  </div>

                <div style="float:left;width:50%;">

                      <h5  style="text-align:right;color:#868484;font-size:18px;margin-top: 10px;margin-bottom: 10px;">Price</h5>

                  </div>

                    <div style="clear:both"></div>

                <hr style="border: 0; border-top: 1px solid #d6d1d1;" />';

				foreach ($item as $rowp) {

					$item_name = str_replace(array('\\', '/'), '', $rowp['item_name']);

					$quantity = str_replace(array('\\', '/'), '', $rowp['quantity']);

					$price = str_replace(array('\\', '/'), '', $rowp['price']);

					$tax2 = str_replace(array('\\', '/'), '', $rowp['tax']);

					$tax_id = str_replace(array('\\', '/'), '', $rowp['tax_id']);

					$total_amount = str_replace(array('\\', '/'), '', $rowp['total_amount']);

					$item_name1 = json_decode($item_name);

					$quantity1 = json_decode($quantity);

					$price1 = json_decode($price);

					$tax1 = json_decode($tax2);

					$tax_id1 = json_decode($tax_id);

					$total_amount1 = json_decode($total_amount);

					$i = 0;

					foreach ($item_name1 as $rowpp) {

						if ($quantity1[$i] > 0 && $item_name1[$i] != 'Labor') {

							$htmlContent .= '<div style="float:left;width:50%;">

                      <h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">' . $item_name1[$i] . '</h5>

                  </div>

                <div style="float:left;width:50%;">

                      <h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ ' . number_format($price1[$i], 2) . '</b></h5>

                  </div>



               <div class="clearfix" style="clear:both"></div>



                   <hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';

						}$i++;}

					$j = 0;

					$qun = 0;

					$prc = 0;

					$tax = 0;

					$total = 0;

					foreach ($item_name1 as $rowpp) {

						if ($item_name1[$j] == 'Labor' && $quantity1[$j] > 0) {

							$qun += $quantity1[$j];

							$prc += $price1[$j];

							$tax += $tax1[$j];

							$total += $total_amount1[$j];

						}

						$j++;}

					$k = 0;

					foreach ($item_name1 as $rowpp) {

						if ($item_name1[$k] == 'Labor') {

							$htmlContent .= '<div style="float:left;width:50%;">

                      <h5 class="p-l-30" style="font-size:18px;font-weight:400;margin-left:30px;margin-top: 10px;margin-bottom: 10px;">Labor</h5>

                  </div>

                <div style="float:left;width:50%;">

                      <h5 style="text-align:right;font-size:18px;margin-top: 10px;margin-bottom: 10px;"><b> $ ' . number_format($prc, 2) . '</b></h5>

                  </div>



               <div class="clearfix" style="clear:both"></div>



                   <hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />';

							break;
							$k++;}
					}

				}

				$htmlContent .= '<div style="float:left;width:50%;text-align:right;margin-left:50%;">

                    <div style="display:block;margin-bottom:20px;overflow: hidden;margin-top:0px;">

                        <span style="float:left">Tax </span>

                        <span style="float:right">$ ' . number_format($tax, 2) . '</span>

                    </div>

                    <div style="clear:both"></div>

                    <hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #d6d1d1;" />

                    <div style="display:block;margin-bottom:25px;overflow: hidden;">

                        <span style="float:left;">Total </span>

                        <span style="float:right;"><b> $ ' . number_format($amount, 2) . '</b></span>

                      </div>

                </div>

                </div>

              </div>

              <footer style="width:100%;border-top: 2px solid #ccc;padding: 40px 0 20px;background: #ddd;margin-top:0px;">

                    <div style="text-align:center;width:80%;margin:0 auto">

                    <h5 style="margin-top: 10px; margin-bottom: 10px;font-size:18px;font-weight:400;">Feel free to contact us any time with  question and concerns.</h5>

                  <p><a style="color:#4a91f9;cursor:pointer;">' . $getEmail1[0]['email'] . '</a> &nbsp;&nbsp;&nbsp; <a style="color:#4a91f9;cursor:pointer;">' . $getEmail1[0]['mob_no'] . '</a></p>

                <br />

                  <p style="color: #868484;">Can you not see the email ? Click here to view in a browser</p>

                  <p style="color: #868484;">You are receiving something because purchased something at Company name</p>

                  <p style="text-align:right"><a style="color:#4a91f9;cursor:pointer;">Powered by: SaleQuick.com</a></p>

                </div>

            </footer>

        </div>

    </body>

</html>



';
				$MailSubject = " Receipt from  " . $getEmail1[0]['business_dba_name'];
				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				$this->email->to($email);

				$this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);

				$this->email->subject($MailSubject);

				$this->email->message($htmlContent);

//$this->email->attach('files/attachment.pdf');

				$this->email->send();

//$sms_sender = trim($this->input->post('sms_sender'));

				$sms_reciever = $getEmail[0]['mobile_no'];

				$sms_message = trim('Payment Receipt' . $purl);
// $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
				$from = '+18325324983'; //trial account twilio number

// $to = '+'.$sms_reciever; //sms recipient number

				$mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);

				$to = '+1' . $mob;

				$response = $this->twilio->sms($from, $to, $sms_message);

//print_r($response); die();

				redirect('rpayment/' . $bct_id1 . '/' . $bct_id2);

				//break;

			} else {

				foreach ($branch as $sub) {

					$data['bct_id'] = $sub->id;

					$data['email'] = $sub->email_id;

					$data['name'] = $sub->name;

					$data['mobile'] = $sub->mobile_no;

					$data['amount'] = $sub->amount;

					$data['title'] = $sub->title;

					$data['detail'] = $sub->detail;

					$data['status'] = $sub->status;

					$data['bct_id1'] = $bct_id1;

					$data['bct_id2'] = $bct_id2;

					$data['recurring_count'] = $sub->recurring_count;

					$data['recurring_type'] = $sub->recurring_type;

					$data['date_c'] = $sub->date_c;

					break;

				}

			}

			$data['loc'] = "payment";

			$data['resend'] = "resend";

			$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

			$data['itemm'] = $itemm;

			$data['logo'] = "logo";

			$this->load->view('rpayment', $data);

		} else {

			$bct_id2 = $this->uri->segment(3);

			$bct_id1 = $this->uri->segment(2);

			$getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");

			$getEmail = $getQuery->result_array();

			$getEmailCount = $getQuery->num_rows();

			$data['getEmailCount'] = $getEmailCount;

			if ($getEmailCount > 0) {

				if ($getEmail[0]['status'] == 'pending') {

					if (!$bct_id2 && !$this->input->post('submit')) {

						echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";

						die;

					}

					$branch = $this->Home_model->get_payment_details_1($bct_id1);

					if ($this->input->post('submit')) {

						$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";

						$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

						$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

						$info = array(

							'status' => 'confirm',

						);

						$this->Home_model->update_payment_single($bct_id1, $info);

						$this->Home_model->update_payment_graph($bct_id1, $info);

						//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");

						//redirect('dashboard/all_subadmin');

						$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');

						// $this->session->unset_userdata('pmsg');

						//  $this->load->view('admin/add_subadmin/'.$bct_id);

						$data['resend'] = "";

						//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);

						// $this->load->view('payment' , $data);

						redirect('rpayment/' . $bct_id1 . '/' . $bct_id2);

					} else {

						foreach ($branch as $sub) {

							$data['bct_id'] = $sub->id;

							$data['email'] = $sub->email_id;

							$data['name'] = $sub->name;

							$data['invoice_no'] = $sub->invoice_no;

							$data['due_date'] = $sub->due_date;

							$data['mobile'] = $sub->mobile_no;

							$data['amount'] = $sub->amount;

							$data['title'] = $sub->title;

							$data['detail'] = $sub->detail;

							$data['status'] = $sub->status;

							$data['bct_id1'] = $bct_id1;

							$data['bct_id2'] = $bct_id2;

							$data['recurring_count'] = $sub->recurring_count;

							$data['recurring_type'] = $sub->recurring_type;

							$data['date_c'] = $sub->date_c;

							break;

						}

					}

					$item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $data['bct_id']));

					$data['item'] = $item;

					$data['loc'] = "payment";

					$data['resend'] = "resend";

					$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

					$data['itemm'] = $itemm;

					$data['logo'] = "logo";

					$this->load->view('rpayment', $data);

				} elseif ($getEmail[0]['status'] == 'confirm') {

					$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Payment  Complete   </div>');

					//$this->session->unset_userdata('pmsg');

					$data['resend'] = "";

					$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

					$data['itemm'] = $itemm;

					$data['logo'] = "logo";

					$this->load->view('rpayment', $data);

				}

			} else {

				$this->session->set_flashdata('pmsg', '<div class="alert alert-danger text-center">  Payment   Not Available </div>');

				$data['resend'] = "";

				$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

				$data['itemm'] = $itemm;

				$data['logo'] = "logo";

				//$this->session->unset_userdata('pmsg');

				$this->load->view('rpayment', $data);

			}

		}

	}

	public function rec_payment() {

		if ($this->input->post('submit')) {

			$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

			$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

			if (!$bct_id2 && !$this->input->post('submit')) {

				echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";

				die;

			}

			$branch = $this->Home_model->get_payment_details_recurring($bct_id1);

			if ($this->input->post('submit')) {

				$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";

				$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

				$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

				$getQuery1 = $this->db->query("SELECT * from recurring_payment where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");

				$getEmail1 = $getQuery1->result_array();

				$pid = $getEmail1[0]['p_id'];

				$today2 = date("Y-m-d H:i:s");

				$getQuery = $this->db->query("SELECT * from customer_payment_request where id ='" . $getEmail1[0]['p_id'] . "' ");

				$getEmail = $getQuery->result_array();

				$type = $getEmail[0]['payment_type'];

				$paid = $getEmail[0]['recurring_count_paid'] + 1;

				$remain = $getEmail[0]['recurring_count_remain'] - 1;

				$info = array(

					'recurring_count_paid' => $paid,

					'recurring_count_remain' => $remain,

				);

				$info1 = array(

					'status' => 'confirm',

					'payment_date' => $today2,

				);

				$this->Home_model->update_payment_single($pid, $info);

				$this->Home_model->update_payment_single_recurring($id, $info1);

				//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");

				//redirect('dashboard/all_subadmin');

				$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');

				//  $this->load->view('admin/add_subadmin/'.$bct_id);

				$data['resend'] = "";

				//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);

				// $this->load->view('payment' , $data);

				redirect('rec_payment/' . $bct_id1 . '/' . $bct_id2);

				// break;

			} else {

				foreach ($branch as $sub) {

					$data['bct_id'] = $sub->id;

					$data['email'] = $sub->email_id;

					$data['name'] = $sub->name;

					$data['mobile'] = $sub->mobile_no;

					$data['amount'] = $sub->amount;

					$data['title'] = $sub->title;

					$data['detail'] = $sub->detail;

					$data['status'] = $sub->status;

					$data['bct_id1'] = $bct_id1;

					$data['bct_id2'] = $bct_id2;

					break;

				}

			}

			$data['loc'] = "payment";

			$data['resend'] = "resend";

			$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

			$data['itemm'] = $itemm;

			$data['logo'] = "logo";

			$this->load->view('repayment', $data);

		} else {

			$bct_id2 = $this->uri->segment(3);

			$bct_id1 = $this->uri->segment(2);

			$getQuery = $this->db->query("SELECT * from recurring_payment where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");

			$getEmail = $getQuery->result_array();

			$getEmailCount = $getQuery->num_rows();

			$data['getEmailCount'] = $getEmailCount;

			if ($getEmailCount > 0) {

				if ($getEmail[0]['status'] == 'pending') {

					if (!$bct_id2 && !$this->input->post('submit')) {

						echo "<h2>Critical error.</h1><h3>No Data specified to Pay</h3>";

						die;

					}

					$branch = $this->Home_model->get_payment_details_recurring($bct_id1);

					if ($this->input->post('submit')) {

						$id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";

						$bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";

						$bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";

						$info = array(

							'status' => 'confirm',

						);

						$this->Home_model->update_payment_single($bct_id1, $info);

						//$this->session->set_userdata("mymsg",  "Data Has Been Updated.");

						//redirect('dashboard/all_subadmin');

						$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center">  Payment  Complete </div>');

						// $this->session->unset_userdata('pmsg');

						//  $this->load->view('admin/add_subadmin/'.$bct_id);

						$data['resend'] = "";

						//$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);

						// $this->load->view('payment' , $data);

						redirect('rec_payment/' . $bct_id1 . '/' . $bct_id2);

					} else {

						foreach ($branch as $sub) {

							$data['bct_id'] = $sub->rid;

							$data['email'] = $sub->email_id;

							$data['name'] = $sub->name;

							$data['mobile'] = $sub->mobile_no;

							$data['amount'] = $sub->amount;

							$data['title'] = $sub->title;

							$data['detail'] = $sub->detail;

							$data['status'] = $sub->status;

							$data['bct_id1'] = $bct_id1;

							$data['bct_id2'] = $bct_id2;

							break;

						}

					}

					$data['loc'] = "payment";

					$data['resend'] = "resend";

					$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

					$data['itemm'] = $itemm;

					$data['logo'] = "logo";

					$this->load->view('repayment', $data);

				} elseif ($getEmail[0]['status'] == 'confirm') {

					$this->session->set_flashdata('pmsg', '<div class="alert alert-success text-center"> Payment  Complet   </div>');

					//$this->session->unset_userdata('pmsg');

					$data['resend'] = "";

					$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

					$data['itemm'] = $itemm;

					$data['logo'] = "logo";

					$this->load->view('repayment', $data);

				}

			} else {

				$this->session->set_flashdata('pmsg', '<div class="alert alert-danger text-center">  Payment   Not Available </div>');

				$data['resend'] = "";

				$itemm = $this->Admin_model->data_get_where_1("merchant", array("id" => $bct_id2));

				$data['itemm'] = $itemm;

				$data['logo'] = "logo";

				//$this->session->unset_userdata('pmsg');

				$this->load->view('repayment', $data);

			}

		}

	}

	public function my_encrypt($string, $action = 'e') {

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

	public function create_signup() {

		if (isset($_POST['submit'])) {

			$name = $this->input->post('f_name') ? $this->input->post('f_name') : "";

			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : "";

			$email = $this->input->post('email') ? $this->input->post('email') : "";

			$state = $this->input->post('state') ? $this->input->post('state') : "";

			$city = $this->input->post('city') ? $this->input->post('city') : "";

			$address1 = $this->input->post('address1') ? $this->input->post('address1') : "";

			$address2 = $this->input->post('address2') ? $this->input->post('address2') : "";

			$password1 = $this->input->post('password') ? $this->input->post('password') : "";

			$monthly_fee = '39.99';

			$chargeback = '20.00';

			$point_sale = '2.8';

			$invoice = '2.9';

			$recurring = '2.9';

			$text_email = '0.0';

			$f_swap_Invoice = '0.30';

			$f_swap_Recurring = '0.3';

			$f_swap_Text = '0.10';

			$merchant_key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1) . substr(md5(time()), 1);

			$password = $this->my_encrypt($password1, 'e');

			$this->form_validation->set_rules('f_name', 'First Name', 'required');

			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[merchant.email]');

			if ($this->form_validation->run() == false) {

				$this->load->view("signup");

				// redirect("signup");

			} else {

				$today2 = date("Y-m-d");

				$today1 = date("Ymdhis") . rand();

				$unique = "SAL" . $today1;

				$data = array(

					"name" => $this->input->post('f_name'),

					"auth_key" => $unique,

					"merchant_key" => $merchant_key,

					"state" => $state,

					"t_fee" => '10',

					"city" => $city,

					"mob_no" => $this->input->post('mobile'),

					"address1" => $address1,

					"address2" => $address2,

					"password" => $password,

					"user_type" => 'merchant',

					"email" => $this->input->post('email'),

					'date_c' => $today2,

					'f_swap_Invoice' => $f_swap_Invoice,

					'f_swap_Recurring' => $f_swap_Recurring,

					'f_swap_Text' => $f_swap_Text,

					'monthly_fee' => $monthly_fee,

					'chargeback' => $chargeback,

					'point_sale' => $point_sale,

					'invoice' => $invoice,

					'recurring' => $recurring,

					'text_email' => $text_email,

					'status' => 'pending',

				);

				$this->Home_model->insert_data("merchant", $data);

				$url = "https://salequick.com/confirm/" . $unique;

				set_time_limit(3000);

				$signup_data['name'] = $name;

				$signup_data['email'] = $email;

				$signup_data['mobile'] = $mobile;

				$signup_data['url'] = $url;

				$MailTo = $email;

				$msg = $this->load->view('email/signup', $signup_data, true);

				// $MailSubject = 'Confirm Email';

				// $header = "From: Gateway<info@salequick.com >\r\n".

				//"MIME-Version: 1.0" . "\r\n" .

				//"Content-type: text/html; charset=UTF-8" . "\r\n";

				//  $msg = " Click this Url: : ".$url.".";

				// ini_set('sendmail_from', $email);

				// mail($MailTo, $MailSubject, $msg, $header);

				$config['mailtype'] = 'html';

				$this->email->initialize($config);

				//$this->email->to($email);

				//$this->email->from('info@salequick.com','SaleQuick');

				//$this->email->subject('Confirm Email');

				//$this->email->message($htmlContent);

				//$this->email->attach('files/attachment.pdf');

				//$this->email->send();

				$MailSubject = 'Confirm Email';

				$this->email->from('info@salequick.com', 'Confirm Email');

				$this->email->to($email);

				$this->email->subject($MailSubject);

				$this->email->message($msg);

				$this->email->send();

				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Please verify your email to confirm account </div>');

				redirect("login");

			}

		} else {

			redirect("signup");

		}

	}

        public function confirm_zip_cnp() {
             //echo '<pre>';print_r($_POST);die();

             $card_id = $_POST['checked_card_id'];
             $confirm_zip = $_POST['confirm_zip'];

             $card_details = $this->db->get_where('token', ['id' => $card_id])->result();
             //echo '<pre>';print_r($card_details[0]->zipcode);die();
             echo $card_details[0]->zipcode;die();
        }

        public function update_saved_card_zipcode() {
             //echo '<pre>';print_r($_POST);die();
             $card_id = $_POST['checked_card_id'];
             $confirm_zip = $_POST['confirm_zip'];

             $data = array(
               'zipcode' => $confirm_zip
            );
            $result = $this->db->where('id', $card_id)->update('token', $data);
            echo $result;die();
        }

        public function payment_cnp_invoicing() {
            //echo '<pre>';print_r($_POST);die();
            $paymentcard = $this->input->post('card_selection_radio') ? $this->input->post('card_selection_radio') : "";
            $issavecard = $this->input->post('issavecard') ? $this->input->post('issavecard') : "0";
            if ($paymentcard == 'newcard') {
                $signImg = $this->input->post('sign') ? $this->input->post('sign') : "";
            } else {
                $signImg = $this->input->post('signImg') ? $this->input->post('signImg') : "";
                //$verify_phone_on_cp = $this->input->post('verify_phone_on_cp') ? $this->input->post('verify_phone_on_cp') : "";

            }
            // echo 'Sign Image :  <br/>'.$signImg ; die('this');
            $id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
            
            
            //echo $id;die();
            $bct_id1 = $this->input->post('bct_id1') ? $this->input->post('bct_id1') : "";
            $bct_id2 = $this->input->post('bct_id2') ? $this->input->post('bct_id2') : "";
            $transaction_id = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : "";
            $message = $this->input->post('message') ? $this->input->post('message') : "";
            $card_type = $this->input->post('card_type') ? $this->input->post('card_type') : "";
            $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
            $card_no = preg_replace('/\s+/', '', $card_no);
            //echo $card_no;die();
            $address = $this->input->post('address') ? $this->input->post('address') : "";
            $zip = $this->input->post('zip') ? $this->input->post('zip') : "";
            $today2 = date("Y-m-d H:i:s");
            $purl = base_url() . "reciept/$bct_id1/$bct_id2";
            //print_r($bct_id2.'--'.$bct_id1); die();
            $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
            $getEmail = $getQuery->result_array();
            $data['getEmail'] = $getEmail;
            $getQuery1 = $this->db->query("SELECT * from merchant where id ='" . $bct_id2 . "' ");
            $getEmail1 = $getQuery1->result_array(); //print_r($getEmail1);  die();
            $data['getEmail1'] = $getEmail1;
            $late_grace_period = $getEmail1[0]['late_grace_period'];
            $qb_online_invoice_id = $getEmail[0]['qb_online_invoice_id']; 
            
            if($getEmail[0]['payment_type'] == 'recurring') {
                $payment_date = date('Y-m-d', strtotime($getEmail[0]['recurring_pay_start_date']. ' + '.$late_grace_period.' days'));
            } else {
                $payment_date = date('Y-m-d', strtotime($getEmail[0]['due_date']. ' + '.$late_grace_period.' days'));
            }
            $late_fee = $getEmail1[0]['late_fee_status'] > 0 && date('Y-m-d') > $payment_date ? $getEmail1[0]['late_fee'] : 0 ;
            
            $merchant_id = $bct_id2;
            if (count($getEmail)) {
                $type = $getEmail[0]['payment_type'];
                $paid = $getEmail[0]['recurring_count_paid'] + 1;
                $remain = $getEmail[0]['recurring_count_remain'] - 1;
                $amount = $getEmail[0]['amount'];
                
                
                $total_amount_with_late_fee_new = number_format(($getEmail[0]['amount'] + $late_fee),2);
                
                    $b = str_replace(",","",$total_amount_with_late_fee_new);
                                $a = number_format($b,2);
                                $total_amount_with_late_fee = str_replace(",","",$a);
            
                                //print_r($total_amount_with_late_fee);

                    
                $name = $getEmail[0]['name'];
                $phone = $getEmail[0]['mobile_no'];
                $invoice_no = $getEmail[0]['invoice_no'];
                
            }
            //if ($paymentcard != 'newcard') {
            //    if (isset($verify_phone_on_cp)) {
            //        if (count($getEmail)) {
            //            if ($verify_phone_on_cp != $getEmail[0]['mobile_no']) {
            //                $id = "Mobile-Number-Not-Matched";
            //                $id=strtolower(urldecode($id)); 
            //                echo 'payment_error/' . $id;die();
            //            }
            //        } else {
            //            $id = "Something went wrong, please try again!!";
            //            $this->session->set_flashdata('error', $id);
            //            echo base_url('card_payment/');
            //        }
            //    } else {
            //        $id = "Mobile-Number-Not-Matched";
            //        $id=strtolower(urldecode($id)); 
            //        echo 'payment_error/' . $id;die();
            //    }
            //}
            //die("its mateched");
            //Data, connection, auth
            # $dataFromTheForm = $_POST['fieldName']; // request data from the form
            $soapUrl = "https://transaction.elementexpress.com/"; // asmx URL of live
            // $soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
            $getQuery_a = $this->db->query("SELECT * from merchant where id ='" . $merchant_id . "'  ");
            $getEmail_a = $getQuery_a->result_array();
            $data['$getEmail_a'] = $getEmail_a;
            if (count($getEmail_a)) {
                $merchant_email = $getEmail_a[0]['email'];
            }
            // $account_id = $getEmail_a[0]['account_id_cnp'];
            // $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
            // $account_token = $getEmail_a[0]['account_token_cnp'];
            // $application_id = $getEmail_a[0]['application_id_cnp'];
            // $terminal_id = $getEmail_a[0]['terminal_id'];

            // $account_id = '1070806';
            // $acceptor_id = '3928907';
            // $account_token = '1A928FD287607C9B1B68E4CB1F52AFF914C37FA6E291FCEF79A199F41A3DBA20858BD901';
            // $application_id = '10049';
            // $terminal_id='4374N000101';
            //print_r($getEmail_a);  die();
            if (!empty($getEmail_a[0]['account_id_cnp']) and !empty($getEmail_a[0]['acceptor_id_cnp']) and !empty($getEmail_a[0]['account_token_cnp']) and !empty($getEmail_a[0]['application_id_cnp']) and !empty($getEmail_a[0]['terminal_id'])) {
                //if($account_id && $acceptor_id && $account_token && $application_id && $terminal_id)
                $account_id = $getEmail_a[0]['account_id_cnp'];
                $acceptor_id = $getEmail_a[0]['acceptor_id_cnp'];
                $account_token = $getEmail_a[0]['account_token_cnp'];
                $application_id = $getEmail_a[0]['application_id_cnp'];
                $terminal_id = $getEmail_a[0]['terminal_id'];

                $card_no = $this->input->post('card_no') ? $this->input->post('card_no') : "";
                $card_no = preg_replace('/\s+/', '', $card_no);
                $cvv = $this->input->post('card_validation_num') ? $this->input->post('card_validation_num') : "";
                $name_card = $this->input->post('name_card') ? $this->input->post('name_card') : "";

                $mmyy = $this->input->post('exp_month') ? $this->input->post('exp_month') : "";
                //print_r($mmyy);
                $pos = strpos($mmyy, '/');
                $expiry_month = substr($mmyy, 0, $pos);
                $expiry_year = substr($mmyy, $pos + 1, 2);
                $payment_id = $this->input->post('invoice_no') ? $this->input->post('invoice_no') : "";
                // xml post structure
                $xml_post_string = "<HealthCheck xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken><AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion><ApplicationName>SaleQuick</ApplicationName></Application></HealthCheck>"; // data from the form, e.g. some ID number
                $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: https://transaction.elementexpress.com/",
                    "Content-length: " . strlen($xml_post_string),
                ); //SOAPAction: your op URL
                //print_r($xml_post_string); die("ok");
                $url = $soapUrl;
                
                // PHP cURL  for https connection with auth
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($ch);

                $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $array = json_decode($json, true);
                //print_r($array); die("ok");
                curl_close($ch);
            
                $TicketNumber = (rand(100000, 999999));
                if ($array['Response']['ExpressResponseMessage'] = 'ONLINE') {
                    if ($paymentcard == 'newcard') {
                        $xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'><Credentials><AccountID>" . $account_id . "</AccountID><AccountToken>" . $account_token . "</AccountToken>
                        <AcceptorID>" . $acceptor_id . "</AcceptorID></Credentials><Application><ApplicationID>" . $application_id . "</ApplicationID><ApplicationVersion>1.1</ApplicationVersion>
                        <ApplicationName>SaleQuick</ApplicationName></Application><Transaction><TransactionAmount>" . $total_amount_with_late_fee . "</TransactionAmount><ReferenceNumber>" . $payment_id . "</ReferenceNumber>
                        <TicketNumber>" . $TicketNumber . "</TicketNumber><MarketCode>3</MarketCode></Transaction><Terminal><TerminalID>" . $terminal_id . "</TerminalID><CardPresentCode>3</CardPresentCode><CardholderPresentCode>7</CardholderPresentCode>
                        <CardInputCode>4</CardInputCode><CVVPresenceCode>1</CVVPresenceCode><TerminalCapabilityCode>5</TerminalCapabilityCode><TerminalEnvironmentCode>6</TerminalEnvironmentCode><MotoECICode>7</MotoECICode>
                        </Terminal><Card><CardNumber>" . $card_no . "</CardNumber><ExpirationMonth>" . $expiry_month . "</ExpirationMonth><ExpirationYear>" . $expiry_year . "</ExpirationYear><CVV>" . $cvv . "</CVV></Card><Address><BillingZipcode>" . $zip . "</BillingZipcode>
                        <BillingAddress1>" . $address . "</BillingAddress1></Address></CreditCardSale>"; // data from the form, e.g. some ID number
                        $headers = array(
                            "Content-type: text/xml;charset=\"utf-8\"",
                            "Accept: text/xml",
                            "Cache-Control: no-cache",
                            "Pragma: no-cache",
                            "SOAPAction: https://transaction.elementexpress.com/",
                            "Content-length: " . strlen($xml_post_string),
                        ); //SOAPAction: your op URL
                        $url = $soapUrl;
                        //print_r($xml_post_string); die();
                        // PHP cURL  for https connection with auth
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword);
                        // username and password - declared at the top of the doc
                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        // converting
                        $response = curl_exec($ch);
                        $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                        $json = json_encode($xml);
                        $arrayy = json_decode($json, true);
                        curl_close($ch);
                        //print_r($arrayy);  die(' ExpressResponseMessage '); 
                        // $arrayy['Response']['ExpressResponseMessage'] ='Declined';  
                        // $arrayy['Response']['ExpressResponseCode']='20';

                        if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved' ){
                            $card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];
                            $trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];
                            $card_a_type = $arrayy['Response']['Card']['CardLogo'];

                            //print_r($card_a_type);  die();
                            $message_a = $arrayy['Response']['Transaction']['TransactionStatus'];
                            $message_complete = $arrayy['Response']['ExpressResponseMessage'];
                            $AVSResponseCode = $arrayy['Response']['Card']['AVSResponseCode'];
                            $CVVResponseCode = $arrayy['Response']['Card']['CVVResponseCode'];
                            //$arrayy['Response']['Transaction']['ApprovedAmount'];
                            //  print_r($CVVResponseCode);
                            //  die();
                            if ($AVSResponseCode == 'A') {
                                $address_status = 'Address match';
                                $zip_status = 'Zip does not match';
                            } elseif ($AVSResponseCode == 'G') {
                                $address_status = 'Global non-AVS participant';
                                $zip_status = 'Global non-AVS participant';
                            } elseif ($AVSResponseCode == 'N') {
                                $address_status = 'Address  not match';
                                $zip_status = 'Zip  not match';
                            } elseif ($AVSResponseCode == 'R') {
                                $address_status = 'Retry, system unavailable or timed out';
                                $zip_status = 'Retry, system unavailable or timed out';
                            } elseif ($AVSResponseCode == 'S') {
                                $address_status = 'Service not supported: Issuer does not support AVS and Visa';
                                $zip_status = 'Service not supported: Issuer does not support AVS and Visa';
                            } elseif ($AVSResponseCode == 'U') {
                                $address_status = 'Unavailable: Address information not verified for domestic transactions';
                                $zip_status = 'Unavailable: Address information not verified for domestic transactions';
                            } elseif ($AVSResponseCode == 'W') {
                                $address_status = 'Address does not match';
                                $zip_status = 'Zip matches';
                            } elseif ($AVSResponseCode == 'X') {
                                $address_status = 'Address match';
                                $zip_status = 'Zip matches';
                            } elseif ($AVSResponseCode == 'Y') {
                                $address_status = 'address match';
                                $zip_status = 'zip match';
                            } elseif ($AVSResponseCode == 'Z') {
                                $address_status = 'Address does not match';
                                $zip_status = 'zip match';
                            } elseif ($AVSResponseCode == 'E') {
                                $address_status = 'AVS service not supported';
                                $zip_status = 'AVS service not supported';
                            } elseif ($AVSResponseCode == 'D') {
                                $address_status = 'Address match (International)';
                                $zip_status = 'Zip  match (International)';
                            } elseif ($AVSResponseCode == 'M') {
                                $address_status = 'Address match (International)';
                                $zip_status = 'Zip  match (International)';
                            } elseif ($AVSResponseCode == 'P') {
                                $address_status = 'Address not verified because of incompatible formats';
                                $zip_status = 'Zip matches';
                            } elseif ($AVSResponseCode == 'N') {
                                $address_status = 'Address  not match';
                                $zip_status = 'Zip not matches';
                            }
                            if ($CVVResponseCode == 'M') {
                                $cvv_status = 'Match';
                            } elseif ($CVVResponseCode == 'P') {
                                $cvv_status = 'Not Processed';
                            } elseif ($CVVResponseCode == 'N') {
                                $cvv_status = 'No Match';
                            } elseif ($CVVResponseCode == 'S') {
                                $cvv_status = 'CVV value should be on the card, but the merchant has indicated that it is not present (Visa & Discover)';
                            } elseif ($CVVResponseCode == 'U') {
                                $cvv_status = 'Issuer not certified for CVV processing';
                            }
                            //print_r($arrayy['Response']['Card']['CVVResponseCode']);  die("tgfgg");
                            if ($arrayy['Response']['Card']['CVVResponseCode'] != 'M') {
                                $id = 'CVV-Number-Error';
                                $this->session->set_flashdata('card_message', $id);
                                redirect('payment_error/'.$getEmail[0]['id']);
                            }
                            //print_r($cvv_status);  die();
                            if ($message_complete == 'Declined') {
                                $staus = 'declined';
                            }
                            //elseif($message_a=='Approved' or $message_a=='Duplicate')
                            elseif ($message_complete == 'Approved') {
                                $staus = 'confirm';
                            } else {
                                $staus = 'pending';
                            }
                            //print_r($staus);  die();
                            $day1 = date("N");
                            $today2_a = date("Y-m-d");
                            $new_add_date= gmdate("Y-m-d H:i:s");
                            $year = date("Y");
                            $month = date("m");
                            $time11 = date("H");
                            if ($time11 == '00') {
                                $time1 = '01';
                            } else {
                                $time1 = date("H");
                            }
                            $type = $getEmail[0]['payment_type'];
                            $recurring_type = $getEmail[0]['recurring_type'];
                            $recurring_count = $getEmail[0]['recurring_count'];

                            $paid = $getEmail[0]['recurring_count_paid'] + 1;
                            $remain = ($recurring_count > 0) ? $getEmail[0]['recurring_count_remain'] - 1 : 1;
                            $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                            $recurring_next1 = $getEmail[0]['recurring_next_pay_date'];
                            $sub_total = $getEmail[0]['sub_total'] + $amount;
                            $paytype = $getEmail[0]['recurring_pay_type'];
                            $recurring_payment = $getEmail[0]['recurring_payment']; //   start, stop,  complete
                            $lastRecord = $this->Admin_model->getlast_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            $AllPaidRequest = $this->Admin_model->getAllpaid_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            //print_r($lastRecord->recurring_count); echo "<br/>";
                            // print_r($AllPaidRequest);
                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $recurring_payment = 'complete';
                            } else {
                                $recurring_payment = $getEmail[0]['recurring_payment'];
                            }
                            //echo 'recurring_payment '.$recurring_payment.' paid'.$paid.' remain'.$remain.' paytype'.$paytype.' recurring_payment'.$recurring_payment;
                            // die();
                            if ($type == 'straight') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $total_amount_with_late_fee,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a,
                                    'payment_date' => $today2,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    'sign' => $signImg,
                                    'address' => $address,
                                    'name_card' => $name_card,
                                    'l_name' => "",
                                    'address_status' => $address_status,
                                    'zip_status' => $zip_status,
                                    'cvv_status' => $cvv_status,
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'new_add_date' => $new_add_date,
                                );
                            } elseif ($type == 'recurring') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $total_amount_with_late_fee,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a, // $today2_a
                                    'payment_date' => $today2,
                                    'recurring_count_paid' => $paid,
                                    'recurring_count_remain' => $remain,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    'sub_total' => $amount,
                                    'recurring_payment' => $recurring_payment,
                                    'address' => $address,
                                    'sign' => $signImg,
                                    'name_card' => $name_card,
                                    'l_name' => "",
                                    'address_status' => $address_status,
                                    'zip_status' => $zip_status,
                                    'cvv_status' => $cvv_status,
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'new_add_date' => $new_add_date,
                                );
                            }
                            //print_r($info);  die("op");
                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $up = $this->Stop_recurring($getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            }
                            // print_r($info);
                            $m = $this->Home_model->update_payment_single($id, $info);
                            // echo $m; die();
                            //echo  $this->db->last_query();  die("my query");
                            $this->session->set_flashdata('pmsg', '<div class="text-success text-center">  Payment  Complete </div>');
                            $getQuery = $this->db->query("SELECT * from customer_payment_request where merchant_id ='" . $bct_id2 . "' and payment_id  ='" . $bct_id1 . "' ");
                            $getEmail = $getQuery->result_array();
                            $data['getEmail'] = $getEmail;
                            $data['resend'] = "";
                            $email = $getEmail[0]['email_id'];
                            $amount = $getEmail[0]['amount'];
                            $sub_total = $getEmail[0]['sub_total'];
                            $tax = $getEmail[0]['tax'];
                            $originalDate = $getEmail[0]['date_c'];
                            $newDate = date("F d,Y", strtotime($originalDate));
                            $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
                            //Email Process
                            $data['email'] = $getEmail[0]['email_id'];
                            $data['color'] = $getEmail1[0]['color'];
                            $data['amount'] = $getEmail[0]['amount'];
                            $data['sub_total'] = $getEmail[0]['sub_total'];
                            $data['tax'] = $getEmail[0]['tax'];
                            $data['originalDate'] = $getEmail[0]['date_c'];
                            $data['card_a_no'] = $card_a_no;
                            $data['invoice_detail_receipt_item'] = $item;
                            $data['trans_a_no'] = $trans_a_no;
                            $data['card_a_type'] = $card_a_type;
                            $data['message_a'] = $message_a;
                            $data['late_grace_period'] = $getEmail_a[0]['late_grace_period'];
                            $data['late_fee_status'] = $getEmail_a[0]['late_fee_status'];
                            $data['late_fee'] = $getEmail[0]['late_fee'];
                            $data['recurring_type'] = $getEmail[0]['recurring_type'];
                            $data['no_of_invoice'] = $getEmail[0]['no_of_invoice'];
                            $data['recurring_count'] = $getEmail[0]['recurring_count'] ? $getEmail[0]['recurring_count'] : '&infin;';
                            $data['msgData'] = $data;
                            //Send Mail Code
                            //$msg = $this->load->view('email/new_receipt', $data, true);
                            //$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
                            $msg = $this->load->view('email/new_receipt_dash', $data, true);
                            $merchnat_msg = $this->load->view('email/merchant_receipt_dash', $data, true);
                            
                            //Satrt QuickBook sync
                            
                            $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $bct_id2 and status='1' and inv_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                           
                            $url ="https://salequick.com/quickbook/get_invoice_detail_live_payment2";
                            $qbdata =array(
                            'id' => $qb_online_invoice_id,
                            'merchant_id' => $bct_id2
                            
                            );
                            
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            $result = curl_exec($ch);
                            curl_close($ch);
                            $result = json_decode($result,true);
                            //print_r($result);
                            curl_close($ch);
                            }
                             //End QuickBook sync
                            

                            $email = $email;
                            $name_of_customer = $getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id'];
                            $MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];
                            $MailSubject2 = ' Receipt to ' . $name_of_customer;
                            if (!empty($email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($email);
                                $this->email->subject($MailSubject);
                                $this->email->message($msg);
                                $this->email->send();
                            }
                            $merchant_email = $getEmail1[0]['email'];
                            
                            if (!empty($merchant_email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($merchant_email);
                                $this->email->subject($MailSubject2);
                                $this->email->message($merchnat_msg);
                                if($bct_id2 !='413'){
                                $this->email->send();
                                }
                            }
                            $merchant_notification_email=$getEmail1[0]['notification_email'];
                            if(!empty($merchant_notification_email)){  
                                $notic_emails=explode(",",$merchant_notification_email);
                                $length=count($notic_emails); 
                                $i=0; $arraydata=array(); 
                                for( $i=0; $i < $length; $i++) {
                                    $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                    $this->email->to($notic_emails[$i]);
                                    $this->email->subject($MailSubject2);
                                    $this->email->message($merchnat_msg);
                                    if($bct_id2 !='413'){
                                $this->email->send();
                                }
                                    //array_push($arraydata,$notic_emails[$i]);
                                }
                            }
                            //    die('its Ok');
                            if ($type != 'recurring') {
                                if (!empty($getEmail[0]['mobile_no'])) {
                                    //$sms_sender = trim($this->input->post('sms_sender'));
                                    $sms_reciever = $getEmail[0]['mobile_no'];
                                    $sms_message = trim(' Receipt from ' . $getEmail1[0]['business_dba_name'] . ' : ' . $purl);
                                     $sms_message = trim('Payment Receipt : '.$purl);
                                    $from = '+18325324983'; //trial account twilio number
                                    // $to = '+'.$sms_reciever; //sms recipient number
                                    $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                                    $to = '+1' . $mob;
                                    $response = $this->twilio->sms($from, $to, $sms_message);
                                }
                            }
                            if (($getEmail1[0]['is_token_system_permission'] == '1' && $issavecard == '1') || $paytype == '1') {
                                $soapUrl1 = "https://services.elementexpress.com/"; //  live
                                // $soapUrl1 = "https://certservices.elementexpress.com/"; //   test
                                $referenceNumber = (rand(1000, 9999));
                                $xml_post_string = "<PaymentAccountCreateWithTransID xmlns='https://services.elementexpress.com'>
                                    <Credentials>
                                    <AccountID>" . $account_id . "</AccountID>
                                    <AccountToken>" . $account_token . "</AccountToken>
                                    <AcceptorID>" . $acceptor_id . "</AcceptorID>
                                    </Credentials>
                                    <Application>
                                    <ApplicationID>" . $application_id . "</ApplicationID>
                                    <ApplicationVersion>2.2</ApplicationVersion>
                                    <ApplicationName>SaleQuick</ApplicationName>
                                    </Application>
                                    <PaymentAccount>
                                    <PaymentAccountType>0</PaymentAccountType>
                                    <PaymentAccountReferenceNumber>" . $referenceNumber . "</PaymentAccountReferenceNumber>
                                    </PaymentAccount>
                                    <Transaction>
                                    <TransactionID>" . $trans_a_no . "</TransactionID>
                                    </Transaction>
                                </PaymentAccountCreateWithTransID>"; // data from the form, e.g. some ID number
                                $headers = array(
                                    "Content-type: text/xml;charset=\"utf-8\"",
                                    "Accept: text/xml",
                                    "Method:POST",
                                ); //SOAPAction: your op URL
                                $url = $soapUrl1;
                                // PHP cURL  for https connection with auth
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
                                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                // converting
                                $response = curl_exec($ch);
                                $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                                $json = json_encode($xml);
                                $arrrayy = json_decode($json, true);
                                curl_close($ch);
                                $mob = str_replace(array('(', ')', '-', ' '), '', $phone);
                                $merchant_id=$getEmail[0]['merchant_id'];
                                $my_toke = array(
                                    'name' => $name_card,
                                    'mobile' => $mob,
                                    'email' => $email,
                                    'card_type' => $card_a_type,
                                    'card_expiry_month' => $expiry_month,
                                    'card_expiry_year' => $expiry_year,
                                    'card_no' => $card_a_no,
                                    // 'transaction_id'=>$trans_a_no,
                                    'merchant_id'=>$merchant_id,
                                    'status'=>$issavecard,
                                    'token' => $arrrayy['Response']['PaymentAccount']['PaymentAccountID'],
                                    'zipcode' => $this->input->post('zip') ? $this->input->post('zip') : ""
                                );

                                if($email!="" && $mob!="" &&  $merchant_id!="")
                                {
                                    $gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND  ( mobile='$mob' or  email='$email' )  AND merchant_id='$merchant_id' ")->result_array();

                                }
                                else if($email="" && $mob!="" &&  $merchant_id!="")
                                {
                                    $gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND mobile='$mob'  AND merchant_id='$merchant_id' ")->result_array();

                                }
                                else if($email!="" && $mob="" &&  $merchant_id!="")
                                {

                                    $gettoken = $this->db->query("SELECT * FROM token WHERE card_expiry_year='$expiry_year' AND card_expiry_month='$expiry_month' AND card_no='$card_a_no'  AND card_type='$card_a_type' AND email='$email'  AND merchant_id='$merchant_id' ")->result_array();
                                }

                                if (count($gettoken) <= 0) {
                                    $this->db->insert('token', $my_toke);
                                    $m = $this->db->insert_id();
                                    $invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $m,'merchant_id'=>$merchant_id);
                                } else {
                                    $invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $gettoken[0]['id'],'merchant_id'=>$merchant_id);
                                }
                                $this->db->insert('invoice_token', $invoice_tokenData);
                            }
                            //print_r($m); die();
                            $TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
                            $TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
                            //print_r($arrayy);  die();
                            $Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
                            $Address = $arrayy['Response']['Address']['BillingAddress1'];

                            $Ttime = substr($TransactionTime, 0, 2) . ':' . substr($TransactionTime, 2, 2) . ':' . substr($TransactionTime, 4, 2);
                            $Tdate = substr($TransactionDate, 0, 4) . '-' . substr($TransactionDate, 4, 2) . '-' . substr($TransactionDate, 6, 2);
                            //die(); //2019-07-04 12:05:41
                            $rt = $Tdate . ' ' . $Ttime;
                            $transaction_date = date($rt);
                            $save_notificationdata = array(
                                'merchant_id' => $merchant_id,
                                'name' => $name,
                                'mobile' => $phone,
                                'email' => $email,
                                'card_type' => $card_a_type,
                                'card_expiry_month' => $expiry_month,
                                'card_expiry_year' => $expiry_year,
                                'card_no' => $card_a_no,
                                'amount' => $Amount,
                                'address' => $Address,
                                'transaction_id' => $trans_a_no,
                                'transaction_date' => $transaction_date,
                                'notification_type' => 'payment',
                                'invoice_no' => $invoice_no,
                                'status' => 'unread',
                                //'zipcode' => $zip
                            );
                            //print_r($save_notificationdata); die();
                            $this->db->insert('notification', $save_notificationdata);
                            if ($getEmail[0]['payment_type'] == 'recurring') {
                                redirect(base_url() . 'rpayment/' . $bct_id1 . '/' . $bct_id2);
                            } else {
                                redirect(base_url() . 'payment/' . $bct_id1 . '/' . $bct_id2);
                            }
                            // End Token
                            //print_r($response); die();
                        } else {
                            if($arrayy['Response']['ExpressResponseMessage'] == 'Declined') {   
                                if($getEmail[0]["recurring_pay_type"] == '1'){
                                    $paytyps='Auto';
                                } else {
                                    $paytyps='Manual';
                                }
                                if($late_fee > 0) {
                                    $declined_late_fee = '<p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                        <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Late Fee:</span>
                                        <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">$ '.$late_fee.'</span>
                                        </p>';
                                } else {
                                    $declined_late_fee = '';
                                }
                                $msg='<!DOCTYPE html>
                                    <html>
                                        <head>
                                            <title>Decline Payment</title>
                                            <meta name="viewport" content="width=device-width,initial-scale=1">
                                            <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
                                        </head>
                                        <body style="padding: 0px;margin: 0;font-family: Fira Sans, sans-serif;font-size: 14px !important;background:#f4f7fc">
                                            <div style="max-width: 100%;margin: 0;padding: 0;clear: both;">
                                                <div style="padding: 25px 15px;background-color: #357fdf;border-bottom: 1px solid #3f86e1;clear:both;">
                                                    <a href="https://salequick.com/" style="max-width: 251px;text-align: center;margin: 10px auto 20px;width: 100%;display: block;">   
                                                        <img src="https://salequick.com/email/images/logo-w.png" style="width: 100%;max-width: 100%;margin-top: 10px;">
                                                    </a>
                                                    <h3 style="margin-top: 25px;margin-bottom: 10px;font-size: 21px;text-align:center;color:rgb(210, 227, 248);font-weight: normal;text-transform: uppercase;">Card Declined </h3>
                                                </div>
                                                <div style="background-color: #f4f7fc;overflow: hidden;padding: 0 15px;clear:both">
                                                    <div style="width: 100%;margin: 35px auto 11px;text-align: center;float: left;">
                                                        <div style="width: auto;font-weight: 600;color: #656565;text-align: center;display: inline-block;max-width: 623px;margin: 0 auto;background-color: rgba(53, 127, 223, 0.05);border: 1px solid rgba(53, 127, 223, 0.2);">
                                                            <p style="font-size: 21px;float: left;width: 100%;clear: both;color: #444">Card <span style="color: #d0021b;">Declined</span> </p>
                                                            <div style="float: left;width: 100%;clear: both;">
                                                            <br>
                                                        </div>
                                                        <br>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Card Number:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.('****'.substr($card_no, -4)).' </span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Invoice No:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["invoice_no"].' </span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Total Amount:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">$ '.$total_amount_with_late_fee.'</span>
                                                        </p>
                                                        '.$declined_late_fee.'
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Payment Type:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$paytyps.' </span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Name:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["name"].'</span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Email:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["email_id"].'</span>
                                                        </p>
                                                        <p style="display: inline-block;max-width: 301px;width: 100%;margin: 0 0 15px;padding: 0 7px;box-sizing: border-box;text-align: center;vertical-align: top;">
                                                            <span style="display: block;width: 101px;float: left;text-align: left;padding: 5px 4px;background-color: #d8d8d8a8;box-sizing: border-box;">Phone:</span>
                                                            <span style="display: block;width: auto;float: left;padding:5px;box-sizing: border-box;color: #666;font-weight: normal;">'.$getEmail[0]["mobile_no"].'</span>
                                                        </p>
                                                        
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="float: left;width: 100%;clear: both;">
                                                <br>
                                            </div>
                                            <div style="float: left;width:100%;text-align:center;clear: both;max-width: 100%;">
                                                <div style="max-width: 970px;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 0 auto;display: table;padding: 15px;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                                                    <div style="width:100%;padding-top: 7px;color:#666;float: left;margin: 0 0 10px;">
                                                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                                                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                                                    </div>
                                                    <div style="float: left;width:100%;text-align:center;margin: 0 0 10px;">
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon1.jpg">
                                                        </a>
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon2.jpg">
                                                        </a>
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon3.jpg">
                                                        </a>
                                                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#">
                                                            <img src="https://salequick.com/front/invoice/img/foot_icon4.jpg">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </body>
                                </html>'; 
         
                                
                                $customername=$getEmail[0]['name'] ? $getEmail[0]['name']:$getEmail[0]['email_id']; 
                                $MailSubject = ' Declined   Payment form '.$getEmail1[0]['business_dba_name'];
                                $MailSubject2 = ' Declined   Payment of '.$customername;
                                   
                                $email=$getEmail[0]['email_id'];
                                if(!empty($email)) { 
                                    $this->email->from('info@salequick.com',   $getEmail1[0]['business_dba_name']);
                                    $this->email->to($email);
                                    $this->email->subject($MailSubject);
                                    $this->email->message($msg);
                                    $this->email->send();
                                }
                                // $merchant_email=$getEmail1[0]['email'];
                                // if(!empty($merchant_email)){ 
                
                                //  $this->email->from('info@salequick.com',   $getEmail1[0]['business_dba_name']);
                                //  $this->email->to($merchant_email);
                                //  $this->email->subject($MailSubject2);
                                //  $this->email->message($msg);
                                //  $this->email->send();
                                //  }
                            }
                            $this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
                            $id = $arrayy['Response']['ExpressResponseMessage'];
                            $this->session->set_flashdata('card_message', $id);
                            redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
                                
                        }
                    } else {
                        //$soapUrl = "https://certtransaction.elementexpress.com/"; // asmx URL of WSDL
                        $xml_post_string = "<CreditCardSale xmlns='https://transaction.elementexpress.com'>

                                <Credentials>

                                <AccountID>" . $account_id . "</AccountID>

                                <AccountToken>" . $account_token . "</AccountToken>

                                <AcceptorID>" . $acceptor_id . "</AcceptorID>

                                </Credentials>

                                <Application>

                                <ApplicationID>" . $application_id . "</ApplicationID>

                                <ApplicationVersion>2.2</ApplicationVersion>

                                <ApplicationName>SaleQuick</ApplicationName>

                                </Application>

                                <Transaction>

                                <TransactionAmount>" . $amount . "</TransactionAmount>

                                <ReferenceNumber>84421174091</ReferenceNumber>

                                <TicketNumber>" . $TicketNumber . "</TicketNumber>

                                <MarketCode>3</MarketCode>

                                <PaymentType>3</PaymentType>

                                <SubmissionType>2</SubmissionType>

                                <NetworkTransactionID>000001051388332</NetworkTransactionID>

                                </Transaction>

                                <Terminal>

                                <TerminalID>" . $terminal_id . "</TerminalID>

                                <CardPresentCode>3</CardPresentCode>

                                <CardholderPresentCode>7</CardholderPresentCode>

                                <CardInputCode>4</CardInputCode>

                                <CVVPresenceCode>2</CVVPresenceCode>

                                <TerminalCapabilityCode>5</TerminalCapabilityCode>

                                <TerminalEnvironmentCode>6</TerminalEnvironmentCode>

                                <MotoECICode>7</MotoECICode>

                                </Terminal>

                                <PaymentAccount>

                                <PaymentAccountID>" . $paymentcard . "</PaymentAccountID>

                                </PaymentAccount>

                                </CreditCardSale>"; // data from the form, e.g. some ID number
                                //print_r($xml_post_string); die();
                                $headers = array(

                                    "Content-type: text/xml;charset=\"utf-8\"",

                                    "Accept: text/xml",

                                    "Method:POST",

                                ); //SOAPAction: your op URL

                                $url = $soapUrl;

                                // PHP cURL  for https connection with auth

                                $ch = curl_init();

                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

                                curl_setopt($ch, CURLOPT_URL, $url);

                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                #curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc

                                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

                                curl_setopt($ch, CURLOPT_TIMEOUT, 10);

                                curl_setopt($ch, CURLOPT_POST, true);

                                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request

                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                // converting

                                $response = curl_exec($ch);

                                $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);

                                $json = json_encode($xml);

                                $arrayy = json_decode($json, true);

                                //print_r($arrayy);   die();
                                

                                //print_r($arrayy);

                                curl_close($ch);

                        if ($arrayy['Response']['ExpressResponseMessage'] == 'Approved') {

                            $card_a_no = $arrayy['Response']['Card']['CardNumberMasked'];

                            $trans_a_no = $arrayy['Response']['Transaction']['TransactionID'];

                            $card_a_type = $arrayy['Response']['Card']['CardLogo'];

                            $message_a = $arrayy['Response']['Transaction']['TransactionStatus'];

                            $message_complete = $arrayy['Response']['ExpressResponseMessage'];

                            //print_r($arrayy); die();
                            $TransactionTime = $arrayy['Response']['ExpressTransactionTime'];
                            $TransactionDate = $arrayy['Response']['ExpressTransactionDate'];
                            $Amount = $arrayy['Response']['Transaction']['ApprovedAmount'];
                            $Address = "";
                            if (isset($arrayy['Response']['Address']['BillingAddress1'])) {
                                $Address = $arrayy['Response']['Address']['BillingAddress1'];
                            }
                            $Ttime = substr($TransactionTime, 0, 2) . ':' . substr($TransactionTime, 2, 2) . ':' . substr($TransactionTime, 4, 2);
                            $Tdate = substr($TransactionDate, 0, 4) . '-' . substr($TransactionDate, 4, 2) . '-' . substr($TransactionDate, 6, 2);
                            //die(); //2019-07-04 12:05:41
                            $rt = $Tdate . ' ' . $Ttime;
                            $transaction_date = date($rt);
                            if ($message_complete == 'Declined') {$staus = 'declined';} //elseif($message_a=='Approved' or $message_a=='Duplicate'
                            elseif ($message_complete == 'Approved') {$staus = 'confirm';} else { $staus = 'pending';}

                            $type = $getEmail[0]['payment_type'];
                            $recurring_type = $getEmail[0]['recurring_type'];
                            $recurring_count = $getEmail[0]['recurring_count'];

                            $paid = $getEmail[0]['recurring_count_paid'] + 1;
                            ///$remain=$getEmail[0]['recurring_count_remain']-1;   // before constant value
                            $remain = ($recurring_count > 0) ? $getEmail[0]['recurring_count_remain'] - 1 : 1;
                            $recurring_pay_start_date = $getEmail[0]['recurring_pay_start_date'];
                            $recurring_next1 = $getEmail[0]['recurring_next_pay_date'];

                            $sub_total = $getEmail[0]['sub_total'] + $amount;
                            $paytype = $getEmail[0]['recurring_pay_type'];

                            $recurring_payment = $getEmail[0]['recurring_payment']; //   start, stop,  complete

                            $lastRecord = $this->Admin_model->getlast_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);

                            $AllPaidRequest = $this->Admin_model->getAllpaid_request("customer_payment_request", $getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            //print_r($lastRecord->recurring_count); echo "<br/>";
                            // print_r($AllPaidRequest);
                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $recurring_payment = 'complete';
                            } else {
                                $recurring_payment = $getEmail[0]['recurring_payment'];
                            }

                            // if ($remain <= '0') {
                            //     $recurring_payment = 'complete';
                            // } else {
                            //     $recurring_payment = 'start';
                            // }
                            $day1 = date("N");
                            $today2_a = date("Y-m-d");
                            $today2 = date("Y-m-d H:i:s");
                            $new_add_date= gmdate("Y-m-d H:i:s");
                            $year = date("Y");
                            $month = date("m");
                            $time11 = date("H");
                            if ($time11 == '00') {$time1 = '01';} else { $time1 = date("H");}
                            //print_r($type);  die();
                            if ($type == 'straight') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $amount,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a,
                                    'payment_date' => $today2,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    'sign' => $signImg,
                                    'address' => $address,
                                    'name_card' => $name_card,
                                    'l_name' => "",
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'new_add_date' => $new_add_date,
                                );
                            } elseif ($type == 'recurring') {
                                $info = array(
                                    'status' => $staus,
                                    'late_fee' => $late_fee,
                                    'amount' => $total_amount_with_late_fee,
                                    'year' => $year,
                                    'month' => $month,
                                    'time1' => $time1,
                                    'day1' => $day1,
                                    'date_c' => $today2_a,
                                    'payment_date' => $today2,
                                    'recurring_count_paid' => $paid,
                                    'recurring_count_remain' => $remain,
                                    'transaction_id' => $trans_a_no,
                                    'message' => $message_a,
                                    'sign' => $signImg,
                                    'card_type' => $card_a_type,
                                    'card_no' => $card_a_no,
                                    'name_card' => $name_card ? $name_card : $getEmail[0]['name_card'],
                                    'sub_total' => $amount, //
                                    'recurring_payment' => $recurring_payment,
                                    'ip_a' => $_SERVER['REMOTE_ADDR'],
                                    'order_type' => 'a',
                                    'new_add_date' => $new_add_date,
                                );
                            }
                            //print_r($id); die();
                            if ($lastRecord->recurring_count == $AllPaidRequest + 1) {
                                $up = $this->Stop_recurring($getEmail[0]['invoice_no'], $getEmail[0]['merchant_id']);
                            }
                            $n = $this->Home_model->update_payment_single($id, $info);
                            //$this->session->set_userdata("mymsg",  "Data Has Been Updated.");
                            //redirect('dashboard/all_subadmin');
                            $this->session->set_flashdata('pmsg', '<div class="text-success text-center">  Payment  Complete </div>');
                            //$this->load->view('admin/add_subadmin/'.$bct_id);
                            $invId = $getEmail[0]['id'];
                            $getQuery = $this->db->query("SELECT * from customer_payment_request where id='$invId' ");
                            $getEmail = $getQuery->result_array();
                            $data['getEmail'] = $getEmail;
                            $data['resend'] = "";
                            //$this->load->view('payment/'.$bct_id1.'/'.$bct_id2);
                            // $this->load->view('payment' , $data);
                            $email = $getEmail[0]['email_id'];
                            $amount = $getEmail[0]['amount'];
                            $sub_total = $getEmail[0]['sub_total'];
                            $tax = $getEmail[0]['tax'];
                            $originalDate = $getEmail[0]['date_c'];
                            $newDate = date("F d,Y", strtotime($originalDate));
                            $item = $this->Admin_model->data_get_where_1("order_item", array("p_id" => $id));
                            //Email Process
                            $data['email'] = $getEmail[0]['email_id'];
                            $data['color'] = $getEmail1[0]['color'];
                            $data['amount'] = $getEmail[0]['amount'];
                            $data['sub_total'] = $getEmail[0]['sub_total'];
                            $data['tax'] = $getEmail[0]['tax'];
                            $data['originalDate'] = $getEmail[0]['date_c'];
                            $data['card_a_no'] = $card_a_no;
                            $data['invoice_detail_receipt_item'] = $item;
                            $data['trans_a_no'] = $trans_a_no;
                            $data['card_a_type'] = $card_a_type;
                            $data['message_a'] = $message_a;
                            $data['late_fee_status'] = $getEmail_a[0]['late_fee_status'];
                            $data['late_fee'] = $getEmail[0]['late_fee'];
                            $data['msgData'] = $data;
                            //$msg = $this->load->view('email/new_receipt', $data, true);
                            //$merchnat_msg = $this->load->view('email/merchant_receipt', $data, true);
                            $msg = $this->load->view('email/new_receipt_dash', $data, true);
                            $merchnat_msg = $this->load->view('email/merchant_receipt_dash', $data, true);

                            //Satrt QuickBook sync
                           $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $bct_id2 and status='1' and inv_status='1' ";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        
                            if(!empty($intuit_realm_id)){
                            $url ="https://salequick.com/quickbook/get_invoice_detail_live_payment2";
                            $qbdata =array(
                            'id' => $qb_online_invoice_id,
                            'merchant_id' => $bct_id2
                            
                            );
                            
                            $ch = curl_init();
                            curl_setopt($ch,CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch,CURLOPT_POSTFIELDS, $qbdata);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            $result = curl_exec($ch);
                            curl_close($ch);
                            $result = json_decode($result,true);
                            //print_r($result);
                            curl_close($ch);
                            }
                             //End QuickBook sync

                            $email = $email;
                            $MailSubject = ' Receipt from ' . $getEmail1[0]['business_dba_name'];
                            $nameoFCustomer = $getEmail[0]['name'] ? $getEmail[0]['name'] : $getEmail[0]['email_id'];
                            $MailSubject2 = ' Receipt to ' . $nameoFCustomer;
                            if (!empty($email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($email);
                                $this->email->subject($MailSubject);
                                $this->email->message($msg);
                                $this->email->send();
                            }
                            
                            $merchant_email = $getEmail1[0]['email'];
                            if (!empty($merchant_email)) {
                                $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                $this->email->to($merchant_email);
                                $this->email->subject($MailSubject2);
                                $this->email->message($merchnat_msg);
                                if($bct_id2 !='413'){
                                $this->email->send();
                                }
                            }
                            $merchant_notification_email=$getEmail1[0]['notification_email'];
                            if(!empty($merchant_notification_email)) {  
                                $notic_emails=explode(",",$merchant_notification_email);
                                $length=count($notic_emails); 
                                $i=0; $arraydata=array(); 
                                for( $i=0; $i < $length; $i++) {
                                    $this->email->from('info@salequick.com', $getEmail1[0]['business_dba_name']);
                                    $this->email->to($notic_emails[$i]);
                                    $this->email->subject($MailSubject2);
                                    $this->email->message($merchnat_msg);
                                   if($bct_id2 !='413'){
                                $this->email->send();
                                }
                                    //array_push($arraydata,$notic_emails[$i]);
                                }
                            }
                            $url = $getEmail[0]['url'];
                            $getEmail[0]['email_id'];
                            $checkurl = strpos($url, 'rpayment');
                            if ($checkurl !== false) {
                                $purl = str_replace('rpayment', 'reciept', $url);
                            } else {
                                $checkurl = strpos($url, 'payment');
                                if ($checkurl !== false) {
                                    $purl = str_replace('payment', 'reciept', $url);
                                }
                            }
                            //$purl = str_replace('payment', 'reciept', $url);
                            if (!empty($getEmail[0]['mobile_no'])) {
                                $sms_reciever = $getEmail[0]['mobile_no'];
                                //$sms_message = trim('Payment Receipt : ' . $purl);
                               // $sms_message = trim(' Receipt from ' . $getEmail1[0]['business_dba_name'] . ' : ' . $purl);
                                 $sms_message = trim('Payment Receipt : '.$purl);
                                $from = '+18325324983'; //trial account twilio number
                                $mob = str_replace(array('(', ')', '-', ' '), '', $sms_reciever);
                                $to = '+1' . $mob;
                                $response = $this->twilio->sms($from, $to, $sms_message);
                            }

                            $gettoken = $this->db->query("SELECT * FROM token WHERE token='$paymentcard' ")->result_array();
                            $merchant_id=$getEmail[0]['merchant_id'];  
                            if (count($gettoken) > 0 && $getEmail[0]['recurring_pay_type']=='1' && $getEmail[0]['payment_type']=='recurring' ) {
                                $invoice_tokenData = array('invoice_no' => $getEmail[0]['invoice_no'], 'token_id' => $gettoken[0]['id'],'merchant_id'=>$merchant_id);
                                $this->db->insert('invoice_token', $invoice_tokenData);
                            } 

                            $save_notificationdata = array(
                                'merchant_id' => $merchant_id,
                                'name' => $name ? $name : $getEmail[0]['name'],
                                'mobile' => $phone,
                                'email' => $email,
                                'card_type' => $card_a_type,
                                'card_expiry_month' => $expiry_month,
                                'card_expiry_year' => $expiry_year,
                                'card_no' => $card_a_no,
                                'amount' => $Amount,
                                'address' => $Address,
                                'transaction_id' => $trans_a_no,
                                'transaction_date' => $transaction_date,
                                'notification_type' => 'payment',
                                'invoice_no' => $invoice_no,
                                'status' => 'unread',
                                //'zipcode' => $zip
                            );
                            //print_r($save_notificationdata); die();
                            $this->db->insert('notification', $save_notificationdata);
                            if ($getEmail[0]['payment_type'] == 'recurring') {
                                echo base_url() . 'rpayment/' . $bct_id1 . '/' . $bct_id2;
                            } else {
                                echo base_url() . 'payment/' . $bct_id1 . '/' . $bct_id2;
                            }
                        } else {
                            if ($paymentcard != 'newcard') {
                                $id = $arrayy['Response']['ExpressResponseMessage'];
                                $id=strtolower(urldecode($id)); 
                                echo 'payment_error/' . $id;
                            } else {
                                $this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
                                $id = $arrayy['Response']['ExpressResponseMessage'];
                                $this->session->set_flashdata('card_message', $id);
                                redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
                            }
                        }
                    }
                } else {
                    if ($paymentcard != 'newcard') {
                        $id = $array['Response']['ExpressResponseMessage'];
                        $id=strtolower(urldecode($id)); 
                        echo 'payment_error/' . $id;
                    } else {
                        $this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
                        $id = $arrayy['Response']['ExpressResponseMessage'];
                        $this->session->set_flashdata('card_message', $id);
                        redirect('payment_error/'.$getEmail[0]['id']);   //  $bct_id2
                    }
                }
            } else {
                if ($paymentcard == 'newcard') {
                    $this->session->set_flashdata('errorCode', $arrayy['Response']['ExpressResponseCode']);
                    $id = 'CNP-Credential-Not-available';
                    $this->session->set_flashdata('card_message', $id);
                    redirect('payment_error/' .$getEmail[0]['id']);   //  $bct_id2
                } else {
                    $id = 'CNP-Credential-Not-available';
                    $id=strtolower(urldecode($id)); 
                    echo 'payment_error/' . $id;
                }
            }
        }


      public function stepthree_signup_new() {
			$dobYear = $this->input->post('fodoby') ? $this->input->post('fodoby') : "";
			$dobMonth = $this->input->post('fodobm') ? $this->input->post('fodobm') : "";
			$dobDate = $this->input->post('fodobd') ? $this->input->post('fodobd') : "";
			$ownerArr = $_POST['ownerArr'] ? $_POST['ownerArr'] : [];
			$DOB = $dobYear . '-' . $dobMonth . '-' . $dobDate;

			$data = array(
				'o_email' => $this->input->post('fo_email') ? $this->input->post('fo_email') : "",
				"o_phone" => $this->input->post('fo_phone') ? $this->input->post('fo_phone') : "",
				'o_dob_d' => $dobDate,
				'o_dob_m' => $dobMonth,
				'o_dob_y' => $dobYear,
				'dob' => $DOB,
				'o_address1' => htmlspecialchars($this->input->post('fohadd_1') ? $this->input->post('fohadd_1') : ""),
				'o_address2' => htmlspecialchars($this->input->post('fohadd_2') ? $this->input->post('fohadd_2') : ""),
				'o_city' => $this->input->post('fohadd_city') ? $this->input->post('fohadd_city') : "",
				'o_country' => $this->input->post('fohadd_cntry') ? $this->input->post('fohadd_cntry') : "",
				'o_state' => $this->input->post('fohadd_state') ? $this->input->post('fohadd_state') : "",
				'o_zip' => $this->input->post('fohadd_zip') ? $this->input->post('fohadd_zip') : "",
				'o_ss_number' => $this->input->post('fossn') ? $this->input->post('fossn') : "",
				'o_name' => $this->input->post('foname1') ? $this->input->post('foname1') : "",
				'name' => htmlspecialchars($this->input->post('foname1') ? $this->input->post('foname1') : ""),
				'm_name' => htmlspecialchars($this->input->post('foname2') ? $this->input->post('foname2') : ""),
				'l_name' => htmlspecialchars($this->input->post('foname3') ? $this->input->post('foname3') : "")
			);
			// echo json_encode($data);  die();
			$last_merchantId = $this->session->userdata('last_merchantId');

			if ( isset($_POST['fo_email']) && isset($_POST['fo_phone']) && isset($_POST['fodobd']) && isset($_POST['fodobm']) &&
			isset($_POST['fodoby']) && isset($_POST['fohadd_1']) && isset($_POST['fohadd_2']) && isset($_POST['fohadd_city']) &&
			isset($_POST['fohadd_cntry']) &&
			isset($_POST['fohadd_state']) && isset($_POST['fohadd_zip']) && isset($_POST['foname1']) && isset($_POST['foname2']) && isset($_POST['foname3']) &&
			isset($_POST['fossn']) ) {
				//$result=$this->Home_model->insert_data("merchant", $data);
				$this->db->where('id', $last_merchantId);
				$this->db->update('merchant', $data);

				$ownerInsertedIds = array();
				$allOwnerInsertedIds = [$last_merchantId];
				if(!empty($ownerArr)) {
					foreach ($ownerArr as $owner) {
						$dobYear_arr = $owner['fodoby_arr'] ? $owner['fodoby_arr'] : "";
						$dobMonth_arr = $owner['fodobm_arr'] ? $owner['fodobm_arr'] : "";
						$dobDate_arr = $owner['fodobd_arr'] ? $owner['fodobd_arr'] : "";
						$DOB_arr = $dobYear_arr . '-' . $dobMonth_arr . '-' . $dobDate_arr;

						if( !empty($owner['saved_id']) ) {
							//update
							$update_data_owner = array(
								'o_email_arr'		=> $owner['fo_email_arr'] ? $owner['fo_email_arr'] : "",
								"o_phone_arr"		=> $owner['fo_phone_arr'] ? $owner['fo_phone_arr'] : "",
								'o_dob_d_arr'		=> $dobDate_arr,
								'o_dob_m_arr'		=> $dobMonth_arr,
								'o_dob_y_arr'		=> $dobYear_arr,
								'dob_arr'			=> $DOB_arr,
								'o_address1_arr' 	=> htmlspecialchars($owner['fohadd_1_arr'] ? $owner['fohadd_1_arr'] : ""),
								'o_address2_arr' 	=> htmlspecialchars($owner['fohadd_2_arr'] ? $owner['fohadd_2_arr'] : ""),
								'o_city_arr'		=> $owner['fohadd_city_arr'] ? $owner['fohadd_city_arr'] : "",
								'o_country_arr'		=> $owner['fohadd_cntry_arr'] ? $owner['fohadd_cntry_arr'] : "",
								'o_state_arr'		=> $owner['fohadd_state_arr'] ? $owner['fohadd_state_arr'] : "",
								'o_zip_arr'			=> $owner['fohadd_zip_arr'] ? $owner['fohadd_zip_arr'] : "",
								'o_ss_number_arr'	=> $owner['fossn_arr'] ? $owner['fossn_arr'] : "",
								'o_name_arr'		=> $owner['foname1_arr'] ? $owner['foname1_arr'] : "",
								'name_arr'			=> htmlspecialchars($owner['foname1_arr'] ? $owner['foname1_arr'] : ""),
								'm_name_arr'		=> htmlspecialchars($owner['foname2_arr'] ? $owner['foname2_arr'] : ""),
								'l_name_arr'		=> htmlspecialchars($owner['foname3_arr'] ? $owner['foname3_arr'] : "")
							);
							$this->db->where('id', $owner['saved_id']);
							$this->db->update('business_owner', $update_data_owner);

							$insertedId = $owner['saved_id'];
					        array_push($ownerInsertedIds, $insertedId);
					        array_push($allOwnerInsertedIds, $insertedId);

						} else {
							//insert
							$insert_data_owner = array(
								'merchant_id_arr'	=> $last_merchantId,
								'o_email_arr'		=> $owner['fo_email_arr'] ? $owner['fo_email_arr'] : "",
								"o_phone_arr"		=> $owner['fo_phone_arr'] ? $owner['fo_phone_arr'] : "",
								'o_dob_d_arr'		=> $dobDate_arr,
								'o_dob_m_arr'		=> $dobMonth_arr,
								'o_dob_y_arr'		=> $dobYear_arr,
								'dob_arr'			=> $DOB_arr,
								'o_address1_arr' 	=> htmlspecialchars($owner['fohadd_1_arr'] ? $owner['fohadd_1_arr'] : ""),
								'o_address2_arr' 	=> htmlspecialchars($owner['fohadd_2_arr'] ? $owner['fohadd_2_arr'] : ""),
								'o_city_arr'		=> $owner['fohadd_city_arr'] ? $owner['fohadd_city_arr'] : "",
								'o_country_arr'		=> $owner['fohadd_cntry_arr'] ? $owner['fohadd_cntry_arr'] : "",
								'o_state_arr'		=> $owner['fohadd_state_arr'] ? $owner['fohadd_state_arr'] : "",
								'o_zip_arr'			=> $owner['fohadd_zip_arr'] ? $owner['fohadd_zip_arr'] : "",
								'o_ss_number_arr'	=> $owner['fossn_arr'] ? $owner['fossn_arr'] : "",
								'o_name_arr'		=> $owner['foname1_arr'] ? $owner['foname1_arr'] : "",
								'name_arr'			=> htmlspecialchars($owner['foname1_arr'] ? $owner['foname1_arr'] : ""),
								'm_name_arr'		=> htmlspecialchars($owner['foname2_arr'] ? $owner['foname2_arr'] : ""),
								'l_name_arr'		=> htmlspecialchars($owner['foname3_arr'] ? $owner['foname3_arr'] : "")
							);
					        $this->db->insert('business_owner', $insert_data_owner);
					        $insertedId = $this->db->insert_id();
					        array_push($ownerInsertedIds, $insertedId);
					        array_push($allOwnerInsertedIds, $insertedId);
						}
					}
				}
				$data['ownerInsertedIds'] = $ownerInsertedIds;
				$data['allOwnerInsertedIds'] = $allOwnerInsertedIds;

				// echo $this->db->last_query();  die();
				$this->session->set_userdata('last_merchantId', $last_merchantId);
				$this->session->set_userdata('step', 'three');
				echo json_encode($data);
			}
		}

		public function delete_business_owner() {
			$owner_id = $this->input->post('del_owner_id') ? $this->input->post('del_owner_id') : "";

			$this->db->where('id', $owner_id);
			$this->db->delete('business_owner');
			echo $owner_id;
		}


}
