<!DOCTYPE html> 
<html> 
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin  | Report</title>
  <!-- DataTables -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/dcalendar.picker.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/datatables.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
  <div id="wrapper"> 
    <div class="page-wrapper">
      <div class="row dash-card">
        <div class="col-3">
          <div class="card-box">
            <div class="request">
              <span class="request-count"><?php echo '$'.@number_format($GrosspaymentValume,2) ;?></span>
              <span class="request-name">Gross  Payment Volume </span>
            </div>
            <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/doller-package.png"> </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card-box">
            <div class="request">
              <span class="request-count"><?php 
                echo '$'.@number_format($TotalFeeCaptured,2) ;?></span>
              <span class="request-name">Total Fee Captured </span>
            </div>
            <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/package.png"> </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card-box">
            <div class="request">
              <span class="request-count"> <?php $payout = $GrosspaymentValume - $TotalFeeCaptured; echo '$'.@number_format($payout,2); ?> </span>
              <span class="request-name">Total Payout</span>
            </div>
            <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/badge.png"> </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card-box">
            <div class="request">
              <span class="request-count"> <?php echo $TotalTransactions ;?></span>
              <span class="request-name">Total Transactions </span>
            </div>
            <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/money-bag.png"> </div>
          </div>
        </div>
      </div>
      <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row" method="post" action="<?php echo base_url('dashboard/report');?>">
              <div class="col-4">
                <div id="daterangeFilter" class="form-control">
                  <!-- <span>April-18-2019 - May-17-2019</span>
                  <input name="start_date" type="hidden">
                  <input name="end_date" type="hidden"> -->
                  <span><?php echo ((isset($reposrint_date) && !empty($reposrint_date))?(date("F-d-Y", strtotime($reposrint_date)) .' - '.date("F-d-Y", strtotime(isset($end_date) ? $end_date:date('Y-m-d')))):('<label class="placeholder">Select date range</label>')) ?>
                    </span>
                    <input name="start_date" type="hidden" value="<?php echo (isset($reposrint_date) && !empty($reposrint_date))? $reposrint_date : '';?>" >
                    <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >
                

                </div>
              </div>
              <div class="col">
                <?php
                $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active', 'user_type' => 'merchant')); ?>
                <select name="employee" class="form-control bder-radius" id="employee" style="height: auto" >
                  <option  value="" >Select Merchant</option>
                  <?php foreach ($data as $view) { ?>
                    <option <?php echo (@$employee==$view['id'])?'selected="selected"':''?>  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col">
                <select class="form-control"  name="status" id="status" >
                  <option value="">Select Status</option>
                  <option <?php echo ($status=="pending")?'selected="selected"':''?> value="pending">Pending</option>
                  <option <?php echo ($status=="confirm")?'selected="selected"':''?> value="confirm">Confirm</option>
                </select>
              </div>
              <div class="col">
                <button class="btn btn-first" type="submit" name="mysubmit"><span>Search</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-detail">
              <?php
              $count = 0;
              if(isset($msg))
                echo $msg;
              ?>
              <div class="pos-list-dtable reset-dataTable">
                <form onsubmit="return validate(this);" method="post" action="<?php echo base_url('dashboard/funding_status_post');?>" >
                  <div class="row form-group">
                    <div style="display:none" id="hideencheckbox"></div>
                    <div class="col-12 text-right">
                      <input class="form-control" required  value="<?php echo $reposrint_date ?>" name="date" type="hidden" autocomplete="off"  placeholder="Select Date">
                      <button class="btn  btn-warning " type="submit" name="pendingSubmit" value="true" ><i class="ti-pencil"></i> Pending</button>
                      <button class="btn btn-success" type="submit" name="confirmSubmit" value="true" ><i class="ti-pencil"></i> Confirm</button>
                    </div>
                  </div>
                </form>
                <table id="example" class="display" style="width:100%">
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
                        echo $a_data['business_dba_name']; ?>
                      </td>
                      <td> <?php echo $a_data['bank_account'] ?></td> 
                      <td>  <b class="text-danger" > $<?php echo @number_format($totalFees,2); ?> </b> </td>
                      <td>  <b class="text-danger" > $<?php 
               //echo '--'.$a_data['hold_amount'].'--'; 
                      $endAmount=(isset($a_data['hold_amount']) && $a_data['hold_amount']!="")?number_format($a_data['hold_amount'],2):'0.00';
                      if($a_data['status']!=''){
                        
                        echo number_format(($a_data['amount']),2).'/'.$endAmount; 
                      }else{
                        echo number_format(($a_data['totalAmount']-$totalFees),2).'/0.00';
                      }
                      ?> </b> </td>
                      <td><?php
                      if($a_data['status']=='pending'){
                        echo '<span class="badge-btn badge-pink"> '.$a_data['status'].'  </span>';
                      }
                      elseif ($a_data['status']=='confirm')
                      {
                        echo '<span class="badge-btn badge-success"> '.$a_data['status'] .' </span>';
                      }else{
                        echo '<span class="badge-btn badge-yellow light-yellow"> UnProcess  </span>';
                      }
                      ?></td>
                      <td> <?php echo $a_data['date_c'] ; ?> </td> 
                      <td>
                        <a href="#" data-toggle="modal" data-target="#view-modal" data-date="<?php echo $a_data['date_c'];?>" data-id="<?php echo $a_data['id'];?>" id="getUser" class="pos_Status_c badge-btn"><i class="ti-eye"></i> View</a>
                        <button data-toggle="modal" data-holdamount="<?php echo $a_data['hold_amount']?>" data-target="#amount-modal" data-amount="<?php echo ($a_data['status']!='')?$a_data['amount']:($a_data['totalAmount']-$totalFees)?>" data-date="<?php echo $a_data['date_c'];?>" data-mid="<?php echo $a_data['id'];?>" id="setamount" class="btn btn-sm btn-warning"><i class="ti-eye"></i> Change Status</button>
                      </td>
                    </tr>
                    <?php $i++;}?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Payment Detail
        </h4> 
      </div> 
      <div class="modal-body"> 
       <div id="modal-loader" class="text-center modal-loader" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
      </div>
        <!-- content will be load here -->                          
        <div id="dynamic-content"></div>
      </div> 
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
      </div> 
    </div> 
  </div>
</div>   
<div id="amount-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Change Status
        </h4> 
      </div> 
      <div class="modal-body"> 
        <!-- content will be load here -->                          
        <div id="amountdynamic-content">
          <form  method="post" action="<?php echo base_url('dashboard/funding_status');?>" >
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
                <h5><small><b>Previous Hold Amount</b></small></h5>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tr>
                      <th>Action</th>
                      <th>Total Amount</th>
                      <th>Hold Amount</th>
                      <th>Date</th>
                      <th>Status</th>
                    </tr>
                    <tbody id="holdrow">
                      <div id="modal-loader" class="text-center modal-loader"  style="padding: 15px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
                      </div>
                    </tbody>
                  </table>
                </div>
                <button class="btn btn-first " type="submit" name="mysubmit" value="Search" ><i class="ti-pencil"></i> Submit</button>
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
</div>   
  <script>
    var resizefunc = [];
  </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>/new_assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> -->
<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
<!-- Custom main Js -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
<a href="report.php"></a>
<script type="text/javascript">
  $("#Hold_Amount").on("keyup",function(){
    calcaulatHold($(this));
  });
  $(document).ready(function() {
    var table =$('#example').DataTable({
      dom: 'lBfrtip',
      "order": [[ 4, "desc" ]],
      responsive: true, 
      language: {
        search: '', searchPlaceholder: "Search",
        oPaginate: {
           sNext: '<i class="fa fa-angle-right"></i>',
           sPrevious: '<i class="fa fa-angle-left"></i>',
           sFirst: '<i class="fa fa-step-backward"></i>',
           sLast: '<i class="fa fa-step-forward"></i>'
           }
       }   ,
     buttons: [
      {
        extend: 'collection',
        text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
        buttons: [
        'copy',
        'excel',
        'csv',
        'pdf',
        'print'
        ]
      }
    ]
    });
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
$('#modal-loader,.modal-loader').show();      // load ajax loader
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
$('#modal-loader,.modal-loader').hide();      // hide ajax loader 
})
.fail(function(){
  $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
  $('#modal-loader,.modal-loader').hide();
});
});
$(document).on('click', '#getUser', function(e){
e.preventDefault();
var uid = $(this).data('id');   // it will get id of clicked row
var date = $(this).data('date');   // it will get id of clicked row
$('#dynamic-content').html(''); // leave it blank before ajax call
$('#modal-loader,.modal-loader').show();      // load ajax loader
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
$('#modal-loader,.modal-loader').hide();      // hide ajax loader 
})
.fail(function(){
  $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
  $('#modal-loader,.modal-loader').hide();
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
$('#modal-loader,.modal-loader').show();      // load ajax loader
$.ajax({
  url: "<?php  echo base_url('dashboard/get_holdamount'); ?>",
  type: 'POST',
  data: 'mid='+mid+'&cdate='+cdate+'&amounnt='+amounnt,
  dataType: 'html'
})
.done(function(data){
  $('#modal-loader,.modal-loader').hide();
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
console.log('done')
      // hide ajax loader 
})
.fail(function(){
  $('#modal-loader,.modal-loader').hide();
  $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
console.log('faail')
});
});
    $(document).on('click', '#getpos', function(e){
      e.preventDefault();
var uid = $(this).data('id');   // it will get id of clicked row
$('#dynamic-content').html(''); // leave it blank before ajax call
$('#modal-loader,.modal-loader').show();      // load ajax loader
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
$('#modal-loader,.modal-loader').hide();      // hide ajax loader 
})
.fail(function(){
  $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
  $('#modal-loader,.modal-loader').hide();
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
</html>