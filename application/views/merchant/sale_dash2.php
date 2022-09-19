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
	currency_symbol = '$';
</script>
<style type="text/css">
	#sales_summery g.highcharts-series.highcharts-series-0,#sales_summery  g.highcharts-series.highcharts-series-2,#sales_summery  g.highcharts-markers.highcharts-series-0,#sales_summery  g.highcharts-markers.highcharts-series-2,#sales_summery  .highcharts-series-group >path:nth-child(1),#sales_summery  .highcharts-series-group >path:nth-child(3) {
		opacity: 0;
	}
    @media screen and (max-width: 1227px) {
        .form_buttons {
            text-align: left !important;
            display: flex !important;
        }
        div#daterange2 {
            font-size: 12px !important;
        }
        select#employee {
            font-size: 12px !important;
        }
    }
    @media screen and (max-width: 500px) {
        .grid-body {
            padding: 15px !important;
        }
        .table.info-table tr td {
            font-size: 10px !important;
        }
        .table:not(.table-bordered) thead tr th, .table:not(.table-bordered) tfoot tr th, table:not(.table-bordered) thead tr th, table:not(.table-bordered) tfoot tr th {
            font-size: 11px !important;
            font-weight: 600 !important;
            font-family: Avenir-Black !important;
        }
        .table.info-table tr th:first-child, table.info-table tr th:first-child {
            font-size: 11px !important;
            font-weight: 600 !important;
        }
    }
    @media screen and (min-width: 501px) {
        .table:not(.table-bordered) thead tr th, .table:not(.table-bordered) tfoot tr th, table:not(.table-bordered) thead tr th, table:not(.table-bordered) tfoot tr th {
            font-size: 15px !important;
            font-weight: 600 !important;
            font-family: Avenir-Black !important;
        }
        .table.info-table tr th:first-child, table.info-table tr th:first-child {
            font-size: 15px !important;
            font-weight: 600 !important;
        }
    }
    .table tfoot tr, table tfoot tr {
        border-top: 3px solid #f2f2f2 !important;
        border-bottom: 3px solid #f2f2f2 !important;
    }
    .table thead tr, table thead tr {
        border-bottom: 3px solid #f2f2f2 !important;
    }
    .table.info-table tr td, table.info-table tr td, .table.info-table tr td a, table.info-table tr td a {
        font-family: AvenirNext-Medium !important;
    }
    tr.breakrow {
        cursor: pointer !important;
    }
</style>
<!-- Start Page Content -->
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
                    <!-- <h4 class="h4-custom">Transaction Summary</h4> -->
                </div>
            </div>
            <!-- <form class="row" method="post" action="<?php echo base_url('graph/sale'); ?>" style="margin-bottom: 20px !important;margin-left: -11px !important;"> -->
            <form class="row" method="post" action="<?php echo base_url('graph/download_reports'); ?>" style="margin-bottom: 20px !important;margin-left: -11px !important;">
            	<div class="col-sm-6 col-md-6 col-lg-6" style="margin-top: 5px !important;">
					<div class="row">
						<div class="custom_range_selector">
                            <div class="form-group">
                                <div id="daterange2" class="form-control" style="background-color: #f5f5fb !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;border: 1px solid transparent !important;">
                                    <span><?php echo date("F-d-Y",strtotime("-5 days"));?> - <?php echo date("F-d-Y");?></span>
                                    <input type="hidden" name="start_date" id="startDate" value="<?php echo date("Y-m-d",strtotime("-5 days"));?>">
                                    <input type="hidden" name="end_date" id="endDate" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                        </div>
				
						<div class="custom_employee_selector">
							<?php
							$merchant_id = $this->session->userdata('merchant_id');
							$data = $this->admin_model->data_get_where_1('merchant', array('merchant_id' => $merchant_id)); ?>
							<select name="employee" class="form-control" id="employee" 
							onchange="saleChart();" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
								<option value="all">Select Employee</option>
								<!-- <option value="merchant"> Merchant</option> -->
								<?php foreach ($data as $view) { ?>
									<option value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 form_buttons" style="text-align: right;">
                    <!-- <input name="start_date" id="start_date" value="" type="hidden">
                    <input name="end_date" id="end_date" value="" type="hidden">
                    <input name="status" type="hidden" value=""> -->

					<button class="btn btn-rounded social-btn-outlined" type="submit" name="search_Submit" value="Search"><i class="mdi mdi-arrow-down small"></i>PDF</button>
					<button class="btn btn-rounded social-btn-outlined" type="submit" name="excel_export" value="Excel" style="margin-left: 10px;"><i class="mdi mdi-arrow-down medium"></i>Excel</button>
					<button class="btn btn-rounded social-btn-outlined" type="submit" name="csv_export" value="CSV" style="margin-left: 10px;"><i class="mdi mdi-arrow-down small"></i>CSV</button>
				</div>
            </form>
            
            <div class="row">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <p class="h4-custom">Sales Summary</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div id="sales_summery" height="350"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 10px !important">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <p class="h4-custom">Time of Day</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div id="sales_time_of_day2" height="350"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 10px !important">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="grid">
								<div class="item-wrapper">
									<div class="table-responsive">
										<table id="report" class="table info-table">
											<thead>
												<tr>
													<th width="55%"></th>
													<th>Sales</th>
													<th>Refunds</th>
													<th>Net</th>
												</tr>
											</thead>
                                            <tbody></tbody>
											<tfoot></tfoot>
										</table>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->

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
        var start = moment().subtract(7, 'days');
        var end = moment();
        // console.log(start, end);return false;

        function cb(start, end) {
            $('#daterange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // console.log(start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));
            $('#startDate').val(start.format('YYYY-MM-D'));
            $('#endDate').val(end.format('YYYY-MM-D'));

            saleChart();
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
    
	function setNullToZero(vals) {
		var valss =isNaN(vals)? 0 : (vals == null? 0: parseFloat(vals));
		return valss;
	}

    var loading = $('#report tbody .loading').hide().clone();
    var nodata = $('#report tbody .nodata').hide().clone();
    var timeout = $('#report tbody .timeout').hide().clone();

    function saleChart() {
        $("#sales_summery").empty();
        $('#sales_time_of_day2').empty();
        $('#sales_time_of_day2').addClass('custom_loading');
        $('table#report > tbody').empty();
        
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var employee =  $('#employee').val();
        // console.log(startDate, endDate);return false;

        if (typeof startDate != 'undefined' && typeof endDate != 'undefined'  && startDate != null & endDate != null ) {
            var postData = {
                all : 1,
                start       : startDate,
                end         : endDate,
                goal : encodeURIComponent(userprefs.goal),
                metric1 : userprefs.metric1,
                metric2 : userprefs.metric2,
                units : userprefs.units,
                employee : employee,
            };
        } else {
            var postData = {
                all : 1,
                start : startDate,
                end : endDate,
                goal : encodeURIComponent(userprefs.goal),
                metric1 : userprefs.metric1,
                metric2 : userprefs.metric2,
                units : userprefs.units,
                employee : employee,
            };
        }

        $.ajax({
            type    : 'POST',
            url     : "<?= base_url('Graph/getSalesSummaryChartData'); ?>",
            data    : postData,
            success : function (data){
                // console.log(data);return false;
                var data = JSON.parse(data);

                if (data.length != 0) {
                    var summaryData = data.summaryData;
                    var summaryTableData = data.summaryTableData;
                    // console.log(summaryTableData);return false;
                    
                    getSalesData('sales_summery', summaryData);
                    getTable(summaryTableData);

                    $.ajax({
                        type    : 'POST',
                        url     : "<?= base_url('Graph/getTODChartData'); ?>",
                        data    : postData,
                        success : function (todData) {
                            var todData = JSON.parse(todData);
                            // console.log(todData);return false;
                            var getDashboardData = todData.getDashboardData[0];
                            timeOfTheDayChart(getDashboardData);
                        }
                    });
                    
                }
            }
        });
    }

	function getSalesData(a, b) {
        if(typeof b =='undefined'){
            return;
        }
        var c = {
            global: {
                useUTC: !1
            },
            chart: {
                type: 'areaspline',
              // width: chart_width,
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
                // shadow: !1,
                backgroundColor: '#fff',
                borderRadius: 10,
                shared: !0,
                formatter: function(a) {
                    var b = parseInt(this.points[0].y) == this.points[0].y ? this.points[0].y : this.points[0].y.toFixed(2),
                    b =isNaN(b)?0:(b!=''?b:0),
                    c = (this.points[1] != undefined) ? (parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2)): 0,
                    fee = (this.points[2] != undefined) ? parseInt(this.points[2].y) == this.points[2].y ? this.points[2].y : this.points[2].y.toFixed(2) : 0,
                    d = '<span ><b>' + moment(this.x).format("dddd, MMM D, YYYY") + "</b></span>",
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

    function timeOfTheDayChart(getDashboardData) {
        // console.log(getDashboardData);return false;
        dataTimeDayVals=[];
        for(index=0;index < 24 ; index++){
             var valY=setNullToZero((getDashboardData['Total_today_'+index+'timea']));
             var valTax=setNullToZero((getDashboardData['Total_today_'+index+'timetax']));
             var valAvg=setNullToZero((getDashboardData['Total_today_'+index+'timefee']));
             var newObjt={y:valY,tax:valTax,avg:valAvg};
             dataTimeDayVals.push(newObjt);
        }
        // salesTimeDayChart(dataTimeDayVals);
        // console.log(dataTimeDayVals);return false;

        Highcharts.chart('sales_time_of_day2', {
            chart: {
              type: 'areaspline',
              spacingBottom: 30
              // width: chart_width
            },
            title: {
              text: null
            },
            xAxis: {
              categories: ['00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00', '12:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00'],

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

              tickInterval: 5000,
              min: 0,
              labels: {
                formatter: function() {
                  return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                }
              },
              //min: 5000
            },
            exporting: {
              enabled: false
            },
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 4000
                    },
                    chartOptions: {
                        yAxis: {
                            labels: {
                                align: 'center'
                            }
                        }
                    }
                }]
            },
            tooltip: {
              backgroundColor: '#fff',
              borderRadius: 10,
              formatter: function() {
                return '<b>' + this.x + '</b><br/>' + '<span style="color: #868e96">Amount' + ':</span> <span style="color:#FDAC42;font-weight:600;">$' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #868e96">' + 'Avg Transaction:</span> <span style="color:#AC5DD9;font-weight:600;">$' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #868e96">Tax:</span> <span style="color:#D0021B;font-weight:600;">$' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
              }
            },
            credits: {
              enabled: false
            },
            plotOptions: {
              areaspline: {
                fillOpacity: 0.1,
                marker: {
                  fillColor: "#fff",
                  lineWidth: 2,
                  lineColor: null,
                  // lineWidth: 3,
                  symbol: 'circle'
                },
              }
            },
            series: [{
              // name: 'Time of Day',
              type: "areaspline",
              // color: '#00a6ff',
              showInLegend: false,
              data: dataTimeDayVals
            }]
        });
    }

	// function updateTimeOfDay(){
	// 	var employee =  $('#employee').val(); 
	// 	var start=$("#daterange2 span").data().d1;
	// 	var end=$("#daterange2 span").data().d2;
	// 	// console.log(end)
	// 	$('#end_date').val(end);
	// 	$('#start_date').val(start);
	// 	$.ajax({
	// 	type: 'POST',
	// 	url: "<?php  echo base_url('graph/sale'); ?>",
	// 	data: {start: start , end : end },
	// 	type:'post',
	// 	success: function(dataJson){
	// 		// console.log(dataJson);return false;
	// 		var data = JSON.parse(dataJson);
	// 		// console.log(data);
	// 		dataTimeDayVals=[];
	// 		for(index=0;index < 24 ; index++){
	// 			var valY=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timea']));
	// 			var valTax=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timetax']));
	// 			var valAvg=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timefee']));
	// 			var newObjt={y:valY,tax:valTax,avg:valAvg};
	// 			dataTimeDayVals.push(newObjt);
	// 		}
	// 		salesTimeDayChart(dataTimeDayVals);
	// 		$('#sales_summery').data('vals',data.item3);
	// 		saleSummeryPdfTableConvertor($('#salesSummeryChartExportDt'),data.item3,data.item5);
	// 	}
	// 	});
	// }
	
	$(document).on('click', '.breakrow', function(e) {
	    if ($(".breakrow").hasClass("active")) {
	        $('.datarow').addClass('d-none');
	        $('.breakrow').removeClass('active');
	    } else {
	        $('.datarow').removeClass('d-none');
	        $('.breakrow').addClass('active');
	    }
	})
	
	function getTable(data) {
        var check_merchant = "<?= $this->session->userdata('employee_id') ? 'EMP' : 'MER' ?>";
	    var html = '', clicks = 0, people = 0,  converted_people = 0;
        if (data.length == 0) {
            $('#report tbody').html(nodata.html());
            
        } else {
            $.each(data, function( key, value ) {
                if (key != 'empTip') {
                    // console.log(value);
                    
                    var label = value['label'];
                    //console.log(label);
                    //data for tbody
                    if (value['label'] == null || value['label'] == '') {
                        label = '[ No Source ]';                
                    }
                    if(label != 'Fee') {
                        
                        if(label == 'Tip') {
                            if (check_merchant == 'MER') {
                                if(employee != 'merchant') {
                                    html += '<tr class="breakrow">';
                                } else {
                                    html += '<tr>';
                                }
                                
                            } else {
                                html += '<tr>';
                            }
                                
                            
                            var url = '';
                            html += '<td style="text-align: left;font-weight:600;color:#000;" class="ellipsis">';
                            
                            if (label.length > 40 && (label.substr(0, 7) == 'http://' || label.substr(0,8) == 'https://')) {
                                //html += '<a href="javascript:void(0)" title="' + label + '">' + label + '</a>';
                                if(employee != 'merchant') {
                                    if (check_merchant == 'MER') {
                                        html += '<span style="color:#007bff">' + label + '</span>';
                                    } else {
                                        html += label;
                                    }
                                    
                                } else {
                                    html += label;
                                }
                                
                            } else {
                                //html += '<a href="javascript:void(0)">' + label + '</a>';
                                if(employee != 'merchant') {
                                    if (check_merchant == 'MER') {
                                        html += '<span style="color:#007bff">' + label + '</span>';
                                    } else {
                                        html += label;
                                    }
                                    
                                } else {
                                    html += label;
                                }
                            }
                            html += '</td>';
                            html += '<td>' + format_money(value['SaleAmount']) + '</td>';
                            html += '<td>' + format_money(value['RefundAmount']) + '</td>';
                            html += '<td>' + format_money(value['NetAmount']) + '</td>';
    
                            html += '</tr>';
                            
                            if (data['empTip'] != []) {
                                $.each(data['empTip'], function( index, emp ) {
                                    html += '<tr class="datarow d-none">';
                                    html += '<td>'+ emp['EmpName'] +'</td><td>'+ emp['SalesTip'] +'</td><td>'+ emp['RefundTip'] +'</td><td>'+ emp['NetTip'] +'</td>';
                                    html += '</tr>';
                                });
                            }
                            
                        } else {
                            html += '<tr>';
                            
                            var url = '';
                            html += '<td style="text-align: left;font-weight:600;color:#000;" class="ellipsis">';
                            
                            if (label.length > 40 && (label.substr(0, 7) == 'http://' || label.substr(0,8) == 'https://')) {
                                //html += '<a href="javascript:void(0)" title="' + label + '">' + label + '</a>';
                                html += label;
                                
                            } else {
                                //html += '<a href="javascript:void(0)">' + label + '</a>';
                                html += label;
                            }
                            html += '</td>';
                            html += '<td>' + format_money(value['SaleAmount']) + '</td>';
                            html += '<td>' + format_money(value['RefundAmount']) + '</td>';
                            html += '<td>' + format_money(value['NetAmount']) + '</td>';
    
                            html += '</tr>';
                        }

                        // clicks += parseFloat(value['RefundAmount']);
                        // people += parseFloat(value['SaleAmount']);
                        // converted_people += parseFloat(value['NetAmount']);

                        
                    }
                }
            });
            
            $('#report tbody').html(html);
            //data for tfoot
            // html = '<tr>';
            // html += '<th>Total</th>';
            // html += '<th> $' + add_commas(people.toFixed(2)) + '</th>';
            // html += '<th> $' + add_commas(clicks.toFixed(2)) + '</th>';
            // html += '<th> $' + add_commas(converted_people.toFixed(2)) + '</th>';
            // html += '</tr>';
            // $('#report tfoot').html(html);
        }
	}
	
	// $(function(){
	// 	getGraph();
	// 	setTimeout(function(){updateTimeOfDay();},50)
	// 	getTable();
	// })
</script>

<?php include_once'footer_dash.php'; ?>