<?php
// if (!empty($this->session->userdata('merchant_name'))) {
//     header('Location:  '.base_url().'merchant'  );
// }

include_once'header_dash.php';
include_once'nav_label.php';
include_once'sidebar_dash.php';
?>
<link rel="stylesheet" href="<?php echo base_url('new_assets/css/style_agent.css') ?>">

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="https://salequick.com/new_assets/img/giphy.gif"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Dashboard</h4> -->
                </div>
            </div>
            <div class="row" style="margin-bottom: 30px !important;">
                <div id="wrapper" style="margin: auto;">
                    <div class="col-sm-6 col-md-10 col-lg-8 custom-stepper-form" style="margin: auto;">
                        <div class="custom-form sign-up-form">
                            <div class="form-steps" style="display:none;">
                                <div class="row">
                                    <div class="step col " data-fStep="1">
                                        <span>1</span>
                                        <p class="step-title">User Account</p>
                                    </div>
                                    <div class="step col " data-fStep="2">
                                        <span>2</span>
                                        <p class="step-title">Business Information</p>
                                    </div>
                                    <div class="step col " data-fStep="3">
                                        <span>3</span>
                                        <p class="step-title">Owner Information</p>
                                    </div>
                                    <div class="step col " data-fStep="4">
                                        <span>4</span>
                                        <p class="step-title">Banking Information</p>
                                    </div>
                                </div>
                            </div>
                            <div class="steps-wrapper ">
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

                                <div class="first-step row active" data-fStep="1">
                                    <div class="col-12">
                                        <p class="steptitle">Add Merchant</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">                
                                            <input type="text" class="form-control email" value="" name="memail" placeholder="Email" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">                
                                            <input type="password" class="form-control password p1" value="" name="mpass" placeholder="Password" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">                
                                            <input type="password" value="" class="form-control password p2" name="mconfpass" placeholder="Confirm Password" required autocomplete="off">
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
                                
                                <div class="second-step row " data-fStep="2">
                                    <div class="col-12">
                                        <span class="cs-label">Legal Business Name</span>
                                        <div class="form-group">                
                                            <input type="text" class="form-control " name="bsns_name" value="" placeholder="Enter the legal name for your business" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">DBA Name</span>
                                        <div class="form-group">                
                                            <input type="text" class="form-control " name="bsns_dbaname" value="" placeholder="Enter the doing business as name for your business" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Tax Identification Number (TIN)</span>
                                        <div class="form-group">
                                            <input type="text" class="form-control us-tin-no" name="bsns_tin" value="" placeholder="Tax Identification Number (TIN)" required autocomplete="off" onkeypress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Physical Address</span>
                                        <div class="form-group mb-5px">  
                                            <select class="form-control selectOption" name="bsnspadd_cnttry" required autocomplete="off">
                                                <option value="">Select Country</option>
                                                <option value="USA">United States of America</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Canada">Canada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-5px">           
                                            <input type="text" class="form-control" name="bsnspadd_1" value="" placeholder="Enter Address 1" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-5px">           
                                            <input type="text" class="form-control" name="bsnspadd_2" value="" placeholder="Enter Address 2" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">           
                                            <div class="csz row">
                                                <div class="col">
                                                    <input type="text" class="form-control mb5" name="bsnspadd_city" value="" placeholder="City" required autocomplete="off">              
                                                </div>
                                                <div class="col">
                                                    <select class="form-control mb5 selectOption" name="bsnspadd_state" required>
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
                                                    <input type="text" class="form-control mb5" name="bsnspadd_zip" value="" placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Ownership Type</span>
                                        <div class="form-group">             
                                            <select class="form-control selectOption" name="bsns_ownrtyp" required autocomplete="off">
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
                                        <span class="cs-label">Business Type</span>
                                        <div class="form-group">               
                                            <select class="form-control selectOption" name="bsns_type" required autocomplete="off">
                                                <option value="">Select Business Type</option>
                                                <option value="Service">Service</option>
                                                <option value="ECommerce">E-Commerce</option>
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
                                                <select class="form-control mb-5px selectOption" name="bsns_strtdate_m" required>
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
                                                <select class="form-control mb-5px selectOption" name="bsns_strtdate_d" required>
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
                                                <select class="form-control mb-5px selectOption" name="bsns_strtdate_y" required>
                                                    <option value="">Year</option>
                                                    <?php $year=date('Y');
                                                    $startYear='1900';
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
                                            <input type="text" class="form-control us-phone-no" name="bsns_phone" value="" placeholder="Business Phone Number" required autocomplete="off" >
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Business Email Address</span>
                                        <div class="form-group">  
                                            <input type="text" class="form-control email" name="bsns_email" value="" placeholder="Business Email Address" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Customer Service Phone Number</span>
                                        <div class="form-group">  
                                            <input type="text" class="form-control us-phone-no" name="custServ_phone" value="" placeholder="Customer Service Phone Number" required autocomplete="off" >
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Customer Service Email Address</span>
                                        <div class="form-group">  
                                            <input type="text" class="form-control email" name="custServ_email" value="" placeholder="Customer Service Email Address" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Business Website</span>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="bsns_website" value="www." placeholder="https://www.yourwebsite.com" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span class="cs-label">Estimated Annual Processing Volume</span>
                                        <div class="form-group">
                                            <select class="form-control" name="mepvolume" required style="color: #adb5c7 !important;">
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
                            
                                <div class="third-step row " data-fStep="3">
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
                                    <div class="col-12 busi_owners_list"></div>

                                <div class="busi_owner_inputs">
                                    <div class="first_busi_owner_section pointer">
                                        <div class="col-12">
                                          <span class="cs-label">Name</span> 
                                          <div class="form-group">             
                                            <div class="fmlname row">
                                                <div class="col">
                                                  <input type="text" class="form-control cl_foname1" value="" name="foname1" placeholder="First" required autocomplete="off">
                                                </div>
                                                <div class="col">
                                                  <input type="text" class="form-control cl_foname2" value="" name="foname2" placeholder="Middle"  autocomplete="off">
                                                </div>
                                                <div class="col">
                                                  <input type="text" class="form-control cl_foname3" value="" name="foname3" placeholder="Last"  autocomplete="off">
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <span class="cs-label">SSN</span>
                                          <div class="form-group">
                                            <input type="text" class="form-control us-ssn-no-enc cl_fossn" name="fossn" value=""  placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11" maxlength="9">
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <span class="cs-label">Date of Birth</span>           
                                          <div class="form-group">        
                                            <div class="mdy-wraper row">
                                              <div class="col">
                                                <select class="form-control mb-1 selectOption cl_fodobm" name="fodobm"  required>
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
                                                <select class="form-control mb-1 selectOption cl_fodobd" name="fodobd"  required>
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
                                                <select class="form-control mb-1 selectOption cl_fodoby" name="fodoby" required>
                                                  <option value="">Year</option>
                                                  <?php  
                                                  $year=date('Y');
                                                  $startYear='1900'; 
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
                                              <option value="USA">United States of America</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <div class="form-group mb-5px">           
                                            <input type="text" class="form-control cl_fohadd_1" name="fohadd_1" value=""  placeholder="Enter Address 1" required autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <div class="form-group mb-5px">           
                                            <input type="text" class="form-control cl_fohadd_2" name="fohadd_2" value=""  placeholder="Enter Address 2"  autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <div class="form-group">           
                                            <div class="csz row">
                                              <div class="col">
                                                <input type="text" class="form-control mb5 cl_fohadd_city" name="fohadd_city" value=""  placeholder="City" required autocomplete="off">              
                                              </div>
                                              <div class="col">
                                                <select class="form-control mb5 selectOption cl_fohadd_state" name="fohadd_state"  required>
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
                                                <input type="text" class="form-control mb5 cl_fohadd_zip" name="fohadd_zip" value=""  placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <span class="cs-label">Owner Phone Number</span>
                                          <div class="form-group">   
                                            <input type="text" class="form-control us-phone-no cl_fo_phone" value="" name="fo_phone" placeholder="Owner Phone Number" required autocomplete="off" >
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <span class="cs-label">Owner Email Address</span>
                                          <div class="form-group">   
                                            <input type="text" class="form-control email cl_fo_email" value="" name="fo_email" placeholder="Owner Email Address" required autocomplete="off">
                                          </div>
                                        </div>
                                        <hr class="custom_hr">
                                    </div>
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
                          <div class="fourth-step row " data-fStep="4">
                            <div class="col-12">
                                <span class="cs-label">Bank Account DDA Type</span>
                              <div class="form-group">                       
                                <select class="form-control selectOption" name="bank_dda_type"  required autocomplete="off">
                                  <option value="">Select Bank Account DDA Type</option>
                                  <option value="CommercialChecking">Commercial Checking</option>
                                  <option value="PrivateChecking">Private Checking</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Bank Account ACH Type</span>
                              <div class="form-group">            
                                <select class="form-control selectOption" name="baccachtype"  required autocomplete="off">
                                  <option value="">Select Bank Account ACH Type</option>
                                  <option value="CommercialChecking">Business Checking</option>
                                  <option value="PrivateChecking">Personal Checking</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Routing Number</span>
                              <div class="form-group">  
                                <input  type="text" class="form-control us-routing" maxlength="9" name="routeNo" value=""  placeholder="Routing Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Confirm Routing Number</span>
                              <div class="form-group">  
                                <input type="text" class="form-control us-routing-c" maxlength="9" name="confrouteNo" value=""  placeholder="Confirm Routing Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Account Number</span>
                              <div class="form-group">  
                                <input type="text" class="form-control us-acc-no" maxlength="17" name="accno" value=""  placeholder="Account Number" required autocomplete="off" onkeypress="return isNumberKey(event)">
                              </div>
                            </div>
                            <div class="col-12">
                                <span class="cs-label">Confirm Account Number</span>
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
                          <div class="col-12 alertmessage">
                           
                            
                           
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  function mSignupStep1Fn(mSignupStepF) {
    // console.log(mSignupStepF);return false;
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('agent/stepone_signup');?>",
      data: mSignupStepF,
      dataType: "JSON",
      success: function(data) {
        // console.log(data, 'man');return false;
        // console.log(data);
        if(data=='200') {
            leaveFirstGoNextStp();
            $(window).trigger('resize');
            $('.custom-stepper-form .first-step .stepper-submit span').removeClass('fa fa-spinner fa-spin');
            $('.alertmessage').html('');
        } else if(data=='400') {
           alert('all fields are required'); 
           $('.alertmessage').html('<div class="alert alert-danger text-center">All fields are required!</div>'); 
        } else if(data=='600') {
          alert("both password Are not Match"); 
          $('.alertmessage').html('<div class="alert alert-danger text-center">Both password not matched!</div>');
        } else if(data=='700') {
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
  function mSignupStep2Fn(mSignupStepS) {
     // console.log(mSignupStepS)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('agent/steptwo_signup');?>",
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

    //3rd New
    function mSignupStep3FnNew(mSignupStepTh) {
        // console.log(mSignupStepTh);return false;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('agent/stepthree_signup_new');?>",
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
                        $(this).children('.rowHiddenInput').attr("data-owner_id", allOwnerInsertedIds[ownerArrIndex1]).val(allOwnerInsertedIds[ownerArrIndex1]);
                        // console.log($(this).children('.rowHiddenInput').val());
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
        // console.log(mSignupStepFth)
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?php echo base_url('agent/stepfour_signup_new'); ?>",
            data: mSignupStepFth,
            success: function(data) {
                // leave4thGoNextStp();

                if(data.Status=='200') {
                    window.location = '<?= base_url("agent/add_merchant"); ?>';
                    // $('.custom-stepper-form .fourth-step .submit-step span').removeClass('fa fa-spinner fa-spin');
                }

                if(data.Status=='30') {
                    window.location.href='<?=base_url("login");?>';
                    alert('Send Successfully'); 
                    $('.alertmessage').html('<div class="alert alert-danger text-center">Send Successfully!</div>');

                } else if(data.Status=='400' ||  data.Status=='40') {
                    alert('all fields are required'); 
                    $('.alertmessage').html('<div class="alert alert-danger text-center">all fields are required!</div>');

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
            newOwnerRow += '<div class="first_busi_owner_section pointer"><input type="hidden" name="saved_id" class="savedId" value=""><div class="col-12"><span class="cs-label">Name</span><div class="form-group"><div class="fmlname row"><div class="col"><input type="text" class="form-control cl_foname1" value="" name="foname1_arr" placeholder="First" required autocomplete="off"></div><div class="col"><input type="text" class="form-control cl_foname2" value="" name="foname2_arr" placeholder="Middle" autocomplete="off"></div><div class="col"><input type="text" class="form-control cl_foname3" value="" name="foname3_arr" placeholder="Last"  autocomplete="off"></div></div></div></div><div class="col-12"><span class="cs-label">SSN</span><div class="form-group"><input type="text" class="form-control us-ssn-no-enc cl_fossn" name="fossn_arr" value="" placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11" maxlength="9"></div></div><div class="col-12"><span class="cs-label">Date of Birth</span><div class="form-group"><div class="mdy-wraper row"><div class="col"><select class="form-control mb-1 selectOption cl_fodobm" name="fodobm_arr" required><option value="">Month</option><option value="01">Jan</option><option value="02">Feb</option><option value="03">Mar</option><option value="04">Apr</option><option value="05">May</option><option value="06">Jun</option><option value="07">Jul</option><option value="08">Aug</option><option value="09">Sep</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select></div><div class="col"><select class="form-control mb-1 selectOption cl_fodobd" name="fodobd_arr" required><option value="">Day</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></div><div class="col"><select class="form-control mb-1 selectOption cl_fodoby" name="fodoby_arr" required><option value="">Year</option>' + owner_doy + '</select></div></div></div></div><div class="col-12"><span class="cs-label">Home Address</span><div class="form-group mb-5px"><select class="form-control selectOption cl_fohadd_cntry" name="fohadd_cntry_arr" required autocomplete="off"><option value="">Select Country</option><option value="USA">United States of America</option></select></div></div><div class="col-12"><div class="form-group mb-5px"><input type="text" class="form-control cl_fohadd_1" name="fohadd_1_arr" value="" placeholder="Enter Address 1" required autocomplete="off"></div></div><div class="col-12"><div class="form-group mb-5px"><input type="text" class="form-control cl_fohadd_2" name="fohadd_2_arr" value="" placeholder="Enter Address 2" autocomplete="off"></div></div><div class="col-12"><div class="form-group"><div class="csz row"><div class="col"><input type="text" class="form-control mb5 cl_fohadd_city" name="fohadd_city_arr" value="" placeholder="City" required autocomplete="off"></div><div class="col"><select class="form-control mb5 selectOption cl_fohadd_state" name="fohadd_state_arr" required><option value="">Select State</option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option></select></div><div class="col"><input type="text" class="form-control mb5 cl_fohadd_zip" name="fohadd_zip_arr" value="" placeholder="Zip code" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)"></div></div></div></div><div class="col-12"><span class="cs-label">Owner Phone Number</span><div class="form-group"><input type="text" class="form-control us-phone-no cl_fo_phone" value="" name="fo_phone_arr" placeholder="Owner Phone Number" required autocomplete="off"></div></div><div class="col-12"><span class="cs-label">Owner Email Address</span><div class="form-group"><input type="text" class="form-control email cl_fo_email" value="" name="fo_email_arr" placeholder="Owner Email Address" required autocomplete="off"></div></div><hr class="custom_hr"></div>';
            
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
                url: "<?php echo base_url('agent/delete_business_owner');?>",
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

<?php include_once 'footer_dash.php'; ?>
<script src="<?php echo base_url('new_assets/js/script_agent.js')?>"></script>
