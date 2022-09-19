<?php
include_once 'header_new.php';
include_once 'nav_new.php';
include_once 'sidebar_new.php'; 
?>
<!-- Start Page Content -->
  <div id="wrapper">
    <div class="page-wrapper pos-list">
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title">
            <span>Inventory  Management</span>
          </div>
        </div>
      </div>
      <!-- <div class="row sales_date_range">
        <div class="col-12 custom-form">
          <div class="card content-card">
            <form class="row " method="post" action="<?php echo base_url('pos/inventorymngt'); ?>" >
              <div class="col mx-501">
                <div id="pos_list_daterange" class="form-control date-range-style">
                    <span> <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                    </span>
                    <input  name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                    <input  name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                </div>
              </div>
              
              <div class="col-3 ">
                <button class="btn btn-first" type="submit" name="mysubmit" value="Search"><span>Search</span></button>
              </div>
            </form>
          </div>
        </div>
      </div> -->
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-detail">
              <div class="row">
                <div class="col-12 text-success">
                  <?php
                    $count = 0;
                    if (isset($msg)) {
                    echo $msg;
                    }
                    ?>
                </div>
              </div>
              <div class="pos-list-dtable reset-dataTable">
                <table id="dt_pos_sale_list" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th width="17%"  >Image</th>
                          <th >Name</th>
                          <th width="12%">Category</th>
                          <th width="21%">SKU</th>
                          <th width="12%">Price</th>
                          <th width="12%">tax</th>
                          <th width="5%" class="no-event" >In Stock</th>
                          <th width="15%"  >Sold Quantity</th>
                          <th width="5%"  >Status</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                   
                        $i = 1;
                        foreach ($mem as $a_data) 
                        {
                        $count++;
                        ?>
                      <tr>
                          
                          <td>
                              <span class="card-type-image">
                                <?php  if($a_data['item_image']!='') {
                                ?>
                                <img src="<?=base_url()?>uploads/item_image/<?php echo $a_data['item_image']; ?>"  >
                                <?php }else{ ?>
                                 <div class="text-danger" style="width:30px;  height:30px; ">No-Image</div>
                                <?php } ?>
                               
                              </span>
                          </td>
                          <td><?php echo $a_data['name'] ?></td>
                          <td><?php echo $a_data['cat_name'] ?></td>
                          <td><?php echo $a_data['sku'] ?></td>
                          <td>$ <?php echo $a_data['price'] ? number_format($a_data['price'],2) : '0.00'; ?></td>
                          <td><?php echo $a_data['tax'] ?>%</td>
                          <td><?php if($a_data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $a_data['quantity']; }  ?></td>
                          <!-- <td><?php echo date("M d Y h:i A", strtotime($a_data['date'])); ?></td> -->
                          <td><?php if($a_data['sold_quantity']=='I'){ echo 'Infinite'; }else{ echo $a_data['sold_quantity']; } ?></td>
                          <td><?php if($a_data['status']=='0') { echo 'active'; }else if($a_data['status']=='1'){ echo 'inactive'; }else if($a_data['status']=='2'){ echo 'deleted'; }else{ echo '--'; }  ?></td>
                      </tr>
                    <?php $i++;}?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- End Page Content -->
<div id="loader-content" style="display: none;">
  <div id="modal-loader" class="text-center"  style="padding: 15px">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
  </div>
</div>
<div id="invoice-receipt-modal" class="invRecptMdlWrapper modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content" id="invoicePdfData"> 
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

<?php
include_once 'footer_new.php';
?>
