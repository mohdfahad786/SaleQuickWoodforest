<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin | Dashboard</title>
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
            <span>View All Call Request</span>
          </div>
        </div>
      </div>
      <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row" method="post" action="<?php echo base_url('customer/all_request');?>">
              <div class="col-4 minx-351">
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
                      <th>Name</th>
                      <th> Phone </th>
                      <th>Email</th>
                      <th>Estimated Monthly Volume</th>
                      <th>Date Time</th>
                      <th>Action </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $i=1;
                      foreach($mem as $a_data)
                      {
                      $count++;
                    ?>
                    <tr>
                      <td><?php echo $a_data['name'] ?></td>
                      <td><?php echo $a_data['phone'] ?></td>
                      <td><?php echo $a_data['email'] ?></td>
                      <td><?php echo $a_data['estimatedmonthluvolume'] ?></td>
                      <td><?php echo $a_data['add_date'] ?></td>
                      <td><button class="btn btn-sm btn-danger" onclick="merchant_delete(<?php echo $a_data['id'];?>)"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <?php $i++;}?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.modal --> 
          </div>
        </div>
      </div>
    </div>
  </div>
<div id="view-modall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Protractor credentials </h4>
      </div>
      <div class="modal-body">
        <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>"> </div>
        <!-- content will be load here -->
        <div id="dynamic-content1">
          <div class="col-md-10">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Connection ID</label>
              <div class="col-md-8">
                <div class="input-group" > <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control"  name="connection_id" id="connection_id"   placeholder="Connection ID:" 
     >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">API Key</label>
              <div class="col-md-8">
                <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="api_key" id="api_key"  placeholder="API Key" 
     >
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Auth Code</label>
              <div class="col-md-8">
                <div class="input-group" > <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
                  <input type="text" class="form-control" autocomplete="off"   name="auth_code" id="auth_code"  placeholder="Auth Code" 
     >
                  <input type="hidden" class="form-control" id="m_id">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer"> 
        <!--   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <button type="submit" name="submit" id="mysubmit" class="btn btn-primary waves-effect waves-light  btn-lg btn-lgs " data-dismiss="modal" >Update</button>
      </div>
    </div>
  </div>
</div>
<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> <i class="glyphicon glyphicon-user"></i> Payment Detail </h4>
      </div>
      <div class="modal-body">
        <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>"> </div>
        <!-- content will be load here -->
        <div id="dynamic-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script type="text/javascript" src="https://salequick.com/new_assets/js/datatables.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    var dtTransactionsConfig={
        "processing": true,
      // "sAjaxSource":"data.php",
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
     url: "<?php  echo base_url('dashboard/search_record_column'); ?>",
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
$(document).on('click', '#getcredt', function(e){
  e.preventDefault();
 // $('#getcredt').on("click", function () {
             //var tax =  $('#myid').val();
 var tax = $(this).data('id');   // it will get id of clicked row
            $('#auth_code').val('');
           $('#api_key').val('');
            $('#connection_id').val('');
            $.ajax({
                type: 'POST',
                 url: "<?php  echo base_url('pos/search_record_credntl'); ?>",
                data: {id: tax},
                type:'post',
                success: function (dataJson)
                {
                    data = JSON.parse(dataJson)
                    console.log(data)
                    $(data).each(function (index, element) {
        $('#auth_code').val(element.auth_code);
           $('#api_key').val(element.api_key);
            $('#connection_id').val(element.connection_id);
             $('#m_id').val(element.id);
                    });
                }
            });
        });
$(document).on('click', '#mysubmit', function(e){
  e.preventDefault();
 // $('#getcredt').on("click", function () {
             var auth_code =  $('#auth_code').val();
             var api_key =  $('#api_key').val();
             var connection_id =  $('#connection_id').val();
             var tax =  $('#m_id').val();
            $.ajax({
                type: 'POST',
                 url: "<?php  echo base_url('pos/search_record_update'); ?>",
                data: {id: tax, auth_code: auth_code,api_key: api_key,connection_id: connection_id},
                type:'post',
                success: function (dataJson)
                {
                    data = JSON.parse(dataJson)
                    console.log(data)
                    $(data).each(function (index, element) {
                    });
                }
            });
        });
});
function merchant_delete(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
          $.ajax({
            url : "<?php echo base_url('customer/subadmin_delete')?>/"+id,
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
    function merchant_block(id)
    {
      if(confirm('Are you sure Block this Merchant?'))
      {
          $.ajax({
            url : "<?php echo base_url('dashboard/block_merchant')?>/"+id,
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
    function active_merchant(id)
    {
      if(confirm('Are you sure Active this Merchant?'))
      {
          $.ajax({
            url : "<?php echo base_url('dashboard/active_merchant')?>/"+id,
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
           }
   }
 </script>
</body>
</html>