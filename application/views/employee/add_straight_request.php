<!DOCTYPE html> 
<html>
<!-- Mirrored from  coderthemes.com/minton/dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:36:17 GMT -->

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
   
    <style>
        .card-box {
        padding: 50px;
      }

.heading1
{

    border: none;background: none; font-weight: 400;
color: #216078;
text-transform: capitalize;
font-size: 14px;
font-family: 'Raleway', sans-serif;
word-spacing: 1px;
letter-spacing: 0.5px;
}

      
    </style>
</head>

<body class="fixed-left">
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
    
    echo form_open('employee/'.$loc, array('id' => "my_form"));
    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";

        $merchant_name = $this->session->userdata('merchant_name');
    
    $names = substr($merchant_name, 0, 3);
      
    ?>
        
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- Page-Title -->
                      <div class="col-md-12">
                            <h2 class="m-b-20">Create Invoice For Straight </h2></div>
                    </div>
                    <div class="card-box">
                        <div class="row">
                            <div class="col-md-6">
                              
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Invoice no</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="invoice_no" id="invoice_no" pattern="[a-zA-Z\s]+"  
        value="INV<?php echo strtoupper($names) ?>000<?php echo  $getDashboardData[0]['TotalOrders']+1; ?>"  readonly required type="text">
                                        </div>
                                    </div>


   <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Reference</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Ex.P.O. Number" name="reverence" id="reverence"   placeholder="Reference:"
        value="<?php echo (isset($reverence) && !empty($reverence)) ? $reverence : set_value('reverence');?>" required type="text">
                                        </div>
                                    </div>

 <div class="form-group row date datetimepicker">
                                        <label class="control-label col-md-3">due date</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" name="due_date"     class="form-control" autocomplete="off" required placeholder="Due date" id="datepicker">
                                                
                                            </div>

                                                                                     <!-- input-group -->
                                        </div>
                                    </div>
                                 
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">title</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="title" id="title"  placeholder="Title:" 
        required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>" type="text">
                                        </div>
                                    </div>
                                   
                              
                            </div>
                            <div class="col-md-6">
                              
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+"  placeholder="Full Name:"
        value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required type="text">
                                        </div>
                                    </div>

  <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Phone</label>
                                        <div class="col-md-9">
                                            <input class="form-control" placeholder="Phone" name="mobile" id="phone" 
        value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required type="text">
                                        </div>

                                       
                                    </div>

                                   
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Email </label>
                                        <div class="col-md-9">
                                            <input class="form-control"  name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email "
        value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required type="text">
                                        </div>
                                    </div>
                                 


                               
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label">note</label>
                                    <div class="col-md-11 pad-l-60">
                                       <textarea class="form-control" style="height: auto"  rows="5" required name="note" ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-box">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="custon-label">Item name</label>
                                   <div class="input-group">
                    <span class="input-group-addon"><i class="fa  fa-meh-o"></i></span> 
                                        <input class="form-control item_name" name="Item_Name[]" placeholder="Item name" type="text" required="">
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="custon-label">quantity</label>
                                    <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
                                    <input class="form-control" placeholder="Quantity" name="Quantity[]" id="quantity_1" type="text" onKeyPress="return isNumberKey(event)" required>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="custon-label">Price</label>
                                    <div class="input-group" >
                    <span class="input-group-addon">
                       <i class="fa fa-usd"></i>
                    </span> 
                                        <input class="form-control item_price"  id="price_1"  name="Price[]" placeholder="Price" type="text" autocomplete="off" onKeyup="findTotal_pr();findTotal();" onblur="findTotal_pr();findTotal();" onKeyPress="return isNumberKeydc(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="custon-label">tax</label>
                                    <div class="icon-class">
                                       <?php
                  $merchant_id = $this->session->userdata('p_merchant_id');
                $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id,'status' => 'active')); ?>
                        <select name="Tax[]" class="form-control tax" id="tax_1" >
                                          <option rel="0" value="0" >No Tax</option>
                            <?php foreach ($data as $view) { ?>
                     <option rel="<?php echo $view['percentage']; ?>" value="<?php echo $view['id']; ?>"><?php echo $view['title']; ?>&nbsp;(<?php echo $view['percentage']; ?>%)</option>
                      <?php } ?>
                                        </select>
                                        <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                                          <input type="hidden" class="form-control price item_tax" id="tax_amount_1" placeholder="Tax Amount"  name="Tax_Amount[]" value="0">
                                            <input type="hidden" class="form-control" id="tax_per_1"   name="Tax_Per[]" value="0">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="custon-label">total</label>
                                   <div class="input-group">
                    <span class="input-group-addon">    <i class="fa fa-usd"></i></span> 
                                        <input class="form-control sub_total" placeholder="Total"  name="Total_Amount[]" id="total_amount_1" readonly type="text">
                                    </div>
                                </div>
                            </div>

                           

                            <div class="col-md-1">
                                <button type="button" id="Add_itom" class="btn btn-info waves-effect waves-light" style="margin-top:30px;"><i class="fa fa-plus"></i></button>

                            </div>
 
            


                                                    </div>

                                                     <div id="add_data"></div>

                        <div class="row rows">
                            <div class="col-md-7"></div>
                            <div class=" col-md-2 text-right">
                                <label class="custon-label">Sub Total</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                     <div class="input-group" >
                    <span class="input-group-addon">
                       <i class="fa fa-usd"></i>
                    </span> 
                                        <input class="form-control " placeholder="0.00" name="sub_amount" id="sub_amount" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row rows">
                            <div class="col-md-7"></div>
                            <div class=" col-md-2 text-right">
                                <label class="custon-label">Total Tax</label>
                            </div>
                            <div class=" col-md-2">
                                <div class="form-group ">
                                    <div class="input-group" >
                    <span class="input-group-addon">
                       <i class="fa fa-usd"></i>
                    </span> 
                              <input class="form-control total_tax" name="total_tax" id="total_tax" placeholder="0.00" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row rows">
                            <div class="col-md-7"></div>
                            <div class=" col-md-2 text-right">
                                <label class="custon-label">Total Amount</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                     <div class="input-group" >
                    <span class="input-group-addon">
                       <i class="fa fa-usd"></i>
                    </span> 
                                        <input class="amount form-control" name="amount" placeholder="0.00" id="amount"  type="text" readonly >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- end row -->






 
   <div class="row text-center">
                    <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light  btn-lg btn-lgs">Send Request</button>
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

     <script >
                                            
                                            $(function(){
  
  $("#phone").mask("(999) 999-9999");


  $("#phone").on("blur", function() {
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


 <script type="text/javascript">

function findTotal(){
    var arr = document.getElementsByClassName('item_price');
  var total_tax = document.getElementsByClassName('item_tax');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);

    }

     var total=0;
    for(var j=0;j<total_tax.length;j++){
        if(parseInt(total_tax[j].value))
            total += parseInt(total_tax[j].value);

    }

  
  var tot11 = parseFloat(tot);
     var tot2 = tot11.toFixed(2);

     var total1 = parseFloat(total);
     var total2 = total1.toFixed(2);
     
      var ful_total_amount =  parseFloat(tot) + parseFloat(total);
   
      //  var ful_total_amount =  parseFloat(tot) ;
    
  
 
   var tot3 = ful_total_amount.toFixed(2);
     
    document.getElementById('amount').value = tot3;
    document.getElementById('sub_amount').value = tot2;
     document.getElementById('total_tax').value = total2;
}


$(document).ready(function(){




$("#tax_1").change(onSelectChange);

function onSelectChange(){
    var output = "",
        $this = $(this);
    
  
        tax = $this.find('option:selected').attr('rel');
 
     var amount =  $('#price_1').val();
     
     var taxa = ($('#price_1').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_1').val(total_amount);
  $('#tax_amount_1').val(taxa);

 $('#tax_per_1').val(tax);

}





$('.tax').on('change', findTotal);

  });

function findTotal_pr(){
    var arr = document.getElementsByClassName('item_price');

    for(var i=0;i<arr.length;i++){

    var ida =  parseInt(arr[i].value);

  
  $('#price_1').on("keyup", function () {


     var testval = parseFloat($('#price_1').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_1').val((test2));
});

   $('#price_2').keyup(function() {

     var testval = parseFloat($('#price_2').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_2').val((test2));
});


   $('#price_3').keyup(function() {
    var testval = parseFloat($('#price_3').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_3').val((test2));
 });

   $('#price_4').keyup(function() {
     var testval = parseFloat($('#price_4').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_4').val((test2));
 });

   $('#price_5').keyup(function() {
    var testval = parseFloat($('#price_5').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_5').val((test2));
 });

   $('#price_6').keyup(function() {
    var testval = parseFloat($('#price_6').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_6').val((test2));
 });

  

   $('#price_7').keyup(function() {
    var testval = parseFloat($('#price_7').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_7').val((test2));
 });

   $('#price_8').keyup(function() {
    var testval = parseFloat($('#price_8').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_8').val((test2));
 });

    $('#price_9').keyup(function() {
    var testval = parseFloat($('#price_9').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_9').val((test2));
 });

   $('#price_10').keyup(function() {
     var testval = parseFloat($('#price_10').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_10').val((test2));
 });

 $('#price_11').keyup(function() {
    var testval = parseFloat($('#price_11').val());
     var test2 = testval.toFixed(2);
    $('#total_amount_11').val((test2));
 });

 }
}
</script>

     <script type="text/javascript">
        
  
  
    $(document).ready(function () {
  // Append Invoice Line
     var counter1 = 2;
        $("#Add_itom").on("click", function () {
             if (counter1 <= 10) {
          row = ' <div class="row"><div class="col-md-3"><div class="form-group"> <label class="custon-label">Item name</label>   <div class="input-group">                    <span class="input-group-addon"><i class="fa  fa-meh-o"></i></span> <input class="form-control item_name" name="Item_Name[]" placeholder="Item name" type="text" required="">    </div>  </div> </div> <div class="col-md-2"> <div class="form-group "><label class="custon-label">quantity</label>  <div class="input-group">                  <span class="input-group-addon"><i class="fa fa-plus-square"></i></span> <input class="form-control" placeholder="Quantity" name="Quantity[]" id="quantity_1" type="text" onKeyPress="return isNumberKey(event)" required> </div></div> </div><div class="col-md-2"> <div class="form-group "><label class="custon-label">Price</label> <div class="input-group" >                    <span class="input-group-addon">                       <i class="fa fa-usd"></i>                    </span>  <input class="form-control item_price" placeholder="Price"  name="Price[]" placeholder="Price" id="price_'+counter1+'" autocomplete="off"  type="text" onKeyup="findTotal();findTotal_pr();" onKeyPress="return isNumberKeydc(event)"> </div>                                </div>                            </div>                            <div class="col-md-2">                                <div class="form-group ">                                    <label class="custon-label">tax</label>                                    <div class="icon-class">                                         <?php
                  $merchant_id = $this->session->userdata("p_merchant_id");
                $data = $this->admin_model->data_get_where_1("tax", array("merchant_id" => $merchant_id,'status' => 'active')); ?>                        <select name="Tax[]" class="form-control tax" id="tax_'+counter1+'" >               <option rel="0" value="0" >No Tax</option>                            <?php foreach ($data as $view) { ?>                       <option rel="<?php echo $view['percentage']; ?>" value="<?php echo $view['id']; ?>"><?php echo $view['title']; ?>&nbsp;(<?php echo $view['percentage']; ?>%)</option>                    <?php } ?>                                        </select>                                <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>                  <input type="hidden" class="form-control price item_tax" placeholder="Tax Amount" id="tax_amount_'+counter1+'"  name="Tax_Amount[]" value="0">                     </div>                                </div>                            </div>                                                      <div class="col-md-2">                                <div class="form-group ">                   <label class="custon-label">total</label>                                     <div class="input-group" >                    <span class="input-group-addon">                       <i class="fa fa-usd"></i>                    </span>     <input class="form-control sub_total" placeholder="Total"  name="Total_Amount[]" id="total_amount_'+counter1+'" readonly type="text">   <input type="hidden" class="form-control" id="tax_per_'+counter1+'"   name="Tax_Per[]" value="0">                                  </div>                                </div>                            </div> <div class="col-md-1">                                <button type="button" id="Add_itom" class="removeItem btn btn-danger waves-effect waves-light removeItem" style="margin-top: 30px;"onClick="$(this).parent().parent().remove();findTotal();"><i class="fa fa-trash"></i></button>                         </div>   </div>';
          
            $("#add_data").append($(row));
           addRowAjax();
       }
            counter1++;
        });







          });
     
 
  function addRowAjax()
    {
       




$("#tax_2").change(onSelectChange2);

function onSelectChange2(){
    var output = "",
        $this = $(this);
    
   
        tax = $this.find('option:selected').attr('rel');
   

     var amount =  $('#price_2').val();
     
     var taxa = ($('#price_2').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_2').val(total_amount);
  $('#tax_amount_2').val(taxa);
   $('#tax_per_2').val(tax);


}

$("#tax_3").change(onSelectChange3);
function onSelectChange3(){
    var output = "",
        $this = $(this);
    
   
        tax = $this.find('option:selected').attr('rel');
  
     var amount =  $('#price_3').val();
     
     var taxa = ($('#price_3').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_3').val(total_amount);
  $('#tax_amount_3').val(taxa);
   $('#tax_per_3').val(tax);

}


$("#tax_4").change(onSelectChange4);
function onSelectChange4(){
    var output = "",
        $this = $(this);
    
        tax = $this.find('option:selected').attr('rel');

     var amount =  $('#price_4').val();
     
     var taxa = ($('#price_4').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_4').val(total_amount);
  $('#tax_amount_4').val(taxa);
   $('#tax_per_4').val(tax);
}


$("#tax_5").change(onSelectChange5);
function onSelectChange5(){
    var output = "",
        $this = $(this);
    
        tax = $this.find('option:selected').attr('rel');

     var amount =  $('#price_5').val();
     
     var taxa = ($('#price_5').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_5').val(total_amount);
  $('#tax_amount_5').val(taxa);
  $('#tax_per_5').val(tax);
}

$("#tax_6").change(onSelectChange6);
function onSelectChange6(){
    var output = "",
        $this = $(this);
    
        tax = $this.find('option:selected').attr('rel');

     var amount =  $('#price_6').val();
     
     var taxa = ($('#price_6').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_6').val(total_amount);
  $('#tax_amount_6').val(taxa);
   $('#tax_per_6').val(tax);

}

$("#tax_7").change(onSelectChange7);
function onSelectChange7(){
    var output = "",
        $this = $(this);
    
        tax = $this.find('option:selected').attr('rel');

     var amount =  $('#price_7').val();
     
     var taxa = ($('#price_7').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_7').val(total_amount);
  $('#tax_amount_7').val(taxa);
   $('#tax_per_7').val(taxa);

}


$("#tax_8").change(onSelectChange8);
function onSelectChange8(){
    var output = "",
        $this = $(this);
    
        tax = $this.find('option:selected').attr('rel');

     var amount =  $('#price_8').val();
     
     var taxa = ($('#price_8').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_8').val(total_amount);
  $('#tax_amount_8').val(taxa);
   $('#tax_per_8').val(taxa);

}


$("#tax_9").change(onSelectChange9);
function onSelectChange9(){
    var output = "",
        $this = $(this);
    
        tax = $this.find('option:selected').attr('rel');

     var amount =  $('#price_9').val();
     
     var taxa = ($('#price_9').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_9').val(total_amount);
  $('#tax_amount_9').val(taxa);
   $('#tax_per_9').val(taxa);

}


$("#tax_10").change(onSelectChange10);
function onSelectChange10(){
    var output = "",
        $this = $(this);
    
        tax = $this.find('option:selected').attr('rel');

     var amount =  $('#price_10').val();
     
     var taxa = ($('#price_10').val() / 100 * tax);
     
      var total_amount =  parseInt(taxa) + parseInt(amount);

  $('#total_amount_10').val(total_amount);
  $('#tax_amount_10').val(taxa);
   $('#tax_per_10').val(taxa);

}






$('.tax').on('change', findTotal);

$('.item_price').on('change', findTotal);

         }

  
 


      </script>



    </body>

</html>