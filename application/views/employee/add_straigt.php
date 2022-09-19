<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8">
<title>Merchant | Dashboard</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.2 -->
<?php
    $this->load->view('merchant/header');
    ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <?php
    $this->load->view('merchant/menu');
    ?>
  <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <div class="box box-solid box-success">
        <div class="box-header">
          <h3 class="box-title"> <?php echo ($meta)?></h3>
        </div><!-- /.box-header -->
        <div class="box-body">
       
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <section class="col-lg-12 connectedSortable">
        <div class="box box-info">
          <?php
    if(isset($msg))
    echo "<h4> $msg</h4>";
    
    echo form_open('merchant/'.$loc, array('id' => "my_form"));
    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
    ?>
          <form>
            <div class="box-body">

               <div class="form-group col-md-4">
                <label for="name">Invoice No</label>
                <?php
        $merchant_name = $this->session->userdata('merchant_name');
    
    $names = substr($merchant_name, 0, 3);
        ?>
          <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-italic"></span>
                    </span>
                <input type="text" class="form-control" name="invoice_no" id="invoice_no" pattern="[a-zA-Z\s]+"  
        value="INV<?php echo strtoupper($names) ?>000<?php echo  $getDashboardData[0]['TotalOrders']+1; ?>"  readonly required>
               </div>
            </div>

               <div class="form-group col-md-4">
                <label for="name">Reference</label>
                  <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-registration-mark"></span>
                    </span>
                <input type="text" class="form-control" name="reverence" id="reverence" pattern="[a-zA-Z\s]+"  placeholder="Reference:"
        value="<?php echo (isset($reverence) && !empty($reverence)) ? $reverence : set_value('reverence');?>" required>
              </div> 
            </div>
            <div class="form-group col-md-4">
                <label for="name">Due  Date</label>
            
  <?php if($loc=='edit_straight_request')  {?> 

              <div class="input-group date datetimepicker" style="z-index:999">
                  <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        <input type="text"  name="due_date"     class="form-control" autocomplete="off"  value="<?php echo (isset($due_date) && !empty($due_date)) ? $due_date :  set_value('due_date');?>" required>
                       
                  
                    </div>

                          <?php } elseif($loc=='add_straight_request')  {?> 


                                  <div class="input-group date datetimepicker" style="z-index:999">
                                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        <input type="text"  name="due_date"     class="form-control" autocomplete="off" required>
                     
                    
                    </div>


                 <?php } ?>


              </div>
      
       <div class="form-group col-md-4">

                <label for="name">Name</label>
                 <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                    </span>
                <input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+"  placeholder="Full Name:"
        value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required>
            </div>   
            </div>

<div class="form-group col-md-4">
                <label for="name">Mobile No </label>
                  <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-phone-alt"></span>
                    </span>
                <input type="text" class="form-control" name="mobile" id="mobile" pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :"
        value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>
              </div> 
            </div>

 <div class="form-group col-md-4">
                <label for="name">Email Id </label>
  <div class="input-group" >
     <span class="input-group-addon" >
                        <span class="glyphicon glyphicon-envelope"></span>
                    </span>
                <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email Id:"
        value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
       
                  </div>
               
            </div>

 

              
                

                <div class="form-group col-md-6">
                <label for="name">Title</label>
                  <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-folder-close"></span>
                    </span>
                <input type="text" class="form-control" name="title" id="title"  placeholder="Title:" 
        required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
              </div>
               </div> 
               <div class="form-group col-md-6">
                <label for="name">Remark</label>
                  <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-folder-open"></span>
                    </span>
                <input type="text" class="form-control" name="remark" id="remark"  placeholder="Remark:" 
        required value="<?php echo (isset($remark) && !empty($remark)) ? $remark : set_value('remark');?>">
              </div>
            </div>

               <div class="form-group col-md-12">
                <label for="name">Note</label>
               

        <textarea class="form-control" rows="2" id="comment" required name="note"> <?php echo (isset($note) && !empty($note)) ? $note : set_value('note');?></textarea>
              </div>
        

 






<div class="col-lg-12">
        <table id="addaccount" class="table table-striped">
          <thead>
            <tr>
             <th class="col-md-3">Item Name</th>
                      <th class="col-md-2">Quantity</th>
                      <th class="col-md-2">Price</th>
              <th class="col-md-2">Tax Rate</th>
           
              <th class="col-md-2">Total</th>
              <th class="col-md-2"></th>
            </tr>
          </thead>
          <tbody>
            <tr>

                <td><div class="col-sm-6 col-lg-12">
                       <div class="input-group">
                    <span class="input-group-addon"><i class="fa  fa-meh-o"></i></span> 
                        <input type="text" class="form-control" name="Item_Name[]" placeholder="Name"   required>
                      </div>
                    </div>
                      </td>
                      <td>
                        <div class="col-sm-6 col-lg-12">
                         <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-plus-square"></i></span> 
                        <input type="text" class="form-control" name="Quantity[]" id="quantity_1" placeholder="Quantity" onKeyPress="return isNumberKey(event)" required >
                     </div>
                     </div>
                      </td>

             
                 <td><div class="col-sm-6 col-lg-12">
                   <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </span> 
                  <input type="text" class="form-control item_price" placeholder="Price"  name="Price[]"  onKeyup="findTotal_pr();" onblur="findTotal_pr();" onKeyPress="return isNumberKeydc(event)" id="price_1" required>
                </div>
              </div></td>
                <td><div class="col-sm-6 col-lg-12">

                <?php
                  $merchant_id = $this->session->userdata('merchant_id');
                $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id)); ?>
                        <select name="Tax[]" class="form-control tax" id="tax_1" >
                        <option value="0" >No Tax</option>
                            <?php foreach ($data as $view) { ?>
                      <option value="<?php echo $view['percentage']; ?>"><?php echo $view['title']; ?>&nbsp;(<?php echo $view['percentage']; ?>%)</option>
                      <?php } ?>
                        </select>

                </div></td>
               
         
                 
                 <td>
 <input type="hidden" class="form-control price item_tax" placeholder="Tax Amount"  name="item_tax">
               
                  <div class="col-sm-6 col-lg-12">
                   <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </span> 
                  <input type="Client Name" class="form-control price sub_total" placeholder="Total"  name="Total_Amount[]" id="total_amount_1" readonly>
                </div>
                </div></td>
              <td><button type="button" id="addnewitem"  class="btn btn-md btn-success" value="+"><span class="glyphicon glyphicon-plus-sign">&nbsp;</span> </button></td>
            </tr>
          </tbody>
          <tr class="form-group" >
            <td colspan="3" align="right"><strong>Sub Total</strong></td>
            <td colspan="2"><div class="form-group">
               <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </span> 
          <input class="subtcollected form-control " name="sub_amount" type="text" value=""  readonly >
        </div></div>
            </td>
            <td></td>
          </tr>
          <tr class="form-group" >
            <td colspan="3" align="right"><strong>Total Tax</strong></td>
            <td colspan="2"><div class="form-group">
               <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </span> 
  <input class="subtaxcollected form-control " name="total_tax" type="text" value="0" readonly >
</div></div>
            </td>
            <td></td>
          </tr>
          <tr class="form-group" >
            <td colspan="3" align="right"><strong>Total Amount</strong></td>
            <td colspan="2">
              <div class="form-group">
               <div class="input-group" >
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </span> 
              <input class="sumamtcollected form-control" name="amount" type="text" value="" readonly >
            </div></div></td>
            <td></td>
          </tr>
        </table>
      </div>









<div class="box-footer clearfix">
              <input type="submit" id="btn_login" name="submit"  class="btn btn-lg btn-primary" value="<?php echo $action ?>" />
            </div>
          </form>
          <?php echo form_close(); ?> </div>
      </section>
      
    </div>
  </section>
   </div><!-- /.box-body -->
      </div>
  <!-- /.content -->
</div>

             <script src="<?php echo base_url("assets/plugins/daterangepicker/moment.js"); ?>" type="text/javascript"></script>
   <script src="<?php echo base_url("assets/plugins/daterangepicker/bootstrap-datetimepicker.min.js"); ?>" type="text/javascript"> </script>
  
<script type="text/javascript">
    $(function () {
        $('.datetimepicker').datetimepicker({
            locale: 'en',
            format: 'YYYY-MM-DD ',
            useCurrent: true,
            sideBySide: true,
            showTodayButton: true
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
        
  
    $(function () {
  // Append Invoice Line
    var counter1 = 2
    $(document).on('click', '#addnewitem', function () {
      var currentTable = $(this).closest('table').attr('id');
       $('#' + currentTable ).append('<tr><td><div class="col-sm-6 col-lg-12"><div class="input-group"><span class="input-group-addon"><i class="fa  fa-meh-o"></i></span> <input type="text" class="form-control" name="Item_Name[]" placeholder="Name"   required> </div> </div> </td> <td><div class="col-sm-6 col-lg-12"> <div class="input-group"><span class="input-group-addon"><i class="fa fa-plus-square"></i></span><input type="text" class="form-control" name="Quantity[]" id="quantity_1" placeholder="Quantity" onKeyPress="return isNumberKey(event)" required ></div></div></td><td><div class="col-sm-6 col-lg-12"><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span><input type="text" class="form-control item_price" placeholder="Price" name="Price[]" id="price_'+counter1+'"  onblur="findTotal_pr()" onKeyup="findTotal_pr();" onKeyPress="return isNumberKeydc(event)"></div></div></td><td><div class="col-sm-6 col-lg-12"><select name="Tax[]" class="form-control tax"><option value="0">No Tax</option><?php foreach ($data as $view) { ?><option value="<?php echo $view["percentage"]; ?>"><?php echo $view["title"]; ?>&nbsp;(<?php echo $view['percentage']; ?>%) </option><?php } ?></select></div></td><td><div class="col-sm-6 col-lg-12"><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span><input type="hidden" class="form-control price item_tax" placeholder="Tax Amount"  name="item_tax"><input type="Client Name" class="form-control price sub_total" id="total_amount_'+counter1+'" placeholder="Total"  name="Total_Amount[]"></div></div></td><td><button type="button" class="removeItem btn btn-danger removeItem" value="-"><span class="glyphicon glyphicon-trash">&nbsp;</span></td></tr>');

      counter1++;
   
     $('.tax').on('change', onChangeCallback);});
     
 
    
     
   //Remove Invoice Line
$(document).on('click', '.removeItem', function () { 
    var currentTable = $(this).closest('table').attr('id');
    $(this).closest('tr').remove();
    calculateTableSum(currentTable);
});

  
function calculateSum() {
    var currentTable = $(this).closest('table').attr('id');
    calculateTableSum(currentTable);
    calculateTableSum2(currentTable);
}

function calculateTableSum(currentTable) {



var summ = 0;
  //  var subtaxcollected = $('.subtcollected').val();

    $('#' + currentTable + ' input.item_price').each(function() {
        //add only if the value is number
        if(!isNaN(this.value) && this.value.length!=0) {
            summ += parseFloat(this.value);
        }
    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $('#' + currentTable + ' input.subtcollected').val(summ.toFixed(2));



    var sum = 0;
  //  var subtaxcollected = $('.subtcollected').val();

    $('#' + currentTable + ' input.sub_total').each(function() {
        //add only if the value is number
        if(!isNaN(this.value) && this.value.length!=0) {
            sum += parseFloat(this.value);
        }
    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $('#' + currentTable + ' input.subtcollected').val(sum.toFixed(2));

    var subtaxcollected = parseFloat($('.subtaxcollected').val());

    var total = parseFloat(sum) + (subtaxcollected);

   $('#' + currentTable + ' input.sumamtcollected').val(total.toFixed(2));
}

$(document).on('change', 'input.sub_total', calculateSum);

function calculateSum1() {
    var currentTable = $(this).closest('table').attr('id');
    calculateTableSum1(currentTable);
}



function calculateTableSum1(currentTable) {
    var sum = 0;
   
    $('#' + currentTable + ' input.item_price').each(function() {
        //add only if the value is number
        if(!isNaN(this.value) && this.value.length!=0) {
            sum += parseFloat(this.value);
            
        }
    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
   $('#' + currentTable + ' input.sumamtcollected').val(sum.toFixed(2));
   $('#' + currentTable + ' input.subtcollected').val(sum.toFixed(2));
 
   
}
$(document).on('keyup', 'input.item_price', calculateSum1);


var onChangeCallback1 = function () { 
   var currentTable = $(this).closest('table').attr('id');
   var itemprice = $(this).parents('tr').find('.item_price').val();
   var  taxrate = $(this).parents('tr').find('.tax').val();
   
   var tax =  taxrate * itemprice /100;
    var total = parseFloat(itemprice) + parseFloat(tax);
     var total1 = parseFloat(itemprice) ;
  
  // $(this).parents('tr').find('.item_tax').val(tax.toFixed(2));
   $(this).parents('tr').find('.sub_total').val(total.toFixed(2));
 


   calculateTableSum1(currentTable);

  };
            
 $('.item_price').on('change', onChangeCallback1);


var onChangeCallback = function () { 
   var currentTable = $(this).closest('table').attr('id');
   var itemprice = $(this).parents('tr').find('.item_price').val();
   var  taxrate = $(this).parents('tr').find('.tax').val();
   
   var tax =  taxrate * itemprice /100;
    var total = parseFloat(itemprice) + parseFloat(tax);
  
   $(this).parents('tr').find('.item_tax').val(tax.toFixed(2));
   $(this).parents('tr').find('.sub_total').val(total.toFixed(2));


   calculateTableSum(currentTable);

  };
            
 $('.tax').on('change', onChangeCallback);
   

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

<?php  $this->load->view('merchant/footer'); ?>


</body></html>
