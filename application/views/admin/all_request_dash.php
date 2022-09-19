<?php
	include_once 'header_dash.php';
	include_once 'sidebar_dash.php';
?>

<style>
	@media screen and (max-width: 640px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 110px !important;
            font-size: 12px !important;
        }
        .summary-grid-img {
		    width: 35px;
		    height: 35px;
		}
		.head-count-val {
			font-size: 25px !important;
		}
		.summary-grid-status {
			font-size: 16px;
		}
		.summary-grid-text-section {
			height: 45px;
		}
    }
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
    #allSupportExport{
        position: absolute;
        right: 15px;
    }
    #allSupportExport button.dt-button.buttons-collection{
        margin: 0 !important
    }
    #allSupportExport.reset-dataTable .dt-buttons {
        padding-top: 0px;
    }
    #allSupportExport table{
        display: none;
        width: 100%;
    }
    #allSupportExport div.dt-button-collection{
        left: auto !important;
        right: 0;
        display: block;
        margin-top: 0px !important;
    }
    /*.form_buttons {
        text-align: left !important;
        display: flex !important;
    }*/
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

            <form class="row" method="post" action="<?php echo base_url('customer/all_request'); ?>" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" id="startDate" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>" >
                        <input name="end_date" id="endDate" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
                <div class="col form_buttons" style="text-align: right;">
                    <div id="allSupportExport" class="reset-dataTable"></div>
                </div>
            </form>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Estimated Monthly Volume</th>
                                <th>Date Time</th>
                                <th>Action</th>
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
                                    <td><?php echo $a_data['phone'] ?></td>
                                    <td><?php echo $a_data['email'] ?></td>
                                    <td><?php echo $a_data['estimatedmonthluvolume'] ?></td>
                                    <td><?php echo $a_data['add_date'] ?></td>
                                    <td><button class="btn btn-sm btn-danger" onclick="merchant_delete(<?php echo $a_data['id'];?>)"><i class="fa fa-trash"></i></button></td>
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

<script>
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#daterangeFilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // console.log(start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));
            $('#startDate').val(start.format('YYYY-MM-D'));
            $('#endDate').val(end.format('YYYY-MM-D'));
        }

        $('#daterangeFilter').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });
    
    $(document).ready(function() {
        var dtTransactionsConfig = {
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

    function merchant_delete(id) {
        if(confirm('Are you sure delete this data?')) {
            $.ajax({
                url : "<?php echo base_url('customer/subadmin_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }
</script>

<?php include_once 'footer_dash.php'; ?>