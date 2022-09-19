<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Quickbook_model extends CI_Model {


    public $income_account_ref;

    public $billing_address;
    public $billing_city;
    public $billing_country;
    public $billing_state;
    public $billing_zip;

    public $address;
    public $city;
    public $country;
    public $state;
    public $zip;



    public function __construct()
    {
        parent::__construct();
        $this->load->model('Home_model');
    }
    
    function init($merchant_id)
    {
         // Get QuickBook setting
        $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id";
        $result_setting = $this->db->query($query_qb_setting)->result();
        $intuit_realm_id = trim($result_setting[0]->realm_id);
        $this->income_account_ref = "1";


        //DEFINE CONSTANT
        define('OAUTH2_BASE_URL', 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer');
        define("COMPANY_ID", $intuit_realm_id);
        define('INVOICE_API_PATH', INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/invoice");
        define('UPDATE_INVOICE_API_PATH', INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/invoice?operation=update");
        define("QUERY_API_PATH", INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/query");
        define("ADD_CUSTOMER_API_PATH", INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/customer");
        define("UPDATE_CUSTOMER_API_PATH", INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/customer?operation=update");
        define("ADD_ITEM_API_PATH", INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/item?operation=create");
        define("ACCOUNT_API_PATH", INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/query");
        define("ADD_PAYMENT_API_PATH", INTUIT_API_BASE_URL."v3/company/".COMPANY_ID."/payment");
        
        
    }

    // Get token information 
    function getTokenInfo($merchant_id) 
    {
        
        $query  = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id";
        $result_setting = $this->db->query($query)->result();
        $tokenInformation = array(
            'client_id'         => INTUIT_CLIENT_ID,
            'client_secret_key' => INTUIT_CLIENT_SECRET,
            'realm_id'          => $result_setting[0]->realm_id,
            'access_token'      => $result_setting[0]->access_token,
            'refresh_token'     => $result_setting[0]->refresh_token,

        );
        return $tokenInformation;
    }

    // Refresh QuickBook access token
    function refreshQBAccessToken()
    {
       

        $call_url               = OAUTH2_BASE_URL;
        $url_encode_data        = "grant_type=refresh_token&refresh_token=".$this->session->userdata['refresh_token'];
         $basic_token            = INTUIT_CLIENT_ID .":".INTUIT_CLIENT_SECRET;
        $basic_token_in_base64  = base64_encode($basic_token);
        
        // Call Curl function
        $ch = curl_init($call_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $url_encode_data);
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'Authorization: Basic ' . $basic_token_in_base64;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        
        // Response decode
        $responseJsonData  = json_decode($response);
        //print_r($responseJsonData);
//print_r($this->session->userdata);
      
        // Update information in database
        
        $tokenArr = [
            'access_token'        => $responseJsonData->access_token,
            'refresh_token'       => $responseJsonData->refresh_token
        ];
        $merchant_id =$this->session->userdata['merchant_id'];
        $condition=" id = $merchant_id";
        $this->Home_model->update_data("tbl_qbonline_setting", $tokenArr,$condition);
        // store access token into session
        $sessionData = array('access_token' => $responseJsonData->access_token);
        $this->session->set_userdata($sessionData);    
        return true;
    }

    // QuickBook request with curl function
    function quickBookRequestWithCurl($qbEndPoint, $postDataArray, $qbQuery){
       

        $ch = curl_init($qbEndPoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        // Headers for json data
        if($postDataArray != ''){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postDataArray));
            $headers[] = 'Content-Type: application/json';
        }

        // Headers for query
        if($qbQuery != ''){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $qbQuery);
            $headers[] = 'Content-Type: application/text';
        }
        // Common headers
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer ' . $this->session->userdata['access_token'];
        $headers[] = 'User-Agent:' . APP_NAME;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);


        // Return response
        return $response;
    }

    // Synchronization with QuickBook
    function sync_qb_calls($qbEndPoint, $postDataArray, $qbQuery){
        $qbResponse = $this->quickBookRequestWithCurl($qbEndPoint, $postDataArray, $qbQuery);
        $qbResponseJson = json_decode($qbResponse);
       
        $status = 1;

        if(isset($qbResponseJson->fault)){
            if($qbResponseJson->fault->error[0]->code == '3200') {
                $requestRefreshToken = $this->refreshQBAccessToken();
                if($requestRefreshToken == 1){
                    $qbResponse = $this->quickBookRequestWithCurl($qbEndPoint, $postDataArray, $qbQuery);
                    $qbResponseJson = json_decode($qbResponse);

                    if(isset($qbResponseJson->fault)){
                        $status = 0;
                    }
                }
            } else {
                $status = 0;
            }
        }

        if($status == 0){
            $apiInputs = '';
            if($postDataArray != ''){
                $apiInputs = json_encode($postDataArray);
            }
            if($qbQuery != ''){
                $apiInputs = $qbQuery;
            }
    
            // Store API logs
          
            // Exit due to some issues with QuickBook connectivity.

        }
        // Return QuickBokk response
        return $qbResponse;
    }

    function sync_invoice_into_QB($qb_invoice_id,$package)
    {
        
        $item_list =$package['item_detail'];
       
       
         // get item list with is_taxable value
         $response_data = $this->get_item_list($item_list);
         // get item list with is_taxable value

       
        // get request data for quickbook online
        $request_body = $this->get_request_data_for_qb($package,$response_data,$qb_invoice_id);
        // get request data for quickbook online

        //Check invoice exits or not
        $invoice_api_path = INVOICE_API_PATH;
        if($qb_invoice_id > 0)
        {
            $checkQuery = "SELECT * FROM Invoice WHERE Id = '$qb_invoice_id' ";

            // Synchronization with QuickBook
            $response = $this->sync_qb_calls(QUERY_API_PATH, '', $checkQuery);
            $arrayResult  = json_decode($response,TRUE);
            
            $query_response = $arrayResult['QueryResponse'];

            
            if(count($query_response) > 0) //Invoice exits
            {
                $invoice_id = $query_response['Invoice'][0]['Id'];
                $sync_token = $query_response['Invoice'][0]['SyncToken'];
                $invoice_api_path = UPDATE_INVOICE_API_PATH;
                $request_body['Id'] = $invoice_id;
                $request_body['SyncToken'] = $sync_token;
            }
            else //Invoice Add
            {
                $invoice_api_path = INVOICE_API_PATH;
            }
        }
        // Synchronization with QuickBook
       
     
        $response = $this->sync_qb_calls($invoice_api_path, $request_body, '');
        $arrayResult  = json_decode($response,TRUE);
        
       
     
       
        
        
        if(isset($arrayResult['Invoice']))
        {
            $invoice_id = $arrayResult['Invoice']['Id'];
        }
        return $invoice_id;
    }

    function get_request_data_for_qb($package,$response_data,$qb_invoice_id)
    {
    
        $item_list =$response_data['item_list'];
        $is_txn_tax_detail =$response_data['is_taxable'];
        

        $customer_id         = $this->customer($package);
      
        $request_body = array (
            'Line' => $item_list,
            'CustomerRef' => array ("value" => $customer_id)
        );
       
        
        $invoice_number  = $package['invoice_no'];
        //$invoice_number  = 'INV-'.time();
        //$invoice_number  = '77281206';
        $qb_invoice_id   = $qb_invoice_id;
        if($invoice_number != "")
        {
            $request_body['DocNumber'] = $invoice_number; //maximum of 21 chars, filterable, sortable and Reference number for the transaction.
        }
        
            
        //Invoice Tax Details
        if($is_txn_tax_detail)
        {
            $txn_tax_detail = array();
            $tax_line_detail = new stdClass();
            $tax_line_detail->PercentBased = TRUE;
            $txn_tax_detail['TaxLine'][] = array(
                'DetailType' => "TaxLineDetail",
                'TaxLineDetail' => $tax_line_detail
            );
            $request_body['TxnTaxDetail'] = $txn_tax_detail;
        }
        //Invoice Tax Details

        return $request_body;
    }

    function get_item_list($item_list_db)
    {
        $item_list=array();
        $is_txn_tax_detail = FALSE;
        $lineNum=1;
        $i=0;
        foreach ($item_list_db as $item_row)
        {
            
            $unit_price =   $item_row['item_price'];
            $amount     =   $item_row['item_total_amount'];
            $qty        =   $item_row['item_quantity'];
            $item_name  =   $item_row['item_name'];
            $item_tax  =   $item_row['item_tax'];
            
            $item_id    = $this->item($item_name);

            $unit_price = (float)sprintf("%01.2f", $unit_price);
            $amount = (float)sprintf("%01.2f", $amount);
            $salesItemLineDetail = array(
                "UnitPrice" => $unit_price,
                "Qty" => $qty,
                "ItemRef" => array(
                    "value" => $item_id
                )
            );

            //TaxCodeRef
            if($item_tax > 0 )
            {
                $tax_code_ref_obj = new stdClass();
                $tax_code_ref_obj->value = "TAX";
                $salesItemLineDetail['TaxCodeRef'] = $tax_code_ref_obj;
                $is_txn_tax_detail = TRUE;
            }
            //TaxCodeRef

            $item_list[$i] = array(
                'Id' =>$lineNum,
                'LineNum'=> $lineNum,
                'Description'=> $options_name,
                'Amount' => $amount,
                'DetailType' => "SalesItemLineDetail",
                'SalesItemLineDetail' => $salesItemLineDetail
            );

            $i++;
            $lineNum ++;
        }
        
        
    //End Item Loop ******************************************* 
        $response_data= array('item_list'=>$item_list,'is_taxable'=>$is_txn_tax_detail );
        
        return $response_data;
    }

  
    
    function getToken($orgID) //Get Access Token and Token Secret
    {
        $query = "SELECT intuit_token,intuit_token_secret,intuit_realm_id From organisation WHERE id = $orgID ";
        $result_org = $this->db->query($query)->result();
        $oauth_access_token_secret = trim($result_org[0]->intuit_token_secret);//intuit_token_secret
        $oauth_token = trim($result_org[0]->intuit_token); //intuit_token

        $options = array(
            'consumer_key' => INTUIT_CONSUMER_KEY,
            'consumer_secret' => INTUIT_CONSUMER_SECRET,
            'signature_methods' => Array
                (
                        '0' => 'HMAC-SHA1'
                ),
            'token_type' => 'access',
            'token' => $oauth_token,
            'token_secret' => $oauth_access_token_secret,
            'server_uri' => "",
            'request_token_uri' => "",
            'authorize_uri' => "",
            'access_token_uri' => ""
        );
        return $options;
    }

    function get_client_name($name_arr)
    {
        $name_arr_update=@explode('  -',$name_arr);
        $name=$name_arr;
        if(count($name_arr_update)==2)
        {
            $name=trim($name_arr_update[0]).' - '.trim($name_arr_update[1]);
        }
        return $name;
    }

    function customer($customerDataInvoice)//Add and check customer/clinet get its ID
    {
       
      
        $customer_id = 0;
        //Get Customer Detail of the call
        $client_email = $customerDataInvoice['email_id'];
        if(isset($client_email))
        {
            $client_email = $client_email;
            if (!filter_var($client_email, FILTER_VALIDATE_EMAIL))
            {
                $client_email = "";
            }
        }
        $cilent_name    =   $customerDataInvoice['name'];
        $display_name   =   $cilent_name;
        $phone_number   =   $customerDataInvoice['mobile_no'];

        if (strlen($display_name) > 99) {
            $client_name = substr($display_name, 0, 99);
        }
        else
        {
            $client_name = $display_name;
        }
        $address = $customerDataInvoice['address'];
        $city = '';
        $state = '';
        $zip = '';
        $country = '';
        if($country == "")
        {
            $country = "USA";
        }

        //Get Customer Detail of the call

        //Customer Billing Address
    
            //$billing_address = $address;
            $billing_address = 'Unknown';
             
            $billing_city = $city;
            $billing_state = $state;
            $billing_zip = $zip;
            $billing_country = $country;
        
        //Customer Billing Address


        $display_name = addslashes(trim($display_name));
        $display_name = preg_replace("/[:]/", "", $display_name);
        $checkQuery = "SELECT * FROM Customer WHERE DisplayName = '$display_name' ";

        // Synchronization with QuickBook
        $response = $this->sync_qb_calls(QUERY_API_PATH, '', $checkQuery);
        $queryResJsonData = json_decode($response, TRUE);
        $query_response = $queryResJsonData['QueryResponse'];
        
        //Assign public variable
        $this->billing_address = $billing_address;
        $this->billing_city = $billing_city;
        $this->billing_country = $billing_country;
        $this->billing_state = $billing_state;
        $this->billing_zip = $billing_zip;

        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->state = $state;
        $this->zip = $zip;
        //Assign public variable

        if(count($query_response) > 0) //Customer exits
        {
            $customer_id = $query_response['Customer'][0]['Id'];
            $sync_token = $query_response['Customer'][0]['SyncToken'];
           
            //$sync_token = $sync_token+1;
            $update_customer_json    =   array(
                "BillAddr"  => array(
                    "Line1"                     => $billing_address,
                    "City"                      => $billing_city,
                    "Country"                   => $billing_country,
                    "CountrySubDivisionCode"    => $billing_state,
                    "PostalCode"                => $billing_zip
                ),
                "ShipAddr"  =>  array(
                    "Line1"                     => $address,
                    "City"                      => $city,
                    "Country"                   => $country,
                    "CountrySubDivisionCode"    => $state,
                    "PostalCode"                => $zip
                ),
                "Id"                =>  $customer_id,
                "Notes"             => "Here are other details.",
                "GivenName"         => $client_name,
                "DisplayName"       => $display_name,
                "PrintOnCheckName"  => $display_name,
                "Active"            => true,
                "PrimaryPhone"      => array(
                  "FreeFormNumber"  => $phone_number
                ),
                "PrimaryEmailAddr"  => array(
                    "Address"       => $client_email
                ),
                "domain"        => "QBO",
                "SyncToken"     => $sync_token,
                "sparse"        =>false,
                "Active"        => true,
            );

            $update_customer_api_path = UPDATE_CUSTOMER_API_PATH;

            // Synchronization with QuickBook
            $response = $this->sync_qb_calls($update_customer_api_path, $update_customer_json, '');
            $arrayResult  = json_decode($response,TRUE);
            $query_response = $arrayResult['Customer'];
           
        }
        else //Add new customer
        {
            $add_customer_api_path = ADD_CUSTOMER_API_PATH;
            $add_customer_json    =   array(
                "BillAddr"  => array(
                    "Line1"                     => $billing_address,
                    "City"                      => $billing_city,
                    "Country"                   => $billing_country,
                    "CountrySubDivisionCode"    => $billing_state,
                    "PostalCode"                => $billing_zip
                ),
                "ShipAddr"  =>  array(
                    "Line1"                     => $address,
                    "City"                      => $city,
                    "Country"                   => $country,
                    "CountrySubDivisionCode"    => $state,
                    "PostalCode"                => $zip
                ),

                "Notes"             => "Here are other details.",
                "GivenName"         => $client_name,
                "DisplayName"       => $display_name,
                "PrintOnCheckName"  => $display_name,
                "Active"            => true,
                "PrimaryPhone"      => array(
                  "FreeFormNumber"  => $phone_number
                ),
                "PrimaryEmailAddr"  => array(
                    "Address"       => $client_email
                ),
                "domain"            => "QBO",
                "sparse"            =>true,
                "Active"            => true,
            );

            // Synchronization with QuickBook
            $response = $this->sync_qb_calls($add_customer_api_path, $add_customer_json, '');
            $arrayResult  = json_decode($response,TRUE);
            $query_response = $arrayResult['Customer'];
            
            if(count($query_response) > 0) //Customer exits
            {
                $customer_id = $query_response['Id'];
            }

        }
        return $customer_id;
    }


    function item($item_name) //Add and check item get its ID
    {
       
        $item_id = 0;
        $checkQuery = "SELECT * FROM Item WHERE Name= '$item_name' ";

        // Synchronization with QuickBook
        $response = $this->sync_qb_calls(QUERY_API_PATH, '', $checkQuery);
        $queryResJsonData = json_decode($response);
        $query_response = $queryResJsonData->QueryResponse;
        
        
        if(isset($query_response->Item)) //Customer exits
        {
           $item_id = $query_response->Item[0]->Id;
        }
        else
        {
            $date = date("Y-m-d");
            $item_query_api_path = ADD_ITEM_API_PATH;
            
            $add_item_json=array(
                "Name" => $item_name,
                "Description" => "",
                "Active" => true,
                "FullyQualifiedName" => $item_name,
                "Taxable" => false,
                "UnitPrice" => 0,
                "IncomeAccountRef"=> array(
                    "value"=> $this->income_account_ref
                ),
                "Type"=> "Service",
                "TrackQtyOnHand"=> false,
                "InvStartDate"=> $date
            );

            // Synchronization with QuickBook
            $response = $this->sync_qb_calls($item_query_api_path, $add_item_json, '');
           
            $arrayResult  = json_decode($response,TRUE);
            $query_response = $arrayResult['Item'];

            $item_id = $query_response['Id'];
        }
        return $item_id;
    }

function sync_invoice_into_QB_a($qb_invoice_id)
    {
     //echo $qb_invoice_id  ; 
    // die();
     
            $checkQuery = "SELECT * FROM Invoice WHERE Id ='$qb_invoice_id' ";
            
             $display_name = addslashes(trim('vaibhav'));
        $display_name = preg_replace("/[:]/", "", $display_name);
        //$checkQuery = "SELECT * FROM Customer WHERE DisplayName = '$display_name' ";
        
            //$item_query_api_path = QUERY_API_PATH;
            
            // Synchronization with QuickBook
           $response = $this->sync_qb_calls(QUERY_API_PATH, '', $checkQuery);
            $arrayResult  = json_decode($response,TRUE);
//print_r($arrayResult);  return $arrayResult; die();
                 $queryResJsonData = json_decode($response, TRUE);
        $query_response = $queryResJsonData['QueryResponse'];
        $customer_id = $query_response['Invoice'][0]['CustomerRef']['value'];
 $customer_name = $query_response['Invoice'][0]['CustomerRef']['name'];
        $cid = $query_response['Invoice'][0]['Id'];
        $amt = $query_response['Invoice'][0]['Balance'];
            
                //Add Payment
 


 $add_payment_json = [
   "CustomerRef" => [
         "value" => $customer_id, 
         "name" => $customer_name 
      ], 
   "TotalAmt" => $amt, 
   "Line" => [
            [
               "Amount" => $amt, 
               "LinkedTxn" => [
                  [
                     "TxnId" => $cid, 
                     "TxnType" => "Invoice" 
                  ] 
               ] 
            ] 
         ] 
]; 
 
 


                // Synchronization with QuickBook
                $response = $this->sync_qb_calls(ADD_PAYMENT_API_PATH, $add_payment_json, '');
                $arrayResult = json_decode($response, TRUE);

                
                //$query_response_e = $arrayResult['Payment'];
            
           
       print_r($arrayResult);
     
        return $arrayResult ;
       
    }
    
    
    function sync_invoice_into_QB_b($qb_invoice_id,$paid_amount)
    {
     //echo $qb_invoice_id  ; 
    // die();
     
            $checkQuery = "SELECT * FROM Invoice WHERE Id ='$qb_invoice_id' ";
            
             $display_name = addslashes(trim('vaibhav'));
        $display_name = preg_replace("/[:]/", "", $display_name);
        //$checkQuery = "SELECT * FROM Customer WHERE DisplayName = '$display_name' ";
        
            //$item_query_api_path = QUERY_API_PATH;
            
            // Synchronization with QuickBook
           $response = $this->sync_qb_calls(QUERY_API_PATH, '', $checkQuery);
            $arrayResult  = json_decode($response,TRUE);
//print_r($arrayResult);  return $arrayResult; die();
                 $queryResJsonData = json_decode($response, TRUE);
        $query_response = $queryResJsonData['QueryResponse'];
        $customer_id = $query_response['Invoice'][0]['CustomerRef']['value'];
 $customer_name = $query_response['Invoice'][0]['CustomerRef']['name'];
        $cid = $query_response['Invoice'][0]['Id'];
        $amt = $query_response['Invoice'][0]['Balance'];
            
                //Add Payment
 


 $add_payment_json = [
   "CustomerRef" => [
         "value" => $customer_id, 
         "name" => $customer_name 
      ], 
   "TotalAmt" => $amt, 
   "Line" => [
            [
               "Amount" => $paid_amount, 
               "LinkedTxn" => [
                  [
                     "TxnId" => $cid, 
                     "TxnType" => "Invoice" 
                  ] 
               ] 
            ] 
         ] 
]; 
 
 


                // Synchronization with QuickBook
                $response = $this->sync_qb_calls(ADD_PAYMENT_API_PATH, $add_payment_json, '');
                $arrayResult = json_decode($response, TRUE);

                
                //$query_response_e = $arrayResult['Payment'];
            
           
       print_r($arrayResult);
     
        return $arrayResult ;
       
    }
   
   
}
