<?php
    error_reporting(0);
    @ob_start();
    session_start();
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
</style>

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
                <div class="col-12 py-5-custom"></div>
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
                                                    <div class="row pull-right" style="margin-right: 10px;">
                                                        <div class="custom-chart-label">
                                                            <span>
                                                                <div class="rectangle"></div>
                                                                <!-- <?php echo date("M d, Y"); ?> -->
                                                                Gross Sales - Today
                                                            </span>
                                                        </div>
                                                        <div class="custom-chart-label year_chart_margin_right">
                                                            <span>
                                                                <div class="rectangle-darked"></div>
                                                                <!-- <?php echo date("M d, Y",strtotime("-1 days")); ?> -->
                                                                Gross Sales - Yesterday
                                                            </span>
                                                        </div>
                                                    </div>
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
                                                    <div class="row pull-right" style="margin-right: 10px;">
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
                                                    </div>
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
                                                    <div class="row pull-right" style="margin-right: 10px;">
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
                                                    </div>
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
    </div>
</div>

<script type="text/javascript">
    function setNullOrZero(i,vals) {
        if(moment().format('HH') < i) {
            //set null
            vals = isNaN(vals) ? null : ( ((vals == null) || (vals == 'null')) ? 0 : parseFloat(vals) );
        } else {
            //set zero future
            vals = isNaN(vals) ? 0 : ( ((vals == null) || (vals == 'null')) ? 0 : parseFloat(vals) );
        }
        return vals;
    }

    function setNullOrZeroByDay(day,vals) {
        var dayArray = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        var currDay = moment().format('ddd');
        var currIndex = dayArray.indexOf(currDay);
        var checkIndex = dayArray.indexOf(day);
        if(currIndex < checkIndex) {
          vals = isNaN(vals)? null : (vals ==null? null: parseFloat(vals));
        } else {
          vals = isNaN(vals)? 0 : (vals ==null? 0: parseFloat(vals));
        }
        return vals;
    }

    function setNullOrZeroByYear(month,vals){
        var mnthArray=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var currMnth=moment().format('MMM');
        var currIndex=mnthArray.indexOf(currMnth);
        var checkIndex=mnthArray.indexOf(month);
        if(currIndex < checkIndex) {
            vals =isNaN(vals)? null : (vals ==null? null: parseFloat(vals));
        } else {
            vals =isNaN(vals)? 0 : (vals ==null? 0: parseFloat(vals));
        }
        return vals;
    }

    $(document).ready(function() {
        $.ajax({
            type    : 'POST',
            url     : "<?= base_url('Graph/dailyGrossData'); ?>",
            data    : {'graph' : '1'},
            success : function (data){
                var data = JSON.parse(data);
                // console.log(data);return false;
                var dailyData = data.dailyData[0];
                dailyGrossSaleChart(dailyData);

                $.ajax({
                    type    : 'POST',
                    url     : "<?= base_url('Graph/weeklyGrossData'); ?>",
                    data    : {'graph' : '1'},
                    success : function (data){
                        var data = JSON.parse(data);
                        // console.log(data);return false;
                        var weeklyData = data.weeklyData[0];
                        weeklyGrossSaleChart(weeklyData);
                    }
                })
            }
        })
    })

    function convertNullToZero(val) {
        val = ((val == null) || (val == 'null')) ? 0 : parseFloat(val);
        return val;
    }

    function dailyGrossSaleChart(dailyData) {
        var g1v1 =
        [
            {
                // y:setNullOrZero(0, dailyData['Total_today_0timea']) , 
                y:  setNullOrZero(dailyData['Total_today_0timea']), 
                tax : setNullOrZero(dailyData['Total_today_0timetax']),
                avg : setNullOrZero(dailyData['Total_today_0timefee'])
            },
            {
                y: setNullOrZero(dailyData['Total_today_1timea']), 
                tax : setNullOrZero(dailyData['Total_today_1timetax']),
                avg : setNullOrZero(dailyData['Total_today_1timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_2timea']), 
                tax : setNullOrZero(dailyData['Total_today_2timetax']),
                avg : setNullOrZero(dailyData['Total_today_2timefee'])
            },  
            {
                y: setNullOrZero(dailyData['Total_today_3timea']), 
                tax : setNullOrZero(dailyData['Total_today_3timetax']),
                avg : setNullOrZero(dailyData['Total_today_3timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_4timea']), 
                tax : setNullOrZero(dailyData['Total_today_4timetax']),
                avg : setNullOrZero(dailyData['Total_today_4timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_5timea']), 
                tax : setNullOrZero(dailyData['Total_today_5timetax']),
                avg : setNullOrZero(dailyData['Total_today_5timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_6timea']), 
                tax : setNullOrZero(dailyData['Total_today_6timetax']),
                avg : setNullOrZero(dailyData['Total_today_6timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_7timea']), 
                tax : setNullOrZero(dailyData['Total_today_7timetax']),
                avg : setNullOrZero(dailyData['Total_today_7timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_8timea']), 
                tax : setNullOrZero(dailyData['Total_today_8timetax']),
                avg : setNullOrZero(dailyData['Total_today_8timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_9timea']), 
                tax : setNullOrZero(dailyData['Total_today_9timetax']),
                avg : setNullOrZero(dailyData['Total_today_9timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_10timea']), 
                tax : setNullOrZero(dailyData['Total_today_10timetax']),
                avg : setNullOrZero(dailyData['Total_today_10timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_11timea']), 
                tax : setNullOrZero(dailyData['Total_today_11timetax']),
                avg : setNullOrZero(dailyData['Total_today_11timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_12timea']), 
                tax : setNullOrZero(dailyData['Total_today_12timetax']),
                avg : setNullOrZero(dailyData['Total_today_12timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_13timea']), 
                tax : setNullOrZero(dailyData['Total_today_13timetax']),
                avg : setNullOrZero(dailyData['Total_today_13timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_14timea']), 
                tax : setNullOrZero(dailyData['Total_today_14timetax']),
                avg : setNullOrZero(dailyData['Total_today_14timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_15timea']), 
                tax : setNullOrZero(dailyData['Total_today_15timetax']),
                avg : setNullOrZero(dailyData['Total_today_15timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_16timea']), 
                tax : setNullOrZero(dailyData['Total_today_16timetax']),
                avg : setNullOrZero(dailyData['Total_today_16timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_17timea']), 
                tax : setNullOrZero(dailyData['Total_today_17timetax']),
                avg : setNullOrZero(dailyData['Total_today_17timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_18timea']), 
                tax : setNullOrZero(dailyData['Total_today_18timetax']),
                avg : setNullOrZero(dailyData['Total_today_18timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_19timea']), 
                tax : setNullOrZero(dailyData['Total_today_19timetax']),
                avg : setNullOrZero(dailyData['Total_today_19timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_20timea']), 
                tax : setNullOrZero(dailyData['Total_today_20timetax']),
                avg : setNullOrZero(dailyData['Total_today_20timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_today_21timea']), 
                tax : setNullOrZero(dailyData['Total_today_21timetax']),
                avg : setNullOrZero(dailyData['Total_today_21timefee'])
            },  
            {
                y: setNullOrZero(dailyData['Total_today_22timea']), 
                tax : setNullOrZero(dailyData['Total_today_22timetax']),
                avg : setNullOrZero(dailyData['Total_today_22timefee'])
            },  
            {
                y: setNullOrZero(dailyData['Total_today_23timea']), 
                tax : setNullOrZero(dailyData['Total_today_23timetax']),
                avg : setNullOrZero(dailyData['Total_today_23timefee'])
            }
        ];

        var g1v2 =
        [
            {
                y: setNullOrZero(dailyData['Total_yesterday_0timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_0timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_0timefee'])
            },
            {
                y: setNullOrZero(dailyData['Total_yesterday_1timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_1timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_1timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_2timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_2timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_2timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_3timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_3timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_3timefee'])
            },  
            {
                y: setNullOrZero(dailyData['Total_yesterday_4timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_4timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_4timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_5timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_5timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_5timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_6timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_6timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_6timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_7timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_7timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_7timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_8timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_8timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_8timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_9timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_9timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_9timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_10timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_10timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_10timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_11timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_11timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_11timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_12timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_12timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_12timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_13timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_13timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_13timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_14timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_14timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_14timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_15timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_15timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_15timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_16timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_16timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_16timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_17timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_17timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_17timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_18timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_18timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_18timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_19timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_19timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_19timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_20timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_20timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_20timefee'])
            }, 
            {
                y: setNullOrZero(dailyData['Total_yesterday_21timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_21timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_21timefee'])
            },  
            {
                y: setNullOrZero(dailyData['Total_yesterday_22timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_22timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_22timefee'])
            },  
            {
                y: setNullOrZero(dailyData['Total_yesterday_23timea']), 
                tax : setNullOrZero(dailyData['Total_yesterday_23timetax']),
                avg : setNullOrZero(dailyData['Total_yesterday_23timefee'])
            }
        ];

        console.log(g1v1);
        console.log(g1v2);
        // return false;

        Highcharts.chart('dailyGrossSale', {
            chart: {
                type: 'column',
                spacingBottom: 30,
                //width: chart_width
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00', '12:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00'],
                labels: {
                    style: {
                        color: '#9b9b9b',
                        fontSize: 9
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
                // tickInterval: 5000,
                min: 0,
                labels: {
                    formatter: function() {
                        return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                    }
                },
                //min: 5000
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    // lineWidth: 4,
                    borderRadius: 8,
                    pointWidth: 20,
                    marker: {
                        // lineWidth: 3,
                        lineColor: '#ffffff',
                        symbol: 'circle'
                    }
                }
            },
            series: [
                {
                    name: 'Gross Sales- Today',
                    type: "column",
                    color: '#00a6ff',
                    // showInLegend: false,
                    data: g1v1
                },{
                    name: 'Gross Sales- Yesterday',
                    type: "column",
                    color: '#1956a6',
                    // showInLegend: false,
                    data: g1v2
                }
            ]
        });
    }

    function weeklyGrossSaleChart(weeklyData) {
        var g2v1 =
        [
            {
                y: convertNullToZero(weeklyData['Sunday']), 
                tax : convertNullToZero(weeklyData['Sunday_tax']),
                avg : convertNullToZero(weeklyData['Sunday_fee'])
            }, 
            {
                y: convertNullToZero(weeklyData['Monday']), 
                tax : convertNullToZero(weeklyData['Monday_tax']),
                avg : convertNullToZero(weeklyData['Monday_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Tuesday']), 
                tax : convertNullToZero(weeklyData['Tuesday_tax']),
                avg : convertNullToZero(weeklyData['Tuesday_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Wednesday']),
                tax : convertNullToZero(weeklyData['Wednesday_tax']),
                avg : convertNullToZero(weeklyData['Wednesday_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Thursday']), 
                tax : convertNullToZero(weeklyData['Thursday_tax']),
                avg : convertNullToZero(weeklyData['Thursday_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Friday']), 
                tax : convertNullToZero(weeklyData['Friday_tax']),
                avg : convertNullToZero(weeklyData['Friday_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Satuday']), 
                tax : convertNullToZero(weeklyData['Satuday_tax']),
                avg : convertNullToZero(weeklyData['Satuday_fee'])
            }
        ];

        var g2v2 =
        [
            {
                y: convertNullToZero(weeklyData['Sunday_l']), 
                tax : convertNullToZero(weeklyData['Sunday_l_tax']),
                avg : convertNullToZero(weeklyData['Sunday_l_fee'])
            }, 
            {
                y: convertNullToZero(weeklyData['Monday_l']), 
                tax : convertNullToZero(weeklyData['Monday_l_tax']),
                avg : convertNullToZero(weeklyData['Monday_l_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Tuesday_l']), 
                tax : convertNullToZero(weeklyData['Tuesday_l_tax']),
                avg : convertNullToZero(weeklyData['Tuesday_l_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Wednesday_l']), 
                tax : convertNullToZero(weeklyData['Wednesday_l_tax']),
                avg : convertNullToZero(weeklyData['Wednesday_l_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Thursday_l']), 
                tax : convertNullToZero(weeklyData['Thursday_l_tax']),
                avg : convertNullToZero(weeklyData['Thursday_l_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Friday_l']), 
                tax : convertNullToZero(weeklyData['Friday_l_tax']),
                avg : convertNullToZero(weeklyData['Friday_l_fee'])
            },
            {
                y: convertNullToZero(weeklyData['Satuday_l']), 
                tax : convertNullToZero(weeklyData['Satuday_l_tax']),
                avg : convertNullToZero(weeklyData['Satuday_l_fee'])
            }
        ];

        // console.log(g2v1);
        // console.log(g2v2);
        // return false;

        Highcharts.chart('weeklyGrossSale', {
            chart: {
                type: 'column',
                spacingBottom: 30,
               // width: chart_width
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
                // tickInterval: 5000,
                min: 0,
                labels: {
                    formatter: function() {
                        return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                    }
                },
                //min: 5000
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    // lineWidth: 4,
                    borderRadius: 8,
                    pointWidth: 13,
                    marker: {
                        // lineWidth: 3,
                        lineColor: '#ffffff',
                        symbol: 'circle'
                    }
                }
            },
            series: [
                {
                    name: 'Current Week',
                    type: "column",
                    color: '#00a6ff',
                    data: g2v1
                },{
                    name: 'Last Week',
                    type: "column",
                    color: '#1956a6',
                    data: g2v2
                }
            ]
        });
    }

    function saleByYear(val1,val2) {
        Highcharts.chart('yearlyGrossSale', {
            chart: {
                type: 'column',
                spacingBottom: 30,
               // width: chart_width
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
                // tickInterval: 30000,
                labels: {
                    formatter: function() {
                        return ((this.value/1000) >= 1 ? ((this.value/1000) + 'k') : (this.value));
                    }
                },
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.series.name + ': "' + this.x + '" </b><br/>' + '<span style="color: #08c08c;line-height: 3" ">Amount' + ': $' + this.y.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' </span><br/> <span style="color: #C14242;line-height: 3">' + 'Avg Transaction: $' + this.point.avg.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</span><br/><span style="color: #390390;line-height: 3">' + 'Tax: $' + this.point.tax.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</span>';
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
            series: [
                {
                    lineWidth: 4,
                    name: 'Yearly Gross Sales-'+ currentYear,
                    type: "column",
                    color: '#00a6ff',
                    // showInLegend: false,
                    data: val1
                },{
                    lineWidth: 4,
                    name: 'Yearly Gross Sales-'+ lastYear,
                    type: "column",
                    color: '#1956a6',
                    // showInLegend: false,
                    data: val2
                }
            ]
        });
    }

    jQuery(function($){
        function setNullOrZeroByYear(month,vals){
            var mnthArray=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var currMnth=moment().format('MMM');
            var currIndex=mnthArray.indexOf(currMnth);
            var checkIndex=mnthArray.indexOf(month);
            if(currIndex < checkIndex){
                vals = isNaN(vals) ? null : ( ((vals == null) || (vals == 'null')) ? 0 : parseFloat(vals) );
            } else {
                vals = isNaN(vals) ? 0 : ( ((vals == null) || (vals == 'null')) ? 0 : parseFloat(vals) );
            }
            return vals;
        }

        var data1 = setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljan'] ?>);
        var data2 = setNullOrZeroByYear('Fen',<?php echo $getSaleByYearData[0]['Totalfeb'] ?>);
        var data3 = setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarch'] ?>);
        var data4 = setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprl'] ?>);
        var data5 = setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmay'] ?>);
        var data6 = setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljune'] ?>);
        var data7 = setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljuly'] ?>);
        var data8 = setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugust'] ?>);
        var data9 = setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalsep'] ?>);
        var data10 = setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totaloct'] ?>);
        var data11 = setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnov'] ?>);
        var data12 = setNullOrZeroByYear('Dec',<?php echo  $getSaleByYearData[0]['Totaldec'] ?>);

        var dataf1 = setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljanf'] ?>);
        var dataf2 = setNullOrZeroByYear('Feb',<?php echo $getSaleByYearData[0]['Totalfebf'] ?>);
        var dataf3 = setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarchf'] ?>);
        var dataf4 = setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprlf'] ?>);
        var dataf5 = setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmayf'] ?>);
        var dataf6 = setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljunef'] ?>);
        var dataf7 = setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljulyf'] ?>);
        var dataf8 = setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugustf'] ?>);
        var dataf9 = setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalsepf'] ?>);
        var dataf10 = setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totaloctf'] ?>);
        var dataf11 = setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnovf'] ?>);
        var dataf12 = setNullOrZeroByYear('Dec',<?php echo  $getSaleByYearData[0]['Totaldecf'] ?>);
        var datatex1 = setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljantax'] ?>);
        var datatex2 = setNullOrZeroByYear('Feb',<?php echo $getSaleByYearData[0]['Totalfebtax'] ?>);
        var datatex3 = setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarchtax'] ?>);
        var datatex4 = setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprltax'] ?>);
        var datatex5 = setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmaytax'] ?>);
        var datatex6 = setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljunetax'] ?>);
        var datatex7 = setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljulytax'] ?>);
        var datatex8 = setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugusttax'] ?>);
        var datatex9 = setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalseptax'] ?>);
        var datatex10 = setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totalocttax'] ?>);
        var datatex11 = setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnovtax'] ?>);
        var datatex12 = setNullOrZeroByYear('Dec',<?php echo $getSaleByYearData[0]['Totaldectax'] ?>);


        
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
        var dataf11b = <?php echo $getSaleByYearData[0]['Totalbnovf'] ?  $getSaleByYearData[0]['Totalbnovf'] :'0'."" ?>  ;
        var dataf12b = <?php echo  $getSaleByYearData[0]['Totalbdecf'] ?  $getSaleByYearData[0]['Totalbdecf'] :'0'."" ?> ;
        var datatex1b = <?php echo $getSaleByYearData[0]['Totalbjantax'] ?  $getSaleByYearData[0]['Totalbjantax'] :'0'."" ?>;
        var datatex2b = <?php echo $getSaleByYearData[0]['Totalbfebtax'] ?  $getSaleByYearData[0]['Totalbfebtax'] :'0'.""; ?>;
        var datatex3b = <?php echo $getSaleByYearData[0]['Totalbmarchtax'] ?  $getSaleByYearData[0]['Totalbmarchtax'] :'0'."" ?>;
        var datatex4b = <?php echo $getSaleByYearData[0]['Totalbaprltax'] ?  $getSaleByYearData[0]['Totalbaprltax'] :'0'."" ?>;
        var datatex5b = <?php echo $getSaleByYearData[0]['Totalbmaytax'] ?  $getSaleByYearData[0]['Totalbmaytax'] :'0'."" ?>;
        var datatex6b = <?php echo $getSaleByYearData[0]['Totalbjunetax'] ?  $getSaleByYearData[0]['Totalbjunetax'] :'0'."" ?>;
        var datatex7b = <?php echo $getSaleByYearData[0]['Totalbjulytax'] ?  $getSaleByYearData[0]['Totalbjulytax'] :'0'."" ?>;
        var datatex8b = <?php echo $getSaleByYearData[0]['Totalbaugusttax'] ?  $getSaleByYearData[0]['Totalbaugusttax'] :'0'."" ?>;
        var datatex9b = <?php echo $getSaleByYearData[0]['Totalseptax'] ?  $getSaleByYearData[0]['Totalseptax'] :'0'."" ?>;
        var datatex10b = <?php echo $getSaleByYearData[0]['Totalbocttax'] ?  $getSaleByYearData[0]['Totalbocttax'] :'0'."" ?>;
        var datatex11b = <?php echo $getSaleByYearData[0]['Totalbnovtax'] ?  $getSaleByYearData[0]['Totalbnovtax'] :'0'."" ?>;
        var datatex12b = <?php echo $getSaleByYearData[0]['Totalbdectax'] ?  $getSaleByYearData[0]['Totalbdectax'] :'0'."" ?>;
        var dataSaleByYearVals1=[{y:data1, tax :datatex1 , avg :dataf1}, {y:data2, tax :datatex2 , avg :dataf2},{y:data3, tax :datatex3 , avg :dataf3},{y:data4, tax :datatex4 , avg :dataf4},{y:data5, tax :datatex5 , avg :dataf5},{y:data6, tax :datatex6 , avg :dataf6},{y:data7, tax :datatex7 , avg :dataf7},{y:data8, tax :datatex8 , avg :dataf8},{y:data9, tax :datatex9 , avg :dataf9},{y:data10, tax :datatex10 , avg :dataf10},{y:data11, tax :datatex11 , avg :dataf11},{y:data12, tax :datatex12 , avg :dataf12}];
        var dataSaleByYearVals2=[{y:datab1, tax :datatex1b, avg :dataf1b}, {y:datab2, tax :datatex2b, avg :dataf2b},{y:datab3, tax :datatex3b, avg :dataf3b},{y:datab4, tax :datatex4b, avg :dataf4b},{y:datab5, tax :datatex5b, avg :dataf5b},{y:datab6, tax :datatex6b, avg :dataf6b},{y:datab7, tax :datatex7b, avg :dataf7b},{y:datab8, tax :datatex8b, avg :dataf8b},{y:datab9, tax :datatex9b, avg :dataf9b},{y:datab10, tax :datatex10b, avg :dataf10b},{y:datab11, tax :datatex11b, avg :dataf11b},{y:datab12, tax :datatex12b, avg :dataf12b}];
        // console.log(dataSaleByYearVals1)
        // console.log(dataSaleByYearVals2)
        saleByYear(dataSaleByYearVals1,dataSaleByYearVals2);
    })
</script>

<?php include_once'footer_dash.php'; ?>
