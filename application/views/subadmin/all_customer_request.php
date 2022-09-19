<?php
    include_once'header_dash_list.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    span.card-type-image {
        display: inline-block !important;
        max-width: 42px;
        vertical-align: middle;
        margin-left:3px;
    }
    .card-type-no-wraper{
        display: block !important;
        width: 121px;
    }
    .table tbody tr td span, table tbody tr td span {
        display: inline-flex !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0em 0.5em !important;
    }
    @media screen and (max-width: 640px) {
        #inv_pos_list_daterange span {
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
    .resend_rcpt_btn2 {
        font-family: AvenirNext-Medium !important;
        color: #868e96 !important;
        padding: 0px 15px !important;
        border: none;
        background: transparent;
        font-weight: 600;
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
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Transactions</h4> -->
                    <!-- <h4 class="h4-custom">Point of Sale List</h4> -->
                </div>
            </div>

            <?php $count = 0; ?>
            <form class="row" method="post" action="<?php echo base_url('pos/all_customer_request'); ?>" style="margin-bottom: 20px !important;">
                <!-- <div class="col-sm-8 col-md-4 col-lg-4" style="margin-left: -10px !important;"> -->
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="inv_pos_list_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                    </div>
                </div>
                <!-- <div class="col-sm-2 col-md-2 col-lg-2"> -->
                <div class="table_custom_status_selector">
                    <select class="form-control"  name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <?php if (!empty($status) && isset($status)) { ?>
                            <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?>>Paid</option>
                            <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?>>Pending</option>
                            <option value="Chargeback_Confirm" <?php echo (($status == 'Chargeback_Confirm') ? 'selected' : "") ?>>Refund</option>
                        <?php } else { ?>
                            <option value="confirm" >Paid</option>
                            <option value="pending" >Pending</option>
                            <option value="Chargeback_Confirm" >Refund</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <!-- <input type="submit" name="mysubmit" class="btn btn-first" value="Search" /> -->
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
            <table id="dt_inv_pos_sale_list" class="table hover row-border pos-list-dtable dt-responsive" style="width:100%">
                <!--<table id="example_list" class="hover row-border pos-list-dtable" style="width:100%">-->
                  <!--<table id="dt_inv_pos_sale_list" class="table  dt-responsive nowrap" style="width:100%">-->
                        <thead>
                            <tr>
                                 <th>Merchant Name</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                               <!--  <th>Revenue</th> -->
                                <th >Date</th>
                             <!--    <th >Settlement</th> -->
                                <th >Status</th>
                                
                                
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($mem as $a_data) {
                                $count++;
                            ?>
                            <tr>
                              <td  class="a"> &nbsp; <?php echo $a_data['merchant_name']; ?></td>
                                <td class="a"> &nbsp; <?php echo $a_data['transaction_id'] ?></td>
                               
                              
                                <td>
                                    <span class="status_success">$<?php echo number_format($a_data['amount'], 2); ?></span>
                                </td>
                                <!-- <td>
                                    <span class="status_success">$<?php echo number_format($a_data['amount'], 2); ?></span>
                                </td> -->

                                 <td>
                                    <?php echo ($a_data['status'] != 'pending' ? date("M d Y h:i A", strtotime($a_data['payment_date'])) : ($current_date > $due_date ? ' Due Date' : '')); ?>
                                </td>
                               <!--  <td>

                                </td> -->
                                
                                <td>
                                    <?php
                                        if ($a_data['status'] == 'pending') {
                                            $current_date = date("Y-m-d");
                                            $due_date = $a_data['due_date'];
                                            if ($current_date > $due_date) {
                                                echo '<span class="pos_Status_cncl"> Late  </span>';
                                            } else {
                                                echo '<span class="pos_Status_pend"> ' . $a_data['status'] . '  </span>';
                                            }
                                        } elseif ($a_data['status'] == 'confirm' || $a_data['status'] == 'Chargeback_Confirm') {
                                            echo '<span class="pos_Status_c"> Paid </span>';
                                        } elseif ($a_data['status'] == 'Declined' ||  $a_data['status'] == 'declined') {
                                            echo '<span class="pos_Status_pend"> pending </span>';
                                            // echo '<span class="pos_Status_cncl">'.ucfirst($a_data['status']).'</span>';
                                        } elseif ($a_data['status'] == 'Refund') {
                                            echo '<span class="status_refund"> Refund  </span>';
                                        }
                                    ?>
                                </td>
                               
                                
                               
                           
                            </tr>
                            <?php $i++;}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="inv_pos_list-modal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"  style="padding: 0px 25px 15px 25px !important;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <!-- <h4 class="modal-title">
                    <i class="glyphicon glyphicon-user"></i> Payment Detail
                </h4> -->
            </div>
            <div class="modal-body">
                <div id="modal-loader" class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
                </div>
                <div id="dynamic-content">
                    <div class="form-group">
                        <label >Invoice No:</label>
                        <p class="form-control-static">POS_20190523070517</p>
                    </div>
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
<div id="invoice-receipt-modal" class="invRecptMdlWrapper modal" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content" id="invoicePdfData">      
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <div class="irm-header-inner">
                    <div class="row">
                        <div class="col">
                            <div class="irm-logo">
                                <img src="https://salequick.com/demo_new/logo/image_201908200049.png" alt="logo">
                            </div>
                            <div class="irm-def">
                                <h4>Test</h4>
                                <p><b>Telephone: </b> -</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="irm-info">
                                <h4>RECEIPT</h4>
                                <p>Customer Copy</p>
                                <p>INVOICE NO. <span>POS_20190802020832</span></p>
                                <p>INVOICE DATE <span>August 02, 2019</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="modal-body"> 
                <div class="row">
                    <div class="col">
                        <div class="irm-inv-to">
                            <div class="irm-to-title"><span>Invoice To</span></div>
                            <div class="irm-to-sign">
                                -
                            </div>
                            <div class="irm-to-status">
                                <span>Payment Status: </span> 
                                <span class="pos_Status_c"> Paid </span>                
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="irm-pay-detail">
                            <div class="irm-pay-title"><span>Payment Details</span></div>
                            <div class="irm-pay-detail">
                                <p><span>Total Amount :</span> <b class="srpttlAmt">0.04</b></p>
                                <p><span>Transaction ID :</span> 19059386</p>
                                <p><span>Reference :</span> -</p>
                                <p><span>Card Type :</span> Visa</p>
                            </div>
                            <div class="allpos__reftype">
                                <div class="irm-pay-title"><span>Refund Type</span></div>
                                <div class="irm-pay-detail custom-form">
                                    <p>
                                        <span class="custom-checkbox">
                                            <input type="radio" id="allpos_fulref" class="radio-circle" value="1" name="allpos__reftypes" checked=""> 
                                            <label for="allpos_fulref" class="inline-block">Full Refund  :</label>                    
                                        </span>
                                        <span> 
                                            <input class="form-control fullRefund__amount" readonly="" name="amount" value="0.04" style="height: auto !important; " type="text">
                                        </span>
                                    </p>
                                    <p>
                                        <span class="custom-checkbox">
                                            <input type="radio" id="allpos_partref" class="radio-circle" value="0" name="allpos__reftypes">
                                            <label for="allpos_partref" class="inline-block">Partial Refund :</label>
                                        </span>
                                        <span>
                                            <input class="form-control partRefund__amount" readonly="" name="amount" value="" style="height: auto !important; " data-max="0.04" type="text" onkeypress="return isNumberKeyOnedc(this,event)" placeholder="Partial amount">
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="modal-footer"> 
                <div class="col text-left">
                    <button type="button" id="receiptSSendRequestPdf" name="submit" class="btn btn-second">Save as PDF</button>
                    <button type="button" id="receiptSSendRequestPrint" name="submit" class="btn btn-first">Print Receipt</button>
                </div>
                <div class="col text-right">
                    <button type="button" onclick="re_receipt(this,1211)" name="submit" class="btn btn-second" style="margin-right: 3px; ">Receipt Re-Send</button> 
                    <form class="form-control-static text-right float-right" action="https://salequick.com/demo_new/pos/refund_pos" abc="CNP" method="post">
                        <input class="form-control" name="invoice_no" id="invoice_no" value="POS_20190802020832" readonly="" required="" type="hidden">
                        <input class="form-control" name="amount" id="amount" value="0" readonly="" required="" type="hidden">
                        <input class="form-control" name="transaction_id" id="transaction_id" value="19059386" readonly="" required="" type="hidden">
                        <input class="form-control" name="id" id="id" value="1211" readonly="" required="" type="hidden">
                        <button type="button" id="receiptSSendRequest" name="submit" class="btn btn-first">Send Refund Request</button>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("new_assets/css/sweetalert.css"); ?>">
<script src="<?php echo base_url("new_assets/js/sweetalert.js"); ?>"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://salequick.com/demo/new_assets/css/sweetalert.css">
<script src="https://salequick.com/demo/new_assets/js/sweetalert.js"></script> -->
<style type="text/css">
    .modal.show.blur-mdl {
        opacity: 0.75;
    }
    /*div#receiptSSendRequest-modal .modal-dialog {
            max-width: 451px;
    }*/
    #receiptSSendRequest-modal{
        padding: 0 !important;
    }
    /*--------------------------*/
    .sweet-alert .btn {
            padding: 5px 15px;
    }
    body.p_recept .modal-footer,body.p_recept .close,body.p_recept .allpos__reftype{
        display: none;
    }
    body.p_recept .modal-content{
        border-color: transparent;
    }
    .noc {
        display: none !important;
    }
    body.p_recept .modal-dialog.modal-lg{
        max-width: 900px;
    }
    body.p_recept .modal .modal-footer,body.p_recept .modal .close, body.p_recept .modal .refunded_row {
        display: none !important;
    }
</style>

<!-- <script>
function makePDF() {
    $('body').addClass('p_recept');
    // window.scroll({ top: 0, left: 0 });
    var winW=$(window).width();
    $('#invoice-receipt-modal').scrollTop(0);
    var quotes = document.getElementById('invoicePdfData');
        var docHgt=quotes.clientHeight;
        html2canvas(quotes, {
            onrendered: function(canvas) {
                cWdth=canvas.width;
                if(cWdth < 500){
                    maxW=cWdth + 40;
                }
                else if(cWdth < 900)
                {
                    maxW=900;
                }
                else{
                    maxW=900;
                }
                xPos=(maxW - cWdth) / 2;
                // console.log(xPos)
                // console.log(canvas)
                //! MAKE YOUR PDF
                var pdf = new jsPDF('p', 'pt', 'a4');
                // console.log(pdf)
                var totalPages=docHgt / 1300;
                // console.log(totalPages)
                for (var i = 0; i <= totalPages; i++) {
                        //! This is all just html2canvas stuff
                        var srcImg  = canvas;
                        var sX      = 0;
                        var sY      = 1300*i ; // start 980 pixels down for every new page
                        var sWidth  = maxW ;
                        var sHeight = 1300;
                        var dX      = xPos;
                        var dY      = 0 ;
                        var dWidth  = maxW;
                        var dHeight = 1300;
                        // console.log(sY);
                        window.onePageCanvas = document.createElement("canvas");
                        onePageCanvas.setAttribute('width', maxW);
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
                            pdf.addPage();
                                // pdf.addPage(612, 791); //8.5" x 11" in pts (in*72)
                        }
                        //! now we declare that we're working on that page
                        pdf.setPage(i+1);
                        //! now we add content to that page!
                        pdf.addImage(canvasDataURL, "PNG", 15, 15, (width*.62), (height*.62));
                        // pdf.addImage(canvasDataURL, "PNG", 15, 15, (width*.62), 1300);

                }
                //! after the for loop is finished running, we save the pdf.
                pdf.save('receipt.pdf');
                $('body').removeClass('p_recept');
            }
        });
    }
</script> -->
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
<!-- <div id="receiptSSendRequest-modal" class="modal transform-modal" >
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
</div> -->
<script>
    function pending_delete(id) {
        swal({
            title: "<span style='font-size: 21px;'>Are you sure, want to delete this Invoice?</span>",
            text: "<span style='font-size: 16px;'>You will not be able to recover this info!</span>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn danger-btn",
            confirmButtonText: "Yes, remove it!",
            cancelButtonClass: "btn btn-first",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo base_url('merchant/pending_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
            } else {

            }
        })
    } 
    // ------------------
    function refundingConfirm(amount,type) {
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
            closeOnCancel: true},function(isConfirm) { 
                $('#inv_pos_list-modal').removeClass('blur-mdl');
                $('#invoice-receipt-modal').removeClass('blur-mdl');
            }
        )
    }
    $(document)
    .on('click','.pos-list-dtable .invoice_pos_list_item_vw_paid_recept', function (e) {
        // stop - start
        e.preventDefault();
        var uid = $(this).data('id');   // it will get id of clicked row
        console.log(uid);
        $('#invoice-receipt-modal').modal('show');
        $('#invoice-receipt-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
        $.ajax({
            url: "<?php echo base_url('merchant/search_invoice_detail_receipt'); ?>",
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            // console.log(data);
            $('#invoice-receipt-modal .modal-content').html(data); // load response 
        })
        .fail(function(){
            $('#invoice-receipt-modal .modal-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
        });
    })
    .on('click','.pos-list-dtable .invoice_pos_list_item_vw__refund_recept', function (e) {
        // stop - start
        e.preventDefault();
        var uid = $(this).data('id');   // it will get id of clicked row
        var row_id = $(this).data('row-id');   // it will get id of clicked row

        $('#invoice-receipt-modal').modal('show');
        $('#invoice-receipt-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
        $.ajax({
            url: "<?php echo base_url('merchant/search_invoice_detail_receipt_refund'); ?>",
            type: 'POST',
            data: 'id='+uid+'&'+'row_id='+row_id,
            dataType: 'html'
        })
        .done(function(data){
            // console.log(data);
            $('#invoice-receipt-modal .modal-content').html(data); // load response 
        })
        .fail(function(){
            $('#invoice-receipt-modal .modal-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
        });
    })

    .on('click','#receiptSSendRequest',function(){
        if($('#allpos_partref').is(':checked') && $('.partRefund__amount').val()) {
            var refType='Partial Refund :';
            $('#invoice-receipt-modal').addClass('blur-mdl');
            refundingConfirm($('.partRefund__amount').val(),refType);
        } else if($('#allpos_fulref').is(':checked') && $('.fullRefund__amount').val()) {
            var refType='Full Refund :';
            $('#invoice-receipt-modal').addClass('blur-mdl');
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
            if($('.modal.show').length > 0) {
                $('body').addClass('modal-open');
            }
        },100)
    })
    .on("click",'#receiptSSendRequestYes,.receiptSSendRequestYes', function () {
        // put your default event here
        if($('#allpos_partref').is(':checked')){
            $('#amount').val($('.partRefund__amount').val());
        } else {
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
        window.print();
        $('body').removeClass('p_recept');
    })
    .on('keydown',function(e){
        if(e.ctrlKey && e.keyCode == 80) {
            if($('#invoice-receipt-modal').hasClass('show') && ($('.modal.show').length == 1)) {
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
    //----------------------------------------------------
    jQuery(document)
    .on('click','.pos-list-dtable .invoice_pos_list_item_vw_recept',function(e){
        e.preventDefault();
        var uid = $(this).data('id');   // it will get id of clicked row
        $('#inv_pos_list-modal').modal('show');
        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader
        $.ajax({
         url: "<?php echo base_url('merchant/search_record_column1'); ?>",
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            // console.log(data);
            $('#dynamic-content').html(data); // load response
            $('#modal-loader').hide();      // hide ajax loader
        })
        .fail(function(){
            $('#dynamic-content').html("<div class='modal-header' style='border-bottom: none !important;margin-top: 10px !important;font-size: 15px !important;font-weight: 500;'><div class='row'><div class='col-12'><i class='mdi mdi-alert-outline mdi-2x' style='color: red;'></i> Something went wrong, Please try again.</div></div></div>");
            $('#modal-loader').hide();
        });
    })
    
    $(document)
    .on('click','#receiptSSendRequest',function(){
        $('#inv_pos_list-modal').addClass('blur-mdl');
        $('#receiptSSendRequest-modal .sure_refund').val($('#inv_pos_list-modal .srpttlAmt').text());
        $('#receiptSSendRequest-modal').modal('show');
    })
    .on("hide.bs.modal",'#receiptSSendRequest-modal', function () {
        // put your default event here
        $('#inv_pos_list-modal').removeClass('blur-mdl');
        setTimeout(function(){
            if($('.modal.show').length > 0){
                $('body').addClass('modal-open');
            }
        },100)
    })
    .on("click",'#receiptSSendRequestYes', function () {
        // put your default event here
        $('#inv_pos_list-modal #receiptSSendRequest').attr('type','submit').trigger('click');
    })
    .on("click",'#receiptSSendRequestNo', function () {
            // put your default event here
        $('#inv_pos_list-modal').removeClass('blur-mdl');
        $('#receiptSSendRequest-modal').modal('hide');
    })
    // .on('click','#receiptSSendRequestPrint',function(){
    //     $('body').addClass('p_recept');
    //     window.print();
    //     $('body').removeClass('p_recept');
    // })
    // .on('keydown',function(e){
    //     if(e.ctrlKey && e.keyCode == 80) {
    //         if($('#inv_pos_list-modal').hasClass('show') && ($('.modal.show').length == 1)) {
    //             e.preventDefault();
    //             $('body').addClass('p_recept');
    //             window.print();
    //             $('body').removeClass('p_recept');
    //         }
    //     }
    // })

    $(document).on('click', '#re_invoice_by_list', function() {
        var data_row_id = $(this).data('id');
        console.log(data_row_id);
        
        $(this).text('Sending');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/re_invoice'); ?>',
            data: {'rowid':data_row_id },

            beforeSend:function(data){$(this).attr("disabled",true);},
            success: function (data) {
                if(data=='200') {
                    // $('#resend-invoice').hide();
                    // $('.bbg').html('<span class="text-success">Invoice re-send Successfully ...</span>');
                    $(this).text('Sent');
                }
            }
        });
    })

    function resendinvoice(rowid) {
        console.log($(this));
        // $(this).text('Sending');
        // $.ajax({
        //     type: 'POST',
        //     url: '<?php echo base_url('merchant/re_invoice'); ?>',
        //     data: {'rowid':rowid },

        //     beforeSend:function(data){$(this).attr("disabled",true);},
        //     success: function (data) {
        //         if(data=='200') {
        //             // $('#resend-invoice').hide();
        //             // $('.bbg').html('<span class="text-success">Invoice re-send Successfully ...</span>');
        //             $(this).text('Sent');
        //         }
        //     }
        // });
    }
</script>

<?php include_once'footer_dash_list.php'; ?>