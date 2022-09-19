<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgi4r_8NVve2Nt9dqc7x8oO26Pzbbzb-8&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

<style>
    .card {
        border: none !important;
    }
    .card.content-card {
        margin-bottom: 0px !important;
    }
    label {
        font-weight: 600;
    }
    .btn.btn-xs {
        padding: 7px 10px !important;
    }
    .modal-body {
        color: black !important;
        font-size: 15px !important;
        font-family: AvenirNext-Medium !important;
        padding: 25px !important;
        text-align: justify !important;
    }
    .modal-header {
        border-bottom: 1px solid #fff !important;
    }
    div.dt-buttons {
        display: none !important;
    }

    /* table style begin */
    .dataTables_wrapper .dataTables_filter input {
        width: 250px !important;
        height: 42px !important;
        color: #4a4a4a;
        -webkit-box-shadow: 0 0;
        box-shadow: 0 0;
        padding-right: 35px;
        padding-left: 15px;
        border-color: transparent !important;
        font-weight: normal;
        border-radius: 3px;
        background-repeat: no-repeat;
        background-size: 15px;
        background-position: right 15px center;
        border: none;
        border-radius: 5px;
    }
    .dataTables_length label {
        display: block !important;
        color: #3A3C3F !important;
        font-size: 16px !important;
        font-weight: 500 !important;
    }
    .dataTables_wrapper table {
        border-spacing: 0 10px !important;
    }
    table.dataTable tbody tr {
        height: 50px !important;
    }
    table.dataTable tbody tr:hover {
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }
    .dataTables_wrapper table thead tr {
        background-color: transparent !important;
    }
    .dataTables_wrapper table tbody tr {
        background-color: #fff !important;
    }
    .table-hover>tbody>tr:hover>td {
        background-color: #fff !important;
    }
    .table-hover>tbody>tr:hover>td.sorting_1 {
        background-color: #fff !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected td,
    .reset-dataTable table.dataTable tbody tr.odd.selected td {
        background-color: rgba(0, 166, 255, 0.2) !important;
    }
    .reset-dataTable table.dataTable tbody tr.even.selected td.sorting_1,
    .reset-dataTable table.dataTable tbody tr.odd.selected td.sorting_1 {
        background-color: rgba(0, 166, 255, 0.2) !important;
    }
    .reset-dataTable table.dataTable tbody tr:hover.even.selected td,
    .reset-dataTable table.dataTable tbody tr:hover.odd.selected td {
        background-color: rgba(0, 166, 255, 0.3) !important;
    }
    .reset-dataTable table.dataTable tbody tr:hover.even.selected td.sorting_1,
    .reset-dataTable table.dataTable tbody tr:hover.odd.selected td.sorting_1 {
        background-color: rgba(0, 166, 255, 0.3) !important;
    }
    /* table style end */

    /* checkbox style begin */
    .custom_checkbox, .custom_checkbox_th {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .custom_checkbox input, .custom_checkbox_th input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #fff;
        border-radius: 50%;
        border: 1px solid rgba(34, 115, 220, 0.8);
    }
    .checkmark.indeterminate {
        background-color: red;
    }
    .custom_checkbox:hover input ~ .checkmark {
        background-color: rgba(34, 115, 220, 0.9);
    }
    .custom_checkbox input:checked ~ .checkmark, .custom_checkbox_th input:checked ~ .checkmark {
        background-color: rgba(34, 115, 220, 0.9);
    }
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    .custom_checkbox input:checked ~ .checkmark:after, .custom_checkbox_th input:checked ~ .checkmark:after {
        display: block;
    }
    .custom_checkbox .checkmark:after, .custom_checkbox_th .checkmark:after {
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    input[name="select_all"] {
        width: 20px;
        height: 20px;
        outline: 0.5px solid blue;
        vertical-align: middle;
    }
    .m_check {
        width: 18px;
        height: 18px;
        vertical-align: middle;
    }
    /* checkbox style end */
    
    /* Address input style begin */
    #map {
        height: 100%;
    }
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #locationField, #controls {
        position: relative;
        width: 100%;
    }
    #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
    }
    .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
        font-family: "Roboto", Arial, Helvetica, sans-serif;
    }
    #address {
        border: 1px solid #000090;
        background-color: #f0f9ff;
        width: 480px;
        padding-right: 2px;
    }
    #address td {
        font-size: 10pt;
    }
    .field {
        width: 99%;
    }
    .slimField {
        width: 80px;
    }
    .wideField {
        width: 200px;
    }
    #locationField {
        height: 40px;
    }
    /* Address input style end */
    .page-content-wrapper {
        background: rgb(243,243,243) !important;
    }
    .form-title {
        color: #3A3C3F !important;
        font-weight: 600 !important;
        font-family: Nunito-Regular !important;
        background-color: transparent !important;
        padding: 0 !important;
        font-size: 24px !important;
    }
    label {
        color: #3A3C3F !important;
        font-weight: 600 !important;
        font-family: Nunito-Regular !important;
        margin-bottom: 5px !important;
        font-size: 12px !important;
    }
    input.form-control {
        font-family: Nunito-Regular !important;
        color: #424D59 !important;
        border: none !important;
        background-color: rgb(243,243,243) !important;
        border-radius: 10px !important;
    }
    input.form-control::placeholder {
        font-family: Nunito-Regular !important;
    }
    .h3_list_section {
        color: #3A3C3F !important;
        font-weight: 600 !important;
        font-family: Nunito-Regular !important;
        font-size: 20px !important;
    }
    .dataTables_wrapper .dataTables_filter input, div.dataTables_wrapper div.dataTables_length select {
        background-color: #fff !important;
        color: #3A3C3F !important;
        font-size: 16px !important;
        font-family: Nunito-Regular !important;
    }
    .dataTables_wrapper .dataTables_filter input::placeholder {
        color: #3A3C3F !important;
    }
    /*.reset-dataTable table.dataTable thead tr th {*/
    table.dataTable thead tr th {
        color: #3A3C3F !important;
        font-size: 16px !important;
        font-family: Nunito-Regular !important;
    }
    .table:not(.table-dark) tbody tr td, table:not(.table-dark) tbody tr td {
        color: #4a4a4a !important;
        font-size: 14px !important;
        font-family: Nunito-Regular !important;
    }
    /*.list_status {
    }*/
    span.list_status  {
        background: rgb(235,245,237);
        padding: 5px 15px;
        font-size: 14px !important;
        font-family: Nunito-Regular !important;
        display: initial !important;
        font-weight: 600;
        border-radius: 20px;
    }
    div.dataTables_wrapper div.dataTables_info {
        background-color: #fff;
        padding: 5px 15px;
        border-radius: 10px;
        font-size: 15px !important;
        font-family: Nunito-Regular !important;
        margin-top: 10px;
        color: #3A3C3F !important;
        font-weight: 600;
    }
    .pagination {
        background-color: #fff !important;
        border-radius: 10px !important;
    }
    .page-link {
        font-size: 15px !important;
        font-family: Nunito-Regular !important;
        color: #3A3C3F !important;
        font-weight: 600;
        background-color: rgb(243,243,243) !important;
        border-color: transparent !important;
    }
    .page-item.active .page-link, .page-link:focus, .page-link:hover {
        color: #007bff !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 0 !important;
        margin-left: 0px !important;
        border: none !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        padding: 5px 10px !important;
    }
    .page-item.previous .page-link, .page-item.next .page-link {
        font-weight: 100 !important;
        color: #007bff !important;
        border-radius: 8px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: transparent !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    .btn-first {
        border-radius: 8px !important;
        font-family: Nunito-Regular !important;
        font-size: 20px;
        padding: 5px 21px !important;
    }
</style>

<script>
    // This sample uses the Autocomplete widget to help the user select a
    // place, then it retrieves the address components associated with that
    // place, and then it populates the form fields with those details.
    // This sample requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script
    // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    let placeSearch;
    let autocomplete;
    const componentForm = {
      street_number: "short_name",
      route: "long_name",
      locality: "long_name",
      administrative_area_level_1: "short_name",
      country: "long_name",
      postal_code: "short_name",
    };
    
    function initAutocomplete() {
      // Create the autocomplete object, restricting the search predictions to
      // geographical location types.
      autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("autocomplete"),
        { types: ["geocode"] }
      );
      // Avoid paying for data that you don't need by restricting the set of
      // place fields that are returned to just the address components.
      autocomplete.setFields(["address_component"]);
      // When the user selects an address from the drop-down, populate the
      // address fields in the form.
      autocomplete.addListener("place_changed", fillInAddress);
    }
    
    function fillInAddress() {
      // Get the place details from the autocomplete object.
      const place = autocomplete.getPlace();
    
      for (const component in componentForm) {
        document.getElementById(component).value = "";
        document.getElementById(component).disabled = false;
      }
    
      // Get each component of the address from the place details,
      // and then fill-in the corresponding field on the form.
      for (const component of place.address_components) {
        const addressType = component.types[0];
    
        if (componentForm[addressType]) {
          const val = component[componentForm[addressType]];
          document.getElementById(addressType).value = val;
        }
      }
    }
    
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          const geolocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          const circle = new google.maps.Circle({
            center: geolocation,
            radius: position.coords.accuracy,
          });
          autocomplete.setBounds(circle.getBounds());
        });
      }
    }
</script>

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

            <form action="#" id='my_form' method="post" enctype='multipart/form-data' autocomplete="off">
                <?php 
                echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                if(isset($view_menu_permissions) && $view_menu_permissions!="") {
                    $view_menu_permissions_Array=explode(',',$view_menu_permissions); 
                } else {
                    $view_menu_permissions_Array=array();
                } ?>
                <div class="row" style="margin-bottom: 10px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-title"><?php echo ($meta)?></div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" pattern="[a-zA-Z\s]+" autocomplete="off" class="form-control" name="name" id="name" placeholder="First Name" required value="<?php echo (isset($name) && !empty($name)) ? $name :'';?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" pattern="[a-zA-Z\s]+" autocomplete="off" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required value="<?php echo (isset($last_name) && !empty($last_name)) ? $last_name :'';?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile No <i class="text-danger">*</i> </label>
                                            <input class="form-control us-phone-no" placeholder="Mobile No" name="mobile" id="mobile" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required type="text" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Email <i class="text-danger">*</i></label>
                                            <input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" value="<?php echo (isset($email) && !empty($email)) ? $email : '';?>" required type="text" <?php echo (($loc=='edit_agent') ? 'disabled' : ''); ?> autocomplete="off">
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Address </label>
                                            <input class="form-control" placeholder="Address" name="address" id="address" value="<?php echo (isset($address) && !empty($address)) ? $address : set_value('address');?>" type="text" autocomplete="off">
                                        </div> -->
                                        <div class="form-group">
                                            <label>Address</label>
                                            <div id="locationField">
                                                <input
                                                    id="autocomplete"
                                                    placeholder="Enter your address"
                                                    onFocus="geolocate()"
                                                    type="text" autocomplete="off"  class="form-control" name="address" id="address"  required value="<?php echo (isset($address) && !empty($address)) ? $address : '';?>"
                                                    />
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 1rem !important;">
                                            <div class="col-6">
                                                <label>City </label>
                                                <input class="form-control" placeholder="City" name="city" id="city" value="<?php echo (isset($city) && !empty($city)) ? $city : set_value('city');?>" type="text" autocomplete="off">
                                            </div>
                                            <div class="col-6">
                                                <label>State </label>
                                                <input class="form-control" placeholder="State" name="state" id="state" value="<?php echo (isset($state) && !empty($state)) ? $state : set_value('state');?>" type="text" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Zipcode </label>
                                            <input class="form-control" placeholder="Zipcode" name="zip_code" id="zip_code" value="<?php echo (isset($zip_code) && !empty($zip_code)) ? $zip_code : set_value('zip_code');?>" type="text" maxlength="6" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Social Security Number</label>
                                                    <input type="text" autocomplete="off" class="form-control us-tin-no" placeholder="Social Security Number" id="ssn" required maxlength="11" value="<?php echo (isset($ssn) && !empty($ssn)) ? $ssn : ''; ?>">
                                                    <input type="hidden" name="ssn" id="ssn_digits" value="<?php echo (isset($ssn) && !empty($ssn)) ? $ssn : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>EIN No.</label>
                                                    <input type="text" autocomplete="off" class="form-control" name="ein_no" placeholder="EIN No" id="ein_no"  required value="<?php echo (isset($ein_no) && !empty($ein_no)) ? $ein_no : '';?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Sign Up Bonus <i class="text-danger">*</i> </label>
                                                    <input class="form-control" placeholder="Sign Up Bonus" name="total_commission" id="total_commission" value="<?php echo (isset($total_commission) && !empty($total_commission)) ? $total_commission : set_value('total_commission');?>" required type="text" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Profit Share <i class="text-danger">*</i> </label>
                                                    <input class="form-control" placeholder="Profit Share" name="commission_p_merchant" id="commission_p_merchant" value="<?php echo (isset($commission_p_merchant) && !empty($commission_p_merchant)) ? $commission_p_merchant : set_value('commission_p_merchant');?>" required type="text" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Gateway Fee (Per Merchant) <i class="text-danger">*</i> </label>
                                            <input class="form-control" placeholder="Gateway Fee (Per Merchant)" name="commission_p_transaction" id="commission_p_transaction" value="<?php echo (isset($commission_p_transaction) && !empty($commission_p_transaction)) ? $commission_p_transaction : set_value('commission_p_transaction');?>" required type="text" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Buy Rate (Per Transaction) <i class="text-danger">*</i> </label>
                                            <input class="form-control" placeholder="Buy Rate (Per Transaction)" name="buy_rent" id="buy_rent" value="<?php echo (isset($buy_rent) && !empty($buy_rent)) ? $buy_rent : '';?>" required type="text" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Buy Rate Volume (in %) <i class="text-danger">*</i> </label>
                                            <input class="form-control" placeholder="Buy Rate Volume" name="buyrate_volume" id="buyrate_volume" value="<?php echo (isset($buyrate_volume) && !empty($buyrate_volume)) ? $buyrate_volume : '';?>" required type="text" autocomplete="off">
                                        </div>
                                        <?php if($loc=='edit_agent') { ?>
                                            <div class="form-group">
                                                <label style="height: 20px !important;"></label>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="reset_password" value="0" id="reset_password" style="width: 17px !important; height: 17px !important;">
                                                    <label for="reset_password">Reset Password for this Agent?</label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <?php if($loc=='edit_agent') { ?>
                    <div class="row" style="margin-bottom: 20px !important;">
                        <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title"><?php echo (($loc=='edit_agent') ? 'Change Password' : 'Password'); ?></div>
                                        </div>
                                    </div>

                                    <?php if($loc=='edit_agent') { ?>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Old Password</label>
                                                    <input type="password" class="form-control" autocomplete="off" name="password" id="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" class="form-control" autocomplete="off" name="npsw" id="npsw" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" autocomplete="off" name="cpsw" id="cpsw" placeholder="Password">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } elseif($loc=='create_new_agent') { ?>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" autocomplete="off" name="password" id="password" placeholder="Password" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" autocomplete="off" name="cpsw" id="cpsw" placeholder="Password" required>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?> -->

                <div class="col-12" style="display:none;">
                    <div class="card content-card">
                        <div class="card-detail">
                            <div class="row custom-form responsive-cols f-wrap f-auto">
                                <div class="col-12">
                                    <div class="custom-form">
                                        <div class="form-group">
                                            <p><b>Merchant Permission</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mx-253">
                                    <div class="form-group">
                                        <?php if($loc=='edit_agent')  {?> 
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="edit_permissions" value="1" id="edit_permissions1" <?php if(1 == $edit_permissions){ echo 'checked="checked"'; } ?>>
                                                <label for="edit_permissions1">Edit Permissions</label>
                                            </div>
                                            <input type="hidden" name="view_permissions" value="1" <?php if(1 == $view_permissions){ echo 'checked="checked"'; } ?> >
                                        <?php } elseif($loc=='create_new_agent')  {?> 
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="edit_permissions" value="1" id="edit_permissions2" >
                                                <label for="edit_permissions2">Edit Permissions</label>
                                            </div>
                                            <input type="hidden" name="view_permissions" value="1">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col mx-253">
                                  <div class="form-group">
                                  <?php if($loc=='edit_agent')  { ?> 
                                    <div class="custom-checkbox">
                                      <input type="checkbox" name="active_permissions" value="1" id="active_permissions1" <?php if(1 == $active_permissions){ echo 'checked="checked"'; } ?>>
                                      <label for="active_permissions1">Active Permissions</label>
                                    </div>
                                  <?php } elseif($loc=='create_new_agent')  {?> 
                                    <div class="custom-checkbox">
                                      <input type="checkbox" name="active_permissions" value="1" id="active_permissions2" >
                                      <label for="active_permissions2">Active Permissions</label>
                                    </div>
                                  <?php } ?>
                                  </div>
                                </div>
                                <div class="col mx-253">
                                  <div class="form-group">
                                  <?php if($loc=='edit_agent')  {?> 
                                   <div class="custom-checkbox">
                                    <input type="checkbox" name="delete_permissions" value="1" id="delete_permissions1" <?php if(1 == $delete_permissions){ echo 'checked="checked"'; } ?>>
                                    <label for="delete_permissions1">Delete Permissions</label>
                                  </div>
                                  <?php } elseif($loc=='create_new_agent')  {?> 
                                    <div class="custom-checkbox">
                                      <input type="checkbox" name="delete_permissions" value="1" id="delete_permissions2" >
                                      <label for="delete_permissions2">Delete Permissions</label>
                                    </div>
                                  <?php } ?>
                                  </div>
                                </div>
                                <!-- <div class="col mx-253">
                                  <div class="form-group">
                                    <div class="custom-checkbox">
                                      <input type="radio" id='activestatus' <?php if( isset($status)  && $status=='active'){ echo 'checked'; } ?>  value="active" name="status" class="radio-circle"> 
                                      <label for="activestatus">Active</label>
                                      &nbsp;&nbsp;
                                      <input type="radio" id='blockstatus'  <?php if( isset($status)  && $status=='block'){ echo 'checked'; } ?>  value="block" name="status"  class="radio-circle"> 
                                      <label for="blockstatus">Block</label>
                                    </div>
                                  </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12" style="border-top: 2px solid rgba(0,0,0,.1)">
                  <div class="card content-card">
                      <div class="card-detail custom-form" style="display:none;">
                        <div class="row">
                          <div class="col-12">
                            <div class="custom-form">
                              <div class="form-group">
                                <p><b>Menu Permission</b></p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="display:none;">
                          <div class="col-12">
                            <p> <label><b>Dashboard</b> </label></p>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="Dashboard" <?php if ( isset($view_menu_permissions) && in_array("1a", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="Dashboard" value="1a" checked>
                                <label for="Dashboard">Dashboard</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="TransactionSummary" <?php if ( isset($view_menu_permissions) && in_array("1b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TransactionSummary" value="1b" checked>
                                <label for="TransactionSummary">Transaction Summary</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="SalesTrends" <?php if ( isset($view_menu_permissions) && in_array("1c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="SalesTrends" value="1c" checked>
                                <label for="SalesTrends">Sales Trends </label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="Funding" <?php if ( isset($view_menu_permissions) && in_array("1d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Funding" value="1d" checked>
                                <label for="Funding">Funding</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="display:none;">
                          <div class="col-12">
                             <p><label><b>Transaction</b> </label></p>
                          </div>
                          <div class="col mx-253">
                             <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="TInstoreMobile" <?php if ( isset($view_menu_permissions) && in_array("2a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInstoreMobile" value="2a" checked>
                                <label for="TInstoreMobile">Instore &amp; Mobile</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="TInvoice" <?php if ( isset($view_menu_permissions) && in_array("2b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TInvoice" value="2b" checked>
                                <label for="TInvoice">Invoicing</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="TRecurring" <?php if ( isset($view_menu_permissions) && in_array("2c", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="TRecurring" value="2c" checked>
                                <label for="TRecurring">Recurring</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="TRecurringRequest"  <?php if ( isset($view_menu_permissions) && in_array("2d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="TRecurringRequest" value="2d" checked>
                                <label for="TRecurringRequest">Recurring Request</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="display:none;">
                          <div class="col-12">
                            <p><label><b>Email template</b> </label></p>
                          </div>
                          <div class="col mx-253">
                             <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="InvoiceTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="InvoiceTemplate" value="3a">
                                <label for="InvoiceTemplate">Invoice Template</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="Instore_MobileTemplate" <?php if ( isset($view_menu_permissions) && in_array("3b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Instore_MobileTemplate" value="3b">
                                <label for="Instore_MobileTemplate">Instore &  Mobile </label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="ReceiptTemplate" <?php if ( isset($view_menu_permissions) && in_array("3c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ReceiptTemplate" value="3c">
                                <label for="ReceiptTemplate">Receipt</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="RecurringTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3d", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RecurringTemplate" value="3d">
                                <label for="RecurringTemplate">Recurring </label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="RegistrationTemplate"  <?php if ( isset($view_menu_permissions) && in_array("3e", $view_menu_permissions_Array)) { echo 'checked'; }?> id="RegistrationTemplate" value="3e">
                                <label for="RegistrationTemplate">Registration</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="display:none;">
                          <div class="col-12">
                            <p><label><b>Merchant Master</b> </label></p>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="Vie_Merchant" <?php if ( isset($view_menu_permissions) && in_array("4a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="Vie_Merchant" value="4a" checked>
                                <label for="Vie_Merchant">View Merchant</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="ViewSubuser" <?php if ( isset($view_menu_permissions) && in_array("4b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ViewSubuser" value="4b">
                                <label for="ViewSubuser">View Sub user</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="display:none;">
                          <div class="col-12">
                            <p><label><b>Customers</b> </label></p>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="SupportsRequest" <?php if ( isset($view_menu_permissions) && in_array("4c", $view_menu_permissions_Array)) { echo 'checked'; }?> id="SupportsRequest" value="4c">
                                <label for="SupportsRequest">Supports Request</label>
                              </div>
                            </div>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="SaleRequest" <?php if ( isset($view_menu_permissions) && in_array("4d", $view_menu_permissions_Array)) { echo 'checked'; }?>  id="SaleRequest" value="4d">
                                <label for="SaleRequest">Sale Request</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="display:none;">
                          <div class="col-12">
                             <p><label><b>Subadmin Master</b> </label></p>
                          </div>
                          <div class="col  mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="CreateSubadmin" <?php if ( isset($view_menu_permissions) && in_array("5a", $view_menu_permissions_Array)) { echo 'checked'; }?> id="CreateSubadmin" value="5a">
                                <label for="CreateSubadmin">Create Subadmin</label>
                              </div>
                            </div>
                          </div>
                          <div class="col  mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" name="ViewAllSubadmin" <?php if ( isset($view_menu_permissions) && in_array("5b", $view_menu_permissions_Array)) { echo 'checked'; }?> id="ViewAllSubadmin" value="5b">
                                <label for="ViewAllSubadmin">View All Subadmin</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <p><label><b>Settings  <i class="text-danger">*</i> </b> </label></p>
                          </div>
                          <div class="col mx-253">
                            <div class="form-group">
                              <div class="custom-checkbox">
                                <input type="checkbox" checked="" <?php if ( isset($view_menu_permissions) && in_array("6", $view_menu_permissions_Array)) { echo 'checked'; }?>  name="Settings" id="Settings" value="6">
                                <label for="Settings">Settings</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="grid grid-chart edit-profile" style="width: 100% !important;background: transparent !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <h3 class="h3_list_section">Assign Merchants (Select below)<i class="text-danger">*</i></h3>
                                            <!-- <span style="margin-left: 10px;">(Select below)</span> -->
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-12">
                                        <div class="pos-list-dtable reset-dataTable">
                                            <table id="example" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>ID</th> -->
                                                        <!-- <th><input name="select_all" value="1" type="checkbox"></th> -->
                                                        <th>
                                                            <!-- <label class="custom_checkbox_th" style="display: inline-block !important;"> 
                                                                <input name="select_all" value="1" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label> -->
                                                        </th>
                                                        <th>DBA Name </th>
                                                        <th>Company Name</th>
                                                        <th>Status</th> 
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 0;
                                                    if($loc=='edit_agent') {
                                                        if($assign_merchant!="") {
                                                            $assign_merchantArray=explode(',',$assign_merchant);
                                                            $lengthOfArray=count($assign_merchantArray);
                                                            if(count($all_merchantList) > 0 ) {
                                                                $i=1;
                                                                foreach($all_merchantList as $a_data) {
                                                                    $count++; ?>
                                                                    <tr class="<?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'selected '.$a_data->id; }?>">
                                                                        <!-- <td><?php echo $a_data->id;?></td> -->
                                                                        <!-- <td>
                                                                            <label class="custom_checkbox"> 
                                                                                <input type="checkbox" class="m_check" id='checkbox_<?php echo $a_data->id; ?>' name="chkstatus[]" value="<?php echo $a_data->id;?>" <?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'checked '.$a_data->id; }?>>
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </td> -->
                                                                        <td>
                                                                            <input type="checkbox" class="m_check" id='checkbox_<?php echo $a_data->id; ?>' <?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'checked'; }?> name="chkstatus[]" value="<?php echo $a_data->id;?>">
                                                                        </td>
                                                                        <td><?php echo $a_data->business_dba_name;?></td>
                                                                        <td><?php echo $a_data->business_name;?></td>
                                                                        <!-- <?php
                                                                        if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                                                        if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                                                        if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; } ?>
                                                                        <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td> -->
                                                                        <?php
                                                                        if($a_data->status=="active"){
                                                                            $dtext='Active';
                                                                            $text_color = 'rgb(60,152,77)';
                                                                        }
                                                                        if($a_data->status=="Waiting_For_Approval"){
                                                                            $dtext='Waiting';
                                                                            $text_color = '#17a2b8';
                                                                        }
                                                                        if($a_data->status=="pending"){
                                                                            $dtext='Pending';
                                                                            $text_color = 'rgb(241,147,59)';
                                                                        } ?>
                                                                        <td style="min-width: 100px;"><span class="list_status" style="color: <?php echo $text_color; ?> !important;"><?php echo $dtext; ?></span></td>

                                                                        <td class="m_email"><?php echo $a_data->email;?></td>
                                                                        <td><?php echo $a_data->business_number;?></td>
                                                                    </tr>
                                                                    <?php $i++;
                                                                }
                                                            }
                                                        } else {
                                                            if(count($all_merchantList) > 0) {
                                                                $i=1;
                                                                foreach($all_merchantList as $a_data) {
                                                                    $count++; ?>
                                                                    <tr>
                                                                        <!-- <td><?php echo $a_data->id;?></td> -->
                                                                        <!-- <td>
                                                                            <label class="custom_checkbox"> 
                                                                                <input type="checkbox" class="m_check" id='checkbox_<?php echo $a_data->id; ?>' name="chkstatus[]" value="<?php echo $a_data->id;?>" <?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'checked '.$a_data->id; }?>>
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </td> -->
                                                                        <td>
                                                                            <input type="checkbox" class="m_check" id='checkbox_<?php echo $a_data->id; ?>' <?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'checked'; }?> name="chkstatus[]" value="<?php echo $a_data->id;?>">
                                                                        </td>
                                                                        <td><?php echo $a_data->business_dba_name;?></td>
                                                                        <td><?php echo $a_data->business_name;?></td>
                                                                        <!-- <?php
                                                                        if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                                                        if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                                                        if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; } ?>
                                                                        <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td> -->
                                                                        <?php
                                                                        if($a_data->status=="active"){
                                                                            $dtext='Active';
                                                                            $text_color = 'rgb(60,152,77)';
                                                                        }
                                                                        if($a_data->status=="Waiting_For_Approval"){
                                                                            $dtext='Waiting';
                                                                            $text_color = '#17a2b8';
                                                                        }
                                                                        if($a_data->status=="pending"){
                                                                            $dtext='Pending';
                                                                            $text_color = 'rgb(241,147,59)';
                                                                        } ?>
                                                                        <td style="min-width: 100px;"><span class="list_status" style="color: <?php echo $text_color; ?> !important;"><?php echo $dtext; ?></span></td>

                                                                        <td class="m_email"><?php echo $a_data->email;?></td>
                                                                        <td><?php echo $a_data->business_number;?></td>
                                                                    </tr>
                                                                    <?php $i++;
                                                                }
                                                            }
                                                        }
                                                    } elseif($loc=='create_new_agent')  {
                                                        if(count($all_merchantList) > 0 ) {
                                                            $i=1;
                                                            foreach($all_merchantList as $a_data) {
                                                                $count++; ?>
                                                                <tr>
                                                                    <!-- <td><?php echo $a_data->id;?></td> -->
                                                                    <!-- <input type="checkbox" class="m_check" id='checkbox_<?php echo $a_data->id; ?>' name="chkstatus[]" value="<?php echo $a_data->id;?>"> -->
                                                                    <!-- <td>
                                                                        <label class="custom_checkbox"> 
                                                                            <input type="checkbox" class="m_check" id='checkbox_<?php echo $a_data->id; ?>' name="chkstatus[]" value="<?php echo $a_data->id;?>">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td> -->
                                                                    <td>
                                                                        <input type="checkbox" class="m_check" id='checkbox_<?php echo $a_data->id; ?>' <?php if(in_array($a_data->id , $assign_merchantArray) ){ echo 'checked'; }?> name="chkstatus[]" value="<?php echo $a_data->id;?>">
                                                                    </td>
                                                                    <td><?php echo $a_data->business_dba_name;?></td>
                                                                    <td><?php echo $a_data->business_name;?></td>
                                                                    <!-- <?php
                                                                    if($a_data->status=="active"){ $btncolor='btn-success'; $dtext='Active'; $title='Active';}
                                                                    if($a_data->status=="Waiting_For_Approval"){ $btncolor='btn-warning'; $dtext='Waiting'; $title='Waiting For Admin Approval'; }
                                                                    if($a_data->status=="pending"){$btncolor='btn-danger'; $dtext='Pending'; $title='Pending'; } ?>
                                                                    <td><a data-toggle="tooltip" class="btn <?php echo $btncolor;?> btn-xs" style="font-size: 12px; color:white; " data-placement="right" title="<?php echo $title;?>"><?php echo $dtext; ?></a></td> -->

                                                                    <?php
                                                                    if($a_data->status=="active"){
                                                                        $dtext='Active';
                                                                        $text_color = 'rgb(60,152,77)';
                                                                    }
                                                                    if($a_data->status=="Waiting_For_Approval"){
                                                                        $dtext='Waiting';
                                                                        $text_color = '#17a2b8';
                                                                    }
                                                                    if($a_data->status=="pending"){
                                                                        $dtext='Pending';
                                                                        $text_color = 'rgb(241,147,59)';
                                                                    } ?>
                                                                    <td style="min-width: 100px;"><span class="list_status" style="color: <?php echo $text_color; ?> !important;"><?php echo $dtext; ?></span></td>

                                                                    <td><?php echo $a_data->email;?></td>
                                                                    <td><?php echo $a_data->business_number;?></td>
                                                                </tr>
                                                                <?php $i++;
                                                            }
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px !important;">
                            <div class="col-12">
                                <div style="display:none" id="hideencheckbox"></div>
                                <input type="submit" id="btn_login" name="submit" class="btn btn-first pull-right" value="<?php echo $action ?>" />
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="message_popup_error" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body error_message"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));

    $("#zip_code").inputFilter(function(value) {
        return /^-?\d*$/.test(value);
    });

    $("#total_commission, #commission_p_merchant, #commission_p_transaction, #buy_rent, #buyrate_volume").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });

    $(function(){
        $(".us-phone-no").mask("(999) 999-9999");
        // $(".us-tin-no").mask("999-99-9999");
    })

    $('#mob_no_new').keypress(function(event){
        // console.log(event.which);
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault();
        }
    });

    $("#Hold_Amount").on("keyup",function(){
        calcaulatHold($(this));
    });

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        var table =$('#example').DataTable({
            dom: 'lBfrtip',
            "order": [[ 0, "desc" ]],
            // select: 'multi',
            responsive: true, 
            language: {
                search: '', searchPlaceholder: "Search",
                oPaginate: {
                    sNext: '<i class="fa fa-arrow-right"></i>',
                    sPrevious: '<i class="fa fa-arrow-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                },
                buttons: {
                    selectAll: "Select all rows",
                    selectNone: "Select none"
                }
            },
            buttons: [
                'selectAll',
                'selectNone',      
            ]
        });

        // updateDataTableSelectOnLoad(table);

        // Handle click on checkbox
        $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
            // console.log('1');return false;
            var $row = $(this).closest('tr');
            // Get row data
            var data = table.row($row).data();
            // Get row ID
            var rowId = data[0];
            // Determine whether row ID is in the list of selected row IDs
            var index = $.inArray(rowId, rows_selected);
            // If checkbox is checked and row ID is not in list of selected row IDs
            if(this.checked && index === -1){
                rows_selected.push(rowId);
                // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
            } else if (!this.checked && index !== -1) {
                rows_selected.splice(index, 1);
            }

            if(this.checked){
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }

            e.stopPropagation();
        });

        // Handle click on "Select all" control
        $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
            if(this.checked){
                $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
                $('#example tbody input[type="checkbox"]:checked').trigger('click');
            }
            // Prevent click event from propagating to parent
            e.stopPropagation();
        });
    });

    function updateDataTableSelectAllCtrl(table){
        var $table             = table.table().node();
        var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);
        // If none of the checkboxes are checked
        if($chkbox_checked.length === 0){
            chkbox_select_all.checked = false;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
                $('.custom_checkbox_th span.checkmark').removeClass('indeterminate');
            }
        // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length){
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
                $('.custom_checkbox_th span.checkmark').removeClass('indeterminate');
            }
        // If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = true;
                $('.custom_checkbox_th span.checkmark').addClass('indeterminate');
            }
        }
    }

    var rows_selected = [];
    function validate(form) {
        // validation code here ...
        if(rows_selected.length==0) {
            alert('Please select checkbox'); return false;
        } else {
            // console.log("Hello");
            $("#hideencheckbox").html(''); 
            $.each(rows_selected, function(index, rowId){ // Create a hidden element
                $("#hideencheckbox").append($(rowId).attr("checked","checked"));      
            });
            //return confirm('Do you really want to submit the form?');
        }
    }

    $('#btn_login').click( function(event) {
        event.preventDefault();

        if($('#btn_login').val()=='Update Agent') {
            var callUrl='dashboard/update_subadmin';
        } else if($('#btn_login').val()=='Create New Agent') {
            var callUrl='dashboard/create_agent';
        }
        // console.log($('#my_form').serialize()+ datanew); 
        $.ajax({
            url: '<?php echo base_url();?>'+callUrl, //  create_new_subadmin
            type: 'post',
            data: $('#my_form').serialize(),
            success: function(data) {
                // console.log(data);return false;
                var data = JSON.parse(data);
                var status = data.status;
                var message = data.message;
                if(status.trim()=='200') {
                    // $('small').html('Success');
                    window.location.replace('<?php echo base_url('dashboard/all_agent?success='); ?>'+message);
                } else {
                    // $('small').html(data); 
                    $('.modal .error_message').html(message);
                    $("#message_popup_error").modal('show');
                    return false;
                }
                // console.log(data); 
            },
            error: function() {
                //alert('error'); 
                // console.log('Error'); 
            }
        });
    });

    <?php if(isset($assign_merchant)) {
        $assign_merchantArray=explode(',',$assign_merchant);
        $jsondata=json_encode($assign_merchantArray); 
    } else {
        $assign_merchantArray=array();
        $jsondata=json_encode($assign_merchantArray); 
    } ?>

    $(document).ready(function() {
        var table = $('#example').DataTable();
        //  table.rows( ['.select'] ).select();
        var json='<?php echo $jsondata; ?>';
        obj = JSON.parse(json);
        var JsArray=Array();
        JsArray=JSON.stringify();
        table.rows().every (function (rowIdx, tableLoop, rowLoop) {
            if ($.inArray(this.data()[0],obj)>-1 ) {
                this.select ();
            }
        });
    });

    $(document).on('click', '#reset_password', function() {
        if ($(this).prop("checked")) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    })

    $(document).on('change', '.m_check', function() {
        if (this.checked) {
            var current_checkbox = $(this);
            var m_id = $(this).val();
            // console.log(m_id);return false;
            $.ajax({
                url: '<?php echo base_url('dashboard/get_merchant_email'); ?>',
                type: 'post',
                data: {'m_id' : m_id},
                success: function(m_email) {
                    // console.log(m_email);
                    var m_email = m_email.trim();
                    $.ajax({
                        url: '<?php echo base_url('dashboard/get_assigned_merchant'); ?>',
                        type: 'post',
                        data: {'m_id' : m_id},
                        success: function(m_count) {
                            console.log(m_count);
                            var m_count = m_count.trim();
                            if(m_count > 0) {
                                current_checkbox.prop('checked', false);
                                current_checkbox.parent().parent().removeClass('selected');
                                var message = 'The merchant belongs to email ' + m_email + ' is already assigned to other reseller. Try other merchants to assign.<br><br>';
                                $('.modal .error_message').html(message);
                                $("#message_popup_error").modal('show');
                                return false;
                            }
                        }
                    });
                }
            });
        }
    })

    $(document).on('blur','#ssn', function() {
        var inpVal = $(this).val();
        var encPlaceh = '';
        $('#ssn_digits').val(inpVal);
        
        if(inpVal.length) {
            var ttlL=$(this).val().trim().length;
            // console.log(ttlL)
            for (var i = 0; i < ttlL; i++) {
                if(i == 3 || i == 6) {
                    encPlaceh+='-';
                } else if(i<= 5) {
                    encPlaceh+='x';
                } else {
                    i = ttlL;
                    // encPlaceh+=inpVal.substr(5, ttlL-1);
                    var str_n = inpVal.substr(7, ttlL);
                    str_n = str_n.replace(/-/g, "");
                    encPlaceh+=str_n;
                }
            }
            $(this).val(encPlaceh);
            // $(this).data('val', '');
            // console.log(encPlaceh)
            // $(this).data('val', encPlaceh);

        } else {
            // console.log('bb');
            $(this).data('val','');
        }
    })

    $(document).on('focus','#ssn', function() {
        var ssn_digits = $('#ssn_digits').val();
        $('#ssn').val(ssn_digits);
    })

    $(document).ready(function() {
        var inpVal = $('#ssn').val(), encPlaceh = '';
        // $('#ssn_digits').val(inpVal);
        
        if(inpVal.length) {
            var ttlL = $('#ssn').val().trim().length;
            for (var i = 0; i < ttlL; i++) {
                if(i == 3 || i == 6) {
                    encPlaceh+='-';
                } else if(i<= 5) {
                    encPlaceh+='x';
                } else {
                    i = ttlL;
                    // encPlaceh+=inpVal.substr(5, ttlL-1);
                    var str_n = inpVal.substr(7, ttlL);
                    str_n = str_n.replace(/-/g, "");
                    encPlaceh+=str_n;
                }
            }
            $('#ssn').val(encPlaceh);

        } else {
            $('#ssn').data('val','');
        }
    })
    
    $(document).ready(function() {
        var value;
        var $ssn = $('#ssn');

        String.prototype.replaceAt=function(index, character) {
            return this.substr(0, index) + character + this.substr(index+character.length);
        }

        var ssn = {
            init: function () {
                this.bind();
            },
            
            bind: function () {
                // $ssn.on('focus', this.syncInput)
                $ssn.on('keydown', this.syncInput)
                    .on('keyup', this.syncInput)
            },
          
            transformDisplay: function (val) {
                var displayVal = val.replace(/[^0-9|\\*]/g, '');
                var displayVal = displayVal.substr(0, 9);
                
                if (displayVal.length >= 4) {
                    displayVal = displayVal.slice(0, 3) + '-' + displayVal.slice(3);
                }
                
                if (displayVal.length >= 7) {
                    displayVal = displayVal.slice(0, 6) + '-' + displayVal.slice(6);
                }
                
                return displayVal;
            },
          
            transformValue: function (val) {
                if (typeof value !== 'string') {
                    value = "";
                }
                
                if (!val) {
                    value = null;
                    return;
                }

                value = val;
            },
          
            syncInput: function () {
                var $input = $(this);
                var val = $(this).val();
                var displayVal = ssn.transformDisplay(val);
                ssn.transformValue(val);
                
                this.setSelectionRange(val.length, val.length);
                
                $input.val(displayVal);
                // $ssnVal.val(value);
                
                // console.log('value set', displayVal);
            },
            
            syncValue: function () {
              
            },
        };

        ssn.init();
    })
</script>

<?php include_once'footer_button_dash.php'; ?>