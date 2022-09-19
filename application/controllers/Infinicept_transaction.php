<?php 
  if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
  }
  class Infinicept_transaction extends CI_Controller {
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
      //ini_set('display_errors', 1);
        //error_reporting(E_ALL);
    }

public function index()
   {
   

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.infinicept.com/api/salequick/transactions/paginated?PageSize=1&includeTotalCount=true&SpecificDate=2021-12-05',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-AuthenticationKeyId: 1625b631-3928-4b08-2a5d-08d988ebffe9',
    'x-AuthenticationKeyValue: DTw1PnWoesjSJATao8VJnZ5bOuxc5rZune6TdRxwfAaoCydiqkwTbUUJSBxnKc0t',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$response_p = json_decode($response, true);
print_r($response_p);
}




}