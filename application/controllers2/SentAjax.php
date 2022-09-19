<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class SentAjax extends CI_Controller {
	public function __construct() {
		parent::__construct();

	}



	public function SentReq()
	{    
		//echo 'hellooo';die;
		$data=array();
		$this->load->view('SentAjax',$data);   
	}


}

?>