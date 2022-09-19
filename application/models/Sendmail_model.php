<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SendMail_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->library('My_PHPMailer');
    }
    function send_mail2($sender_email, $username, $receiver_email, $subject, $msg) {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth = true; // enabled SMTP authentication
        $mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
        $mail->Host = "linux3.gipcloudlinux.com";      // mail.salequick.com setting GMail as our SMTP server
        $mail->Port = 25;                   //25 SMTP port to connect to GMail
        $mail->Username = "no-reply@salequick.com";  // user email address
        $mail->Password = "Augurs@009";            // password in GMail       
        $mail->SetFrom($sender_email, 'no-reply@salequick.com');  //Who is sending the email	
        $mail->AddReplyTo($sender_email, 'info@salequick.com');  //email address that receives the response
        $body = $msg;
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->AltBody = "Plain text message";
        // echo "hellob $receiver_email";
        // die;
        $emails = explode(",", $receiver_email);

        foreach ($emails as $key => $value) {
            $mail->AddAddress(trim($value));
        }
        // $mail->AddAddress($receiver_email, $username);
        //$mail->addbCC('vaibhav.angad@gmail.com');
        if (!$mail->Send()) {
            echo "Error: " . $mail->ErrorInfo;
            die;
        } else {
            return TRUE;
        }
    }
}