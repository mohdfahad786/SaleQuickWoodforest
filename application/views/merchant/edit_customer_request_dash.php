<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    @media (max-width: 1300px) {
        .recurring__paytpye .custom-checkbox {
            max-width: 125px;
        }
    }
    @media (max-width: 800px) {
        .product_row_section {
            overflow: auto;
            white-space: nowrap;
        }
        .recurring__paytpye .custom-checkbox {
            max-width: 90px;
        }
        input#recurring_count {
            width: 60px !important;
        }
    }
	
	@media (max-width: 640px) {
        .all_items_wrapper {
            min-width: 645px !important;
        }
    }

    @media (max-width: 640px) {
        .name_wrapper_row {
            min-width: 645px !important;
        }
    }

    @media (max-width: 640px) {
        .col_prod_input {
            width: 175px;
        }
    }

    @media (max-width: 640px) {
        .col_qty_input {
            width: 70px;
        }
    }

    @media (max-width: 640px) {
        .col_price_input {
            width: 120px;
        }
    }

    @media (max-width: 640px) {
        .col_tax_input {
            width: 115px;
        }
    }

    @media (max-width: 640px) {
        .col_total_input {
            width: 115px;
        }
    }

    @media (max-width: 640px) {
        .col_del_input {
            width: 56px;
        }
    }

    @media (max-width: 640px) {
        .form-title {
            margin-top: 15px;
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
                    <!-- <h4 class="h4-custom">Edit Recurring</h4> -->
                </div>
            </div>
            
            <div class="row" style="margin-bottom: 30px !important;">
                <div class="col-12">
					<?php if( isset($get_recurring_invoice) ) {
						echo form_open('recurring/edit_customer_request/'.$get_recurring_invoice->id, array('id' => "my_form",'class'=>"row"));
						echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
						$merchant_name = $this->session->userdata('merchant_name');
						$names = substr($merchant_name, 0, 3); ?>
						
						<div class="grid grid-chart" style="width: 100% !important;">
							<div class="grid-body d-flex flex-column">
								<div class="mt-auto">
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-title">Customer Details</div>
											<div class="form-group">
												<label for="">Customer Name</label>
												<input class="form-control" name="name" id="name" readonly pattern="[a-zA-Z\s]+"  placeholder="Customer Name" value="<?=$get_recurring_invoice->name; ?>" required type="text">
											</div>
											<div class="form-group">
												<label for="">Email Address</label>
												<input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email Address" value="<?=$get_recurring_invoice->email_id; ?>" type="email">
											</div>
											<div class="form-group">
												<label for="">Mobile Number</label>
												<input class="form-control" placeholder="Mobile Number" name="mobile" id="phone" value="<?=$get_recurring_invoice->mobile_no; ?>" type="text" readonly>
											</div> 
										</div>
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-title">Invoice Details</div>
											<div class="form-group">
												<label for="">Invoice No</label>
												<input class="form-control" name="invoice_no" id="invoice_no" pattern="[a-zA-Z\s]+" value="<?=$get_recurring_invoice->invoice_no; ?>"  readonly required type="text">

												<input type="hidden" name="url" value="<?=$get_recurring_invoice->url; ?>" />
												<input type="hidden" name="payment_id" value="<?=$get_recurring_invoice->payment_id; ?>" />
												<input type="hidden" name="recurring_count_paid" value="<?=$get_recurring_invoice->recurring_count_paid; ?>" />
												<input type="hidden" name="merchant_id" value="<?=$get_recurring_invoice->merchant_id; ?>" />
												<input type="hidden" name="itemid" value="<?=$itemslist[0]->id; ?>" />
											</div>
											<div class="form-group">
												<label for="">Reference</label>
												<input class="form-control" placeholder="Ex.P.O. Number" name="reverence" id="reverence"  placeholder="Reference" value="<?=$get_recurring_invoice->reference; ?>"  type="text">
											</div>
											<div class="row">
												<div class="col-<?= ($get_recurring_invoice->recurring_count_paid != 0) ? '6' : '12' ?>">
													<div class="form-group">
														<label for="">Start Date</label>
														<?php if($get_recurring_invoice->recurring_count_paid != 0){ ?>
															<input type="text" name="recurring_pay_start_date" readonly  value="<?=$get_recurring_invoice->recurring_pay_start_date; ?>" class="form-control" autocomplete="off" required placeholder="Start date" >
														<?php } else { ?>
															<input type="text" name="recurring_pay_start_date" value="<?=$get_recurring_invoice->recurring_pay_start_date; ?>" class="form-control bindCanendar" autocomplete="off" required placeholder="Start date" >
														<?php } ?>
													</div>
												</div>
												<?php if($get_recurring_invoice->recurring_count_paid != 0){ ?>
													<div class="col-6">
														<div class="form-group">
															<label for="">Next Payment Date</label>
															<input type="text" name="recurring_next_pay_date" value="<?php echo $get_recurring_invoice->recurring_next_pay_date; ?>" class="form-control" autocomplete="off" required placeholder="Next Payment Date" id="nextPayCalandar">
														</div>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr class="form-hr">
							<div class="grid-body d-flex flex-column">
								<div class="mt-auto">
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="form-title">Payment Details</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
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
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group recurring__paytpye">
												<label for="" style="display: block">Payment Type</label>
												<div class="custom-checkbox">
													<input type="radio" id="pt__Auto" class="radio-circle" value="1" name="paytype"  <?php echo (($get_recurring_invoice->recurring_pay_type=='1')? 'checked' : ''); ?>>
													<label for="pt__Auto" class="inline-block" >Auto</label>
												</div>
												<div class="custom-checkbox">
													<input type="radio" id="pt__Manual" class="radio-circle" value="0" name="paytype" <?php echo (($get_recurring_invoice->recurring_pay_type=='1')? '' : 'checked'); ?>>
													<label for="pt__Manual" class="inline-block" >Manual</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<label for="" style="display: block">Payments Duration Remaining/Complete</label>
												<?php if($get_recurring_invoice->recurring_count < 0 ){ ?>
													<input type='text' class='form-control' value="∞ / <?php if($get_recurring_invoice->recurring_count_paid > 0 ) echo $get_recurring_invoice->recurring_count_paid; else echo '0'  ?>"  readonly >  
												<?php } else { ?>
													<input type='text' class='form-control' value="<?php if($get_recurring_invoice->recurring_count_remain > 0 ) echo $get_recurring_invoice->recurring_count_remain;  ?>/<?php if($get_recurring_invoice->recurring_count_paid > 0 ) echo $get_recurring_invoice->recurring_count_paid; else echo '0' ?> "  readonly >
												<?php } ?>            
											</div>
										</div>
										<div class="col-sm-6 col-md-6 col-lg-6">
											<div class="form-group " id="payment_dur_wrapper">
												<label for="" style="display: block">Change Payments Duration</label>
												<div class="custom-checkbox" style="display: inline-block;padding-right: 21px;vertical-align: middle;">
													<input type="radio" class="radio-circle" id="pd__constant" name="pd__constant" <?php if($get_recurring_invoice->recurring_count < 0 ) echo 'checked';  ?>>
													<label for="pd__constant" class="inline-block" >Constant</label>
												</div>
												OR
												<input type="radio" id="pd__var" name="pd__constant" style="display: none;" <?php if($get_recurring_invoice->recurring_count > 0) echo 'checked'; ?>>

												<?php if($get_recurring_invoice->recurring_count < 0 ){ ?>
													<input type='text' style="width: auto;display: inline-block;vertical-align: middle;margin-left: 15px;" class='form-control' value="" name='recurring_count' id='recurring_count'    maxlength="3" placeholder="Enter 1 to 200 " onKeyPress="return isNumberKey(event)">    
												<?php } else { ?> 
													<input type='text' style="width: auto;display: inline-block;vertical-align: middle;margin-left: 15px;" class='form-control' value="<?php if($get_recurring_invoice->recurring_count_remain > 0 ) echo $get_recurring_invoice->recurring_count_remain;  ?>" name='recurring_count' id='recurring_count'    maxlength="3" placeholder="Enter 1 to 200 " onKeyPress="return isNumberKey(event)">  
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr class="form-hr">
							<div class="grid-body d-flex flex-column">
								<div class="mt-auto product_row_section">
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="form-title">Items</div>
										</div>
									</div>
									
									<div class="card-detail name_wrapper_row">
										<?php
										$itemLength=count(json_decode($itemslist[0]->quantity));
										for($i=0; $i<$itemLength; $i++) {
											//json_decode($myJSON);
											$quantity=json_decode($itemslist[0]->quantity);
											$price=json_decode($itemslist[0]->price);
											$tax=json_decode($itemslist[0]->tax);
											$tax_id=json_decode($itemslist[0]->tax_id);
											$tax_per=json_decode($itemslist[0]->tax_per);
											$total_amount=json_decode($itemslist[0]->total_amount);
											$item_name=json_decode($itemslist[0]->item_name); ?>
											<div class="row">
												<?php if($i == 0){?>
													<div class="col-sm-3 col-md-3 col-lg-3 col_prod_input">
														<label for="">Product</label>
													</div>
												<?php } ?>
												
												<?php if($i == 0){?>
													<div class="col-sm-2 col-md-2 col-lg-2 col_qty_input" style="padding-left: 7px !important;">
														<label for="">QTY</label>
													</div>
												<?php } ?>
												
												<?php if($i == 0){?>
													<div class="col-sm-2 col-md-2 col-lg-2 col_price_input" style="padding-left: 7px !important;">
														<label for="">Unit Price ($)</label>
													</div>
												<?php } ?>
												
												<?php if($i == 0){?>
													<div class="col-sm-2 col-md-2 col-lg-2 col_tax_input" style="padding-left: 7px !important;">
														<label for="">Tax</label>
													</div>
												<?php } ?>
												
												<?php if($i == 0){?>
													<div class="col-sm-2 col-md-2 col-lg-2 col_total_input" style="padding-left: 7px !important;">
														<label for="">Total ($)</label>
													</div>
												<?php } ?>
												
												<?php if($i == 0){?>
													<div class="col-sm-1 col-md-1 col-lg-1 col_del_input"></div>
												<?php } ?>
											</div>
											<div class="all_items_wrapper">
												<div class="row custom-form reset-col-p" style="margin-bottom: 10px;">
													<div class="item_row col-sm-3 col-md-3 col-lg-3 col_prod_input">
														<input class="form-control item_name" name="Item_Name[]" value="<?=$item_name[$i]; ?>" placeholder="Product" type="text" required="">
													</div>
													<div class="item_row col-sm-2 col-md-2 col-lg-2 col_qty_input">
														<input class="form-control item_qty" placeholder="QTY" value="<?=$quantity[$i]?>" name="Quantity[]" id="quantity_1" type="text" onKeyPress="return isNumberKey(event)" required>
													</div>
													<div class="item_row col-sm-2 col-md-2 col-lg-2 col_price_input">
														<input class="form-control item_price" id="price_1" name="Price[]" value="<?=$price[$i]?>" placeholder="Unit Price ($)" type="text" autocomplete="off" onKeyPress="return isNumberKeydc(event)">
													</div>
													<div class="item_row col-sm-2 col-md-2 col-lg-2 col_tax_input">
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
													<div class="item_row col-sm-2 col-md-2 col-lg-2 col_total_input">
														<input class="form-control sub_total" placeholder="Total" value="<?=$total_amount[$i]?>" name="Total_Amount[]" id="total_amount_1" readonly type="text">
													</div>
													<div class="item_row col-sm-1 col-md-1 col-lg-1 col_del_input">
														<?php if($i != 0){?>
															<span class="remove-invoice-item"> <img src="https://salequick.com/new_assets/img/delete.png" alt="del"> </span>
														<?php } ?>
													</div>
												</div>
											</div>
										<?php } ?>
										<div class="row">
											<div class="col-12">
												<div class="item-adder new-item-adder">
													<button type="button" class="add-item">Add Product</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr class="form-hr">
							<div class="grid-body d-flex flex-column">
								<div class="mt-auto">
									<div class="row">
										<div class="col-sm-6 col-md-6 col-lg-8"></div>
										<div class="col-sm-6 col-md-6 col-lg-4">
											<div class="form-title">Total and Subtotal</div>
											<div class="row">
												<div class="col-sm-8 col-md-8 col-lg-8">
													<label class="invoicing_total_label" for="">Sub Total ($)</label>
												</div>
												<div class="col-sm-4 col-md-4 col-lg-4">
													<input class="form-control" value="<?php
														// $subttl=(float)$get_recurring_invoice->amount-(float)$get_recurring_invoice->tax;
														$subttl1=$get_recurring_invoice->amount;
														$subttl2=$get_recurring_invoice->tax; 
														// settype($subttl1,float);
														// settype($subttl2,float);
														echo number_format(($subttl1 - $subttl2),2); ?>" placeholder="0.00" name="sub_amount" id="sub_amount" type="text" readonly style="background-color: #fff !important;border: none !important;text-align: right !important;">
												</div>
											</div>
											<div class="row">
												<div class="col-sm-8 col-md-8 col-lg-8">
													<label class="invoicing_total_label" for="">Sub Tax ($)</label>
												</div>
												<div class="col-sm-4 col-md-4 col-lg-4">
													<input class="form-control total_tax" name="total_tax" id="total_tax" placeholder="0.00" value="<?=$get_recurring_invoice->tax; ?>" type="text" readonly style="background-color: #fff !important;border: none !important;text-align: right !important;">
												</div>
											</div>

											<?php
                                            $merchant_id = $this->session->userdata('merchant_id');
                                            $data = $this->admin_model->data_get_where_1('other_charges', array('merchant_id' => $merchant_id,'status' => 'active'));
                                            if($data[0]['percentage']!='') { ?>
                                            	<div class="row">
	                                                <div class="col-8">
	                                                    <label class="invoicing_total_label"><?php if($data[0]['title']!=''){echo $data[0]['title'];} else { ?>Other Charges <?php } ?> ($)</label>
	                                                </div>
                                                	<div class="col-4">
	                                                    <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data[0]['type']; ?>" readonly>

	                                                    <input class="form-control" name="other_charges_title" id="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>

	                                                    <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data[0]['percentage']; ?>" readonly>                          

	                                                    <!--<input class="form-control" placeholder="0.00" name="other_charges" id="other_charges" type="text" readonly>-->

	                                                    <input class="amount form-control" name="other_charges" value="0.00" id="other_charges" type="text" readonly style="background-color: #fff !important;border: none !important;text-align: right !important;" readonly>
                                                	</div>
                                            	</div>                                       
                                            <?php } ?>

											<div class="row">
												<div class="col-sm-8 col-md-8 col-lg-8">
													<label for="" style="font-size: 22px !important;font-weight: 600 !important;margin-top: 5px !important;">Total Amount ($)</label>
												</div>
												<div class="col-sm-4 col-md-4 col-lg-4">
													<input class="amount form-control" name="amount" placeholder="0.00" value="<?=$get_recurring_invoice->amount; ?>" id="amount" type="text" readonly style="background-color: #fff !important;border: none !important;font-size: 22px !important;font-weight: 600 !important;text-align: right !important;">
												</div>
											</div>
											<div class="row custom-form inv-custom-btns">
												<div class="col-sm-6 col-md-6 col-lg-6">
													<button type="button" class="btn btn-second" onclick="history.back(-1)" style="width: 100% !important;border-radius: 8px !important;">Cancel</button>
												</div>
												<div class="col-sm-6 col-md-6 col-lg-6">
													<button type="submit" name="submit" class="btn btn-first" style="width: 100% !important;border-radius: 8px !important;">Save</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close();
					} else { ?>
						<div class="text-center text-danger">No Data Found</div>
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

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

<?php include_once'footer_dash.php'; ?>