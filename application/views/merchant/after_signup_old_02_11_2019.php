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
          <div class="card content-card">
            <div class="card-title">
              <div class="row">
                <div class="col-12">
                  <div class="back-title m-title "> <span>Activate your SaleQuick account:</span></div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row">
                <div class="col-12">
                  <p>In order for your business to begin processing, we need to learn a little more about what you do. All the information you provide will only be visible to the account owner and the administrators of SaleQuick. </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        if(isset($msg))
          echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$msg."</div> </div> </div> </div>";
      ?>
      <?php
          echo form_open('merchant/after_signup', array('id' => "my_form",'class'=>"row after_signup_form"));
          echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
      ?>      
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              <div class="row">
                <div class="col-12">
                  <?php echo '<p>'.validation_errors().'</p>'; ?>
                </div>
                <div class="col-12">
                  <div >
                    Tell us about the product or service you provide ?
                  </div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row">
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Business Service</label>
                      <select name="business_service" required="required" class="form-control">
                        <option>--Select--</option>
                        <option <?php echo $mearchent["business_service"]=="Auto Repair Center"?'selected="selected"':""?>>Auto Repair Center</option>
                        <option <?php echo $mearchent["business_service"]=="Auto Dealer"?'selected="selected"':""?>>Auto Dealer</option>
                        <option <?php echo $mearchent["business_service"]=="Auto Body Shop"?'selected="selected"':""?>>Auto Body Shop</option>
                        <option <?php echo $mearchent["business_service"]=="Glass Shop"?'selected="selected"':""?>>Glass Shop</option>
                        <option <?php echo $mearchent["business_service"]=="Auto Detail Shop"?'selected="selected"':""?>>Auto Detail Shop</option>
                      </select>
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Business website</label>
                      <input class="form-control" required value="<?php echo $mearchent["website"]?>"   size="20" type="text" name="website" placeholder="company.com">
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Business Phone Number</label>
                      <input class="form-control" type="text" value="<?php echo $mearchent["business_number"]?>"  required="required" id="business_number" name="business_number"  placeholder="Business Phone Number">
                    </div>      
                  </div>
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Years in Business</label>
                      <input class="form-control" type="text" required value="<?php echo $mearchent["year_business"]?>"  name="year_business" onKeyPress="return isNumberKey(event)" placeholder="">
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
                <div class="col-12">
                  <div >
                    Give us a short description about your business.
                  </div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row">
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Estimated monthly processing volume:</label>
                      <select class="form-control" name="monthly_processing_volume">
                        <option <?php echo $mearchent["monthly_processing_volume"]=="Less than $10,000"?'selected="selected"':""?>>Less than $10,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$20,000"?'selected="selected"':""?>>$20,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$30,000"?'selected="selected"':""?>>$30,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$40,00"?'selected="selected"':""?>>$40,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$50,000"?'selected="selected"':""?>>$50,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$60,000"?'selected="selected"':""?>>$60,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$70,000"?'selected="selected"':""?>>$70,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$80,000"?'selected="selected"':""?>>$80,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$90,000"?'selected="selected"':""?>>$90,000</option>
                        <option <?php echo $mearchent["monthly_processing_volume"]=="$100,000+"?'selected="selected"':""?>>$100,000+</option>
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
            <div class="card-title">
              <div class="row">
                <div class="col-12">
                  <div >
                    Business Details
                  </div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row">
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Legal Name of Business</label>
                      <input  class="form-control" value="<?php echo $mearchent["business_name"]?>" type="text" required name="business_name" placeholder="Business Legal Name" required>
                    </div>
                  </div>      
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">DBA Name</label>
                      <input class="form-control" type="text" value="<?php echo $mearchent["business_dba_name"]?>" required name="business_dba_name" placeholder="DBA Name">
                    </div>      
                  </div>
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Type of Business</label>
                      <select class="form-control" name="business_type">
                        <option>--Select--</option>
                        <option <?php echo $mearchent["business_type"]=="Sole Proprietorship"?'selected="selected"':""?>>Sole Proprietorship</option>
                        <option <?php echo $mearchent["business_type"]=="Partnership"?'selected="selected"':""?>>Partnership</option>
                        <option <?php echo $mearchent["business_type"]=="Corporation"?'selected="selected"':""?>>Corporation</option>
                        <option <?php echo $mearchent["business_type"]=="Limited Liability Company (LLC)"?'selected="selected"':""?>>Limited Liability Company (LLC)</option>
                        <option>Other</option>
                      </select>
                    </div>      
                  </div>
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Employer Identification Number (EIN)</label>
                      <input class="form-control" value="<?php echo $mearchent["ien_no"]?>" type="text" name="ien_no" placeholder="EIN" required>
                    </div>      
                  </div>
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Street</label>
                      <input class="form-control" value="<?php echo @$mearchent["address1"]?>" type="text" name="address1" placeholder="Street">
                    </div>      
                  </div>
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">City</label>
                      <input class="form-control" value="<?php echo @$mearchent["city"]?>" type="text" name="city" placeholder="city">
                    </div>      
                  </div>
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">State</label>
                      <select class="form-control" id="sel1" name="country">
                        <option value="">--Select--</option>
                        <option <?php if( $mearchent["country"]=='Alabama') echo 'selected';  ?> value="Alabama">Alabama</option>
                        <option <?php if( $mearchent["country"]=='Alaska') echo 'selected';  ?> value="Alaska">Alaska</option>
                        <option <?php if( $mearchent["country"]=='Arizona') echo 'selected';  ?> value="Arizona">Arizona</option>
                        <option <?php if( $mearchent["country"]=='Arkansas') echo 'selected';  ?> value="Arkansas"> Arkansas</option>
                        <option <?php if( $mearchent["country"]=='California') echo 'selected';  ?> value="California">California</option>
                        <option <?php if( $mearchent["country"]=='Colorado') echo 'selected';  ?> value="Colorado">Colorado</option>
                        <option <?php if( $mearchent["country"]=='Connecticut') echo 'selected';  ?> value="Connecticut">Connecticut</option>
                        <option <?php if( $mearchent["country"]=='Delaware') echo 'selected';  ?> value="Delaware"> Delaware</option>
                        <option <?php if( $mearchent["country"]=='Florida') echo 'selected';  ?> value="Florida"> Florida</option>
                        <option <?php if( $mearchent["country"]=='Georgia') echo 'selected';  ?> value="Georgia">Georgia</option>
                        <option <?php if( $mearchent["country"]=='Hawaii') echo 'selected';  ?> value="Hawaii">Hawaii</option>
                        <option <?php if( $mearchent["country"]=='Idaho') echo 'selected';  ?> value="Idaho">Idaho</option>
                        <option <?php if( $mearchent["country"]=='Illinois') echo 'selected';  ?> value="Illinois ">Illinois</option>
                        <option <?php if( $mearchent["country"]=='Indiana') echo 'selected';  ?> value="Indiana">Indiana</option>
                        <option <?php if( $mearchent["country"]=='Iowa') echo 'selected';  ?> value="Iowa">Iowa</option>
                        <option <?php if( $mearchent["country"]=='Kansas') echo 'selected';  ?> value="Kansas">Kansas</option>
                        <option <?php if( $mearchent["country"]=='Kentucky') echo 'selected';  ?> value="Kentucky">Kentucky</option>
                        <option <?php if( $mearchent["country"]=='Louisiana') echo 'selected';  ?> value="Louisiana">Louisiana</option>
                        <option <?php if( $mearchent["country"]=='Maine') echo 'selected';  ?> value="Maine">Maine</option>
                        <option <?php if( $mearchent["country"]=='Maryland') echo 'selected';  ?> value="Maryland"> Maryland</option>
                        <option <?php if( $mearchent["country"]=='Massachusetts') echo 'selected';  ?> value="Massachusetts"> Massachusetts</option>
                        <option <?php if( $mearchent["country"]=='Michigan') echo 'selected';  ?> value="Michigan">Michigan</option>
                        <option <?php if( $mearchent["country"]=='Minnesota') echo 'selected';  ?> value="Minnesota">Minnesota</option>
                        <option <?php if( $mearchent["country"]=='Mississippi') echo 'selected';  ?> value="Mississippi">Mississippi</option>
                        <option <?php if( $mearchent["country"]=='Missouri') echo 'selected';  ?> value="Missouri">Missouri</option>
                        <option <?php if( $mearchent["country"]=='Montana') echo 'selected';  ?> value="Montana">Montana</option>
                        <option <?php if( $mearchent["country"]=='Nebraska') echo 'selected';  ?> value="Nebraska">Nebraska</option>
                        <option <?php if( $mearchent["country"]=='Nevada') echo 'selected';  ?> value="Nevada">Nevada</option>
                        <option <?php if( $mearchent["country"]=='New Hampshire') echo 'selected';  ?> value="New Hampshire">New Hampshire</option>
                        <option <?php if( $mearchent["country"]=='New Jersey') echo 'selected';  ?> value="New Jersey">New Jersey</option>
                        <option <?php if( $mearchent["country"]=='New Mexico') echo 'selected';  ?> value="New Mexico">New Mexico</option>
                        <option <?php if( $mearchent["country"]=='New York') echo 'selected';  ?> value="New York">New York</option>
                        <option <?php if( $mearchent["country"]=='North Carolina') echo 'selected';  ?> value="North Carolina">North Carolina</option>
                        <option <?php if( $mearchent["country"]=='North Dakota') echo 'selected';  ?> value="North Dakota">North Dakota</option>
                        <option <?php if( $mearchent["country"]=='Ohio') echo 'selected';  ?> value="Ohio">Ohio</option>
                        <option <?php if( $mearchent["country"]=='Oklahoma') echo 'selected';  ?> value="Oklahoma">Oklahoma</option>
                        <option <?php if( $mearchent["country"]=='Oregon') echo 'selected';  ?> value="Oregon">Oregon</option>
                        <option <?php if( $mearchent["country"]=='Pennsylvania') echo 'selected';  ?> value="Pennsylvania">Pennsylvania</option>
                        <option <?php if( $mearchent["country"]=='Rhode Island') echo 'selected';  ?> value="Rhode Island">Rhode Island</option>
                        <option <?php if( $mearchent["country"]=='South Carolina') echo 'selected';  ?> value="South Carolina">South Carolina</option>
                        <option <?php if( $mearchent["country"]=='South Dakota') echo 'selected';  ?> value="South Dakota">South Dakota</option>
                        <option <?php if( $mearchent["country"]=='Tennessee') echo 'selected';  ?> value="Tennessee">Tennessee</option>
                        <option <?php if( $mearchent["country"]=='Texas') echo 'selected';  ?> value="Texas">Texas</option>
                        <option <?php if( $mearchent["country"]=='Utah') echo 'selected';  ?> value="Utah">Utah</option>
                        <option <?php if( $mearchent["country"]=='Vermont') echo 'selected';  ?> value="Vermont">Vermont</option>
                        <option <?php if( $mearchent["country"]=='Virginia') echo 'selected';  ?> value="Virginia">Virginia</option>
                        <option <?php if( $mearchent["country"]=='Washington') echo 'selected';  ?> value="Washington">Washington</option>
                        <option <?php if( $mearchent["country"]=='West Virginia') echo 'selected';  ?> value="West Virginia">West Virginia</option>
                        <option <?php if( $mearchent["country"]=='Wisconsin') echo 'selected';  ?> value="Wisconsin">Wisconsin</option>
                        <option <?php if( $mearchent["country"]=='Wyoming') echo 'selected';  ?> value="Wyoming">Wyoming</option>
                      </select>
                    </div>      
                  </div>
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Zip</label>
                      <input class="form-control" value="<?php echo @$mearchent["zip"]?>" type="text" name="zip" placeholder="Zip code">
                    </div>      
                  </div>
                </div>
              </div>
            </div>
          </div> 
        </div>
        <!-- step-2 -->  
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              <div class="row">
                <div class="col-12">
                  <div >
                    Business Owner Information:
                  </div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row custom-form">
                <div class="col-12">
                  <p>The individual who’s interest in the company consists of 51% majority ownership in the company listed above.</p>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" value="<?php echo $mearchent["o_name"]?>" name="o_name" placeholder="First Name">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" value="" name="o_last_name" placeholder="Last Name">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control any-date reg-dob" type="text" value="<?php echo $mearchent["o_dob"]?>" name="o_dob" placeholder="Date of Brith">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control encrypted-field" type="text" value="**-**-****" id="o_ss_number1" name="o_ss_number1" placeholder="***-**-****" required>
                    <input class="form-control" type="hidden" value="<?php echo $mearchent["o_ss_number"]?>" id="o_ss_number" name="o_ss_number"  onKeyPress="return isNumberKey(event)" placeholder="Social Security Number" required>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" value="<?php echo $mearchent["percentage_of_ownership"]?>" name="percentage_of_ownership" placeholder="Percentage of ownership">
                    <input class="form-control" type="hidden" value="<?php echo $mearchent["o_address"]?>" name="o_address" placeholder="Home Address" >
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
                <div class="col-12">
                  <div >
                    Home Address:
                  </div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row">
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Street</label>
                      <input class="form-control" id="" name="bank_street" value="<?php echo $mearchent["bank_street"]?>" type="text" placeholder="street">
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">City</label>
                      <input class="form-control" id="" name="bank_city" value="<?php echo $mearchent["bank_city"]?>" type="text" placeholder="City">
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">State</label>
                      <select class="form-control" id="sel1" name="bank_country" >
                        <option  value="">--Select--</option>
                        <option <?php if( $mearchent["bank_country"]=='Alabama') echo 'selected';  ?> value="Alabama">Alabama</option>
                        <option <?php if( $mearchent["bank_country"]=='Alaska') echo 'selected';  ?> value="Alaska">Alaska</option>
                        <option <?php if( $mearchent["bank_country"]=='Arizona') echo 'selected';  ?> value="Arizona">Arizona</option>
                        <option <?php if( $mearchent["bank_country"]=='Arkansas') echo 'selected';  ?> value="Arkansas"> Arkansas</option>
                        <option <?php if( $mearchent["bank_country"]=='California') echo 'selected';  ?> value="California">California</option>
                        <option <?php if( $mearchent["bank_country"]=='Colorado') echo 'selected';  ?> value="Colorado">Colorado</option>
                        <option <?php if( $mearchent["bank_country"]=='Connecticut') echo 'selected';  ?> value="Connecticut">Connecticut</option>
                        <option <?php if( $mearchent["bank_country"]=='Delaware') echo 'selected';  ?> value="Delaware"> Delaware</option>
                        <option <?php if( $mearchent["bank_country"]=='Florida') echo 'selected';  ?> value="Florida"> Florida</option>
                        <option <?php if( $mearchent["bank_country"]=='Georgia') echo 'selected';  ?> value="Georgia">Georgia</option>
                        <option <?php if( $mearchent["bank_country"]=='Hawaii') echo 'selected';  ?> value="Hawaii">Hawaii</option>
                        <option <?php if( $mearchent["bank_country"]=='Idaho') echo 'selected';  ?> value="Idaho">Idaho</option>
                        <option <?php if( $mearchent["bank_country"]=='Illinois') echo 'selected';  ?> value="Illinois ">Illinois</option>
                        <option <?php if( $mearchent["bank_country"]=='Indiana') echo 'selected';  ?> value="Indiana">Indiana</option>
                        <option <?php if( $mearchent["bank_country"]=='Iowa') echo 'selected';  ?> value="Iowa">Iowa</option>
                        <option <?php if( $mearchent["bank_country"]=='Kansas') echo 'selected';  ?> value="Kansas">Kansas</option>
                        <option <?php if( $mearchent["bank_country"]=='Kentucky') echo 'selected';  ?> value="Kentucky">Kentucky</option>
                        <option <?php if( $mearchent["bank_country"]=='Louisiana') echo 'selected';  ?> value="Louisiana">Louisiana</option>
                        <option <?php if( $mearchent["bank_country"]=='Maine') echo 'selected';  ?> value="Maine">Maine</option>
                        <option <?php if( $mearchent["bank_country"]=='Maryland') echo 'selected';  ?> value="Maryland"> Maryland</option>
                        <option <?php if( $mearchent["bank_country"]=='Massachusetts') echo 'selected';  ?> value="Massachusetts"> Massachusetts</option>
                        <option <?php if( $mearchent["bank_country"]=='Michigan') echo 'selected';  ?> value="Michigan">Michigan</option>
                        <option <?php if( $mearchent["bank_country"]=='Minnesota') echo 'selected';  ?> value="Minnesota">Minnesota</option>
                        <option <?php if( $mearchent["bank_country"]=='Mississippi') echo 'selected';  ?> value="Mississippi">Mississippi</option>
                        <option <?php if( $mearchent["bank_country"]=='Missouri') echo 'selected';  ?> value="Missouri">Missouri</option>
                        <option <?php if( $mearchent["bank_country"]=='Montana') echo 'selected';  ?> value="Montana">Montana</option>
                        <option <?php if( $mearchent["bank_country"]=='Nebraska') echo 'selected';  ?> value="Nebraska">Nebraska</option>
                        <option <?php if( $mearchent["bank_country"]=='Nevada') echo 'selected';  ?> value="Nevada">Nevada</option>
                        <option <?php if( $mearchent["bank_country"]=='New Hampshire') echo 'selected';  ?> value="New Hampshire">New Hampshire</option>
                        <option <?php if( $mearchent["bank_country"]=='New Jersey') echo 'selected';  ?> value="New Jersey">New Jersey</option>
                        <option <?php if( $mearchent["bank_country"]=='New Mexico') echo 'selected';  ?> value="New Mexico">New Mexico</option>
                        <option <?php if( $mearchent["bank_country"]=='New York') echo 'selected';  ?> value="New York">New York</option>
                        <option <?php if( $mearchent["bank_country"]=='North Carolina') echo 'selected';  ?> value="North Carolina">North Carolina</option>
                        <option <?php if( $mearchent["bank_country"]=='North Dakota') echo 'selected';  ?> value="North Dakota">North Dakota</option>
                        <option <?php if( $mearchent["bank_country"]=='Ohio') echo 'selected';  ?> value="Ohio">Ohio</option>
                        <option <?php if( $mearchent["bank_country"]=='Oklahoma') echo 'selected';  ?> value="Oklahoma">Oklahoma</option>
                        <option <?php if( $mearchent["bank_country"]=='Oregon') echo 'selected';  ?> value="Oregon">Oregon</option>
                        <option <?php if( $mearchent["bank_country"]=='Pennsylvania') echo 'selected';  ?> value="Pennsylvania">Pennsylvania</option>
                        <option <?php if( $mearchent["bank_country"]=='Rhode Island') echo 'selected';  ?> value="Rhode Island">Rhode Island</option>
                        <option <?php if( $mearchent["bank_country"]=='South Carolina') echo 'selected';  ?> value="South Carolina">South Carolina</option>
                        <option <?php if( $mearchent["bank_country"]=='South Dakota') echo 'selected';  ?> value="South Dakota">South Dakota</option>
                        <option <?php if( $mearchent["bank_country"]=='Tennessee') echo 'selected';  ?> value="Tennessee">Tennessee</option>
                        <option <?php if( $mearchent["bank_country"]=='Texas') echo 'selected';  ?> value="Texas">Texas</option>
                        <option <?php if( $mearchent["bank_country"]=='Utah') echo 'selected';  ?> value="Utah">Utah</option>
                        <option <?php if( $mearchent["bank_country"]=='Vermont') echo 'selected';  ?> value="Vermont">Vermont</option>
                        <option <?php if( $mearchent["bank_country"]=='Virginia') echo 'selected';  ?> value="Virginia">Virginia</option>
                        <option <?php if( $mearchent["bank_country"]=='Washington') echo 'selected';  ?> value="Washington">Washington</option>
                        <option <?php if( $mearchent["bank_country"]=='West Virginia') echo 'selected';  ?> value="West Virginia">West Virginia</option>
                        <option <?php if( $mearchent["bank_country"]=='Wisconsin') echo 'selected';  ?> value="Wisconsin">Wisconsin</option>
                        <option <?php if( $mearchent["bank_country"]=='Wyoming') echo 'selected';  ?> value="Wyoming">Wyoming</option>
                      </select>
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Zip</label>
                      <input class="form-control" id="" name="bank_zip" value="<?php echo $mearchent["bank_zip"]?>" type="text" placeholder="zip code">
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
                <div class="col-12">
                  <div >
                    Credit card statement details
                  </div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row">
                <div class="col-12">
                  <p>What would you like your customers to see on their credit card statement? We recommend the name they know you by, such as you DBA name. Ex: Joe’s Auto Repair.</p>
                </div>
                <div class="col-4">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Business name</label>
                      <input class="form-control" value="<?php echo $mearchent["cc_business_name"]?>" name="cc_business_name" type="text" placeholder="Your company name" required>
                    </div>
                  </div>      
                </div>
                <div class="col-12">
                  <p>Use the name for your business that your customers will recongnize to help prevent unintended chargebacks.</p>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
              <div class="row">
                <div class="col-12">
                  <div >
                    Bank details
                  </div>
                </div>
              </div>
            </div>
            <div class="card-detail">
              <div class="row">
                <div class="col-12">
                  <p>Please provide us with the bank account where you would like your processing funds deposited to. Make sure all bank information is accurate and correct to prevent any delays in funding.</p>
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Routing number</label>
                      <input class="form-control" type="text" value="<?php echo $mearchent["bank_routing"]?>" name="bank_routing" placeholder="Routing number" required>
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Account number</label>
                      <input class="form-control acc1" id="bank_account" value="<?php echo $mearchent["bank_account"]?>"  name="bank_account" type="password" placeholder="Account number" required>
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Confirm account number</label>
                      <input class="form-control acc2"  value="<?php echo $mearchent["bank_account"]?>" id="bank_account_confirm"  name="bank_account_confirm" type="password" placeholder="Confirm account number" required>
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Bank Name</label>
                      <input class="form-control" id="" name="bank_name" value="<?php echo $mearchent["bank_name"]?>" type="text" placeholder="Bank Name" required>
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Funding Time</label>
                      <input class="form-control" id="" name="funding_time" value="<?php echo $mearchent["funding_time"]?>" type="text" placeholder="Funding Time">
                    </div>
                  </div>      
                </div>
                <div class="col-12 text-right">
                  <div class="form-group">
                    <input type="submit" id="btn_login" name="submit"  class="btn btn-first after_signup_form_submit" value="Submit application " />                  
                  </div>
                  <p >By submitting this information you agree to our service agreement, and that all information you have provided is accurate and complete.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
<!-- End Page Content -->
<script>
function check(input) {
  if (input.value != document.getElementById('bank_account').value) {
    $(input).closest('.form-group').addClass('not-match');
  } 
}
$(function(){
  $("#business_number").mask("(999) 999-9999");
  $('.reg-dob').daterangepicker({
              singleDatePicker: true,
              showDropdowns: true,
              periods: ['day','month','year'],
              locale: {format: "YYYY-MM-DD"}
              }, function(start, end, label) {
          });
}); 
$(document)
.on('keydown','#o_ss_number1',function(event) {
  var ttlV=$(this).val();
  if ( event.keyCode != 46 && event.keyCode != 8 ) 
    {
      if(ttlV)
      {
        var ttlL=ttlV.length;
        if(ttlL == 3)
        {
          $(this).val(ttlV + '-');
        }
        else if(ttlL == 6)
        {
          $(this).val(ttlV + '-');
        }
      }
    }
    // Allow only backspace and delete
    if ( event.keyCode == 46 || event.keyCode == 8 ) 
    {
      // let it happen, don't do anything

    }
    else 
    {
        if($(this).val().length >= 11)
        {
          return false;
        }
        // Ensure that it is a number and stop the keypress
        if (event.keyCode < 48 || event.keyCode > 57 ) 
        {
            event.preventDefault(); 
        }   
    }
})
.on('blur','#o_ss_number1',function(){
  $("#o_ss_number").val($("#o_ss_number1").val());  
})

// -----------

function checkAllRequiredFields($wrapperForm){
  var formFiled=true;
  $wrapperForm.find('input[type="text"][required],input[type="password"][required],input[type="hidden"][required],input[type="email"][required],input[type="date"][required],input[type="tel"][required],select[required]').each(function(){
    console.log($(this).attr('class'));
    if($(this).val() == '')
    {
      var ttTop=$(this).offset().top - $('.topbar').height() - 25;
      console.log(ttTop)
      $('html, body').animate({
          scrollTop: ttTop
      },500);
      $(this).closest('.form-group').addClass('mandatory');
      $(this).focus();
      formFiled=false;
      return false;
    }
    if($(this).hasClass('acc2'))
    {
      var val1=$wrapperForm.find('.form-control.acc1').val();
      var val2=$wrapperForm.find('.form-control.acc2').val();
      console.log(val1)
      console.log(val2)
      if(val1 != val2){
        var ttTop=$(this).offset().top - $('.topbar').height() - 25;
        console.log(ttTop)
        $('html, body').animate({
            scrollTop: ttTop
        },500);
        $(this).closest('.form-group').addClass('not-match');
        $(this).focus();
        formFiled=false;
        return false;
      }
    }
  })
  // setTimeout(function(){
  return formFiled;
  // },50)
}
  $(document).on('click','.after_signup_form_submit',function(e){
    var $wrapperForm=$(this).closest('form');
    console.log(checkAllRequiredFields($wrapperForm))
    if(!checkAllRequiredFields($wrapperForm)){
      e.preventDefault();
    } 
  })
  $(document).on('keydown','.after_signup_form input',function(e){
    $('.after_signup_form .form-group').removeClass('mandatory incorrect not-match');
  })
</script>
<?php
include_once'footer_new.php';
?>