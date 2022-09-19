<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style>
    .dataTables_wrapper .dataTables_filter input {
        width: 220px !important;
        height: 45px!important;
        color: #4a4a4a;
        -webkit-box-shadow: 0 0;
        box-shadow: 0 0;
        padding-left: 35px;
        border-color: #e1e6ea;
        font-weight: normal;
        border-radius: 3px;
        background-image: url('<?php echo base_url('new_assets/img/search.svg') ?>');
        background-repeat: no-repeat;
        background-size: 25px;
        background-position: 5px center;
        border: none;
        border-radius: 5px;
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
                    <!-- <h4 class="h4-custom">Split Transaction List</h4> -->
                </div>
            </div>

            <?php $count = 0; ?>
            <div class="row">
                <div class="col-12">
                    <table id="dt_pos_sale_list" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="17%">Transaction ID</th>
                                <th>Payment Details</th>
                                <?php if ($merchant_data[0]->csv_Customer_name > 0) { ?>
                                    <th class="noc">Name on Card</th>
                                <?php }?>
                                <th width="21%">Receipt</th>
                                <th width="12%">Split Amount</th>
                                <th width="12%">Full Amount</th>
                                <th width="12%">Status</th>
                                <th width="15%">Date</th>
                                <th width="5%" class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($result as $a_data) {
                                $count++; ?>
                                <tr>
                                    <td title="<?php echo $a_data['c_type']; ?>">
                                        <?php echo $a_data['transaction_id'] ?>
                                    </td>
                                    <td>
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
                                                default:
                                                    $card_image = 'other.png';
                                            }
                                            if ($typeOfCard == "cash" || $typeOfCard == "check") {
                                                $no = "";
                                                if ($typeOfCard == "check") {
                                                    $check_img = '<img src="'.base_url('new_assets/img/check.png').'" style="display: inline;max-width: 35px;">';
                                                    $no = "(" . $a_data['card_no'] . ")";
                                                    echo $check_img . $no;
                                                } else if($typeOfCard == "cash") {
                                                    $cash_img = '<img src="'.base_url('new_assets/img/cash.png').'" style="display: inline;max-width: 35px;" >';
                                                    echo $cash_img;
                                                } else {
                                                    echo $a_data['card_type'];
                                                }
                                            } else { ?>
                                                <img src="<?=base_url()?>new_assets/img/<?php echo $card_image; ?>" alt="<?php echo $a_data['card_type'] ?>" style="display: inline;max-width: 35px;">
                                                </span>
                                                    <?php echo !empty($a_data['card_no']) ? ('****' . substr($a_data['card_no'], -4)) : '********';
                                            } ?>
                                    </td>
                                    <?php if ($merchant_data[0]->csv_Customer_name > 0) { ?>
                                        <td class="noc"><?=$a_data['name']?></td>
                                    <?php }?>
                                    <td>
                                        <?php
                                            echo (isset($a_data['repeiptmethod']) && !empty($a_data['repeiptmethod'])) ? $a_data['repeiptmethod'] : 'No Receipt';
                                        ?>
                                    </td>
                                    <td><a href="javascript:void(0)" class="status_success">$<?php echo number_format($a_data['amount'], 2); ?></a>
                                    </td>
                                    <td><a href="javascript:void(0)" class="status_success">$<?php echo number_format($a_data['full_amount'], 2); ?></a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($a_data['status'] == 'pending') {
                                            echo '<span class="pos_Status_pend"> ' . ucfirst($a_data['status']) . '  </span>';
                                        } elseif ($a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm') {
                                            echo '<span class="pos_Status_c"> Paid </span>';
                                        } elseif ($a_data['status'] == 'declined') {
                                            echo '<span class="pos_Status_cncl"> ' . ucfirst($a_data['status']) . ' </span>';
                                        } elseif ($a_data['status'] == 'Refund') {
                                            echo '<span class="status_refund"> Refund  </span>';
                                        } ?>
                                    </td>
                                    <td><?php echo date("M d Y h:i A", strtotime($a_data['date'])); ?></td>
                                    <td>
                                        <?php if ( $a_data['status'] == 'confirm' ||  $a_data['status'] == 'Chargeback_Confirm') { ?>
                                            <a href="#" class="poslist_vw_btn pos_Status_c badge-btn" data-id="<?php echo $a_data['id']; ?>" ><span class="fa fa-eye"></span> Receipt</a>
                                        <?php } else {?>
                                            <a class="pos_Status_c  badge-btn  posrefund_receipt_vw_btn" data-id="<?php echo $a_data['id']; ?>" data-row-id="<?php echo $a_data['refund_row_id']; ?>"   href="#"><span class="fa fa-eye"></span>  Receipt</a>
                                        <?php }?>
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

<div id="loader-content" style="display: none;">
    <div id="modal-loader" class="text-center"  style="padding: 15px">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
    </div>
</div>
<div id="invoice-receipt-modal" class="invRecptMdlWrapper modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="invoicePdfData" style="padding: 0px 25px 15px 25px !important;">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('new_assets/css/sweetalert.css')?>">
<script src="<?=base_url('new_assets/js/sweetalert.js')?>"></script>
<style type="text/css">
    .sweet-alert .btn {
        padding: 5px 15px;
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
                for (var i = 0; i <= quotes.clientHeight/980; i++) {
                    //! This is all just html2canvas stuff
                    var srcImg  = canvas;
                    var sX      = 0;
                    var sY      = 980*i ; // start 980 pixels down for every new page
                    var sWidth  = 900 ;
                    var sHeight = 980;
                    var dX      = 0;
                    var dY      = 0 ;
                    var dWidth  = 900;
                    var dHeight = 980;

                    window.onePageCanvas = document.createElement("canvas");
                    onePageCanvas.setAttribute('width', 900);
                    onePageCanvas.setAttribute('height', 980);
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
                                pdf.addPage(612, 791); //8.5" x 11" in pts (in*72)
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
            closeOnCancel: true
        },function(isConfirm) {
            if(isConfirm){$('#invoice-receipt-modal').removeClass('blur-mdl');} else{
                $('#invoice-receipt-modal').removeClass('blur-mdl');
            }
        })
    }

    $(document)
    .on('click','.poslist_vw_btn', function (e) {
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
        // alert()
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
</script>

<script>
    jQuery(function($){
        $('.posrefund_receipt_vw_btn').on('click', function (e) {
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
                $('#invoice-receipt-modal .modal-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            });
        })
    });
</script>

<?php include_once'footer_dash.php'; ?>