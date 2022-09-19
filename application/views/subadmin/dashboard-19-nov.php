<?php ?>  

<?php

include_once'header_new.php';

include_once'nav_new.php';

include_once'sidebar_new.php';



?>

<!-- Start Page Content -->





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

  </script>

  <style type="text/css">

    #saleChart g.highcharts-series.highcharts-series-0,#saleChart  g.highcharts-series.highcharts-series-2,#saleChart  g.highcharts-markers.highcharts-series-0,#saleChart  g.highcharts-markers.highcharts-series-2,#saleChart  .highcharts-series-group >path:nth-child(1),#saleChart  .highcharts-series-group >path:nth-child(3) 

  {

      opacity: 0;

  }

  </style>



  <!-- Start Page Content --> 

  <div id="wrapper"> 

    <div class="page-wrapper">   

           

      <div class="row dash-card">

        <div class="col-3">

          <div class="card-box">

            <div class="request">

              <span class="request-count newtotalorders">

             

                 

                <?php echo $widgets_data['NewTotalOrders'];?>

              </span>

              <span class="request-name"> New Completed Instore & Mobile Transactions</span>

            </div>

            <div class="request-icon">

              <img src="<?php echo base_url('new_assets/img/confirm-payment.png'); ?>" alt="request-icon">

            </div>

          </div>

        </div> 

        <div class="col-3">

          <div class="card-box">

            <div class="request">

              <div class="request-count totalpendingorders"><?php echo $widgets_data['TotalpendingOrders'];?></div>

              <div class="request-name">Pending Invoice Transactions</div>

            </div>

            <div class="request-icon">

              <img src="<?php echo base_url('new_assets/img/pending-payment.png'); ?>" alt="request-icon">

            </div>

          </div>

        </div> 

        <div class="col-3">

          <div class="card-box">

            <div class="request">

              <div class="request-count totalorders"><?php echo $widgets_data['TotalOrders']; ?></div>

              <div class="request-name">Completed Invoice Transaction</div>

            </div>

            <div class="request-icon">

              <img src="<?php echo base_url('new_assets/img/new-payment.png'); ?>" alt="request-icon">

            </div>

          </div>

        </div> 

        <div class="col-3">

          <div class="card-box">

            <div class="request">

              <div class="request-count totallate"><?php echo $widgets_data['TotalLate']; ?></div>

              <div class="request-name">Late invoice Transactions</div>

            </div>

            <div class="request-icon">

              <img src="<?php echo base_url('new_assets/img/failed-payment.png'); ?>" alt="request-icon">

            </div>

          </div>

        </div> 

      </div>   

      <div class="row employee_date_range">

        <div class="col-12 custom-form">

          <div class="form-group ">

            <div id="daterange" class="form-control">

                <span></span>

            </div>

          </div>

          <div class="form-group ">

            <?php

              $merchant_id = $this->session->userdata('merchant_id');

              $data = $this->admin_model->data_get_where_1('merchant', array('merchant_id' => $merchant_id)); ?>

            <select name="employee" class="form-control" id="employee" onchange="getGraph();getSaleOrderChartsDate();">

              <option  value="all" >Select Employee</option>

              <option  value="merchant" > Merchant</option>

              <?php foreach ($data as $view) { ?>

                <option  value="<?php echo $view['id']; ?>"><?php echo $view['name']; ?></option>

              <?php } ?>

            </select>

          </div>

        </div>

      </div>

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

      <div class="row">

        <div class="col-7 saleChart-col">

          <div class="card content-card">

            <div class="card-title">

              Sales Chart

              <!-- <button class="btn btn-custom1" id="downloadCsvBtn" ><span>Download CSV</span> <span class="material-icons">arrow_downward</span></button> -->

              <div id="salesChartExportDt" class="reset-dataTable">

              </div>

            </div>

            <div class="card-detail">

              <!-- <div id="saleChart" height="151"> </div> -->

              <div id="saleChart" height="151"> 

                <div class="placeholder"></div>

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

              <div class="row text-center" id="circularOrderCharts">

                <div class="col" >

                    <!-- <div  id="aa" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div> -->

                    <div class="order-chart-text">

                      <span>Invoices</span>

                      <span class="oc-no">23,123</span>

                    </div>

                </div>

                <div class="col" >

                    <!-- <div id="bb" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" 

                    data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div> -->

                    <div class="order-chart-text">

                      <span>Recurring</span>

                      <span class="oc-no">4,203</span>

                    </div>

                </div>

                <div class="col" >

                    <!-- <div id="cc" data-dimension="121" data-fontsize="21" data-fgcolor="#2273dc" data-bgcolor="#e8e8e8" 

                    data-width="8" data-bordersize="8" data-animationstep="5" data-strokeLinecap="round"></div> -->

                    <div class="order-chart-text">

                      <span>Instore & Mobile</span>

                      <span class="oc-no">32</span>

                    </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="row">

        <div class="col-12">

          <div class="card content-card">

            <div class="card-title">

              Sales By Year

            </div>

            <div class="card-detail">

                <div id="chart1" height="350"> </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- End Page Content -->

  <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >

    <div class="modal-dialog"> 

      <div class="modal-content"> 

        <div class="modal-header"> 

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×

          </button> 

          <h4 class="modal-title">

            <i class="glyphicon glyphicon-user">

            </i> Payment Detail

          </h4> 

        </div> 

        <div class="modal-body"> 

          <div id="modal-loader" style="display: none; text-align: center;">

            <img src="<?php echo base_url('new_assets/img/ajax-loader.gif'); ?>">

          </div>

          <div id="dynamic-content">

          </div>

        </div> 

        <div class="modal-footer"> 

          <button type="button" class="btn btn-default" data-dismiss="modal">Close

          </button>  

        </div> 

      </div> 

    </div>

  </div>

    <script>



    function getGraph() {

          

        var start=$("#daterange span").data().d1;

        var end=$("#daterange span").data().d2;

        var employee =  $('#employee').val(); 



        $('#saleChart .placeholder').html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px">Loading...</div>');

        // $('#graph h1, #graph h2').html('&nbsp;');

        // $('#graph .metric1 h1').html('<i class="fa fa-spinner fa-spin"></i>');

        var jsonurl = '<?php echo base_url('merchant-panel'); ?>/graph/graph.php?filters[all]=1&start=<?php echo $last_date; ?>&end=<?php echo $date; ?>&employee=<?php echo 'all'; ?>';

             

        jsonurl += '&filters[goal]=' + encodeURIComponent(userprefs.goal);

        jsonurl += '&metric1=' + userprefs.metric1 + '&metric2=' + userprefs.metric2 + '&units=' + userprefs.units +'&employee=' + employee + '&merchant=' + userprefs.merchant + '&fee=' + userprefs.fee ;



        if (typeof location.search == 'string' && location.search.length > 0)

            jsonurl += '&' + location.search.substring(1);

        if (typeof start != 'undefined' && typeof end != 'undefined'  && start != null & end != null )

            jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) ;

          // console.log('calling...');

          $.getJSON(jsonurl, function(data) {

            if (data.length != 0) {

              // saleChartFn('CHART-ID', CHART-data);

              // console.log(data)

              saleChartFn('saleChart', data,201);

              // salesChart(data)

            }

        });

    }

    //updating circles

      function getSaleOrderChartsDate(){
        var start=$("#daterange span").data().d1;
        var end=$("#daterange span").data().d2;
        var employee =  $('#employee').val(); 
        console.log(start + end + employee)
        $.ajax({
          type: 'POST',
           //url: "<?php  echo base_url('merchant/index1'); ?>",
          url: "<?php  echo base_url('graph/sale'); ?>", 
          data: {start: start , end : end , employee : employee },
          type:'post',
          success: function (dataJson){
              data = JSON.parse(dataJson)
              console.log(data);
              console.log(data.item3);
              $('#saleChart').data('vals',data.item3);
              saleSummeryPdfTableConvertor($('#salesChartExportDt'),data.item3,data.item5)
              // var a=data.getDashboardData[0].TotalAmount;
              // var b=data.getDashboardData[0].TotalAmountRe;
              // var c=data.getDashboardData[0].TotalAmountPOS;
              
              // $('.newtotalorders').html(data.widgets_data.NewTotalOrders); 
              // $('.totalorders').html(data.widgets_data.TotalOrders); 
              // $('.totalpendingorders').html(data.widgets_data.TotalpendingOrders); 
              // $('.totallate').html(data.widgets_data.TotalLate);  

              // updateSaleOrderChart(a ,b ,c )
          }
        });

        $.ajax({
          type: 'POST',
         
          url: "<?php  echo base_url('graph/widgets'); ?>", 
          data: {start: start , end : end , employee : employee },
          type:'post',
          success: function (dataJson){
              data = JSON.parse(dataJson);
              console.log(data);
              var a=data.getDashboardData[0].TotalAmount;
              var b=data.getDashboardData[0].TotalAmountRe;
              var c=data.getDashboardData[0].TotalAmountPOS;
              
              $('.newtotalorders').html(data.widgets_data.NewTotalOrders); 
              $('.totalorders').html(data.widgets_data.TotalOrders); 
              $('.totalpendingorders').html(data.widgets_data.TotalpendingOrders); 
              $('.totallate').html(data.widgets_data.TotalLate); 
              updateSaleOrderChart(a ,b ,c )
          }
        });



      }

      jQuery(function($){

        setTimeout(function(){

          getSaleOrderChartsDate();

          getGraph();

        },55)

    // below only below graph

      function setNullOrZeroByYear(month,vals){

        var mnthArray=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        var currMnth=moment().format('MMM');

        var currIndex=mnthArray.indexOf(currMnth);

        var checkIndex=mnthArray.indexOf(month);

        if(currIndex < checkIndex){

          vals =isNaN(vals)? null : (vals ==null? null: parseFloat(vals));

        }

        else{

          vals =isNaN(vals)? 0 : (vals ==null? 0: parseFloat(vals));

        }



        return vals;

      }

      var data1 = setNullOrZeroByYear('Jan',<?php echo $getDashboardData[0]['Totaljan'] ?>);

      var data2 = setNullOrZeroByYear('Fen',<?php echo $getDashboardData[0]['Totalfeb'] ?>);

      var data3 = setNullOrZeroByYear('Mar',<?php echo $getDashboardData[0]['Totalmarch'] ?>);

      var data4 = setNullOrZeroByYear('Apr',<?php echo $getDashboardData[0]['Totalaprl'] ?>);

      var data5 = setNullOrZeroByYear('May',<?php echo $getDashboardData[0]['Totalmay'] ?>);

      var data6 = setNullOrZeroByYear('Jun',<?php echo $getDashboardData[0]['Totaljune'] ?>);

      var data7 = setNullOrZeroByYear('Jul',<?php echo $getDashboardData[0]['Totaljuly'] ?>);

      var data8 = setNullOrZeroByYear('Aug',<?php echo $getDashboardData[0]['Totalaugust'] ?>);

      var data9 = setNullOrZeroByYear('Sep',<?php echo $getDashboardData[0]['Totalsep'] ?>);

      var data10 = setNullOrZeroByYear('Oct',<?php echo $getDashboardData[0]['Totaloct'] ?>);

      var data11 = setNullOrZeroByYear('Nov',<?php echo $getDashboardData[0]['Totalnov'] ?>);

      var data12 = setNullOrZeroByYear('Dec',<?php echo  $getDashboardData[0]['Totaldec'] ?>);



      var dataf1 = setNullOrZeroByYear('Jan',<?php echo $getDashboardData[0]['Totaljanf'] ?>);

      var dataf2 = setNullOrZeroByYear('Feb',<?php echo $getDashboardData[0]['Totalfebf'] ?>);

      var dataf3 = setNullOrZeroByYear('Mar',<?php echo $getDashboardData[0]['Totalmarchf'] ?>);

      var dataf4 = setNullOrZeroByYear('Apr',<?php echo $getDashboardData[0]['Totalaprlf'] ?>);

      var dataf5 = setNullOrZeroByYear('May',<?php echo $getDashboardData[0]['Totalmayf'] ?>);

      var dataf6 = setNullOrZeroByYear('Jun',<?php echo $getDashboardData[0]['Totaljunef'] ?>);

      var dataf7 = setNullOrZeroByYear('Jul',<?php echo $getDashboardData[0]['Totaljulyf'] ?>);

      var dataf8 = setNullOrZeroByYear('Aug',<?php echo $getDashboardData[0]['Totalaugustf'] ?>);

      var dataf9 = setNullOrZeroByYear('Sep',<?php echo $getDashboardData[0]['Totalsepf'] ?>);

      var dataf10 = setNullOrZeroByYear('Oct',<?php echo $getDashboardData[0]['Totaloctf'] ?>);

      var dataf11 = setNullOrZeroByYear('Nov',<?php echo $getDashboardData[0]['Totalnovf'] ?>);

      var dataf12 = setNullOrZeroByYear('Dec',<?php echo  $getDashboardData[0]['Totaldecf'] ?>);

      var datatex1 = setNullOrZeroByYear('Jan',<?php echo $getDashboardData[0]['Totaljantax'] ?>);

      var datatex2 = setNullOrZeroByYear('Feb',<?php echo $getDashboardData[0]['Totalfebtax'] ?>);

      var datatex3 = setNullOrZeroByYear('Mar',<?php echo $getDashboardData[0]['Totalmarchtax'] ?>);

      var datatex4 = setNullOrZeroByYear('Apr',<?php echo $getDashboardData[0]['Totalaprltax'] ?>);

      var datatex5 = setNullOrZeroByYear('May',<?php echo $getDashboardData[0]['Totalmaytax'] ?>);

      var datatex6 = setNullOrZeroByYear('Jun',<?php echo $getDashboardData[0]['Totaljunetax'] ?>);

      var datatex7 = setNullOrZeroByYear('Jul',<?php echo $getDashboardData[0]['Totaljulytax'] ?>);

      var datatex8 = setNullOrZeroByYear('Aug',<?php echo $getDashboardData[0]['Totalaugusttax'] ?>);

      var datatex9 = setNullOrZeroByYear('Sep',<?php echo $getDashboardData[0]['Totalseptax'] ?>);

      var datatex10 = setNullOrZeroByYear('Oct',<?php echo $getDashboardData[0]['Totalocttax'] ?>);

      var datatex11 = setNullOrZeroByYear('Nov',<?php echo $getDashboardData[0]['Totalnovtax'] ?>);

      var datatex12 = setNullOrZeroByYear('Dec',<?php echo $getDashboardData[0]['Totaldectax'] ?>);





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

      var dataSaleByYearVals1=[{y:data1, tax :datatex1 , avg :dataf1}, {y:data2, tax :datatex2 , avg :dataf2},{y:data3, tax :datatex3 , avg :dataf3},{y:data4, tax :datatex4 , avg :dataf4},{y:data5, tax :datatex5 , avg :dataf5},{y:data6, tax :datatex6 , avg :dataf6},{y:data7, tax :datatex7 , avg :dataf7},{y:data8, tax :datatex8 , avg :dataf8},{y:data9, tax :datatex9 , avg :dataf9},{y:data10, tax :datatex10 , avg :dataf10},{y:data11, tax :datatex11 , avg :dataf11},{y:data12, tax :datatex12 , avg :dataf12}];

      var dataSaleByYearVals2=[{y:datab1, tax :datatex1b, avg :dataf1b}, {y:datab2, tax :datatex2b, avg :dataf2b},{y:datab3, tax :datatex3b, avg :dataf3b},{y:datab4, tax :datatex4b, avg :dataf4b},{y:datab5, tax :datatex5b, avg :dataf5b},{y:datab6, tax :datatex6b, avg :dataf6b},{y:datab7, tax :datatex7b, avg :dataf7b},{y:datab8, tax :datatex8b, avg :dataf8b},{y:datab9, tax :datatex9b, avg :dataf9b},{y:datab10, tax :datatex10b, avg :dataf10b},{y:datab11, tax :datatex11b, avg :dataf11b},{y:datab12, tax :datatex12b, avg :dataf12b}];

      // console.log(dataSaleByYearVals1)

      // console.log(dataSaleByYearVals2)

      saleByYear(dataSaleByYearVals1,dataSaleByYearVals2);

    })

  </script>



<!-- End Page Content -->

<?php

include_once'footer_new.php';

?>