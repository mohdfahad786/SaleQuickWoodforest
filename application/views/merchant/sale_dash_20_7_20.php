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
    .table.info-table tr td, table.info-table tr td, .table.info-table tr td a, table.info-table tr td a {
        font-family: AvenirNext-Medium !important;
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
            <form class="row" method="post" action="<?php echo base_url('graph/sale'); ?>" style="margin-bottom: 20px !important;margin-left: -11px !important;">
            	<div class="col-sm-6 col-md-6 col-lg-6" style="margin-top: 5px !important;">
					<div class="row">
						<div class="custom_range_selector">
							<div id="daterange" class="form-control" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
								<span>April-18-2019 - May-17-2019</span>
							</div>
						</div>
				
						<div class="custom_employee_selector">
							<?php
							$merchant_id = $this->session->userdata('merchant_id');
							$data = $this->admin_model->data_get_where_1('merchant', array('merchant_id' => $merchant_id)); ?>
							<select name="employee" class="form-control" id="employee" 
							onchange="getGraph();updateTimeOfDay();getTable();" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
								<option value="all">Select Employee</option>
								<option value="merchant"> Merchant</option>
									<?php foreach ($data as $view) { ?>
										<option value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 form_buttons" style="text-align: right;">
                    <input name="start_date" id="start_date" value="" type="hidden">
                    <input name="end_date" id="end_date" value="" type="hidden">
                    <input name="status" type="hidden" value="">

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
												<tr>
													<th>Amount</th>
													<td>$4.00</td>
													<td>$2.00</td>
													<td>$2.00</td>
												</tr>
												<tr>
													<th>Tax</th>
													<td>$0.00</td>
													<td>$0.00</td>
													<td>$0.00</td>
												</tr>
											</tbody>
											<tfoot>
												<th>Total</th>
												<th>$4.00</th>
												<th>$2.00</th>
												<th>$2.00</th>
											</tfoot>
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
	function setNullToZero(vals) {
		var valss =isNaN(vals)? 0 : (vals == null? 0: parseFloat(vals));
		return valss;
	}
	function saleChartFn(a, b) {
        if(typeof b =='undefined'){
            return;
        }

        /*if ($(window).width() >= 2000) {
            var chart_width = 1663;
        } else if ($(window).width() <= 1999 && $(window).width() >= 1700) {
            var chart_width = 1438;
        } else if ($(window).width() <= 1699 && $(window).width() >= 1550) {
            var chart_width = 1326;
        } else if ($(window).width() <= 1549 && $(window).width() >= 1401) {
            var chart_width = 1138;
        } else if ($(window).width() <= 1400 && $(window).width() >= 1341) {
            var chart_width = 1009;
        } else if ($(window).width() <= 1340 && $(window).width() >= 1150) {
            var chart_width = 886;
        } else if ($(window).width() <= 1149 && $(window).width() >= 950) {
            var chart_width = 739;
        } else if ($(window).width() <= 949 && $(window).width() >= 850) {
            var chart_width = 838;
        } else if ($(window).width() <= 849 && $(window).width() >= 750) {
            var chart_width = 708;
        } else if ($(window).width() <= 749 && $(window).width() >= 600) {
            var chart_width = 611;
        } else if ($(window).width() <= 599 && $(window).width() >= 460) {
            var chart_width = 474;
        // } else if ($(window).width() <= 459) {
        //     var chart_width = 413;
        // }
        } else if ($(window).width() <= 459 && $(window).width() >= 380) {
            var chart_width = 400;
        } else if ($(window).width() <= 379 && $(window).width() >= 290) {
            var chart_width = 285;
        } else if ($(window).width() <= 289) {
            var chart_width = 218;
        }*/

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
            /*responsive: {
                rules: [{
                    condition: {
                        maxWidth: 900
                    },
                    chartOptions: {
                        yAxis: {
                            labels: {
                                align: 'center'
                            }
                        }
                    }
                }]
            },*/
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
	function getGraph() {
		var start=$("#daterange span").data().d1;
		var end=$("#daterange span").data().d2;
		var employee =  $('#employee').val(); 
		$('#sales_summery .placeholder').html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px">Loading...</div>');
		// $('#graph h1, #graph h2').html('&nbsp;');
		// $('#graph .metric1 h1').html('<i class="fa fa-spinner fa-spin"></i>');
	 	var jsonurl = '<?php echo base_url('merchant-panel'); ?>/graph/graph.php?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>&employee=<?php echo 'all'; ?>';
		jsonurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
		jsonurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2 + '&units=' + userprefs.units +'&employee=' + employee + '&merchant=' + userprefs.merchant + '&fee=' + userprefs.fee ;
		if (typeof location.search == 'string' && location.search.length > 0)
			jsonurl += '&' + location.search.substring(1);
		if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null )
			jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) ;
		$.getJSON(jsonurl, function(data) {
			if (data) {
				// console.log(data)
				saleChartFn('sales_summery', data);
			}
		});
	}
	function updateTimeOfDay(){
		var employee =  $('#employee').val(); 
		var start=$("#daterange span").data().d1;
		var end=$("#daterange span").data().d2;
		// console.log(end)
		$('#end_date').val(end);
		$('#start_date').val(start);
		$.ajax({
		type: 'POST',
		url: "<?php  echo base_url('graph/sale'); ?>",
		data: {start: start , end : end },
		type:'post',
		success: function(dataJson){
			// console.log(dataJson);return false;
			var data = JSON.parse(dataJson);
			// console.log(data);
			dataTimeDayVals=[];
			for(index=0;index < 24 ; index++){
				var valY=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timea']));
				var valTax=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timetax']));
				var valAvg=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timefee']));
				var newObjt={y:valY,tax:valTax,avg:valAvg};
				dataTimeDayVals.push(newObjt);
			}
			salesTimeDayChart(dataTimeDayVals);
			$('#sales_summery').data('vals',data.item3);
			saleSummeryPdfTableConvertor($('#salesSummeryChartExportDt'),data.item3,data.item5);
		}
		});
	}
	function getTable() {
		var loading = $('<tr class="loading"> <td colspan="4" style="text-align: center"><div class="message"> <div class="progress"> <div class="progress-bar progress-bar-striped active" style="width: 100%;"></div> </div> Your report is being generated. This may take up to several minutes... </div></td> </tr>');
		var nodata = $('<tr class="nodata"> <td colspan="4" style="text-align: center"> <div class="message"> There is no data to display for the selected date range. </div> </td> </tr>');
		var timeout = $('<tr class="timeout"> <td colspan="4" style="text-align: center"><div class="message"> Report generation has timed out. </div></td> </tr>');

		var employee =  $('#employee').val();
		var start=$("#daterange span").data().d1;
		var end=$("#daterange span").data().d2;

		$('#report tbody').html(loading.html());
		$('#report tfoot').html('');

		var jsonurl = '<?php echo base_url('merchant-panel'); ?>/graph/report.php?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>&employee=<?php echo 'all'; ?>&merchant=<?php echo $merchant_id ; ?>';

		if (typeof location.search == 'string' && location.search.length > 0)
			jsonurl += '?' + location.search.substring(1) + '&type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal) +'&employee=' + employee + '&merchant=' + userprefs.merchant;
		else
			jsonurl += '?type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal) +'&employee=' + employee + '&merchant=' + userprefs.merchant;
		if (typeof start != 'undefined' && typeof end != 'undefined' && start != null && end != null)
			jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end);

		$.post(jsonurl, function(data) {
			// console.log(data , 'dhgjhhkj');
			var html = '', clicks = 0, people = 0,  converted_people = 0;
			if (data.length == 0) {
				$('#report tbody').html(nodata.html());
			} else {
				for (var row in data) {
					var label = data[row]['label'];
					// console.log(label)
					//data for tbody
					if (data[row]['label'] == null || data[row]['label'] == '') {
						label = '[ No Source ]';                
					}
					if(label != 'Fee') {
						html += '<tr>';
						var url = '';
						html += '<td style="text-align: left" class="ellipsis">';

						if (label.length > 40 && (label.substr(0, 7) == 'http://' || label.substr(0,8) == 'https://'))
							html += '<a href="javascript:void(0)" title="' + label + '">' + label + '</a>';
							// html += '<a href="' + url + '" title="' + label + '">' + label + '</a>';
						else
							html += '<a href="javascript:void(0)">' + label + '</a>';
							// html += '<a href="' + url + '">' + label + '</a>';

						html += '</td>';
						html += '<td>' + format_money(data[row]['SaleAmount']) + '</td>';
						html += '<td>' + format_money(data[row]['RefundAmount']) + '</td>';
						html += '<td>' + format_money(data[row]['NetAmount']) + '</td>';


						html += '</tr>';

						clicks += parseFloat(data[row]['RefundAmount']);
						people += parseFloat(data[row]['SaleAmount']);
						converted_people += parseFloat(data[row]['NetAmount']);

						
					}
				}
				$('#report tbody').html(html);
				//data for tfoot
				html = '<tr>';
				html += '<th>Total</th>';
				html += '<th> $' + add_commas(people.toFixed(2)) + '</th>';
				html += '<th> $' + add_commas(clicks.toFixed(2)) + '</th>';
				html += '<th> $' + add_commas(converted_people.toFixed(2)) + '</th>';
				html += '</tr>';
				$('#report tfoot').html(html);
			}

		}, 'json').fail(function() {
			$('#report tbody').html(timeout.html());
		});
	}
	$(function(){
		getGraph();
		setTimeout(function(){updateTimeOfDay();},50)
		getTable();
		// saleSummeryPdfTableConvertor($('#salesSummeryChartExportDt'),$('#salesSummeryChartExportDt').data('defjson'));
	})
</script>

<script>
    /*$(window).on("resize", function () {
        console.log('123');
        $('#sales_summery').empty();
        getGraph();

        $('#sales_time_of_day').empty();
        updateTimeOfDay();

    }).resize();*/
</script>

<?php include_once'footer_dash.php'; ?>