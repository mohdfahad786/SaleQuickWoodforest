<!DOCTYPE html> 
<html> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
    <title>Admin  | Report</title>
    <!-- DataTables -->
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">


    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
   
   
    <!-- Responsive datatable examples -->
  
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>


 
     <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
  
<link href="<?php echo base_url('merchant-panel'); ?>/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">

    <!-- Begin page -->
   <link href="<?php echo base_url('datatable'); ?>/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('datatable'); ?>/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<style>
table.dataTable.select tbody tr,
table.dataTable thead th:first-child {
  cursor: pointer;
}
</style>
</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php $this->load->view('admin/top'); ?>
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
           <?php $this->load->view('admin/menu'); ?>

            <div class="content-page">
            <!-- Start content -->
            <div class="content">


 <div class="container-fluid">

        <div class="row">
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-green card-box fadeInDown animated">
        <div class="bg-icon  pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/doller-package.png"> </div>
        <div class="text-left">
              <h3 class=" m-t-10"><b class="counter"><?php echo '$'.@number_format($GrosspaymentValume,2) ;?></b></h3>
              <p class="text-muted mb-0">Gross  Payment Volume </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-yellow card-box">
        <div class="bg-icon pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/package.png"> </div>
        <div class="text-left">
            <h3 class=" m-t-10"><b class="counter"><?php 
              echo '$'.@number_format($TotalFeeCaptured,2) ;?></b></h3>
              <p class="text-muted mb-0">Total Fee Captured </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-blue card-box">
        <div class="bg-icon pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/badge.png"> </div>
        <div class="text-left">
              <h3 class=" m-t-10"><b class="counter"> <?php $payout = $GrosspaymentValume - $TotalFeeCaptured; echo '$'.@number_format($payout,2); ?> </b></h3>
              <p class="text-muted mb-0">Total Payout </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-red card-box">
        <div class="bg-icon pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/money-bag.png"> </div>
        <div class="text-left">
              <h3 class=" m-t-10"><b class="counter"> <?php echo $TotalTransactions ;?></b></h3>
              <p class="text-muted mb-0">Total Transactions </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
  </div>

                    </div>  
  <div class="card-box">
    <form method="post" action="<?php echo base_url('dashboard/report');?>" >
                        <div class="row">
                             <div class="col-md-3 form-group form-group">
                              <?php
                
     $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active', 'user_type' => 'merchant')); ?>
            <select name="employee" class="form-control bder-radius" id="employee" style="height: auto" >
                  <option  value="" >Select Merchant</option>
                 
                  <?php foreach ($data as $view) { ?>
                  <option <?php echo (@$employee==$view['id'])?'selected="selected"':''?>  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
                  <?php } ?>
                </select>
                         <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                            </div>

                            <div class="col-md-2 form-group form-group">
                              <select class="form-control"  name="status" id="status" >
   <option value="">Select Status</option>
    <option <?php echo (@$status=="pending")?'selected="selected"':''?> value="pending">Pending</option>
     <option <?php echo (@$status=="confirm")?'selected="selected"':''?> value="confirm">Confirm</option>
                          
                    
                                             </select>

                            </div>
                          


                                   <div class="col-sm-2 form-group">
                                                            <div class="input-daterange input-group" id="date-range">
                                                                <input class="form-control" required  value="<?php echo $reposrint_date ?>" name="start_date" type="text" autocomplete="off"  placeholder="Select Date">
                                        
                                                    </div>
                                                        </div>



                            <div class="col-md-2 form-group">
                             <button class="btn btn-primary " type="submit" name="mysubmit" value="Search" ><i class=" ti-search"></i> Search</button>

                            </div>
                        </div>
                      </form>
                    </div>

 





 <div class="row">
                        <div class="col-12">
                            <div class="card-box table-responsive">
                                <?php
$count = 0;
if(isset($msg))
echo $msg;
?>





<form onsubmit="return validate(this);" method="post" action="<?php echo base_url('dashboard/funding_status_post');?>" >
          <div class="row">
                    <div style="display:none" id="hideencheckbox"></div>
                    <div class="col-md-8 form-group form-group"></div>
                    <div class="col-md-4 form-group">
                    <input class="form-control" required  value="<?php echo $reposrint_date ?>" name="date" type="hidden" autocomplete="off"  placeholder="Select Date">
                             <button class="btn  btn-warning " type="submit" name="pendingSubmit" value="true" ><i class="ti-pencil"></i> Pending</button>
                             <button class="btn btn-success" type="submit" name="confirmSubmit" value="true" ><i class="ti-pencil"></i> Confirm</button>
                            </div>
                  
          </div>
</form>

<table id="example" class="display  table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
 <th><input name="select_all" value="1" type="checkbox"></th>                                         <!--  <th>Sr.No.</th> -->

<th>Gross Payments </th>
<th>Merchant</th>

<th>Account</th>

<th>Fee Total</th> 
<th>Payable/Hold Amount</th>
 <th>Status</th>

<th>Funding Date</th> 
 <th>Details</th>


                  
                                        </tr>
        </thead>
      
         <tbody>
                                        <?php
$i=1;

  foreach($full_reporst as $a_data)
{
$count++;
 
  ?>
  <?php
    $totalFees=0;
    if($a_data['totalAmount']>0){
        $totalFees=$a_data['feesamoun']+$a_data['monthly_fees'];
    }
?>

                                        <tr>
<td><input type="checkbox" name="chkstatus[]" value="<?php echo $a_data['id'];?>_<?php echo $a_data['totalAmount']-$totalFees?>"></td>                                    
<td>$ <?php echo @number_format($a_data['totalAmount'],2); ?></td>


<td>  <?php 
  
    echo $a_data['name']; ?>
</td>
 
<td> <?php echo $a_data['bank_account'] ?></td> 

<td>  <h5 class="no-margin text-bold text-danger" > $<?php echo @number_format($totalFees,2); ?> </h5> </td>
<td>  <h5 class="no-margin text-bold text-danger" > $<?php 
if($a_data['status']!=''){
    echo @number_format(($a_data['amount']),2).'/'.number_format(($a_data['hold_amount']),2);
  }else{
    echo @number_format(($a_data['totalAmount']-$totalFees),2).'/0.00';
  }
 ?> </h5> </td>
<td><?php

if($a_data['status']=='pending'){
 echo '<span class="badge badge-pink"> '.$a_data['status'].'  </span>';
}
elseif ($a_data['status']=='confirm')
{
echo '<span class="badge badge-success"> '.$a_data['status'] .' </span>';
}else{
    echo '<span class="badge badge-yellow light-yellow"> UnProcess  </span>';
}
 ?></td>
<td> <?php echo $a_data['date_c'] ; ?> </td> 

<td>

            <button data-toggle="modal" data-target="#view-modal" data-date="<?php echo $a_data['date_c'];?>" data-id="<?php echo $a_data['id'];?>" id="getUser" class="btn btn-sm btn-info"><i class="ti-eye"></i> View</button>

            <button data-toggle="modal" data-holdamount="<?php echo $a_data['hold_amount']?>" data-target="#amount-modal" data-amount="<?php echo ($a_data['status']!='')?$a_data['amount']:($a_data['totalAmount']-$totalFees)?>" data-date="<?php echo $a_data['date_c'];?>" data-mid="<?php echo $a_data['id'];?>" id="setamount" class="btn btn-sm btn-warning"><i class="ti-eye"></i> Change Status</button>

            

</td>

                          </tr>
                                        <?php $i++;}?>


                                        
                                        
                                        
                                    </tbody>
    </table>

</div></div></div>

</div></div></div>

  </div>

    <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog"> 
                  <div class="modal-content"> 
                  
                       <div class="modal-header"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                            <h4 class="modal-title">
                              <i class="glyphicon glyphicon-user"></i> Payment Detail
                            </h4> 
                       </div> 
                       <div class="modal-body"> 
                       
                           <div id="modal-loader" style="display: none; text-align: center;">
                            <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>">
                           </div>
                            
                           <!-- content will be load here -->                          
                           <div id="dynamic-content"></div>
                             
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        </div> 
                        
                 </div> 
              </div>
       </div><!-- /.modal -->    


        <div id="amount-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog"> 
                  <div class="modal-content"> 
                  
                       <div class="modal-header"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                            <h4 class="modal-title">
                              <i class="glyphicon glyphicon-user"></i> Change Status
                            </h4> 
                       </div> 
                       <div class="modal-body"> 
                       
                           <div id="amount-loader" style="display: none; text-align: center;">
                            <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>">
                           </div>
                            
                           <!-- content will be load here -->                          
                           <div id="amountdynamic-content">
                           <form  method="post" action="<?php echo base_url('dashboard/funding_status');?>" >
                                <div class="row">
                                          
                                          <div class="row">
                                              <div class="col-md-12">
                                                
                                                      <div class="form-group row">
                                                          <label class="col-md-2 col-form-label">Status</label>
                                                          <div class="col-md-5 form-group">
                                                              <select class="form-control bder-radius" required="required" name="pstatus" id="pstatus">
                                                                <option value="">-Select Status-<opton>
                                                                <option value="pending">Pending<opton>
                                                                <option value="confirm">Confirm<opton>
                                                              </select>
                                                          </div>
                                                        
                                                      </div>
                                                   
                                                     
                                                     
                                              </div>
                                              <div class="col-md-6">
                                                
                                                      <div class="form-group row">
                                                          <label class="col-md-6 col-form-label">Payable Amount $</label>
                                                          <div class="col-md-6">
                                                              <input type="text" class="form-control" readonly name="PayableAmount3" id="PayableAmount"  required value="">
                                                              <input type="hidden" class="form-control" readonly name="PayableAmount" id="PayableAmount2"  required value="">
                                                          </div>
                                                        
                                                      </div>
                                                   
                                                     
                                                     
                                              </div>
                                              <div class="col-md-6">
                                                
                                                    
                                                      <div class="form-group row">
                                                          <label class="col-md-5 col-form-label">Hold Amount</label>
                                                          <div class="col-md-7">
                                                              <input type="text" class="form-control" name="Hold_Amount" id="Hold_Amount"  required value="0">                                               
                                                              <input type="hidden" class="form-control" name="date" id="popup_date"  required value="">
                                                              <input type="hidden" class="form-control" name="mid" id="popup_mearchent_id"  required value="">
                                                          </div>
                                                      </div>
                                                    
                                                 
                                                 
                                              </div>
                                     <div class="col-md-12">
                                        <h3>Previous Hold Amount</h3>
                                        <table class="table table-bordered">
                                        <tr>
                                          <Th>Action</TH>
                                          <th>Total Amount</th>
                                          <th>Hold Amount</th>
                                          <th>Date</th>
                                          <th>Status</th>
                                        </tr>
                                        <tbody id="holdrow">
                                        <tbody>
                                        </table>
                                        <button class="btn btn-primary " type="submit" name="mysubmit" value="Search" ><i class="ti-pencil"></i> Submit</button>
                                     </div>
                                        

                                </div>
                      </form>

                           </div>
                             
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        </div> 
                        
                 </div> 
              </div>
       </div><!-- /.modal -->    
    
    </div>


   <!-- END wrapper -->
    <script>
    var resizefunc = [];
    </script>
    <!-- Plugins  -->

      <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>

      
 
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
    <!-- Popper for Bootstrap -->
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
   
    <!-- App js -->
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>




       <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
       

        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
       

        <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script>



 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

 <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>

 <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>

 <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

 <script src=" //cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>

 <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

   <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>

 <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>

 


    
    
   


 <a href="report.php"></a>
    <script type="text/javascript">
      
$("#Hold_Amount").on("keyup",function(){
  calcaulatHold($(this));
});

$(document).ready(function() {
    var table =$('#example').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 4, "desc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    // Handle click on checkbox
   $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');

      // Get row data
      var data = table.row($row).data();

      // Get row ID
      var rowId = data[0];

      // Determine whether row ID is in the list of selected row IDs
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
         rows_selected.push(rowId);

      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
         rows_selected.splice(index, 1);
      }

      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });


   // Handle click on "Select all" control

   $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
      if(this.checked){
         $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
         $('#example tbody input[type="checkbox"]:checked').trigger('click');
      }

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });
} );

function updateDataTableSelectAllCtrl(table){
   var $table             = table.table().node();
   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

   // If none of the checkboxes are checked
   if($chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if ($chkbox_checked.length === $chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}

    </script>


     <script>
  

 
function stop_pak(id)
    {
      if(confirm('Are you sure Stop Recurring?'))
      {
       
          $.ajax({
            url : "<?php echo base_url('merchant/stop_recurring')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error  data');
            }
        });

      }
    }


    function start_pak(id)
    {
      if(confirm('Are you sure Start Recurring?'))
      {
       
          $.ajax({
            url : "<?php echo base_url('merchant/start_recurring')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

      }
    }


</script>
   



      <script>


      var rows_selected = [];
      var globalPaybelAmount=0;

      function calcaulatHold(obj){


    var PayableAmount=globalPaybelAmount;    
    var holdamount=PayableAmount-$("#Hold_Amount").val();
     

    $(document).ready(function() {
      var PayableAmount=globalPaybelAmount;    
      var gHoldamount=PayableAmount-$("#Hold_Amount").val();
      $('#holdrow [type="checkbox"]').each(function(i, chk) {
       
        if (chk.checked) {
          oblhod=parseFloat($(chk).data("amount"));
          gHoldamount=oblhod+gHoldamount;
          console.log(oblhod,holdamount);          
          
        }else{
           
        }
      });
        
        gHoldamount=parseFloat(gHoldamount);
          gHoldamount=gHoldamount.toFixed(2);
          $("#PayableAmount2").val(gHoldamount);
          gHoldamount=(gHoldamount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
          $("#PayableAmount").val(gHoldamount);

    });
 }
$(document).ready(function(){
  
  $(document).on('click', '#getUser', function(e){
    
    e.preventDefault();
    
    var uid = $(this).data('id');   // it will get id of clicked row
    var date = $(this).data('date');   // it will get id of clicked row
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({

     url: "<?php  echo base_url('dashboard/search_record_column2'); ?>",

     
      type: 'POST',
      data: 'id='+uid+"&date="+date,
      dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); // load response 
      $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });

  $(document).on('click', '#getUser', function(e){
    
    e.preventDefault();
    
    var uid = $(this).data('id');   // it will get id of clicked row
    var date = $(this).data('date');   // it will get id of clicked row
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({

     url: "<?php  echo base_url('dashboard/search_record_column2'); ?>",

     
      type: 'POST',
      data: 'id='+uid+"&date="+date,
      dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); // load response 
      $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });


 $(document).on('click', '#setamount', function(e){
    
    e.preventDefault();
    
    var amounnt = $(this).data('amount');   // it will get id of clicked row
    amounnt = amounnt ? amounnt : 0;
    var holdAmount=$(this).data('holdamount');
    holdAmount=parseFloat(holdAmount);
    holdAmount = holdAmount ? holdAmount : 0;
    globalPaybelAmount=amounnt;
    var cdate=$(this).data('date');
    var mid=$(this).data('mid');
    
          $("#Hold_Amount").val($(this).data('holdamount'));
          amounnt=parseFloat(amounnt);
          amounnt=amounnt.toFixed(2);
          amounnt2=(amounnt-holdAmount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    $("#PayableAmount").val(amounnt2);
    $("#PayableAmount2").val(amounnt-holdAmount);
    //$("#Hold_Amount").val(0);
    $("#popup_date").val(cdate);
    $("#popup_mearchent_id").val(mid);
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#amount-loader').show();      // load ajax loader
    
    $.ajax({

     url: "<?php  echo base_url('dashboard/get_holdamount'); ?>",

     
      type: 'POST',
      data: 'mid='+mid+'&cdate='+cdate+'&amounnt='+amounnt,
      dataType: 'html'
    })
    .done(function(data){
      data = jQuery.parseJSON(data);    
      console.log(data);    
      $('#holdrow').html('');    
      $.each( data, function( key, value ) {
        var amount=value['amount'];
        var hold_amount=value['hold_amount'];

        amount=(amount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        hold_amount=(hold_amount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
          $('#holdrow').append('<tr><td><input type="checkbox" onclick="calcaulatHold($(this));" data-amount="'+value['hold_amount']+'" value="'+value['id']+'" name="holdetext[]"></td><td>$'+amount+'</td><td>$'+hold_amount+'</td><td>'+value['date']+'</td><td>'+value['status']+'</td></tr>');
      });
      //$('#holdrow').html(data); // load response 
      $('#amount-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });

 
 $(document).on('click', '#getpos', function(e){
    
    e.preventDefault();
    
    var uid = $(this).data('id');   // it will get id of clicked row
    
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({

     url: "<?php  echo base_url('dashboard/search_record_pos'); ?>",

     
      type: 'POST',
      data: 'id='+uid,
      dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); // load response 
      $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });



  
});

function validate(form) {

    // validation code here ...


    if(rows_selected.length==0) {
        alert('Please select checkbox');
        return false;
    }
    else {
        $("#hideencheckbox").html(''); 
        $.each(rows_selected, function(index, rowId){         // Create a hidden element
             $("#hideencheckbox").append($(rowId).attr("checked","checked"));      
      });
      return confirm('Do you really want to submit the form?');
    }
}
</script>

</script>  

</body>
<!-- Mirrored from coderthemes.com/minton/dark/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:40:15 GMT -->

</html>