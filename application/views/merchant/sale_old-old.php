<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
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
  #sales_summery g.highcharts-series.highcharts-series-0,#sales_summery  g.highcharts-series.highcharts-series-2,#sales_summery  g.highcharts-markers.highcharts-series-0,#sales_summery  g.highcharts-markers.highcharts-series-2,#sales_summery  .highcharts-series-group >path:nth-child(1),#sales_summery  .highcharts-series-group >path:nth-child(3) 
{
    opacity: 0;
}
</style>
<!-- Start Page Content -->
<div id="wrapper"> 
  <div class="page-wrapper sales-summery">      
    <div class="row sales_date_range">
      <div class="col-12 custom-form">
        <div class="card content-card">
          <div class="row">
            <div class="col">
              <div id="daterange" class="form-control">
                  <span>April-18-2019 - May-17-2019</span>
              </div>
            </div>
            <div class="col">
              <?php
                $merchant_id = $this->session->userdata('merchant_id');
                $data = $this->admin_model->data_get_where_1('merchant', array('merchant_id' => $merchant_id)); ?>
                <select name="employee" class="form-control bder-radius" id="employee" 
                onchange="getGraph();updateTimeOfDay();getTable();" >
                <!-- onchange="getGraph();getTable();getGraph1();" > -->
                  <option  value="all" >Select Employee</option>
                  <option  value="merchant" > Merchant</option>
              <?php foreach ($data as $view) { ?>
                  <option  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>
              <?php } ?>
                </select>
              <!-- <select name="employee" class="form-control" id="employee" onchange="getGraph();getSaleOrderChartsDate();">
                <option value="all">Select Employee</option>
                <option value="merchant">Merchant</option>
                <option value="165">fahad</option>
                <option value="164">fahad</option>
              </select> -->
            </div>
            <div class="col-3 text-right">
                     <textarea id="txt"  class="txtarea" style="display: none;"  >



        <?php 
echo ($item3);



                      ?>


</textarea>
              <button class="btn btn-custom1" id="salesSumeryCsvBtn" ><span>Download CSV</span> <span class="material-icons">arrow_downward</span></button>
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
              <div id="sales_summery" height="350"> 
                <div class="placeholder"></div>
              </div>
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
              <div id="sales_time_of_day" height="350"> </div>
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
                <tfoot class="bg-tfoot">
                  <td>Total</td>
                  <td>$4.00</td>
                  <td>$2.00</td>
                  <td>$2.00</td>
                </tfoot>
              </table>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Page Content -->
<script>
  var dataTimeDayVals=[{
    y:<?php echo  $getDashboardData[0]['Totaljan'] ?  $getDashboardData[0]['Totaljan'] :'0'.""  ?>,
    tax : <?php echo  $getDashboardData[0]['Totaljantax'] ?  $getDashboardData[0]['Totaljantax'] :'0'.""  ?> ,
    avg:<?php echo  $getDashboardData[0]['Totaljanfee'] ?  $getDashboardData[0]['Totaljanfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totalfeb'] ?  $getDashboardData[0]['Totalfeb'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalfebtax'] ?  $getDashboardData[0]['Totalfebtax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totalfebfee'] ?  $getDashboardData[0]['Totalfebfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totalmarch'] ?  $getDashboardData[0]['Totalmarch'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalmarchtax'] ?  $getDashboardData[0]['Totalmarchtax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totalmarchfee'] ?  $getDashboardData[0]['Totalmarchfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totalaprl'] ?  $getDashboardData[0]['Totalaprl'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalaprltax'] ?  $getDashboardData[0]['Totalaprltax'] :'0'.""  ?>,
    avg :<?php echo  $getDashboardData[0]['Totalmayfee'] ?  $getDashboardData[0]['Totalmayfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totalmay'] ?  $getDashboardData[0]['Totalmay'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalmaytax'] ?  $getDashboardData[0]['Totalmaytax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totalaprlfee'] ?  $getDashboardData[0]['Totalaprlfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totaljune'] ?  $getDashboardData[0]['Totaljune'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totaljunetax'] ?  $getDashboardData[0]['Totaljunetax'] :'0'.""  ?>,
    avg :<?php echo  $getDashboardData[0]['Totaljunefee'] ?  $getDashboardData[0]['Totaljunefee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totaljuly'] ?  $getDashboardData[0]['Totaljuly'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totaljulytax'] ?  $getDashboardData[0]['Totaljulytax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totaljulyfee'] ?  $getDashboardData[0]['Totaljulyfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totalaugust'] ?  $getDashboardData[0]['Totalaugust'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalaugusttax'] ?  $getDashboardData[0]['Totalaugusttax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totalaugustfee'] ?  $getDashboardData[0]['Totalaugustfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totalsep'] ?  $getDashboardData[0]['Totalsep'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalseptax'] ?  $getDashboardData[0]['Totalseptax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totalsepfee'] ?  $getDashboardData[0]['Totalsepfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totaloct'] ?  $getDashboardData[0]['Totaloct'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalocttax'] ?  $getDashboardData[0]['Totalocttax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totaloctfee'] ?  $getDashboardData[0]['Totaloctfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totalnov'] ?  $getDashboardData[0]['Totalnov'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totalnovtax'] ?  $getDashboardData[0]['Totalnovtax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totalnovfee'] ?  $getDashboardData[0]['Totalnovfee'] :'0'.""  ?>
    },
    {y: <?php echo  $getDashboardData[0]['Totaldec'] ?  $getDashboardData[0]['Totaldec'] :'0'.""  ?>,
    tax :<?php echo  $getDashboardData[0]['Totaldectax'] ?  $getDashboardData[0]['Totaldectax'] :'0'.""  ?> ,
    avg :<?php echo  $getDashboardData[0]['Totaldecfee'] ?  $getDashboardData[0]['Totaldecfee'] :'0'.""  ?>
}]
</script>
<script>
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
        if (data) 
        {
          // console.log(data)
          saleChartFn('sales_summery', data,251);
        }
    });
}
function updateTimeOfDay(){
  var employee =  $('#employee').val(); 
  var start=$("#daterange span").data().d1;
  var end=$("#daterange span").data().d2;
  $.ajax({
      type: 'POST',
      url: "<?php  echo base_url('graph/sale'); ?>",
      data: {start: start , end : end },
      type:'post',
      success: function(dataJson)
      {
          data = JSON.parse(dataJson);
             console.log(data)
            $('#txt').val(data.item3);
          // var dataTimeDayVals={};
          $(data).each(function(index, element) {
            console.log(element.getDashboardData[0]['Totaljan'])
            dataTimeDayVals[0].y=parseFloat((element.getDashboardData[0]['Totaljan'])|| 0);
            dataTimeDayVals[1].y=parseFloat((element.getDashboardData[0]['Totalfeb'])|| 0);
            dataTimeDayVals[2].y=parseFloat((element.getDashboardData[0]['Totalmarch'])|| 0);
            dataTimeDayVals[3].y=parseFloat((element.getDashboardData[0]['Totalaprl'])|| 0);
            dataTimeDayVals[4].y=parseFloat((element.getDashboardData[0]['Totalmay'])|| 0);
            dataTimeDayVals[5].y=parseFloat((element.getDashboardData[0]['Totaljune'])|| 0);
            dataTimeDayVals[6].y=parseFloat((element.getDashboardData[0]['Totaljuly'])|| 0);
            dataTimeDayVals[7].y=parseFloat((element.getDashboardData[0]['Totalaugust'])|| 0);
            dataTimeDayVals[8].y=parseFloat((element.getDashboardData[0]['Totalsep'])|| 0);
            dataTimeDayVals[9].y=parseFloat((element.getDashboardData[0]['Totaloct'])|| 0);
            dataTimeDayVals[10].y=parseFloat((element.getDashboardData[0]['Totalnov'])|| 0);
            dataTimeDayVals[11].y=parseFloat((element.getDashboardData[0]['Totaldec'])|| 0);

            dataTimeDayVals[0].tax=parseFloat((element.getDashboardData[0]['Totaljantax'])||0);
            dataTimeDayVals[1].tax=parseFloat((element.getDashboardData[0]['Totalfebtax'])||0);
            dataTimeDayVals[2].tax=parseFloat((element.getDashboardData[0]['Totalmarchtax'])||0);
            dataTimeDayVals[3].tax=parseFloat((element.getDashboardData[0]['Totalaprltax'])||0);
            dataTimeDayVals[4].tax=parseFloat((element.getDashboardData[0]['Totalmaytax'])||0);
            dataTimeDayVals[5].tax=parseFloat((element.getDashboardData[0]['Totaljunetax'])||0);
            dataTimeDayVals[6].tax=parseFloat((element.getDashboardData[0]['Totaljulytax'])||0);
            dataTimeDayVals[7].tax=parseFloat((element.getDashboardData[0]['Totalaugusttax'])||0);
            dataTimeDayVals[8].tax=parseFloat((element.getDashboardData[0]['Totalseptax'])||0);
            dataTimeDayVals[9].tax=parseFloat((element.getDashboardData[0]['Totalocttax'])||0);
            dataTimeDayVals[10].tax=parseFloat((element.getDashboardData[0]['Totalnovtax'])||0);
            dataTimeDayVals[11].tax=parseFloat((element.getDashboardData[0]['Totaldectax'])||0);

            dataTimeDayVals[0].avg=parseFloat((element.getDashboardData[0]['Totaljanfee'])|| 0);
            dataTimeDayVals[1].avg=parseFloat((element.getDashboardData[0]['Totalfebfee'])|| 0);
            dataTimeDayVals[2].avg=parseFloat((element.getDashboardData[0]['Totalmarchfee'])|| 0);
            dataTimeDayVals[3].avg=parseFloat((element.getDashboardData[0]['Totalaprlfee'])|| 0);
            dataTimeDayVals[4].avg=parseFloat((element.getDashboardData[0]['Totalmayfee'])|| 0);
            dataTimeDayVals[5].avg=parseFloat((element.getDashboardData[0]['Totaljunefee'])|| 0);
            dataTimeDayVals[6].avg=parseFloat((element.getDashboardData[0]['Totaljulyfee'])|| 0);
            dataTimeDayVals[7].avg=parseFloat((element.getDashboardData[0]['Totalaugustfee'])|| 0);
            dataTimeDayVals[8].avg=parseFloat((element.getDashboardData[0]['Totalsepfee'])|| 0);
            dataTimeDayVals[9].avg=parseFloat((element.getDashboardData[0]['Totaloctfee'])|| 0);
            dataTimeDayVals[10].avg=parseFloat((element.getDashboardData[0]['Totalnovfee'])|| 0);
            dataTimeDayVals[11].avg=parseFloat((element.getDashboardData[0]['Totaldec'])|| 0);
            console.log(dataTimeDayVals)
            salesTimeDayChart(dataTimeDayVals);
        });
        $('#sales_summery').data('vals',data.item3);
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

  $.post(jsonurl, function(data) 
  {
    // console.log(data);
    var html = '', clicks = 0, people = 0,  converted_people = 0;
    if (data.length == 0) 
    {
      $('#report tbody').html(nodata.html());
    } 
    else 
    {
        for (var row in data) 
        {
          var label = data[row]['label'];
          // console.log(label)
        //data for tbody
            if (data[row]['label'] == null || data[row]['label'] == '') 
            {
              label = '[ No Source ]';                
            }
            if(label != 'Fee')
            {
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
              html += '<td>' + format_money(data[row]['people']) + '</td>';
              html += '<td>' + format_money(data[row]['clicks']) + '</td>';
              html += '<td>' + format_money(data[row]['converted_people']) + '</td>';


              html += '</tr>';

              clicks += parseFloat(data[row]['clicks']);
              people += parseFloat(data[row]['people']);
              converted_people += parseFloat(data[row]['converted_people']);
            }
          }
          $('#report tbody').html(html);
        //data for tfoot
          html = '<tr>';
          html += '<td>Total</td>';
          html += '<td> $' + add_commas(people.toFixed(2)) + '</td>';
          html += '<td> $' + add_commas(clicks.toFixed(2)) + '</td>';
          html += '<td> $' + add_commas(converted_people.toFixed(2)) + '</td>';
          html += '</tr>';
          $('#report tfoot').html(html);
      }

  }, 'json').fail(function() 
  {
    $('#report tbody').html(timeout.html());
  });
}
$(function(){
  getGraph();
  salesTimeDayChart(dataTimeDayVals);
  getTable();
})
</script>
<?php
include_once'footer_new.php';
?>