<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .table tbody tr td span, table tbody tr td span {
        display: inline !important;
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
                    <!-- <h4 class="h4-custom">Inventory Report</h4> -->
                </div>
            </div>

            <?php $count = 0; ?>
            <!-- <div class="row">
                <div class="col-sm-8">
                    <form class="row" method="post" action="<?php echo base_url('pos/inventoryreport'); ?>" >
                        <div class="col-6">
                            <div id="pos_list_daterange" class="form-control date-range-style" style="margin-top: 7px !important;border: none !important;">
                                <span> <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) .'-'. date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                                </span>
                                <input id="start_date" name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input id="end_date" name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                            </div>
                        </div>
                        <?php if(count($getInventry_main_items) > 0 ) { ?>
                            <div class="col-3">
                                <select class="form-control" name="main_items" id="main_items" style="border: none !important;margin-top: 2px !important;">
                                    <option value="">Categories</option>
                                    <?php foreach($getInventry_main_items  as $inventory) { ?>
                                        <option value="<?php echo  $inventory->id; ?>" <?php if($main_items==$inventory->id){ echo 'selected';} ?> ><?php echo  $inventory->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="col-3">
                            <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search" style="width: 130px !important;"><i class="mdi mdi-magnify medium"></i>Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-4">
                    <div class="row pull-right">
                        <div class="col-4">
                            <form method="post" action="<?php echo base_url('pos/inventoryreport'); ?>" >
                                <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                <input name="main_items" type="hidden" value="<?php echo (isset($main_items) && !empty($main_items)) ? $main_items : ''; ?>">
                                <button class="btn btn-rounded social-btn-outlined" type="submit" name="search_Submit" value="Search"><i class="mdi mdi-arrow-down small"></i>PDF</button>
                            </form>
                        </div>

                        <div class="col-4">
                            <form method="post" id="form_excel" action="<?php echo base_url('pos/inventoryreport_ExcelDownload/') ?>">
                                <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                <input name="main_items" type="hidden" value="<?php echo (isset($main_items) && !empty($main_items)) ? $main_items : ''; ?>">
                                <button class="btn btn-rounded social-btn-outlined" type="submit" name="excel_export" value="Excel"><i class="mdi mdi-arrow-down medium"></i>Excel</button>
                            </form>
                        </div>

                        <div class="col-4">
                            <form method="post" id="form_csv" action="<?php echo base_url('pos/inventoryreport_CSVDownload/') ?>">
                                <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                <input name="main_items" type="hidden" value="<?php echo (isset($main_items) && !empty($main_items)) ? $main_items : ''; ?>">
                                <button class="btn btn-rounded social-btn-outlined" type="submit" name="excel_csv" value="CSV"><i class="mdi mdi-arrow-down small"></i>CSV</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div class="row"> -->
                <!-- <div class="col-sm-8"> -->
                    <form class="row" method="post" action="<?php echo base_url('pos/inventoryreport'); ?>" style="margin-bottom: 15px;">
                        <!-- <div class="col-6"> -->
                        <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                            <div id="pos_list_daterange" class="form-control date-range-style" style="margin-top: 7px !important;border: none !important;">
                                <span> <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) .'-'. date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                                </span>
                                <input id="start_date" name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input id="end_date" name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                            </div>
                        </div>
                        <?php if(count($getInventry_main_items) > 0 ) { ?>
                            <!-- <div class="col-3"> -->
                            <div class="table_custom_status_selector">
                                <select class="form-control" name="main_items" id="main_items" style="border: none !important;margin-top: 2px !important;">
                                    <option value="">Categories</option>
                                    <?php foreach($getInventry_main_items  as $inventory) { ?>
                                        <option value="<?php echo  $inventory->id; ?>" <?php if($main_items==$inventory->id){ echo 'selected';} ?> ><?php echo  $inventory->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <!-- <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search" style="width: 130px !important;"><i class="mdi mdi-magnify medium"></i>Submit</button> -->
                            <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                        </div>
                    </form>
                <!-- </div> -->
            <!-- </div> -->
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <!-- <div class="row pull-right"> -->
                        <!-- <div class="col-4"> -->
                            <form method="post" action="<?php echo base_url('pos/inventoryreport'); ?>" >
                                <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                <input name="main_items" type="hidden" value="<?php echo (isset($main_items) && !empty($main_items)) ? $main_items : ''; ?>">
                                <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="search_Submit" value="Search" style="margin-right: 5px;"><i class="mdi mdi-arrow-down small"></i>PDF</button>
                            </form>
                        <!-- </div> -->

                        <!-- <div class="col-4"> -->
                            <form method="post" id="form_excel" action="<?php echo base_url('pos/inventoryreport_ExcelDownload/') ?>">
                                <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                <input name="main_items" type="hidden" value="<?php echo (isset($main_items) && !empty($main_items)) ? $main_items : ''; ?>">
                                <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="excel_export" value="Excel" style="margin-right: 5px;"><i class="mdi mdi-arrow-down medium"></i>Excel</button>
                            </form>
                        <!-- </div> -->

                        <!-- <div class="col-4"> -->
                            <form method="post" id="form_csv" action="<?php echo base_url('pos/inventoryreport_CSVDownload/') ?>">
                                <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                <input name="main_items" type="hidden" value="<?php echo (isset($main_items) && !empty($main_items)) ? $main_items : ''; ?>">
                                <button class="btn btn-rounded social-btn-outlined btn_width_sm" type="submit" name="excel_csv" value="CSV"><i class="mdi mdi-arrow-down small"></i>CSV</button>
                            </form>
                        <!-- </div> -->
                    <!-- </div> -->
                </div>
            </div>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="dt_pos_sale_list" class="hover row-border" style="width:100%">
                        <thead>
                            <tr>
                                <th width="17%" style="padding-left: 25px !important;">Image</th>
                                <th >Name</th>
                                <th width="12%">Sku</th>
                                <th width="21%">Total Sold</th>
                                <th width="5%">SubTotal</th>
                                <th width="12%">Discount</th>
                                <th width="12%">Tax</th>
                                <th width="12%">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            //print_r($package_data_mis_item);
                            foreach ($package_data_no_main_item as $a_data) { ?>
                                <tr>
                                    <td>
                                        <span class="card-type-image">
                                            <?php  if($a_data['item_image']!='') { ?>
                                                <img src="<?php echo base_url().'uploads/item_image/'.$a_data['item_image'] ?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;">
                                            <?php } else { ?>
                                                <!-- <div class="text-danger" style="width:40px;height:40px;">No-Image</div> -->
                                                <img src="<?=base_url('new_assets/img/no-image.png')?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;">
                                            <?php } ?>
                                        </span>
                                    </td>
                                    <td title="<?php echo $a_data['updated_at']?>" ><?php echo Ucfirst($a_data['mname']); ?></td>
                                    <td><?php echo $a_data['sku']; ?></td>
                                    <td><?php if($a_data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $a_data['quantity']; }  ?></td>
                                    <td><?php  if($a_data['sold_price']!="") { echo '$ '.number_format($a_data['sold_price'],2); }else{ echo '0.00'; }?></td>
                                    <td><?php  if($a_data["discount"]!="") { echo '$ '.number_format(str_replace("-",'', $a_data['discount']),2); }else{ echo '$ 0.00'; } ?></td>
                                    <td>$<?php echo $a_data['tax_value'] ? number_format($a_data['tax_value'],2) :'0.00';  ?></td> 
                                    <td>$ <?php echo $a_data['sold_price'] ? number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2) : '0.00'; ?></td>
                                </tr>
                            <?php }
                            
                             foreach ($package_data_mis_item as $a_data) { ?>
                                <tr>
                                    <td>
                                        <span class="card-type-image">
                                            <?php  if($a_data['item_image']!='') { ?>
                                                <img src="<?php echo base_url().'uploads/item_image/'.$a_data['item_image'] ?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;">
                                            <?php } else { ?>
                                                <!-- <div class="text-danger" style="width:40px;height:40px;">No-Image</div> -->
                                                <img src="<?=base_url('new_assets/img/no-image.png')?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;">
                                            <?php } ?>
                                        </span>
                                    </td>
                                    <td title="<?php echo $a_data['updated_at']?>" ><?php echo Ucfirst($a_data['mname']); ?></td>
                                    <td><?php echo $a_data['sku']; ?></td>
                                    <td><?php if($a_data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $a_data['quantity']; }  ?></td>
                                    <td><?php  if($a_data['sold_price']!="") { echo '$ '.number_format($a_data['sold_price'],2); }else{ echo '0.00'; }?></td>
                                    <td><?php  if($a_data["discount"]!="") { echo '$ '.number_format(str_replace("-",'', $a_data['discount']),2); }else{ echo '$ 0.00'; } ?></td>
                                    <td>$<?php echo $a_data['tax_value'] ? number_format($a_data['tax_value'],2) :'0.00';  ?></td> 
                                    <td>$ <?php echo $a_data['sold_price'] ? number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2) : '0.00'; ?></td>
                                </tr>
                            <?php }
                           
                            
                            $i = 1;
                            foreach ($mem as $a_data) {
                                $count++; ?>
                                <tr>
                                    <td>
                                        <span class="card-type-image">
                                            <?php if($a_data['item_image']!='') { ?>
                                                <img src="<?php echo base_url().'uploads/item_image/'.$a_data['item_image'] ?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;">
                                            <?php } else { ?>
                                                <!-- <div class="text-danger" style="width:40px;  height:40px; ">No-Image</div> -->
                                                <img src="<?=base_url('new_assets/img/no-image.png')?>" style="width:40px !important;height:40px !important;border-radius: 10px !important;">
                                            <?php } ?>
                                        </span>
                                    </td>
                                    <td title="<?php echo $a_data['updated_at']?>" ><?php echo Ucfirst($a_data['mname']); ?></td>
                                    <td></td>
                                    <td><?php if($a_data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $a_data['quantity']; }  ?></td>
                                    <td><?php  if($a_data['sold_price']!="") { echo '$ '.number_format($a_data['sold_price'],2); }else{ echo '0.00'; }?></td>
                                    <td><?php  if($a_data["discount"]!="") { echo '$ '.number_format(str_replace("-",'', $a_data['discount']),2); }else{ echo '$ 0.00'; } ?></td>
                                    <td>$<?php echo $a_data['tax_value'] ? number_format($a_data['tax_value'],2) :'0.00';  ?></td> 
                                    <td>$ <?php echo $a_data['sold_price'] ? number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2) : '0.00'; ?></td>
                                </tr>
                                <?php $parent = $this->Inventory_model->get_full_inventory_reportdata($start_date, $end_date,$a_data['merchant_id'],$a_data['main_item_id']);
                                foreach ($parent as $parent_Data) {       
                                    if(strtolower($parent_Data['item_title'])!='regular') { ?>
                                        <tr id="item_id<?=$parent_Data['item_id']?>" style="height: 40px !important;">
                                            <td></td>
                                            <td style="padding-left:25px;">-<?php if(Ucfirst($parent_Data['item_title'])!='Regular'){echo Ucfirst($parent_Data['item_title']);} elseif(Ucfirst($parent_Data['item_title'])=='Regular'){echo Ucfirst($parent_Data['item_name']);}  ?></td>
                                            <td><?php echo $parent_Data['sku'] ?></td>
                                            <td><?php if($parent_Data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $parent_Data['quantity']; } ?></td>
                                            <td><?php  if($parent_Data['sold_price']!="") { echo '$ '.number_format($parent_Data['sold_price'],2); }else{ echo '0.00'; }?></td>
                                            <td><?php  if($parent_Data["discount"]!="") { echo '$ '.number_format(str_replace("-",'', $parent_Data['discount']),2); }else{ echo '$ 0.00'; } ?></td>
                                            <td>$<?php echo $parent_Data['tax_value'] ? number_format($parent_Data['tax_value'],2) :'0.00'; ?></td>
                                            <td>$ <?php echo $parent_Data['sold_price'] ? number_format(($parent_Data['sold_price']+$parent_Data['tax_value'])-$parent_Data['discount'],2) : '0.00'; ?></td>
                                        </tr>
                                    <?php }
                                }
                                $i++;
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<link rel="stylesheet" type="text/css" href="https://salequick.com/new_assets/css/sweetalert.css">
<script src="https://salequick.com/new_assets/js/sweetalert.js"></script>
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

  $(document).ready(function(){
    // $(document).on('click', '#export_excel', function() {
    //   // $('#form_excel').on('submit', function (e) {
    //   //   e.preventDefault();
    //   //   $.ajax({
    //   //     type: 'post',
    //   //     url: '<?php echo base_url('pos/inventoryreport_ExcelDownload/') ?>',
    //   //     data: $('#form_excel').serialize(),
    //   //     success: function () {
    //   //       window.open('<?php echo base_url('pos/inventoryreport_ExcelDownload/') ?>','_blank' );
    //   //     }
    //   //   });
    //   // });
    //   var start_date = $('#start_date').val();
    //   var end_date = $('#end_date').val();
    //   var main_items = $('#main_items').val();
    //   var data = {
    //           "filter_data": [{
    //             'start_date': start_date,
    //             'end_date': end_date,
    //             'main_items': main_items
    //             }]
    //           };
    //   // console.log(data);return false;
    //   $.ajax({
    //     url: "<?php echo base_url('pos/inventoryreport_ExcelDownload/') ?>",
    //     data: {"filter_data": [{'start_date': start_date, 'end_date': end_date, 'main_items': main_items}]},
    //     method: 'POST',
    //     success: function(){
    //       window.open('<?php echo base_url('pos/inventoryreport_ExcelDownload/') ?>','_blank' );
    //     }
    //   });
    // })

    $(document).on('click', '#export_csv', function() {
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      var main_items = $('#main_items').val();
      var data = {
              "filter_data": [{
                'start_date': start_date,
                'end_date': end_date,
                'main_items': main_items
                }]
              };
      // console.log(data);
      $.ajax({
        url: "<?php echo base_url('pos/inventoryreport_CSVDownload/') ?>",
        data: data,
        method: 'POST',
        success: function(){
          window.open('<?php echo base_url('pos/inventoryreport_CSVDownload/') ?>','_blank' );
        }
      });
    })
  })
</script>

<?php include_once'footer_dash.php'; ?>