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
        
        
        
        <div class="col-md-12">
          <h2 class="m-b-20">View All Call Request</h2>
        </div>
      </div>
      <div class="card-box">
        <form method="post" action="<?php echo base_url('customer/all_request');?>" >
          <div class="row">
            <div class="col-sm-8 form-group">
              <div class="input-daterange input-group" id="date-range">
                <input class="form-control" name="start_date" type="text" autocomplete="off"  placeholder="Select Start Date">
                <span class="input-group-addon bg-primary b-0 text-white" style="background-color: #3bafda !important;">to</span>
                <input class="form-control" name="end_date" type="text" autocomplete="off"  placeholder="Select End Date">
              </div>
            </div>
            <div class="col-md-2 form-group"> 
              
              <!--  <input type="submit" name="mysubmit" class="btn btn-primary " value="Search" />  -->
              
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
            <div class="table-rep-plugin">
              <div class="table-responsive" data-pattern="priority-columns"> 
                
                <!--   <h4 class="m-t-0 header-title"><b>data table</b></h4> -->
                
                <table id="datatable" class="table table-bordered">
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
            <!-- /.modal --> 
            
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

           }9

   }

 </script>
</body>

<!-- Mirrored from coderthemes.com/minton/dark/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 01 Nov 2017 07:40:15 GMT -->

</html>