<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SaleQuick</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
        <style>
            body {
                font-family: 'Open Sans', sans-serif !important;
                width: 100% !important;
                height: 80vh !important;
            }

            td,
            th {
                vertical-align: top !important;
                text-align: left !important;
            }

            a {
                text-decoration: none !important;
            }

            .invoice-wrap {
                width: 575px;
                max-width: 575px;
            }

            @media only screen and (max-width:820px) {
                .footer-wraper>div>div {
                    float: none !important;
                }

                .footer_t_c {
                    padding-bottom: 7px !important;
                }
            }

            @media only screen and (min-width:481px) and (max-width:768px) {
                .top-div {
                    padding: 20px 20px !important;
                }
            }            

            @media only screen and (max-width:480px) {
                .top-div {
                    padding: 20px 20px !important;
                }

            }

            @media screen and (max-width: 640px) {
                .footer_t_c {
                    font-size: 12px !important;
                }
            }

            @media screen and (max-width: 640px) {
                p {
                    margin: 0px;
                }
            }
            .btn.btn-first {
                font-size: 16px;
                background: rgb(0, 166, 255);
                -webkit-transition: all 0.3s ease 0s;
                -o-transition: all 0.3s ease 0s;
                transition: all 0.3s ease 0s;
                border: 1px solid #2273dc;
                color: #fff;
                padding: 7px 15px;
            }
            @media screen and (max-width: 640px) {
                .btn.btn-first {
                    font-size: 13px;
                }
            }
            .btn.btn-first:hover, .btn.btn-first:focus {
                outline: none;
                -webkit-box-shadow: 0 0;
                box-shadow: 0 0;
                background-image: none;
                background-color: transparent !important;
                border: 1px solid #2273dc !important;
                color: #1369d9 !important;
            }
            .btn {
                display: inline-block;
                padding: 6px 12px;
                margin-bottom: 0;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                -ms-touch-action: manipulation;
                touch-action: manipulation;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-image: none;
                border: 1px solid transparent;
                border-radius: 4px;
            }
        </style>
    </head>

    <body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;position: relative;background-color: #2273dc !important;">
        <div style="text-align: center;">
            <img src="https://salequick.com/front/images/logo-w.png" alt="Salequick" style="width: 220px;margin-bottom: 30px;margin-top: 50px;">
        </div>
        <div class="main-box" style="width: 100%;height: 100%;display: inline-block;">
            <div class="invoice-wrap" style="position:relative;margin: 0 auto;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">

                <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;display: inline-block;width: 100%;padding: 20px 20px;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;text-align: center;">

                    <!-- <p><img src="https://salequick.com/assets/img/rec_setup.png" style="width: 110px;"></p> -->
                    <p><img src="https://salequick.com/assets/img/rec_setup.png" style="width: 150px;border-radius: 50%;"></p>

                    <!-- <p style="font-size: 15px !important;color: #666;margin-top: 5px !important;">Hi <strong>Andrew,</strong></p> -->

                    <p style="font-weight: 600;color: #666;font-size: 20px !important;">Your card on file for <strong><?= $msgData['getEmail1'][0]['business_dba_name']; ?></strong> has been declined. Please update payment information.</p>

                    <p><a href="<?php echo base_url(''); ?>add_card/<?= $msgData['getEmail'][0]['id']; ?>/<?= $msgData['getEmail'][0]['merchant_id']; ?>/<?= $msgData['getEmail'][0]['invoice_no']; ?>" class="btn btn-first" style="width: 200px;border-radius: 20px;">ADD NEW CARD</a></p>
                </div>
            </div>

            <div class="footer-wraper" style="float: left; width:100%;display:inline-block;text-align:center;clear: both;max-width: 100%;">
                <div style="max-width: 1000px;padding: 0;text-align: center;font-size: 14px;width: 100%;clear: both;margin: 20px auto 0;display: block;">

                    <div class="footer_t_c" style="width:100%;display:inline-block;text-align:center;vertical-align: middle;padding-top: 7px;color:#fff;">
                        © SaleQuick 2022 | All rights reserved
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>