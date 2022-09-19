<?php
    include_once'header_dash.php';
    include_once'sidebar_dash.php';
?>

<style>
    label {
        font-weight: 600;
    }
    .modal-body {
        color: black !important;
        font-size: 15px !important;
        font-family: AvenirNext-Medium !important;
    }
    .modal-header {
        border-bottom: 1px solid #fff !important;
    }
    div.dt-buttons {
        display: block !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        width: 250px !important;
        height: 42px!important;
        color: #4a4a4a;
        -webkit-box-shadow: 0 0;
        box-shadow: 0 0;
        padding-right: 35px;
        padding-left: 15px;
        border-color: #e1e6ea;
        font-weight: normal;
        border-radius: 3px;
        background-repeat: no-repeat;
        background-size: 15px;
        background-position: right 15px center;
        border: none;
        border-radius: 5px;
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
                <div class="col-12 py-5-custom"></div>
            </div>

            <form action="<?php echo base_url('Agent/edit_payout_agent'); ?>" id='my_form' method="post" enctype='multipart/form-data' autocomplete="off">
                <div class="row" style="margin-bottom: 20px !important;">
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
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Name</label>
                                                    <input class="form-control" name="name" id="name" pattern="[a-zA-Z\s]+" placeholder="Full Name" value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>" required="" type="text" readonly>

                                                    <input class="form-control" name="bct_id" id="bct_id" value="<?php echo (isset($bct_id) && !empty($bct_id)) ? $bct_id : set_value('bct_id');?>" required="" type="hidden">

                                                    <input class="form-control" name="merchant_id" id="merchant_id" value="<?php echo (isset($merchant_id) && !empty($merchant_id)) ? $merchant_id : set_value('merchant_id');?>" required="" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Email Address <i class="text-danger">*</i></label>
                                                    <input class="form-control" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Phone <i class="text-danger">*</i> </label>
                                                    <input class="form-control" placeholder="Phone" name="mobile" id="mobile" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Year</label>
                                                    <select class="form-control"  name="year" id="year" required="">
                                                        <option value="">Select Year</option>
                                                        <option <?php echo ($year=="2020")?'selected="selected"':''?> value="2020">2020</option>
                                                        <option <?php echo ($year=="2021")?'selected="selected"':''?> value="2021">2021</option>
                                                        <option <?php echo ($year=="2022")?'selected="selected"':''?> value="2022">2022</option>
                                                        <option <?php echo ($year=="2023")?'selected="selected"':''?> value="2023">2023</option>
                                                        <option <?php echo ($year=="2024")?'selected="selected"':''?> value="2024">2024</option>
                                                        <option <?php echo ($year=="2025")?'selected="selected"':''?> value="2025">2025</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Month</label>
                                                    <select class="form-control"  name="month" id="month" required="">
                                                        <option value="">Select Month</option>
                                                        <option <?php echo ($month=="01")?'selected="selected"':''?> value="01">January</option>
                                                        <option <?php echo ($month=="02")?'selected="selected"':''?> value="02">February</option>
                                                        <option <?php echo ($month=="03")?'selected="selected"':''?> value="03">March</option>
                                                        <option <?php echo ($month=="04")?'selected="selected"':''?> value="04">April</option>
                                                        <option <?php echo ($month=="05")?'selected="selected"':''?> value="05">May</option>
                                                        <option <?php echo ($month=="06")?'selected="selected"':''?> value="06">June</option>
                                                        <option <?php echo ($month=="07")?'selected="selected"':''?> value="07">July</option>
                                                        <option <?php echo ($month=="08")?'selected="selected"':''?> value="08">August</option>
                                                        <option <?php echo ($month=="09")?'selected="selected"':''?> value="09">September</option>
                                                        <option <?php echo ($month=="10")?'selected="selected"':''?> value="10">October</option>
                                                        <option <?php echo ($month=="11")?'selected="selected"':''?> value="11">November</option>
                                                        <option <?php echo ($month=="12")?'selected="selected"':''?> value="12">December</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Amount</label>
                                                    <input class="form-control" placeholder="Amount" name="amount" id="amount"  required type="number" value="<?php echo (isset($amount) && !empty($amount)) ? $amount : set_value('amount');?>">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function isNumberKeydc(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

<?php include_once'footer_button_dash.php'; ?>