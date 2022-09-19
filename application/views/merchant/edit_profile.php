<?php
	include_once'header_new.php';
	include_once'nav_new.php';
	include_once'sidebar_new.php';
?>
<!-- Start Page Content -->
	<div id="wrapper"> 
		<div class="page-wrapper edit-profile">
			<?php
				// if(isset($msg))
				//   echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$msg."</div> </div> </div> </div>";
				if($this->session->flashdata('success'))
					echo "<div class='row'> <div class='col-12'> <div class='card content-card'> <div class='card-title'> ".$this->session->flashdata('success')."</div> </div> </div> </div>";
			?>
			<?php
				echo form_open(base_url().'merchant/'.$loc, array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
				echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
			?>      
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
										Profile Image & Invoice color
									</div>
								</div>
								<div class="col">
									<div class="profile-updater">
										<div class="profile-icon-outer">
											<div class="profile-icon">
												<?php 
													if(isset($mypic) && $mypic!=''){
														?>
														<img src="<?php echo $upload_loc.'/'.$mypic ;?>" alt="user">
														<?php 
													}else{
														?>
														<img src="<?php echo base_url('new_assets/img/user.svg')?>" alt="user">
														<?php 
													}
												?>
											</div> 
											<!-- <span class="c-name">SaleQuick</span>
											<span>Lorem ipsum dolor sit amet</span> -->
										</div>
										
										<?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
											<div class="upload-btn btn">
											<span>Upload</span>
											<span class="material-icons">camera_alt</span>
											 </div>
											 <input type="file" name="mypic" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Editor Image:" id="saleQuickPfIcon" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">
										<?php } ?>
									</div>
								</div>
								<div class="col">
									<div class="invoice-color-wraper">
										<span>Select Invoice Color</span> 
										<div style="display: inline-block;vertical-align: middle;width: 101px;border: 1px solid #e9e9e9;border-radius: 4px">
											<input autocomplete="off"  id="styleInput" class="jscolor
											{valueElement:'valueInput', styleElement:'styleInput', borderColor:'#fff', insetColor:'#fff', backgroundColor:'rgb(255, 255, 255)',padding: 15,borderWidth:0,borderRadius:4,}"  value="" 
											style="display: block;width: 100%;outline: none;max-width: 100%;font-size: 1rem;line-height: 1.25;border: 4px solid #fff;height: 35px;background-color: rgb(255, 255, 255);caret-color: transparent;background-image: none;color: rgb(0, 0, 0);cursor: pointer;border-radius: 4px !important;max-width: 100%;border-radius: 4px !important,box-shadow:rgba(0, 0, 0, 0.2) 0px 0px 9px -3px;-webkit-box-shadow:rgba(0, 0, 0, 0.2) 0px 0px 9px -3px">
											<!-- <input type="hidden" id="valueInput" value="#2273dc" > -->
											<input type="hidden" name="color" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  id="valueInput" value="#<?php echo (isset($color) && !empty($color)) ? $color : set_value('color');?>" >
										</div>
									</div>
								</div>
								<!-- <div class="col-12">
									<div class="form-group">
										<button class="btn btn-first pull-right">Update</button>
									</div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							<div class="row">
								<div class="col  fixed-col">

								<?php //echo '$account_id_cnp '.$account_id_cnp.' acceptor_id_cnp '.$acceptor_id_cnp.' account_token_cnp'.$account_token_cnp.' application_id_cnp '.$application_id_cnp.' terminal_id'.$terminal_id;  ?> 
									<div class="change-pass">
										Name
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">User Name</label>
											<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="title" style="text-transform: lowercase;" id="title" readonly required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
										</div>
									</div>      
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">DBA Name</label>
											<input   type="text"  class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  readonly name="business_dba_name" id="business_dba_name"  required value="<?php echo (isset($business_dba_name) && !empty($business_dba_name)) ? $business_dba_name : set_value('business_dba_name');?>"  required>
										</div>
										<!-- <div class="form-group">
												<button class="btn btn-first pull-right">Update</button>
										</div> -->
									</div>      
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
						<div class="row">
							<div class="col  fixed-col">
									<div class="change-pass">
									Business Info
									</div>
								</div>
								<div class="col">
										<div class="custom-form">
											<div class="form-group">
												<label for="">Address 1</label>
												<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="address1" id="address1" value="<?php echo (isset($address1) && !empty($address1)) ? $address1 : set_value('address1');?>" >
											</div>
										</div>      
									</div>
									<div class="col">
										<div class="custom-form">
											<div class="form-group">
												<label for="">Address 2</label>
												<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="address2" id="address2"  value="<?php echo (isset($address2) && !empty($address2)) ? $address2 : set_value('address2');?>">
											</div>
										</div>      
									</div>

							</div>
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
									
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">City</label>
											<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="city" id="city"   value="<?php echo (isset($city) && !empty($city)) ? $city : set_value('city');?>">
										</div>
										<div class="form-group">
											<label for="">State</label>
											<select class="form-control" name="state" id="state" required <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> >
											<option value="">Select State</option>
											<option value="AL" <?php if($state=='AL') echo 'selected';  ?>>Alabama</option>
											<option value="AK" <?php if($state=='AK') echo 'selected';  ?>>Alaska</option>
											<option value="AZ" <?php if($state=='AZ') echo 'selected';  ?>>Arizona</option>
											<option value="AR" <?php if($state=='AR') echo 'selected';  ?>>Arkansas</option>
											<option value="CA" <?php if($state=='CA') echo 'selected';  ?>>California</option>
											<option value="CO" <?php if($state=='CO') echo 'selected';  ?>>Colorado</option>
											<option value="CT" <?php if($state=='CT') echo 'selected';  ?>>Connecticut</option>
											<option value="DE" <?php if($state=='DE') echo 'selected';  ?>>Delaware</option>
											<option value="DC" <?php if($state=='DC') echo 'selected';  ?>>District Of Columbia</option>
											<option value="FL" <?php if($state=='FL') echo 'selected';  ?>>Florida</option>
											<option value="GA" <?php if($state=='GA') echo 'selected';  ?>>Georgia</option>
											<option value="HI" <?php if($state=='HI') echo 'selected';  ?>>Hawaii</option>
											<option value="ID" <?php if($state=='ID') echo 'selected';  ?>>Idaho</option>
											<option value="IL" <?php if($state=='IL') echo 'selected';  ?>>Illinois</option>
											<option value="IN" <?php if($state=='IN') echo 'selected';  ?>>Indiana</option>
											<option value="IA" <?php if($state=='IA') echo 'selected';  ?>>Iowa</option>
											<option value="KS" <?php if($state=='KS') echo 'selected';  ?>>Kansas</option>
											<option value="KY" <?php if($state=='KY') echo 'selected';  ?>>Kentucky</option>
											<option value="LA" <?php if($state=='LA') echo 'selected';  ?>>Louisiana</option>
											<option value="ME" <?php if($state=='ME') echo 'selected';  ?>>Maine</option>
											<option value="MD" <?php if($state=='MD') echo 'selected';  ?>>Maryland</option>
											<option value="MA" <?php if($state=='MA') echo 'selected';  ?>>Massachusetts</option>
											<option value="MI" <?php if($state=='MI') echo 'selected';  ?>>Michigan</option>
											<option value="MN" <?php if($state=='MN') echo 'selected';  ?>>Minnesota</option>
											<option value="MS" <?php if($state=='MS') echo 'selected';  ?>>Mississippi</option>
											<option value="MO" <?php if($state=='MO') echo 'selected';  ?>>Missouri</option>
											<option value="MT" <?php if($state=='MT') echo 'selected';  ?>>Montana</option>
											<option value="NE" <?php if($state=='NE') echo 'selected';  ?>>Nebraska</option>
											<option value="NV" <?php if($state=='NV') echo 'selected';  ?>>Nevada</option>
											<option value="NH" <?php if($state=='NH') echo 'selected';  ?>>New Hampshire</option>
											<option value="NJ" <?php if($state=='NJ') echo 'selected';  ?>>New Jersey</option>
											<option value="NM" <?php if($state=='NM') echo 'selected';  ?>>New Mexico</option>
											<option value="NY" <?php if($state=='NY') echo 'selected';  ?>>New York</option>
											<option value="NC" <?php if($state=='NC') echo 'selected';  ?>>North Carolina</option>
											<option value="ND" <?php if($state=='ND') echo 'selected';  ?>>North Dakota</option>
											<option value="OH" <?php if($state=='OH') echo 'selected';  ?>>Ohio</option>
											<option value="OK" <?php if($state=='OK') echo 'selected';  ?>>Oklahoma</option>
											<option value="OR" <?php if($state=='OR') echo 'selected';  ?>>Oregon</option>
											<option value="PA" <?php if($state=='PA') echo 'selected';  ?>>Pennsylvania</option>
											<option value="RI" <?php if($state=='RI') echo 'selected';  ?>>Rhode Island</option>
											<option value="SC" <?php if($state=='SC') echo 'selected';  ?>>South Carolina</option>
											<option value="SD" <?php if($state=='SD') echo 'selected';  ?>>South Dakota</option>
											<option value="TN" <?php if($state=='TN') echo 'selected';  ?>>Tennessee</option>
											<option value="TX" <?php if($state=='TX') echo 'selected';  ?>>Texas</option>
											<option value="UT" <?php if($state=='UT') echo 'selected';  ?>>Utah</option>
											<option value="VT" <?php if($state=='VT') echo 'selected';  ?>>Vermont</option>
											<option value="VA" <?php if($state=='VA') echo 'selected';  ?>>Virginia</option>
											<option value="WA" <?php if($state=='WA') echo 'selected';  ?>>Washington</option>
											<option value="WV" <?php if($state=='WV') echo 'selected';  ?>>West Virginia</option>
											<option value="WY" <?php if($state=='WY') echo 'selected';  ?>>Wisconsin</option>
											<option value="WY" <?php if($state=='WY') echo 'selected';  ?>>Wyoming</option>
											</select>
											<!-- <input type="text" class="form-control" name="state" id="state"   value="<?php echo (isset($state) && !empty($state)) ? $state : set_value('state');?>"> -->
										</div>
									</div>      
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Zip Code</label>
											<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="zip" id="zip" maxlength="6" onKeyPress="return isNumberKey(event)"   value="<?php echo (isset($zip) && !empty($zip)) ? $zip : set_value('zip');?>">
											<input type="hidden" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="psw" id="psw" readonly required value="<?php echo (isset($psw) && !empty($psw)) ? $psw : set_value('psw');?>">
										</div>
										<div class="form-group">
											<label for="">Phone</label>
											<input class="form-control us-phone-no" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Phone" name="business_number" id="business_number"  maxlength="14" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :" value="<?php echo (isset($business_number) && !empty($business_number)) ? $business_number : set_value('business_number');?>" required type="text">
										</div>
									 
									</div>      
								</div>
								

								

							</div>

							
						</div>
					</div>
				</div> 
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
						<div class="row">
							<div class="col  fixed-col">
									<div class="change-pass">
										 Personal Info
									</div>
								</div>
								<div class="col">
										<div class="custom-form">
											<div class="form-group">
												<label for="">Address 1</label>
												<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="o_address1" id="o_address1"  value="<?php echo (isset($o_address1) && !empty($o_address1)) ? $o_address1 : set_value('o_address1');?>">
											</div>
										</div>      
									</div>
									<div class="col">
										<div class="custom-form">
											<div class="form-group">
												<label for="">Address 2</label>
												<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="o_address2" id="o_address2"  value="<?php echo (isset($o_address2) && !empty($o_address2)) ? $o_address2 : set_value('o_address2');?>">
											</div>
										</div>      
									</div>

							</div>
						<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
									 
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">City</label>
											<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="o_city" id="o_city"   value="<?php echo (isset($o_city) && !empty($o_city)) ? $o_city : set_value('o_city');?>">
										</div>
										<div class="form-group">
											<label for="">State</label>
											<select class="form-control" name="o_state" id="o_state" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> >
											<option value="">Select State</option>
											<option value="AL" <?php if($o_state=='AL') echo 'selected';  ?>>Alabama</option>
											<option value="AK" <?php if($o_state=='AK') echo 'selected';  ?>>Alaska</option>
											<option value="AZ" <?php if($o_state=='AZ') echo 'selected';  ?>>Arizona</option>
											<option value="AR" <?php if($o_state=='AR') echo 'selected';  ?>>Arkansas</option>
											<option value="CA" <?php if($o_state=='CA') echo 'selected';  ?>>California</option>
											<option value="CO" <?php if($o_state=='CO') echo 'selected';  ?>>Colorado</option>
											<option value="CT" <?php if($o_state=='CT') echo 'selected';  ?>>Connecticut</option>
											<option value="DE" <?php if($o_state=='DE') echo 'selected';  ?>>Delaware</option>
											<option value="DC" <?php if($o_state=='DC') echo 'selected';  ?>>District Of Columbia</option>
											<option value="FL" <?php if($o_state=='FL') echo 'selected';  ?>>Florida</option>
											<option value="GA" <?php if($o_state=='GA') echo 'selected';  ?>>Georgia</option>
											<option value="HI" <?php if($o_state=='HI') echo 'selected';  ?>>Hawaii</option>
											<option value="ID" <?php if($o_state=='ID') echo 'selected';  ?>>Idaho</option>
											<option value="IL" <?php if($o_state=='IL') echo 'selected';  ?>>Illinois</option>
											<option value="IN" <?php if($o_state=='IN') echo 'selected';  ?>>Indiana</option>
											<option value="IA" <?php if($o_state=='IA') echo 'selected';  ?>>Iowa</option>
											<option value="KS" <?php if($o_state=='KS') echo 'selected';  ?>>Kansas</option>
											<option value="KY" <?php if($o_state=='KY') echo 'selected';  ?>>Kentucky</option>
											<option value="LA" <?php if($o_state=='LA') echo 'selected';  ?>>Louisiana</option>
											<option value="ME" <?php if($o_state=='ME') echo 'selected';  ?>>Maine</option>
											<option value="MD" <?php if($o_state=='MD') echo 'selected';  ?>>Maryland</option>
											<option value="MA" <?php if($o_state=='MA') echo 'selected';  ?>>Massachusetts</option>
											<option value="MI" <?php if($o_state=='MI') echo 'selected';  ?>>Michigan</option>
											<option value="MN" <?php if($o_state=='MN') echo 'selected';  ?>>Minnesota</option>
											<option value="MS" <?php if($o_state=='MS') echo 'selected';  ?>>Mississippi</option>
											<option value="MO" <?php if($o_state=='MO') echo 'selected';  ?>>Missouri</option>
											<option value="MT" <?php if($o_state=='MT') echo 'selected';  ?>>Montana</option>
											<option value="NE" <?php if($o_state=='NE') echo 'selected';  ?>>Nebraska</option>
											<option value="NV" <?php if($o_state=='NV') echo 'selected';  ?>>Nevada</option>
											<option value="NH" <?php if($o_state=='NH') echo 'selected';  ?>>New Hampshire</option>
											<option value="NJ" <?php if($o_state=='NJ') echo 'selected';  ?>>New Jersey</option>
											<option value="NM" <?php if($o_state=='NM') echo 'selected';  ?>>New Mexico</option>
											<option value="NY" <?php if($o_state=='NY') echo 'selected';  ?>>New York</option>
											<option value="NC" <?php if($o_state=='NC') echo 'selected';  ?>>North Carolina</option>
											<option value="ND" <?php if($o_state=='ND') echo 'selected';  ?>>North Dakota</option>
											<option value="OH" <?php if($o_state=='OH') echo 'selected';  ?>>Ohio</option>
											<option value="OK" <?php if($o_state=='OK') echo 'selected';  ?>>Oklahoma</option>
											<option value="OR" <?php if($o_state=='OR') echo 'selected';  ?>>Oregon</option>
											<option value="PA" <?php if($o_state=='PA') echo 'selected';  ?>>Pennsylvania</option>
											<option value="RI" <?php if($o_state=='RI') echo 'selected';  ?>>Rhode Island</option>
											<option value="SC" <?php if($o_state=='SC') echo 'selected';  ?>>South Carolina</option>
											<option value="SD" <?php if($o_state=='SD') echo 'selected';  ?>>South Dakota</option>
											<option value="TN" <?php if($o_state=='TN') echo 'selected';  ?>>Tennessee</option>
											<option value="TX" <?php if($o_state=='TX') echo 'selected';  ?>>Texas</option>
											<option value="UT" <?php if($o_state=='UT') echo 'selected';  ?>>Utah</option>
											<option value="VT" <?php if($o_state=='VT') echo 'selected';  ?>>Vermont</option>
											<option value="VA" <?php if($o_state=='VA') echo 'selected';  ?>>Virginia</option>
											<option value="WA" <?php if($o_state=='WA') echo 'selected';  ?>>Washington</option>
											<option value="WV" <?php if($o_state=='WV') echo 'selected';  ?>>West Virginia</option>
											<option value="WY" <?php if($o_state=='WY') echo 'selected';  ?>>Wisconsin</option>
											<option value="WY" <?php if($o_state=='WY') echo 'selected';  ?>>Wyoming</option>
											</select>
											<!-- <input type="text" class="form-control" name="state" id="state"   value="<?php echo (isset($state) && !empty($state)) ? $state : set_value('state');?>"> -->
										</div>
									</div>      
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Zip Code</label>
											<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="o_zip" id="o_zip" maxlength="6" onKeyPress="return isNumberKey(event)"   value="<?php echo (isset($o_zip) && !empty($o_zip)) ? $o_zip : set_value('o_zip');?>">
										 
										</div>
										<div class="form-group">
											<label for="">Phone</label>
											<input class="form-control us-phone-no" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Phone" name="o_phone" id="o_phone"  maxlength="14" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :" value="<?php echo (isset($o_phone) && !empty($o_phone)) ? $o_phone : set_value('o_phone');?>"  type="text">
										</div>
									 
									</div>      
								</div>
							

								

							</div>

							
						</div>
					</div>
				</div> 
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
										Email Address
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Report Email Address</label>
											<?php //echo (isset($report_email) && !empty($report_email)) ? $report_email : set_value('report_email');?>
											<input type="text" id="multipleEmailOnly" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Enter Emails only" class="form-control" name="report_email"  value="<?php echo (isset($report_email) && !empty($report_email)) ? $report_email : set_value('report_email');?>" >
										</div>
									</div>      
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Email Report Type <!--<?php $arraytdata=explode(",",$report_type); print_r($arraytdata);  ?>--></label>
											<select id='reportEmailTypes' name="report_type[]" multiple data-placeholder="Select Report Type" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  >
													<option value="">Please Select</option>
													<?php 
													$arraytdata=explode(",",$report_type);
													if(isset($report_type) && !empty($report_type))
													{
													?>
														<option value="daily" <?php if(in_array('daily',$arraytdata)) echo "selected"; ?>>Daily</option>
														<option value="weekly" <?php if(in_array('weekly',$arraytdata)) echo "selected"; ?>>Weekly</option>
														<option value="monthly" <?php if(in_array('monthly',$arraytdata)) echo "selected"; ?>>Monthly</option>
													<?php }else {?>
														<option value="daily" >Daily</option>
														<option value="weekly" >Weekly</option>
														<option value="monthly" >Monthly</option>
													<?php } ?>
											</select>
										</div>
										<!-- <div class="form-group">
												<button class="btn btn-first pull-right">Update</button>
										</div> -->
									</div>      
								</div>
							</div>
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
										<!-- Email Address -->
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Invoice Notification Email Address</label>
											<?php //echo (isset($report_email) && !empty($report_email)) ? $report_email : set_value('report_email');?>
											<input type="text" id="multipleNotificationEmailOnly" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  placeholder="Enter  Notification Emails only" class="form-control" name="notification_email"  value="<?php echo (isset($notification_email) && !empty($notification_email)) ? $notification_email : set_value('notification_email');?>" >
										</div>
									</div>      
								</div>
								</div>

						</div>
					</div>
				</div> 
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
										Keys
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Auth Key</label>
											<input type="text" class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="auth_key" id="auth_key" readonly required value="<?php echo (isset($auth_key) && !empty($auth_key)) ? $auth_key : set_value('auth_key');?>">
										</div>
									</div>      
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Merchant Key</label>
											<input type="text" class="form-control" name="merchant_key" id="merchant_key" readonly required value="<?php echo (isset($merchant_key) && !empty($merchant_key)) ? $merchant_key : set_value('merchant_key');?>">
										</div>
										<!-- <div class="form-group">
												<button class="btn btn-first pull-right">Update</button>
										</div> -->
									</div>      
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
										Permission
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
									 
										<div class="form-group">
											<div class="custom-checkbox">
												<input type="checkbox" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="csv_Customer_name" <?php if($csv_Customer_name > 0 ) echo 'checked'; ?> id="nameoncsv" value="1">
												<label for="nameoncsv">Want to show name on receipt to show on csv</label>
											</div>
										</div>
										<?php if($is_token_system_permission > 0 ) { ?>
										<div class="form-group">
											<div class="custom-checkbox">
												<input type="checkbox" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  disabled name="is_tokenized" <?php if($is_tokenized > 0 ) echo 'checked';  ?> id="allowTokenized" value="1">
												<label for="allowTokenized">Want to allow the tokenized system</label>
											</div>
										</div>
										<?php } ?> 
										<?php //echo  $pak_id;  echo $signature_status;  
									 	if($signature_status > 0 ) { ?>
											<div class="form-group">
												<div class="custom-checkbox">
													<input type="checkbox"  <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> name="signature_status"  <?php if($signature_status =='1' ) echo 'checked';  ?> id="signature_status" >
													<label for="signature_status">Signature Permission</label>
												</div>
											</div>
										<?php }?>
										<div class="form-group">
											<div class="custom-checkbox">
												<input type="checkbox" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="late_fee_status"  <?php if($late_fee_status =='1' ) echo 'checked';  ?> id="late_fee_status" value="1">
												<label for="late_fee_status">Late Fee Status</label>
											</div>
										</div>
									</div>      
								</div>

								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Time Zone</label>
											<select class="form-control" name="time_zone" id="time_zone" required <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> >
												<option value="">--Select Time Zone--</option>
												<?php  $sessionTime_zone=$this->session->userdata("time_zone"); 
										 			foreach(timezone_identifiers_list() as $key => $zone) {  
										 				date_default_timezone_set($zone);
										 				$zones_array[$key]['zone'] = $zone;
												?> 
											 	<option value="<?php echo $zone; ?>"   class="<?php echo $time_zone; ?>" <?php if($time_zone==$zone  ||  $sessionTime_zone==$zone){ echo 'selected'; } ?>><?php echo $zone; ?></option>
												<?php  }  ?> 
											</select>
										</div>
										<div class="form-group row">
											<div class="col-6">
												<label for="">Late Fee</label>
												<input type="text" min="0" maxlength="5" class="form-control allownumericwithdecimal"  <?php if($this->session->userdata('employee_id')) { }?> name="late_fee" id="late_fee" disabled value="<?php echo (isset($late_fee) && !empty($late_fee)) ? $late_fee : set_value('late_fee');?>">
											</div>
											<div class="col-6">
												<label for="">Late Grace Period(In days)</label>
												<input type="text" min="0" maxlength="2" class="form-control allownumericwithoutdecimal" name="late_grace_period" id="late_grace_period" disabled value="<?php echo (isset($late_grace_period) && !empty($late_grace_period)) ? $late_grace_period : set_value('late_grace_period');?>">
											</div>
										</div>
									</div>      
								</div>

								<!-- <div class="col-12">
									<div class="custom-form" >
										<div class="form-group">
												<input type="submit" id="btn_login" name="mysubmit" value="Update" class="btn btn-first pull-right">
										</div>
									</div>      
								</div> -->
							</div>
						</div>
					</div>
				</div> 
			</div>
				
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
										Status
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<?php if(isset($register_type) && $register_type=='api'){ ?>
											<label for="">Api Status</label>
											<select class="form-control" name="api_type" id="api_type" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?> >
													<option value="sandbox" <?php if($api_type=='sandbox'){ echo 'selected'; } ?>>Sandbox</option>
													<option value="live" <?php if($api_type=='live'){ echo 'selected'; } ?>>Live</option>
											</select>
											<?php } ?>
										</div>
									</div>      
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Status</label>
											<input   type="text"  class="form-control" <?php if($this->session->userdata('employee_id')) {  echo 'disabled'; }?>  name="status" id="status" readonly required value="<?php echo (isset($status) && !empty($status)) ? $status : set_value('status');?>"  >
										</div>
										<!-- <div class="form-group">
												<button class="btn btn-first pull-right">Update</button>
										</div> -->
									</div>      
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>

			<?php if($this->session->userdata('merchant_user_type')=='merchant') { ?>
			<div class="row">
				<div class="col-12">
					<div class="card content-card">
						<div class="card-title">
							<div class="row">
								<div class="col  fixed-col">
									<div class="change-pass">
										Change Password
									</div>
								</div>
								<div class="col">
									<div class="custom-form">
										<div class="form-group">
											<label for="">Old Password</label>
											<input type="password" class="form-control" name="opsw" id="cpsw" value="" autocomplete="off"  >
										</div>
										<div class="form-group">
											<label for="">New Password</label>
											<input type="password" class="form-control"  autocomplete="off"  name="npsw" placeholder="New Password" >
										</div>
									</div>      
								</div>
								<div class="col">
									<div class="custom-form" style=" margin-top: 80px; ">
										<div class="form-group">
											<label for="">Confirm Password</label>
											<input type="password" class="form-control"  autocomplete="off" placeholder="Confirm Password"  name="cpsw" >
										</div>
										<div class="form-group">
												<input type="submit" id="btn_login" name="mysubmit" value="Update" class="btn btn-first pull-right">
										</div>
									</div>      
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>
			<?php } ?>
			<?php echo form_close(); ?> 
		</div>
	</div>
<!-- End Page Content -->
<?php
	include_once'footer_new.php';
?>
<script type="text/javascript">
	$(document).ready(function() {
		//Late Fee Validation
		$(".allownumericwithdecimal").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
     		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
           	$(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
		if($('#late_fee_status').is(':checked')){
    		$('#late_fee, #late_grace_period').prop('disabled',false);
            $('#late_fee, #late_grace_period').attr('required','required');
        }
	    $('#late_fee_status').click(function() {
	    	if($(this).is(':checked')){
	    		$('#late_fee, #late_grace_period').prop('disabled',false);
	            $('#late_fee, #late_grace_period').attr('required','required');
	    	} else {
	    		$('#late_fee, #late_grace_period').prop('disabled',true);
	            $('#late_fee, #late_grace_period').removeAttr('required');
	    	}
	    });

	});
</script>