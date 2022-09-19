<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class  Aa extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->library('session');
    	$this->load->database();
    	$this->load->model('Home_model');
    	$this->load->model('admin_model');
    	$this->load->model('profile_model'); 
    	$this->load->model("Quickbook_model");//LOAD QUICKBOOK 

        //ini_set('display_errors', 1);
	    //error_reporting(E_ALL);
	    //	 ini_set('max_execution_time', -1);
		date_default_timezone_set("America/Chicago");
    }
    
    function index() {
        echo '<pre>'; print_r($this->session->userdata);  die();
        $merchant_id = $this->session->userdata('merchant_id');
        // $query_qb_setting = "SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id";
        $result_setting = $this->db->query("SELECT * From tbl_qbonline_setting WHERE merchant_id = $merchant_id")->result();
        // echo '<pre>';print_r($result_setting);die();
        
        $data['merchant_id'] = $merchant_id;
        $data['status'] = trim($result_setting[0]->status);
        $data['pos_status'] = trim($result_setting[0]->pos_status);
        $data['inv_status'] = trim($result_setting[0]->inv_status);
        $data['vt_status'] = trim($result_setting[0]->vt_status);
        
    	//	$this->db->delete('tbl_qbonline_setting');
        $redirect_url=base_url()."quickbook/redirect_qb_online";
        $data['redirect_url'] = $redirect_url;
        $this->load->view('merchant/quickbook',$data);
    }
    
    public function get_invoice_detail() {
        
            //$this->db->where('merchant_id',413);
            //$this->db->delete('tbl_qbonline_setting');
			$data = array();
			$package = array();
			$searchby='3523';
			//$searchby = $_POST['id'];
			//$merchant_id = $_POST['merchant_id'];
			$merchant_id='413';
			//$merchant_id = $this->session->userdata('merchant_id');
			$invoice_detail = $this->admin_model->search_record($searchby);
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		
	
				
		
			    $package['id'] = $invoice_detail[0]->id;
					$package['invoice_no'] = $invoice_detail[0]->invoice_no;
					$package['name'] = $invoice_detail[0]->name;
                    $package['merchant_id'] = $invoice_detail[0]->merchant_id;
                    $package['qb_online_invoice_id'] = $invoice_detail[0]->qb_online_invoice_id;
                    $package['payment_id'] = $invoice_detail[0]->payment_id;
                    $package['name'] = $invoice_detail[0]->name;
                    $package['email_id'] = $invoice_detail[0]->email_id;
                    $package['mobile_no'] = $invoice_detail[0]->mobile_no;
                    $package['amount'] = $invoice_detail[0]->amount;
                    $package['tax'] = $invoice_detail[0]->tax;
                    $package['other_charges'] = $invoice_detail[0]->other_charges;
                    $package['otherChargesName'] = $invoice_detail[0]->otherChargesName;
                    $package['transaction_id'] = $invoice_detail[0]->transaction_id;
                    $package['status'] = $invoice_detail[0]->status;
                    $package['city'] = $invoice_detail[0]->city;
                    $package['state'] = $invoice_detail[0]->state;
                    $package['country'] = $invoice_detail[0]->country;
                    $package['zipcode'] = $invoice_detail[0]->zipcode;
                    $package['address'] = $invoice_detail[0]->address;
                    $package['payment_date'] = $invoice_detail[0]->payment_date;
                    $package['add_date'] = $invoice_detail[0]->add_date;
                    $package['invoice_type'] = $invoice_detail[0]->invoice_type;
                    if($invoice_detail[0]->invoice_type=='custom'){
					$invoice_detail_receipt_item = $this->admin_model->data_get_where_1("order_item", array("p_id" =>$invoice_detail[0]->id));
					
					
				
                     $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                       
                            $quantity1=json_decode($invoice_detail_receipt_item[0]['quantity']);
                            $price1=json_decode($invoice_detail_receipt_item[0]['price']);
                            $tax1=json_decode($invoice_detail_receipt_item[0]['tax']);
                            $tax_id1=json_decode($invoice_detail_receipt_item[0]['tax_id']);
                            $tax_per1=json_decode($invoice_detail_receipt_item[0]['tax_per']);
                            $total_amount1=json_decode($invoice_detail_receipt_item[0]['total_amount']);
                           $item_name1=json_decode($invoice_detail_receipt_item[0]['item_name']);
                           
                           
                           	$i = 0;
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$i] > 0 ) {
						$price_bb = number_format($price1[$i], 2);
						$item_total_amount = $price1[$i] * $quantity1[$i];
						//$tax_aaa = number_format($tax_aa, 2);
						//$total_aaa = number_format($total_amount1[$i], 2);


						 $package['item_detail'][] = array(
                        'item_name' => $item_name1[$i],
                        'item_quantity' => $quantity1[$i],
                        'item_price' => $price1[$i],
                        'item_tax' => '',
                        'item_total_amount' => $item_total_amount
                        );

					}

					$i++;
				}
                      }
                      else
                      {
                           $amount = $invoice_detail[0]->amount - ($invoice_detail[0]->tax + $invoice_detail[0]->other_charges);
                           $package['item_detail'][] = array(
                        'item_name' => 'Simple Invoice',
                        'item_quantity' => 1,
                        'item_price' =>  $amount,
                        'item_tax' => '',
                        'item_total_amount' => $amount
                        );
                      
                      }
				 if($invoice_detail[0]->tax >0){
					 $package['item_detail'][] = array(
                        'item_name' =>'Tax',
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->tax,
                        'item_tax' =>  $invoice_detail[0]->tax,
                        'item_total_amount' =>  $invoice_detail[0]->tax
                        );
				 }
                        if($invoice_detail[0]->other_charges >0){
                         $package['item_detail'][] = array(
                        'item_name' => $invoice_detail[0]->otherChargesName,
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->other_charges,
                        'item_tax' => '',
                        'item_total_amount' =>  $invoice_detail[0]->other_charges
                        );
                        }
				 // echo '<pre>';			
		     // print_r($package); die();
	         
                $session_data = array('invoice_id' => $searchby);
                $this->session->set_userdata($session_data);
            
               
                $this->Quickbook_model->init($merchant_id);

                $quick_book_settings = $this->Quickbook_model->getTokenInfo($merchant_id);
                //echo '<pre>';
               //print_r( $quick_book_settings ); exit;
                
                $quick_book_settings['access_token']='eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..U7sjez5igvRTr4aX5GUtIw.1rAyGAfun0GvePgMSDzCdq_3PY4fWWpmbTyBu755zuG0IpOie6aYJ2LVR4iAm06qnpUUpccL5mBd7dYom6GlM5GhjsxkVAuJpkMYhjuCw7TizfYO9kUSTBthBBZ1nfaGOB-s4USVlni7Z8z_RIlOkI6Vt09ek5dtQaQufhwt3Qs4ZozS2nnXdAA3DE8NhlmZiBeUceXMR-lCFV9qtC80_ukaYWtLY2RKFAQ3RgKoAFesqN7AKc0plTvUzLKoGmSIzdkVx_Cc3ZUbXW0FfAelpFZacO155HNGDY2BVMQKPV05Xu8DNnPugjraLBeZiFFoicQRmeD18BQ5i4LQ4QWXJD5g6oKhNH4MhffI0yu63FmScmW0aOXldsxeF5cGgD2WdoOLRBSmOibPpksIOskh9sPOEVmQHjrW5xjPG6AblRbqH0p700sCh2pP0BFNROh54IzJfhOYq4S8t93EXGHM0_8chZWyrve50r5kWtnsUmMzugrs2RBMo-45jJa_P9lpZzRU-zEFyptILxKADQGAeFLmSFBJ_Xl9DrvcmbcwXEdTaCqGrI0FD54UefEPBXapXnPnDnNGuKoglaoURCAFGBX1o_k_QdizrvtasJTjbTu220txz9lAL07QWJUoenofyMusm73YJWN_v7AG32ARPnrEP0MnhFRI_Z_7qHrpOD8boF0SgTSgGbonFfBzTW9jNlKE24QWIIFfIpSsD_o-oohtedx52wuRSXYNArvtjX0.f5o-nVCU66oq5kp2wOpIgA';
          
                
                $this->session->set_userdata($quick_book_settings);
                
                $access_token = $this->session->userdata['access_token'];
                
            // echo '<pre>';
            //print_r($package); exit;
                $qb_invoice_id = 0;
        
                   try {
                       echo 'ss';
                    $invoice_id = $this->Quickbook_model->sync_invoice_into_QB($qb_invoice_id,$package);
                    echo $invoice_id ; 
                  exit;
                    if($invoice_id > 0)
                    {
        	$stmt2 =$this->db->query("UPDATE  customer_payment_request set qb_status ='1',qb_online_invoice_id ='".$invoice_id."' where id ='".$invoice_detail[0]->id."' ");
                       // invoice id update in invoice table 
                        $invoice_res = array('status' => TRUE,
                        "invoice_id" => $invoice_id,
                        "message" => "Invoice sync successful. QB Invoice #$invoice_id"
                      );
                     print_r($invoice_res);
                    }
                  }catch(Exception $e) {
                        if($error_reporting ==1)
                        {
                          echo 'Message: ' .$e->getMessage();
        
                        }
              }
                       
	
			

		
		}
		
		public function get_invoice_detail_live() {
        
            //$this->db->where('merchant_id',413);
            //$this->db->delete('tbl_qbonline_setting');
			$data = array();
			$package = array();
			//$searchby='3434';
			$searchby = $_POST['id'];
			$merchant_id = $_POST['merchant_id'];
			//$merchant_id='413';
			//$merchant_id = $this->session->userdata('merchant_id');
			$invoice_detail = $this->admin_model->search_record($searchby);
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		
	
				
		
			    $package['id'] = $invoice_detail[0]->id;
					$package['invoice_no'] = $invoice_detail[0]->invoice_no;
					$package['name'] = $invoice_detail[0]->name;
                    $package['merchant_id'] = $invoice_detail[0]->merchant_id;
                    $package['qb_online_invoice_id'] = $invoice_detail[0]->qb_online_invoice_id;
                    $package['payment_id'] = $invoice_detail[0]->payment_id;
                    $package['name'] = $invoice_detail[0]->name;
                    $package['email_id'] = $invoice_detail[0]->email_id;
                    $package['mobile_no'] = $invoice_detail[0]->mobile_no;
                    $package['amount'] = $invoice_detail[0]->amount;
                    $package['tax'] = $invoice_detail[0]->tax;
                    $package['other_charges'] = $invoice_detail[0]->other_charges;
                    $package['otherChargesName'] = $invoice_detail[0]->otherChargesName;
                    $package['transaction_id'] = $invoice_detail[0]->transaction_id;
                    $package['status'] = $invoice_detail[0]->status;
                    $package['city'] = $invoice_detail[0]->city;
                    $package['state'] = $invoice_detail[0]->state;
                    $package['country'] = $invoice_detail[0]->country;
                    $package['zipcode'] = $invoice_detail[0]->zipcode;
                    $package['address'] = $invoice_detail[0]->address;
                    $package['payment_date'] = $invoice_detail[0]->payment_date;
                    $package['add_date'] = $invoice_detail[0]->add_date;
                    $package['invoice_type'] = $invoice_detail[0]->invoice_type;
                    if($invoice_detail[0]->invoice_type=='custom'){
					$invoice_detail_receipt_item = $this->admin_model->data_get_where_1("order_item", array("p_id" =>$invoice_detail[0]->id));
                     $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                       
                            $quantity1=json_decode($invoice_detail_receipt_item[0]['quantity']);
                            $price1=json_decode($invoice_detail_receipt_item[0]['price']);
                            $tax1=json_decode($invoice_detail_receipt_item[0]['tax']);
                            $tax_id1=json_decode($invoice_detail_receipt_item[0]['tax_id']);
                            $tax_per1=json_decode($invoice_detail_receipt_item[0]['tax_per']);
                            $total_amount1=json_decode($invoice_detail_receipt_item[0]['total_amount']);
                           $item_name1=json_decode($invoice_detail_receipt_item[0]['item_name']);
                           
                           	$i = 0;
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$i] > 0 ) {
						$price_bb = number_format($price1[$i], 2);
						$item_total_amount = $price1[$i] * $quantity1[$i];
						//$tax_aaa = number_format($tax_aa, 2);
						//$total_aaa = number_format($total_amount1[$i], 2);


						 $package['item_detail'][] = array(
                        'item_name' => $item_name1[$i],
                        'item_quantity' => $quantity1[$i],
                        'item_price' => $price1[$i],
                        'item_tax' => '',
                        'item_total_amount' => $item_total_amount
                        );

					
					}

					$i++;
				}
				
	          	}
                      else
                     {
                           $amount = $invoice_detail[0]->amount - ($invoice_detail[0]->tax + $invoice_detail[0]->other_charges);
                           $package['item_detail'][] = array(
                        'item_name' => 'Simple Invoice',
                        'item_quantity' => 1,
                        'item_price' =>  $amount,
                        'item_tax' => '',
                        'item_total_amount' => $amount
                        );
                      
                      }
				 if($invoice_detail[0]->tax >0){
					 $package['item_detail'][] = array(
                        'item_name' =>'Tax',
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->tax,
                        'item_tax' =>  $invoice_detail[0]->tax,
                        'item_total_amount' =>  $invoice_detail[0]->tax
                        );
				 }
                        if($invoice_detail[0]->other_charges >0){
                         $package['item_detail'][] = array(
                        'item_name' => $invoice_detail[0]->otherChargesName,
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->other_charges,
                        'item_tax' => '',
                        'item_total_amount' =>  $invoice_detail[0]->other_charges
                        );
                        }
				 // echo '<pre>';			
		     // print_r($package); die();
	         
                $session_data = array('invoice_id' => $searchby);
                $this->session->set_userdata($session_data);
            
                //$this->load->model("Quickbook_model");//LOAD QUICKBOOK 
                $this->Quickbook_model->init($merchant_id);

                $quick_book_settings = $this->Quickbook_model->getTokenInfo($merchant_id);
                //echo '<pre>';
               //print_r( $quick_book_settings ); exit;
                
                $quick_book_settings['access_token']='eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..U7sjez5igvRTr4aX5GUtIw.1rAyGAfun0GvePgMSDzCdq_3PY4fWWpmbTyBu755zuG0IpOie6aYJ2LVR4iAm06qnpUUpccL5mBd7dYom6GlM5GhjsxkVAuJpkMYhjuCw7TizfYO9kUSTBthBBZ1nfaGOB-s4USVlni7Z8z_RIlOkI6Vt09ek5dtQaQufhwt3Qs4ZozS2nnXdAA3DE8NhlmZiBeUceXMR-lCFV9qtC80_ukaYWtLY2RKFAQ3RgKoAFesqN7AKc0plTvUzLKoGmSIzdkVx_Cc3ZUbXW0FfAelpFZacO155HNGDY2BVMQKPV05Xu8DNnPugjraLBeZiFFoicQRmeD18BQ5i4LQ4QWXJD5g6oKhNH4MhffI0yu63FmScmW0aOXldsxeF5cGgD2WdoOLRBSmOibPpksIOskh9sPOEVmQHjrW5xjPG6AblRbqH0p700sCh2pP0BFNROh54IzJfhOYq4S8t93EXGHM0_8chZWyrve50r5kWtnsUmMzugrs2RBMo-45jJa_P9lpZzRU-zEFyptILxKADQGAeFLmSFBJ_Xl9DrvcmbcwXEdTaCqGrI0FD54UefEPBXapXnPnDnNGuKoglaoURCAFGBX1o_k_QdizrvtasJTjbTu220txz9lAL07QWJUoenofyMusm73YJWN_v7AG32ARPnrEP0MnhFRI_Z_7qHrpOD8boF0SgTSgGbonFfBzTW9jNlKE24QWIIFfIpSsD_o-oohtedx52wuRSXYNArvtjX0.f5o-nVCU66oq5kp2wOpIgA';
          
                
                $this->session->set_userdata($quick_book_settings);
                
                $access_token = $this->session->userdata['access_token'];
                
             //echo '<pre>';
            //print_r($package); exit;
                $qb_invoice_id = 0;
        
                   try {
                    $invoice_id = $this->Quickbook_model->sync_invoice_into_QB($qb_invoice_id,$package);
                    echo $invoice_id ;
                    //exit;
                    if($invoice_id > 0)
                    {
        	$stmt2 =$this->db->query("UPDATE  customer_payment_request set qb_status ='1',qb_online_invoice_id ='".$invoice_id."' where id ='".$invoice_detail[0]->id."' ");
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
                       
	
			

		
		}
		
		public function get_invoice_detail_live_payment3() {
        
           
			$data = array();
			$package = array();
			$invoice_id = $_POST['id'];
			$merchant_id = $_POST['merchant_id'];
		
                $this->Quickbook_model->init($merchant_id);


                   try {
                   
                    
                       // invoice id update in invoice table 
                 $this->get_invoice_detail_payment_vt($invoice_id);

                 
                  }catch(Exception $e) {
                        if($error_reporting ==1)
                        {
                          echo 'Message: ' .$e->getMessage();
        
                        }
              }
                       

		}



public function get_invoice_detail_live_payment() {
        
            //$this->db->where('merchant_id',413);
            //$this->db->delete('tbl_qbonline_setting');
			$data = array();
			$package = array();
			//$searchby='3434';
			$searchby = $_POST['id'];
			$merchant_id = $_POST['merchant_id'];
			//$merchant_id='413';
			//$merchant_id = $this->session->userdata('merchant_id');
			$invoice_detail = $this->admin_model->search_record($searchby);
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		
	
				
		
			    $package['id'] = $invoice_detail[0]->id;
					$package['invoice_no'] = $invoice_detail[0]->invoice_no;
					$package['name'] = $invoice_detail[0]->name;
                    $package['merchant_id'] = $invoice_detail[0]->merchant_id;
                    $package['qb_online_invoice_id'] = $invoice_detail[0]->qb_online_invoice_id;
                    $package['payment_id'] = $invoice_detail[0]->payment_id;
                    $package['name'] = $invoice_detail[0]->name;
                    $package['email_id'] = $invoice_detail[0]->email_id;
                    $package['mobile_no'] = $invoice_detail[0]->mobile_no;
                    $package['amount'] = $invoice_detail[0]->amount;
                    $package['tax'] = $invoice_detail[0]->tax;
                    $package['other_charges'] = $invoice_detail[0]->other_charges;
                    $package['otherChargesName'] = $invoice_detail[0]->otherChargesName;
                    $package['transaction_id'] = $invoice_detail[0]->transaction_id;
                    $package['status'] = $invoice_detail[0]->status;
                    $package['city'] = $invoice_detail[0]->city;
                    $package['state'] = $invoice_detail[0]->state;
                    $package['country'] = $invoice_detail[0]->country;
                    $package['zipcode'] = $invoice_detail[0]->zipcode;
                    $package['address'] = $invoice_detail[0]->address;
                    $package['payment_date'] = $invoice_detail[0]->payment_date;
                    $package['add_date'] = $invoice_detail[0]->add_date;
                    $package['invoice_type'] = $invoice_detail[0]->invoice_type;
                    if($invoice_detail[0]->invoice_type=='custom'){
					$invoice_detail_receipt_item = $this->admin_model->data_get_where_1("order_item", array("p_id" =>$invoice_detail[0]->id));
                     $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                       
                            $quantity1=json_decode($invoice_detail_receipt_item[0]['quantity']);
                            $price1=json_decode($invoice_detail_receipt_item[0]['price']);
                            $tax1=json_decode($invoice_detail_receipt_item[0]['tax']);
                            $tax_id1=json_decode($invoice_detail_receipt_item[0]['tax_id']);
                            $tax_per1=json_decode($invoice_detail_receipt_item[0]['tax_per']);
                            $total_amount1=json_decode($invoice_detail_receipt_item[0]['total_amount']);
                           $item_name1=json_decode($invoice_detail_receipt_item[0]['item_name']);
                           
                           	$i = 0;
				foreach ($item_name1 as $rowpp) {
					if ($quantity1[$i] > 0 ) {
						$price_bb = number_format($price1[$i], 2);
						$item_total_amount = $price1[$i] * $quantity1[$i];
						//$tax_aaa = number_format($tax_aa, 2);
						//$total_aaa = number_format($total_amount1[$i], 2);


						 $package['item_detail'][] = array(
                        'item_name' => $item_name1[$i],
                        'item_quantity' => $quantity1[$i],
                        'item_price' => $price1[$i],
                        'item_tax' => '',
                        'item_total_amount' => $item_total_amount
                        );

					
					}

					$i++;
				}
				
	          	}
                      else
                     {
                           $amount = $invoice_detail[0]->amount - ($invoice_detail[0]->tax + $invoice_detail[0]->other_charges);
                           $package['item_detail'][] = array(
                        'item_name' => 'Simple Invoice',
                        'item_quantity' => 1,
                        'item_price' =>  $amount,
                        'item_tax' => '',
                        'item_total_amount' => $amount
                        );
                      
                      }
				 if($invoice_detail[0]->tax >0){
					 $package['item_detail'][] = array(
                        'item_name' =>'Tax',
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->tax,
                        'item_tax' =>  $invoice_detail[0]->tax,
                        'item_total_amount' =>  $invoice_detail[0]->tax
                        );
				 }
                        if($invoice_detail[0]->other_charges >0){
                         $package['item_detail'][] = array(
                        'item_name' => $invoice_detail[0]->otherChargesName,
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->other_charges,
                        'item_tax' => '',
                        'item_total_amount' =>  $invoice_detail[0]->other_charges
                        );
                        }
				 // echo '<pre>';			
		     // print_r($package); die();
	         
                $session_data = array('invoice_id' => $searchby);
                $this->session->set_userdata($session_data);
            
                //$this->load->model("Quickbook_model");//LOAD QUICKBOOK 
                $this->Quickbook_model->init($merchant_id);

                $quick_book_settings = $this->Quickbook_model->getTokenInfo($merchant_id);
                //echo '<pre>';
               //print_r( $quick_book_settings ); exit;
                
                $quick_book_settings['access_token']='eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..U7sjez5igvRTr4aX5GUtIw.1rAyGAfun0GvePgMSDzCdq_3PY4fWWpmbTyBu755zuG0IpOie6aYJ2LVR4iAm06qnpUUpccL5mBd7dYom6GlM5GhjsxkVAuJpkMYhjuCw7TizfYO9kUSTBthBBZ1nfaGOB-s4USVlni7Z8z_RIlOkI6Vt09ek5dtQaQufhwt3Qs4ZozS2nnXdAA3DE8NhlmZiBeUceXMR-lCFV9qtC80_ukaYWtLY2RKFAQ3RgKoAFesqN7AKc0plTvUzLKoGmSIzdkVx_Cc3ZUbXW0FfAelpFZacO155HNGDY2BVMQKPV05Xu8DNnPugjraLBeZiFFoicQRmeD18BQ5i4LQ4QWXJD5g6oKhNH4MhffI0yu63FmScmW0aOXldsxeF5cGgD2WdoOLRBSmOibPpksIOskh9sPOEVmQHjrW5xjPG6AblRbqH0p700sCh2pP0BFNROh54IzJfhOYq4S8t93EXGHM0_8chZWyrve50r5kWtnsUmMzugrs2RBMo-45jJa_P9lpZzRU-zEFyptILxKADQGAeFLmSFBJ_Xl9DrvcmbcwXEdTaCqGrI0FD54UefEPBXapXnPnDnNGuKoglaoURCAFGBX1o_k_QdizrvtasJTjbTu220txz9lAL07QWJUoenofyMusm73YJWN_v7AG32ARPnrEP0MnhFRI_Z_7qHrpOD8boF0SgTSgGbonFfBzTW9jNlKE24QWIIFfIpSsD_o-oohtedx52wuRSXYNArvtjX0.f5o-nVCU66oq5kp2wOpIgA';
          
                
                $this->session->set_userdata($quick_book_settings);
                
                $access_token = $this->session->userdata['access_token'];
                
             //echo '<pre>';
            //print_r($package); exit;
                $qb_invoice_id = 0;
        
                   try {
                    $invoice_id = $this->Quickbook_model->sync_invoice_into_QB($qb_invoice_id,$package);
                    echo $invoice_id ;
                    //exit;
                    if($invoice_id > 0)
                    {
        	$stmt2 =$this->db->query("UPDATE  customer_payment_request set qb_status ='1',qb_online_invoice_id ='".$invoice_id."' where id ='".$invoice_detail[0]->id."' ");
                       // invoice id update in invoice table 
$this->get_invoice_detail_payment_vt($invoice_id);

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
                       
	
			

		
		}
	
	
		public function get_invoice_detail_vt() {
        
           
			$data = array();
			$package = array();

// 			$searchby = 30918;
// 			$merchant_id = 413;
				$searchby = $_POST['id'];
			$merchant_id = $_POST['merchant_id'];
			$invoice_detail = $this->admin_model->search_record_pos($searchby);
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		    //print_r($invoice_detail); die();
	
			  $package['id'] = $invoice_detail[0]->id;
					$package['invoice_no'] = $invoice_detail[0]->invoice_no;
				
					 if ($invoice_detail[0]->name=='N/A')
					{
					$package['name'] = 'POS';
					}
					else	if($invoice_detail[0]->name!='')
					{
					$package['name'] = $invoice_detail[0]->name;
					}
					else
					{
					    	$package['name'] = 'VT';
					}
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
                    
                    $package['add_date'] = $invoice_detail[0]->add_date;
                    
                    $package['item_detail'][] = array(
                        'item_name' => 'VT',
                        'item_quantity' => 1,
                        'item_price' => $invoice_detail[0]->amount,
                        'item_tax' =>'',
                        'item_total_amount' => $invoice_detail[0]->amount
                        );
                        
				 if($invoice_detail[0]->tax >0){
					 $package['item_detail'][] = array(
                        'item_name' =>'Tax',
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->tax,
                        'item_tax' =>  $invoice_detail[0]->tax,
                        'item_total_amount' =>  $invoice_detail[0]->tax
                        );
				 }
                        if($invoice_detail[0]->other_charges >0){
                         $package['item_detail'][] = array(
                        'item_name' => $invoice_detail[0]->otherChargesName,
                        'item_quantity' =>1 ,
                        'item_price' =>  $invoice_detail[0]->other_charges,
                        'item_tax' => '',
                        'item_total_amount' =>  $invoice_detail[0]->other_charges
                        );
                        }
			//	  echo '<pre>';			
		    //  print_r($package); die();
	         
                $session_data = array('invoice_id' => $searchby);
                $this->session->set_userdata($session_data);
            
                //$this->load->model("Quickbook_model");//LOAD QUICKBOOK 
                $this->Quickbook_model->init($merchant_id);

                $quick_book_settings = $this->Quickbook_model->getTokenInfo($merchant_id);
                //echo '<pre>';
               //print_r( $quick_book_settings ); exit;
                
                $quick_book_settings['access_token']='eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..U7sjez5igvRTr4aX5GUtIw.1rAyGAfun0GvePgMSDzCdq_3PY4fWWpmbTyBu755zuG0IpOie6aYJ2LVR4iAm06qnpUUpccL5mBd7dYom6GlM5GhjsxkVAuJpkMYhjuCw7TizfYO9kUSTBthBBZ1nfaGOB-s4USVlni7Z8z_RIlOkI6Vt09ek5dtQaQufhwt3Qs4ZozS2nnXdAA3DE8NhlmZiBeUceXMR-lCFV9qtC80_ukaYWtLY2RKFAQ3RgKoAFesqN7AKc0plTvUzLKoGmSIzdkVx_Cc3ZUbXW0FfAelpFZacO155HNGDY2BVMQKPV05Xu8DNnPugjraLBeZiFFoicQRmeD18BQ5i4LQ4QWXJD5g6oKhNH4MhffI0yu63FmScmW0aOXldsxeF5cGgD2WdoOLRBSmOibPpksIOskh9sPOEVmQHjrW5xjPG6AblRbqH0p700sCh2pP0BFNROh54IzJfhOYq4S8t93EXGHM0_8chZWyrve50r5kWtnsUmMzugrs2RBMo-45jJa_P9lpZzRU-zEFyptILxKADQGAeFLmSFBJ_Xl9DrvcmbcwXEdTaCqGrI0FD54UefEPBXapXnPnDnNGuKoglaoURCAFGBX1o_k_QdizrvtasJTjbTu220txz9lAL07QWJUoenofyMusm73YJWN_v7AG32ARPnrEP0MnhFRI_Z_7qHrpOD8boF0SgTSgGbonFfBzTW9jNlKE24QWIIFfIpSsD_o-oohtedx52wuRSXYNArvtjX0.f5o-nVCU66oq5kp2wOpIgA';
          
                
                $this->session->set_userdata($quick_book_settings);
                
                $access_token = $this->session->userdata['access_token'];
                
             //echo '<pre>';
            //print_r($package); exit;
                $qb_invoice_id = 0;
        
                   try {
                    $invoice_id = $this->Quickbook_model->sync_invoice_into_QB($qb_invoice_id,$package);
                    echo $invoice_id ;
                    //exit;
                    if($invoice_id > 0)
                    {
        	$stmt2 =$this->db->query("UPDATE  pos set qb_status ='1',qb_online_invoice_id ='".$invoice_id."' where id ='".$invoice_detail[0]->id."' ");

                     $this->get_invoice_detail_payment_vt($invoice_id);

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
                       
	
			

		
		}
	
	
    public function invoice_data() {
			$data = array();
			echo $merchant_id = $this->session->userdata('merchant_id');
			
			$merchant_data = $this->profile_model->get_merchant_details($merchant_id);
		
				$employee = 0;
			//	$status = $_POST['status'];
				$status = 'confirm';
				// $date1 = $_POST['start_date'];
				// $date2 = $_POST['end_date'];
				$start_date = '2020-07-01';
				$end_date = '2020-07-15';
				
				$package_data = $this->admin_model->get_search_merchant_pos_paid_list($start_date, $end_date, $status, $merchant_id, 'customer_payment_request');
				
 echo '<pre>'; print_r($package_data); die();
			
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
			//echo '<pre>';			
			//print_r($data); die();
			

		
		}
	
	
   function redirect_qb_online()
   {
     
        $scope='com.intuit.quickbooks.accounting';
          
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
        $scope      =   'com.intuit.quickbooks.accounting';
    
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
        
        	public function get_invoice_detail_live_payment2() {
        
           
			$data = array();
			$package = array();
		$invoice_id = $_POST['id'];
			$merchant_id = $_POST['merchant_id'];
	
                $this->Quickbook_model->init($merchant_id);

 $quick_book_settings = $this->Quickbook_model->getTokenInfo($merchant_id);
                //echo '<pre>';
               //print_r( $quick_book_settings ); exit;
                
                $quick_book_settings['access_token']='eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..U7sjez5igvRTr4aX5GUtIw.1rAyGAfun0GvePgMSDzCdq_3PY4fWWpmbTyBu755zuG0IpOie6aYJ2LVR4iAm06qnpUUpccL5mBd7dYom6GlM5GhjsxkVAuJpkMYhjuCw7TizfYO9kUSTBthBBZ1nfaGOB-s4USVlni7Z8z_RIlOkI6Vt09ek5dtQaQufhwt3Qs4ZozS2nnXdAA3DE8NhlmZiBeUceXMR-lCFV9qtC80_ukaYWtLY2RKFAQ3RgKoAFesqN7AKc0plTvUzLKoGmSIzdkVx_Cc3ZUbXW0FfAelpFZacO155HNGDY2BVMQKPV05Xu8DNnPugjraLBeZiFFoicQRmeD18BQ5i4LQ4QWXJD5g6oKhNH4MhffI0yu63FmScmW0aOXldsxeF5cGgD2WdoOLRBSmOibPpksIOskh9sPOEVmQHjrW5xjPG6AblRbqH0p700sCh2pP0BFNROh54IzJfhOYq4S8t93EXGHM0_8chZWyrve50r5kWtnsUmMzugrs2RBMo-45jJa_P9lpZzRU-zEFyptILxKADQGAeFLmSFBJ_Xl9DrvcmbcwXEdTaCqGrI0FD54UefEPBXapXnPnDnNGuKoglaoURCAFGBX1o_k_QdizrvtasJTjbTu220txz9lAL07QWJUoenofyMusm73YJWN_v7AG32ARPnrEP0MnhFRI_Z_7qHrpOD8boF0SgTSgGbonFfBzTW9jNlKE24QWIIFfIpSsD_o-oohtedx52wuRSXYNArvtjX0.f5o-nVCU66oq5kp2wOpIgA';
          
                
                $this->session->set_userdata($quick_book_settings);
                
                $access_token = $this->session->userdata['access_token'];
                
                       //echo 'ss';
                   
                   // die();
                       // invoice id update in invoice table 
                 $this->get_invoice_detail_payment_vt($invoice_id);

                 
               
                       

		}
        
    public function get_invoice_detail_payment_vt($qb_invoice_id) {
        $quick_book_settings = $this->Quickbook_model->sync_invoice_into_QB_a($qb_invoice_id);
        echo '<pre>';
        print_r( $quick_book_settings ); exit;
    }
        
    public function get_invoice_detail_data() {
        $merchant_id=413;
        $this->Quickbook_model->init($merchant_id);
        $qb_invoice_id=72;
        $quick_book_settings = $this->Quickbook_model->sync_invoice_into_QB_a($qb_invoice_id);
        echo '<pre>';
        print_r( $quick_book_settings ); exit;
    }
	
	public function update_other_conn_status() {
	    $data = array();
	    $status = $this->input->post('status');
	    $merchant_id = $this->input->post('merchant_id');
	    $checkbox_nm = $this->input->post('checkbox_nm');
	    // echo $status.','.$merchant_id.','.$checkbox_nm;die();
	    
	    if ($checkbox_nm == 'inv_check') {
	        $data = array(
                'inv_status' => $status
            );
	    } else if ($checkbox_nm == 'pos_check') {
	        $data = array(
                'pos_status' => $status
            );
	    } else if ($checkbox_nm == 'vt_check') {
	        $data = array(
                'vt_status' => $status
            );
	    }
	    
	    $this->db->where('merchant_id', $merchant_id);
	    $this->db->update('tbl_qbonline_setting', $data);
	    echo $status;die();
	}
	
	public function delete_connection($merchant_id) {
	    $merchant_id = $this->uri->segment('3');
	    // echo $merchant_id;die();
	    
	    $this->db->delete('tbl_qbonline_setting', array('merchant_id' => $merchant_id));
	    redirect(base_url('quickbook'));
	}
}
			