<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>

<!-- Start Page Content -->
<div id="wrapper"> 
  <div class="page-wrapper api-detail-page"> 
    <div class="row">
      <div class="col-12">
        <div class="back-title m-title">
            <span>Api Detail</span>
        </div>
      </div>
      <div class="col-6 custom-form">
        <div class="card content-card">
          <div class="card-title">
            Attributes
          </div>
          <div class="card-detail">
            <div class="row">
              <div class="col-4">
                <label>name (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  First Name (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>l_name (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Last Name (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>mobile_no (<small>Integer</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Mobile No (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>email_id  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Email Id (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>amount  (<small>Integer</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Amount (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>tax  (<small>Integer</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Tax (Optional)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>invoice_no  (<small>Integer</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Invoice No (Required And Generate Unique)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>city  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  City (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>state  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  State (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>country  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Country (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>zipcode  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Zip Code (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>address   (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Street Address (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>op1   (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Optional Data1 If You Want To Add Any Extra Field (Optional)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>op2   (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Optional Data2 If You Want To Add Any Extra Field (Optional)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Auth Key  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Auth Key Provided By Gateway (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>merchant_key  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Merchant Key Provided By Gateway (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Type   (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Card Type (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>cNum   (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Card Number (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>cvv  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Cvv Number (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>expiry_month  (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Expiry Month (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>expiry_year (<small>String</small>)</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  Expiry Year (Required)
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Download Kit </label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  <a href="https://salequick.com/file.zip">Download</a> 
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 custom-form">
        <div class="card content-card">
          <div class="card-title">
            Result In Json
          </div>
          <div class="card-detail">
            <div class="row">
              <div class="col-12">
<pre style="background-color: rgba(0, 42, 97, 0.8);font-size: 20px; color: white">
{
  "errorCode":0,
  "message":"SUCCESS",
  "result":
  {  
    "name":"shuaeb",
    "amount":"200",
    "invoice_no":"fsr453443tre",
    "email_id":"shuaebahmad15@gmail.com",
    "mobile_no":"9919692700",
    "payment_id":"PY20180117110106"
  }
}  
</pre>
              </div>
            </div>
          </div>
          <div class="card-title">
            Sample Payment Form
          </div>
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
              $url = "https://www.gateway.anmolenterprises.org/api/product/create.php";
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
              return $content;
            }
          ?>
          <div class="card-detail">
            <div class="row">
              <div class="col-12">
                <form action="#" method="post">
                  <div class="row reset-col-p">
                    <div class="col">
                      <div class="form-group">
                        <select name="type" class="form-control">
                          <option value="American">American Express</option>
                          <option value="Dinners">Diner's Club</option>
                          <option value="Discover">Discover</option>
                          <option value="Master">Master Card</option>
                          <option value="Visa">Visa</option>
                        </select>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <input type="text" name="cNum" class="form-control" placeholder="Card No" required>
                      </div>
                    </div>
                  </div>
                  <!--  -->
                  <div class="row reset-col-p">
                    <div class="col-3">
                      <div class="form-group">
                        <input type="text" name="cvv" class="form-control" placeholder="CVV" required>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <select class="form-control">
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
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <select class="form-control">
                          <option value="16"> 2016</option>
                          <option value="17"> 2017</option>
                          <option value="18"> 2018</option>
                          <option value="19"> 2019</option>
                          <option value="20"> 2020</option>
                          <option value="21"> 2021</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!--  -->
                  <div class="row reset-col-p">
                    <div class="col">
                      <div class="form-group">
                        <input type="text" name="name" value="" class="form-control" placeholder="First Name" required>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <input type="text" name="l_name" value="" class="form-control" placeholder="Last Name" required>
                      </div>
                    </div>
                  </div>
                  <div class="invoice-form-all-f-col row">
                    <div class="form-group col-12">
                      <input type="text" name="email_id" value="" class="form-control" placeholder="Email id" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="mobile_no" value="" class="form-control" placeholder="Mobile no" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="amount" value="" class="form-control" placeholder="Amount" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="tax" value="" class="form-control" placeholder="Tax" >
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="invoice_no" value="" class="form-control" placeholder="Invoice No" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="city" value="" class="form-control" placeholder="City Name" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="state" value="" class="form-control" placeholder="State Name" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="country" value="" class="form-control" placeholder="Country Name" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="zipcode" value="" class="form-control" placeholder="Zip Code" >
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="address" value="" class="form-control" placeholder="Street Address" required>
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="op1" class="form-control" value="" placeholder="optional 1" >
                    </div>
                    <div class="form-group col-12">
                      <input type="text" name="op2" class="form-control" value="" placeholder="optional 2" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-12">
                      <button type="submit" class="btn btn-first">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="card-title">
            Some sample card number
          </div>
          <div class="card-detail">
            <div class="row">
              <div class="col-4">
                <label>American Express:</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  340000000000009
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Discover:</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  6011000000000004
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Diners Club:</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  38520000023237
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>MasterCard:</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  5500000000000004
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Visa:</label>
              </div>
              <div class="col">
                <p class="form-control-static">
                  4111111111111111
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Page Content -->

<?php
include_once'footer_new.php';
?>