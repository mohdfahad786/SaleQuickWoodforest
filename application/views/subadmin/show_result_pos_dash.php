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
    @media screen and (max-width: 640px) {
        .invoice-logo {
            max-height: 80px;
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
            font-size: 27px;
        }
    }
    @media screen and (max-width: 640px) {
        .invoice-number {
            font-size: 15px;
        }
    }
    @media screen and (max-width: 640px) {
        .owner-name {
            font-size: 23px;
        }
    }
    @media screen and (max-width: 640px) {
        .mail-phone-text {
            font-size: 13px;
        }
    }
    @media screen and (max-width: 640px) {
        .item-head {
            font-size: 23px;
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
    @media screen and (max-width: 640px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 135px !important;
        }
    }
    @media screen and (min-width: 641px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 164px !important;
        }
    }
</style> 


    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>

    <div class="modal-body">
        <div id="new_receipt_body" class="col-12">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                    <p class="invoice-number">Merchant Detail</p>
                </div>
            </div>

           


            <div class="row" style="margin-bottom: 15px !important;margin-top: 5px !important;">

                <div class="col-sm-6 col-md-6 col-lg-6">
                  
                    <table class="payment-details-table" style="width: 100%">
                        <tbody>
                          
                                <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">Name</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['name']; ?></td>
                                </tr>
                                
                              <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">Email Id</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['email']; ?></td>
                                </tr>

                                 <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">Mobile No.</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['mob_no']; ?></td>
                                </tr>
                                
                              <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">Address</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['address1']; ?></td>
                                </tr>
                          
                               
                            
                            
                           
                        </tbody>
                    </table>
                </div>

                 <div class="col-sm-6 col-md-6 col-lg-6">
                  
                    <table class="payment-details-table" style="width: 100%">
                        <tbody>
                          
                                <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">Business Number</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['business_number']; ?></td>
                                </tr>
                                
                              <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">State</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['state']; ?></td>
                                </tr>

                                 <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">City</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['city']; ?></td>
                                </tr>
                                
                              <tr>
                                    <td width="50%" class="left" style="font-size: 18px;">Zip</td>
                                    <td width="50%" style="text-align: right;"> <?php echo $merchant_details[0]['zip']; ?></td>
                                </tr>
                          
                               
                            
                            
                           
                        </tbody>
                    </table>
                </div>
            </div>

           
        </div>
    </div>

   


<script>
$(document).ready(function(){
    $("input[name=allpos__reftypes]").change(function(){
        $('#receiptSSendRequest').prop("disabled", false);
        var vals=$(this).val(); 
        console.log(vals)
        if(parseInt(vals)) {
            $('.partRefund__amount').val('').attr('readonly','readonly');
        }else{
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
            alert('Amount must be less than original amount.');
            $this.css({'color': '#d0021b'});
        } else{
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
});

$(document).on('click', '.receiptSSendRequestYes', function(e){
    e.preventDefault();
    $('#receiptSSendRequest').html('<span class="fa fa-spinner fa-spin"></span>');
})

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
                if(data=='200')
                {
                    // $('.rcptbtn').hide(); 
                    $this.html('<span class="fa fa-check status_success"></span> Receipt Re-Send');
                    setTimeout(function(){$this.html('Receipt Re-Send')},2000);
                    // //alert('Receipt re-send Successfully ...'); 
                    // $('.bbg').html('<span class="text-success"> Receipt re-send Successfully ...</span>');
                }
                
        }
    });
}


function resendinvoice(el,rowid) {
    $this=$(el);
    $this.html('<span class="fa fa-spinner fa-spin"></span> Re-Sending Invoice');
        $.ajax({
        type: 'POST',
        url: '<?=base_url();?>merchant/re_invoice',
        data: {'rowid':rowid },
            beforeSend:function(data){$("#resend-invoice").attr("disabled",true);},
            success: function (data){
                console.log(data);
                if(data=='200')
                {
                $this.html('<span class="fa fa-check status_success"></span> Re-Sent Invoice!');
                setTimeout(function(){$("#resend-invoice").removeAttr("disabled");$this.html('Re-Send Invoice')},2000);
                }
            }
        });
}


</script>
