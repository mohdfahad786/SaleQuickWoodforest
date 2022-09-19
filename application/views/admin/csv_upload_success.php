<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    p {
        font-size: 13px;
        color: #878787;
        line-height: 30px;
        margin: 4px 0px;
    }
    .invoice-wrap {
        display: table;
        max-width: 972px;
        width: 100%;
        margin: 10px auto 0;
        border-radius: 10px;
        -webkit-box-shadow: rgba(102, 102, 102, 0.09) 0px 0 20px;
        -moz-box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;
        box-shadow: rgba(102, 102, 102, 0.09) 0 0 20px;
    }
    .main-box {
        width: 100%;
        height: 100%;
        padding: 0 15px;
        float: left;
        max-width: 100%;
        clear: both;
    }
    .top-div {
        border-radius: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        background: #fff;
        display: inline-block;
        width: 100%;
        float: left;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        padding: 40px;
    }
    .float-left {
        float: left;
        text-align: left
    }
    .float-right {
        float: right;
        text-align: right
    }
    .alert.alert-success{
          color: #7CB342;
    }
    .onlyMessageSection{
      padding: 21px 0;
      clear: both;
      width: 100%;
      text-align: center;
      min-height: 201px;
      font-weight: 600;
    }
    .svgAlertWraper{
      margin: 0 auto;
      width: 170px !important;
    }
    .alert.alert-danger,.text-danger {
        color: #FF6245;
        text-transform: capitalize;
    }
    .onlyMessageSection span.text-success,.onlyMessageSection span.text-danger {
        font-size: 21px;
        font-weight: 600;
        display: block;
        margin-bottom: 21px;
    }
    @media only screen and (min-width:481px) and (max-width:768px) {
        .top-div {
            padding: 20px 20px;
        }
    }
    @media only screen and (max-width:480px) {
        .float-right {
            text-align: center;
            width: 100%;
        }
        .float-left {
            text-align: center;
            width: 100%;
        }
        .top-div {
            padding: 20px 20px;
        }
    }
    @media screen and (max-width: 600px) {
        .onlyMessageSection{
          min-height: 101px
        }
    }
    .btn-link {
        background: none!important;
        border: none;
        padding: 0!important;
        font-family: arial, sans-serif;
        color: #B9B9B9;
        text-decoration: underline;
        cursor: pointer;
        margin-bottom: 10px;
        font-weight: 600;
        font-size: 15px;
    }
    .success_text {
        font-family: AvenirNext-Medium !important;
        margin: 20px 0;
        font-size: 20px !important;
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
            <div class="row">
                <div class="col-12 py-5-custom"></div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin: auto;">
                    <div class="main-box">
                        <div class="invoice-wrap">
                            <div class="top-div">
                                <div class="onlyMessageSection">
                                    <div class="svgAlertWraper"> 
                                        <img src="<?php echo base_url('new_assets/img/big_tick.png'); ?>">
                                    </div>
                                    <h2 class="success_text" style="color: #28a745 !important"><?php echo $this->session->flashdata('success_new1'); ?></h2>
                                    <!-- <h2 class="success_text" style="color: #28a745 !important">Book121.csv Uploaded Successfully</h2> -->
                                    <a class="btn-link" href="<?php echo base_url('users'); ?>" style="font-family: AvenirNext-Medium !important;">Back to CSV Upload</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // console.log('11');
        $.ajax({
            url: '<?php echo base_url('users/get_update_revenue'); ?>',
            type: 'get',
            success: function(data) {
                console.log(data);
            }
        });
    })
</script>

<?php include_once'footer_dash.php'; ?>