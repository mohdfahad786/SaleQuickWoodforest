<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SalesQuick</title>
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

            /*.footer-wraper>div::after,
            .footer-wraper>div::before,
            .footer-wraper::after,
            .footer-wraper:before {
                display: table !important;
                clear: both !important;
                content: "" !important;
            }*/

            /*.footer-wraper>div>div {
                margin-bottom: 11px !important;
                width: auto !important;
            }*/

            @media only screen and (max-width:820px) {
                .footer-wraper>div>div {
                    float: none !important;
                }

                .footer_t_c {
                    padding-bottom: 7px !important;
                }

                /*.footer-wraper>div {
                    margin: 20px auto 0 !important;
                }*/
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
        </style>
    </head>

    <body style="margin:0 auto;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;height: 100%;position: relative;background-color: #2273dc !important;">
        <div style="text-align: center;">
            <img src="https://salequick.com/front/images/logo-w.png" alt="Salequick" style="width: 220px;margin-bottom: 30px;margin-top: 50px;">
        </div>
        <div class="main-box" style="width: 100%;height: 100%;display: inline-block;">
            <div class="invoice-wrap" style="position:relative;margin: 0 auto;border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #fff;box-shadow: 0px -2px 17px -2px #7b7b7b;-moz-box-shadow: 0px -2px 17px -2px #7b7b7b;-webkit-box-shadow: 0px -2px 17px -2px #7b7b7b;">

                <div class="top-div" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;display: inline-block;width: 100%;padding: 20px 20px;box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;text-align: center;">

                    <p><img src="https://salequick.com/new_assets/img/otp_mail_icon.jpg" style="width: 110px;"></p>

                    <p style="font-weight: 600;color: #666;font-size: 20px !important;margin-bottom: 0px !important;">Here is your one time password</p>

                    <p style="font-size: 15px !important;color: #666;margin-top: 5px !important;">for <strong><?php echo $admin_name; ?></strong></p>

                    <p style="color: #666;font-weight: 600;font-size: 40px;margin: 20px;letter-spacing: 7px;"><?php echo $otp; ?></p>
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