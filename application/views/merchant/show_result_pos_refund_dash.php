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
        border-top: 1px solid lightgray !important;
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
</style> 

<?php //print_r($pay_report); 
//print_r($refundData);
foreach ($pay_report as $row) { ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="invoice-number">Merchant Copy</p>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px !important;">
                <div class="col-6"> 
                    <div class="display-avatar" style="padding: 0px !important;">
                        <?php if($this->session->userdata('merchant_logo')) { ?>
                            <img class="invoice-logo" src="<?php echo base_url()."logo/".$this->session->userdata('merchant_logo'); ?>" alt="logo">
                        <?php } else { ?>
                            <div class="img-lg-custom-text">
                                <?php echo substr($this->session->userdata('merchant_name'),0,1); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-6 text-right">
                    <?php if(isset($refundData[0]['add_date']) && !empty($refundData[0]['add_date'])) {
                        if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago') {
                            $time_Zone=$this->session->userdata('time_zone');
                            date_default_timezone_set('America/Chicago');
                            $datetime = new DateTime($refundData[0]['add_date']);
                            $la_time = new DateTimeZone($time_Zone);
                            $datetime->setTimezone($la_time); 
                            $row->date_c=$datetime->format('Y-m-d H:i:s');
                        } ?>
                        <p class="date-text"><?php echo date("M d, Y", strtotime($row->date_c)); ?></p>
                    <?php } ?>
                    <p class="heading-text">REFUND RECEIPT</p>
                    <p class="invoice-number"><?php echo (isset($row->invoice_no) && !empty($row->invoice_no))? $row->invoice_no : "-"; ?></p>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px !important;">
                <div class="col-6"></div>
                <div class="col-6 text-right">
                    <?php if($this->session->userdata('business_dba_name')) { ?>
                        <p class="owner-name"><?php echo $this->session->userdata('business_dba_name'); ?></p>
                    <?php } ?>
                    <p class="mail-phone-text"><?php echo ($this->session->userdata('website')) ?  $this->session->userdata('website'): ""; ?></p>
                    <?php if($this->session->userdata('m_business_number')) { ?>
                        <p class="mail-phone-text"><?php echo $this->session->userdata('m_business_number');?></p>
                    <?php } ?>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px !important;">
                <div class="col-6">
                    <!-- <p class="invoice-to-text">Invoice To</p> -->
                    
                </div>
                <div class="col-6">
                    
                </div>
            </div>
            
            <?php
            if(isset($item) && count($item) >0 ){
                $recipt='<div class="row" style="margin-bottom: 20px !important;">
                    <div class="col-12">
                        <div class="undergo-head">
                            <span class="item-head">Item Details</span>
                            <div class="line-b4-head"></div>
                        </div>
                        <table class="item-details-table" style="width: 100%">
                            <tbody>';
                            $i=1;
                            $subtotalamt=0;
                            foreach($item as $pos){
                                $recipt=$recipt.'<tr class="item-table-border">
                                    <td width="10%">'.$pos['quantity'].'x</td>
                                    <td>'.$pos['name'].'</td>
                                    <td width="30%" style="text-align: right;">$ '.number_format($pos['price'],2).'</td>
                                </tr>';
                                $subtotalamt=$subtotalamt+$pos['price']; 
                                $i++;
                            }
                            $recipt.='</tbody>
                            <tfoot>
                                <tr>
                                    <td width="10%"></td>
                                    <td style="padding: 5px 1px;font-size: 18px;font-weight: 600 !important;">Total</td>
                                    <td width="30%" style="text-align: right;font-size: 18px;font-weight: 600 !important;">$ '.number_format($subtotalamt,2).'</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>';
                echo $recipt;
            } else {
                $subtotalamt=0;
            } ?>

            <div class="row" style="margin-bottom: 20px !important;">
                <div class="col-6">
                    <?php if($row->name) { ?>
                        <p class="invoice-number"><?php echo $row->name; ?></p>
                    <?php } ?>
                    <?php if($row->sign) { ?>
                        <img src="<?php echo base_url(); ?>logo/<?php echo $row->sign; ?>" class="signature-size">
                    <?php } else { ?>
                        <div style="height: 80px;">N/A</div>
                    <?php } ?>

                    <p class="terms-text" style="margin-bottom: 0px !important;text-align: justify !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p>
                    <p class="terms-text" style="text-align: justify !important;margin-bottom: 20px !important;">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>

                    <?php if(count($refundData)) { ?>
                        <span style="font-family: Avenir-Heavy;font-size: 18px;">Refunded</span><br>
                        <?php
                        $ttlrefunded = 0;
                        foreach($refundData as $rowdata) {
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
                                    $ <?php $refundAmount=$rowdata['amount']?$rowdata['amount']:$row->amount; echo number_format($refundAmount,2); 
                                    $ttlrefunded += $rowdata['amount']?$rowdata['amount']:$row->amount;  ?>
                                </span>
                                <span>On</span>
                                <span>
                                    <?php if($rowdata['add_date']) {
                                        echo $newDate = date("F d, Y", strtotime($rowdata['add_date']));
                                    } else {
                                        echo '-';
                                    } ?>
                                </span>
                            </span>
                        <?php }

                        if(!$ttlrefunded) {
                            $ttlrefunded=$row->amount;
                        }

                    } else {
                        $ttlrefunded=0;
                    } ?>
                </div>
                <div class="col-6">
                    <div class="undergo-head">
                        <span class="item-head">Payment Details</span>
                        <div class="line-b4-head"></div>
                    </div>
                    <table class="payment-details-table" style="width: 100%">
                        <tbody>
                            <?php if($row->transaction_type == 'split') { ?>
                                <tr>
                                    <td width="50%" class="left">Sub Amount</td>
                                    <td width="50%" style="text-align: right;">$ <?php  echo  $subtotalamt? number_format($subtotalamt,2):number_format($row->full_amount,2); ?></td>
                                </tr>
                                <?php if(isset($row->discount) && $row->discount!='0' && $row->discount!='' ){
                                    $DisAmount = $row->tax + $row->total_amount - $row->full_amount;
                                    if($DisAmount!=0) { ?>
                                        <tr>
                                            <td width="50%" class="left">Total Discount</td>
                                            <td width="50%" style="text-align: right;">- $ <?php echo number_format($DisAmount,2);  ?></td>
                                        </tr>
                                    <?php }
                                } 

                                if(isset($item) && count($item) > 0  && $row->tax  > 0) { ?>
                                    <tr>
                                        <td width="50%" class="left">Total Taxes</td>
                                        <td width="50%" style="text-align: right;">$ <?php echo number_format($row->tax,2); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td width="50%" class="left">Total Amount</td>
                                    <td width="50%" style="text-align: right;"><?php echo (isset($row->full_amount) && !empty($row->full_amount)) ? '$ '. number_format($row->full_amount,2) : "-"; ?></td>
                                </tr>
                                <?php if(isset($row->tip_amount) && !empty($row->tip_amount) && $row->tip_amount!=0) { ?>
                                    <tr>
                                        <td width="50%" class="left">Total Tip</td>
                                        <td width="50%" style="text-align: right;">$ <?php echo (isset($row->tip_amount) && !empty($row->tip_amount))? number_format($row->tip_amount,2) : "-"; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td width="50%" class="left">Split Amount</td>
                                    <td width="50%" style="text-align: right;"><?= !empty($row->amount) ? '$ '.number_format($row->amount,2) : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="left">Refunded Amount</td>
                                    <td width="50%" style="text-align: right;">$ <?php $refund=$refundData[0]['amount']?$refundData[0]['amount']:$row->amount; echo number_format($refund,2); ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="left">Transaction Id</td>
                                    <td width="50%" style="text-align: right;"><?php echo $refundData[0]['transaction_id'] ? $refundData[0]['transaction_id'] : '-'; ?></td>
                                </tr>

                            <?php } else { ?>
                                <tr>
                                    <td width="50%" class="left">Sub Amount</td>
                                    <td width="50%" style="text-align: right;">$ <?php  echo  number_format($row->total_amount,2); ?></td>
                                </tr>
                                <?php if(isset($row->discount) && $row->discount!='0' && $row->discount!='') {
                                    $DisAmount=$row->tax+$row->total_amount-$row->amount;
                                    if($DisAmount!=0) { ?>
                                        <tr>
                                            <td width="50%" class="left">Total Discount</td>
                                            <td width="50%" style="text-align: right;">- $ <?php echo number_format($DisAmount,2);  ?></td>
                                        </tr>
                                    <?php }
                                } 

                                if(isset($item) && count($item) > 0  && $row->tax  > 0) { ?>
                                    <tr>
                                        <td width="50%" class="left">Total Taxes</td>
                                        <td width="50%" style="text-align: right;"><?php echo number_format($row->tax,2); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td width="50%" class="left">Total Amount</td>
                                    <td width="50%" style="text-align: right;"><?php echo (isset($row->amount) && !empty($row->amount)) ? '$ '. number_format($row->amount,2) : "-"; ?></td>
                                </tr>
                                <?php if(isset($row->tip_amount) && !empty($row->tip_amount) && $row->tip_amount!=0) { ?>
                                    <tr>
                                        <td width="50%" class="left">Total Tip</td>
                                        <td width="50%" style="text-align: right;">$ <?php echo (isset($row->tip_amount) && !empty($row->tip_amount))? number_format($row->tip_amount,2) : "-"; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td width="50%" class="left">Total Payable Amount</td>
                                    <td width="50%" style="text-align: right;">$ <?php echo (isset($row->amount) && !empty($row->amount) && $row->tax=='CNP' ) ? number_format($row->amount+$row->tax,2) : $row->amount; ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="left">Refunded Amount</td>
                                    <td width="50%" style="text-align: right;">$ <?php $refund = isset($refundData[0]['amount']) ? $refundData[0]['amount'] : $row->amount; echo number_format($refund,2); ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="left">Transaction Id</td>
                                    <td width="50%" style="text-align: right;"><?php echo isset($refundData[0]['transaction_id']) ? $refundData[0]['transaction_id'] : '-'; ?></td>
                                </tr>
                            <?php } ?>

                            <?php if(isset($row->card_type) && !empty($row->card_type) && ($row->c_type=='CNP' || $row->c_type=='CP')) { ?>
                                <tr>
                                    <td width="50%" class="left">Card Type</td>
                                    <td width="50%" style="text-align: right;"><?php echo (isset($row->card_type) && !empty($row->card_type))? $row->card_type : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="left">Last 4 digit on Card</td>
                                    <td width="50%" style="text-align: right;"><?php echo (isset($row->card_no) && !empty($row->card_no))? substr($row->card_no,-4) : "-"; ?></td>
                                </tr>
                                <?php if(isset($row->name) && !empty($row->name)) { ?>
                                    <tr>
                                        <td width="50%" class="left">Customer Name</td>
                                        <td width="50%" style="text-align: right;"><?php echo (isset($row->name) && !empty($row->name))? ucfirst($row->name) : "-"; ?></td>
                                    </tr>
                                <?php }
                            } else if(isset($row->card_type) && !empty($row->card_type) && $row->card_type=='CHECK') { ?>
                                <tr>
                                    <td width="50%" class="left">Payment Type</td>
                                    <td width="50%" style="text-align: right;"><?php echo (isset($row->card_type) && !empty($row->card_type))? $row->card_type : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td width="50%" class="left">Cheque No.</td>
                                    <td width="50%" style="text-align: right;"><?php echo (isset($row->card_no) && !empty($row->card_no)) ? $row->card_no : "-"; ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td width="50%" class="left">Payment Type</td>
                                    <td width="50%" style="text-align: right;"><?php echo (isset($row->card_type) && !empty($row->card_type))? $row->card_type : "-"; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-12">
                    <p class="terms-text" style="margin-bottom: 0px !important;">* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT</p>
                    <p class="terms-text" style="margin-bottom: 0px !important;">(MERCHANT AGREEMENT IF CREDIT VOUCHER)</p>
                    <p class="terms-text">** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>
                </div>
            </div> -->

        </div>          
    </div>
    
    <div class="modal-footer"> 
        <div class="col-12">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-right">
                    <button type="button" id="receiptSSendRequestPdf" name="submit" class="btn btn-rounded social-btn-outlined" style="width: 160px !important;"><i class="mdi mdi-arrow-down medium"></i>Save as PDF</button>

                    <button type="button" id="receiptSSendRequestPrint" name="submit" class="btn btn-rounded social-btn-outlined" style="width: 164px !important;"><i class="mdi mdi-arrow-down medium"></i>Print Receipt</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<script>
    $(document).ready(function(){
        $("input[name=allpos__reftypes]").change(function(){
            var vals=$(this).val(); 
            console.log(vals)
            if(parseInt(vals)) {
                $('.partRefund__amount').val('').attr('readonly','readonly');
            } else {
                $('.partRefund__amount').val('').removeAttr('readonly').focus();

            }
        });

        $(".partRefund__amount").on('blur',function(){
            var valsM=parseFloat($(this).attr('data-max')); 
            var newvals=parseFloat($(this).val()); 
            if(newvals >= valsM) { 
                $(".partRefund__amount").css({'color': 'initial'}).val('');;
                $('#allpos_fulref').trigger('click');
            }
        });

        $(".partRefund__amount").on('keyup',function(){
            var valsM=parseFloat($(this).attr('data-max')); 
            var newvals=parseFloat($(this).val());
            $this=$(this);
            if(newvals > valsM) { 
                // $('#transactioninv__fullrefund').trigger('click');
                $this.css({'color': '#d0021b'});
            } else {
                $this.css({'color': 'initial'});
            }
        }); 
    });

    function re_receipt(el,rowid) {
        $this=$(el);
        $this.html('<span class="fa fa-spinner fa-spin"></span> Receipt Re-Send');
        // alert(id); 
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/re_receipt'); ?>',   //  re_receipt_pos
            data: {'rowid':rowid ,'type':'all_request'},
            success: function (data){
                //$('.bbg').html(data);
                if(data=='200') {
                    // $('.rcptbtn').hide(); 
                    $this.html('<span class="fa fa-check status_success"></span> Receipt Re-Send');
                    setTimeout(function(){$this.html('Receipt Re-Send')},2000);
                    // //alert('Receipt re-send Successfully ...'); 
                    // $('.bbg').html('<span class="text-success"> Receipt re-send Successfully ...</span>');
                }
            }
        });
    }
</script>