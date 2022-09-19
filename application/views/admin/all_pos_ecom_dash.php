<?php
    // include_once 'header_dash.php';
    include_once 'sidebar_dash.php';
?>

<style>
    .table tbody tr td span, table tbody tr td span {
        display: inline !important;
    }
    .action-styling {
        color: black !important;
        text-decoration: underline !important;
    }
    .resend_rcpt_btn_confirm {
        margin-top: 10px !important;
        font-family: AvenirNext-Medium !important;
        font-weight: 600;
        color: #000;
    }
    .resend_rcpt_btn_confirm:focus, .resend_rcpt_btn_confirm:hover {
        color: #000;
    }
    .resend_rcpt_btn {
        font-family: AvenirNext-Medium !important;
        color: #868e96 !important;
        padding: 0px 15px !important;
    }
    .resend_rcpt_btn:focus, .resend_rcpt_btn:hover {
        color: #000;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0em 0.5em !important;
    }
    @media screen and (max-width: 640px) {
        #pos_list_daterange span {
            font-size: 10px !important;
        }
    }
    @media screen and (max-width: 640px) {
        select.form-control {
            font-size: 10px !important;
        }
    }
    div.dataTables_wrapper div.dataTables_filter input {
        border:none !important;
    }
    .btn:not(.social-icon-btn).social-btn-outlined {
        width: 126px !important;
    }
    @media screen and (max-width: 640px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 110px !important;
            font-size: 12px !important;
        }
    }
    @media screen and (max-width: 640px) {
        .btn.social-btn-outlined i.medium {
            margin-right: 10px !important;
        }
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

            <?php $count = 0; ?>
            <form class="row" method="post" action="<?php echo base_url('pos/all_ecommerce'); ?>" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="pos_list_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                    </div>
                </div>
                
                <div class="table_custom_status_selector">
                    <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <?php
                        if (!empty($status) && isset($status)) {
                            ?>
                                <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?>>Paid</option>
                                <option value="Chargeback_Confirm" <?php echo (($status == 'Chargeback_Confirm') ? 'selected' : "") ?>>Refunded</option>
                                <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?>>Pending</option>
                        <?php
                        } else {?>
                                <option value="confirm">Paid</option>
                                <option value="Chargeback_Confirm">Refunded</option>
                                <option value="pending">Pending</option>
                        <?php
                        }
                        
                        ?>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="dt_inv_pos_sale_list" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Payment Details</th>
                                <th>Receipt</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="no-event"></th>
                                <!-- <th class="no-event"></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if(!empty($mem)) {
                                foreach ($mem as $a_data) {
                                    $count++; ?>
                                    <tr>
                                        <td title="<?php echo $a_data['c_type']; ?>" class="a"> &nbsp; <?php echo $a_data['transaction_id']; ?></td>

                                        <td>
                                            <span class="card-img-no">
                                                <span class="card-type-image" style="display: inline !important;">
                                                    <?php
                                                        $typeOfCard = strtolower($a_data['card_type']);
                                                        switch ($typeOfCard) {
                                                            case 'discover':
                                                                $card_image = 'discover.png';
                                                                break;
                                                            case 'mastercard':
                                                                $card_image = 'mastercard.png';
                                                                break;
                                                            case 'visa':
                                                                $card_image = 'visa.png';
                                                                break;
                                                            case 'jcb':
                                                                $card_image = 'jcb.png';
                                                                break;
                                                            case 'maestro':
                                                                $card_image = 'maestro.png';
                                                                break;
                                                            case 'dci':
                                                                $card_image = 'dci.png';
                                                                break;
                                                            case 'amex':
                                                                $card_image = 'amx.png';
                                                                break;
                                                            case 'american express':
                                                                $card_image = 'amx.png';
                                                                break;
                                                            default:
                                                                $card_image = 'other.png';
                                                        }
                                                        if ($card_image == 'other.png') {
                                                            $no = "";
                                                            if ($typeOfCard == "check") {
                                                                $check_img = '<img src="'.base_url('new_assets/img/check.png').'" style="display: inline;max-width: 35px;border-radius: 7px;margin-right: 5px;">';
                                                                $no = "(" . $a_data['card_no'] . ")";
                                                                echo $check_img . $no;
                                                            } else if($typeOfCard == "cash") {
                                                                $cash_img = '<img src="'.base_url('new_assets/img/cash.png').'" style="display: inline; max-width: 35px;border-radius: 7px;margin-right: 5px;">';
                                                                echo $cash_img;
                                                            } else {
                                                                echo $a_data['card_type'];
                                                            }
                                                        } else { ?>
                                                            <img src="<?=base_url()?>new_assets/img/<?php echo $card_image; ?>" alt="<?php echo $a_data['card_type'] ?>" style="display: inline; max-width: 35px;border-radius: 7px;margin-right: 5px;">
                                                </span>
                                                <?php echo !empty($a_data['card_no']) ? ('****' . substr($a_data['card_no'], -4)) : '********';} ?>
                                            </span>
                                        </td>

                                        <?php if($merchant_data[0]->csv_Customer_name > 0) { ?>
                                                <td class="noc"><?= $a_data['name']?></td>
                                        <?php } ?>

                                        <td><?php echo (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod'])) ? $a_data['repeiptmethod'] : 'No Receipt'; ?></td>

                                        <td><span class="status_success">$<?php echo number_format($a_data['amount'],2); //number_format($a_data['amount'], 2); ?></span></td>

                                        <td>
                                            <?php if ($a_data['status'] == 'pending') {
                                                echo '<span class="pos_Status_pend"> ' . ucfirst($a_data['status']) . '  </span>';
                                            } elseif ($a_data['status'] == 'confirm' || $a_data['status'] == 'Chargeback_Confirm') {
                                                echo '<span class="pos_Status_c"> Paid </span>';
                                            } elseif ($a_data['status'] == 'declined') {
                                                echo '<span class="pos_Status_cncl"> ' . ucfirst($a_data['status'])  . ' </span>'; //  pos_Status_cncl
                                            } elseif ($a_data['status'] == 'Refund') {
                                                echo '<span class="status_refund"> Refund  </span>';
                                            } ?>
                                        </td>

                                        <td><?php echo date("M d Y h:i A", strtotime($a_data['date'])); ?></td>

                                        <td style="width: 150px !important;">
                                            <?php
                                                if ($a_data['transaction_type'] == "split" && $a_data['status'] !='Refund') {?>
                                                <a class="pos_Status_c  badge-btn  " data-id=""    href="<?php echo base_url() . "pos/split_transactions/" . $a_data['transaction_id']; ?>" style="display: table-caption !important;"><span class="fa fa-eye"></span>  Split Transactions</a>

                                            <?php } elseif ($a_data['status'] == 'Refund') { ?>
                                            
                                                <a class="pos_Status_c  badge-btn  posrefund_receipt_vw_btn" data-id="<?php echo $a_data['id']; ?>" data-row-id="<?php echo $a_data['refund_row_id']; ?>" href="#" style="display: table-caption !important;"><span class="fa fa-eye"></span> Receipt</a>
                                            <?php } else { ?>
                                                <a href="#" class="poslist_vw_btn pos_Status_c badge-btn" data-id="<?php echo $a_data['id']; ?>" style="display: table-caption !important;"><span class="fa fa-eye"></span> Receipt</a>
                                            <?php }?>

                                            <?php if ($a_data['status'] == 'confirm' || $a_data['status'] == 'Chargeback_Confirm') { ?>
                                                <!-- <br> -->
                                                <span>
                                                    <a class="resend_rcpt_btn" data-id="<?php echo $a_data['id']; ?>" href="#">Re-send</a>
                                                </span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php $i++;
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center">No Data Found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loader-content" style="display: none;">
    <div id="modal-loader" class="text-center"  style="padding: 15px">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
    </div>
</div>
<style>
    @media screen and (min-width: 641px) {
        #invoice-receipt-modal .modal-content {
            padding: 0px 25px 15px 25px !important;
            border: none !important;
        }
    }
    @media screen and (max-width: 640px) {
        #invoice-receipt-modal .modal-content {
            padding: 0px 5px 15px 5px !important;
            border: none !important;
        }
    }
    
</style>
<div id="invoice-receipt-modal" class="invRecptMdlWrapper modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"  id="invoicePdfData">

        </div>
    </div>
</div>

<div id="receiptSSendRequest-modal" class="modal transform-modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><span class="fa fa-exclamation-triangle"></span> Confirm</h4>
            </div>
            <div class="modal-body">
                <p>Refund : <input type="text" class="sure_refund form-control status_success" readonly> <span class="h4" >Are you sure?</span></p>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button type="button" class="btn btn-first" id="receiptSSendRequestYes"><span class="fa fa-check"></span> Complete</button>
                    <button type="button" class="btn btn-second" id="receiptSSendRequestNo"><span class="fa fa-close"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header {
        border-bottom: none !important;
    }
</style>

<div id="resendReceiptModal" class="modal fade">
    <div class="modal-dialog"> 
        <div class="modal-content" id="resendReceipt"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="col-12" style="margin-bottom: 10px !important;">
                    <div class="form-title">Re-sent Receipt</div>
                    
                    <div class="form-group" style="margin-bottom: 0rem !important;">
                        <label for="">Phone</label>
                        <!-- <input type="text" class="form-control" placeholder="Phone" name="mobile_no" id="phone"> -->
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Phone" name="mobile_no" id="re_mobile">
                            <div class="input-group-append">
                                <button class="btn btn-info resend_phone_receipt" type="submit">Send</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <label for="" style="margin-top: 10px !important;">OR</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0rem !important;">
                        <label for="">Email</label>
                        <!-- <input type="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" name="email_id" id="email_id" placeholder="Email"> -->
                        <div class="input-group">
                            <input type="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" name="email_id" id="re_email_id" placeholder="Email">
                            <div class="input-group-append">
                                <button class="btn btn-info resend_email_receipt" type="submit">Send</button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="rcpt_row_id" id="rcpt_row_id" value="">

                    <!-- <div class="row" style="margin-top: 25px;margin-bottom: 25px;">
                        <div class="col-12 text-center">
                            <a href="#" class="resend_rcpt_btn_confirm">Receipt Re-Send</a>
                            <button type="button" name="resend_rcpt_btn_confirm" class="btn btn-rounded social-btn-outlined resend_rcpt_btn_confirm" style="width: 195px !important;font-size: 14px !important;"><i class="mdi mdi-send medium"></i>Receipt Re-Send</button>
                        </div>
                    </div> -->
                </div>          
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('new_assets/css/sweetalert.css')?>">
<script src="<?=base_url('new_assets/js/sweetalert.js')?>"></script>

<style type="text/css">
    .modal.show.blur-mdl {
        opacity: 0.75;
    }
    body.p_recept .modal-dialog.modal-lg{
        max-width: 900px;
    }
    body.p_recept .modal .modal-footer,body.p_recept .modal .close, body.p_recept .modal .refunded_row {
        display: none !important;
    }
    span.card-img-no {
        white-space: nowrap;
        display: block;
        min-width: 115px;
    }
    .noc {
        display: none !important;
    }
</style>
<script>
function makePDF() {
    $('body').addClass('p_recept');
    // window.scroll({ top: 0, left: 0 });
    var winW=$(window).width();
    $('#invoice-receipt-modal').scrollTop(0);
    var quotes = document.getElementById('invoicePdfData');
        html2canvas(quotes, {
                onrendered: function(canvas) {

                //! MAKE YOUR PDF
                var pdf = new jsPDF('p', 'pt', 'a4');

                for (var i = 0; i <= quotes.clientHeight/1300; i++) {
                        //! This is all just html2canvas stuff
                        var srcImg  = canvas;
                        var sX      = 0;
                        var sY      = 1300*i ; // start 1300 pixels down for every new page
                        var sWidth  = 900 ;
                        var sHeight = 1300;
                        var dX      = 0;
                        var dY      = 0 ;
                        var dWidth  = 900;
                        var dHeight = 1300;

                        window.onePageCanvas = document.createElement("canvas");
                        onePageCanvas.setAttribute('width', 900);
                        onePageCanvas.setAttribute('height', 1300);
                        var ctx = onePageCanvas.getContext('2d');
                        // details on this usage of this function:
                        // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
                        ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);

                        // document.body.appendChild(canvas);
                        var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);

                        var width         = onePageCanvas.width;
                        var height        = onePageCanvas.clientHeight;

                        //! If we're on anything other than the first page,
                        // add another page
                        if (i > 0) {
                                pdf.addPage(); //8.5" x 11" in pts (in*72)
                                // pdf.addPage(580, 791); //8.5" x 11" in pts (in*72)
                        }
                        //! now we declare that we're working on that page
                        pdf.setPage(i+1);
                        //! now we add content to that page!
                        pdf.addImage(canvasDataURL, 'PNG', 15, 15, (width*.62), (height*.62));

                }
                //! after the for loop is finished running, we save the pdf.
                pdf.save('receipt.pdf');
                $('body').removeClass('p_recept');
        }
});
}
</script>
<script>



function refundingConfirm(amount,type)
{
swal({
title: '<span class="h4">Are you sure?</span>',
text: '<p><span class="refund__type">'+type+'</span> <input type="text" class="sure_refund form-control status_success" readonly="" value="'+amount+'"> </p>',
type: "warning",
showCancelButton: true,
confirmButtonClass: "btn btn-first receiptSSendRequestYes",
confirmButtonText: "Send",
cancelButtonClass: "btn danger-btn receiptSSendRequestNo",
cancelButtonText: "Cancel",
closeOnConfirm: true,
html: true,
closeOnCancel: true},function(isConfirm) 
{
    if(isConfirm){$('#invoice-receipt-modal').removeClass('blur-mdl');} else{
$('#invoice-receipt-modal').removeClass('blur-mdl');}
})
}


jQuery(function($){
    $('body').on('click','.poslist_vw_btn', function (e) {
            // stop - start
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#invoice-receipt-modal').modal('show');
            $('#invoice-receipt-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
            $.ajax({
             url: "<?php echo base_url('merchant/search_record_column_pos'); ?>",
             type: 'POST',
             data: 'id='+uid,
             dataType: 'html'
         })
            .done(function(data){
                console.log(data);
                $('#invoice-receipt-modal .modal-content').html(data); // load response
            })
            .fail(function(){
                $('#invoice-receipt-modal .modal-content').html("<div class='modal-header' style='border-bottom: none !important;margin-top: 10px !important;font-size: 15px !important;font-weight: 500;'><div class='row'><div class='col-12'><i class='mdi mdi-alert-outline mdi-2x' style='color: red;'></i> Something went wrong, Please try again.</div></div></div>");
            });
    })
});
jQuery(function($){
    $('body').on('click','.posrefund_receipt_vw_btn', function (e) {
            // stop - start
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            var row_id = $(this).data('row-id');   // it will get id of clicked row
            $('#invoice-receipt-modal').modal('show');
            $('#invoice-receipt-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
            $.ajax({
             url: "<?php echo base_url('merchant/search_record_column_pos_refund'); ?>",
             type: 'POST',
             data: 'id='+uid+'&'+'row_id='+row_id,
             dataType: 'html'
         })
            .done(function(data){
                // console.log(data);
                $('#invoice-receipt-modal .modal-content').html(data); // load response
            })
            .fail(function(){
                $('#invoice-receipt-modal .modal-content').html("<div class='modal-header' style='border-bottom: none !important;margin-top: 10px !important;font-size: 15px !important;font-weight: 500;'><div class='row'><div class='col-12'><i class='mdi mdi-alert-outline mdi-2x' style='color: red;'></i> Something went wrong, Please try again.</div></div></div>");
            });
    })
});




$(document)
.on('click','#receiptSSendRequest',function(){
    if($('#allpos_partref').is(':checked') && $('.partRefund__amount').val())
    {
        var refType='Partial Refund :';
        $('#invoice-receipt-modal').addClass('blur-mdl');
        //alert($('.partRefund__amount').val()); exit; 
        refundingConfirm($('.partRefund__amount').val(),refType);
    }
    else if($('#allpos_fulref').is(':checked') && $('.fullRefund__amount').val())
    {
        var refType='Full Refund :';
        $('#invoice-receipt-modal').addClass('blur-mdl');
        //alert($('.fullRefund__amount').val()); exit;
        refundingConfirm($('.fullRefund__amount').val(),refType)
        // $('#receiptSSendRequest-modal .sure_refund').val($('#amount.refund__amount').val());
        // $('#receiptSSendRequest-modal').modal('show');
    }
    // $('#invoice-receipt-modal').addClass('blur-mdl');
    // $('#receiptSSendRequest-modal .sure_refund').val($('#invoice-receipt-modal .srpttlAmt').text());
    // $('#receiptSSendRequest-modal').modal('show');
})
.on("hide.bs.modal",'#receiptSSendRequest-modal', function () {
        // put your default event here
        $('#invoice-receipt-modal').removeClass('blur-mdl');
        setTimeout(function(){
            if($('.modal.show').length > 0)
            {
                    $('body').addClass('modal-open');
            }
        },100)
})
.on("click",'#receiptSSendRequestYes,.receiptSSendRequestYes', function () {
        // put your default event here
        if($('#allpos_partref').is(':checked')){
            $('#amount').val($('.partRefund__amount').val());
        }
        else{
            $('#amount').val($('.fullRefund__amount').val());
        }

         $('#invoice-receipt-modal #receiptSSendRequest').attr('type','submit').trigger('click');
})
.on("click",'#receiptSSendRequestNo,.receiptSSendRequestNo', function () {
        // put your default event here
    $('#invoice-receipt-modal').removeClass('blur-mdl');
    // $('#receiptSSendRequest-modal').modal('hide');
})

.on('click','#receiptSSendRequestPrint',function(){
    $('body').addClass('p_recept');
    $('.t-header').addClass('d-none');
    $('.sidebar').addClass('d-none');
    $('#base-contents').addClass('d-none');
    window.print();
    $('body').removeClass('p_recept');
    $('.t-header').removeClass('d-none');
    $('.sidebar').removeClass('d-none');
    $('#base-contents').removeClass('d-none');
})
.on('keydown',function(e){
    if(e.ctrlKey && e.keyCode == 80)
    {
        if($('#invoice-receipt-modal').hasClass('show') && ($('.modal.show').length == 1))
        {
                e.preventDefault();
                $('body').addClass('p_recept');
                window.print();
                $('body').removeClass('p_recept');
        }
    }
})
.on('click','#receiptSSendRequestPdf',function(e){
    e.preventDefault();
        makePDF();
        // generate2();

})

$(document).on('click', '.resend_rcpt_btn', function() {
    var rowid = $(this).data('id');
    // console.log(rowid);
    $('#re_mobile').val('');
    $('#re_email_id').val('');
    $('.resend_phone_receipt').html('Send');
    $('.resend_email_receipt').html('Send');

    if(rowid != '') {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/get_phone_email_info'); ?>',   //  re_receipt_pos
            data: {'rowid': rowid},
            success: function (data){
                var obj = JSON.parse(data);
                // console.log(obj);

                $('#re_mobile').val(obj.phone_no);
                $('#re_email_id').val(obj.email_id);
            }
        });
        
        $('#resendReceiptModal').modal('show');
        $('#rcpt_row_id').val(rowid);
    }
})

$(document).on('click', '.resend_phone_receipt, .resend_email_receipt', function() {
    // alert();
    var rcpt_row_id = $('#rcpt_row_id').val();
    var phone_formated = $('#re_mobile').val();
    var email_id = $('#re_email_id').val();
    // console.log(this.className);return false;
    if(this.className == 'btn btn-info resend_phone_receipt') {
        if(phone_formated == '') {
            alert('Please enter phone number to re-send receipt.');
            return false;
        }
        // $('.resend_phone_receipt').prop("disabled", true);
        phone = phone_formated.replace(/[- )(]/g,'');

        var data = {
            'rowid'             : rcpt_row_id,
            'type'              : 'all_request',
            'phone_formated'    : phone_formated,
            'phone'             : phone
        };
        // console.log(this);return false;
        $('.resend_phone_receipt').html('<span class="fa fa-spinner fa-spin" style="width: 35px;"></span>');
        // return false;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/re_receipt_instore_on_phone'); ?>',   //  re_receipt_pos
            data: data,
            success: function (data){
                if(data==200) {
                    $('.resend_phone_receipt').html('<span class="fa fa-check" style="width:35px;"></span>');
                    
                    // $(this).html('Sent');
                    // alert('Receipt sent successfully.');
                    // $('.resend_rcpt_btn_confirm').html('<span class="fa fa-check status_success"></span> Re-Send Success');
                }
                if(data==500) {
                    alert('Something went wrong.');
                }
            }
        });
    }


    if(this.className == 'btn btn-info resend_email_receipt') {
        if(email_id == '') {
            alert('Please enter email address to re-send receipt.');
            return false;
        }

        if(email_id != '') {
            var pattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$/i;
            if(!pattern.test(email_id)) {
                alert('Please provide a valid email');
                return false;
            }
        }
        // $('.resend_email_receipt').prop("disabled", true);

        var data = {
            'rowid'             : rcpt_row_id,
            'type'              : 'all_request',
            'email_id'          : email_id
        };
        // console.log(this);return false;
        $('.resend_email_receipt').html('<span class="fa fa-spinner fa-spin" style="width: 35px;"></span>');
        // return false;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/re_receipt_instore_on_email'); ?>',   //  re_receipt_pos
            data: data,
            success: function (data){
                if(data==200) {
                    // console.log('done');
                    $('.resend_email_receipt').html('<span class="fa fa-check" style="width:35px;"></span>');
                    // $('.resend_email_receipt').html('<span class="text-success">Sent</span>');
                    
                    // $(this).html('Sent');
                    // alert('Receipt sent successfully.');
                    // $('.resend_rcpt_btn_confirm').html('<span class="fa fa-check status_success"></span> Re-Send Success');
                }
                if(data==500) {
                    alert('Something went wrong.');
                }
            }
        });
    }    
    // if((phone_formated == '') && (email_id == '')) {
    //     alert('Please enter either phone or email to re-send receipt.');
    //     return false;
    // }

    // if(email_id != '') {
    //     var pattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$/i;
    //     if(!pattern.test(email_id)) {
    //         alert('Please provide a valid email');
    //         return false;
    //     }
    // }
    // phone = phone_formated.replace(/[- )(]/g,'');
})
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<?php //include_once'footer_dash.php'; ?>