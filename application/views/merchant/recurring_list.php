<?php
    include_once'header_rec_list.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
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
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span></span>
                        <input name="start_date" id="start_date" type="hidden">
                        <input name="end_date" id="end_date" type="hidden" >
                    </div>
                </div>
                <div class="table_custom_status_selector">
                    <select class="form-control"  name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <option value="confirm">Complete</option>
                        <option value="pending">Good Standing</option>
                        <option value="late">Late</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" id="btn-filter" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table id="recurring_list" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th width="9%">Amount</th>
                                <th width="8%">Status</th>
                                <th width="15%">Start Date</th>
                                <th width="15%">Next Payment Date</th>
                                <th width="15%">End Date</th>
                                <th width="18%">Completed/Upcomming</th>
                                <th data-priority="1">Recurring</th>
                                <th width="8%">Payment type</th>
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
        var start = moment().subtract(29, 'days');
        // var start = moment().subtract(30, 'days');
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
        // console.log($('#start_date').val(), $('#end_date').val());return false
        var table_body = $('table#recurring_list > tbody');
        table_body.empty();
        table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
        table = $('#recurring_list').DataTable({
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
                "url": "<?= base_url('Recurring_serverside')?>",
                "type": "POST",
                "data": function ( data ) {
                    // console.log(data)
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
                    data.status = $('#status').val();
                }
            },
            preDrawCallback: function(settings) {
                if ($.fn.DataTable.isDataTable('#recurring_list')) {
                    var dt = $('#recurring_list').DataTable();

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
    });

    $(document).on('click', '.payment_clear_btn', function() {
        alert('Your All Dues are Clear and Payment complete!');
    })

    function stop_pak(id) {
        if(confirm('Are you sure Stop Recurring?')) {
            $.ajax({
                url : "<?php echo base_url('merchant/stop_recurring')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    location.reload(); 
                    // $('#sidebar-menu ul.sub-menu  a.allCustomerRecur').trigger('click');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error data');
                }
            });
        }
    }

    function start_pak(id) {
        if(confirm('Are you sure Start Recurring?')) {
            $.ajax({
                url : "<?php echo base_url('merchant/start_recurring')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    location.reload(); 
                    // $('#sidebar-menu ul.sub-menu  a.allCustomerRecur').trigger('click');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }
    
    jQuery(document).on('click','.transaction_recur_vw_btn',function(e) {
        console.log('clicked-lined')
        // stop - start
        e.preventDefault();
        var uid = $(this).data('id');   // it will get id of clicked row
        $('#transRecur-modal').modal('show');
        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader
        $.ajax({
            url: "<?php  echo base_url('merchant/search_record_payment'); ?>",
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            // console.log(data);    
            $('#dynamic-content').html(data); // load response 
            $('#modal-loader').hide();      // hide ajax loader 
        })
        .fail(function(){
            $('#dynamic-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again.');
            $('#modal-loader').hide();
        });
    })

    $(document).on('click', '.start_stop_tax,.start_stop_tax input[type="checkbox"]', function (e) {
        // stop - start
        e.preventDefault();
        if($(this).closest('.start_stop_tax').hasClass('active')){
            stop_pak($(this).closest('.start_stop_tax').attr('rel'));
        } else {
            start_pak($(this).closest('.start_stop_tax').attr('rel'));
        }
    })
</script>

<?php include_once'footer_dash.php'; ?>