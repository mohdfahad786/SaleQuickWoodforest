<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Merchant | Dashboard</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.2 -->
<?php
    $this->load->view('merchant/header');
    ?>
 <link href="<?php echo base_url("assets2/css/styles.css"); ?>" rel="stylesheet" type="text/css" />
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <?php
    $this->load->view('merchant/menu');
    ?>
  <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">
    <div class="row">
        
       
        <div class="creditCardForm">
            <div class="heading">
                <h1> Card Payment </h1>
            </div>
            <div class="payment">
                <form >

                     <div class="form-group" id="card-number-field">
                        <label for="cardNumber">Amount</label>
                        <input type="text" class="form-control" id="cardNumber" name="amount" id="amount"  placeholder="Amount:" 
                required value="<?php echo  $amount ; ?>" readonly>
                    </div>

                    <div class="form-group owner">
                   
                        <label for="owner">Owner</label>
                      
                        <input type="text" class="form-control" id="owner">
                 
                    </div>
                    <div class="form-group CVV">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv">
                    </div>
                    <div class="form-group" id="card-number-field">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber">
                    </div>
                    <div class="form-group" id="expiration-date">
                        <label>Expiration Date</label>
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
                    </div>
                    <div class="form-group" id="credit_cards">
                        <img src="<?php echo base_url("") ?>assets2/images/visa.jpg" id="visa">
                        <img src="<?php echo base_url("") ?>assets2/images/mastercard.jpg" id="mastercard">
                        <img src="<?php echo base_url("") ?>assets2/images/amex.jpg" id="amex">
                    </div>
                   <!--  <div class="form-group" id="pay-now">
                        <button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
                    </div> -->

  <div class="box-footer clearfix">
              <input type="submit" id="btn_login" name="submit"  class="btn btn-success pull-right" value="Pay Now" />

         
        </div>


                </form>
            </div>
        </div>





    </div>
  </section>
  <!-- /.content -->
</div>
  <script>


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
<?php  $this->load->view('admin/footer'); ?>
 <script src="<?php echo base_url("assets2/js/jquery.payform.min.js"); ?>" charset="utf-8"></script> 
    <script src="<?php echo base_url("assets2/js/jQuery/script.js"); ?>"></script> 
</body></html>
