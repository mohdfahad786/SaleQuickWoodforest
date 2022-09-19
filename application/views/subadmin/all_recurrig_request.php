<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Subadmin | Dashboard</title>
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
  <!-- Begin page -->
  <div id="wrapper"> 
    <div class="page-wrapper pos-list invoice-pos-list">     
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title"> 
            <span>View All Send Recurring Payment Request</span>
          </div>
        </div>
      </div>
      <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row" method="post" action="<?php echo base_url('subadmin/all_recurrig_request');?>">
              <div class="col">
                <div id="daterangeFilter" class="form-control">
                    <!-- <span>April-18-2019 - May-17-2019</span>
                    <input name="start_date" type="hidden">
                    <input name="end_date" type="hidden"> -->
                    <span><?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
                    </span>
                    <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>" >
                    <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >
                

                </div>
              </div>
              <div class="col">
                <select class="form-control" name="status" id="status">
                  <option value="">Select Status</option>
                  <?php if (!empty($status) && isset($status)) {  ?>
                    <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?> >Pending</option>
                    <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?> >Confirm</option>
                    <option value="Chargeback_Confirm" <?php echo (($status == 'Chargeback_Confirm') ? 'selected' : "") ?> >Refund</option>
                  <?php  } else { ?>
                    <option value="pending">Pending</option>
                    <option value="confirm">Confirm</option>
                    <option value="Chargeback_Confirm">Refund</option>
                    <?php } ?>

                    
                </select>
              </div>
              <div class="col-3 ">
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
                <table id="datatable" class="display" style="width:100%">
                  <thead>
                    <tr>
                      <th>Merchant</th>       
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Title</th>
                      <th>Amount</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>View</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach($mem as $a_data)
                        {
                        $count++;
                        ?>
                      <td>
                       <?php 
                        $data = $this->admin_model->data_get_where_1('merchant', array('id' => $a_data['merchant_id'])); 
                        foreach ($data as $view) { 
                          echo $view['name']; ?>
                      <?php 
                        }
                      ?>
                      </td>
                      <td> <?php echo $a_data['name'] ?></td>
                      <td> <?php echo $a_data['email'] ?></td>
                      <td> <?php echo $a_data['mobile'] ?></td>
                      <td> <?php echo $a_data['title'] ?></td>
                      <td> <?php echo $a_data['amount'] ?></td>
                      <td> <?php echo $a_data['payment_type'] ?></td>
                      <td> <?php echo $a_data['status'] ?></td>
                      <td> <?php echo $a_data['date'] ?></td>
                      <td>
                      <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['cid'];  ?>" id="getUser" class="btn btn-sm btn-info"><i class="ti-eye"></i> View</button>
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
</div>  
<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
      <div class="modal-content"> 
           <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h4 class="modal-title">
                  <i class="glyphicon glyphicon-user"></i> Payment  Detail
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
</div> 
<script>
var resizefunc = [];
</script>
<!-- Plugins  -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<!-- Popper for Bootstrap -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> -->
<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
var dtTransactionsConfig={
"processing": true,
"pagingType": "full_numbers",
"pageLength": 25,
"dom": 'lBfrtip',
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
"buttons": [
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
}
$('#datatable').DataTable(dtTransactionsConfig);
});
</script>
<script>
$(document).ready(function(){
  $(document).on('click', '#getUser', function(e){
    e.preventDefault();
    var uid = $(this).data('id');   // it will get id of clicked row
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    $.ajax({
      url: "<?php  echo base_url('subadmin/search_record_payment'); ?>",
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
</script>  
 <script type="text/javascript">
   function CheckAll()
     {  
       var post_count = document.getElementById('id').value;
       var k ;
       var j =0
        for(k=1; k<=post_count;k++)
         {
           if(document.getElementById('checkall').checked==true)
                   {
                    document.getElementById('ids'+k).checked=true;
              j++;
               }
         else
           {
             document.getElementById('ids'+k).checked=false;
           }   
           }9
   }
 </script>
</html>