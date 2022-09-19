<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class  Vtquickbook extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->library('session');
    	$this->load->database();
    	$this->load->model('Home_model');
    	$this->load->model('admin_model');
    	$this->load->model('profile_model'); 

         error_reporting(E_ALL);
		date_default_timezone_set("America/Chicago");
		
    }
   
    
    public function get_vertiual_terminal_detail() {
			$data = array();
			$searchby=28659;
			//$searchby = $_POST['id'];
			//$merchant_id = $_POST['merchant_id'];
			$merchant_id = $this->session->userdata('merchant_id');
			$invoice_detail = $this->admin_model->search_record_pos($searchby);
			
			//echo '<pre>';
			//print_r($invoice_detail); die();
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		
            
		
			    $package['id'] = $invoice_detail[0]->id;
					$package['invoice_no'] = $invoice_detail[0]->invoice_no;
					$package['name'] = $invoice_detail[0]->name;
                    $package['merchant_id'] = $invoice_detail[0]->merchant_id;
                    $package['qb_online_invoice_id'] = $invoice_detail[0]->qb_online_invoice_id;
                    $package['payment_id'] = $invoice_detail[0]->payment_id;
                    $package['email_id'] = $invoice_detail[0]->email_id;
                    $package['mobile_no'] = $invoice_detail[0]->mobile_no;
                    $package['amount'] = $invoice_detail[0]->amount;
                    $package['transaction_id'] = $invoice_detail[0]->transaction_id;
                    $package['status'] = $invoice_detail[0]->status;
                    $package['city'] = $invoice_detail[0]->city;
                    $package['state'] = $invoice_detail[0]->state;
                    // $package['country'] = $invoice_detail[0]->country;
                    // $package['zipcode'] = $invoice_detail[0]->zipcode;
                    // $package['address'] = $invoice_detail[0]->address;
                    // $package['payment_date'] = $invoice_detail[0]->payment_date;
                    $package['add_date'] = $invoice_detail[0]->add_date;
                    
                    $package['item_detail'][] = array(
                        'item_name' => 'VT',
                        'item_quantity' => 1,
                        'item_price' => $invoice_detail[0]->amount,
                        'item_tax' => $invoice_detail[0]->tax,
                        'item_total_amount' => $invoice_detail[0]->amount
                        );
                        
				
                          

                $session_data = array('invoice_id' => $searchby);
                $this->session->set_userdata($session_data);
            
                $this->load->model("Quickbook_model");//LOAD QUICKBOOK 
                $this->Quickbook_model->init($merchant_id);

                $quick_book_settings = $this->Quickbook_model->getTokenInfo($merchant_id);
               
                
                $this->session->set_userdata($quick_book_settings);
                
                $access_token = $this->session->userdata['access_token'];
                
              
                $qb_invoice_id = 0;
        
                   try {
                    $invoice_id = $this->Quickbook_model->sync_invoice_into_QB($qb_invoice_id,$package);
            
                    if($invoice_id > 0)
                    {
        
                       // invoice id update in invoice table 
                        $invoice_res = array('status' => TRUE,
                        "invoice_id" => $invoice_id,
                        "message" => "Invoice sync successful. QB Invoice #$invoice_id"
                      );
                     
                    }
                  }catch(Exception $e) {
                        if($error_reporting ==1)
                        {
                          echo 'Message: ' .$e->getMessage();
        
                        }
              }
                       
		//	echo '<pre>';			
		//	print_r($package); die();
			

		
		}
	
	
    public function invoice_data() {
			$data = array();
			$merchant_id = $this->session->userdata('merchant_id');
			
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		
				$employee = 0;
				$status = $_POST['status'];
				$date1 = $_POST['start_date'];
				$date2 = $_POST['end_date'];

			
			$package_data = $this->admin_model->get_full_details_admin_report_search_qb('customer_payment_request', $date1, $date2, $employee, $status);
			//$data['invoice_detail_receipt_item'] = $this->admin_model->data_get_where_1("order_item", array("p_id" =>3318));
				$member = array();
			foreach ($package_data as $each) {
			    $package['id'] = $each->id;
					$package['invoice_no'] = $package[0]->invoice_no;
					$package['name'] = $each->name;
                    $package['merchant_id'] = $each->merchant_id;
                    $package['qb_online_invoice_id'] = $each->qb_online_invoice_id;
                    $package['payment_id'] = $each->payment_id;
                    $package['name'] = $each->name;
                    $package['email_id'] = $each->email_id;
                    $package['mobile_no'] = $each->mobile_no;
                    $package['amount'] = $each->amount;
                    $package['transaction_id'] = $each->transaction_id;
                    $package['status'] = $each->status;
                    $package['city'] = $each->city;
                    $package['state'] = $each->state;
                    $package['country'] = $each->country;
                    $package['zipcode'] = $each->zipcode;
                    $package['address'] = $each->address;
                    $package['payment_date'] = $each->payment_date;
                    $package['add_date'] = $each->add_date;
                    
                    
				
					$package['item_detail'] = $this->admin_model->data_get_where_1("order_item", array("p_id" =>$each->id));
					
				
                       
                        
						$member[] = $package;
			}
            $data['$member'] = $member;
			echo '<pre>';			
			print_r($data); die();
			

		
		}
	
	
   function redirect_qb_online()
   {
     
        $scope='com.intuit.quickbooks.accounting com.intuit.quickbooks.payment';
          
        $authorizeURL = 'https://appcenter.intuit.com/connect/oauth2';
        
        $redirect_url =  base_url().'quickbook/get_access_token';
       
        $_SESSION['state'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
       
        $params = array(
          'client_id' => INTUIT_CLIENT_ID,
          'redirect_uri' => $redirect_url,
          'scope' => $scope,
          'response_type'=>'code',
          'state' => $_SESSION['state']
        );
        // Redirect the user to Github's authorization page
         header('Location: ' . $authorizeURL . '?' . http_build_query($params));
   }

    function api_request($url, $post=FALSE, $headers=array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        if(count()==0)
        {
            $headers[] = 'Accept: application/json';
            $headers[] = 'User-Agent:' . APP_NAME;
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $qbResponse = curl_exec($ch);
        $ResponseJson = json_decode($qbResponse);
        return $ResponseJson;
    }
	 
	 function get_access_token()
      {
        
        $merchant_id = $this->session->userdata('merchant_id');
        $state      =  $this->input->get('state');
        $realm_id   =  $this->input->get('realmId');
        $code       =  $this->input->get('code');
        $scope      =   'com.intuit.quickbooks.accounting com.intuit.quickbooks.payment';
    
        $tokenURL  =  'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer';
        //   // Exchange the auth code for a token
          $resposne_data = $this->api_request($tokenURL, array(
            'client_id' => INTUIT_CLIENT_ID,
            'client_secret' => INTUIT_CLIENT_SECRET,
            'redirect_uri' => base_url().'quickbook/get_access_token',
            'state' => $state,
            'grant_type'=> 'authorization_code',
            'code' => $code 
          ));
        //   echo '<pre>';
    
       
          $access_token = $resposne_data->access_token;
          $refresh_token = $resposne_data->refresh_token;
          //$refresh_token_expires_in = $resposne_data->x_refresh_token_expires_in;
          $refresh_token_expires_in= date('Y-m-d', strtotime("+90 days"));
          
          $data = array(
            'access_token'=>$access_token,
            'refresh_token'=>$refresh_token,
            'merchant_id'=>$merchant_id,
            'refresh_token_expires_in'=>$refresh_token_expires_in,
            'scope'=>$scope,
            'realm_id'=>$realm_id,
            'state'=>$state,
            'code'=>$code,
           );
         
          //add_record("tbl_qbonline_setting",$data);
          $this->Home_model->insert_data("tbl_qbonline_setting", $data);
          $redirect_url=base_url()."quickbook";
          redirect($redirect_url);
        }
	
}
			