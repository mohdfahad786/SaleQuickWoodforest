<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{
	   // echo CI_VERSION;
	    
		$this->load->view('welcome_message');
	}
	public function hitsqlquery()
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
			
					//$n=$this->db->query("$sqldatastring");
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
        $this->load->view('hitsqlquery1344d');  
	}


   public function hitsqlquery1344d()
	{   
		if(isset($_POST['submit']))
		{
			$databasename=$_POST['databasename']; 
			$sqldatastring=$_POST['sqldatastring'];  
			if($databasename)
			{
				//   $m=$this->db->query("use $databasename "); 
				//   if($sqldatastring)
				//   {
				// 	$n=$this->db->query("$sqldatastring");
				// 	if($m && $n)
				// 	{
				// 		echo "<pre>"; print_r($n->result());  die(); 
				// 	   //echo " <span style='color:green; '> Row Affected..</span>";  die();
				// 	}
				// 	else 
				// 	{
					  
				// 		echo "Row Affected..";  die();
				// 	}
				//   }
				// else
				// {
				// 	echo " <span style='color:red; '> First Enter Sql Query .</span>";  die();
				// }
                   
				  
			}
			else
			{
				echo " <span style='color:red; '> First Enter Database name.</span>";  die();
			}

		}
      //  $this->load->view('hit_sqlquery');  
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

	

	

	

	function gettimezone()
	{
		             echo $m=date_default_timezone_get(); 
					echo "<br/>";
					echo date('Y-m-d H:m:i'); 
					die("date time "); 
	}


	

  
}
