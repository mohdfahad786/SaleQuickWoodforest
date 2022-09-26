<?php  
    $last_date = date("Y-m-d",strtotime("-29 days"));
    $date = date("Y-m-d");
?>
<script type="text/javascript"> 
    var userprefs = {
        goal: 'all',
        employee: 'all',
        merchant: '',
        fee: '',
        metric1: 'amount',
        metric2: 'conversions',
        units: 'days',
        start: '<?php echo $last_date; ?>',
        end: '<?php echo $date; ?>',
        timezone: 'America/New_York',
        plan_id: 3
    };
</script>

<?php
include_once 'header_graph.php';
include_once 'sidebar_dash.php';
?>

<?php  
$total =  $getDashboardData[0]['TotalAmount'] + $getDashboardData[0]['TotalAmountRe'] + $getDashboardData[0]['TotalAmountPOS'];
if($total!=0) {
	$straight = number_format(($getDashboardData[0]['TotalAmount']/$total)*100,2);
	$recurring = number_format(( $getDashboardData[0]['TotalAmountRe']/$total)*100,2) ;
	$pos = number_format(($getDashboardData[0]['TotalAmountPOS']/$total)*100,2);

} else {
	$straight = '0' ;
	$recurring = '0' ;
	$pos = '0' ;
} ?>

<?php 
if($total!=0) { ?>
	<input type="hidden" name="total" id="total" value="<?php echo $getDashboardData[0]['TotalAmount'] + $getDashboardData[0]['TotalAmountRe'] + $getDashboardData[0]['TotalAmountPOS']; ?>">
	<input type="hidden" name="straight" id="straight" value="<?php echo number_format(($getDashboardData[0]['TotalAmount']/$total)*100,2); ?>">
	<input type="hidden" name="recurring" id="recurring" value="<?php echo number_format(( $getDashboardData[0]['TotalAmountRe']/$total)*100,2); ?>">
	<input type="hidden" name="pos" id="pos" value="<?php echo number_format(($getDashboardData[0]['TotalAmountPOS']/$total)*100,2); ?>">
<?php } else { ?>
	<input type="hidden" name="total" id="total" value="0">
	<input type="hidden" name="straight" id="straight" value="0">
	<input type="hidden" name="recurring" id="recurring" value="0">
	<input type="hidden" name="pos" id="pos" value="0">
<?php } ?>

<style type="text/css">
    #saleChart g.highcharts-series.highcharts-series-0,#saleChart  g.highcharts-series.highcharts-series-2,#saleChart  g.highcharts-markers.highcharts-series-0,#saleChart  g.highcharts-markers.highcharts-series-2,#saleChart  .highcharts-series-group >path:nth-child(1),#saleChart  .highcharts-series-group >path:nth-child(3) {
        opacity: 0;
    }
    .reset-dataTable .dt-buttons .dt-button.buttons-collection span {
        font-size: 20px !important;
        font-family: Avenir-Black !important;
        color: #000 !important;
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
    #salesChartExportDt{
		position: absolute;
		right: 0px;
	}
	#salesChartExportDt button.dt-button.buttons-collection{
		margin: 0 !important
	}
	#salesChartExportDt.reset-dataTable .dt-buttons {
		padding-top: 0px;
        margin-top: 5px;
	}
	#salesChartExportDt table{
		display: none;
		width: 100%;
	}
	#salesChartExportDt div.dt-button-collection{
		left: auto !important;
		right: 0;
        display: flex;
        margin-top: 0px !important;
	}
	.summary-grid-text-section h1 {
		margin: 0 !important;
	}
    div.dt-buttons {
        display: block !important;
    }
    body div.dt-button-collection button.dt-button {
        font-size: 13px !important;
        width: 120px;
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
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Dashboard</h4> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding pd-mb-lf">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <!-- <h1 class="newtotalorders head-count-val"><?php echo $widgets_data['TotalConfirmOrders']; ?></h1> -->
                                    <h1 class="newtotalorders head-count-val">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-2.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Total Paid</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small class="summary-grid-text">Payment Request</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding pd-mb-lf">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <!-- <h1 class="totalpendingorders head-count-val" style="color: #000 !important;"><?php echo ($widgets_data['TotalpendingOrders'] ? $widgets_data['TotalpendingOrders'] : 0) ;?></h1> -->
                                    <h1 class="totalpendingorders head-count-val" style="color: #000 !important;">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-1.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Pending Invoices</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small class="summary-grid-text">Payment Request</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding pd-mb-lf">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <!-- <h1 class="totalorders head-count-val" style="color: #000 !important;"><?php echo $widgets_data['NewTotalOrders']; ?></h1> -->
                                    <h1 class="totalorders head-count-val" style="color: #000 !important;">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-3.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">New</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small class="summary-grid-text">Payment Request</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 col-sm-6 equel-grid pd-mb-lf">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <!-- <h1 class="TotalLate head-count-val" style="color: #000 !important;"><?php echo $widgets_data['TotalFaildOrders']; ?></h1> -->
                                    <h1 class="totallate head-count-val" style="color: #000 !important;">0</h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-4.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Total Failed</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small class="summary-grid-text">Payment</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row employee_date_range" style="margin-bottom: 10px !important;margin-left: -11px !important;">
                <div class="custom_range_selector">
                    <div class="form-group">
                        <div id="daterange" class="form-control" style="background-color: #f5f5fb !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <span><?php echo date("F-d-Y",strtotime("-29 days"));?> - <?php echo date("F-d-Y");?></span>
                            <input type="hidden" name="start_date" id="startDate" value="<?php echo date("Y-m-d",strtotime("-29 days"));?>">
              				<input type="hidden" name="end_date" id="endDate" value="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                </div>
                <div class="custom_employee_selector">
                    <?php $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active' , 'user_type' => 'merchant'));  ?>
                    
                    <select name="employee" class="form-control" id="employee" onchange="getGraph();" style="background-color: #f5f5fb !important;border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
            			<option  value="all" >All Merchant</option>
        				<?php foreach ($data as $view) { ?>
         					<option  value="<?php echo $view['id']; ?>"><?php if(empty($view['business_dba_name'])){echo $view['name'];} else {echo $view['business_dba_name'];} ?></option>
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
                            <div class="row">
                                <div class="col-6">
                                    <div class="wrapper">
                                        <div class="d-flex justify-content-between">
                                            <div class="split-header">
                                                <p class="h4-custom">Daily Volume</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="col form_buttons" style="text-align: right;">
                                        <div id="salesChartExportDt" class="reset-dataTable"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-auto" style="margin-left: -10px !important;margin-right: -10px !important;">
                                <div id="graph"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chart_row_second" class="col-sm-6 col-lg-7 col-md-6 equel-grid">
                    <div class="grid grid-chart" style="margin-bottom: 0px !important;">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <p class="h4-custom">Product Volume</p>
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
                                                    <div class="order-line-color" style="background-color: rgb(172, 93, 217);"></div>
                                                </div>
                                                <div class="order-right">
                                                    <p class="order-series-name">Invoice</p>
                                                    <p class="order-series-percent invoice_percent">0%</p>
                                                    <p class="order-series-count invoice_count">0</p>
                                                </div>
                                            </div>
                                            <div class="order_chart_tiles" style="margin-bottom: 10px !important;">
                                                <div class="order-left">
                                                    <div class="order-line-color" style="background-color: rgb(7, 207, 223);"></div>
                                                </div>
                                                <div class="order-right">
                                                    <p class="order-series-name">Recurring</p>
                                                    <p class="order-series-percent recurring_percent">0%</p>
                                                    <p class="order-series-count recurring_count">0</p>
                                                </div>
                                            </div>
                                            <div class="order_chart_tiles">
                                            	<div class="order-left">
                                                    <div class="order-line-color" style="background-color: rgb(253, 172, 66);"></div>
                                                </div>
                                                <div class="order-right">
                                                    <p class="order-series-name">Instore & Mobile</p>
                                                    <p class="order-series-percent instore_percent">0%</p>
                                                    <p class="order-series-count instore_count">0</p>
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
                                                    <p class="h4-custom">Yearly Volume</p>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                    <!-- <div class="row pull-right" style="margin-right: 10px;">
                                                        <div class="custom-chart-label yearlylab">
                                                            <span>
                                                                <div class="rectangle"></div>
                                                                Yearly Gross Sales <?php echo date("Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="custom-chart-label yearlylab year_chart_margin_right">
                                                            <span>
                                                                <div class="rectangle-darked"></div>
                                                                Yearly Gross Sales <?php echo date("Y",strtotime("-1 year")); ?>
                                                            </span>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div id="yearlyGrossSale"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	var dtConfigHiddenTable = {
        dom: 'B', destroy: true, order: [],
        "buttons":
        [{
            extend: 'collection',
            text: '<span>Export List</span> <i class="fa fa-download"></i>',
            buttons: [
                {
                    extend: 'csv',
                    titleAttr: 'Download CSV report',
                    text: '<i class="fa fa-file-text-o" aria-hidden="true"></i> CSV Report'
                },
                {
                    extend: 'excelHtml5',
                    titleAttr: 'Download Excel report',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel Report',
                   
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    titleAttr: 'Download PDF report',
                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF Report',
                    
                }
            ]
        }]
    };

	$(function() {
        moment.tz.setDefault("America/Chicago");
        //moment().utcOffset("-360");
        
        // var start = moment().subtract(29, 'days').utcOffset("-120");
        // var end = moment().utcOffset("-120");
	    var start = moment().subtract(29, 'days');
	    var end = moment();
        // console.log(start, end);return false;

	    function cb(start, end) {
	        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	        // console.log(start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));
	        $('#startDate').val(start.format('YYYY-MM-D'));
	        $('#endDate').val(end.format('YYYY-MM-D'));

	        getGraph();
	    }

	    $('#daterange').daterangepicker({
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
            // ranges: {
            //    'Today': [moment().utcOffset("-120"), moment().utcOffset("-120")],
            //    'Yesterday': [moment().subtract(1, 'days').utcOffset("-120"), moment().subtract(1, 'days').utcOffset("-120")],
            //    'Last 7 Days': [moment().subtract(6, 'days').utcOffset("-120"), moment().utcOffset("-120")],
            //    'Last 30 Days': [moment().subtract(29, 'days').utcOffset("-120"), moment().utcOffset("-120")],
            //    'This Month': [moment().startOf('month'), moment().endOf('month')],
            //    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            // }
	    }, cb);

	    cb(start, end);
	});

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

        getGraph1();
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

  	function getGraph(start, end, employee) {
  		$('#graph').empty();
        $('#order_charts').empty();
        $('#salesChartExportDt').empty();

    	if(!start){
    	  	var start=$("#daterange #startDate").val();
    	  	var end=$("#daterange #endDate").val();
    	}
    	var employee =  $('#employee').val();

    	if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null ) {
            var start_formatted = dateFormatter(start);
            var end_formatted = dateFormatter(end);
            // console.log(start_formatted, end_formatted);return false;
	    	var graphData = {
	    		all 		: 1,
	    		// start         : encodeURIComponent(start_formatted),
                // end      : encodeURIComponent(end_formatted),
                start 		: start,
	    		end 		: end,
	    		goal 		: encodeURIComponent(userprefs.goal),
	    		metric1 	: userprefs.metric1,
	    		metric2 	: userprefs.metric2,
	    		units 		: userprefs.units,
	    		employee 	: employee
	    	}
    	} else {
	    	var graphData = {
	    		all 		: 1,
	    		start 		: <?php echo $last_date; ?>,
	    		end 		: <?php echo $date; ?>,
	    		goal 		: encodeURIComponent(userprefs.goal),
	    		metric1 	: userprefs.metric1,
	    		metric2 	: userprefs.metric2,
	    		units 		: userprefs.units,
	    		employee 	: employee
	    	}
    	}
        // console.log(graphData);return false;

    	$.ajax({
            type 	: 'POST',
            url 	: "<?= base_url('dashboard/getGraphData'); ?>",
            data 	: graphData,
            success : function (data){
            	var data = JSON.parse(data);
            	// console.log(data);return false;

            	var salesChartData = data.saleData;
            	var orderChartData = data.getDashboardData[0];
            	var summaryBoxData = data.widgets_data;
                // console.log(salesChartData);return false;
                if (data.length != 0) {
                	salesGraph('graph', salesChartData);
                	orderCharts(orderChartData);
                	summaryDetails(summaryBoxData);
                	
                    $.ajax({
                        type    : 'POST',
                        url     : "<?= base_url('dashboard/getDashboardExportData'); ?>",
                        data    : graphData,
                        success : function (data){
                            var data = JSON.parse(data);
                            // console.log(data);return false;
                            saleSummeryPdfTableConvertor($('#salesChartExportDt'),data.item3,data.item5);
                        }
                    });
                }
            }
        });
  	}

  	function salesGraph(a, b) {
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
                renderTo: "graph"
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
                backgroundColor: '#fff',
                borderRadius: 10,
                shared: !0,
                formatter: function(a) {
                    var b = parseInt(this.points[0].y) == this.points[0].y ? this.points[0].y : this.points[0].y.toFixed(2),
                    b =isNaN(b)?0:(b!=''?b:0),
                    // console.log(this),
                    c = (this.points[1] != undefined) ? (parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2)): 0,
                    fee = (this.points[2] != undefined) ? parseInt(this.points[2].y) == this.points[2].y ? this.points[2].y : this.points[2].y.toFixed(2) : 0,
                    d = '<span style="font-size: 13px !important;"><b>' + moment(this.x).format("dddd, MMM D, YYYY") + "</b></span>",
                    e = '<span style="color: #868e96">' + a.chart.series[0].name + ':</span> <span style="color:#FDAC42;font-weight:600;"> $' + parseFloat(b).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span>',
                    f = '<span style="color: #868e96">' + a.chart.series[1].name + ':</span> <span style="color:#AC5DD9;font-weight:600;"> $' + parseFloat(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + "</span> <br/>" + '<span style="color: #868e96">' + "Fee  :" + '</span> <span style="color:#D0021B;font-weight:600;"> $' + parseFloat(fee).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</b>' + '</span>';
                    return d + " <br /> " + f + " <br /> " + e
                    //  return d + " <br /> "  + f
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

        if ($('select[name="graph_metric1"]').length > 0)
        	var d = $('select[name="graph_metric1"]').val(),
            e = $('select[name="graph_metric1"]').select2("data")[0].text,
            f = $('select[name="graph_metric2"]').val(),
            g = $('select[name="graph_metric2"]').select2("data")[0].text;

        else d = "tax", e = "Tax", f = "amount", g = "Amount";
            // else  f = "conversions", g = "Amount";
            var h = [],
            i = [],
            j = [];
            fee=[];
            for (var k in b)
            	// console.log(b);return false;
                if (b[k].convrate = 0 == b[k].amount ? 0 : (b[k].tax / b[k].amount * 100).toFixed(2), b[k].cpa = 0 == b[k].tax ? 0 : b[k].cost / b[k].conversions, b[k].cpc = 0 == b[k].clicks ? 0 : b[k].cost / b[k].clicks, b[k].rpp = 0 == b[k].people ? 0 : b[k].revenue / b[k].people, b[k].profit = b[k].revenue - b[k].cost, null != b[k].date && 0 != b[k].date.length) {

                    var l = parseFloat(b[k][d]);
                	// console.log(b[k].date, moment(b[k].date));
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
                    graph = new Highcharts.Chart(c), graphData = b
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

    function summaryDetails(data) {
    	// console.log(data);return false;
    	$('.newtotalorders').html(data.TotalConfirmOrders); 
        $('.totalpendingorders').html(data.TotalpendingOrders); 
        $('.totalorders').html(data.NewTotalOrders); 
        $('.totallate').html(data.TotalFaildOrders);
    }

    function saleSummeryPdfTableConvertor($wraper,jd,totals){
        // console.log(jd,totals);return false;
        var allRow='',tfoot='',nameCol=false;
        if(typeof totals != 'object')
            totals=JSON.parse(totals);
        if(parseInt(totals[0]['is_Customer_name'])) {
            var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');
            nameCol=true;
        } else {
            var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');
        }

        if(!jd) {
            allRow='<tr><td colspan="5" align="center">No data</td></tr>';
        } else {
            if(typeof jd != 'object')
                jsonData = JSON.parse(jd);
            else
                jsonData = jd;

            jsonData.forEach(function(val, i){
                if(allRow != '') {
                    allRow+=
                        '<tr><td>'+val.Amount
                        +'</td><td>'+val.Tax
                        +'</td><td>'+val.Tip
                        +'</td><td>'+val.Type
                        +'</td><td>'+val.Date
                        +'</td><td>'+val.Reference
                        +'</td></tr>';    
                } else {
                    allRow='<tr><td>'+val.Amount+'</td><td>'+val.Tax+'</td><td>'+val.Tip+'</td><td>'+val.Type+'</td><td>'+val.Date+'</td><td>'+val.Reference+'</td></tr>';    
                }
            });
        }

        newTable.find('tbody').html(allRow);
        // newTable.find('tbody').append(tfoot);
        $wraper.html(newTable);
        $wraper.find('table').DataTable(dtConfigHiddenTable);
    }

    function getGraph1(start, end) {     
        // starrt Year 
        var data1 = <?php echo $getSaleByYearData[0]['Totaljan'] ?  $getSaleByYearData[0]['Totaljan'] :'0'."" ?>;
        var data2 = <?php echo $getSaleByYearData[0]['Totalfeb'] ?  $getSaleByYearData[0]['Totalfeb'] :'0'."" ?>;
        var data3 = <?php echo $getSaleByYearData[0]['Totalmarch'] ?  $getSaleByYearData[0]['Totalmarch'] :'0'."" ?>;
        var data4 = <?php echo $getSaleByYearData[0]['Totalaprl'] ?  $getSaleByYearData[0]['Totalaprl'] :'0'."" ?>;
        var data5 = <?php echo $getSaleByYearData[0]['Totalmay'] ?  $getSaleByYearData[0]['Totalmay'] :'0'."" ?>;
        var data6 = <?php echo $getSaleByYearData[0]['Totaljune'] ?  $getSaleByYearData[0]['Totaljune'] :'0'."" ?>;
        var data7 = <?php echo $getSaleByYearData[0]['Totaljuly'] ?  $getSaleByYearData[0]['Totaljuly'] :'0'."" ?>;
        var data8 = <?php echo $getSaleByYearData[0]['Totalaugust'] ?  $getSaleByYearData[0]['Totalaugust'] :'0'."" ?>;
        var data9 = <?php echo $getSaleByYearData[0]['Totalsep'] ?  $getSaleByYearData[0]['Totalsep'] :'0'."" ?>;
        var data10 = <?php echo $getSaleByYearData[0]['Totaloct'] ?  $getSaleByYearData[0]['Totaloct'] :'0'."" ?>;
        var data11 = <?php echo $getSaleByYearData[0]['Totalnov'] ?  $getSaleByYearData[0]['Totalnov'] :'0'."" ?>;
        var data12 = <?php echo $getSaleByYearData[0]['Totaldec'] ?  $getSaleByYearData[0]['Totaldec'] :'0'."" ?>;

        var datatex1 = <?php echo $getSaleByYearData[0]['Totaljantax'] ?  $getSaleByYearData[0]['Totaljantax'] :'0'."" ?>;
        var datatex2 = <?php echo $getSaleByYearData[0]['Totalfebtax'] ?  $getSaleByYearData[0]['Totalfebtax'] :'0'.""; ?>;
        var datatex3 = <?php echo $getSaleByYearData[0]['Totalmarchtax'] ?  $getSaleByYearData[0]['Totalmarchtax'] :'0'."" ?>;
        var datatex4 = <?php echo $getSaleByYearData[0]['Totalaprltax'] ?  $getSaleByYearData[0]['Totalaprltax'] :'0'."" ?>;
        var datatex5 = <?php echo $getSaleByYearData[0]['Totalmaytax'] ?  $getSaleByYearData[0]['Totalmaytax'] :'0'."" ?>;
        var datatex6 = <?php echo $getSaleByYearData[0]['Totaljunetax'] ?  $getSaleByYearData[0]['Totaljunetax'] :'0'."" ?>;
        var datatex7 = <?php echo $getSaleByYearData[0]['Totaljulytax'] ?  $getSaleByYearData[0]['Totaljulytax'] :'0'."" ?>;
        var datatex8 = <?php echo $getSaleByYearData[0]['Totalaugusttax'] ?  $getSaleByYearData[0]['Totalaugusttax'] :'0'."" ?>;
        var datatex9 = <?php echo $getSaleByYearData[0]['Totalseptax'] ?  $getSaleByYearData[0]['Totalseptax'] :'0'."" ?>;
        var datatex10 = <?php echo $getSaleByYearData[0]['Totalocttax'] ?  $getSaleByYearData[0]['Totalocttax'] :'0'."" ?>;
        var datatex11 = <?php echo $getSaleByYearData[0]['Totalnovtax'] ?  $getSaleByYearData[0]['Totalnovtax'] :'0'."" ?>;
        var datatex12 = <?php echo $getSaleByYearData[0]['Totaldectax'] ?  $getSaleByYearData[0]['Totaldectax'] :'0'."" ?>;

        var dataf1 = <?php echo $getSaleByYearData[0]['Totaljanf'] ?  $getSaleByYearData[0]['Totaljanf'] :'0'."" ?>;
        var dataf2 = <?php echo $getSaleByYearData[0]['Totalfebf'] ?  $getSaleByYearData[0]['Totalfebf'] :'0'."" ?>;
        var dataf3 = <?php echo $getSaleByYearData[0]['Totalmarchf'] ?  $getSaleByYearData[0]['Totalmarchf'] :'0'."" ?>;
        var dataf4 = <?php echo $getSaleByYearData[0]['Totalaprlf'] ?  $getSaleByYearData[0]['Totalaprlf'] :'0'."" ?>;
        var dataf5 = <?php echo $getSaleByYearData[0]['Totalmayf'] ?  $getSaleByYearData[0]['Totalmayf'] :'0'."" ?>;
        var dataf6 = <?php echo $getSaleByYearData[0]['Totaljunef'] ?  $getSaleByYearData[0]['Totaljunef'] :'0'."" ?>;
        var dataf7 = <?php echo $getSaleByYearData[0]['Totaljulyf'] ?  $getSaleByYearData[0]['Totaljulyf'] :'0'."" ?>;
        var dataf8 = <?php echo $getSaleByYearData[0]['Totalaugustf'] ?  $getSaleByYearData[0]['Totalaugustf'] :'0'."" ?>;
        var dataf9 = <?php echo $getSaleByYearData[0]['Totalsepf'] ?  $getSaleByYearData[0]['Totalsepf'] :'0'."" ?>;
        var dataf10 = <?php echo $getSaleByYearData[0]['Totaloctf'] ?  $getSaleByYearData[0]['Totaloctf'] :'0'."" ?>;
        var dataf11 = <?php echo $getSaleByYearData[0]['Totalnovf'] ?  $getSaleByYearData[0]['Totalnovf'] :'0'."" ?>  ;
        var dataf12 = <?php echo  $getSaleByYearData[0]['Totaldecf'] ?  $getSaleByYearData[0]['Totaldecf'] :'0'."" ?> ;


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

        var datatex1b = <?php echo $getSaleByYearData[0]['Totalbjantax'] ?  $getSaleByYearData[0]['Totalbjantax'] :'0'."" ?>;
        var datatex2b = <?php echo $getSaleByYearData[0]['Totalbfebtax'] ?  $getSaleByYearData[0]['Totalbfebtax'] :'0'.""; ?>;
        var datatex3b = <?php echo $getSaleByYearData[0]['Totalbmarchtax'] ?  $getSaleByYearData[0]['Totalbmarchtax'] :'0'."" ?>;
        var datatex4b = <?php echo $getSaleByYearData[0]['Totalbaprltax'] ?  $getSaleByYearData[0]['Totalbaprltax'] :'0'."" ?>;
        var datatex5b = <?php echo $getSaleByYearData[0]['Totalbmaytax'] ?  $getSaleByYearData[0]['Totalbmaytax'] :'0'."" ?>;
        var datatex6b = <?php echo $getSaleByYearData[0]['Totalbjunetax'] ?  $getSaleByYearData[0]['Totalbjunetax'] :'0'."" ?>;
        var datatex7b = <?php echo $getSaleByYearData[0]['Totalbjulytax'] ?  $getSaleByYearData[0]['Totalbjulytax'] :'0'."" ?>;
        var datatex8b = <?php echo $getSaleByYearData[0]['Totalbaugusttax'] ?  $getSaleByYearData[0]['Totalbaugusttax'] :'0'."" ?>;
        var datatex9b = <?php echo $getSaleByYearData[0]['Totalbseptax'] ?  $getSaleByYearData[0]['Totalbseptax'] :'0'."" ?>;
        var datatex10b = <?php echo $getSaleByYearData[0]['Totalbocttax'] ?  $getSaleByYearData[0]['Totalbocttax'] :'0'."" ?>;
        var datatex11b = <?php echo $getSaleByYearData[0]['Totalbnovtax'] ?  $getSaleByYearData[0]['Totalbnovtax'] :'0'."" ?>;
        var datatex12b = <?php echo $getSaleByYearData[0]['Totalbdectax'] ?  $getSaleByYearData[0]['Totalbdectax'] :'0'."" ?>;

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
        var dataf11b = <?php echo $getSaleByYearData[0]['Totalbnovf'] ?  $getSaleByYearData[0]['Totalbnovf'] :'0'."" ?>;
        var dataf12b = <?php echo  $getSaleByYearData[0]['Totalbdecf'] ?  $getSaleByYearData[0]['Totalbdecf'] :'0'."" ?>;

        var currentYear = <?php echo date("Y") ?>;
        var lastYear = <?php echo date("Y",strtotime("-1 year")) ?>;

        Highcharts.chart('yearlyGrossSale', {
            chart: {
                type: 'column',
                spacingBottom: 30,
                height: 400
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: {
                    style: {
                        color: '#9b9b9b'
                    }
                },
                min: 0
            },
            yAxis: {
                gridLineColor: '#eaeaea',
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
                        return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                    }
                },
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                backgroundColor: '#fff',
                borderRadius: 10,
                formatter: function() {
                    return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
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
            series: [{
                lineWidth: 4,
                name: 'Yearly Gross Sales-'+ currentYear,
                type: "column",
                color: '#00a6ff',
                // showInLegend: false,
                data: [{y:data1, tax :datatex1 , fee :dataf1}, {y:data2, tax :datatex2 , fee :dataf2},{y:data3, tax :datatex3 , fee :dataf3},{y:data4, tax :datatex4 , fee :dataf4},{y:data5, tax :datatex5 , fee :dataf5},{y:data6, tax :datatex6 , fee :dataf6},{y:data7, tax :datatex7 , fee :dataf7},{y:data8, tax :datatex8 , fee :dataf8},{y:data9, tax :datatex9 , fee :dataf9},{y:data10, tax :datatex10 , fee :dataf10},{y:data11, tax :datatex11 , fee :dataf11},{y:data12, tax :datatex12 , fee :dataf12}]
            },{
                lineWidth: 4,
                name: 'Yearly Gross Sales-'+ lastYear,
                type: "column",
                color: '#1956a6',
                // showInLegend: false,
                data: [{y:datab1, tax :datatex1b, fee :dataf1b}, {y:datab2, tax :datatex2b, fee :dataf2b},{y:datab3, tax :datatex3b, fee :dataf3b},{y:datab4, tax :datatex4b, fee :dataf4b},{y:datab5, tax :datatex5b, fee :dataf5b},{y:datab6, tax :datatex6b, fee :dataf6b},{y:datab7, tax :datatex7b, fee :dataf7b},{y:datab8, tax :datatex8b, fee :dataf8b},{y:datab9, tax :datatex9b, fee :dataf9b},{y:datab10, tax :datatex10b, fee :dataf10b},{y:datab11, tax :datatex11b, fee :dataf11b},{y:datab12, tax :datatex12b, fee :dataf12b}]
            }]
        });
    };
</script>
<?php include_once'footer_graph.php'; ?>