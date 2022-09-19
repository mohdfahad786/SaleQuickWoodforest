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
            <div class="col-3 text-right">
                <!-- <textarea id="txt"  class="txtarea" style="display: none;"  > -->
                <?php 
               // echo ($item3);
                ?>
                <!-- </textarea> -->
              <!-- <button class="btn btn-custom1" id="salesSumeryCsvBtn" ><span>Download CSV</span> <span class="material-icons">arrow_downward</span></button> -->
              <div id="salesSummeryChartExportDt"  class="reset-dataTable" data-defjson='<?php echo $item3; ?>'> </div>
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
  function setNullToZero(vals){
    var valss =isNaN(vals)? 0 : (vals == null? 0: parseFloat(vals));
    return valss;
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
  console.log(end)
  $.ajax({
  type: 'POST',
  url: "<?php  echo base_url('graph/sale'); ?>",
  data: {start: start , end : end },
  type:'post',
  success: function(dataJson){
  var data = JSON.parse(dataJson);
  dataTimeDayVals=[];
  for(index=0;index < 24 ; index++){
  var valY=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timea']));
  var valTax=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timetax']));
  var valAvg=setNullToZero((data.getDashboardData[0]['Total_today_'+index+'timefee']));
  var newObjt={y:valY,tax:valTax,avg:valAvg};
  dataTimeDayVals.push(newObjt);}
  salesTimeDayChart(dataTimeDayVals);
  $('#sales_summery').data('vals',data.item3);
  saleSummeryPdfTableConvertor($('#salesSummeryChartExportDt'),data.item3);
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
  setTimeout(function(){updateTimeOfDay();},50)
  getTable();
  saleSummeryPdfTableConvertor($('#salesSummeryChartExportDt'),$('#salesSummeryChartExportDt').data('defjson'));
})
</script>
<?php
include_once'footer_new.php';
?>