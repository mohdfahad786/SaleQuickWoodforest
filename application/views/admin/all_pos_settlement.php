<?php
    include_once 'header_dash.php';
    include_once 'sidebar_dash.php';
  //  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  //header('Pragma: no-cache');
?>

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
    .dt-vw-del-dpdwn {
        text-align: right !important;
    }
    div.dataTables_wrapper div.dataTables_processing {
        display: none !important;
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

            <div id="form_div" class="row" style="margin-bottom: 20px !important;">
            <!-- <form class="row" method="post" action="<?php echo base_url('dashboard/report'); ?>" style="margin-bottom: 20px !important;"> -->
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo (date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))) ?>
                        </span>
                        <input name="start_date" id="start_date" type="hidden">
                        <input name="end_date" id="end_date" type="hidden" >
                    </div>
                </div>
                <div class="table_custom_status_selector">
                    <select class="form-control"  name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <option value="confirm">Paid</option>
                        <option value="Chargeback_Confirm">Refunded</option>
                        <option value="pending">Declined</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" id="btn-filter" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            <!-- </form> -->
            </div>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table id="pos_list" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Card Type</th>
                                <th>Merchant</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
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
                <h4 class="modal-title">
                    <i class="glyphicon glyphicon-user"></i> Payment Detail
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
        
        moment.tz.setDefault("America/Chicago");
        var start = moment().subtract(2, 'days');
        var end = moment();
        // console.log(start,end);

        function cb(start, end) {
            $('#daterangeFilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            $('#start_date').val( start.format('YYYY-MM-D') );
            $('#end_date').val( end.format('YYYY-MM-D') );
        }

        $('#daterangeFilter').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              
            }
        }, cb);

        cb(start, end);
    });

    var table;
    $(document).ready(function() {
        // console.log($('#start_date').val(), $('#end_date').val());return false
        var table_body = $('table#pos_list > tbody');
        table_body.empty();
        table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
        table = $('#pos_list').DataTable({
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
                "url": "<?=site_url('settlement_list/pos_list')?>",
                "type": "POST",
                "data": function ( data ) {
                    // console.log(data)
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
                    data.status = $('#status').val();
                }
            },
            preDrawCallback: function(settings) {
                if ($.fn.DataTable.isDataTable('#pos_list')) {
                    var dt = $('#pos_list').DataTable();

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
        // $("div#form_div").reset();
        //$("div#form_div").find('input:text').val('');
        // console.log($("div#form_div"));
        // console.log(dateFormatter($('#start_date').val()),dateFormatter($('#end_date').val()));
        
        $('#btn-filter').click(function(){
            table_body.empty();
            table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
            table.ajax.reload();
            // $("#form_div")[0].reset();
           // $("div#form_div").find('input:text').val('');
        });
        
        $('#btn-reset').click(function(){
            $('#form-filter')[0].reset();
            table.ajax.reload();
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

        $(document).on('click', '#getUser', function(e){
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#dynamic-content').html(''); // leave it blank before ajax call
            $('#modal-loader').show();      // load ajax loader
            $.ajax({
                url: "<?php echo site_url('Admin/search_record_column_pos'); ?>",
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
                url: "<?php echo base_url('admin/search_record_column_recurring'); ?>",
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