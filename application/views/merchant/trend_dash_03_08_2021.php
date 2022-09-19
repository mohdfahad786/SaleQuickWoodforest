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
<!-- End Page Content -->
<script type="text/javascript">
    function setNullOrZero(i,vals) {
        if(moment().format('HH') < i) {
            //set null
            vals = isNaN(vals)? null : (vals ==null? null: parseFloat(vals));
        } else {
            //set zero future
            vals = isNaN(vals)? 0 : (vals ==null? 0: parseFloat(vals));
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

    function dailyGrossSaleChart(val1,val2) {
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
                    data: val1
                },{
                    name: 'Gross Sales- Yesterday',
                    type: "column",
                    color: '#1956a6',
                    // showInLegend: false,
                    data: val2
                }
            ]
        });
    }

    function weeklyGrossSaleChart(val1,val2) {
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
            /*responsive: {
                rules: [{
                    condition: {
                        maxWidth: 1500
                    },
                    chartOptions: {
                        yAxis: {
                            labels: {
                                align: 'center'
                            }
                        }
                    }
                }]
            },*/
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
                    // lineWidth: 2,
                    name: 'Current Week',
                    type: "column",
                    color: '#00a6ff',
                    // showInLegend: false,
                    data: val1
                },{
                    // lineWidth: 2,
                    name: 'Last Week',
                    type: "column",
                    color: '#1956a6',
                    // showInLegend: false,
                    data: val2
                }
            ]
        });
    }

    function yearlyGrossSaleChart(val1,val2) {
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
            /*responsive: {
                rules: [{
                    condition: {
                        maxWidth: 1500
                    },
                    chartOptions: {
                        yAxis: {
                            labels: {
                                align: 'center'
                            }
                        }
                    }
                }]
            },*/
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

    $(function() {
        var g1v1 =
        [
            {
                y:setNullOrZero(0,<?php echo $getDashboardData[0]['Total_today_0timea']?>) , 
                tax :setNullOrZero(0,<?php echo $getDashboardData[0]['Total_today_0timetax']?>)   ,
                avg :setNullOrZero(0,<?php echo $getDashboardData[0]['Total_today_0timefee']?>)
            },
            {
                y:setNullOrZero(1,<?php echo $getDashboardData[0]['Total_today_1timea']?>), 
                tax :setNullOrZero(1,<?php echo $getDashboardData[0]['Total_today_1timetax']?>)   ,
                avg :setNullOrZero(1,<?php echo $getDashboardData[0]['Total_today_1timefee']?>)
            }, 
            {
                y:setNullOrZero(2,<?php echo $getDashboardData[0]['Total_today_2timea']?>), 
                tax :setNullOrZero(2,<?php echo $getDashboardData[0]['Total_today_2timetax']?>)   ,
                avg :setNullOrZero(2,<?php echo $getDashboardData[0]['Total_today_2timefee']?>)
            },  
            {
                y:setNullOrZero(3,<?php echo $getDashboardData[0]['Total_today_3timea']?>), 
                tax :setNullOrZero(3,<?php echo $getDashboardData[0]['Total_today_3timetax']?>)   ,
                avg :setNullOrZero(3,<?php echo $getDashboardData[0]['Total_today_3timefee']?>)
            }, 
            {
                y:setNullOrZero(4,<?php echo $getDashboardData[0]['Total_today_4timea']?>), 
                tax :setNullOrZero(4,<?php echo $getDashboardData[0]['Total_today_4timetax']?>)   ,
                avg :setNullOrZero(4,<?php echo $getDashboardData[0]['Total_today_4timefee']?>)
            }, 
            {
                y:setNullOrZero(5,<?php echo $getDashboardData[0]['Total_today_5timea']?>), 
                tax :setNullOrZero(5,<?php echo $getDashboardData[0]['Total_today_5timetax']?>)   ,
                avg :setNullOrZero(5,<?php echo $getDashboardData[0]['Total_today_5timefee']?>)
            }, 
            {
                y:setNullOrZero(6,<?php echo $getDashboardData[0]['Total_today_6timea']?>), 
                tax :setNullOrZero(6,<?php echo $getDashboardData[0]['Total_today_6timetax']?>)   ,
                avg :setNullOrZero(6,<?php echo $getDashboardData[0]['Total_today_6timefee']?>)
            }, 
            {
                y:setNullOrZero(7,<?php echo $getDashboardData[0]['Total_today_7timea']?>), 
                tax :setNullOrZero(7,<?php echo $getDashboardData[0]['Total_today_7timetax']?>)   ,
                avg :setNullOrZero(7,<?php echo $getDashboardData[0]['Total_today_7timefee']?>)
            }, 
            {
                y:setNullOrZero(8,<?php echo $getDashboardData[0]['Total_today_8timea']?>), 
                tax :setNullOrZero(8,<?php echo $getDashboardData[0]['Total_today_8timetax']?>)   ,
                avg :setNullOrZero(8,<?php echo $getDashboardData[0]['Total_today_8timefee']?>)
            }, 
            {
                y:setNullOrZero(9,<?php echo $getDashboardData[0]['Total_today_9timea']?>), 
                tax :setNullOrZero(9,<?php echo $getDashboardData[0]['Total_today_9timetax']?>)   ,
                avg :setNullOrZero(9,<?php echo $getDashboardData[0]['Total_today_9timefee']?>)
            }, 
            {
                y:setNullOrZero(10,<?php echo $getDashboardData[0]['Total_today_10timea']?>), 
                tax :setNullOrZero(10,<?php echo $getDashboardData[0]['Total_today_10timetax']?>)   ,
                avg :setNullOrZero(10,<?php echo $getDashboardData[0]['Total_today_10timefee']?>)
            }, 
            {
                y:setNullOrZero(11,<?php echo $getDashboardData[0]['Total_today_11timea']?>), 
                tax :setNullOrZero(11,<?php echo $getDashboardData[0]['Total_today_11timetax']?>)   ,
                avg :setNullOrZero(11,<?php echo $getDashboardData[0]['Total_today_11timefee']?>)
            }, 
            {
                y:setNullOrZero(12,<?php echo $getDashboardData[0]['Total_today_12timea']?>), 
                tax :setNullOrZero(12,<?php echo $getDashboardData[0]['Total_today_12timetax']?>)   ,
                avg :setNullOrZero(12,<?php echo $getDashboardData[0]['Total_today_12timefee']?>)
            }, 
            {
                y:setNullOrZero(13,<?php echo $getDashboardData[0]['Total_today_13timea']?>), 
                tax :setNullOrZero(13,<?php echo $getDashboardData[0]['Total_today_13timetax']?>)   ,
                avg :setNullOrZero(13,<?php echo $getDashboardData[0]['Total_today_13timefee']?>)
            }, 
            {
                y:setNullOrZero(14,<?php echo $getDashboardData[0]['Total_today_14timea']?>), 
                tax :setNullOrZero(14,<?php echo $getDashboardData[0]['Total_today_14timetax']?>)   ,
                avg :setNullOrZero(14,<?php echo $getDashboardData[0]['Total_today_14timefee']?>)
            }, 
            {
                y:setNullOrZero(15,<?php echo $getDashboardData[0]['Total_today_15timea']?>), 
                tax :setNullOrZero(15,<?php echo $getDashboardData[0]['Total_today_15timetax']?>)   ,
                avg :setNullOrZero(15,<?php echo $getDashboardData[0]['Total_today_15timefee']?>)
            }, 
            {
                y:setNullOrZero(16,<?php echo $getDashboardData[0]['Total_today_16timea']?>), 
                tax :setNullOrZero(16,<?php echo $getDashboardData[0]['Total_today_16timetax']?>)   ,
                avg :setNullOrZero(16,<?php echo $getDashboardData[0]['Total_today_16timefee']?>)
            }, 
            {
                y:setNullOrZero(17,<?php echo $getDashboardData[0]['Total_today_17timea']?>), 
                tax :setNullOrZero(17,<?php echo $getDashboardData[0]['Total_today_17timetax']?>)   ,
                avg :setNullOrZero(17,<?php echo $getDashboardData[0]['Total_today_17timefee']?>)
            }, 
            {
                y:setNullOrZero(18,<?php echo $getDashboardData[0]['Total_today_18timea']?>), 
                tax :setNullOrZero(18,<?php echo $getDashboardData[0]['Total_today_18timetax']?>)   ,
                avg :setNullOrZero(18,<?php echo $getDashboardData[0]['Total_today_18timefee']?>)
            }, 
            {
                y:setNullOrZero(19,<?php echo $getDashboardData[0]['Total_today_19timea']?>), 
                tax :setNullOrZero(19,<?php echo $getDashboardData[0]['Total_today_19timetax']?>)   ,
                avg :setNullOrZero(19,<?php echo $getDashboardData[0]['Total_today_19timefee']?>)
            }, 
            {
                y:setNullOrZero(20,<?php echo $getDashboardData[0]['Total_today_20timea']?>), 
                tax :setNullOrZero(20,<?php echo $getDashboardData[0]['Total_today_20timetax']?>)   ,
                avg :setNullOrZero(20,<?php echo $getDashboardData[0]['Total_today_20timefee']?>)
            }, 
            {
                y:setNullOrZero(21,<?php echo $getDashboardData[0]['Total_today_21timea']?>), 
                tax :setNullOrZero(21,<?php echo $getDashboardData[0]['Total_today_21timetax']?>)   ,
                avg :setNullOrZero(21,<?php echo $getDashboardData[0]['Total_today_21timefee']?>)
            },  
            {
                y:setNullOrZero(22,<?php echo $getDashboardData[0]['Total_today_22timea']?>), 
                tax :setNullOrZero(22,<?php echo $getDashboardData[0]['Total_today_22timetax']?>)   ,
                avg :setNullOrZero(22,<?php echo $getDashboardData[0]['Total_today_22timefee']?>)
            },  
            {
                y:setNullOrZero(23,<?php echo $getDashboardData[0]['Total_today_23timea']?>), 
                tax :setNullOrZero(23,<?php echo $getDashboardData[0]['Total_today_23timetax']?>)   ,
                avg :setNullOrZero(23,<?php echo $getDashboardData[0]['Total_today_23timefee']?>)
            }
        ];

        var g1v2 =
        [
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_0timea'] ?  $getDashboardData[0]['Total_yesterday_0timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_0timetax'] ?  $getDashboardData[0]['Total_yesterday_0timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_0timefee'] ?  $getDashboardData[0]['Total_yesterday_0timefee'] :'0'."" ?>
            },
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_1timea'] ?  $getDashboardData[0]['Total_yesterday_1timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_1timetax'] ?  $getDashboardData[0]['Total_yesterday_1timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_1timefee'] ?  $getDashboardData[0]['Total_yesterday_1timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_2timea'] ?  $getDashboardData[0]['Total_yesterday_2timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_2timetax'] ?  $getDashboardData[0]['Total_yesterday_2timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_2timefee'] ?  $getDashboardData[0]['Total_yesterday_2timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_3timea'] ?  $getDashboardData[0]['Total_yesterday_3timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_3timetax'] ?  $getDashboardData[0]['Total_yesterday_3timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_3timefee'] ?  $getDashboardData[0]['Total_yesterday_3timefee'] :'0'."" ?>
            },  
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_4timea'] ?  $getDashboardData[0]['Total_yesterday_4timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_4timetax'] ?  $getDashboardData[0]['Total_yesterday_4timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_4timefee'] ?  $getDashboardData[0]['Total_yesterday_4timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_5timea'] ?  $getDashboardData[0]['Total_yesterday_5timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_5timetax'] ?  $getDashboardData[0]['Total_yesterday_5timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_5timefee'] ?  $getDashboardData[0]['Total_yesterday_5timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_6timea'] ?  $getDashboardData[0]['Total_yesterday_6timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_6timetax'] ?  $getDashboardData[0]['Total_yesterday_6timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_6timefee'] ?  $getDashboardData[0]['Total_yesterday_6timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_7timea'] ?  $getDashboardData[0]['Total_yesterday_7timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_7timetax'] ?  $getDashboardData[0]['Total_yesterday_7timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_7timefee'] ?  $getDashboardData[0]['Total_yesterday_7timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_8timea'] ?  $getDashboardData[0]['Total_yesterday_8timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_8timetax'] ?  $getDashboardData[0]['Total_yesterday_8timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_8timefee'] ?  $getDashboardData[0]['Total_yesterday_8timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_9timea'] ?  $getDashboardData[0]['Total_yesterday_9timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_9timetax'] ?  $getDashboardData[0]['Total_yesterday_9timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_9timefee'] ?  $getDashboardData[0]['Total_yesterday_9timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_10timea'] ?  $getDashboardData[0]['Total_yesterday_10timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_10timetax'] ?  $getDashboardData[0]['Total_yesterday_10timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_10timefee'] ?  $getDashboardData[0]['Total_yesterday_10timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_11timea'] ?  $getDashboardData[0]['Total_yesterday_11timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_11timetax'] ?  $getDashboardData[0]['Total_yesterday_11timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_11timefee'] ?  $getDashboardData[0]['Total_yesterday_11timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_12timea'] ?  $getDashboardData[0]['Total_yesterday_12timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_12timetax'] ?  $getDashboardData[0]['Total_yesterday_12timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_12timefee'] ?  $getDashboardData[0]['Total_yesterday_12timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_13timea'] ?  $getDashboardData[0]['Total_yesterday_13timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_13timetax'] ?  $getDashboardData[0]['Total_yesterday_13timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_13timefee'] ?  $getDashboardData[0]['Total_yesterday_13timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_14timea'] ?  $getDashboardData[0]['Total_yesterday_14timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_14timetax'] ?  $getDashboardData[0]['Total_yesterday_14timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_14timefee'] ?  $getDashboardData[0]['Total_yesterday_14timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_15timea'] ?  $getDashboardData[0]['Total_yesterday_15timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_15timetax'] ?  $getDashboardData[0]['Total_yesterday_15timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_15timefee'] ?  $getDashboardData[0]['Total_yesterday_15timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_16timea'] ?  $getDashboardData[0]['Total_yesterday_16timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_16timetax'] ?  $getDashboardData[0]['Total_yesterday_16timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_16timefee'] ?  $getDashboardData[0]['Total_yesterday_16timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_17timea'] ?  $getDashboardData[0]['Total_yesterday_17timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_17timetax'] ?  $getDashboardData[0]['Total_yesterday_17timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_17timefee'] ?  $getDashboardData[0]['Total_yesterday_17timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_18timea'] ?  $getDashboardData[0]['Total_yesterday_18timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_18timetax'] ?  $getDashboardData[0]['Total_yesterday_18timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_18timefee'] ?  $getDashboardData[0]['Total_yesterday_18timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_19timea'] ?  $getDashboardData[0]['Total_yesterday_19timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_19timetax'] ?  $getDashboardData[0]['Total_yesterday_19timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_19timefee'] ?  $getDashboardData[0]['Total_yesterday_19timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_20timea'] ?  $getDashboardData[0]['Total_yesterday_20timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_20timetax'] ?  $getDashboardData[0]['Total_yesterday_20timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_20timefee'] ?  $getDashboardData[0]['Total_yesterday_20timefee'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_21timea'] ?  $getDashboardData[0]['Total_yesterday_21timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_21timetax'] ?  $getDashboardData[0]['Total_yesterday_21timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_21timefee'] ?  $getDashboardData[0]['Total_yesterday_21timefee'] :'0'."" ?>
            },  
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_22timea'] ?  $getDashboardData[0]['Total_yesterday_22timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_22timetax'] ?  $getDashboardData[0]['Total_yesterday_22timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_22timefee'] ?  $getDashboardData[0]['Total_yesterday_22timefee'] :'0'."" ?>
            },  
            {
                y:<?php echo $getDashboardData[0]['Total_yesterday_23timea'] ?  $getDashboardData[0]['Total_yesterday_23timea'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Total_yesterday_23timetax'] ?  $getDashboardData[0]['Total_yesterday_23timetax'] :'0'."" ?>   ,
                avg :<?php echo $getDashboardData[0]['Total_yesterday_23timefee'] ?  $getDashboardData[0]['Total_yesterday_23timefee'] :'0'."" ?>
            }
        ];
        // console.log(g1v1)
        // console.log(g1v2)

        var g2v1 =
        [
            {
                y:setNullOrZeroByDay('Sun',<?php echo $getDashboardData[0]['Sunday'] ?>), 
                tax :setNullOrZeroByDay('Sun',<?php echo $getDashboardData[0]['Sunday_tax'] ?>),
                avg :setNullOrZeroByDay('Sun',<?php echo $getDashboardData[0]['Sunday_fee'] ?>)
            }, 
            {
                y:setNullOrZeroByDay('Mon',<?php echo $getDashboardData[0]['Monday']?>), 
                tax :setNullOrZeroByDay('Mon',<?php echo $getDashboardData[0]['Monday_tax']?>),
                avg :setNullOrZeroByDay('Mon',<?php echo $getDashboardData[0]['Monday_fee']?>)
            },
            {
                y:setNullOrZeroByDay('Tue',<?php echo $getDashboardData[0]['Tuesday']?>), 
                tax :setNullOrZeroByDay('Tue',<?php echo $getDashboardData[0]['Tuesday_tax']?>),
                avg :setNullOrZeroByDay('Tue',<?php echo $getDashboardData[0]['Tuesday_fee']?>)
            },
            {
                y:setNullOrZeroByDay('Wed',<?php echo $getDashboardData[0]['Wednesday']?>), 
                tax :setNullOrZeroByDay('Wed',<?php echo $getDashboardData[0]['Wednesday_tax']?>),
                avg :setNullOrZeroByDay('Wed',<?php echo $getDashboardData[0]['Wednesday_fee']?>)
            },
            {
                y:setNullOrZeroByDay('Thu',<?php echo $getDashboardData[0]['Thursday']?>), 
                tax :setNullOrZeroByDay('Thu',<?php echo $getDashboardData[0]['Thursday_tax']?>),
                avg :setNullOrZeroByDay('Thu',<?php echo $getDashboardData[0]['Thursday_fee']?>)
            },
            {
                y:setNullOrZeroByDay('Fri',<?php echo $getDashboardData[0]['Friday'] ?>), 
                tax :setNullOrZeroByDay('Fri',<?php echo $getDashboardData[0]['Friday_tax'] ?>),
                avg :setNullOrZeroByDay('Fri',<?php echo $getDashboardData[0]['Friday_fee'] ?>)
            },
            {
                y:setNullOrZeroByDay('Sat',<?php echo $getDashboardData[0]['Satuday']?>), 
                tax :setNullOrZeroByDay('Sat',<?php echo $getDashboardData[0]['Satuday_tax']?>),
                avg :setNullOrZeroByDay('Sat',<?php echo $getDashboardData[0]['Satuday_fee']?>)
            }
        ];

        var g2v2 =
        [
            {
                y:<?php echo $getDashboardData[0]['Sunday_l']  ?  $getDashboardData[0]['Sunday_l'] :'0'."" ; ?>, 
                tax :<?php echo $getDashboardData[0]['Sunday_l_tax']  ?  $getDashboardData[0]['Sunday_l_tax'] :'0'."" ; ?>,
                avg :<?php echo $getDashboardData[0]['Sunday_l_fee']  ?  $getDashboardData[0]['Sunday_l_fee'] :'0'."" ; ?>
            }, 
            {
                y:<?php echo $getDashboardData[0]['Monday_l'] ?  $getDashboardData[0]['Monday_l'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Monday_l_tax'] ?  $getDashboardData[0]['Monday_l_tax'] :'0'."" ?>,
                avg :<?php echo $getDashboardData[0]['Monday_l_fee'] ?  $getDashboardData[0]['Monday_l_fee'] :'0'."" ?>
            },
            {
                y:<?php echo $getDashboardData[0]['Tuesday_l'] ?  $getDashboardData[0]['Tuesday_l'] :'0'."" ?>, 
                tax :<?php echo $getDashboardData[0]['Tuesday_l_tax'] ?  $getDashboardData[0]['Tuesday_l_tax'] :'0'."" ?>,
                avg :<?php echo $getDashboardData[0]['Tuesday_l_fee'] ?  $getDashboardData[0]['Tuesday_l_fee'] :'0'."" ?>
            },
            {
                y:<?php echo $getDashboardData[0]['Wednesday_l'] ?  $getDashboardData[0]['Wednesday_l'] :'0'."" ; ?>, 
                tax :<?php echo $getDashboardData[0]['Wednesday_l_tax'] ?  $getDashboardData[0]['Wednesday_l_tax'] :'0'."" ; ?>,
                avg :<?php echo $getDashboardData[0]['Wednesday_l_fee'] ?  $getDashboardData[0]['Wednesday_l_fee'] :'0'."" ; ?>
            },
            {
                y:<?php echo $getDashboardData[0]['Thursday_l'] ?  $getDashboardData[0]['Thursday_l'] :'0'."" ; ?>, 
                tax :<?php echo $getDashboardData[0]['Thursday_l_tax'] ?  $getDashboardData[0]['Thursday_l_tax'] :'0'."" ; ?>,
                avg :<?php echo $getDashboardData[0]['Thursday_l_fee'] ?  $getDashboardData[0]['Thursday_l_fee'] :'0'."" ; ?>
            },
            {
                y:<?php echo $getDashboardData[0]['Friday_l']  ?  $getDashboardData[0]['Friday_l'] :'0'."" ; ?>, 
                tax :<?php echo $getDashboardData[0]['Friday_l_tax']  ?  $getDashboardData[0]['Friday_l_tax'] :'0'."" ; ?>,
                avg :<?php echo $getDashboardData[0]['Friday_l_fee']  ?  $getDashboardData[0]['Friday_l_fee'] :'0'."" ; ?>
            },
            {
                y:<?php echo $getDashboardData[0]['Satuday_l'] ?  $getDashboardData[0]['Satuday_l'] :'0'."" ; ?>, 
                tax :<?php echo $getDashboardData[0]['Satuday_l_tax'] ?  $getDashboardData[0]['Satuday_l_tax'] :'0'."" ; ?>,
                avg :<?php echo $getDashboardData[0]['Satuday_l_fee'] ?  $getDashboardData[0]['Satuday_l_fee'] :'0'."" ; ?>
            }
        ]; 
     
        var g3v1 =
        [
            {
                y:setNullOrZeroByYear('Jan',<?php echo  $getSaleByYearData[0]['Totaljan'] ?>), 
                tax :setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljantax'] ?>) , 
                avg :setNullOrZeroByYear('Jan',<?php echo $getSaleByYearData[0]['Totaljanf'] ?>)
            }, 
            {
                y:setNullOrZeroByYear('Feb',<?php echo  $getSaleByYearData[0]['Totalfeb'] ?>), 
                tax :setNullOrZeroByYear('Feb',<?php echo $getSaleByYearData[0]['Totalfebtax'] ?>) , 
                avg :setNullOrZeroByYear('Feb',<?php echo $getSaleByYearData[0]['Totalfebf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Mar',<?php echo  $getSaleByYearData[0]['Totalmarch'] ?>), 
                tax :setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarchtax'] ?>) , 
                avg :setNullOrZeroByYear('Mar',<?php echo $getSaleByYearData[0]['Totalmarchf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Apr',<?php echo  $getSaleByYearData[0]['Totalaprl'] ?>), 
                tax :setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprltax'] ?>) , 
                avg :setNullOrZeroByYear('Apr',<?php echo $getSaleByYearData[0]['Totalaprlf'] ?>)
            },
            {
                y:setNullOrZeroByYear('May',<?php echo  $getSaleByYearData[0]['Totalmay'] ?>), 
                tax :setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmaytax'] ?>) , 
                avg :setNullOrZeroByYear('May',<?php echo $getSaleByYearData[0]['Totalmayf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Jun',<?php echo  $getSaleByYearData[0]['Totaljune'] ?>), 
                tax :setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljunetax'] ?>) , 
                avg :setNullOrZeroByYear('Jun',<?php echo $getSaleByYearData[0]['Totaljunef'] ?>)
            },
            {
                y:setNullOrZeroByYear('Jul',<?php echo  $getSaleByYearData[0]['Totaljuly'] ?>), 
                tax :setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljulytax'] ?>) , 
                avg :setNullOrZeroByYear('Jul',<?php echo $getSaleByYearData[0]['Totaljulyf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Aug',<?php echo  $getSaleByYearData[0]['Totalaugust'] ?>), 
                tax :setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugusttax'] ?>) , 
                avg :setNullOrZeroByYear('Aug',<?php echo $getSaleByYearData[0]['Totalaugustf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Sep',<?php echo  $getSaleByYearData[0]['Totalsep'] ?>), 
                tax :setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalseptax'] ?>) , 
                avg :setNullOrZeroByYear('Sep',<?php echo $getSaleByYearData[0]['Totalsepf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Oct',<?php echo  $getSaleByYearData[0]['Totaloct'] ?>), 
                tax :setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totalocttax'] ?>) , 
                avg :setNullOrZeroByYear('Oct',<?php echo $getSaleByYearData[0]['Totaloctf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Nov',<?php echo  $getSaleByYearData[0]['Totalnov'] ?>), 
                tax :setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnovtax'] ?>) , 
                avg :setNullOrZeroByYear('Nov',<?php echo $getSaleByYearData[0]['Totalnovf'] ?>)
            },
            {
                y:setNullOrZeroByYear('Dec',<?php echo  $getSaleByYearData[0]['Totaldec'] ?>), 
                tax :setNullOrZeroByYear('Dec',<?php echo $getSaleByYearData[0]['Totaldectax'] ?>) , 
                avg :setNullOrZeroByYear('Dec',<?php echo  $getSaleByYearData[0]['Totaldecf'] ?>)
            }
        ];

        var g3v2 =
        [
            {
                y:<?php echo $getSaleByYearData[0]['Totalbjan'] ?  $getSaleByYearData[0]['Totalbjan'] :'0'."" ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbjantax'] ?  $getSaleByYearData[0]['Totalbjantax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbjanf'] ?  $getSaleByYearData[0]['Totalbjanf'] :'0'."" ?>
            }, 
            {
                y:<?php echo $getSaleByYearData[0]['Totalbfeb'] ?  $getSaleByYearData[0]['Totalbfeb'] :'0'."" ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbfebtax'] ?  $getSaleByYearData[0]['Totalbfebtax'] :'0'.""; ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbfebf'] ?  $getSaleByYearData[0]['Totalbfebf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbmarch'] ?  $getSaleByYearData[0]['Totalbmarch'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbmarchtax'] ?  $getSaleByYearData[0]['Totalbmarchtax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbmarchf'] ?  $getSaleByYearData[0]['Totalbmarchf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbaprl'] ?  $getSaleByYearData[0]['Totalbaprl'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbaprltax'] ?  $getSaleByYearData[0]['Totalbaprltax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbaprlf'] ?  $getSaleByYearData[0]['Totalbaprlf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbmay']  ?  $getSaleByYearData[0]['Totalbmay'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbmaytax'] ?  $getSaleByYearData[0]['Totalbmaytax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbmayf'] ?  $getSaleByYearData[0]['Totalbmayf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbjune'] ?  $getSaleByYearData[0]['Totalbjune'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbjunetax'] ?  $getSaleByYearData[0]['Totalbjunetax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbjunef'] ?  $getSaleByYearData[0]['Totalbjunef'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbjuly']  ?  $getSaleByYearData[0]['Totalbjuly'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbjulytax'] ?  $getSaleByYearData[0]['Totalbjulytax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbjulyf'] ?  $getSaleByYearData[0]['Totalbjulyf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbaugust']  ?  $getSaleByYearData[0]['Totalbaugust'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbaugusttax'] ?  $getSaleByYearData[0]['Totalbaugusttax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbaugustf'] ?  $getSaleByYearData[0]['Totalbaugustf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbsep']  ?  $getSaleByYearData[0]['Totalbsep'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalseptax'] ?  $getSaleByYearData[0]['Totalseptax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbsepf'] ?  $getSaleByYearData[0]['Totalbsepf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalboct'] ?  $getSaleByYearData[0]['Totalboct'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbocttax'] ?  $getSaleByYearData[0]['Totalbocttax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalboctf'] ?  $getSaleByYearData[0]['Totalboctf'] :'0'."" ?>
            },
            {
                y:<?php echo $getSaleByYearData[0]['Totalbnov'] ?  $getSaleByYearData[0]['Totalbnov'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbnovtax'] ?  $getSaleByYearData[0]['Totalbnovtax'] :'0'."" ?>, 
                avg :<?php echo $getSaleByYearData[0]['Totalbnovf'] ?  $getSaleByYearData[0]['Totalbnovf'] :'0'."" ?>
            },
            {
                y:<?php echo ($getSaleByYearData[0]['Totalbdec']) ?  $getSaleByYearData[0]['Totalbdec'] :'0'."" ; ?>, 
                tax :<?php echo $getSaleByYearData[0]['Totalbdectax'] ?  $getSaleByYearData[0]['Totalbdectax'] :'0'."" ?>, 
                avg :<?php echo  $getSaleByYearData[0]['Totalbdecf'] ?  $getSaleByYearData[0]['Totalbdecf'] :'0'."" ?>
            }
        ];
        dailyGrossSaleChart(g1v1,g1v2);
        weeklyGrossSaleChart(g2v1,g2v2);
        yearlyGrossSaleChart(g3v1,g3v2);
    })
</script>

<?php include_once'footer_dash.php'; ?>
