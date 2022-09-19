<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    </head>
    <body style="padding: 0px;margin: 0;font-family:Open Sans, sans-serif;font-size: 14px !important;color: #333;">
        <div style="max-width: 751px;margin: 0 auto;background:#fafafa;">
            <div style="color:#fff;padding-top: 10px;background-color: #2273dc;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                <div style="width:80%;margin:0 auto;">
                    <div style="width: 245px;text-align: center;height: 70px;border-radius: 50%;margin: 10px auto 20px;box-shadow: 0px 0px 5px 10px #438cec8c;">
                        <img src="https://salequick.com/front/images/logo-w.png" style="max-width: 90%;width: 100%;margin: 8px auto 0;display: block;">
                    </div>
                </div>
            </div>

            <div style="max-width: 563px;text-align:justify;margin: 0px auto 0;clear: both;width: 100%;display: table;">
                <div style="padding: 0 15px !important;">
                    <p style="font-size: 16px !important;text-align: justify !important;font-weight: 600;"><?= $subject ?></p>
                    <p style="font-size: 16px !important;text-align: justify !important;"><?= $description ?></p>
                </div>
            </div>

            <div style="overflow:hidden;background-color:#414141;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;padding-top:10px;">
                <footer style="width:100%;padding: 35px 0 21px;background-color: #414141;margin-top: 0px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                    <div style="text-align:center;width:80%;margin:0 auto;color: rgba(255, 255, 255, 0.75);">
                        <?php if (!empty($footer_quote)) { ?>
                            <h5 style="margin-top: 0;margin-bottom: 10px;font-size: 16px;font-weight:400;line-height: 1.432;color: #fff !important;"><?= $footer_quote ?></h5>
                        <?php } ?>
                        <!-- <p style="color: rgba(255, 255, 255, 0.55);">You are receiving something because purchased something at Company name</p> -->
                        
                        <?php if (!empty($website_link)) { ?>
                            <p style="text-align:center">
                            	<span style="color: rgba(255, 255, 255, 0.55);"><?= $footer_text ?></span> <a href="<?= $website_link ?>" style="color: #6ea9ff;cursor:pointer;text-decoration:none !important;"><?= $website_name ?></a>
                            </p>
                        <?php } else { ?>
                            <p style="text-align:center">
                            	<span style="color: rgba(255, 255, 255, 0.55);"><?= $footer_text ?></span> <span style="color: #6ea9ff;cursor:pointer;text-decoration:none !important;"><?= $website_name ?></span>
                            </p>
                        <?php } ?>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>