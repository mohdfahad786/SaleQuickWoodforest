<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    span.cs-label {
        color: #adb5c7;
        font-size: 11px;
        font-weight: normal;
        letter-spacing: 1px;
        margin-bottom: 3px;
        display: block;
        font-family: AvenirNext-Medium !important;
    }
    label.chk-label,.chk-label{
        padding: 4px 3px 0;
        cursor: pointer;
        color: #fff;
    }
    .csz .col:nth-child(2),.mdy-wraper .col:nth-child(2),.fmlname .col:nth-child(2){
        padding: 0;
    }
    .aftersignup_tabswrapper {
        max-width: 1000px;
    }
    .aftersignup_tabswrapper .custom-tab .nav.nav-tabs span:last-child {
        display: flex !important;
    }
    .custom-tab .nav-tabs .nav-item a.nav-link {
        border-radius: 5px !important;
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>

        <div class="content-viewport d-none" id="base-contents">
            <div class="row" style="margin-bottom: 30px !important;">
                <div class="col-12">
                    <div class="card content-card">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-12">
                                    <div class="m-title"><span>Activate your account:</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-detail required__message">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-detail  aftersignup_tabswrapper">
                                        <div class="row custom-form custom-tab">
                                            <form class="form-group" id="activateAccountform">
                                                <div class="col-12">
                                                    <ul class="nav nav-tabs" id="activateacc__tabs" role="tablist">
                                                        <li class="nav-item active">
                                                            <a class="nav-link" data-toggle="tab" href="#as_yourb" role="tab" data-val="1" aria-controls="as_yourb"><span class="badge">1.</span> <span>Tell us about your business</span></a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#as__bownerinfo" role="tab" data-val="2" aria-controls="as__bownerinfo"><span class="badge">2.</span> <span style="line-height: 22px !important;">Business Owner Information</span></a>
                                                        </li>
                                                        <li class="nav-item ">
                                                            <a class="nav-link " data-toggle="tab" href="#as__backDet" role="tab" data-val="3" aria-controls="as__backDet"><span class="badge">3.</span> <span  style="line-height: 1.432;">Where would you like your funds deposited</span></a>
                                                        </li>
                                                    </ul>
                        
                                                    <div class="tab-content dobWrapper__activateAcc">
                                                        <div class="tab-pane active" id="as_yourb" role="tabpanel" data-step="1">
                                                            <div class="card_info_inner">
                                                                <div class="row astab__form">
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Legal Business Name</span> 
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control" name="bsns_name" value="<?php echo $mearchent['business_name']; ?>"  required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Legal Business DBA Name</span>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control " name="bsns_dbaname" value="<?php echo $mearchent['business_dba_name']; ?>"   required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Tax Identification Number</span>
                                                                        <div class="form-group">  
                                                                            <input type="text" class="form-control us-tin-no" name="bsns_tin" value="<?php echo $mearchent['taxid']; ?>"   required autocomplete="off" onkeypress="return isNumberKey(event)">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Country</span>
                                                                        <div class="form-group mb-5px">  
                                                                            <select class="form-control selectOption" name="bsnspadd_cnttry"  required autocomplete="off">
                                                                                <option value="">Select Country</option>
                                                                                <option value="USA" <?php if($mearchent['country']=='USA') echo 'selected'; ?>>United States of America</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <span class="cs-label">Physical Address</span>  
                                                                        <div class="form-group mb-5px">
                                                                            <input type="text" class="form-control" name="bsnspadd_1" value="<?php echo $mearchent['address1']; ?>"  placeholder="Enter Address 1" required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group mb-5px">
                                                                            <input type="text" class="form-control" name="bsnspadd_2" value="<?php echo $mearchent['address2']; ?>"  placeholder="Enter Address 2"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">           
                                                                            <div class="csz row">
                                                                                <div class="col">
                                                                                    <span class="cs-label">City</span> 
                                                                                    <input type="text" class="form-control mb5" name="bsnspadd_city" value="<?php echo $mearchent['city']; ?>"  required autocomplete="off">              
                                                                                </div>
                                                                                <div class="col">
                                                                                    <span class="cs-label">State</span> 
                                                                                    <select class="form-control mb5 selectOption" name="bsnspadd_state"  required>
                                                                                        <option value="">Select State</option>
                                                                                        <option value="AL" <?php if($mearchent['state']=='AL') echo 'selected';  ?>>Alabama</option>
                                                                                        <option value="AK" <?php if($mearchent['state']=='AK') echo 'selected';  ?>>Alaska</option>
                                                                                        <option value="AZ" <?php if($mearchent['state']=='AZ') echo 'selected';  ?>>Arizona</option>
                                                                                        <option value="AR" <?php if($mearchent['state']=='AR') echo 'selected';  ?>>Arkansas</option>
                                                                                        <option value="CA" <?php if($mearchent['state']=='CA') echo 'selected';  ?>>California</option>
                                                                                        <option value="CO" <?php if($mearchent['state']=='CO') echo 'selected';  ?>>Colorado</option>
                                                                                        <option value="CT" <?php if($mearchent['state']=='CT') echo 'selected';  ?>>Connecticut</option>
                                                                                        <option value="DE" <?php if($mearchent['state']=='DE') echo 'selected';  ?>>Delaware</option>
                                                                                        <option value="DC" <?php if($mearchent['state']=='DC') echo 'selected';  ?>>District Of Columbia</option>
                                                                                        <option value="FL" <?php if($mearchent['state']=='FL') echo 'selected';  ?>>Florida</option>
                                                                                        <option value="GA" <?php if($mearchent['state']=='GA') echo 'selected';  ?>>Georgia</option>
                                                                                        <option value="HI" <?php if($mearchent['state']=='HI') echo 'selected';  ?>>Hawaii</option>
                                                                                        <option value="ID" <?php if($mearchent['state']=='ID') echo 'selected';  ?>>Idaho</option>
                                                                                        <option value="IL" <?php if($mearchent['state']=='IL') echo 'selected';  ?>>Illinois</option>
                                                                                        <option value="IN" <?php if($mearchent['state']=='IN') echo 'selected';  ?>>Indiana</option>
                                                                                        <option value="IA" <?php if($mearchent['state']=='IA') echo 'selected';  ?>>Iowa</option>
                                                                                        <option value="KS" <?php if($mearchent['state']=='KS') echo 'selected';  ?>>Kansas</option>
                                                                                        <option value="KY" <?php if($mearchent['state']=='KY') echo 'selected';  ?>>Kentucky</option>
                                                                                        <option value="LA" <?php if($mearchent['state']=='LA') echo 'selected';  ?>>Louisiana</option>
                                                                                        <option value="ME" <?php if($mearchent['state']=='ME') echo 'selected';  ?>>Maine</option>
                                                                                        <option value="MD" <?php if($mearchent['state']=='MD') echo 'selected';  ?>>Maryland</option>
                                                                                        <option value="MA" <?php if($mearchent['state']=='MA') echo 'selected';  ?>>Massachusetts</option>
                                                                                        <option value="MI" <?php if($mearchent['state']=='MI') echo 'selected';  ?>>Michigan</option>
                                                                                        <option value="MN" <?php if($mearchent['state']=='MN') echo 'selected';  ?>>Minnesota</option>
                                                                                        <option value="MS" <?php if($mearchent['state']=='MS') echo 'selected';  ?>>Mississippi</option>
                                                                                        <option value="MO" <?php if($mearchent['state']=='MO') echo 'selected';  ?>>Missouri</option>
                                                                                        <option value="MT" <?php if($mearchent['state']=='MT') echo 'selected';  ?>>Montana</option>
                                                                                        <option value="NE" <?php if($mearchent['state']=='NE') echo 'selected';  ?>>Nebraska</option>
                                                                                        <option value="NV" <?php if($mearchent['state']=='NV') echo 'selected';  ?>>Nevada</option>
                                                                                        <option value="NH" <?php if($mearchent['state']=='NH') echo 'selected';  ?>>New Hampshire</option>
                                                                                        <option value="NJ" <?php if($mearchent['state']=='NJ') echo 'selected';  ?>>New Jersey</option>
                                                                                        <option value="NM" <?php if($mearchent['state']=='NM') echo 'selected';  ?>>New Mexico</option>
                                                                                        <option value="NY" <?php if($mearchent['state']=='NY') echo 'selected';  ?>>New York</option>
                                                                                        <option value="NC" <?php if($mearchent['state']=='NC') echo 'selected';  ?>>North Carolina</option>
                                                                                        <option value="ND" <?php if($mearchent['state']=='ND') echo 'selected';  ?>>North Dakota</option>
                                                                                        <option value="OH" <?php if($mearchent['state']=='OH') echo 'selected';  ?>>Ohio</option>
                                                                                        <option value="OK" <?php if($mearchent['state']=='OK') echo 'selected';  ?>>Oklahoma</option>
                                                                                        <option value="OR" <?php if($mearchent['state']=='OR') echo 'selected';  ?>>Oregon</option>
                                                                                        <option value="PA" <?php if($mearchent['state']=='PA') echo 'selected';  ?>>Pennsylvania</option>
                                                                                        <option value="RI" <?php if($mearchent['state']=='RI') echo 'selected';  ?>>Rhode Island</option>
                                                                                        <option value="SC" <?php if($mearchent['state']=='SC') echo 'selected';  ?>>South Carolina</option>
                                                                                        <option value="SD" <?php if($mearchent['state']=='SD') echo 'selected';  ?>>South Dakota</option>
                                                                                        <option value="TN" <?php if($mearchent['state']=='TN') echo 'selected';  ?>>Tennessee</option>
                                                                                        <option value="TX" <?php if($mearchent['state']=='TX') echo 'selected';  ?>>Texas</option>
                                                                                        <option value="UT" <?php if($mearchent['state']=='TX') echo 'selected';  ?>>Utah</option>
                                                                                        <option value="VT" <?php if($mearchent['state']=='VT') echo 'selected';  ?>>Vermont</option>
                                                                                        <option value="VA" <?php if($mearchent['state']=='VA') echo 'selected';  ?>>Virginia</option>
                                                                                        <option value="WA" <?php if($mearchent['state']=='WA') echo 'selected';  ?>>Washington</option>
                                                                                        <option value="WV" <?php if($mearchent['state']=='WV') echo 'selected';  ?>>West Virginia</option>
                                                                                        <option value="WY" <?php if($mearchent['state']=='WY') echo 'selected';  ?>>Wisconsin</option>
                                                                                        <option value="WY" <?php if($mearchent['state']=='WY') echo 'selected';  ?>>Wyoming</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <span class="cs-label">Zip</span> 
                                                                                    <input type="text" class="form-control mb5" name="bsnspadd_zip" value="<?php echo $mearchent['zip']; ?>"   required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Ownership Type</span> 
                                                                        <div class="form-group">             
                                                                            <select class="form-control selectOption" name="bsns_ownrtyp"  required autocomplete="off">
                                                                                <option value="">Select Ownership Type</option>
                                                                                <option value="Government" <?PHP if($mearchent['ownershiptype']=='Government') echo 'selected'; ?>>Government</option>
                                                                                <option value="LLC" <?PHP if($mearchent['ownershiptype']=='LLC') echo 'selected'; ?>>Limited Liability Company</option>
                                                                                <option value="NonProfit" <?PHP if($mearchent['ownershiptype']=='NonProfit') echo 'selected'; ?>>Non-Profit</option>
                                                                                <option value="Partnership" <?PHP if($mearchent['ownershiptype']=='Partnership') echo 'selected'; ?>>Partnership</option>
                                                                                <option value="PrivateCorporation" <?PHP if($mearchent['ownershiptype']=='PrivateCorporation') echo 'selected'; ?>>Private Corporation</option>
                                                                                <option value="PublicCorporation" <?PHP if($mearchent['ownershiptype']=='PublicCorporation') echo 'selected'; ?>>Public Corporation</option>
                                                                                <option value="SoleProprietorship" <?PHP if($mearchent['ownershiptype']=='SoleProprietorship') echo 'selected'; ?>>Sole Proprietorship</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Business Type</span> 
                                                                        <div class="form-group">
                                                                            <select class="form-control selectOption" name="bsns_type"  required autocomplete="off">
                                                                                <option value="">Select Business Type</option>
                                                                                <option value="AutoRental" <?PHP if($mearchent['business_type']=='AutoRental') echo 'selected'; ?>>Auto Rental</option>
                                                                                <option value="ECommerce" <?PHP if($mearchent['business_type']=='ECommerce') echo 'selected'; ?>>E-Commerce</option>
                                                                                <option value="Lodging" <?PHP if($mearchent['business_type']=='Lodging') echo 'selected'; ?>>Lodging</option>
                                                                                <option value="MOTO" <?PHP if($mearchent['business_type']=='MOTO') echo 'selected'; ?>>MOTO</option>
                                                                                <option value="Restaurant" <?PHP if($mearchent['business_type']=='Restaurant') echo 'selected'; ?>>Restaurant</option>
                                                                                <option value="Retail" <?PHP if($mearchent['business_type']=='Retail') echo 'selected'; ?>>Retail</option>
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
                                                                                        <option value="01" <?php if($mearchent['month_business']=='01') echo 'selected'; ?> >Jan</option>
                                                                                        <option value="02" <?php if($mearchent['month_business']=='02') echo 'selected'; ?>>Feb</option>
                                                                                        <option value="03" <?php if($mearchent['month_business']=='03') echo 'selected'; ?>>Mar</option>
                                                                                        <option value="04" <?php if($mearchent['month_business']=='04') echo 'selected'; ?>>Apr</option>
                                                                                        <option value="05" <?php if($mearchent['month_business']=='05') echo 'selected'; ?>>May</option>
                                                                                        <option value="06" <?php if($mearchent['month_business']=='06') echo 'selected'; ?>>Jun</option>
                                                                                        <option value="07" <?php if($mearchent['month_business']=='07') echo 'selected'; ?>>Jul</option>
                                                                                        <option value="08" <?php if($mearchent['month_business']=='08') echo 'selected'; ?>>Aug</option>
                                                                                        <option value="09" <?php if($mearchent['month_business']=='09') echo 'selected'; ?>>Sep</option>
                                                                                        <option value="10" <?php if($mearchent['month_business']=='10') echo 'selected'; ?>>Oct</option>
                                                                                        <option value="11" <?php if($mearchent['month_business']=='11') echo 'selected'; ?>>Nov</option>
                                                                                        <option value="12" <?php if($mearchent['month_business']=='12') echo 'selected'; ?>>Dec</option>
                                                                                    </select>        
                                                                                </div>
                                                                                <div class="col">
                                                                                    <select class="form-control mb-5px selectOption" name="bsns_strtdate_d"  required>
                                                                                        <option value="">Day</option>
                                                                                        <option value="01" <?php if($mearchent['day_business']=='01') echo 'selected'; ?>>01</option>
                                                                                        <option value="02" <?php if($mearchent['day_business']=='02') echo 'selected'; ?>>02</option>
                                                                                        <option value="03" <?php if($mearchent['day_business']=='03') echo 'selected'; ?>>03</option>
                                                                                        <option value="04" <?php if($mearchent['day_business']=='04') echo 'selected'; ?>>04</option>
                                                                                        <option value="05" <?php if($mearchent['day_business']=='05') echo 'selected'; ?>>05</option>
                                                                                        <option value="06" <?php if($mearchent['day_business']=='06') echo 'selected'; ?>>06</option>
                                                                                        <option value="07" <?php if($mearchent['day_business']=='07') echo 'selected'; ?>>07</option>
                                                                                        <option value="08" <?php if($mearchent['day_business']=='08') echo 'selected'; ?> >08</option>
                                                                                        <option value="09" <?php if($mearchent['day_business']=='09') echo 'selected'; ?> >09</option>
                                                                                        <option value="10" <?php if($mearchent['day_business']=='10') echo 'selected'; ?>>10</option>
                                                                                        <option value="11" <?php if($mearchent['day_business']=='11') echo 'selected'; ?>>11</option>
                                                                                        <option value="12" <?php if($mearchent['day_business']=='12') echo 'selected'; ?>>12</option>
                                                                                        <option value="13" <?php if($mearchent['day_business']=='13') echo 'selected'; ?>>13</option>
                                                                                        <option value="14" <?php if($mearchent['day_business']=='14') echo 'selected'; ?>>14</option>
                                                                                        <option value="15" <?php if($mearchent['day_business']=='15') echo 'selected'; ?>>15</option>
                                                                                        <option value="16" <?php if($mearchent['day_business']=='16') echo 'selected'; ?>>16</option>
                                                                                        <option value="17" <?php if($mearchent['day_business']=='17') echo 'selected'; ?>>17</option>
                                                                                        <option value="18" <?php if($mearchent['day_business']=='18') echo 'selected'; ?>>18</option>
                                                                                        <option value="19" <?php if($mearchent['day_business']=='19') echo 'selected'; ?>>19</option>
                                                                                        <option value="20" <?php if($mearchent['day_business']=='20') echo 'selected'; ?>>20</option>
                                                                                        <option value="21" <?php if($mearchent['day_business']=='21') echo 'selected'; ?>>21</option>
                                                                                        <option value="22" <?php if($mearchent['day_business']=='22') echo 'selected'; ?> >22</option>
                                                                                        <option value="23" <?php if($mearchent['day_business']=='23') echo 'selected'; ?>>23</option>
                                                                                        <option value="24" <?php if($mearchent['day_business']=='24') echo 'selected'; ?>>24</option>
                                                                                        <option value="25" <?php if($mearchent['day_business']=='25') echo 'selected'; ?>>25</option>
                                                                                        <option value="26" <?php if($mearchent['day_business']=='26') echo 'selected'; ?>>26</option>
                                                                                        <option value="27" <?php if($mearchent['day_business']=='27') echo 'selected'; ?>>27</option>
                                                                                        <option value="28" <?php if($mearchent['day_business']=='28') echo 'selected'; ?>>28</option>
                                                                                        <option value="29" <?php if($mearchent['day_business']=='29') echo 'selected'; ?>>29</option>
                                                                                        <option value="30" <?php if($mearchent['day_business']=='30') echo 'selected'; ?>>30</option>
                                                                                        <option value="31" <?php if($mearchent['day_business']=='31') echo 'selected'; ?>>31</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <select class="form-control mb-5px selectOption" name="bsns_strtdate_y"  required>
                                                                                        <option value="">Year</option>
                                                                                        <option value="<?=$mearchent['year_business']?>"  selected><?=$mearchent['year_business']?></option>
                                                                                        <?php 
                                                                                        $year=date('Y');
                                                                                        $startYear=$mearchent['year_business']+1; 
                                                                                        for($i=$startYear; $startYear<=$year;  $startYear++) {
                                                                                        ?> 
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
                                                                            <input type="text" class="form-control us-phone-no" name="bsns_phone" value="<?php echo $mearchent['business_number']; ?>" required autocomplete="off" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Business Email Address</span> 
                                                                        <div class="form-group">  
                                                                            <input type="text" class="form-control email" name="bsns_email" value="<?php echo $mearchent['business_email']; ?>" required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Customer Service Phone Number</span> 
                                                                        <div class="form-group">  
                                                                            <input type="text" class="form-control us-phone-no" name="custServ_phone" value="<?php echo $mearchent['customer_service_phone']; ?>" required autocomplete="off" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Customer Service Email Address</span> 
                                                                        <div class="form-group">  
                                                                            <input type="text" class="form-control email" name="custServ_email" value="<?php echo $mearchent['customer_service_email']; ?>" required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Website</span>
                                                                        <div class="form-group">  
                                                                            <input type="text" class="form-control" name="bsns_website" value="<?php echo $mearchent['website']; ?>"  placeholder="https://www.yourwebsite.com" required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <span class="cs-label">Annual Processing Volume</span>
                                                                        <div class="form-group">   
                                                                            <select class="form-control selectOption" name="mepvolume" required>
                                                                                <option value="">Estimated Annual Processing Volume</option>
                                                                                <option value="10000" <?php if($mearchent['annual_processing_volume']=='10000')echo 'selected'; ?> >$10,000</option>
                                                                                <option value="20000" <?php if($mearchent['annual_processing_volume']=='20000')echo 'selected'; ?>>$20,000</option>
                                                                                <option value="30000" <?php if($mearchent['annual_processing_volume']=='30000')echo 'selected'; ?>>$30,000</option>
                                                                                <option value="40000" <?php if($mearchent['annual_processing_volume']=='40000')echo 'selected'; ?>>$40,000</option>
                                                                                <option value="50000" <?php if($mearchent['annual_processing_volume']=='50000')echo 'selected'; ?>>$50,000</option>
                                                                                <option value="60000" <?php if($mearchent['annual_processing_volume']=='60000')echo 'selected'; ?>>$60,000</option>
                                                                                <option value="70000" <?php if($mearchent['annual_processing_volume']=='70000')echo 'selected'; ?>>$70,000</option>
                                                                                <option value="80000" <?php if($mearchent['annual_processing_volume']=='80000')echo 'selected'; ?>>$80,000</option>
                                                                                <option value="90000" <?php if($mearchent['annual_processing_volume']=='90000')echo 'selected'; ?>>$90,000</option>
                                                                                <option value="100000" <?php if($mearchent['annual_processing_volume']=='100000')echo 'selected'; ?>>$100,000+</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group text-right"> 
                                                                            <button type="button" class="btn btn-first initail stepper-next">Next</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane " id="as__bownerinfo" role="tabpanel" data-step="2">
                                                            <div class="row astab__form">
                                                                <div class="col-12">
                                                                    <span class="cs-label">Name</span> 
                                                                    <div class="form-group">             
                                                                        <div class="fmlname row">
                                                                            <div class="col">
                                                                                <input type="text" class="form-control" value="<?php if($mearchent['o_name']){ echo $mearchent['o_name']; } else {$mearchent['name']; } ?>" name="foname1" placeholder="First" required autocomplete="off">
                                                                            </div>
                                                                            <div class="col">
                                                                                <input type="text" class="form-control" value="<?php echo $mearchent['m_name'];  ?> " name="foname2" placeholder="Middle"  autocomplete="off">
                                                                            </div>
                                                                            <div class="col">
                                                                                <input type="text" class="form-control" value="<?php echo $mearchent['l_name'];  ?>" name="foname3" placeholder="Last"  autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">SSN</span>
                                                                    <div class="form-group"> 
                                                                        <input type="text" class="form-control us-ssn-no-enc" name="fossn" value="<?php echo $mearchent['o_ss_number']; ?>" placeholder="SSN" required autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="11" maxlength="9">     
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">Date of Birth</span>           
                                                                    <div class="form-group">        
                                                                        <div class="mdy-wraper row">
                                                                            <div class="col">
                                                                                <select class="form-control mb-1 selectOption" name="fodobm"  required>
                                                                                    <option value="">Month</option>
                                                                                    <option value="01" <?php if($mearchent['o_dob_m']=='01') echo 'selected'; ?> >Jan</option>
                                                                                    <option value="02" <?php if($mearchent['o_dob_m']=='02') echo 'selected'; ?>>Feb</option>
                                                                                    <option value="03" <?php if($mearchent['o_dob_m']=='03') echo 'selected'; ?>>Mar</option>
                                                                                    <option value="04" <?php if($mearchent['o_dob_m']=='04') echo 'selected'; ?>>Apr</option>
                                                                                    <option value="05" <?php if($mearchent['o_dob_m']=='05') echo 'selected'; ?>>May</option>
                                                                                    <option value="06" <?php if($mearchent['o_dob_m']=='06') echo 'selected'; ?>>Jun</option>
                                                                                    <option value="07" <?php if($mearchent['o_dob_m']=='07') echo 'selected'; ?>>Jul</option>
                                                                                    <option value="08" <?php if($mearchent['o_dob_m']=='08') echo 'selected'; ?>>Aug</option>
                                                                                    <option value="09" <?php if($mearchent['o_dob_m']=='09') echo 'selected'; ?>>Sep</option>
                                                                                    <option value="10" <?php if($mearchent['o_dob_m']=='10') echo 'selected'; ?>>Oct</option>
                                                                                    <option value="11" <?php if($mearchent['o_dob_m']=='11') echo 'selected'; ?>>Nov</option>
                                                                                    <option value="12" <?php if($mearchent['o_dob_m']=='12') echo 'selected'; ?>>Dec</option>
                                                                                </select>                 
                                                                            </div>
                                                                            <div class="col">
                                                                                <select class="form-control mb-1 selectOption" name="fodobd"  required>
                                                                                    <option value="">Day</option>
                                                                                    <option value="01" <?php if($mearchent['o_dob_d']=='01') echo 'selected'; ?>>01</option>
                                                                                    <option value="02" <?php if($mearchent['o_dob_d']=='02') echo 'selected'; ?>>02</option>
                                                                                    <option value="03" <?php if($mearchent['o_dob_d']=='03') echo 'selected'; ?>>03</option>
                                                                                    <option value="04" <?php if($mearchent['o_dob_d']=='04') echo 'selected'; ?>>04</option>
                                                                                    <option value="05" <?php if($mearchent['o_dob_d']=='05') echo 'selected'; ?>>05</option>
                                                                                    <option value="06" <?php if($mearchent['o_dob_d']=='06') echo 'selected'; ?>>06</option>
                                                                                    <option value="07" <?php if($mearchent['o_dob_d']=='07') echo 'selected'; ?>>07</option>
                                                                                    <option value="08" <?php if($mearchent['o_dob_d']=='08') echo 'selected'; ?> >08</option>
                                                                                    <option value="09" <?php if($mearchent['o_dob_d']=='09') echo 'selected'; ?> >09</option>
                                                                                    <option value="10" <?php if($mearchent['o_dob_d']=='10') echo 'selected'; ?>>10</option>
                                                                                    <option value="11" <?php if($mearchent['o_dob_d']=='11') echo 'selected'; ?>>11</option>
                                                                                    <option value="12" <?php if($mearchent['o_dob_d']=='12') echo 'selected'; ?>>12</option>
                                                                                    <option value="13" <?php if($mearchent['o_dob_d']=='13') echo 'selected'; ?>>13</option>
                                                                                    <option value="14" <?php if($mearchent['o_dob_d']=='14') echo 'selected'; ?>>14</option>
                                                                                    <option value="15" <?php if($mearchent['o_dob_d']=='15') echo 'selected'; ?>>15</option>
                                                                                    <option value="16" <?php if($mearchent['o_dob_d']=='16') echo 'selected'; ?>>16</option>
                                                                                    <option value="17" <?php if($mearchent['o_dob_d']=='17') echo 'selected'; ?>>17</option>
                                                                                    <option value="18" <?php if($mearchent['o_dob_d']=='18') echo 'selected'; ?>>18</option>
                                                                                    <option value="19" <?php if($mearchent['o_dob_d']=='19') echo 'selected'; ?>>19</option>
                                                                                    <option value="20" <?php if($mearchent['o_dob_d']=='20') echo 'selected'; ?>>20</option>
                                                                                    <option value="21" <?php if($mearchent['o_dob_d']=='21') echo 'selected'; ?>>21</option>
                                                                                    <option value="22" <?php if($mearchent['o_dob_d']=='22') echo 'selected'; ?> >22</option>
                                                                                    <option value="23" <?php if($mearchent['o_dob_d']=='23') echo 'selected'; ?>>23</option>
                                                                                    <option value="24" <?php if($mearchent['o_dob_d']=='24') echo 'selected'; ?>>24</option>
                                                                                    <option value="25" <?php if($mearchent['o_dob_d']=='25') echo 'selected'; ?>>25</option>
                                                                                    <option value="26" <?php if($mearchent['o_dob_d']=='26') echo 'selected'; ?>>26</option>
                                                                                    <option value="27" <?php if($mearchent['o_dob_d']=='27') echo 'selected'; ?>>27</option>
                                                                                    <option value="28" <?php if($mearchent['o_dob_d']=='28') echo 'selected'; ?>>28</option>
                                                                                    <option value="29" <?php if($mearchent['o_dob_d']=='29') echo 'selected'; ?>>29</option>
                                                                                    <option value="30" <?php if($mearchent['o_dob_d']=='30') echo 'selected'; ?>>30</option>
                                                                                    <option value="31" <?php if($mearchent['o_dob_d']=='31') echo 'selected'; ?>>31</option>
                                                                                </select>            
                                                                            </div>
                                                                            <div class="col">
                                                                                <select class="form-control mb-1 selectOption" name="fodoby"  required>
                                                                                    <option value="">Year</option>
                                                                                    <option value="<?=$mearchent['o_dob_y']?>"  selected><?=$mearchent['o_dob_y']?></option>
                                                                                    <?php  
                                                                                    $year=date('Y');
                                                                                    $startYear=$mearchent['o_dob_y'] ?$mearchent['o_dob_y']-10 :'1900'; 
                                                                                    for($i=$startYear; $startYear<=$year;  $startYear++){ ?>
                                                                                        <option value="<?=$startYear?>"><?=$startYear?></option>
                                                                                    <?php } ?>
                                                                                </select>     
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">Country</span>
                                                                    <div class="form-group mb-5px">  
                                                                        <select class="form-control selectOption" name="fohadd_cntry"  required autocomplete="off">
                                                                            <option value="">Select Country</option>
                                                                            <option value="USA" <?php if($mearchent['o_country']=='USA') echo 'selected'; ?>>United States of America</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">Home Address</span>
                                                                    <div class="form-group mb-5px">
                                                                        <input type="text" class="form-control" name="fohadd_1" value="<?php echo $mearchent['o_address1'];  ?>"  placeholder="Enter Address 1" required autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group mb-5px">         
                                                                        <input type="text" class="form-control" name="fohadd_2" value="<?php echo $mearchent['o_address2'];  ?>"  placeholder="Enter Address 2"  autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">           
                                                                        <div class="csz row">
                                                                            <div class="col">
                                                                                <span class="cs-label">City</span>
                                                                                <input type="text" class="form-control mb5" name="fohadd_city" value="<?php echo $mearchent['o_city'];  ?>"  placeholder="Enter City" required autocomplete="off">
                                                                            </div>
                                                                            <div class="col">
                                                                                <span class="cs-label">State</span>
                                                                                <select class="form-control mb5 selectOption" name="fohadd_state"  required>
                                                                                    <option value="">Select State</option>
                                                                                    <option value="AL" <?php if($mearchent['o_state']=='AL') echo 'selected';  ?>>Alabama</option>
                                                                                    <option value="AK" <?php if($mearchent['o_state']=='AK') echo 'selected';  ?>>Alaska</option>
                                                                                    <option value="AZ" <?php if($mearchent['o_state']=='AZ') echo 'selected';  ?>>Arizona</option>
                                                                                    <option value="AR" <?php if($mearchent['o_state']=='AR') echo 'selected';  ?>>Arkansas</option>
                                                                                    <option value="CA" <?php if($mearchent['o_state']=='CA') echo 'selected';  ?>>California</option>
                                                                                    <option value="CO" <?php if($mearchent['o_state']=='CO') echo 'selected';  ?>>Colorado</option>
                                                                                    <option value="CT" <?php if($mearchent['o_state']=='CT') echo 'selected';  ?>>Connecticut</option>
                                                                                    <option value="DE" <?php if($mearchent['o_state']=='DE') echo 'selected';  ?>>Delaware</option>
                                                                                    <option value="DC" <?php if($mearchent['o_state']=='DC') echo 'selected';  ?>>District Of Columbia</option>
                                                                                    <option value="FL" <?php if($mearchent['o_state']=='FL') echo 'selected';  ?>>Florida</option>
                                                                                    <option value="GA" <?php if($mearchent['o_state']=='GA') echo 'selected';  ?>>Georgia</option>
                                                                                    <option value="HI" <?php if($mearchent['o_state']=='HI') echo 'selected';  ?>>Hawaii</option>
                                                                                    <option value="ID" <?php if($mearchent['o_state']=='ID') echo 'selected';  ?>>Idaho</option>
                                                                                    <option value="IL" <?php if($mearchent['o_state']=='IL') echo 'selected';  ?>>Illinois</option>
                                                                                    <option value="IN" <?php if($mearchent['o_state']=='IN') echo 'selected';  ?>>Indiana</option>
                                                                                    <option value="IA" <?php if($mearchent['o_state']=='IA') echo 'selected';  ?>>Iowa</option>
                                                                                    <option value="KS" <?php if($mearchent['o_state']=='KS') echo 'selected';  ?>>Kansas</option>
                                                                                    <option value="KY" <?php if($mearchent['o_state']=='KY') echo 'selected';  ?>>Kentucky</option>
                                                                                    <option value="LA" <?php if($mearchent['o_state']=='LA') echo 'selected';  ?>>Louisiana</option>
                                                                                    <option value="ME" <?php if($mearchent['o_state']=='ME') echo 'selected';  ?>>Maine</option>
                                                                                    <option value="MD" <?php if($mearchent['o_state']=='MD') echo 'selected';  ?>>Maryland</option>
                                                                                    <option value="MA" <?php if($mearchent['o_state']=='MA') echo 'selected';  ?>>Massachusetts</option>
                                                                                    <option value="MI" <?php if($mearchent['o_state']=='MI') echo 'selected';  ?>>Michigan</option>
                                                                                    <option value="MN" <?php if($mearchent['o_state']=='MN') echo 'selected';  ?>>Minnesota</option>
                                                                                    <option value="MS" <?php if($mearchent['o_state']=='MS') echo 'selected';  ?>>Mississippi</option>
                                                                                    <option value="MO" <?php if($mearchent['o_state']=='MO') echo 'selected';  ?>>Missouri</option>
                                                                                    <option value="MT" <?php if($mearchent['o_state']=='MT') echo 'selected';  ?>>Montana</option>
                                                                                    <option value="NE" <?php if($mearchent['o_state']=='NE') echo 'selected';  ?>>Nebraska</option>
                                                                                    <option value="NV" <?php if($mearchent['o_state']=='NV') echo 'selected';  ?>>Nevada</option>
                                                                                    <option value="NH" <?php if($mearchent['o_state']=='NH') echo 'selected';  ?>>New Hampshire</option>
                                                                                    <option value="NJ" <?php if($mearchent['o_state']=='NJ') echo 'selected';  ?>>New Jersey</option>
                                                                                    <option value="NM" <?php if($mearchent['o_state']=='NM') echo 'selected';  ?>>New Mexico</option>
                                                                                    <option value="NY" <?php if($mearchent['o_state']=='NY') echo 'selected';  ?>>New York</option>
                                                                                    <option value="NC" <?php if($mearchent['o_state']=='NC') echo 'selected';  ?>>North Carolina</option>
                                                                                    <option value="ND" <?php if($mearchent['o_state']=='ND') echo 'selected';  ?>>North Dakota</option>
                                                                                    <option value="OH" <?php if($mearchent['o_state']=='OH') echo 'selected';  ?>>Ohio</option>
                                                                                    <option value="OK" <?php if($mearchent['o_state']=='OK') echo 'selected';  ?>>Oklahoma</option>
                                                                                    <option value="OR" <?php if($mearchent['o_state']=='OR') echo 'selected';  ?>>Oregon</option>
                                                                                    <option value="PA" <?php if($mearchent['o_state']=='PA') echo 'selected';  ?>>Pennsylvania</option>
                                                                                    <option value="RI" <?php if($mearchent['o_state']=='RI') echo 'selected';  ?>>Rhode Island</option>
                                                                                    <option value="SC" <?php if($mearchent['o_state']=='SC') echo 'selected';  ?>>South Carolina</option>
                                                                                    <option value="SD" <?php if($mearchent['o_state']=='SD') echo 'selected';  ?>>South Dakota</option>
                                                                                    <option value="TN" <?php if($mearchent['o_state']=='TN') echo 'selected';  ?>>Tennessee</option>
                                                                                    <option value="TX" <?php if($mearchent['o_state']=='TX') echo 'selected';  ?>>Texas</option>
                                                                                    <option value="UT" <?php if($mearchent['o_state']=='TX') echo 'selected';  ?>>Utah</option>
                                                                                    <option value="VT" <?php if($mearchent['o_state']=='VT') echo 'selected';  ?>>Vermont</option>
                                                                                    <option value="VA" <?php if($mearchent['o_state']=='VA') echo 'selected';  ?>>Virginia</option>
                                                                                    <option value="WA" <?php if($mearchent['o_state']=='WA') echo 'selected';  ?>>Washington</option>
                                                                                    <option value="WV" <?php if($mearchent['o_state']=='WV') echo 'selected';  ?>>West Virginia</option>
                                                                                    <option value="WY" <?php if($mearchent['o_state']=='WY') echo 'selected';  ?>>Wisconsin</option>
                                                                                    <option value="WY" <?php if($mearchent['o_state']=='WY') echo 'selected';  ?>>Wyoming</option>
                                                                                </select>            
                                                                            </div>
                                                                            <div class="col">
                                                                                <span class="cs-label">Zip</span>
                                                                                <input type="text" class="form-control mb5" name="fohadd_zip" value="<?php echo $mearchent['o_zip'];  ?>"  placeholder="Enter Zip" required autocomplete="off" maxlength="6" onkeypress="return isNumberKey(event)">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">Phone Number</span>
                                                                    <div class="form-group">   
                                                                        <input type="text" class="form-control us-phone-no" value="<?php echo $mearchent['o_phone'];  ?>" name="fo_phone"  required autocomplete="off" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">Email Address</span>
                                                                    <div class="form-group">   
                                                                        <input type="text" class="form-control email" value="<?php echo $mearchent['o_email'];  ?>" name="fo_email"  required autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group text-right">
                                                                        <button type="button" class="btn btn-first initail stepper-next"> Next</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane " id="as__backDet" role="tabpanel" data-step="3">
                                                            <div class="row astab__form">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <select class="form-control selectOption" name="bank_dda_type"  required autocomplete="off">
                                                                            <option value="">Select Bank Account DDA Type</option>
                                                                            <option value="CommercialChecking" <?php if($mearchent['bank_dda']=='CommercialChecking') echo 'selected'; ?>>Commercial Checking</option>
                                                                            <option value="PrivateChecking" <?php if($mearchent['bank_dda']=='PrivateChecking') echo 'selected'; ?>>Private Checking</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">            
                                                                        <select class="form-control selectOption" name="baccachtype"  required autocomplete="off">
                                                                            <option value="">Select Bank Account ACH Type</option>
                                                                            <option value="CommercialChecking" <?php if($mearchent['bank_ach']=='CommercialChecking') echo 'selected'; ?>>Business Checking</option>
                                                                            <option value="PrivateChecking" <?php if($mearchent['bank_ach']=='PrivateChecking') echo 'selected'; ?>>Personal Checking</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">Routing Number</span>
                                                                    <div class="form-group">  
                                                                        <input type="text" class="form-control us-routing" maxlength="9" name="routeNo" value="<?php echo $mearchent['bank_routing']; ?>"   required autocomplete="off" onkeypress="return isNumberKey(event)">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span class="cs-label">Account Number</span>
                                                                    <div class="form-group">  
                                                                        <input type="text" class="form-control us-acc-no" maxlength="17" name="accno" value="<?php echo $mearchent['bank_account']; ?>"   required autocomplete="off" onkeypress="return isNumberKey(event)">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group text-right"> 
                                                                        <button type="button" class="btn btn-first initail stepper-next"> Update Account</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="col-12">
                                            <div class="form-group alert_message" style="text-align:center;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header {
        border-bottom: 1px solid #fff !important;
    }
</style>
<div class="modal fade" id="update_popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="update_popup_msg"></p>
            </div>
        </div>
    </div>
</div>
<!-- <script>
    $(document).ready(function () {
        $("#update_popup").modal('show');
        return false;
    })
</script> -->

<script>
    $(function(){
        $('.required__message').on('keydown click',function(){
            $('.required__message .form-group').removeClass('not-match mandatory incorrect');
        })
        $("#business_number").mask("(999) 999-9999");
        $('.reg-dob').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            periods: ['day','month','year'],
            locale: {format: "YYYY-MM-DD"}
            }, function(start, end, label) {
        });
    });

    function checkAllRequiredClassFields($wrapperForm){
        var emailRegx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;// Email address
        var formFiled=true;
        $wrapperForm.find('[required]:not(:hidden)').each(function() {
            var txtVal=$(this).val();
            if(!txtVal) {
                var ttTop=$(this).offset().top - $('.topbar').height() - 25;
                // console.log(ttTop)
                $('html, body').animate({
                    scrollTop: ttTop
                },500);
                $(this).closest('.form-group').addClass('mandatory');
                $(this).focus();
                formFiled=false;
                return formFiled;
            }
            txtVal=txtVal.trim();
            if($(this).hasClass('email')) {
                if(!emailRegx.test(txtVal)) {
                    $(this).closest('.form-group').addClass('incorrect');
                    $(this).focus();
                    formFiled=false;
                    return false;
                }
            }
            //check if routing
            if($(this).hasClass('us-routing-c')) {
                if(txtVal != $('.us-routing').val().trim()) {
                    $(this).closest('.form-group').addClass('not-match');
                    $(this).focus();
                    formFiled=false;
                    return false;
                }
            }
            //check if acc-no
            if($(this).hasClass('us-acc-no-c')) {
                if(txtVal != $('.us-acc-no').val().trim()) {
                    $(this).closest('.form-group').addClass('not-match');
                    $(this).focus();
                    formFiled=false;
                    return false;
                }
            }
        })
        return formFiled;
    }

    $(document).on('keydown','.after_signup_form input',function(e){
        $('.after_signup_form .form-group').removeClass('mandatory incorrect not-match');
    })
</script>

<style type="text/css">
    .login-register.v-center {
        position: relative !important;
        top: 0 !important;
        left: 0 !important;
        transform: none !important;
    }
    .custom-stepper-form .form-steps .step:not(:last-child):after{
        background: #90b9ed;
    }
</style>

<script>
    $(function(){
        setTimeout(function(){
            $('.selectOption').each(function(){
                $(this).select2();
            })
        },300)
        $(".us-phone-no").mask("(999) 999-9999");
        $(".us-tin-no").mask("99-9999999");
    })

    $(document) 
    .on('click','.aftersignup_tabswrapper .astab__form .stepper-next',function(){
        var $wrapperForm=$(this).closest('.astab__form');
        if(checkAllRequiredClassFields($wrapperForm)) {
            //start ajax here
            //console.log(retrunAllInputs($wrapperForm));
            var nextStp=parseInt($(this).closest('.tab-pane').data().step) + 1;
            // console.log(nextStp);
            if(nextStp <= 3) {
                $('.aftersignup_tabswrapper .nav.nav-tabs .nav-link[data-val="'+(nextStp -1)+'"] span:first-child').removeClass('badge').text('').addClass('fa fa-check').parent().addClass('status_success');

                $('.aftersignup_tabswrapper .nav.nav-tabs .nav-link[data-val="'+nextStp+'"]').trigger('click');

                $('.aftersignup_tabswrapper .nav.nav-tabs .nav-link[data-val="'+(nextStp -1)+'"]').closest('li').removeClass('active');

                $('.aftersignup_tabswrapper .nav.nav-tabs .nav-link[data-val="'+nextStp+'"]').closest('li').addClass('active');

            } else if(nextStp == 4) {
                var alldata=$('#activateAccountform').serialize();
                //console.log(alldata); 
                $('.update_popup_msg').html('');
                $.ajax({
                    type: "POST",
                    url:'<?php echo base_url('merchant/updateAfetrsignupformdata'); ?>',  
                    data:$('#activateAccountform').serialize(), // serializes the form's elements. //  ?'+$('#activateAccountform').serialize()
                    success: function(data) {
                        var ab='<?php echo base_url('merchant/updateAfetrsignupformdata'); ?>?'+$('#activateAccountform').serialize();
                        var urlParams = new URLSearchParams(ab);
                        console.log(urlParams.get('bsns_dbaname'));
                        console.log(data);
                        if(data=='200') {
                            $('.user-name').html(urlParams.get('bsns_dbaname')); 
                            $('.user-icon-text').html(urlParams.get('foname1').charAt(0)); 
                            $('.update_popup_msg').html('<span class="text-success">Account details updated successfully.</span>');
                            $("#update_popup").modal('show');
                            $('.aftersignup_tabswrapper .nav.nav-tabs .nav-link[data-val="'+(nextStp -1)+'"] span:first-child').removeClass('badge').text('').addClass('fa fa-check').parent().addClass('status_success');
                        } else {
                            $('.update_popup_msg').html('<span class="text-danger">'+data+'</span>');
                            $("#update_popup").modal('show');
                        }
                    }
                });
            }
        }
    })
  
    // .on('click','.aftersignup_tabswrapper .astab__form .stepper-back',function(){
    //     var $wrapperForm=$(this).closest('.astab__form');
    //       if(checkAllRequiredClassFields($wrapperForm)){
    //         //start ajax here
    //         var prevStp=parseInt($(this).closest('.tab-pane').data().step) - 1;
    //         if(prevStp != 0){
    //           $('.aftersignup_tabswrapper .astab__form .form-step').removeClass('active');
    //  $('.aftersignup_tabswrapper .astab__form .form-step[data-fstep="'+prevStp+'"]').addClass('active');
    //           // console.log(prevStp)
    //           $('.aftersignup_tabswrapper .form-steps .step').removeClass('active');
    //  $('.aftersignup_tabswrapper .form-steps .step[data-fstep="'+prevStp+'"]').addClass('active');
    //  $('.aftersignup_tabswrapper .form-steps .step[data-fstep="'+prevStp+'"]').removeClass('completed').find('span').removeClass('fa fa-check').text(prevStp);
    //         }
    //       }
    //       else{
    //         //step incomplete
    //       }
    // })
</script>
<!-- 
https://maps.googleapis.com/maps/api/js?key=AIzaSyDIJ9XX2ZvRKCJcFRrl-lRanEtFUow4piM&libraries=places&callback=initMap 
-->
<!-- 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2OqsECQzseEMxXABMBA44js7X21MQPq8&libraries=places" -->
<!-- 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2OqsECQzseEMxXABMBA44js7X21MQPq8&libraries=places"
        async defer></script> 
-->
<script>
  // navigator.geolocation.getCurrentPosition(function(location) {
  //   // console.log(location.coords.latitude);
  //   // console.log(location.coords.longitude);
  //   // console.log(location.coords.accuracy);
  // });
  // function fillIn() {
  //   console.log(this.inputId);
  //   var place = this.getPlace();
  //   console.log(place. address_components[0].long_name);
  // }

  // $(function(){
  //   var inputs = document.getElementsByClassName('addressFields');

  //   var options = {
  //     types: ['geocode'],
  //     componentRestrictions: {country: 'fr'}
  //   };

  //   var autocompletes = [];

  //   for (var i = 0; i < inputs.length; i++) {
  //     var autocomplete = new google.maps.places.Autocomplete(inputs[i], options);
  //     autocomplete.inputId = inputs[i].id;
  //     autocomplete.addListener('place_changed', fillIn);
  //     autocompletes.push(autocomplete);
  //   }


  // });
</script>
<?php include_once'footer_dash.php'; ?>