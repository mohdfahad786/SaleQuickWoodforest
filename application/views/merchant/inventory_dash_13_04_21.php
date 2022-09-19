<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    .table tbody tr td span, table tbody tr td span {
        display: inline !important;
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
    @media screen and (max-width: 640px) {
        .btn.social-btn-outlined i.small {
            margin-right: 10px !important;
        }
    }
    @media screen and (max-width: 380px) {
        .btn:not(.social-icon-btn).social-btn-outlined.btn_width_sm {
            width: 90px !important;
        }
    }
    /*td a {
        color: black !important;
        text-decoration: underline !important;
        font-size: 14px !important;
        margin-right: 10px !important;
    }*/
    .btn_custom {
        height: 30px !important;
        max-height: 30px !important;
        padding: 4px 8px !important;
        text-transform: none !important;
        width: 78px !important;
    }
    .btn_custom_v {
        height: 30px !important;
        max-height: 30px !important;
        padding: 4px 8px !important;
        text-transform: none !important;
        width: 160px !important;
    }
    .product_image {
        width:40px !important;
        height:40px !important;
        border-radius: 10px !important;
    }
    .product_no_image {
        width: 40px;
        height: 40px;
        font-size: 22px;
        color: #fff;
        font-family: Roboto-Thin !important;
        padding: 4px;
        border-radius: 10px;
        background-color: rgb(0, 166, 255);
        text-align: center !important;
        margin-left: 5px !important;
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
                    <!-- <h4 class="h4-custom">Inventory Management</h4> -->
                </div>
            </div>

            <?php $count = 0; ?>
            <div class="row">
                <form method="post" action="<?php echo base_url('pos/inventorymngt_FullExcelDownload'); ?>">
                    <div class="col-4">
                        <a href="<?php echo base_url('pos/inventorymngt_FullExcelDownload/') ?>">
                            <button id="excel-print" class="btn btn-rounded social-btn-outlined btn_width_sm"><i class="mdi mdi-arrow-down medium"></i>Excel</button>
                        </a>
                    </div>
                </form>

                <form method="post" action="<?php echo base_url('pos/inventorymngt_FullCSVDownload'); ?>">
                    <div class="col-4">
                        <a href="<?php echo base_url('pos/inventorymngt_FullCSVDownload/') ?>">
                            <button id="csv-print" class="btn btn-rounded social-btn-outlined btn_width_sm"><i class="mdi mdi-arrow-down small"></i>CSV</button>
                        </a>
                    </div>
                </form>
            </div>
            <hr>
            <?php $merchant_id = $this->session->userdata('merchant_id'); ?>
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-12">
                    <?php //echo '<pre>';print_r($mem); ?>
                    <table id="dt_pos_sale_list_e" class="hover row-border" style="width:100%">
                        <thead>
                            <tr>
                                <th width="17%" style="padding-left: 25px !important;">Image</th>
                                <th>Name</th>
                                <th width="12%">Category</th>
                                <th width="21%">SKU</th>
                                <th>Barcode</th>
                                <th width="12%">Price</th>
                                <th width="12%">Tax</th>
                                <th width="5%" class="no-event">In Stock</th>
                                <th width="15%">Sold Qty</th>
                                <th width="5%">Status</th>
                                <?php if($merchant_id == '413') { ?>
                                    <th width="5%">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($package_data_no_main_item as $a_data) { ?>
                                <tr>
                                    <td>
                                        <span class="card-type-image">
                                            <?php if($a_data['item_image']!='') { ?>
                                                <img src="<?=base_url()?>uploads/item_image/<?php echo $a_data['item_image']; ?>" class="product_image">
                                            <?php } else { ?>
                                                <!-- <img src="<?=base_url('new_assets/img/no-image.png')?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;"> -->
                                                <div class="product_no_image">
                                                    <?php echo strtoupper(substr($a_data['name'],0,1)); ?>
                                                </div>
                                            <?php } ?>
                                        </span>
                                    </td> 
                                    <td style="font-size:16px;font-stle:bold"><?php echo Ucfirst($a_data['name']) ?></td>
                                    <td><?php echo $a_data['cat_name'] ?></td>
                                    <td><?php echo $a_data['sku'] ?></td>
                                    <td><?php echo $a_data['barcode_data'] ?></td>
                                    <td>$ <?php echo $a_data['price'] ? number_format($a_data['price'],2) : '0.00'; ?></td>
                                    <td><?php echo $a_data['tax'] ?>%</td>
                                    <td><?php if($a_data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $a_data['quantity']; }  ?></td>
                                    <td><?php if($a_data['sold_quantity']=='I'){ echo 'Infinite'; }else{ echo $a_data['sold_quantity']; } ?></td>
                                    <td><?php if($a_data['status']=='0') { echo 'Active'; }else if($a_data['status']=='1'){ echo 'Inactive'; }else if($a_data['status']=='2'){ echo 'Deleted'; }else{ echo '--'; }  ?></td>
                                    <?php if($merchant_id == '413') { ?>
                                    <td>
                                        <a class="btn btn-sm btn-secondary btn_custom" href="<?php echo base_url('Inventory/editInventory/'); ?><?php echo $a_data['id']; ?>"><i class="fa fa-pencil"></i> Edit</a>
                                        <a class="btn btn-sm btn-danger btn_custom" href="#" onClick="del_main_item(<?php echo $a_data['item_id'];?>)"><i class="fa fa-trash"></i> Delete</a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <?php
                            $i = 1;
                            foreach ($mem as $a_data) { ?>
                                <tr>
                                    <td>
                                        <span class="card-type-image">
                                            <?php if($a_data['item_image']!='') { ?>
                                                <img src="<?=base_url()?>uploads/item_image/<?php echo $a_data['item_image']; ?>" class="product_image">
                                            <?php } else { ?>
                                                <!-- <img src="<?=base_url('new_assets/img/no-image.png')?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;"> -->
                                                <div class="product_no_image">
                                                    <?php echo strtoupper(substr($a_data['name'],0,1)); ?>
                                                </div>
                                            <?php } ?>
                                        </span>
                                    </td>
                                    <td style="font-size:16px;font-stle:bold"><?php echo Ucfirst($a_data['mname']) ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php if($merchant_id == '413') { ?>
                                    <td>
                                        <a class="btn btn-sm btn-info btn_custom_v" href="<?php echo base_url().'Inventory/addProductVariant/'.$a_data['item_id']; ?>"><i class="fa fa-plus"></i> Add Variant</a>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $parent = $this->Inventory_graph_model->get_full_inventory_data_no_limit_list($a_data['merchant_id'],$a_data['item_id']);
                
                                foreach ($parent as $parent_Data) { ?> 
                                    <tr style="height: 40px !important;">
                                        <td></td>
                                        <td style="padding-left:25px;">-<?php echo $parent_Data['title'] ?></td>
                                        <td><?php echo $parent_Data['cat_name'] ?></td>
                                        <td><?php echo $parent_Data['sku'] ?></td>
                                        <td><?php echo $parent_Data['barcode_data'] ?></td>
                                        <td>$ <?php echo $parent_Data['price'] ? number_format($parent_Data['price'],2) : '0.00'; ?></td>
                                        <td><?php echo $parent_Data['tax'] ?>%</td>
                                        <td><?php if($parent_Data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $parent_Data['quantity']; }  ?></td>
                                        <td><?php if($parent_Data['sold_quantity']=='I'){ echo 'Infinite'; }else{ echo $parent_Data['sold_quantity']; } ?></td>
                                        <td><?php if($parent_Data['status']=='0') { echo 'Active'; }else if($parent_Data['status']=='1'){ echo 'Inactive'; }else if($parent_Data['status']=='2'){ echo 'Deleted'; }else{ echo '--'; }  ?></td>
                                        <?php if($merchant_id == '413') { ?>
                                        <td>
                                            <a class="btn btn-sm btn-secondary btn_custom" href="<?php echo base_url('Inventory/editInventory/'); ?><?php echo $parent_Data['id']; ?>"><i class="fa fa-pencil"></i> Edit</a>
                                            <!-- <a href="<?php echo base_url('Inventory/deleteAdvPOSItem/'); ?><?php echo $parent_Data['id']; ?>" onclick="alert('Are you sure!');"><i class="fa fa-trash"></i></a> -->
                                            <a class="btn btn-sm btn-danger btn_custom" href="#" onClick="del_tier_item(<?php echo $parent_Data['id'];?>)"><i class="fa fa-trash"></i> Delete</a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                <?php }
                                $i++;
                            }?>
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

<div class="modal fade" id="message_popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
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

    function del_main_item(id) {
        swal({
            title: "<span style='font-size: 21px;'>Are you sure, want to delete this Item?</span>",
            text: "<span style='font-size: 16px;'>You will not be able to recover this info!</span>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn danger-btn",
            confirmButtonText: "Yes, remove it!",
            cancelButtonClass: "btn btn-first",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo base_url('Inventory/deleteAdvPOSMainItem')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if(data.status == '200'){
                            location.reload();
                        } else {
                            var msg = data.errorMsg;
                            $("#message_popup.modal-body").html(msg);
                            $("#message_popup").modal('show');
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            } else {

            }
        })
    }

    function del_tier_item(id) {
        swal({
            title: "<span style='font-size: 21px;'>Are you sure, want to delete this Item?</span>",
            text: "<span style='font-size: 16px;'>You will not be able to recover this info!</span>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn danger-btn",
            confirmButtonText: "Yes, remove it!",
            cancelButtonClass: "btn btn-first",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo base_url('Inventory/deleteAdvPOSItem')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if(data.status == '200'){
                            location.reload();
                        } else {
                            var msg = data.errorMsg;
                            $("#message_popup.modal-body").html(msg);
                            $("#message_popup").modal('show');
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            } else {

            }
        })
    } 
</script>

<?php include_once'footer_dash.php'; ?>