<!DOCTYPE html>
<html lang="en">
<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
  
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
  
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta http-equiv='cache-control' content='no-cache'> 
<meta http-equiv='expires' content='0'> 
<meta http-equiv='pragma' content='no-cache'>

  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin | Dashboard</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/new_assets/css/datatables.min.css"/>
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/dcalendar.picker.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
  <link href="<?php echo base_url('merchant-panel'); ?>/plugins/jquery-circliful/css/jquery.circliful.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
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
    var dtConfigHiddenTable={
        dom: 'B', destroy: true, order: [],
        "buttons": [
          {extend: 'collection',
            text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
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
    function saleSummeryPdfTableConvertor($wraper,jd,totals){
   
    var allRow='',tfoot='',nameCol=false;
    if(typeof totals != 'object')
    totals=JSON.parse(totals);
     if(parseInt(totals[0]['is_Customer_name'])){
    var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');
    nameCol=true;
    }
    else{
    var newTable=$('<table><thead><th>Amount</th><th>Tax</th><th>Tip</th><th>Type</th><th>Date</th><th>Reference</th></thead><tbody></tbody></table>');

    }

    if(!jd){
      allRow='<tr><td colspan="5" align="center">No data</td></tr>';
    }
    else
    {
      if(typeof jd != 'object')
      jsonData=JSON.parse(jd);
      else
        jsonData=jd;
      jsonData.forEach(function(val, i){
        if(allRow != '')
        {
         allRow+=
         '<tr><td>'+val.Amount
         +'</td><td>'+val.Tax
         +'</td><td>'+val.Tip
         +'</td><td>'+val.Type
         +'</td><td>'+val.Date
         +'</td><td>'+val.Reference
         +'</td></tr>';    
        }
        else 
        {
         allRow='<tr><td>'+val.Amount+'</td><td>'+val.Tax+'</td><td>'+val.Tip+'</td><td>'+val.Type+'</td><td>'+val.Date+'</td><td>'+val.Reference+'</td></tr>';    
        }

      });
    }
    newTable.find('tbody').html(allRow);
    // newTable.find('tbody').append(tfoot);
    $wraper.html(newTable);
    $wraper.find('table').DataTable(dtConfigHiddenTable);
  }
  </script>
  <script src="<?php echo base_url('merchant-panel'); ?>/graph/app.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript">
    function imGraph(a, b) {
      var c = {
        global: {
          useUTC: !1
        },
        chart: {
          type: 'spline',
          renderTo: "graph",
          height: 201,
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
                  lineColor: "#ffffff00",
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
                yAxis: 1,
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
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
  <!-- Begin page -->
  <div id="wrapper">
    <!-- Top Bar Start -->
    <?php //$this->load->view('admin/top'); ?> 
    <!-- Top Bar End --> 
    <!-- ========== Left Sidebar Start ========== -->
    <?php //$this->load->view('admin/menu'); ?>
    <?php  
    $total =  $getDashboardData[0]['TotalAmount'] + $getDashboardData[0]['TotalAmountRe'] + $getDashboardData[0]['TotalAmountPOS'];
    if($total!=0) {
    $straight = number_format(($getDashboardData[0]['TotalAmount']/$total)*100,2) ;
    $recurring = number_format(( $getDashboardData[0]['TotalAmountRe']/$total)*100,2) ;
    $pos = number_format(($getDashboardData[0]['TotalAmountPOS']/$total)*100,2)  ;
  }
  else
  {
    $straight = '0' ;
    $recurring = '0' ;
    $pos = '0' ;
  }
  ?>
  <?php 
  if($total!=0) { ?>
  <input type="total" name="total" id="total" value="<?php echo $getDashboardData[0]['TotalAmount'] + $getDashboardData[0]['TotalAmountRe'] + $getDashboardData[0]['TotalAmountPOS']; ?>">
  <input type="straight" name="straight" id="straight" value="<?php echo number_format(($getDashboardData[0]['TotalAmount']/$total)*100,2); ?>">
  <input type="recurring" name="recurring" id="recurring" value="<?php echo number_format(( $getDashboardData[0]['TotalAmountRe']/$total)*100,2); ?>">
  <input type="pos" name="pos" id="pos" value="<?php echo number_format(($getDashboardData[0]['TotalAmountPOS']/$total)*100,2); ?>">
  <?php } else { ?>
  <input type="total" name="total" id="total" value="0">
  <input type="straight" name="straight" id="straight" value="0">
  <input type="recurring" name="recurring" id="recurring" value="0">
  <input type="pos" name="pos" id="pos" value="0">
  <?php } ?>
      <style type="text/css">
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
      </style>
  <div class="page-wrapper">
    <div class="row dash-card">
      <div class="col-3">
        <div class="card-box">
          <div class="request">
            <span class="request-count totalorders"><?php echo $getDashboardData[0]['TotalOrders'] + $getDashboardData[0]['TotalPosorder'];?></span>
            <span class="request-name">Total Confirm Payment Request </span>
          </div>
          <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/doller-package.png"> </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card-box">
          <div class="request">
            <span class="request-count totalpendingorders"><?php echo $getDashboardData[0]['TotalpendingOrders'];?></span>
            <span class="request-name">Total Pending Payment Requests </span>
          </div>
          <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/package.png"> </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card-box">
          <div class="request">
            <span class="request-count newtotalorders"> <?php echo $getDashboardData[0]['NewTotalOrders'] + $getDashboardData[0]['TotalPosordernew'] ; ?> </span>
            <span class="request-name">New Payment Request </span>
          </div>
          <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/badge.png"> </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card-box">
          <div class="request">
            <span class="request-count totallate"> 0</span>
            <span class="request-name">Total Failed Payments</span>
          </div>
          <div class="request-icon"> <img src="<?php echo base_url('merchant-panel'); ?>/image/money-bag.png"> </div>
        </div>
      </div>
    </div>
    <div class="row employee_date_range">
      <div class="col-12 custom-form">
        <div class="form-group ">
          <div id="daterange" class="form-control">
              <span><?php echo date("F-d-Y",strtotime("-29 days"));?> - <?php echo date("F-d-Y");?></span>
              <input type="hidden" name="start_date" id="startDate" value="<?php echo date("Y-m-d",strtotime("-29 days"));?>">
              <input type="hidden" name="end_date" id="endDate" value="<?php echo date("Y-m-d");?>">
          </div>
        </div>
        <div class="form-group ">
          <?php
             $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active' , 'user_type' => 'merchant')); 
          ?>
          <select name="employee" class="form-control bder-radius" id="employee" onchange="getGraph();onSelectChange3()" >
            <option  value="all" >All Merchant</option>
            <?php foreach ($data as $view) { ?>
             <option  value="<?php echo $view['id']; ?>"><?php if(empty($view['business_dba_name'])){echo $view['name'];} else {echo $view['business_dba_name'];} ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      currency_symbol = '$';
    </script>
    <div class="row">
      <div class="col-7 saleChart-col">
        <div class="card content-card">
          <div class="card-title">
            Sales Chart
            <div id="salesChartExportDt" class="reset-dataTable">
            </div>
            <!-- <div class='mydiv pull-right'>
                  <textarea id="txt"  class="txtarea" style="display:none"   >
                    <?php 
                    $a = $item;
                    $b = $item1;
                    $c = $item2;
                    echo json_encode(array_merge($a,$b,$c));
                    ?>
                  </textarea>
                  <button id="dn" class='tn btn btn-primary gen_btn'>Download Excel CSV <i class="fa fa-download"></i></button>
                </div> -->
          </div>
          <div class="card-detail">
            <div id="graph" >
              <div class="placeholder" height="151"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-5 order-charts">
        <div class="card content-card">
          <div class="card-title">
            Order Charts
          </div>
          <div class="card-detail">
            <div class="row text-center">
              <div class="col" id="outer">
                  <!-- <div class="circliful-chart" id="aa" data-dimension="121" data-text="" data-info="Direct" data-width="8" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8"></div> -->
                  <div  id="aa" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div>
                  <div class="order-chart-text">
                    <span>Invoices</span>
                    <!-- <span>23,123</span> -->
                  </div>
              </div>
              <div class="col" id="outer1">
                  <!-- <div class="circliful-chart" id="bb" data-dimension="121" data-width="8" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8"></div> -->
                  <div id="bb" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" 
                  data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div>
                  <div class="order-chart-text">
                    <span>Recurring</span>
                    <!-- <span>4,203</span> -->
                  </div>
              </div>
              <div class="col"  id="outer2">
                  <!-- <div class="circliful-chart" data-dimension="121" id="cc" data-width="8" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8"></div> -->
                  <div id="cc" data-dimension="121" data-fontsize="21" adat-fgcolor="#2273dc" data-bgcolor="#e8e8e8" 
                  data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div>
                  <div class="order-chart-text">
                    <span>Instore & Mobile</span>
                    <!-- <span>32</span> -->
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    

  </div>
<script type="text/javascript">
  window.onload = function() {
    $("#graph").val("");
  $("#graph").html("");
    getGraph();
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
    $('#graph .placeholder').html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px">Loading...</div>');
    $('#graph h1, #graph h2').html('&nbsp;');
    $('#graph .metric1 h1').html('<i class="fa fa-spinner fa-spin"></i>');
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
  function reset(percent,divid,text,parecent)
  {
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
  function reset1(percent,divid,text,parecent)
  {
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
  function reset2(percent,divid,text,parecent)
  {
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
<!-- END wrapper --> 
<script>
  var resizefunc = [];
</script> 
<!-- Plugins  --> 
<!--   <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script> --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url(); ?>/new_assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/new_assets/js/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script>
<!-- Custom main Js -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url(); ?>/new_assets/js/jquery.circliful.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
<script>
function onSelectChange3(){
  if(!start){
    var start=$("#daterange #startDate").val();
    var end=$("#daterange #endDate").val();
  }
  var employee =  $('#employee').val(); 
  console.log(start+end+employee)
  //employee=employee.toString();
  // let emt='399';
  $.ajax({
    type: 'POST',
    url: "<?php  echo base_url('dashboard/index1'); ?>",
    data: {"start":start,"end":end,"employee":employee},  //  "employee" :employee, 
    // dataType: "text",
    success: function(dataJson)
    {
      // console.log(dataJson)
      data = JSON.parse(dataJson)
        $('.newtotalorders').html(data.widgets_data.NewTotalOrders); 
        $('.totalorders').html(data.widgets_data.TotalConfirmOrders); 
        $('.totalpendingorders').html(data.widgets_data.TotalpendingOrders); 
        $('.totallate').html(data.widgets_data.TotalFaildOrders); 
      $(data).each(function (index, element) {
        $('#start').val(element.getDashboardData[0]['TotalAmount']);
        $('#pos').val(element.getDashboardData[0]['TotalAmountPOS']);
        $('#recurring').val(element.getDashboardData[0]['TotalAmountRe']);
        var start = element.getDashboardData[0]['TotalAmount'];
        var pos = element.getDashboardData[0]['TotalAmountPOS'];
        var recurring =  element.getDashboardData[0]['TotalAmountRe'];
        recurring = isNaN(parseFloat(recurring)) ? 0 : parseFloat(recurring);
        start = isNaN(parseFloat(start)) ? 0 : parseFloat(start);
        pos = isNaN(parseFloat(pos)) ? 0 : parseFloat(pos);
        var total_amount =  parseFloat(start) + parseFloat(pos) + parseFloat(recurring);
        var start11 = parseFloat((start / total_amount)*100).toFixed(2);
        var pos11 =  parseFloat((pos/total_amount)*100).toFixed(2);
        var recurring11 =  parseFloat((recurring/total_amount)*100).toFixed(2);
        start1 = isNaN(parseFloat(start11)) ? 0 : parseFloat(start11);
        pos1 = isNaN(parseFloat(pos11)) ? 0 : parseFloat(pos11);
        recurring1 = isNaN(parseFloat(recurring11)) ? 0 : parseFloat(recurring11);
        $('#aa').attr("data-text", start1 ); //setter
        $('#aa').attr("data-percent", start1); //setter
        //console.log(recurring);
        $('#outer').html();
        //var b = $('#bb').data('text'); //getter
        $('#bb').attr("data-text", recurring1); //setter
        $('#bb').attr("data-percent", recurring1); //setter
        $('#outer1').html();
        //var c = $('#cc').data('text'); //getter
        $('#cc').attr("data-text", pos1); //setter
        $('#cc').attr("data-percent", pos1); //setter
        $('#outer2').html();
        // circliful();
        // $('.circliful-chart').circliful();
        reset('outer','aa',start1,start1);
        reset1('outer1','bb',recurring1,recurring1);
        reset2('outer2','cc',pos1,pos1);
        //$('#txt').val(element.getDashboardData[0]['TotalAmount']);
    });
      // console.log(start + end +'updating')
      // console.log(data.item3)
      saleSummeryPdfTableConvertor($('#salesChartExportDt'),data.item3,data.item5)
      // $('#txt').html('');
      // $('#txt').val(data.item3);
      
    }
  });
}
</script> 

</body>
</html>