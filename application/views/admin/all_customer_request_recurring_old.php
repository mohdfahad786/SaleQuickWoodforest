<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
    <title>Admin | Dashboard</title>
    <!-- DataTables -->
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">

    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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



</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php $this->load->view('admin/top'); ?>
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
           <?php $this->load->view('admin/menu'); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- Page-Title 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Datatable</h4>
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="#">Minton</a></li>
                                        <li class="breadcrumb-item"><a href="#">Tables</a></li>
                                        <li class="breadcrumb-item active">Datatable</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
-->   
<div class="col-md-12">
                            <h2 class="m-b-20">View All Customer Recurring  Payment Request </h2></div>
                    </div>  
  <div class="card-box">
    <form method="post" action="<?php echo base_url('dashboard/all_customer_request_recurring');?>" >
                        <div class="row">
                            <div class="col-md-4">
                               <select class="form-control"  name="status" id="status" required="">
   <option value="">Select Status</option>
    <option value="pending">Pending</option>
     <option value="confirm">Confirm</option>
                          
                    
                                             </select>
                         <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                            </div>
                          


  <!-- <div class="form-group row date datetimepicker col-md-5">
                                       
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" name="curr_payment_date"      class="form-control" autocomplete="off"  placeholder="Select Date" id="datepicker">
                                                
                                            </div>

                                                                                  
                                        </div>
                                    </div> -->

                                    <div class="col-sm-6 form-group row">
                                                            <div class="input-daterange input-group" id="date-range">
                                    <input class="form-control" name="start_date" type="text" autocomplete="off"  placeholder="Select Start Date">
                                        <span class="input-group-addon bg-primary b-0 text-white" style="background-color: #3bafda !important;">to</span>
                                                                <input class="form-control" name="end_date" type="text" autocomplete="off"  placeholder="Select End Date">
                                                            </div>
                                                        </div>



                            <div class="col-md-2">
                             

                                 <input type="submit" name="mysubmit" class="btn btn-primary " value="Search" /> 
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
<div class="table-rep-plugin">
                                        <div class="table-responsive" data-pattern="priority-columns">
                              <!--   <h4 class="m-t-0 header-title"><b>data table</b></h4> -->
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                         <tr>
                                              <th style="display: none;">Sr.No.</th>
                                         <th>Invoice</th>
<th>Name</th>
<th>Merchant </th>
<th>Phone</th>
<th>Title</th>
<th>Amount</th>

<th>Status</th>
<th>Due Date</th>
<th>Create Date</th>
<th>Recurring Status</th>
<th>Action</th>
<!-- <th>Edit</th>
<th>Delete</th> -->
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
                                        <tr>
                                           <td style="display: none;"> <?php echo $i; ?></td>
<td> <?php echo $a_data['payment_id'] ?></td>
<td> <?php echo $a_data['name'] ?></td>
<td>
    
 <?php 
  $data = $this->admin_model->data_get_where_1('merchant', array('id' => $a_data['merchant_id'])); 

  foreach ($data as $view) { 

    echo $view['name']; ?>
<?php 
  }
?>
  </td>

<td> <?php echo $a_data['mobile'] ?></td>
<td> <?php echo $a_data['title'] ?></td>

<td>  <h5 class="no-margin text-bold text-danger" > $<?php echo number_format($a_data['amount'],2); ?> </h5> </td>



<td><?php

if($a_data['status']=='pending'){
 echo '<span class="badge badge-pink"> '.$a_data['status'].'  </span>';
}
elseif ($a_data['status']=='confirm')
{
echo '<span class="badge badge-success"> '.$a_data['status'] .' </span>';
}
 ?></td>
<td> <?php echo $a_data['due_date'] ; ?></td>
<td> <?php echo $a_data['date_c'] ; ?></td>
<td> <?php echo $a_data['recurring_payment'] ?></td>


 <td> <?php
if($a_data['recurring_payment']=='start'){ ?>

<button class="btn btn-sm  btn-danger" onclick="stop_pak(<?php echo $a_data['id'];?>)"><i class="ti-control-pause"></i> Stop</button>


<?php 
}
elseif($a_data['recurring_payment']=='stop')
{ ?>

<button class="btn btn-sm  btn-danger" onclick="start_pak(<?php echo $a_data['id'];?>)"><i class="ti-control-play"></i> Start</button>

<?php 
}
elseif($a_data['recurring_payment']=='complete')
{ ?>



 <a class="btn btn-sm  btn-danger"  onClick="alert('Your All Dues are Clear and Payment complete!')"> <i class="glyphicon glyphicon-eye-open"></i> Done</a>

<?php 
}

?>     </td>
 <!-- <td> 
  <?php if($a_data['status']=='pending') { ?>
 

  <a class="btn btn-warning" id="edit-bt" href="<?php  echo base_url('merchant/edit_request/' . $a_data['id']) ?>"><i class="fa fa-pencil"></i> </a>

  <?php } else { ?> 

 
 <a class="btn btn-warning"  onClick="alert('No Edit After Payment Confirm!')"> <i class="fa fa-pencil"></i> </a>
 <?php } ?>
</td>
 -->



<td>

            <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id'];  ?>" id="getUser" class="btn btn-sm btn-info"><i class="ti-eye"></i> View</button>

            </td>

          

                                        </tr>
                                        <?php $i++;}?>
                                        
                                    </tbody>



                                </table>
</div></div>

                            </div>


                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end content -->
        </div>


        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
       


        <!-- /Right-bar -->
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
    
    </div>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
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
    <!-- Required datatable js -->
    <script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/buttons.bootstrap4.min.js"></script>
  
    <!-- <script src="plugins/datatables/pdfmake.min.js"></script>
        <script src="plugins/datatables/vfs_fonts.js"></script>
        <script src="plugins/datatables/buttons.html5.min.js"></script>
        <script src="plugins/datatables/buttons.print.min.js"></script>
        <script src="plugins/datatables/buttons.colVis.min.js"></script>-->
    <!-- Responsive examples -->
    <script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <!-- App js -->
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>




       <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
       

        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
       

        <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script>




<script>
  

 
function stop_pak(id)
    {
      if(confirm('Are you sure Stop Recurring?'))
      {
       
          $.ajax({
            url : "<?php echo base_url('dashboard/stop_recurring')?>/"+id,
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
            url : "<?php echo base_url('dashboard/start_recurring')?>/"+id,
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
   



    <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable();

        //Buttons examples
        // var table = $('#datatable-buttons').DataTable({
        //lengthChange: false,
        //  buttons: ['copy', 'excel', 'pdf']
        // });

        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
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

     url: "<?php  echo base_url('dashboard/search_record_payment'); ?>",

     
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