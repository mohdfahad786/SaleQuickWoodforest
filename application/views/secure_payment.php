<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>:: Payment Link ::</title>
    <link rel="shortcut icon" href="https://salequick.com/merchant-panel/assets/images/favicon_1.ico">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>new_assets/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('new_assets/css/sweetalert.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://salequick.com/front/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="https://salequick.com/merchant-panel/assets/js/masking.js"></script> -->
    <script src="<?php echo base_url('new_assets/js/jquery.inputmask.js');?>" ></script>
    <script src="<?php echo base_url('new_assets/js/sweetalert.js'); ?>"></script>
    <!-- <script src="<?php echo base_url();?>new_assets/js/cp_script_new.js"></script> -->
    <script src="<?php echo base_url();?>new_assets/js/payment_script_link.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>new_assets/css/payment_style_link.css">
    <script src="<?php echo base_url('new_assets/js/cleave.min.js') ?>"></script>
 
    <style>
        .card-inner-sketch {
            background: url("<?= base_url('new_assets/img/credit_card_bg.jpg') ?>");
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div class="loader_wraper_outer">
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
            <form class="cardPaymentFormWrapper" action="<?php echo base_url('pay_now/card_payment') ?>" method="post" style="margin-bottom: 0px !important;">
                <div class="row" style="display: flex !important;margin: 0;">
                    <div class="col-sm-6 col-md-12 col-lg-12 col-xl-6 text-center form_main_section">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="display-avatar">
                                    <?php if($itemm[0]['logo']) { ?>
                                        <img class="invoice-logo" src="<?php echo base_url(); ?>logo/<?php echo $itemm[0]['logo']; ?>" alt="logo">
                                    <?php } else { ?>
                                        <div class="owner-name" style="font-size: 50px !important;">
                                            <?php echo substr($itemm[0]['business_dba_name'],0,1); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <h4><strong style="font-family: 'Nunito-Regular' !important;"><?= $itemm[0]['business_dba_name'] ?></strong></h4>
                                <p style="display: inline-block;color:#666;font-family: 'Nunito-Regular' !important;font-size: 12px;"><?= $itemm[0]['address1'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center" style="margin-top: 10px;border-radius: 15px;">
                                <div class="row" style="display: inline-flex !important;">
                                    <div class="col" style="margin-top: 13px;">
                                        <span class="dollar_section">$</span>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="amount" onkeyup="this.style.width = ((this.value.length + 30) * 8) + 'px';" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" class="form-control text-right" id="money" value="" placeholder="0.00" style="text-align: center !important;height: 80px !important;z-index: 0 !important;width:160px;display: inline;">
                                    </div>
                                </div>

                                <?php
                                $getOtherCharges = $this->db->where('merchant_id', $itemm[0]['id'])->where('status', 'active')->get('other_charges')->row();
                                //echo '<pre>';print_r($getOtherCharges);die;
                                $data['title'] = $getOtherCharges->title ? $getOtherCharges->title : '';
                                $data['percentage'] = $getOtherCharges->percentage ? $getOtherCharges->percentage : '';
                                $data['type'] = $getOtherCharges->type ? $getOtherCharges->type : '';
                                ?>
                                <input class="form-control" name="other_charges_type" id="other_charges_type" type="hidden" value="<?php echo $data['type']; ?>" readonly>

                                <input class="form-control" name="other_charges_title" id="other_charges_title" type="hidden" value="<?php echo $data['title']; ?>" readonly>

                                <input class="form-control"  name="other_charges_value" id="other_charges_value" type="hidden" value="<?php echo $data['percentage']; ?>" readonly>

                                <?php if($data['percentage']!='') { ?>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <div class="checkbox text-center" style="display: inline-block !important;height: 20px !important;margin-top: 0px !important;">
                                                <label style="font-size: 16px;font-weight: 600;">
                                                    <!-- <input type="checkbox" name="carrent_othercharges" id="carrent_othercharges" class="form-check-input" style="margin-top: 2px !important;"> -->
                                                    <?php echo ($data['title']!='') ? $data['title'] : 'Other Charges'; ?> - <?php echo ($data['percentage'] != '') ? $data['percentage'] : '0' ?><?php echo ($data['type'] != '') ? $data['type'] : '$'; ?>, Total - $ <i class="input-frame"></i> <span id="full_amount_span">0.00</span> 
                                                    <input class="form-control" name="other_charges_s" id="other_charges_s" type="hidden" value="" readonly>  
                                                    <input class="form-control" name="other_charges_title" type="hidden" value="<?php echo $data['title']; ?>" readonly>
                                                    <input class="form-control" name="full_amount" id="full_amount" type="hidden" value="" readonly>
                                                    <input class="form-control" name="full_amount_amount" id="full_amount_amount" type="hidden" value="" readonly>  
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="email_section">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group" style="margin-bottom: 10px !important;">
                                        <!-- <label for="card__phone" class="movbale">Phone No</label> -->
                                        <input id="card__phone" name="mobile_no" class="form-control custum_input for_selection phone" type="text" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
                                    <div class="form-group">
                                        <!-- <label for="card__email" class="movbale">Email</label> -->
                                        <label for="card__email" class="movbale">-- OR --</label>
                                        <input id="card__email" name="email_id" class="form-control custum_input for_selection" type="email" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
                                    <div class="form-group">
                                        <!-- <label for="card__email" class="movbale">Email</label> -->
                                        <input id="card__reference" name="reference" class="form-control custum_input for_selection" type="text" placeholder="Reference">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn_collapse">Next</button>
                            </div>
                        </div>

                        <div class="row">
                            <!-- <div id="demo" class="collapse"> -->
                            <div id="lower_section" class="d-none">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-left">
                                        <h3 class="form-title" style="margin: 0 0 5px 15px !important;">Add Payment Method</h3>
                                    </div>
                                </div>

                                <div class="row" style="margin: 0 !important;">
                                    <div class="col-sm-6 col-md-12 col-lg-12 col-xl-6 card-inner-boxes">
                                        
                                    </div>
                                </div>

                                <div class="row hide_show">
                                    <div class="card-placeholder">
                                        <div class="card-inner-sketch">
                                            <div class="col-12">
                                                <div class="row" style="margin: 0px;display: block !important;">
                                                    <div class="mycl-wrapper responsive-cols flex-row">
                                                        <div class="col-6" style="padding: 0px !important;">
                                                            <div class="chip-logo">
                                                                <img src="https://salequick.com/new_assets/img/chip.png">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 text-right" style="padding: 0px !important;">
                                                            <div class="card-type-logo" style="display: inline-flex !important;">
                                                                <!-- <img src="<?php echo base_url() ?>new_assets/img/blank_card.png"> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 0px;">
                                                    <p class="c__val card__no"><span>****</span><span>****</span><span>****</span><span id="card_last_four">----</span></p>
                                                </div>

                                                <div class="mycl-wrapper row" style="margin: 0 !important;display: flex;">
                                                    <div class="col-6" style="margin: 0 !important;max-width: 40px !important;">
                                                        <p style="line-height: 5px !important;color: #fff !important;font-size: 8px !important;">VALID</p>
                                                        <p style="line-height: 5px !important;color: #fff !important;font-size: 8px !important;">THRU</p>
                                                    </div>
                                                    <div class="col-6" style="margin: 0 !important;">
                                                        <div class="flex-col">
                                                            <p class="c__val" style="margin-bottom: 5px !important;"><span class="card_exp_mm">--</span> <span>/</span> <span class="card_exp_yy">--</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row text-left" style="margin-left: 8px !important;">
                                                    <p class="c__val nameonc" style="margin: 0px !important;">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hide_show">
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-left">
                                        <div class="form_right_section">
                                            <div class="row" style="padding: 15px 15px 0 15px;">
                                                <div class="pay-detail" style="display: inline-block !important;width: 100%;">
                                                    <input id="merchant_id_val" name="merchant_id" class="form-control required" type="hidden" value="<?php echo $itemm[0]['id']; ?>" >
                                                    <input id="merchant_key_val" name="merchant_key" class="form-control required" type="hidden" value="<?php echo $itemm[0]['merchant_key']; ?>">
                                                    <div class="form-group">
                                                        <label for="card__cnumber" class="movbale">Card Number*</label>
                                                        <div class="input-group" style="height: 30px !important;">
                                                            <input id="card__cnumber" name="card_no" class="form-control custum_input for_selection CardNumber" type="text" minlength="14">
                                                            <input type="hidden" id="card_no_type" name="card_type" value="">
                                                            <div class="input-group-addon" style="border: transparent !important;background-color: #fff !important;border-radius: 0 !important;">
                                                                <span class="input-group-text card_type">
                                                                    <img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 27px;">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="card__nameoncard" class="movbale">Card Holder Name*</label>
                                                        <input id="card__nameoncard" name="name_card" class="form-control custum_input for_selection" type="text">
                                                    </div>
                                                    <div class="mycl-wrapper responsive-cols flex-row">
                                                        <div class="flex-col" style="padding-left: 0 !important;">
                                                            <div class="form-group fg-half">
                                                                <?php
                                                                $currYr=date('Y');
                                                                // $newArray=date('Y');
                                                                $LastYr=$currYr + 20;
                                                                $yeardata=array();
                                                                for ($i=$currYr; $i < $LastYr; $i++) { 
                                                                    array_push($yeardata,substr($i, 2,2));
                                                                } ?>
                                                                <label for="card__validutil" class="movbale">Expiry Date*</label>
                                                                <input autocomplete="off" id="card__validutil" data-yr='<?php echo json_encode($yeardata);?>' name="exp_month" placeholder="MM/YY" class="form-control custum_input for_selection ddmm" type="text" maxlength="5">
                                                            </div>
                                                        </div>
                                                        <div class="flex-col">
                                                            <div class="form-group fg-half">
                                                                <label for="card__cvv" class="movbale">CVV/CVC*</label>
                                                                <input id="card__cvv" class="form-control custum_input for_selection cvv" type="text" name="cvv" maxlength="4">
                                                            </div>
                                                        </div>
                                                        <div class="flex-col" style="padding-right: 0 !important;">
                                                            <div class="form-group fg-half">
                                                                <input type="hidden" id="isVerified" name="isVerified" value="no">
                                                                <input type="hidden" id="token" name="token" value="no">
                                                                <label for="card__zip" class="movbale zipcode_label">Zip Code* <i class="fa fa-question-circle" style="color: #e0e9fa;background-color: #3f78e0;border-radius: 50%;margin-left: 20px;"></i></label>
                                                                <input id="card__zip" name="zip" class="form-control custum_input for_selection zip" type="text" maxlength="10">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="card__id" value="">
                                                    <input type="hidden" id="token_id" name="token_id" value="">
                                                    <!-- <div class="form-group">
                                                        <button type="submit" id="submit_btn" class="btn btn-first" data-val="" style="width: 100%;border-radius: 5px;">Submit</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if($itemm[0]['isBilling'] == 1) { ?>
                                    <div class="row hide_show">
                                        <div class="col-sm-12 col-md-12 col-lg-12 text-left">
                                            <h3 class="form-title" style="margin: 0 0 5px 15px !important;">Add Billing Address</h3>
                                        </div>
                                    </div>

                                    <div class="row hide_show">
                                        <div class="col-sm-12 col-md-12 col-lg-12 text-left">
                                            <div class="form_right_section">
                                                <div class="row" style="padding: 5px 15px 0 15px;">
                                                    <div class="bill-address">
                                                        <div class="form-group">
                                                            <label for="card__address" class="movbale">Address*</label>
                                                            <input id="card__address" name="address" class="form-control custum_input for_selection required" type="text">
                                                        </div>

                                                        <div class="mycl-wrapper responsive-cols flex-row" style="margin-bottom: 0px !important;">
                                                            <div class="flex-col" style="padding-left: 0 !important;">
                                                                <div class="form-group fg-half" style="margin-bottom: 0 !important;">
                                                                    <label for="card__city" class="movbale">City*</label>
                                                                    <input id="card__city" name="city" class="form-control custum_input for_selection required" type="text" style="height: 35px !important;">
                                                                </div>
                                                            </div>
                                                            <div class="flex-col" style="padding-right: 0 !important;">
                                                                <div class="form-group fg-half ui-widget" style="margin-bottom: 0 !important;">
                                                                    <label for="card__state" class="movbale">State*</label>
                                                                    <input id="card__state" name="card__state" autocomplete="off" class="form-control custum_input for_selection required" type="text">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="row hide_show">
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-left">
                                        <div class="form_right_section">
                                            <div class="row" style="padding: 15px 15px 0 15px;">
                                                <div class="form-group">
                                                    <button type="submit" id="submit_btn" class="btn btn-first" data-val="" data-token="no" style="width: 100%;border-radius: 5px;">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_error" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-top: 0 !important;">
                <p class="modal_error_msg"></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_zip" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 20px !important;">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <!-- <p class="modal-title">Amount payable is</p> -->
                <!-- <p class="ttlamt"></p> -->
                <!-- <hr class="hr_custom"> -->
            </div>
            <style>
                .signatureMsg {
                    margin-top: 10px !important;
                }
                .popup_para {
                    line-height: 25px !important;
                    font-family: Nunito-Regular;
                }
                .popup_para span {
                    color: #0088ff;
                }
            </style>

            <form action="<?php echo base_url('pay_now/card_payment') ?>" method="post">
                <div class="modal-body" style="padding-top: 5px !important;">
                    <div class="verify_phone_on_cp">
                        <p class="popup_para">Use my <span class="card_val_name"></span> card ending at <span class="card_val_no"></span> for amount <span class="for_amount"></span>. Please verify zipcode.</p>
                        <div class="input-group" style="width: 100%;display: inline-flex !important;">
                            <input class="form-control confirm_zip" placeholder="Zipcode" id="confirm_zip" maxlength="10" minlength="5" value="" type="text" aria-describedby="basic-addon1" style="border-radius: 5px !important;">

                            <input id="amount_nn" type="hidden" name="amount" value="">
                            <input id="full_amount_nn" type="hidden" name="full_amount" value="">
                            <input id="full_amount_amount_nn" type="hidden" name="full_amount_amount" value="">
                            <input id="other_charges_title_nn" type="hidden" name="other_charges_title" value="">
                            <input id="other_charges_s_nn" type="hidden" name="other_charges_s" value="">

                            <input id="mobile_no_nn" type="hidden" name="mobile_no" value="">
                            <input id="email_id_nn" type="hidden" name="email_id" value="">
                            <input id="reference_nn" type="hidden" name="reference" value="">
                            <input id="card_no_nn" type="hidden" name="card_no" value="">
                            <input id="card_type_nn" type="hidden" name="card_type" value="">
                            
                            <input id="name_nn" type="hidden" name="name" value="">
                            <input id="cvv_nn" type="hidden" name="cvv" value="">
                            <input id="zip_nn" type="hidden" name="zip" value="">

                            <input id="merchant_id_nn" type="hidden" name="merchant_id" value="">
                            <input id="merchant_key_nn" type="hidden" name="merchant_key" value="">
                            <input id="token_status_nn" type="hidden" name="token_status" value="">
                            <input type="hidden" id="token_id_nn" name="token_id" value="">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default nextStp_to_sign" style="border-radius: 20px;width: 145px;">Complete Payment</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://salequick.com/new_assets/js/jquery.maskMoney.min.js" type="text/javascript"></script>
<link href='<?php echo base_url('new_assets/css/jquery-ui.css'); ?>' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url('new_assets/js/jquery-ui.js'); ?>' type='text/javascript'></script>

<script>
    new Cleave('#card__cnumber', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            //console.log(type)
            if(type == 'amex') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                var card_type = type;
            } else if(type == 'visa') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                var card_type = type;
            } else if(type == 'diners') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                var card_type = type;
            } else if( (type == 'mastercard') || (type == 'Mastercard') ) {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                var card_type = type;
            } else if(type == 'jcb') {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                var card_type = type;
            } else if( (type == 'discover') || (type == 'Discover') ) {
                var card_img = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 35px;">';
                var card_img2 = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
                var card_type = type;
            } else {
                //console.log('else');
                var card_img = '<img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">';
                // var card_img2 = '<img src="https://salequick.com/new_assets/img/blank_card.png" style="width: 48px;height: 30px;">';
                var card_img2 = '';
                //var card_img2 = '';
                var card_type = type;
            }
            // console.log(card_type);
            document.querySelector('.card_type').innerHTML = card_img;
            document.querySelector('.card-type-logo').innerHTML = card_img2;
            document.querySelector('#card_no_type').value = card_type;
        }
    });

    var isBilling = "<?php echo $itemm[0]['isBilling']; ?>";
    var isReferenceRequired = "<?php echo $itemm[0]['isReferenceRequired']; ?>";

    $(document)
    .on('keydown blur','.card-form .required',function(){
        $('.card-form .form-group').removeClass('incorrect');
    })
    .on('click', '.btn_collapse', function() {
        var money = $('#money').val();
        var phone = $('#card__phone').val();
        var email = $('#card__email').val();
        var reference = $('#card__reference').val();

        var error_msg = '';
        if((money == '') || (money == '0') || (money == '0.00')) {
            var error_msg = 'Amount must be greater than zero';
        }

        if((phone == '') && (email == '')) {
            var error_msg = 'Please enter a valid phone number or email address to proceed with your payment';
        }

        if(isReferenceRequired == 1) {
            if(reference == '') {
                var error_msg = 'Reference field is required';
            }
        }

        if(error_msg == '') {
            $('#lower_section').removeClass('d-none');
            $(this).parent().parent().remove();
            var submit_btn_val = $('#submit_btn').attr('data-token');
            if(submit_btn_val == 'yes') {
                $('.hide_show').css('display','none');
            }

        } else {
            $('.modal_error_msg').empty();
            $('.modal_error_msg').html(error_msg);
            $('#modal_error').modal('show');
            return false;
        }
    })
    .on('click', '#submit_btn', function() {
        var money = $('#money').val();
        var phone = $('#card__phone').val();
        var email = $('#card__email').val();

        var error_msg = '';
        if((money == '') || (money == '0') || (money == '0.00')) {
            var error_msg = 'Amount must be greater than zero';
        }

        if((phone == '') && (email == '')) {
            var error_msg = 'Please enter a valid phone number or email address to proceed with your payment';
        }

        if(error_msg == '') {
            var card__id = $('#card__id').val();
            var isVerified = $('#isVerified').val();
            var confirm_zip = $('#card__zip').val();
            var submit_btn_val = $('#submit_btn').attr('data-val');

            var card__cnumber = $('#card__cnumber').val();
            var card__nameoncard = $('#card__nameoncard').val();
            var card__validutil = $('#card__validutil').val();
            var card__cvv = $('#card__cvv').val();
            var card__zip = $('#card__zip').val();

            if(submit_btn_val == 'zip') {
                // $('.ttlamt').html('$ '+money);
                // $('#myModal_zip').modal('show');

            } else {
                if( (card__cnumber -= '') || (card__nameoncard == '') || (card__validutil == '') || (card__cvv == '') || (card__zip == '') ) {
                    $('.modal_error_msg').empty();
                    $('.modal_error_msg').text('All fields are required.');
                    $('#modal_error').modal('show');
                    return false;
                }
            }

        } else {
            $('.modal_error_msg').empty();
            $('.modal_error_msg').html(error_msg);
            $('#modal_error').modal('show');
            return false;
        }
    })

    $(document).on('click', '.nextStp_to_sign', function() {
        var confirm_zip = $('.confirm_zip').val();
        var card__id = $('#card__id').val();
        var checked_card_id = card__id;
        var isVerified = $('#isVerified').val();

        $('.signatureMsg').remove();

        if(confirm_zip == '') {
            $('#myModal_zip .modal-header').append('<p class="alert alert-danger signatureMsg">Invalid Zipcode</p>');
            return false;

        } else {
            if(isVerified == 'no') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('pay_now/verify_zipcode')?>",
                    data:{'confirm_zip':confirm_zip, 'checked_card_id':checked_card_id},
                    success: function(response) {
                        //console.log(response);
                        if (response != '') {
                            if (response == confirm_zip) {
                                var amount = $('#money').val();
                                var full_amount = $('#full_amount').val();
                                var full_amount_amount = $('#full_amount_amount').val();
                                var other_charges_title = $('#other_charges_title').val();
                                var other_charges_s = $('#other_charges_s').val();
                                var card__phone = $('#card__phone').val();
                                var card__email = $('#card__email').val();
                                var card_no_type = $('#card_no_type').val();

                                var card__cnumber = $('#card__cnumber').val();
                                var card__nameoncard = $('#card__nameoncard').val();
                                var card__validutil = $('#card__validutil').val();
                                var card__cvv = $('#card__cvv').val();
                                var card__reference = $('#card__reference').val();

                                var merchant_id_val = $('#merchant_id_val').val();
                                var merchant_key_val = $('#merchant_key_val').val();
                                var token = $('#token').val();
                                var token_id = $('#token_id').val();

                                $('#amount_nn').val(amount);
                                $('#full_amount_nn').val(full_amount);
                                $('#sub_total_nn').val(full_amount_amount);
                                $('#other_charges_title_nn').val(other_charges_title);
                                $('#other_charges_s_nn').val(other_charges_s);
                                $('#mobile_no_nn').val(card__phone);
                                $('#email_id_nn').val(card__email);
                                $('#reference_nn').val(card__reference);
                                $('#card_no_nn').val(card__cnumber);
                                $('#card_type_nn').val(card_no_type);
                                $('#name_nn').val(card__nameoncard);
                                $('#cvv_nn').val(card__cvv);
                                $('#zip_nn').val(confirm_zip);
                                $('#merchant_id_nn').val(merchant_id_val);
                                $('#merchant_key_nn').val(merchant_key_val);
                                $('#token_status_nn').val(token);
                                $('#token_id_nn').val(token_id);

                                // $('#myModal_zip .modal-header').append('<p class="alert alert-success signatureMsg">Zipcode Verified.</p>');
                                // $('.nextStp_to_sign').addClass('final_submit');
                                
                                $('#isVerified').val('yes');
                                $('.nextStp_to_sign').attr('data-val','');
                                $('.nextStp_to_sign').text('Complete Payment');
                                $('#token').val('yes');
                                $('.nextStp_to_sign').attr('type','submit');
                                $('body').addClass('loader-active');
                                $('.nextStp_to_sign').trigger( "click" );

                            } else {
                                $('#myModal_zip .modal-header').append('<p class="alert alert-danger signatureMsg">Invalid Zipcode. Try Another.</p>');
                                return false;
                            }
                        }
                    }
                });
            } else {
                $('.nextStp_to_sign').html('<i class="fa fa-spinner fa-spin"></i> Processing');
            }
        }
    })

    function allFieldsFilled(){
        var validation=true;
        $('.card-form .required').each(function(){
            $this=$(this);
            if(!$this.val().length){
                validation=false;
                $this.closest('.form-group').addClass('incorrect').find('input').focus();
            
            } else if($this.hasClass('CardNumber') && $this.val().length < 14) {
                validation=false;
                $this.closest('.form-group').addClass('incorrect').find('input').focus();
          
            } else if($this.hasClass('ddmm') && $this.val().length < 5) {
                validation=false;
                $this.closest('.form-group').addClass('incorrect').find('input').focus();
            
            } else if($this.hasClass('cvv') && $this.val().length < 3) {
                validation=false;
                $this.closest('.form-group').addClass('incorrect').find('input').focus();
            
            } else if($this.hasClass('zip') && $this.val().length < 4) {
                validation=false;
                $this.closest('.form-group').addClass('incorrect').find('input').focus();
            }
            if(!validation)
            return validation;
        })
        return validation;
    }

    $(document).ready(function() {
        $('.cardPaySignModalTglr').on('click', function (e) {
            if(allFieldsFilled()) {
                $('.cardPaySignModalTglr').removeAttr( "type");
                $('.cardPaySignModalTglr').attr('type','submit');
                $('body').addClass('loader-active');
            }
        })
    })

    function isDecimal(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }
    }

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $(function(){
        $(".phone").inputmask({ mask: "(999) 999-9999",clearIncomplete: true });
        $("#card__validutil").inputmask({ mask: "99/99",clearIncomplete: true });
        Inputmask({ regex: "[0-9]{3,4}",clearIncomplete: true}).mask('#card__cvv');
        Inputmask({ regex: "[0-9]{5,10}",clearIncomplete: true}).mask('#card__zip');
        Inputmask({ regex: "[0-9]{5,10}",clearIncomplete: true}).mask('#confirm_zip');
        $('#money').maskMoney();
    })

    $(document).ready(function() {
        $("#money").click(function() {
            $("#full_amount").val();
            $("#full_amount_span").text('0.00');
            //$("#other_amount_span").text();

            $("#carrent_othercharges").prop("checked", false);
        });

        $(document).on('keyup', '#money', function() {
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
        })
    });

    $(document).on('keyup', '#card__phone', function() {
        var phone_formatted = $(this).val();
        var phone = phone_formatted.replace(/[-_ )(]/g,'');
        // console.log(phone, phone.length);
        // console.log(phone.length);

        if(phone.length > 9) {
            // console.log('11');
            $.ajax({
                url: "<?php echo base_url('Pay_now/searchByPhoneNo');?>",
                type: 'post',
                dataType: "json",
                data: {'phone': phone},
                success: function(data) {
                    // response(data);
                    if(data.status == 200) {
                        var result = data.result;
                        var section1 = '<div class="all_get_saved_cards"><div class="saved_card_head_wrapper"><h3 class="form-title">My Saved Cards</h3></div>';
                        $('#submit_btn').attr('data-token', 'yes');

                        var sectionLoop = '';
                        $.each(result, function( index, val ) {
                            // console.log(index);
                            var card_no = val.card_no;
                            var lastFour = card_no.substr(card_no.length - 4);
                            var card_type = val.card_type;

                            if(card_type == 'Discover') {
                                card_image='discover.png';
                                
                            } else if(card_type == 'Mastercard') {
                                card_image='mastercard.png';
                                
                            } else if(card_type == 'MasterCard') {
                                card_image='mastercard.png';
                                
                            } else if(card_type == 'mc') {
                                card_image='mastercard.png';
                                
                            } else if(card_type == 'Visa') {
                                card_image='visa.png';
                                
                            } else if(card_type == 'visa') {
                                card_image='visa.png';
                                
                            } else if(card_type == 'Jcb') {
                                card_image='jcb.png';
                                
                            } else if(card_type == 'Maestro') {
                                card_image='maestro.png';
                                
                            } else if(card_type == 'Amex') {
                                card_image='amx.png';
                                
                            } else {
                                card_image='cardtypelogo.png';
                            }

                            // isChecked = (index == 0) ? 'checked' : '';
                            sectionLoop += '<div id="card_'+val.id+'" class="card-box get_card_box" data-cardno="'+lastFour+'" data-fullcardno="'+card_no+'" data-expiry="'+val.card_expiry_month+'/'+val.card_expiry_year+'" data-src="https://salequick.com/new_assets/img/'+card_image+'" data-chn="'+val.name+'" data-token="'+val.token+'" data-id="'+val.id+'" data-token="'+val.token+'" data-card_type="'+val.card_type+'" data-mm="'+val.card_expiry_month+'" data-yy="'+val.card_expiry_year+'"><input type="radio" class="radio_select" name="card_selection_radio" value="'+val.token+'" ><div class="card__box __card__box__" style="display: flex;"><div class="card__type"><img src="https://salequick.com/new_assets/img/'+card_image+'"></div><div class="card__no"><span style="font-size: 11px;color: rgb(105, 105, 105);">Ending at</span><br><span class="c_last_2">'+lastFour+'</span></div><span class="remove_card_btn fa fa-trash" onclick="deletecard('+val.id+')"></span></div></div>';
                        })
                        var sectionAdd = '<a href="javascript:void(0)" class="btn btn-first" id="add_new_card"><i class="fa fa-plus"></i> Add New Card</a>';

                        var section2 = '</div>';
                        var content = section1 + sectionLoop + sectionAdd + section2;
                        $('.card-inner-boxes').html(content);

                    } else {
                        $('#submit_btn').attr('data-token', 'no');
                        $('.card-inner-boxes').empty();
                        $('.hide_show').css('display','block');
                    }
                }
            });

        } else {
            // console.log('22');
            $('.card-inner-boxes').empty();
            $('.hide_show').css('display','block');
        }
    })

    $(document).on('click', '#add_new_card', function() {
        $('.hide_show').css('display','inline-block');

        $('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
            $(this).val('').removeAttr('disabled');
        })
        $('.get_card_box').removeAttr('checked');
        $('input[name="card_selection_radio"]').prop('checked', false).removeAttr('disabled');

        $('#submit_btn').attr('data-val', '');
        $('#submit_btn').text('Submit');
        $('#submit_btn').attr('type','submit');

        $('#card_last_four').text('----');
        $('.card_exp_mm').text('--');
        $('.card_exp_yy').text('--');
        $('.nameonc').text('-');
        $('.card-type-logo').empty();
        $('.card_type').html('<img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 27px;">');
    })

    $(document)
    .on('change','input[name="card_selection_radio"]',function(){
        $('.card_type').html('<div style="width: 35px;"></div>')
        var SelectedCard=$('input[name="card_selection_radio"]:checked').closest('.card-box');
        $('.card-inner-sketch .mycl-wrapper .card-type-logo img').attr('src',SelectedCard.data('src'));//card type
        changeCardImageDetail(SelectedCard);
        // console.log('new data');
        var clicked_event = $(this).parent().attr('class');
        //console.log(clicked_event)
        if(clicked_event == 'card-box get_card_box') {

        } else {
            $('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
                $(this).val('').removeAttr('disabled');
            })
        }
    })

    // $(document).ready(function() {
    //     $('.hide_show').css('display','none');
    // })

    $(document).on('click', '.get_card_box', function() {
        $('.hide_show').css('display','none');

        var wrapper = $(this);
        var input_selection = $(this).children('.radio_select');
        $('.get_card_box').removeAttr('checked');
        input_selection.attr('checked', 'checked');

        var cardno = wrapper.attr('data-cardno');
        var fullcardno = wrapper.attr('data-fullcardno');
        var expiry = wrapper.attr('data-expiry');
        var name = wrapper.attr('data-chn');
        var card_id = wrapper.attr('data-id');
        var token = wrapper.attr('data-token');
        var type = wrapper.attr('data-card_type');
        console.log(type)
        // var src = wrapper.attr('data-src');

        $('#card__cnumber').val(fullcardno);
        $('#card__validutil').val(expiry);
        $('#card__nameoncard').val(name);
        $('#card__id').val(card_id);
        $('#token_id').val(token);

        // console.log(type);return false;
        if(type == 'amex') {
            var card_img = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 35px;">';
            var card_img2 = '<img src="https://salequick.com/new_assets/img/card/amex_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            var card_type = type;
            var card_val_name = 'Amex';
        } else if(type == 'visa') {
            var card_img = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 35px;">';
            var card_img2 = '<img src="https://salequick.com/new_assets/img/card/visa_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            var card_type = type;
            var card_val_name = 'Visa';
        } else if(type == 'diners') {
            var card_img = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 35px;">';
            var card_img2 = '<img src="https://salequick.com/new_assets/img/card/diners_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            var card_type = type;
            var card_val_name = 'Diners Club';
        } else if( (type == 'mastercard') || (type == 'Mastercard') ) {
            var card_img = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 35px;">';
            var card_img2 = '<img src="https://salequick.com/new_assets/img/card/master_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            var card_type = type;
            var card_val_name = 'Mastercard';
        } else if(type == 'jcb') {
            var card_img = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 35px;">';
            var card_img2 = '<img src="https://salequick.com/new_assets/img/card/jcb_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            var card_type = type;
            var card_val_name = 'JCB';
        } else if( (type == 'discover') || (type == 'Discover') ) {
            var card_img = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 35px;">';
            var card_img2 = '<img src="https://salequick.com/new_assets/img/card/discover_n.png" style="width: 48px;height: 30px;background-color: #FCB;">';
            var card_type = type;
            var card_val_name = 'Discover';
        } else {
            //console.log('else');
            var card_img = '<img src="https://salequick.com/new_assets/img/card/no_card.png" style="width: 35px;">';
            var card_img2 = '';
            var card_type = type;
            var card_val_name = '';
        }
        // console.log(card_type);
        document.querySelector('.card_type').innerHTML = card_img;
        document.querySelector('.card-type-logo').innerHTML = card_img2;
        document.querySelector('#card_no_type').value = card_type;

        var clicked_event = $(this).attr('class');
        // console.log($(this))
        if(clicked_event == 'card-box get_card_box') {
            $('.pay-detail input.for_selection,.pay-detail select,.bill-address input.for_selection,.bill-address select').each(function(){
                $(this).attr('disabled','disabled');
            })
        } else {
            $('.pay-detail input:not(:hidden),.pay-detail select,.bill-address input:not(:hidden),.bill-address select').each(function(){
                $(this).val('').removeAttr('disabled');
            })
        }
        
        $('#submit_btn').attr('data-val', 'zip');
        $('#submit_btn').text('Verify Zip');
        $('#submit_btn').attr('type','button');

        var other_charges = $('#other_charges_s').val();
        if(other_charges > 0) {
            var money = $('#full_amount').val();
        } else {
            var money = $('#money').val();
        }

        $('.card_val_name').text(card_val_name);
        $('.card_val_no').text(cardno);
        $('.for_amount').text('$'+money);

        // $('.ttlamt').html('$ '+money);
        $('#myModal_zip').modal('show');
    })

    $(document).on('keyup', '#card__email', function() {
        var email = $(this).val();
        // var regex = new RegExp("^[@\s]+$");
        // console.log(email.indexOf('@'));
        if (email.indexOf('@') > -1) {
            // console.log(222);
            $.ajax({
                url: "<?php echo base_url('Pay_now/searchByEmail');?>",
                type: 'post',
                dataType: "json",
                data: {'email': email},
                success: function(data) {
                    // response(data);
                    if(data.status == 200) {
                        var result = data.result;
                        var section1 = '<div class="all_get_saved_cards"><div class="saved_card_head_wrapper"><h3 class="form-title">My Saved Cards</h3></div>';
                        $('#submit_btn').attr('data-token', 'yes');

                        var sectionLoop = '';
                        $.each(result, function( index, val ) {
                            // console.log(index);
                            var card_no = val.card_no;
                            var lastFour = card_no.substr(card_no.length - 4);
                            var card_type = val.card_type;

                            if(card_type == 'Discover') {
                                card_image='discover.png';
                                
                            } else if(card_type == 'Mastercard') {
                                card_image='mastercard.png';
                                
                            } else if(card_type == 'MasterCard') {
                                card_image='mastercard.png';
                                
                            } else if(card_type == 'mc') {
                                card_image='mastercard.png';
                                
                            } else if(card_type == 'Visa') {
                                card_image='visa.png';
                                
                            } else if(card_type == 'visa') {
                                card_image='visa.png';
                                
                            } else if(card_type == 'Jcb') {
                                card_image='jcb.png';
                                
                            } else if(card_type == 'Maestro') {
                                card_image='maestro.png';
                                
                            } else if(card_type == 'Amex') {
                                card_image='amx.png';
                                
                            } else {
                                card_image='cardtypelogo.png';
                            }

                            // isChecked = (index == 0) ? 'checked' : '';
                            sectionLoop += '<div id="card_'+val.id+'" class="card-box get_card_box" data-cardno="'+lastFour+'" data-fullcardno="'+card_no+'" data-expiry="'+val.card_expiry_month+'/'+val.card_expiry_year+'" data-src="https://salequick.com/new_assets/img/'+card_image+'" data-chn="'+val.name+'" data-token="'+val.token+'" data-id="'+val.id+'" data-token="'+val.token+'" data-card_type="'+val.card_type+'" data-mm="'+val.card_expiry_month+'" data-yy="'+val.card_expiry_year+'"><input type="radio" class="radio_select" name="card_selection_radio" value="'+val.token+'" ><div class="card__box __card__box__" style="display: flex;"><div class="card__type"><img src="https://salequick.com/new_assets/img/'+card_image+'"></div><div class="card__no"><span style="font-size: 11px;color: rgb(105, 105, 105);">Ending at</span><br><span class="c_last_2">'+lastFour+'</span></div><span class="remove_card_btn fa fa-trash" onclick="deletecard('+val.id+')"></span></div></div>';
                        })
                        var sectionAdd = '<a href="javascript:void(0)" class="btn btn-first" id="add_new_card"><i class="fa fa-plus"></i> Add New Card</a>';

                        var section2 = '</div>';
                        var content = section1 + sectionLoop + sectionAdd + section2;
                        $('.card-inner-boxes').html(content);

                    } else {
                        $('#submit_btn').attr('data-token', 'no');
                        $('.card-inner-boxes').empty();
                        $('.hide_show').css('display','block');
                    }
                }
            });

        } else {
            $('.card-inner-boxes').empty();
            $('.hide_show').css('display','block');
        }
        // console.log(phone, phone.length);
    })
</script>
</body>
</html>