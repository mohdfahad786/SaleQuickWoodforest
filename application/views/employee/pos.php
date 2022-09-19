<!DOCTYPE html>
<html>
<!-- Mirrored from coderthemes.com/minton/dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:36:17 GMT -->

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
<meta name="author" content="Coderthemes">
<link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
<title>Employee | Dashboard</title>
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
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>

</head>
<style>
.card-box {
  /*padding: 50px; */
  background-color:transparent !important;
  padding: 0px; 
}


.card-boxP2{ background-color:#fff; padding: 45px;}
.noBorder {
  border: none;
}
.price {
  text-align: center;
  cursor: pointer;
  font-weight: bold;
  font-size: 1.5em;
}
.p2 {
  height: 150px !important;
  border-radius: 0px !important;
}
.btn2h2 {
  border: 1px solid #D7E4EA;
  background-color: #fff;
  height: 300px;
  border-radius: 0px !important;
}
.btn2h3 {
  border: 1px solid #D7E4EA;
  background-color: #fff;
  height: 300px;
  border-radius: 0px !important;
}
.nopadding {
  padding: 0 !important;
}
.m2 {
  margin-bottom: 0 !important;
}

.h4h{    
   margin-top: 20px !important;
    width: 100%;
}

.col-xs-4{ 
  -ms-flex: 0 0 33.333333% !important;
    flex: 0 0 33.333333% !important;
    max-width: 33.333333% !important;}
  
.col-xs-3{
     -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;}
  
.col-xs-9{ 
  -ms-flex: 0 0 75%;
    flex: 0 0 75%;
    max-width: 75%;}
  
  .col-xs-8{    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;}
  
  .RightBox{ 
    background-color:#eee !important;     
    margin-top: 0px; padding:40px 20px 90px 20px;}

</style>
</head><body class="fixed-left">
<!-- Begin page -->
<div id="wrapper"> 
  <!-- Top Bar Start -->
  <?php $this->load->view('employee/top'); ?>
  <!-- Top Bar End --> 
  <!-- ========== Left Sidebar Start ========== -->
  <?php $this->load->view('employee/menu'); ?>
  <!-- Left Sidebar End --> 
  <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
  <?php
    if(isset($msg))
    echo "<h4> $msg</h4>";
    
     echo form_open('pos_employee/'.$loc, array('id' => "my_form", "onsubmit"=>"return validateForm()" ));
    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";

       
      
    ?>
  <div class="content-page"> 
    <!-- Start content -->
    <div class="content">
      <div class="container-fluid"> 
        <!-- Page-Title -->
        <div class="col-md-12">
          <h2 class="m-b-20"> <?php echo ($meta)?> </h2>
        </div>
      </div>
      <div class="card-box card-boxP">
        <div class="row">
          <div class="col-md-8 ">
          
          <div class="card-boxP2">
            <div class="form-group row">
              <div class="col-md-12" id="mainDiv">
                <div class="input-group" > <span class="input-group-addon"><i class="fa fa-usd"></i></span> 
                  
                 
                  
                  <input type="text" class="form-control" name="t_amount" id="t_amount"   onKeyPress="return isNumberKey(event)"     placeholder="0.00" autocomplete="off"  >
                </div>
              </div>
            </div>
            <div class=" row">
              <div class=" col-sm-9 col-xs-9 nopadding">
                <div class="form-group row m2">
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="one" id="one" onclick="myFunction(this)" readonly value="1"  >
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="two" id="two" onclick="myFunction(this)" readonly  value="2"  >
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="three" id="three" onclick="myFunction(this)" readonly value="3"  >
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group row m2">
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="four" id="four" onclick="myFunction(this)" readonly value="4"  >
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="five" id="five" onclick="myFunction(this)" readonly value="5"  >
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="six" id="six" onclick="myFunction(this)" readonly value="6"  >
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group row m2">
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="seven"  onclick="myFunction(this)" id="seven" readonly value="7"  >
                  </div>
                  <div class="col-md-4 col-sm-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="eight" onclick="myFunction(this)" id="eight" readonly value="8"  >
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="nine" onclick="myFunction(this)" id="nine" readonly value="9"  >
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group row m2">
                  <div class="col-md-8 col-sm-8 col-xs-8 nopadding">
                    <input type="button" class="form-control price p2" name="zero1" id="zero1" onclick="myFunction(this)" readonly value="00"  >
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 nopadding">
                    <input type="button" class="form-control price p2" name="zero" id="zero" onclick="myFunction(this)" readonly value="0"  >
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-3 nopadding">
                <div class=" col-md-12 col-sm-12 col-xs-12 nopadding">
                  <button type="button" class="btn btn-lg btn btn2h2 col-md-12 col-sm-12 col-xs-12" id="del"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </button>
                </div>
                <div class=" col-md-12 col-sm-12 col-xs-12 nopadding">
                  <button type="button" class="btn btn-lg btn btn2h3 col-md-12 col-sm-12 col-xs-12" id="add"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </button>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          </div>
          <div class="col-md-4">
          <div class="RightBox">
          
            <h3 class="col-md-12">Current Sale</h3>
            <div class="form-group ">
              <label class="col-md-3 col-form-label">Amount</label>
              <div class="col-md-9">
                <div class="input-group" > <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                  <input type="text" class="sub_amount form-control " name="sub_amount" id="sub_amount" readonly  placeholder="0.00">
                </div>
              </div>
            </div>
            <div id="amount-add"> </div>
            <div class="form-group ">
              <label class="col-md-3 col-form-label">Tax</label>
              <div class="col-md-9">
                <div class="input-group" > <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                  <input type="text" class="form-control" name="totaltax" id="totaltax" value="0.00" readonly>
                </div>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-md-3 col-form-label">Tax</label>
              <div class="col-md-9">
                <div class="input-group icon-class" > <span class="input-group-addon"><i class="fa fa-angle-down"></i></span>
                  <select name="tax" class="form-control tax" id="tax"  >
                    <option value="<?php if($getDashboardData[0]['TotalTax']!=''){echo $getDashboardData[0]['TotalTax']; }  else { echo '0';} ?>">Tax Apply</option>
                    <option value="0" >No Tax</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-md-3 col-form-label">Total</label>
              <div class="col-md-9">
                <div class="input-group" > <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                  <input type="text" class="form-control" name="amount" id="amount" placeholder="0.00"  readonly  required>
                </div>
              </div>
            </div>
            
            
            <div class="form-group row">
          <div class="clearfix"></div>
          <div class="h4h"></div>
           <div class="clearfix"></div>
            <div class="col-md-12">
              <button type="reset" onclick="window.location.reload();" class="btn btn-primary waves-effect waves-light btn-lg col-md-9 col-sm-9 col-xs-9 ">Reset</button>
            </div>
            <div class="clearfix"></div>
             <div class="h4h"></div>
              <div class="clearfix"></div>
            <div class="col-md-12" style="">
              <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light btn-lg col-md-9 col-sm-9 col-xs-9">Charge</button>
            </div>
          </div>
            </div><!--RightBox-->
          </div>
          
          <div class="clearfix"></div>
        </div>
        
      </div>
      
      <!-- end row --> 
      <!--end row/ WEATHER --> 
      <!-- end row --> 
    </div>
    <!-- end container --> 
  </div>
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
function validateForm() {
    var x = document.forms["my_form"]["amount"].value;
    if (x == "") {
        alert("Amount must be filled out");
        return false;
    }
}
</script> 
<script>
  var input = ""; //holds current input as a string
      $(function(){
    $("#parsed").click(function(){
        $("#number").focus();            
    });        
    $("#number").keyup(function(e){
        var number = $("#number").val();
        var newValue = (Math.round(parseFloat(number)*100)/100)/100;
        $("#parsed").html(newValue);
    });
});

       $(function() {
    
   
    
     $("#t_amount").keydown(function(e) {     
         //handle backspace key
         if(e.keyCode == 8 && input.length > 0) {
             input = input.slice(0,input.length-1); //remove last digit
             $(this).val(formatNumber(input));
         }
         else {
             var key = getKeyValue(e.keyCode);
             if(key) {
                 input += key; //add actual digit to the input string
                 $(this).val(formatNumber(input)); //format input string and set the input box value to it
             }
         }
     inputvalue=input;
         return false;
     });


    
     function getKeyValue(keyCode) {
         if(keyCode > 57) { //also check for numpad keys
             keyCode -= 48;
         }
         if(keyCode >= 48 && keyCode <= 57) {
             return String.fromCharCode(keyCode);
         }
     }
    
     function formatNumber(input) {
         if(isNaN(parseFloat(input))) {
             return "0.00"; //if the input is invalid just set the value to 0.00
         }
         var num = parseFloat(input);
         return (num / 100).toFixed(2); //move the decimal up to places return a X.00 format
     }
    
    });
    
  function formatNumberg(input) {
         if(isNaN(parseFloat(input))) {
             return "0.00"; //if the input is invalid just set the value to 0.00
         }
         var num = parseFloat(input);
         return (num / 100).toFixed(2); //move the decimal up to places return a X.00 format
     }
 $("#add").click(function () {

   

 $("#sub_amount,#sub_amount_1,#sub_amount_2,#sub_amount_3,#sub_amount_4,#sub_amount_5,#sub_amount_6,#sub_amount_7,#sub_amount_8,#sub_amount_9,#sub_amount_10").removeClass("sub_amount");
 });

var inputvalue='';
function myFunction(button) {



    var x = button.value;
   
    var y = button.value;
  var doc=document.getElementById("t_amount").value;
  doc+=x;
  inputvalue+=x
  input=inputvalue;
    document.getElementById("t_amount").value = formatNumberg(inputvalue);
    


  var z = document.getElementsByClassName("sub_amount");
    z[0].value = formatNumberg(inputvalue);




}




  $(document).ready(function () {

//     var el = document.getElementById("t_amount");
// el.value = parseFloat(el.value.toFixed(2));

//        document.getElementById('t_amount').addEventListener('click', force2decimals);

// function force2decimals(event) {
//     event.target.value = parseFloat(event.target.value).toFixed(2);
// }




     var counter = 1;
         $("#add").click(function () {
          
          var primaryincome1 = parseFloat($("#t_amount").val());

         

                $("#amount-add").append("<div class='form-group'><label class='col-md-3 col-form-label'>Amount</label> <div class='col-md-9'><div class='input-group'>  <span class='input-group-addon'><i class='fa fa-usd'></i></span> <input type='text' class='sub_amount form-control' name='sub_amount_"+counter+"' id='sub_amount_"+counter+"' readonly placeholder='0.00'  > </div>  </div></div>");

               
         counter++; 
       

        });




          });
    



$("#t_amount").keyup(function () {

 var primaryincome1 = $("#t_amount").val();

 $(".sub_amount").val(primaryincome1);

});



$("#add").click(function () {

    var primaryincome1 = $("#t_amount").val();
    var otherincome = $("#amount").val()|| 0;
     var totaltax1 = $("#totaltax").val();

      var tax1 = $("#tax").val();

 //$("#sub_amount").removeClass("sub_amount");

    // var primaryincome = ($('#t_amount').val(), 10);
    //var otherincome = ($('#amount').val(), 10);
    if(primaryincome1!='')
    {
      primaryincome = primaryincome1;
    }
    else
    {
     primaryincome = '0';
    }


   var tax =  parseFloat(tax1) * parseFloat(primaryincome) /100;
    var total = parseFloat(primaryincome) + parseFloat(tax);

    var totalincome = parseFloat(total) + parseFloat(otherincome);
    var totaltax = parseFloat(tax) + parseFloat(totaltax1);

   //  var primaryincome2 = parseFloat(primaryincome);
   
    $("#amount").val(totalincome.toFixed(2));

      $("#totaltax").val(totaltax.toFixed(2));
   // $("#mainDiv").val('0.00');
    $("#t_amount").val('');
   //  $("#sub_amount").val('');
    //$(".sub_amount").val(primaryincome2.toFixed(2));
  inputvalue='';
  input='';
 
     
});


$("#del").click(function () {
   
          inputvalue = inputvalue.slice(0,inputvalue.length-1); //remove last digit
             input=inputvalue;

    var str = $('#t_amount').val();
$('#t_amount').val(formatNumberg(inputvalue));

$('.sub_amount').val(formatNumberg(inputvalue));


});






  </script> 
<script>
            var resizefunc = [];
        </script> 

<!-- Plugins  --> 

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
<script>


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

       function isNumberKeydc(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
      
    </script>
</body>
</html>