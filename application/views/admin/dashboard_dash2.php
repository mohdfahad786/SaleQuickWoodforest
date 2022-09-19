<?php
include_once'header_dash.php';
include_once'sidebar_dash.php';
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
	<input type="pos" name="pos" id="pos" value="<?php echo number_format(($getDashboardData[0]['TotalAmountPOS']/$total)*100,2); ?>">
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
		top: 9px;
		right: 15px;
	}
	#salesChartExportDt button.dt-button.buttons-collection{
		margin: 0 !important
	}
	#salesChartExportDt.reset-dataTable .dt-buttons {
		padding-top: 0px;
	}
	#salesChartExportDt table{
		display: none;
		width: 100%;
	}
	#salesChartExportDt div.dt-button-collection{
		left: auto !important;
		right: 0;
	}
	.summary-grid-text-section h1 {
		margin: 0 !important;
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
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="newtotalorders head-count-val"><?php echo $getDashboardData[0]['TotalOrders'] + $getDashboardData[0]['TotalPosorder'];?></h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-2.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Total Confirm</p>
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
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="totalpendingorders head-count-val" style="color: #000 !important;"><?php echo $getDashboardData[0]['TotalpendingOrders'];?></h1>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-1.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="summary-grid-status">Total Pending</p>
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
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <h1 class="totalorders head-count-val" style="color: #000 !important;"><?php echo $getDashboardData[0]['NewTotalOrders'] + $getDashboardData[0]['TotalPosordernew']; ?></h1>
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
                    <?php $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active' , 'user_type' => 'merchant')); ?>
                    <select name="employee" class="form-control" id="employee" onchange="onSelectChange3();getGraph();" style="background-color: #f5f5fb !important;border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
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
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <p class="h4-custom">Sales Chart</p>
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
            <!-- <div class="row" style="margin-top: 20px !important;">
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
            </div> -->
        </div>
    </div>
</div>

<script>
	$(function() {
	    var start = moment().subtract(10, 'days');
	    var end = moment();

	    function cb(start, end) {
	        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
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
    })
</script>

<script>
	function onSelectChange3() {
		if(!start){
			var start=$("#daterange #startDate").val();
			var end=$("#daterange #endDate").val();
		}
      var employee =  $('#employee').val();

        $('.order_charts_wrapper').empty();
        $('.order_charts_wrapper').html('<div id="order_charts"></div>');

        var order_charts_img = "<?php echo base_url('new_assets/img/orderCharts.png') ?>";
        // console.log(start + end + employee)
        $.ajax({
            type: 'POST',
            url: "<?php  echo base_url('dashboard/index1'); ?>",
            data: {start: start, end : end, employee : employee},
            type:'post',
            success: function (data){
                var data = JSON.parse(data)

                var a= data.getDashboardData[0].TotalAmount;
                var b= data.getDashboardData[0].TotalAmountRe;
                var c= data.getDashboardData[0].TotalAmountPOS;

                var t1=isNaN(parseFloat(a)) ? 0: (isNaN(parseFloat(a)) == null ? 0: parseFloat(a));
                var t2=isNaN(parseFloat(b)) ? 0: (isNaN(parseFloat(b)) == null ? 0: parseFloat(b));
                var t3=isNaN(parseFloat(c)) ? 0: (isNaN(parseFloat(c)) == null ? 0: parseFloat(c));

                t11 = t1.toFixed(2);
                t21 = t2.toFixed(2);
                t31 = t3.toFixed(2);

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
                
                p1 = Math.round(p1);
                p2 = Math.round(p2);
                p3 = Math.round(p3);

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

                // $('#saleChart').data('vals',data.item3);
                // saleSummeryPdfTableConvertor($('#salesChartExportDt'),data.item3,data.item5);

                // $('.newtotalorders').html(data.widgets_data.NewTotalOrders); 
                // $('.totalorders').html(data.widgets_data.TotalOrders); 
                // $('.totalpendingorders').html(data.widgets_data.TotalpendingOrders); 
                // $('.totallate').html(data.widgets_data.TotalLate);

                $('.newtotalorders').html(data.widgets_data.NewTotalOrders);
	            $('.totalorders').html(data.widgets_data.TotalConfirmOrders);
	            $('.totalpendingorders').html(data.widgets_data.TotalpendingOrders);
	            $('.totallate').html(data.widgets_data.TotalFaildOrders);
            }
        });
	}
</script> 

<script type="text/javascript">
  	window.onload = function() {
  	  	$("#graph").val("");
  		$("#graph").html("");
  	  	// getGraph();
  	};

  	$(document).ready(function() {
  		$("#graph").val("");
  		$("#graph").html("");
  		getGraph();
  		onSelectChange3();
  	});

  	function getGraph(start, end, employee) {
    	if(!start){
    	  	var start=$("#daterange #startDate").val();
    	  	var end=$("#daterange #endDate").val();
    	}

    	var employee =  $('#employee').val();
    	// $('#graph .placeholder').html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px">Loading...</div>');
    	// $('#graph h1, #graph h2').html('&nbsp;');
    	// $('#graph .metric1 h1').html('<i class="fa fa-spinner fa-spin"></i>');
    	var jsonurl = '<?php echo base_url('merchant-panel'); ?>/graph/graph_dashboard.php?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>';
    	jsonurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
    	jsonurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2 + '&units=' + userprefs.units +'&employee=' + employee ;
    	if (typeof location.search == 'string' && location.search.length > 0)
    	  	jsonurl += '&' + location.search.substring(1);
    	if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null )
    	  	jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) ;
    	$.getJSON(jsonurl, function(data) {
    	  	if (data.length != 0) imGraph('graph', data);
    	});
  	}

  	function downloadGraph() {
  	  	var dlurl = '<?php echo base_url('merchant-panel'); ?>/graph/graph_dashboard.php?filters[ad]=1&start=<?php echo $last_date; ?>&end=?php echo $date; ?>';
    	dlurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
    	dlurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2;
    	if (typeof location.search == 'string' && location.search.length > 0)
    	  	dlurl += '&' + location.search.substring(1);
    	window.location = dlurl;
  	}

  	function reset(percent,divid,text,parecent) {
  	  	$("#"+divid).remove();
  	  	$divid=$('<div id="'+divid+'"></div>');
  	  	$("#"+percent).prepend($divid);
  	  	$divid.attr("data-dimension", "121");
  	  	$divid.attr("data-width", "8");
  	  	$divid.attr("data-fontsize", "21");
  	  	$divid.attr("data-fgcolor", "#2273dc");
  	  	$divid.attr("data-bgcolor", "#e8e8e8");
  	  	$divid.attr("data-percent", parecent.toString());
  	  	$divid.circliful();
  	}

  	function reset1(percent,divid,text,parecent) {
    	$("#"+divid).remove();
    	$divid=$('<div id="'+divid+'"></div>');
    	$("#"+percent).prepend($divid);
    	$divid.attr("data-dimension", "121");
    	$divid.attr("data-width", "8");
    	$divid.attr("data-fontsize", "21");
    	$divid.attr("data-fgcolor", "#2273dc");
    	$divid.attr("data-bgcolor", "#e8e8e8");
    	$divid.attr("data-percent", parecent.toString());
    	$divid.circliful();
  	}

  	function reset2(percent,divid,text,parecent) {
    	$("#"+divid).remove();
    	$divid=$('<div id="'+divid+'"></div>');
    	$("#"+percent).prepend($divid);
    	$divid.attr("data-dimension", "121");
    	$divid.attr("data-width", "8");
    	$divid.attr("data-fontsize", "21");
    	$divid.attr("data-fgcolor", "#2273dc");
    	$divid.attr("data-bgcolor", "#e8e8e8");
    	$divid.attr("data-percent", parecent.toString());
    	$divid.circliful();
  	}
</script>
<?php include_once'footer_dash.php'; ?>