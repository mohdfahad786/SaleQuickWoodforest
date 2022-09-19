<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
   <meta name="author" content="Coderthemes">
   <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
   <title>Subadmin POS  | Dashboard</title>
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
      <div class="page-wrapper pos-list invoice-pos-list">     
         <div class="row">
           <div class="col-12">
             <div class="back-title m-title"> 
               <span>Point Of Sale List</span>
             </div>
           </div>
         </div>
         <div class="row sales_date_range">
           <div class="col-12 custom-form">
             <div class="card content-card">
               <form id="form-filter" class="row">
                 <div class="col minx-351">
                   <div id="daterangeFilter" class="form-control date-range-style">
                       <span>April-18-2019 - May-17-2019</span>
                       <input name="start_date" id="start_date" type="hidden">
                       <input name="end_date" id="end_date" type="hidden">
                   </div>
                 </div>
                 <div class="col">
                   <select class="form-control"  name="status" id="status" required="">
                      <option value="">Select Status</option>
                      <option value="pending">Pending</option>
                      <option value="confirm">Confirm</option>
                      <option value="Chargeback_Confirm">Refund</option>
                    </select>
                 </div>
                 <div class="col-3 ">
                   <!-- <button class="btn btn-first" type="submit" name="mysubmit"><span>Search</span></button> -->
                  <button type="button" id="btn-filter" class="btn btn-first">Search</button>
                 <!--  <button type="button" id="btn-reset" class="btn btn-second">Reset</button> -->
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
                        if (isset($msg)) {
                           echo $msg;
                        }
                     ?>
                     <div class="pos-list-dtable reset-dataTable">
                        <table id="pos_list" class="display" style="width:100%" data-tablesaw-mode="stack">
                           <thead>
                              <tr>
                                 <th>Transaction id</th>
                                 <th>Card Type</th>
                                 <th>Merchant</th>
                                 <th>Phone</th>
                                 <th>Amount</th>
                                 <th>Status</th>
                                 <th> Date</th>
                                 <th class="no-event">
                                <!-- Receipt </th>
                                 <th>View -->
                                 </th>
                              </tr>
                           </thead>
                           <tbody>
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
               <div id="modal-loader" class="text-center" style="display: none;">
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
<script>
var resizefunc = [];
</script>
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
<script>
var table;
$(document).ready(function(){
//datatables
table = $('#pos_list').DataTable({
  pagingType: 'full_numbers',
   "processing": true,
   "serverSide": true,
   "order": [[6,'desc']], //Initial no order.
   responsive: true, 
   dom: 'lBfrtip',
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
      ],
   "ajax": {
      "url": "<?php echo base_url('subadmin/pos_list'); ?>",
      "type": "POST",
      "data": function ( data ) {
         // console.log(data)
         data.start_date = $('#start_date').val();
         data.end_date = $('#end_date').val();
         data.status = $('#status').val();
      }
   },
});
$('#btn-filter').click(function(){ //button filter event click
     table.ajax.reload();  //just reload table
 });
 $('#btn-reset').click(function(){ //button reset event click
   $('#form-filter')[0].reset();
   table.ajax.reload();  //just reload table
});
$(document).on('click', '#getUser', function(e){
   e.preventDefault();
   var uid = $(this).data('id');   // it will get id of clicked row
   $('#dynamic-content').html(''); // leave it blank before ajax call
   $('#modal-loader').show();      // load ajax loader
   $.ajax({
      url: "<?php echo base_url('admin/search_record_column_pos'); ?>",
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
$(document).on('click', '#getUserrecurring', function(e){
   e.preventDefault();
   var uid = $(this).data('id');   // it will get id of clicked row
   $('#dynamic-content').html(''); // leave it blank before ajax call
   $('#modal-loader').show();      // load ajax loader
   $.ajax({
      url: "<?php echo base_url('subadmin/search_record_column_recurring'); ?>",
      type: 'POST',
      data: 'id='+uid,
      dataType: 'html'
    })
   .done(function(data){
      // console.log(data);
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
 </body>
</html>