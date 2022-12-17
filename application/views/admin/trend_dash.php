<?php  
$last_date = date("Y-m-d",strtotime("-29 days"));
$date = date("Y-m-d");
$merchant_id = '1';
$t_fee = '1';
?>

<?php
include_once 'header_graph.php';
include_once 'sidebar_dash.php';
?>

<style type="text/css">
    .gross-sale-legend{
        float: right;
    }
    .gross-sale-legend span{
        width: 100%;
        text-align: right;
        display: block;
    }
    .highcharts-container {
        margin: 0 auto !important;
    }
    .custom-chart-label {
        padding: 10px;
    }
    @media screen and (max-width: 1400px) {
        .grid-body {
            padding: 20px 15px 20px !important;
        }
    }
    .year_chart_margin_right {
        margin-left: 20px;
    }
    @media screen and (max-width: 1120px) {
        .year_chart_margin_right {
            margin-left: 0px;
        }
    }
    .mt-auto {
        height: 400px;
    }
</style>
<!-- Start Page Content -->
<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center">
                    <img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>">
                </div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Sales Trends</h4> -->
                </div>
            </div>

                <?php
    $monday = strtotime("last monday");
    $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
    $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
    $sunday1 = strtotime(date("Y-m-d",$monday)." -7 days");
    $sunday2 = strtotime(date("Y-m-d",$sunday1)." +6 days");
    $this_week_sd1 = date("M ,d",$sunday2);
    $this_week_ed1 = date("M ,d",$sunday1);
    $this_week_sd = date("M ,d",$monday);
    $this_week_ed = date("M ,d",$sunday);
    ?>

            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">

                                    <div class="split-header">
                                        <div class="split-sub-header">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <p class="h4-custom">Daily Gross Sales</p>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto dailyGrossSale_chart_wrapper">
                                <div id="dailyGrossSale" height="350"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <div class="split-sub-header">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <p class="h4-custom">Weekly Gross Sales</p>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                    <!-- <div class="row pull-right" style="margin-right: 10px;">
                                                        <div class="custom-chart-label">
                                                            <span>
                                                                <div class="rectangle"></div>
                                                                Current Week
                                                            </span>
                                                        </div>
                                                        <div class="custom-chart-label" style="margin-left: 20px;">
                                                            <span>
                                                                <div class="rectangle-darked"></div>
                                                                Last Week
                                                            </span>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div id="weeklyGrossSale"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <div class="split-sub-header">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <p class="h4-custom">Yearly Gross Sales</p>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                    <!-- <div class="row pull-right" style="margin-right: 10px;">
                                                        <div class="custom-chart-label yearlylab">
                                                            <span>
                                                                <div class="rectangle"></div>
                                                                Yearly Gross Sales <?php echo date("Y"); ?>
                                                            </span>
                                                        </div>
                                                        <div class="custom-chart-label yearlylab year_chart_margin_right">
                                                            <span>
                                                                <div class="rectangle-darked"></div>
                                                                Yearly Gross Sales <?php echo date("Y",strtotime("-1 year")); ?>
                                                            </span>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div id="yearlyGrossSale"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="Totaljan" id="Totaljan" value="<?php echo $getDashboardData[0]['ThisJanAmt'] ? $getDashboardData[0]['ThisJanAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totalfeb" id="Totalfeb" value="<?php echo $getDashboardData[0]['ThisFebAmt'] ? $getDashboardData[0]['ThisFebAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totalmarch" id="Totalmarch" value="<?php echo $getDashboardData[0]['ThisMarAmt'] ? $getDashboardData[0]['ThisMarAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totalaprl" id="Totalaprl" value="<?php echo $getDashboardData[0]['ThisAprAmt'] ? $getDashboardData[0]['ThisAprAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totalmay" id="Totalmay" value="<?php echo $getDashboardData[0]['ThisMayAmt'] ? $getDashboardData[0]['ThisMayAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totaljune" id="Totaljune" value="<?php echo $getDashboardData[0]['ThisJunAmt'] ? $getDashboardData[0]['ThisJunAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totaljuly" id="Totaljuly" value="<?php echo $getDashboardData[0]['ThisJulAmt'] ? $getDashboardData[0]['ThisJulAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totalaugust" id="Totalaugust" value="<?php echo $getDashboardData[0]['ThisAugAmt'] ? $getDashboardData[0]['ThisAugAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totalsep" id="Totalsep" value="<?php echo $getDashboardData[0]['ThisSepAmt'] ? $getDashboardData[0]['ThisSepAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totaloct" id="Totaloct" value="<?php echo $getDashboardData[0]['ThisOctAmt'] ? $getDashboardData[0]['ThisOctAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totalnov" id="Totalnov" value="<?php echo $getDashboardData[0]['ThisNovAmt'] ? $getDashboardData[0]['ThisNovAmt'] : '0'.""; ?>"/>
        <input type="hidden" name="Totaldec" id="Totaldec" value="<?php echo $getDashboardData[0]['ThisDecAmt'] ? $getDashboardData[0]['ThisDecAmt'] : '0'.""; ?>"/>
        
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
    getGraph1() ;
  });
//   function onSelectChange3(start, end){
//     var start =  start;
//     var end =  end;
//     $.ajax({
//       type: 'POST',
//       url: "<?php  echo base_url('graph/trends'); ?>",
//       data: {start: start , end : end },
//       type:'post',
//       success: function (dataJson)
//       {
//         data = JSON.parse(dataJson)
//         $(data).each(function (index, element) {
//           $('#Totaljan').val(element.getDashboardData[0]['ThisJanAmt']);  
//           $('#Totalfeb').val(element.getDashboardData[0]['ThisFebAmt']);  
//           $('#Totalmarch').val(element.getDashboardData[0]['ThisMarAmt']);  
//           $('#Totalaprl').val(element.getDashboardData[0]['ThisAprAmt']);  
//           $('#Totalmay').val(element.getDashboardData[0]['ThisMayAmt']);  
//           $('#Totaljune').val(element.getDashboardData[0]['ThisJunAmt']);  
//           $('#Totaljuly').val(element.getDashboardData[0]['ThisJulAmt']);  
//           $('#Totalaugust').val(element.getDashboardData[0]['ThisAugAmt']);  
//           $('#Totalsep').val(element.getDashboardData[0]['ThisSepAmt']);  
//           $('#Totaloct').val(element.getDashboardData[0]['ThisOctAmt']);  
//           $('#Totalnov').val(element.getDashboardData[0]['ThisNovAmt']);
//           $('#Totaldec').val(element.getDashboardData[0]['ThisDecAmt']);
//           // $('#Totalnovtax').val(element.getDashboardData[0]['Totalnovtax']);
//           // $('#Totaldectax').val(element.getDashboardData[0]['Totaldectax']);
//           // $('#Totalnovfee').val(element.getDashboardData[0]['Totalnovfee']);
//           // $('#Totaldecfee').val(element.getDashboardData[0]['Totaldec']);
// // $('#txt').val(element.item[0][]);
// getGraph1() ;
// });
//       }
//     });
//   }
</script> 

<script>
function getGraph1(start, end) {
    // start time
    // current day -> start
    var CurrAmtDailyOne = <?php echo $getDashboardData[0]['CurrAmtDailyOne'] ?  $getDashboardData[0]['CurrAmtDailyOne'] :'0'."" ?>;
    var CurrAmtDailyTwo = <?php echo $getDashboardData[0]['CurrAmtDailyTwo'] ?  $getDashboardData[0]['CurrAmtDailyTwo'] :'0'."" ?>;
    var CurrAmtDailyThree = <?php echo $getDashboardData[0]['CurrAmtDailyThree'] ?  $getDashboardData[0]['CurrAmtDailyThree'] :'0'."" ?>;
    var CurrAmtDailyFour = <?php echo $getDashboardData[0]['CurrAmtDailyFour'] ?  $getDashboardData[0]['CurrAmtDailyFour'] :'0'."" ?>;
    var CurrAmtDailyFive = <?php echo $getDashboardData[0]['CurrAmtDailyFive'] ?  $getDashboardData[0]['CurrAmtDailyFive'] :'0'."" ?>;
    var CurrAmtDailySix = <?php echo $getDashboardData[0]['CurrAmtDailySix'] ?  $getDashboardData[0]['CurrAmtDailySix'] :'0'."" ?>;
    var CurrAmtDailySeven = <?php echo $getDashboardData[0]['CurrAmtDailySeven'] ?  $getDashboardData[0]['CurrAmtDailySeven'] :'0'."" ?>;
    var CurrAmtDailyEight = <?php echo $getDashboardData[0]['CurrAmtDailyEight'] ?  $getDashboardData[0]['CurrAmtDailyEight'] :'0'."" ?>;
    var CurrAmtDailyNine = <?php echo $getDashboardData[0]['CurrAmtDailyNine'] ?  $getDashboardData[0]['CurrAmtDailyNine'] :'0'."" ?>;
    var CurrAmtDailyTen = <?php echo $getDashboardData[0]['CurrAmtDailyTen'] ?  $getDashboardData[0]['CurrAmtDailyTen'] :'0'."" ?>;
    var CurrAmtDailyEleven = <?php echo $getDashboardData[0]['CurrAmtDailyEleven'] ?  $getDashboardData[0]['CurrAmtDailyEleven'] :'0'."" ?>  ;
    var CurrAmtDailyTwelve = <?php echo  $getDashboardData[0]['CurrAmtDailyTwelve'] ?  $getDashboardData[0]['CurrAmtDailyTwelve'] :'0'."" ?> ;

    var CurrAvgDailyOne = <?php echo $getDashboardData[0]['CurrAvgDailyOne'] ?  $getDashboardData[0]['CurrAvgDailyOne'] :'0'."" ?>;
    var CurrAvgDailyTwo = <?php echo $getDashboardData[0]['CurrAvgDailyTwo'] ?  $getDashboardData[0]['CurrAvgDailyTwo'] :'0'."" ?>;
    var CurrAvgDailyThree = <?php echo $getDashboardData[0]['CurrAvgDailyThree'] ?  $getDashboardData[0]['CurrAvgDailyThree'] :'0'."" ?>;
    var CurrAvgDailyFour = <?php echo $getDashboardData[0]['CurrAvgDailyFour'] ?  $getDashboardData[0]['CurrAvgDailyFour'] :'0'."" ?>;
    var CurrAvgDailyFive = <?php echo $getDashboardData[0]['CurrAvgDailyFive'] ?  $getDashboardData[0]['CurrAvgDailyFive'] :'0'."" ?>;
    var CurrAvgDailySix = <?php echo $getDashboardData[0]['CurrAvgDailySix'] ?  $getDashboardData[0]['CurrAvgDailySix'] :'0'."" ?>;
    var CurrAvgDailySeven = <?php echo $getDashboardData[0]['CurrAvgDailySeven'] ?  $getDashboardData[0]['CurrAvgDailySeven'] :'0'."" ?>;
    var CurrAvgDailyEight = <?php echo $getDashboardData[0]['CurrAvgDailyEight'] ?  $getDashboardData[0]['CurrAvgDailyEight'] :'0'."" ?>;
    var CurrAvgDailyNine = <?php echo $getDashboardData[0]['CurrAvgDailyNine'] ?  $getDashboardData[0]['CurrAvgDailyNine'] :'0'."" ?>;
    var CurrAvgDailyTen = <?php echo $getDashboardData[0]['CurrAvgDailyTen'] ?  $getDashboardData[0]['CurrAvgDailyTen'] :'0'."" ?>;
    var CurrAvgDailyEleven = <?php echo $getDashboardData[0]['CurrAvgDailyEleven'] ?  $getDashboardData[0]['CurrAvgDailyEleven'] :'0'."" ?>  ;
    var CurrAvgDailyTwelve = <?php echo  $getDashboardData[0]['CurrAvgDailyTwelve'] ?  $getDashboardData[0]['CurrAvgDailyTwelve'] :'0'."" ?> ;

    var CurrTaxDailyOne = <?php echo $getDashboardData[0]['CurrTaxDailyOne'] ?  $getDashboardData[0]['CurrTaxDailyOne'] :'0'."" ?>;
    var CurrTaxDailyTwo = <?php echo $getDashboardData[0]['CurrTaxDailyTwo'] ?  $getDashboardData[0]['CurrTaxDailyTwo'] :'0'.""; ?>;
    var CurrTaxDailyThree = <?php echo $getDashboardData[0]['CurrTaxDailyThree'] ?  $getDashboardData[0]['CurrTaxDailyThree'] :'0'."" ?>;
    var CurrTaxDailyFour = <?php echo $getDashboardData[0]['CurrTaxDailyFour'] ?  $getDashboardData[0]['CurrTaxDailyFour'] :'0'."" ?>;
    var CurrTaxDailyFive = <?php echo $getDashboardData[0]['CurrTaxDailyFive'] ?  $getDashboardData[0]['CurrTaxDailyFive'] :'0'."" ?>;
    var CurrTaxDailySix = <?php echo $getDashboardData[0]['CurrTaxDailySix'] ?  $getDashboardData[0]['CurrTaxDailySix'] :'0'."" ?>;
    var CurrTaxDailySeven = <?php echo $getDashboardData[0]['CurrTaxDailySeven'] ?  $getDashboardData[0]['CurrTaxDailySeven'] :'0'."" ?>;
    var CurrTaxDailyEight = <?php echo $getDashboardData[0]['CurrTaxDailyEight'] ?  $getDashboardData[0]['CurrTaxDailyEight'] :'0'."" ?>;
    var CurrTaxDailyNine = <?php echo $getDashboardData[0]['CurrTaxDailyNine'] ?  $getDashboardData[0]['CurrTaxDailyNine'] :'0'."" ?>;
    var CurrTaxDailyTen = <?php echo $getDashboardData[0]['CurrTaxDailyTen'] ?  $getDashboardData[0]['CurrTaxDailyTen'] :'0'."" ?>;
    var CurrTaxDailyEleven = <?php echo $getDashboardData[0]['CurrTaxDailyEleven'] ?  $getDashboardData[0]['CurrTaxDailyEleven'] :'0'."" ?>;
    var CurrTaxDailyTwelve = <?php echo $getDashboardData[0]['CurrTaxDailyTwelve'] ?  $getDashboardData[0]['CurrTaxDailyTwelve'] :'0'."" ?>;
    // current day -> end

    // last day -> start
    var LastAmtDailyOne = <?php echo $getDashboardData[0]['LastAmtDailyOne'] ?  $getDashboardData[0]['LastAmtDailyOne'] :'0'."" ?>;
    var LastAmtDailyTwo = <?php echo $getDashboardData[0]['LastAmtDailyTwo'] ?  $getDashboardData[0]['LastAmtDailyTwo'] :'0'."" ?>;
    var LastAmtDailyThree = <?php echo $getDashboardData[0]['LastAmtDailyThree'] ?  $getDashboardData[0]['LastAmtDailyThree'] :'0'."" ?>;
    var LastAmtDailyFour = <?php echo $getDashboardData[0]['LastAmtDailyFour'] ?  $getDashboardData[0]['LastAmtDailyFour'] :'0'."" ?>;
    var LastAmtDailyFive = <?php echo $getDashboardData[0]['LastAmtDailyFive'] ?  $getDashboardData[0]['LastAmtDailyFive'] :'0'."" ?>;
    var LastAmtDailySix = <?php echo $getDashboardData[0]['LastAmtDailySix'] ?  $getDashboardData[0]['LastAmtDailySix'] :'0'."" ?>;
    var LastAmtDailySeven = <?php echo $getDashboardData[0]['LastAmtDailySeven'] ?  $getDashboardData[0]['LastAmtDailySeven'] :'0'."" ?>;
    var LastAmtDailyEight = <?php echo $getDashboardData[0]['LastAmtDailyEight'] ?  $getDashboardData[0]['LastAmtDailyEight'] :'0'."" ?>;
    var LastAmtDailyNine = <?php echo $getDashboardData[0]['LastAmtDailyNine'] ?  $getDashboardData[0]['LastAmtDailyNine'] :'0'."" ?>;
    var LastAmtDailyTen = <?php echo $getDashboardData[0]['LastAmtDailyTen'] ?  $getDashboardData[0]['LastAmtDailyTen'] :'0'."" ?>;
    var LastAmtDailyEleven = <?php echo $getDashboardData[0]['LastAmtDailyEleven'] ?  $getDashboardData[0]['LastAmtDailyEleven'] :'0'."" ?>  ;
    var LastAmtDailyTwelve = <?php echo  $getDashboardData[0]['LastAmtDailyTwelve'] ?  $getDashboardData[0]['LastAmtDailyTwelve'] :'0'."" ?> ;

    var LastAvgDailyOne = <?php echo $getDashboardData[0]['LastAvgDailyOne'] ?  $getDashboardData[0]['LastAvgDailyOne'] :'0'."" ?>;
    var LastAvgDailyTwo = <?php echo $getDashboardData[0]['LastAvgDailyTwo'] ?  $getDashboardData[0]['LastAvgDailyTwo'] :'0'."" ?>;
    var LastAvgDailyThree = <?php echo $getDashboardData[0]['LastAvgDailyThree'] ?  $getDashboardData[0]['LastAvgDailyThree'] :'0'."" ?>;
    var LastAvgDailyFour = <?php echo $getDashboardData[0]['LastAvgDailyFour'] ?  $getDashboardData[0]['LastAvgDailyFour'] :'0'."" ?>;
    var LastAvgDailyFive = <?php echo $getDashboardData[0]['LastAvgDailyFive'] ?  $getDashboardData[0]['LastAvgDailyFive'] :'0'."" ?>;
    var LastAvgDailySix = <?php echo $getDashboardData[0]['LastAvgDailySix'] ?  $getDashboardData[0]['LastAvgDailySix'] :'0'."" ?>;
    var LastAvgDailySeven = <?php echo $getDashboardData[0]['LastAvgDailySeven'] ?  $getDashboardData[0]['LastAvgDailySeven'] :'0'."" ?>;
    var LastAvgDailyEight = <?php echo $getDashboardData[0]['LastAvgDailyEight'] ?  $getDashboardData[0]['LastAvgDailyEight'] :'0'."" ?>;
    var LastAvgDailyNine = <?php echo $getDashboardData[0]['LastAvgDailyNine'] ?  $getDashboardData[0]['LastAvgDailyNine'] :'0'."" ?>;
    var LastAvgDailyTen = <?php echo $getDashboardData[0]['LastAvgDailyTen'] ?  $getDashboardData[0]['LastAvgDailyTen'] :'0'."" ?>;
    var LastAvgDailyEleven = <?php echo $getDashboardData[0]['LastAvgDailyEleven'] ?  $getDashboardData[0]['LastAvgDailyEleven'] :'0'."" ?>  ;
    var LastAvgDailyTwelve = <?php echo  $getDashboardData[0]['LastAvgDailyTwelve'] ?  $getDashboardData[0]['LastAvgDailyTwelve'] :'0'."" ?> ;

    var LastTaxDailyOne = <?php echo $getDashboardData[0]['LastTaxDailyOne'] ?  $getDashboardData[0]['LastTaxDailyOne'] :'0'."" ?>;
    var LastTaxDailyTwo = <?php echo $getDashboardData[0]['LastTaxDailyTwo'] ?  $getDashboardData[0]['LastTaxDailyTwo'] :'0'.""; ?>;
    var LastTaxDailyThree = <?php echo $getDashboardData[0]['LastTaxDailyThree'] ? $getDashboardData[0]['LastTaxDailyThree'] :'0'."" ?>;
    var LastTaxDailyFour = <?php echo $getDashboardData[0]['LastTaxDailyFour'] ?  $getDashboardData[0]['LastTaxDailyFour'] :'0'."" ?>;
    var LastTaxDailyFive = <?php echo $getDashboardData[0]['LastTaxDailyFive'] ?  $getDashboardData[0]['LastTaxDailyFive'] :'0'."" ?>;
    var LastTaxDailySix = <?php echo $getDashboardData[0]['LastTaxDailySix'] ?  $getDashboardData[0]['LastTaxDailySix'] :'0'."" ?>;
    var LastTaxDailySeven = <?php echo $getDashboardData[0]['LastTaxDailySeven'] ?  $getDashboardData[0]['LastTaxDailySeven'] :'0'."" ?>;
    var LastTaxDailyEight = <?php echo $getDashboardData[0]['LastTaxDailyEight'] ?  $getDashboardData[0]['LastTaxDailyEight'] :'0'."" ?>;
    var LastTaxDailyNine = <?php echo $getDashboardData[0]['LastTaxDailyNine'] ?  $getDashboardData[0]['LastTaxDailyNine'] :'0'."" ?>;
    var LastTaxDailyTen = <?php echo $getDashboardData[0]['LastTaxDailyTen'] ?  $getDashboardData[0]['LastTaxDailyTen'] :'0'."" ?>;
    var LastTaxDailyEleven = <?php echo $getDashboardData[0]['LastTaxDailyEleven'] ?  $getDashboardData[0]['LastTaxDailyEleven'] :'0'."" ?>;
    var LastTaxDailyTwelve = <?php echo $getDashboardData[0]['LastTaxDailyTwelve'] ?  $getDashboardData[0]['LastTaxDailyTwelve'] :'0'."" ?>;
    // last day -> end
    // End time


    //start week
    var ThisMondayAmt = <?php echo $getDashboardData[0]['ThisMondayAmt'] ?  $getDashboardData[0]['ThisMondayAmt'] :'0'."" ?>;
    var ThisTuesdayAmt = <?php echo $getDashboardData[0]['ThisTuesdayAmt'] ?  $getDashboardData[0]['ThisTuesdayAmt'] :'0'."" ?>;
    var ThisWednesdayAmt = <?php echo $getDashboardData[0]['ThisWednesdayAmt'] ?  $getDashboardData[0]['ThisWednesdayAmt'] :'0'."" ; ?>;
    var ThisThursdayAmt = <?php echo $getDashboardData[0]['ThisThursdayAmt'] ?  $getDashboardData[0]['ThisThursdayAmt'] :'0'."" ; ?>;
    var ThisFridayAmt = <?php echo $getDashboardData[0]['ThisFridayAmt']  ?  $getDashboardData[0]['ThisFridayAmt'] :'0'."" ; ?>;
    var ThisSaturdayAmt = <?php echo $getDashboardData[0]['ThisSaturdayAmt'] ?  $getDashboardData[0]['ThisSaturdayAmt'] :'0'."" ; ?>;
    var ThisSundayAmt = <?php echo $getDashboardData[0]['ThisSundayAmt']  ?  $getDashboardData[0]['ThisSundayAmt'] :'0'."" ; ?>;

    var ThisMondayAvg = <?php echo $getDashboardData[0]['ThisMondayAvg'] ?  $getDashboardData[0]['ThisMondayAvg'] :'0'."" ?>;
    var ThisTuesdayAvg = <?php echo $getDashboardData[0]['ThisTuesdayAvg'] ?  $getDashboardData[0]['ThisTuesdayAvg'] :'0'."" ?>;
    var ThisWednesdayAvg = <?php echo $getDashboardData[0]['ThisWednesdayAvg'] ?  $getDashboardData[0]['ThisWednesdayAvg'] :'0'."" ; ?>;
    var ThisThursdayAvg = <?php echo $getDashboardData[0]['ThisThursdayAvg'] ?  $getDashboardData[0]['ThisThursdayAvg'] :'0'."" ; ?>;
    var ThisFridayAvg = <?php echo $getDashboardData[0]['ThisFridayAvg']  ?  $getDashboardData[0]['ThisFridayAvg'] :'0'."" ; ?>;
    var ThisSaturdayAvg = <?php echo $getDashboardData[0]['ThisSaturdayAvg'] ?  $getDashboardData[0]['ThisSaturdayAvg'] :'0'."" ; ?>;
    var ThisSundayAvg = <?php echo $getDashboardData[0]['ThisSundayAvg']  ?  $getDashboardData[0]['ThisSundayAvg'] :'0'."" ; ?>;

    var ThisMondayTax = <?php echo $getDashboardData[0]['ThisMondayTax'] ?  $getDashboardData[0]['ThisMondayTax'] :'0'."" ?>;
    var ThisTuesdayTax = <?php echo $getDashboardData[0]['ThisTuesdayTax'] ?  $getDashboardData[0]['ThisTuesdayTax'] :'0'."" ?>;
    var ThisWednesdayTax = <?php echo $getDashboardData[0]['ThisWednesdayTax'] ?  $getDashboardData[0]['ThisWednesdayTax'] :'0'."" ; ?>;
    var ThisThursdayTax = <?php echo $getDashboardData[0]['ThisThursdayTax'] ?  $getDashboardData[0]['ThisThursdayTax'] :'0'."" ; ?>;
    var ThisFridayTax = <?php echo $getDashboardData[0]['ThisFridayTax']  ?  $getDashboardData[0]['ThisFridayTax'] :'0'."" ; ?>;
    var ThisSaturdayTax = <?php echo $getDashboardData[0]['ThisSaturdayTax'] ?  $getDashboardData[0]['ThisSaturdayTax'] :'0'."" ; ?>;
    var ThisSundayTax = <?php echo $getDashboardData[0]['ThisSundayTax']  ?  $getDashboardData[0]['ThisSundayTax'] :'0'."" ; ?>;

    var LastMondayAmt = <?php echo $getDashboardData[0]['LastMondayAmt'] ?  $getDashboardData[0]['LastMondayAmt'] :'0'."" ?>;
    var LastTuesdayAmt = <?php echo $getDashboardData[0]['LastTuesdayAmt'] ?  $getDashboardData[0]['LastTuesdayAmt'] :'0'."" ?>;
    var LastWednesdayAmt = <?php echo $getDashboardData[0]['LastWednesdayAmt'] ?  $getDashboardData[0]['LastWednesdayAmt'] :'0'."" ; ?>;
    var LastThursdayAmt = <?php echo $getDashboardData[0]['LastThursdayAmt'] ?  $getDashboardData[0]['LastThursdayAmt'] :'0'."" ; ?>;
    var LastFridayAmt = <?php echo $getDashboardData[0]['LastFridayAmt']  ?  $getDashboardData[0]['LastFridayAmt'] :'0'."" ; ?>;
    var LastSaturdayAmt = <?php echo $getDashboardData[0]['LastSaturdayAmt'] ?  $getDashboardData[0]['LastSaturdayAmt'] :'0'."" ; ?>;
    var LastSundayAmt = <?php echo $getDashboardData[0]['LastSundayAmt']  ?  $getDashboardData[0]['LastSundayAmt'] :'0'."" ; ?>;
    
    var LastMondayAvg = <?php echo $getDashboardData[0]['LastMondayAvg'] ?  $getDashboardData[0]['LastMondayAvg'] :'0'."" ?>;
    var LastTuesdayAvg = <?php echo $getDashboardData[0]['LastTuesdayAvg'] ?  $getDashboardData[0]['LastTuesdayAvg'] :'0'."" ?>;
    var LastWednesdayAvg = <?php echo $getDashboardData[0]['LastWednesdayAvg'] ?  $getDashboardData[0]['LastWednesdayAvg'] :'0'."" ; ?>;
    var LastThursdayAvg = <?php echo $getDashboardData[0]['LastThursdayAvg'] ?  $getDashboardData[0]['LastThursdayAvg'] :'0'."" ; ?>;
    var LastFridayAvg = <?php echo $getDashboardData[0]['LastFridayAvg']  ?  $getDashboardData[0]['LastFridayAvg'] :'0'."" ; ?>;
    var LastSaturdayAvg = <?php echo $getDashboardData[0]['LastSaturdayAvg'] ?  $getDashboardData[0]['LastSaturdayAvg'] :'0'."" ; ?>;
    var LastSundayAvg = <?php echo $getDashboardData[0]['LastSundayAvg']  ?  $getDashboardData[0]['LastSundayAvg'] :'0'."" ; ?>;
    
    var LastMondayTax = <?php echo $getDashboardData[0]['LastMondayTax'] ?  $getDashboardData[0]['LastMondayTax'] :'0'."" ?>;
    var LastTuesdayTax = <?php echo $getDashboardData[0]['LastTuesdayTax'] ?  $getDashboardData[0]['LastTuesdayTax'] :'0'."" ?>;
    var LastWednesdayTax = <?php echo $getDashboardData[0]['LastWednesdayTax'] ?  $getDashboardData[0]['LastWednesdayTax'] :'0'."" ; ?>;
    var LastThursdayTax = <?php echo $getDashboardData[0]['LastThursdayTax'] ?  $getDashboardData[0]['LastThursdayTax'] :'0'."" ; ?>;
    var LastFridayTax = <?php echo $getDashboardData[0]['LastFridayTax']  ?  $getDashboardData[0]['LastFridayTax'] :'0'."" ; ?>;
    var LastSaturdayTax = <?php echo $getDashboardData[0]['LastSaturdayTax'] ?  $getDashboardData[0]['LastSaturdayTax'] :'0'."" ; ?>;
    var LastSundayTax = <?php echo $getDashboardData[0]['LastSundayTax']  ?  $getDashboardData[0]['LastSundayTax'] :'0'."" ; ?>;
    //end week


    // starrt Year
    // This year
    // var ThisJanAmt = <?php echo $getDashboardData[0]['ThisJanAmt'] ?  $getDashboardData[0]['ThisJanAmt'] :'0'."" ?>;
    // var ThisFebAmt = <?php echo $getDashboardData[0]['ThisFebAmt'] ?  $getDashboardData[0]['ThisFebAmt'] :'0'."" ?>;
    // var ThisMarAmt = <?php echo $getDashboardData[0]['ThisMarAmt'] ?  $getDashboardData[0]['ThisMarAmt'] :'0'."" ?>;
    // var ThisAprAmt = <?php echo $getDashboardData[0]['ThisAprAmt'] ?  $getDashboardData[0]['ThisAprAmt'] :'0'."" ?>;
    // var ThisMayAmt = <?php echo $getDashboardData[0]['ThisMayAmt'] ?  $getDashboardData[0]['ThisMayAmt'] :'0'."" ?>;
    // var ThisJunAmt = <?php echo $getDashboardData[0]['ThisJunAmt'] ?  $getDashboardData[0]['ThisJunAmt'] :'0'."" ?>;
    // var ThisJulAmt = <?php echo $getDashboardData[0]['ThisJulAmt'] ?  $getDashboardData[0]['ThisJulAmt'] :'0'."" ?>;
    // var ThisAugAmt = <?php echo $getDashboardData[0]['ThisAugAmt'] ?  $getDashboardData[0]['ThisAugAmt'] :'0'."" ?>;
    // var ThisSepAmt = <?php echo $getDashboardData[0]['ThisSepAmt'] ?  $getDashboardData[0]['ThisSepAmt'] :'0'."" ?>;
    // var ThisOctAmt = <?php echo $getDashboardData[0]['ThisOctAmt'] ?  $getDashboardData[0]['ThisOctAmt'] :'0'."" ?>;
    // var ThisNovAmt = <?php echo $getDashboardData[0]['ThisNovAmt'] ?  $getDashboardData[0]['ThisNovAmt'] :'0'."" ?>;
    // var ThisDecAmt = <?php echo $getDashboardData[0]['ThisDecAmt'] ?  $getDashboardData[0]['ThisDecAmt'] :'0'."" ?>;

    // var ThisJanAvg = <?php echo $getDashboardData[0]['ThisJanAvg'] ?  $getDashboardData[0]['ThisJanAvg'] :'0'."" ?>;
    // var ThisFebAvg = <?php echo $getDashboardData[0]['ThisFebAvg'] ?  $getDashboardData[0]['ThisFebAvg'] :'0'."" ?>;
    // var ThisMarAvg = <?php echo $getDashboardData[0]['ThisMarAvg'] ?  $getDashboardData[0]['ThisMarAvg'] :'0'."" ?>;
    // var ThisAprAvg = <?php echo $getDashboardData[0]['ThisAprAvg'] ?  $getDashboardData[0]['ThisAprAvg'] :'0'."" ?>;
    // var ThisMayAvg = <?php echo $getDashboardData[0]['ThisMayAvg'] ?  $getDashboardData[0]['ThisMayAvg'] :'0'."" ?>;
    // var ThisJunAvg = <?php echo $getDashboardData[0]['ThisJunAvg'] ?  $getDashboardData[0]['ThisJunAvg'] :'0'."" ?>;
    // var ThisJulAvg = <?php echo $getDashboardData[0]['ThisJulAvg'] ?  $getDashboardData[0]['ThisJulAvg'] :'0'."" ?>;
    // var ThisAugAvg = <?php echo $getDashboardData[0]['ThisAugAvg'] ?  $getDashboardData[0]['ThisAugAvg'] :'0'."" ?>;
    // var ThisSepAvg = <?php echo $getDashboardData[0]['ThisSepAvg'] ?  $getDashboardData[0]['ThisSepAvg'] :'0'."" ?>;
    // var ThisOctAvg = <?php echo $getDashboardData[0]['ThisOctAvg'] ?  $getDashboardData[0]['ThisOctAvg'] :'0'."" ?>;
    // var ThisNovAvg = <?php echo $getDashboardData[0]['ThisNovAvg'] ?  $getDashboardData[0]['ThisNovAvg'] :'0'."" ?>;
    // var ThisDecAvg = <?php echo $getDashboardData[0]['ThisDecAvg'] ?  $getDashboardData[0]['ThisDecAvg'] :'0'."" ?>;

    // var ThisJanTax = <?php echo $getDashboardData[0]['ThisJanTax'] ?  $getDashboardData[0]['ThisJanTax'] :'0'."" ?>;
    // var ThisFebTax = <?php echo $getDashboardData[0]['ThisFebTax'] ?  $getDashboardData[0]['ThisFebTax'] :'0'."" ?>;
    // var ThisMarTax = <?php echo $getDashboardData[0]['ThisMarTax'] ?  $getDashboardData[0]['ThisMarTax'] :'0'."" ?>;
    // var ThisAprTax = <?php echo $getDashboardData[0]['ThisAprTax'] ?  $getDashboardData[0]['ThisAprTax'] :'0'."" ?>;
    // var ThisMayTax = <?php echo $getDashboardData[0]['ThisMayTax'] ?  $getDashboardData[0]['ThisMayTax'] :'0'."" ?>;
    // var ThisJunTax = <?php echo $getDashboardData[0]['ThisJunTax'] ?  $getDashboardData[0]['ThisJunTax'] :'0'."" ?>;
    // var ThisJulTax = <?php echo $getDashboardData[0]['ThisJulTax'] ?  $getDashboardData[0]['ThisJulTax'] :'0'."" ?>;
    // var ThisAugTax = <?php echo $getDashboardData[0]['ThisAugTax'] ?  $getDashboardData[0]['ThisAugTax'] :'0'."" ?>;
    // var ThisSepTax = <?php echo $getDashboardData[0]['ThisSepTax'] ?  $getDashboardData[0]['ThisSepTax'] :'0'."" ?>;
    // var ThisOctTax = <?php echo $getDashboardData[0]['ThisOctTax'] ?  $getDashboardData[0]['ThisOctTax'] :'0'."" ?>;
    // var ThisNovTax = <?php echo $getDashboardData[0]['ThisNovTax'] ?  $getDashboardData[0]['ThisNovTax'] :'0'."" ?>;
    // var ThisDecTax = <?php echo $getDashboardData[0]['ThisDecTax'] ?  $getDashboardData[0]['ThisDecTax'] :'0'."" ?>;

    // // last year
    // var LastJanAmt = <?php echo $getDashboardData[0]['LastJanAmt'] ?  $getDashboardData[0]['LastJanAmt'] :'0'."" ?>;
    // var LastFebAmt = <?php echo $getDashboardData[0]['LastFebAmt'] ?  $getDashboardData[0]['LastFebAmt'] :'0'."" ?>;
    // var LastMarAmt = <?php echo $getDashboardData[0]['LastMarAmt'] ?  $getDashboardData[0]['LastMarAmt'] :'0'."" ?>;
    // var LastAprAmt = <?php echo $getDashboardData[0]['LastAprAmt'] ?  $getDashboardData[0]['LastAprAmt'] :'0'."" ?>;
    // var LastMayAmt = <?php echo $getDashboardData[0]['LastMayAmt'] ?  $getDashboardData[0]['LastMayAmt'] :'0'."" ?>;
    // var LastJunAmt = <?php echo $getDashboardData[0]['LastJunAmt'] ?  $getDashboardData[0]['LastJunAmt'] :'0'."" ?>;
    // var LastJulAmt = <?php echo $getDashboardData[0]['LastJulAmt'] ?  $getDashboardData[0]['LastJulAmt'] :'0'."" ?>;
    // var LastAugAmt = <?php echo $getDashboardData[0]['LastAugAmt'] ?  $getDashboardData[0]['LastAugAmt'] :'0'."" ?>;
    // var LastSepAmt = <?php echo $getDashboardData[0]['LastSepAmt'] ?  $getDashboardData[0]['LastSepAmt'] :'0'."" ?>;
    // var LastOctAmt = <?php echo $getDashboardData[0]['LastOctAmt'] ?  $getDashboardData[0]['LastOctAmt'] :'0'."" ?>;
    // var LastNovAmt = <?php echo $getDashboardData[0]['LastNovAmt'] ?  $getDashboardData[0]['LastNovAmt'] :'0'."" ?>;
    // var LastDecAmt = <?php echo $getDashboardData[0]['LastDecAmt'] ?  $getDashboardData[0]['LastDecAmt'] :'0'."" ?>;

    // var LastJanAvg = <?php echo $getDashboardData[0]['LastJanAvg'] ?  $getDashboardData[0]['LastJanAvg'] :'0'."" ?>;
    // var LastFebAvg = <?php echo $getDashboardData[0]['LastFebAvg'] ?  $getDashboardData[0]['LastFebAvg'] :'0'."" ?>;
    // var LastMarAvg = <?php echo $getDashboardData[0]['LastMarAvg'] ?  $getDashboardData[0]['LastMarAvg'] :'0'."" ?>;
    // var LastAprAvg = <?php echo $getDashboardData[0]['LastAprAvg'] ?  $getDashboardData[0]['LastAprAvg'] :'0'."" ?>;
    // var LastMayAvg = <?php echo $getDashboardData[0]['LastMayAvg'] ?  $getDashboardData[0]['LastMayAvg'] :'0'."" ?>;
    // var LastJunAvg = <?php echo $getDashboardData[0]['LastJunAvg'] ?  $getDashboardData[0]['LastJunAvg'] :'0'."" ?>;
    // var LastJulAvg = <?php echo $getDashboardData[0]['LastJulAvg'] ?  $getDashboardData[0]['LastJulAvg'] :'0'."" ?>;
    // var LastAugAvg = <?php echo $getDashboardData[0]['LastAugAvg'] ?  $getDashboardData[0]['LastAugAvg'] :'0'."" ?>;
    // var LastSepAvg = <?php echo $getDashboardData[0]['LastSepAvg'] ?  $getDashboardData[0]['LastSepAvg'] :'0'."" ?>;
    // var LastOctAvg = <?php echo $getDashboardData[0]['LastOctAvg'] ?  $getDashboardData[0]['LastOctAvg'] :'0'."" ?>;
    // var LastNovAvg = <?php echo $getDashboardData[0]['LastNovAvg'] ?  $getDashboardData[0]['LastNovAvg'] :'0'."" ?>;
    // var LastDecAvg = <?php echo $getDashboardData[0]['LastDecAvg'] ?  $getDashboardData[0]['LastDecAvg'] :'0'."" ?>;

    // var LastJanTax = <?php echo $getDashboardData[0]['LastJanTax'] ?  $getDashboardData[0]['LastJanTax'] :'0'."" ?>;
    // var LastFebTax = <?php echo $getDashboardData[0]['LastFebTax'] ?  $getDashboardData[0]['LastFebTax'] :'0'."" ?>;
    // var LastMarTax = <?php echo $getDashboardData[0]['LastMarTax'] ?  $getDashboardData[0]['LastMarTax'] :'0'."" ?>;
    // var LastAprTax = <?php echo $getDashboardData[0]['LastAprTax'] ?  $getDashboardData[0]['LastAprTax'] :'0'."" ?>;
    // var LastMayTax = <?php echo $getDashboardData[0]['LastMayTax'] ?  $getDashboardData[0]['LastMayTax'] :'0'."" ?>;
    // var LastJunTax = <?php echo $getDashboardData[0]['LastJunTax'] ?  $getDashboardData[0]['LastJunTax'] :'0'."" ?>;
    // var LastJulTax = <?php echo $getDashboardData[0]['LastJulTax'] ?  $getDashboardData[0]['LastJulTax'] :'0'."" ?>;
    // var LastAugTax = <?php echo $getDashboardData[0]['LastAugTax'] ?  $getDashboardData[0]['LastAugTax'] :'0'."" ?>;
    // var LastSepTax = <?php echo $getDashboardData[0]['LastSepTax'] ?  $getDashboardData[0]['LastSepTax'] :'0'."" ?>;
    // var LastOctTax = <?php echo $getDashboardData[0]['LastOctTax'] ?  $getDashboardData[0]['LastOctTax'] :'0'."" ?>;
    // var LastNovTax = <?php echo $getDashboardData[0]['LastNovTax'] ?  $getDashboardData[0]['LastNovTax'] :'0'."" ?>;
    // var LastDecTax = <?php echo $getDashboardData[0]['LastDecTax'] ?  $getDashboardData[0]['LastDecTax'] :'0'."" ?>;
    //End year

    var data1 = <?php echo $getSaleByYearData[0]['Totaljan'] ?  $getSaleByYearData[0]['Totaljan'] :'0'."" ?>;
    var data2 = <?php echo $getSaleByYearData[0]['Totalfeb'] ?  $getSaleByYearData[0]['Totalfeb'] :'0'."" ?>;
    var data3 = <?php echo $getSaleByYearData[0]['Totalmarch'] ?  $getSaleByYearData[0]['Totalmarch'] :'0'."" ?>;
    var data4 = <?php echo $getSaleByYearData[0]['Totalaprl'] ?  $getSaleByYearData[0]['Totalaprl'] :'0'."" ?>;
    var data5 = <?php echo $getSaleByYearData[0]['Totalmay'] ?  $getSaleByYearData[0]['Totalmay'] :'0'."" ?>;
    var data6 = <?php echo $getSaleByYearData[0]['Totaljune'] ?  $getSaleByYearData[0]['Totaljune'] :'0'."" ?>;
    var data7 = <?php echo $getSaleByYearData[0]['Totaljuly'] ?  $getSaleByYearData[0]['Totaljuly'] :'0'."" ?>;
    var data8 = <?php echo $getSaleByYearData[0]['Totalaugust'] ?  $getSaleByYearData[0]['Totalaugust'] :'0'."" ?>;
    var data9 = <?php echo $getSaleByYearData[0]['Totalsep'] ?  $getSaleByYearData[0]['Totalsep'] :'0'."" ?>;
    var data10 = <?php echo $getSaleByYearData[0]['Totaloct'] ?  $getSaleByYearData[0]['Totaloct'] :'0'."" ?>;
    var data11 = <?php echo $getSaleByYearData[0]['Totalnov'] ?  $getSaleByYearData[0]['Totalnov'] :'0'."" ?>;
    var data12 = <?php echo $getSaleByYearData[0]['Totaldec'] ?  $getSaleByYearData[0]['Totaldec'] :'0'."" ?>;

    var datatex1 = <?php echo $getSaleByYearData[0]['Totaljantax'] ?  $getSaleByYearData[0]['Totaljantax'] :'0'."" ?>;
    var datatex2 = <?php echo $getSaleByYearData[0]['Totalfebtax'] ?  $getSaleByYearData[0]['Totalfebtax'] :'0'.""; ?>;
    var datatex3 = <?php echo $getSaleByYearData[0]['Totalmarchtax'] ?  $getSaleByYearData[0]['Totalmarchtax'] :'0'."" ?>;
    var datatex4 = <?php echo $getSaleByYearData[0]['Totalaprltax'] ?  $getSaleByYearData[0]['Totalaprltax'] :'0'."" ?>;
    var datatex5 = <?php echo $getSaleByYearData[0]['Totalmaytax'] ?  $getSaleByYearData[0]['Totalmaytax'] :'0'."" ?>;
    var datatex6 = <?php echo $getSaleByYearData[0]['Totaljunetax'] ?  $getSaleByYearData[0]['Totaljunetax'] :'0'."" ?>;
    var datatex7 = <?php echo $getSaleByYearData[0]['Totaljulytax'] ?  $getSaleByYearData[0]['Totaljulytax'] :'0'."" ?>;
    var datatex8 = <?php echo $getSaleByYearData[0]['Totalaugusttax'] ?  $getSaleByYearData[0]['Totalaugusttax'] :'0'."" ?>;
    var datatex9 = <?php echo $getSaleByYearData[0]['Totalseptax'] ?  $getSaleByYearData[0]['Totalseptax'] :'0'."" ?>;
    var datatex10 = <?php echo $getSaleByYearData[0]['Totalocttax'] ?  $getSaleByYearData[0]['Totalocttax'] :'0'."" ?>;
    var datatex11 = <?php echo $getSaleByYearData[0]['Totalnovtax'] ?  $getSaleByYearData[0]['Totalnovtax'] :'0'."" ?>;
    var datatex12 = <?php echo $getSaleByYearData[0]['Totaldectax'] ?  $getSaleByYearData[0]['Totaldectax'] :'0'."" ?>;

    var dataf1 = <?php echo $getSaleByYearData[0]['Totaljanf'] ?  $getSaleByYearData[0]['Totaljanf'] :'0'."" ?>;
    var dataf2 = <?php echo $getSaleByYearData[0]['Totalfebf'] ?  $getSaleByYearData[0]['Totalfebf'] :'0'."" ?>;
    var dataf3 = <?php echo $getSaleByYearData[0]['Totalmarchf'] ?  $getSaleByYearData[0]['Totalmarchf'] :'0'."" ?>;
    var dataf4 = <?php echo $getSaleByYearData[0]['Totalaprlf'] ?  $getSaleByYearData[0]['Totalaprlf'] :'0'."" ?>;
    var dataf5 = <?php echo $getSaleByYearData[0]['Totalmayf'] ?  $getSaleByYearData[0]['Totalmayf'] :'0'."" ?>;
    var dataf6 = <?php echo $getSaleByYearData[0]['Totaljunef'] ?  $getSaleByYearData[0]['Totaljunef'] :'0'."" ?>;
    var dataf7 = <?php echo $getSaleByYearData[0]['Totaljulyf'] ?  $getSaleByYearData[0]['Totaljulyf'] :'0'."" ?>;
    var dataf8 = <?php echo $getSaleByYearData[0]['Totalaugustf'] ?  $getSaleByYearData[0]['Totalaugustf'] :'0'."" ?>;
    var dataf9 = <?php echo $getSaleByYearData[0]['Totalsepf'] ?  $getSaleByYearData[0]['Totalsepf'] :'0'."" ?>;
    var dataf10 = <?php echo $getSaleByYearData[0]['Totaloctf'] ?  $getSaleByYearData[0]['Totaloctf'] :'0'."" ?>;
    var dataf11 = <?php echo $getSaleByYearData[0]['Totalnovf'] ?  $getSaleByYearData[0]['Totalnovf'] :'0'."" ?>  ;
    var dataf12 = <?php echo  $getSaleByYearData[0]['Totaldecf'] ?  $getSaleByYearData[0]['Totaldecf'] :'0'."" ?> ;


    var datab1 = <?php echo $getSaleByYearData[0]['Totalbjan'] ?  $getSaleByYearData[0]['Totalbjan'] :'0'."" ?>;
    var datab2 = <?php echo $getSaleByYearData[0]['Totalbfeb'] ?  $getSaleByYearData[0]['Totalbfeb'] :'0'."" ?>;
    var datab3 = <?php echo $getSaleByYearData[0]['Totalbmarch'] ?  $getSaleByYearData[0]['Totalbmarch'] :'0'."" ; ?>;
    var datab4 = <?php echo $getSaleByYearData[0]['Totalbaprl'] ?  $getSaleByYearData[0]['Totalbaprl'] :'0'."" ; ?>;
    var datab5 = <?php echo $getSaleByYearData[0]['Totalbmay']  ?  $getSaleByYearData[0]['Totalbmay'] :'0'."" ; ?>;
    var datab6 = <?php echo $getSaleByYearData[0]['Totalbjune'] ?  $getSaleByYearData[0]['Totalbjune'] :'0'."" ; ?>;
    var datab7 = <?php echo $getSaleByYearData[0]['Totalbjuly']  ?  $getSaleByYearData[0]['Totalbjuly'] :'0'."" ; ?>;
    var datab8 = <?php echo $getSaleByYearData[0]['Totalbaugust']  ?  $getSaleByYearData[0]['Totalbaugust'] :'0'."" ; ?>;
    var datab9 = <?php echo $getSaleByYearData[0]['Totalbsep']  ?  $getSaleByYearData[0]['Totalbsep'] :'0'."" ; ?>;
    var datab10 = <?php echo $getSaleByYearData[0]['Totalboct'] ?  $getSaleByYearData[0]['Totalboct'] :'0'."" ; ?>;
    var datab11 = <?php echo $getSaleByYearData[0]['Totalbnov'] ?  $getSaleByYearData[0]['Totalbnov'] :'0'."" ; ?>;
    var datab12 = <?php echo ($getSaleByYearData[0]['Totalbdec']) ?  $getSaleByYearData[0]['Totalbdec'] :'0'."" ; ?>;

    var datatex1b = <?php echo $getSaleByYearData[0]['Totalbjantax'] ?  $getSaleByYearData[0]['Totalbjantax'] :'0'."" ?>;
    var datatex2b = <?php echo $getSaleByYearData[0]['Totalbfebtax'] ?  $getSaleByYearData[0]['Totalbfebtax'] :'0'.""; ?>;
    var datatex3b = <?php echo $getSaleByYearData[0]['Totalbmarchtax'] ?  $getSaleByYearData[0]['Totalbmarchtax'] :'0'."" ?>;
    var datatex4b = <?php echo $getSaleByYearData[0]['Totalbaprltax'] ?  $getSaleByYearData[0]['Totalbaprltax'] :'0'."" ?>;
    var datatex5b = <?php echo $getSaleByYearData[0]['Totalbmaytax'] ?  $getSaleByYearData[0]['Totalbmaytax'] :'0'."" ?>;
    var datatex6b = <?php echo $getSaleByYearData[0]['Totalbjunetax'] ?  $getSaleByYearData[0]['Totalbjunetax'] :'0'."" ?>;
    var datatex7b = <?php echo $getSaleByYearData[0]['Totalbjulytax'] ?  $getSaleByYearData[0]['Totalbjulytax'] :'0'."" ?>;
    var datatex8b = <?php echo $getSaleByYearData[0]['Totalbaugusttax'] ?  $getSaleByYearData[0]['Totalbaugusttax'] :'0'."" ?>;
    var datatex9b = <?php echo $getSaleByYearData[0]['Totalbseptax'] ?  $getSaleByYearData[0]['Totalbseptax'] :'0'."" ?>;
    var datatex10b = <?php echo $getSaleByYearData[0]['Totalbocttax'] ?  $getSaleByYearData[0]['Totalbocttax'] :'0'."" ?>;
    var datatex11b = <?php echo $getSaleByYearData[0]['Totalbnovtax'] ?  $getSaleByYearData[0]['Totalbnovtax'] :'0'."" ?>;
    var datatex12b = <?php echo $getSaleByYearData[0]['Totalbdectax'] ?  $getSaleByYearData[0]['Totalbdectax'] :'0'."" ?>;

    var dataf1b = <?php echo $getSaleByYearData[0]['Totalbjanf'] ?  $getSaleByYearData[0]['Totalbjanf'] :'0'."" ?>;
    var dataf2b = <?php echo $getSaleByYearData[0]['Totalbfebf'] ?  $getSaleByYearData[0]['Totalbfebf'] :'0'."" ?>;
    var dataf3b = <?php echo $getSaleByYearData[0]['Totalbmarchf'] ?  $getSaleByYearData[0]['Totalbmarchf'] :'0'."" ?>;
    var dataf4b = <?php echo $getSaleByYearData[0]['Totalbaprlf'] ?  $getSaleByYearData[0]['Totalbaprlf'] :'0'."" ?>;
    var dataf5b = <?php echo $getSaleByYearData[0]['Totalbmayf'] ?  $getSaleByYearData[0]['Totalbmayf'] :'0'."" ?>;
    var dataf6b = <?php echo $getSaleByYearData[0]['Totalbjunef'] ?  $getSaleByYearData[0]['Totalbjunef'] :'0'."" ?>;
    var dataf7b = <?php echo $getSaleByYearData[0]['Totalbjulyf'] ?  $getSaleByYearData[0]['Totalbjulyf'] :'0'."" ?>;
    var dataf8b = <?php echo $getSaleByYearData[0]['Totalbaugustf'] ?  $getSaleByYearData[0]['Totalbaugustf'] :'0'."" ?>;
    var dataf9b = <?php echo $getSaleByYearData[0]['Totalbsepf'] ?  $getSaleByYearData[0]['Totalbsepf'] :'0'."" ?>;
    var dataf10b = <?php echo $getSaleByYearData[0]['Totalboctf'] ?  $getSaleByYearData[0]['Totalboctf'] :'0'."" ?>;
    var dataf11b = <?php echo $getSaleByYearData[0]['Totalbnovf'] ?  $getSaleByYearData[0]['Totalbnovf'] :'0'."" ?>;
    var dataf12b = <?php echo  $getSaleByYearData[0]['Totalbdecf'] ?  $getSaleByYearData[0]['Totalbdecf'] :'0'."" ?>;

    var currentYear = <?php echo date("Y") ?>;
    var lastYear = <?php echo date("Y",strtotime("-1 year")) ?>;


    //   var t_fee =<?php echo   $this->session->userdata('t_fee') ?>;
    //     var fee = (data12/100)*t_fee;
    var currentYear = <?php echo date("Y") ?>;
    var lastYear = <?php echo date("Y",strtotime("-1 year")) ?>;

    Highcharts.chart('dailyGrossSale', {
        chart: {
            type: 'column',
            spacingBottom: 30,
            height: 400
        },
        title: {
            text: null
        },
        xAxis: {
            // categories: ['12:00 AM','01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM', '12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM'],
            categories: ['00:00','02:00','04:00','06:00','08:00','10:00','12:00','14:00','16:00','18:00','20:00','22:00'],
            labels: {
                style: {
                    color: '#9b9b9b',
                    fontFamily: 'AvenirNext-Medium'
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
            min: 0,
            labels:{
                formatter: function() {
                    return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                }
            },
        },
        exporting: {
            enabled: false
        },
        tooltip: {
            backgroundColor: '#fff',
            borderRadius: 10,
            formatter: function() {
                return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            series: {
                pointWidth: 13,
                borderRadius: 8,
                marker: {
                    lineWidth: 3,
                    lineColor: '#ffffff',
                    symbol: 'circle'
                }
            }
        },
        // series: [{
        //     name: 'Gross Sales- Today',
        //     type: "column",
        //     color: '#00a6ff',
        //     // showInLegend: false,
        //     data: [{y:data1a_ld, tax :datatex1a_ld   ,fee :dataf1a_ld}, {y:data2a_ld, tax :datatex2a_ld ,fee :dataf2a_ld},{y:data3a_ld, tax :datatex3a_ld ,fee :dataf3a_ld},{y:data4a_ld, tax :datatex4a_ld,fee :dataf4a_ld},{y:data5a_ld, tax :datatex5a_ld ,fee :dataf5a_ld},{y:data6a_ld, tax :datatex6a_ld, fee :dataf6a_ld},{y:data7a_ld, tax :datatex7a_ld ,fee :dataf7a_ld},{y:data8a_ld, tax :datatex8a_ld ,fee :dataf8a_ld},{y:data9a_ld, tax :datatex9a_ld ,fee :dataf9a_ld},{y:data10a_ld, tax :datatex10a_ld ,fee :dataf10a_ld},{y:data11a_ld, tax :datatex11a_ld ,fee :dataf11a_ld},{y:data12a_ld, tax :datatex12a_ld ,fee :dataf12a_ld}]
        // },{
        //     name: 'Gross Sales- Yesterday',
        //     type: "column",
        //     color: '#1956a6',
        //     // showInLegend: false,
        //     data: [{y:data1a, tax :datatex1a   ,fee :dataf1a}, {y:data2a, tax :datatex2a ,fee :dataf2a},{y:data3a, tax :datatex3a ,fee :dataf3a},{y:data4a, tax :datatex4a,fee :dataf4a},{y:data5a, tax :datatex5a ,fee :dataf5a},{y:data6a, tax :datatex6a, fee :dataf6a},{y:data7a, tax :datatex7a ,fee :dataf7a},{y:data8a, tax :datatex8a ,fee :dataf8a},{y:data9a, tax :datatex9a ,fee :dataf9a},{y:data10a, tax :datatex10a ,fee :dataf10a},{y:data11a, tax :datatex11a ,fee :dataf11a},{y:data12a, tax :datatex12a ,fee :dataf12a}]
        // }]
        series: [{
            name: 'Gross Sales- Today',
            type: "column",
            color: '#00a6ff',
            // showInLegend: false,
            data: [
                {y: CurrAmtDailyOne, fee: CurrAvgDailyOne, tax: CurrTaxDailyOne},
                {y: CurrAmtDailyTwo, fee: CurrAvgDailyTwo, tax: CurrTaxDailyTwo},
                {y: CurrAmtDailyThree, fee: CurrAvgDailyThree, tax: CurrTaxDailyThree},
                {y: CurrAmtDailyFour, fee: CurrAvgDailyFour, tax: CurrTaxDailyFour},
                {y: CurrAmtDailyFive, fee: CurrAvgDailyFive, tax: CurrTaxDailyFive},
                {y: CurrAmtDailySix, fee: CurrAvgDailySix, tax: CurrTaxDailySix},
                {y: CurrAmtDailySeven, fee: CurrAvgDailySeven, tax: CurrTaxDailySeven},
                {y: CurrAmtDailyEight, fee: CurrAvgDailyEight, tax: CurrTaxDailyEight},
                {y: CurrAmtDailyNine, fee: CurrAvgDailyNine, tax: CurrTaxDailyNine},
                {y: CurrAmtDailyTen, fee: CurrAvgDailyTen, tax: CurrTaxDailyTen},
                {y: CurrAmtDailyEleven, fee: CurrAvgDailyEleven, tax: CurrTaxDailyEleven},
                {y: CurrAmtDailyTwelve, fee: CurrAvgDailyTwelve, tax: CurrTaxDailyTwelve}
            ]
        },{
            name: 'Gross Sales- Yesterday',
            type: "column",
            color: '#1956a6',
            // showInLegend: false,
            data: [
                {y: LastAmtDailyOne, tax: LastAvgDailyOne, fee: LastTaxDailyOne},
                {y: LastAmtDailyTwo, tax: LastAvgDailyTwo, fee: LastTaxDailyTwo},
                {y: LastAmtDailyThree, tax: LastAvgDailyThree, fee: LastTaxDailyThree},
                {y: LastAmtDailyFour, tax: LastAvgDailyFour, fee: LastTaxDailyFour},
                {y: LastAmtDailyFive, tax: LastAvgDailyFive, fee: LastTaxDailyFive},
                {y: LastAmtDailySix, tax: LastAvgDailySix, fee: LastTaxDailySix},
                {y: LastAmtDailySeven, tax: LastAvgDailySeven, fee: LastTaxDailySeven},
                {y: LastAmtDailyEight, tax: LastAvgDailyEight, fee: LastTaxDailyEight},
                {y: LastAmtDailyNine, tax: LastAvgDailyNine, fee: LastTaxDailyNine},
                {y: LastAmtDailyTen, tax: LastAvgDailyTen, fee: LastTaxDailyTen},
                {y: LastAmtDailyEleven, tax: LastAvgDailyEleven, fee: LastTaxDailyEleven},
                {y: LastAmtDailyTwelve, tax: LastAvgDailyTwelve, fee: LastTaxDailyTwelve}
            ]
        }]
    });

    Highcharts.chart('weeklyGrossSale', {
        chart: {
            type: 'column',
            spacingBottom: 30,
            height: 400
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            labels: {
                style: {
                    color: '#9b9b9b'
                }
            },
            min: 0,
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
            min: 0,
            labels: {
                formatter: function() {
                    return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                }
            },
        },
        exporting: {
            enabled: false
        },
        tooltip: {
            backgroundColor: '#fff',
            borderRadius: 10,
            formatter: function() {
                return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            series: {
                pointWidth: 13,
                borderRadius: 8,
                marker: {
                    lineWidth: 3,
                    lineColor: '#ffffff',
                    symbol: 'circle'
                }
            }
        },
        series: [{
            name: 'Current Week',
            type: "column",
            color: '#00a6ff',
            // showInLegend: false,
            data: [
                {y: ThisSundayAmt, fee: ThisSundayAvg, tax: ThisSundayTax},
                {y: ThisMondayAmt, fee: ThisMondayAvg, tax: ThisMondayTax},
                {y: ThisTuesdayAmt, fee: ThisTuesdayAvg, tax: ThisTuesdayTax},
                {y: ThisWednesdayAmt, fee: ThisWednesdayAvg, tax: ThisWednesdayTax},
                {y: ThisThursdayAmt, fee: ThisThursdayAvg, tax: ThisThursdayTax},
                {y: ThisFridayAmt, fee: ThisFridayAvg, tax: ThisFridayTax},
                {y: ThisSaturdayAmt, fee: ThisSaturdayAvg, tax: ThisSaturdayTax}
            ]
        },{
            name: 'Last Week',
            type: "column",
            color: '#1956a6',
            // showInLegend: false,
            data: [
                {y: LastSundayAmt, fee: LastSundayAvg, tax: LastSundayTax},
                {y: LastMondayAmt, fee: LastMondayAvg, tax: LastMondayTax},
                {y: LastTuesdayAmt, fee: LastTuesdayAvg, tax: LastTuesdayTax},
                {y: LastWednesdayAmt, fee: LastWednesdayAvg, tax: LastWednesdayTax},
                {y: LastThursdayAmt, fee: LastThursdayAvg, tax: LastThursdayTax},
                {y: LastFridayAmt, fee: LastFridayAvg, tax: LastFridayTax},
                {y: LastSaturdayAmt, fee: LastSaturdayAvg, tax: LastSaturdayTax}
            ]
        }]
    });

    // Highcharts.chart('yearlyGrossSale', {
    //     chart: {
    //         type: 'column',
    //         spacingBottom: 30,
    //         height: 400
    //     },
    //     title: {
    //         text: null
    //     },
    //     xAxis: {
    //         categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    //         labels: {
    //             style: {
    //                 color: '#9b9b9b'
    //             }
    //         },
    //         min: 0
    //     },
    //     yAxis: {
    //         gridLineColor: '#eaeaea',
    //         title: {
    //             text: false
    //         },
    //         labels: {
    //             style: {
    //                 color: '#9b9b9b'
    //             }
    //         },
    //         labels: {
    //             formatter: function() {
    //                 return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
    //             }
    //         },
    //     },
    //     exporting: {
    //         enabled: false
    //     },
    //     tooltip: {
    //         backgroundColor: '#fff',
    //         borderRadius: 10,
    //         formatter: function() {
    //             return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
    //         }
    //     },
    //     credits: {
    //         enabled: false 
    //     },
    //     plotOptions: {
    //         series: {
    //             minPointLength: 6,
    //             pointWidth: 13,
    //             borderRadius: 8,
    //             marker: {
    //                 lineWidth: 3,
    //                 lineColor: '#ffffff',
    //                 symbol: 'circle'
    //             }
    //         }
    //     },
    //     series: [{
    //         lineWidth: 4,
    //         name: 'Yearly Gross Sales-'+ currentYear,
    //         type: "column",
    //         color: '#00a6ff',
    //         // showInLegend: false,
    //         data: [
    //             {y: ThisJanAmt, fee: ThisJanAvg, tax: ThisJanTax},
    //             {y: ThisFebAmt, fee: ThisFebAvg, tax: ThisFebTax},
    //             {y: ThisMarAmt, fee: ThisMarAvg, tax: ThisMarTax},
    //             {y: ThisAprAmt, fee: ThisAprAvg, tax: ThisAprTax},
    //             {y: ThisMayAmt, fee: ThisMayAvg, tax: ThisMayTax},
    //             {y: ThisJunAmt, fee: ThisJunAvg, tax: ThisJunTax},
    //             {y: ThisJulAmt, fee: ThisJulAvg, tax: ThisJulTax},
    //             {y: ThisAugAmt, fee: ThisAugAvg, tax: ThisAugTax},
    //             {y: ThisSepAmt, fee: ThisSepAvg, tax: ThisSepTax},
    //             {y: ThisOctAmt, fee: ThisOctAvg, tax: ThisOctTax},
    //             {y: ThisNovAmt, fee: ThisNovAvg, tax: ThisNovTax},
    //             {y: ThisDecAmt, fee: ThisDecAvg, tax: ThisDecTax}
    //         ]
    //     },{
    //         lineWidth: 4,
    //         name: 'Yearly Gross Sales-'+ lastYear,
    //         type: "column",
    //         color: '#1956a6',
    //         // showInLegend: false,
    //         data: [
    //             {y: LastJanAmt, fee: LastJanAvg, tax: LastJanTax},
    //             {y: LastFebAmt, fee: LastFebAvg, tax: LastFebTax},
    //             {y: LastMarAmt, fee: LastMarAvg, tax: LastMarTax},
    //             {y: LastAprAmt, fee: LastAprAvg, tax: LastAprTax},
    //             {y: LastMayAmt, fee: LastMayAvg, tax: LastMayTax},
    //             {y: LastJunAmt, fee: LastJunAvg, tax: LastJunTax},
    //             {y: LastJulAmt, fee: LastJulAvg, tax: LastJulTax},
    //             {y: LastAugAmt, fee: LastAugAvg, tax: LastAugTax},
    //             {y: LastSepAmt, fee: LastSepAvg, tax: LastSepTax},
    //             {y: LastOctAmt, fee: LastOctAvg, tax: LastOctTax},
    //             {y: LastNovAmt, fee: LastNovAvg, tax: LastNovTax},
    //             {y: LastDecAmt, fee: LastDecAvg, tax: LastDecTax}
    //         ]
    //     }]
    // });

    Highcharts.chart('yearlyGrossSale', {
        chart: {
            type: 'column',
            spacingBottom: 30,
            height: 400
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
            labels: {
                formatter: function() {
                    return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                }
            },
        },
        exporting: {
            enabled: false
        },
        tooltip: {
            backgroundColor: '#fff',
            borderRadius: 10,
            formatter: function() {
                return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.fee.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
            }
        },
        credits: {
            enabled: false 
        },
        plotOptions: {
            series: {
                minPointLength: 6,
                pointWidth: 13,
                borderRadius: 8,
                marker: {
                    lineWidth: 3,
                    lineColor: '#ffffff',
                    symbol: 'circle'
                }
            }
        },
        series: [{
            lineWidth: 4,
            name: 'Yearly Gross Sales-'+ currentYear,
            type: "column",
            color: '#00a6ff',
            // showInLegend: false,
            data: [{y:data1, tax :datatex1 , fee :dataf1}, {y:data2, tax :datatex2 , fee :dataf2},{y:data3, tax :datatex3 , fee :dataf3},{y:data4, tax :datatex4 , fee :dataf4},{y:data5, tax :datatex5 , fee :dataf5},{y:data6, tax :datatex6 , fee :dataf6},{y:data7, tax :datatex7 , fee :dataf7},{y:data8, tax :datatex8 , fee :dataf8},{y:data9, tax :datatex9 , fee :dataf9},{y:data10, tax :datatex10 , fee :dataf10},{y:data11, tax :datatex11 , fee :dataf11},{y:data12, tax :datatex12 , fee :dataf12}]
        },{
            lineWidth: 4,
            name: 'Yearly Gross Sales-'+ lastYear,
            type: "column",
            color: '#1956a6',
            // showInLegend: false,
            data: [{y:datab1, tax :datatex1b, fee :dataf1b}, {y:datab2, tax :datatex2b, fee :dataf2b},{y:datab3, tax :datatex3b, fee :dataf3b},{y:datab4, tax :datatex4b, fee :dataf4b},{y:datab5, tax :datatex5b, fee :dataf5b},{y:datab6, tax :datatex6b, fee :dataf6b},{y:datab7, tax :datatex7b, fee :dataf7b},{y:datab8, tax :datatex8b, fee :dataf8b},{y:datab9, tax :datatex9b, fee :dataf9b},{y:datab10, tax :datatex10b, fee :dataf10b},{y:datab11, tax :datatex11b, fee :dataf11b},{y:datab12, tax :datatex12b, fee :dataf12b}]
        }]
    });
};
</script>
<?php include_once'footer_dash.php'; ?>