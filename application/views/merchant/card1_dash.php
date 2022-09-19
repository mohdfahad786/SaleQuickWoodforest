<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

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
                    <!-- <h4 class="h4-custom">Card Payment</h4> -->
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php
                        echo form_open('pos/card_payment/', array('id' => "my_form",'class' => "row"));
                        echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                        $merchant_name = $this->session->userdata('merchant_name');
                        $names = substr($merchant_name, 0, 3);
                    ?>
                        <div class="grid grid-chart" style="width: 100% !important;">
                            <div class="grid-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="row" style="margin-top: 15px;">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-title">Card Details</div>
                                            <div class="form-group">
                                                <label for="">Amount</label>     
                                                <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" required value="<?php echo  $amount ; ?>" readonly>
                                                <input type="hidden" class="form-control" name="tax" id="tax" required value="<?php echo  $tax ; ?>" readonly>
                                                <?php
                                                    $merchant_id = $this->session->userdata('merchant_id');
                                                    $data = $this->admin_model->data_get_where_1('tax', array('merchant_id' => $merchant_id));
                                                ?>
                                                <?php foreach ($data as $view) { ?>
                                                    <input type="hidden" class="form-control" name="TAX_ID[]" required value="<?php echo $view['id']; ?>" readonly>
                                                    <input type="hidden" class="form-control" name="TAX_PER[]" required value="<?php echo $view['percentage']; ?>" readonly>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Card Holder Name</label>
                                                <input type="text" class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" placeholder="Card Holder Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Card Number</label> 
                                                <input type="text" class="form-control" autocomplete="off" onKeyPress="return isNumberKey(event)" minlength="14" maxlength="16" name="card_no" id="card_no" placeholder="Card Number" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Expiry Month</label>
                                                                <select class="form-control" name="expiry_month" id="expiry_month" required>
                                                                    <option value="">MM</option>
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
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Expiry Year</label>
                                                                <select class="form-control" name="expiry_year" required>
                                                                    <option value="">YY</option>
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
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">CVV</label>
                                                        <input type="text" class="form-control" name="cvv" id="cvv" autocomplete="off" minlength="3" maxlength="3" onKeyPress="return isNumberKey(event)" placeholder="CVV" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-title">General Info</div>
                                                <div class="form-group">
                                                    <label for="">Address</label>
                                                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="">State</label>
                                                            <input type="text" class="form-control" name="state" id="state" pattern="[a-zA-Z\s]+"  placeholder="State" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="">City</label>
                                                            <input type="text" class="form-control" name="city" id="city" pattern="[a-zA-Z\s]+"  placeholder="City" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="">Zip Code</label>
                                                            <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Phone</label>
                                                    <input type="text" class="form-control" placeholder="Phone" name="mobile_no" id="phone">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Email">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px;margin-bottom: 15px;">
                                        <div class="col-12 text-right">
                                            <button id="paymentCheckoutSubmitBtn" type="submit" name="submit" class="btn btn-first" data-dismiss="modal" style="border-radius: 8px !important;">Pay Now</button>
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

<?php include_once'footer_dash.php'; ?>