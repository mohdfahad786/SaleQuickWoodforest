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

                </div>

            </div>

        </div>

    </div>

    </div>

<script>

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();   

});

</script>

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