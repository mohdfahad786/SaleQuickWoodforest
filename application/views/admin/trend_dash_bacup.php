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

            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
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
                                    <div class="split-header">
                                        <div class="split-sub-header">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <p class="h4-custom">Daily Gross Sales</p>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                    <!-- <div class="row pull-right" style="margin-right: 10px;">
                                                        <div class="custom-chart-label">
                                                            <span>
                                                                <div class="rectangle"></div>
                                                                Gross Sales - Today
                                                            </span>
                                                        </div>
                                                        <div class="custom-chart-label year_chart_margin_right">
                                                            <span>
                                                                <div class="rectangle-darked"></div>
                                                                Gross Sales - Yesterday
                                                            </span>
                                                        </div>
                                                    </div> -->
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
  function onSelectChange3(start, end){
    var start =  start;
    var end =  end;
    $.ajax({
      type: 'POST',
      url: "<?php  echo base_url('graph/trends'); ?>",
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
// $('#txt').val(element.item[0][]);
getGraph1() ;
});
      }
    });
  }
</script> 

<script>
function getGraph1(start, end) {     
    // starrt Year 
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
    var datab11n = <?php echo $getDashboardData[0]['Totalbnov'] ?  $getDashboardData[0]['Totalbnov'] :'0'."" ; ?>;
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
    var datab11 = <?php echo $getDashboardData[0]['Totaljana'] ?  $getDashboardData[0]['Totaljana'] :'0'."" ?>;
    var datab21 = <?php echo $getDashboardData[0]['Totalfeba'] ?  $getDashboardData[0]['Totalfeba'] :'0'."" ?>;
    var datab31 = <?php echo $getDashboardData[0]['Totalmarcha'] ?  $getDashboardData[0]['Totalmarcha'] :'0'."" ?>;
    var datab41 = <?php echo $getDashboardData[0]['Totalaprla'] ?  $getDashboardData[0]['Totalaprla'] :'0'."" ?>;
    var datab51 = <?php echo $getDashboardData[0]['Totalmaya'] ?  $getDashboardData[0]['Totalmaya'] :'0'."" ?>;
    var datab61 = <?php echo $getDashboardData[0]['Totaljunea'] ?  $getDashboardData[0]['Totaljunea'] :'0'."" ?>;
    var datab71 = <?php echo $getDashboardData[0]['Totaljulya'] ?  $getDashboardData[0]['Totaljulya'] :'0'."" ?>;
    var datab81 = <?php echo $getDashboardData[0]['Totalaugusta'] ?  $getDashboardData[0]['Totalaugusta'] :'0'."" ?>;
    var datab91 = <?php echo $getDashboardData[0]['Totalsepa'] ?  $getDashboardData[0]['Totalsepa'] :'0'."" ?>;
    var datab101 = <?php echo $getDashboardData[0]['Totalocta'] ?  $getDashboardData[0]['Totalocta'] :'0'."" ?>;
    var datab111 = <?php echo $getDashboardData[0]['Totalnova'] ?  $getDashboardData[0]['Totalnova'] :'0'."" ?>;
    var datab121 = <?php echo $getDashboardData[0]['Totaldeca'] ?  $getDashboardData[0]['Totaldeca'] :'0'."" ?>;
    //End Fee
    // start time 
    var datatex1a = <?php echo $getDashboardData[0]['Totaljantaxa'] ?  $getDashboardData[0]['Totaljantaxa'] :'0'."" ?>;
    var datatex2a = <?php echo $getDashboardData[0]['Totalfebtaxa'] ?  $getDashboardData[0]['Totalfebtaxa'] :'0'.""; ?>;
    var datatex3a = <?php echo $getDashboardData[0]['Totalmarchtaxa'] ?  $getDashboardData[0]['Totalmarchtaxa'] :'0'."" ?>;
    var datatex4a = <?php echo $getDashboardData[0]['Totalaprltaxa'] ?  $getDashboardData[0]['Totalaprltaxa'] :'0'."" ?>;
    var datatex5a = <?php echo $getDashboardData[0]['Totalmaytaxa'] ?  $getDashboardData[0]['Totalmaytaxa'] :'0'."" ?>;
    var datatex6a = <?php echo $getDashboardData[0]['Totaljunetaxa'] ?  $getDashboardData[0]['Totaljunetaxa'] :'0'."" ?>;
    var datatex7a = <?php echo $getDashboardData[0]['Totaljulytaxa'] ?  $getDashboardData[0]['Totaljulytaxa'] :'0'."" ?>;
    var datatex8a = <?php echo $getDashboardData[0]['Totalaugusttaxa'] ?  $getDashboardData[0]['Totalaugusttaxa'] :'0'."" ?>;
    var datatex9a = <?php echo $getDashboardData[0]['Totalseptaxa'] ?  $getDashboardData[0]['Totalseptaxa'] :'0'."" ?>;
    var datatex10a = <?php echo $getDashboardData[0]['Totalocttaxa'] ?  $getDashboardData[0]['Totalocttaxa'] :'0'."" ?>;
    var datatex11a = <?php echo $getDashboardData[0]['Totalnovtaxa'] ?  $getDashboardData[0]['Totalnovtaxa'] :'0'."" ?>;
    var datatex12a = <?php echo $getDashboardData[0]['Totaldectaxa'] ?  $getDashboardData[0]['Totaldectaxa'] :'0'."" ?>;
    var dataf1a = <?php echo $getDashboardData[0]['Totaljanfeea'] ?  $getDashboardData[0]['Totaljanfeea'] :'0'."" ?>;
    var dataf2a = <?php echo $getDashboardData[0]['Totalfebfeea'] ?  $getDashboardData[0]['Totalfebfeea'] :'0'."" ?>;
    var dataf3a = <?php echo $getDashboardData[0]['Totalmarchfeea'] ?  $getDashboardData[0]['Totalmarchfeea'] :'0'."" ?>;
    var dataf4a = <?php echo $getDashboardData[0]['Totalaprlfeea'] ?  $getDashboardData[0]['Totalaprlfeea'] :'0'."" ?>;
    var dataf5a = <?php echo $getDashboardData[0]['Totalmayfeea'] ?  $getDashboardData[0]['Totalmayfeea'] :'0'."" ?>;
    var dataf6a = <?php echo $getDashboardData[0]['Totaljunefeea'] ?  $getDashboardData[0]['Totaljunefeea'] :'0'."" ?>;
    var dataf7a = <?php echo $getDashboardData[0]['Totaljulyfeea'] ?  $getDashboardData[0]['Totaljulyfeea'] :'0'."" ?>;
    var dataf8a = <?php echo $getDashboardData[0]['Totalaugustfeea'] ?  $getDashboardData[0]['Totalaugustfeea'] :'0'."" ?>;
    var dataf9a = <?php echo $getDashboardData[0]['Totalsepfeea'] ?  $getDashboardData[0]['Totalsepfeea'] :'0'."" ?>;
    var dataf10a = <?php echo $getDashboardData[0]['Totaloctfeea'] ?  $getDashboardData[0]['Totaloctfeea'] :'0'."" ?>;
    var dataf11a = <?php echo $getDashboardData[0]['Totalnovfeea'] ?  $getDashboardData[0]['Totalnovfeea'] :'0'."" ?>  ;
    var dataf12a = <?php echo  $getDashboardData[0]['Totaldecfeea'] ?  $getDashboardData[0]['Totaldecfeea'] :'0'."" ?> ;
    var data1a = <?php echo $getDashboardData[0]['Totaljana'] ?  $getDashboardData[0]['Totaljana'] :'0'."" ?>;
    var data2a = <?php echo $getDashboardData[0]['Totalfeba'] ?  $getDashboardData[0]['Totalfeba'] :'0'."" ?>;
    var data3a = <?php echo $getDashboardData[0]['Totalmarcha'] ?  $getDashboardData[0]['Totalmarcha'] :'0'."" ?>;
    var data4a = <?php echo $getDashboardData[0]['Totalaprla'] ?  $getDashboardData[0]['Totalaprla'] :'0'."" ?>;
    var data5a = <?php echo $getDashboardData[0]['Totalmaya'] ?  $getDashboardData[0]['Totalmaya'] :'0'."" ?>;
    var data6a = <?php echo $getDashboardData[0]['Totaljunea'] ?  $getDashboardData[0]['Totaljunea'] :'0'."" ?>;
    var data7a = <?php echo $getDashboardData[0]['Totaljulya'] ?  $getDashboardData[0]['Totaljulya'] :'0'."" ?>;
    var data8a = <?php echo $getDashboardData[0]['Totalaugusta'] ?  $getDashboardData[0]['Totalaugusta'] :'0'."" ?>;
    var data9a = <?php echo $getDashboardData[0]['Totalsepa'] ?  $getDashboardData[0]['Totalsepa'] :'0'."" ?>;
    var data10a = <?php echo $getDashboardData[0]['Totalocta'] ?  $getDashboardData[0]['Totalocta'] :'0'."" ?>;
    var data11a = <?php echo $getDashboardData[0]['Totalnova'] ?  $getDashboardData[0]['Totalnova'] :'0'."" ?>  ;
    var data12a = <?php echo  $getDashboardData[0]['Totaldeca'] ?  $getDashboardData[0]['Totaldeca'] :'0'."" ?> ;
    // End time
    var Monday = <?php echo $getDashboardData[0]['Monday'] ?  $getDashboardData[0]['Monday'] :'0'."" ?>;
    var Tuesday = <?php echo $getDashboardData[0]['Tuesday'] ?  $getDashboardData[0]['Tuesday'] :'0'."" ?>;
    var Wednesday = <?php echo $getDashboardData[0]['Wednesday'] ?  $getDashboardData[0]['Wednesday'] :'0'."" ; ?>;
    var Thursday = <?php echo $getDashboardData[0]['Thursday'] ?  $getDashboardData[0]['Thursday'] :'0'."" ; ?>;
    var Friday = <?php echo $getDashboardData[0]['Friday']  ?  $getDashboardData[0]['Friday'] :'0'."" ; ?>;
    var Satuday = <?php echo $getDashboardData[0]['Satuday'] ?  $getDashboardData[0]['Satuday'] :'0'."" ; ?>;
    var Sunday = <?php echo $getDashboardData[0]['Sunday']  ?  $getDashboardData[0]['Sunday'] :'0'."" ; ?>;
    var Monday_l = <?php echo $getDashboardData[0]['Monday_l'] ?  $getDashboardData[0]['Monday_l'] :'0'."" ?>;
    var Tuesday_l = <?php echo $getDashboardData[0]['Tuesday_l'] ?  $getDashboardData[0]['Tuesday_l'] :'0'."" ?>;
    var Wednesday_l = <?php echo $getDashboardData[0]['Wednesday_l'] ?  $getDashboardData[0]['Wednesday_l'] :'0'."" ; ?>;
    var Thursday_l = <?php echo $getDashboardData[0]['Thursday_l'] ?  $getDashboardData[0]['Thursday_l'] :'0'."" ; ?>;
    var Friday_l = <?php echo $getDashboardData[0]['Friday_l']  ?  $getDashboardData[0]['Friday_l'] :'0'."" ; ?>;
    var Satuday_l = <?php echo $getDashboardData[0]['Satuday_l'] ?  $getDashboardData[0]['Satuday_l'] :'0'."" ; ?>;
    var Sunday_l = <?php echo $getDashboardData[0]['Sunday_l']  ?  $getDashboardData[0]['Sunday_l'] :'0'."" ; ?>;
    var Monday_fee = <?php echo $getDashboardData[0]['Monday_fee'] ?  $getDashboardData[0]['Monday_fee'] :'0'."" ?>;
    var Tuesday_fee = <?php echo $getDashboardData[0]['Tuesday_fee'] ?  $getDashboardData[0]['Tuesday_fee'] :'0'."" ?>;
    var Wednesday_fee = <?php echo $getDashboardData[0]['Wednesday_fee'] ?  $getDashboardData[0]['Wednesday_fee'] :'0'."" ; ?>;
    var Thursday_fee = <?php echo $getDashboardData[0]['Thursday_fee'] ?  $getDashboardData[0]['Thursday_fee'] :'0'."" ; ?>;
    var Friday_fee = <?php echo $getDashboardData[0]['Friday_fee']  ?  $getDashboardData[0]['Friday_fee'] :'0'."" ; ?>;
    var Satuday_fee = <?php echo $getDashboardData[0]['Satuday_fee'] ?  $getDashboardData[0]['Satuday_fee'] :'0'."" ; ?>;
    var Sunday_fee = <?php echo $getDashboardData[0]['Sunday_fee']  ?  $getDashboardData[0]['Sunday_fee'] :'0'."" ; ?>;
    var Monday_l_fee = <?php echo $getDashboardData[0]['Monday_l_fee'] ?  $getDashboardData[0]['Monday_l_fee'] :'0'."" ?>;
    var Tuesday_l_fee = <?php echo $getDashboardData[0]['Tuesday_l_fee'] ?  $getDashboardData[0]['Tuesday_l_fee'] :'0'."" ?>;
    var Wednesday_l_fee = <?php echo $getDashboardData[0]['Wednesday_l_fee'] ?  $getDashboardData[0]['Wednesday_l_fee'] :'0'."" ; ?>;
    var Thursday_l_fee = <?php echo $getDashboardData[0]['Thursday_l_fee'] ?  $getDashboardData[0]['Thursday_l_fee'] :'0'."" ; ?>;
    var Friday_l_fee = <?php echo $getDashboardData[0]['Friday_l_fee']  ?  $getDashboardData[0]['Friday_l_fee'] :'0'."" ; ?>;
    var Satuday_l_fee = <?php echo $getDashboardData[0]['Satuday_l_fee'] ?  $getDashboardData[0]['Satuday_l_fee'] :'0'."" ; ?>;
    var Sunday_l_fee = <?php echo $getDashboardData[0]['Sunday_l_fee']  ?  $getDashboardData[0]['Sunday_l_fee'] :'0'."" ; ?>;
    var Monday_tax = <?php echo $getDashboardData[0]['Monday_tax'] ?  $getDashboardData[0]['Monday_tax'] :'0'."" ?>;
    var Tuesday_tax = <?php echo $getDashboardData[0]['Tuesday_tax'] ?  $getDashboardData[0]['Tuesday_tax'] :'0'."" ?>;
    var Wednesday_tax = <?php echo $getDashboardData[0]['Wednesday_tax'] ?  $getDashboardData[0]['Wednesday_tax'] :'0'."" ; ?>;
    var Thursday_tax = <?php echo $getDashboardData[0]['Thursday_tax'] ?  $getDashboardData[0]['Thursday_tax'] :'0'."" ; ?>;
    var Friday_tax = <?php echo $getDashboardData[0]['Friday_tax']  ?  $getDashboardData[0]['Friday_tax'] :'0'."" ; ?>;
    var Satuday_tax = <?php echo $getDashboardData[0]['Satuday_tax'] ?  $getDashboardData[0]['Satuday_tax'] :'0'."" ; ?>;
    var Sunday_tax = <?php echo $getDashboardData[0]['Sunday_tax']  ?  $getDashboardData[0]['Sunday_tax'] :'0'."" ; ?>;
    var Monday_l_tax = <?php echo $getDashboardData[0]['Monday_l_tax'] ?  $getDashboardData[0]['Monday_l_tax'] :'0'."" ?>;
    var Tuesday_l_tax = <?php echo $getDashboardData[0]['Tuesday_l_tax'] ?  $getDashboardData[0]['Tuesday_l_tax'] :'0'."" ?>;
    var Wednesday_l_tax = <?php echo $getDashboardData[0]['Wednesday_l_tax'] ?  $getDashboardData[0]['Wednesday_l_tax'] :'0'."" ; ?>;
    var Thursday_l_tax = <?php echo $getDashboardData[0]['Thursday_l_tax'] ?  $getDashboardData[0]['Thursday_l_tax'] :'0'."" ; ?>;
    var Friday_l_tax = <?php echo $getDashboardData[0]['Friday_l_tax']  ?  $getDashboardData[0]['Friday_l_tax'] :'0'."" ; ?>;
    var Satuday_l_tax = <?php echo $getDashboardData[0]['Satuday_l_tax'] ?  $getDashboardData[0]['Satuday_l_tax'] :'0'."" ; ?>;
    var Sunday_l_tax = <?php echo $getDashboardData[0]['Sunday_l_tax']  ?  $getDashboardData[0]['Sunday_l_tax'] :'0'."" ; ?>;
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
            categories: ['12:00 AM','01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM', '12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM'],
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
        series: [{
            name: 'Gross Sales- Today',
            type: "column",
            color: '#00a6ff',
            // showInLegend: false,
            data: [{y:data1a, tax :datatex1a   ,fee :dataf1a}, {y:data2a, tax :datatex2a ,fee :dataf2a},{y:data3a, tax :datatex3a ,fee :dataf3a},{y:data4a, tax :datatex4a,fee :dataf4a},{y:data5a, tax :datatex5a ,fee :dataf5a},{y:data6a, tax :datatex6a, fee :dataf6a},{y:data7a, tax :datatex7a ,fee :dataf7a},{y:data8a, tax :datatex8a ,fee :dataf8a},{y:data9a, tax :datatex9a ,fee :dataf9a},{y:data10a, tax :datatex10a ,fee :dataf10a},{y:data11a, tax :datatex11a ,fee :dataf11a},{y:data12a, tax :datatex12a ,fee :dataf12a}]
        },{
            name: 'Gross Sales- Yesterday',
            type: "column",
            color: '#1956a6',
            // showInLegend: false,
            data: [{y:data1a, tax :datatex1a   ,fee :dataf1a}, {y:data2a, tax :datatex2a ,fee :dataf2a},{y:data3a, tax :datatex3a ,fee :dataf3a},{y:data4a, tax :datatex4a,fee :dataf4a},{y:data5a, tax :datatex5a ,fee :dataf5a},{y:data6a, tax :datatex6a, fee :dataf6a},{y:data7a, tax :datatex7a ,fee :dataf7a},{y:data8a, tax :datatex8a ,fee :dataf8a},{y:data9a, tax :datatex9a ,fee :dataf9a},{y:data10a, tax :datatex10a ,fee :dataf10a},{y:data11a, tax :datatex11a ,fee :dataf11a},{y:data12a, tax :datatex12a ,fee :dataf12a}]
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
            data: [{y:Sunday, tax :Sunday_tax,fee :Sunday_fee}, {y:Monday, tax :Monday_tax,fee :Monday_fee},{y:Tuesday, tax :Tuesday_tax,fee :Tuesday_fee},{y:Wednesday, tax :Wednesday_tax,fee :Wednesday_fee},{y:Thursday, tax :Thursday_tax,fee :Thursday_fee},{y:Friday, tax :Friday_tax,fee :Friday_fee},{y:Satuday, tax :Satuday_tax,fee :Satuday_fee}]
        },{
            name: 'Last Week',
            type: "column",
            color: '#1956a6',
            // showInLegend: false,
            data: [{y:Sunday_l, tax :Sunday_l_tax,fee :Sunday_l_fee}, {y:Monday_l, tax :Monday_l_tax,fee :Monday_l_fee},{y:Tuesday_l, tax :Tuesday_l_tax,fee :Tuesday_l_fee},{y:Wednesday_l, tax :Wednesday_l_tax,fee :Wednesday_l_fee},{y:Thursday_l, tax :Thursday_l_tax,fee :Thursday_l_fee},{y:Friday_l, tax :Friday_l_tax,fee :Friday_l_fee},{y:Satuday_l, tax :Satuday_l_tax,fee :Satuday_l_fee}]
        }]
    });

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
            data: [{y:datab1, tax :datatex1b, fee :dataf1b}, {y:datab2, tax :datatex2b, fee :dataf2b},{y:datab3, tax :datatex3b, fee :dataf3b},{y:datab4, tax :datatex4b, fee :dataf4b},{y:datab5, tax :datatex5b, fee :dataf5b},{y:datab6, tax :datatex6b, fee :dataf6b},{y:datab7, tax :datatex7b, fee :dataf7b},{y:datab8, tax :datatex8b, fee :dataf8b},{y:datab9, tax :datatex9b, fee :dataf9b},{y:datab10, tax :datatex10b, fee :dataf10b},{y:datab11n, tax :datatex11b, fee :dataf11b},{y:datab12, tax :datatex12b, fee :dataf12b}]
        }]
    });
};
</script>
<?php include_once'footer_dash.php'; ?>