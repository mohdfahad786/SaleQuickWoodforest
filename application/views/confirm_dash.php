<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="">
        <link rel="shortcut icon" href="https://salequick.com/merchant-panel/assets/images/favicon_1.ico">
        <title>SaleQuick | Email Verified</title>
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">
        <link href="<?php echo base_url('new_assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('new_assets/css/style.css'); ?>">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://salequick.com/merchant-panel/assets/js/modernizr.min.js"></script>
    </head>
    <body class="fixed-left">
        <style type="text/css">
            body {
                font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif !important
            }
            .log-reg-box-inner.custom-stepper-form {
                max-width: 650px !important;
            }
            .steps-wrapper .steptitle-msg {
                font-size: 16px;
                font-weight: 500;
            }
            .dobWrapper__activateAcc .select2-container--default .select2-selection--single {
                border: 1px solid rgba(0,0,0,.15) !important;
            }
            .steps-wrapper {
                background: #f8f8f8;
                padding: 45px 30px;
                border-radius: 5px;
                box-shadow: 0px 0px 10px 6px rgb(20,20,50,.3);
            }
            .steps-wrapper .fifth-step:not(.active){
              display: none;
            }
            @media only screen and (max-width: 359px){
              #wrapper .custom-form.sign-up-form {
                padding: 15px 0;
              }
            }
            .btn-primary {
                padding: 10px 25px;
                color: #fff !important;
            }
            .btn-primary:hover {
                background-color: #fff !important;
                color: #007bff !important;
            }
            .alert-success {
                background-color: transparent !important;
                border: none !important;
            }
        </style>

        <div id="wrapper">
            <div class="outer-page-wrapper main-stepper-form">
                <div class="login-register dobWrapper__activateAcc">
                    <div class="log-reg-box-inner custom-stepper-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="logo-wrapper-outer clearfix">
                                    <a href="<?php echo base_url(); ?>" class="logo-wrapper no-ajax">
                                    <img src="<?php echo base_url('front/images/logo-w.png'); ?>" alt="Salequick">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="custom-form sign-up-form">
                            <div class="steps-wrapper">
                                <div class="first-step row active" data-fStep="1">
                                    <?php if($this->session->flashdata('cmsg') == 'Email Not Available') { ?>
                                        <div class="col-12 text-center">
                                            <img src="<?php echo base_url('new_assets/img/big_cross.png'); ?>" style="width: 150px;">
                                        </div>
                                        <div class="col-12 text-center">
                                            <p class="steptitle-msg text-danger"><?php echo $this->session->flashdata('cmsg'); ?></p>
                                        </div>

                                    <?php } else { ?>
                                        <div class="col-12 text-center">
                                            <img src="<?php echo base_url('new_assets/img/big_tick.png'); ?>" style="width: 150px;">
                                        </div>
                                        <div class="col-12 text-center">
                                            <p class="steptitle-msg text-success"><?php echo $this->session->flashdata('cmsg'); ?></p>
                                        </div>
                                        <div class="col-12" style="margin-top: 60px;">
                                            <div class="form-group text-center"> 
                                                <a class="btn btn-primary" href="<?php echo base_url('login'); ?>">Login Now</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- END wrapper -->
        <script>
          var resizefunc = [];
        </script>
        <!-- Plugins  -->
        <script src="<?php echo base_url('merchant-panel/assets/js/popper.min.js') ?>"></script>
        <script src="<?php echo base_url('merchant-panel/assets/js/bootstrap.min.js') ?>"></script>

        <script src="<?php echo base_url('merchant-panel/assets/js/jquery.slimscroll.js') ?>"></script>
        <script src="<?php echo base_url('new_assets/js/waves.js') ?>"></script>
    </body>
</html>