<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Acceptcard_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

      public function insert_Card($mydata)
      {
        // print_r($mydata);die
         $this->db->insert('token',$mydata);
        // return $this->db->insert_id();
         //echo $this->db->last_query(); die;
      }

      public function insert_data($table, $data) 
      {
          $this->db->insert($table, $data);
        return $this->db->insert_id();
      }
      public function saveInvoiceNum($data,$tok)
      {
         
        // print_r($mydata);die
        $SQL= "SELECT id from token where token='$tok'";
         $query = $this->db->query($SQL);
           $token= $query->result_array()['0']['id'];
         $data['token_id']=$token;
         $data['status']='1'; 
         //print_r($mydata);die;
         $this->db->insert('invoice_token',$data);
         
         //return $query[0]['token'];
         
      }
      public function updateTokenForCustomer($data)
      {
         $sql="update customer_payment_request set token=".$data['token']." where invoice_no='".$data['invoice_no']."'";
         $this->db->query($sql);
         //echo $this->db->last_query(); die;
        
      } 
      public function saveCardNum($token)
      {

        $query="SELECT id,merchant_id,card_no from token where token=".$token;
        $x=$this->db->query($query);
        //echo $this->db->last_query();die;
        $id=$x->result_array()[0]['id'];
        $card_no=$x->result_array()[0]['card_no'];
        $merchantid=$x->result_array()[0]['merchant_id'];
        $q2="SELECT invoice_no from invoice_token WHERE token_id=".$id;
        $y=$this->db->query($q2);
        //echo $this->db->last_query();die;
        $invoice_no= $y->result_array()[0]['invoice_no'];
        $query3="update customer_payment_request set card_no='".$card_no."' where invoice_no='".$invoice_no."' and merchant_id=".$merchantid;
        $this->db->query($query3);
        //echo $this->db->last_query();die;
      }
      public function updateInvoiceAndToken($token,$merchant_id,$invoice_no,$response,$row_Id){
         $sql="SELECT token from token where token='".$token."'";
         $query1 = $this->db->query($sql);
         $q1="SELECT id from token where token=".$token." and status=1";
         $res=$this->db->query($q1);
         //echo $this->db->last_query(); die;
         $id=$res->result_array()[0]['id']; //getting tokens id
         // $query2="insert into invoice_token (invoice_no,merchant_id,token_id) values('".$invoice_no."',".$merchant_id.",".$id.")";
         $query2="UPDATE invoice_token set token_id='".$id."' where invoice_no='".$invoice_no."' and merchant_id='".$merchant_id."'";
         $this->db->query($query2);
         //echo $this->db->last_query(); die;
         // $query3="update customer_payment_request set token=1 where invoice_no='".$invoice_no."'";
         // $this->db->query($query3);
         //echo $this->db->last_query(); die;
        if($response['responsetext']!='Approved'){
           $q1="update customer_payment_request set status='declined',message='".$response['responsetext']."',auth_code='".$response['authcode']."',transaction_id=".$response['transactionid'].",card_no='".$response['cc_number']."',card_type='".$response['cc_type']."',name_card='".$response['name']."'  where invoice_no='".$invoice_no."' and id='".$row_Id."'";
            $this->db->query($q1);
          // echo $this->db->last_query();die; 
        }
        else{
            $r_count=$this->db->query("SELECT recurring_count from customer_payment_request where invoice_no='".$invoice_no."' and id='".$row_Id."'")->result_array();
        
            $recurringcount= $r_count[0]['recurring_count'];
        
            if($recurringcount!=-1){
                $q1="update customer_payment_request set token=1,status='confirm',message='".$response['responsetext']."',auth_code='".$response['authcode']."',transaction_id=".$response['transactionid'].",card_no='".$response['cc_number']."',card_type='".$response['cc_type']."',name_card='".$response['name']."', recurring_count_paid=recurring_count_paid+1,recurring_count_remain=recurring_count_remain-1 where invoice_no='".$invoice_no."' and id='".$row_Id."'";
            $this->db->query($q1);
            // echo $this->db->last_query();die; 
            }
            else{
                $q1="update customer_payment_request set token=1,status='confirm',message='".$response['responsetext']."',auth_code='".$response['authcode']."',transaction_id=".$response['transactionid'].",card_no='".$response['cc_number']."',card_type='".$response['cc_type']."',name_card='".$response['name']."', recurring_count_paid=recurring_count_paid+1,recurring_count_remain=1 where invoice_no='".$invoice_no."' and id='".$row_Id."'";
                $this->db->query($q1);
                // echo $this->db->last_query();die; 
          }
        
        }
      }
      public function fetch($token,$merchant_id)
      {
           $sql="SELECT card_type, right(card_no,4) as 'card_no',token from token where token='".$token."' and merchant_id='".$merchant_id."' ";
         $query1 = $this->db->query($sql);

        //  $q1="SELECT id from token where token=".$token." and status=1";
        //  $res=$this->db->query($q1);
        //  //echo $this->db->last_query(); die;
        //  $id=$res->result_array()[0]['id']; //getting tokens id
        //  $changeTokenId="update invoice_token set token_id=".$id." where merchant_id=".$merchant_id;
        //  $this->db->query($changeTokenId);
        // // echo $this->db->last_query(); die;
        //  $changeTokenStatus="update token set status=0 where id!=".$id." and merchant_id=".$merchant_id;
        //  $this->db->query($changeTokenStatus);
        // //echo $this->db->last_query(); die;
         return $query1->result_array();
       
      }
      public function saveCustomerRecord($data)
      {
         
         $this->db->insert('customer_payment_request',$data);
         //echo $this->db->last_query(); die;
      }
      public function amountDetails($invoice_no)
      {
         $q1="SELECT amount,late_fee from customer_payment_request where invoice_no='".$invoice_no."'";
          $res= $this->db->query($q1);
          return $res->result_array();
         // echo $this->db->last_query();die;
      }
      public function tokenDetails($invoice_no)
      {

        $q1="SELECT token_id from invoice_token where invoice_no='".$invoice_no."'";
        $res=$this->db->query($q1);
        
        $tokenid=$res->result_array()[0]['token_id'];
        if($tokenid!='')
        {
          $q2="Select token from token where id=".$tokenid;
          $res2=$this->db->query($q2);
          //echo $this->db->last_query();die;
          $token=$res2->result_array()[0]['token'];
        
          return $token;
        }
        else
        {
          return 0;
        }
        //echo $this->db->last_query();die; 

        
      }

      public function updateRecurringDeclined($row_Id,$invoice_no,$response)
      {
        if($response['cc_type']=='mc') {
              $card_a_type ='MasterCard';
          } else {
              $card_a_type =ucfirst($response['cc_type']);
          }

        $q1="update customer_payment_request set status='declined',message='".$response['responsetext']."',auth_code='".$response['authcode']."',transaction_id='".$response['transactionid']."',card_no='".$response['cc_number']."',card_type='".$card_a_type."'  where invoice_no='".$invoice_no."' and id='".$row_Id."'";
          $this->db->query($q1);
          // echo $this->db->last_query();die; 
      }
      public function updateRecurringCount($row_Id,$invoice_no,$response)
      {
        if($response['cc_type']=='mc') {
              $card_a_type ='MasterCard';
          } else {
              $card_a_type =ucfirst($response['cc_type']);
          }

        $r_count=$this->db->query("SELECT recurring_count from customer_payment_request where invoice_no='".$invoice_no."' and id='".$row_Id."'")->result_array();
        
        $recurringcount= $r_count[0]['recurring_count'];
        
        if($recurringcount!=-1){
          $q1="update customer_payment_request set status='confirm',message='".$response['responsetext']."',auth_code='".$response['authcode']."',transaction_id=".$response['transactionid'].",card_no='".$response['cc_number']."',card_type='".$card_a_type."', recurring_count_paid=recurring_count_paid+1,recurring_count_remain=recurring_count_remain-1,payment_date=curdate() where invoice_no='".$invoice_no."' and id='".$row_Id."'";
          $this->db->query($q1);
// echo $this->db->last_query();die; 
        }
        else{
          $q1="update customer_payment_request set status='confirm',message='".$response['responsetext']."',auth_code='".$response['authcode']."',transaction_id=".$response['transactionid'].",card_no='".$response['cc_number']."',card_type='".$card_a_type."', recurring_count_paid=recurring_count_paid+1,recurring_count_remain=1,payment_date=curdate() where invoice_no='".$invoice_no."' and id='".$row_Id."'";
          $this->db->query($q1);

        }
        // echo $this->db->last_query();die; 
      }
			
   } 
