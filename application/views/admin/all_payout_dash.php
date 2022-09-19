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
    .btn_custom_link {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        padding: .5rem .75rem;
        font-size: 1rem;
        line-height: 1.25;
        cursor: pointer;
        color: #000 !important;
        text-decoration: underline !important;
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
                                <th>Payout</th>
                                <th>Month / Year</th>
                                <!-- <th>Edit</th> -->
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
                                    <td><?php echo $a_data['name'] ?></td>
                                    <td><?php echo $a_data['email'] ?></td>
                                    <td><?php echo $a_data['mob_no'] ?></td>
                                    <td><?php echo '$'.$a_data['amount']; ?></td>
                                    <td><?php echo $a_data['month'] .'/'. $a_data['year']; ?></td>
                                    <td>
                                        <a class="btn_custom_link" id="edit-bt" href="<?php echo site_url('Agent/edit_payout_agent/' .$a_data['id'].'/'.$a_data['merchant_id']) ?>"><i class="fa fa-pencil"></i>  Edit</a>
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
                    'pdf',
                    'print'
                ]
            }]
        }
        $('#datatable').DataTable(dtTransactionsConfig);
    });
</script>

<?php include_once'footer_dash.php'; ?>