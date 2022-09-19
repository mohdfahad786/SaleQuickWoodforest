<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style type="text/css">
    #saleChart g.highcharts-series.highcharts-series-0,#saleChart  g.highcharts-series.highcharts-series-2,#saleChart  g.highcharts-markers.highcharts-series-0,#saleChart  g.highcharts-markers.highcharts-series-2,#saleChart  .highcharts-series-group >path:nth-child(1),#saleChart  .highcharts-series-group >path:nth-child(3) {
        opacity: 0;
    }
    .apexcharts-legend-marker {
        height: 10px !important;
        width: 30px !important;
    }
    .apexcharts-legend-text span {
        font-size: 22px;
    }
    .order_chart_tiles {
        width: 100%;
        display: flex;
        margin-left: 15px;
    }
    .order-left {
        width: 40px;
        height: 90px;
    }
    .order-line-color {
        height: 6px;
        width: 19px;
        border-radius: 10px;
        margin-top: 9px;
    }
    .order-right {
        width: 200px;
        height: 90px;
    }
    .order-series-name {
        font-size: 18px;
        color: rgb(148, 148, 146);
        margin-bottom: 0px !important;
        font-family: AvenirNext-Medium;
    }
    .order-series-percent {
        color: rgb(80, 93, 111);
        margin-bottom: 0px !important;
        font-size: 23px;
        font-weight: 600;
        font-family: Avenir-Heavy;
    }
    .order-series-count {
        font-size: 18px;
        color: rgb(148, 148, 146);
        font-family: AvenirNext-Medium;
    }

    @media screen and (max-width: 1220px) {
        .summary-grid-text-section {
            width: 80px;
            height: 60px;
        }
        .grid-summary {
            border-radius: 15px !important;
        }
    }
    @media screen and (min-width: 1221px) {
        .summary-grid-text-section {
            width: 110px;
            height: 52px;
        }
        .grid-summary {
            border-radius: 15px !important;
        }
    }
    @media screen and (max-width: 1349px) {
        .summary-grid-text {
            font-size: 11px !important;
        }
    }
    .summary-grid-text {
        font-family: AvenirNext-Medium !important;
        font-weight: 500;
        color: rgb(184, 184, 184);
        font-size: 12px;
    }
    .summary-grid-status {
        font-size: 18px;
        color: rgb(62, 62, 62);
        font-weight: 600;
        font-family: Avenir-Heavy !important;
        margin-bottom: 0px !important;
    }
    .summary-grid-img-section {
        width: 54px;
        height: 54px;
        margin-top: 5px;
    }
    .summary-grid-img {
        width: 54px;
        height: 54px;
    }
    .summary-transaction-count {
        width: 100%
    }
    .head-count-val {
        color: #000 !important;
        font-family: Avenir-Black;
        font-weight: 600 !important;
        font-size: 41px !important;
    }
    @media screen and (min-width: 720px) {
        .summary-grid-padding {
            padding-right: 7.5px !important;
        }
    }
    .top_grid_effect:hover {
        -webkit-box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        -moz-box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        box-shadow: rgba(102, 102, 102, 0.09) 15px 25px 15px;
        /*box-shadow: rgba(102, 102, 102, 0.09) 0 0 15px;*/
        opacity: 1;
        transition-timing-function: ease;
    }
    .top_grid_link {
        background-color: #4c6ef5;
        padding: 2px 10px;
        border-radius: 10px;
    }
    .top_grid_btn {
        background-color: #4c6ef5;
        border-radius: 10px;
        border: none !important;
        padding: 0px 10px;
    }
    .grid_text_col {
        max-width: calc(100% - 65px) !important;
        padding-right: 0px !important;
    }
    
    /*grid-summary css < 500px width*/
    @media screen and (max-width: 460px) {
        .summary-grid-img {
            width: 36px;
            height: 36px;
        }
        .summary-grid-img-section {
            width: 36px;
            height: 36px;
            margin-top: 0px;
        }
        .summary-grid-text-section {
            width: auto;
            height: 45px;
        }
        .head-count-val {
            font-family: AvenirNext-Medium;
            font-size: 30px !important;
        }
        .summary-grid-status {
            font-size: 16px;
        }
    }
    @media screen and (max-width: 400px) {
        .summary-grid-img {
            width: 28px;
            height: 28px;
        }
        .summary-grid-img-section {
            width: 28px;
            height: 28px;
            margin-top: 0px;
        }
        .summary-grid-text-section {
            width: auto;
            height: 38px;
        }
        .head-count-val {
            font-family: AvenirNext-Medium;
            font-size: 22px !important;
        }
        .summary-grid-status {
            font-size: 12px;
        }
        .summary-grid-text {
            font-size: 8px !important;
        }
        .pd-mb-lf {
            padding-left: 10px;
        }
        .reset-dataTable .dt-buttons .dt-button.buttons-collection span {
            font-size: 16px !important;
        }
        #salesChartExportDt.reset-dataTable .dt-buttons {
            margin-top: -3px;
        }
        body div.dt-button-collection button.dt-button {
            font-size: 12px !important;
            width: 80px;
        }
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <div class="wrapper">
                                <div class="d-flex justify-content-between">
                                    <div class="split-header">
                                        <div class="split-sub-header">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="h4-custom">Your Account has not been Activated</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once'footer_dash.php'; ?>