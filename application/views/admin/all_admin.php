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
    .btn_custom {
        height: 30px !important;
        max-height: 30px !important;
        padding: 4px 12px !important;
        text-transform: none !important;
        width: 85px !important;
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
                                <th>Username</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Status</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $i=1;
                            foreach($adminArr as $admin) {
                                $count++; ?>
                                <tr>
                                    <td><?php echo $admin['name']; ?></td>
                                    <td><?php echo $admin['username']; ?></td>
                                    <td><?php echo $admin['email_id']; ?></td>
                                    <td><?php echo ucfirst($admin['user_type']); ?></td>
                                    <td><?php echo ucfirst($admin['status']); ?></td>
                                    <td>
                                        <?php if($admin['id'] != '9') { ?>
                                            <a class="btn btn-sm btn-secondary btn_custom" href="<?php echo base_url('Multiadmin/edit_admin/'); ?><?php echo $admin['id']; ?>"><i class="fa fa-pencil"></i> Edit</a>
                                            <?php if($this->session->userdata('id') != $admin['id']) { ?>
                                                <a class="btn btn-sm btn-danger btn_custom" href="#" onClick="del_admin(<?php echo $admin['id'];?>)"><i class="fa fa-trash"></i> Delete</a>
                                            <?php } ?>
                                        <?php } ?>
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

<link rel="stylesheet" type="text/css" href="<?=base_url('new_assets/css/sweetalert.css')?>">
<script src="<?=base_url('new_assets/js/sweetalert.js')?>"></script>
<style type="text/css">
.sweet-alert .btn {
  padding: 5px 15px;
}
</style>

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

    function del_admin(id) {
        swal({
            title: "<span style='font-size: 21px;'>Are you sure, want to delete this Admin?</span>",
            text: "<span style='font-size: 16px;'>You will not be able to recover this info!</span>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn danger-btn",
            confirmButtonText: "Yes, remove it!",
            cancelButtonClass: "btn btn-first",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo base_url('Multiadmin/deleteAdmin')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if(data.status == '200'){
                            location.reload();
                        } else {
                            var msg = data.errorMsg;
                            $("#message_popup.modal-body").html(msg);
                            $("#message_popup").modal('show');
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            } else {

            }
        })
    }
</script>

<?php include_once'footer_dash.php'; ?>