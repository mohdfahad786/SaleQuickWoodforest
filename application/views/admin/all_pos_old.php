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
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
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
                            <h2 class="m-b-20">Point Of Sale List</h2></div>
                    </div>  


 
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box table-responsive">
                                <?php
$count = 0;
if(isset($msg))
echo $msg;
?>
                              <!--   <h4 class="m-t-0 header-title"><b>data table</b></h4> -->
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                         <th>Sr.No.</th>
  <th> Owner Name </th>
                    <th> Card No </th>
                    <th> Amount </th>
                     <th> Status </th>

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
                                      
<td> <?php echo $i; ?></td>

<td> <?php echo $a_data['name'] ?></td>
<td> <?php echo $a_data['card_no'] ?></td>
<td>  <h5 class="no-margin text-bold text-danger" > $<?php echo number_format($a_data['amount'],2); ?> </h5> </td>





<td>  
    
    <?php

if($a_data['status']=='pending'){
 echo '<span class="badge badge-pink"> '.$a_data['status'].'  </span>';
}
elseif ($a_data['status']=='confirm')
{
echo '<span class="badge badge-success"> '.$a_data['status'] .' </span>';
}
 
 elseif ($a_data['status']=='declined')
{
echo '<span class="badge badge-danger"> '.$a_data['status'] .' </span>';
}
 elseif ($a_data['status']=='Chargeback_Confirm')
{
echo '<span class="badge badge-pink"> Refund</span>';
}
	
else
{
    echo '<span class="badge badge-pink"> '.$a_data['status'] .' </span>';
}
 ?>
    
    
    
</td>

                                        </tr>
                                        <?php $i++;}?>
                                        
                                    </tbody>



                                </table>


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
    <script src="<?php echo base_url('merchant-panel'); ?>/plugins/datatables/jszip.min.js"></script>
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

       <script type="text/javascript">


function tax_delete(id)
    {
      if(confirm('Are you sure delete this ?'))
      {
       
          $.ajax({
            url : "<?php echo base_url('merchant/tax_delete')?>/"+id,
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

</body>
<!-- Mirrored from coderthemes.com/minton/dark/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:40:15 GMT -->

</html>