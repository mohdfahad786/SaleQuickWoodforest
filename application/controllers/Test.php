<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class  Test extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->model('Home_model');
        $this->load->model('Admin_model');
        $this->load->library('email');
         $this->load->library('email');
        $this->load->library('twilio');
        date_default_timezone_set("America/Chicago");
    }
    public function index(){
     
/*
This calls sends an email to one recipient.
*/
//require 'vendor/autoload.php';
//use Mailjet\Resources;
$mj = new \Mailjet\Client('645ac38ed31d83f991b75b335be725b3', '5bd5f9766ec98a79b6111a1464044acb',
              true,['version' => 'v3.1']);
$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "reply@salequick.com",
                'Name' => "donotreply"
            ],
            'To' => [
                [
                    'Email' => "vaibhav.angad@gmail.com",
                    'Name' => "vaibhav"
                ],
				
            ],
            'Subject' => "Your email flight plan!",
            'TextPart' => "Dear passenger 1, welcome to Mailjet! May the delivery force be with you!",
            'HTMLPart' => "<h3>Dear passenger 1, welcome to Mailjet!</h3><br />May the delivery force be with you!"
        ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);
$response->success() && var_dump($response->getData());

//print_r($response);
    }
 
}
