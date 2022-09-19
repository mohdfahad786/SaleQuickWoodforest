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
                    <form method="post" action="<?php echo base_url('inventory_report/inventoryreport'); ?>" >
                        <input id="start_date2" name="start_date" type="hidden" value="">
                        <input id="end_date2" name="end_date" type="hidden" value="">
                        <input id="main_items1" name="main_items" type="hidden" value="">
                        <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="search_Submit" value="Search" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>PDF</button>
                    </form>

                    <form method="post" id="form_excel" action="<?php echo base_url('inventory_report/inventoryreport_ExcelDownload/') ?>">
                        <input id="start_date3" name="start_date" type="hidden" value="">
                        <input id="end_date3" name="end_date" type="hidden" value="">
                        <input id="main_items2" name="main_items" type="hidden" value="">
                        <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="excel_export" value="Excel" style="margin-right: 5px;"><i class="mdi mdi-arrow-down medium"></i>Excel</button>
                    </form>

                    <form method="post" id="form_csv" action="<?php echo base_url('inventory_report/inventoryreport_CSVDownload/') ?>">
                        <input id="start_date4" name="start_date" type="hidden" value="">
                        <input id="end_date4" name="end_date" type="hidden" value="">
                        <input id="main_items3" name="main_items" type="hidden" value="">
                        <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="excel_csv" value="CSV"><i class="mdi mdi-arrow-down small"></i>CSV</button>
                    </form>
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

    function makePDF() {
        $('body').addClass('p_recept');
        // window.scroll({ top: 0, left: 0 });
        var winW=$(window).width();
        $('#invoice-receipt-modal').scrollTop(0);
        var quotes = document.getElementById('invoicePdfData');
          html2canvas(quotes, {
            onrendered: function(canvas) {

            //! MAKE YOUR PDF
            var pdf = new jsPDF('p', 'pt', 'a4');

            for (var i = 0; i <= quotes.clientHeight/980; i++) {
              //! This is all just html2canvas stuff
              var srcImg  = canvas;
              var sX      = 0;
              var sY      = 980*i ; // start 980 pixels down for every new page
              var sWidth  = 900 ;
              var sHeight = 980;
              var dX      = 0;
              var dY      = 0 ;
              var dWidth  = 900;
              var dHeight = 980;

              window.onePageCanvas = document.createElement("canvas");
              onePageCanvas.setAttribute('width', 900);
              onePageCanvas.setAttribute('height', 980);
              var ctx = onePageCanvas.getContext('2d');
              // details on this usage of this function:
              // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
              ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);

              // document.body.appendChild(canvas);
              var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);

              var width         = onePageCanvas.width;
              var height        = onePageCanvas.clientHeight;

              //! If we're on anything other than the first page,
              // add another page
              if (i > 0) {
                pdf.addPage(612, 791); //8.5" x 11" in pts (in*72)
              }
              //! now we declare that we're working on that page
              pdf.setPage(i+1);
              //! now we add content to that page!
              pdf.addImage(canvasDataURL, 'PNG', 15, 15, (width*.62), (height*.62));
            }
            //! after the for loop is finished running, we save the pdf.
            pdf.save('receipt.pdf');
            $('body').removeClass('p_recept');
          }
        });
    }

    $(document).ready(function(){
        // $(document).on('click', '#export_csv', function() {
        //   var start_date = $('#start_date').val();
        //   var end_date = $('#end_date').val();
        //   var main_items = $('#main_items').val();
        //   var data = {
        //           "filter_data": [{
        //             'start_date': start_date,
        //             'end_date': end_date,
        //             'main_items': main_items
        //             }]
        //           };
        //   // console.log(data);
        //   $.ajax({
        //     url: "<?php echo base_url('pos/inventoryreport_CSVDownload/') ?>",
        //     data: data,
        //     method: 'POST',
        //     success: function(){
        //       window.open('<?php echo base_url('pos/inventoryreport_CSVDownload/') ?>','_blank' );
        //     }
        //   });
        // })
    })
</script>

<?php include_once'footer_dash.php'; ?>