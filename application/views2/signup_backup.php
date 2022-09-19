<?php
  if (!empty($this->session->userdata('merchant_name')))
  {
      header('Location:  '.  'https://salequick.com/merchant'  );
  }
  include_once'header_new.php';
  // include_once'nav.php';
  // include_once'sidebar.php';
?>

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
                  <span>1</span>
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
                    Tell us about your business
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
                    Where would you like your funds deposited
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
                  <p class="steptitle">
                    Creating Account
                  </p>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control " name="mbname" value="<?php if($Merchant) echo $Merchant['name']; ?>"  placeholder="Business Name" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control email"   value="<?php if($Merchant) echo $Merchant['email']; ?>" name="memail" placeholder="Email" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control phone"  value="<?php if($Merchant) echo $Merchant['mob_no']; ?>" name="mphone" id="signUpphone" placeholder="Phone" required>
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
                    <input type="text" class="form-control" name="mlbName"  value="<?php if($Merchant) echo $Merchant['business_name']; ?>" placeholder="Legal Business Name"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control" name="mdba"  value="<?php if($Merchant) echo $Merchant['business_dba_name']; ?>" placeholder="DBA (Doing Business As)" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control" value="<?php if($Merchant) echo $Merchant['website']; ?>" name="mwebsite"  placeholder="Website">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">            
                    <select class="form-control" name="mepvolume">
                      <option value="">Estimated Monthly Processing Volume</option>
                      <option  value="10000">$10,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='20000') echo 'selected'; }?> value="20000">$20,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='30000') echo 'selected'; }?> value="30000">$30,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='40000') echo 'selected'; }?> value="40000">$40,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='50000') echo 'selected'; }?>  value="50000">$50,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='60000') echo 'selected'; }?> value="60000">$60,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='70000') echo 'selected'; }?> value="70000">$70,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='80000') echo 'selected'; }?> value="80000">$80,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='90000') echo 'selected'; }?> value="90000">$90,000</option>
                      <option <?php if($Merchant){ if($Merchant['monthly_processing_volume']=='100000') echo 'selected'; }?> value="100000">$100,000+</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">   
                    <input type="text" value="<?php if($Merchant) echo $Merchant['ien_no']; ?>" class="form-control any-no"  name="meidno" placeholder="EIN (Employer Identification Number) "  required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <textarea class="form-control" name="mbaddress" placeholder="Business Address" rows="2"><?php if($Merchant) echo $Merchant['address1']; ?></textarea>
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
                  <div class="form-group">                
                    <input type="text" class="form-control" name="mfname" value="<?php if($Merchant) echo $Merchant['l_name']; ?>" placeholder="Full Name"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control any-date reg-dob" value="<?php if($Merchant) echo $Merchant['dob']; ?>" name="mdob"  placeholder="Date of Birth:YYYY-MM-DD"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control"  value="<?php if($Merchant) echo $Merchant['percentage_of_ownership']; ?>"  name="mopercentage"  placeholder="Ownership Percentage">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" id="social_scurity_no" value="<?php if($Merchant) echo $Merchant['o_social']; ?>"  class="form-control any-no encrypted-field" name="mssno"  placeholder="Social Security Number"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text"  value="<?php if($Merchant) echo $Merchant['driver_license']; ?>" class="form-control any-no encrypted-field" name="mdlno"  placeholder="Drivers License Number"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <textarea class="form-control" placeholder="Home Address" name="mhaddress" rows="2"><?php  if($Merchant) echo $Merchant['address2']; ?></textarea>
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
                    <input type="text" class="form-control any-no" value="<?php if($Merchant) echo $Merchant['bank_routing']; ?>" name="mrouteno"  placeholder="Routing Number"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control any-no acc1" value="<?php if($Merchant) echo $Merchant['bank_account']; ?>" name="maccno"  placeholder="Account Number"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control any-no acc2" value="<?php if($Merchant) echo $Merchant['bank_account']; ?>" name="mconfaccno"  placeholder="Confirm Account Number"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control"  value="<?php if($Merchant) echo $Merchant['bank_name']; ?>" name="mbankname"  placeholder="Bank Name"   required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group text-right"> 
                    <button type="button" class="btn btn-second back-step"> Back</button>
                    <button type="submit" name="submit" class="btn btn-first submit-step"><span></span> Submit</button>
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
    // console.log(mSignupStepF)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/stepone_signup');?>",
      data: mSignupStepF,
      success: function(data) {
        // console.log(data);
        leaveFirstGoNextStp();
        $('.custom-stepper-form .first-step .stepper-submit span').removeClass('fa fa-spinner fa-spin');
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
     // console.log(mSignupStepS)
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
     // console.log(mSignupStepTh)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/stepthree_signup');?>",
      data: mSignupStepTh,
      success: function() {
        // console.log('submited');
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
     // console.log(mSignupStepFth)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/stepfour_signup'); ?>",
      data: mSignupStepFth,
      success: function(data) {
          // console.log(data == '200');
        if(data == "200")
        {
          // console.log(data == '200')
          window.location.href='<?=base_url("login");?>';
          // window.location.href='https://google.com';
        }
        // console.log(data);
        $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');
      },
      error: function(xhr){
        console.log('error');
        $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');
      },
    })
  }
</script>
<?php
include_once'footer_new.php';
?>
