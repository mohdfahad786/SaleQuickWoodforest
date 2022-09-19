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
                    <!-- <h4 class="h4-custom">View All Straight Payment Request</h4> -->
                </div>
            </div>

            <?php $count = 0; ?>
            <form class="row" method="post" action="<?php echo base_url('merchant/all_straight_request');?>" style="margin-bottom: 20px !important;">

                <div class="col-sm-8 col-md-4 col-lg-4" style="margin-left: -10px !important;">
                    <div id="inv_pos_list_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                        <input name="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <select class="form-control" name="status" id="status" style="border: none !important;">
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirm">Confirm</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Search</button>
                </div>
            </form>
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <table id="dt_inv_pos_sale_list" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th width="5%" class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($mem as $a_data) {
                                $count++; ?>
                                <tr>
                                    <td style="display: none;"> <?php echo $i; ?></td>
                                    <td><?php echo $a_data['payment_id'] ?></td>
                                    <td><?php echo $a_data['name'] ?></td>
                                    <td><?php echo $a_data['mobile'] ?></td>
                                    <td><span class="status_success">$<?php echo number_format($a_data['amount'],2); ?></span></td>
                                    <td>
                                    <?php
                                        if($a_data['status']=='pending'){
                                            echo '<span class="pos_Status_pend">'.ucfirst($a_data['status']).'</span>';
                                        } elseif ($a_data['status']=='confirm') {
                                            echo '<span class="pos_Status_c">'.ucfirst($a_data['status']).'</span>';
                                        }
                                    ?>
                                    </td>
                                    <td><?php echo $a_data['due_date']; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id'];  ?>" id="getUser" class="btn btn-sm btn-info"><i class=" ti-eye "></i>  View</button>
                                    </td>
                                </tr>
                                <?php $i++;
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once'footer_dash.php'; ?>