<?php
	include_once 'header_dash.php';
	include_once 'sidebar_dash.php';
?>

<style>
	@media screen and (max-width: 480px) {
    	.d-flex {
    		display: block !important;
    	}
    }
    @media screen and (max-width: 640px) {
        .btn.social-btn-outlined i.medium {
            margin-right: 10px !important;
        }
    }
    .dataTables_empty {
        text-align: center !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0em 0.5em !important;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        border:none !important;
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Dashboard</h4> -->
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $i=1;
                            foreach($mem as $a_data) {
                                $count++; ?>
                                <tr>
                                    <td><?php echo $a_data['name'].' '.$a_data['last_name']; ?></td>
                                    <td><?php echo $a_data['email'] ?></td>
                                    <td><?php echo $a_data['mob_no'] ?></td>
                                    <td><?php echo $a_data['status'] ?></td>
                                    <td> 
                                        <div class="dropdown dt-vw-del-dpdwn" style="text-align: right;">
                                            <button type="button" data-toggle="dropdown">
                                                <i class="material-icons"> more_vert </i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item invoice_pos_list_item_vw_recept" id="edit-bt" href="<?php  echo site_url('dashboard/edit_agent/' . $a_data['id']) ?>">
                                                    <span class="fa fa-pencil"></span>  Edit
                                                </a>
                                                <a class="dropdown-item invoice_pos_list_item_vw_refund" href="#" onclick="subadmin_delete('<?php echo $a_data['id'];?>')">
                                                    <span class="fa fa-trash"></span>  Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var dtTransactionsConfig={
            "processing": true,
            // "sAjaxSource":"data.php",
            "order": [[ 4, "desc" ]],
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
            },
            "buttons": [{
                extend: 'collection',
                text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf'
                ]
            }]
        }
        $('#datatable').DataTable(dtTransactionsConfig);
    });

    function subadmin_delete(id) {
        if(confirm('Are you sure delete this Agent?')) {
            // console.log("<?php echo base_url('dashboard/subadmin_delete')?>/"+id);return false;
            $.ajax({
                url : "<?php echo base_url('dashboard/subadmin_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);return false;
                    var message = data.message;
                    window.location.replace('<?php echo base_url('dashboard/all_agent?success='); ?>'+message);
                    // location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }
</script>

<?php include_once'footer_dash.php'; ?>