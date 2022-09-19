<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>:: Payment ::</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
<!-- Custom Css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/css/bootstrap.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("front/invoice/css/style.css"); ?>" />

</head>
<style>
  .custom-btn
{background-color: #0077e2 !important;
border-radius: 4px;
text-transform: uppercase;
padding: 10px 30px;

text-decoration: none;
float: right;
color: #fff;
-webkit-appearance: button;
-moz-appearance: button;
-ms-appearance: button;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
-ms-touch-action: manipulation;
touch-action: manipulation;
cursor: pointer;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
-ms-border-radius: 4px;
border: 0;
font-size:12px;}
.custom-btn:hover
{color: #fff;}
.invoice_box_header
{background-color: #fafafa;
padding: 20px 25px;border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;}
</style>

<body>
<div class="container-fluid">
  <div class="row">
    <div class="invoice">
      <div class="invoice_box">
        <div class=" invoice_box_header">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="invoice_logo"> <img src="https://salequick.com/logo/<?php echo $itemm[0]['logo']; ?>" alt="" class=""/> </div>
            <!--invoice_logo-->
            <div class="clearfix"></div>
            <div class="Recipient">
              <div class="Recipient1">Recipient</div>
              <div class="Recipient_Susan"><?php echo $branch[0]->name  ;?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="header_right">
              <div class="header_right_INVOICE1">INVOICE </div>
              <div class="header_right_INVOICE2">Invoice No.</div>
              <div class="header_right_INVOICE3"><?php echo $branch[0]->invoice_no  ;?></div>
              <div class="header_right_INVOICE4">INVOICE DATE</div>
              <div class="header_right_INVOICE5"><?php $originalDate = $branch[0]->date_c;
                            echo $newDate = date("F d, Y", strtotime($originalDate)); ?></div>
            </div>
            <!--header_right--> 
            
          </div>
          <div class=" clearfix"></div>
        </div>
       
        <div class=" invoice_box_mid">
           <form action="<?php echo base_url('Sandbox/payment_cnp');?>/<?php echo  $_POST['bct_id1'] ;?>/<?php echo  $_POST['bct_id2'] ;?>" method="post">
            <div class="form-group clearfix">
              <div class="col-xs-12 col-md-6">
                <label >First Name</label>
                <input type="text" class="form-control" name="name"  placeholder="" required>
                
                 <input type="hidden" class="form-control" name="invoice_no" value="<?php echo $branch[0]->invoice_no  ;?>"  required>
        <input type="hidden" class="form-control" name="amount" value="<?php echo number_format($branch[0]->amount,0)  ;?>"  required>
        
         <input type="hidden" class="form-control" name="bct_id" value="<?php echo $_POST['bct_id'] ;?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id1" value="<?php echo  $_POST['bct_id1'] ;?>" readonly required>
      <input type="hidden" class="form-control" name="bct_id2"  value="<?php echo  $_POST['bct_id2'] ;?>" readonly required>
              </div>
              <div class="col-xs-12 col-md-6">
                <label >Last Name</label>
                <input type="text" class="form-control"  placeholder="" name="l_name">
              </div>
            </div>
            <div class="form-group clearfix">
              <div class="col-xs-12 col-md-12">
                <label >Address</label>
                <input type="text" class="form-control"  placeholder="" name="address" value="" required>
              </div>
            </div>
            <div class="form-group clearfix">
              <div class="col-xs-12 col-md-6">
                <label >Country</label>
                <select class="form-control">
                  <option>USA</option>
                 
                </select>
              </div>
              <div class="col-xs-12 col-md-6">
                <label >City</label>
                <input type="text" class="form-control"  placeholder="" name="city" value=""   required>
              </div>
            </div>
            <div class="form-group clearfix">
              <div class="col-xs-12 col-md-6">
                <label >Postal Code</label>
                <input type="text" class="form-control" name="zip" value=""  required  placeholder="">
              </div>
              <div class="col-xs-12 col-md-6">
                <label >Phone</label>
                <input type="text" class="form-control"  placeholder="" name="phone" >
              </div>
            </div>
            
            <div class="form-group clearfix">
              <div class="col-xs-12 col-md-12">
                <label >Card Number</label>
                <input type="text" class="form-control CardNumber" name="card_no"  minlength="14" maxlength="16"  onKeyPress="return isNumberKey(event)" value="" required  placeholder="">
              </div>
            </div>
            
            <div class="form-group clearfix">
              <div class="col-xs-12 col-md-6">
                <label >Name on Card</label>
                <input type="text" class="form-control"   name="name_card" required>
              </div>
              <!--<div class="col-xs-12 col-md-4">-->
              <!--  <label style="display: block;">Expiry Date</label>-->
              <!--  <input style="display:inline-block;float:left;width:100%;-webkit-appearance:textfield;-moz-appearance:textfield;-o-appearance:textfield;-ms-appearance:textfield;" type="date" class="form-control"   name="exp_month" id="exp_month" required>-->
              <!--</div>-->
              
               <div class="col-xs-6 col-md-2">
                <label style="display: block;">Expiry Month</label>
               <select class="form-control" name="exp_month" id="exp_month" required="">
                                    <option value="">Select Month</option>
                                    <option value="01">Jan (01)</option>
                                    <option value="02">Feb (02)</option>
                                    <option value="03">Mar (03)</option>
                                    <option value="04">Apr (04)</option>
                                    <option value="05">May (05)</option>
                                    <option value="06">June (06)</option>
                                    <option value="07">July (07)</option>
                                    <option value="08">Aug (08)</option>
                                    <option value="09">Sep (09)</option>
                                    <option value="10">Oct (10)</option>
                                    1
                                    <option value="11">Nov (11)</option>
                                    <option value="12">Dec (12)</option>
                                 </select>
              </div>
              
               <div class="col-xs-6 col-md-2">
                <label style="display: block;">Expiry Year</label>
<select class="form-control" name="exp_year" required="">
                                    <option value="">Select year</option>
                                    
                                    <option value="19">2019</option>
                                    <option value="20">2020</option>
                                    <option value="21">2021</option>
                                    <option value="22">2022</option>
                                    <option value="23">2023</option>
                                    <option value="24">2024</option>
                                    <option value="25">2025</option>
                                    <option value="26">2026</option>
                                    <option value="27">2027</option>
                                    <option value="28">2028</option>
                                    <option value="29">2029</option>
                                    <option value="30">2030</option>
                                 </select>              </div>
              
              
              <div class="col-xs-12 col-md-2">
                <label >Cvv Code</label>
                <input type="text" style="position: relative;cursor: pointer;width: 100%;display: inline-block" class="form-control Cvv"  placeholder="" name="card_validation_num" value="" onKeyPress="return isNumberKey(event)"   required>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="BacktoInvoice_box">
            <div class="col-xs-6 col-sm-6 col-res-12 col-md-6"> <a href="#" onclick="goBack()" class="BacktoInvoice"><img src="<?php echo base_url("front/invoice/img"); ?>/arow.jpg"/> &nbsp; Back to Invoice</a></div>
            <div class="col-xs-6 col-sm-6 col-res-12 col-md-6">
             <input  type="submit" class=" btn custom-btn" name="submit"  value="COMPLETE PAYMENT">
            </div>
            <div class="clearfix"></div>
            </div>
            
          


          </form>
          <div class="clearfix"></div>
        </div>
      </div>
      <!--invoice_box--> 
    </div>
  </div>

  <div class="row">
    <div class="foot_wrp">
    <div>
    <div class="col-md-4 col-sm-12">
    <div class="foot_wrp_Adr">
      <span style="font-weight: 600"><?php echo $itemm[0]['business_dba_name']   ;?></span><br />
      <span style="color: #666;"><?php echo $itemm[0]['address1']   ;?></span></div>
    </div>
    <div class="col-md-4 col-sm-12">
    <div class=" invoice_box_foot"><a href="https://salequick.com/terms_and_condition">Terms </a>& <a href="https://salequick.com/privacy_policy">Privacy policy</a> | <span class="Powered_by">Powered by SaleQuick.com</span></div>
    </div>
    <div class="col-md-4 col-sm-12">
    <div class="foot_icon">
    <ul>
    <li><a href="#"><img src="<?php echo base_url("front/invoice/img"); ?>/foot_icon1.jpg" alt="" class="" /></a></li>
   <li><a href="#"><img src="<?php echo base_url("front/invoice/img"); ?>/foot_icon2.jpg" alt="" class="" /></a></li>
    <li><a href="#"><img src="<?php echo base_url("front/invoice/img"); ?>/foot_icon3.jpg" alt="" class="" /></a></li>
     <li><a href="#"><img src="<?php echo base_url("front/invoice/img"); ?>/foot_icon4.jpg" alt="" class="" /></a></li>
    
    </ul>
    </div>
    
    
    </div>
    <div class="clearfix"></div>
    
    </div>
    </div><!--foot_wrp-->
    
    
     
  </div>
  <!--row--> 
</div>
<!--container--> 
<script>
function goBack() {
  window.history.back();
}
</script>
<script>





function isNumberKey(evt){

    var charCode = (evt.which) ? evt.which : event.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;

    return true;

}

</script>
<!-- j Query --> 
<script type="text/javascript" src="<?php echo base_url("front/invoice/js"); ?>/jquery-2.1.4.js"></script> 

<!-- Bootstrap JS --> 
<script type="text/javascript" src="<?php echo base_url("front/invoice/js"); ?>/bootstrap.min.js"></script>
</body>
</html>
