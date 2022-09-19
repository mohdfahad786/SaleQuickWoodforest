<?php
    include_once'header_rec_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
    .card-inner-sketch {
        background: url("<?= base_url('new_assets/img/credit_card_bg.jpg') ?>");
        box-shadow: 0px -1px 25px 0px rgba(16, 57, 107, 0.63);
    }
    #card_close {
        border-radius: 50% !important;
    }
</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('new_assets/css/recurring.css') ?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
                    <!-- <h4 class="h4-custom">Create Invoice</h4> -->
                    <div class="form-group">
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
            <div id="simple_invoice_wrapper" class="row" style="margin-bottom: 30px !important;">
                <div class="col-sm-12 col-md-8 col-lg-6" style="margin: auto;">
                    <?php
                    echo form_open('Customer_recurring/create_recurring', array('id' => "my_form",'class'=>"row inv-rec-wrapper",'enctype'=> 'multipart/form-data','name' => "myFormm",'onsubmit' => "return validateFormm()"));
                    
                    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                    ?>
                    <input type="hidden" class="new_token_input" id="new_token_input" name="new_token_input" value="">
                    <div class="grid grid-chart" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-12 col-md-12 col-lg-12" style="padding: 0px 30px 0px 30px !important;">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control" name="name" id="s_name" pattern="[a-zA-Z\s]+" placeholder="Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required type="text" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" name="s_email" id="s_email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" placeholder="Email" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>"  type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <style>
                                            @media (max-width: 1150px) {
                                                input#money {
                                                    max-width: 280px !important;
                                                    font-size: 50px !important;
                                                }
                                            }

                                            @media (min-width: 1151px) {
                                                input#money {
                                                    max-width: 360px !important;
                                                    font-size: 56px !important;
                                                }
                                            }

                                            @media (max-width: 1150px) {
                                                .checkbox label {
                                                    font-size: 14px !important;
                                                }
                                            }
                                        </style>
                                        <div class="row amount_row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <div class="" style="border: none !important;margin: auto !important;display: inline-flex;">
                                                            <div class="input-group-addon" style="border: none !important;background-color: #FAFAFF !important;height: 62px !important;padding: 0px !important;">
                                                                <span class="input-group-text">$</span>
                                                            </div>

                                                            <input type="text" name="s_amount"  onkeyup="this.style.width = ((this.value.length + 30) * 8) + 'px';"  required autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" class="form-control text-right" id="money" value="0.00" placeholder="0.00" style="background-color: #FAFAFF !important;text-align: center !important;height: 80px !important;z-index: 0 !important;width:200px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $getOtherCharges = $this->db->where('merchant_id',$merchant_id)->get('other_charges')->result();
                                                //print_r($getOtherCharges[0]->title);
                                                $data[0]['title'] = $getOtherCharges[0]->title ? $getOtherCharges[0]->title : '';
                                                $data[0]['percentage'] = $getOtherCharges[0]->percentage ? $getOtherCharges[0]->percentage : '';
                                                $data[0]['type'] = $getOtherCharges[0]->type ? $getOtherCharges[0]->type : '';
                                                ?>
                                                <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data[0]['type']; ?>" readonly>

                                                <input class="form-control" name="other_charges_title" id="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>

                                                <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data[0]['percentage']; ?>" readonly>

                                                <?php //print_r($data[0]); ?>
                                                <?php if($data[0]['percentage']!='') { ?>
                                                    <div class="row" style="margin-top: 10px;">
                                                        <div class="col-12 text-center">
                                                            <div class="checkbox text-center" style="display: inline-block !important;height: 20px !important;">
                                                                <label style="font-size: 16px;font-weight: 600;">
                                                                <input type="checkbox" name="carrent_othercharges" id="carrent_othercharges" class="form-check-input" > <?php if($data[0]['title']!=''){echo $data[0]['title'];  } else { ?>Other Charges <?php } ?> - <?php if($data[0]['percentage']!=''){echo $data[0]['percentage'];} else { ?>0 <?php } ?><?php if($data[0]['type']!=''){echo $data[0]['type'];} else { ?>$<?php } ?>, Total - $    <i class="input-frame"></i> <span id="full_amount_span" >00.00</span> 
                                                                <input class="form-control"  name="other_charges_s" id="other_charges_s" type="hidden" value="" readonly>  
                                                                <input class="form-control" name="other_charges_title" type="hidden" value="<?php echo $data[0]['title']; ?>" readonly>
                                                                <input class="form-control"  name="full_amount" id="full_amount" type="hidden" value="" readonly>
                                                                <input class="form-control"  name="full_amount_amount" id="full_amount_amount" type="hidden" value="" readonly>  
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $("#money").click(function() {
                                                    $("#full_amount").val();
                                                    $("#full_amount_span").text('0.00');
                                                    //$("#other_amount_span").text();

                                                    $("#carrent_othercharges").prop("checked", false);
                                                });

                                                $('input[name="carrent_othercharges"]').click(function() {
                                                    if ($(this).prop("checked") == true) {
                                                        var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                                                        // alert(other_charges_type);return false;
                                                        var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                                                        var currency = ($("#money").val()) ? $("#money").val() : 0;
                                                        var amount = Number(currency.replace(/[^0-9.-]+/g, ""));

                                                        if (other_charges_type == '$') {
                                                            // alert(1)
                                                            var otherCharges = parseFloat(other_charges_value);
                                                            var totalAmount = parseFloat(other_charges_value) + parseFloat(amount);
                                                        } else if (other_charges_type == '%') {
                                                            // alert(2)
                                                            var subTotal = parseFloat(amount);
                                                            var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                                                            var totalAmount = parseFloat(otherCharges) + parseFloat(amount);
                                                        }

                                                        $("#full_amount_amount").val(currency);
                                                        //$("#money").val(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                        // console.log('totalAmount', totalAmount)
                                                        $("#full_amount").val(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                        $("#full_amount_span").text(totalAmount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                                                        $("#other_charges_s").val(otherCharges.toFixed(2));

                                                    } else if ($(this).prop("checked") == false) {
                                                        var other_charges_type = ($("#other_charges_type").val()) ? $("#other_charges_type").val() : 0;
                                                        var other_charges_value = ($("#other_charges_value").val()) ? $("#other_charges_value").val() : 0;
                                                        var amount = ($("#full_amount").val()) ? $("#full_amount").val() : 0;
                                                        var full_amount_amount = ($("#full_amount_amount").val()) ? $("#full_amount_amount").val() : 0;

                                                        if (other_charges_type == '$') {
                                                            var otherCharges = parseFloat(other_charges_value);
                                                            var totalAmount = parseFloat(amount) - parseFloat(other_charges_value);
                                                        } else if (other_charges_type == '%') {
                                                            var subTotal = parseFloat(amount);
                                                            var otherCharges = parseFloat(subTotal * (other_charges_value / 100));
                                                            var totalAmount = parseFloat(amount) - parseFloat(otherCharges);
                                                        }
                                                        // $("#money").val(full_amount_amount);
                                                        $("#other_charges_s").val('');
                                                        $("#full_amount").val(full_amount_amount);
                                                        $("#full_amount_span").text(full_amount_amount);
                                                    }
                                                });
                                            });
                                        </script>

                                        <div class="row" style="margin-top: 15px">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Mobile Number</label>
                                                    <input class="form-control" placeholder="Mobile Number" name="s_mobile" id="s_phone" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="text" name="s_start_date" class="form-control" id="s_invoiceDueDatePicker" placeholder="Start Date" name="" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- added -->
                                        <div class="row">
                                            <input type="text" class="btn btn-first" name="recurring_type" value="Interval" onclick="javascript:void(0)" id="recurring_type" readonly required style="width: 100%;margin: 0px 15px 15px;">

                                            <input type="hidden" name="recurring_type_hid" value="" id="recurring_type_hid" >
                                            <!--   <select  class="form-control" id="recurring_type" name="recurring_type" required>
                                                <option value="" class="text-center">Interval</option>
                                                <option value="daily" class="text-center">Daily</option>
                                                <option value="weekly" class="text-center">Weekly</option>
                                                <option value="biweekly" class="text-center">Bi Weekly</option>
                                                <option value="monthly" class="text-center">Monthly</option>
                                                <option value="quarterly" class="text-center">Quarterly</option>
                                                <option value="yearly" class="text-center">Yearly</option>
                                            </select> -->
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group small_box">
                                                    <label><b>Count</b> <img src="<?php echo base_url()?>new_assets/img/info.png" title="Number of times your customer will be billed" aria-hidden="true" style="width:15px;"></label>

                                                    <div class="col-12" style="padding: 0px !important;margin-top: 5px;">
                                                        <input type="radio" class="radio-circle" id="pd__constant" name="pd__constant" checked>
                                                        <label for="pd__constant" class="inline-block">Constant</label>
                                                        &nbsp;&nbsp;OR
                                                        <input type="radio" id="pd__var" name="pd__constant" style="display: none;">
                                                        <input type='text' style="width: 55px;display: inline-block;vertical-align: middle;margin-left: 5px;background-color: #fff !important;padding: 2px !important;" class='form-control text-center' name='recurring_count' id='recurring_count' maxlength="3" placeholder="Count" onKeyPress="return isNumberKey(event)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group small_box">
                                                    <label><b>Type</b> <img src="<?php echo base_url()?>new_assets/img/info.png" title="Select either Auto or Manual type" aria-hidden="true" style="width:15px;"></label>

                                                    <div class="col-12" style="padding: 0px !important;margin-top: 15px;margin-bottom: 9px;">
                                                        <input type="radio" id="pt__Auto" value="1" name="paytype" checked>    Auto 
                                                        <input style="margin-left:50px;" type="radio" id="pt__Manual" value="0" name="paytype">    Manual
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="row">
                                            <div class="text-center col-12">
                                                <a href="javascript:void(0)" class="btn btn-first" id="show_card_popup"><img src="<?php echo base_url('new_assets/img/Activity.png') ?>" style="width: 15px;margin-bottom: 4px;margin-right: 7px;">Add New Card</a>
                                            </div>
                                        </div>

                                        <div class="row token_section d-none" style="margin-top: 15px;">
                                            <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                                <div class="form-group small_box">
                                                    <p><b>Token Created</b></p>
                                                    <p><b class="token_value"></b></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                                <div class="form-group small_box">
                                                    <div class="row" style="display: block !important;">
                                                        <div class="card_value text-center" style="margin-bottom: 5px;">
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row" style="display: block !important;margin-bottom: 13px;">
                                                        <div class="text-center">
                                                            <b class="card_no_value"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <input type="submit" id="btn_login" name="submit" value="Send" class="btn btn-first" style="width: 80px !important;margin-top: 25px;">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-6 text-center" style="margin: auto;">
                                        <span id="s_invoice_loader" class="d-none">
                                            <div style="display: inline;"><img src="<?= base_url('new_assets/img/invoice_loader.gif') ?>" style="width: 20px;" /></div>
                                            <div style="display: inline;"><span> Sending...</span></div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- interval popup -->
<div class="modal fade" id="interval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">Select Interval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="container-fluid" style="border: 1px solid rgb(212, 240, 255) !important; height: 70px;">

                     <button style="float: right; margin-top:13px;" type="button" class="btn btn-primary Daily" value="Daily" id="daily">Apply</button> 
                   
                    <h6 style="margin-top: 10px ;">Daily</h6>
                    <span style="color: gray;">Daily it will bill every day at 1pm cost</span>
                </div>
                <div class="container-fluid" style="border: 1px solid rgb(212, 240, 255) !important; height: 125px;">
                     <button style="float: right; margin-top:13px;" type="button" class="btn btn-primary" value="" id="weekly">Apply</button> 
                   
                    <h6 style="margin-top: 10px ;">Weekly</h6>
                    <span style="color: gray;">Please select day you would like weekly<br> charge to occur</span><br>
                    <button class="btn btn-secondary button5" id="Sun" value="Sunday">Sun</button>
                    <button class="btn btn-secondary button5" id="Mon" value="Monday">Mon</button>
                    <button class="btn btn-secondary button5" id="Tue" value="Tueday">Tue</button>
                    <button class="btn btn-secondary button5" id="Wed" value="Wednesday">Wed</button>
                    <button class="btn btn-secondary button5" id="Thu" value="Thursday">Thu</button>
                    <button class="btn btn-secondary button5" id="Fri" value="Friday">Fri</button>
                    <button class="btn btn-secondary button5" id="Sat" value="Saturday">Sat</button>
 
                </div>
                <div class="container-fluid" style="border: 1px solid rgb(212, 240, 255) !important; height: 120px;">
                     <button style="float: right; margin-top:13px;" type="button" class="btn btn-primary" id="monthlyBtn" name="monthly">Apply</button> 
                   
                    <h6 style="margin-top: 10px ;">Monthly</h6>
                    <span style="color: gray;">Please select day for charge to occur<br> 1 to 28th</span><br>
                    <select class="monthly" name="dateOfMonth" required>
                        <option id="first" value="Select Date" class="text-center">Select Date</option>
                        <?php for ($x = 1; $x <= 28; $x++) {
                             ?><option value="<?php echo $x ?>" class="text-center"><?php echo $x ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right: 0px !important;">
    <div class="modal-dialog" role="document" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none !important;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #3A3C3F !important;font-weight: 600 !important;font-family: Nunito-Regular !important;margin-left: 20px;">Add Your Card Details</h5>
                <button id="card_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="loader_wraper_outer ">
                    <div class="loader_wraper_inner">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="323px" height="292px" viewBox="0 0 323 292" enable-background="new 0 0 323 292" xml:space="preserve">
                            <path fill-rule="evenodd" class="l_svg_top" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M80.747,158.409
                                c18.835,0.853,37.741,0.211,56.614,0.082c8.004-0.056,13.297-3.973,13.162-12.278c-0.135-8.346-5.562-11.768-13.601-11.749
                                c-15.202,0.041-30.406-0.188-45.606-0.031c-7.701,0.081-14.22-1.698-19.787-7.56c-11.189-11.781-22.45-23.546-34.388-34.546
                                c-7.45-6.867-6.208-11.52,0.535-17.809c11.878-11.079,23.238-22.729,34.5-34.444c5.105-5.309,10.741-7.328,18.117-7.292
                                c56.625,0.28,113.253,0.403,169.877,0.1c10.038-0.055,14.076,2.889,13.801,13.391c-0.577,21.479-0.095,42.987-0.047,64.485
                                c0.018,8.729,2.484,16.494,12.664,16.276c10.17-0.215,12.102-8.129,12.074-16.805c-0.073-20.973,0.078-41.946,0.033-62.917
                                c-0.057-27.581-11.35-38.993-39.276-39.21c-27.788-0.218-55.58-0.047-83.367-0.058c-28.314-0.013-56.628,0.045-84.941-0.037
                                c-12.455-0.037-24.02,2.299-33.213,11.47c-13.732,13.698-27.48,27.385-41.05,41.248C9.961,67.755,6.065,76.38,6.974,86.296
                                C8.613,104.161,62.714,157.598,80.747,158.409z"></path>
                            <path fill-rule="evenodd" class="l_svg_bottom" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M317.027,207.701
                                c-1.643-17.862-55.744-71.3-73.775-72.111c-18.836-0.853-37.743-0.211-56.615-0.081c-8.005,0.056-13.296,3.973-13.161,12.278
                                c0.136,8.342,5.562,11.765,13.6,11.744c15.203-0.036,30.406,0.189,45.606,0.032c7.702-0.081,14.22,1.698,19.787,7.563
                                c11.19,11.777,22.448,23.543,34.39,34.547c7.449,6.862,6.206,11.52-0.534,17.804c-11.879,11.082-23.241,22.731-34.504,34.447
                                c-5.102,5.31-10.738,7.329-18.112,7.291c-56.628-0.276-113.257-0.402-169.881-0.098c-10.038,0.054-14.077-2.89-13.8-13.391
                                c0.576-21.479,0.095-42.99,0.047-64.485c-0.019-8.729-2.485-16.494-12.665-16.279c-10.17,0.214-12.102,8.129-12.073,16.804
                                c0.072,20.977-0.079,41.945-0.035,62.922c0.057,27.579,11.35,38.992,39.278,39.208c27.786,0.222,55.579,0.048,83.365,0.058
                                c28.315,0.013,56.63-0.044,84.945,0.037c12.451,0.038,24.018-2.296,33.213-11.469c13.731-13.696,27.479-27.386,41.048-41.247
                                C314.037,226.242,317.933,217.616,317.027,207.701z"></path>
                            <path fill-rule="evenodd" class="l_circle_one" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M78.328,67.273
                                C67.85,67.507,62.187,74.27,62.595,84.598c0.382,9.705,6.231,14.911,16.313,15.168c10.274-1.035,16.378-6.644,15.716-17.188
                                C94.028,73.065,87.913,67.06,78.328,67.273z"></path>
                            <path fill-rule="evenodd" class="l_circle_two" clip-rule="evenodd" fill="#F7F7F7" stroke="#000000" stroke-width="8" d="M245.119,192.908
                                c-10.479,0.233-16.141,6.996-15.733,17.324c0.382,9.705,6.231,14.91,16.313,15.168c10.273-1.034,16.379-6.644,15.717-17.188
                                C260.818,198.7,254.704,192.695,245.119,192.908z"></path>
                        </svg>
                        <p class="loading_txt">Processing </p>
                    </div>
                    <span class="overlay-bg"></span>
                </div>

                <div class="invoice-wrapper">
                   <div class="irm-header-inner">
                        <form id="pop_inputs" class="cardPaymentFormWrapper row">
                            <div class="col-12">
                                <div class="row" style="display: block !important;">
                                    <div class="card-placeholder">
                                        <div class="card-inner-sketch">
                                            <div class="col-12" style="margin-top: 15px;">
                                                <div class="row" style="margin: 0px;display: block !important;">
                                                    <div class="mycl-wrapper responsive-cols flex-row">
                                                        <div class="col-6" style="padding: 0px !important;">
                                                            <div class="chip-logo">
                                                                <img src="<?php echo base_url('new_assets/img/chip.png') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 text-right" style="padding: 0px !important;">
                                                            <div class="card-type-logo" style="display: inline-flex !important;">
                                                                <img src="https://salequick.com/new_assets/img/cardtypelogo.png">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin: 0px;">
                                                    <p class="c__val card__no"><span>****</span><span>****</span><span>****</span><span>----</span></p>
                                                </div>

                                                <div class="mycl-wrapper row" style="margin: 0 !important;">
                                                    <div class="col-6" style="padding: 0 !important;max-width: 40px !important;margin-bottom: 10px;">
                                                        <p style="line-height: 10px !important;color: #fff !important;font-size: 10px !important;">VALID</p>
                                                        <p style="line-height: 10px !important;color: #fff !important;font-size: 10px !important;">THRU</p>
                                                    </div>
                                                    <div class="col-6" style="padding: 0 !important;">
                                                        <div class="flex-col">
                                                            <p class="c__val" style="margin-bottom: 5px !important;margin-top: 0px !important;"><span>--</span><span>/</span><span>--</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-inner-boxes">
                                            <div class="card-box  new-card-box" data-cardno="----" data-mm="--" data-yy="--" data-src="https://salequick.com/new_assets/img/cardtypelogo.png" data-chn="-" style="text-align: -webkit-center !important;">
                                                <input type="radio" value="newcard" name="card_selection_radio" <?php  if(count($token_data) <= '0') { echo  "checked";  } ?> >
                                            </div>
                                        <style>
                                            .card-inner-boxes .card-box .card__no {
                                                width: 210px;
                                                padding: 7px;
                                                text-align: right;
                                            }
                                            .card-inner-boxes .card-box .remove_card_btn_wrapper {
                                                width: 40px;
                                            }
                                            .get_card_box {
                                                margin-bottom: 10px !important;
                                                border: 1px solid rgb(210, 223, 245);
                                                border-radius: 5px;
                                            }
                                            .get_card_box:hover {
                                                    -webkit-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                                    -moz-box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                                    box-shadow: 0px -1px 6px 0px rgba(16, 57, 107, 0.63) !important;
                                            }
                                            .inner_get_card_box {
                                                padding: 0px !important;
                                                height: 50px !important;
                                                text-align: right !important;
                                            }
                                            .saved_card_head_wrapper {
                                                position: relative;
                                                width: 320px;
                                                margin: auto;
                                            }
                                            .all_get_saved_cards {
                                                width: 320px;
                                                margin: auto;
                                            }
                                        </style>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 card-form">
                                        <div class="pay-detail" style="display: inline-block;width: 100%;margin-top: 25px;">
                                            <h3 class="form-title card_form_title">Payment Details</h3>
                                            <input type="hidden" value="<?php print_r($getEmail1); ?>"/>
                                            
                                            <div class="form-group">
                                                <label for="card__cnumber" class="movbale">Card Number</label>
                                                <div class="input-group" style="height: 35px !important;">
                                                    <input id="card__cnumber" name="card_no" class="form-control required CardNumber" type="text" minlength="14">
                                                    <div class="input-group-addon" style="border: none !important;background-color: #fff !important;padding: 0px 5px !important;">
                                                        <span class="input-group-text card_type">
                                                            <img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="card__nameoncard" class="movbale">Card Holder Name</label>
                                                <input id="card__nameoncard"  name="name_card" class="form-control required" type="text">
                                            </div>
                                            
                                            <div class="mycl-wrapper responsive-cols flex-row row" style="margin: 0 -15px !important;">
                                                <div class="col-4" style="padding-left: 8px !important;">
                                                    <div class="form-group fg-half">
                                                        <?php
                                                        $currYr=date('Y');
                                                        $LastYr=$currYr + 20;
                                                        $yeardata=array();
                                                        for ($i=$currYr; $i < $LastYr; $i++) { 
                                                            array_push($yeardata,substr($i, 2,2));
                                                        }
                                                        ?>
                                                        <label for="card__validutil" class="movbale">Expire Date</label>
                                                        <input autocomplete="off"  id="card__validutil"  data-yr='<?php echo json_encode($yeardata);?>' name="exp" placeholder="MM/YY" class="form-control required ddmm" type="text"  maxlength="5">
                                                    </div>
                                                </div>
                                                <div class="col-4" style="padding-left: 8px !important;">
                                                    <div class="form-group fg-half">
                                                        <label for="card__cvv" class="movbale">CVV</label>
                                                        <input id="card__cvv" class="form-control required cvv" type="text"  name="card_validation_num" maxlength="4">
                                                    </div>
                                                </div>
                                                <div class="col-4" style="padding-left: 8px !important;padding-right: 8px !important;">
                                                    <div class="form-group">
                                                        <div class="form-group fg-half">
                                                            <label for="card__zip" class="movbale">Zip Code</label>
                                                            <input id="card__zip" name="zip" class="form-control zip required" type="text" maxlength="10" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-first d-colors" style="border-radius: 8px !important;margin: 15px 0px !important;width: 100%;">Complete The Payment</button>
                                    </div>
                                    <style>
                                        #myModal .modal-header {
                                            border-bottom: none !important;
                                        }
                                        p.modal-title {
                                            font-size: 14px;
                                            font-family: Nunito-Regular;
                                            line-height: 20px;
                                        }
                                        p.ttlamt {
                                            font-size: 26px;
                                            font-family: Avenir-Black;
                                            color: #0088ff;
                                            margin: 0px !important;
                                        }
                                        hr.hr_custom {
                                            margin: 0px;
                                            border-top: 1px solid #e5e5e5;
                                        }
                                        p.signature_text {
                                            color: rgb(105, 105, 105);
                                            font-family: Nunito-Regular;
                                            font-size: 16px;
                                        }
                                        p.terms_policy {
                                            color: rgb(148, 148, 146) !important;
                                            font-size: 12px !important;
                                            font-family: Nunito-Regular;
                                        }
                                        @media screen and (max-width: 700px) {
                                            p.modal-title {
                                                font-size: 12px;
                                            }
                                            p.ttlamt {
                                                font-size: 22px;
                                            }
                                            p.signature_text {
                                                font-size: 14px;
                                            }
                                            p.terms_policy {
                                                font-size: 10px !important;
                                            }
                                        }
                                    </style>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cardsave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right: 0px !important;">
     <div class="modal-dialog" role="document" style="max-width: 460px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none !important;">
                <h5>&nbsp;&nbsp;</h5>
                <button id="card_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="container-fluid text-center" style="height: 300px;">
                    <img style="margin-top: 20px; width: 60px;" src="<?php echo base_url();?>new_assets/img/hand.png">
                    <br><br>
                    <h4>Card Token has been created</h4>
                    <br><br>
                    <h5 style="color: blue;">Have a nice day!</h5>
                </div>
            
            </div>
           <div class="modal-footer text-center">
                
                <button type="button" id="saveTokenBtn" class="btn btn-primary">Save and Continue</button>
          </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>new_assets/js/cp_script_rec.js"></script>
<script src="<?php echo base_url('new_assets/js/cleave.min.js') ?>"></script>

<script>
    
</script>

<script>
//check
$(document).ready(function() {
    var res="Select Date";
    $("select.monthly").change(function(){
        res = $(this).children("option:selected").val();
        
    }); 
    $("#Sun").click(function(){
        $("#weekly").val("Sunday");
        $("#Sun").css("backgroundColor", "#24a0ed");
        $("#Mon").css("backgroundColor", "#6c757d");
        $("#Tue").css("backgroundColor", "#6c757d");
        $("#Wed").css("backgroundColor", "#6c757d");
        $("#Thu").css("backgroundColor", "#6c757d");
        $("#Fri").css("backgroundColor", "#6c757d");
        $("#Sat").css("backgroundColor", "#6c757d");

    });
    $("#Mon").click(function(){
        $("#weekly").val("Monday");
        $("#Mon").css("backgroundColor", "#24a0ed");
        $("#Sun").css("backgroundColor", "#6c757d");
        $("#Tue").css("backgroundColor", "#6c757d");
        $("#Wed").css("backgroundColor", "#6c757d");
        $("#Thu").css("backgroundColor", "#6c757d");
        $("#Fri").css("backgroundColor", "#6c757d");
        $("#Sat").css("backgroundColor", "#6c757d");
    });
    $("#Tue").click(function(){
        $("#weekly").val("Tuesday");
        $("#Tue").css("backgroundColor", "#24a0ed");
        $("#Sun").css("backgroundColor", "#6c757d");
        $("#Mon").css("backgroundColor", "#6c757d");
        $("#Wed").css("backgroundColor", "#6c757d");
        $("#Thu").css("backgroundColor", "#6c757d");
        $("#Fri").css("backgroundColor", "#6c757d");
        $("#Sat").css("backgroundColor", "#6c757d");
    });
    $("#Wed").click(function(){
        $("#weekly").val("Wednesday");
        $("#Wed").css("backgroundColor", "#24a0ed");
        $("#Sun").css("backgroundColor", "#6c757d");
        $("#Mon").css("backgroundColor", "#6c757d");
        $("#Tue").css("backgroundColor", "#6c757d");
        $("#Thu").css("backgroundColor", "#6c757d");
        $("#Fri").css("backgroundColor", "#6c757d");
        $("#Sat").css("backgroundColor", "#6c757d");
    });
    $("#Thu").click(function(){
        $("#weekly").val("Thursday");
        $("#Thu").css("backgroundColor", "#24a0ed");
        $("#Sun").css("backgroundColor", "#6c757d");
        $("#Mon").css("backgroundColor", "#6c757d");
        $("#Tue").css("backgroundColor", "#6c757d");
        $("#Wed").css("backgroundColor", "#6c757d");
        $("#Fri").css("backgroundColor", "#6c757d");
        $("#Sat").css("backgroundColor", "#6c757d");
    });
    $("#Fri").click(function(){
        $("#weekly").val("Friday");
        $("#Fri").css("backgroundColor", "#24a0ed");
        $("#Sun").css("backgroundColor", "#6c757d");
        $("#Mon").css("backgroundColor", "#6c757d");
        $("#Tue").css("backgroundColor", "#6c757d");
        $("#Wed").css("backgroundColor", "#6c757d");
        $("#Thu").css("backgroundColor", "#6c757d");
        $("#Sat").css("backgroundColor", "#6c757d");
    });
    $("#Sat").click(function(){
        $("#weekly").val("Saturday");
        $("#Sat").css("backgroundColor", "#24a0ed");
        $("#Sun").css("backgroundColor", "#6c757d");
        $("#Mon").css("backgroundColor", "#6c757d");
        $("#Tue").css("backgroundColor", "#6c757d");
        $("#Wed").css("backgroundColor", "#6c757d");
        $("#Thu").css("backgroundColor", "#6c757d");
        $("#Fri").css("backgroundColor", "#6c757d");
        
    });

    $(":button").click(function(event){
        if($(this).prop("id") == "saveTokenBtn"){ 
            // window.location.replace('<?php echo base_url('Customer_recurring/'); ?>');
            $('.token_section').removeClass('d-none');
            $('#cardsave').modal('hide');
        }

        if($(this).prop("id") == "daily"){
            $("#recurring_type").val($(this).prop("value"));
            $("#recurring_type_hid").val($(this).prop("value"));
            $('#interval').modal('hide');
  
        } else if($(this).prop("id") == "weekly") {
            if($(this).prop("value")=="") {
                alert("Select a day");
            } else {
                $("#recurring_type").val("Weekly,"+$(this).prop("value"));
                $("#recurring_type_hid").val("Weekly,"+$(this).prop("value"));
                $('#interval').modal('hide');     
                //alert("Weekly,"+$(this).prop("value"));
            }
        
        } else if($(this).prop("id") == "monthlyBtn") {
            if(res=="Select Date") {
                alert("Select a date from drop-down");
            } else {
                $("#recurring_type").val("Monthly,"+res);
                $("#recurring_type_hid").val("Monthly,"+res);
                $('#interval').modal('hide');     
                //alert("Monthly,"+res);
            }
        }
        // else if($(this).prop("id") == ""){
        //  alert($(this).prop("name"));
        // }
    });
});
//check

    //for interval
    $(document).on('click', '#recurring_type', function() {
        // var recurring_type = $('#recurring_type_hid').val();
        // if(recurring_type == '') {
        //     alert('Interval field is required');
        //     return false;
        // }
        $('#interval').modal('show');
    })

    new Cleave('#card__cnumber', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            //console.log(type)
            if(type == 'amex') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'visa') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'diners') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'mastercard') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'jcb') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else if(type == 'discover') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            } else {
                //console.log('else');
                var card_img = '<img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/cardtypelogo.png" style="width: 48px;height: 30px;">';
                //var card_img2 = '';
            }
            // console.log(card_img)
            // console.log(card_img2);
            document.querySelector('.card_type').innerHTML = card_img;
            document.querySelector('.card-type-logo').innerHTML = card_img2;
            document.querySelector('.card-type-logo2').innerHTML = card_img2;
        }
    });

 
    $(document)
    .on('keydown blur','.card-form .required',function(){
        $('.card-form .form-group').removeClass('incorrect');
    })

    $('.d-colors').on('click', function (e) {
        if(allFieldsFilled()) {
            $('.d-colors').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
            var formData1 = $('#my_form').serialize();
            var formData2 = $('#pop_inputs').serialize();

            var formData = formData1+'&'+formData2;
            // console.log(formData);return false;

            $.ajax({
                url: "<?= base_url('AcceptCard/saveCard') ?>",
                type: 'post',
                dataType: 'json',
                data: formData,
                success: function(data1) {
                    if(data1.code=='200') {
                        var msg_data = data1.msg;
                        $('.token_value').html(msg_data.token);
                        $('.new_token_input').val(msg_data.id);
                        $('.card_no_value').html(msg_data.card_no);
                        $('.card_value').html(msg_data.card_type);
                        
                        // console.log(msg_data.card_no);return false;
                        // $('small').html('Success');
                        // window.location.replace('<?php echo base_url('pos/all_customer_request_recurring'); ?>');

                        // $('.token_value').val()

                        $('#AddCard').modal('hide');     
                        $('#cardsave').modal('show');

                    } else {
                        $('.d-colors').html('Complete The Payment');
                        alert(data1.msg);return false;
                        // $('small').html(data1); 
                    }
                    // console.log(data1); 
                },
                error :function() {
                    //alert('error'); 
                    console.log('Error'); 
                }
            });
        }
    })

    function allFieldsFilled(){
      var validation=true;
      $('.card-form .required').each(function(){
        $this=$(this);
          if(!$this.val().length){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('CardNumber') && $this.val().length < 14){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('ddmm') && $this.val().length < 5){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('cvv') && $this.val().length < 3){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          else if($this.hasClass('zip') && $this.val().length < 4){
            validation=false;
            $this.closest('.form-group').addClass('incorrect').find('input').focus();
            // console.log($this.html())
            // console.log(validation)
            // return false;
          }
          if(!validation)
          return validation;
      })
      return validation;
    }

    function validateFormm() {
        var x = document.forms["myFormm"]["s_amount"].value;
        
        if (x == "0.00") {
            alert("Amount Must Be Grater Than Zero");
            return false;

        } else if (x == "0") {
            alert("Amount Must Be Grater Than Zero");
            return false;

        } else if (x == "") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        }
    }


    $(document).on('click', '#show_card_popup', function() {
        var s_name = $('#s_name').val();
        var s_email = $('#s_email').val();
        var s_phone = $('#s_phone').val();
        var money = $('#money').val();

        var recurring_type = $('#recurring_type_hid').val();
        var recurring_count = $('#recurring_count').val();

        if(s_name == '') {
            alert('Name field is required');
            return false;
        }

        if( (s_email == '') && (s_phone == '') ) {
            alert('Enter either Email Address or Mobile Number.');
            return false;
        }

        if (money == "0.00") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        } else if (money == "0") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        } else if (money == "") {
            alert("Amount Must Be Grater Than Zero");
            return false;
        }

        if(recurring_type == '') {
            alert('Interval field is required');
            return false;
        }

        if( ($("#pd__constant").prop('checked') == false) && (recurring_count == '') ) {
            alert('Count field is required');
            return false;
        }

        if( ($("#pt__Auto").prop('checked') == false) && ($("#pt__Manual").prop('checked') == false) ) {
            alert('Type field is required');
            return false;
        }

        $('#AddCard').modal('show');
    })

    $(document).on('click', '#recurring_count', function() {
        $("#pd__constant").prop('checked', false);
    })

    $(document).on('click', '#pd__constant', function() {
        $("#pd__constant").prop('checked', true);
        $('#recurring_count').val('');
    })

    $(document).on('click', '#btn_login', function() {
        if($('#money').val() > 0) {

            var recurring_type = $('#recurring_type_hid').val();
            var recurring_count = $('#recurring_count').val();

            var s_email = $('#s_email').val();
            var s_phone = $('#s_phone').val();

            if(recurring_type == '') {
                alert('Interval field is required');
                return false;
            }

            if( ($("#pd__constant").prop('checked') == false) && (recurring_count == '') ) {
                alert('Count field is required');
                return false;
            }

            if( ($("#pt__Auto").prop('checked') == false) && ($("#pt__Manual").prop('checked') == false) ) {
                alert('Type field is required');
                return false;
            }

            if( (s_email == '') && (s_phone == '') ) {
                alert('Enter either Email Address or Mobile Number.');
                return false;
            }

            $('#s_invoice_loader').removeClass('d-none');
        }
    })
</script>

<div class="row">
   <div class="col-md-12">
      <?php 
         $success=$this->session->userdata('success');
         if($success!="")
         {?>
         <div class="alert alert-success"> <?php echo $success;?> </div>
         <?php }?>

         <?php 
         $failure=$this->session->userdata('failure');
         if($failure!="")
         {?>
         <div class="alert alert-success"> <?php echo $failure;?> </div>
         <?php }?>
   </div>
</div>

<?php include_once'footer_rec_dash.php'; ?>

<script>
    if($('#s_invoiceDueDatePicker').length){
        $("#s_invoiceDueDatePicker").val(moment().format("YYYY-MM-DD"));
        //$("#s_invoiceDueDatePicker").val(moment().substract(1,'Days').format("YYYY-MM-DD"));
        $('#s_invoiceDueDatePicker').daterangepicker({
            minDate: new Date(),
            singleDatePicker: true,
            showDropdowns: true,
            locale: {format: "YYYY-MM-DD"}
        },
        function(start, end, label) {
        });
    }
</script>