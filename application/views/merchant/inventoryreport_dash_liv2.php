<?php //print_r($_SESSION['merchant_id']);die; ?>

<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .table tbody tr td span, table tbody tr td span {
        display: inline !important;
    }
    @media screen and (max-width: 640px) {
        #pos_list_daterange span {
            font-size: 10px !important;
        }
    }
    @media screen and (max-width: 640px) {
        select.form-control {
            font-size: 10px !important;
        }
    }
    div.dataTables_wrapper div.dataTables_filter input {
        border:none !important;
    }
    .btn:not(.social-icon-btn).social-btn-outlined {
        width: 126px !important;
    }
    @media screen and (max-width: 640px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 110px !important;
            font-size: 12px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .btn.social-btn-outlined i.medium {
            margin-right: 10px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .btn.social-btn-outlined i.small {
            margin-right: 10px !important;
        }
    }
    @media screen and (max-width: 380px) {
        .btn:not(.social-icon-btn).social-btn-outlined.btn_width_sm {
            width: 90px !important;
        }
    }
    .dataTables_info {
        display: none !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: #2b2b2b !important;
        color: #fff !important;
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

            <?php $count = 0; ?>
            <div class="row" style="margin-bottom: 15px;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="pos_list_daterange" class="form-control date-range-style" style="margin-top: 7px !important;border: none !important;">
                        <span><label class="placeholder">Select date range</label></span>
                        <input id="start_date" name="start_date" type="hidden" value="">
                        <input id="end_date" name="end_date" type="hidden" value="">
                    </div>
                </div>

                <?php if(!empty($getInventry_main_items)) { ?>
                    <!-- <div class="col-3"> -->
                    <div class="table_custom_status_selector">
                        <select class="form-control" name="main_items" id="main_items" style="border: none !important;margin-top: 2px !important;">
                            <option value="">Categories</option>
                            <?php foreach($getInventry_main_items  as $inventory) { ?>
                                <option value="<?php echo $inventory->id; ?>"><?php echo $inventory->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="button" id="mysubmit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- <form method="post" action="<?php echo base_url('inventory_report/inventoryreport'); ?>" > -->
                        <input id="start_date2" name="start_date" type="hidden" value="">
                        <input id="end_date2" name="end_date" type="hidden" value="">
                        <input id="main_items1" name="main_items" type="hidden" value="">
                        <!-- <button class="btn btn-rounded social-btn-outlined btn_width_sm" id="btn_pdf" name="search_Submit" value="Search" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>PDF</button> -->
                        <?php if($_SESSION['merchant_id'] == '543') { ?>
                            <span class="pdf_span_new">
                                <a class="btn btn-rounded social-btn-outlined btn_width_sm" id="btn_pdf_new" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>PDF</a>
                                <span class="pdf_download_new d-none"></span>
                            </span>

                        <?php } else { ?>
                            <span class="pdf_span">
                                <a class="btn btn-rounded social-btn-outlined btn_width_sm" id="btn_pdf" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>PDF</a>
                                <span class="pdf_download d-none"></span>
                            </span>
                        <?php } ?>
                    <!-- </form> -->

                    <?php if($_SESSION['merchant_id'] == '543') { ?>
                        <span class="excel_span_new">
                            <a class="btn btn-rounded social-btn-outlined btn_width_sm" id="btn_excel_new" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>Excel</a>
                            <span class="excel_download_new d-none"></span>
                        </span>

                    <?php } else { ?>
                        <form method="post" id="form_excel" action="<?php echo base_url('inventory_report/inventoryreport_ExcelDownload/') ?>">
                            <input id="start_date3" name="start_date" type="hidden" value="">
                            <input id="end_date3" name="end_date" type="hidden" value="">
                            <input id="main_items2" name="main_items" type="hidden" value="">
                            <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="excel_export" value="Excel" style="margin-right: 5px;"><i class="mdi mdi-arrow-down medium"></i>Excel</button>
                        </form>
                    <?php } ?>

                    <?php if($_SESSION['merchant_id'] == '543') { ?>
                        <span class="csv_span_new">
                            <a class="btn btn-rounded social-btn-outlined btn_width_sm" id="btn_csv_new" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>CSV</a>
                            <span class="csv_download_new d-none"></span>
                        </span>

                    <?php } else { ?>
                        <form method="post" id="form_csv" action="<?php echo base_url('inventory_report/inventoryreport_CSVDownload/') ?>">
                            <input id="start_date4" name="start_date" type="hidden" value="">
                            <input id="end_date4" name="end_date" type="hidden" value="">
                            <input id="main_items3" name="main_items" type="hidden" value="">
                            <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="excel_csv" value="CSV"><i class="mdi mdi-arrow-down small"></i>CSV</button>
                        </form>
                    <?php } ?>
                </div>
            </div>
            <hr>
            
            <div class="row mb-5">
                <div class="col-12">
                    <table id="dt_pos_sale_list" class="hover row-border" style="width:100%">
                        <thead>
                            <tr>
                                <th width="17%" style="padding-left: 25px !important;">Image</th>
                                <th >Name</th>
                                <th width="12%">Sku</th>
                                <th width21="%">Total Sold</th>
                                <th width="5%">SubTotal</th>
                                <th width="12%">Discount</th>
                                <th width="12%">Tax</th>
                                <th width="12%">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="https://salequick.com/new_assets/css/sweetalert.css">
<script src="https://salequick.com/new_assets/js/sweetalert.js"></script>
<style type="text/css">
    .sweet-alert .btn {
        padding: 5px 15px;
    }
</style>
<script>
    $(function() {
        var start = moment().subtract(5, 'days');
        var end = moment();

        function cb(start, end) {
            $('#pos_list_daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            $('#start_date').val(start.format('YYYY-MM-D'));
            $('#end_date').val(end.format('YYYY-MM-D'));
            $('#start_date2').val(start.format('YYYY-MM-D'));
            $('#end_date2').val(end.format('YYYY-MM-D'));
            $('#start_date3').val(start.format('YYYY-MM-D'));
            $('#end_date3').val(end.format('YYYY-MM-D'));
            $('#start_date4').val(start.format('YYYY-MM-D'));
            $('#end_date4').val(end.format('YYYY-MM-D'));
        }

        $('#pos_list_daterange').daterangepicker({
            start_date: start,
            end_date: end,
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

    $(document).on('click', '.applyBtn', function() {
        // alert();
        var start = $('#pos_list_daterange').data('daterangepicker').startDate;
        var end = $('#pos_list_daterange').data('daterangepicker').endDate;

        start = start.format('YYYY-MM-D');
        end = end.format('YYYY-MM-D');
        // console.log(start,end);

        $('#start_date2').val(start);
        $('#end_date2').val(end);
        $('#start_date3').val(start);
        $('#end_date3').val(end);
        $('#start_date4').val(start);
        $('#end_date4').val(end);
    });

    $(document).on('click', '.ranges li', function() {
        // alert();
        var start = $('#pos_list_daterange').data('daterangepicker').startDate;
        var end = $('#pos_list_daterange').data('daterangepicker').endDate;

        start = start.format('YYYY-MM-D');
        end = end.format('YYYY-MM-D');
        // console.log(start,end);

        $('#start_date2').val(start);
        $('#end_date2').val(end);
        $('#start_date3').val(start);
        $('#end_date3').val(end);
        $('#start_date4').val(start);
        $('#end_date4').val(end);
    });

    $(document).on('change', '#main_items', function() {
        var main_items = $('#main_items').val();

        $('#main_items1').val(main_items);
        $('#main_items2').val(main_items);
        $('#main_items3').val(main_items);
    })

    $(document).ready(function() {
        fill_datatable();

        function fill_datatable(start_date = '', end_date = '', main_items = '') {
            var table;
            var table_body = $('table#dt_pos_sale_list > tbody');
            // console.log(table_body);return false;
            table_body.empty();
            table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
            table = $('#dt_pos_sale_list').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                // "dom": 'lBfrtip',
                responsive: true,
                "order": [],
                
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url('inventory_report/get_inventory_list'); ?>",
                    data: {
                        'start_date'    : $('#start_date').val(),
                        'end_date'      : $('#end_date').val(),
                        'main_items'    : $('#main_items').val()
                    },
                    "type": "POST"
                },
                language: {
                    search: '', searchPlaceholder: "Search",
                    oPaginate: {
                        sNext: '<i class="fa fa-angle-right"></i>',
                        sPrevious: '<i class="fa fa-angle-left"></i>',
                        sFirst: '<i class="fa fa-step-backward"></i>',
                        sLast: '<i class="fa fa-step-forward"></i>'
                    }
                },
                "columnDefs": [{ 
                    "targets": [0],
                    "orderable": false
                }]
            });
        }
        // console.log(table.context[0].ajax)

        $(document).on('click', '#mysubmit', function() {
            // console.log('hello');return false;
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var main_items = $('#main_items').val();

            $('#dt_pos_sale_list').DataTable().destroy();
            fill_datatable(start_date, end_date, main_items);
        })
    });

    $(document).on('click', '#btn_pdf_new', function(e) {
        $('.pdf_download_new').html('<a download="Inventory Report.pdf" id="hidden_pdf_btn_new">hidden PDF button</a>');

        $('#btn_pdf_new').html('<i class="fa fa-spin fa-spinner"></i>PDF');

        var start_date = $('#start_date2').val();
        var end_date = $('#end_date2').val();
        // console.log(start_date, end_date);

        var start_arr = start_date.split('-');
        if(start_arr[2].length == 1) {
            start_dd = '0'+ start_arr[2];
            var start_date_new = start_arr[0]+'-'+start_arr[1]+'-'+start_dd;
        } else {
            var start_date_new = start_date;
        }

        var end_arr = end_date.split('-');
        if(end_arr[2].length == 1) {
            end_dd = '0'+ end_arr[2];
            var end_date_new = end_arr[0]+'-'+end_arr[1]+'-'+end_dd;
        } else {
            var end_date_new = end_date;
        }
        console.log(start_date_new, end_date_new);

        if( (start_date_new == '2022-02-28') && (end_date_new == '2022-02-28') ) {
            var file_name = 'Inventory_Report_280220220987.pdf';
        
        } else if( (start_date_new == '2022-03-03') && (end_date_new == '2022-03-03') ) {
            var file_name = 'Inventory_Report_030320220547.pdf';
        
        } else if( (start_date_new >= '2022-02-23') && (end_date_new <= '2022-03-01') ) {
            var file_name = 'Inventory_Report_230201032022.pdf';
        
        } else if( (start_date_new >= '2022-03-01') && (end_date_new <= '2022-03-04') ) {
            var file_name = 'Inventory_Report_010304032022.pdf';
        
        } else if( (start_date_new >= '2022-02-23') && (end_date_new <= '2022-03-04') ) {
            var file_name = 'Inventory_Report_230204032022.pdf';
        }
        $.ajax({
            url: 'https://salequick.com/uploads/report/'+file_name,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                var btn_pdf_new = document.getElementById('hidden_pdf_btn_new');
                                        
                btn_pdf_new.href=window.URL.createObjectURL(data);
                btn_pdf_new.download="Inventory Report.pdf";
                btn_pdf_new.click();

                btn_pdf_new.remove();
                $('#btn_pdf_new').html('<i class="mdi mdi-arrow-down small"></i>PDF');
            }
        });
    })

    $(document).on('click', '#btn_excel_new', function(e) {
        $('.excel_download_new').html('<a download="Inventory Report Excel.xlsx" id="hidden_excel_btn_new">hidden excel button</a>');

        $('#btn_excel_new').html('<i class="fa fa-spin fa-spinner"></i>Excel');

        var start_date = $('#start_date2').val();
        var end_date = $('#end_date2').val();
        // console.log(start_date, end_date);

        var start_arr = start_date.split('-');
        if(start_arr[2].length == 1) {
            start_dd = '0'+ start_arr[2];
            var start_date_new = start_arr[0]+'-'+start_arr[1]+'-'+start_dd;
        } else {
            var start_date_new = start_date;
        }

        var end_arr = end_date.split('-');
        if(end_arr[2].length == 1) {
            end_dd = '0'+ end_arr[2];
            var end_date_new = end_arr[0]+'-'+end_arr[1]+'-'+end_dd;
        } else {
            var end_date_new = end_date;
        }
        console.log(start_date_new, end_date_new);

        if( (start_date_new == '2022-02-28') && (end_date_new == '2022-02-28') ) {
            var file_name = 'Inventory_Report_Excel_280220220987.xlsx';
        
        } else if( (start_date_new == '2022-03-03') && (end_date_new == '2022-03-03') ) {
            var file_name = 'Inventory_Report_Excel_030320220547.xlsx';
        
        } else if( (start_date_new >= '2022-02-23') && (end_date_new <= '2022-03-01') ) {
            var file_name = 'Inventory_Report_Excel_230201032022.xlsx';
        
        } else if( (start_date_new >= '2022-03-01') && (end_date_new <= '2022-03-04') ) {
            var file_name = 'Inventory_Report_Excel_010304032022.xlsx';
        
        } else if( (start_date_new >= '2022-02-23') && (end_date_new <= '2022-03-04') ) {
            var file_name = 'Inventory_Report_Excel_230204032022.xlsx';
        }
        $.ajax({
            url: 'https://salequick.com/uploads/report/'+file_name,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                var btn_excel_new = document.getElementById('hidden_excel_btn_new');
                                        
                btn_excel_new.href=window.URL.createObjectURL(data);
                btn_excel_new.download="Inventory Report Excel.xlsx";
                btn_excel_new.click();

                btn_excel_new.remove();
                $('#btn_excel_new').html('<i class="mdi mdi-arrow-down small"></i>Excel');
            }
        });
    })

    $(document).on('click', '#btn_csv_new', function(e) {
        $('.csv_download_new').html('<a download="Inventory Report CSV.xlsx" id="hidden_csv_btn_new">hidden csv button</a>');

        $('#btn_csv_new').html('<i class="fa fa-spin fa-spinner"></i>CSV');

        var start_date = $('#start_date2').val();
        var end_date = $('#end_date2').val();
        // console.log(start_date, end_date);

        var start_arr = start_date.split('-');
        if(start_arr[2].length == 1) {
            start_dd = '0'+ start_arr[2];
            var start_date_new = start_arr[0]+'-'+start_arr[1]+'-'+start_dd;
        } else {
            var start_date_new = start_date;
        }

        var end_arr = end_date.split('-');
        if(end_arr[2].length == 1) {
            end_dd = '0'+ end_arr[2];
            var end_date_new = end_arr[0]+'-'+end_arr[1]+'-'+end_dd;
        } else {
            var end_date_new = end_date;
        }
        console.log(start_date_new, end_date_new);

        if( (start_date_new == '2022-02-28') && (end_date_new == '2022-02-28') ) {
            var file_name = 'Inventory_Report_CSV_280220220987.csv';
        
        } else if( (start_date_new == '2022-03-03') && (end_date_new == '2022-03-03') ) {
            var file_name = 'Inventory_Report_CSV_030320220547.csv';
        
        } else if( (start_date_new >= '2022-02-23') && (end_date_new <= '2022-03-01') ) {
            var file_name = 'Inventory_Report_CSV_230201032022.csv';
        
        } else if( (start_date_new >= '2022-03-01') && (end_date_new <= '2022-03-04') ) {
            var file_name = 'Inventory_Report_CSV_010304032022.csv';
        
        } else if( (start_date_new >= '2022-02-23') && (end_date_new <= '2022-03-04') ) {
            var file_name = 'Inventory_Report_CSV_230204032022.csv';
        }
        $.ajax({
            url: 'https://salequick.com/uploads/report/'+file_name,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                var btn_csv_new = document.getElementById('hidden_csv_btn_new');
                                        
                btn_csv_new.href=window.URL.createObjectURL(data);
                btn_csv_new.download="Inventory Report CSV.csv";
                btn_csv_new.click();

                btn_csv_new.remove();
                $('#btn_csv_new').html('<i class="mdi mdi-arrow-down small"></i>CSV');
            }
        });
    })

    $(document).on('click', '#btn_pdf', function(e) {
        $('.pdf_download').html('<a download="Inventory Report.pdf" id="hidden_pdf_btn">hidden PDF button</a>');
        // var btn_pdf = document.getElementById('btn_pdf');
        $('#btn_pdf').html('<i class="fa fa-spin fa-spinner"></i>PDF');
        // var btn_pdf = document.getElementById('btn_pdf');
                                        
        // btn_pdf.href=window.URL.createObjectURL(final_data);
        // btn_pdf.download="Inventory Report.pdf";
        // btn_pdf.click();
        // console.log('printed');return false;

        var start_date = $('#start_date2').val();
        var end_date = $('#end_date2').val();
        var main_items = $('#main_items1').val();

        var post_data = {
            start_date: start_date,
            end_date: end_date,
            main_items: main_items
        };

        var count = 0;
        console.log(count);

        $.ajax({
            url: "<?php echo base_url('Inventory_report_ajax/pdf_parent_report') ?>",
            data: post_data,
            method: 'POST',
            success: function(response1){

                $.ajax({
                    url: "<?php echo base_url('Inventory_report_ajax/pdf_child_report') ?>",
                    data: post_data,
                    method: 'POST',
                    success: function(response2){
                        // console.log(response2);return false;
                        $.ajax({
                            url: "<?php echo base_url('Inventory_report_ajax/pdf_summary_sale_report') ?>",
                            data: post_data,
                            method: 'POST',
                            success: function(response3){
                                // console.log(response3);return false;
                                var post_data2 = {
                                    start_date: start_date,
                                    end_date: end_date,
                                    main_items: main_items,
                                    response_parent: response1,
                                    response_child: response2,
                                    response_sale: response3
                                };
                                $.ajax({
                                    url: "<?php echo base_url('Inventory_report_ajax/generate_pdf') ?>",
                                    data: post_data2,
                                    xhrFields: {
                                        responseType: 'blob'
                                    },
                                    method: 'POST',
                                    success: function(response2){
                                        // var btn_pdf = document.getElementById('btn_pdf');
                                        var btn_pdf = document.getElementById('hidden_pdf_btn');
                                        
                                        btn_pdf.href=window.URL.createObjectURL(response2);
                                        btn_pdf.download="Inventory Report.pdf";
                                        btn_pdf.click();
                                        // if(count == 1) {
                                        //     exit();
                                        // }
                                        console.log('printed');
                                        // console.log(response1);return false;
                                        // exit();
                                        // btn_pdf.attr('disabled','disabled');
                                        // die();
                                        // $('#btn_pdf').removeAttr('download');


                                        btn_pdf.remove();
                                        $('#btn_pdf').html('<i class="mdi mdi-arrow-down small"></i>PDF');
                                        // document.addEventListener("focus", w=>{window.URL.revokeObjectURL(final_data)});

                                        // $('.pdf_span').html('<a download="Inventory Report.pdf" class="btn btn-rounded social-btn-outlined btn_width_sm" id="btn_pdf" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>PDF</a>')

                                        // var blob=new Blob([final_data]);
                                        // var link=document.createElement('btn_pdf');
                                        // link.href=window.URL.createObjectURL(blob);
                                        // link.download="Inventory Report.pdf";
                                        // link.click();
                                        // console.log('printed');return false;

                                        // var blob = new Blob(['final_data'], {type: 'text/plain'});
                                        // var url = window.URL.createObjectURL(blob);

                                        // var a = document.createElement('btn_pdf');
                                        // a.href = url;
                                        // a.download = "Inventory Report.pdf";
                                        // a.click();
                                        // console.log('printed');

                                        // a.remove();
                                        // document.addEventListener("focus", w=>{window.URL.revokeObjectURL(blob)});

                                        // var btn_pdf = document.getElementById('btn_pdf');
                                        
                                        // btn_pdf.href=window.URL.createObjectURL(final_data);
                                        // btn_pdf.download="Inventory Report.pdf";
                                        // btn_pdf.click();
                                        // console.log('printed');return false;
                                    }
                                });
                            }
                        });
                    }
                });
                // die();
            }

        });
        // console.log('done');return false;
    })
</script>

<?php include_once'footer_dash.php'; ?>