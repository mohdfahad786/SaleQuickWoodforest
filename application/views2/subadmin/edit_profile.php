<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
    ?>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgi4r_8NVve2Nt9dqc7x8oO26Pzbbzb-8&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
        #map {
        height: 100%;
    }
    /* Optional: Makes the sample page fill the window. */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #locationField,
    #controls {
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
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: block !important;
    }
    .btn {
        /*border: 1px solid rgb(210, 223, 245);*/
        color: rgb(148, 148, 146);
        background-color: #fff;
        padding: 8px 20px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        width: 100% !important;
    }
    @media (min-width: 1401px) {
        .btn {
            border: 2px solid rgba(210, 223, 245) !important;
        }
    }
    @media (max-width: 1400px) {
        .btn {
            border: 1px solid rgba(210, 223, 245) !important;
        }
    }
    .btn:not([class*='btn-inverse']):not(.component-flat) {
        box-shadow: none !important;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .custom_logo_style {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        max-height: 130px;
        width: 240px;
    }
    .logo_preview {
        text-align: center;
        margin-top: 5px;
        position: relative;
    }
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
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .custom-file-input {
        position: absolute !important;
    }

    .upload_profile{
      width: 120px;
      position: relative;
      margin: auto;
    }

    .upload_profile img{
      border-radius: 50%;
      width: 120px;
      height: 120px;
    }

    .upload_profile .round{
      position: absolute;
      bottom: 3px;
      right: 3px;
      background: #00B4FF;
      width: 32px;
      height: 32px;
      line-height: 33px;
      text-align: center;
      border-radius: 50%;
      overflow: hidden;
    }

    .upload_profile .round input[type = "file"]{
      position: absolute;
      transform: scale(2);
      opacity: 0;
    }

    input[type=file]::-webkit-file-upload-button{
        cursor: pointer;
    }
    #btn_login {
        width: 230px !important;
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
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom"></div>
            </div>
            <?php if(isset($msg)) {
                echo '<span class="text-success" > '.$msg.'</span>';
            }
            echo form_open(base_url().'agent/edit_profile', array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
            echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : ""; ?>
                <div class="row" style="margin-bottom: 10px !important;">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Update Reseller Profile</div>
                                            <div class="form-group" style="margin: 20px 0 30px 0;">
                                                <label class="text-center" style="display: grid !important;">Profile Picture</label>
                                                <!-- <input type="file" name="mypic" class="custom-file-input" id="mypic" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>"> -->
                                                <!-- <div class="upload-btn-wrapper">
                                                    <button class="btn">Browse Picture</button>
                                                </div>
                                                <?php if(isset($mypic) && $mypic!='') { ?>
                                                    <div class="logo_preview">
                                                        <img class="custom_logo_style" src="<?php echo $upload_loc.'/'.$mypic ;?>" alt="logo">
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="logo_preview">
                                                        <img class="custom_logo_style" src="<?php echo base_url('new_assets/img/no-logo.png') ;?>" alt="logo">
                                                    </div>
                                                <?php } ?> -->
                                                <!-- <div class="profile_content p-4 my-3">
                                                    <a class="post-author show_profile_pic_modal" href="javascript:void(0)">
                                                        <div class="post-author-avatar">
                                                            <img class="img-fluid rounded-circle mb-2 user_profile_pic2" src="<?php echo base_url('new_assets/img/no-logo.png') ;?>" alt="user-profice-pic" style="max-width: 100px !important;width: 100px !important;height: 100px !important;">
                                                            <div class="side-icon">
                                                                <i class="fa fa-camera"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div> -->
                                                <!-- <div class="profile_content p-4 my-3">
                                                    <div class="post-author-avatar">
                                                        <img class="img-fluid rounded-circle mb-2 user_profile_pic2" src="<?php echo base_url('new_assets/img/no-logo.png') ;?>" alt="user-profice-pic">
                                                        <input type="file" name="mypic" class="custom-file-input" id="mypic" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">
                                                        <div class="side-icon">
                                                            <button id="profile_btn" type="button" style="background-color: #2273dc;border: none;padding: 2px 2px 0px 2px;">
                                                                <i class="fa fa-plus" style="font-size: 16px;color: #fff;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="upload_profile">
                                                    <img class="custom_logo_style_new" src="<?php echo ((isset($mypic) && $mypic!='') ? $upload_loc.'/'.$mypic : base_url('new_assets/img/empty_pic.png')) ?>" alt="Profile Picture">
                                                    <div class="round">
                                                        <input type="file" name="mypic" class="custom-file-input" id="mypic" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">
                                                        <i class="fa fa-plus" style="color: #fff;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">First Name</label>
                                                        <input type="text" autocomplete="off" class="form-control" name="name" id="name"  required value="<?php echo (isset($name) && !empty($name)) ? $name :'';?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Last Name</label>
                                                        <input type="text" autocomplete="off" class="form-control" name="last_name" id="last_name"  required value="<?php echo (isset($last_name) && !empty($last_name)) ? $last_name :'';?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Mobile No.</label>
                                                <input type="text" autocomplete="off" class="form-control us-phone-no" name="mob_no" id="mob_no" required value="<?php echo (isset($mob_no) && !empty($mob_no)) ? $mob_no : '';?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" autocomplete="off" readonly class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required value="<?php echo (isset($email) && !empty($email)) ? $email : '';?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <div id="locationField">
                                                    <input
                                                        id="autocomplete"
                                                        placeholder="Enter your address"
                                                        onFocus="geolocate()"
                                                        type="text" autocomplete="off"  class="form-control" name="address" id="address"  required value="<?php echo (isset($address) && !empty($address)) ? $address : '';?>"
                                                        />
                                                </div>
                                                <!--  <input type="text" autocomplete="off"  class="form-control" name="address" id="address"  required value="<?php echo (isset($address) && !empty($address)) ? $address : '';?>"> -->
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">City</label>
                                                        <input type="text" autocomplete="off"  class="form-control" name="city" id="city"  required value="<?php echo (isset($city) && !empty($city)) ? $city : '';?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">State</label>
                                                        <input type="text" autocomplete="off"  class="form-control" name="state" id="state"  required value="<?php echo (isset($state) && !empty($state)) ? $state : '';?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Zip Code</label>
                                                <input type="text" autocomplete="off"  class="form-control" name="zip_code" id="zip_code"  required value="<?php echo (isset($zip_code) && !empty($zip_code)) ? $zip_code : '';?>" maxlength="6">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="grid grid-chart" style="width: 100% !important;margin-bottom: 30px;">
                                    <div class="grid-body d-flex flex-column" style="margin-top: 10px;">
                                        <div class="mt-auto">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="">Social Security Number</label>
                                                                <input type="text" autocomplete="off" class="form-control us-tin-no" name="ssn" id="ssn"  required value="<?php echo (isset($ssn) && !empty($ssn)) ? $ssn : ''; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="">EIN No.</label>
                                                                <input type="text" autocomplete="off" class="form-control" name="ein_no" id="ein_no"  required value="<?php echo (isset($ein_no) && !empty($ein_no)) ? $ein_no : '';?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="">Sign Up Bonus</label>
                                                                <input type="text" autocomplete="off" readonly class="form-control" name="total_commission" id="total_commission" required value="<?php echo (isset($total_commission) && !empty($total_commission)) ? $total_commission : '';?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="">Profit Share %</label>
                                                                <input type="text" autocomplete="off" readonly class="form-control" name="commission_p_merchant" id="commission_p_merchant" required value="<?php echo (isset($commission_p_merchant) && !empty($commission_p_merchant)) ? $commission_p_merchant : '';?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Gateway Fee (Per Merchant)</label>
                                                        <input type="text" autocomplete="off" readonly class="form-control" name="commission_p_transaction" id="commission_p_transaction"  required value="<?php echo (isset($commission_p_transaction) && !empty($commission_p_transaction)) ? $commission_p_transaction : '';?>">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="">Buy Rate (Per Transaction)</label>
                                                                <input type="text" autocomplete="off" readonly  class="form-control" name="buy_rent" id="buy_rent"  required value="<?php echo (isset($buy_rent) && !empty($buy_rent)) ? $buy_rent : '';?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="">Buy Rate Volume</label>
                                                                <input type="text" autocomplete="off" readonly class="form-control" name="buyrate_volume" id="buyrate_volume" required value="<?php echo (isset($buyrate_volume) && !empty($buyrate_volume)) ? $buyrate_volume : '';?>">
                                                            </div>
                                                        </div>
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
                                <div class="grid grid-chart" style="width: 100% !important;">
                                    <div class="grid-body d-flex flex-column">
                                        <div class="mt-auto">
                                            <div class="row" style="margin-top: 10px;">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-title">Change Password</div>
                                                    <div class="form-group">
                                                        <label for="">Old Password</label>
                                                        <input type="password" class="form-control" name="oldpsw" value="" placeholder="Old Password" autocomplete="new-password">
                                                        <input type="hidden" autocomplete="off" class="form-control" name="psw" id="psw" value="<?php echo $psw ? $psw : set_value('psw');?>"> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">New Password</label>
                                                        <input type="password" class="form-control" autocomplete="false" name="npsw" placeholder="New Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Confirm Password</label>
                                                        <input type="password" class="form-control" autocomplete="false" placeholder="Confirm Password" name="cpsw">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-12 text-center">
                        <input type="submit" id="btn_login" name="mysubmit" value="Update" class="btn btn-first">
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<script>
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
    
    $("#total_commission, #commission_p_merchant, #commission_p_transaction, #buy_rent").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value);
    });
    
    $(function(){
        $(".us-phone-no").mask("(999) 999-9999");
        $(".us-tin-no").mask("999-99-9999");
    })
    
    $(document).on('blur','input.us-tin-no',function(){
        // console.log('111');
        $(this).attr('maxlength',11);
        var inpVal=$(this).val(),encPlaceh='';
        if(inpVal.length) {
            $(this).data('val',$(this).val().trim());
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
                    var str_n = inpVal.substr(5, ttlL-1);
                    str_n = str_n.replace(/-/g, "");
                    encPlaceh+=str_n;
                }
            }
            // console.log(encPlaceh)
            $(this).val(encPlaceh);
        } else {
            $(this).data('val','');
        }
    })
    
    $(document).ready(function() {
        $('input[name=old_pswd]').val('');
    })

    $(document).on('change', '#mypic', function(){
        var input = this;
        // console.log(input);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
            $('.custom_logo_style_new').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    });
</script>
<?php include_once'footer_dash.php'; ?>