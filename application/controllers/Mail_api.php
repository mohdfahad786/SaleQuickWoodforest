<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . 'third_party/REST_Controller.php';
//require APPPATH . 'third_party/Format.php';
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';
//use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type,      Accept");
header("Content-Type: application/json");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
class Mail_api extends REST_Controller {
    public function __construct() {
        parent::__construct();
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
        $this->load->model('login_model');
        $this->load->model('Home_model');
        $this->load->model('profile_model');
		$this->load->model('admin_model');
		$this->load->library('email');
        $this->load->library('twilio');
        date_default_timezone_set("America/Chicago");
    }
    
private function verify_request()
{
    // Get all the headers
    $headers = $this->input->request_headers();
    
    //print_r($headers); die();
    // Extract the token
    //$token = $headers['Authorization'];
     $token = $headers['X-Requested-With'];
    
    // Use try-catch
    // JWT library throws exception if the token is not valid
    try {
        // Validate the token
        // Successfull validation will return the decoded user data else returns false
        $data = AUTHORIZATION::validateToken($token);
        if ($data === false) {
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
            $this->response($response, $status);
            exit();
        } else {
            return $data;
        }
    } catch (Exception $e) {
        // Token is invalid
        // Send the unathorized access message
        $status = parent::HTTP_UNAUTHORIZED;
        $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
        $this->response($response, $status);
    }
}
public function add_pos_mail_post()
{
    // Call the verification method and store the return value in the variable
    $data = array();
    $data = $this->verify_request();
    // print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id = $data->merchant_id)
    {
			if (isset($_POST['posType']) && $_POST['posType'] === "ADVPOS") {
				$merchant_id = $_POST['merchant_id'];
				$payment_id = $_POST['payment_id'];
				$sid = $_POST['id'];
				$type = $_POST['type'];
				//$merchant_id_e = 11;
				$merchant_id_e = 13;
				$merchant_id_ee = 8;
				if (isset($_POST['split_invoice_no']) && !empty($_POST['split_invoice_no'])) {
					$stmt = $this->db->query("SELECT otherChargesName,other_charges,transaction_id,card_type,mobile_no,invoice_no,amount,tax,fee,tip_amount,discount,total_amount,full_amount,transaction_type,date_c,sign,reference,card_no,transaction_status,name FROM pos WHERE invoice_no = '".$_POST['split_invoice_no']."' ");
					
				} else {
					$stmt = $this->db->query("SELECT otherChargesName,other_charges,transaction_id,card_type,mobile_no,invoice_no,amount,tax,fee,tip_amount,discount,total_amount,full_amount,transaction_type,date_c,sign,reference,card_no,transaction_status,name FROM pos WHERE id = '".$_POST['payment_id']."' ");
					
				}
				$splitView = "";
				$package_data = $stmt->result_array();
				$mem = array();
				if ($stmt->num_rows() > 1) {
					$splitView = '<table width="100%" border="0" style="border-collapse:collapse;border:0px"><tr><td>Transaction ID</td><td>Amount</td><td>Card Type</td><td>Card No</td></tr>';
					$splitDetails = array();
					$amount = 0;
					foreach ($package_data as $each) {
						$amount1 = $each['amount'];
						$invoice_no = $each['invoice_no'];
						$package['split_amount'] = $split_amount = number_format($amount1, 2);
						$amount = $amount1 + $amount;
						$other_charges=$each['other_charges'];
						$otherChargesName=$each['otherChargesName'];
						if($otherChargesName=='')
						{
						    $otherChargesName ='Other Charges';
						}
						else
						{
						  $otherChargesName = $otherChargesName;  
						}
						$discount=$each['discount'];
						$total_amount = $each['total_amount'];
						$full_amount=$each['full_amount'];
						$transaction_type = $each['transaction_type'];
						$tax = number_format($each['tax'], 2);
						$fee = number_format($each['fee'], 2);
						$tip_amount = number_format($each['tip_amount'], 2);
						$date_c = $each['date_c'];
						$sign = $each['sign'];
						$transaction_id = $each['transaction_id'];
						$card_type = $each['card_type'];
						$card_no = $each['card_no'];
						$mobile_no = $each['mobile_no'];
						$transaction_status = $each['transaction_status'];
						$nameR = $_POST['recipient_name'] ? $_POST["recipient_name"] : $each['name'];
						$c_name = (isset($_POST['receipt_type']) && $_POST['receipt_type'] == 1) ? $nameR : "";
						$cc_name = $c_name;
						$reference = $each['reference'];
						if ($referenc == '0') {$referenc = 'N/A';} else { $referenc = $referenc;}
						//array_push($splitDetails, $temp);
						$mem[] = $package;
						$cNo=(substr($card_no, -4)==0)?'':substr($card_no, -4);
						$splitView = $splitView . "<tr><td>" . $transaction_id . "</td><td>$" . number_format($split_amount, 2) . "</td><td>" . $card_type . "</td><td>" . $cNo . "</td></tr>";
					}
					$splitView = $splitView . "</table>";
					$amount = $amount;
					$splitDetails = $mem;
				} else {
					
					$getDashboardData = $stmt->result_array();
                    $invoice_no = $getDashboardData[0]['invoice_no'];
                    $amount1 = $getDashboardData[0]['amount'];
					$amount = number_format($amount1, 2);
					
					$other_charges=$getDashboardData[0]['other_charges'];
					$otherChargesName=$getDashboardData[0]['otherChargesName'];
					if($otherChargesName=='')
					{
					    $otherChargesName ='Other Charges';
					}
					else
					{
					  $otherChargesName = $otherChargesName;  
					}
					$discount=$getDashboardData[0]['discount'];
						
					$transaction_type = $getDashboardData[0]['transaction_type'];
					$tax = number_format($getDashboardData[0]['tax'], 2);
					$fee = number_format($getDashboardData[0]['fee'], 2);
					$tip_amount = number_format($getDashboardData[0]['tip_amount'], 2);
					$full_amount=$getDashboardData[0]['full_amount'];
					$date_c = $getDashboardData[0]['date_c'];
					$sign = $getDashboardData[0]['sign'];
					$transaction_id = $getDashboardData[0]['transaction_id'];
					$card_type = $getDashboardData[0]['card_type'];
					$mobile_no = $getDashboardData[0]['mobile_no'];
					$transaction_status = $getDashboardData[0]['transaction_status'];
					$nameR = $_POST['recipient_name'] ? $_POST["recipient_name"] : $getDashboardData[0]['name'];
					$c_name = (isset($_POST['receipt_type']) && $_POST['receipt_type'] == 1) ? $nameR : "";
					$cc_name = $c_name;
					$reference = $getDashboardData[0]['reference'];
					if ($referenc == '0') {$referenc = 'N/A';} else { $referenc = $referenc;}
					$card_no = $getDashboardData[0]['card_no'];
					$card_no_1 = substr($card_no, -4);
				}
				//$signn = 'https://salequick.com/logo/'.$sign;
				// $p_date = date('F j, Y',strtotime($date_c));
				$p_date = date('F d, Y', strtotime($date_c));
				$mob = str_replace(array('(', ')', '-', ' '), '', $mobile_no);
				$mobile = '+1' . $mob;
				$url = 'https://salequick.com/adv_pos_reciept/' . $invoice_no . '/' . $merchant_id;
				$stmt1 = $this->db->query("SELECT logo,name,business_dba_name,email,mob_no,address1,color FROM merchant WHERE id ='".$merchant_id."' ");
                $getDetail = $stmt1->result_array();
                $logo = $getDetail[0]['logo'];
                $name = $getDetail[0]['name'];
                $business_dba_name = $getDetail[0]['business_dba_name'];
                $email_id = $getDetail[0]['email'];
                $color = $getDetail[0]['color'];
                $mob_no = $getDetail[0]['mob_no'];
                $address1 = $getDetail[0]['address1'];
               
				if ($type == 'email') {
					try {
						$merchant_id_e = ($transaction_type == 'split') ? 12 : $merchant_id_e;
						if ($transaction_type == 'split') {
							$stmt = $this->db->query("UPDATE  pos set name='".$c_name."', email_id ='".$sid."', receipt_type=IFNULL (CONCAT( receipt_type ,',', 'email'), 'email') where invoice_no ='".$_POST['split_invoice_no']."' ");
							
						} else {
							$stmt = $this->db->query("UPDATE  pos set name='".$c_name."', email_id ='".$sid."', receipt_type=IFNULL (CONCAT( receipt_type ,',', 'email'), 'email') where id ='".$payment_id."' ");
							
						}
					
						if ($invoice_no != '') {
							$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_e."' ");
					
							$getTemplate = $stmt5->result_array();
                            $templete = $getTemplate[0]['templete'];
							$tamount1 = !empty($full_amount)?$full_amount:$amount;//$total_amount - $tax - $tip_amount;
							$tamount = number_format($tamount1, 2);
							//if($reference!='0'){
							$token = array(
								'USER_NAME' => $name,
								'C_NAME' => $c_name,
								'NAME' => $c_name,
								'PHONE' => $mob_no,
								'EMAIL' => $email_id,
								'AMOUNT' => $amount,
								'LOGO' => $logo,
								'COLOR' => $color,
								'TAX' => $tax,
								'TIP_AMOUNT' => $tip_amount,
								'TAMOUNT' => $tamount,
								'INVOICE_NO' => $invoice_no,
								'PAYMENT_DATE' => $p_date,
								'SIGN' => $sign,
								'TRANSACTION_ID' => $transaction_id,
								'CARD_TYPE' => $card_type,
								'REFERENCE' => $reference,
								'CARD_LAST' => $card_no_1,
								'ADDRESS' => $address1,
								'BUSINESS_NAME' => $business_dba_name,
								'STATUS' => $transaction_status,
								'OTHER_CHARGES' => $other_charges,
								'OTHER_CHARGES_NAME' => $otherChargesName,
								
								
							);
							// 		echo $transaction_type;die;
							if ($transaction_type == 'split') {
								$stmt6 = $this->db->query("SELECT c.quantity,c.price,c.new_price,i.name,i.title  FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id  where c.status=2 and c.transaction_id='".$invoice_no."' ");
								
							} else {
								$stmt6 = $this->db->query("SELECT c.quantity,c.price,c.new_price,i.name,i.title FROM `adv_pos_cart_item` c join adv_pos_item i on c.item_id=i.id join pos p on c.transaction_id=p.transaction_id where c.status=2 and p.id='".$payment_id."' ");
								
							}
							$package_data_split = $stmt6->result_array();
							//$stmt6->bind_result($quantity, $price, $new_price, $name, $title);
							$recipt = '<table width="100%" border="0" style="border-collapse:collapse;border:0px"> <tbody><tr>
                                     <th style="text-align:right !important;color:#7e8899;text-transform:uppercase;font-weight:500;font-size:13px;border:0px">Name</th>
                                     <th style="text-align:right !important;color:#7e8899;text-transform:uppercase;font-weight:500;font-size:13px;border:0px">Qty</th>
                                     <th style="text-align:right !important;color:#7e8899;text-transform:uppercase;font-weight:500;font-size:13px;border:0px">Price</th>
                                     </tr>';
							$i = 1;
							$subTotal = 0;
							// 		print_r($stmt6);die;
							foreach ($package_data_split as $each) {
								$quantity=$each['quantity'];
								$price=$each['price'];
								$new_price=$each['new_price']; 
								$name=$each['name'];
								$title=$each['title'];
											
						
								if (number_format(($new_price * $quantity), 2) == number_format($price, 2)) {
									$itemPrice = "$" . number_format($price, 2);
								} else {
									$itemPrice = "<del>$" . number_format(($new_price * $quantity), 2) . "</del> $" . number_format($price, 2);
								}
								$row = '<td style="line-height:50px;text-align:right !important;color:#000;font-size:13px;border-bottom:1px solid #cfcfcf;border:0px"> ' . $name . '(' . $title . ')  </td>
                                         <td style="line-height:50px;text-align:right !important;color:#000;font-size:13px;border-bottom:1px solid #cfcfcf;border:0px"> ' . $quantity . '  </td>
                                         <td style="line-height:50px;text-align:right !important;color:#000;font-size:13px;border-bottom:1px solid #cfcfcf;border:0px">' . $itemPrice . '  </td>';
								$recipt = $recipt . '<tr>' . $row . '</tr>';
								$i++;
								$subTotal = $subTotal + $price;
							}
							$end_table = '<tr>
                                         <td style="border-top:1px solid #ccc;text-align:right !important;border-bottom:0px solid #ccc"></td>
                                         <td style="border-top:1px solid #ccc;text-align:right !important;border-bottom:0px solid #ccc"></td>
                                         <td style="border-top:1px solid #ccc;text-align:right !important;border-bottom:0px solid #ccc"></td>
                                         </tr>
                                         </tbody></table>';
							$recipt = $recipt . $end_table;
							$token['SUBTOTAL_AMOUNT'] = number_format($subTotal, 2);
							//$newsubTotal=$subTotal -($tip+$tax+$other_charges);
							//$token['SUBTOTAL_AMOUNT'] = number_format($newsubTotal, 2);
				// 			$discountVal = $amount - ($tax + $total_amount + $tip_amount);
				
							$token['TAX_AMOUNT'] = number_format($tax, 2);
							$token['TIP_AMOUNT'] = number_format($tip_amount, 2);
							//$token['DISCOUNT'] = "$" . number_format($discountVal, 2);
							$token['DISCOUNT'] = "$" . number_format($discount, 2);
							$token['RECIPT_INVOICE'] = $recipt;
							$token['SPLIT_TRANSACTION_DETAIL'] = $splitView;
						} else {
							$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_ee."' ");
							$getTemplate = $stmt5->result_array();
                            $templete = $getTemplate[0]['templete'];
                         	$tamount1 = $amount - $tax;
							$tamount = number_format($tamount1, 2);
							$token = array(
								'USER_NAME' => $name,
								'PHONE' => $mob_no,
								'EMAIL' => $email_id,
								'AMOUNT' => $amount,
								'LOGO' => $logo,
								'TAX' => $tax,
								'TAMOUNT' => $tamount,
								'INVOICE_NO' => $invoice_no,
								'PAYMENT_DATE' => $p_date,
								'SIGN' => $sign,
							);
						}
						$pattern = '[%s]';
						foreach ($token as $key => $val) {
							$varMap[sprintf($pattern, $key)] = $val;
						}
						$htmlContent = strtr($templete, $varMap);
                        // echo $htmlContent;die;
						set_time_limit(3000);
					   $email = $sid;
					   $MailSubject = 'Receipt from ' . $business_dba_name;
					   $nameoFCustomer=$name ? $name : $email_id; 
					   $MailSubject2 = 'Receipt to ' .$nameoFCustomer;
					
					   if (!empty($email)) {
						   $this->email->from('info@salequick.com', $business_dba_name);
						   $this->email->to($email);
						   $this->email->subject($MailSubject);
						   $this->email->message($htmlContent);
						   $this->email->send();
					   }
						$message = 1;
					} catch (Exception $e) {
						
						$response = ['status' => '401', 'errorMsg' => 'Invalid Email'];
					}
				} else if ($type == 'sms') {
					try {
						$stmt = $this->db->query("UPDATE  pos set name='".$cc_name."', mobile_no ='".$sid."',receipt_type=IFNULL (CONCAT( receipt_type ,',', 'sms'), 'sms') where id ='".$payment_id."' ");
						
						$mob = str_replace(array('(', ')', '-', ' '), '', $sid);
						$mobile = '+1' . $mob;
						
                      $sms_message = trim(" 'Dear " .$cc_name. ", ".$business_dba_name ."' POS Invoice No'" . $invoice_no . "' Your Amount '" .$amount."'  "); 
					  $sms_message_1 = trim(" ' Payment date '" . $p_date . "' Transaction id '" . $transaction_id . "' Card type '".$card_type."' "); 
				
					//$sms_message = trim(" 'Dear'");
						$sms_message_2 = trim("Receipt from $business_dba_name: $url");
                         $from = '+18325324983'; //trial account twilio number
		                 $to = '+1' . $mob;
		                 //$response = $this->twilio->sms($from, $to, $sms_message);
		                 //$response_1 = $this->twilio->sms($from, $to, $sms_message_1);
		                 $response_2 = $this->twilio->sms($from, $to, $sms_message_2);
		                 
		                 //print_r($response_2); die();
		                 //print_r($response_1->HttpStatus);
		                 //print_r($response_2->TwilioRestResponse['ResponseXml']['SMSMessage']['Status'] );
		                 $status = parent::HTTP_OK;
		                 if($response_2->HttpStatus==400 || $response_2->HttpStatus==429 || $response_2->HttpStatus==503){
		                  $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 }
		                 // else if($response_1->HttpStatus==400 || $response_1->HttpStatus==429 || $response_1->HttpStatus==503){
		                 // $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 // }
		                 // else if($response->HttpStatus==400 || $response->HttpStatus==429 || $response->HttpStatus==503){
		                 //  $response = ['status' => $status,'successMsg' => 'Successfull'];
		                
		                 // }
		                 else
		                 {
		                
                        $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 }
		               
		                 
					} catch (Exception $e) {
						// $response['error'] = true;
						// $response['errorMsg'] = 'Invalid Number';
						$status = parent::HTTP_OK;
                        $response = ['status' => $status,'successMsg' => 'Successfull'];
					}
				} else {
			
					
					$stmt = $this->db->query("UPDATE  pos set name='". $nameR."', receipt_type = 'no-cepeipt' where id ='".$payment_id."' ");

					//$stmt = $this->db->query("UPDATE  pos set receipt_type = 'no-cepeipt' where id ='".$payment_id."' ");
				
					$message = 1;
				}
				if ($message) {
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status,'successMsg' => 'Successfull'];
				}
			} else {
				$merchant_id = $_POST['merchant_id'];
				$payment_id = $_POST['payment_id'];
				$sid = $_POST['id'];
				$type = $_POST['type'];
				$merchant_id_e = 2;
				$merchant_id_ee = 8;
				$stmt = $this->db->query("SELECT otherChargesName,other_charges,transaction_id,card_type,mobile_no,invoice_no,amount,tax,fee,tip_amount,date_c,sign,reference,card_no,transaction_status,name FROM pos WHERE id = '".$payment_id."' ");
				$getDetail = $stmt->result_array();
                $otherChargesName = $getDetail[0]['otherChargesName'];
				$invoice_no =  $getDetail[0]['invoice_no'];
				$amount = number_format($getDetail[0]['amount'], 2);
				$tax = number_format($getDetail[0]['tax'], 2);
				$fee = number_format($getDetail[0]['fee'], 2);
				$tip_amount = number_format($getDetail[0]['tip_amount'], 2);
				$date_c = $getDetail[0]['date_c'];
				$sign = $getDetail[0]['sign'];
				$other_charges=$getDetail[0]['other_charges'];
				
				if($otherChargesName=='')
				{
				    $otherChargesName ='Other Charges';
				}
				else
				{
				  $otherChargesName = $otherChargesName;  
				}
				$transaction_id = $getDetail[0]['transaction_id'];
				$card_type = $getDetail[0]['card_type'];
				$mobile_no = $getDetail[0]['mobile_no'];
				$transaction_status = $getDetail[0]['transaction_status'];
				$nameR = $_POST['recipient_name'] ? $_POST["recipient_name"] : $getDetail[0]['name'];
				$c_name = (isset($_POST['receipt_type']) && $_POST['receipt_type'] == 1) ? $nameR : "";
				$cc_name = $c_name;
				$reference = $getDetail[0]['reference'];
				if ($referenc == '0') {$referenc = 'N/A';} else { $referenc = $referenc;}
				$card_no = $getDetail[0]['card_no'];
				$card_no_1 = substr($card_no, -4);
				//$signn = 'https://salequick.com/logo/'.$sign;
				// $p_date = date('F j, Y',strtotime($date_c));
				$p_date = date('F d, Y', strtotime($date_c));
				$mob = str_replace(array('(', ')', '-', ' '), '', $mobile_no);
				$mobile = '+1' . $mob;
				$url = 'https://salequick.com/pos_reciept/' . $invoice_no . '/' . $merchant_id;
				$stmt1 = $this->db->query("SELECT logo,name,business_dba_name,email,mob_no,address1,color FROM merchant WHERE id = '".$merchant_id."' ");
				
				$getDetail_personal = $stmt1->result_array();
                $logo = $getDetail_personal[0]['logo'];
                $name = $getDetail_personal[0]['name'];
                $business_dba_name = $getDetail_personal[0]['business_dba_name'];
                $email_id = $getDetail_personal[0]['email'];
                $color = $getDetail_personal[0]['color'];
                $mob_no = $getDetail_personal[0]['mob_no'];
                $address1 = $getDetail_personal[0]['address1'];
				if ($type == 'email') {
					try {
						$stmt = $this->db->query("UPDATE  pos set name='".$nameR."', email_id ='".$sid."', receipt_type=IFNULL (CONCAT( receipt_type ,',', 'email'), 'email') where id ='".$payment_id."' ");
						
						if ($transaction_id != '') {
							$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_e."' ");
							$getTemplate = $stmt5->result_array();
                            $templete = $getTemplate[0]['templete'];
							$tamount1 = $amount - $tax;
							$tamount = number_format($tamount1, 2);
							//if($reference!='0'){
							$token = array(
								'USER_NAME' => $name,
								'C_NAME' => $c_name,
								'NAME' => $c_name,
								'PHONE' => $mob_no,
								'EMAIL' => $email_id,
								'AMOUNT' => $amount,
								'LOGO' => $logo,
								'COLOR' => $color,
								'TAX' => $tax ? $tax : "0.00",
								'TIP_AMOUNT' => $tip_amount ? $tip_amount : "0.00",
								'TAMOUNT' => $tamount,
								'INVOICE_NO' => $invoice_no,
								'PAYMENT_DATE' => $p_date,
								'SIGN' => $sign,
								'TRANSACTION_ID' => $transaction_id,
								'CARD_TYPE' => $card_type,
								'REFERENCE' => $reference,
								'CARD_LAST' => $card_no_1,
								'ADDRESS' => $address1,
								'BUSINESS_NAME' => $business_dba_name,
								'STATUS' => $transaction_status,
								'OTHER_CHARGES' => $other_charges ? $other_charges : "0.00",
								'OTHER_CHARGES_NAME' => $otherChargesName,
								
							);
								$newsubTotal=$amount -($tip+$tax+$other_charges);
							$token['SUBTOTAL_AMOUNT'] = number_format($newsubTotal, 2);
							
						} else {
							$stmt5 = $this->db->query("SELECT templete FROM email_template WHERE id ='".$merchant_id_ee."' ");
							$getTemplate = $stmt5->result_array();
                            $templete = $getTemplate[0]['templete'];
							$tamount1 = $amount - $tax;
							$tamount = number_format($tamount1, 2);
							$token = array(
								'USER_NAME' => $name,
								'PHONE' => $mob_no,
								'EMAIL' => $email_id,
								'AMOUNT' => $amount,
								'LOGO' => $logo,
								'TAX' => $tax,
								'TAMOUNT' => $tamount,
								'INVOICE_NO' => $invoice_no,
								'PAYMENT_DATE' => $p_date,
								'SIGN' => $sign,
							);
							$token['TIP_AMOUNT'] = number_format($tip_amount, 2);
						}
						
						
						
                       // $token['TIP_AMOUNT'] = ($tip_amount==0 || $tip_amount==0.00 ) ? "":'<p style="line-height:26px;"><span class="left-div" style="width: 50%;display: inline-block;float: left;font-size: 14px;color: #353535;"> Tip :</span> <span class="right-div" style="width: 50%;display: inline-block;float: left;text-align: right;font-size: 14px;color: #353535;font-weight: 600;"> $'.$tip_amount.'</span></p>';
						$pattern = '[%s]';
						foreach ($token as $key => $val) {
							$varMap[sprintf($pattern, $key)] = $val;
						}
						$MailSubject = 'Payment  Receipt'; //text in the Subject field of the mail'
						$header = "From:Salequick<donotreply@salequick.co >\r\n" .
							"MIME-Version: 1.0" . "\r\n" .
							"Content-type: text/html; charset=UTF-8" . "\r\n";
						$htmlContent = strtr($templete, $varMap);
						
						set_time_limit(3000);
					   $email = $sid;
					   $MailSubject = 'Receipt from ' . $business_dba_name;
					   $nameoFCustomer=$name ? $name : $email_id; 
					   $MailSubject2 = 'Receipt to ' .$nameoFCustomer;
					
					   if (!empty($email)) {
						   $this->email->from('info@salequick.com', $business_dba_name);
						   $this->email->to($email);
						   $this->email->subject($MailSubject);
						   $this->email->message($htmlContent);
						   $this->email->send();
					   }
						$message = 1;
					} catch (Exception $e) {
					
						$response = ['status' => '401', 'errorMsg' => 'Invalid Email'];
					}
				} else if ($type == 'sms') {
					try {
						$stmt = $this->db->query("UPDATE  pos set name='".$nameR."', mobile_no ='".$sid."',receipt_type=IFNULL (CONCAT( receipt_type ,',', 'sms'), 'sms') where id ='".$payment_id."' ");
						
						$mob = str_replace(array('(', ')', '-', ' '), '', $sid);
						$mobile = '+1' . $mob;
						
					  $sms_message = trim(" '" . $business_dba_name . "' POS Invoice No '" . $invoice_no . "' Your Amount '" . $amount . "' "); 
					
					  //$sms_message = trim(" 'Dear " .$cc_name. ", ".$business_dba_name ."' POS Invoice No'" . $invoice_no . "' Your Amount '" .$amount."'  "); 
					  $sms_message_1 = trim(" Payment date '" . $p_date . "' Transaction id '" . $transaction_id . "' Card type '" . $card_type . "' "); 
				
					//$sms_message = trim(" 'Dear'");
						$sms_message_2 = trim("Receipt from $business_dba_name: $url");
                         $from = '+18325324983'; //trial account twilio number
		                 $to = '+1' . $mob;
		                 //$response = $this->twilio->sms($from, $to, $sms_message);
		                // $response_1 = $this->twilio->sms($from, $to, $sms_message_1);
		                 $response_2 = $this->twilio->sms($from, $to, $sms_message_2);
		                 
		                 //print_r($response_2); die();
		                 //print_r($response_1->HttpStatus);
		                 //print_r($response_2->TwilioRestResponse['ResponseXml']['SMSMessage']['Status'] );
		                 $status = parent::HTTP_OK;
		                 if($response_2->HttpStatus==400 || $response_2->HttpStatus==429 || $response_2->HttpStatus==503){
		                  $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 }
		                 // else if($response_1->HttpStatus==400 || $response_1->HttpStatus==429 || $response_1->HttpStatus==503){
		                 // $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 // }
		                 // else if($response->HttpStatus==400 || $response->HttpStatus==429 || $response->HttpStatus==503){
		                 //  $response = ['status' => $status,'successMsg' => 'Successfull'];
		                
		                 // }
		                 else
		                 {
		                
                        $response = ['status' => $status,'successMsg' => 'Successfull'];
		                 }
						
						
						
						
						
						
				//		 $sms_message = trim(" '" . $business_dba_name . "' POS Invoice No '" . $invoice_no . "' Your Amount '" . $amount . "' Payment date '" . $p_date . "' Transaction id '" . $transaction_id . "' Card type '" . $card_type . "' "); 
				// 		 $sms_message_1 = trim(" Payment  Receipt: $url");
    //                      $from = '+18325324983'; //trial account twilio number
		  //               $to = '+1' . $mob;
		  //               $response_1 = $this->twilio->sms($from, $to, $sms_message);
		  //               $response_2 = $this->twilio->sms($from, $to, $sms_message_1);
		                 
		  //               if($response_2->HttpStatus==400 || $response_2->HttpStatus==429 || $response_2->HttpStatus==503){
		  //               $response = ['status' => '400', 'errorMsg' => $response_2->ErrorMessage];
		  //               }else if($response_1->HttpStatus==400 || $response_1->HttpStatus==429 || $response_1->HttpStatus==503){
		  //               $response = ['status' => '400', 'errorMsg' => $response_1->ErrorMessage];
		  //               }
		  //               else
		  //               {
		  //              $status = parent::HTTP_OK;
    //                     $response = ['status' => $status,'successMsg' => 'Successfull'];
		  //               }
		                 
					} catch (Exception $e) {
						// $response['error'] = true;
						// $response['errorMsg'] = 'Invalid Number';
						$status = parent::HTTP_OK;
                        $response = ['status' => $status, 'successMsg' => 'Successfull'];
					}
				} else {
			$stmt = $this->db->query("UPDATE  pos set name='".$nameR."', receipt_type = 'no-cepeipt' where id ='".$payment_id."' ");
				
				//$stmt = $this->db->query("UPDATE  pos set receipt_type = 'no-cepeipt' where id ='".$payment_id."' ");
				
					$message = 1;
				}
				if ($message) {
					
					
					$status = parent::HTTP_OK;
                    $response = ['status' => $status, 'successMsg' => 'Successfull'];
				}
				
			}
	}
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }
    $this->response($response, $status);
}




public function add_simple_invoice_request_mail_post()
{
	$data = array();
    $data = $this->verify_request();
    //print_r($data->merchant_id);
    $merchant_id = $this->input->post('merchant_id');
    if($merchant_id == $data->merchant_id)
    {

			$payment_id = $_POST['payment_id'];
			$sid = $_POST['id'];
			$type = $_POST['type'];
			$merchant_id_e = 1;

			$stmt = $this->db->query("SELECT other_charges,otherChargesName,name,sub_total,invoice_no,amount,tax,fee,date_c,url,email_id,mobile_no,due_date,detail FROM customer_payment_request WHERE id ='".$payment_id."'");

			$getDetail = $stmt->result_array();
			$invoice_no = $getDetail[0]['invoice_no'];
			
			$other_charges = $getDetail[0]['other_charges'];
			$otherChargesName = $getDetail[0]['otherChargesName'];
			if($otherChargesName=='')
			{
			    $otherChargesName ='Other Charges';
			}
			else
			{
			  $otherChargesName = $otherChargesName;  
			}
			$amount = number_format($getDetail[0]['amount'], 2);
			$sub_total = number_format($getDetail[0]['sub_total'], 2);
			$tax = $getDetail[0]['tax'];
			$name1 = $getDetail[0]['name'];
			$detail = $getDetail[0]['detail'];
			$fee = $getDetail[0]['fee'];
			$date_c = $getDetail[0]['date_c'];
			$url = $getDetail[0]['url'];
			$email_id1 = $getDetail[0]['email_id'];
			$mobile_no = $getDetail[0]['mobile_no'];
			$due_date = $getDetail[0]['due_date'];

			$p_date = date('F j, Y', strtotime($date_c));
			$p_date1 = date('F d, Y', strtotime($date_c));

			$stmt1 =$this->db->query("SELECT logo,business_dba_name,name,email,business_number,address1,color FROM merchant WHERE id ='".$merchant_id."' ");
			
		
			$getCustDetail = $stmt1->result_array();
			$name = $getCustDetail[0]['name'];
			$logo = $getCustDetail[0]['logo'];
			$color = $getCustDetail[0]['color'];
			$email_id = $getCustDetail[0]['email'];
			$business_dba_name = $getCustDetail[0]['business_dba_name'];
			$mob_no = $getCustDetail[0]['business_number'];
			$address = $getCustDetail[0]['address1'];


			if ($type == 'email') {

				$stmt = $this->db->query("UPDATE  customer_payment_request set email_id ='".$sid."' where id = '".$payment_id."' ");
				

				$mail_body = '<!DOCTYPE html>
						<html>
						    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						        
						        <title>SalesQuick</title>
						        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
						         <style>
						        body {
						            font-family: Open Sans, sans-serif !important;
						            width: 100% !important;
						            height: 100% !important;
						        }

						        td,
						        th {
						            vertical-align: top !important;
						            text-align: left !important;
						        }

						        p {
						            font-size: 13px !important;
						            color: #878787 !important;
						            line-height: 28px !important;
						            margin: 4px 0px !important;
						        }

						        a {
						            text-decoration: none !important;
						        }

						        .main-box {
						            padding: 80px 0px 10px 0px !important;
						        }

						        .invoice-wrap {
						            margin-left: 14% !important;
						            width: 72% !important;
						            max-width: 72% !important;
						        }

						        .top-div {
						            padding: 20px 40px !important;
						        }

						        .float-left {
						            float: left !important;
						            width:auto !important;
						            text-align: left !important;
						        }

						        .float-right {
						            float: right !important;
						            width:auto !important;
						            text-align: right !important;
						        }

						        .bottom-div {
						            padding: 20px 40px !important;
						        }

						        .footer-wraper>div::after,
						        .footer-wraper>div::before,
						        .footer-wraper::after,
						        .footer-wraper:before {
						            display: table !important;
						            clear: both !important;
						            content: "" !important;
						        }

						        .footer_cards {
						            padding-right: 15px !important;
						        }

						        .footer-wraper>div>div {
						            margin-bottom: 11px !important;
						        }

						        .footer_address span:first-child {
						            font-weight: 600 !important;
						        }

						        @media screen and (max-width: 768px) {
						            .footer_address>span:first {
						                display: inline-block !important;
						                width: 100% !important;
						            }
						        }

						        @media only screen and (max-width:820px) {
						            .footer-wraper>div>div {
						                float: none !important;
						            }
						            .footer_address,
						            .footer_cards {
						                padding-right: 0px !important;
						                padding-left: 0px !important;
						            }
						            .footer_t_c {
						                padding-bottom: 7px !important;
						            }
						            .footer-wraper>div {
						                margin: 20px auto 0 !important;
						            }
						        }

						        @media only screen and (min-width:769px) and (max-width:900px) {
						            .invoice-wrap {
						                margin-left: 10% !important;
						                width: 80% !important;
						                max-width: 80% !important;
						            }
						            .main-box {
						                padding: 50px 0px !important;
						            }
						        }

						        @media only screen and (min-width:481px) and (max-width:768px) {
						            .invoice-wrap {
						                margin-left: 6% !important;
						                width: 88% !important;
						                max-width: 88% !important;
						            }
						            .main-box {
						                padding: 30px 0px !important;
						            }
						            .bottom-div {
						                padding: 20px 20px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }

						        @media only screen and (max-width:400px) {
						            .twenty-div {
						                word-wrap: break-word !important;
						            }
						        }

						        @media only screen and (max-width:375px) {
						            .twenty-div {
						                word-wrap: anywhere !important;
						            }
						        }

						        @media only screen and (max-width:480px) {
						            .fourty-div {

						                    width: 100% !important;

						                    float: right !important;

						                }

						                .sixty-div {

						                    width: 100% !important;

						                    text-align: center !important;

						                }
						            .float-right {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .float-left {
						                text-align: center !important;
						                width: 100% !important;
						            }
						            .invoice-wrap {
						                margin-left: 5% !important;
						                width: 90% !important;
						                max-width: 90% !important;
						            }
						            .bottom-div {
						                padding: 20px 10px !important;
						            }
						            .top-div {
						                padding: 20px 20px !important;
						            }
						        }
						         .sixty-div {

						                width: 60% !important;

						                float: left !important;

						                display: inline-block !important;

						            }

						            .fourty-div {

						                width: 40% !important;

						                float: right !important;

						                display: inline-block !important;

						            }
						    </style>
						    </head>
						   <body style="margin:0 auto;padding: 0;font-family: Open Sans, sans-serif;width: 100%;height: 100%;">

						    <div class="main-box" style="background-image: linear-gradient(#' . $color . ',#' . $color . ');padding: 80px 0px 10px 0px;background-repeat: no-repeat;width: 100%;height: 100%;display: inline-block;background-size: 100% 190px;">

						        <div class="invoice-wrap" style="width: 90%;margin: 0 auto;margin-left: 5%; display: inline-block;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">

						            <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background: #fafafa;display: inline-block;width: 100%;padding: 20px 20px;float: left;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;">

						                <div class="float-left" style="width:100%;display:inline-block;text-align:center;">

						                        <p><img src="https://salequick.com/logo/' . $logo . '" width="200px"></p>
						                            <h4 style="margin-bottom: 0px;color:#000; ">' . $business_dba_name . ' </h4>
						                            <!-- <p style="margin-top: 0px;">www.salequick.com</p> -->
						                            <p style="color: #878787; margin-top: 0px;">Telephone:' . $mob_no . '</p>
						                    </div>
						                    <div class="float-right" style="width:100%;display:inline-block;text-align:center;">
						                        <h3 style="text-transform: uppercase;margin-bottom: 0;color:#000;">Invoice</h3>
						                        <p style="margin-top: 0;line-height: 20px;color:#000">Customer Copy</p>
						                        <p style="line-height: 20px;margin-top: 10px">
						                            <span style="display: block;color:#000;text-transform:uppercase;">Invoice No.</span>
						                            <span style="display: block;color: #878787;">' . $invoice_no . '</span></p>
						                        <p style="line-height: 20px;margin-top: 10px"><span style="display: block;color:#000;text-transform:uppercase;">Invoice Date</span>
						                            <span style="display: block;color: #878787;">' . $p_date1 . '</span></p>
						                    </div>
						                </div>
						                 <div class="bottom-div twenty-div" style="display: inline-block;float: left;width: 100%;box-sizing: border-box;padding: 20px;">

						                   <table width="100%" border="0" style="border-collapse: collapse;border: 0px;">
						                        <tr>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;"> Name</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Phone</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Due date</th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;"></th>
						                            <th style="text-align:center;color: #7e8899;text-transform: uppercase;font-weight: 500;font-size: 13px;border: 0px;text-aliign:left;">Amount</th>

						                        </tr>


						 <tr>';

			

						$mail_body .= '  <tr>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                               ' . $name1 . '

                                            </td>
                                            
                                           
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">
                                                ' . $mobile_no . '

                                                </td>
                                            <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">' . $due_date . '</td>
                                             <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;"></td>
                                            
                                     <td style="line-height: 50px; text-align:center;color: #000;font-size: 13px;border-bottom: 1px solid #cfcfcf;border: 0px;">$' . $amount . '
                                            </td>
                                           
                                            
                                        </tr>'
                                        
                                        
                                        ;
                                        
                                        
                                        if($other_charges > 0){
				$mail_body .= '  
				
				<tr>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">'.$otherChargesName.'</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;">
                                <p style="color: #0077e2;border:0px;">$' . $other_charges . '</p>
                            </td>
                        </tr>';
      }
					

				$mail_body .= '  <tr>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="text-transform: uppercase;color:#7e8899;border:0px! important;">Total</p>
                            </td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;"></td>
                            <td style="border-top:1px solid #ccc;text-align:center;border-bottom:0px solid #ccc;">
                                <p style="color: #0077e2;border:0px;">$' . $amount . '</p>
                            </td>
                        </tr>
                    </table>
                    <div style="width: 100%;float: left;display: inline-block;margin-top: 30px;">

                        <a href="' . $url . '" class="custom-btn" style="background-color: #0077e2;border-radius: 4px;text-transform: uppercase;padding: 10px 30px;font-size: 13px;text-decoration: none;float: right;color: #fff;-webkit-appearance: button;-moz-appearance: button;-ms-appearance: button;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-moz-border-radius: 4px;-webkit-border-radius: 4px;-ms-border-radius: 4px;border: 0;">CONTINUE TO PAYMENT</a>

                    </div>
                </div>
            </div>
                <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">

                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 91px auto 0;display: block;">

                     <div class="footer_address" style="float: left;width:100%;display:inline-block; text-align:center; padding-left: 15px;">

                        <span style="display: block;font-weight:600;color:#000 ">' . $business_dba_name . '</span>
                        <span style="display: inline-block;color:#666">' . $address . '</span>
                    </div>
                    <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#666;">

                        <a style="text-decoration: none;color:#666;" href="https://salequick.com/terms_and_condition">Terms </a>& <a style="text-decoration: none;color:#666;" href="https://salequick.com/privacy_policy">Privacy policy</a>|
                        <a href="#" style="text-decoration: none;color:#0077e2 ">Powered by SaleQuick.com </a>
                    </div>
                    <div class="footer_cards" style="float: right;width:100%;display:inline-block;text-align:center;">

                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon1.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon2.jpg" ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon3.jpg"  ></a>
                        <a style="display: inline-block;vertical-align: top;margin-left: 7px; text-decoration: none;color:#666;" href="#"><img src="https://salequick.com/front/invoice/img/foot_icon4.jpg"  ></a>
                    </div>
                </div>
            </div>
        </div>
			    </body>
			</html>';
				
				set_time_limit(3000);


			   $email = $sid;
			   $MailSubject = 'Salequick Simple Invoice' . $business_dba_name;
			  
			
			   if (!empty($email)) {
				   $this->email->from('info@salequick.com', $business_dba_name);
				   $this->email->to($email);
				   $this->email->subject($MailSubject);
				   $this->email->message($mail_body);
				   $this->email->send();
			   }
				//$messagee->success() && var_dump($messagee->getData());
				$message = '1';

			} else if ($type == 'sms') {

				$stmt = $this->db->query("UPDATE  customer_payment_request set mobile_no ='".$sid."' where id ='".$payment_id."' ");

				$mob = str_replace(array('(', ')', '-', ' '), '', $sid);

				
				 //$sms_message = trim(" Hello '" . $name1 . "' . ('" . $business_dba_name . "') is requesting  payment from you.  ('" . $amount . "') $url "); 

// $sms_message = trim(' Receipt from '.$getEmail1[0]['business_dba_name'].' : '.$purl);
				 $sms_message = trim($business_dba_name.' is Requesting Payment : '.$url);
                 

				
                 $from = '+18325324983'; //trial account twilio number
                 $to = '+1' . $mob;
                 $response_1 = $this->twilio->sms($from, $to, $sms_message);
                 	//print_r($response_1); die();
				$message = '1';

			}

			if ($message) {

                $status = parent::HTTP_OK;
                $response = ['status' => $status, 'successMsg' => 'Successfull'];

			} else {
				
				$response = ['status' => '401', 'errorMsg' => 'Fail'];
			}
			
	}
    else
    {
        $response = ['status' => '401', 'errorMsg' => 'Unauthorized Access!'];
    }

    $this->response($response, $status);
}



}
	
