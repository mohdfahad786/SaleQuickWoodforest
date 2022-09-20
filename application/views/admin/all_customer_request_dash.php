<?php
	include_once 'header_dash.php';
	include_once 'sidebar_dash.php';
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Pragma: no-cache');
?>
<link href="https://salequick.com/new_assets/css/select2.min.css" rel="stylesheet" type="text/css">
<style>
	@media screen and (max-width: 640px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 110px !important;
            font-size: 12px !important;
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
    .dataTables_empty {
        text-align: center !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0em 0.5em !important;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        border:none !important;
    }
    #dynamic-content table.table>thead>tr>th {
        background: #f1f1f1 !important;
    }
    #dynamic-content table.table>tbody>tr>td {
        background-color: #fff !important;
        border-bottom-color: #f1f1f1 !important;
    }
    .dt-vw-del-dpdwn {
        text-align: right !important;
    }
    div.dataTables_wrapper div.dataTables_processing {
        display: none !important;
    }
    .select2.select2-container .select2-selection--single {
        background-color: transparent !important;
    }
    .select2-container--default .select2-selection--single {
        border: none !important;
    }
    .select2-container .select2-selection .select2-selection__rendered {
        line-height: 27px !important;
        color: rgb(110, 110, 110) !important;
        font-family: Avenir-Heavy !important;
    }
    .custom_employee_selector {
        width: 130px !important;
        margin-right: 10px;
    }
    .form-control {
        line-height: 1.5 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        top: 70% !important;
        border-width: 5px 6px 0 6px !important;
        background: url(<?php echo base_url().'new_assets/img/arrowD.png' ?>);
        background-repeat: no-repeat;
        background-color: transparent;
        background-position: center right;
        background-size: 18px auto;
        padding-right: 35px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-style: none !important;
        position: initial !important;
        background-position: bottom !important;
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
                <div class="col-12 py-5-custom"></div>
            </div>

            <div class="row" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo (date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))) ?>
                        </span>
                        <input name="start_date" id="start_date" type="hidden">
                        <input name="end_date" id="end_date" type="hidden">
                    </div>
                </div>
                <div class="custom_employee_selector">
                    <?php $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active' , 'user_type' => 'merchant'));  ?>
                    
                    <select name="employee" class="form-control selectOption" id="employee" style="background-color: #f5f5fb !important;border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option  value="" >All Merchant</option>
                        <?php foreach ($data as $view) { ?>
                            <option  value="<?php echo $view['id']; ?>"><?php if(empty($view['business_dba_name'])){echo $view['name'];} else {echo $view['business_dba_name'];} ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="table_custom_status_selector">
                    <select class="form-control"  name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <option value="pending" <?php if( isset($status) && $status=='pending'){ echo 'selected';} ?> >Pending</option>
                        <option value="confirm" <?php if( isset($status) && $status=='confirm') { echo 'selected'; } ?> >Confirm</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" id="btn-filter" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Generated on </th> 
                                <th>Transaction id</th>
                                <th>Card Type</th>
                                <th>Merchant </th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Payment Date</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
                <h4 class="modal-title"><i class="glyphicon glyphicon-user"></i> Payment Detail</h4>
            </div>
            <div class="modal-body">
                <div id="modal-loader" class="text-center" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
                </div>
                <div id="dynamic-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
        $('.selectOption').select2();
    })
    function dateFormatter(date) {
        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = year+'-'+month+'-'+day;
        return date;
    };

	$(function() {
        moment.tz.setDefault("America/Chicago");
	    var start = moment().subtract(29, 'days');
	    var end = moment();

	    function cb(start, end) {
	        $('#daterangeFilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	        
            $('#start_date').val(start.format('YYYY-MM-D'));
	        $('#end_date').val(end.format('YYYY-MM-D'));
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

    var table;
    $(document).ready(function() {
        var table_body = $('table#datatable > tbody');
        table_body.empty();
        table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
        table = $('#datatable').DataTable({
            pagingType: 'full_numbers',
            "pageLength": 25,
            "processing": true,
            "serverSide": true,
            "order": [[6,'desc']], //Initial no order.
            responsive: true, 
            dom: 'lBfrtip',
            language: {
                search: '', searchPlaceholder: "Search",
                oPaginate: {
                    sNext: '<i class="fa fa-angle-right"></i>',
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                }
            },
            buttons: [{
                extend: 'collection',
                text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }],
            "ajax": {
                "url": "<?=site_url('dashboard/invoice_list')?>",
                "type": "POST",
                "data": function ( data ) {
                    // console.log(data)
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
                    data.status = $('#status').val();
                    data.merchant_id = $('#employee').val();
                }
            },
            preDrawCallback: function(settings) {
                if ($.fn.DataTable.isDataTable('#datatable')) {
                    var dt = $('#datatable').DataTable();

                    //Abort previous ajax request if it is still in process.
                    var settings = dt.settings();
                    if (settings[0].jqXHR) {
                        settings[0].jqXHR.abort();
                    }
                }
            },
            drawCallback: function(){
                $('.paginate_button:not(.disabled):not(.active)', this.api().table().container())
                .on('click', function(){
                    table_body.empty();
                    table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
                });
            }
        });
        
        $('#btn-filter').click(function(){
            table_body.empty();
            table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
            table.ajax.reload();
        });
        
        $('#btn-reset').click(function(){ //button reset event click
            $('#form-filter')[0].reset();
            table.ajax.reload();  //just reload table
        });

        $(document).on("keyup", "input[type=search]", function (event) {
            var key = event.keyCode;
            // console.log(key);return false;
            if(key == 16) {
                console.log(key);return false;
            } else if(key == 17) {
                console.log(key);return false;
            } else if(key == 18) {
                console.log(key);return false;
            } else if(key == 9) {
                console.log(key);return false;
            } else {
                table_body.empty();
                table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
            }
        })

        $(document).on('click', '.getUser', function(e){
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#dynamic-content').html(''); // leave it blank before ajax call
            $('#modal-loader').show();      // load ajax loader
            $.ajax({
                url: "<?php echo base_url('dashboard/search_record_column1'); ?>",
                type: 'POST',
                data: 'id='+uid,
                dataType: 'html'
            })
            .done(function(data){
                // console.log(data);
                $('#dynamic-content').html('');
                $('#dynamic-content').html(data); // load response
                $('#modal-loader').hide();      // hide ajax loader
            })
            .fail(function(){
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader').hide();
            });
        });

        $(document).on('click', '#getUserrecurring', function(e){
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#dynamic-content').html(''); // leave it blank before ajax call
            $('#modal-loader').show();      // load ajax loader
            $.ajax({
                url: "<?php echo base_url('merchant/search_record_column_recurring'); ?>",
                type: 'POST',
                data: 'id='+uid,
                dataType: 'html'
            })
            .done(function(data){
                // console.log(data);
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

<?php include_once'footer_dash.php'; ?>
<script src="https://salequick.com/new_assets/js/select2.min.js"></script>