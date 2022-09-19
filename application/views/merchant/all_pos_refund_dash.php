<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .table tbody tr td span, table tbody tr td span {
        display: inline !important;
    }
    .action-styling {
        color: black !important;
        text-decoration: underline !important;
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
                </div>
            </div>

            <?php $count = 0; ?>
            <form class="row" method="post" action="<?php echo base_url('refund/all_pos');?>" style="margin-bottom: 20px !important;">
                <div class="col-sm-8 col-md-4 col-lg-4" style="margin-left: -10px !important;">
                    <div id="all_pos_refund_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search" style="width: 126px !important;"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="all_pos_refund_dt" class="table table-hover salequick-dt" style="width:100%">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=1;
                                foreach($mem as $a_data) {
                                    $count++; ?>
                                    <tr>
                                        <td><?php echo $a_data['payment_id'] ?></td>
                                        <td><?php echo $a_data['name'] ?></td>
                                        <td><?php echo $a_data['mobile'] ?></td>
                                        <td>
                                            <a href="javascript:void(0)" class="status_success">
                                                $<?php echo number_format($a_data['amount'],2); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="pos_Status_cncl">
                                                <?php if($a_data['status'] =='Chargeback_Confirm') {
                                                    echo 'Refund';
                                                } else {
                                                    echo $a_data['status'];
                                                } ?>  
                                            </a>
                                        </td>
                                        <td><?php echo $a_data['date'] ; ?></td>
                                        <td>
                                            <?php if ($a_data['status'] == 'Chargeback_Confirm') { ?>
                                                <div class="dropdown dt-vw-del-dpdwn">
                                                    <button type="button" data-toggle="dropdown">
                                                        <i class="material-icons"> more_vert </i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item all_pos_refund_vw_btn" data-id="<?php echo $a_data['id'];  ?>" href="#"><span class="fa fa-eye"></span>  Receipt</a>
                                                        <a class="dropdown-item pos_vw_refund" id="receiptSSendRequest" data-amount="<?=  $a_data['amount'];  ?>" href="#"><span class="fa fa-eye"></span>  Refund</a>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <a href="#" class="all_pos_refund_vw_btn pos_Status_c badge-btn" data-id="<?php echo $a_data['id'];  ?>" ><span class="fa fa-eye"></span> Receipt</a>
                                            <?php } ?>
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
<div id="invoice-receipt-modal" class="invRecptMdlWrapper modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"  id="invoicePdfData" style="padding: 0px 25px 15px 25px !important;border: none !important;">

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
                <p>Refund : <input type="text" class="sure_refund form-control status_success" readonly></p>
                <h4 style=" margin: 0 0 11px; ">Are you sure?</h4>
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

<link rel="stylesheet" type="text/css" href="<?=base_url('new_assets/css/sweetalert.css')?>">
<script src="<?=base_url('new_assets/js/sweetalert.js')?>"></script>

<style type="text/css">
    .modal-header {
        border-bottom: none !important;
    }
    body.p_recept .modal-dialog.modal-lg{
        max-width: 900px;
    }
    body.p_recept > .modal .modal-footer,body.p_recept > .modal .close{
        display: none;
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
                        var sY      = 1300*i ; // start 980 pixels down for every new page
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

jQuery(function($){
    $('.all_pos_refund_vw_btn').on('click', function (e) {
            // stop - start
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#invoice-receipt-modal').modal('show');
            $('#invoice-receipt-modal .modal-content').html($('#loader-content').html()); // leave it blank before ajax call
            $.ajax({
             url: "<?php  echo base_url('merchant/search_record_column_pos'); ?>",
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
})
$(document)
.on('click','#receiptSSendRequest',function(){
    $('#invoice-receipt-modal').addClass('blur-mdl');
    var amount = $(this).data('amount');
    // $('#receiptSSendRequest-modal .sure_refund').val($('#invoice-receipt-modal .srpttlAmt').text());
    $('#receiptSSendRequest-modal .sure_refund').val(amount);

    $('#receiptSSendRequest-modal').modal('show');
})
.on("hide.bs.modal",'#receiptSSendRequest-modal', function () {
        // put your default event here
        $('#invoice-receipt-modal').removeClass('blur-mdl');
        if($('.modal.show').length > 0)
        {
                $('body').addClass('modal-open');
        }
})
.on("click",'#receiptSSendRequestYes', function () {
        // put your default event here
        $('#invoice-receipt-modal #receiptSSendRequest').attr('type','submit').trigger('click');
})
.on("click",'#receiptSSendRequestNo', function () {
        // put your default event here
    $('#invoice-receipt-modal').removeClass('blur-mdl');
    $('#receiptSSendRequest-modal').modal('hide');
})
.on('click','#receiptSSendRequestPrint',function(){
    $('body').addClass('p_recept');
    window.print();
    $('body').removeClass('p_recept');
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<?php include_once'footer_dash.php'; ?>