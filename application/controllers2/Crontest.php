<?php 
	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}
	class Crontest extends CI_Controller {
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

public function mail_test() {

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
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">vaibhav</td>
					</tr>
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Email
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">vaibhav.angad@gmail.com</td>
					</tr>
					<tr >
						<th style="color: #535963;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;">
							Phone
						</th>
						<td style="color: #7e8899;text-transform: uppercase;font-weight: 500;border: 0px;text-align: left;border-bottom: 1px solid #eaeaea;padding: 7px;color: #444;text-align: right;">33333</td>
					</tr>
				</table>
				</div>
				<div style="padding: 25px 0;overflow:hidden;">
				<div style="width: 100%;margin:0 auto;overflow:hidden;max-width: 80%;">
				<div style="width: 100%;margin:10px auto 20px;text-align:center;">
				<p style="line-height: 1.432;">
				<span style="display: block;margin-bottom: 11px;font-weight: 600;color: #3c763d !important;">Verify Email</span>
				<a href="url" style="max-height: 40px;padding: 10px 20px;display: inline-flex;justify-content: center;align-items: center;font-size: 0.875rem;font-weight: 600;letter-spacing: 0.03rem;color: #fff;background-color: #696ffb;text-decoration: none;border-radius: 20px;">Click Here</a>
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
                $config['mailtype'] = 'html';
				$this->email->initialize($config);
				$MailSubject = 'Salequick Registration Confirmation ';
				$this->email->from('info@salequick.com', 'Confirm Email');
				$this->email->to('vaibhav.angad@gmail.com');
				$this->email->subject('Mail Test');
				$this->email->message($htmlContent);
				$this->email->send();

	}

}