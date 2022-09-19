<?php 
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
class Merchant_agreement extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('twilio');
		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	}

	public function index() {
		// echo $this->uri->segment(4);die;
		$merchant_id = $this->uri->segment(3);
		$mail_verify_key = $this->uri->segment(4);
		$merchant = $this->db->where('id', $merchant_id)->get('merchant')->row();
		// echo $merchant->email;die;

		$data['email'] = $merchant->email;
		$data['business_dba_name'] = $merchant->business_dba_name;
		$data['merchant_id'] = $merchant_id;
		$data['mail_verify_key'] = $mail_verify_key;
		$data['getData'] = $this->db->where('merchant_id', $merchant_id)->get('agreement_verification')->row();
		// echo '<pre>';print_r($data);die;

		$this->load->view('merchant_agreement', $data);
	}

	public function createInfiniceptMerchant() {
		$id = $_POST['merchant_id'];

		$this->db->where('id', $id);
		$getdata=$this->db->get('merchant')->row();

		// echo $getdata->o_ss_number.','.str_replace("-","",$getdata->o_ss_number);die;

		// echo $getdata->country;die;

		// $getOwner = $this->db->where('merchant_id_arr', $id)->get('business_owner')->result_array();
		// // echo $this->db->last_query();die;
		// // echo '<pre>';print_r($getOwner);die;

		// if(isset($getOwner[0]) && !empty($getOwner[0]['name_arr'])) {
		// 	$owner2_title =  $getOwner[0]['name_arr'];
		// 	$owner2_f_name = $getOwner[0]['name_arr'];
		// 	$owner2_m_name = $getOwner[0]['m_name_arr'];
		// 	$owner2_l_name = $getOwner[0]['l_name_arr'];
		// 	$owner2_perc = $getOwner[0]['o_perc_arr'];
		// 	$owner2_ssn = $getOwner[0]['o_ss_number_arr'];
		// 	$owner2_dob_d = $getOwner[0]['o_dob_d_arr'];
		// 	$owner2_dob_m = $getOwner[0]['o_dob_m_arr'];
		// 	$owner2_dob_y = $getOwner[0]['o_dob_y_arr'];
		// 	$owner2_country = $getOwner[0]['o_country_arr'];
		// 	$owner2_add = $getOwner[0]['o_address1_arr'];
		// 	$owner2_city = $getOwner[0]['o_city_arr'];
		// 	$owner2_state = $getOwner[0]['o_state_arr'];
		// 	$owner2_zip = $getOwner[0]['o_zip_arr'];
		// 	$owner2_phone = $getOwner[0]['o_phone_arr'];
		// 	$owner2_email = $getOwner[0]['o_email_arr'];
		// 	$owner2_checkbox = $getOwner[0]['is_primary_o_arr'];
		// 	$owner2_question = ($getOwner[0]['o_perc_arr'] > 25) ? 'True' : 'False';
		// } else {
		// 	$owner2_title =  '';
		// 	$owner2_f_name = '';
		// 	$owner2_m_name = '';
		// 	$owner2_l_name = '';
		// 	$owner2_perc = '';
		// 	$owner2_ssn = '';
		// 	$owner2_dob_d = '';
		// 	$owner2_dob_m = '';
		// 	$owner2_dob_y = '';
		// 	$owner2_country = '';
		// 	$owner2_add = '';
		// 	$owner2_city = '';
		// 	$owner2_state = '';
		// 	$owner2_zip = '';
		// 	$owner2_phone = '';
		// 	$owner2_email = '';
		// 	$owner2_checkbox = '';
		// 	$owner2_question = '';
		// }

		// if(isset($getOwner[1]) && !empty($getOwner[1]['name_arr'])) {
		// 	$owner3_title =  $getOwner[1]['name_arr'];
		// 	$owner3_f_name = $getOwner[1]['name_arr'];
		// 	$owner3_m_name = $getOwner[1]['m_name_arr'];
		// 	$owner3_l_name = $getOwner[1]['l_name_arr'];
		// 	$owner3_perc = $getOwner[1]['o_perc_arr'];
		// 	$owner3_ssn = $getOwner[1]['o_ss_number_arr'];
		// 	$owner3_dob_d = $getOwner[1]['o_dob_d_arr'];
		// 	$owner3_dob_m = $getOwner[1]['o_dob_m_arr'];
		// 	$owner3_dob_y = $getOwner[1]['o_dob_y_arr'];
		// 	$owner3_country = $getOwner[1]['o_country_arr'];
		// 	$owner3_add = $getOwner[1]['o_address1_arr'];
		// 	$owner3_city = $getOwner[1]['o_city_arr'];
		// 	$owner3_state = $getOwner[1]['o_state_arr'];
		// 	$owner3_zip = $getOwner[1]['o_zip_arr'];
		// 	$owner3_phone = $getOwner[1]['o_phone_arr'];
		// 	$owner3_email = $getOwner[1]['o_email_arr'];
		// 	$owner3_checkbox = $getOwner[1]['is_primary_o_arr'];
		// 	$owner3_question = ($getOwner[1]['o_perc_arr'] > 25) ? 'True' : 'False';
		// } else {
		// 	$owner3_title =  '';
		// 	$owner3_f_name = '';
		// 	$owner3_m_name = '';
		// 	$owner3_l_name = '';
		// 	$owner3_perc = '';
		// 	$owner3_ssn = '';
		// 	$owner3_dob_d = '';
		// 	$owner3_dob_m = '';
		// 	$owner3_dob_y = '';
		// 	$owner3_country = '';
		// 	$owner3_add = '';
		// 	$owner3_city = '';
		// 	$owner3_state = '';
		// 	$owner3_zip = '';
		// 	$owner3_phone = '';
		// 	$owner3_email = '';
		// 	$owner3_checkbox = '';
		// 	$owner3_question = '';
		// }

		// if(isset($getOwner[2]) && !empty($getOwner[2]['name_arr'])) {
		// 	$owner4_title =  $getOwner[2]['name_arr'];
		// 	$owner4_f_name = $getOwner[2]['name_arr'];
		// 	$owner4_m_name = $getOwner[2]['m_name_arr'];
		// 	$owner4_l_name = $getOwner[2]['l_name_arr'];
		// 	$owner4_perc = $getOwner[2]['o_perc_arr'];
		// 	$owner4_ssn = $getOwner[2]['o_ss_number_arr'];
		// 	$owner4_dob_d = $getOwner[2]['o_dob_d_arr'];
		// 	$owner4_dob_m = $getOwner[2]['o_dob_m_arr'];
		// 	$owner4_dob_y = $getOwner[2]['o_dob_y_arr'];
		// 	$owner4_country = $getOwner[2]['o_country_arr'];
		// 	$owner4_add = $getOwner[2]['o_address1_arr'];
		// 	$owner4_city = $getOwner[2]['o_city_arr'];
		// 	$owner4_state = $getOwner[2]['o_state_arr'];
		// 	$owner4_zip = $getOwner[2]['o_zip_arr'];
		// 	$owner4_phone = $getOwner[2]['o_phone_arr'];
		// 	$owner4_email = $getOwner[2]['o_email_arr'];
		// 	$owner4_checkbox = $getOwner[2]['is_primary_o_arr'];
		// 	$owner4_question = ($getOwner[2]['o_perc_arr'] > 25) ? 'True' : 'False';
		// } else {
		// 	$owner4_title =  '';
		// 	$owner4_f_name = '';
		// 	$owner4_m_name = '';
		// 	$owner4_l_name = '';
		// 	$owner4_perc = '';
		// 	$owner4_ssn = '';
		// 	$owner4_dob_d = '';
		// 	$owner4_dob_m = '';
		// 	$owner4_dob_y = '';
		// 	$owner4_country = '';
		// 	$owner4_add = '';
		// 	$owner4_city = '';
		// 	$owner4_state = '';
		// 	$owner4_zip = '';
		// 	$owner4_phone = '';
		// 	$owner4_email = '';
		// 	$owner4_checkbox = '';
		// 	$owner4_question = '';
		// }

		$inputRawData=array (
			'AuthenticationKeyId' => 'be63ed6a-69eb-437c-b026-c4a4c4b81ee7',
			'AuthenticationKeyValue' => '4qaG6ZW2YR*bXnIFZE4sCIf8ta-PvAEi6rbHysTCQ^z!MGRC!oldl._vg9TCTl_V',
			
			"merchant_EmailAddress" => $getdata->email,
			"Merchant_IPAddress"=> $_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR'] :'',
			"Merchant_IPDateTime"=> date("l j F Y  g:ia", time() - date("Z")) ? date("l j F Y  g:ia", time() - date("Z")) :'',
			"Merchant_BrowserUserAgentString"=> $_SERVER['HTTP_USER_AGENT']?$_SERVER['HTTP_USER_AGENT']:'',
			"TermsVersion" => "2021-06-15T16:51:03.9591065Z",
	        "TermsSignerName" => "TermsTestSigner",
			"ExternalApplicationId"=> $getdata->business_name ? $getdata->business_name :'',
			"DoApplicationSubmissionUnderwriting" => true,
			'CustomFieldAnswers' => 
			array (
			  	array (
					'Id' => 47208,
					'UserDefinedId' => 'legal.name',
					'Value' => 
					array (
					  	'#' => $getdata->business_name,
					),
			  	),
			  	array (
					'Id' => 47209,
					'UserDefinedId' => 'legal.dba',
					'Value' => 
					array (
					  	'#' => $getdata->business_dba_name,
					),
			  	),
			  	array (
					'Id' => 47212,
					'UserDefinedId' => 'legal.taxid',
					'Value' => 
					array (
					  	'#' => str_replace("-","",$getdata->taxid),
					  	// '#' => '123456789',
					),
			  	),
			  	array (
					'Id' => 47210,
					'UserDefinedId' => 'legal.address',
					'Value' => 
					array (
					  	'Country' => ($getdata->country == 'USA') ? 'US' : $getdata->country,
					  	'Street1' => $getdata->address1,
					  	'Street2' => $getdata->address2,
					  	'City' => $getdata->city,
					  	'State' => $getdata->state,
					  	'Zip' => $getdata->zip,
					),
			  	),
			  	array (
					'Id' => 47286,
					'UserDefinedId' => 'legal.mailingaddressquestion',
					'Value' => 
					array (
					  	'#' => 'True',
					),
			  	),
			  	array (
					'Id' => 47287,
					'UserDefinedId' => 'legal.mailingaddress',
					'Value' => 
					array (
					  	'Country' => ($getdata->country == 'USA') ? 'US' : $getdata->country,
					  	'Street1' => $getdata->address1,
					  	'Street2' => $getdata->address2,
					  	'City' => $getdata->city,
					  	'State' => $getdata->state,
					  	'Zip' => $getdata->zip,
					),
			  	),
			  	array (
					'Id' => 47211,
					'UserDefinedId' => 'legal.ownershiptype',
					'Value' => 
					array (
					  	'#' => $getdata->ownershiptype,
					),
			  	),
			  	array (
					'Id' => 47273,
					'UserDefinedId' => 'legal.mcc',
					'Value' => 
					array (
					  '#' => 'legal mcc',
					),
			  	),
			  	array (
					'Id' => 47213,
					'UserDefinedId' => 'legal.phone',
					'Value' => 
					array (
					  	'#' => $getdata->business_number,
					),
			  	),
			  	array (
					'Id' => 47214,
					'UserDefinedId' => 'legal.email',
					'Value' => 
					array (
					  	'#' => $getdata->business_email,
					),
			  	),
			  	array (
					'Id' => 47516,
					'UserDefinedId' => 'products.sold',
					'Value' => 
					array (
					  	'#' => $getdata->business_type,
					),
			  	),
			  	array (
					'Id' => 47517,
					'UserDefinedId' => 'legal.dateofincorporation',
					'Value' => 
					array (
					  	'Month' => $getdata->month_business,
					  	'Day' => $getdata->day_business,
					  	'Year' =>  $getdata->year_business,
					),
			  	),
			  	array (
					'Id' => 47518,
					'UserDefinedId' => 'billing.address',
					'Value' => 
					array (
					  	'Country' => ($getdata->country == 'USA') ? 'US' : $getdata->country,
					  	'Street1' => $getdata->address1,
					  	'Street2' => $getdata->address2,
					  	'City' => $getdata->city,
					  	'State' => $getdata->state,
					  	'Zip' => $getdata->zip,
					),
			  	),
			  	array (
					'Id' => 47519,
					'UserDefinedId' => 'seasonal.business.question',
					'Value' => 
					array (
					  	'#' => 'NA',
					),
			  	),
			  	array (
					'Id' => 47520,
					'UserDefinedId' => 'monthsof.operation',
					'Value' => 
					array (
					  	'#' => 'False',
					),
			  	),
			  	array (
					'Id' => 47699,
					'UserDefinedId' => 'legal.limitedacceptance',
					'Value' => 
					array (
					  	'#' => 'False',
					),
			  	),
			  	array (
					'Id' => 47700,
					'UserDefinedId' => 'legal.acceptedcards',
					'Value' => 
					array (
					  	'#' => 'False',
					),
			  	),
			  	array (
					'Id' => 47266,
					'UserDefinedId' => 'owner.question',
					'Value' => 
					array (
					  	// '#' => $getdata->o_question,
					  	'#' => False,
					),
			  	),

			  	// owner
			  	array (
					'Id' => 47278,
					'UserDefinedId' => 'owner1.title',
					'Value' => 
					array (
					  '#' => $getdata->o_name,
					),
			  	),
			  	array (
					'Id' => 47220,
					'UserDefinedId' => 'owner1.name',
					'Value' => 
					array (
					  	'FirstName' => $getdata->name,
					  	'MiddleName' => $getdata->m_name,
					  	'LastName' => $getdata->l_name,
					),
			  	),
			  	array (
					'Id' => 47274,
					'UserDefinedId' => 'owner1.perc',
					'Value' => 
					array (
					  	'#' =>$getdata->o_percentage,
					),
			  	),
			  	array (
					'Id' => 47224,
					'UserDefinedId' => 'owner1.ssn',
					'Value' => 
					array (
					  	'#' => str_replace("-","",$getdata->o_ss_number),
					),
			  	),
			  	array (
					'Id' => 47221,
					'UserDefinedId' => 'owner1.dob',
					'Value' => 
					array (
					  	'Month' => $getdata->o_dob_m,
					  	'Day' => $getdata->o_dob_d,
					  	'Year' => $getdata->o_dob_y,
					),
			  	),
			  	array (
					'Id' => 47222,
					'UserDefinedId' => 'owner1.address',
					'Value' => 
					array (
					  	// 'Country' => $getdata->o_country,
					  	'Country' => ($getdata->o_country == 'USA') ? 'US' : $getdata->o_country,
					  	'Street1' => $getdata->o_address1,
					  	'Street2' => $getdata->o_address2,
					  	'City' => $getdata->o_city,
					  	'State' => $getdata->o_state,
					  	'Zip' => $getdata->o_zip,
					),
			  	),
			  	array (
					'Id' => 47223,
					'UserDefinedId' => 'owner1.phone',
					'Value' => 
					array (
					  	'#' =>$getdata->o_phone,
					),
			  	),
			  	array (
					'Id' => 47261,
					'UserDefinedId' => 'owner1.email',
					'Value' => 
					array (
					  '#' => $getdata->o_email,
					),
			  	),
			  	array (
					'Id' => 47269,
					'UserDefinedId' => 'owner1.checkbox',
					'Value' => 
					array (
					  '#' => 'False',
					),
			  	),
			  	array (
					'Id' => 47225,
					'UserDefinedId' => 'owner1.question',
					'Value' => 
					array (
					  // '#' => $getdata->o_question,
					  '#' => False,
					),
			  	),
			  // 	array (
					// 'Id' => 47279,
					// 'UserDefinedId' => 'owner2.title',
					// 'Value' => 
					// array (
					//   '#' => $owner2_title,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47226,
					// 'UserDefinedId' => 'owner2.name',
					// 'Value' => 
					// array (
					//   	'FirstName' => $owner2_f_name,
					//   	'MiddleName' => $owner2_m_name,
					//   	'LastName' => $owner2_l_name,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47275,
					// 'UserDefinedId' => 'owner2.perc',
					// 'Value' => 
					// array (
					//   	'#' => $owner2_perc,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47228,
					// 'UserDefinedId' => 'owner2.ssn',
					// 'Value' => 
					// array (
					//   	'#' => str_replace("-","",$owner2_ssn),
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47227,
					// 'UserDefinedId' => 'owner2.dob',
					// 'Value' => 
					// array (
					//   	'Month' => $owner2_dob_m,
					//   	'Day' => $owner2_dob_d,
					//   	'Year' => $owner2_dob_y,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47229,
					// 'UserDefinedId' => 'owner2.address',
					// 'Value' => 
					// array (
					//   	'Country' => $owner2_country,
					//   	'Street1' => $owner2_add,
					//   	'Street2' => '',
					//   	'City' => $owner2_city,
					//   	'State' => $owner2_state,
					//   	'Zip' => $owner2_zip,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47262,
					// 'UserDefinedId' => 'owner2.phone',
					// 'Value' => 
					// array (
					//   '#' => $owner2_phone,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47263,
					// 'UserDefinedId' => 'owner2.email',
					// 'Value' => 
					// array (
					//   '#' => $owner2_email,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47270,
					// 'UserDefinedId' => 'owner2.checkbox',
					// 'Value' => 
					// array (
					//   '#' => $owner2_checkbox,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47230,
					// 'UserDefinedId' => 'owner2.question',
					// 'Value' => 
					// array (
					//   '#' => $owner2_question,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47280,
					// 'UserDefinedId' => 'owner3.title',
					// 'Value' => 
					// array (
					//   '#' => $owner3_title,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47231,
					// 'UserDefinedId' => 'owner3.name',
					// 'Value' => 
					// array (
					//   	'FirstName' => $owner3_f_name,
					//   	'MiddleName' => $owner3_m_name,
					//   	'LastName' => $owner3_l_name,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47276,
					// 'UserDefinedId' => 'owner3.perc',
					// 'Value' => 
					// array (
					//   	'#' =>$owner3_perc,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47234,
					// 'UserDefinedId' => 'owner3.ssn',
					// 'Value' => 
					// array (
					//   	'#' => str_replace("-","",$owner3_ssn),
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47233,
					// 'UserDefinedId' => 'owner3.dob',
					// 'Value' => 
					// array (
					//   	'Month' => $owner3_dob_m,
					//   	'Day' => $owner3_dob_d,
					//   	'Year' => $owner3_dob_y,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47232,
					// 'UserDefinedId' => 'owner3.address',
					// 'Value' => 
					// array (
					//   	'Country' => $owner3_country,
					//   	'Street1' => $owner3_add,
					//   	'Street2' => '',
					//   	'City' => $owner3_city,
					//   	'State' => $owner3_state,
					//   	'Zip' => $owner3_zip,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47267,
					// 'UserDefinedId' => 'owner3.phone',
					// 'Value' => 
					// array (
					//   '#' => $owner3_phone,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47268,
					// 'UserDefinedId' => 'owner3.email',
					// 'Value' => 
					// array (
					//   '#' => $owner3_email,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47271,
					// 'UserDefinedId' => 'owner3.checkbox',
					// 'Value' => 
					// array (
					//   '#' => $owner3_email,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47235,
					// 'UserDefinedId' => 'owner3.question',
					// 'Value' => 
					// array (
					//   '#' => $owner3_email,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47281,
					// 'UserDefinedId' => 'owner4.title',
					// 'Value' => 
					// array (
					//   '#' => $owner4_title,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47236,
					// 'UserDefinedId' => 'owner4.name',
					// 'Value' => 
					// array (
					//   	'FirstName' => $owner4_f_name,
					//   	'MiddleName' => $owner4_m_name,
					//   	'LastName' => $owner4_l_name,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47277,
					// 'UserDefinedId' => 'owner4.perc',
					// 'Value' => 
					// array (
					//   	'#' =>$owner4_perc,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47239,
					// 'UserDefinedId' => 'owner4.ssn',
					// 'Value' => 
					// array (
					//   	'#' => $owner4_ssn,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47238,
					// 'UserDefinedId' => 'owner4.dob',
					// 'Value' => 
					// array (
					//   	'Month' => $owner4_dob_m,
					//   	'Day' => $owner4_dob_d,
					//   	'Year' => $owner4_dob_y,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47237,
					// 'UserDefinedId' => 'owner4.address',
					// 'Value' => 
					// array (
					//   	'Country' => $owner4_country,
					//   	'Street1' => $owner4_add,
					//   	'Street2' => '',
					//   	'City' => $owner4_city,
					//   	'State' => $owner4_state,
					//   	'Zip' => $owner4_zip,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47264,
					// 'UserDefinedId' => 'owner4.phone',
					// 'Value' => 
					// array (
					//   '#' => $owner4_phone,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47265,
					// 'UserDefinedId' => 'owner4.email',
					// 'Value' => 
					// array (
					//   '#' => $owner4_email,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47272,
					// 'UserDefinedId' => 'owner4.checkbox',
					// 'Value' => 
					// array (
					//   '#' => $owner4_checkbox,
					// ),
			  // 	),
			  // 	array (
					// 'Id' => 47240,
					// 'UserDefinedId' => 'owner4.question',
					// 'Value' => 
					// array (
					//   '#' => $owner4_question,
					// ),
			  // 	),
			  	array (
					'Id' => 47240,
					'UserDefinedId' => 'cprong.question',
					'Value' => 
					array (
					  '#' => True,
					),
			  	),
			  	array (
					'Id' => 47241,
					'UserDefinedId' => 'prong.title',
					'Value' => 
					array (
					  '#' => 'Owner',
					),
			  	),
			  	array (
					'Id' => 47242,
					'UserDefinedId' => 'prong.name',
					'Value' => 
					array (
					  'FirstName' => $getdata->name,
					  'MiddleName' =>  $getdata->m_name,
					  'LastName' => $getdata->l_name,
					),
			  	),
			  	array (
					'Id' => 47245,
					'UserDefinedId' => 'prong.ssn',
					'Value' => 
					array (
					  '#' =>str_replace("-","",$getdata->o_ss_number),
					),
			  	),
			  	array (
					'Id' => 47244,
					'UserDefinedId' => 'prong.dob',
					'Value' => 
					array (
					  'Month' => $getdata->o_dob_m,
					  'Day' => $getdata->o_dob_d,
					  'Year' => $getdata->o_dob_y,
					),
			  	),
			  	array (
					'Id' => 47243,
					'UserDefinedId' => 'prong.address',
					'Value' => 
					array (
					  // 'Country' => $getdata->o_country,
					  'Country' => ($getdata->o_country == 'USA') ? 'US' : $getdata->o_country,
					  'Street1' => $getdata->o_address1,
					  'Street2' => $getdata->o_address2,
					  'City' => $getdata->o_city,
					  'State' => $getdata->o_state,
					  'Zip' => $getdata->o_zip,
					),
			  	),
			  	array (
					'Id' => 47282,
					'UserDefinedId' => 'prong.phone',
					'Value' => 
					array (
					  '#' => $getdata->o_phone,
					),
			  	),
			  	array (
					'Id' => 47290,
					'UserDefinedId' => 'prong.email',
					'Value' => 
					array (
					  '#' => $getdata->o_email,
					),
			  	),
			  	array (
					'Id' => 47247,
					'UserDefinedId' => 'pc.title',
					'Value' => 
					array (
					  '#' => $getdata->pc_title,
					),
			  	),
			  	array (
					'Id' => 47246,
					'UserDefinedId' => 'pc.name',
					'Value' => 
					array (
					  'FirstName' => $getdata->pc_name,
					  'MiddleName' => $getdata->pc_name,
					  'LastName' => $getdata->pc_name,
					),
			  	),
			  	array (
					'Id' => 47249,
					'UserDefinedId' => 'pc.phone',
					'Value' => 
					array (
					  '#' => $getdata->pc_phone,
					),
			  	),
			  	array (
					'Id' => 47248,
					'UserDefinedId' => 'pc.email',
					'Value' => 
					array (
					  '#' => $getdata->pc_email,
					),
			  	),
			  	array (
					'Id' => 47216,
					'UserDefinedId' => 'bank.routingnumber',
					'Value' => 
					array (
					  	'#' => $getdata->bank_routing,
					),
			  	),
			  	array (
					'Id' => 47217,
					'UserDefinedId' => 'bank.routingnumber.confirm',
					'Value' => 
					array (
					  	'#' => $getdata->bank_routing,
					),
			  	),
			  	array (
					'Id' => 47218,
					'UserDefinedId' => 'bank.acctnumber',
					'Value' => 
					array (
					  	'#' => $getdata->bank_account,
					),
			  	),
			  	array (
					'Id' => 47219,
					'UserDefinedId' => 'bank.acctnumber.confirm',
					'Value' => 
					array (
					  	'#' => $getdata->bank_account,
					),
			  	),
			  	array (
					'Id' => 47283,
					'UserDefinedId' => 'legal.cnp',
					'Value' => 
					array (
					  '#' => $getdata->cnp_percent,
					),
			  	),
			  	array (
					'Id' => 47284,
					'UserDefinedId' => 'legal.cp',
					'Value' => 
					array (
					  '#' => $getdata->cp_percent,
					),
			  	),
			  	array (
					'Id' => 47215,
					'UserDefinedId' => 'legal.website',
					'Value' => 
					array (
					  	'#' => $getdata->website,
					),
			  	),
			  	array (
					'Id' => 47289,
					'UserDefinedId' => 'legal.averageticket',
					'Value' => 
					array (
					  '#' => $getdata->average_ticket,
					),
			  	),
			  	array (
					'Id' => 47701,
					'UserDefinedId' => 'legal.highesttransaction',
					'Value' => 
					array (
					  '#' => '10',
					),
			  	),
			  	array (
					'Id' => 47288,
					'UserDefinedId' => 'legal.monthlyvolume',
					'Value' => 
					array (
					  '#' => '10',
					),
			  	),
			  	array (
					'Id' => 47702,
					'UserDefinedId' => 'legal.highestmonthlyvolume',
					'Value' => 
					array (
					  '#' => '10',
					),
			  	),
			  	array (
					'Id' => 52656,
					'UserDefinedId' => 'billing.type',
					'Value' => 
					array (
					  '#' => $getdata->billing_structure,
					),
			  	),
			  	array (
					'Id' => 48769,
					'UserDefinedId' => 'feeprofile.pricing',
					'Value' => 
					array (
					  // '#' => $getdata->fee_structure,
					  '#' => '3.84% and $0.00',
					),
			  	),
			  	array (
					'Id' => 47260,
					'UserDefinedId' => 'feeprofile.annualccsalesvol',
					'Value' => 
					array (
					  '#' => $getdata->annual_cc_sales_vol,
					),
			  	),
			  	
			)
		);

      	// print_r($inputRawData);die;
	   	// echo json_encode($inputRawData); 
		// die;
		
	   	// $purl='https://merchantapp.io/salequicktest/api/v1/MerchantApplication/Submit';
	   	$purl='https://merchantapp.io/salequickpflite/api/v1/MerchantApplication/Submit'; 
		$ch = curl_init();
		$headers = array("Accept-Encoding: gzip", "Content-Type: application/json");
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
		// print_r($response);die();
		$responceArrayData =json_decode($response, true); 
		curl_close($ch);

		if ($err) {
		  //echo json_encode("cURL Error #:" . $err);
		  echo json_encode(array('Status'=>600,'StatusMessage'=>'cURL Error #'.$err));
		} else {
			//print_r($responceArrayData['Status']); 
			if($responceArrayData['Status']=='30') {
               	$apidata=array(
					'merchant_id'=>$getdata->id,
					'merchant_application_id'=>$responceArrayData['MerchantApplicationId'],
					'external_merchant_application_id'=>$responceArrayData['ExternalMerchantApplicationId'],
					'infinicept_application_id'=>$responceArrayData['InfiniceptApplicationId'],
					'status'=>$responceArrayData['Status'],
					'status_message'=>$responceArrayData['StatusMessage']
			   	);
               	$getdataOfApi=$this->db->query("SELECT * FROM  merchant_api WHERE merchant_id='$getdata->id'  ")->result_array(); 
			   	if(count($getdataOfApi) == '0') {
				    $this->db->insert('merchant_api',$apidata);
			   	}

			   	$up_mail = array(
			   		'verification_status' => 'done'
			   	);
			   	$this->db->where('merchant_id', $id);
				$this->db->update('agreement_verification', $up_mail);

				$agreement_log_data = array(
			   		'status' => '1'
			   	);
			   	$this->db->where('merchant_id', $id);
				$this->db->update('agreement_mail_log', $agreement_log_data);

				$ip_address = $_SERVER['REMOTE_ADDR'];

				$getloc = json_decode(file_get_contents("http://ipinfo.io/"));
				$coordinates = explode(",", $getloc->loc); // -> '32,-72' becomes'32','-72'
				$latitude = $coordinates[0];
				$longitude = $coordinates[1];
				// echo $latitude.'-'.$longitude;die;
				// print_r($getloc->loc);die;

				$agreement_accepted_at = date("Y-m-d h:i:s");

				$browser = $_SERVER['HTTP_USER_AGENT'];

				$get_last_mail = $this->db->where('merchant_id', $id)->order_by('id', 'DESC')->get('agreement_mail_log')->row();
				// print_r($get_last_mail);die;
				$agreement_log_data_new = array(
			   		'ip_address' => $ip_address,
			   		'latitude' => $latitude,
			   		'longitude' => $longitude,
			   		'browser' => $browser,
			   		'agreement_accepted_at' => $agreement_accepted_at
			   	);
			   	$this->db->where('id', $get_last_mail->id);
				$this->db->update('agreement_mail_log', $agreement_log_data_new);

				echo $response;
			
			} else {
				//echo json_encode(array('Status'=>200));
				echo $response;   
			}
		}
	}

	public function verification() {
		// echo $this->uri->segment(5);die;
		$unique = $this->uri->segment(5);
		$merchant_id = $this->uri->segment(3);

		$getQuery = $this->db->query("SELECT * from merchant where auth_key='" . $unique . "' ");
		$getEmail = $getQuery->result_array();
		// echo $this->db->last_query();die;

		$getEmailCount = $getQuery->num_rows();
		if ($getEmailCount > 0) {
			if ( ($getEmail[0]['status'] == 'pending') || ($getEmail[0]['status'] == 'block') || ($getEmail[0]['status'] == 'pending_signup') ) {
				// print_r($getEmail[0]['status']); die();
				$info = array(
					'status' => 'Waiting_For_Approval',
				);

				$this->db->where('id', $merchant_id);
				$this->db->update('merchant', $info);
			}
		}

		$mail_verify_key = $this->uri->segment(4);
		$merchant = $this->db->where('id', $merchant_id)->get('merchant')->row();
		// echo $merchant->email;die;

		$data['email'] = $merchant->email;
		$data['business_dba_name'] = $merchant->business_dba_name;
		$data['merchant_id'] = $merchant_id;
		$data['mail_verify_key'] = $mail_verify_key;
		$data['getData'] = $this->db->where('merchant_id', $merchant_id)->get('agreement_verification')->row();
		// echo '<pre>';print_r($data);die;

		$this->load->view('merchant_agreement', $data);
	}
	
}