



<!DOCTYPE html>

<html>

   <head>

      <meta charset="utf-8">

      <meta name="viewport" content="width=device-width,initial-scale=1">

      <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">

      <meta name="author" content="Coderthemes">

      <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">

      <title>Admin POS  | Dashboard</title>

      <!-- DataTables -->

      <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">

      <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

      <!-- Responsive datatable examples -->

      <link href="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" />

      <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

      <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">

      <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">

      <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>

      <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap-confirmation.min.js"></script>

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

   </head>

   <body class="fixed-left">

      <!-- Begin page -->

      <div id="wrapper">

         <!-- Top Bar Start -->

         <!-- Top Bar Start -->

         <?php $this->load->view('admin/top');?>

         <!-- Top Bar End -->

         <!-- ========== Left Sidebar Start ========== -->

         <?php $this->load->view('admin/menu');?>

         <!-- Top Bar End -->

         <!-- ========== Left Sidebar Start ========== -->

         <div class="content-page">

            <!-- Start content -->

            <div class="content">

               <div class="container-fluid">

                  <div class="col-md-12">

                     <h2 class="m-b-20">Point Of Sale List </h2>

                  </div>

               </div>

               <div class="card-box">

                  <form id="form-filter" action="" >

                     <div class="row">

                        <div class="col-md-4 form-group form-group">

                           <select class="form-control"  name="status" id="status" required="">

                              <option value="">Select Status</option>

                              <option value="pending">Pending</option>

                              <option value="confirm">Confirm</option>

                              <option value="Chargeback_Confirm">Refund</option>

                           </select>

                           <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                        </div>

                        <div class="col-sm-6 form-group">

                           <div class="input-daterange input-group" id="date-range">

                              <input class="form-control" id="start_date" name="start_date" type="text" autocomplete="off" placeholder="Select Start Date">

                              <span class="input-group-addon bg-primary b-0 text-white" style="background-color: #3bafda !important;">to</span>

                              <input class="form-control" id="end_date" name="end_date" type="text" autocomplete="off" placeholder="Select End Date">

                           </div>

                        </div>

                        <div class="col-md-2 form-group">

                           <!-- <button class="btn btn-primary " type="submit" name="mysubmit" value="Search" ><i class=" ti-search"></i> Search</button> -->

                           <button type="button" id="btn-filter" class="btn btn-primary">Search</button>

                           <button type="button" id="btn-reset" class="btn btn-default">Reset</button>

                        </div>

                     </div>

                  </form>

               </div>

               <div class="row">

                  <div class="col-12">

                     <!--<div class="card-box table-responsive">-->

                     <div class="table-responsive" data-pattern="priority-columns">

                        <!--   <h4 class="m-t-0 header-title"><b>data table</b></h4> -->

                        <?php

$count = 0;

if (isset($msg)) {
	echo $msg;
}

?>

                        <table id="pos_list" class="display nowrap table table-bordered" width="100%" cellspacing="0" data-tablesaw-mode="stack">

                           <!--<table id="example" class="display nowrap table table-bordered" width="100%" cellspacing="0">-->

                           <thead>

                              <tr>

                                 <!-- <th style="display: none;">Sr.No.</th> -->

                                 <!--<th>Invoice </th>-->

                                 <th>Transaction id</th>

                                 <th>Card Type</th>

                                 <th>Merchant</th>

                                 <th>Phone</th>

                                 <th>Amount</th>

                                 <th>Status</th>

                                 <th> Date</th>

                                 <!--  <th>Edit</th> -->

                                 <th>Receipt </th>

                                 <th>View</th>

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

      <!-- /.modal -->

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

      <script>

         var table;

         $(document).ready(function(){

            //datatables

            table = $('#pos_list').DataTable({

               "processing": true, //Feature control the processing indicator.

               "serverSide": true, //Feature control DataTables' server-side processing mode.

               "order": [[6,'desc']], //Initial no order.

               // Load data for the table's content from an Ajax source

               dom: 'Bfrtip',

               buttons: [

                  'copy', 'csv', 'excel', 'pdf', 'print'

               ],

               "ajax": {

                  "url": "<?=site_url('admin/pos_list')?>",

                  "type": "POST",

                  "data": function ( data ) {

                     // console.log(data)

                     data.start_date = $('#start_date').val();

                     data.end_date = $('#end_date').val();

                     data.status = $('#status').val();

                  }

               },

               //Set column definition initialisation properties.

               // "columnDefs": [

               //    {

               //        "targets": [ 0 ], //first column / numbering column

               //        "orderable": false, //set not orderable

               //    },

               // ]

            });

            $('#btn-filter').click(function(){ //button filter event click

                 table.ajax.reload();  //just reload table

             });

             $('#btn-reset').click(function(){ //button reset event click

               $('#form-filter')[0].reset();

               table.ajax.reload();  //just reload table

            });

            // $('#example').DataTable({

            //    dom: 'Bfrtip',

            //    buttons: [

            //       'copy', 'csv', 'excel', 'pdf', 'print'

            //    ]

            // });

            $(document).on('click', '#getUser', function(e){

               e.preventDefault();

               var uid = $(this).data('id');   // it will get id of clicked row

               $('#dynamic-content').html(''); // leave it blank before ajax call

               $('#modal-loader').show();      // load ajax loader

               $.ajax({

                  url: "<?php echo site_url('Admin/search_record_column_pos'); ?>",

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

                  url: "<?php echo base_url('admin/search_record_column_recurring'); ?>",

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

   </body>

   <!-- Mirrored from coderthemes.com/minton/dark/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:40:15 GMT -->

</html>



