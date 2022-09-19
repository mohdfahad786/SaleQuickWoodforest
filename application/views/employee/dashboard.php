<!DOCTYPE html>
<html lang="en">
    <head>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico"> 
    <title>Employee | Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/dcalendar.picker.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
    <link href="<?php echo base_url('merchant-panel'); ?>/plugins/jquery-circliful/css/jquery.circliful.css" rel="stylesheet" type="text/css" />
    <?php  
 $last_date = date("Y-m-d",strtotime("-29 days"));
 $date = date("Y-m-d");

  $merchant_id = $this->session->userdata('p_merchant_id');
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
      start: '<?php echo $last_date; ?>',
      end: '<?php echo $date; ?>',
      timezone: 'America/New_York',
      plan_id: 3
    };
    </script>
    <link href="<?php echo base_url('merchant-panel'); ?>/graph//app.min.css" rel="stylesheet" />
    <script src="<?php echo base_url('merchant-panel'); ?>/graph//app.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript">
        
function imGraph(a, b) {

    var c = {

        global: {

            useUTC: !1

        },

        chart: {

            renderTo: "graph",

            marginTop: 0,

            marginBottom: 40,

            borderRadius: 0,

            backgroundColor: "#ffffff"

        },

        title: {

            text: null

        },

        colors: ["#ffffff", "#00CBE6"], 

        credits: {

            enabled: !1

        },

        legend: {

            enabled: !1

        },

        plotOptions: {

            area: {

                lineWidth: 2.5,

                fillOpacity: .1,

                marker: {

                    lineColor: "#fff",

                    lineWidth: 1,

                    radius: 3.5,

                    symbol: "circle"

                },

                shadow: !1

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

            gridLineColor: "#eeeeee",

            gridLineWidth: 0,

            labels: {

                style: {

                    color: "#999999"

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

            gridLineColor: "#eeeeee",

            gridLineWidth: .5,

            zIndex: 1,

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

            gridLineColor: "#eeeeee",

            gridLineWidth: .5,

            zIndex: 2,

            labels: {

                align: "right",

                style: {

                    color: "#999999"

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

                    c = parseInt(this.points[1].y) == this.points[1].y ? this.points[1].y : this.points[1].y.toFixed(2),
          
          fee = parseInt(this.points[2].y) == this.points[2].y ? this.points[2].y : this.points[2].y.toFixed(2),

                    d = '<span style="font-size: 10px">' + moment(this.x).format("dddd, MMM D, YYYY") + "</span>",

                    e = '<span style="color: #08c">' + a.chart.series[0].name + ":</span> <b> $" + parseFloat(b).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + "</b>",

                    f = '<span style="color: #390">' + a.chart.series[1].name + ":</span> <b> $" + parseFloat(c).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") 

                    + "</b> <br/>" + '<span style="color: #C14242">' + "Fee  :" + '<b> $' + parseFloat(fee).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")

                     + '</b>' + '</span>';

                return d + " <br /> " + f + " <br /> " + e



              //  return d + " <br /> "  + f

            }

        },

        series: [{

            type: "column"

        }, {

            type: "area",

            yAxis: 1

        }, {

            type: "area",

            yAxis: 1

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
    
    
         <style type="text/css">
/*.calendar.right {
    display: none !important;
}
.daterangepicker_input {
    display: none !important;
}*/


.selectbox {
    background: #fff;
    color: #333;
    border-radius: 4px;
    height: 38px !important;
    padding: 6px 12px !important;
    line-height: 28px !important;
    border-width: thin !important;
}

</style>
    

    </head>
    <body class="fixed-left">
<!-- Begin page -->
<div id="wrapper">
<!-- Top Bar Start -->
<?php $this->load->view('employee/top'); ?>

<!-- Top Bar End --> 
<!-- ========== Left Sidebar Start ========== -->
<?php $this->load->view('employee/menu'); ?>
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
<input type="total" name="total" id="total" value="<?php echo $getDashboardData[0]['TotalAmount'] + $getDashboardData[0]['TotalAmountRe'] + $getDashboardData[0]['TotalAmountPOS']; ?>">
<?php if($total==0) { ?>
<input type="straight" name="straight" id="straight" value="<?php echo '0.00'; ?>">
<input type="recurring" name="recurring" id="recurring" value="<?php echo '0.00';; ?>">
<input type="pos" name="pos" id="pos" value="<?php echo '0.00';; ?>">

<?php }
else if ($total > 0)
{?>
<input type="straight" name="straight" id="straight" value="<?php echo number_format(($getDashboardData[0]['TotalAmount']/$total)*100,2); ?>">
<input type="recurring" name="recurring" id="recurring" value="<?php echo number_format(( $getDashboardData[0]['TotalAmountRe']/$total)*100,2); ?>">
<input type="pos" name="pos" id="pos" value="<?php echo number_format(($getDashboardData[0]['TotalAmountPOS']/$total)*100,2); ?>">
<?php }
?>

<div class="content-page">
<!-- Start content -->
<div class="content">
<div class="container-fluid"> 
      <!-- Page-Title -->
      
      
    <!--   <div class="transparent-header111">
                   <h2>Dashboard </h2>
                 </div> -->
      
      <div class="row">
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-green card-box fadeInDown animated">
        <div class="bg-icon  pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/doller-package.png"> </div>
        <div class="text-left">
              <h3 class=" m-t-10"><b class="counter"><?php echo $getDashboardData[0]['TotalOrders']+$getDashboardData[0]['TotalOrders_p'];?></b></h3>
              <p class="text-muted mb-0">Total Confirm Payment Request </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-yellow card-box">
        <div class="bg-icon pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/package.png"> </div>
        <div class="text-left">
              <h3 class=" m-t-10"><b class="counter"><?php echo $getDashboardData[0]['TotalpendingOrders'];?></b></h3>
              <p class="text-muted mb-0">Total Pending Payment Requests </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-blue card-box">
        <div class="bg-icon pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/badge.png"> </div>
        <div class="text-left">
              <h3 class=" m-t-10"><b class="counter"> <?php echo $getDashboardData[0]['NewTotalOrders']+$getDashboardData[0]['NewTotalOrders_p']; ?> </b></h3>
              <p class="text-muted mb-0">New Payment Request </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
    <div class="col-lg-3 col-md-6">
          <div class="widget-bg-color-icon light-red card-box">
        <div class="bg-icon pull-left"> <img src="<?php echo base_url('merchant-panel'); ?>/image/money-bag.png"> </div>
        <div class="text-left">
              <h3 class=" m-t-10"><b class="counter"> 0</b></h3>
              <p class="text-muted mb-0">Total Failed Payments </p>
            </div>
        <div class="clearfix"></div>
      </div>
        </div>
  </div>
      <script type="text/javascript">
currency_symbol = '$';
</script>
      <div class="card-box ">
    <div class="row" style="">
          <div class="col-md-6">
        <div id="daterange" class="selectbox form-control bder-radius"> <i class="fa fa-calendar"></i> <span><?php echo date("F-d-Y",strtotime("-29 days")); ?> - <?php echo date("F-d-Y"); ?></span> <b class="caret"></b> </div>
      </div>
          <div class="col-md-6">
        <div class="form-group ">
              <div class="icon-class">
            <?php
                  $merchant_id = $this->session->userdata('p_merchant_id');
                $data = $this->admin_model->data_get_where_1('merchant', array('merchant_id' => $merchant_id)); ?>
            <select name="employee" class="form-control bder-radius" id="employee" onchange="getGraph();onSelectChange3()" >
                  <option  value="all" >Select Employee</option>
                  <option  value="merchant" > Merchant</option>
                  <?php foreach ($data as $view) { ?>
                  <option  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
                  <?php } ?>
                </select>
            <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span> </div>
            </div>
      </div>
        </div>
  </div>
      <div class="card-box ">
    <div class="row" style="">
          <div class="col-md-6">
          <h4>Sales Charts </h4>
          
        <div class="page page-white card-box">
              <div id="graph" class="graph">
            <div class="pull-right"> 
                  
                  <!--
        <select name="graph_units" style="width: 100px; display: none">
            <option value="days">Days</option>
            <option value="weeks">Weeks</option>
            <option value="months">Months</option>
        </select>
        --> 
                  
                  <!--   <btn class="btn btn-default btn-sm graph_download" rel="tooltip" title="Download Excel CSV" style="margin-left: 7px; background: #fff; border-width: 1px"><i class="fa fa-download"></i></btn>
 -->
                  <div class='mydiv'>
                <textarea id="txt"  class="txtarea" style="display: none;"  >



        <?php 

  $a = $item;
  $b = $item1;
  $c = $item2;
   $d = $item4;
      

echo json_encode(array_merge($a,$b,$c,$d));



                      ?>


</textarea>
                <button id="dn" class='tn btn btn-primary gen_btn'>Download Excel CSV <i class="fa fa-download"></i></button>
              </div>
                </div>
            
            <!--  <div class="pull-left metric1">
        <h1 style="font-weight: normal; color: #08c; margin: 0; font-size: 30px; line-height: 1.1em"></h1>
        <h2 style="font-weight: normal; color: #ababab; margin: 0; letter-spacing: .15em; text-transform: uppercase; line-height: 1.5em; font-size: 12px">People</h2>
    </div>

    <div class="pull-left metric2" style="margin-left: 30px">
        <h1 style="font-weight: normal; color: #390; margin: 0; font-size: 30px; line-height: 1.1em"></h1>
        <h2 style="font-weight: normal; color: #ababab; margin: 0; letter-spacing: .15em; text-transform: uppercase; line-height: 1.5em; font-size: 12px">Conversions</h2>
    </div> -->
            
            <div class="placeholder" style="clear: both; margin: 0 -10px -10px -10px"></div>
          </div>
            </div>
      </div>
          <div class="col-md-6">
          
           <h3>Order Charts </h3>
        <div class="card-box">
        
              <h4 class="m-t-0 header-title"><b>&nbsp;</b></h4>
              <p class="text-muted m-b-30 font-13"> Your awesome text goes here. </p>

              <div class="row text-center">
            <div class="col-sm-6 col-lg-4 col-md-4" id="outer">
                  <div class="circliful-chart" id="aa" data-dimension="140" data-text="" data-info="Direct" data-width="20" data-fontsize="24" data-percent="" data-fgcolor="#34d3eb" data-bgcolor="#ebeff2" data-fill="#f4f8fb"></div>
                </div>
            <div class="col-sm-6 col-lg-4 col-md-4" id="outer1">
               <div class="circliful-chart m-b-30" id="bb" data-dimension="140" data-text="" data-info="Recur" data-width="20" data-fontsize="24" data-percent="" data-fgcolor="#5fbeaa" data-bgcolor="#ebeff2" data-fill="#f4f8fb"></div>
                </div>
            <div class="col-sm-6 col-lg-4 col-md-4" id="outer2">
                  <div class="circliful-chart" data-dimension="140" id="cc" data-text="" data-info="Pos" data-width="20" data-fontsize="24" data-percent="" data-fgcolor="#ffbd4a" data-bgcolor="#ebeff2"  ></div>
                </div>

          </div>
            </div>
      </div>
        </div>
  </div>
      <div class="card-box ">
    <div class="row" style="">
        <div class="col-md-12">
        <h4> Sales Compare <?php echo date("Y",strtotime("-1 year")) ?> and   <?php echo date("Y") ?> </h4>
        </div>
          <!-- <div class="col-md-6">
        <div class="form-group ">
              <div class="icon-class">
            <select name="start_year" class="form-control bder-radius" id="start_year" >
                  <option  value="2017"> 2017</option>
                  <option  value="2018"> 2018</option>
                                             <option  value="2019"> 2019</option>
                                              <option  value="2020"> 2020</option>
                  
                </select>
            <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span> </div>
            </div>
        
      
        
      </div> -->
         <!--  <div class="col-md-6">
        <div class="form-group ">
              <div class="icon-class">
            <select name="end_year" class="form-control bder-radius" id="end_year" >
                  <option  value="2018"> 2018</option>
               
                </select>
            <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span> </div>
            </div>
      </div> -->
        </div>
  </div>
      <div class="card-box ">
    <div class="row">
          <div class="col-md-12">
        <div class="portlet">
              <div class="portlet-heading portlet-default">
            <h3 class="portlet-title"> Sales by Year </h3>
            <ul class="nav nav-pills navtab-bg nav-justified pull-right">
                </ul>
            <div class="clearfix"></div>
          </div>
              <div id="bg-default" class="panel-collapse collapse show">
            <div class="portlet-body">
                  <div class="tab-pane fade show active" id="profile1">
                <div id="chart1" height="350"> </div>
              </div>
                </div>
          </div>
            </div>
      </div>
        </div>
  </div>
    </div>
<script type="text/javascript">
    
$(document).ready(function(){
    $('#dn').click(function(){
        var data = $('#txt').val();
        if(data == '')
            return;
        
        JSONToCSVConvertor(data, "csv Report", true);
    });
});

function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "MyReport_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
       document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

</script> 
<script type="text/javascript">

var updates = 0;
var loading = $('#report tbody .loading').hide().clone();
var nodata = $('#report tbody .nodata').hide().clone();
var timeout = $('#report tbody .timeout').hide().clone();

$(document).ready(function() {
   // getTable();
    getGraph();
    onSelectChange3();
});



function getGraph(start, end, employee) {


     var employee =  $('#employee').val();
    $('#graph .placeholder').html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px">Loading...</div>');
    $('#graph h1, #graph h2').html('&nbsp;');
    $('#graph .metric1 h1').html('<i class="fa fa-spinner fa-spin"></i>');

   var jsonurl = '<?php echo base_url('merchant-panel'); ?>/graph/graph.php?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>&employee=<?php echo 'all'; ?>';
    jsonurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
    jsonurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2 + '&units=' + userprefs.units +'&employee=' + employee + '&merchant=' + userprefs.merchant + '&fee=' + userprefs.fee ;

    if (typeof location.search == 'string' && location.search.length > 0)
        jsonurl += '&' + location.search.substring(1);

    if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null )
        jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) ;

    $.getJSON(jsonurl, function(data) {
        if (data.length != 0) imGraph('graph', data);
    });


}

function downloadGraph() {
    var dlurl = '<?php echo base_url('merchant-panel'); ?>/graph/graph.php?filters[ad]=1&start=<?php echo $last_date; ?>&end=?php echo $date; ?>';
    dlurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
    dlurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2;
    if (typeof location.search == 'string' && location.search.length > 0)
        dlurl += '&' + location.search.substring(1);
    window.location = dlurl;
}

function reset(percent,divid,text,parecent)
{
$("#"+divid).remove();
$("#"+percent).append('<div id="'+divid+'"></div>');
$("#"+divid).attr("data-dimension", "140");
$("#"+divid).attr("data-info", 'Invoices %');
$("#"+divid).attr("data-width", "20");
$("#"+divid).attr("data-fontsize", "24");
$("#"+divid).attr("data-fgcolor", "#34d3eb");
$("#"+divid).attr("data-bgcolor", "#ebeff2");
$("#"+divid).attr("data-text", text.toString());
$("#"+divid).attr("data-percent", parecent.toString());
$("#"+divid).circliful();
}



function reset1(percent,divid,text,parecent)
{
$("#"+divid).remove();
$("#"+percent).append('<div id="'+divid+'"></div>');
$("#"+divid).attr("data-dimension", "140");
$("#"+divid).attr("data-info", 'Recur %');
$("#"+divid).attr("data-width", "20");
$("#"+divid).attr("data-fontsize", "24");
$("#"+divid).attr("data-fgcolor", "#5fbeaa");
$("#"+divid).attr("data-bgcolor", "#ebeff2");
$("#"+divid).attr("data-text", text.toString());
$("#"+divid).attr("data-percent", parecent.toString());
$("#"+divid).circliful();
}

function reset2(percent,divid,text,parecent)
{
$("#"+divid).remove();
$("#"+percent).append('<div id="'+divid+'"></div>');
$("#"+divid).attr("data-dimension", "140");
$("#"+divid).attr("data-info", 'Pos %');
$("#"+divid).attr("data-width", "20");
$("#"+divid).attr("data-fontsize", "24");
$("#"+divid).attr("data-fgcolor", "#ffbd4a");
$("#"+divid).attr("data-bgcolor", "#ebeff2");
$("#"+divid).attr("data-text", text.toString());
$("#"+divid).attr("data-percent", parecent.toString());
$("#"+divid).circliful();
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
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/wow.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.js"></script>

        <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
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


<script src="<?php echo base_url('merchant-panel'); ?>/plugins/jquery-circliful/js/jquery.circliful.min.js"></script> 
<script>

            // $(function circular() {
            //    // $(".knob").knob();
            //     $('.circliful-chart').circliful();
            // });




function onSelectChange3(start, end){

  $('.circliful-chart').html('');

    var start =  encodeURIComponent(start);
     var end =  encodeURIComponent(end);
         var employee =  $('#employee').val();   
            $.ajax({
                type: 'POST',
             
                 url: "<?php  echo base_url('merchant/index1'); ?>",

                data: {start: start , end : end , employee : employee },
                type:'post',
                success: function (dataJson)
                {
                    data = JSON.parse(dataJson)
                   
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
    
    var total_amount =  parseFloat(start) + parseFloat(pos) + parseFloat(recurring) ;
    
     var start11 = parseFloat((start / total_amount)*100).toFixed(2);
      var pos11 =  parseFloat((pos/total_amount)*100).toFixed(2);
     var recurring11 =  parseFloat((recurring/total_amount)*100).toFixed(2);

      start1 = isNaN(parseFloat(start11)) ? 0 : parseFloat(start11);
       pos1 = isNaN(parseFloat(pos11)) ? 0 : parseFloat(pos11);
        recurring1 = isNaN(parseFloat(recurring11)) ? 0 : parseFloat(recurring11);


//var a = $('#aa').data('text'); //getter
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

   $('.circliful-chart').circliful();



   reset('outer','aa',start1,start1);
   
    reset1('outer1','bb',recurring1,recurring1);
  
   reset2('outer2','cc',pos1,pos1);

  //$('#txt').val(element.getDashboardData[0]['TotalAmount']);


                    });
                    
                    $('#txt').html('');
             $('#txt').val(data.item3);
             // $('#txt').val(data.item4);
             //console.log(data.item3);
                 
                }
            });

}


        </script> 
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



    

   $(function () {     

 var data1 = <?php echo $getDashboardData[0]['Totaljan'] ?  $getDashboardData[0]['Totaljan'] :'0'."" ?>;
 var data2 = <?php echo $getDashboardData[0]['Totalfeb'] ?  $getDashboardData[0]['Totalfeb'] :'0'."" ?>;
 var data3 = <?php echo $getDashboardData[0]['Totalmarch'] ?  $getDashboardData[0]['Totalmarch'] :'0'."" ?>;
 var data4 = <?php echo $getDashboardData[0]['Totalaprl'] ?  $getDashboardData[0]['Totalaprl'] :'0'."" ?>;
 var data5 = <?php echo $getDashboardData[0]['Totalmay'] ?  $getDashboardData[0]['Totalmay'] :'0'."" ?>;
 var data6 = <?php echo $getDashboardData[0]['Totaljune'] ?  $getDashboardData[0]['Totaljune'] :'0'."" ?>;
 var data7 = <?php echo $getDashboardData[0]['Totaljuly'] ?  $getDashboardData[0]['Totaljuly'] :'0'."" ?>;
 var data8 = <?php echo $getDashboardData[0]['Totalaugust'] ?  $getDashboardData[0]['Totalaugust'] :'0'."" ?>;
 var data9 = <?php echo $getDashboardData[0]['Totalsep'] ?  $getDashboardData[0]['Totalsep'] :'0'."" ?>;
 var data10 = <?php echo $getDashboardData[0]['Totaloct'] ?  $getDashboardData[0]['Totaloct'] :'0'."" ?>;
 var data11 = <?php echo $getDashboardData[0]['Totalnov'] ?  $getDashboardData[0]['Totalnov'] :'0'."" ?>  ;
 var data12 = <?php echo  $getDashboardData[0]['Totaldec'] ?  $getDashboardData[0]['Totaldec'] :'0'."" ?> ;


 var dataf1 = <?php echo $getDashboardData[0]['Totaljanf'] ?  $getDashboardData[0]['Totaljanf'] :'0'."" ?>;
 var dataf2 = <?php echo $getDashboardData[0]['Totalfebf'] ?  $getDashboardData[0]['Totalfebf'] :'0'."" ?>;
 var dataf3 = <?php echo $getDashboardData[0]['Totalmarchf'] ?  $getDashboardData[0]['Totalmarchf'] :'0'."" ?>;
 var dataf4 = <?php echo $getDashboardData[0]['Totalaprlf'] ?  $getDashboardData[0]['Totalaprlf'] :'0'."" ?>;
 var dataf5 = <?php echo $getDashboardData[0]['Totalmayf'] ?  $getDashboardData[0]['Totalmayf'] :'0'."" ?>;
 var dataf6 = <?php echo $getDashboardData[0]['Totaljunef'] ?  $getDashboardData[0]['Totaljunef'] :'0'."" ?>;
 var dataf7 = <?php echo $getDashboardData[0]['Totaljulyf'] ?  $getDashboardData[0]['Totaljulyf'] :'0'."" ?>;
 var dataf8 = <?php echo $getDashboardData[0]['Totalaugustf'] ?  $getDashboardData[0]['Totalaugustf'] :'0'."" ?>;
 var dataf9 = <?php echo $getDashboardData[0]['Totalsepf'] ?  $getDashboardData[0]['Totalsepf'] :'0'."" ?>;
 var dataf10 = <?php echo $getDashboardData[0]['Totaloctf'] ?  $getDashboardData[0]['Totaloctf'] :'0'."" ?>;
 var dataf11 = <?php echo $getDashboardData[0]['Totalnovf'] ?  $getDashboardData[0]['Totalnovf'] :'0'."" ?>  ;
 var dataf12 = <?php echo  $getDashboardData[0]['Totaldecf'] ?  $getDashboardData[0]['Totaldecf'] :'0'."" ?> ;

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
var datatex11 = <?php echo $getDashboardData[0]['Totalnovtax'] ?  $getDashboardData[0]['Totalnovtax'] :'0'."" ?>;
var datatex12 = <?php echo $getDashboardData[0]['Totaldectax'] ?  $getDashboardData[0]['Totaldectax'] :'0'."" ?>;


var datab1 = <?php echo $getDashboardData[0]['Totalbjan'] ?  $getDashboardData[0]['Totalbjan'] :'0'."" ?>;
 var datab2 = <?php echo $getDashboardData[0]['Totalbfeb'] ?  $getDashboardData[0]['Totalbfeb'] :'0'."" ?>;
 var datab3 = <?php echo $getDashboardData[0]['Totalbmarch'] ?  $getDashboardData[0]['Totalbmarch'] :'0'."" ; ?>;
 var datab4 = <?php echo $getDashboardData[0]['Totalbaprl'] ?  $getDashboardData[0]['Totalbaprl'] :'0'."" ; ?>;
 var datab5 = <?php echo $getDashboardData[0]['Totalbmay']  ?  $getDashboardData[0]['Totalbmay'] :'0'."" ; ?>;
 var datab6 = <?php echo $getDashboardData[0]['Totalbjune'] ?  $getDashboardData[0]['Totalbjune'] :'0'."" ; ?>;
 var datab7 = <?php echo $getDashboardData[0]['Totalbjuly']  ?  $getDashboardData[0]['Totalbjuly'] :'0'."" ; ?>;
 var datab8 = <?php echo $getDashboardData[0]['Totalbaugust']  ?  $getDashboardData[0]['Totalbaugust'] :'0'."" ; ?>;
 var datab9 = <?php echo $getDashboardData[0]['Totalbsep']  ?  $getDashboardData[0]['Totalbsep'] :'0'."" ; ?>;
 var datab10 = <?php echo $getDashboardData[0]['Totalboct'] ?  $getDashboardData[0]['Totalboct'] :'0'."" ; ?>;
 var datab11 = <?php echo $getDashboardData[0]['Totalbnov'] ?  $getDashboardData[0]['Totalbnov'] :'0'."" ; ?>;
  var datab12 = <?php echo ($getDashboardData[0]['Totalbdec']) ?  $getDashboardData[0]['Totalbdec'] :'0'."" ; ?>;


 var dataf1b = <?php echo $getDashboardData[0]['Totalbjanf'] ?  $getDashboardData[0]['Totalbjanf'] :'0'."" ?>;
 var dataf2b = <?php echo $getDashboardData[0]['Totalbfebf'] ?  $getDashboardData[0]['Totalbfebf'] :'0'."" ?>;
 var dataf3b = <?php echo $getDashboardData[0]['Totalbmarchf'] ?  $getDashboardData[0]['Totalbmarchf'] :'0'."" ?>;
 var dataf4b = <?php echo $getDashboardData[0]['Totalbaprlf'] ?  $getDashboardData[0]['Totalbaprlf'] :'0'."" ?>;
 var dataf5b = <?php echo $getDashboardData[0]['Totalbmayf'] ?  $getDashboardData[0]['Totalbmayf'] :'0'."" ?>;
 var dataf6b = <?php echo $getDashboardData[0]['Totalbjunef'] ?  $getDashboardData[0]['Totalbjunef'] :'0'."" ?>;
 var dataf7b = <?php echo $getDashboardData[0]['Totalbjulyf'] ?  $getDashboardData[0]['Totalbjulyf'] :'0'."" ?>;
 var dataf8b = <?php echo $getDashboardData[0]['Totalbaugustf'] ?  $getDashboardData[0]['Totalbaugustf'] :'0'."" ?>;
 var dataf9b = <?php echo $getDashboardData[0]['Totalbsepf'] ?  $getDashboardData[0]['Totalbsepf'] :'0'."" ?>;
 var dataf10b = <?php echo $getDashboardData[0]['Totalboctf'] ?  $getDashboardData[0]['Totalboctf'] :'0'."" ?>;
 var dataf11b = <?php echo $getDashboardData[0]['Totalbnovf'] ?  $getDashboardData[0]['Totalbnovf'] :'0'."" ?>  ;
 var dataf12b = <?php echo  $getDashboardData[0]['Totalbdecf'] ?  $getDashboardData[0]['Totalbdecf'] :'0'."" ?> ;

var datatex1b = <?php echo $getDashboardData[0]['Totalbjantax'] ?  $getDashboardData[0]['Totalbjantax'] :'0'."" ?>;
var datatex2b = <?php echo $getDashboardData[0]['Totalbfebtax'] ?  $getDashboardData[0]['Totalbfebtax'] :'0'.""; ?>;
var datatex3b = <?php echo $getDashboardData[0]['Totalbmarchtax'] ?  $getDashboardData[0]['Totalbmarchtax'] :'0'."" ?>;
var datatex4b = <?php echo $getDashboardData[0]['Totalbaprltax'] ?  $getDashboardData[0]['Totalbaprltax'] :'0'."" ?>;
var datatex5b = <?php echo $getDashboardData[0]['Totalbmaytax'] ?  $getDashboardData[0]['Totalbmaytax'] :'0'."" ?>;
var datatex6b = <?php echo $getDashboardData[0]['Totalbjunetax'] ?  $getDashboardData[0]['Totalbjunetax'] :'0'."" ?>;
var datatex7b = <?php echo $getDashboardData[0]['Totalbjulytax'] ?  $getDashboardData[0]['Totalbjulytax'] :'0'."" ?>;
var datatex8b = <?php echo $getDashboardData[0]['Totalbaugusttax'] ?  $getDashboardData[0]['Totalbaugusttax'] :'0'."" ?>;
var datatex9b = <?php echo $getDashboardData[0]['Totalseptax'] ?  $getDashboardData[0]['Totalseptax'] :'0'."" ?>;
var datatex10b = <?php echo $getDashboardData[0]['Totalbocttax'] ?  $getDashboardData[0]['Totalbocttax'] :'0'."" ?>;
var datatex11b = <?php echo $getDashboardData[0]['Totalbnovtax'] ?  $getDashboardData[0]['Totalbnovtax'] :'0'."" ?>;
var datatex12b = <?php echo $getDashboardData[0]['Totalbdectax'] ?  $getDashboardData[0]['Totalbdectax'] :'0'."" ?>;

   var t_fee =<?php echo   $this->session->userdata('t_fee') ?>;
    var fee = (data12/100)*t_fee;
 
  var curent_year = <?php echo date("Y") ?>;
  var last_year = <?php echo date("Y",strtotime("-1 year")) ?>;


 Highcharts.chart('chart1', {
        chart: {
            type: 'area',
            spacingBottom: 30,
            height:300
            
        },
        title: {
            text: null
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                style: {
                    color: '#A7BBC4'
                }
            },
            min: 0.5,
            max: 10.5
        },
        yAxis: {

            title: {
                text: false
            },
            labels: {
                style: {
                    color: '#A7BBC4'
                }
            },

            tickInterval: 5000,
            //step: 9000,
            labels: {
                formatter: function() {
                    return this.value;
                }

            },
            //min: 5000
        },
        exporting: { enabled: false },
        tooltip: {
            formatter: function() {
                return '<b>' + this.series.name + ': (' +  this.x + ') </b><br/>' +
                    'Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")     +  ' <br/> ' + 'Fee: $' + this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '<br/>'  + 'Tax: $'+ this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            }
        },
        credits: {
            enabled: false
        },

        plotOptions: {
            series: {
                marker: {
                    fillColor: '#FFFFFF',
                    lineWidth: 2,
                    lineColor: null, // inherit from series
                    symbol: 'circle'
                }
            }
        },
        series: [{

             name: 'Merchant-'+ curent_year  ,
               type: "area",
            color: '#81D33F',
            showInLegend: false,
            fillColor: {
                linearGradient: [0, 50, 0, 270],
                stops: [
                    [0, '#81D33F'],
                    [1, '#fff']
                ]
            },
            data: [{y:data1, tax :datatex1 , fee :dataf1}, {y:data2, tax :datatex2 , fee :dataf2},{y:data3, tax :datatex3 , fee :dataf3},{y:data4, tax :datatex4 , fee :dataf4},{y:data5, tax :datatex5 , fee :dataf5},{y:data6, tax :datatex6 , fee :dataf6},{y:data7, tax :datatex7 , fee :dataf7},{y:data8, tax :datatex8 , fee :dataf8},{y:data9, tax :datatex9 , fee :dataf9},{y:data10, tax :datatex10 , fee :dataf10},{y:data11, tax :datatex11 , fee :dataf11},{y:data12, tax :datatex12 , fee :dataf12}]
        }, 



        {
            name: 'Merchant-'+ last_year ,
            type: "area",
            color: '#FFB30F',
            showInLegend: false,
            fillColor: {
                linearGradient: [0, 50, 0, 270],
                stops: [
                    [0, '#F8B118'],
                    [1, '#fff']
                ]
            },
            

              data: [{y:datab1, tax :datatex1b, fee :dataf1b}, {y:datab2, tax :datatex2b, fee :dataf2b},{y:datab3, tax :datatex3b, fee :dataf3b},{y:datab4, tax :datatex4b, fee :dataf4b},{y:datab5, tax :datatex5b, fee :dataf5b},{y:datab6, tax :datatex6b, fee :dataf6b},{y:datab7, tax :datatex7b, fee :dataf7b},{y:datab8, tax :datatex8b, fee :dataf8b},{y:datab9, tax :datatex9b, fee :dataf9b},{y:datab10, tax :datatex10b, fee :dataf10b},{y:datab11, tax :datatex11b, fee :dataf11b},{y:datab12, tax :datatex12b, fee :dataf12b}]
        }]
    });
   
    });
    </script>
</body>
</html>