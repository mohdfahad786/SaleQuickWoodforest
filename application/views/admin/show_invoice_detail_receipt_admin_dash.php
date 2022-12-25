<style>
    .modal-header {
        border-bottom: none !important;
    }
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
        max-height: 100px;
        max-width: 300px;
    }
    .date-text {
        color: rgb(148, 148, 146);
        font-size: 16px;
        margin-bottom: 0rem !important;
        font-family: AvenirNext-Medium !important;
    }
    .heading-text {
        color: rgb(0, 166, 255);
        font-size: 30px;
        /*letter-spacing: 5px;*/
        font-weight: 600 !important;
        margin-bottom: 0px !important;
        font-family: Avenir-Heavy !important;
    }
    .invoice-number {
        font-size: 18px;
        font-family: Avenir-Black !important;
    }
    .owner-name {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 0px !important;
        font-family: AvenirNext-Medium !important;
        color: #000;
    }
    .mail-phone-text {
        font-size: 16px;
        color: rgb(148, 148, 146);
        font-weight: 400 !important;
        margin-bottom: 0px !important;
        font-family: AvenirNext-Medium !important;
    }
    .item-head {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 0px !important;
        color: #000 !important;
        font-family: AvenirNext-Medium !important;
    }
    .item-detail-hr {
        width: 20% !important;
    }
    .item-details-table tbody tr td {
        font-size: 16px;
        font-weight: 400 !important;
        font-family: AvenirNext-Medium !important;
    }
    .item-details-table tbody tr {
        height: 45px;
    }
    .item-table-border {
        border-bottom: 1px solid rgb(245, 245, 251);
    }
    .item-details-table tfoot tr td {
        font-size: 16px;
        font-weight: 500 !important;
        font-family: AvenirNext-Medium !important;
    }
    .item-details-table tfoot tr {
        height: 45px;
        /*border-top: 1px solid lightgray !important;*/
    }
    .payment-details-table tr td {
        height: 30px !important;
        font-size: 14px;
        font-weight: 400 !important;
        font-family: AvenirNext-Medium !important;
    }
    .payment-details-table tr td.left {
        color: rgb(105, 105, 105);
    }
    .terms-text {
        font-weight: 400 !important;
        font-size: 8px !important;
        color: rgb(148, 148, 146);
        font-family: AvenirNext-Medium !important;
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
        font-family: AvenirNext-Medium !important;
    }
    .line-b4-head {
        height: 4px;
        width: 70px;
        background-color: #000;
    }
    .undergo-head {
        margin-bottom: 10px;
    }
    @media screen and (max-width: 640px) {
        .invoice-logo {
            max-height: 75px;
            max-width: 175px;
        }
    }
    @media screen and (max-width: 640px) {
        .date-text {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .heading-text {
            font-size: 20px;
        }
    }
    @media screen and (max-width: 640px) {
        .invoice-number {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .owner-name {
            font-size: 20px;
        }
    }
    @media screen and (max-width: 640px) {
        .mail-phone-text {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .item-head {
            font-size: 20px;
        }
    }
    @media screen and (max-width: 640px) {
        .item-details-table tbody tr td {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .payment-details-table tr td {
            font-size: 12px;
        }
    }
    @media screen and (max-width: 640px) {
        .invRecptMdlWrapper .irm-pay-title, .invRecptMdlWrapper .irm-to-title {
            font-size: 14px;
        }
    }
</style>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>

<div class="modal-body">
    <div id="new_receipt_body" class="col-12">
        <div class="row">
            <div class="col-12 text-center">
                <p class="invoice-number">Customer Copy</p>
            </div>
        </div>
        
        <div class="row" style="margin-bottom: 20px !important;">
            <div class="col-sm-6 col-md-6 col-lg-6"> 
                <div class="display-avatar" style="padding: 0px !important;">
                    <?php if($merchant_data[0]['logo']) { ?>
                        <img class="invoice-logo" src="<?= base_url()."logo/".$merchant_data[0]['logo']; ?>" alt="logo">
                    <?php } else { ?>
                        <div class="img-lg-custom-text">
                            <?php echo substr($merchant_data[0]['name'],0,1); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                <?php if(isset($invoice_detail_receipt[0]->date_c) && !empty($invoice_detail_receipt[0]->date_c)) {
                    if($this->session->userdata('time_zone') && $this->session->userdata('time_zone') != 'America/Chicago') {
                        $time_Zone=$this->session->userdata('time_zone');
                        date_default_timezone_set('America/Chicago');
                        $datetime = new DateTime($invoice_detail_receipt[0]->date_c);
                        $la_time = new DateTimeZone($time_Zone);
                        $datetime->setTimezone($la_time);
                        $invoice_detail_receipt[0]->date_c=$datetime->format('Y-m-d H:i:s');
                    } ?>
                    <p class="date-text"><?php echo date("M d Y", strtotime($invoice_detail_receipt[0]->date_c)); ?></p>
                <?php } ?>

                <p class="heading-text">RECEIPT</p>
                <p class="invoice-number"><?php echo (isset($invoice_detail_receipt[0]->invoice_no) && !empty($invoice_detail_receipt[0]->invoice_no))? $invoice_detail_receipt[0]->invoice_no : "-"; ?></p>
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px !important;">
            <div class="col-sm-6 col-md-6 col-lg-6"></div>
            <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                <?php if($merchant_data[0]['business_dba_name']) { ?>
                    <p class="owner-name"><?php echo $merchant_data[0]['business_dba_name']; ?></p>
                <?php } ?>
                <?php if($merchant_data[0]['website']) { ?>
                    <p class="mail-phone-text"><?php echo $merchant_data[0]['website']; ?></p>
                <?php } ?>
                <?php if($merchant_data[0]['business_number']) { ?>
                    <p class="mail-phone-text"><?php echo $merchant_data[0]['business_number']; ?></p>
                <?php } ?>
            </div>
        </div>
        
        <div class="row" style="margin-bottom: 20px !important;">
            <div class="col-12">
                <div class="undergo-head">
                    <span class="item-head">Item Details</span>
                    <div class="line-b4-head"></div>
                </div>
                <table class="item-details-table" style="width: 100%">
                    <tbody>
                        <?php
                        $itemLength=!empty($invoice_detail_receipt_item[0]['quantity'])?count(json_decode($invoice_detail_receipt_item[0]['quantity'])):0;
                        for($i=0; $i<$itemLength; $i++) {
                            $quantity=json_decode($invoice_detail_receipt_item[0]['quantity']);
                            $price=json_decode($invoice_detail_receipt_item[0]['price']);
                            $tax=json_decode($invoice_detail_receipt_item[0]['tax']);
                            $tax_id=json_decode($invoice_detail_receipt_item[0]['tax_id']);
                            $tax_per=json_decode($invoice_detail_receipt_item[0]['tax_per']);
                            $total_amount=json_decode($invoice_detail_receipt_item[0]['total_amount']);
                            $item_name=json_decode($invoice_detail_receipt_item[0]['item_name']);
                        ?>
                            <tr class="item-table-border">
                                <td width="10%"><?=$quantity[$i]; ?>x</td>
                                <td><?=$item_name[$i]; ?></td>
                                <td width="30%" style="text-align: right;">$ <?=number_format($total_amount[$i],2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td width="10%"></td>
                            <td style="padding: 5px 1px;font-size: 18px;font-weight: 600 !important;">Sub Total</td>
                            <td width="30%" style="text-align: right;font-size: 18px;font-weight: 600 !important;">
                                <?php
                                $subttl1 = $invoice_detail_receipt[0]->amount;
                                $subttl2 = $invoice_detail_receipt[0]->tax;
                                $late_fee = $invoice_detail_receipt[0]->late_fee;
                                echo '$ '.number_format(($subttl1 - $subttl2 - $late_fee),2); ?>
                            </td>
                        </tr>
                        <?php if($itemLength > 0 && $invoice_detail_receipt[0]->tax > 0 ) { ?>
                            <tr>
                                <td width="10%"></td>
                                <td style="padding: 5px 1px;font-size: 18px;font-weight: 600 !important;">Tax</td>
                                <td width="30%" style="text-align: right;font-size: 18px;font-weight: 600 !important;">
                                    <?php echo (isset($invoice_detail_receipt[0]->tax) && !empty($invoice_detail_receipt[0]->tax)) ? '$'.$invoice_detail_receipt[0]->tax : "-"; ?>
                                </td>
                            </tr>
                         <?php } ?>
                         
                         <?php if($invoice_detail_receipt[0]->other_charges > 0) { ?>
                            <tr>
                                <td width="10%"></td>
                                <td style="padding: 5px 1px;font-size: 18px;font-weight: 600 !important;"><?= $invoice_detail_receipt[0]->otherChargesName; ?></td>
                                <td width="30%" style="text-align: right;font-size: 18px;font-weight: 600 !important;">
                                    <?= '$'.number_format($invoice_detail_receipt[0]->other_charges,2); ?>
                                </td>
                            </tr>
                         <?php } ?>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row" style="margin-bottom: 15px !important;margin-top: 5px !important;">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="col-12">
                        <?php if($invoice_detail_receipt[0]->sign!="") {
                            $base64_string=$invoice_detail_receipt[0]->sign; 
                            $img = str_replace('data:image/png;base64,', '', $base64_string);
                            $img = str_replace(' ', '+', $img);  
                            $img = base64_decode($img);
                            $file='signature_'.uniqid().'.png';
                            $success=file_put_contents('uploads/sign/'.$file, $img);

                            if($invoice_detail_receipt[0]->name) { ?>
                                <p class="invoice-number"><?php echo $invoice_detail_receipt[0]->name; ?></p>
                            <?php } ?>
                            
                            <img src="<?php echo base_url('uploads/sign/'); ?><?php echo $file; ?>" class="signature-size"/>

                            <p class="terms-text" style="margin-bottom: 0px !important;text-align: justify !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p>
                            <p class="terms-text" style="text-align: justify !important;">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>
                        <?php } ?>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px !important;">
                    <div class="col-12 text-right" style="margin-bottom: 15px;">
                        <?php if(count($refundData) > 0 ) { ?>
                            <span style="font-family: Avenir-Heavy;font-size: 18px;">Refunded</span><br>
                                <?php 
                                $refundedAmt=0;
                                foreach($refundData as $rowdata) { 
                                    // DATE Convert According to  the  merchant Time Zone 
                                    if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago') {
                                        $time_Zone=$this->session->userdata('time_zone');
                                        date_default_timezone_set('America/Chicago');
                                        $datetime = new DateTime($rowdata['add_date']);
                                        $la_time = new DateTimeZone($time_Zone);
                                        $datetime->setTimezone($la_time);
                                        $rowdata['add_date']=$datetime->format('Y-m-d H:i:s');
                                    } ?>
                                    <span class="" style="font-family: AvenirNext-Medium !important;font-size: 16px !important;">
                                        <span class="status_success">
                                            <?php $refundedAmt += $rowdata['amount'];  if($rowdata['amount']!="") { echo '$'.$rowdata['amount']; }else{ echo '$0'; }  ?>,
                                        </span>
                                        <span>On</span>
                                        <span><?php echo date('M j,Y g:i a',strtotime($rowdata['add_date'])); ?></span>
                                    </span>
                                    <br>
                                <?php } ?>

                        <?php } else {
                            $refundedAmt = 0;
                        } ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="undergo-head">
                    <span class="item-head">Payment Details</span>
                    <div class="line-b4-head"></div>
                </div>
                <table class="payment-details-table" style="width: 100%">
                    <tbody>
                        <?php 
                        $late_grace_period = !empty($merchant_data[0]->late_grace_period)?$merchant_data[0]->late_grace_period:'0';
                        if(!empty($invoice_detail_receipt[0]->late_fee)) { ?>
                            <tr>
                                <td width="50%" class="left">Late Fee</td>
                                <td width="50%" style="text-align: right;"><?php echo (isset($invoice_detail_receipt[0]->late_fee) && !empty($invoice_detail_receipt[0]->late_fee)) ? '$'. $invoice_detail_receipt[0]->late_fee : "0"; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td width="50%" class="left">Total Amount</td>
                            <td width="50%" style="text-align: right;"><?php echo (isset($invoice_detail_receipt[0]->amount) && !empty($invoice_detail_receipt[0]->amount))? '$'.$invoice_detail_receipt[0]->amount : "-"; ?></td>
                        </tr>
                        <tr>
                            <td width="50%" class="left">Transaction ID</td>
                            <td width="50%" style="text-align: right;"><?php echo (isset($invoice_detail_receipt[0]->transaction_id) && !empty($invoice_detail_receipt[0]->transaction_id))? $invoice_detail_receipt[0]->transaction_id : "-"; ?></td>
                        </tr>
                        <tr>
                            <td width="50%" class="left">Reference</td>
                            <td width="50%" style="text-align: right;"><?php echo (isset($invoice_detail_receipt[0]->reference) && !empty($invoice_detail_receipt[0]->reference))? $invoice_detail_receipt[0]->reference : "-"; ?></td>
                        </tr>
                        <tr>
                            <td width="50%" class="left">Card Type</td>
                            <td width="50%" style="text-align: right;"><?php echo (isset($invoice_detail_receipt[0]->card_type) && !empty($invoice_detail_receipt[0]->card_type))? $invoice_detail_receipt[0]->card_type : "-"; ?></td>
                        </tr>
                        <tr>
                            <td width="50%" class="left">Last 4 digits on Card</td>
                            <td width="50%" style="text-align: right;"><?php echo (isset($invoice_detail_receipt[0]->card_no) && !empty($invoice_detail_receipt[0]->card_no))? substr ($invoice_detail_receipt[0]->card_no,-4) : "-"; ?></td>
                        </tr>
                        <?php if($invoice_detail_receipt[0]->name_card!='') { ?>
                            <tr>
                                <td width="50%" class="left">Customer Name</td>
                                <td width="50%" style="text-align: right;"><?php echo (isset($invoice_detail_receipt[0]->name_card) && !empty($invoice_detail_receipt[0]->name_card))? ucfirst($invoice_detail_receipt[0]->name_card) : "-"; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td width="50%" class="left">Payment Status</td>
                            <td width="50%" style="text-align: right;text-transform: uppercase;">
                                <?php 
                                if(!empty($invoice_detail_receipt[0]->status) && $invoice_detail_receipt[0]->status=='Chargeback_Confirm') {
                                    echo 'confirm'; 
                                }else if (!empty($invoice_detail_receipt[0]->status) && $invoice_detail_receipt[0]->status!='') {
                                    echo $invoice_detail_receipt[0]->status; 
                                } else { 
                                    echo '-';   
                                } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if(($invoice_detail_receipt[0]->status == 'confirm' || $invoice_detail_receipt[0]->status == 'Chargeback_Confirm') && $refundedAmt < $invoice_detail_receipt[0]->amount) { ?>
            <!-- <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="irm-pay-title" style="padding-left: 0px;"><span>Refund Type </span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="irm-pay-detail custom-form">
                        <div class="row" style="margin-top: 5px !important;">
                            <div class="col-6">
                                <span class="custom-checkbox">
                                    <input type="radio" id="allpos_fulref" class="radio-circle" value="1" name="allpos__reftypes" checked="">
                                    <label for="allpos_fulref" class="inline-block">Full Refund :</label>
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="custom-checkbox">
                                    <input type="radio" id="allpos_partref" class="radio-circle" value="0" name="allpos__reftypes" >
                                    <label for="allpos_partref" class="inline-block">Partial Refund :</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-9" style="padding-right: 0px !important;">
                            <input class="form-control fullRefund__amount" readonly name="amount" value="<?php echo $invoice_detail_receipt[0]->amount-$refundedAmt; ?>" style="height: auto !important;border-top-right-radius: 0px !important;border-bottom-right-radius: 0px !important; "  type="text">
                            <input class="form-control partRefund__amount" readonly name="amount" value="" style="height: auto !important;border-top-right-radius: 0px !important;border-bottom-right-radius: 0px !important; " data-max="<?php echo $invoice_detail_receipt[0]->amount-$refundedAmt; ?>"  type="text" onKeyPress="return isNumberKeyOnedc(this,event)" placeholder="Partial Amount">
                        </div>

                        <div class="col-3" style="padding-left: 0px !important;">
                            <form id="sRefform" action="<?php echo base_url(); ?>dashboard/refund" method="post" style=" display: inline;">
                            <input class="form-control" name="invoice_no" id="invoice_no" value="<?php echo $invoice_detail_receipt[0]->invoice_no ?>" readonly required type="hidden">
                            <input class="form-control" name="amount" id="amount" value="<?php echo $invoice_detail_receipt[0]->amount; ?>" readonly required type="hidden">
                            <input class="form-control" name="transaction_id" id="transaction_id" value="<?php echo $invoice_detail_receipt[0]->transaction_id ?>" readonly required type="hidden">
                            <input class="form-control" name="payment_id" id="payment_id" value="<?php echo $invoice_detail_receipt[0]->payment_id ?>" readonly required type="hidden">
                            <input class="form-control" name="id" id="id" value="<?php echo $invoice_detail_receipt[0]->id ?>" readonly required type="hidden">
                            <input class="form-control" name="merchant_id" id="merchant_id" value="<?php echo $invoice_detail_receipt[0]->merchant_id ?>"  readonly required type="hidden">
                            <input class="form-control" name="refundfor" id="" value="recurring"  type="hidden" required>
                                <button type="button" id="receiptSSendRequest" name="submit" class="btn btn-first" disabled style="height: 33px !important;padding-top: 5px !important;border-top-left-radius: 0px !important;border-bottom-left-radius: 0px !important;">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->
        <?php } ?>
    </div>
</div>

<div class="modal-footer">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <button type="button" id="receiptSSendRequestPdf" name="submit" class="btn btn-rounded social-btn-outlined" style="width: 150px !important;font-size: 12px !important;"><i class="mdi mdi-arrow-down medium"></i>Save as PDF</button>
        <button type="button" id="receiptSSendRequestPrint" name="submit" class="btn btn-rounded social-btn-outlined" style="width: 152px !important;font-size: 12px !important;margin-left:5px;"><i class="mdi mdi-arrow-down medium"></i>Print Receipt</button>
        <button type="submit" id="resend-recept" onclick="resendreceipt(this,<?=$invoice_detail_receipt[0]->id; ?>)" name="submit" class="btn btn-rounded social-btn-outlined" style="width: 172px !important;font-size: 12px !important;"><i class="mdi mdi-send medium"></i>Receipt Re-Send</button>
    </div>
</div>

<style type="text/css">
    .total__refunds {
        clear: both;
    }
    .total__refunds>span {
        max-width: 60%;
        width: auto;
        font-size: 12px;
        float: left;
        padding: 4px 7px;
        min-width: 90px;
    }
    span.total__refunds:first-of-type {
        margin-bottom: 0;
        font-weight: 600;
    }
</style>

<script>
    $(document).ready(function(){
        $("input[name=allpos__reftypes]").change(function(){
            $('#receiptSSendRequest').prop("disabled", false);
            var vals=$(this).val(); 
            console.log(vals)
            if(parseInt(vals)) {
                $('.partRefund__amount').val('').attr('readonly','readonly');
            } else {
                $('.partRefund__amount').val('').removeAttr('readonly').focus();
            }

            if ($('#allpos_fulref').is(':checked')) {
                $('.partRefund__amount').addClass('d-none');
                $('.fullRefund__amount').removeClass('d-none');
            } else {
                $('.fullRefund__amount').addClass('d-none');
                $('.partRefund__amount').removeClass('d-none');
            }
        }); 

        $(".partRefund__amount").on('blur',function(){
            var valsM=parseFloat($(this).attr('data-max')); 
            var newvals=parseFloat($(this).val()); 
            if(newvals >= valsM) { 
                $(".partRefund__amount").css({'color': 'initial'}).val('');
                // $('#allpos_fulref').trigger('click');
            }
        }); 

        $(".partRefund__amount").on('keyup',function(){
            var valsM=parseFloat($(this).attr('data-max')); 
            var newvals=parseFloat($(this).val());
            $this=$(this);
            if(newvals > valsM) { 
                // $('#transactioninv__fullrefund').trigger('click');
                alert('Amount must be less than original amount.')
                $this.css({'color': '#d0021b'});
            } else {
                $this.css({'color': 'initial'});
            }
        });

        if ($('#allpos_fulref').is(':checked')) {
            $('.partRefund__amount').addClass('d-none');
            $('.fullRefund__amount').removeClass('d-none');
        } else {
            $('.fullRefund__amount').addClass('d-none');
            $('.partRefund__amount').removeClass('d-none');
            
        }
        
        $("#invoice_my").on('click',function(){
            //alert('helooo');
            var $this=$(this);
            var rowid=$this.attr('alt');
            $this.html('<span class="fa fa-spinner fa-spin"></span> Sending Invoice');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('merchant/invoice_my'); ?>',
                data: {'rowid':rowid },
                beforeSend:function(data){$("#invoice_my").attr("disabled",true);},
                success: function (data){
                    if(data=='200')
                    {
                    $this.html('<span class="fa fa-check status_success"></span> Re-Sent Invoice!');
                    setTimeout(function(){$("#invoice_my").removeAttr("disabled");$this.html('Re-Send Invoice')},2000);
                    }
                }
            });
        });

    });
    
    $(document).on('click', '.receiptSSendRequestYes', function(e){
        e.preventDefault();
        $('#receiptSSendRequest').html('<span class="fa fa-spinner fa-spin"></span>');
    })
    
    function resendreceipt(el,rowid) {
        $this=$(el);
        $this.html('<span class="fa fa-spinner fa-spin"></span> Re-Sending Receipt');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/re_receipt'); ?>', 
            data: {'rowid':rowid ,'type':'request'},
            beforeSend:function(data){$("#resend-recept").attr("disabled",true);},
            success: function (data){
                //alert(data); 
                // console.log(data);
                //$('#mydiv').html(data);
                if(data=='200') {
                    $this.html('<span class="fa fa-check status_success"></span> Re-Sent Receipt !!');
                    setTimeout(function(){$("#resend-recept").removeAttr("disabled"); $this.html('Re-Send Receipt')},2000);
                } else if(data=='500') {
                    $this.html('<span class="fa fa-check status_danger text-danger"></span> Somthing went Wrong!');
                    setTimeout(function(){$("#resend-recept").removeAttr("disabled"); $this.html('Re-Send Receipt')},2000);
                }
            }
        });
    }
</script>