<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<!-- <script src="https://cdn.jsdelivr.net/npm/davidshimjs-qrcodejs@0.0.2/qrcode.min.js"></script> -->
<script src="<?php echo base_url() ?>new_assets/js/easy.qrcode.min.js?<?php echo date('ymdhisu'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url() ?>new_assets/js/html2canvas.js?<?php echo date('ymdhisu'); ?>" type="text/javascript" charset="utf-8"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.5.2/dom-to-image.min.js"></script> -->

<style type="text/css">
    #qrcode {
        width: 350px;
        height: 350px;
        margin-top: 15px;
    }
    .imgblock {
        text-align: center;
        min-height: 291px;
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

            <div class="row" style="margin-bottom: 20px !important;">
                <div class="grid grid-chart" style="width: 100% !important;">
                    <div class="grid-body d-flex flex-column">
                        <div class="mt-auto">
                            <div class="row" style="margin-top: 10px !important;">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-title" style="margin-bottom: 10px !important;">Link Pay</div>
                                    <div class="form-group">
                                        <input type="text" id="copy_payment_link" disabled class="form-control" value="https://salequick.com/pay_now/<?php echo $merchant_key; ?>/<?php echo $id; ?>" title="https://salequick.com/pay_now/<?php echo $merchant_key; ?>/<?php echo $id; ?>" style="background-color: transparent !important;border: none !important;padding-left: 0px !important;">
                                        <button type="button" class="btn btn-sm btn-primary" id="copyLink">Copy</button>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-title" style="margin-bottom: 0px !important;">Link Pay QR</div>
                                    <div class="form-group">
                                        <input id="text" type="hidden" value="https://salequick.com/pay_now/<?php echo $merchant_key; ?>/<?php echo $id; ?>" />
                                        <!-- <div id="container_new"></div> -->
                                        <div class="convert <?php echo date('ymdhisu') ?>">
                                            <div style="width: 330px;margin: 10px auto;background-color: #20358e;height: 550px;border-radius: 20px;">
                                                <div style="text-align: center;padding: 60px 20px 0px 20px;">
                                                    <img src="<?php echo base_url(); ?>front/images/logo-w.png" alt="Salequick" style="width: 200px;margin-bottom: 30px;">
                                                    <div id="container_new"></div>
                                                    <p style="color: #fff;margin-top: 20px;font-size: 20px;">Scan and Pay</p>
                                                    <p style="color: #fff;margin-top: 60px;font-size: 11px;">© SaleQuick <?php echo date('Y'); ?> | All rights reserved</p>
                                                </div>
                                            </div>
                                        </div>
                                        <a id="btn-downloadQR" class="btn btn-first" href="">Download</a>
                                        <!-- <button type="button" id="btn-downloadQR" class="btn btn-first">Download</button> -->
                                    </div>
                                    <!-- <a id="qrdl" class="btn btn-first" hidden>Download</a> -->
                                    
                                    <div class="result d-none <?php echo date('ymdhisu') ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/template" id="qrcodeTpl">
    <div class="imgblock">
        <div class="qr" id="qrcode_{i}"></div>
    </div>
</script>

<script type="text/javascript">
    var qrcode_url = "<?php echo base_url().'pay_now/'.$merchant_key.'/'.$id; ?>";
    var logo_path = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMAAAADACAYAAABS3GwHAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAyuklEQVR42u19C0xT2dY/OWkIIYQQYiYT4+d4RwXG6ziIXkYRkUF8ISLKQ0BeIm95lra836IC8hIRERR5tKWFCgV5KQ/R8TVzvfebz+vn5zeZmXj9G//GGP/GGGOI43/ttgdOSx+nWGipeye/dPX0vHrOWnv/1t5rr21iYmJCmEwXgvKpbLvib3Tl2R6njWyyQGUTI/gPxvAONP8wS4XGBZcFUegq7nzV6J+TgeGaWI8yoYGyfCrmS3mIBSov5Hs3FllrRf0kjoULbgEMrQWYzUvBPgA2AKOiQLqkPYQKaoVl1RQIK6UB9AIRC7B2wwUXnfcCmeiQ0mADwBQIUyAsYwqEKRBuAXDBFAgbAKZAhjsQRmcAy9AokLFVPlief3nOaRAuuCyIGmihOpGYAmEZUyBMgbCMKRAuuGAKhCkQljEFwhQIy5gC4YILpkCYAmEZUyBMgbCMKRAuuGAKhCkQlk2MdVJ8YF0fEVzfz8hpu2EWVT9sEXH2inVI3fCX7kcvLV6fI1i843jPkh3Hupc4ZncsWcvhL5Ygg7/YIUuK9dkAidyxeC0Afa7PEgA6Fv8NjkdwzBUCyM9OLdCl5f5UkNekQn4burf1s4T0f1HPK1T4Lv8//oaQA/8nRyo75nUtdi/pXuxfM/BF5LkRK3brhHl6yw1T38rBBUeBFmQpEN4k4KGbBtcOWXqd7P36YM2Qi09FX7BvdX+OT1X/+S2Fok5QZrFb8aWrCOuyOvq+S+f32SNkyJDJ71srg31Gh5jE2gyBeG2mQOyQJRCvy54NhCog0DnQPa7VEg5Z2vw32b3nSD67ZZB8dym61OlZ3lfnVzPAPFg75BVQPejgUzmwOJN/0zyDe5OxEJpfbZplg6AopwZ+JZIu3CSSm8fNUprHHYJqhlK2Hu2+ujqd/9ImjffuL6lt779Kbp1czmz/sDKN++Hr1LYPsO3DCpBtWOrQLgNX4bN9ap+VLOk5pdCVrAIsKejfM1fh3rUHec3pe1R/z8uZ8GxT2ia/Tm1/b8fivgGDeehd0d/Ibv9xP7PlxpLE5jHihPhHAlMgndX6d4ik5htm0MzabCvpKV2XI3i8LKXt41cAUPCPtgA7Fu+jHRtkFshsnhSkDL9Jt0u/S2QWb1qm7sNSkJXtL/uu9FjyHmacf3rb1H2xuXL3aEe5vh2L+pvCsSwa+7O5M57BzPNQwOZO38/UeRXOw5K/Z1v4DgbxEQzh49LkVpDb32wuFI1G1F8Jj2u6siij4wYDU6BPLIfPDBFHmsasD54e9tpa0j0ICvUW1e5Qc0mUiwT5spTKLBUynX1Yn3BOijx1n2wVMvrUdn/WLM+v7XYVMhU2ae0fVzDbP37NbHsPrfJvu0vFpTHnR1YUdN1iYAr0KQZQP2y9t7w33DFP+AA9XFTj2CpTPjYNA2DTVGg2jfPTOafC/kpBrXnZGvajs03dsWwa96Dq/Gw1+1MMAlVMYAgf7DjcZ27HuuvAAJZiCjTL8sPR7i835HUmfZvBf4J4pw1rml7MoCKyJlv5dlUyd5b7cNXsw1V5npnUhauZ0iiVVZ1H3T6qzq8M6u6Bq/YeSENArQG8rxdeFZfrem7/bi2+/TumQLQVv7iL8CzrXbIhr4sDXPMxcsRslSq3okxnH94cnIer8VhbijHYKt2uuA9Xyf68WezDU0KZeDSvS2d/1cciI4D9n8ScH2NyeDdMMQWibwBL1mULON9weH+gXgpbWopIt7bWJHNpbKfTAsw8z0yoqp2VtQ6ajudp2J9L8xpcLX5Xfz+ocwKMYPK7zI67J8Q/OWMKRKN4nBAvdcwVZq1Cyp8mU34q/1bFudmfwNfZNHwJOudUd6wyPq4N92erkOnwfTZNf4LOdi3Pj5xjwKv9Ff31wo8fMQVSV7zKuhdvzOtkrU7nPyKV35asUdgqamJFR5OtgreyKV16OpG5Wm7nUT7pbOfqYB86svx9Ku9ZUqBAcr1VKugQe7o1BAo76ZDVcb+k664DpkAqyr4y8WKnvM4UUP77QHsmbZQo83RtSjWA6Ye+HDgnGh9YlkyiVfL5lQStUqQofC506PB/fJ3aJq2xZb05iliJeD2iNbJ9ZtAh6vtiT4+JrES+AJv7gtl6LR5TICUl6szg0s0FXSxS+W0pA0W2ygazFBw79NLQy1uTwX+zMV/0ZBPAKb9LAolcgL7LPhEKJXi8qfASQCTDJQ0QafiuLdRdd3q77F6lKFCDwpmYeS2R2mutzxH+sYrN+w3o529/pWC1DEj+NoOP8Hwlqx2Nusu9H2WDfeT7gVbgrV/NQLPw1hNTAKZAU/38dQNLnfM7s/7K4T8E2jNpq+CEqXNGp7vb2t855XeObikWsfZVDoT7VA2E76/qh08ZqvvDfeHTr3oQMBTuWzMUiuBXMwwYkuIUyLXzBOp1a4Y1YCh8CtUqUKMU0+c4BXLtkOxz5v34Aw4A3E+Ig79N7whak9ERBI6rBPYUrM3kB/0tVxC0qaAr+oej3Y1rswTIT/tok6bYCyTfu2Ujc4Z/OHrpxtGun5YAGJgCQQmvHV66SaL8vIcrpTE7Kvq1qWEF0w8bDYpBbfTKMU/Y6Ft52S3s7NAiZutNSybvugWTPyGHdEA2/xbgJ4sM7h0LTrsC+ACRDF0yUGVl36nbRWpkKgRKrq0GWby7Fllwz9pC7j+i/yYE8JT8R0A6ILvzlkXA2VGL9Vki83WZyuGcJzTfXNxpHnxm2DK2adRu78nLpQ7ZgqfS7k4epSXgyYWjkINjjrnCR/EXxuzjL4wyPnsKFHF6YPGmgk4OKP8DReXX1L2IPlHzi2JPthRfqtpfdXlN4OlBUxPDn89gVDOt4prGvTfmd91dLu3vVzlAhrpD4V19BIr1OKpx1Blg+llToEOnBhdDzc8E5Z9yeOUVXYECUWoTCe2Bhwk89SVw/sbA6sEVgTWDBhuCa8zlQPWA+/pswQRSbrLnZ6rXiNJik621Q5bgaXDdsBtAL4NiBkGBwk5BzZ/XyUI1P+L8NlqECpCcf3U677nb0Z76bUd7VpssrBltRjXTyvNEt/varI5xG7XhEtMGYJ/V8dSnss/Np6rP9LOkQEHVvUtB+RHteUgd4dVMe3hTNf83UPNvO9ZTl9g8sSadexMvk6pH2fdkrxu0AKM2auOIpsYCPoLT/BRaDTf/6oHPiwLtPCEmAIudCzozgLr8upI6yMVWRnvkWwKq8v9wtLs5nfvjqgzej5j26LkEnRpw+1sOGECawkAYdeCMTTEAcJgDT19xC6z9zCjQzpLuxRvyupL+KlN+G5WTQBS+s7lU5X/hUnSpjdU2YW+ycCf1GxUFCq0fdv1bbueoNESdN9VDNzUoJj8arMoAjJsC7Tl+6YuNuULm6nT+w5XKYnsow+uKMvng4EEi5W9Obr7mYLKws1oYFQWKODfm8n1e11Vyjoaq+CXyPaIu0yAwAIDxUyCvMjGxp7RnkXOeMAmU//FKxdgeZb09CoMo08ovakltvmYPwLmMDKjENk+4bMgXDZMtgMowbFn4xLoc4ZOwM6OuAOOmQODlE55l4i9dCruiV6fznsrV/NSBEhVhtaTyI9qzpRiUv22q5jcxghbAaChQ0sXrLhsLpg1gxjtVoEDrczqfRJwdd42oH9MbBZpzAztUP0z4V/d/AYob/206/7cVaQq9OmxqtyaPEuejoPxQ828putTCar1mbyTUwehKUgvVABSjR+XnGa+gGMBheQMwiKKq5tfG0kzizl8los9dsdx5oid+TWYHKL/iTC7VMjVyEJT/JVL+1JZrDqw2THsM1gAuTrg4KTEAZSAN4DAygLPjpkb3MI6KfiaOXBi39q26HGCf2fEC5eexZamZgKJkMspyZtvHb1i8l27F3c1pbRNrTHBqRIOnQFQDUOcES30A1AKMuQKMiwIN/vMPIld4x/rg6SvhaLDjL6ltCpGbyhxfedqDRnhXAed3K+mpZ7deX0WXWhQUjBM5BaNEQEEn4dsqIPyEQkPNf2qELQDVAFTNJ572AdZlC5+EnB1xDWkYMR4KND7+kTg/8sAsuWXCfWNe171lKa20ac9U85gKys/mvXYr6W5Oap5wAAPQOMjlVztMHKgdZsSfG7XwLxv4YkeR6Evvyp5FIaeHLUJPXTENqbmKqZNeKBBPKQVS0g1qHGVo/A2R0XZnsX/NIP8/klreSwOj6CWQQlgOyg+0593Wkp6WlJYJh/Tp3JJKa9Dzw/8gioU3Gf41Q2b7qgbsDp+9muRZ3nfetUgk8CwTNwbUDMYGVA3Z+1UMWMQ3jBBnxT8TBl7RGEkvkOp5zWQ0KDkQpmAAC5cCCR88IC6M3LdgtlwPgofwBs3KmjlPl0KB0HbKfFS0P9CeVztO9NaweDfsNNGJ3jv/Q5R13zGPOzfqtLf8cr1jrvC3r2RTHtG5pJ/SsNttJT01B6r67bPbb5iN3P0/mALNQUlWRYGUZKcjDSBIj6EQOqdA3L//QqRyJ5b5nRpsW5LUMoP3qaM9yyWcn//K/Zi4NqZpfDUYgFrac6r/V+L0wD3zxAvjLt/ndt1cmtwqSZGobBI3GMEH8CneuhR19R06c9Wlvv++OSYsui9HLkxIWwCWKgrEk6NAa42NAjVc/btZ0OlBFxTn/ZeUVjX5c+SdYElvD4f3zv1YT2PUuRF7NvemqaYaFBkAPLgVO06I+4BqTa4kk+KyeUoNDD3wpUDJdhwXiyLqR9ZgCqR7+VDTmOv3+V1XV051bnCVzghTjAUyGgpUO3DP6lD9lXDE423SFLo42Ury8LCktAcexnvX4kv14WeurGK3TdDKIMxqvb7Ip3KAuTy1bXKlYteqkmvZyuaiwvUmvcr7jlf0/LT0559/xhRIh+VQIzKAzqszEhUrpUBcaTh0zaAbwDgoUPLF8SX+NQMVXyW10nJ8Zfki33lVXK5PbhlfE9tIb0RQeP1XYm9F3yq3ku6Jv6S0qc4IrWQ76pJ1LhD97FvZ73blx59xCLUOS3jDqOv3eTMNQHkvkNQA/KqG3ADGQYG8Ky6vcC/pESOllM+INnMCu420GXyPemxSWq45lPf9ZEa3BhVc/9XUGxTYMU/4ZLlsAvbMa82cQkmOL3yX0fFyd2lvfKX4JytMgXQnh9VfdXXMBQNQjAVi8+SSb8kZQOWgm6+8ASxcCrTzRO/qLUXddyUGoCxxFXs6BgjtsyGv855v9YBr5cgvZtpQiNyO25Z7T14OX53Be7MyTVliLGovk7wBoJfzDZv3fkuRqPRQ3dBSTIF0V0LqhsAAhKMz0qIoiQWSTolEBnDZzbfysnFQIDCANcDlf5EzAGVxPgC0gsjWku5hv5qBVYLpHJG0Suy5q9Y7jvfEg+P81obuYhaUphcZwA/FoorD9UNfY+KiuxJUg2aECUdtaPUCSQ0Apa/xq7psHBTIo6x31Q9HL91WSYEoUaAoZaFTQdeD4NNXPCt671loU4MWCn609D7ZF746nf/GhsXVigKtlIZYvPMo7S0sENxegimQ7uSAmn6ZASgJg2bzlEyKFzzdX9nntl/eAOb0PpekCoglKQLTOWmGwQFesfOEuBvllZw5+CUv20hT5KGuz76QM8OubO6EOV0DaLr8T9M9ZX3oYT9dwWyjdK0q62aVD7dGPVRrszqe7ynvi2gYua+V4WEKpOH9V112W59DTorXFAskNYB9Jy+77T/ZN28tgE06j2GTzv9yTihQWtv1xQGnBo/PNADVvUBAR958n9cpAsNxDa8fpjVA1d//v4RfZf8qd6BQy1JatVrmCO0PNG0itO6Kc/c/fse9QDosB6r7pwyALgXaVwEGUDF/FOibNJ4pYNWcnPzcyH9aRp4bCUbpr9FAh/Lc+fI1tKQrNI37Bmpzwa5SsWvixRFzOjVoRut1a/+qgXg451vFTGQz0qjI6NBySQ4h/kvvisucos7bXxqAzhgVBTqg0AKonxEmNQBpXqD5o0C2ae2mgPVz0gwP/ef/mMZdGN2wIb/z0VfkSDCbqySXv/xI8ArJXF/u6w25Qq5XqdiF2TiqkQ6N3PuNkXpxwmbXCXELHP9eksqbmjWOsuyobAAMjTi/dikSNUSdvbrmpwe/M0xwLND8UCC2agrkVzng5ls5MG8tgC0bDIDdvmFOKNCNhw8JDndiiW/1QN1/JLVI0mDTXXJUOu2R+2pjnrDNu7zXuYB/w0xjizP8TzN2+/UNzoUiLji2T1ENL1X09o+kTMIhW/Dk+1xhvU/FZceSzttmJrjonQKhcQD/6iE3wLwZgB2r3RSwfs4uUDtwzzypedzTPhPFA7UpCYZT7aTKfIKXTvmdLb5VfS7p/HFzTTVoieiu6ZEL4w5bii9lrMsWDH+X2fHIPrPj6XcZHc/h87FDluAXx1xhP9AeZnTD1VXs5nFDUn4jo0DIAISjNmpXqJSPBQo4NeQGmDcKZJfGYwBWzFkzPPaP34kCwe3F+ysH6qAWfiNbGVD1mlyUZXpIOoQS3ToVdLaBc+Sa0X5dIx1i824wEi6OL0KBeLtLeyOBFnG2H+vO213Wl+JX1R9wpGl0w7Gu21bCsQeGNDvM6Epg9eDUOIDmgTD9hEOvYPEJgPWcUCBSbh1/YMpsvb7BqaCr/y+p1PV8ac4Ik7YEr5zyu7j7wAiy2kdo1drRDX8nos/dNYu7MGYZ2ThgHXfxisVJrpghlE6LxGWOS8jpYVfHnM5RG02T4tOmZoQ9CTlz1Q0wbwawrOACsaygee6vx4Ka+3DDiJdjbuc9RIWkw+NKJsTILXgx/TltBJ3c/RV9zllt181M8KR4g5bJYDhpD6BCLJDCOmFkYqyIsyOuAOPMC8Rp/9E8rfVG8Co27w9qVgg7DZPiSZn0CTbld7X4VF7eAFSHdsCcCc4LNO8lsmnchTofQOVAWBqZFkX4JBIMILL+qnHmBfrXv/5FdF/72cyvagAtcv0QLYtjk0afDpG9Q8gncC7satsHRsA8P4F7cAy0JDZfc95Y0KVmUvx0QCJpALFgALFnR0yN8XlIjEF46xaRyR+x9K64nLQmk/9gucQI2ikOkeKaXzPzhMpygr7aVIB8gr4NaU2jZsb0jIxFZrZOOIPfNziVGpE1vTokNfGBbI2wj+AwP044N+YCMN7UiOhTIPgXkX/xR4voxpGIbzP4j5Yz26ZaAlvKwJVcakS2Ih2StAjICPj7yvocExrHTRMbxw01589nSYHS2284by4QDc6cFC9PgUgDAP/wcXLzuAvAOCkQWQSCB0TNvadE5v95yUi+OB77Vw7/V2gJJm0U02Vo6h1Kk4RNvN6Y29W5/2S/fUrTqFE2nQu1ZPNvOTkXiPo1UiDSAPLAAFp/dAEYLwVSrPmEf/5JxDWNMv+azpO0BMozR/BUOMfSEUSUcgUeNN+v4vIadtuYqRE8I6OQ2fwfV2/M7+LbSLJ/81QOhMnWCf4APsCvh8+OOgL0tkzqvBsAQvvVn8wiG0ZjV3GADqVOO8bUVUXkKJDcdDqeNJSaxX3rnN/VF3Cq3z67ZZQBWGh0yOhKw9WfrVyKRcWr0/mvqa0AlQKRTjAwgPc/lPQMnxDd+eKE6DaxEGqmWVMgxSIe/y+itusfFn7Vg5xv2LzfJI6xloNlkjnFLLQusKjzUO2ADatxxLSk7Toe8NKrAfydCK4b8vo+t/M2NUeTrcJ7k0UAP49pGks50XWbMEQDmNMWYHz8d2Js7Hei9OJP5v7Vg8xV6XxkBB9tFFaFkadDXLneITKgCiW8ci+51BZTN7wip32csUCfkdHIw7/8ZoXS1dhnCh7/JaXtAxkWT9b8KCsHvLNXe8v7uL13/tdan/esNwokbwzjjKjGkfBvM/n3v5aFTch1j1JWGpzazqYYgTTO/51bsagv8uzQag4YAbttQfQOGW3puvPfVn7V/UHrsgXjoPSvwBDeLUtpfQfv6fW6HMH9wFPDWe2j9xcvtJpJZxSIWsAAiMy2EYvwM0PR35FGoGwyjTo6lCbJKP1m69FL/YfPDq840jRmmt52C9Mh/RkAEVwhMk9oGrWPrB9J8qnorwo8NVTrW9Wfc/D08HYwAIu2kftGPxuPdo2IjKBUdN0q/sK1+PU5nQ+Xp1JjhzT7BpSsb++2l/Two8+Ork5vvWm6gJ6R0ckFBQVEueg2I61lwiK4dtjq8NkRq7AzQ5bx58fNDOU+CUMxAPT54MED4vTwL2YB1QMB36bz76GsESvTFP0BJdSIOtFeOsT+/vv8zrsRZ6/4HmocsfKp7mf4nuxlhJ25ykhovk6w2m4wOO3XGRnt1wkAIx2h9TqB1iBIg98SL14nIhvHJfsfPDVABFRcZviV9zH2l/cS+8vFDATfk31EQGU/I/zMFUbC+TGC3TLOON79EyODe5OA+ydiG0eIVN4NIlV4a1YUKDU1lcjOziby8vKJw4ejiLKyMsaZM/VESckxBigWA/0eExPLOHz4MCM8PJwIDQ1lyAByGCMs7BDj0KHDRFRUFCMuLo6RnJxMpKWlMTgcDiMnJ4coKipiyIAUlQHXYrDZbCIpKUlyTjiGyM3NJTIzMyXIy8uTKPTn1IrNGwWilj///JMIPT1kvqes13dtVscNNFgmDYPQsncorX3yGw7vuWuxSOxxvKfYu0ycEVQ7zIpqHE9JaL6WktQ8npTSPJaUCp/J8Jl8YTwp8fx4UsKFaynR58dTQs+OMtH+B6r6Ob7lfZx9pb0Ze06IM7xOdGd4lfZkoPP5ll+Gcw5xos6NMJPOjyblCm4lJF+ciNxfcTkg7Mywa2TjyJfJ3OumwpuPtHomjY2NSFnNUlJSlnI46e6hoeEBoKgRlZWVCXl5BUlZWVkpiYmJTDAMFig/JyQkJOPgwYMUBGeEhIRmwHGciIgITnR0FOvIkSMsUG4WGA4zPT09BRQ+iQQ6Hyg/XC6FGR8fzwoLC+OA4XBgv2gmk7kTjGcN3M8iON4UGcnnZgjz1gJQ5cCaQcvQuiu+jrmdE8tkPQnTk2nknWDFtCtUvwCOQ4mzXoL8YiWT+1yKdoRnKvAcjnkOjvVz1E0nkeETzvGCipUIU79Lzvd8BTqe1f7Uls19sorD+23bse7zic3j6wU3/8dMm4oGDMAcFM3V29u7083N7Q/Aky1btjx1cXF5Bp/PEUB+7urqSuIFwg8//CCD9DvldwnIY2V4RgF8n/6dcswzuPbjXbt2/QxGUR8dHe0L97UYtRjGQtUIQzUAhGz+bYvYpjGvzUWXrqJxArmZZTMW056ZF4g67G4jM4hZgaUGcvu2T+2P7vWr5Na3biXdg7FNoxueP3/OoEOBOjo6LJjMtJ1eXntvOzk5vQOF/AhK/RGUUS3QPtNw1bi/lvgABvdm27ZtT/fv3y8GeuTPYrGsMAWaAwqkWEp7frKIaRrzdC4UDX+d0kYvlJqtWrZjaQCbRmwSW/XyP7YKs9rAmX/rWz1YcvLyvaV0/i/QDhvg8Y2bNm16D0onp9hQG0tA/a5MVjxmtjIVpDGAQb7bvn37I2gRyoFOrYLWAMdizVULQMrHu+9abikSeYCCDaJ1hmWh0UpSrWjKC6Q+ZaIqx1ouVJulmnrJn58nS8LV9tG58NLtvSf7nTRVNF1dl81jY+O8du/e/Qhqfzml1wazPY7OeVGLBPgA31/4+Pi0gc+xAWCGKdAcGgCCY3aH5bccLhhBez8yAgkdUrXoBnU7W03GOLbC4h0s5WsVK91H2flZM8+PRrfRpI+tx3o8BDf/zVBHgS5d6rOOiYmNB+V6t3nz5hnKTFem1uTaHkvv/NLWAL6/Bv9ABL6KC8UIMAWaqxuyZ7ejlOie246Lh5FiraQzWMamnzJR7T6zlJGhrs8VPN9ZKt4/8l//Vy1dEIv7FkELwAQl+6BIf2aLT6E9miDzPd7s3LlTBL6B26FDh/BMvblqAUj53Oh/WQbXXfFcmyUYtkEtwVTiLVW0hKuEuvBo7MNVsT8NCkShXpJZT7mCJ+7Hezx7/v3/GOoqGpFIZB0dHR0PSvUOGYC29ERZzT/bc9AFpSUQgBG4ghGYYwo0hwaA4FMxYLn9mNjDMbez+xsO783XTOmAmVx6dOqCbAoLZMjNOCO3sxW4PjWHqbJ92Dylad9tFdKCS30A0W3vyn7ngj//VNsLxOfzwQeI9YTyEPkAquiNMqd4LigQnWtRjOAVtAT8ffu8XQMCAswwBZrjcrh+xGJfRb/z5iJRlUOW4CEYwAe0HjDK/W/LUt9Lo0nWFrYqepJk4RzvPcp6jzPbrmvsBWptbSXy8/PtwsPDUS/QFA1Sp5CzaR1UyaqUnw7FkhrBDzIj2OcaFhaG6ZDJHEdTZnInTGPOXf3ao7Q3dEN+pwho0W/fsHmTy6Xdj9JuSIAs9lztWACZqYw8Fq0hQOYXJc+xgim/jYxXspkOy57KR4rSw4MxvttcKOoLqx92Ft35bzM6FQ2Xy7VgsVg7vby8xp2dnSeRM4yAjAH1wJDdkei7JlD31wRlxykzFPVGRrYEuyRGEBwcvBB6h3TWOuilJUAl7sJVs4izw46eZeJ4xxxhM7QIo/aZHQ9WZ/CffpvZ8frbDP6rVWzei1UcCZ4rwzey39dkdryCY19/J8MaGb7LoIDy+yoOX3LOvwJWp/OfwbYnKB/p2qyOe5vyu86H1l1xPyq6a6nN/zlx4oRVYmKi5+7du7nArf8Jterj7du3P9m2bduzrVu3PnN3d38O21Bt+3rHjh1yQNtIwDEvYf/nCOgYFUDnfA7nfkmeA7a9kfX5z8oxRkYA9w1GIOcTGHwNTa1hdRnvPpdx9VNGVir+kUi+OGLuWSq2Ca0ddvM62Re+ufhShltJd6nr0e7j0DoUIjhkC/LWAdYDHCQQ5q3NEuatyegoXJcrLHY71nN8V6m4fNuxnnJ3Gbaiz5LuKaDfdhxHEJeuyxYWO2R15H2f3ZHjUijKgu0c74o+Znj9FX9WyzW7AmkiL02VxIz/duzYMbOcnJzVcXFxAaBEKcCrOdAqZHl4eGSBYeQdPHiwFFAeEBAICJAgMDCwPCgoqBxtDwkJKff19S3x8NiVB8aQ4+GxWwI4Vg5wPgl8fHxK0LEHDhwo37t3bxX81gnbH6E+f2prQGfsYdon2MVHvUOhoaFmJgtgPsZcTNTQy4SSsAtjRHDTqOmuUwMWgaf6rQ+cGrLanC+wciy6ZOlY0mG55SjX0q2Ea+kEcCzpsnTME1vaZwktNx7ttgo4M2IdcXbEOgiOCzw1YB1QN2x9AOH0sHXAaakcCJ/h8HmoYdR6C5x3QxbP0j2/y9KzrNcyvGHQIvHCqEVK8zihi9YUBZ7l5uaagyFY+Pn5WYJSWwK9sExOTrZKTU21jo+Pt4bf5AC/WQONso6KirICo7EEZZYcowzo9z179liC32GVkpKCeqGswYAWgfHZRUZGxkKLMIG6ZamtAR2/gtoSgHG5wL2YYQqkomRnZ5tBjfUF1BRLYmJiFqelpVmUl5fjiEM9FmR4CQkJZmBQ7qDAN8A3eKctJSKNAFoSvr+/vwubzTY4x1hvFGhsbIwAMGJi4r4G5ff09vZmeXp6HofPQmjKg6DZXwM1kCVdCrTAZYOeugk+yU7wJ66CAbxVRYdUUSRynABaIQEYgXNERIQh0SH9UaBz586Z5uXl2UOTXgWK/094wG9kD3ESms0/gIdyoSneX1hYaG1i3HNqDd5AoSWAiirGHWryflDod9ToU7p0CD7RYFkn0DhDix3SDwUCxV4VFhbWArXKm02bNkm638ieB1nX3wfgp7ePHDkSUFtba4FJiX4L+BtoFpozGME4GqmeGYJNK2xC0hIApXKElsAUQBhK7TOvFOjOnTum4LwdByV/QR3soUJmCB+AEvUVFxc7CQQCTIEMQAZH2XXnzp3joNBv1Y0VKL5TauwQGIEIWoL1QUFB+qZD+qFA7e3tS4H2/AIPZFLZgyJlZ2fnj9Bs/hYVFZVQVlZmhimQYchJSUmuHh67hrdsmTYCunMSZANvb+H9owC69eDrmX52FAgeoCc8jOeaohZR67Bt27bX4CfUQPO72AQXgyhMJpMAIDo0TG0JtMRbaAmGwTFeHxoaaoom8382FGjPnj0BsvmragdXEA3aunXrW/AF6qGmWIYpkGHIMgNgAI0FNrRzAgzgvSIdohObhBxq0IW+AwcO2IFjbAo+4edBgUCh/dGMIk1Ri8gAoAV4A01lHTzspZgCGZaMUq0kJia6Q00+TjUCbXqH4B2/9/Lai7pIVwUHB5uiFC9GT4HAsZUYgKaHpMQAcDFMSrQBOL0Y0aHZxA8hI4Dj+5Fj7O8fzPDzmzs6ZJPGI1amcRm2bJ6FPinQVAugygkmDQAFZiEDSEhIWIopkGHKYACoV88VlLhP0QhU9QgpoUPIMR6FutFu/35/UzCGOblnMACGTRp3hS2by9EbBYqNjQsifQBV3WdqDABTIAOU09LSkBFsR0qM0qhoS4dkRjC5e7dnp7f3PjswAMZc3CcYgBUYQIYti/dMbxTozJkz0fBnX2p6SKQB+Pj41AHfxBRongqKA6KC7nEsFosBPoEL+HhoxHhyNr1DLi4u78Gx7ouOjnYoKyszHRgY0GlFZ8tqXwzos2VxJ/VGgcAAYuHPvpTFiagcPKEaAEoTiCnQ3MoxMTEE1OKMjIwMlALRHD7NORyOGQqFAKDgOI3nQSkdQXndwAiQT/CepEOKrbu6OcbOzs5vIyIiBLm5uUv5fD5Dl/8RGQDKLGLH4n7QGwVSNAANvUCvoTmshdoFU6A5lkFxzY4cObIKlD4oNTU1C555IRgCCxTfA7YvQYZA5zxwrHlkZKT73r175YxAm96hzZs3vwEDTKipqbHS5X+0TeN+CRCRLYBeKFBtbW0sXQpEGgC8CEyB5qgUFRUhxXdAA45AP+6i/KCggK+AjryC2vglvIsnKCViUFBQeEhICK24LDAe1BK4eHvvFSE6pE3vEBkFAK3Io6SkJAegQTpbR8A2jfcFoMGOxXujNwoEVj1lAOqcInIkGBkA1EpLMAXSrTwxMUFcu3bNAgxgOyjbIFJ6UNRJFfOG38I7eRwVFVWYlZX15b///W+N5wcjMD906BCiQ91Un0DdPGPq73A/k+D75YG+LKH4Ap/034H+WNmlcZlAgR7rjQJVV1fTNgDwASQGkJ6evgRTIN3K169fN83MzHQ8cOCAeNOmTTP68BXfh2yy/DNQypzjx49/Seda4BRbhIaGuu/Zs0es2DukKRQGRQkfPHhwoqioxGVs7KaZLv67LZtnDvAACnRXbxSIagCaYoEUDAAXHZaGhoYl4PTmIb6NQtDp0BOklGiuMPBz/+7ublqT/cF3sAgODnb39PTsRnOM6dIh9P537979jMViM2trTy/SxX9eyeSicQAboEDNeqNAlZWVMwxA1QNAFMjf378WHjimQDqUQfkZwK+dofaf2Lhxo1Zx/U5OTpMxMTHnS0pKVqCZfXSui+Y0BwYGorAJMAJ6XaSyWLD3YDwCuN4KXfz3L6O4xPJkrhUYQKjeKBDVANT1ApEGAC+pFppqTIF0KKN1CA4fPhwMTu8LxUS8mnppUNY6Hx+f++Dkuufn55vRvW5kZKTFwYPB2/fu9R5EE+01MQDy9717994FFrBGJ//dT0gsSeSZ2rK5S+fzpckVZABkNyidcGhkAOB4YQqkwwKK+wU8V46iItIBMhiUdwha5ggwAq0WyoD3aBUBBeU1opsAGFqNB2AEDrr678sKmgkAQ68USNlAmGJvAMUAamQGgCmQjuSQkJAloFglygYjNbUE6L3s2LHj/f79+xPAwbXW5rpcLtcUWh5ncIqfkC2Puok0COBzPIT9HebgOeiPAikOhKl60KQBYAqkWxmc3y9RBg66qdUVW4Bdu3a9gvei2AJovG5zc7NFcnKyLxz/gtoCqOsNpBiAcYRDa6JAik4wpQXARUcFjbAePHgwFk04Qs6mNklxUU8Q1P4PgNNvz8nJoZ3rp6WlxSwjI8MJ3qcAzqPRESZ/B+W/B9ezn8vax+AokGILgCmQbmU+n28KCrwTlOsBUmh1MVmKlRTqNTp06FB3Vlb2akqyArXXhf2Q8m8AZ7YZZYdQjBFSER0qSZMTGBjYB/dqZ9QUSEMvENUAMAXSgdzQ0ECmYm9AWajptgIy3v4yMTExpa6ubhGda4nFYjPZgFsjSpJFjjlomkSP7gl8jZdA1wqhfPnZUCBlTrDMB8BFh2V8fNwCnqsntAJ3nZycPiirlRUpKQqJgBq5jcPhrL5165bGGJ3e3l4zqLwcAwICGoBuvaJ2udIxtn379t1LTU3dCQZrPpe1D6ZAnxkFIuXTp08vSklJCd++ffttpNyK6wrIVoWUrBUM7+wZKKQAjMbpwoUL5prOj5Q/Ozt7PSh/PVJ+Oss+UQ0ABcSFhYVVsdnsr6G1YWAKhCnQnMhVVVVWwM+9wNEUuLu7P0LvBp7/Gxleo9XigYrcgPdQwmQyVxUXF5tqOufQ0JBZXl7eemgt6sman27uIEpP0+OkpCS3pqamuUylqB8KRDcWCFOg+SnHjx83hdraBvh2OAqL9vLy4np6enJBPg8OLysqKsoJlNGSzgyx3t5BM/AvHIKCgiTKj2pybXqZZFkB3xw5cuQ4VHyL5qP20VssEKZA+qVAinJcXBwRHR1tCc/8C39//y/QegEABoCWbvT09IDyFzpAzS/H+dUt5qckJeZbMLxuaJVsmpubGXP4f/VDgZSFQ2MKtPBlsVhsWlRUZA+cv1GZ8tPp9ty4ceMkULGJtLQ0l4qKCtN5uP/5p0DKwqGV8UFMgRZOuXTpElJ+B3hXzdSuTm2iTBFVAmf8nydPntze1dVlPp+1z7xSIOqUSHULLKgIhcAUyMBkqPkZZWVlq6HmPw/vUc7hVZcXSIH3f4Btz6urK33Pnj1jAQZgvKkRFQ2ADgXCsUCGKff19THOnDljB8qP1np4rU0/v4LT+zwFSkFBPqOp6Zxxp0akZoXAvUALm/YAXUE1P9fNTRreoI3yk7TH3d39Cfh4CUePHjXTV+0zrxSorq5OZV4gDQaAKZAByD09PUR3dzejpqZmjb+/fxuiPapie9SkQpQE1bm6bnlRUFCQAv6DFRjA55Edmk5eIDXzATAF0rMMyo8MYBnU/G3wDpVObNE04IWoEhz3Oicnp7C6utri1KlTn88CGbOgQLWYAhlGAc5PXLx4cbWvr28f6q+nO6tLkfPDe30CNT8Lan1ToVBIIOiz9plXCnT69OloTWlR1MwJxhRID/LIyIgEFy5cQA6vAJT4larsDuoyvskM5jGTyUwoLi62lo0sf15rhMXFxQXBw3hBZ+odmRUC9wLpV5YZwJLAwEAuoj3KklxpcngR7dm6desfcI4UUHwrhbCKz4cCUVeIoUOBoMapAq6I1wjTU7lz5w4hEolsQkJC2lBX52xWjEfvcteunQ/T0tIiUaiFodU+80qB9u7d609njTD00NCUPaBA9VVVVcswBZpfubW1lWhpaSH6+/vR8kWd8D5eUnt7NGV8pij/5O7du3/OyckOLi0ttTKg/6gfCkQukaRpjTDZw0NrBYsaGhrsMQWaXxkMgAEGsAylKkeJcqlrOtPh/rL5BJMo4e6hQ4eCwH+wMsD/O/8UCBwgTzTsTcdxQrzRw2PXrzExMUxoPhcBb2TIQKiSMWn5tBIVFUUkJiZbJiWluPn5+XPRvABtenvIqE5U8+/Zs+dmXNyRAHh3VoZc+8x3L5C9u7v7YzpLa0p7in54v2vXrvsoR2hQUFCCr69vNNCiWHCmYsE/iAU5GuRo+C364MGD0cHBIdFhYWGR4eHhCFCBRUZERkoB/DMiNjY2AsW9x8cfCU9ISAxPTEwMT05ODk9KSpLgU2Qq6B6Lro+QkJAw9Sm9Pyni4uLC4Z7DoRIIR/ePAHKEMjkqKgb+J0K07DMGtkn3UXYM+oyNjZNc58iRI+FMZloo3EMEPOPyHTt2/IyUX11+f1XrOsB3lDdonM1m+1dVnTIk2qN/CiQQCKx9fHxuKK4vq25QDKXRAH/gJeA3wK+aAAZG4pFqbHsETrZBQv19zxUk136Iro8oKjWbM92kWTLag9Z27gfl9+7s7DRE2qNfCgROFQNqnhp4UC+1SctHnauqDch5reqAmnh9gM69zSeo96VNTw+F9ryFCkgMLbGHUCi0NHS6pxcKhITCwkIveFCPFHsVNE2YVreN7jI86lobbWRdXIvOf9VmeSG659c0KZ2uLE973ICqevQDffIEumm5AAb49EOBEC5evLgkODi4Dc39JKMItVE4XSmxrgyAThCYqq5DOrOltF1ydDZGM9tjUYuBVnPZt2//KDjO+6Fys1xAXdHzT4FQ6e7uNi0pKfEC7nkfHh6tdWU/5cUasryQIQtp/rBr164byckpAYODV60XYh/0vFOg0dFRAmAdHh5eAg/yKR0qpIoC6atlULfQty4oEJ3noalH5lNokKbzkCO8aJArNjY29OzZs4tMFlZot/4oECnX1dXZHThwoAGl21PW3aatoquqXelw3E8xgNlw9PloIeaqNZJ1LnwA5b+XmJgY2dTU9MUCHY3XDwWiFjSZ2sfHpxmc4uey9HtzSoF0pSy6utZCozyyiurdjh07bqKxg9OnT3+x0Ifh550CKcrICFBCpu3bt6PMZO/JLk9N1EHNuMGsHFNd9ALpggLNlhbpigIpi+khUyTCtqd79niK4uJivY4ePWq1wGiPYVEgqlxaWrosOjo6ydPTcxge8hNylXFq/z+1JpoPzGVNuhBAjg2gdwEt9DNwdm/6+fnlJScnr6moqDAzWfgBifqnQNQiFArN4+LiNgQGBuaAIfS7u7s/QDUOKM0b1Oyi1kEKt/ewHWFyLoBGnjXs80ENJhc60LOW5QZ96u6+7T4o/mBoaGhhfHy8K1r21FjingyGAinKHA7HMj+/yI7DSfeKjIzMQjkqd+7c2Qm1UOe2bds6PTw8u729vcVeXl7iPXv29GkLcN76PDw8JJ8kqN9JGX3Cy5eAlOGzXxXgdxKqjlV6bcX7oIK6jZRn85/pAioeMVyjE2r687GxsVmVlZU7s7Ky4F1wzCjBhgs6l5FBUqBP/QM4HBrLC54C4YILpkD0ZTwjDMuYAmEKhGVMgXDBBVMgTIGwjCkQpkBYxhQIF1wwBcIUCMuYAmEKhGVMgXDBBVMgTIGwjCkQpkBYxhQIF1wwBcIUCMuYAmEKhCkQpkC4YAqEKRCmQJgCYQqEKRCmQJgC4YIpEKZAmAJhCoQpEKZAmAJhCoQLpkCYAmEKhCkQpkCYAmEKhCkQLpgCYQqEKRCmQJgCYQqEKRCmQLhgCoQpEKZAmAJhCoQpEKZAmALhgikQpkCYAmEKhCkQpkCGLv9/9Wca8tvjloIAAAAASUVORK5CYII=";
    var demoParams = [
        {
            config: {
                text: qrcode_url,
                width: 220,
                height: 220,
                quietZone: 30,
                logo: logo_path,
                
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H, // L, M, Q, H
                
                dotScale: 0.5, // For body block, must be greater than 0, less than or equal to 1. default is 1
                dotScaleTiming: 0.5, // Dafault for timing block , must be greater than 0, less than or equal to 1. default is 1
                dotScaleTiming_H: undefined, // For horizontal timing block, must be greater than 0, less than or equal to 1. default is 1
                dotScaleTiming_V: undefined, // For vertical timing block, must be greater than 0, less than or equal to 1. default is 1
                
                dotScaleA: 0.5, // Dafault for alignment block, must be greater than 0, less than or equal to 1. default is 1
                dotScaleAO: undefined, // For alignment outer block, must be greater than 0, less than or equal to 1. default is 1
                dotScaleAI: undefined, // For alignment inner block, must be greater than 0, less than or equal to 1. default is 1
            }
        }
    ]

    var qrcodeTpl = document.getElementById("qrcodeTpl").innerHTML;
    // console.log(qrcodeTpl)
    var container_new = document.getElementById('container_new');

    for (var i = 0; i < demoParams.length; i++) {
        var qrcodeHTML = qrcodeTpl.replace(/\{title\}/, demoParams[i].title).replace(/{i}/, i);
        container_new.innerHTML+=qrcodeHTML;
    }
    for (var i = 0; i < demoParams.length; i++) {
         var t=new QRCode(document.getElementById("qrcode_"+i), demoParams[i].config);
         // console.log(t)
    }
</script>

<?php include_once'footer_dash.php'; ?>

<script>
    $(document).on('click', '#copyLink', function() {
        var $this = $(this);
        var text_to_copy = $('#copy_payment_link').val();
        var $tempElement = $('<input id="clipBoard">');

        $("body").append($tempElement);
        $tempElement.val(text_to_copy).select();
        document.execCommand("Copy");
        $tempElement.remove();

        $this.text('Copied');
    })
</script>

<!-- <script type="text/javascript">
    const makeQR = (url, Qr_code) => {
        var qrcode = new QRCode("qrcode", {
            text: "http://jindo.dev.naver.com/collie",
            width: 300,
            height: 300,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrcode.makeCode(url);

        setTimeout(() => {
            let qelem = document.querySelector('#qrcode img')
            let dlink = document.querySelector('#qrdl')
            let qr = qelem.getAttribute('src');
            dlink.setAttribute('href', qr);
            dlink.setAttribute('download', 'Qr_code');
            dlink.removeAttribute('hidden');
        }, 500);
    }

    makeQR(document.querySelector('#text').value, 'qr-code.png')
</script> -->
<!-- <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> -->
<script>
    // console.log($('.convert'))
    const elm = document.querySelector('.convert');
    // const elm = $('.convert');
    html2canvas(elm, {backgroundColor: "transparent"}).then(canvas => {

        document.querySelector('.result').append(canvas);
        // let cvs_qr = $('canvas')[0];
        // console.log(cvs_qr);
        // $('.qr_div').html(cvs_qr);
        // console.log($('canvas')[1]);
        let cvs = $('canvas')[1];
        let anchor = document.querySelector('#btn-downloadQR');
        anchor.href = cvs.toDataURL();
        anchor.download = "qrcode.png";
    });
</script>