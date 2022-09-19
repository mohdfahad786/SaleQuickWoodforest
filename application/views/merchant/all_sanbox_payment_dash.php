<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    span.card-type-image {
        display: inline-block;
        max-width: 51px;
        vertical-align: middle;
        margin-left:3px;
    }
    .card-type-no-wraper{
        display: block;
        width: 121px;
    }
    .dataTables_wrapper .dataTables_filter input {
        width: 220px !important;
        height: 45px!important;
        color: #4a4a4a;
        -webkit-box-shadow: 0 0;
        box-shadow: 0 0;
        padding-left: 35px;
        border-color: #e1e6ea;
        font-weight: normal;
        border-radius: 3px;
        background-image: url('<?php echo base_url('new_assets/img/search.svg') ?>');
        background-repeat: no-repeat;
        background-size: 25px;
        background-position: 5px center;
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
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">All Sandbox Payment</h4> -->
                </div>
            </div>

            <?php $count = 0; ?>
            <form class="row" method="post" action="<?php echo base_url('sandbox/all_sandbox_payment');?>" style="margin-bottom: 20px !important;">
                <div class="col-sm-8 col-md-4 col-lg-4" style="margin-left: -10px !important;">
                    <div id="allSAndBoxPay_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;">
                        <span> <?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input  name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>">
                        <input  name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <select class="form-control" name="status" id="status" style="border: none !important;">
                        <option value="">Select Status</option>
                        <?php if(!empty($status) && isset($status)) { ?>
                            <option value="pending" <?php echo (($status == 'pending')?'selected':"") ?>>Pending</option>
                            <option value="confirm" <?php echo (($status == 'confirm')?'selected':"") ?>>Confirm</option>
                        <?php } else { ?>
                            <option value="pending" >Pending</option>
                            <option value="confirm" >Confirm</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <!-- <input type="submit" name="mysubmit" class="btn btn-first" value="Search" /> -->
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Search</button>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="allSandboxPay-dt" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th idth="22%">Invoice</th>
                                <th>Name</th>
                                <th width="22%">Phone</th>
                                <th width="13%">Amount</th>
                                <th width="13%">Status</th>
                                <th width="16%">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($mem as $a_data) {
                                $count++; ?>
                                <tr>
                                    <td><?php echo $a_data['payment_id'] ?></td>
                                    <td><?php echo $a_data['name'] ?></td>
                                    <td><?php echo $a_data['mobile'] ?></td>
                                    <td><span class="status_success">$<?php echo number_format($a_data['amount'],2); ?></td>
                                    <td>
                                        <a href="#" class="<?php if($a_data['status']=='pending'){ echo 'pos_Status_pend';}elseif ($a_data['status']=='confirm'){echo 'pos_Status_c';}elseif ($a_data['status']=='declined'){echo 'pos_Status_cncl';}?>"><?php echo $a_data['status']; ?></a>
                                    </td>
                                    <td><?php echo $a_data['date'] ; ?></td>
                                </tr>
                            <?php $i++;}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once'footer_dash.php'; ?>