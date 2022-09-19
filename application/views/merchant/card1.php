<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>
<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper edit-profile">  
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title "> 
            <span>Card Payment</span>
          </div>
        </div>
      </div>   
      <?php
        if(isset($msg))
          echo '<div class="row"> <div class="col-12"> <div class="back-title m-title"><span>'. $msg.'</span> </div> </div> </div>'
      ?>
      <?php        
        echo form_open('pos/card_payment/', array('id' => "my_form",'class' => "row"));
        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
        $merchant_name = $this->session->userdata('merchant_name');
        $names = substr($merchant_name, 0, 3);
      ?>
      <!-- <div class="row"> -->
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              <div class="row">
                <div class="col  fixed-col">
                  <div class="change-pass">
                    General Info
                  </div>
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Amount</label>     
                      <input type="text" class="form-control"  name="amount" id="amount"  placeholder="Amount:" 
                         required value="<?php echo  $amount ; ?>" readonly>
                      <input type="hidden" class="form-control"  name="tax" id="tax"  
                         required value="<?php echo  $tax ; ?>" readonly>
                      <?php
                         $merchant_id = $this->session->userdata('merchant_id');
                         $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
                         
                         ?>
                      <?php foreach ($data as $view) { ?>
                      <input type="hidden" class="form-control"  name="TAX_ID[]" 
                         required value="<?php echo $view['id']; ?>" readonly>
                      <input type="hidden" class="form-control"  name="TAX_PER[]" 
                         required value="<?php echo $view['percentage']; ?>" readonly>
                      <?php } ?>
                    </div>
                    <div class="form-group">
                      <label for="">Address</label>
                      <input type="text" class="form-control"  name="address" id="address"   placeholder="Address:" 
                                       required >
                    </div>
                    <div class="form-group">
                      <label for="">State</label>
                      <input type="text" class="form-control"  name="state" id="state" pattern="[a-zA-Z\s]+"  placeholder="State Name:" 
                                       required >
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Owner Name</label>
                      <input type="text" class="form-control"  name="name" id="name" pattern="[a-zA-Z\s]+"  placeholder="Owner name:" 
                                       required >
                    </div>
                    <div class="form-group">
                      <label for="">City</label>
                      <input type="text" class="form-control"  name="city" id="city" pattern="[a-zA-Z\s]+"  placeholder="City Name:" 
                                       required >
                    </div>
                    <div class="form-group">
                      <label for="">Zip Code</label>
                      <input type="text" class="form-control"  name="zip" id="zip"   placeholder="Zip:" 
                                       required >
                    </div>
                  </div>      
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              <div class="row">
                <div class="col  fixed-col">
                  <div class="change-pass">
                    Card Info
                  </div>
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Card Number</label> 
                      <input type="text" class="form-control" autocomplete="off" onKeyPress="return isNumberKey(event)"     minlength="14"      maxlength="16"  name="card_no" id="card_no"  placeholder="Card Number" 
                                       required >
                    </div>
                    <div class="form-group">
                      <label for="">Card Expiry Month</label>
                      <select class="form-control" name="expiry_month" id="expiry_month" required>
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
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">CVV</label>
                      <input type="text" class="form-control"  name="cvv" id="cvv" autocomplete="off" minlength="3" maxlength="3" onKeyPress="return isNumberKey(event)"  placeholder="CVV" 
                                       required >
                    </div>
                    <div class="form-group">
                      <label for="">Card Expiry Year</label>
                      <select class="form-control" name="expiry_year" required>
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
                      </select>
                    </div>
                  </div>      
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title custom-form">
              <div class="row">
                <div class="col  fixed-col">
                  <div class="change-pass">
                    Customer Detail
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" class="form-control"  placeholder="Please phone no" name="mobile_no" id="phone" >
                  </div>     
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control"  name="email_id" id="email_id"  placeholder="Please enter email"  >
                  </div>
                  <div class="form-group text-right">
                      <button id="paymentCheckoutSubmitBtn"  type="submit" name="submit" class="btn btn-first" data-dismiss="modal">Pay Now</button>
                  </div>     
                </div>
              </div>
            </div>
          </div>
        </div> 
      <!-- </div> -->
      <?php echo form_close();?>
    </div>
  </div>
<!-- End Page Content -->
<script type="text/javascript">
function checkAllRequiredFields($wrapperForm){
  var formFiled=true;
  $wrapperForm.find('input[type="text"][required],input[type="hidden"][required],input[type="email"][required],input[type="date"][required],input[type="tel"][required],select[required]').each(function(){
    if($(this).val() == ''){
      formFiled=0;
      var ttTop=$(this).offset().top - $('.topbar').height() - 25;
      console.log(ttTop)
      $('html, body').animate({
          scrollTop: ttTop
      },500);
      $(this).focus();
      return false;
    }
  })
  return formFiled;
}
$(document).on('click','#paymentCheckoutSubmitBtn',function(e){
  var $wrapperForm=$(this).closest('form');
  if(!checkAllRequiredFields($wrapperForm)){
    e.preventDefault();
  } 
})
</script>
<?php
include_once'footer_new.php';
?>