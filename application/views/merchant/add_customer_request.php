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
		echo form_open('merchant/'.$loc, array('id' => "my_form",'class'=>"row"));
		echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
		$merchant_name = $this->session->userdata('merchant_name');
		$names = substr($merchant_name, 0, 3);
	  ?>  
	  <!-- <div class="row"> -->
		<div class="col-12">

		  <div class="card content-card">
			<div class="card-title">
			  Create Invoice For Straight
				<div class="float-right text-right custom-form recurring__topinvoice">
				  <div class="form-group m-0">
					<label for="" style="font-weight: 500;font-size: 12px;">Invoice No</label>
					<input class="form-control" name="invoice_no" id="invoice_no" pattern="[a-zA-Z\s]+"  
					value="INV<?php echo strtoupper($names) ?>000<?php echo  $getDashboardData[0]['TotalOrders']+1; ?>"  readonly required type="text">
				  </div>
				</div>
			</div>
			<div class="card-detail recurring__geninfo" >
			  <div class="row custom-form responsive-cols f-wrap f-auto">
				<div class="col mx-253">
				  <div class="form-group">
					<label for="">Customer Name</label>
					<input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+"  placeholder="Full Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required type="text">
				  </div>
				</div>
				<div class="col mx-253">
				  <div class="form-group">
					<label for="">Email Address</label>
					<input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email"
					  value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" type="email" >
				  </div>
				</div>
				<div class="col mx-253">
				  <div class="form-group">
					<label for="">Phone Number</label>
					  <input class="form-control" placeholder="Phone" name="mobile" id="phone" 
					  value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" type="text">
				  </div>
				</div>
				<div class="col mx-253">
				  <div class="form-group">
					<label for="">Reference Number</label>
					<input class="form-control" placeholder="Ex.P.O. Number" name="reverence" id="reverence"  placeholder="Reference"
					value="<?php echo (isset($reverence) && !empty($reverence)) ? $reverence : set_value('reverence');?>"  type="text">
				  </div>
				</div>
				<div class="col mx-253">
				  <div class="form-group">
					<label for="">Start Date</label>
					  <!-- <input type="text" name="recurring_pay_start_date"  class="form-control" autocomplete="off" required placeholder="Start date" id="autopayCradInfoStartDate"> -->
					 <input type="text" name="recurring_pay_start_date"  class="form-control" autocomplete="off" required placeholder="Start date" id="autopayCradInfoStartDate">
				  </div>
				</div>
			  </div>
			</div>
		  </div>

		</div>
		<div class="col-12">
		  <div class="card content-card mb-10">
			<!-- <div class="card-title">
			 Payment Detail
			</div> -->
			<div class="card-detail">
			  <div class="row custom-form responsive-cols">
				<div class="col mx-301">
				  <div class="form-group">
					<label for="">Payment Interval</label>
					<select class="form-control" name="recurring_type"  required>                      
					  <option value="">Select Type</option>
					  <option value="daily">Daily</option>
					  <option value="weekly">Weekly</option>
					  <option value="biweekly">Bi Weekly</option>
					  <option value="monthly">Monthly</option>
					  <option value="quarterly">Quarterly</option>
					  <option value="yearly">Yearly</option>
					</select>
				  </div>
				</div>
				<div class="col minx-351">
				  <div class="form-group " id="payment_dur_wrapper">
					<label for="" style="display: block">Payments Duration</label>
					<div class="custom-checkbox" style="display: inline-block;padding-right: 21px;vertical-align: middle;">
					  <input type="radio" class="radio-circle" id="pd__constant" name="pd__constant">
					  <label for="pd__constant" class="inline-block" >Constant</label>
					</div>
					  OR
					<input type="radio" id="pd__var" name="pd__constant" style="display: none;">
					<input type='text' style="width: auto;display: inline-block;vertical-align: middle;margin-left: 15px;" class='form-control' name='recurring_count' id='recurring_count'  required  maxlength="3" placeholder="Enter 1 to 200 " onKeyPress="return isNumberKey(event)">            
				  </div>
				</div>
			  <!-- </div>
			  <div class="row custom-form"> -->
				<div class="col-12">
				  <div class="form-group recurring__paytpye">
					<label for="" style="display: block">Payment Type</label>

					<div class="custom-checkbox">
					  <input type="radio" id="pt__Auto" class="radio-circle" value="1" name="paytype" checked>
					  <label for="pt__Auto" class="inline-block" >Auto</label>
					</div>
					<div class="custom-checkbox">
					  <input type="radio" id="pt__Manual" class="radio-circle" value="0" name="paytype">
					  <label for="pt__Manual" class="inline-block" >Manual</label>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- <div class="row  custom-form responsive-cols">
				<div class="col-12">
				  <div  class="card_info_inner" id="autoType" style="display: block; border-top: 1px solid rgb(225, 230, 234); padding-top: 15px;">
					<div class="row custom-form   responsive-cols">
					  <div class="col mx-301">
						<div class="form-group">
						  <label for="nameoncard">Name on card</label>
						  <input class="form-control" name="nameoncard" id="nameoncard"  placeholder="Name on card"  required type="text">
						</div>
					  </div>
					  <div class="col mx-301">
						<div class="form-group">
						  <label for="">Card Number</label>
						  <input class="form-control" name="card_no" id="card_no"  placeholder="Card Number:" 
						  required  type="text" minlength="14" maxlength="16"  onKeyPress="return isNumberKey(event)">
						</div>
					  </div>
					  <div class="col mx-240">
						<div class="form-group">
						  <label for="" style="width: 100%;float: left;">Expiry Month/Year</label>
						  <select style="width: calc(50% - 5px);float: left;margin-right: 10px;" class="form-control" required   name="exp_month" id="exp_month" >
							<option value="">Month</option>
							<option value="01">Jan (01)</option>
							<option value="02">Feb (02)</option>
							<option value="03">Mar (03)</option>
							<option value="04">Apr (04)</option>
							<option value="05">May (05)</option>
							<option value="06">June (06)</option>
							<option value="07">July (07)</option>
							<option value="08">Aug (08)</option>
							<option value="09">Sep (09)</option>
							<option value="10">Oct (10)</option>
							<option value="11">Nov (11)</option>
							<option value="12">Dec (12)</option>
						  </select>
						  <select style="width: calc(50% - 5px);float: left;" class="form-control"   name="exp_year" required="" >
							<option value="">Year</option>
							<option value="19">2019</option>
							<option value="20">2020</option>
							<option value="21">2021</option>
							<option value="22">2022</option>
							<option value="23">2023</option>
							<option value="24">2024</option>
							<option value="25">2025</option>
							<option value="26">2026</option>
							<option value="27">2027</option>
							<option value="28">2028</option>
							<option value="29">2029</option>
							<option value="30">2030</option>
						  </select>
						</div>
					  </div>
					  <div class="col mx-121">
						<div class="form-group">
						  <label for="">CVC Code</label>
						  <input type='txet'  class="form-control Cvv"  placeholder="" name="card_validation_num" value="" onKeyPress="return isNumberKey(event)" minlength="3" maxlength="4" required>
						</div>
					  </div>
					</div>
					<div class="row custom-form responsive-cols">
					  <div class="col minx-351 mx-501">
						<div class="form-group">
						  <label for="">Address</label>
						  <input class="form-control" name="address" id="invoice_no" placeholder="Address"  required type="text">
						</div>
					  </div>
					  <div class="col mx-301">
						<div class="form-group">
						  <label for="">State</label>
						  <select class="form-control"  name="country" required>
							<option value="">Select State</option>
							<option value="Alabama">Alabama</option>
							<option value="Alaska">Alaska</option>
							<option value="Arizona">Arizona</option>
							<option value="Arkansas">Arkansas</option>
							<option value="California">California</option>
							<option value="Colorado">Colorado</option>
							<option value="Connecticut">Connecticut</option>
							<option value="Delaware">Delaware</option>
							<option value="District of Columbia">District of Columbia</option>
							<option value="Florida">Florida</option>
							<option value="Georgia">Georgia</option>
							<option value="Guam">Guam</option>
							<option value="Hawaii">Hawaii</option>
							<option value="Idaho">Idaho</option>
							<option value="Illinois">Illinois</option>
							<option value="Indiana">Indiana</option>
							<option value="Iowa">Iowa</option>
							<option value="Kansas">Kansas</option>
							<option value="Kentucky">Kentucky</option>
							<option value="Louisiana">Louisiana</option>
							<option value="Maine">Maine</option>
							<option value="Maryland">Maryland</option>
							<option value="Massachusetts">Massachusetts</option>
							<option value="Michigan">Michigan</option>
							<option value="Minnesota">Minnesota</option>
							<option value="Mississippi">Mississippi</option>
							<option value="Missouri">Missouri</option>
							<option value="Montana">Montana</option>
							<option value="Nebraska">Nebraska</option>
							<option value="Nevada">Nevada</option>
							<option value="New Hampshire">New Hampshire</option>
							<option value="New Jersey">New Jersey</option>
							<option value="New Mexico">New Mexico</option>
							<option value="New York">New York</option>
							<option value="North Carolina">North Carolina</option>
							<option value="North Dakota">North Dakota</option>
							<option value="Northern Marianas Islands">Northern Marianas Islands</option>
							<option value="Ohio">Ohio</option>
							<option value="Oklahoma">Oklahoma</option>
							<option value="Oregon">Oregon</option>
							<option value="Pennsylvania">Pennsylvania</option>
							<option value="Puerto Rico">Puerto Rico</option>
							<option value="Rhode Island">Rhode Island</option>
							<option value="South Carolina">South Carolina</option>
							<option value="South Dakota">South Dakota</option>
							<option value="Tennessee">Tennessee</option>
							<option value="Texas">Texas</option>
							<option value="Utah">Utah</option>
							<option value="Vermont">Vermont</option>
							<option value="Virginia">Virginia</option>
							<option value="Virgin Islands">Virgin Islands</option>
							<option value="Washington">Washington</option>
							<option value="West Virginia">West Virginia</option>
							<option value="Wisconsin">Wisconsin</option>
							<option value="Wyoming">Wyoming</option>
						  </select>
						</div>
					  </div>
					  <div class="col mx-301">
						<div class="form-group">
						  <label for="">City</label>
						  <input class="form-control" name="city" id="city"  placeholder="City"  required type="text">
						</div>
					  </div>
					  <div class="col mx-301">
						<div class="form-group">
						  <label for="">Zip code</label>
						  <input class="form-control" placeholder="Zip Code" name="zip" id="zip"  required type="text">
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div> -->
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
				  <div class="row custom-form reset-col-p">
					<div class="col">
					  <div class="form-group">
						<label for="">Item Name</label>
					  </div>
					  <div class="form-group">
						<input class="form-control item_name" name="Item_Name[]" placeholder="Item name" type="text" required="">
					  </div>
					</div>
					<div class="col">
					  <div class="form-group">
						<label for="">Quantity</label>
					  </div>
					  <div class="form-group">
						<input class="form-control item_qty" placeholder="Quantity" name="Quantity[]" id="quantity_1" type="text" onKeyPress="return isNumberKey(event)" required value="1">
					  </div>
					</div>
					<div class="col">
					  <div class="form-group">
						<label for="">Price ($)</label>
					  </div>
					  <div class="form-group">
						<div class="input-group ">
						  <div class="input-group-addon">
							<span class="input-group-text">$</span>
						  </div>
						  <input class="form-control item_price"  id="price_1"  name="Price[]" placeholder="Price" type="text" autocomplete="off"  required  onKeyPress="return isNumberKeydc(event)" value="">
						</div>
					  </div>
					</div>
					<div class="col">
					  <div class="form-group">
						<label for="">Tax</label>
					  </div>
					  <div class="form-group">
						<?php
						  $merchant_id = $this->session->userdata('merchant_id');
						  $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id,'status' => 'active')); 
						?>
						<select name="Tax[]" class="form-control sel_item_tax tax" id="tax_1" >
						  <option rel="0" value="0" >No Tax</option>
						  <?php foreach ($data as $view) { ?>
							<option rel="<?php echo $view['percentage']; ?>" value="<?php echo $view['id']; ?>"><?php echo $view['title']; ?>&nbsp;(<?php echo $view['percentage']; ?>%)</option>
						  <?php } ?>
						</select>
						<input type="hidden" class="form-control price item_tax" id="tax_amount_1" placeholder="Tax Amount"  name="Tax_Amount[]" value="0">
						<input type="hidden" class="form-control hide_tax" id="tax_per_1" name="Tax_Per[]" value="0">
					  </div>
					</div>
					<div class="col">
					  <div class="form-group">
						<label for="">Total ($)</label>
					  </div>
					  <div class="form-group">
						<div class="input-group ">
						  <div class="input-group-addon">
							<span class="input-group-text">$</span>
						  </div>
						  <input class="form-control sub_total" placeholder="Total" name="Total_Amount[]" id="total_amount_1" readonly type="text">
						</div>
					  </div>
					</div>
				  </div>
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
				  <label for="">Sub Total</label>
				  <div class="input-group ">
					<div class="input-group-addon">
					  <span class="input-group-text">$</span>
					</div>
					<input class="form-control " placeholder="0.00" name="sub_amount" id="sub_amount" type="text" readonly>
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
					<input class="form-control total_tax" name="total_tax" id="total_tax" placeholder="0.00" type="text" readonly>
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
					<input class="amount form-control" name="amount" placeholder="0.00" id="amount"  type="text" readonly >
				  </div>
				</div>
			  </div>
			  <div class="row custom-form inv-custom-btns">
				<div class="col form-inline">
				  <button type="reset" class="btn btn-second">Clear All</button>
				  <button type="submit" name="submit" id="send_request" class="btn btn-first">Send Request</button>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  <!-- </div> -->
	  <?php echo form_close(); ?>
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
		if($('#autopayCradInfoStartDate').length){
			$("#autopayCradInfoStartDate").val(moment().format("YYYY-MM-DD"));
			$('#autopayCradInfoStartDate').daterangepicker({
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

