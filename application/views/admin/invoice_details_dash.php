<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>

<style>
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
    span.card-type-image {
        display: inline-block;
        max-width: 51px;
        vertical-align: middle;
        margin-left:3px;
    }
    .card-type-no-wraper{
        display: block;
        width: 121px;
    }
    span.num_seprater {
        padding: 0 5px;
        color: rgba(68, 68, 68, 0.68);
        font-size: 20px;
        display: inline-block;
    }
    #invoice-detail-modal .modal-dialog {
        max-width: 800px;
        padding: 0 15px;
    }
    .sweet-alert .btn {
        padding: 5px 15px;
        min-width: 100px;
    }
    .modal.show.blur-mdl {
        overflow: hidden;
        filter: blur(1px);
        opacity: 0.8;
    }
    body.p_recept #invoice-detail-modal .modal-dialog.modal-lg{
        max-width: 900px;
    }
    body.p_recept > .modal .modal-footer,body.p_recept > .modal .close{
        display: none;
    }
    @media only screen and (max-width: 851px){
        .modal .modal-dialog .close {
            right: -8px;
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

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <span onclick="history.back(-1)" class="float-buttons float-left goback-button"><span class="material-icons"> arrow_back</span> Go Back</span>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right" style="margin-top: 8px !important;">
                    <span class="text-uppercase name__invoice"><?php if(count($mem) > 0 ) echo $mem[0]['name'].' </span><small class="pos_Status_c"> ('.$mem[0]['invoice_no'].')</small>'; ?></span>
                </div>
            </div>

            <?php if(count($mem) > 0  && 3 > 4 ) {  //  Condition False Here  ?>
                <form class="row" method="post" action="<?php  $inv=$mem[0]['invoice_no']?$mem[0]['invoice_no']:$invoice_no; echo base_url('pos/invoice_details/'.$inv);?>" style="margin-bottom: 20px !important;">
                    <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;">
                        <div id="transaction_recurring_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;width: auto !important;">
                            <span>
                                <?php echo ((isset($curr_payment_date) && !empty($curr_payment_date))?(date("F-d-Y", strtotime($curr_payment_date)) .' - '.date("F-d-Y", strtotime($end))):('<label class="placeholder">Select date range</label>')) ?>
                            </span>
                            <input name="invoice_no" type="hidden" value="<?php if($mem[0]['invoice_no']){ echo $mem[0]['invoice_no']; }else{ echo $invoice_no; }    ?> "  />
                            <input  name="curr_payment_date" type="hidden" value="<?php echo (isset($curr_payment_date) && !empty($curr_payment_date))? $curr_payment_date : '';?>">
                            <input  name="end" type="hidden" value="<?php echo (isset($end) && !empty($end))? $end : '';?>">
                        </div>
                    </div>
                    
                    <div class="table_custom_status_selector">
                        <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                            <option value="">Select Status</option>
                            <?php if(!empty($status) && isset($status)) { ?>
                                <option value="confirm" <?php echo (($status == 'confirm')?'selected':"") ?>>Complete</option>
                                <option value="pending" <?php echo (($status == 'pending')?'selected':"") ?>>Good Standing</option>
                                <option value="late" <?php echo (($status == 'late')?'selected':"") ?>>Late</option>
                            <?php } else { ?>
                                <option value="confirm" >Complete</option>
                                <option value="pending" >Good Standing</option>
                                <option value="late" >Late</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search" style="width: 126px !important;"><i class="mdi mdi-magnify medium"></i>Submit</button>
                    </div>
                </form>
                <hr>
            <?php } ?>
            
            <div class="row">
                <div class="col-12">
                    <table id="transaction_recurring_dt" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th width="20%">Card Info</th>
                                <th width="15%">Receipt</th>
                                <th width="9%">Amount</th>
                                <th width="8%">Status</th>
                                <th width="15%">Payment Date</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            $count = 0;
                            foreach($mem as $a_data) {
                                $count++;
                                if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago') {
                                    $time_Zone=$this->session->userdata('time_zone');
                                    date_default_timezone_set('America/Chicago');
                                    $datetime = new DateTime($a_data['payment_date']);
                                    $la_time = new DateTimeZone($time_Zone);
                                    $datetime->setTimezone($la_time);
                                    $a_data['payment_date']=$datetime->format('Y-m-d H:i:s');
                                }
                                if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago') {
                                    $prev_ConversionDate=$a_data['recurring_pay_start_date'];
                                    $time_Zone=$this->session->userdata('time_zone');
                                    date_default_timezone_set('America/Chicago');
                                    $datetime = new DateTime($a_data['recurring_pay_start_date']);
                                    $la_time = new DateTimeZone($time_Zone);
                                    $datetime->setTimezone($la_time);
                                    $a_data['recurring_pay_start_date']=$datetime->format('Y-m-d H:i:s');
                                } ?>
                                <tr>
                                    <td><?php echo $a_data['transaction_id'] ?></td>
                                    <td>
                                        <span class="card-type-no-wraper">
                                            <?php echo !empty($a_data['card_no'])?('****'.substr($a_data['card_no'], -4)): 'xxxxxxxx'; ?>
                                            <span class="card-type-image">
                                                <?php
                                                    $typeOfCard=strtolower($a_data['card_type']);
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
                                                        !empty($a_data['card_no'])?($card_image = 'other.png') : ($card_image = 'nocard.png');
                                                } ?>
                                                <img src="<?=base_url()?>new_assets/img/<?php echo $card_image; ?>" alt="<?php echo $a_data['card_type'] ?>" >
                                            </span>
                                        </span>
                                    </td>
                                    <td><?= $a_data['email_id'] ?></td>
                                    <td>
                                        <?php $amount = $a_data['amount'] - $a_data['late_fee']; ?>
                                        <span class="status_success">$<?= number_format($amount,2); ?></span>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <?php
                                                $th=$a_data['payment_date']  ? date("d M  Y", strtotime($a_data['payment_date']) ): date("d M  Y", strtotime($a_data['recurring_pay_start_date'])); 
                                           
                                            if($a_data['status']=='confirm' || $status=='confirm') { 
                                               echo '<span class="badge badge-success">Completed</span>';
                                            } elseif ($a_data['status']=='Chargeback_Confirm') {
                                                echo '<span class="badge badge-secondary">Refund</span>';
                                            } elseif($a_data['status']!='confirm' && $status!='confirm' && date("Y-m-d", strtotime($a_data['recurring_pay_start_date']))<date("Y-m-d")) { 
                                                echo '<span class="badge badge-danger">Late</span>';  
                                            } elseif($a_data['status']!='pending'  && date("Y-m-d", strtotime($a_data['recurring_pay_start_date']))>date("Y-m-d")) {
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            } else{} ?>
                                        </a>
                                    </td>
                                    <td><?php if($a_data['status']=='confirm' ||  $a_data['status']=='Chargeback_Confirm') { echo date("d M  Y", strtotime($a_data['payment_date'])); } else{ echo date("d M  Y", strtotime($a_data['recurring_pay_start_date'])); } ?>
                                    </td>
                                    <td>
                                        <?php if($a_data['status'] == 'confirm' || $status=='confirm' || $a_data['status'] == 'Chargeback_Confirm') { ?>
                                            <span class="transaction_recur_vw_btn pos_Status_c badge-btn" style="cursor:pointer;" data-id="<?php echo $a_data['id'];  ?>"><span class="fa fa-eye"></span>  Receipt</span>
                                        <?php } else if($a_data['status']!='confirm' && $status!='confirm' && $a_data['recurring_pay_start_date']!=!empty($prev_ConversionDate)) { ?>
                                            <button type="submit" id="resend-invoice" name="submit" onclick="resendinvoice(this,<?php echo $a_data['id']; ?> )" class="pos_Status_c badge-btn" style="border: none !important;">Re-Send Invoice</button>  
                                        <?php } ?> 
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="transRecur-modal" class="modal fade">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h4 class="modal-title">
                    <i class="glyphicon glyphicon-user"></i> Payment Detail
                </h4> 
            </div> 
            <div class="modal-body"> 
                <div id="modal-loader" class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
                </div>                          
                <div id="dynamic-content">
                    <!-- <div class="form-group">
                        <label >Invoice No:</label>
                        <p class="form-control-static">POS_20190523070517</p>
                    </div> -->
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

<div id="invoice-detail-modal" class="invRecptMdlWrapper modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content" id="invoicePdfData"> 
            <div class="modal-content">      
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo  base_url(); ?>new_assets/css/sweetalert.css">
<script src="<?php echo  base_url(); ?>new_assets/js/sweetalert.js"></script>

<script>
    $(document).ready(function() {
        var dtConfigOrderSort={
            "processing": true,
            // "sAjaxSource":"data.php",
            "pagingType": "full_numbers",
            "pageLength": 25,
            //"dom": 'lBfrtip',
            "order": [], 
            // "ordering": true,
            // "order": [[ 5, "desc" ]],
            "destroy": true,
            responsive: true,
            language: {
                search: '', searchPlaceholder: "Search",
                oPaginate: {
                     sNext: '<i class="fa fa-angle-right"></i>',
                     sPrevious: '<i class="fa fa-angle-left"></i>',
                     sFirst: '<i class="fa fa-step-backward"></i>',
                     sLast: '<i class="fa fa-step-forward"></i>'
                     }
             }   ,
            "buttons": [
                {
                    extend: 'collection',
                    text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
                    buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                    ]
                }
            ]
        }
        $('#transaction_recurring_dt').DataTable(dtConfigOrderSort);
    })

    function makePDF() {
        $('body').addClass('p_recept');
        // window.scroll({ top: 0, left: 0 });
        var winW=$(window).width();
        $('#invoice-detail-modal').scrollTop(0);
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
                if(isConfirm){$('#invoice-detail-modal').removeClass('blur-mdl');
                    ///call here 
                } else{
                $('#invoice-detail-modal').removeClass('blur-mdl');}
            })
    }

    $(document)
    .on('click','.transaction_recur_vw_btn', function (e) {
        // stop - start
        e.preventDefault();
        var uid = $(this).data('id');   // it will get id of clicked row
        $('#invoice-detail-modal').modal('show');
        $('#invoice-detail-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
        $.ajax({
            url: "<?php  echo base_url('dashboard/search_invoice_detail_receipt'); ?>",
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            // console.log(data);
            $('#invoice-detail-modal .modal-content').html(data); // load response 
        })
        .fail(function(){
            $('#invoice-detail-modal .modal-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
        });
    })
    .on('click','#receiptSSendRequest',function(){
        if($('#allpos_partref').is(':checked') && $('.partRefund__amount').val()) {
            var refType='Partial Refund :';
            $('#invoice-detail-modal').addClass('blur-mdl');
            refundingConfirm($('.partRefund__amount').val(),refType);
        } else if($('#allpos_fulref').is(':checked') && $('.fullRefund__amount').val()) {
            var refType='Full Refund :';
            $('#invoice-detail-modal').addClass('blur-mdl');
            refundingConfirm($('.fullRefund__amount').val(),refType)
            // $('#receiptSSendRequest-modal .sure_refund').val($('#amount.refund__amount').val());
            // $('#receiptSSendRequest-modal').modal('show');
        }
        // $('#invoice-detail-modal').addClass('blur-mdl');
        // $('#receiptSSendRequest-modal .sure_refund').val($('#invoice-detail-modal .srpttlAmt').text());
        // $('#receiptSSendRequest-modal').modal('show');
    })
    .on("hide.bs.modal",'#receiptSSendRequest-modal', function () {
        // put your default event here
        $('#invoice-detail-modal').removeClass('blur-mdl');
        setTimeout(function(){
          if($('.modal.show').length > 0)
          {
              $('body').addClass('modal-open');
          }
        },100)
    })
    .on("click",'#receiptSSendRequestYes,.receiptSSendRequestYes', function () {
        // put your default event here
        $('#amount').val($('input.sure_refund').val());
        $('#invoice-detail-modal #receiptSSendRequest').attr('type','submit').trigger('click');
    })
    .on("click",'#receiptSSendRequestNo,.receiptSSendRequestNo', function () {
        // put your default event here
        $('#invoice-detail-modal').removeClass('blur-mdl');
        // $('#receiptSSendRequest-modal').modal('hide');
    })
    .on('click','#receiptSSendRequestPrint',function(){
        $('body').addClass('p_recept');
        window.print();
        $('body').removeClass('p_recept');
    })
    .on('keydown',function(e){
        if(e.ctrlKey && e.keyCode == 80) {
            if($('#invoice-detail-modal').hasClass('show') && ($('.modal.show').length == 1)) {
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
    function resendinvoice(el,rowid){
        $this=$(el);
        $this.html('<span class="fa fa-spinner fa-spin"></span> Re-Sending Invoice');
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>dashboard/re_invoice',
            data: {'rowid':rowid },
            beforeSend:function(data){$("#resend-invoice").attr("disabled",true);},
            success: function (data){
                if(data=='200'){
                    $this.html('<span class="fa fa-check status_success"></span> Re-Sent Invoice!');
                    setTimeout(function(){$("#resend-invoice").removeAttr("disabled");$this.html('Re-Send Invoice')},2000);
                }
            }
        });
    }
</script>

<?php include_once'footer_dash.php'; ?>