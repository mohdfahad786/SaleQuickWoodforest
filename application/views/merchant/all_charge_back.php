<!DOCTYPE html> 
<html> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
    <title>Merchant File export | Dashboard</title>
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


</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php $this->load->view('merchant/top'); ?>
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
           <?php $this->load->view('merchant/menu'); ?>

            <div class="content-page">
            <!-- Start content -->
            <div class="content">


 <div class="container-fluid">
<div class="col-md-12">
                            <h2 class="m-b-20"><?php echo ($meta)?> </h2></div>
                    </div>  
  <div class="card-box">
    <form method="post" action="<?php echo base_url('pos/all_charge_back');?>" >
                        <div class="row">
                             <div class="col-md-4 form-group form-group">
                               <select class="form-control"  name="status" id="status" required="" style="height: auto;">
     <option value="straight">Straight</option>
     <option value="recurring">Recurring</option>
     <option value="pos">POS</option>
                          
                    
                                             </select>
                         <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>

                            </div>
                          


                                   <div class="col-sm-6 form-group">
                                                            <div class="input-daterange input-group" id="date-range">
                                    <input class="form-control" name="start_date" type="text" autocomplete="off"  placeholder="Select Start Date">
                                        <span class="input-group-addon bg-primary b-0 text-white" style="background-color: #3bafda !important;">to</span>
                                                                <input class="form-control" name="end_date" type="text" autocomplete="off"  placeholder="Select End Date">
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



<table id="example" class="display  table table-bordered" width="100%" cellspacing="0">
        <thead>
           <tr>
                                       
                                         <th>Invoice No</th>
                                         <th>Amount</th>
<th>Name</th>
<th>Email</th>
<th>Phone/th>
<th>Reason</th>
<th>Status</th>


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
                                        


<td> <?php echo $a_data['payment_id'] ?></td>
<td>  <h5 class="no-margin text-bold text-danger" > $<?php echo number_format($a_data['amount'],2); ?> </h5> </td>
<td> <?php echo $a_data['name'] ?></td>
<td> <?php echo $a_data['email'] ?></td>
<td> <?php echo $a_data['mobile_no'] ?></td>
<td> <?php echo $a_data['reason'] ?></td>



<td><?php

if($a_data['status']=='pending'){
 echo '<span class="badge badge-pink"> '.$a_data['status'].'  </span>';
}
elseif ($a_data['status']=='confirm')
{
echo '<span class="badge badge-success"> '.$a_data['status'] .' </span>';
}
 ?></td>

                                        </tr>
                                          <?php $i++;}?>
                                        
                                    </tbody>
    </table>

</div></div></div>

</div></div></div>

  </div>

  


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


    <script type="text/javascript">
      
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

    </script>



</body>
<!-- Mirrored from coderthemes.com/minton/dark/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:40:15 GMT -->

</html>