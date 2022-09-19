<?php 

function CCValidate($type, $cNum) {
    switch ($type) {
    case "American":
        $pattern = "/^([34|37]{2})([0-9]{13})$/";//American Express
        return (preg_match($pattern,$cNum)) ? true : false; 
        break;
    case "Dinners":
        $pattern = "/^([30|36|38]{2})([0-9]{12})$/";//Diner's Club
        return (preg_match($pattern,$cNum)) ? true : false;
        break;
    case "Discover":
        $pattern = "/^([6011]{4})([0-9]{12})$/";//Discover Card
        return (preg_match($pattern,$cNum)) ? true : false;
        break;
    case "Master":
        $pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
        return (preg_match($pattern,$cNum)) ? true : false;
        break;
    case "Visa":
        $pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
        return (preg_match($pattern,$cNum)) ? true : false; 
        break;               
   }
} 
?>

<!DOCTYPE html>
<html>
<head>
<title>Credit card validation script in PHP</title>
</head>
<body>
<?php
  if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    echo (CCValidate($_REQUEST['type'], $_REQUEST['cNum'])) ? "<h3>Credit Card Valid.</h3>" : "<h3>Credit Card Invalid, Please check again..!!</h3>";




    
            $request ="";
            $param['merchant_key'] = 'GT20171116021141';
            $param['auth_key'] = 'SL_20171209121239';
            $param['name'] = $_POST['name'];
             $param['l_name'] = $_POST['l_name'];
            $param['email_id'] = $_POST['email_id'];
            $param['mobile_no'] = $_POST['mobile_no'];
            $param['amount'] = $_POST['amount'];
             $param['tax'] = $_POST['tax'];
             $param['invoice_no'] = $_POST['invoice_no'];
            $param['success_url'] = $_POST['success_url'];
            $param['fail_url'] = $_POST['fail_url'];
            $param['domain'] = $_SERVER['HTTP_HOST'];
            
            
             $param['city'] = $_POST['city'];
            $param['state'] = $_POST['state'];
            $param['country'] = $_POST['country'];
             $param['zipcode'] = $_POST['zipcode'];
            $param['address'] = $_POST['address'];
            $param['op1'] = $_POST['op1'];
            $param['op2'] = $_SERVER['op2'];
            

            $url = "https://salequick.com/api/product/create.php";


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch,CURLOPT_TIMEOUT,9000);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
            $content = curl_exec($ch);
            $content;


            $obj = json_decode($content,true);

            print_r($content); 
// echo $obj[result]['amount'];
            return $content;
          // echo $content['message'];
        
         //$obj[request]['number'];
        // $obj[request]['request_id'];
       //$this->load->view('header');
      //$this->load->view('index',$res);

  }
?>
<form action="" method="post">
<select name="type">
<option value="American">American Express</option>
<option value="Dinners">Diner's Club</option>
<option value="Discover">Discover</option>
<option value="Master">Master Card</option>
<option value="Visa">Visa</option>
</select>
<input type="text" name="cNum" placeholder="Card No" required="">

<input type="text" name="cvv" placeholder="CVV" required="">

 <select>
                            <option value="01">January</option>
                            <option value="02">February </option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
<select>
                            <option value="16"> 2016</option>
                            <option value="17"> 2017</option>
                            <option value="18"> 2018</option>
                            <option value="19"> 2019</option>
                            <option value="20"> 2020</option>
                            <option value="21"> 2021</option>
                        </select>
<br/>
<br/>
<input type="text" name="name" value="" placeholder="First Name" required="">
<br/><br/>
<input type="text" name="l_name" value="" placeholder="Last Name" required="">
<br/><br/>
<input type="text" name="email_id" value="" placeholder="Email id" required="">
<br/><br/>
<input type="text" name="mobile_no" value="" placeholder="Mobile no" required="">

<br/><br/>
<input type="text" name="amount" value="" placeholder="Amount" required="">

<br/><br/>
<input type="text" name="tax" value="" placeholder="Tax" >


<br/><br/>
<input type="text" name="invoice_no" value="" placeholder="Invoice No" required="">

<br/><br/>
<input type="text" name="city" value="" placeholder="City Name" required="">

<br/><br/>
<input type="text" name="state" value="" placeholder="State Name" required="">

<br/><br/>
<input type="text" name="country" value="" placeholder="Country Name" required="">

<br/><br/>
<input type="text" name="zipcode" value="" placeholder="Zip Code" >

<br/><br/>
<input type="text" name="address" value="" placeholder="Street Address" required="">


<br/><br/>
<input type="text" name="op1" value=""  >

<br/><br/>
<input type="text" name="op2" value="" >

<!-- <br/><br/>
<input type="text" name="success_url" value="xyz.com" placeholder="Success url" required="">

<br/><br/>
<input type="text" name="fail_url" value="xyz.com" placeholder="Fail Url" required="">

<br/><br/>
<input type="text" name="domain" value="<?php echo $_SERVER['HTTP_HOST'] ?>" placeholder="Domain"> -->




<br/><br/>
<button type="submit">Submit</button>
</form>
<br/>
<br/>
 <h3>Some sample card number</h3>
<b>American Express:</b>    340000000000009<br/>
<b>Discover:</b>    6011000000000004<br/>
<b>Diners Club:</b> 38520000023237<br/>
<b>MasterCard:</b>  5500000000000004<br/>
<b>Visa:</b>    4111111111111111 
</body>
</html>

