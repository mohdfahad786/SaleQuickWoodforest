<?php  
$last_date = date("Y-m-d",strtotime("-29 days"));
$date = date("Y-m-d");
$merchant_id = '';
$t_fee = '';
?>

<?php
include_once 'header_graph.php';
include_once 'sidebar_dash.php';
?>

<style type="text/css">
	.selectbox {
		background: #fff;
		color: #333;
		border-radius: 4px;
		height: 38px !important;
		padding: 6px 12px !important;
		line-height: 28px !important;
		border-width: thin !important;
	}
	.custom_loading {
		position: relative;
		height: 400px;
	}
	.custom_loading:before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		/*background: rgba(255,255,255,0.8);*/
		z-index: 99;
	}
	.custom_loading:after {
		content: "Loading...";
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translateX(-50%) translateY(-50%);
		font-size: 18px;
		/*z-index: 999;*/
	}
	.sales-summery .table > thead > tr > th {
		font-size: 16px;
		color: #9b9b9b;
		background-color: transparent !important;
	}
	.sales-summery  .table thead th {
		vertical-align: bottom;
		border-bottom: 2px solid #e9ecef !important;
	}
	.sales-summery .table-responsive{
		overflow-x: auto;
	}
	#salesSummeryChartExportDt{
		float: right;
	}
	#salesSummeryChartExportDt button.dt-button.buttons-collection{
		margin: 0 !important
	}
	#salesSummeryChartExportDt.reset-dataTable .dt-buttons{
		padding-top: 4px;
	}
	div.dt-buttons {
		display: block !important;
	}

	#salesSummeryChartExportDt table{
		display: none;
		width: 100%;
	}
	#salesSummeryChartExportDt div.dt-button-collection{
		left: auto !important;
		right: 0;
		display: block;
		margin-top: 0px !important;
	}
	#sales_summery g.highcharts-series.highcharts-series-0,#sales_summery  g.highcharts-series.highcharts-series-2,#sales_summery  g.highcharts-markers.highcharts-series-0,#sales_summery  g.highcharts-markers.highcharts-series-2,#sales_summery  .highcharts-series-group >path:nth-child(1),#sales_summery  .highcharts-series-group >path:nth-child(3) {
		opacity: 0;
	}
    @media screen and (max-width: 1227px) {
        .form_buttons {
            text-align: left !important;
            display: flex !important;
        }
        div#daterange {
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
    .table>tbody>tr>td, table>tbody>tr>td {
        border-bottom: 2px solid #f2f2f2 !important;
    }
    .table.info-table tr td, table.info-table tr td, .table.info-table tr td a, table.info-table tr td a {
        font-family: AvenirNext-Medium !important;
    }
    #report tfoot td, #report th {
	    background: #fff !important;
	}
	.table tbody tr, table tbody tr {
		height: 40px !important;
	}
	.table tbody tr td span, table tbody tr td span {
	    display: block !important;
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
                    <!-- <h4 class="h4-custom">Transaction Summary</h4> -->
                </div>
            </div>

            <div class="row employee_date_range" style="margin-bottom: 10px !important;margin-left: -11px !important;">
            	<div class="col-sm-6 col-md-6 col-lg-6" style="margin-top: 5px !important;">
					<div class="row">
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
		                    <?php  $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active', 'user_type' => 'merchant')); ?>
		                    <select name="employee" class="form-control" id="employee" onchange="salesChart();" style="background-color: #f5f5fb !important;border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
		            			<option  value="all" >Select Merchant</option>
		        				<?php foreach ($data as $view) { ?>
									<option  value="<?php echo $view['id']; ?>"><?php if(empty($view['business_dba_name'])){echo $view['name'];} else {echo $view['business_dba_name'];} ?></option>
								<?php } ?>
		      				</select>
		                </div>
		            </div>
		        </div>

		        <div class="col-sm-6 col-md-6 col-lg-6 form_buttons" style="text-align: right;">
		        	<div id="salesSummeryChartExportDt" class="reset-dataTable"> </div>
		        </div>
            </div>
            
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
                                <div id="sales_summery" height="350"> </div>
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
                                <div id="sales_time_of_day" height="350"> </div>
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
											<tbody>
											</tbody>
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

<script type="text/javascript">
	currency_symbol = '$';

	var userprefs = {
		goal: 'all',
		employee: 'all',
		merchant: '<?php echo $merchant_id; ?>',
		fee: '<?php echo $t_fee; ?>',
		metric1: 'amount',
		metric2: 'conversions',
		metric3: 'cost',
		units: 'days',
		start: '<?php echo $last_date; ?>',
		end: '<?php echo $date; ?>',
		timezone: 'America/New_York',
		plan_id: 3
	};

	var dtConfigHiddenTable = {
		dom: 'B', destroy: true, order: [],
		"buttons": [
      		{
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
      		}
    	]
	};

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
	    	$('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	        $('#startDate').val(start.format('YYYY-MM-D'));
	        $('#endDate').val(end.format('YYYY-MM-D'));

	        // getGraphsAndTables();
	        salesChart();
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
</script>

<script type="text/javascript">
	var loading = $('#report tbody .loading').hide().clone();
	var nodata = $('#report tbody .nodata').hide().clone();
	var timeout = $('#report tbody .timeout').hide().clone();

	function salesChart() {
		$("#sales_summery").empty();
        $('#sales_time_of_day').empty();
        $('#sales_time_of_day').addClass('custom_loading');
        $('table#report > tbody').empty();
        $('#salesSummeryChartExportDt').empty();
		
		var startDate = $('#startDate').val();
		var endDate = $('#endDate').val();
		var employee =  $('#employee').val();
		// console.log(startDate, endDate);return false;

		if (typeof startDate != 'undefined' && typeof endDate != 'undefined'  && startDate != null & endDate != null ) {
			var postData = {
				all	: 1,
				start 		: startDate,
	    		end 		: endDate,
				goal : encodeURIComponent(userprefs.goal),
				metric1 : userprefs.metric1,
				metric2 : userprefs.metric2,
				units : userprefs.units,
				employee : employee,
			};
		} else {
			var postData = {
				all	: 1,
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
            type 	: 'POST',
            url 	: "<?= base_url('Admin_Graph/getSalesSummaryChartData'); ?>",
            data 	: postData,
            success : function (data){
            	var data = JSON.parse(data);
            	// console.log(data);return false;

            	if (data.length != 0) {
	            	var summaryData = data.summaryData;
	            	// var summaryTableData = data.summaryTableData;
	            	
	            	getSalesData('sales_summery', summaryData);

	            	$.ajax({
			            type 	: 'POST',
			            url 	: "<?= base_url('Admin_Graph/getSalesSummaryTableData'); ?>",
			            data 	: postData,
			            success : function (data_new){
			            	var data_new = JSON.parse(data_new);
			            	// console.log(data);return false;

			            	if (data_new.length != 0) {
			            		var summaryTableData = data_new.summaryTableData;
			            		getTable(summaryTableData);

				            	$.ajax({
			                        type    : 'POST',
			                        url     : "<?= base_url('Admin_Graph/getTODChartData'); ?>",
			                        data    : postData,
			                        success : function (todData) {
			                        	var todData = JSON.parse(todData);
			                            // console.log(todData);return false;
			                            var getDashboardData = todData.getDashboardData[0];
						            	timeOfTheDayChart(getDashboardData);

					                    $.ajax({
					                        type    : 'POST',
					                        url     : "<?= base_url('Admin_Graph/getSalesSummaryReportData'); ?>",
					                        data    : postData,
					                        success : function (reportData) {
					                            var reportData = JSON.parse(reportData);
					                            // console.log(reportData);return false;
					                            saleSummeryPdfTableConvertor($('#salesSummeryChartExportDt'),reportData.item3,reportData.item5);
					                        }
					                    });
			                        }
			                    });
			            	}
			            }
			        });
                }
            }
        });
	}

	function getSalesData(a, b) {
		// console.log(b);return false;
		var c = {
			global: {
				useUTC: !1
			},
			chart: {
                type: 'areaspline',
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
					f = '<span style="color: #868e96">' + a.chart.series[1].name + ':</span> <span style="color:#AC5DD9;font-weight:600;"> $' + parseFloat(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + "</span> <br/>" + '<span style="color: #868e96">' + "Fee  :" + '</span> <span style="color:#D0021B;font-weight:600;"> $' + parseFloat(fee).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span>';
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

			// console.log(b);return false;
			for (var k in b)
				if (b[k].convrate = 0 == b[k].amount ? 0 : (b[k].tax / b[k].amount * 100).toFixed(2), b[k].cpa = 0 == b[k].tax ? 0 : b[k].cost / b[k].conversions, b[k].cpc = 0 == b[k].clicks ? 0 : b[k].cost / b[k].clicks, b[k].rpp = 0 == b[k].people ? 0 : b[k].revenue / b[k].people, b[k].profit = b[k].revenue - b[k].cost, null != b[k].date && 0 != b[k].date.length) {

					var l = parseFloat(b[k][d]);
					h.push([moment(b[k].date).valueOf(), l]);
					var l = parseFloat(b[k][f]);
					i.push([moment(b[k].date).valueOf(), l])
					var l = parseFloat(b[k].cost);
					fee.push([moment(b[k].date).valueOf(), l])

				} else j = b[k];
					0 == j.length && b[0] && (j = b[0]), c.series[0].name = e, c.series[0].data = h, c.series[0].pointStart = h[0][0].valueOf(), c.series[1].name = g, c.series[1].data = i, c.series[1].pointStart = i[0][0].valueOf(), c.series[2].name = "Fee", c.series[2].data = fee, c.series[2].pointStart = i[0][0].valueOf(), $("#" + a + " .placeholder").length > 0 ? c.chart.renderTo = $("#" + a + " .placeholder")[0] : c.chart.renderTo = $("#" + a)[0];
					var m, n;
					m = "cost" == d || "cpa" == d || "cpc" == d || "revenue" == d || "rpp" == d || "profit" == d ? format_money(j[d]) : "convrate" == d ? format_rate(j[d] / 100) : add_commas(j[d]), n = "cost" == f || "cpa" == f || "cpc" == f || "revenue" == f || "rpp" == f || "profit" == f ? format_money(j[f]) : "convrate" == f ? format_rate(j[f] / 100) : add_commas(j[f]),
					$(".metric1 h1").html(m), $(".metric1 h2").html(e), $(".metric2 h1").html(n), $(".metric2 h2").html(g),
					graph = new Highcharts.Chart(c), graphData = b
	}

	function getTable(tableData) {
		var html = '', clicks = 0, people = 0, conversions = 0, converted_people = 0, revenue = 0, cost = 0;
		if (tableData.length == 0) {
			$('#report tbody').html(notableData.html());
		} else {
			for (var row in tableData) {
				var label = tableData[row]['label'];
				if (tableData[row]['label'] == null || tableData[row]['label'] == '') {
					label = '[ No Source ]';
				}
				html += '<tr>';
				var url = '';
				if (label.length > 40 && (label.substr(0, 7) == 'http://' || label.substr(0,8) == 'https://'))
					html += '<td style="text-align: left;font-weight:600;color:#000;" class="ellipsis">'+label+'</td>';
				else
					html += '<td style="text-align: left;font-weight:600;color:#000;" class="ellipsis">'+label+'</td>';
				
				var url = '/reports/webshop/people?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(tableData[row]['label']);
				html += '<td>' + format_money(tableData[row]['people']) + '</td>';
				var url = '/reports/webshop/clicks?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(tableData[row]['label']);
				html += '<td>' + format_money(tableData[row]['clicks']) + '</td>';
				var url = '/reports/webshop/conversions?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(tableData[row]['label']) + '&goal=' + encodeURIComponent(userprefs.goal);
				html += '<td>' + format_money(tableData[row]['converted_people']) + '</td>';
				var url = '/reports/webshop/conversions?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(tableData[row]['label']) + '&goal=' + encodeURIComponent(userprefs.goal);
				html += '</tr>';
				clicks += parseInt(tableData[row]['clicks']);
				people += parseInt(tableData[row]['people']);
				converted_people += parseInt(tableData[row]['converted_people']);
				conversions += parseInt(tableData[row]['conversions']);
				revenue += parseFloat(tableData[row]['revenue']);
				cost += parseFloat(tableData[row]['cost']);
			}
			$('#report tbody').html(html);
		}
		html = '<tr>';
		html += '</tr>';
		$('#report tfoot').html(html);
	}

	function timeOfTheDayChart(todData) {
		points = [
			{y: eval(todData.Totaljan) ? eval(todData.Totaljan) : 0, fee: eval(todData.Totaljanfee) ? eval(todData.Totaljanfee) : 0, tax: eval(todData.Totaljantax) ? eval(todData.Totaljantax) : 0},
			{y: eval(todData.Totalfeb) ? eval(todData.Totalfeb) : 0, fee: eval(todData.Totalfebfee) ? eval(todData.Totalfebfee) : 0, tax: eval(todData.Totalfebtax) ? eval(todData.Totalfebtax) : 0},
			{y: eval(todData.Totalmarch) ? eval(todData.Totalmarch) : 0, fee: eval(todData.Totalmarchfee) ? eval(todData.Totalmarchfee) : 0, tax: eval(todData.Totalmarchtax) ? eval(todData.Totalmarchtax) : 0},
			{y: eval(todData.Totalaprl) ? eval(todData.Totalaprl) : 0, fee: eval(todData.Totalaprlfee) ? eval(todData.Totalaprlfee) : 0, tax: eval(todData.Totalaprltax) ? eval(todData.Totalaprltax) : 0},
			{y: eval(todData.Totalmay) ? eval(todData.Totalmay) : 0, fee: eval(todData.Totalmayfee) ? eval(todData.Totalmayfee) : 0, tax: eval(todData.Totalmaytax) ? eval(todData.Totalmaytax) : 0},
			{y: eval(todData.Totaljune) ? eval(todData.Totaljune) : 0, fee: eval(todData.Totaljunefee) ? eval(todData.Totaljunefee) : 0, tax: eval(todData.Totaljunetax) ? eval(todData.Totaljunetax) : 0},
			{y: eval(todData.Totaljuly) ? eval(todData.Totaljuly) : 0, fee: eval(todData.Totaljulyfee) ? eval(todData.Totaljulyfee) : 0, tax: eval(todData.Totaljulytax) ? eval(todData.Totaljulytax) : 0},
			{y: eval(todData.Totalaugust) ? eval(todData.Totalaugust) : 0, fee: eval(todData.Totalaugustfee) ? eval(todData.Totalaugustfee) : 0, tax: eval(todData.Totalaugusttax) ? eval(todData.Totalaugusttax) : 0},
			{y: eval(todData.Totalsep) ? eval(todData.Totalsep) : 0, fee: eval(todData.Totalsepfee) ? eval(todData.Totalsepfee) : 0, tax: eval(todData.Totalseptax) ? eval(todData.Totalseptax) : 0},
			{y: eval(todData.Totaloct) ? eval(todData.Totaloct) : 0, fee: eval(todData.Totaloctfee) ? eval(todData.Totaloctfee) : 0, tax: eval(todData.Totalocttax) ? eval(todData.Totalocttax) : 0},
			{y: eval(todData.Totalnov) ? eval(todData.Totalnov) : 0, fee: eval(todData.Totalnovfee) ? eval(todData.Totalnovfee) : 0, tax: eval(todData.Totalnovtax) ? eval(todData.Totalnovtax) : 0},
			{y: eval(todData.Totaldec) ? eval(todData.Totaldec) : 0, fee: eval(todData.Totaldecfee) ? eval(todData.Totaldecfee) : 0, tax: eval(todData.Totaldectax) ? eval(todData.Totaldectax) : 0},
		];
		// console.log(points);return false;
		
		//console.log(data)
		Highcharts.chart('sales_time_of_day', {
			chart: {
	          	type: 'areaspline',
	          	spacingBottom: 30
	        },
			title: {
				text: null
			},
			xAxis: {
	 			categories: ['04:00 AM', '05:00 AM', '06:00 AM', '07:00 AM', '08:00 AM', '09:00 AM' ,'10:00 AM' ,'11:00 AM' ,'12:00 PM' ,'01:00 PM' ,'02:00 PM' ,'03:00 PM' ,'04:00 PM'],            
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
				//step: 9000,
				labels: {
					formatter: function() {
						return ((this.value/1000) > 0 ? ((this.value/1000) + 'k') : (this.value/1000));
					}
				},
				//min: 5000
			},
			exporting: {
				enabled: false
			},
			tooltip: {
				backgroundColor: '#fff',
		        borderRadius: 10,
				formatter: function() {
					return '<span style="font-size: 13px !important;"><b>' + this.series.name + ': (' +  this.x + ') </b></span><br/>' + '<span style="color: #868e96">Amount' + ':</span><span style="color:#FDAC42;font-weight:600;"> $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/> <span style="color: #868e96">' + 'Avg Transaction:</span><span style="color:#AC5DD9;font-weight:600;"> $' + this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #868e96">' + 'Tax:</span><span style="color:#D0021B;font-weight:600;"> $'+ this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
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
						symbol: 'circle'
					},
				}
			},
			series: [{
              	// name: 'Time of Day',
              	type: "areaspline",
              	// color: '#00a6ff',
              	showInLegend: false,
              	data: points
            }]
		});
		$('#sales_time_of_day').removeClass('custom_loading');
	}

	function saleSummeryPdfTableConvertor($wraper,jd,totals) {
		var allRow='',tfoot='',nameCol=false;
		if(typeof totals != 'object')
			totals=JSON.parse(totals);
			if(parseInt(totals[0]['is_Customer_name'])) {
				var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');
				nameCol=true;
			} else {
				var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');
			}
			if(!jd){
				allRow='<tr><td colspan="5" align="center">No data</td></tr>';
			} else {
				if(typeof jd != 'object')
					jsonData=JSON.parse(jd);
				else
					jsonData=jd;
					jsonData.forEach(function(val, i){
						if(allRow != '') {
 							allRow+=
							'<tr><td>'+val.amount
							+'</td><td>'+val.tax
							+'</td><td>'+val.tip_amount
							+'</td><td>'+val.type
							+'</td><td>'+val.date_c
							+'</td><td>'+val.reference
							+'</td></tr>';    
						} else {
			 				allRow='<tr><td>'+val.amount+'</td><td>'+val.tax+'</td><td>'+val.tip_amount+'</td><td>'+val.type+'</td><td>'+val.date_c+'</td><td>'+val.reference+'</td></tr>';
						}
                        // console.log(allRow);
					});
                    // return false;
					totals.forEach(function(val, i) {
						if(allRow != '') {
							allRow+='<tr><td>'+val.Refund_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Sum_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Tip_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr>';
						} else {   
						 	allRow='<tr><td>'+val.Refund_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Sum_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Tip_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr>';    
						}
					});
			}
        // console.log(allRow);return false;
        newTable.find('tbody').html(allRow);

		$wraper.html(newTable);
		$wraper.find('table').DataTable(dtConfigHiddenTable);
	}
</script>

<?php include_once'footer_graph.php'; ?>