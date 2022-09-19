<!DOCTYPE html>
<html lang="en">
     <head>
     <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width,initial-scale=1">
     <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
     <meta name="author" content="Coderthemes">
     <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
     <title>Admin | Dashboard</title>
     <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
     <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
     <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
     <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
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
    </script>
     <script type="text/javascript">
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
    </script>
     <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />
     <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
     <script src="<?php echo base_url('merchant-panel'); ?>/graph/app1.min.js"></script>
     <script src="<?php echo base_url('merchant-panel'); ?>/graph/app2.js"></script>
     <?php $this->load->view('merchant/top'); ?>
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

                    lineColor: "#03A9F4",

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
.daterangepicker .ranges li {
}
</style>
     </head>
     <body class="fixed-left">
<!-- Begin page -->
<div id="wrapper"> 
       <!-- Top Bar Start -->
       <?php $this->load->view('admin/top'); ?>
       
       <!-- Top Bar End --> 
       <!-- ========== Left Sidebar Start ========== -->
       <?php $this->load->view('admin/menu'); ?>
       <div class="content-page"> 
    <!-- Start content -->
    <div class="content">
           <div class="container-fluid">
        <div > 
               <script type="text/javascript">
currency_symbol = '$';
</script>
               <div class="row1">
            <div class="transparent-header111">
                   <h2>Sales Summary</h2>
                 </div>
            <div class="card-box col-md-12">
                   <div class="col-md-6 col-sm-6">
                <div id="daterange" class="selectbox form-control bder-radius"> <i class="fa fa-calendar"></i> <span><?php echo date("F-d-Y",strtotime("-29 days")); ?> - <?php echo date("F-d-Y"); ?> </span> <b class="caret"></b> </div>
              </div>
                   <!-- <div class="col-md-2">
    
        <div class="pull-right" style="margin-right: 10px">
            <select name="goal" id="goalfilter" style="width: 150px" multiple="multiple">
                                <option value="sale">Sale</option>
                            </select>
        </div>
    </div> -->
                   
                   <div class="col-md-4 col-sm-4"> 
                <!--  <select name="graph_units" style="width: 100px;" >
            <option value="days">Days</option>
            <option value="weeks">Weeks</option>
            <option value="months">Months</option>
        </select>
    </div>

      <div class="form-group "> -->
                <div class="icon-class">
                       <?php
                
                               
     $data = $this->admin_model->data_get_where_1('merchant', array('status' => 'active', 'user_type' => 'merchant')); ?>
                       <select name="employee" class="form-control bder-radius" id="employee" onchange="getGraph();getTable();" >
                    <option  value="all" >All Merchant</option>
                   <!--  <option  value="merchant" > Merchant</option> -->
                    <?php foreach ($data as $view) { ?>
                    <option  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
                    <?php } ?>
                  </select>
                       <span class="drop-icon"><i class="fa fa-angle-down " aria-hidden="true"></i></span> </div>
              </div>
                   <div class="col-md-2 col-sm-3 pull-right">
                <div class='mydiv'>
                       <textarea id="txt"  class="txtarea" style="display: none;"  >



        <?php 

  $a = $item;
  $b = $item1;
$c = $item2;
 // echo  $d = $item['reference'];
  
 
      

echo json_encode(array_merge($a,$b,$c));



                      ?>


</textarea>
                       <button id="dn" class='tn btn btn-primary pull-right'>Download  CSV <i class="fa fa-download"></i></button>
                     </div>
                <!-- <btn class="btn btn-default btn-sm graph_download" rel="tooltip" title="Download Excel CSV" style="margin-left: 7px; background: #fff; border-width: 1px">
        <i class="fa fa-download"></i></btn> --> 
                
              </div>
                 </div>
          </div>
               
               <!-- card-box-->
               <div class="clearfix"></div>
               <div class="card-box col-md-12">
            <div id="heading"  class="transparent-header">
                   <h3><span><?php echo date("F-d-Y",strtotime("-29 days")); ?> - <?php echo date("F-d-Y"); ?></span></h3>
                 </div>
            <div class="row" style="margin-bottom: 20px">
                   <div class="col-md-12">
                <div class="page page-white">
                       <div id="graph" class="graph">
                    <div class="pull-right"> </div>
                    <div class="placeholder" style="clear: both; margin: 0 -10px -10px -10px"></div>
                  </div>
                     </div>
              </div>
                 </div>
          </div>
               <div class="clearfix"></div>
               <div class="card-box col-md-12"> 
            <!-- strat graph -->
            <div class="transparent-header">
                   <h3>TIME OF DAY</h3>
                 </div>
            
            <!-- <div class="row" style="margin-bottom: 20px">
    <div class="col-md-12">
        <div class="page page-white">
            <div id="new_graph" class="graph">

   
 
    <div class="placeholder" style="clear: both; margin: 0 -10px -10px -10px"></div>

</div>      </div>
    </div>
</div> --> 
            <!-- End Graph -->
            
            <div class="row">
                   <div class="col-md-12">
                <div class="portlet">
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
               <div class="clearfix"></div>
               <div class="row1">
            <div class="card-box col-md-12">
                   <div class="page page-white" style="padding: 0">
                <table id="report" class="table-striped">
                       <thead>
                    <tr>
                           <th style="text-align: left; width: 100%"></th>
                           <th>Sales</th>
                           <th >Refunds</th>
                           <th >total</th>
                           <!--  <th title="Conversions: Number of times one of your goals was reached">Conv.</th>
                        <th title="Conversion Rate: Percentage of people that reached one of your goals">CR</th>
                        <th title="Total PPC cost from these ad clicks">Cost</th>
                        <th title="Cost Per Acquisition: Average cost to acquire one goal conversion">CPA</th>
                        <th title="Cost Per Click (Visit)" class="hidden-sm hidden-xs hidden-md">CPC</th>
                        <th title="Revenue from goal conversions">Revenue</th>
                        <th title="Revenue Per Person" class="hidden-sm hidden-xs hidden-md">RPP</th>
                        <th title="Revenue minus cost">Profit</th> --> 
                         </tr>
                  </thead>
                       <tbody>
                    <tr class="loading">
                           <td colspan="11" style="text-align: center"><div class="message">
                               <div class="progress">
                               <div class="progress-bar progress-bar-striped active" style="width: 100%;"></div>
                             </div>
                               Your report is being generated. This may take up to several minutes... </div></td>
                         </tr>
                    <tr class="nodata">
                           <td colspan="11" style="text-align: center"><div class="message"> There is no data to display for the selected date range. 
                               
                               Have you installed the <a href="/code/webshop">Improvely Tracking Code</a> on your site, and updated your ads with <a href="/tools/webshop/link_builder">tracking links</a>? </div></td>
                         </tr>
                    <tr class="timeout">
                           <td colspan="11" style="text-align: center"><div class="message"> Report generation has timed out. </div></td>
                         </tr>
                  </tbody>
                       <tfoot>
                  </tfoot>
                     </table>
              </div>
                   
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
               <div class="clearfix"></div>
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
    getTable();
    getGraph();
    
      getGraph1() ;
    
});


function onSelectChange3(start, end){

    var start =  encodeURIComponent(start);
     var end =  encodeURIComponent(end);
           
            $.ajax({
                type: 'POST',
             
                 url: "<?php  echo base_url('Admin_Graph/sale'); ?>",

                data: {start: start , end : end },
                type:'post',
                success: function (dataJson)
                {
                    data = JSON.parse(dataJson)
                   
                    $(data).each(function (index, element) {
       $('#Totaljan').val(element.getDashboardData[0]['Totaljan']);  

         $('#Totalfeb').val(element.getDashboardData[0]['Totalfeb']);  
         $('#Totalmarch').val(element.getDashboardData[0]['Totalmarch']);  
        $('#Totalaprl').val(element.getDashboardData[0]['Totalaprl']);  
        $('#Totalmay').val(element.getDashboardData[0]['Totalmay']);  
         $('#Totaljune').val(element.getDashboardData[0]['Totaljune']);  
         $('#Totaljuly').val(element.getDashboardData[0]['Totaljuly']);  
         $('#Totalaugust').val(element.getDashboardData[0]['Totalaugust']);  
         $('#Totalsep').val(element.getDashboardData[0]['Totalsep']);  
          $('#Totaloct').val(element.getDashboardData[0]['Totaloct']);  

       
        $('#Totalnov').val(element.getDashboardData[0]['Totalnov']);
         $('#Totaldec').val(element.getDashboardData[0]['Totaldec']);


         $('#Totalnovtax').val(element.getDashboardData[0]['Totalnovtax']);
         $('#Totaldectax').val(element.getDashboardData[0]['Totaldectax']);

         $('#Totalnovfee').val(element.getDashboardData[0]['Totalnovfee']);
         $('#Totaldecfee').val(element.getDashboardData[0]['Totaldec']);

        
       
       getGraph1() ;

                    });
                    
                     // $('#txt').val('');
         $('#txt').html('');
          $('#txt').val(data.item3);
          
         
                 
                }
            });

}



function getGraph(start, end) {

      var employee =  $('#employee').val();
    $('#graph .placeholder').html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px">Loading...</div>');
    $('#graph h1, #graph h2').html('&nbsp;');
    $('#graph .metric1 h1').html('<i class="fa fa-spinner fa-spin"></i>');

   var jsonurl = '<?php echo base_url('merchant-panel'); ?>/graph/graph_dashboard.php?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>';
    jsonurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);
    jsonurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2 + '&units=' + userprefs.units +'&employee=' + employee + '&merchant='  ;

    if (typeof location.search == 'string' && location.search.length > 0)
        jsonurl += '&' + location.search.substring(1);

    if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null )
        jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) ;

    $.getJSON(jsonurl, function(data) {
        if (data.length != 0) imGraph('graph', data);
    });


}



function getTable(start, end) {

   var employee =  $('#employee').val();
    $('#report tbody').html(loading.html());
    $('#report tfoot').html('');

    var jsonurl = '<?php echo base_url('merchant-panel'); ?>/graph/report_dashboard.php?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>';
    if (typeof location.search == 'string' && location.search.length > 0)
        jsonurl += '?' + location.search.substring(1) + '&type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal) +'&employee=' + employee + '&merchant=' + userprefs.merchant;

    else
        jsonurl += '?type=ad&filters[goal]=' + encodeURIComponent(userprefs.goal) +'&employee=' + employee + '&merchant=' + userprefs.merchant;


    if (typeof start != 'undefined' && typeof end != 'undefined' && start != null && end != null)
        jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end);

    $.post(jsonurl, function(data) {

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

                // html += '<td><a href="' + url + '">' + add_commas(data[row]['conversions']) + '</a></td>';

                // html += '<td>' + format_rate(data[row]['converted_people'] / data[row]['people']) + '</td>';
                // html += '<td>' + format_money(data[row]['cost']) + '</td>';
                // html += '<td>' + format_money(data[row]['cost'] / data[row]['conversions']) + '</td>';
                // html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(data[row]['cost'] / data[row]['clicks']) + '</td>';
                // html += '<td>' + format_money(data[row]['revenue']) + '</td>';
                // html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(data[row]['revenue'] / data[row]['people']) + '</td>';
                // html += '<td>' + format_money(data[row]['revenue'] - data[row]['cost']) + '</td>';
                
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
        // html += '<td style="text-align: left"><b>Totals:</b></td>';
        // html += '<td>' + format_money(people) + '</td>';
        // html += '<td>' + format_money(clicks) + '</td>';          
        // html += '<td>' + format_money(converted_people) + '</td>';

        // html += '<td>' + add_commas(conversions) + '</td>';
        // html += '<td>' + format_rate(converted_people / people) + '</td>';
        // html += '<td>' + format_money(cost) + '</td>';
        // html += '<td>' + format_money(cost / conversions) + '</td>';
        // html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(cost / clicks) + '</td>';
        // html += '<td>' + format_money(revenue) + '</td>';
        // html += '<td class="hidden-sm hidden-xs hidden-md">' + format_money(revenue / people) + '</td>';
        // html += '<td>' + format_money(revenue - cost) + '</td>';

        html += '</tr>';

        $('#report tfoot').html(html);

    }, 'json').fail(function() {
        $('#report tbody').html(timeout.html());
    });

}

</script> 
               <script>
    var resizefunc = [];
    </script> 
               <!-- Plugins  --> 
               <!--    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script> --> 
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




    

function getGraph1(start, end) {    

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




 Highcharts.chart('chart1', {
        chart: {
            type: 'area',
            spacingBottom: 30,
            height:250
        },
        title: {
            text: null
        },

        xAxis: {
           categories: ['12 am', '2 am', '4 am', '6 am', '8 am', '10 am', '12 pm', '2 pm', '4 pm', '6 pm', '8 pm', '10 pm'],            labels: {
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
                    return  '$' + this.value ;
                }

            },
            //min: 5000
        },
        exporting: { enabled: false },
        tooltip: {
            formatter: function() {
               return '<b>' + this.series.name + ': (' +  this.x + ') </b><br/>' +
                    'Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")     +  ' <br/> ' + 'Fee: $' +
                     this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '<br/>'  + 'Tax: $'+ this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
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

             name: 'Merchant'  ,
               type: "area",
            color: '#00DFEF',
            showInLegend: false,
            fillColor: {
                //linearGradient: [0, 50, 0, 270],
                stops: [
                    [0, '#00DFEF'],
                    [1, '#fff']
                ]
            },
             data: [{y:data1, tax :datatex1 ,fee :datafee1}, {y:data2, tax :datatex2 ,fee :datafee2},{y:data3, tax :datatex3 ,fee :datafee3},{y:data4, tax :datatex4,fee :datafee4},{y:data5, tax :datatex5 ,fee :datafee5},{y:data6, tax :datatex6, fee :datafee6},{y:data7, tax :datatex7 ,fee :datafee7},{y:data8, tax :datatex8 ,fee :datafee8},{y:data9, tax :datatex9 ,fee :datafee9},{y:data10, tax :datatex10 ,fee :datafee10},{y:data11, tax :datatex11 ,fee :datafee11},{y:data12, tax :datatex12 ,fee :datafee12}]
        }]
    });
    
};






    </script> 
             </div>
      </div>
         </div>
  </div>
     </div>
</div>
<div class="container">
       <div class="row">
    <div class="col-md-12">
           <div class="afs_ads" style="color: #ccc; font-size: 10px; text-align: right; padding: 5px 0">ip-10-150-59-89</div>
         </div>
  </div>
     </div>
</body>
</html>
