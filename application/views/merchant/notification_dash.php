<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style>
    /*.card {
        border-radius: 20px !important;
    }
    .card.content-card .card-title {
        padding: 20px 40px !important;
    }
    .card.content-card .card-detail {
        padding: 25px !important;
    }*/
    .right-grid-main {
        border-radius: 0px !important;
        margin-bottom: 0px !important;
    }
    .right-grid-body {
        margin-top: 20px !important;
    }
    .grid-chart {
        margin-top: 40px !important;
    }
    .invoice-logo {
        height: 75px;
        width: 150px;
    }
    .date-text {
        color: rgb(148, 148, 146);
        font-size: 14px;
        margin-bottom: 0rem !important;
    }
    .heading-text {
        color: rgb(0, 166, 255);
        font-size: 24px;
        letter-spacing: 5px;
        font-weight: 700 !important;
        margin-bottom: 0px !important;
    }
    .invoice-number {
        font-size: 14px;
    }
    .owner-name {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 0px !important;
    }
    .mail-phone-text {
        font-size: 14px;
        color: rgb(148, 148, 146);
        font-weight: 400 !important;
        margin-bottom: 0px !important;
    }
    .item-head {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 0px !important;
    }
    .item-detail-hr {
        width: 20% !important;
    }
    .item-details-table tr td {
        font-size: 16px;
        font-weight: 500 !important;
    }
    .item-details-table tr {
        height: 45px;
    }
    .item-table-border {
        border-bottom: 1px solid rgb(245, 245, 251);
    }
    .payment-details-table tr td {
        height: 30px !important;
    }
    .payment-details-table tr td {
        font-size: 13px;
        font-weight: 400 !important;
    }
    .payment-details-table tr td.left {
        color: rgb(105, 105, 105);
    }
    .terms-text {
        font-weight: 400 !important;
        font-size: 11px !important;
        color: rgb(148, 148, 146);
    }
    .signature-size {
        max-width: 200px;
        max-height: 80px;
        margin-bottom: 20px;
    }
    .invoice-to-text {
        color: rgb(105, 105, 105);
        font-size: 22px;
        font-weight: 400;
    }
    .noti_mt_auto {
        padding: 0px 25px !important;
    }

    @media screen and (max-width: 640px) {
        .noti_mt_auto {
            padding: 0px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .date-text {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .heading-text {
            font-size: 24px;
        }
    }
    @media screen and (max-width: 640px) {
        .invoice-number {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .footer_t_c {
            font-size: 12px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .owner-name {
            font-size: 19px;
        }
    }
    @media screen and (max-width: 640px) {
        .mail-phone-text {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .item-head {
            font-size: 19px;
        }
    }
    @media screen and (max-width: 640px) {
        .item-details-table thead tr th {
            font-size: 13px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .item-details-table tbody tr td {
            font-size: 13px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .payment-details-table tr td {
            font-size: 12px !important;
        }
    }
</style>

<div class="page-content-wrapper pos-page">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Notification</h4> -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8" style="margin: auto;">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto noti_mt_auto">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <p class="invoice-number">Merchant Copy</p>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 20px !important;">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="display-avatar" style="padding: 0px !important;">
                                                    <?php if(isset($merchantdata[0]['logo']) && $merchantdata[0]['logo']!=''){ ?>
                                                        <img class="invoice-logo" src="<?php echo base_url(); ?>logo/<?php echo $merchantdata[0]['logo']; ?>" alt="logo">
                                                    <?php } else { ?>
                                                        <div class="img-lg-custom-text">
                                                            <?php echo substr($this->session->userdata('merchant_name'),0,1); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                <p class="date-text"><?php echo $gettransaction['add_date']; ?></p>
                                                <p class="heading-text">RECEIPT</p>
                                                <p class="invoice-number"><?php echo $gettransaction['invoice_no']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 20px !important;">
                                            <div class="col-sm-6 col-md-6 col-lg-6"></div>
                                            <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                                                <p class="owner-name">
                                                    <?php echo $merchantdata[0]['name']; ?>
                                                </p>
                                                <?php if($merchantdata[0]['mob_no']) { ?>
                                                    <p class="mail-phone-text"><?php echo $merchantdata[0]['mob_no']; ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <!-- <p class="invoice-to-text">Invoice To</p> -->
                                                <?php if($gettransaction['name']!="") { ?>
                                                    <p class="invoice-number"><?php echo $gettransaction['name']; ?></p>
                                                <?php } ?>
                                                <?php if(isset($gettransaction['sign'])) { ?>
                                                    <img src="<?php echo $gettransaction['sign']; ?>" class="signature-size">
                                                <?php } else { ?>
                                                    <div style="height: 80px;">N/A</div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <p class="item-head">Payment Details</p>
                                                <table class="payment-details-table" style="width: 100%">
                                                    <tr>
                                                        <td width="50%" class="left">Total Amount</td>
                                                        <td width="50%" style="text-align: right;">$ <?php echo $gettransaction['amount'] ? $gettransaction['amount']:'0.00'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%" class="left">Transaction ID</td>
                                                        <td width="50%" style="text-align: right;"><?php echo $gettransaction['transaction_id'] ? $gettransaction['transaction_id'] : '-'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%" class="left">Reference</td>
                                                        <td width="50%" style="text-align: right;"><?php echo $gettransaction['reference'] ? $gettransaction['reference']:'-'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%" class="left">Card Type</td>
                                                        <td width="50%" style="text-align: right;"><?php echo $gettransaction['card_type'] ? $gettransaction['card_type'] : '-'; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p style="margin-bottom: 0px !important;">Payment Status: <span class="<?php if($gettransaction['transaction_id']!="") { echo 'pos_Status_c'; }else{ echo 'pos_Status_cncl'; }?>"><?php if($gettransaction['transaction_id']!="") { echo 'Paid'; }else{ echo 'Unpaid'; } ?></p>
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