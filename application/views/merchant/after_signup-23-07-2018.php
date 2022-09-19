<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
<meta name="author" content="Coderthemes">
<link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
<title>Merchant | Dashboard</title>
<link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" />
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
<style>
.card-box {
	padding: 50px;
}
.noBorder {
	border: none;
}

.form-control{ margin-bottom:10px;text-transform:unset;}
.col-centered{ clear:both !important; float:none !important; margin:80px auto 0 auto;}

</style>
</head>

<body class="fixed-left">

<!-- Begin page -->

<div id="wrapper">

<!-- Top Bar Start -->

<?php $this->load->view('merchant/top'); ?>

<!-- Top Bar End --> 

<!-- ========== Left Sidebar Start ========== -->

<?php $this->load->view('merchant/menu'); ?>

<!-- Left Sidebar End --> 

<!-- ============================================================== --> 

<!-- Start right Content here --> 

<!-- ============================================================== -->

<?php

    if(isset($msg))

    echo "<h4> $msg</h4>";

    

    echo form_open('merchant/after_signup', array('id' => "my_form"));

    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";

    ?>

  <div class="content-page1"> 
    
    <!-- Start content -->
    
    <div class="content1">
      <div class="container-fluid">
        <div style="color:red;"><?php echo validation_errors(); ?></div>
        
        <!-- Page-Title -->
        
        <?php /*?><div class="col-md-12">
          <h2 class="m-b-20"> <?php echo ($meta)?> </h2>
        </div><?php */?>
      </div>
      <div class="card-box">
        <div class="row">
          <div class="col-md-5 col-sm-7 col-centered" >
            <h3>Activate your SaleQuick account:</h3>
            <div class=" clearfix"></div>
            <p>In order for your business to begin processing, we need to learn a little more about what you do. All the information you provide will only be visible to the account owner and the administrators of SaleQuick. </p>
            <h3>Tell us about the product or service you provide ?</h3>
            <div class="form-group ">
              <label >Business Service</label>
              <select name="business_service" required="required" class="form-control">
                <option>--Select--</option>
                <option <?php echo $mearchent["business_service"]=="Auto Repair Center"?'selected="selected"':""?>>Auto Repair Center</option>
                <option <?php echo $mearchent["business_service"]=="Auto Dealer"?'selected="selected"':""?>>Auto Dealer</option>
                <option <?php echo $mearchent["business_service"]=="Auto Body Shop"?'selected="selected"':""?>>Auto Body Shop</option>
                <option <?php echo $mearchent["business_service"]=="Glass Shop"?'selected="selected"':""?>>Glass Shop</option>
                 <option <?php echo $mearchent["business_service"]=="Auto Detail Shop"?'selected="selected"':""?>>Auto Detail Shop</option>                
              </select>
            <!--  <p>If you don't see your country. let us know you'e interested.</p> -->
            </div>
            
            <br/>
           
            <div class="form-group ">
              <label><strong>Business website</strong> </label>
              <input class="form-control" required="required" value="<?php echo $mearchent["website"]?>"  pattern="https://.*" size="20" type="url" name="website" placeholder="http://company.com">
              <div class=" clearfix"></div>
            </div>
             <div class="form-group ">
              <label><strong>Business Phone Number</strong> </label>
              <input class="form-control" type="text" value="<?php echo $mearchent["business_number"]?>"  required="required" id="business_number" name="business_number" onKeyPress="return isNumberKey(event)" placeholder="Business Phone Number">
              <div class=" clearfix"></div>
            </div>
             <div class="form-group ">
              <label><strong>Years in Business</strong> </label>
              <input class="form-control" type="text" required="required" value="<?php echo $mearchent["year_business"]?>"  name="year_business" onKeyPress="return isNumberKey(event)" placeholder="">
              <div class=" clearfix"></div>
            </div>
            <br/>
            <h3>Give us a short description about your business (optional).</h3>
            <div class="form-group ">
              <label><strong>Estimated monthly processing volume:</strong></label>
              <select class="form-control" name="monthly_processing_volume">
                <option <?php echo $mearchent["monthly_processing_volume"]=="Less than $10,000"?'selected="selected"':""?>>Less than $10,000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$20,000"?'selected="selected"':""?>>$20,000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$30,000"?'selected="selected"':""?>>$30,000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$40,00"?'selected="selected"':""?>>$40,000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$50,000"?'selected="selected"':""?>>$50,000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$60,0000"?'selected="selected"':""?>>$60,0000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$70,000"?'selected="selected"':""?>>$70,000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$80,000"?'selected="selected"':""?>>$80,000</option>
                <option <?php echo $mearchent["monthly_processing_volume"]=="$90,000"?'selected="selected"':""?>>$90,000</option>
                 <option <?php echo $mearchent["monthly_processing_volume"]=="$100,000+"?'selected="selected"':""?>>$100,000+</option>
              </select>
            </div>
            <br/>
            <h3>Business Details</h3>
            <div class="form-group ">
              <label><strong>Legal Name of business</strong></label>
              <input  class="form-control" value="<?php echo $mearchent["business_name"]?>" type="text" required="required" name="business_name" placeholder="Business Legal Name">              
            </div>
            
            <div class="form-group ">
              <label ><strong> DBA Name</strong> </label>
              
                <input class="form-control" type="text" value="<?php echo $mearchent["business_dba_name"]?>" required="required" name="business_dba_name" placeholder="DBA Name">    
              
            </div>
            <div class="form-group ">
              <label ><strong>Type of Business</strong> </label>
              
              <select class="form-control" name="business_type">
                <option>--Select--</option>
                <option <?php echo $mearchent["business_type"]=="Sole Proprietorship"?'selected="selected"':""?>>Sole Proprietorship</option>
                <option <?php echo $mearchent["business_type"]=="Partnership"?'selected="selected"':""?>>Partnership</option>
                <option <?php echo $mearchent["business_type"]=="Corporation"?'selected="selected"':""?>>Corporation</option>
                <option <?php echo $mearchent["business_type"]=="Limited Liability Company (LLC)"?'selected="selected"':""?>>Limited Liability Company (LLC)</option>               
              </select>
              
            </div>
            <div class="form-group ">
              <label ><strong>Employer Identification Number (EIN)</strong> </label>
              
                <input class="form-control" value="<?php echo $mearchent["ien_no"]?>" type="text" name="ien_no" placeholder="EIN">    
              
            </div>
            <div class="form-group ">
              <label ><strong>Business Address</strong> </label>
                <textarea style="height:80px;"  rows="5" class="form-control" value=""  name="address1" placeholder="Business Address"><?php echo $mearchent["address1"]?></textarea>
                
              
            </div>
            <br/>
            <h3>Business Owner Information:</h3>
            <p>The individual who’s interest in the company consists of 51% majority ownership in the company listed above.</p>
            <div class="form-group ">
              <label ><br/> </label>
              
                <input class="form-control" type="text" value="<?php echo $mearchent["o_name"]?>" name="o_name" placeholder="First Name">
              
                <input class="form-control" type="text" value="" name="o_last_name" placeholder="Last Name">
                <input class="form-control" type="date" value="<?php echo $mearchent["o_dob"]?>" name="o_dob" placeholder="Date of Brith">
                <input class="form-control" type="text" value="**-**-****" id="o_ss_number1" name="o_ss_number1" placeholder="**-**-****">
                 <input class="form-control" type="hidden" value="<?php echo $mearchent["o_ss_number"]?>" id="o_ss_number" name="o_ss_number"  onKeyPress="return isNumberKey(event)" placeholder="Social Security Number">
                <input class="form-control" type="text" value="<?php echo $mearchent["percentage_of_ownership"]?>" name="percentage_of_ownership" placeholder="Percentage of ownership">
                <input class="form-control" type="text" value="<?php echo $mearchent["o_address"]?>" name="o_address" placeholder="Home Address">
              
            </div>           
            
            <br/>
            <h3>Credit card statement details</h3>
<p>What would you like your customers to see on their credit card statement? We recommend the name they know you by, such as you DBA name. Ex: Joe’s Auto Repair. </p>


		<div class="form-group ">
              <label><strong>Business name </strong></label>
              <input class="form-control" value="<?php echo $mearchent["cc_business_name"]?>" name="cc_business_name" type="text" placeholder="Your company name">
              <p>Use the name for your business that your customers will recongnize to help prevent unintended chargebacks.</p>
            </div>
            
            
            
            
            
            <br/>
            <h3>Bank details</h3>
<p>Please provide us with the bank account where you would like your processing funds deposited to. Make sure all bank information is accurate and correct to prevent any delays in funding.</p>
            
            <div class="form-group ">
              <label><strong>Routing number</strong> </label>
              <input class="form-control" type="text" value="<?php echo $mearchent["bank_routing"]?>" name="bank_routing" placeholder="Routing number">
              
            </div>
            
            
            <div class="form-group ">
              <label><strong>Account number</strong> </label>
              <input class="form-control" id="bank_account" value="<?php echo $mearchent["bank_account"]?>" onblur="comparevalue();" name="bank_account" type="password" placeholder="Account number">
              
            </div>
            
            <div class="form-group ">
              <label><strong>Confirm account number</strong> </label>
              <input class="form-control" onblur="comparevalue();" value="<?php echo $mearchent["bank_account"]?>" id="bank_account_confirm"  name="bank_account_confirm" type="password" placeholder="Confirm account number">
              
            </div>
            <div class="form-group ">
              <label><strong>Bank Name</strong> </label>
              <input class="form-control" id="" name="bank_name" value="<?php echo $mearchent["bank_name"]?>" type="text" placeholder="Bank Name">
              
            </div>
            <div class="form-group ">
              <label><strong>Funding Time</strong> </label>
              <input class="form-control" id="" name="funding_time" value="<?php echo $mearchent["funding_time"]?>" type="text" placeholder="Funding Time">
              
            </div>

            
            
            
            <!--
             <div class="col-4" style="float:left;"><input type="submit" id="btn_login" name="submit"  class="btn btn-primary btn-md pull-right" value="Save for later " /></div>
             !-->
             <div class="col-4" style="float:left;">
            <input type="submit" id="btn_login" name="submit"  class="btn btn-primary btn-md pull-right" value="Submit application " /></div>
            
            <div class=" clearfix"></div>
            
            <p>By submitting this information you agree to our service agreement, and that all information you have provided is accurate and complete.</p>
            
          </div>
        </div>
      
        
      </div>
    </div>
    
    <!-- end row --> 
    
    <!--end row/ WEATHER --> 
    
    <!-- end row --> 
    
  </div>
  
  <!-- end container -->
  
  </div>
</form>
<?php echo form_close(); ?> 

<!-- end content -->

</div>

<!-- ============================================================== --> 

<!-- End Right content here --> 

<!-- ============================================================== --> 

<!-- Right Sidebar --> 

<!-- /Right-bar -->

</div>

<!-- END wrapper --> 

<script>

            var resizefunc = [];

        </script> 

<!-- Plugins  --> 

<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script><!-- Popper for Bootstrap --> 

<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.blockUI.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/js/jquery.multi-select.js"></script> 
<script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/jquery-quicksearch/jquery.quicksearch.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> 

<!-- Custom main Js --> 

<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/masking.js"></script>
<script>





function isNumberKey(evt){

    var charCode = (evt.which) ? evt.which : event.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;

    return true;

}

function converttostar(evt){

    var charCode = (evt.which) ? evt.which : event.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;

    return true;

}

function comparevalue(){
  if($("#bank_account").val()!="" && $("#bank_account_confirm").val()!=""){
      if($("#bank_account").val()!=$("#bank_account_confirm").val()){
        alert("Account Number not match");
        $("#bank_account").focus();
      }
  }
}



       function isNumberKeydc(evt)

       {

          var charCode = (evt.which) ? evt.which : evt.keyCode;

          if (charCode != 46 && charCode > 31 

            && (charCode < 48 || charCode > 57))

             return false;



          return true;

       }

       $(function(){

  

  $("#business_number").mask("(999) 999-9999");

  $("#o_ss_number1").mask("99-99-9999");


  $("#o_ss_number1").on("blur", function() {
       var o_ss_number1=$('#o_ss_number1').val();
       $("#o_ss_number").val(o_ss_number1);      


        $("#o_ss_number1").val('**-**-****');


      
  });


  $("#business_number").on("blur", function() {

      var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );



      if( last.length == 5 ) {

          var move = $(this).val().substr( $(this).val().indexOf("-") + 1, 1 );



          var lastfour = last.substr(1,4);



          var first = $(this).val().substr( 0, 9 );



          $(this).val( first + move + '-' + lastfour );

      }

  });

}); 

      

    </script>
</body>
</html>