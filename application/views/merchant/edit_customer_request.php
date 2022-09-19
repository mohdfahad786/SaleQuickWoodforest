<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>
 
<!-- Start Page Content -->
	<div id="wrapper"> 
		<!-- class="form-control bg-gray" -->
		<div class="page-wrapper recurring-wrapper"> 
			<?php
				if(isset($msg))
					echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$msg."</div> </div> </div> </div>";
			
					if($this->session->flashdata('error'))
					{
						echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$this->session->flashdata("error")."</div> </div> </div> </div>";
					}
					else if($this->session->flashdata('success'))
					{
						echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$this->session->flashdata("success")."</div> </div> </div> </div>";
					}
				 
		 
					
			?>
			<?php
			 if( isset($get_recurring_invoice) ) {

				echo form_open('recurring/edit_customer_request/'.$get_recurring_invoice->id, array('id' => "my_form",'class'=>"row"));
				echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
				$merchant_name = $this->session->userdata('merchant_name');
				$names = substr($merchant_name, 0, 3);
			?>  
			<!-- <div class="row"> -->
				<div class="col-12">

					<div class="card content-card">
						<div class="card-title">
							Update Invoice For Recurring
								<div class="float-right text-right custom-form recurring__topinvoice">
									<div class="form-group m-0">
										<label for="" style="font-weight: 500;font-size: 12px;">Invoice No</label>
										<input class="form-control" name="invoice_no" id="invoice_no" pattern="[a-zA-Z\s]+"  
										value="<?=$get_recurring_invoice->invoice_no; ?>"  readonly required type="text">

										<input type="hidden" name="url" value="<?=$get_recurring_invoice->url; ?>" />
										<input type="hidden" name="payment_id" value="<?=$get_recurring_invoice->payment_id; ?>" />
										<input type="hidden" name="recurring_count_paid" value="<?=$get_recurring_invoice->recurring_count_paid; ?>" />
										<input type="hidden" name="merchant_id" value="<?=$get_recurring_invoice->merchant_id; ?>" />
										<input type="hidden" name="itemid" value="<?=$itemslist[0]->id; ?>" />
									 
									</div>
								</div>
						</div>
						<div class="card-detail recurring__geninfo" >
							<div class="row custom-form responsive-cols f-wrap f-auto">
								<div class="col mx-253">
									<div class="form-group">
										<label for="">Customer Name</label>
										<input class="form-control" name="name" id="name" readonly pattern="[a-zA-Z\s]+"  placeholder="Full Name" value="<?=$get_recurring_invoice->name; ?>" required type="text">
									</div>
								</div>
								<div class="col mx-253">
									<div class="form-group">
										<label for="">Email Address</label>
										<input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email"
											value="<?=$get_recurring_invoice->email_id; ?>" type="email">
									</div>
								</div>
								<div class="col mx-253">
									<div class="form-group">
										<label for="">Phone Number</label>
											<input class="form-control" placeholder="Phone" name="mobile" id="phone" 
											value="<?=$get_recurring_invoice->mobile_no; ?>" type="text" readonly>
									</div>
								</div>
								<div class="col mx-253">
									<div class="form-group">
										<label for="">Reference Number</label>
										<input class="form-control" placeholder="Ex.P.O. Number" name="reverence" id="reverence"  placeholder="Reference"
										value="<?=$get_recurring_invoice->reference; ?>"  type="text">
									</div>
								</div>
								<div class="col mx-253">
									<div class="form-group">
										<label for="">Start Date</label>
											<?php 
												if($get_recurring_invoice->recurring_count_paid != 0){
											?>
											<input type="text" name="recurring_pay_start_date" readonly  value="<?=$get_recurring_invoice->recurring_pay_start_date; ?>" class="form-control" autocomplete="off" required placeholder="Start date" >
										<?php }else{ ?>
											<input type="text" name="recurring_pay_start_date" value="<?=$get_recurring_invoice->recurring_pay_start_date; ?>" class="form-control bindCanendar" autocomplete="off" required placeholder="Start date" >
										<?php }?>
									</div>
								</div>
								
								<?php 
									if($get_recurring_invoice->recurring_count_paid != 0){
								?>
								<div class="col mx-253">
									<div class="form-group">
										<label for="">Next Payment Date  </label>
											<input type="text" name="recurring_next_pay_date"  value="<?php echo $get_recurring_invoice->recurring_next_pay_date; ?>" class="form-control" autocomplete="off" required placeholder="Next Payment  date" id="nextPayCalandar">
									</div>
								</div>
							<?php }?>
							</div>
						</div>
					</div>

				</div>
				<div class="col-12">
					<div class="card content-card mb-10">
						<!-- <div class="card-title">
						 Payment Detail
						</div> -->
						<?php
							// print_r($get_recurring_invoice);
						?>
						<div class="card-detail">
							<div class="row custom-form responsive-cols">
								<div class="col mx-301">
									<div class="form-group">
										<label for="">Payment Interval</label>
										<select class="form-control" name="recurring_type"  required >                      
											<option value="">Select Type</option>
											<option value="daily" <?php if($get_recurring_invoice->recurring_type=='daily') echo 'selected';  ?> >Daily</option>
											<option value="weekly" <?php if($get_recurring_invoice->recurring_type=='weekly') echo 'selected';  ?>>Weekly</option>
											<option value="biweekly" <?php if($get_recurring_invoice->recurring_type=='biweekly') echo 'selected';  ?>>Bi Weekly</option>
											<option value="monthly" <?php if($get_recurring_invoice->recurring_type=='monthly') echo 'selected';  ?>>Monthly</option>
											<option value="quarterly" <?php if($get_recurring_invoice->recurring_type=='quarterly') echo 'selected';  ?>>Quarterly</option>
											<option value="yearly" <?php if($get_recurring_invoice->recurring_type=='yearly') echo 'selected';  ?>>Yearly</option>
										</select>
									</div>
								</div>
								<div class="col mx-301">
									<div class="form-group " >
										<label for="" style="display: block">Payments Duration Remaining/Complete</label>
										<?php if($get_recurring_invoice->recurring_count < 0 ){ ?>
										<input type='text' class='form-control' value="∞ / <?php if($get_recurring_invoice->recurring_count_paid > 0 ) echo $get_recurring_invoice->recurring_count_paid; else echo '0'  ?>"  readonly >  
										<?php } else{ ?>

										<input type='text' class='form-control' value="<?php if($get_recurring_invoice->recurring_count_remain > 0 ) echo $get_recurring_invoice->recurring_count_remain;  ?>/<?php if($get_recurring_invoice->recurring_count_paid > 0 ) echo $get_recurring_invoice->recurring_count_paid; else echo '0' ?> "  readonly >
										 <?php }?>            
									</div>
								</div>
								<div class="col minx-351">
									<div class="form-group " id="payment_dur_wrapper">
										<label for="" style="display: block">Change Payments Duration</label>
										<div class="custom-checkbox" style="display: inline-block;padding-right: 21px;vertical-align: middle;">
											<input type="radio" class="radio-circle" id="pd__constant" name="pd__constant" <?php if($get_recurring_invoice->recurring_count < 0 ) echo 'checked';  ?>>
											<label for="pd__constant" class="inline-block" >Constant</label>
										</div>
											OR
										<input type="radio" id="pd__var" name="pd__constant" style="display: none;" <?php if($get_recurring_invoice->recurring_count > 0) echo 'checked';  ?>>

										<?php if($get_recurring_invoice->recurring_count < 0 ){ ?>
										<input type='text' style="width: auto;display: inline-block;vertical-align: middle;margin-left: 15px;" class='form-control' value="" name='recurring_count' id='recurring_count'  required  maxlength="3" placeholder="Enter 1 to 200 " onKeyPress="return isNumberKey(event)">    
										<?php } else{ ?> 
										<input type='text' style="width: auto;display: inline-block;vertical-align: middle;margin-left: 15px;" class='form-control' value="<?php if($get_recurring_invoice->recurring_count_remain > 0 ) echo $get_recurring_invoice->recurring_count_remain;  ?>" name='recurring_count' id='recurring_count'  required  maxlength="3" placeholder="Enter 1 to 200 " onKeyPress="return isNumberKey(event)">  
										<?php }?> 
									</div>
								</div>
								<div class="col-12">
									<div class="form-group recurring__paytpye">
										<label for="" style="display: block">Payment Type</label>
										<div class="custom-checkbox"   >
											<input type="radio" id="pt__Auto" class="radio-circle" value="1" name="paytype"  <?php echo (($get_recurring_invoice->recurring_pay_type=='1')? 'checked' : '');  ?>>
											<label for="pt__Auto" class="inline-block" >Auto</label>
										</div>
										<div class="custom-checkbox"  >
											<input type="radio" id="pt__Manual" class="radio-circle" value="0" name="paytype" <?php echo (($get_recurring_invoice->recurring_pay_type=='1')? '' : 'checked');  ?>>
											<label for="pt__Manual" class="inline-block" >Manual</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							All Items
						</div>
						<div class="card-detail inv-recur-adder-form">
							<div class="all_items_wrapper_outer">
								<div class="all_items_wrapper">

									<?php
										// print_r($itemslist);die;
										$itemLength=count(json_decode($itemslist[0]->quantity));
										// echo $itemLength;
									?>
									 <?php  for($i=0; $i<$itemLength;  $i++)
									 { 
												//json_decode($myJSON);
												$quantity=json_decode($itemslist[0]->quantity);
												$price=json_decode($itemslist[0]->price);
												$tax=json_decode($itemslist[0]->tax);
												$tax_id=json_decode($itemslist[0]->tax_id);
												$tax_per=json_decode($itemslist[0]->tax_per);
												$total_amount=json_decode($itemslist[0]->total_amount);
												$item_name=json_decode($itemslist[0]->item_name);

										 ?>
									<div class="row custom-form reset-col-p">
										<div class="col">
											<?php if($i == 0){?>
											<div class="form-group">
												<label for="">Item Name</label>
											</div>
											<?php }?>
											<div class="form-group">
												<input class="form-control item_name" name="Item_Name[]" value="<?=$item_name[$i]; ?>" placeholder="Item name" type="text" required="">
											</div>
										</div>
										<div class="col">
											<?php if($i == 0){?>
											<div class="form-group">
												<label for="">Quantity</label>
											</div>
											<?php }?>
											<div class="form-group">
												<input class="form-control item_qty" placeholder="Quantity" value="<?=$quantity[$i]?>" name="Quantity[]" id="quantity_1" type="text" onKeyPress="return isNumberKey(event)" required>
											</div>
										</div>
										<div class="col">
											<?php if($i == 0){?>
											<div class="form-group">
												<label for="">Price ($)</label>
											</div>
											<?php }?>
											<div class="form-group">
												<div class="input-group ">
													<div class="input-group-addon">
														<span class="input-group-text">$</span>
													</div>
													<input class="form-control item_price"  id="price_1"  name="Price[]" value="<?=$price[$i]?>" placeholder="Price" type="text" autocomplete="off"  onKeyPress="return isNumberKeydc(event)">
												</div>
											</div>
										</div>
										<div class="col">
											<?php if($i == 0){?>
											<div class="form-group">
												<label for="">Tax</label>
											</div>
											<?php }?>
											<div class="form-group">
												<?php
													$merchant_id = $this->session->userdata('merchant_id');
													$data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id,'status' => 'active')); 
												?>
												<select name="Tax[]" class="form-control sel_item_tax tax" id="tax_1" >
													<option rel="0" value="0" >No Tax</option>
													<?php foreach ($data as $view) { ?>
														<option rel="<?php echo $view['percentage']; ?>" <?php if($tax_id[$i]==$view['id']) echo 'selected'; ?> value="<?php echo $view['id']; ?>"><?php echo $view['title']; ?>&nbsp;(<?php echo $view['percentage']; ?>%)</option>
													<?php } ?>
												</select>
												<input type="hidden" class="form-control price item_tax" id="tax_amount_1" placeholder="Tax Amount"  name="Tax_Amount[]" value="<?=$tax[$i]?>">
												<input type="hidden" class="form-control hide_tax" id="tax_per_1" name="Tax_Per[]" value="<?=$tax_per[$i]?>">
											</div>
										</div>
										<div class="col">
											<?php if($i == 0){?>
											<div class="form-group">
												<label for="">Total ($)</label>
											</div>
											<?php }?>
											<div class="form-group">
												<div class="input-group ">
													<div class="input-group-addon">
														<span class="input-group-text">$</span>
													</div>
													<input class="form-control sub_total" placeholder="Total" value="<?=$total_amount[$i]?>" name="Total_Amount[]" id="total_amount_1" readonly type="text">
												</div>
											</div>
											<?php if($i != 0){?>
											<span class="remove-invoice-item"> <img src="https://salequick.com/new_assets/img/delete.png" alt="del"> </span>
											<?php }?>
										</div>
									</div>
								<?php } ?>

								</div>
							</div>
							<div class="item-adder new-item-adder">
								<button type="button" class="btn btn-custom1">Add Item <span class="material-icons plus"> add </span></button>
							</div>
						</div>
						<div class="card-title"></div>
						<div class="invoice-total-wraper">
							<div class="row custom-form">
								<div class="col form-inline">
									<label for="">Sub Total </label>
									<div class="input-group ">
										<div class="input-group-addon">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control " placeholder="0.00" name="sub_amount" id="sub_amount" type="text" value="<?php
										 // $subttl=(float)$get_recurring_invoice->amount-(float)$get_recurring_invoice->tax;
											$subttl1=$get_recurring_invoice->amount;
											$subttl2=$get_recurring_invoice->tax; 
											// settype($subttl1,float);
											// settype($subttl2,float);
											echo number_format(($subttl1 - $subttl2),2);
										 ?>" readonly>
									</div>
								</div>
							</div>
							<div class="row custom-form">
								<div class="col form-inline">
									<label for="">Total Tax</label>
									<div class="input-group ">
										<div class="input-group-addon">
											<span class="input-group-text">$</span>
										</div>
										<input class="form-control total_tax" name="total_tax" id="total_tax" placeholder="0.00" type="text" value="<?=$get_recurring_invoice->tax; ?>" readonly>
									</div>
								</div>
							</div>
							<div class="row custom-form">
								<div class="col form-inline">
									<label for="">Total Amount</label>
									<div class="input-group ">
										<div class="input-group-addon">
											<span class="input-group-text">$</span>
										</div>
										<input class="amount form-control" name="amount" type="text" value="<?=$get_recurring_invoice->amount; ?>" placeholder="0.00" id="amount"  type="text" readonly >
									</div>
								</div>
							</div>
							<div class="row custom-form inv-custom-btns">
								<div class="col form-inline">
									<button type="button" class="btn btn-second" onclick="history.back(-1)">Cancel</button>
									<button type="submit" name="submit" class="btn btn-first">Save</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- </div> -->
			<?php echo form_close(); }else{ ?>
				<div class="text-center text-danger">There Are No data...</div>
			<?php }  ?>
		</div>
	</div>
<!-- End Page Content -->
<style type="text/css">
	#invoiceStartDatePicker{
		width: auto;
	}
</style>
<script>
	$(document).ready(function(){
		//Add required in phone or email
		$("#send_request").click(function() {
			let email = $("#email").val(),
				phone = $("#phone").val()
			if(email != '') {
				$("#phone").removeAttr("required");
			} else if(phone != '') {
				$("#email").removeAttr("required");
			} else {
				$("#email, #phone").attr("required", true)
			}
		})
		if($('#nextPayCalandar').length){
			$('#nextPayCalandar').daterangepicker({
				singleDatePicker: true,minDate: moment(),showDropdowns: true,
				locale: {format: "YYYY-MM-DD"}
				}, function(start, end, label) {
			});
		}
		if($('.bindCanendar').length){
			$('.bindCanendar').daterangepicker({
				singleDatePicker: true,minDate: moment(),showDropdowns: true,
				locale: {format: "YYYY-MM-DD"}
				}, function(start, end, label) {
			});
		}
	})
	$(document)
	.on('click','#recurring_count',function(){
		console.log('click-1')
		$('#pd__var').trigger('click');
		$('#payment_dur_wrapper input[type=text]').attr('required','required');
	})
	.on('keydown keyup','#recurring_count',function(){
		var $this=$(this);
		var vals=parseInt($(this).val());
		if(vals >200){
			$this.closest('.form-group').find('label:first-child').html('Payments Duration <small style="color: #f5a623;">Max 200</small>');
			$this.val('200');
			setTimeout(function(){
			$this.closest('.form-group').find('label:first-child').html('Payments Duration');
			},2000)
			return false;
		}
	})
	.on('change','#pd__constant',function(){
		if($(this).is(':checked')){
			$('#payment_dur_wrapper input[type=text]').val('').removeAttr('required');
		}
	})
</script>

<?php
	include_once'footer_new.php';
?>

