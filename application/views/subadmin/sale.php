<!DOCTYPE html>
<html lang="en"> 
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">
		<link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
		<title>Subadmin | Dashboard</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
		<link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>new_assets/css/datatables.min.css"/>
		<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url('merchant-panel'); ?>/assets/css/dcalendar.picker.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
		<link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
		<?php  
			$last_date = date("Y-m-d",strtotime("-29 days"));
			$date = date("Y-m-d");
			$merchant_id = '';
			$t_fee = '';
		?>
		<script type="text/javascript">
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
			var userprefs1 = {
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

			var dtConfigHiddenTable={
					dom: 'B', destroy: true, order: [],
					// "buttons": [
					// 	{extend: 'collection',
					// 		text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
					// 		buttons: ['csv','pdf','print'
					// 		]
					// 	}
					// ]
					buttons: [
		                {
		                    extend: 'csv',
		                    titleAttr: 'Download CSV report',
		                    text: '<i class="fa fa-file-text-o" aria-hidden="true"></i>'
		                },
		                {
		                    extend: 'excelHtml5',
		                    titleAttr: 'Download Excel report',
		                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
		                },
		                {
		                    extend: 'pdfHtml5',
		                    orientation: 'landscape',
		                    titleAttr: 'Download PDF report',
		                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
		                }
		            ]
				};
			function saleSummeryPdfTableConvertor($wraper,jd,totals){
			
				var allRow='',tfoot='',nameCol=false;
				if(typeof totals != 'object')
				totals=JSON.parse(totals);
				if(parseInt(totals[0]['is_Customer_name'])){
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

						});
					totals.forEach(function(val, i) {
						if(allRow != '') {
							allRow+=
							'<tr><td>'+val.Refund_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Sum_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Tip_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr>';
						} else {   
						 	allRow='<tr><td>'+val.Refund_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Sum_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>'+val.Total_Tip_Amount+'</td><td></td><td></td><td></td><td></td><td></td></tr>';    
						}

					});
				}
				newTable.find('tbody').html(allRow);
				// newTable.find('tbody').append(tfoot);
				$wraper.html(newTable);
				$wraper.find('table').DataTable(dtConfigHiddenTable);
			}
		</script>
		<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/graph/app1.min.js"></script>
		<script src="<?php echo base_url('merchant-panel'); ?>/graph/app2.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- start Mixpanel -->
		<!-- end Mixpanel -->
		<script type="text/javascript">
		/*! improvely 2017-07-09 */
		function imGraph(a, b) {
var c = {
		global: {
				useUTC: !1
		},
		chart: {
				type: 'spline',
				height: 201,
				renderTo: "graph",
				marginTop: 0,
				// marginBottom: 40,
				borderRadius: 0,
				backgroundColor: "#ffffff"
		},
		title: {
				text: null
		},
		colors: ["#ffffff00", "#00a6ff",'#ffffff00'],
		credits: {
				enabled: !1
		},
		legend: {
				enabled: !1
		},
		plotOptions: {
					area: {
					lineWidth: 4,
					fillOpacity: .1,
					marker: {
						lineColor: "#fff",
						lineWidth: 3,
						symbol: 'circle'
					},
					shadow: !1
					},
					spline: {
						lineWidth: 4,
						marker: {
						lineWidth: 3,
						lineColor: '#ffffff',
						symbol: 'circle'
					}
					},
					column: {
						lineWidth: 16,
						shadow: !1,
						borderWidth: 0,
						groupPadding: .05
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
		yAxis: [ {
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
				shadow: !1,
								borderRadius: 3,
								shared: !0,
										formatter: function(a) {
	var b = parseInt(this.points[0].y) == this.points[0].y ? this.points[0].y : this.points[0].y.toFixed(2),
			b =isNaN(b)?0:(b!=''?b:0),
	// console.log(this),
		c = (this.points[1] != undefined) ? (parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2)): 0,
		fee = (this.points[2] != undefined) ? parseInt(this.points[2].y) == this.points[2].y ? this.points[2].y : this.points[2].y.toFixed(2) : 0,
		d = '<span ><b>' + moment(this.x).format("dddd, MMM D, YYYY") + "</b></span>",
		e = '<span style="color: #390390">' + a.chart.series[0].name + ":</span> <b> $" + parseFloat(b).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + "</b>",
		f = '<span style="color: #08c08c">' + a.chart.series[1].name + ":</span> <b> $" + parseFloat(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") 
		+ "</b> <br/>" + '<span style="color: #C14242">' + "Fee  :" + '<b> $' + parseFloat(fee).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
		 + '</b>' + '</span>';
												return d + " <br /> " + f + " <br /> " + e
											//  return d + " <br /> "  + f
								}
						},
						series: [{
								type: "spline",
								marker: {
									lineWidth: 0,
								},
								states: {
										hover: {
												enabled: false
										}
								}
						}, {
								type: "spline",
								yAxis: 1
						}, {
								type: "spline",
								// yAxis: 1,
								marker: {
									lineWidth: 0,
								},
								states: {
									hover: {
											enabled: false
									}
								}
						}]
				};

if ($('select[name="graph_metric1"]').length > 0) var d = $('select[name="graph_metric1"]').val(),
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
		graph = new Highcharts.Chart(c), graphData = b
}
</script>
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
		}
		.custom_loading:before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(255,255,255,0.8);
			z-index: 99;
		}
		.custom_loading:after {
			content: "Loading...";
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translateX(-50%) translateY(-50%);
			font-size: 24px;
			z-index: 999;
		}
		.sales-summery .table > thead > tr > th {
				font-size: 16px;
				color:  #9b9b9b;
		background-color: transparent !important;
		}
		.sales-summery  .table thead th {
				vertical-align: bottom;
				border-bottom: 2px solid #e9ecef !important;
		}
		.sales-summery .table-responsive{
			overflow-x: auto;
		}
	</style>
</head>
<body class="fixed-left">
	<?php 
	include_once 'top_bar.php';
	include_once 'sidebar.php';
	?>
	<!-- Begin page -->
	<div id="wrapper"> 
	 <div class="page-wrapper sales-summery">
		<script type="text/javascript">
			currency_symbol = '$';
		</script>
		<div class="row sales_date_range">
			<div class="col-12 custom-form">
				<div class="card content-card">
					<div class="row">
						<div class="col">
							<div id="daterange" class="form-control">
								 <span><?php echo date("F-d-Y",strtotime("-29 days")); ?> - <?php echo date("F-d-Y"); ?></span>
								 <input type="hidden" name="start_date" id="startDate" value="<?php echo date("Y-m-d",strtotime("-29 days"));?>">
								 <input type="hidden" name="end_date" id="endDate" value="<?php echo date("Y-m-d");?>"> 
							</div>
						</div>
						<?php
						 $Allmerchantdata=explode(',',$this->session->userdata('subadmin_assign_merchant')); 
						 $this->db->where_in('id',$Allmerchantdata); 
						 $this->db->where('status','active'); 
						 $this->db->where('user_type','merchant'); 
						 $this->db->order_by('id','desc'); 
						 $data = $this->db->get('merchant')->result_array(); 
					?>
						<div class="col">
							<select name="employee" class="form-control" id="employee"  onchange="getGraph();getTable();onSelectChange3()" >
								<option value="all">Select Merchant</option>
								<!-- <option value="merchant">Merchant</option>
								<option value="165">fahad</option>
								<option value="164">fahad</option> -->
								<?php if(count($data) > 0) { foreach ($data as $view) { ?>
										<option  value="<?php echo $view['id']; ?>"><?php if(empty($view['business_dba_name'])){echo $view['name'];} else {echo $view['business_dba_name'];} ?></option>
								<?php } }?>
							</select>
						</div>
						<!-- <div class="col-3 text-right">
								<textarea id="txt"  class="txtarea" style="display: none;"  > -->
							<?php  
							$a = $item; $b = $item1; $c = $item2;
							// echo  $d = $item['reference']; 
								$wholeData=json_encode(array_merge($a,$b,$c));  
							?> 
							<!-- </textarea>
							<button class="btn btn-custom1" id="salesSumeryCsvBtn" ><span>Download CSV</span> <span class="material-icons">arrow_downward</span></button> -->
						<style type="text/css">
							#salesSummeryChartExportDt{
								float: right;
							}
							#salesSummeryChartExportDt button.dt-button.buttons-collection{
								margin: 0 !important
							}
							#salesSummeryChartExportDt.reset-dataTable .dt-buttons{
								padding-top: 4px;
							}
							#salesSummeryChartExportDt table{
								display: none;
								width: 100%;
							}
							#salesSummeryChartExportDt div.dt-button-collection{
								left: auto !important;
								right: 0;
							}
						</style>
						<div class="col text-right">
							<div id="salesSummeryChartExportDt"  class="reset-dataTable" data-defjson='<?php echo $wholeData;  ?>'> </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card content-card">
					<div class="card-title">
						Sales Summery
					</div>
					<div class="card-detail">
						<!-- <div id="graph" class="graph"></div>
						<div class="pull-right"> </div>
						<div class="placeholder" style="clear: both; margin: 0 -10px -10px -10px"></div> -->
						<div id="sales_summery" height="350"> </div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card content-card">
					<div class="card-title">
						Time of Day
					</div>
					<div class="card-detail">
						<div class="tab-pane fade show active" id="profile1"></div>
						<div id="sales_time_of_day" height="350"> </div>
						<!-- <div id="sales_time_of_day" height="350"> </div> -->
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card content-card">
					<div class="card-detail">
						<div class="table-responsive">
							<table id="report" class="table table-borderless">
								<thead>
									<tr>
										<th width="55%"></th>
										<th>Sales</th>
										<th >Refunds</th>
										<th >Net</th>
									</tr>
								</thead>
								<tbody>
									<tr class="loading">
										<td colspan="11" style="text-align: center"><div class="message">
											<div class="progress">
												<div class="progress-bar progress-bar-striped active" style="width: 100%;"></div>
											</div>
											Your report is being generated. This may take up to several minutes... </div>
										</td>
									</tr>
									<tr class="nodata">
									 <td colspan="11" style="text-align: center"><div class="message"> There is no data to display for the selected date range. 
										 Have you installed the <a href="/code/webshop">Improvely Tracking Code</a> on your site, and updated your ads with <a href="/tools/webshop/link_builder">tracking links</a>? </div></td>
									</tr>
									<tr class="timeout">
									 <td colspan="11" style="text-align: center"><div class="message"> Report generation has timed out. </div></td>
									</tr>
								</tbody>
								<tfoot  class="bg-tfoot">
								</tfoot>
							</table>
						</div>  
					</div>
				</div>
			</div>
		</div>
		<div class="row1">
			<div class="card-box col-md-12">
			 <!--   <a href="/api/report.xls?type=ad&amp;tab=channel"><button class="btn btn-primary" style="margin-top: 20px"><i class="fa fa-download"></i> &nbsp; Download Excel CSV</button></a> -->
			 <input type="hidden" name="Totaljan" id="Totaljan" value="<?php echo  $getDashboardData[0]['Totaljan'] ?  $getDashboardData[0]['Totaljan'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalfeb" id="Totalfeb" value="<?php echo  $getDashboardData[0]['Totalfeb'] ?  $getDashboardData[0]['Totalfeb'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalmarch" id="Totalmarch" value="<?php echo  $getDashboardData[0]['Totalmarch'] ?  $getDashboardData[0]['Totalmarch'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalaprl" id="Totalaprl" value="<?php echo  $getDashboardData[0]['Totalaprl'] ?  $getDashboardData[0]['Totalaprl'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalmay" id="Totalmay" value="<?php echo  $getDashboardData[0]['Totalmay'] ?  $getDashboardData[0]['Totalmay'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totaljune" id="Totaljune" value="<?php echo  $getDashboardData[0]['Totaljune'] ?  $getDashboardData[0]['Totaljune'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totaljuly" id="Totaljuly" value="<?php echo  $getDashboardData[0]['Totaljuly'] ?  $getDashboardData[0]['Totaljuly'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalaugust" id="Totalaugust" value="<?php echo  $getDashboardData[0]['Totalaugust'] ?  $getDashboardData[0]['Totalaugust'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalsep" id="Totalsep" value="<?php echo  $getDashboardData[0]['Totalsep'] ?  $getDashboardData[0]['Totalsep'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totaloct" id="Totaloct" value="<?php echo  $getDashboardData[0]['Totaloct'] ?  $getDashboardData[0]['Totaloct'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalnov" id="Totalnov" value="<?php echo  $getDashboardData[0]['Totalnov'] ?  $getDashboardData[0]['Totalnov'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totaldec" id="Totaldec" value="<?php echo  $getDashboardData[0]['Totaldec'] ?  $getDashboardData[0]['Totaldec'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalnovtax" id="Totalnovtax" value="<?php echo  $getDashboardData[0]['Totalnovtax'] ?  $getDashboardData[0]['Totalnovtax'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totaldectax" id="Totaldectax" value="<?php echo  $getDashboardData[0]['Totaldectax'] ?  $getDashboardData[0]['Totaldectax'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totalnovfee" id="Totalnovfee" value="<?php echo  $getDashboardData[0]['Totalnovfee'] ?  $getDashboardData[0]['Totalnovfee'] :'0'.""  ?>"  />
			 <input type="hidden" name="Totaldecfee" id="Totaldecfee" value="<?php echo  $getDashboardData[0]['Totaldecfee'] ?  $getDashboardData[0]['Totaldecfee'] :'0'.""  ?>"  />
		 </div>
	 </div>
<script type="text/javascript">
	$(document)
	.ready(function(){
		onSelectChange3(); 
	});
	
</script> 
<script type="text/javascript">
	var updates = 0;
	var loading = $('#report tbody .loading').hide().clone();
	var nodata = $('#report tbody .nodata').hide().clone();
	var timeout = $('#report tbody .timeout').hide().clone();
$(function() {
	getTable(); 
	getGraph(); 
	getGraph1(); 
});
function onSelectChange3(start, end){
	if(window.start) {
		start = window.start;
		end = window.end;
	} else {
		start =  encodeURIComponent(start);
		end =  encodeURIComponent(end);
	}
	var employee =  $('#employee').val();
	if(start=='undefined')
	{
		var start=$("#daterange #startDate").val();
		var end=$("#daterange #endDate").val();
	} console.log(start+'-----'+end+employee); 
	$.ajax({
		type: 'POST',
		url: "<?php  echo base_url('subadmin_Graph/sale'); ?>",
		data: {start: start , end : end,employee:employee},
		type:'post',
		beforeSend: function() {
			$('#sales_time_of_day').addClass('custom_loading');
		},
		success: function (dataJson)
		{
			fullData = JSON.parse(dataJson);
			data = fullData.getDashboardData[0];
					//console.log(data)
					points = [
					{y: eval(data.Totaljan) ? eval(data.Totaljan) : 0, fee: eval(data.Totaljanfee) ? eval(data.Totaljanfee) : 0, tax: eval(data.Totaljantax) ? eval(data.Totaljantax) : 0},
					{y: eval(data.Totalfeb) ? eval(data.Totalfeb) : 0, fee: eval(data.Totalfebfee) ? eval(data.Totalfebfee) : 0, tax: eval(data.Totalfebtax) ? eval(data.Totalfebtax) : 0},
					{y: eval(data.Totalmarch) ? eval(data.Totalmarch) : 0, fee: eval(data.Totalmarchfee) ? eval(data.Totalmarchfee) : 0, tax: eval(data.Totalmarchtax) ? eval(data.Totalmarchtax) : 0},
					{y: eval(data.Totalaprl) ? eval(data.Totalaprl) : 0, fee: eval(data.Totalaprlfee) ? eval(data.Totalaprlfee) : 0, tax: eval(data.Totalaprltax) ? eval(data.Totalaprltax) : 0},
					{y: eval(data.Totalmay) ? eval(data.Totalmay) : 0, fee: eval(data.Totalmayfee) ? eval(data.Totalmayfee) : 0, tax: eval(data.Totalmaytax) ? eval(data.Totalmaytax) : 0},
					{y: eval(data.Totaljune) ? eval(data.Totaljune) : 0, fee: eval(data.Totaljunefee) ? eval(data.Totaljunefee) : 0, tax: eval(data.Totaljunetax) ? eval(data.Totaljunetax) : 0},
					{y: eval(data.Totaljuly) ? eval(data.Totaljuly) : 0, fee: eval(data.Totaljulyfee) ? eval(data.Totaljulyfee) : 0, tax: eval(data.Totaljulytax) ? eval(data.Totaljulytax) : 0},
					{y: eval(data.Totalaugust) ? eval(data.Totalaugust) : 0, fee: eval(data.Totalaugustfee) ? eval(data.Totalaugustfee) : 0, tax: eval(data.Totalaugusttax) ? eval(data.Totalaugusttax) : 0},
					{y: eval(data.Totalsep) ? eval(data.Totalsep) : 0, fee: eval(data.Totalsepfee) ? eval(data.Totalsepfee) : 0, tax: eval(data.Totalseptax) ? eval(data.Totalseptax) : 0},
					{y: eval(data.Totaloct) ? eval(data.Totaloct) : 0, fee: eval(data.Totaloctfee) ? eval(data.Totaloctfee) : 0, tax: eval(data.Totalocttax) ? eval(data.Totalocttax) : 0},
					{y: eval(data.Totalnov) ? eval(data.Totalnov) : 0, fee: eval(data.Totalnovfee) ? eval(data.Totalnovfee) : 0, tax: eval(data.Totalnovtax) ? eval(data.Totalnovtax) : 0},
					{y: eval(data.Totaldec) ? eval(data.Totaldec) : 0, fee: eval(data.Totaldecfee) ? eval(data.Totaldecfee) : 0, tax: eval(data.Totaldectax) ? eval(data.Totaldectax) : 0},
					]
					getGraph1(points) ;
					// $('#txt').val('');
					saleSummeryPdfTableConvertor($('#salesSummeryChartExportDt'),fullData.item3,fullData.item5)
				}
			});
}
function getGraph(start, end) {
	var employee =  $('#employee').val();
	var jsonurl ='<?php echo base_url('subadmin_graph_dashboard/index'); ?>?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>';
	jsonurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
	jsonurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2 + '&units=' + userprefs.units +'&employee=' + employee + '&merchant='  ;
	if (typeof location.search == 'string' && location.search.length > 0)
		jsonurl += '&' + location.search.substring(1);
	if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null ) {
		window.start = encodeURIComponent(start);
		window.end = encodeURIComponent(end);
		jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) ;
	} else if(window.start) {
		jsonurl += '&start=' + window.start + '&end=' + window.end;
	}
	$.ajax({
						type: "GET",
						url: jsonurl,
						success: function(data) {
							 data=JSON.parse(data); 
								if (data.length != 0)
								imGraph('sales_summery', data);
						},
						error :function(){
								//console.log('error');
						}
				});
}
function getTable(start, end) {
 var employee =  $('#employee').val();
 $('#report tbody').html(loading.html());
 $('#report tfoot').html('');
 var jsonurl = '<?php echo base_url('subadmin_graph_dashboard/report'); ?>?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>';
 if (typeof location.search == 'string' && location.search.length > 0  && location.search.substring(1)!="" )
	jsonurl += '?' + location.search.substring(1) + '&type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal) +'&employee=' + employee + '&merchant=' + userprefs.merchant;
else
	jsonurl += '&type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal) +'&employee=' + employee + '&merchant=' + userprefs.merchant;
if (typeof start != 'undefined' && typeof end != 'undefined' && start != null && end != null) {
	jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end);
} else if(window.start) {
	jsonurl += '&start=' + window.start + '&end=' + window.end ;
}
	// console.log(jsonurl);
$.ajax({
						type: "GET",
						url: jsonurl,
						success: function(data) {
						//  console.log(data);
							 data=JSON.parse(data); 
							 var html = '', clicks = 0, people = 0, conversions = 0, converted_people = 0, revenue = 0, cost = 0;
							if (data.length == 0) {
								$('#report tbody').html(nodata.html());
							} else {
						for (var row in data) {
							var label = data[row]['label'];
							if (data[row]['label'] == null || data[row]['label'] == '') {
								label = '[ No Source ]';                }
								html += '<tr>';
								var url = '';
								html += '<td style="text-align: left" class="ellipsis">';
								if (label.length > 40 && (label.substr(0, 7) == 'http://' || label.substr(0,8) == 'https://'))
									html += '<a href="' + url + '" title="' + label + '">' + label + '</a>';
								else
									html += '<a href="' + url + '">' + label + '</a>';
								html += '</td>';
								var url = '/reports/webshop/people?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']);
								html += '<td>' + format_money(data[row]['people']) + '</td>';
								var url = '/reports/webshop/clicks?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']);
								html += '<td>' + format_money(data[row]['clicks']) + '</td>';
								var url = '/reports/webshop/conversions?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']) + '&goal=' + encodeURIComponent(userprefs.goal);
								html += '<td>' + format_money(data[row]['converted_people']) + '</td>';
								var url = '/reports/webshop/conversions?from=ad&filters[ad]=1&filters[source]=' + encodeURIComponent(data[row]['label']) + '&goal=' + encodeURIComponent(userprefs.goal);
												html += '</tr>';
												clicks += parseInt(data[row]['clicks']);
												people += parseInt(data[row]['people']);
												converted_people += parseInt(data[row]['converted_people']);
												conversions += parseInt(data[row]['conversions']);
												revenue += parseFloat(data[row]['revenue']);
												cost += parseFloat(data[row]['cost']);
											}
											$('#report tbody').html(html);
											if (updates == 0) {
												$("#report").tablesorter({ 
													textExtraction: function(node) { 
														var decoded = $('<div/>').html(currency_symbol).text();
														return node.innerHTML.replace(/<\/?[^>]+>/gi, '').replace(',', '').replace(currency_symbol, '').replace(decoded, '');
													},
													sortList: [[1,1]]
												}); 
											} else {
												$('#report').trigger("update");
												$('#report').trigger("sorton",[[[1,1]]]);
											}
											updates++;
										}
							html = '<tr>';
							html += '</tr>';
							 $('#report tfoot').html(html);
						},
						error :function(){
							$('#report tbody').html(timeout.html());
						}
				});
		}
	</script> 
	<script>
		var resizefunc = [];
	</script> 
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>new_assets/js/datatables.min.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url(); ?>/new_assets/js/waves.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
	<script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/js/jquery.multi-select.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script>
	<!-- Custom main Js -->
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
	<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
	<script>
		function toLocaleStringSupportsLocales() {
			var number = 0;
			try {
				number.toLocaleString('i');
			} catch (e) {
				return e.name === 'RangeError';
			}
			return false;
		}
		function getGraph1(points = []) {    
			let data = [];
			if(points.length) {
				data = points;
			} else {
				var data1 = parseFloat(document.getElementById('Totaljan').value); 
				var data2 = parseFloat(document.getElementById('Totalfeb').value);
				var data3 = parseFloat(document.getElementById('Totalmarch').value); 
				var data4 = parseFloat(document.getElementById('Totalaprl').value);
				var data5 = parseFloat(document.getElementById('Totalmay').value); 
				var data6 = parseFloat(document.getElementById('Totaljune').value);
				var data7 = parseFloat(document.getElementById('Totaljuly').value); 
				var data8 = parseFloat(document.getElementById('Totalaugust').value);
				var data9 = parseFloat(document.getElementById('Totalsep').value); 
				var data10 = parseFloat(document.getElementById('Totaloct').value);
				var data11 = parseFloat(document.getElementById('Totalnov').value); 
				var data12 = parseFloat(document.getElementById('Totaldec').value);
				var datatex1 = <?php echo $getDashboardData[0]['Totaljantax'] ?  $getDashboardData[0]['Totaljantax'] :'0'."" ?>;
				var datatex2 = <?php echo $getDashboardData[0]['Totalfebtax'] ?  $getDashboardData[0]['Totalfebtax'] :'0'.""; ?>;
				var datatex3 = <?php echo $getDashboardData[0]['Totalmarchtax'] ?  $getDashboardData[0]['Totalmarchtax'] :'0'."" ?>;
				var datatex4 = <?php echo $getDashboardData[0]['Totalaprltax'] ?  $getDashboardData[0]['Totalaprltax'] :'0'."" ?>;
				var datatex5 = <?php echo $getDashboardData[0]['Totalmaytax'] ?  $getDashboardData[0]['Totalmaytax'] :'0'."" ?>;
				var datatex6 = <?php echo $getDashboardData[0]['Totaljunetax'] ?  $getDashboardData[0]['Totaljunetax'] :'0'."" ?>;
				var datatex7 = <?php echo $getDashboardData[0]['Totaljulytax'] ?  $getDashboardData[0]['Totaljulytax'] :'0'."" ?>;
				var datatex8 = <?php echo $getDashboardData[0]['Totalaugusttax'] ?  $getDashboardData[0]['Totalaugusttax'] :'0'."" ?>;
				var datatex9 = <?php echo $getDashboardData[0]['Totalseptax'] ?  $getDashboardData[0]['Totalseptax'] :'0'."" ?>;
				var datatex10 = <?php echo $getDashboardData[0]['Totalocttax'] ?  $getDashboardData[0]['Totalocttax'] :'0'."" ?>;
				var datatex11 = parseFloat(document.getElementById('Totalnovtax').value);
				var datatex12 =  parseFloat(document.getElementById('Totaldectax').value);
				var datafee1 = <?php echo $getDashboardData[0]['Totaljanfee'] ?  $getDashboardData[0]['Totaljanfee'] :'0'."" ?>;
				var datafee2 = <?php echo $getDashboardData[0]['Totalfebfee'] ?  $getDashboardData[0]['Totalfebfee'] :'0'.""; ?>;
				var datafee3 = <?php echo $getDashboardData[0]['Totalmarchfee'] ?  $getDashboardData[0]['Totalmarchfee'] :'0'."" ?>;
				var datafee4 = <?php echo $getDashboardData[0]['Totalaprlfee'] ?  $getDashboardData[0]['Totalaprlfee'] :'0'."" ?>;
				var datafee5 = <?php echo $getDashboardData[0]['Totalmayfee'] ?  $getDashboardData[0]['Totalmayfee'] :'0'."" ?>;
				var datafee6 = <?php echo $getDashboardData[0]['Totaljunefee'] ?  $getDashboardData[0]['Totaljunefee'] :'0'."" ?>;
				var datafee7 = <?php echo $getDashboardData[0]['Totaljulyfee'] ?  $getDashboardData[0]['Totaljulyfee'] :'0'."" ?>;
				var datafee8 = <?php echo $getDashboardData[0]['Totalaugustfee'] ?  $getDashboardData[0]['Totalaugustfee'] :'0'."" ?>;
				var datafee9 = <?php echo $getDashboardData[0]['Totalsepfee'] ?  $getDashboardData[0]['Totalsepfee'] :'0'."" ?>;
				var datafee10 = <?php echo $getDashboardData[0]['Totaloctfee'] ?  $getDashboardData[0]['Totaloctfee'] :'0'."" ?>;
				var datafee11 =  parseFloat(document.getElementById('Totalnovfee').value);
				var datafee12 =   parseFloat(document.getElementById('Totaldecfee').value);
				data = [{y:data1, tax :datatex1 ,fee :datafee1}, {y:data2, tax :datatex2 ,fee :datafee2},{y:data3, tax :datatex3 ,fee :datafee3},{y:data4, tax :datatex4,fee :datafee4},{y:data5, tax :datatex5 ,fee :datafee5},{y:data6, tax :datatex6, fee :datafee6},{y:data7, tax :datatex7 ,fee :datafee7},{y:data8, tax :datatex8 ,fee :datafee8},{y:data9, tax :datatex9 ,fee :datafee9},{y:data10, tax :datatex10 ,fee :datafee10},{y:data11, tax :datatex11 ,fee :datafee11},{y:data12, tax :datatex12 ,fee :datafee12}];
			}
//console.log(data)
Highcharts.chart('sales_time_of_day', {
	chart: {
		type: 'spline',
		spacingBottom: 30,
		height:201
	},
	title: {
		text: null
	},
	xAxis: {
	 categories: ['04:00 AM', '05:00 AM', '06:00 AM', '07:00 AM', '08:00 AM', '09:00 AM' ,'10:00 AM' ,'11:00 AM' ,'12:00 PM' ,'01:00 PM' ,'02:00 PM' ,'03:00 PM' ,'04:00 PM']
	 ,            
	 labels: {
		style: {
			color: '#9b9b9b'
		}
	},
	min: 0.5
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
					exporting: { enabled: false },
					tooltip: {
						formatter: function() {
						 return '<b>' + this.series.name + ': (' +  this.x + ') </b><br/>' +
						 '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")     +  ' </span><br/> <span style="color: #C14242"> ' + 'Avg Transaction: $' +
						 this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">'  + 'Tax: $'+ this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
					 }
				 },
				 credits: {
					enabled: false
				},
				plotOptions: {
					series: {
						lineWidth: 4,
						marker: {
							lineWidth: 3,
							lineColor: '#ffffff',
							symbol: 'circle'
						}
					}
				},
				series: [{
					name: 'Time of Day',
					type: "spline",
					color: '#00a6ff',
					showInLegend: false,
					data: data
				}]
			});
$('#sales_time_of_day').removeClass('custom_loading');
};
</script> 
</div>
</div>
</div>
</body>
</html>