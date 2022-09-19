<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>subadmin | Dashboard</title>
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
            <span>View All Subadmin</span>
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
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Edit</th>
                      <th>Delete</th>
                      <th>Active</th>
                      <th>Status</th>
                      <?php if((!empty($this->session->userdata('subadmin_delete_permissions')) && $this->session->userdata('subadmin_delete_permissions')=='1' ) || (!empty($this->session->userdata('subadmin_edit_permissions')) && $this->session->userdata('subadmin_delete_permissions')=='1' ) ) { ?>
                      <th class="no-event"></th>
                      <?php } ?>
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
                      <td> <?php echo $a_data['name'] ?></td>
                      <td> <?php echo $a_data['email'] ?></td>
                      <td> <?php echo $a_data['mob_no'] ?></td>
                      <td> <?php if($a_data['edit_permissions']=='1') {echo 'Yes';} elseif($a_data['edit_permissions']=='0'){ echo 'No';} ?></td>
                      <td> <?php if($a_data['delete_permissions']=='1') {echo 'Yes';} elseif($a_data['delete_permissions']=='0'){ echo 'No';} ?></td>
                      <td> <?php if($a_data['active_permissions']=='1') {echo 'Yes';} elseif($a_data['active_permissions']=='0'){ echo 'No';} ?></td>
                      <td> <?php echo $a_data['status'] ?></td>
                      <?php if((!empty($this->session->userdata('subadmin_delete_permissions')) && $this->session->userdata('subadmin_delete_permissions')=='1' ) || (!empty($this->session->userdata('subadmin_edit_permissions')) && $this->session->userdata('subadmin_delete_permissions')=='1' ) ) { ?>

                      <td> 
                        <div class="dropdown dt-vw-del-dpdwn">
                          <button type="button" data-toggle="dropdown">
                            <i class="material-icons"> more_vert </i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-right">
                          
                          <?php if(!empty($this->session->userdata('subadmin_edit_permissions')) && $this->session->userdata('subadmin_edit_permissions')=='1') { ?>
                            <a class="dropdown-item invoice_pos_list_item_vw_recept" id="edit-bt" href="<?php  echo site_url('subadmin/edit_subadmin/' . $a_data['id']) ?>">
                              <span class="fa fa-pencil"></span>  Edit
                            </a>

                          <?php } if(!empty($this->session->userdata('subadmin_delete_permissions')) && $this->session->userdata('subadmin_delete_permissions')=='1') { ?>
                           <a class="dropdown-item invoice_pos_list_item_vw_refund" href="#" onclick="subadmin_delete('<?php echo $a_data['id'];?>')">
                              <span class="fa fa-trash"></span>  Delete
                            </a>
                            <?php } ?>
                          </div>
                        </div>
                      </td>
                      <?php } ?>

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
<i class="glyphicon glyphicon-user"></i> Merchant Detail
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
function subadmin_delete(id)
    {
      if(confirm('Are you sure delete this Subadmin?'))
      {
          $.ajax({
            url : "<?php echo base_url('subadmin/subadmin_delete')?>/"+id,
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