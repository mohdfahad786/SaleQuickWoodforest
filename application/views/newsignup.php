<?php
  if (!empty($this->session->userdata('merchant_name')))
  {
      // header('Location:  '. base_url().'merchant'  );
    header('Location:  '.base_url().'merchant'  );
  }
  include_once'header_new_partial.php';


  // if (!empty($this->session->userdata('merchant_name')))
  // {
  //     header('Location:  '.  'https://salequick.com/merchant'  );
  // }
  // include_once'header_new.php';
  // include_once'nav.php';
  // include_once'sidebar.php';
?>
<style type="text/css">
.custom-stepper-form .form-steps .step span {
  border: 2px solid #c7e0ff;
  color: #c7e0ff;
}
.sign-up-form .step.completed span {
    border-color: #79de00;
    color: #79de00;
}
.sign-up-form .step.completed {
    color: #79de00;
}
.custom-stepper-form .form-steps .step.active span {
    border-color: #f7c247;
    color: #f7c247;
}
.custom-stepper-form .form-steps .step.active {
    color: #f7c247;
}
.custom-stepper-form .form-steps .step:not(:last-child):after{
  background: #c7e0ff;
}
.custom-stepper-form .form-steps {
    color: #c7e0ff;
}
.custom-stepper-form .form-steps .step span{
  background: #3180e6;
  -webkit-filter: drop-shadow(0px 0px 1px #ddd);
  -moz-filter: drop-shadow(0px 0px 1px #ddd);
  filter: drop-shadow(0px 0px 1px #ddd);
}
.custom-stepper-form .form-steps .step:not(:last-child):after{
  -webkit-filter: drop-shadow(0px 0px 1px #ddd);
  -moz-filter: drop-shadow(0px 0px 1px #ddd);
  filter: drop-shadow(0px 0px 1px #ddd);
}
.steps-wrapper .fifth-step:not(.active){
  display: none;
}
/*sth step*/
.custom-form input[type="checkbox"] {
    opacity: 0;
}
.switch {
    --switchSize: 35px;
    vertical-align: top;
    margin-right: 7px;
    margin-bottom: 3px;
}
  span.cs-label {
    color: #adb5c7;
    font-size: 11px;
    font-weight: normal;
    letter-spacing: 1px;
    margin-bottom: 3px;
    display: block;
}
label.chk-label,.chk-label{
  padding: 4px 3px 0;
    cursor: pointer;
    color: #fff;
}
.mb-5px {
    margin-bottom: 5px !important;
}
.csz .col:nth-child(2),.mdy-wraper .col:nth-child(2),.fmlname .col:nth-child(2){
    padding: 0;
}
.log-reg-box-inner .custom-form .form-control {
    background-color: rgba(255, 255, 255, 0.85);
}
.prefixed-input {
  padding-left: 25px;
}
span.input-prefix {
  position: absolute;
  display: block;
  font-size: 14px;
  font-weight: normal;
  pointer-events: none;
  padding-left: 10px;
  width: 20px;
  background: none;
  bottom: 10px;
  left: 2px;
  z-index: 0;
}
.form-steps::after, .form-steps::before {
    display: table;
    content: "";
    clear: both;
}
</style>
<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="outer-page-wrapper main-stepper-form">    
      <div class="login-register">
        <div class="log-reg-box-inner custom-stepper-form">
          <div class="row">
            <div class="col-12">
              <div class="logo-wrapper-outer clearfix">
                  <a href="<?php echo base_url(); ?>" class="logo-wrapper no-ajax">
                    <img src="<?php echo base_url('front/images/logo-w.png'); ?>" alt="Salequick">
                  </a>
              </div>
            </div>
          </div>
          <div class="custom-form sign-up-form">
            <div class="form-steps" style="<?php if($this->session->userdata('step')!=""){ echo 'display:block;'; }else{ echo ''; } ?>">
              <div class="row">
                <div class="step col  <?php if($this->session->userdata('step')!=""){ echo 'completed'; }else{ echo 'active'; } ?>"  data-fStep="1">
                  <?php if($this->session->userdata('step')!=""){ echo '<span class="fa fa-check"></span>'; }else{ echo '<span>1</span>'; } ?>
                  
                  <p class="step-title">
                    Creating Account Web Version
                  </p>
                </div>
                <div class="step col <?php 
                if($this->session->userdata('step')=="one"){
                  echo 'active'; 
                  }elseif($this->session->userdata('step')=="two" || $this->session->userdata('step')=="three"){
                    echo 'completed';
                  } 
                  ?>"  data-fStep="2">
                  <span>2</span>
                  <p class="step-title">
                    Business Information 
                  </p>
                </div>
                <div class="step col <?php 
                if($this->session->userdata('step')=="two"){
                  echo 'active'; 
                  }elseif($this->session->userdata('step')=="three"){
                    echo 'completed';
                  } 
                  ?>"  data-fStep="3">
                  <span>3</span>
                  <p class="step-title">
                    Business Owner Information
                  </p>
                </div>
                <div class="step col <?php 
                if($this->session->userdata('step')=="three"){
                  echo 'active'; 
                  }elseif($this->session->userdata('step')=="four"){
                    echo 'completed';
                  } 
                  ?>"  data-fStep="4">
                  <span>4</span>
                  <p class="step-title">
                    <!-- Where would you like your funds deposited -->
                    Banking Information
                  </p>
                </div>
              </div>
            </div>
            <div class="steps-wrapper  ">
              <div class="row">
                  <div class="col-12">
                    <?php if($this->session->flashdata('success')){ ?>
                      <div class="alert alert-success text-center"><?php echo $this->session->flashdata('success'); ?></div>
                   <?php } ?>
                   <?php if($this->session->flashdata('error')){ ?>
                      <div class="alert alert-danger text-center"><?php echo $this->session->flashdata('error'); ?></div>
                   <?php } ?>
                  </div>
              </div>    
              <div class="first-step row <?php if($this->session->userdata('step')!=""){ echo ''; }else{ echo 'active'; } ?>" data-fStep="1">
                <div class="col-12">
                  <p class="steptitle"> Creating Account </p>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control email"   value="<?php if($Merchant) echo $Merchant['email']; ?>" name="memail" placeholder="Email" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="password" class="form-control password p1" value="<?php if($Merchant) echo $Merchant['password']; ?>" name="mpass" placeholder="Password" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="password" value="<?php if($Merchant) echo $Merchant['password']; ?>" class="form-control password p2" name="mconfpass" placeholder="Confirm Password" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group text-right"> 
                    <button type="button" class="btn btn-second stepper-submit"> 
                      <span></span>
                      Submit
                    </button>
                  </div>
                </div>
              </div>
              <div class="second-step row <?php if($this->session->userdata('step')=="one"){ echo 'active'; } ?>" data-fStep="2">
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control " name="bsns_name" value=""  placeholder="Enter the legal name for your business" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control " name="bsns_dbaname" value=""  placeholder="Enter the doing business as name for your business" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control us-tin-no" name="bsns_tin" value=""  placeholder="Tax Identification Number (TIN)" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                  <span class="cs-label">Physical Address</span>                          
                  <div class="form-group mb-5px">  
                    <select class="form-control" name="bsnspadd_cnttry"  required autocomplete="off">
                      <option value="">Select Country</option>
                      <option value="USA">United States of America</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group mb-5px">           
                    <input type="text" class="form-control" name="bsnspadd_1" value=""  placeholder="Enter Address 1" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group mb-5px">           
                    <input type="text" class="form-control" name="bsnspadd_2" value=""  placeholder="Enter Address 2"  autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">           
                    <div class="csz row">
                      <div class="col">
                        <input type="text" class="form-control mb5" name="bsnspadd_city" value=""  placeholder="Enter City" required autocomplete="off">              
                      </div>
                      <div class="col">
                        <select class="form-control mb5" name="bsnspadd_state"  required>
                          <option value="">Select State</option>
                          <option value="AL">Alabama</option>
                          <option value="AK">Alaska</option>
                          <option value="AZ">Arizona</option>
                          <option value="AR">Arkansas</option>
                          <option value="CA">California</option>
                          <option value="CO">Colorado</option>
                          <option value="CT">Connecticut</option>
                          <option value="DE">Delaware</option>
                          <option value="DC">District Of Columbia</option>
                          <option value="FL">Florida</option>
                          <option value="GA">Georgia</option>
                          <option value="HI">Hawaii</option>
                          <option value="ID">Idaho</option>
                          <option value="IL">Illinois</option>
                          <option value="IN">Indiana</option>
                          <option value="IA">Iowa</option>
                          <option value="KS">Kansas</option>
                          <option value="KY">Kentucky</option>
                          <option value="LA">Louisiana</option>
                          <option value="ME">Maine</option>
                          <option value="MD">Maryland</option>
                          <option value="MA">Massachusetts</option>
                          <option value="MI">Michigan</option>
                          <option value="MN">Minnesota</option>
                          <option value="MS">Mississippi</option>
                          <option value="MO">Missouri</option>
                          <option value="MT">Montana</option>
                          <option value="NE">Nebraska</option>
                          <option value="NV">Nevada</option>
                          <option value="NH">New Hampshire</option>
                          <option value="NJ">New Jersey</option>
                          <option value="NM">New Mexico</option>
                          <option value="NY">New York</option>
                          <option value="NC">North Carolina</option>
                          <option value="ND">North Dakota</option>
                          <option value="OH">Ohio</option>
                          <option value="OK">Oklahoma</option>
                          <option value="OR">Oregon</option>
                          <option value="PA">Pennsylvania</option>
                          <option value="RI">Rhode Island</option>
                          <option value="SC">South Carolina</option>
                          <option value="SD">South Dakota</option>
                          <option value="TN">Tennessee</option>
                          <option value="TX">Texas</option>
                          <option value="UT">Utah</option>
                          <option value="VT">Vermont</option>
                          <option value="VA">Virginia</option>
                          <option value="WA">Washington</option>
                          <option value="WV">West Virginia</option>
                          <option value="WI">Wisconsin</option>
                          <option value="WY">Wyoming</option>
                        </select>            
                      </div>
                      <div class="col">
                        <input type="text" class="form-control mb5" name="bsnspadd_zip" value=""  placeholder="Enter Zip" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">             
                    <select class="form-control " name="bsns_ownrtyp"  required autocomplete="off">
                      <option value="">Select Ownership Type</option>
                      <option value="Government">Government</option>
                      <option value="LLC">Limited Liability Company</option>
                      <option value="NonProfit">Non-Profit</option>
                      <option value="Partnership">Partnership</option>
                      <option value="PrivateCorporation">Private Corporation</option>
                      <option value="PublicCorporation">Public Corporation</option>
                      <option value="SoleProprietorship">Sole Proprietorship</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">               
                    <select class="form-control" name="bsns_type"  required autocomplete="off">
                      <option value="">Select Business Type</option>
                      <option value="AutoRental">Auto Rental</option>
                      <option value="ECommerce">E-Commerce</option>
                      <option value="Lodging">Lodging</option>
                      <option value="MOTO">MOTO</option>
                      <option value="Restaurant">Restaurant</option>
                      <option value="Retail">Retail</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <span class="cs-label">Business Establishment Date</span> 
                  <div class="form-group"> 
                    <div class="mdy-wraper row">
                      <div class="col">
                        <select class="form-control mb-5px" name="bsns_strtdate_m"  required>
                          <option value="">Month</option>
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">May</option>
                          <option value="06">Jun</option>
                          <option value="07">Jul</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                        </select>                 
                      </div>
                      <div class="col">
                        <select class="form-control mb-5px" name="bsns_strtdate_d"  required>
                          <option value="">Day</option>
                          <option value="01">01</option>
                          <option value="02">02</option>
                          <option value="03">03</option>
                          <option value="04">04</option>
                          <option value="05">05</option>
                          <option value="06">06</option>
                          <option value="07">07</option>
                          <option value="08">08</option>
                          <option value="09">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                          <option value="24">24</option>
                          <option value="25">25</option>
                          <option value="26">26</option>
                          <option value="27">27</option>
                          <option value="28">28</option>
                          <option value="29">29</option>
                          <option value="30">30</option>
                          <option value="31">31</option>
                        </select>            
                      </div>
                      <div class="col">
                        <select class="form-control mb-5px" name="bsns_strtdate_y"  required>
                            <option value="">Year</option>
                          <?php  
                          $year=date('Y');
                          $startYear=$year ; 
                          for($i=$startYear; $startYear>=1900;  $startYear--){ ?>
                              <option value="<?=$startYear?>"><?=$startYear?></option>
                              <?php } 
                            ?>                        
                        </select>     
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control us-phone-no" name="bsns_phone" value=""  placeholder="Business Phone Number" required autocomplete="off" >
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control email" name="bsns_email" value=""  placeholder="Business Email Address" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control us-phone-no" name="custServ_phone" value=""  placeholder="Customer Service Phone Number" required autocomplete="off" >
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control email" name="custServ_email" value=""  placeholder="Customer Service Email Address" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control" name="bsns_website" value=""  placeholder="https://www.yourwebsite.com" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">   
                    <select class="form-control" name="mepvolume" required>
                      <option value="">Estimated Annual Processing Volume</option>
                      <option value="10000">$10,000</option>
                      <option value="20000">$20,000</option>
                      <option value="30000">$30,000</option>
                      <option value="40000">$40,000</option>
                      <option value="50000">$50,000</option>
                      <option value="60000">$60,000</option>
                      <option value="70000">$70,000</option>
                      <option value="80000">$80,000</option>
                      <option value="90000">$90,000</option>
                      <option value="100000">$100,000+</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group text-right"> 
                    <button type="button" class="btn btn-first next-step"><span></span> Next</button>
                  </div>
                </div>
              </div>
              <div class="third-step row <?php if($this->session->userdata('step')=="two"){ echo 'active'; } ?>" data-fStep="3">
                <div class="col-12">
                  <span class="cs-label">Name</span> 
                  <div class="form-group">             
                    <div class="fmlname row">
                        <div class="col">
                          <input type="text" class="form-control" value="" name="foname1" placeholder="First" required autocomplete="off">
                        </div>
                        <div class="col">
                          <input type="text" class="form-control" value="" name="foname2" placeholder="Middle"  autocomplete="off">
                        </div>
                        <div class="col">
                          <input type="text" class="form-control" value="" name="foname3" placeholder="Last"  autocomplete="off">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group"> 
                    <input type="text" class="form-control us-ssn-no-enc" name="fossn" value=""  placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11" maxlength="9">     
                  </div>
                </div>
                <div class="col-12">
                  <span class="cs-label">Date of Birth</span>           
                  <div class="form-group">        
                    <div class="mdy-wraper row">
                      <div class="col">
                        <select class="form-control mb-1" name="fodobm"  required>
                          <option value="">Month</option>
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">May</option>
                          <option value="06">Jun</option>
                          <option value="07">Jul</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                        </select>                 
                      </div>
                      <div class="col">
                        <select class="form-control mb-1" name="fodobd"  required>
                          <option value="">Day</option>
                          <option value="01">01</option>
                          <option value="02">02</option>
                          <option value="03">03</option>
                          <option value="04">04</option>
                          <option value="05">05</option>
                          <option value="06">06</option>
                          <option value="07">07</option>
                          <option value="08">08</option>
                          <option value="09">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                          <option value="24">24</option>
                          <option value="25">25</option>
                          <option value="26">26</option>
                          <option value="27">27</option>
                          <option value="28">28</option>
                          <option value="29">29</option>
                          <option value="30">30</option>
                          <option value="31">31</option>
                        </select>            
                      </div>
                      <div class="col">
                        <select class="form-control mb-1" name="fodoby"  required>
                          <option value="">Year</option>
                          <?php  
                          $year=date('Y');
                          $startYear=$year ; 
                          for($i=$startYear; $startYear>=1900;  $startYear--){ ?>
                              <option value="<?=$startYear?>"><?=$startYear?></option>
                              <?php } 
                            ?>
                        </select>     
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <span class="cs-label">Home Address</span>                          
                  <div class="form-group mb-5px">  
                    <select class="form-control" name="fohadd_cntry"  required autocomplete="off">
                      <option value="">Select Country</option>
                      <option value="USA">United States of America</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group mb-5px">           
                    <input type="text" class="form-control" name="fohadd_1" value=""  placeholder="Enter Address 1" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group mb-5px">           
                    <input type="text" class="form-control" name="fohadd_2" value=""  placeholder="Enter Address 2"  autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">           
                    <div class="csz row">
                      <div class="col">
                        <input type="text" class="form-control mb5" name="fohadd_city" value=""  placeholder="Enter City" required autocomplete="off">              
                      </div>
                      <div class="col">
                        <select class="form-control mb5" name="fohadd_state"  required>
                          <option value="">Select State</option>
                          <option value="AL">Alabama</option>
                          <option value="AK">Alaska</option>
                          <option value="AZ">Arizona</option>
                          <option value="AR">Arkansas</option>
                          <option value="CA">California</option>
                          <option value="CO">Colorado</option>
                          <option value="CT">Connecticut</option>
                          <option value="DE">Delaware</option>
                          <option value="DC">District Of Columbia</option>
                          <option value="FL">Florida</option>
                          <option value="GA">Georgia</option>
                          <option value="HI">Hawaii</option>
                          <option value="ID">Idaho</option>
                          <option value="IL">Illinois</option>
                          <option value="IN">Indiana</option>
                          <option value="IA">Iowa</option>
                          <option value="KS">Kansas</option>
                          <option value="KY">Kentucky</option>
                          <option value="LA">Louisiana</option>
                          <option value="ME">Maine</option>
                          <option value="MD">Maryland</option>
                          <option value="MA">Massachusetts</option>
                          <option value="MI">Michigan</option>
                          <option value="MN">Minnesota</option>
                          <option value="MS">Mississippi</option>
                          <option value="MO">Missouri</option>
                          <option value="MT">Montana</option>
                          <option value="NE">Nebraska</option>
                          <option value="NV">Nevada</option>
                          <option value="NH">New Hampshire</option>
                          <option value="NJ">New Jersey</option>
                          <option value="NM">New Mexico</option>
                          <option value="NY">New York</option>
                          <option value="NC">North Carolina</option>
                          <option value="ND">North Dakota</option>
                          <option value="OH">Ohio</option>
                          <option value="OK">Oklahoma</option>
                          <option value="OR">Oregon</option>
                          <option value="PA">Pennsylvania</option>
                          <option value="RI">Rhode Island</option>
                          <option value="SC">South Carolina</option>
                          <option value="SD">South Dakota</option>
                          <option value="TN">Tennessee</option>
                          <option value="TX">Texas</option>
                          <option value="UT">Utah</option>
                          <option value="VT">Vermont</option>
                          <option value="VA">Virginia</option>
                          <option value="WA">Washington</option>
                          <option value="WV">West Virginia</option>
                          <option value="WI">Wisconsin</option>
                          <option value="WY">Wyoming</option>
                        </select>            
                      </div>
                      <div class="col">
                        <input type="text" class="form-control mb5" name="fohadd_zip" value=""  placeholder="Enter Zip" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">   
                    <input type="text" class="form-control us-phone-no" value="" name="fo_phone" placeholder="Phone Number" required autocomplete="off" >
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">   
                    <input type="text" class="form-control email" value="" name="fo_email" placeholder="Email Address" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group text-right"> 
                    <button type="button" class="btn btn-second back-step"> Back</button>
                    <button type="button" class="btn btn-first next-step"><span></span> Next</button>
                  </div>
                </div>
              </div>
              <div class="fourth-step row <?php if($this->session->userdata('step')=="three"){ echo 'active'; } ?>" data-fStep="4">
                <div class="col-12">
                  <div class="form-group">                       
                    <select class="form-control" name="bank_dda_type"  required autocomplete="off">
                      <option value="">Select Bank Account DDA Type</option>
                      <option value="CommercialChecking">Commercial Checking</option>
                      <option value="PrivateChecking">Private Checking</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">            
                    <select class="form-control" name="baccachtype"  required autocomplete="off">
                      <option value="">Select Bank Account ACH Type</option>
                      <option value="CommercialChecking">Business Checking</option>
                      <option value="PrivateChecking">Personal Checking</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input  type="text" class="form-control us-routing" maxlength="9" name="routeNo" value=""  placeholder="Routing Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control us-routing-c" maxlength="9" name="confrouteNo" value=""  placeholder="Confirm Routing Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control us-acc-no" maxlength="17" name="accno" value=""  placeholder="Account Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">  
                    <input type="text" class="form-control us-acc-no-c" maxlength="17" name="confaccno" value=""  placeholder="Confirm Account Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group text-right"> 
                    <button type="button" class="btn btn-second back-step"> Back</button>
                    <button type="button" name="button" class="btn btn-first submit-step"><span></span> Submit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group text-center">
                <p class="have-acc-txt">Have an account <a class="no-ajax" href="<?php echo base_url('login'); ?>" > Login?</a></p>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>

<script type="text/javascript">
  function mSignupStep1Fn(mSignupStepF)
  {
    console.log(mSignupStepF)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/stepone_signup');?>",
      data: mSignupStepF,
      dataType: "JSON",
      success: function(data) {
        console.log(data);
       
        if(data=='200')
        {
               leaveFirstGoNextStp();
              $(window).trigger('resize');
              $('.custom-stepper-form .first-step .stepper-submit span').removeClass('fa fa-spinner fa-spin');
        }
        else if(data=='400')
        {
           alert('all fields are required'); 
        }
        else if(data=='600')
        {
          alert("both password Are not Match"); 
        }
        
      },
      error: function(xhr){
        console.log('error');
        $('.custom-stepper-form .first-step .stepper-submit span').removeClass('fa fa-spinner fa-spin');
      },
    })
  }
  //2nd
  function mSignupStep2Fn(mSignupStepS)
  {
     console.log(mSignupStepS)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/steptwo_signup');?>",
      data: mSignupStepS,
      success: function(data) {
        // console.log(data);
        // console.log('submited');
        leave2ndGoNextStp();
        $('.custom-stepper-form .second-step .next-step span').removeClass('fa fa-spinner fa-spin');
      },
      error: function(xhr){
        console.log('error'); 
        $('.custom-stepper-form .second-step .next-step span').removeClass('fa fa-spinner fa-spin');
      },
    })
  }
  //3nd
  function mSignupStep3Fn(mSignupStepTh)
  {
    console.log(mSignupStepTh)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/stepthree_signup');?>",
      data: mSignupStepTh,
      success: function(data) {
      //  console.log(data); 
        leave3rdGoNextStp();
        $('.custom-stepper-form .third-step .next-step span').removeClass('fa fa-spinner fa-spin');
      },
      error: function(xhr){
        console.log('error');
        $('.custom-stepper-form .third-step .next-step span').removeClass('fa fa-spinner fa-spin');
      },
    })
  }
  //4th
  function mSignupStep4Fn(mSignupStepFth)
  {
     console.log(mSignupStepFth)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/stepfour_signup'); ?>",
      data: mSignupStepFth,
      success: function(data) {
          // console.log(data == '200');
          // leave4thGoNextStp();

        if(data == "200")  { window.location.href='<?=base_url("login");?>'; }
        $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');
      },
      error: function(xhr){
        console.log('error');
        $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');
      },
    })
  }
 
$(function(){
    $('#as__day').select2();
    $('#as__month').select2();
    $('#as__year').select2();
    $(".us-phone-no").mask("(999) 999-9999");
    $(".us-tin-no").mask("99-9999999");
    // $(".us-ssn-no-val").mask("999-99-9999");
})
</script>
<?php
include_once 'footer_new_partial.php';
?>
