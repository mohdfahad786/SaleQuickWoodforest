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
						<span>Inventory  Report</span>
					</div>
				</div>
			</div>
			<div class="row sales_date_range">
				<div class="col-12 custom-form">
					<div class="card content-card">
						<form class="row " method="post" action="<?php echo base_url('pos/inventoryreport'); ?>" >
							<div class="col mx-501">
								<div id="pos_list_daterange" class="form-control date-range-style">
										<span> <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
										</span>
										<input  name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
										<input  name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
								</div>
							</div>
							<?php   if(count($getInventry_main_items) > 0 ) { ?>
							<div class="col mx-501">
								<select class="form-control" name="main_items" id="main_items">
									<option value="">Items</option>
									<?php foreach($getInventry_main_items  as $inventory) { ?>
									<option value="<?php echo  $inventory->id; ?>" <?php if($main_items==$inventory->id){ echo 'selected';} ?> ><?php echo  $inventory->name; ?></option>
									<?php } ?>
									<!-- <option value="pending" <?php if($status=='pending'){ echo 'selected';} ?> >Pending</option>
									<option value="confirm" <?php if($status=='confirm') { echo 'selected'; } ?> >Confirm</option> -->
								</select>
							</div>
							<?php } ?>
							<div class="col-3 ">
								<button class="btn btn-first" type="submit" name="mysubmit" value="Search"><span>Search</span></button>
							</div>
						</form>
					</div>
				</div>
			</div>
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
													<th width="17%"  ></th>
													<th >Name</th>
													<th width="12%">Category</th>
													<th width="21%">Total Sold</th>
													<th width="5%">SubTotal</th>
													<th width="12%">Discount</th>
													<!-- <th width="12%">Tax</th> -->
													<th width="12%">Grand Total</th>
													<!-- <th width="5%"  >Status</th>
													<th width="12%"  >Date</th> -->
													
											</tr>
									</thead>
									<tbody>
										<?php
									 
												$i = 1;
												foreach ($mem as $a_data) 
												{
												$count++;

												
													
												?>
											<tr id="item_id<?=$a_data['item_id'];?>">
													
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
													<td title="<?php echo $a_data['updated_at']?>"><?php echo $a_data['item_name']; ?><?php //echo $a_data['item_title'] ? '('.$a_data['item_title'].')' :''; ?></td>
													<td><?php echo $a_data['cat_name'] ?></td>
													<td><?php if($a_data['quantity']=='I'){ echo "<span style='font-size:20px;'><b> &infin; </b></span>"; }else{ echo $a_data['quantity']; }  ?></td>
													<td><?php  if($a_data['sold_price']!="") { echo '$ '.number_format($a_data['sold_price'],2); }else{ echo '0.00'; }?></td>
													<td><?php  if($a_data["discount"]!="") { echo '$ '.number_format($a_data['discount'],2); }else{ echo '$ 0.00'; } ?></td>
													<!-- <td>$<?php echo $a_data['tax'] ? number_format($a_data['tax'],2) :'0.00';  ?></td> -->
													<!-- <td>$ <?php echo $a_data['base_price'] ? number_format($a_data['base_price'],2) : '0.00'; ?></td> -->
													<td>$ <?php echo $a_data['sold_price'] ? number_format($a_data['sold_price']-$a_data['discount'],2) : '0.00'; ?></td>

													<!-- <td><?php if($a_data['status']=='0') { echo 'Cart'; }else if($a_data['status']=='1'){ echo 'Wishlist'; }else if($a_data['status']=='2'){ echo 'Sold'; }else{ echo $a_data['status']; }  ?></td> -->
													 <!-- <td><?php echo date("M d Y h:i A", strtotime($a_data['updated_at'])); ?></td> -->
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
