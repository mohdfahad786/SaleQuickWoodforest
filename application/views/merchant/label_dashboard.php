<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<?php  
    $last_date = date("Y-m-d",strtotime("-10 days"));
    $date = date("Y-m-d");
    $merchant_id = $this->session->userdata('merchant_id');
    $t_fee = $this->session->userdata('t_fee');
?>

<script type="text/javascript"> 
    var userprefs = {
        goal: 'all',
        employee: 'all',
        merchant: '<?php echo $merchant_id; ?>',
        fee: '<?php echo $t_fee; ?>',
        metric1: 'amount',
        metric2: 'conversions',
        units: 'days',
        start: moment().subtract(10, 'days'),
        end: moment(),
        timezone: 'America/New_York',
        plan_id: 3
    };
</script>

<style type="text/css">
    #saleChart g.highcharts-series.highcharts-series-0,#saleChart  g.highcharts-series.highcharts-series-2,#saleChart  g.highcharts-markers.highcharts-series-0,#saleChart  g.highcharts-markers.highcharts-series-2,#saleChart  .highcharts-series-group >path:nth-child(1),#saleChart  .highcharts-series-group >path:nth-child(3) {
        opacity: 0;
    }
    .apexcharts-legend-marker {
        height: 10px !important;
        width: 30px !important;
    }
    .apexcharts-legend-text span {
        font-size: 22px;
    }
    .order_chart_tiles {
        width: 100%;
        display: flex;
        margin-left: 15px;
    }
    .order-left {
        width: 40px;
        height: 90px;
    }
    .order-line-color {
        height: 6px;
        width: 19px;
        border-radius: 10px;
        margin-top: 9px;
    }
    .order-right {
        width: 200px;
        height: 90px;
    }
    .order-series-name {
        font-size: 18px;
        color: rgb(148, 148, 146);
        margin-bottom: 0px !important;
        font-family: AvenirNext-Medium;
    }
    .order-series-percent {
        color: rgb(80, 93, 111);
        margin-bottom: 0px !important;
        font-size: 23px;
        font-weight: 600;
        font-family: Avenir-Heavy;
    }
    .order-series-count {
        font-size: 18px;
        color: rgb(148, 148, 146);
        font-family: AvenirNext-Medium;
    }

    @media screen and (max-width: 1220px) {
        .summary-grid-text-section {
            width: 80px;
            height: 60px;
        }
        .grid-summary {
            border-radius: 15px !important;
        }
    }
    @media screen and (min-width: 1221px) {
        .summary-grid-text-section {
            width: 110px;
            height: 52px;
        }
        .grid-summary {
            border-radius: 15px !important;
        }
    }
    @media screen and (max-width: 1349px) {
        .summary-grid-text {
            font-size: 11px !important;
        }
    }
    .summary-grid-text {
        font-family: AvenirNext-Medium !important;
        font-weight: 500;
        color: rgb(184, 184, 184);
        font-size: 12px;
    }
    .summary-grid-status {
        font-size: 18px;
        color: rgb(62, 62, 62);
        font-weight: 600;
        font-family: Avenir-Heavy !important;
        margin-bottom: 0px !important;
    }
    .summary-grid-img-section {
        width: 54px;
        height: 54px;
        margin-top: 5px;
    }
    .summary-grid-img {
        width: 54px;
        height: 54px;
    }
    .summary-transaction-count {
        width: 100%
    }
    .head-count-val {
        color: #000 !important;
        font-family: Avenir-Black;
        font-weight: 600 !important;
        font-size: 41px !important;
    }
    @media screen and (min-width: 720px) {
        .summary-grid-padding {
            padding-right: 7.5px !important;
        }
    }
    .top_grid_effect:hover {
        -webkit-box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        -moz-box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        /*box-shadow: rgba(102, 102, 102, 0.09) 0 0 15px;*/
        opacity: 1;
        transition-timing-function: ease;
    }
    .top_grid_link {
        background-color: #4c6ef5;
        padding: 2px 10px;
        border-radius: 10px;
    }
    .top_grid_btn {
        background-color: #4c6ef5;
        border-radius: 10px;
        border: none !important;
        padding: 0px 10px;
    }
    .grid_text_col {
        max-width: calc(100% - 65px) !important;
        padding-right: 0px !important;
    }
    
    /*grid-summary css < 500px width*/
    @media screen and (max-width: 460px) {
        .summary-grid-img {
            width: 36px;
            height: 36px;
        }
        .summary-grid-img-section {
            width: 36px;
            height: 36px;
            margin-top: 0px;
        }
        .summary-grid-text-section {
            width: auto;
            height: 45px;
        }
        .head-count-val {
            font-family: AvenirNext-Medium;
            font-size: 30px !important;
        }
        .summary-grid-status {
            font-size: 16px;
        }
    }
    @media screen and (max-width: 400px) {
        .summary-grid-img {
            width: 28px;
            height: 28px;
        }
        .summary-grid-img-section {
            width: 28px;
            height: 28px;
            margin-top: 0px;
        }
        .summary-grid-text-section {
            width: auto;
            height: 38px;
        }
        .head-count-val {
            font-family: AvenirNext-Medium;
            font-size: 22px !important;
        }
        .summary-grid-status {
            font-size: 12px;
        }
        .summary-grid-text {
            font-size: 8px !important;
        }
        .pd-mb-lf {
            padding-left: 10px;
        }
        .reset-dataTable .dt-buttons .dt-button.buttons-collection span {
            font-size: 16px !important;
        }
        #salesChartExportDt.reset-dataTable .dt-buttons {
            margin-top: -3px;
        }
        body div.dt-button-collection button.dt-button {
            font-size: 12px !important;
            width: 80px;
        }
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
            <div class="row">
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="newtotalorders head-count-val">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-2.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Completed</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 grid_text_col">
                                    <small class="summary-grid-text">Instore & Mobile Transactions</small>
                                </div>
                                <div class="col-2 text-right">
                                    <a class="top_grid_link" href="<?= base_url('pos/all_pos'); ?>" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="totalpendingorders head-count-val" style="color: #000 !important;">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-1.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Pending</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 grid_text_col">
                                    <small class="summary-grid-text">Invoice Transactions</small>
                                </div>
                                <div class="col-2 text-right">
                                    <form method="post" action="<?php echo base_url('pos/all_customer_request'); ?>">
                                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                        <input name="status" type="hidden" value="pending">

                                        <button class="top_grid_btn" type="submit" name="mysubmit" value="Search" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="totalorders head-count-val" style="color: #000 !important;">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-3.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Completed</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 grid_text_col">
                                    <small class="summary-grid-text">Invoice Transactions</small>
                                </div>
                                <div class="col-2 text-right">
                                    <a class="top_grid_link" href="<?= base_url('pos/all_customer_request'); ?>" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 col-sm-6 equel-grid">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="TotalLate head-count-val" style="color: #000 !important;">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-4.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Late</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 grid_text_col">
                                    <small class="summary-grid-text">Invoice Transactions</small>
                                </div>
                                <div class="col-2 text-right">
                                    <form method="post" action="<?php echo base_url('pos/all_customer_request'); ?>">
                                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                        <input name="status" type="hidden" value="pending">

                                        <button class="top_grid_btn" type="submit" name="mysubmit" value="Search" title="Go to List"><i class="fa fa-arrow-right" style="color: #fff !important;"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row employee_date_range" style="margin-bottom: 10px !important;margin-left: -11px !important;">
                <!-- <div class="col-md-4 col-sm-8 custom-form"> -->
                <div class="custom_range_selector">
                    <div class="form-group">
                        <div id="daterange2" class="form-control" style="background-color: #f5f5fb !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <span><?php echo date("F-d-Y",strtotime("-5 days"));?> - <?php echo date("F-d-Y");?></span>
                            <input type="hidden" name="start_date" id="startDate" value="<?php echo date("Y-m-d",strtotime("-5 days"));?>">
                            <input type="hidden" name="end_date" id="endDate" value="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3 col-sm-4"> -->
                <div class="custom_employee_selector">
                    <?php
                        $merchant_id = $this->session->userdata('merchant_id');
                        $data = $this->admin_model->data_get_where_1('merchant', array('merchant_id' => $merchant_id)); ?>
                    <select name="employee" class="form-control" id="employee" onchange="getGraph();" style="background-color: #f5f5fb !important;border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option  value="all" >Select Employee</option>
                        <!-- <option  value="merchant" > Merchant</option> -->
                        <?php foreach ($data as $view) { ?>
                            <option  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <style>
                    @media screen and (max-width: 1400px) {
                        .grid-body {
                            padding: 20px 22px 20px 25px !important;
                        }
                    }
                    @media screen and (max-width: 500px) {
                        .grid-body {
                            padding: 15px !important;
                        }
                    }
                </style>
                <div id="chart_row_first" class="col-sm-6 col-lg-5 col-md-6 equel-grid" style="display: block !important;">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100" style="min-height: 448px !important;">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <p class="h4-custom">Sales Chart</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto" style="margin-left: -10px !important;margin-right: -10px !important;">
                                <div id="saleChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chart_row_second" class="col-sm-6 col-lg-7 col-md-6 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <p class="h4-custom">Order Charts</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <style>
                                    @media screen and (min-width: 1100px) {
                                        #chart_row_third {
                                            border-right: 1px dashed rgb(226, 226, 226);
                                        }
                                    }
                                    @media screen and (max-width: 1100px) {
                                        .order-series-name {
                                            font-size: 15px;
                                        }
                                        .order-series-percent {
                                            font-size: 20px;
                                        }
                                        .order-series-count {
                                            font-size: 15px;
                                        }
                                    }
                                </style>
                                <div class="row">
                                    <div id="chart_row_third" class="col-7 order_charts_wrapper">
                                        <div id="order_charts"></div>
                                    </div>

                                    <div class="mobile_tiles_view d-none" style="width:100%;margin-top: -35px !important;border-top: 1px dashed rgb(226, 226, 226);">
                                        <div style="margin-left: 24% !important;margin-top: 15px;">
                                            <div class="order_chart_tiles" style="margin-bottom: 10px !important;">
                                                <div class="order-left">
                                                    <div class="order-line-color" style="background-color: rgb(253, 172, 66);"></div>
                                                </div>
                                                <div class="order-right">
                                                    <p class="order-series-name">Instore & Mobile</p>
                                                    <p class="order-series-percent instore_percent">0%</p>
                                                    <p class="order-series-count instore_count">0</p>
                                                </div>
                                            </div>
                                            <div class="order_chart_tiles" style="margin-bottom: 10px !important;">
                                                <div class="order-left">
                                                    <div class="order-line-color" style="background-color: rgb(172, 93, 217);"></div>
                                                </div>
                                                <div class="order-right">
                                                    <p class="order-series-name">Invoice</p>
                                                    <p class="order-series-percent invoice_percent">0%</p>
                                                    <p class="order-series-count invoice_count">0</p>
                                                </div>
                                            </div>
                                            <div class="order_chart_tiles">
                                                <div class="order-left">
                                                    <div class="order-line-color" style="background-color: rgb(7, 207, 223);"></div>
                                                </div>
                                                <div class="order-right">
                                                    <p class="order-series-name">Recurring</p>
                                                    <p class="order-series-percent recurring_percent">0%</p>
                                                    <p class="order-series-count recurring_count">0</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="chart_row_fourth" class="col-5">
                                        <div class="order_chart_tiles" style="margin-bottom: 20px !important;">
                                            <div class="order-left">
                                                <div class="order-line-color" style="background-color: rgb(253, 172, 66);"></div>
                                            </div>
                                            <div class="order-right">
                                                <p class="order-series-name">Instore & Mobile</p>
                                                <p class="order-series-percent instore_percent">0%</p>
                                                <p class="order-series-count instore_count">0</p>
                                            </div>
                                        </div>
                                        <div class="order_chart_tiles" style="margin-bottom: 20px !important;">
                                            <div class="order-left">
                                                <div class="order-line-color" style="background-color: rgb(172, 93, 217);"></div>
                                            </div>
                                            <div class="order-right">
                                                <p class="order-series-name">Invoice</p>
                                                <p class="order-series-percent invoice_percent">0%</p>
                                                <p class="order-series-count invoice_count">0</p>
                                            </div>
                                        </div>
                                        <div class="order_chart_tiles">
                                            <div class="order-left">
                                                <div class="order-line-color" style="background-color: rgb(7, 207, 223);"></div>
                                            </div>
                                            <div class="order-right">
                                                <p class="order-series-name">Recurring</p>
                                                <p class="order-series-percent recurring_percent">0%</p>
                                                <p class="order-series-count recurring_count">0</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <div class="split-sub-header">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <p class="h4-custom">Sales By Year</p>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right" style="padding-right: 0px !important;">
                                                    <div class="row pull-right" style="margin-right: 10px;">
                                                        <div class="custom-chart-label">
                                                            <span>
                                                                <div class="rectangle"></div>
                                                                Merchant - <?php echo date("Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="custom-chart-label" style="margin-left: 30px;">
                                                            <span>
                                                                <div class="rectangle-darked"></div>
                                                                Merchant - <?php echo date("Y",strtotime("-1 year")); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div id="chart1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        var start = moment().subtract(5, 'days');
        var end = moment();
        // console.log(start, end);return false;

        function cb(start, end) {
            $('#daterange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // console.log(start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));
            $('#startDate').val(start.format('YYYY-MM-D'));
            $('#endDate').val(end.format('YYYY-MM-D'));

            getGraph();
        }

        $('#daterange2').daterangepicker({
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

    function getGraph(start, end, employee) {
        $('#saleChart').empty();
        $('#order_charts').empty();
        // $('#salesChartExportDt').empty();

        var start = $("#daterange2 #startDate").val();
        var end = $("#daterange2 #endDate").val();
        var employee =  $('#employee').val();
        // console.log(start, end, employee);return false;

        if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null ) {
            var start_formatted = dateFormatter(start);
            var end_formatted = dateFormatter(end);
            // console.log(start_formatted, end_formatted);return false;
            var graphData = {
                all         : 1,
                // start         : encodeURIComponent(start_formatted),
                // end      : encodeURIComponent(end_formatted),
                start       : start,
                end         : end,
                goal        : encodeURIComponent(userprefs.goal),
                metric1     : userprefs.metric1,
                metric2     : userprefs.metric2,
                units       : userprefs.units,
                employee    : employee
            }
        } else {
            var graphData = {
                all         : 1,
                start       : <?php echo $last_date; ?>,
                end         : <?php echo $date; ?>,
                goal        : encodeURIComponent(userprefs.goal),
                metric1     : userprefs.metric1,
                metric2     : userprefs.metric2,
                units       : userprefs.units,
                employee    : employee
            }
        }
        // console.log(graphData);return false;

        $.ajax({
            type    : 'POST',
            url     : "<?= base_url('merchant/getGraphData'); ?>",
            data    : graphData,
            success : function (data){
                var data = JSON.parse(data);
                // console.log(data);return false;

                var salesChartData = data.saleData;
                var orderChartData = data.getDashboardData[0];
                var summaryBoxData = data.widgets_data;
                // console.log(salesChartData);return false;
                if (data.length != 0) {
                    salesGraph('saleChart', salesChartData);
                    orderCharts(orderChartData);
                    summaryDetails(summaryBoxData);
                }
            }
        });
    }

    function summaryDetails(data) {
        // console.log(data);return false;
        $('.newtotalorders').html(data.NewTotalOrders); 
        $('.totalpendingorders').html(data.TotalpendingOrders); 
        $('.totalorders').html(data.TotalOrders); 
        $('.totallate').html(data.TotalLate);
    }
    
    function salesGraph(a, b) {
        // console.log(a, b);return false;
        if(typeof b =='undefined'){
            return;
        }

        var c = {
            global: {
                useUTC: !1
            },
            chart: {
                type: 'areaspline',
              //  width: chart_width,
                height: 350,
                renderTo: "saleChart"
            },
            
            title: {
                text: null
            },
            colors: ["#fff", "#00a6ff",'#fff'],
            credits: {
                enabled: !1
            },
            legend: {
                enabled: !1
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.1,
                    marker: {
                        fillColor: "#fff",
                        lineWidth: 2,
                        lineColor: null,
                        symbol: 'circle'
                    },
                }
            },
            xAxis: {
                type: "datetime",
                title: {
                    text: null
                },
                tickmarkPlacement: "off",
                dateTimeLabelFormats: {
                    day: "%b %e"
                },
                gridLineColor: "#eaeaea",
                gridLineWidth: 0,
                labels: {
                    style: {
                        color: "#9b9b9b"
                    }
                }
            },
            yAxis: [
                {
                    showFirstLabel: !1,
                    showLastLabel: !1,
                    tickPixelInterval: 50,
                    endOnTick: !1,
                    title: {
                        text: null
                    },
                    opposite: !0,
                    gridLineColor: "#eaeaea",
                    gridLineWidth: .5,
                    zIndex: -1,
                    labels: {
                        align: "left",
                        style: {
                            color: "#fff"
                        },
                        x: 4
                    }
                },
                {
                    showFirstLabel: !1,
                    showLastLabel: !1,
                    tickPixelInterval: 50,
                    endOnTick: !1,
                    title: {
                        text: null
                    },
                    gridLineColor: "#eaeaea",
                    gridLineWidth: .5,
                    zIndex: 2,
                    labels: {
                        align: "right",
                        style: {
                            color: "#9b9b9b"
                        },
                        x: -4
                    }
                }
            ],
            tooltip: {
                // shadow: !1,
                backgroundColor: '#fff',
                borderRadius: 10,
                shared: !0,
                formatter: function(a) {
                    var b = parseInt(this.points[0].y) == this.points[0].y ? this.points[0].y : this.points[0].y.toFixed(2),
                    b =isNaN(b)?0:(b!=''?b:0),
                    c = (this.points[1] != undefined) ? (parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2)): 0,
                    fee = (this.points[2] != undefined) ? parseInt(this.points[2].y) == this.points[2].y ? this.points[2].y : this.points[2].y.toFixed(2) : 0,
                    d = '<span style="font-size: 13px !important;"><b>' + moment(this.x).format("dddd, MMM D, YYYY") + "</b></span>",
                    e = '<span style="color: #868e96">' + a.chart.series[0].name + ':</span> <span style="color:#FDAC42;font-weight:600;"> $' + parseFloat(b).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span>',
                    f = '<span style="color: #868e96">' + a.chart.series[1].name + ':</span> <span style="color:#AC5DD9;font-weight:600;"> $' + parseFloat(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + "</span> <br/>" + '<span style="color: #868e96">' + "Avg Transaction  :" + '</span> <span style="color:#D0021B;font-weight:600;"> $' + parseFloat(fee).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span>';
                    return d + " <br /> " + f + " <br /> " + e
                }
            },
            series: [
                {
                    type: "areaspline"
                }, {
                    type: "areaspline",
                    yAxis: 1
                }, {
                    type: "areaspline",
                    yAxis: 1
                }
            ]
        };

        if ($('select[name="graph_metric1"]').length > 0) var d = $('select[name="graph_metric1"]').val(),
            e = $('select[name="graph_metric1"]').select2("data")[0].text,
            f = $('select[name="graph_metric2"]').val(),
            g = $('select[name="graph_metric2"]').select2("data")[0].text;

        else d = "tax", e = "Tax", f = "amount", g = "Amount";
            var h = [],
                i = [],
                j = [];
                fee=[];
            for (var k in b)
                if (b[k].convrate = 0 == b[k].amount ? 0 : (b[k].tax / b[k].amount * 100).toFixed(2), b[k].cpa = 0 == b[k].tax ? 
                    0 : b[k].cost / b[k].conversions, b[k].cpc = 0 == b[k].clicks ? 0 : b[k].cost / b[k].clicks, b[k].rpp = 0 == b[k].people ? 0
                    : b[k].revenue / b[k].people, b[k].profit = b[k].revenue - b[k].cost, null != b[k].date && 0 != b[k].date.length) {
                        var l = parseFloat(b[k][d]);
                        h.push([moment(b[k].date).valueOf(), l]);
                        var l = parseFloat(b[k][f]);
                        i.push([moment(b[k].date).valueOf(), l])
                        var l = parseFloat(b[k].cost);
                        fee.push([moment(b[k].date).valueOf(), l])
                    } else j = b[k];

                0 == j.length && b[0] && (j = b[0]), c.series[0].name = e, c.series[0].data = h, c.series[0].pointStart = h[0][0].valueOf(), 
                c.series[1].name = g, c.series[1].data = i, c.series[1].pointStart = i[0][0].valueOf(), c.series[2].name = "Fee", c.series[2].data = fee, c.series[2].pointStart = i[0][0].valueOf(), $("#" + a + " .placeholder")
                .length > 0 ? c.chart.renderTo = $("#" + a + " .placeholder")[0] : c.chart.renderTo = $("#" + a)[0];
                var m, n;
                m = "cost" == d || "cpa" == d || "cpc" == d || "revenue" == d || "rpp" == d || "profit" == d ? format_money(j[d]) :
                "convrate" == d ? format_rate(j[d] / 100) : add_commas(j[d]), n = "cost" == f || "cpa" == f || "cpc" == f || "revenue" == f ||
                "rpp" == f || "profit" == f ? format_money(j[f]) : "convrate" == f ? format_rate(j[f] / 100) : add_commas(j[f]),
                $(".metric1 h1").html(m), $(".metric1 h2").html(e), $(".metric2 h1").html(n), $(".metric2 h2").html(g),
                graph = new Highcharts.Chart(c)
    }

    function saleByYear(dataSaleByYearVals1,dataSaleByYearVals2) {
        Highcharts.chart('chart1', {
            chart: {
                type: 'column',
                spacingBottom: 30,
                //width: chart_width
            },
            title: {
                text: null
            },
            legend: {
                enabled: !1
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

                labels: {
                    style: {
                        color: '#9b9b9b',
                        fontFamily: 'AvenirNext-Medium'
                    }
                },
                min: 0
            },
            yAxis: {
                title: {
                    text: false
                },
                labels: {
                    style: {
                        color: '#9b9b9b'
                    }
                },
                labels: {
                    formatter: function() {
                        return ((this.value > 1000) ? ((this.value/1000).toFixed(2) + 'k') : (this.value));
                        // return ((this.value/1000) > 0 ? ((this.value/1000).toFixed(2) + 'k') : (this.value/1000));
                        // return this.value;
                    }
                },
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                backgroundColor: '#fff',
                borderRadius: 10,
                formatter: function() {
                    return '<span style="font-size:13px !important;font-weight: 600 !important;">' + this.series.name + ': ' + this.x + ' </span><br/> <span style="color: #949492">Amount' + ':</span> <span style="color:#FDAC42;font-weight:600;">$' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/> <span style="color: #949492;">' + 'Avg Transaction:</span> <span style="color:#D0021B;font-weight:600;">$' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #949492">' + 'Tax:</span> <span style="color: #AC5DD9;font-weight:600;">$' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    minPointLength: 6,
                    pointWidth: 13,
                    borderRadius: 8,
                    marker: {
                        lineWidth: 3,
                        lineColor: '#ffffff',
                        symbol: 'circle'
                    }
                }
            },
            series: [
                {
                    name: 'Merchant-' + currentYear,
                    type: "column",
                    color: '#00a6ff',
                    data: dataSaleByYearVals1
                },
                {
                    name: 'Merchant-' + lastYear,
                    type: "column",
                    color: '#1956a6',
                    data: dataSaleByYearVals2 
                }
            ]
        });
    }

    function orderCharts(data) {
        var order_charts_img = "<?php echo base_url('new_assets/img/orderCharts.png') ?>";

        var a= data.TotalAmount;
        var b= data.TotalAmountRe;
        var c= data.TotalAmountPOS;

        var t1=isNaN(parseFloat(a)) ? 0: (isNaN(parseFloat(a)) == null ? 0: parseFloat(a));
        var t2=isNaN(parseFloat(b)) ? 0: (isNaN(parseFloat(b)) == null ? 0: parseFloat(b));
        var t3=isNaN(parseFloat(c)) ? 0: (isNaN(parseFloat(c)) == null ? 0: parseFloat(c));

        $('#start').val(t1);
        $('#recurring').val(t2);
        $('#pos').val(t3);

        // console.log(t1, t2, t3);return false;

        t11 = (t1 == 0) ? t1 : t1.toFixed(2);
        t21 = (t2 == 0) ? t2 : t2.toFixed(2);
        t31 = (t3 == 0) ? t3 : t3.toFixed(2);

        t11 = t11.toString().split(".");
        t11[0] = t11[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        t11 = t11.join(".");

        t21 = t21.toString().split(".");
        t21[0] = t21[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        t21 = t21.join(".");

        t31 = t31.toString().split(".");
        t31[0] = t31[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        t31 = t31.join(".");

        var total_amount =  parseFloat(t1 + t2 + t3) ;

        var p1=(t1==0)?0:parseFloat((t1 / total_amount)*100);
        var p2=(t2==0)?0:parseFloat((t2 / total_amount)*100);
        var p3=(t3==0)?0:parseFloat((t3 / total_amount)*100);
        
        // p1 = Math.round(p1);
        // p2 = Math.round(p2);
        // p3 = Math.round(p3);

        p1 = p1.toFixed(2);
        p2 = p2.toFixed(2);
        p3 = p3.toFixed(2);

        $('.invoice_percent').html(p1+'%');
        $('.invoice_count').html('$'+t11);

        $('.recurring_percent').html(p2+'%');
        $('.recurring_count').html('$'+t21);

        $('.instore_percent').html(p3+'%');
        $('.instore_count').html('$'+t31);
        
        var options = {
            series: [p1, p2, p3],
            chart: {
                height: 350,
                type: 'radialBar',
            },
            stroke: {
                show: true,
                curve: 'smooth',
                lineCap: 'round',
                width: 5
            },
            plotOptions: {
                radialBar: {
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 330,
                    hollow: {
                        size: '40%',
                        background: 'transparent',
                        image: order_charts_img,
                        imageWidth: 50,
                        imageHeight: 50,
                        imageClipped: false
                    },
                    track: {
                        margin: 10
                    },
                    dataLabels: {
                        name: {
                            show: true,
                        },
                        value: {
                            show: true,
                        }
                    }
                }
            },
            colors: ['#AC5DD9', '#07CFDF', '#FDAC42'],
            labels: ['Invoices', 'Recurring', 'Instore & Mobile'],
            legend: {
                show: false,
                labels: {
                    useSeriesColors: false,
                },
                markers: {
                    size: 0
                },
                formatter: function(seriesName, opts) {
                    // return seriesName + "<br/><span>"+opts.w.globals.series[opts.seriesIndex] +'%</span>';
                    return null;
                },
                itemMargin: {
                    vertical: 0
                }
            },
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        legend: {
                            show: false
                        }
                    }
                }
                ]
            };
        var chart = new ApexCharts(document.querySelector("#order_charts"), options);
        chart.render();
    }

    jQuery(function($){
        function setNullOrZeroByYear(month,vals){
            var mnthArray=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var currMnth=moment().format('MMM');
            var currIndex=mnthArray.indexOf(currMnth);
            var checkIndex=mnthArray.indexOf(month);
            if(currIndex < checkIndex){
                vals =isNaN(vals)? null : (vals ==null? null: parseFloat(vals));
            } else {
                vals =isNaN(vals)? 0 : (vals ==null? 0: parseFloat(vals));
            }
            return vals;
        }

        var data1 = setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljan'] ?>);
        var data2 = setNullOrZeroByYear('Fen',<?php echo $getSaleByYearData[0]['Totalfeb'] ?>);
        var data3 = setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarch'] ?>);
        var data4 = setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprl'] ?>);
        var data5 = setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmay'] ?>);
        var data6 = setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljune'] ?>);
        var data7 = setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljuly'] ?>);
        var data8 = setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugust'] ?>);
        var data9 = setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalsep'] ?>);
        var data10 = setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totaloct'] ?>);
        var data11 = setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnov'] ?>);
        var data12 = setNullOrZeroByYear('Dec',<?php echo  $getSaleByYearData[0]['Totaldec'] ?>);

        var dataf1 = setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljanf'] ?>);
        var dataf2 = setNullOrZeroByYear('Feb',<?php echo $getSaleByYearData[0]['Totalfebf'] ?>);
        var dataf3 = setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarchf'] ?>);
        var dataf4 = setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprlf'] ?>);
        var dataf5 = setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmayf'] ?>);
        var dataf6 = setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljunef'] ?>);
        var dataf7 = setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljulyf'] ?>);
        var dataf8 = setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugustf'] ?>);
        var dataf9 = setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalsepf'] ?>);
        var dataf10 = setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totaloctf'] ?>);
        var dataf11 = setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnovf'] ?>);
        var dataf12 = setNullOrZeroByYear('Dec',<?php echo  $getSaleByYearData[0]['Totaldecf'] ?>);
        var datatex1 = setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljantax'] ?>);
        var datatex2 = setNullOrZeroByYear('Feb',<?php echo $getSaleByYearData[0]['Totalfebtax'] ?>);
        var datatex3 = setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarchtax'] ?>);
        var datatex4 = setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprltax'] ?>);
        var datatex5 = setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmaytax'] ?>);
        var datatex6 = setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljunetax'] ?>);
        var datatex7 = setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljulytax'] ?>);
        var datatex8 = setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugusttax'] ?>);
        var datatex9 = setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalseptax'] ?>);
        var datatex10 = setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totalocttax'] ?>);
        var datatex11 = setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnovtax'] ?>);
        var datatex12 = setNullOrZeroByYear('Dec',<?php echo $getSaleByYearData[0]['Totaldectax'] ?>);


        
        var datab1 = <?php echo $getSaleByYearData[0]['Totalbjan'] ?  $getSaleByYearData[0]['Totalbjan'] :'0'."" ?>;
        var datab2 = <?php echo $getSaleByYearData[0]['Totalbfeb'] ?  $getSaleByYearData[0]['Totalbfeb'] :'0'."" ?>;
        var datab3 = <?php echo $getSaleByYearData[0]['Totalbmarch'] ?  $getSaleByYearData[0]['Totalbmarch'] :'0'."" ; ?>;
        var datab4 = <?php echo $getSaleByYearData[0]['Totalbaprl'] ?  $getSaleByYearData[0]['Totalbaprl'] :'0'."" ; ?>;
        var datab5 = <?php echo $getSaleByYearData[0]['Totalbmay']  ?  $getSaleByYearData[0]['Totalbmay'] :'0'."" ; ?>;
        var datab6 = <?php echo $getSaleByYearData[0]['Totalbjune'] ?  $getSaleByYearData[0]['Totalbjune'] :'0'."" ; ?>;
        var datab7 = <?php echo $getSaleByYearData[0]['Totalbjuly']  ?  $getSaleByYearData[0]['Totalbjuly'] :'0'."" ; ?>;
        var datab8 = <?php echo $getSaleByYearData[0]['Totalbaugust']  ?  $getSaleByYearData[0]['Totalbaugust'] :'0'."" ; ?>;
        var datab9 = <?php echo $getSaleByYearData[0]['Totalbsep']  ?  $getSaleByYearData[0]['Totalbsep'] :'0'."" ; ?>;
        var datab10 = <?php echo $getSaleByYearData[0]['Totalboct'] ?  $getSaleByYearData[0]['Totalboct'] :'0'."" ; ?>;
        var datab11 = <?php echo $getSaleByYearData[0]['Totalbnov'] ?  $getSaleByYearData[0]['Totalbnov'] :'0'."" ; ?>;
        var datab12 = <?php echo ($getSaleByYearData[0]['Totalbdec']) ?  $getSaleByYearData[0]['Totalbdec'] :'0'."" ; ?>;
        var dataf1b = <?php echo $getSaleByYearData[0]['Totalbjanf'] ?  $getSaleByYearData[0]['Totalbjanf'] :'0'."" ?>;
        var dataf2b = <?php echo $getSaleByYearData[0]['Totalbfebf'] ?  $getSaleByYearData[0]['Totalbfebf'] :'0'."" ?>;
        var dataf3b = <?php echo $getSaleByYearData[0]['Totalbmarchf'] ?  $getSaleByYearData[0]['Totalbmarchf'] :'0'."" ?>;
        var dataf4b = <?php echo $getSaleByYearData[0]['Totalbaprlf'] ?  $getSaleByYearData[0]['Totalbaprlf'] :'0'."" ?>;
        var dataf5b = <?php echo $getSaleByYearData[0]['Totalbmayf'] ?  $getSaleByYearData[0]['Totalbmayf'] :'0'."" ?>;
        var dataf6b = <?php echo $getSaleByYearData[0]['Totalbjunef'] ?  $getSaleByYearData[0]['Totalbjunef'] :'0'."" ?>;
        var dataf7b = <?php echo $getSaleByYearData[0]['Totalbjulyf'] ?  $getSaleByYearData[0]['Totalbjulyf'] :'0'."" ?>;
        var dataf8b = <?php echo $getSaleByYearData[0]['Totalbaugustf'] ?  $getSaleByYearData[0]['Totalbaugustf'] :'0'."" ?>;
        var dataf9b = <?php echo $getSaleByYearData[0]['Totalbsepf'] ?  $getSaleByYearData[0]['Totalbsepf'] :'0'."" ?>;
        var dataf10b = <?php echo $getSaleByYearData[0]['Totalboctf'] ?  $getSaleByYearData[0]['Totalboctf'] :'0'."" ?>;
        var dataf11b = <?php echo $getSaleByYearData[0]['Totalbnovf'] ?  $getSaleByYearData[0]['Totalbnovf'] :'0'."" ?>  ;
        var dataf12b = <?php echo  $getSaleByYearData[0]['Totalbdecf'] ?  $getSaleByYearData[0]['Totalbdecf'] :'0'."" ?> ;
        var datatex1b = <?php echo $getSaleByYearData[0]['Totalbjantax'] ?  $getSaleByYearData[0]['Totalbjantax'] :'0'."" ?>;
        var datatex2b = <?php echo $getSaleByYearData[0]['Totalbfebtax'] ?  $getSaleByYearData[0]['Totalbfebtax'] :'0'.""; ?>;
        var datatex3b = <?php echo $getSaleByYearData[0]['Totalbmarchtax'] ?  $getSaleByYearData[0]['Totalbmarchtax'] :'0'."" ?>;
        var datatex4b = <?php echo $getSaleByYearData[0]['Totalbaprltax'] ?  $getSaleByYearData[0]['Totalbaprltax'] :'0'."" ?>;
        var datatex5b = <?php echo $getSaleByYearData[0]['Totalbmaytax'] ?  $getSaleByYearData[0]['Totalbmaytax'] :'0'."" ?>;
        var datatex6b = <?php echo $getSaleByYearData[0]['Totalbjunetax'] ?  $getSaleByYearData[0]['Totalbjunetax'] :'0'."" ?>;
        var datatex7b = <?php echo $getSaleByYearData[0]['Totalbjulytax'] ?  $getSaleByYearData[0]['Totalbjulytax'] :'0'."" ?>;
        var datatex8b = <?php echo $getSaleByYearData[0]['Totalbaugusttax'] ?  $getSaleByYearData[0]['Totalbaugusttax'] :'0'."" ?>;
        var datatex9b = <?php echo $getSaleByYearData[0]['Totalseptax'] ?  $getSaleByYearData[0]['Totalseptax'] :'0'."" ?>;
        var datatex10b = <?php echo $getSaleByYearData[0]['Totalbocttax'] ?  $getSaleByYearData[0]['Totalbocttax'] :'0'."" ?>;
        var datatex11b = <?php echo $getSaleByYearData[0]['Totalbnovtax'] ?  $getSaleByYearData[0]['Totalbnovtax'] :'0'."" ?>;
        var datatex12b = <?php echo $getSaleByYearData[0]['Totalbdectax'] ?  $getSaleByYearData[0]['Totalbdectax'] :'0'."" ?>;
        var dataSaleByYearVals1=[{y:data1, tax :datatex1 , avg :dataf1}, {y:data2, tax :datatex2 , avg :dataf2},{y:data3, tax :datatex3 , avg :dataf3},{y:data4, tax :datatex4 , avg :dataf4},{y:data5, tax :datatex5 , avg :dataf5},{y:data6, tax :datatex6 , avg :dataf6},{y:data7, tax :datatex7 , avg :dataf7},{y:data8, tax :datatex8 , avg :dataf8},{y:data9, tax :datatex9 , avg :dataf9},{y:data10, tax :datatex10 , avg :dataf10},{y:data11, tax :datatex11 , avg :dataf11},{y:data12, tax :datatex12 , avg :dataf12}];
        var dataSaleByYearVals2=[{y:datab1, tax :datatex1b, avg :dataf1b}, {y:datab2, tax :datatex2b, avg :dataf2b},{y:datab3, tax :datatex3b, avg :dataf3b},{y:datab4, tax :datatex4b, avg :dataf4b},{y:datab5, tax :datatex5b, avg :dataf5b},{y:datab6, tax :datatex6b, avg :dataf6b},{y:datab7, tax :datatex7b, avg :dataf7b},{y:datab8, tax :datatex8b, avg :dataf8b},{y:datab9, tax :datatex9b, avg :dataf9b},{y:datab10, tax :datatex10b, avg :dataf10b},{y:datab11, tax :datatex11b, avg :dataf11b},{y:datab12, tax :datatex12b, avg :dataf12b}];
        // console.log(dataSaleByYearVals1)
        // console.log(dataSaleByYearVals2)
        saleByYear(dataSaleByYearVals1,dataSaleByYearVals2);
    })

    $(document).ready(function() {
        // if($(window).width() < 1085) {
        if($(window).width() < 1220) {
            $('#chart_row_first').removeClass('col-lg-5');
            $('#chart_row_first').addClass('col-lg-6');

            $('#chart_row_second').removeClass('col-lg-7');
            $('#chart_row_second').addClass('col-lg-6');

            $('#chart_row_third').removeClass('col-7');
            $('#chart_row_third').addClass('col-12');

            $('#chart_row_fourth').remove();

            $('.mobile_tiles_view').removeClass('d-none');
        }
    })

    $(document).on("click",".applyBtn",function() {
        updateSaleOrderChartsDate();
    });

$(document).ready(function() {
        $.ajax({
            type    : 'POST',
            url     : "<?= base_url('Employee_update_merchant'); ?>",
            data    : {'aaa' : 1},
            success : function (data){
                
            }
        });
    })

$(document).ready(function() {
        $.ajax({
            type    : 'POST',
            url     : "<?= base_url('Merchant_week_graph_one'); ?>",
            data    : {'aaa' : 1},
            success : function (data){
                
            }
        });
    })

   
</script>

<?php include_once'footer_dash.php'; ?>