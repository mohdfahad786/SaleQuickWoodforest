<?php
if (!empty($this->session->userdata('merchant_name'))) {
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
    @font-face {
        font-family: 'Avenir-Black';
        /*font-weight: bold;*/
        font-style: normal;
        src: url('new_assets/css/fonts/Avenir-Black.woff') format('woff'),
             url('new_assets/css/fonts/Avenir-Black.ttf') format('truetype');
        /*src: url('../../new_assets/css/fonts/Avenir-Black.woff') format('woff'),
             url('../../new_assets/css/fonts/Avenir-Black.ttf') format('truetype');*/
    }
    @font-face {
        font-family: 'Avenir-Heavy';
        /*font-weight: bold;*/
        font-style: normal;
        src: url('new_assets/css/fonts/Avenir-Heavy.woff') format('woff'),
             url('new_assets/css/fonts/Avenir-Heavy.ttf') format('truetype');
    }
    @font-face {
        font-family: 'AvenirNext-Medium';
        /*font-weight: bold;*/
        font-style: normal;
        src: url('new_assets/css/fonts/AvenirNext-Medium.woff') format('woff'),
             url('new_assets/css/fonts/AvenirNext-Medium.ttf') format('truetype');
    }
    @font-face {
        font-family: 'Avenir-Roman';
        /*font-weight: bold;*/
        font-style: normal;
        src: url('new_assets/css/fonts/Avenir-Roman.woff') format('woff'),
             url('new_assets/css/fonts/Avenir-Roman.ttf') format('truetype');
    }
    .steps-wrapper .steptitle {
        color: #4c6ef5 !important;
    }
    .form-control {
        border: 1px solid rgba(0,0,0,.15) !important;
    }
    .form-control:focus {
        border: 1px solid #4c6ef5 !important;
    }
    .dobWrapper__activateAcc .select2-container--default .select2-selection--single {
        border: 1px solid rgba(0,0,0,.15) !important;
    }
    span.cs-label {
        color: rgb(110, 110, 110) !important;
        font-family: Avenir-Black !important;
    }
    .steps-wrapper {
        background: #f8f8f8;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px 6px rgb(20,20,50,.3);
    }
    .custom-form .form-control::-webkit-input-placeholder {
        font-family: AvenirNext-Medium !important;
    }
    .select2-selection__rendered {
        color: #adb5c7 !important;
        font-family: AvenirNext-Medium !important;
    }
    .have-acc-txt {
        font-family: Avenir-Black !important;
        font-size: 16px !important;
    }
    .custom-stepper-form .form-steps {
        margin-bottom: 28px;
        border-bottom: none !important;
    }
    .custom-stepper-form .form-steps .step .step-title {
        font-size: 10px !important;
        text-transform: uppercase !important;
        color: #fff !important;
        font-family: AvenirNext-Medium !important;
    }
    .custom-stepper-form button.btn.btn-first:not(.initail) {
        background-color: #4c6ef5 !important;
        border: 1px solid #fff !important;
        color: #fff !important;
        font-family: AvenirNext-Medium !important;
    }
    .custom-stepper-form button.btn.btn-first:not(.initail):focus, .custom-stepper-form button.btn.btn-first:not(.initail):hover {
        border: 1px solid #4c6ef5 !important;
        color: #4c6ef5 !important;
    }
    .custom-stepper-form button.btn.btn-second:not(.initail) {
        border: 1px solid #4c6ef5 !important;
        color: #4c6ef5 !important;
        font-family: AvenirNext-Medium !important;
    }
    .custom-stepper-form button.btn.btn-second:not(.initail):focus, .custom-stepper-form button.btn.btn-second:not(.initail):hover {
        background-color: #4c6ef5 !important;
        border: 1px solid #fff !important;
        color: #fff !important;
    }
    .sign-up-form .step.completed span {
        background: #1956a6 !important;
        color: #fff !important;
    }
    .sign-up-form .step.completed {
        color: #79de00;
    }
    .custom-stepper-form .form-steps .step.active span {
        background: #1956a6 !important;
        color: #fff !important;
    }
    .custom-stepper-form .form-steps .step.active {
        color: #f7c247;
    }
    /*.custom-stepper-form .form-steps .step:not(:last-child):after{
        background: #c7e0ff;
    }*/
    .custom-stepper-form .form-steps {
        color: #c7e0ff;
    }
    .custom-stepper-form .form-steps .step span{
        -webkit-filter: drop-shadow(0px 0px 1px #ddd);
        -moz-filter: drop-shadow(0px 0px 1px #ddd);
        filter: drop-shadow(0px 0px 1px #ddd);
    }
    .custom-stepper-form .form-steps .step:not(:last-child):after{
        background: #fff !important;
        top: 14px !important;
        -webkit-filter: drop-shadow(0px 0px 1px #ddd);
        -moz-filter: drop-shadow(0px 0px 1px #ddd);
        filter: drop-shadow(0px 0px 1px #ddd);
    }
    .steps-wrapper .fifth-step:not(.active){
      display: none;
    }
    .switch {
        --switchSize: 35px;
        vertical-align: top;
        margin-right: 7px;
        margin-bottom: 3px;
    }
      span.cs-label {
        color: #adb5c7;
        font-size: 11px !important;
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
    @media only screen and (max-width: 359px){
      #wrapper .custom-form.sign-up-form {
        padding: 15px 0;
      }
    }
    .custom_hr {
        border-top: 1px solid #90b9ed !important;
        margin: 15px !important;
    }
    .save_owner {
        width: 100px !important;
    }
    .busi_owner_row {
        border-bottom: 1px solid rgb(184, 184, 184);
        margin: 10px 0px;
        padding: 12px 0px;
    }
    .busi_owner_row:hover {
        background: rgb(242, 242, 242, 1);
    }
    .delete_owner {
        background: transparent !important;
    }
    .btn-primary {
        font-family: AvenirNext-Medium !important;
    }
    .owner_list_name {
        color: rgb(110, 110, 110) !important;
        font-family: Avenir-Heavy;
        text-transform: capitalize;
    }
    .owner_list_email {
        font-family: AvenirNext-Medium !important;
        color: rgb(184, 184, 184) !important;
    }
    .owner_list_icon {
        background: #757575;
        padding: 11px 18px;
        border-radius: 50%;
    }
    .owner_list_icon_span {
        color: #fff !important;
        font-family: AvenirNext-Medium !important;
        text-transform: uppercase;
    }
    .btn_custom_width {
        width: inherit !important;
    }
    .owner_check {
      opacity: 1 !important;
    }
    .doc_url {
      color: #007bff !important;
    }
    .doc_url:hover {
      color: #1956a6 !important;
    }
    .custom-form input[type=checkbox] {
      opacity: 1 !important;
      width: 18px !important;
      height: 18px !important;
    }
    .sign-up-form .steps-wrapper .form-group.check_form_group.mandatory:after {
      top: 30px !important;
    }
</style>
<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="outer-page-wrapper main-stepper-form">    
      <div class="login-register dobWrapper__activateAcc">
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
                    User Account
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
                    Owner Information
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
                    <input type="text" class="form-control email" value="<?php if($Merchant) echo $Merchant['email']; ?>" name="memail" placeholder="Email" required>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">                
                    <input type="text" class="form-control us-phone-no" value="<?php if($Merchant) echo $Merchant['pc_phone']; ?>" name="primary_phone" placeholder="Mobile Number" required>
                  </div>
                </div>

                 <div class="col-12">
                  <div class="form-group check_pswd1">                
                    <input type="text" id="secret1" class="form-control p1" value="<?php if($Merchant) echo $Merchant['password']; ?>" name="secret1" placeholder="Password" required>
                    <input type="hidden" id="secret11" name="secret11" value="">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group check_pswd2">                
                    <input type="text" id="secret2" value="<?php if($Merchant) echo $Merchant['password']; ?>" class="form-control p2" name="secret22" placeholder="Confirm Password" required>
                    <input type="hidden" id="secret22" name="secret22" value="">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group check_form_group">
                    <p>
                      <input class="form-control accept_check" name="accept_check" type="checkbox" value="" required style="display: inline !important;">
                      <span>By clicking you agree to SaleQuick's <a class="doc_url" target="_blank" href="<?php echo base_url('merchant-services-agreement'); ?>">Merchant Services Agreement</a>, <a class="doc_url" target="_blank" href="<?php echo base_url('terms_and_condition'); ?>">Terms & Privacy Policy</a>. Please take time to read and understand.</span>
                    </p>
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
                    <span class="cs-label">Legal Business Name</span>
                    <div class="form-group">                
                        <input type="text" class="form-control " name="bsns_name" value="<?php if($Merchant) echo $Merchant['business_name']; ?>"  placeholder="Enter the legal name for your business" required autocomplete="off">
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">DBA Name</span>
                    <div class="form-group">                
                        <input type="text" class="form-control " name="bsns_dbaname" value="<?php if($Merchant) echo $Merchant['business_dba_name']; ?>"  placeholder="Enter the doing business as name for your business" required autocomplete="off">
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Tax Identification Number (TIN)</span>
                    <div class="form-group">
                        <input type="text" class="form-control us-tin-no" name="bsns_tin" value="<?php if($Merchant) echo $Merchant['taxid']; ?>"  placeholder="Tax Identification Number (TIN)" required autocomplete="off" onkeypress="return isNumberKey(event)">
                    </div>
                </div>
                <div class="col-12">
                  <span class="cs-label">Physical Address</span>
                  <div class="form-group mb-5px">  
                    <select class="form-control selectOption" name="bsnspadd_cnttry"  required autocomplete="off">
                      <option value="">Select Country</option>
                      <option value="USA" <?php if($Merchant) {if($Merchant['country']=='USA') echo 'selected';  } ?> >United States of America</option>
                      <option value="Mexico" <?php if($Merchant) {if($Merchant['country']=='Mexico') echo 'selected';  } ?> >Mexico</option>
                      <option value="Canada" <?php if($Merchant) {if($Merchant['country']=='Canada') echo 'selected';  } ?> >Canada</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group mb-5px">           
                    <input type="text" class="form-control" name="bsnspadd_1" value="<?php if($Merchant) echo $Merchant['address1']; ?>"  placeholder="Enter Address 1" required autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group mb-5px">           
                    <input type="text" class="form-control" name="bsnspadd_2" value="<?php if($Merchant) echo $Merchant['address2']; ?>"  placeholder="Enter Address 2"  autocomplete="off">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">           
                    <div class="csz row">
                      <div class="col">
                        <input type="text" class="form-control mb5" name="bsnspadd_city" value="<?php if($Merchant) echo $Merchant['city']; ?>"  placeholder="City" required autocomplete="off">              
                      </div>
                      <div class="col">
                        <select class="form-control mb5 selectOption" name="bsnspadd_state"  required>
                          <option value="">Select State</option>
                          <option value="AL" <?php if($Merchant) {if($Merchant['state']=='AL') echo 'selected';  } ?> >Alabama</option>
                          <option value="AK" <?php if($Merchant) {if($Merchant['state']=='AK') echo 'selected';  } ?> >Alaska</option>
                          <option value="AZ" <?php if($Merchant) {if($Merchant['state']=='AZ') echo 'selected';  } ?> >Arizona</option>
                          <option value="AR" <?php if($Merchant) {if($Merchant['state']=='AR') echo 'selected';  } ?> >Arkansas</option>
                          <option value="CA" <?php if($Merchant) {if($Merchant['state']=='CA') echo 'selected';  } ?> >California</option>
                          <option value="CO" <?php if($Merchant) {if($Merchant['state']=='CO') echo 'selected';  } ?>>Colorado</option>
                          <option value="CT" <?php if($Merchant) {if($Merchant['state']=='CT') echo 'selected';  } ?>>Connecticut</option>
                          <option value="DE" <?php if($Merchant) {if($Merchant['state']=='DE') echo 'selected';  } ?>>Delaware</option>
                          <option value="DC" <?php if($Merchant) {if($Merchant['state']=='DC') echo 'selected';  } ?>>District Of Columbia</option>
                          <option value="FL" <?php if($Merchant) {if($Merchant['state']=='FL') echo 'selected';  } ?>>Florida</option>
                          <option value="GA" <?php if($Merchant) {if($Merchant['state']=='GA') echo 'selected';  } ?>>Georgia</option>
                          <option value="HI" <?php if($Merchant) {if($Merchant['state']=='HI') echo 'selected';  } ?> >Hawaii</option>
                          <option value="ID" <?php if($Merchant) {if($Merchant['state']=='ID') echo 'selected';  } ?> >Idaho</option>
                          <option value="IL" <?php if($Merchant) {if($Merchant['state']=='IL') echo 'selected';  } ?> >Illinois</option>
                          <option value="IN" <?php if($Merchant) {if($Merchant['state']=='IN') echo 'selected';  } ?> >Indiana</option>
                          <option value="IA" <?php if($Merchant) {if($Merchant['state']=='IA') echo 'selected';  } ?> >Iowa</option>
                          <option value="KS" <?php if($Merchant) {if($Merchant['state']=='KS') echo 'selected';  } ?> >Kansas</option>
                          <option value="KY" <?php if($Merchant) {if($Merchant['state']=='KY') echo 'selected';  } ?> >Kentucky</option>
                          <option value="LA" <?php if($Merchant) {if($Merchant['state']=='LA') echo 'selected';  } ?> >Louisiana</option>
                          <option value="ME" <?php if($Merchant) {if($Merchant['state']=='ME') echo 'selected';  } ?> >Maine</option>
                          <option value="MD" <?php if($Merchant) {if($Merchant['state']=='MD') echo 'selected';  } ?> >Maryland</option>
                          <option value="MA" <?php if($Merchant) {if($Merchant['state']=='MA') echo 'selected';  } ?> >Massachusetts</option>
                          <option value="MI" <?php if($Merchant) {if($Merchant['state']=='MI') echo 'selected';  } ?> >Michigan</option>
                          <option value="MN" <?php if($Merchant) {if($Merchant['state']=='MN') echo 'selected';  } ?> >Minnesota</option>
                          <option value="MS" <?php if($Merchant) {if($Merchant['state']=='MS') echo 'selected';  } ?> >Mississippi</option>
                          <option value="MO" <?php if($Merchant) {if($Merchant['state']=='MO') echo 'selected';  } ?> >Missouri</option>
                          <option value="MT" <?php if($Merchant) {if($Merchant['state']=='MT') echo 'selected';  } ?> >Montana</option>
                          <option value="NE" <?php if($Merchant) {if($Merchant['state']=='NE') echo 'selected';  } ?> >Nebraska</option>
                          <option value="NV" <?php if($Merchant) {if($Merchant['state']=='NV') echo 'selected';  } ?>>Nevada</option>
                          <option value="NH" <?php if($Merchant) {if($Merchant['state']=='NH') echo 'selected';  } ?> >New Hampshire</option>
                          <option value="NJ" <?php if($Merchant) {if($Merchant['state']=='NJ') echo 'selected';  } ?> >New Jersey</option>
                          <option value="NM" <?php if($Merchant) {if($Merchant['state']=='NM') echo 'selected';  } ?> >New Mexico</option>
                          <option value="NY" <?php if($Merchant) {if($Merchant['state']=='NY') echo 'selected';  } ?> >New York</option>
                          <option value="NC" <?php if($Merchant) {if($Merchant['state']=='NC') echo 'selected';  } ?> >North Carolina</option>
                          <option value="ND" <?php if($Merchant) {if($Merchant['state']=='ND') echo 'selected';  } ?> >North Dakota</option>
                          <option value="OH" <?php if($Merchant) {if($Merchant['state']=='OH') echo 'selected';  } ?> >Ohio</option>
                          <option value="OK" <?php if($Merchant) {if($Merchant['state']=='OK') echo 'selected';  } ?> >Oklahoma</option>
                          <option value="OR" <?php if($Merchant) {if($Merchant['state']=='OR') echo 'selected';  } ?> >Oregon</option>
                          <option value="PA" <?php if($Merchant) {if($Merchant['state']=='PA') echo 'selected';  } ?> >Pennsylvania</option>
                          <option value="RI" <?php if($Merchant) {if($Merchant['state']=='RI') echo 'selected';  } ?> >Rhode Island</option>
                          <option value="SC" <?php if($Merchant) {if($Merchant['state']=='SC') echo 'selected';  } ?> >South Carolina</option>
                          <option value="SD" <?php if($Merchant) {if($Merchant['state']=='SD') echo 'selected';  } ?> >South Dakota</option>
                          <option value="TN" <?php if($Merchant) {if($Merchant['state']=='TN') echo 'selected';  } ?> >Tennessee</option>
                          <option value="TX" <?php if($Merchant) {if($Merchant['state']=='TX') echo 'selected';  } ?> >Texas</option>
                          <option value="UT" <?php if($Merchant) {if($Merchant['state']=='UT') echo 'selected';  } ?> >Utah</option>
                          <option value="VT" <?php if($Merchant) {if($Merchant['state']=='VT') echo 'selected';  } ?> >Vermont</option>
                          <option value="VA" <?php if($Merchant) {if($Merchant['state']=='VA') echo 'selected';  } ?> >Virginia</option>
                          <option value="WA" <?php if($Merchant) {if($Merchant['state']=='WA') echo 'selected';  } ?> >Washington</option>
                          <option value="WV" <?php if($Merchant) {if($Merchant['state']=='WV') echo 'selected';  } ?> >West Virginia</option>
                          <option value="WI" <?php if($Merchant) {if($Merchant['state']=='WI') echo 'selected';  } ?> >Wisconsin</option>
                          <option value="WY" <?php if($Merchant) {if($Merchant['state']=='WY') echo 'selected';  } ?> >Wyoming</option>
                        </select>            
                      </div>
                      <div class="col">
                        <input type="text" class="form-control mb5" name="bsnspadd_zip" value="<?php if($Merchant) echo $Merchant['zip']; ?>"  placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Ownership Type</span>
                    <div class="form-group">             
                        <select class="form-control selectOption" name="bsns_ownrtyp"  required autocomplete="off">
                            <option value="">Select Ownership Type</option>
                            <option value="Government"  <?php if($Merchant) {if($Merchant['ownershiptype']=='Government') echo 'selected';  } ?> >Government</option>
                            <option value="LLC"  <?php if($Merchant) {if($Merchant['ownershiptype']=='LLC') echo 'selected';  } ?> >Limited Liability Company</option>
                            <option value="NonProfit"  <?php if($Merchant) {if($Merchant['ownershiptype']=='NonProfit') echo 'selected';  } ?> >Non-Profit</option>
                            <option value="Partnership"  <?php if($Merchant) {if($Merchant['ownershiptype']=='Partnership') echo 'selected';  } ?> >Partnership</option>
                            <option value="PrivateCorporation"  <?php if($Merchant) {if($Merchant['ownershiptype']=='PrivateCorporation') echo 'selected';  } ?> >Private Corporation</option>
                            <option value="PublicCorporation"  <?php if($Merchant) {if($Merchant['ownershiptype']=='PublicCorporation') echo 'selected';  } ?> >Public Corporation</option>
                            <option value="SoleProprietorship"  <?php if($Merchant) {if($Merchant['ownershiptype']=='SoleProprietorship') echo 'selected';  } ?> >Sole Proprietorship</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Business Type</span>
                    <div class="form-group">               
                        <select class="form-control selectOption" name="bsns_type"  required autocomplete="off">
                            <option value="">Select Business Type</option>
                            <!-- <option value="AutoRental"  <?php if($Merchant) {if($Merchant['business_type']=='AutoRental') echo 'selected';  } ?> >Auto Rental</option>
                            <option value="ECommerce"  <?php if($Merchant) {if($Merchant['business_type']=='ECommerce') echo 'selected';  } ?> >E-Commerce</option>
                            <option value="Lodging"  <?php if($Merchant) {if($Merchant['business_type']=='Lodging') echo 'selected';  } ?> >Lodging</option>
                            <option value="MOTO"  <?php if($Merchant) {if($Merchant['business_type']=='MOTO') echo 'selected';  } ?> >MOTO</option>
                            <option value="Restaurant"  <?php if($Merchant) {if($Merchant['business_type']=='Restaurant') echo 'selected';  } ?> >Restaurant</option>
                            <option value="Retail"  <?php if($Merchant) {if($Merchant['business_type']=='Retail') echo 'selected';  } ?> >Retail</option> -->

                            <option value="Service"  <?php if($Merchant) {if($Merchant['business_type']=='Service') echo 'selected';  } ?> >Service</option>
                            <option value="ECommerce"  <?php if($Merchant) {if($Merchant['business_type']=='ECommerce') echo 'selected';  } ?> >E-Commerce</option>
                            <option value="Restaurant"  <?php if($Merchant) {if($Merchant['business_type']=='Restaurant') echo 'selected';  } ?> >Restaurant</option>
                            <option value="Retail"  <?php if($Merchant) {if($Merchant['business_type']=='Retail') echo 'selected';  } ?> >Retail</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Business Establishment Date</span> 
                    <div class="form-group"> 
                        <div class="mdy-wraper row">
                        <div class="col">
                            <select class="form-control mb-5px selectOption" name="bsns_strtdate_m"  required>
                          <option value="">Month</option>
                          <option value="01" <?php if($Merchant['month_business']=='01') echo 'selected'; ?> >Jan</option>
                          <option value="02" <?php if($Merchant['month_business']=='02') echo 'selected'; ?>>Feb</option>
                          <option value="03" <?php if($Merchant['month_business']=='03') echo 'selected'; ?>>Mar</option>
                          <option value="04" <?php if($Merchant['month_business']=='04') echo 'selected'; ?>>Apr</option>
                          <option value="05" <?php if($Merchant['month_business']=='05') echo 'selected'; ?>>May</option>
                          <option value="06" <?php if($Merchant['month_business']=='06') echo 'selected'; ?>>Jun</option>
                          <option value="07" <?php if($Merchant['month_business']=='07') echo 'selected'; ?>>Jul</option>
                          <option value="08" <?php if($Merchant['month_business']=='08') echo 'selected'; ?>>Aug</option>
                          <option value="09" <?php if($Merchant['month_business']=='09') echo 'selected'; ?>>Sep</option>
                          <option value="10" <?php if($Merchant['month_business']=='10') echo 'selected'; ?>>Oct</option>
                          <option value="11" <?php if($Merchant['month_business']=='11') echo 'selected'; ?>>Nov</option>
                          <option value="12" <?php if($Merchant['month_business']=='12') echo 'selected'; ?>>Dec</option>
                            </select>                 
                        </div>
                        <div class="col">
                            <select class="form-control mb-5px selectOption" name="bsns_strtdate_d"  required>
                          <option value="">Day</option>
                          <option value="01" <?php if($Merchant['day_business']=='01') echo 'selected'; ?>>01</option>
                          <option value="02" <?php if($Merchant['day_business']=='02') echo 'selected'; ?>>02</option>
                          <option value="03" <?php if($Merchant['day_business']=='03') echo 'selected'; ?>>03</option>
                          <option value="04" <?php if($Merchant['day_business']=='04') echo 'selected'; ?>>04</option>
                          <option value="05" <?php if($Merchant['day_business']=='05') echo 'selected'; ?>>05</option>
                          <option value="06" <?php if($Merchant['day_business']=='06') echo 'selected'; ?>>06</option>
                          <option value="07" <?php if($Merchant['day_business']=='07') echo 'selected'; ?>>07</option>
                          <option value="08" <?php if($Merchant['day_business']=='08') echo 'selected'; ?> >08</option>
                          <option value="09" <?php if($Merchant['day_business']=='09') echo 'selected'; ?> >09</option>
                          <option value="10" <?php if($Merchant['day_business']=='10') echo 'selected'; ?>>10</option>
                          <option value="11" <?php if($Merchant['day_business']=='11') echo 'selected'; ?>>11</option>
                          <option value="12" <?php if($Merchant['day_business']=='12') echo 'selected'; ?>>12</option>
                          <option value="13" <?php if($Merchant['day_business']=='13') echo 'selected'; ?>>13</option>
                          <option value="14" <?php if($Merchant['day_business']=='14') echo 'selected'; ?>>14</option>
                          <option value="15" <?php if($Merchant['day_business']=='15') echo 'selected'; ?>>15</option>
                          <option value="16" <?php if($Merchant['day_business']=='16') echo 'selected'; ?>>16</option>
                          <option value="17" <?php if($Merchant['day_business']=='17') echo 'selected'; ?>>17</option>
                          <option value="18" <?php if($Merchant['day_business']=='18') echo 'selected'; ?>>18</option>
                          <option value="19" <?php if($Merchant['day_business']=='19') echo 'selected'; ?>>19</option>
                          <option value="20" <?php if($Merchant['day_business']=='20') echo 'selected'; ?>>20</option>
                          <option value="21" <?php if($Merchant['day_business']=='21') echo 'selected'; ?>>21</option>
                          <option value="22" <?php if($Merchant['day_business']=='22') echo 'selected'; ?> >22</option>
                          <option value="23" <?php if($Merchant['day_business']=='23') echo 'selected'; ?>>23</option>
                          <option value="24" <?php if($Merchant['day_business']=='24') echo 'selected'; ?>>24</option>
                          <option value="25" <?php if($Merchant['day_business']=='25') echo 'selected'; ?>>25</option>
                          <option value="26" <?php if($Merchant['day_business']=='26') echo 'selected'; ?>>26</option>
                          <option value="27" <?php if($Merchant['day_business']=='27') echo 'selected'; ?>>27</option>
                          <option value="28" <?php if($Merchant['day_business']=='28') echo 'selected'; ?>>28</option>
                          <option value="29" <?php if($Merchant['day_business']=='29') echo 'selected'; ?>>29</option>
                          <option value="30" <?php if($Merchant['day_business']=='30') echo 'selected'; ?>>30</option>
                          <option value="31" <?php if($Merchant['day_business']=='31') echo 'selected'; ?>>31</option>
                            </select>            
                        </div>
                        <div class="col">
                            <select class="form-control mb-5px selectOption" name="bsns_strtdate_y"  required>
                                <option value="">Year</option>
                                <?php if($Merchant['year_business']) {?>
                                    <option value="<?=$Merchant['year_business']?>"  selected><?=$Merchant['year_business']?></option>
                                <?php } ?>
                                <?php  
                                $year=date('Y');
                                $startYear=$Merchant['year_business'] ? $Merchant['year_business']+1:'1900';
                                for($i=$startYear; $startYear <=$year;  $startYear++){ ?>
                                    <option value="<?=$startYear?>"><?=$startYear?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Business Phone Number</span>
                    <div class="form-group">  
                        <input type="text" class="form-control us-phone-no" name="bsns_phone" value="<?php if($Merchant) echo $Merchant['business_number']; ?>"  placeholder="Business Phone Number" required autocomplete="off" >
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Business Email Address</span>
                    <div class="form-group">  
                        <input type="text" class="form-control email" name="bsns_email" value="<?php if($Merchant) echo $Merchant['business_email']; ?>" placeholder="Business Email Address" required autocomplete="off">
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Customer Service Phone Number</span>
                    <div class="form-group">  
                        <input type="text" class="form-control us-phone-no" name="custServ_phone" value="<?php if($Merchant) echo $Merchant['customer_service_phone']; ?>" placeholder="Customer Service Phone Number" required autocomplete="off" >
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Customer Service Email Address</span>
                    <div class="form-group">  
                        <input type="text" class="form-control email" name="custServ_email" value="<?php if($Merchant) echo $Merchant['customer_service_email']; ?>" placeholder="Customer Service Email Address" required autocomplete="off">
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Business Website</span>
                    <div class="form-group">
                        <!-- <input type="text" class="form-control" name="bsns_website" value="<?php if($Merchant) echo $Merchant['website']; ?>"  placeholder="https://www.yourwebsite.com" required autocomplete="off"> -->
                        <?php
                        // if(!empty($Merchant['website'])) {
                        //     $website = $Merchant['website'];
                        // } else {
                        //     $website = 'www.';
                        // } 
                        ?>
                        <input type="text" class="form-control" name="bsns_website" value="<?php echo !empty($Merchant['website']) ? $Merchant['website'] : ''; ?>" placeholder="https://www.yourwebsite.com" autocomplete="off">
                    </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Estimated Annual Processing Volume</span>
                    <div class="form-group">
                        <!-- <select class="form-control selectOption" name="mepvolume" required> -->
                        <select class="form-control" name="mepvolume" required style="color: #adb5c7 !important;">
                      <option value="">Estimated Annual Processing Volume</option>
                      <option value="10000" <?php if($Merchant['annual_processing_volume']=='10000') echo 'selected'; ?> >$10,000</option>
                      <option value="20000" <?php if($Merchant['annual_processing_volume']=='20000') echo 'selected'; ?> >$20,000</option>
                      <option value="30000" <?php if($Merchant['annual_processing_volume']=='30000') echo 'selected'; ?> >$30,000</option>
                      <option value="40000" <?php if($Merchant['annual_processing_volume']=='40000') echo 'selected'; ?> >$40,000</option>
                      <option value="50000" <?php if($Merchant['annual_processing_volume']=='50000') echo 'selected'; ?> >$50,000</option>
                      <option value="60000" <?php if($Merchant['annual_processing_volume']=='60000') echo 'selected'; ?> >$60,000</option>
                      <option value="70000" <?php if($Merchant['annual_processing_volume']=='70000') echo 'selected'; ?> >$70,000</option>
                      <option value="80000" <?php if($Merchant['annual_processing_volume']=='80000') echo 'selected'; ?> >$80,000</option>
                      <option value="90000" <?php if($Merchant['annual_processing_volume']=='90000') echo 'selected'; ?> >$90,000</option>
                      <option value="100000" <?php if($Merchant['annual_processing_volume']=='100000') echo 'selected'; ?> >$100,000+</option>
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
                <!-- <div class="col-12 text-right" style="margin-bottom: 10px !important;">
                    <button type="button" class="btn btn-primary add_more_owner">Add Owner <i class="fa fa-plus"></i></button>
                </div> -->
                <?php function convertSSN($ssn_no) {
                    $encPlaceh = '';
                    if($ssn_no) {
                        $ttlL = strlen($ssn_no);
                        for ($ss_i = 0; $ss_i < $ttlL; $ss_i++) {
                            if($ss_i == 3 || $ss_i == 6) {
                                $encPlaceh .= '-';

                            } else if($ss_i <= 5) {
                                $encPlaceh .= 'x';

                            } else {
                                $ss_i = $ttlL;
                                $encPlaceh .= substr($ssn_no, 5, $ttlL-1);
                            }
                        }
                    }
                    return $encPlaceh;
                } ?>
                <div class="col-12 busi_owners_list">
                    <?php if($Merchant) {
                        if(!empty($business_owner)) { ?>
                            <div class="busi_owner_row row">
                                <input type="hidden" class="rowHiddenInput" data-owner_id="<?= $Merchant['id']; ?>">
                                <div class="col-2">
                                    <div class="owner_list_icon">
                                        <span class="owner_list_icon_span"><?= ucfirst(substr($Merchant['name'], 0, 1)); ?></span>
                                    </div>
                                </div>
                                <div class="col-8" style="display: grid;">
                                    <span class="owner_list_name"><?= ucfirst($Merchant['name']).' '.ucfirst($Merchant['m_name']).' '.ucfirst($Merchant['l_name']) ?></span>
                                    <?php
                                     ?>
                                    <span class="owner_list_email"><?= convertSSN($Merchant['o_ss_number']); ?></span>
                                    <span class="owner_list_email"><?= $Merchant['o_email']; ?></span>
                                </div>
                            </div>
                        <?php }
                    }

                    if(!empty($business_owner)) {
                        $owner_length = sizeof($business_owner);
                        for ($o_index = 1; $o_index <= $owner_length-1; $o_index++) { ?>
                            <div class="busi_owner_row row">
                                <input type="hidden" class="rowHiddenInput" data-owner_id="<?= $business_owner[$o_index-1]['id']; ?>">
                                <div class="col-2">
                                    <div class="owner_list_icon">
                                        <span class="owner_list_icon_span"><?= ucfirst(substr($business_owner[$o_index-1]['name_arr'], 0, 1)); ?></span>
                                    </div>
                                </div>
                                <div class="col-8" style="display: grid;">
                                    <span class="owner_list_name"><?= ucfirst($business_owner[$o_index-1]['name_arr']).' '.ucfirst($business_owner[$o_index-1]['m_name_arr']).' '.ucfirst($business_owner[$o_index-1]['l_name_arr']) ?></span>
                                    <?php
                                     ?>
                                    <span class="owner_list_email"><?= convertSSN($business_owner[$o_index-1]['o_ss_number_arr']); ?></span>
                                    <span class="owner_list_email"><?= $business_owner[$o_index-1]['o_email_arr']; ?></span>
                                </div>
                                <div class="col-2 text-center">
                                    <button type="button" class="btn delete_owner"><i class="fa fa-minus-circle" style="color: #d93025;font-size: 20px;"></i></button>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>

                <div class="busi_owner_inputs">
                    <?php if(!empty($Merchant)) { ?>
                        <div class="first_busi_owner_section <?php echo (!empty($business_owner) ? 'd-none' : 'pointer') ?>">
                            <div class="col-12">
                              <span class="cs-label">Name</span>
                              <div class="form-group">             
                                <div class="fmlname row">
                                    <div class="col">
                                      <input type="text" class="form-control cl_foname1" value="<?php if($Merchant) echo $Merchant['name']; ?>" name="foname1" placeholder="First" required autocomplete="off">
                                    </div>
                                    <div class="col">
                                      <input type="text" class="form-control cl_foname2" value="<?php if($Merchant) echo $Merchant['m_name']; ?>" name="foname2" placeholder="Middle"  autocomplete="off">
                                    </div>
                                    <div class="col">
                                      <input type="text" class="form-control cl_foname3" value="<?php if($Merchant) echo $Merchant['l_name']; ?>" name="foname3" placeholder="Last"  autocomplete="off">
                                    </div>
                                </div>
                              </div>
                            </div>
                            <?php if($Merchant) {
                              $o_question_check = ( ($Merchant['o_question'] != '') && ($Merchant['o_question'] == 'True') ) ? 'checked' : '';
                              $o_question_check_val = ( ($Merchant['o_question'] != '') && ($Merchant['o_question'] == 'True') ) ? '1' : '0';

                              $is_primary_owner = ( ($Merchant['is_primary_owner'] != '') && ($Merchant['is_primary_owner'] == 'True') ) ? 'checked' : '';
                              $is_primary_owner_val = ( ($Merchant['is_primary_owner'] != '') && ($Merchant['is_primary_owner'] == 'True') ) ? '1' : '0'; ?>

                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="o_question" class="form-control owner_check" style="height: 15px !important;width: auto !important;" <?php echo $o_question_check; ?> value="<?php echo $o_question_check_val; ?>"> <span class="cs-label" style="margin-left:10px;">Are there any owners with 25% or more ownership?</span>
                              </div>
                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="is_primary_owner" class="form-control owner_check" style="height: 15px !important;width: auto !important;" <?php echo $is_primary_owner; ?> value="<?php echo $is_primary_owner_val; ?>"> <span class="cs-label" style="margin-left:10px;">Is this person the control prong?</span>
                              </div>

                            <?php } else { ?>
                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="o_question" class="form-control owner_check" style="height: 15px !important;width: auto !important;"  value="0"> <span class="cs-label" style="margin-left:10px;">Are there any owners with 25% or more ownership?</span>
                              </div>
                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="is_primary_owner" class="form-control owner_check" style="height: 15px !important;width: auto !important;"  value="0"> <span class="cs-label" style="margin-left:10px;">Is this person the control prong?</span>
                              </div>
                            <?php } ?>

                            <div class="col-12">
                              <span class="cs-label">SSN</span>
                              <div class="form-group">
                                <input type="text" class="form-control us-ssn-no-enc cl_fossn" name="fossn" value="<?php if($Merchant) echo $Merchant['o_ss_number']; ?>"  placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11">
                              </div>
                            </div>
                            <div class="col-12">
                              <span class="cs-label">Ownership Percentage</span>
                              <div class="form-group">
                                <input type="text" class="form-control" name="o_percentage" value="<?php if($Merchant) echo $Merchant['o_percentage']; ?>"  placeholder="Ownership Percentage" required onkeypress="return isNumberKey(event)">
                              </div>
                            </div>
                            <div class="col-12">
                              <span class="cs-label">Date of Birth</span>           
                              <div class="form-group">        
                                <div class="mdy-wraper row">
                                  <div class="col">
                                    <select class="form-control mb-1 selectOption cl_fodobm" name="fodobm"  required>
                                      <option value="">Month</option>
                                      <option value="01" <?php if($Merchant['o_dob_m']=='01') echo 'selected'; ?> >Jan</option>
                                      <option value="02" <?php if($Merchant['o_dob_m']=='02') echo 'selected'; ?>>Feb</option>
                                      <option value="03" <?php if($Merchant['o_dob_m']=='03') echo 'selected'; ?>>Mar</option>
                                      <option value="04" <?php if($Merchant['o_dob_m']=='04') echo 'selected'; ?>>Apr</option>
                                      <option value="05" <?php if($Merchant['o_dob_m']=='05') echo 'selected'; ?>>May</option>
                                      <option value="06" <?php if($Merchant['o_dob_m']=='06') echo 'selected'; ?>>Jun</option>
                                      <option value="07" <?php if($Merchant['o_dob_m']=='07') echo 'selected'; ?>>Jul</option>
                                      <option value="08" <?php if($Merchant['o_dob_m']=='08') echo 'selected'; ?>>Aug</option>
                                      <option value="09" <?php if($Merchant['o_dob_m']=='09') echo 'selected'; ?>>Sep</option>
                                      <option value="10" <?php if($Merchant['o_dob_m']=='10') echo 'selected'; ?>>Oct</option>
                                      <option value="11" <?php if($Merchant['o_dob_m']=='11') echo 'selected'; ?>>Nov</option>
                                      <option value="12" <?php if($Merchant['o_dob_m']=='12') echo 'selected'; ?>>Dec</option>
                                    </select>                 
                                  </div>
                                  <div class="col">
                                    <select class="form-control mb-1 selectOption cl_fodobd" name="fodobd"  required>
                                      <option value="">Day</option>
                                      <option value="01" <?php if($Merchant['o_dob_d']=='01') echo 'selected'; ?>>01</option>
                                      <option value="02" <?php if($Merchant['o_dob_d']=='02') echo 'selected'; ?>>02</option>
                                      <option value="03" <?php if($Merchant['o_dob_d']=='03') echo 'selected'; ?>>03</option>
                                      <option value="04" <?php if($Merchant['o_dob_d']=='04') echo 'selected'; ?>>04</option>
                                      <option value="05" <?php if($Merchant['o_dob_d']=='05') echo 'selected'; ?>>05</option>
                                      <option value="06" <?php if($Merchant['o_dob_d']=='06') echo 'selected'; ?>>06</option>
                                      <option value="07" <?php if($Merchant['o_dob_d']=='07') echo 'selected'; ?>>07</option>
                                      <option value="08" <?php if($Merchant['o_dob_d']=='08') echo 'selected'; ?> >08</option>
                                      <option value="09" <?php if($Merchant['o_dob_d']=='09') echo 'selected'; ?> >09</option>
                                      <option value="10" <?php if($Merchant['o_dob_d']=='10') echo 'selected'; ?>>10</option>
                                      <option value="11" <?php if($Merchant['o_dob_d']=='11') echo 'selected'; ?>>11</option>
                                      <option value="12" <?php if($Merchant['o_dob_d']=='12') echo 'selected'; ?>>12</option>
                                      <option value="13" <?php if($Merchant['o_dob_d']=='13') echo 'selected'; ?>>13</option>
                                      <option value="14" <?php if($Merchant['o_dob_d']=='14') echo 'selected'; ?>>14</option>
                                      <option value="15" <?php if($Merchant['o_dob_d']=='15') echo 'selected'; ?>>15</option>
                                      <option value="16" <?php if($Merchant['o_dob_d']=='16') echo 'selected'; ?>>16</option>
                                      <option value="17" <?php if($Merchant['o_dob_d']=='17') echo 'selected'; ?>>17</option>
                                      <option value="18" <?php if($Merchant['o_dob_d']=='18') echo 'selected'; ?>>18</option>
                                      <option value="19" <?php if($Merchant['o_dob_d']=='19') echo 'selected'; ?>>19</option>
                                      <option value="20" <?php if($Merchant['o_dob_d']=='20') echo 'selected'; ?>>20</option>
                                      <option value="21" <?php if($Merchant['o_dob_d']=='21') echo 'selected'; ?>>21</option>
                                      <option value="22" <?php if($Merchant['o_dob_d']=='22') echo 'selected'; ?> >22</option>
                                      <option value="23" <?php if($Merchant['o_dob_d']=='23') echo 'selected'; ?>>23</option>
                                      <option value="24" <?php if($Merchant['o_dob_d']=='24') echo 'selected'; ?>>24</option>
                                      <option value="25" <?php if($Merchant['o_dob_d']=='25') echo 'selected'; ?>>25</option>
                                      <option value="26" <?php if($Merchant['o_dob_d']=='26') echo 'selected'; ?>>26</option>
                                      <option value="27" <?php if($Merchant['o_dob_d']=='27') echo 'selected'; ?>>27</option>
                                      <option value="28" <?php if($Merchant['o_dob_d']=='28') echo 'selected'; ?>>28</option>
                                      <option value="29" <?php if($Merchant['o_dob_d']=='29') echo 'selected'; ?>>29</option>
                                      <option value="30" <?php if($Merchant['o_dob_d']=='30') echo 'selected'; ?>>30</option>
                                      <option value="31" <?php if($Merchant['o_dob_d']=='31') echo 'selected'; ?>>31</option>
                                    </select>            
                                  </div>
                                  <div class="col">
                                    <select class="form-control mb-1 selectOption cl_fodoby" name="fodoby" required>
                                      <option value="">Year</option>
                                      <?php if($Merchant['o_dob_y']){?>
                                      <option value="<?=$Merchant['o_dob_y']?>" selected><?=$Merchant['o_dob_y']?></option>
                                      <?php } ?>
                                      <?php  
                                      $year=date('Y');
                                      $startYear=$Merchant['o_dob_y'] ? $Merchant['o_dob_y']-10 : '1900'; 
                                      for($i=$startYear; $startYear <=$year;  $startYear++){ ?>
                                          <option value="<?=$startYear?>"><?=$startYear?></option>
                                      <?php } ?>
                                    </select>     
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <span class="cs-label">Home Address</span>                          
                              <div class="form-group mb-5px">  
                                <select class="form-control selectOption cl_fohadd_cntry" name="fohadd_cntry" required autocomplete="off">
                                  <option value="">Select Country</option>
                                  <option value="USA" <?php if($Merchant['o_country']=='USA') echo 'selected'; ?> >United States of America</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group mb-5px">           
                                <input type="text" class="form-control cl_fohadd_1" name="fohadd_1" value="<?php if($Merchant) echo $Merchant['o_address1']; ?>"  placeholder="Enter Address 1" required autocomplete="off">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group mb-5px">           
                                <input type="text" class="form-control cl_fohadd_2" name="fohadd_2" value="<?php if($Merchant) echo $Merchant['o_address2']; ?>"  placeholder="Enter Address 2"  autocomplete="off">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">           
                                <div class="csz row">
                                  <div class="col">
                                    <input type="text" class="form-control mb5 cl_fohadd_city" name="fohadd_city" value="<?php if($Merchant) echo $Merchant['o_city']; ?>"  placeholder="City" required autocomplete="off">              
                                  </div>
                                  <div class="col">
                                    <select class="form-control mb5 selectOption cl_fohadd_state" name="fohadd_state"  required>
                                      <option value="">Select State</option>
                                      <option value="AL" <?php if($Merchant) {if($Merchant['o_state']=='AL') echo 'selected';  } ?> >Alabama</option>
                                      <option value="AK" <?php if($Merchant) {if($Merchant['o_state']=='AK') echo 'selected';  } ?> >Alaska</option>
                                      <option value="AZ" <?php if($Merchant) {if($Merchant['o_state']=='AZ') echo 'selected';  } ?> >Arizona</option>
                                      <option value="AR" <?php if($Merchant) {if($Merchant['o_state']=='AR') echo 'selected';  } ?> >Arkansas</option>
                                      <option value="CA" <?php if($Merchant) {if($Merchant['o_state']=='CA') echo 'selected';  } ?> >California</option>
                                      <option value="CO" <?php if($Merchant) {if($Merchant['o_state']=='CO') echo 'selected';  } ?>>Colorado</option>
                                      <option value="CT" <?php if($Merchant) {if($Merchant['o_state']=='CT') echo 'selected';  } ?>>Connecticut</option>
                                      <option value="DE" <?php if($Merchant) {if($Merchant['o_state']=='DE') echo 'selected';  } ?>>Delaware</option>
                                      <option value="DC" <?php if($Merchant) {if($Merchant['o_state']=='DC') echo 'selected';  } ?>>District Of Columbia</option>
                                      <option value="FL" <?php if($Merchant) {if($Merchant['o_state']=='FL') echo 'selected';  } ?>>Florida</option>
                                      <option value="GA" <?php if($Merchant) {if($Merchant['o_state']=='GA') echo 'selected';  } ?>>Georgia</option>
                                      <option value="HI" <?php if($Merchant) {if($Merchant['o_state']=='HI') echo 'selected';  } ?> >Hawaii</option>
                                      <option value="ID" <?php if($Merchant) {if($Merchant['o_state']=='ID') echo 'selected';  } ?> >Idaho</option>
                                      <option value="IL" <?php if($Merchant) {if($Merchant['o_state']=='IL') echo 'selected';  } ?> >Illinois</option>
                                      <option value="IN" <?php if($Merchant) {if($Merchant['o_state']=='IN') echo 'selected';  } ?> >Indiana</option>
                                      <option value="IA" <?php if($Merchant) {if($Merchant['o_state']=='IA') echo 'selected';  } ?> >Iowa</option>
                                      <option value="KS" <?php if($Merchant) {if($Merchant['o_state']=='KS') echo 'selected';  } ?> >Kansas</option>
                                      <option value="KY" <?php if($Merchant) {if($Merchant['o_state']=='KY') echo 'selected';  } ?> >Kentucky</option>
                                      <option value="LA" <?php if($Merchant) {if($Merchant['o_state']=='LA') echo 'selected';  } ?> >Louisiana</option>
                                      <option value="ME" <?php if($Merchant) {if($Merchant['o_state']=='ME') echo 'selected';  } ?> >Maine</option>
                                      <option value="MD" <?php if($Merchant) {if($Merchant['o_state']=='MD') echo 'selected';  } ?> >Maryland</option>
                                      <option value="MA" <?php if($Merchant) {if($Merchant['o_state']=='MA') echo 'selected';  } ?> >Massachusetts</option>
                                      <option value="MI" <?php if($Merchant) {if($Merchant['o_state']=='MI') echo 'selected';  } ?> >Michigan</option>
                                      <option value="MN" <?php if($Merchant) {if($Merchant['o_state']=='MN') echo 'selected';  } ?> >Minnesota</option>
                                      <option value="MS" <?php if($Merchant) {if($Merchant['o_state']=='MS') echo 'selected';  } ?> >Mississippi</option>
                                      <option value="MO" <?php if($Merchant) {if($Merchant['o_state']=='MO') echo 'selected';  } ?> >Missouri</option>
                                      <option value="MT" <?php if($Merchant) {if($Merchant['o_state']=='MT') echo 'selected';  } ?> >Montana</option>
                                      <option value="NE" <?php if($Merchant) {if($Merchant['o_state']=='NE') echo 'selected';  } ?> >Nebraska</option>
                                      <option value="NV" <?php if($Merchant) {if($Merchant['o_state']=='NV') echo 'selected';  } ?>>Nevada</option>
                                      <option value="NH" <?php if($Merchant) {if($Merchant['o_state']=='NH') echo 'selected';  } ?> >New Hampshire</option>
                                      <option value="NJ" <?php if($Merchant) {if($Merchant['o_state']=='NJ') echo 'selected';  } ?> >New Jersey</option>
                                      <option value="NM" <?php if($Merchant) {if($Merchant['o_state']=='NM') echo 'selected';  } ?> >New Mexico</option>
                                      <option value="NY" <?php if($Merchant) {if($Merchant['o_state']=='NY') echo 'selected';  } ?> >New York</option>
                                      <option value="NC" <?php if($Merchant) {if($Merchant['o_state']=='NC') echo 'selected';  } ?> >North Carolina</option>
                                      <option value="ND" <?php if($Merchant) {if($Merchant['o_state']=='ND') echo 'selected';  } ?> >North Dakota</option>
                                      <option value="OH" <?php if($Merchant) {if($Merchant['o_state']=='OH') echo 'selected';  } ?> >Ohio</option>
                                      <option value="OK" <?php if($Merchant) {if($Merchant['o_state']=='OK') echo 'selected';  } ?> >Oklahoma</option>
                                      <option value="OR" <?php if($Merchant) {if($Merchant['o_state']=='OR') echo 'selected';  } ?> >Oregon</option>
                                      <option value="PA" <?php if($Merchant) {if($Merchant['o_state']=='PA') echo 'selected';  } ?> >Pennsylvania</option>
                                      <option value="RI" <?php if($Merchant) {if($Merchant['o_state']=='RI') echo 'selected';  } ?> >Rhode Island</option>
                                      <option value="SC" <?php if($Merchant) {if($Merchant['o_state']=='SC') echo 'selected';  } ?> >South Carolina</option>
                                      <option value="SD" <?php if($Merchant) {if($Merchant['o_state']=='SD') echo 'selected';  } ?> >South Dakota</option>
                                      <option value="TN" <?php if($Merchant) {if($Merchant['o_state']=='TN') echo 'selected';  } ?> >Tennessee</option>
                                      <option value="TX" <?php if($Merchant) {if($Merchant['o_state']=='TX') echo 'selected';  } ?> >Texas</option>
                                      <option value="UT" <?php if($Merchant) {if($Merchant['o_state']=='UT') echo 'selected';  } ?> >Utah</option>
                                      <option value="VT" <?php if($Merchant) {if($Merchant['o_state']=='VT') echo 'selected';  } ?> >Vermont</option>
                                      <option value="VA" <?php if($Merchant) {if($Merchant['o_state']=='VA') echo 'selected';  } ?> >Virginia</option>
                                      <option value="WA" <?php if($Merchant) {if($Merchant['o_state']=='WA') echo 'selected';  } ?> >Washington</option>
                                      <option value="WV" <?php if($Merchant) {if($Merchant['o_state']=='WV') echo 'selected';  } ?> >West Virginia</option>
                                      <option value="WI" <?php if($Merchant) {if($Merchant['o_state']=='WI') echo 'selected';  } ?> >Wisconsin</option>
                                      <option value="WY" <?php if($Merchant) {if($Merchant['o_state']=='WY') echo 'selected';  } ?> >Wyoming</option>
                                    </select>            
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control mb5 cl_fohadd_zip" name="fohadd_zip" value="<?php if($Merchant) echo $Merchant['o_zip']; ?>"  placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Owner Phone Number</span>
                              <div class="form-group">   
                                <input type="text" class="form-control us-phone-no cl_fo_phone" value="<?php if($Merchant) echo $Merchant['o_phone']; ?>" name="fo_phone" placeholder="Owner Phone Number" required autocomplete="off" >
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Owner Email Address</span>
                              <div class="form-group">   
                                <input type="text" class="form-control email cl_fo_email" value="<?php if($Merchant) echo $Merchant['o_email']; ?>" name="fo_email" placeholder="Owner Email Address" required autocomplete="off">
                              </div>
                            </div>
                            <!-- <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary save_owner">Add</button>
                            </div> -->
                            <hr class="custom_hr">
                        </div>
                    <?php } else { ?>
                        <div class="first_busi_owner_section pointer">
                            <div class="col-12">
                              <span class="cs-label">Name</span> 
                              <div class="form-group">             
                                <div class="fmlname row">
                                    <div class="col">
                                      <input type="text" class="form-control cl_foname1" value="<?php if($Merchant) echo $Merchant['name']; ?>" name="foname1" placeholder="First" required autocomplete="off">
                                    </div>
                                    <div class="col">
                                      <input type="text" class="form-control cl_foname2" value="<?php if($Merchant) echo $Merchant['m_name']; ?>" name="foname2" placeholder="Middle"  autocomplete="off">
                                    </div>
                                    <div class="col">
                                      <input type="text" class="form-control cl_foname3" value="<?php if($Merchant) echo $Merchant['l_name']; ?>" name="foname3" placeholder="Last"  autocomplete="off">
                                    </div>
                                </div>
                              </div>
                            </div>
                            <?php if($Merchant) {
                              $o_question_check = ( ($Merchant['o_question'] != '') || ($Merchant['o_question'] == 'True') ) ? 'checked' : '';
                              $o_question_check_val = ( ($Merchant['o_question'] != '') || ($Merchant['o_question'] == 'True') ) ? '1' : '0';

                              $is_primary_owner = ( ($Merchant['is_primary_owner'] != '') || ($Merchant['is_primary_owner'] == 'True') ) ? 'checked' : '';
                              $is_primary_owner_val = ( ($Merchant['is_primary_owner'] != '') || ($Merchant['is_primary_owner'] == 'True') ) ? '1' : '0';
                              ?>
                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="o_question" class="form-control owner_check" style="height: 15px !important;width: auto !important;" <?php echo $o_question_check; ?> value="<?php echo $o_question_check_val; ?>"> <span class="cs-label" style="margin-left:10px;">Are there any owners with 25% or more ownership?</span>
                              </div>
                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="is_primary_owner" class="form-control owner_check" style="height: 15px !important;width: auto !important;" <?php echo $is_primary_owner; ?> value="<?php echo $is_primary_owner_val; ?>"> <span class="cs-label" style="margin-left:10px;">Is this person the control prong?</span>
                              </div>
                            <?php } else { ?>
                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="o_question" class="form-control owner_check" style="height: 15px !important;width: auto !important;"  value="0"> <span class="cs-label" style="margin-left:10px;">Are there any owners with 25% or more ownership?</span>
                              </div>
                              <div class="col-12" style="display: inline-flex !important;">
                                <input type="checkbox" name="is_primary_owner" class="form-control owner_check" style="height: 15px !important;width: auto !important;"  value="0"> <span class="cs-label" style="margin-left:10px;">Is this person the control prong?</span>
                              </div>
                            <?php } ?>
                            
                            <div class="col-12">
                                <span class="cs-label">SSN</span>
                              <div class="form-group">
                                <input type="text" class="form-control us-ssn-no-enc cl_fossn" name="fossn" value="<?php if($Merchant) echo $Merchant['o_ss_number']; ?>"  placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11">
                              </div>
                            </div>
                            <div class="col-12">
                              <span class="cs-label">Ownership Percentage</span>
                              <div class="form-group">
                                <input type="text" class="form-control" name="o_percentage" value="<?php if($Merchant) echo $Merchant['o_percentage']; ?>"  placeholder="Ownership Percentage" required onkeypress="return isNumberKey(event)">
                              </div>
                            </div>
                            <div class="col-12">
                              <span class="cs-label">Date of Birth</span>           
                              <div class="form-group">        
                                <div class="mdy-wraper row">
                                  <div class="col">
                                    <select class="form-control mb-1 selectOption cl_fodobm" name="fodobm"  required>
                                      <option value="">Month</option>
                                      <option value="01" <?php if($Merchant['o_dob_m']=='01') echo 'selected'; ?> >Jan</option>
                                      <option value="02" <?php if($Merchant['o_dob_m']=='02') echo 'selected'; ?>>Feb</option>
                                      <option value="03" <?php if($Merchant['o_dob_m']=='03') echo 'selected'; ?>>Mar</option>
                                      <option value="04" <?php if($Merchant['o_dob_m']=='04') echo 'selected'; ?>>Apr</option>
                                      <option value="05" <?php if($Merchant['o_dob_m']=='05') echo 'selected'; ?>>May</option>
                                      <option value="06" <?php if($Merchant['o_dob_m']=='06') echo 'selected'; ?>>Jun</option>
                                      <option value="07" <?php if($Merchant['o_dob_m']=='07') echo 'selected'; ?>>Jul</option>
                                      <option value="08" <?php if($Merchant['o_dob_m']=='08') echo 'selected'; ?>>Aug</option>
                                      <option value="09" <?php if($Merchant['o_dob_m']=='09') echo 'selected'; ?>>Sep</option>
                                      <option value="10" <?php if($Merchant['o_dob_m']=='10') echo 'selected'; ?>>Oct</option>
                                      <option value="11" <?php if($Merchant['o_dob_m']=='11') echo 'selected'; ?>>Nov</option>
                                      <option value="12" <?php if($Merchant['o_dob_m']=='12') echo 'selected'; ?>>Dec</option>
                                    </select>                 
                                  </div>
                                  <div class="col">
                                    <select class="form-control mb-1 selectOption cl_fodobd" name="fodobd"  required>
                                      <option value="">Day</option>
                                      <option value="01" <?php if($Merchant['o_dob_d']=='01') echo 'selected'; ?>>01</option>
                                      <option value="02" <?php if($Merchant['o_dob_d']=='02') echo 'selected'; ?>>02</option>
                                      <option value="03" <?php if($Merchant['o_dob_d']=='03') echo 'selected'; ?>>03</option>
                                      <option value="04" <?php if($Merchant['o_dob_d']=='04') echo 'selected'; ?>>04</option>
                                      <option value="05" <?php if($Merchant['o_dob_d']=='05') echo 'selected'; ?>>05</option>
                                      <option value="06" <?php if($Merchant['o_dob_d']=='06') echo 'selected'; ?>>06</option>
                                      <option value="07" <?php if($Merchant['o_dob_d']=='07') echo 'selected'; ?>>07</option>
                                      <option value="08" <?php if($Merchant['o_dob_d']=='08') echo 'selected'; ?> >08</option>
                                      <option value="09" <?php if($Merchant['o_dob_d']=='09') echo 'selected'; ?> >09</option>
                                      <option value="10" <?php if($Merchant['o_dob_d']=='10') echo 'selected'; ?>>10</option>
                                      <option value="11" <?php if($Merchant['o_dob_d']=='11') echo 'selected'; ?>>11</option>
                                      <option value="12" <?php if($Merchant['o_dob_d']=='12') echo 'selected'; ?>>12</option>
                                      <option value="13" <?php if($Merchant['o_dob_d']=='13') echo 'selected'; ?>>13</option>
                                      <option value="14" <?php if($Merchant['o_dob_d']=='14') echo 'selected'; ?>>14</option>
                                      <option value="15" <?php if($Merchant['o_dob_d']=='15') echo 'selected'; ?>>15</option>
                                      <option value="16" <?php if($Merchant['o_dob_d']=='16') echo 'selected'; ?>>16</option>
                                      <option value="17" <?php if($Merchant['o_dob_d']=='17') echo 'selected'; ?>>17</option>
                                      <option value="18" <?php if($Merchant['o_dob_d']=='18') echo 'selected'; ?>>18</option>
                                      <option value="19" <?php if($Merchant['o_dob_d']=='19') echo 'selected'; ?>>19</option>
                                      <option value="20" <?php if($Merchant['o_dob_d']=='20') echo 'selected'; ?>>20</option>
                                      <option value="21" <?php if($Merchant['o_dob_d']=='21') echo 'selected'; ?>>21</option>
                                      <option value="22" <?php if($Merchant['o_dob_d']=='22') echo 'selected'; ?> >22</option>
                                      <option value="23" <?php if($Merchant['o_dob_d']=='23') echo 'selected'; ?>>23</option>
                                      <option value="24" <?php if($Merchant['o_dob_d']=='24') echo 'selected'; ?>>24</option>
                                      <option value="25" <?php if($Merchant['o_dob_d']=='25') echo 'selected'; ?>>25</option>
                                      <option value="26" <?php if($Merchant['o_dob_d']=='26') echo 'selected'; ?>>26</option>
                                      <option value="27" <?php if($Merchant['o_dob_d']=='27') echo 'selected'; ?>>27</option>
                                      <option value="28" <?php if($Merchant['o_dob_d']=='28') echo 'selected'; ?>>28</option>
                                      <option value="29" <?php if($Merchant['o_dob_d']=='29') echo 'selected'; ?>>29</option>
                                      <option value="30" <?php if($Merchant['o_dob_d']=='30') echo 'selected'; ?>>30</option>
                                      <option value="31" <?php if($Merchant['o_dob_d']=='31') echo 'selected'; ?>>31</option>
                                    </select>            
                                  </div>
                                  <div class="col">
                                    <select class="form-control mb-1 selectOption cl_fodoby" name="fodoby" required>
                                      <option value="">Year</option>
                                      <?php if($Merchant['o_dob_y']){?>
                                      <option value="<?=$Merchant['o_dob_y']?>" selected><?=$Merchant['o_dob_y']?></option>
                                      <?php } ?>
                                      <?php  
                                      $year=date('Y');
                                      $startYear=$Merchant['o_dob_y'] ? $Merchant['o_dob_y']-10 : '1900'; 
                                      for($i=$startYear; $startYear <=$year;  $startYear++){ ?>
                                          <option value="<?=$startYear?>"><?=$startYear?></option>
                                      <?php } ?>
                                    </select>     
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <span class="cs-label">Home Address</span>
                              <div class="form-group mb-5px">  
                                <select class="form-control selectOption cl_fohadd_cntry" name="fohadd_cntry" required autocomplete="off">
                                  <option value="">Select Country</option>
                                  <option value="USA" <?php if($Merchant['o_country']=='USA') echo 'selected'; ?> >United States of America</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group mb-5px">           
                                <input type="text" class="form-control cl_fohadd_1" name="fohadd_1" value="<?php if($Merchant) echo $Merchant['o_address1']; ?>"  placeholder="Enter Address 1" required autocomplete="off">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group mb-5px">           
                                <input type="text" class="form-control cl_fohadd_2" name="fohadd_2" value="<?php if($Merchant) echo $Merchant['o_address2']; ?>"  placeholder="Enter Address 2"  autocomplete="off">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">           
                                <div class="csz row">
                                  <div class="col">
                                    <input type="text" class="form-control mb5 cl_fohadd_city" name="fohadd_city" value="<?php if($Merchant) echo $Merchant['o_city']; ?>"  placeholder="City" required autocomplete="off">              
                                  </div>
                                  <div class="col">
                                    <select class="form-control mb5 selectOption cl_fohadd_state" name="fohadd_state"  required>
                                      <option value="">Select State</option>
                                      <option value="AL" <?php if($Merchant) {if($Merchant['o_state']=='AL') echo 'selected';  } ?> >Alabama</option>
                                      <option value="AK" <?php if($Merchant) {if($Merchant['o_state']=='AK') echo 'selected';  } ?> >Alaska</option>
                                      <option value="AZ" <?php if($Merchant) {if($Merchant['o_state']=='AZ') echo 'selected';  } ?> >Arizona</option>
                                      <option value="AR" <?php if($Merchant) {if($Merchant['o_state']=='AR') echo 'selected';  } ?> >Arkansas</option>
                                      <option value="CA" <?php if($Merchant) {if($Merchant['o_state']=='CA') echo 'selected';  } ?> >California</option>
                                      <option value="CO" <?php if($Merchant) {if($Merchant['o_state']=='CO') echo 'selected';  } ?>>Colorado</option>
                                      <option value="CT" <?php if($Merchant) {if($Merchant['o_state']=='CT') echo 'selected';  } ?>>Connecticut</option>
                                      <option value="DE" <?php if($Merchant) {if($Merchant['o_state']=='DE') echo 'selected';  } ?>>Delaware</option>
                                      <option value="DC" <?php if($Merchant) {if($Merchant['o_state']=='DC') echo 'selected';  } ?>>District Of Columbia</option>
                                      <option value="FL" <?php if($Merchant) {if($Merchant['o_state']=='FL') echo 'selected';  } ?>>Florida</option>
                                      <option value="GA" <?php if($Merchant) {if($Merchant['o_state']=='GA') echo 'selected';  } ?>>Georgia</option>
                                      <option value="HI" <?php if($Merchant) {if($Merchant['o_state']=='HI') echo 'selected';  } ?> >Hawaii</option>
                                      <option value="ID" <?php if($Merchant) {if($Merchant['o_state']=='ID') echo 'selected';  } ?> >Idaho</option>
                                      <option value="IL" <?php if($Merchant) {if($Merchant['o_state']=='IL') echo 'selected';  } ?> >Illinois</option>
                                      <option value="IN" <?php if($Merchant) {if($Merchant['o_state']=='IN') echo 'selected';  } ?> >Indiana</option>
                                      <option value="IA" <?php if($Merchant) {if($Merchant['o_state']=='IA') echo 'selected';  } ?> >Iowa</option>
                                      <option value="KS" <?php if($Merchant) {if($Merchant['o_state']=='KS') echo 'selected';  } ?> >Kansas</option>
                                      <option value="KY" <?php if($Merchant) {if($Merchant['o_state']=='KY') echo 'selected';  } ?> >Kentucky</option>
                                      <option value="LA" <?php if($Merchant) {if($Merchant['o_state']=='LA') echo 'selected';  } ?> >Louisiana</option>
                                      <option value="ME" <?php if($Merchant) {if($Merchant['o_state']=='ME') echo 'selected';  } ?> >Maine</option>
                                      <option value="MD" <?php if($Merchant) {if($Merchant['o_state']=='MD') echo 'selected';  } ?> >Maryland</option>
                                      <option value="MA" <?php if($Merchant) {if($Merchant['o_state']=='MA') echo 'selected';  } ?> >Massachusetts</option>
                                      <option value="MI" <?php if($Merchant) {if($Merchant['o_state']=='MI') echo 'selected';  } ?> >Michigan</option>
                                      <option value="MN" <?php if($Merchant) {if($Merchant['o_state']=='MN') echo 'selected';  } ?> >Minnesota</option>
                                      <option value="MS" <?php if($Merchant) {if($Merchant['o_state']=='MS') echo 'selected';  } ?> >Mississippi</option>
                                      <option value="MO" <?php if($Merchant) {if($Merchant['o_state']=='MO') echo 'selected';  } ?> >Missouri</option>
                                      <option value="MT" <?php if($Merchant) {if($Merchant['o_state']=='MT') echo 'selected';  } ?> >Montana</option>
                                      <option value="NE" <?php if($Merchant) {if($Merchant['o_state']=='NE') echo 'selected';  } ?> >Nebraska</option>
                                      <option value="NV" <?php if($Merchant) {if($Merchant['o_state']=='NV') echo 'selected';  } ?>>Nevada</option>
                                      <option value="NH" <?php if($Merchant) {if($Merchant['o_state']=='NH') echo 'selected';  } ?> >New Hampshire</option>
                                      <option value="NJ" <?php if($Merchant) {if($Merchant['o_state']=='NJ') echo 'selected';  } ?> >New Jersey</option>
                                      <option value="NM" <?php if($Merchant) {if($Merchant['o_state']=='NM') echo 'selected';  } ?> >New Mexico</option>
                                      <option value="NY" <?php if($Merchant) {if($Merchant['o_state']=='NY') echo 'selected';  } ?> >New York</option>
                                      <option value="NC" <?php if($Merchant) {if($Merchant['o_state']=='NC') echo 'selected';  } ?> >North Carolina</option>
                                      <option value="ND" <?php if($Merchant) {if($Merchant['o_state']=='ND') echo 'selected';  } ?> >North Dakota</option>
                                      <option value="OH" <?php if($Merchant) {if($Merchant['o_state']=='OH') echo 'selected';  } ?> >Ohio</option>
                                      <option value="OK" <?php if($Merchant) {if($Merchant['o_state']=='OK') echo 'selected';  } ?> >Oklahoma</option>
                                      <option value="OR" <?php if($Merchant) {if($Merchant['o_state']=='OR') echo 'selected';  } ?> >Oregon</option>
                                      <option value="PA" <?php if($Merchant) {if($Merchant['o_state']=='PA') echo 'selected';  } ?> >Pennsylvania</option>
                                      <option value="RI" <?php if($Merchant) {if($Merchant['o_state']=='RI') echo 'selected';  } ?> >Rhode Island</option>
                                      <option value="SC" <?php if($Merchant) {if($Merchant['o_state']=='SC') echo 'selected';  } ?> >South Carolina</option>
                                      <option value="SD" <?php if($Merchant) {if($Merchant['o_state']=='SD') echo 'selected';  } ?> >South Dakota</option>
                                      <option value="TN" <?php if($Merchant) {if($Merchant['o_state']=='TN') echo 'selected';  } ?> >Tennessee</option>
                                      <option value="TX" <?php if($Merchant) {if($Merchant['o_state']=='TX') echo 'selected';  } ?> >Texas</option>
                                      <option value="UT" <?php if($Merchant) {if($Merchant['o_state']=='UT') echo 'selected';  } ?> >Utah</option>
                                      <option value="VT" <?php if($Merchant) {if($Merchant['o_state']=='VT') echo 'selected';  } ?> >Vermont</option>
                                      <option value="VA" <?php if($Merchant) {if($Merchant['o_state']=='VA') echo 'selected';  } ?> >Virginia</option>
                                      <option value="WA" <?php if($Merchant) {if($Merchant['o_state']=='WA') echo 'selected';  } ?> >Washington</option>
                                      <option value="WV" <?php if($Merchant) {if($Merchant['o_state']=='WV') echo 'selected';  } ?> >West Virginia</option>
                                      <option value="WI" <?php if($Merchant) {if($Merchant['o_state']=='WI') echo 'selected';  } ?> >Wisconsin</option>
                                      <option value="WY" <?php if($Merchant) {if($Merchant['o_state']=='WY') echo 'selected';  } ?> >Wyoming</option>
                                    </select>            
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control mb5 cl_fohadd_zip" name="fohadd_zip" value="<?php if($Merchant) echo $Merchant['o_zip']; ?>"  placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Owner Phone Number</span>
                              <div class="form-group">   
                                <input type="text" class="form-control us-phone-no cl_fo_phone" value="<?php if($Merchant) echo $Merchant['o_phone']; ?>" name="fo_phone" placeholder="Owner Phone Number" required autocomplete="off" >
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Owner Email Address</span>
                              <div class="form-group">   
                                <input type="text" class="form-control email cl_fo_email" value="<?php if($Merchant) echo $Merchant['o_email']; ?>" name="fo_email" placeholder="Owner Email Address" required autocomplete="off">
                              </div>
                            </div>
                            <!-- <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary save_owner">Add</button>
                            </div> -->
                            <hr class="custom_hr">
                        </div>
                    <?php } ?>

                    <?php if(!empty($business_owner)) {
                        $ownerLength = sizeof($business_owner);
                        foreach ($business_owner as $form_key => $o_form_value) {
                            $ptr_key = ($form_key+1);
                            $set_ptr_rule = ($ptr_key == $ownerLength) ? 'pointer' : 'd-none'; ?>
                            <div class="first_busi_owner_section <?php echo $set_ptr_rule; ?>">
                                <input type="hidden" name="saved_id" class="savedId" value="<?php if($o_form_value) echo $o_form_value['id']; ?>">
                                <div class="col-12">
                                  <span class="cs-label">Name</span> 
                                  <div class="form-group">             
                                    <div class="fmlname row">
                                        <div class="col">
                                          <input type="text" class="form-control cl_foname1" value="<?php if($o_form_value) echo $o_form_value['name_arr']; ?>" name="foname1_arr" placeholder="First" required autocomplete="off">
                                        </div>
                                        <div class="col">
                                          <input type="text" class="form-control cl_foname2" value="<?php if($o_form_value) echo $o_form_value['m_name_arr']; ?>" name="foname2_arr" placeholder="Middle"  autocomplete="off">
                                        </div>
                                        <div class="col">
                                          <input type="text" class="form-control cl_foname3" value="<?php if($o_form_value) echo $o_form_value['l_name_arr']; ?>" name="foname3_arr" placeholder="Last"  autocomplete="off">
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-12" style="display: inline-flex !important;">
                                  <?php $is_primary_o_arr = ( ($o_form_value['is_primary_o_arr'] != '') && ($o_form_value['is_primary_o_arr'] == 'True') ) ? 'checked' : ''; ?>
                                  <?php $is_primary_o_arr_val = ( ($o_form_value['is_primary_o_arr'] != '') && ($o_form_value['is_primary_o_arr'] == 'True') ) ? '1' : '0'; ?>
                                  

                                  <input type="checkbox" name="is_primary_o_arr" class="form-control owner_check" style="height: 15px !important;width: auto !important;" <?php echo $is_primary_o_arr; ?> value="<?php echo $is_primary_o_arr_val; ?>"> <span class="cs-label" style="margin-left:10px;">Is this person the control prong?</span>
                                </div>
                                <div class="col-12">
                                    <span class="cs-label">SSN</span>
                                  <div class="form-group">
                                    <input type="text" class="form-control us-ssn-no-enc cl_fossn" name="fossn_arr" value="<?php if($o_form_value) echo $o_form_value['o_ss_number_arr']; ?>"  placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <span class="cs-label">Ownership Percentage</span>
                                  <div class="form-group">
                                    <input type="text" class="form-control" name="o_perc_arr" value="<?php if($o_form_value) echo $o_form_value['o_perc_arr']; ?>"  placeholder="Ownership Percentage" required onkeypress="return isNumberKey(event)">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <span class="cs-label">Date of Birth</span>           
                                  <div class="form-group">        
                                    <div class="mdy-wraper row">
                                      <div class="col">
                                        <select class="form-control mb-1 selectOption cl_fodobm" name="fodobm_arr"  required>
                                          <option value="">Month</option>
                                          <option value="01" <?php if($o_form_value['o_dob_m_arr']=='01') echo 'selected'; ?> >Jan</option>
                                          <option value="02" <?php if($o_form_value['o_dob_m_arr']=='02') echo 'selected'; ?>>Feb</option>
                                          <option value="03" <?php if($o_form_value['o_dob_m_arr']=='03') echo 'selected'; ?>>Mar</option>
                                          <option value="04" <?php if($o_form_value['o_dob_m_arr']=='04') echo 'selected'; ?>>Apr</option>
                                          <option value="05" <?php if($o_form_value['o_dob_m_arr']=='05') echo 'selected'; ?>>May</option>
                                          <option value="06" <?php if($o_form_value['o_dob_m_arr']=='06') echo 'selected'; ?>>Jun</option>
                                          <option value="07" <?php if($o_form_value['o_dob_m_arr']=='07') echo 'selected'; ?>>Jul</option>
                                          <option value="08" <?php if($o_form_value['o_dob_m_arr']=='08') echo 'selected'; ?>>Aug</option>
                                          <option value="09" <?php if($o_form_value['o_dob_m_arr']=='09') echo 'selected'; ?>>Sep</option>
                                          <option value="10" <?php if($o_form_value['o_dob_m_arr']=='10') echo 'selected'; ?>>Oct</option>
                                          <option value="11" <?php if($o_form_value['o_dob_m_arr']=='11') echo 'selected'; ?>>Nov</option>
                                          <option value="12" <?php if($o_form_value['o_dob_m_arr']=='12') echo 'selected'; ?>>Dec</option>
                                        </select>                 
                                      </div>
                                      <div class="col">
                                        <select class="form-control mb-1 selectOption cl_fodobd" name="fodobd_arr" required>
                                          <option value="">Day</option>
                                          <option value="01" <?php if($o_form_value['o_dob_d_arr']=='01') echo 'selected'; ?>>01</option>
                                          <option value="02" <?php if($o_form_value['o_dob_d_arr']=='02') echo 'selected'; ?>>02</option>
                                          <option value="03" <?php if($o_form_value['o_dob_d_arr']=='03') echo 'selected'; ?>>03</option>
                                          <option value="04" <?php if($o_form_value['o_dob_d_arr']=='04') echo 'selected'; ?>>04</option>
                                          <option value="05" <?php if($o_form_value['o_dob_d_arr']=='05') echo 'selected'; ?>>05</option>
                                          <option value="06" <?php if($o_form_value['o_dob_d_arr']=='06') echo 'selected'; ?>>06</option>
                                          <option value="07" <?php if($o_form_value['o_dob_d_arr']=='07') echo 'selected'; ?>>07</option>
                                          <option value="08" <?php if($o_form_value['o_dob_d_arr']=='08') echo 'selected'; ?> >08</option>
                                          <option value="09" <?php if($o_form_value['o_dob_d_arr']=='09') echo 'selected'; ?> >09</option>
                                          <option value="10" <?php if($o_form_value['o_dob_d_arr']=='10') echo 'selected'; ?>>10</option>
                                          <option value="11" <?php if($o_form_value['o_dob_d_arr']=='11') echo 'selected'; ?>>11</option>
                                          <option value="12" <?php if($o_form_value['o_dob_d_arr']=='12') echo 'selected'; ?>>12</option>
                                          <option value="13" <?php if($o_form_value['o_dob_d_arr']=='13') echo 'selected'; ?>>13</option>
                                          <option value="14" <?php if($o_form_value['o_dob_d_arr']=='14') echo 'selected'; ?>>14</option>
                                          <option value="15" <?php if($o_form_value['o_dob_d_arr']=='15') echo 'selected'; ?>>15</option>
                                          <option value="16" <?php if($o_form_value['o_dob_d_arr']=='16') echo 'selected'; ?>>16</option>
                                          <option value="17" <?php if($o_form_value['o_dob_d_arr']=='17') echo 'selected'; ?>>17</option>
                                          <option value="18" <?php if($o_form_value['o_dob_d_arr']=='18') echo 'selected'; ?>>18</option>
                                          <option value="19" <?php if($o_form_value['o_dob_d_arr']=='19') echo 'selected'; ?>>19</option>
                                          <option value="20" <?php if($o_form_value['o_dob_d_arr']=='20') echo 'selected'; ?>>20</option>
                                          <option value="21" <?php if($o_form_value['o_dob_d_arr']=='21') echo 'selected'; ?>>21</option>
                                          <option value="22" <?php if($o_form_value['o_dob_d_arr']=='22') echo 'selected'; ?> >22</option>
                                          <option value="23" <?php if($o_form_value['o_dob_d_arr']=='23') echo 'selected'; ?>>23</option>
                                          <option value="24" <?php if($o_form_value['o_dob_d_arr']=='24') echo 'selected'; ?>>24</option>
                                          <option value="25" <?php if($o_form_value['o_dob_d_arr']=='25') echo 'selected'; ?>>25</option>
                                          <option value="26" <?php if($o_form_value['o_dob_d_arr']=='26') echo 'selected'; ?>>26</option>
                                          <option value="27" <?php if($o_form_value['o_dob_d_arr']=='27') echo 'selected'; ?>>27</option>
                                          <option value="28" <?php if($o_form_value['o_dob_d_arr']=='28') echo 'selected'; ?>>28</option>
                                          <option value="29" <?php if($o_form_value['o_dob_d_arr']=='29') echo 'selected'; ?>>29</option>
                                          <option value="30" <?php if($o_form_value['o_dob_d_arr']=='30') echo 'selected'; ?>>30</option>
                                          <option value="31" <?php if($o_form_value['o_dob_d_arr']=='31') echo 'selected'; ?>>31</option>
                                        </select>            
                                      </div>
                                      <div class="col">
                                        <select class="form-control mb-1 selectOption cl_fodoby" name="fodoby_arr" required>
                                          <option value="">Year</option>
                                          <?php if($o_form_value['o_dob_y_arr']){?>
                                          <option value="<?=$o_form_value['o_dob_y_arr']?>" selected><?=$o_form_value['o_dob_y_arr']?></option>
                                          <?php } ?>
                                          <?php  
                                          $year=date('Y');
                                          $startYear=$o_form_value['o_dob_y_arr'] ? $o_form_value['o_dob_y_arr']-10 : '1900'; 
                                          for($i=$startYear; $startYear <=$year;  $startYear++){ ?>
                                              <option value="<?=$startYear?>"><?=$startYear?></option>
                                          <?php } ?>
                                        </select>     
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <span class="cs-label">Home Address</span>
                                  <div class="form-group mb-5px">  
                                    <select class="form-control selectOption cl_fohadd_cntry" name="fohadd_cntry_arr" required autocomplete="off">
                                      <option value="">Select Country</option>
                                      <option value="USA" <?php if($o_form_value['o_country_arr']=='USA') echo 'selected'; ?> >United States of America</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group mb-5px">           
                                    <input type="text" class="form-control cl_fohadd_1" name="fohadd_1_arr" value="<?php if($o_form_value) echo $o_form_value['o_address1_arr']; ?>"  placeholder="Enter Address 1" required autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group mb-5px">           
                                    <input type="text" class="form-control cl_fohadd_2" name="fohadd_2_arr" value="<?php if($o_form_value) echo $o_form_value['o_address2_arr']; ?>"  placeholder="Enter Address 2"  autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">           
                                    <div class="csz row">
                                      <div class="col">
                                        <input type="text" class="form-control mb5 cl_fohadd_city" name="fohadd_city_arr" value="<?php if($o_form_value) echo $o_form_value['o_city_arr']; ?>"  placeholder="City" required autocomplete="off">              
                                      </div>
                                      <div class="col">
                                        <select class="form-control mb5 selectOption cl_fohadd_state" name="fohadd_state_arr"  required>
                                          <option value="">Select State</option>
                                          <option value="AL" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='AL') echo 'selected';  } ?> >Alabama</option>
                                          <option value="AK" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='AK') echo 'selected';  } ?> >Alaska</option>
                                          <option value="AZ" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='AZ') echo 'selected';  } ?> >Arizona</option>
                                          <option value="AR" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='AR') echo 'selected';  } ?> >Arkansas</option>
                                          <option value="CA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='CA') echo 'selected';  } ?> >California</option>
                                          <option value="CO" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='CO') echo 'selected';  } ?>>Colorado</option>
                                          <option value="CT" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='CT') echo 'selected';  } ?>>Connecticut</option>
                                          <option value="DE" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='DE') echo 'selected';  } ?>>Delaware</option>
                                          <option value="DC" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='DC') echo 'selected';  } ?>>District Of Columbia</option>
                                          <option value="FL" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='FL') echo 'selected';  } ?>>Florida</option>
                                          <option value="GA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='GA') echo 'selected';  } ?>>Georgia</option>
                                          <option value="HI" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='HI') echo 'selected';  } ?> >Hawaii</option>
                                          <option value="ID" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='ID') echo 'selected';  } ?> >Idaho</option>
                                          <option value="IL" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='IL') echo 'selected';  } ?> >Illinois</option>
                                          <option value="IN" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='IN') echo 'selected';  } ?> >Indiana</option>
                                          <option value="IA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='IA') echo 'selected';  } ?> >Iowa</option>
                                          <option value="KS" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='KS') echo 'selected';  } ?> >Kansas</option>
                                          <option value="KY" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='KY') echo 'selected';  } ?> >Kentucky</option>
                                          <option value="LA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='LA') echo 'selected';  } ?> >Louisiana</option>
                                          <option value="ME" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='ME') echo 'selected';  } ?> >Maine</option>
                                          <option value="MD" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='MD') echo 'selected';  } ?> >Maryland</option>
                                          <option value="MA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='MA') echo 'selected';  } ?> >Massachusetts</option>
                                          <option value="MI" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='MI') echo 'selected';  } ?> >Michigan</option>
                                          <option value="MN" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='MN') echo 'selected';  } ?> >Minnesota</option>
                                          <option value="MS" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='MS') echo 'selected';  } ?> >Mississippi</option>
                                          <option value="MO" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='MO') echo 'selected';  } ?> >Missouri</option>
                                          <option value="MT" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='MT') echo 'selected';  } ?> >Montana</option>
                                          <option value="NE" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='NE') echo 'selected';  } ?> >Nebraska</option>
                                          <option value="NV" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='NV') echo 'selected';  } ?>>Nevada</option>
                                          <option value="NH" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='NH') echo 'selected';  } ?> >New Hampshire</option>
                                          <option value="NJ" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='NJ') echo 'selected';  } ?> >New Jersey</option>
                                          <option value="NM" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='NM') echo 'selected';  } ?> >New Mexico</option>
                                          <option value="NY" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='NY') echo 'selected';  } ?> >New York</option>
                                          <option value="NC" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='NC') echo 'selected';  } ?> >North Carolina</option>
                                          <option value="ND" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='ND') echo 'selected';  } ?> >North Dakota</option>
                                          <option value="OH" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='OH') echo 'selected';  } ?> >Ohio</option>
                                          <option value="OK" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='OK') echo 'selected';  } ?> >Oklahoma</option>
                                          <option value="OR" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='OR') echo 'selected';  } ?> >Oregon</option>
                                          <option value="PA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='PA') echo 'selected';  } ?> >Pennsylvania</option>
                                          <option value="RI" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='RI') echo 'selected';  } ?> >Rhode Island</option>
                                          <option value="SC" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='SC') echo 'selected';  } ?> >South Carolina</option>
                                          <option value="SD" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='SD') echo 'selected';  } ?> >South Dakota</option>
                                          <option value="TN" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='TN') echo 'selected';  } ?> >Tennessee</option>
                                          <option value="TX" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='TX') echo 'selected';  } ?> >Texas</option>
                                          <option value="UT" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='UT') echo 'selected';  } ?> >Utah</option>
                                          <option value="VT" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='VT') echo 'selected';  } ?> >Vermont</option>
                                          <option value="VA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='VA') echo 'selected';  } ?> >Virginia</option>
                                          <option value="WA" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='WA') echo 'selected';  } ?> >Washington</option>
                                          <option value="WV" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='WV') echo 'selected';  } ?> >West Virginia</option>
                                          <option value="WI" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='WI') echo 'selected';  } ?> >Wisconsin</option>
                                          <option value="WY" <?php if($o_form_value) {if($o_form_value['o_state_arr']=='WY') echo 'selected';  } ?> >Wyoming</option>
                                        </select>            
                                      </div>
                                      <div class="col">
                                        <input type="text" class="form-control mb5 cl_fohadd_zip" name="fohadd_zip_arr" value="<?php if($o_form_value) echo $o_form_value['o_zip_arr']; ?>"  placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-12">
                                    <span class="cs-label">Owner Phone Number</span>
                                  <div class="form-group">   
                                    <input type="text" class="form-control us-phone-no cl_fo_phone" value="<?php if($o_form_value) echo $o_form_value['o_phone_arr']; ?>" name="fo_phone_arr" placeholder="Owner Phone Number" required autocomplete="off" >
                                  </div>
                                </div>
                                <div class="col-12">
                                    <span class="cs-label">Owner Email Address</span>
                                  <div class="form-group">   
                                    <input type="text" class="form-control email cl_fo_email" value="<?php if($o_form_value) echo $o_form_value['o_email_arr']; ?>" name="fo_email_arr" placeholder="Owner Email Address" required autocomplete="off">
                                  </div>
                                </div>
                                <!-- <div class="col-12 text-right">
                                    <button type="button" class="btn btn-primary save_owner">Add</button>
                                </div> -->
                                <hr class="custom_hr">
                            </div>
                        <?php }
                    } ?>
                </div>

                <div class="col-12">
                    <div class="form-group text-right">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <button type="button" class="btn btn-first add_more_owner" style="width: inherit !important;">Add Owner <i class="fa fa-plus"></i></button>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <button type="button" class="btn btn-second back-step" style="width: inherit !important;"> Back</button>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <button type="button" class="btn btn-first next-step" style="width: inherit !important;"><span></span> Next</button>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="fourth-step row <?php if($this->session->userdata('step')=="three"){ echo 'active'; } ?>" data-fStep="4">
                <div class="col-12">
                    <span class="cs-label">Bank Account DDA Type</span>
                  <div class="form-group">                       
                    <select class="form-control selectOption" name="bank_dda_type"  required autocomplete="off">
                      <option value="">Select Bank Account DDA Type</option>
                      <option value="CommercialChecking" <?php if($Merchant) {if($Merchant['bank_dda']=='CommercialChecking') echo 'selected';  } ?> >Commercial Checking</option>
                      <option value="PrivateChecking" <?php if($Merchant) {if($Merchant['bank_dda']=='PrivateChecking') echo 'selected';  } ?> >Private Checking</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Bank Account ACH Type</span>
                  <div class="form-group">            
                    <select class="form-control selectOption" name="baccachtype"  required autocomplete="off">
                      <option value="">Select Bank Account ACH Type</option>
                      <option value="CommercialChecking" <?php if($Merchant) {if($Merchant['bank_ach']=='CommercialChecking') echo 'selected';  } ?>  >Business Checking</option>
                      <option value="PrivateChecking" <?php if($Merchant) {if($Merchant['bank_ach']=='PrivateChecking') echo 'selected';  } ?>  >Personal Checking</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Routing Number</span>
                  <div class="form-group">  
                    <input  type="text" class="form-control us-routing" maxlength="9" name="routeNo" value="<?php if($Merchant) echo $Merchant['bank_routing']; ?>"  placeholder="Routing Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Confirm Routing Number</span>
                  <div class="form-group">  
                    <input type="text" class="form-control us-routing-c" maxlength="9" name="confrouteNo" value="<?php if($Merchant) echo $Merchant['bank_routing']; ?>"  placeholder="Confirm Routing Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Account Number</span>
                  <div class="form-group">  
                    <input type="text" class="form-control us-acc-no" maxlength="17" name="accno" value="<?php if($Merchant) echo $Merchant['bank_account']; ?>"  placeholder="Account Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                  </div>
                </div>
                <div class="col-12">
                    <span class="cs-label">Confirm Account Number</span>
                  <div class="form-group">  
                    <input type="text" class="form-control us-acc-no-c" maxlength="17" name="confaccno" value="<?php if($Merchant) echo $Merchant['bank_account']; ?>"  placeholder="Confirm Account Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
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
              <div class="col-12 alertmessage"></div>
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
  $(document).on('click', '.owner_check', function() {
    var $this = $(this);
    if ($this.is(':checked')) {
      $this.val('1');
      // console.log($this.val());
    } else {
      $this.val('0');
      // console.log($this.val());
    }
  })

  $(document).on('click', '.accept_check', function() {
    if ($('.accept_check').is(':checked')) {
      $('.accept_check').val('1');
    } else {
      $('.accept_check').val('0');
    }
  })

  function mSignupStep1Fn(mSignupStepF) {
    // console.log(mSignupStepF);return false;
    var email_en = mSignupStepF.email;
    var mconfpass_en = mSignupStepF.mconfpass;
    var password_en = mSignupStepF.password;
    var pc_phone_en = mSignupStepF.primary_phone;
    var allData = email_en+"/"+mconfpass_en+"/"+password_en+"/"+pc_phone_en;
    // console.log(allData);return false;

    $.ajax({
      type: "POST",
      url: "<?php echo base_url('signup/stepone_signup');?>",
      // data: mSignupStepF,
      data: {'allData': allData},
      dataType: "JSON",
      success: function(data) {
        // console.log(data, 'man');return false;
        console.log(data);
       
        if(data=='200')
        {
            leaveFirstGoNextStp();
            $(window).trigger('resize');
            $('.custom-stepper-form .first-step .stepper-submit span').removeClass('fa fa-spinner fa-spin');
            $('.alertmessage').html('');
        }
        else if(data=='400')
        {
           alert('all fields are required'); 
           $('.alertmessage').html('<div class="alert alert-danger text-center">All fields are required!</div>'); 
        }
        else if(data=='600')
        {
          alert("both password Are not Match"); 
          $('.alertmessage').html('<div class="alert alert-danger text-center">Both password not matched!</div>');
        }
        else if(data=='700')
        {
            $('.custom-stepper-form .first-step .stepper-submit span').removeClass('fa fa-spinner fa-spin');
            $('.alertmessage').html('<div class="alert alert-danger text-center">This email already registered click here to login!</div>'); 
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
    // console.log(mSignupStepTh);
    console.log('hello');return false;
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

    //3rd New
    function mSignupStep3FnNew(mSignupStepTh) {
        // console.log(mSignupStepTh);return false;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('signup/stepthree_signup_new');?>",
            data: mSignupStepTh,
            success: function(data) {
                var data = JSON.parse(data);
                var ownerInsertedIds = data.ownerInsertedIds;
                var allOwnerInsertedIds = data.allOwnerInsertedIds;
                var ownerArrIndex = 0;
                var ownerArrIndex1 = 0;
                var index = 0;
                var index1 = 0;
                $('.custom-stepper-form .third-step .first_busi_owner_section').each(function() {
                    if (index != 0) {
                        $(this).children('.savedId').val(ownerInsertedIds[ownerArrIndex]);
                        ownerArrIndex++;
                    }
                    index++;
                });

                $('.custom-stepper-form .third-step .busi_owner_row').each(function() {
                    // if (index1 != 0) {
                        $(this).children('.rowHiddenInput').val(allOwnerInsertedIds[ownerArrIndex1]);
                        console.log($(this).children('.rowHiddenInput').val());
                        ownerArrIndex1++;
                    // }
                    // index1++;
                });

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
    function mSignupStep4Fn(mSignupStepFth) {
        console.log(mSignupStepFth)
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo base_url('signup/stepfour_signup_new'); ?>",
            data: mSignupStepFth,
            success: function(data) {
                // console.log(data == '200');
                // leave4thGoNextStp();

                if(data.Status=='200') {
                    window.location.href='<?=base_url("login");?>';
                    $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');

                    // alert('Send Successfully2'); 
                    $('.alertmessage').html('<div class="alert alert-danger text-center">Send Successfully!</div>');
                }

                if(data.Status=='30') {
                    window.location.href='<?=base_url("login");?>';
                    // alert('Send Successfully'); 
                    $('.alertmessage').html('<div class="alert alert-danger text-center">Send Successfully!</div>');

                } else if(data.Status=='400' ||  data.Status=='40') {
                    // alert('all fields are required'); 
                    $('.alertmessage').html('<div class="alert alert-danger text-center">all fields are required!</div>');

                } else if(data.Status=='500') {
                    $('.alertmessage').html('<div class="alert alert-danger text-center">Mail not sent!</div>');

                } else {
                    $('.alertmessage').html(data.StatusMessage); 
                    if(data.Errors.length > 0) {
                        var i=0;
                        for(i=0;i<data.Errors.length; i++) {
                            //console.log(data.Errors[i].Message);
                            $('.alertmessage').append('<span class="text-danger">'+data.Errors[i].Message+'</span><br/>');
                        }
                    }
                }
                $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');
            },
            error: function(xhr){
                console.log('error');
                $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');
            },
        })
    }

    function signUpStepThirdNew($wrapper){
        // console.log($wrapper);return false;
        var trueFalse= 1;
        $wrapper.find('.form-control[required]').each(function(){
            var txtVal=$(this).val();
            //check empty
            if(!txtVal.length) {
                // console.log('run')
                $(this).closest('.form-group').addClass('mandatory');
                $(this).focus();
                trueFalse=0;
                return false;
            }
            //check if email
            if($(this).hasClass('email')) {
                if(!emailRegx.test(txtVal))
                {
                    $(this).closest('.form-group').addClass('incorrect');
                    $(this).focus();
                    trueFalse=0;
                    return false;
                }
            }
            // console.log($(this));
        })
        return trueFalse;
    }


    $(function() {
        //Extends JQuery Methods to get current cursor postion in input text.
        //GET CURSOR POSITION
        jQuery.fn.getCursorPosition = function() {
            if (this.length == 0) return -1;
            return $(this).getSelectionStart();
        }

        jQuery.fn.getSelectionStart = function() {
            if (this.length == 0) return -1;
            input = this[0];
            var pos = input.value.length;

            if (input.createTextRange) {
                var r = document.selection.createRange().duplicate();
                r.moveEnd('character', input.value.length);
                if (r.text == '') pos = input.value.length;
                pos = input.value.lastIndexOf(r.text);
            } else if (typeof(input.selectionStart) != "undefined") pos = input.selectionStart;

            return pos;
        }

        //Bind Key Press event with password field    
        $("#secret1").keypress(function(e) {
            setTimeout(function() {
                maskPassword1(e)
            }, 500);
        });

        $("#secret1").keydown(function(e) {
            if (e.keyCode == 8) {
                setTimeout(function() {
                    maskPassword1(e)
                }, 1);
            }
        });

        $("#secret1").bind("paste", function(e) {
            setTimeout(function() {
                maskPassword1(e)
            }, 500);
        });

        $("#secret2").keypress(function(e) {
            setTimeout(function() {
                maskPassword2(e)
            }, 500);
        });

        $("#secret2").keydown(function(e) {
            if (e.keyCode == 8) {
                setTimeout(function() {
                    maskPassword2(e)
                }, 1);
            }
        });

        $("#secret2").bind("paste", function(e) {
            setTimeout(function() {
                maskPassword2(e)
            }, 500);
        });
    });

    function generateStars(n) {
        var stars = '';
        for (var i = 0; i < n; i++) {
            stars += '*';
        }
        return stars;
    }

    function maskPassword1(e) {
        var text = $('#secret11').val();

        var stars1 = $('#secret11').val().length;
        var unicode = e.keyCode ? e.keyCode : e.charCode;
        
        //Get Current Cursor Position on Password Textbox
        var curPos = $("#secret1").getCursorPosition();
        var PwdLength = $("#secret1").val().length;

        if (unicode != 9 && unicode != 13 && unicode != 37 && unicode != 40 && unicode != 37 && unicode != 39) {
            //If NOT <Back Space> OR <DEL> Then...
            if (unicode != 8 && unicode != 46) {
                text = text + String.fromCharCode(unicode);
                stars1 += 1;
            }
            //If Press <Back Space> Or <DEL> Then...
            else if ((unicode == 8 || unicode == 46) && stars1 != PwdLength) {
                stars1 -= 1;
                text = text.substr(0, curPos) + text.substr(curPos + 1);
            }
            //Set New String on both input fields
            $('#secret11').val(text);
            $('#secret1').val(generateStars(stars1));
        }
    }

    function maskPassword2(e) {
        var text = $('#secret22').val();
        var stars2 = $('#secret22').val().length;
        var unicode = e.keyCode ? e.keyCode : e.charCode;
        
        //Get Current Cursor Position on Password Textbox
        var curPos = $("#secret2").getCursorPosition();
        var PwdLength = $("#secret2").val().length;

        if (unicode != 9 && unicode != 13 && unicode != 37 && unicode != 40 && unicode != 37 && unicode != 39) {
            //If NOT <Back Space> OR <DEL> Then...
            if (unicode != 8 && unicode != 46) {
                text = text + String.fromCharCode(unicode);
                stars2 += 1;
            }
            //If Press <Back Space> Or <DEL> Then...
            else if ((unicode == 8 || unicode == 46) && stars2 != PwdLength) {
                stars2 -= 1;
                text = text.substr(0, curPos) + text.substr(curPos + 1);
            }
            //Set New String on both input fields
            $('#secret22').val(text);

            $('#secret2').val(generateStars(stars2));
        }
    }
 
    $(function(){
        $('.selectOption').select2();
        // $('#as__day').select2();
        // $('#as__month').select2();
        // $('#as__year').select2();
        $(".us-phone-no").mask("(999) 999-9999");
        $(".us-tin-no").mask("99-9999999");
        // $(".us-ssn-no-val").mask("999-99-9999");
    })

    $(document).on('click', '.add_more_owner', function() {
        var $owner_wrapper = $('.custom-stepper-form .third-step .pointer');
        // var $owner_wrapper = $(this).parent().parent();

        if(signUpStepThirdNew($owner_wrapper)) {
            //no validation error section
            // console.log($('.first_busi_owner_section'));return false;
            var mSignupStepTh={};
            $('.custom-stepper-form .third-step .pointer input,.custom-stepper-form .third-step select').each(function(){
                var newval=$(this).val();

                if($(this).hasClass('us-phone-no')){
                    newval=newval.replace(/[\(\)-\s]/g,'');

                } else if($(this).hasClass('us-ssn-no-enc')){
                    // newval=$(this).data('val');
                    var newval=$(this).val();
                }
                mSignupStepTh[$(this).attr('name')]= newval;
            })
            // console.log(mSignupStepTh);return false; //values of input and select
            // mSignupStep3Fn(mSignupStepTh);
            $owner_wrapper.addClass('d-none');
            $owner_wrapper.removeClass('pointer');

            var checkIndexCount = 0;
            $.each(mSignupStepTh, function( index, value ) {
                // console.log(index, value);
                if( index == 'foname1_arr' ) {
                    checkIndexCount++ //for second row onwards
                
                } else {
                    //for first row
                }
            });
            // console.log(checkIndexCount);

            if( checkIndexCount == 0 ) {
                var foname1 = mSignupStepTh.foname1;
                var icon_first_ch = foname1.charAt(0);

                $('.busi_owners_list').append('<div class="busi_owner_row row"><input type="hidden" class="rowHiddenInput" data-owner_id=""><div class="col-2"><div class="owner_list_icon"><span class="owner_list_icon_span">'+icon_first_ch+'</span></div></div><div class="col-8" style="display: grid;"><span class="owner_list_name">'+foname1+' '+mSignupStepTh.foname2+' '+mSignupStepTh.foname3+'</span><span class="owner_list_email">'+mSignupStepTh.fossn+'</span><span class="owner_list_email">'+mSignupStepTh.fo_email+'</span></div></div>');

            } else {
                var foname1_arr = mSignupStepTh.foname1_arr;
                var icon_first_ch = foname1_arr.charAt(0);

                $('.busi_owners_list').append('<div class="busi_owner_row row"><input type="hidden" class="rowHiddenInput" data-owner_id=""><div class="col-2"><div class="owner_list_icon"><span class="owner_list_icon_span">'+icon_first_ch+'</span></div></div><div class="col-8" style="display: grid;"><span class="owner_list_name">'+foname1_arr+' '+mSignupStepTh.foname2_arr+' '+mSignupStepTh.foname3_arr+'</span><span class="owner_list_email">'+mSignupStepTh.fossn_arr+'</span><span class="owner_list_email">'+mSignupStepTh.fo_email_arr+'</span></div><div class="col-2 text-center"><button type="button" class="btn delete_owner"><i class="fa fa-minus-circle" style="color: #d93025;font-size: 20px;"></i></button></div></div>');
            }

            var ownerRowLength = $('.custom-stepper-form .third-step .busi_owner_row').length;
            if(ownerRowLength == 10) {
                alert('You can Add Business Owner upto 10 only.');return false;
            }
            // console.log(ownerRowLength);return false;

            var current_year = new Date().getFullYear();
            var newOwnerRow = '';
            var i, owner_doy = '';
            for (i = 1900; i <= current_year; i++) {
                owner_doy += '<option value="'+i+'">'+i+'</option>';
            }
            newOwnerRow += '<div class="first_busi_owner_section pointer"><input type="hidden" name="saved_id" class="savedId" value=""><div class="col-12"><span class="cs-label">Name</span><div class="form-group"><div class="fmlname row"><div class="col"><input type="text" class="form-control cl_foname1" value="" name="foname1_arr" placeholder="First" required autocomplete="off"></div><div class="col"><input type="text" class="form-control cl_foname2" value="" name="foname2_arr" placeholder="Middle" autocomplete="off"></div><div class="col"><input type="text" class="form-control cl_foname3" value="" name="foname3_arr" placeholder="Last"  autocomplete="off"></div></div></div></div><div class="col-12" style="display: inline-flex !important;"><input type="checkbox" name="is_primary_o_arr" class="form-control owner_check" style="height: 15px !important;width: auto !important;" value="0"> <span class="cs-label" style="margin-left:10px;">Is this person the control prong?</span></div><div class="col-12"><span class="cs-label">SSN</span><div class="form-group"><input type="text" class="form-control us-ssn-no-enc cl_fossn" name="fossn_arr" value="" placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11"></div></div><div class="col-12"><span class="cs-label">Ownership Percentage</span><div class="form-group"><input type="text" class="form-control" name="o_perc_arr" value="" placeholder="Ownership Percentage" required onkeypress="return isNumberKey(event)"></div></div><div class="col-12"><span class="cs-label">Date of Birth</span><div class="form-group"><div class="mdy-wraper row"><div class="col"><select class="form-control mb-1 selectOption cl_fodobm" name="fodobm_arr" required><option value="">Month</option><option value="01">Jan</option><option value="02">Feb</option><option value="03">Mar</option><option value="04">Apr</option><option value="05">May</option><option value="06">Jun</option><option value="07">Jul</option><option value="08">Aug</option><option value="09">Sep</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select></div><div class="col"><select class="form-control mb-1 selectOption cl_fodobd" name="fodobd_arr" required><option value="">Day</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></div><div class="col"><select class="form-control mb-1 selectOption cl_fodoby" name="fodoby_arr" required><option value="">Year</option>' + owner_doy + '</select></div></div></div></div><div class="col-12"><span class="cs-label">Home Address</span><div class="form-group mb-5px"><select class="form-control selectOption cl_fohadd_cntry" name="fohadd_cntry_arr" required autocomplete="off"><option value="">Select Country</option><option value="USA">United States of America</option></select></div></div><div class="col-12"><div class="form-group mb-5px"><input type="text" class="form-control cl_fohadd_1" name="fohadd_1_arr" value="" placeholder="Enter Address 1" required autocomplete="off"></div></div><div class="col-12"><div class="form-group mb-5px"><input type="text" class="form-control cl_fohadd_2" name="fohadd_2_arr" value="" placeholder="Enter Address 2" autocomplete="off"></div></div><div class="col-12"><div class="form-group"><div class="csz row"><div class="col"><input type="text" class="form-control mb5 cl_fohadd_city" name="fohadd_city_arr" value="" placeholder="City" required autocomplete="off"></div><div class="col"><select class="form-control mb5 selectOption cl_fohadd_state" name="fohadd_state_arr" required><option value="">Select State</option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option></select></div><div class="col"><input type="text" class="form-control mb5 cl_fohadd_zip" name="fohadd_zip_arr" value="" placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)"></div></div></div></div><div class="col-12"><span class="cs-label">Owner Phone Number</span><div class="form-group"><input type="text" class="form-control us-phone-no cl_fo_phone" value="" name="fo_phone_arr" placeholder="Owner Phone Number" required autocomplete="off"></div></div><div class="col-12"><span class="cs-label">Owner Email Address</span><div class="form-group"><input type="text" class="form-control email cl_fo_email" value="" name="fo_email_arr" placeholder="Owner Email Address" required autocomplete="off"></div></div><hr class="custom_hr"></div>';
            
            $('.busi_owner_inputs').append(newOwnerRow);
            $('.pointer').find('.cl_fo_phone').mask("(999) 999-9999");
            $('.pointer').find('.selectOption').select2();

        } else {
            //validation error section
        }
    })

    $(document).on('click', '.save_owner', function() {
        var $owner_wrapper = $(this).parent().parent();

        if(signUpStepThirdNew($owner_wrapper)) {
            // validation false
            var mSignupStepTh={};
            $('.custom-stepper-form .third-step .pointer input,.custom-stepper-form .third-step select').each(function(){
                var newval=$(this).val();

                if($(this).hasClass('us-phone-no')){
                    newval=newval.replace(/[\(\)-\s]/g,'');
                }
                else if($(this).hasClass('us-ssn-no-enc')){
                    // newval=$(this).data('val');
                    var newval=$(this).val();
                }
                mSignupStepTh[$(this).attr('name')]= newval;
            })
            // console.log(mSignupStepTh);return false; //values of input and select
            // mSignupStep3Fn(mSignupStepTh);
            $(this).parent().parent().addClass('d-none');
            $(this).parent().parent().removeClass('pointer');

            var checkIndexCount = 0;
            $.each(mSignupStepTh, function( index, value ) {
                // console.log(index, value);
                if( index == 'foname1_arr' ) {
                    checkIndexCount++ //for second row onwards
                
                } else {
                    //for first row
                }
            });
            // console.log(checkIndexCount);

            if( checkIndexCount == 0 ) {
                var foname1 = mSignupStepTh.foname1;
                var icon_first_ch = foname1.charAt(0);

                $('.busi_owners_list').append('<div class="busi_owner_row row"><div class="col-2"><div class="owner_list_icon"><span class="owner_list_icon_span">'+icon_first_ch+'</span></div></div><div class="col-8" style="display: grid;"><span class="owner_list_name">'+foname1+' '+mSignupStepTh.foname2+' '+mSignupStepTh.foname3+'</span><span class="owner_list_email">'+mSignupStepTh.fossn+'</span><span class="owner_list_email">'+mSignupStepTh.fo_email+'</span></div></div>');
            } else {
                var foname1_arr = mSignupStepTh.foname1_arr;
                var icon_first_ch = foname1_arr.charAt(0);

                $('.busi_owners_list').append('<div class="busi_owner_row row"><input type="hidden" class="rowHiddenInput" data-fo_email_arr="'+mSignupStepTh.fo_email_arr+'" data-fo_phone_arr="'+mSignupStepTh.fo_phone_arr+'" data-fodobd_arr="'+mSignupStepTh.fodobd_arr+'" data-fodobm_arr="'+mSignupStepTh.fodobm_arr+'" data-fodoby_arr="'+mSignupStepTh.fodoby_arr+'" data-fohadd_1_arr="'+mSignupStepTh.fohadd_1_arr+'" data-fohadd_2_arr="'+mSignupStepTh.fohadd_2_arr+'" data-fohadd_city_arr="'+mSignupStepTh.fohadd_city_arr+'" data-fohadd_cntry_arr="'+mSignupStepTh.fohadd_cntry_arr+'" data-fohadd_state_arr="'+mSignupStepTh.fohadd_state_arr+'" data-fohadd_zip_arr="'+mSignupStepTh.fohadd_zip_arr+'" data-foname1_arr="'+mSignupStepTh.foname1_arr+'" data-foname2_arr="'+mSignupStepTh.foname2_arr+'" data-foname3_arr="'+mSignupStepTh.foname3_arr+'" data-fossn_arr="'+mSignupStepTh.fossn_arr+'"><div class="col-2"><div class="owner_list_icon"><span class="owner_list_icon_span">'+icon_first_ch+'</span></div></div><div class="col-8" style="display: grid;"><span class="owner_list_name">'+foname1_arr+' '+mSignupStepTh.foname2_arr+' '+mSignupStepTh.foname3_arr+'</span><span class="owner_list_email">'+mSignupStepTh.fossn_arr+'</span><span class="owner_list_email">'+mSignupStepTh.fo_email_arr+'</span></div><div class="col-2 text-center"><button type="button" class="btn delete_owner"><i class="fa fa-minus-circle" style="color: #d93025;font-size: 20px;"></i></button></div></div>');
            }
            // console.log(mSignupStepTh);return false;

        } else {
            // validation true
            // console.log('22');return false;
        }
    })

    $(document).on('click', '.delete_owner', function() {
        var $this = $(this);
        var parent_row = $(this).parent().parent();
        // var del_owner_id = $(this).parent().parent().children('.rowHiddenInput').val();
        var del_owner_id = $(this).parent().parent().children('.rowHiddenInput').attr('data-owner_id');
        var get_parent_index = parent_row.index();
        // console.log(del_owner_id, get_parent_index);return false;
        if (del_owner_id != "") {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('signup/delete_business_owner');?>",
                data: {'del_owner_id' : del_owner_id},
                success: function(data) {
                    $this.parent().parent().remove();
                    $('.first_busi_owner_section')[get_parent_index].remove();
                }
            });

        } else {
            $this.parent().parent().remove();
            $('.first_busi_owner_section')[get_parent_index].remove();
        }
    })
</script>
<?php
include_once 'footer_signup.php';
?>
