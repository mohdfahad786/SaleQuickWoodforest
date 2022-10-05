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
        width: 150px;
        margin: auto;
        margin-top: 5px;
    }
    .image_btn {
        background: rgb(0, 166, 255) !important;
        color: #fff !important;
        width: 150px !important;
        height: 36px !important;
        text-transform: none !important;
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
    .custom_logo_style_blank {
        border: 3px solid #ddd;
        border-style: dotted;
        border-radius: 10px;
        padding: 20px;
        /*max-height: 110px;*/
        width: 140px;
        height: 120px;
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
            <?php
            echo form_open( (($loc=='edit_admin') ? base_url().'multiadmin/'.$loc.'/'.$id : base_url().'multiadmin/'.$loc) , array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
            echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : ""; ?>
                <div class="row" style="margin-bottom: 20px !important;">
                    <div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto;">
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-title">Admin Details</div>
                                            <div class="form-group">
                                                <label for="">Profile Picture</label>
                                                
                                                <?php if(isset($image) && $image!=''){ ?>
                                                    <div class="logo_preview">
                                                        <img class="custom_logo_style" src="<?php echo $upload_loc.'/'.$image ;?>" alt="logo">
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="logo_preview">
                                                        <img class="custom_logo_style_blank" src="<?php echo base_url('new_assets/img/plus-2.png'); ?>" alt="logo">
                                                    </div>
                                                <?php } ?>
                                                <div class="upload-btn-wrapper">
                                                    <button class="btn image_btn">Browse Picture</button>
                                                    <input type="file" name="image" class="custom-file-input" id="image" value="<?php echo (isset($image) && !empty($image)) ? $image : set_value('image');?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" autocomplete="off" placeholder="Name" class="form-control" name="name" id="name"  required value="<?php echo (isset($name) && !empty($name)) ? $name :'';?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" autocomplete="off" placeholder="Username" class="form-control" name="username" id="username" minlength="6" required value="<?php echo (isset($username) && !empty($username)) ? $username :'';?>" <?php echo (($loc=='edit_admin') ? 'disabled' : ''); ?>>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="text" autocomplete="off" placeholder="Email" class="form-control" name="email_id" id="email_id" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" required value="<?php echo (isset($email_id) && !empty($email_id)) ? $email_id : '';?>" <?php echo (($loc=='edit_admin') ? 'disabled' : ''); ?>>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="">Phone</label>
                                                        <input type="text" autocomplete="off" placeholder="Phone" class="form-control" name="phone" id="phone" required value="<?php echo (isset($phone) && !empty($phone)) ? $phone : '';?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php if($loc=='edit_admin') { ?>
                                                <div class="form-group">
                                                    <label for="">User Type</label>
                                                    <select name="user_type" class="form-control">
                                                        <option value="">Select User Type</option>
                                                        <option value="wf" <?php echo ($user_type == 'wf') ? 'selected' : '' ?>>Woodforest</option>
                                                        <!-- <option value="subadmin" <?php echo ($user_type == 'subadmin') ? 'selected' : '' ?>>Sub Admin</option> -->
                                                    </select>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group">
                                                    <label for="">User Type</label>
                                                    <select name="user_type" class="form-control">
                                                        <option value="">Select User Type</option>
                                                        <option value="wf">Woodforest</option>
                                                        <!-- <option value="subadmin">Sub Admin</option> -->
                                                    </select>
                                                </div>
                                            <?php } ?>
                                                
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <div id="locationField">
                                                    <input id="autocomplete" placeholder="Address" onFocus="geolocate()" type="text" autocomplete="off" class="form-control" name="address" id="address" required value="<?php echo (isset($address) && !empty($address)) ? $address : '';?>" />
                                                </div>
                                            </div>
                                            <?php if($loc=='edit_admin') { ?>
                                                <div class="form-group">
                                                    <label for="">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="active" <?php echo ($status == 'active') ? 'selected' : '' ?>>Active</option>
                                                        <option value="block" <?php echo ($status == 'block') ? 'selected' : '' ?>>Block</option>
                                                    </select>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group">
                                                    <label for="">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="active">Active</option>
                                                        <option value="block">Block</option>
                                                    </select>
                                                </div>
                                            <?php } ?>

                                            <?php if($loc=='edit_admin') { ?>
                                                <div class="form-group" style="margin-bottom: 0px !important;margin-top: -10px !important;">
                                                    <label for=""></label>
                                                    <div class="custom-checkbox">
                                                        <input type="checkbox" name="reset_password" value="0" id="reset_password" style="width: 17px !important; height: 17px !important;">
                                                        <label for="reset_password">Reset Password for this Admin?</label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                    <!-- <div class="col-12 text-right"> -->
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right" style="margin: auto;">
                        <input type="submit" id="btn_login" name="mysubmit" value="<?php echo $action; ?>" class="btn btn-first" style="width: 230px !important;border-radius: 8px !important;">
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<script>
    $(document).keypress(
      function(event){
        if (event.which == '13') {
          event.preventDefault();
        }
    });
    
    $(document).on('change', '#image', function(){
        var input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // $('.custom_logo_style').attr('src', e.target.result);
                var upImage = e.target.result;
                $('.logo_preview').html('<img class="custom_logo_style" src="' + upImage + '" alt="user">');
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    });

    $(document).on('click', '#reset_password', function() {
        if ($(this).prop("checked")) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    })
</script>
<?php include_once'footer_dash.php'; ?>