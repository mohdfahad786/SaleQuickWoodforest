<?php 
 
 require_once 'connect.php';
// require_once 'twilio-php-master/Twilio/autoload.php';
require 'mailjet/vendor/autoload.php';
use Mailjet\Resources;
use Twilio\Rest\Client;
 
 $response = array();
 
if($_SERVER['REQUEST_METHOD']=='POST'){

if(isset($_POST['email'])  ){
 
 $email = $_POST['email'];
 
 
 $stmt = $conn->prepare("SELECT id FROM merchant WHERE email = ? ");
 $stmt->bind_param("s",$email);
 
 $stmt->execute();
 
 $stmt->store_result();
 
 if($stmt->num_rows > 0){

 	$password1 = rand();
 
 

  $password = my_encrypt( $password1 , 'e' );




 $stmt = $conn->prepare("UPDATE merchant SET password = ? WHERE email = ?");
 $stmt->bind_param("ss", $password, $email);


if($stmt->execute())
{


 $MailSubject = 'Update Password'; //text in the Subject field of the mail'	
				 $header = "From: Salequick<info@salequick.com >\r\n".
						  "MIME-Version: 1.0" . "\r\n" .
						  "Content-type: text/html; charset=UTF-8" . "\r\n"; 

$mail_body = '<div style="border: 1px solid #e6e6e6; width:65%; background-color:#F4FFFF;"><div id="logo"> <spn class="punchline"></span></div>
				<div style="width:500px;padding:0 0 0 15px;">
				<p> <strong>Update Password</strong></p>
						
						<p>Password: <strong>'.$password1.'</strong></p>
						
					
						<hr color="#2362a3" size="1px" width="100%">
						<br /><br /><br />
				<font color="#2362a3"><em>Please do not reply to this e-mail as this a system generated notification.</em>
						<p><font size="1">Thank You<br>
						Web Services</font></p></font>
						</div></div>';
						
	//	$mail = mail($email, $MailSubject, $mail_body, $header);
		
	//	$MailSubject = 'Forgot Password';
				

				set_time_limit(3000);

				$mj = new Mailjet\Client('bd44f3f110259eb60f880abdc2de47e3', '571258666c3347fbf47fbf12850f00e7',
					true, ['version' => 'v3.1']);
				$body = [
					'Messages' => [
						[
							'From' => [
								'Email' => "info@salequick.com",
								'Name' => "Salequick",
							],
							'To' => [
								[
									'Email' => $email,
									'Name' => "",
								],
							],
							'Subject' => "Salequick Update Password",
							'TextPart' => "",
							'HTMLPart' => $mail_body,
						],
					],
				];

				$messagee = $mj->post(Resources::$Email, ['body' => $body]);
				//$messagee->success() && var_dump($messagee->getData());
				$message = '1';

$response['error'] = false;
$response['message'] = "Password updated successfully, new password sent to your email!";
}

else
{
$response['error'] = true;
$response['message'] = "Password not updated, something went wrong.";
}

 
  

 
 
 
 }
 else{
 $response['error'] = true; 
 $response['errorMsg'] = 'User Not Exists';
 }
 }
 else 
 {
 $response['error'] = true; 
 $response['errorMsg'] = 'Invalid Operation Called';
 }
 
 }
 else{
 $response['error'] = true; 
 $response['errorMsg'] = 'Invalid API Call';
 }
 
echo json_encode($response);
 
 //echo $json=json_encode(
// 'responseString' => $response['error'],
// array('UserData' => $response['UserDate'], 'successMsg' => $response['successMsg']));
 
