<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    .action-styling {
        color: black !important;
        text-decoration: underline !important;
    }
    .add-payment-link {
        width: auto;
        height: 40px;
        background: rgb(237, 237, 237);
        border: none;
        border-radius: 8px;
        color: rgb(132, 132, 132);
        font-size: 16px;
        font-weight: 400;
        padding: 10px 20px 10px 20px;
        font-family: Avenir-Black !important;
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
                <!-- <div class="col-6 py-5-custom">
                    <h4 class="h4-custom">View Payment Mode List</h4>
                </div> -->
                <div class="col-12 py-5 py-5-custom text-right">
                    <a class="add-payment-link" href="<?php echo base_url('merchant/add_payment_mode'); ?>"><i class="fa fa-plus"></i> Add Payment Type</a>
                </div>
            </div>

            <?php $count = 0; ?>
            <div class="row">
                <div class="col-12">
                    <!-- <div class="reset-dataTable"> -->
                        <table id="dt_view_tax_list" class="hover row-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-priority="0">SR NO</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th class="no-event"></th>
                                    <th class="no-event" data-priority="1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;
                                foreach($mem as $a_data) {
                                    $count++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucfirst($a_data['name']) ?></td>
                                        <td>
                                            <a href="#" class="<?php if($a_data['status']=='1') { echo 'pos_Status_c'; } elseif( $a_data['status']=='0'){ echo 'pos_Status_cncl'; } ?>"><?php if($a_data['status']=='1') { echo 'Active';} if($a_data['status']=='0') { echo 'Block';}   ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('merchant/edit_payment_mode/'.$a_data['id']) ?>" class="tax-edit-btn action-styling">Edit</a>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url('merchant/delete_payment_mode/'.$a_data['id']) ?>" class="tax-edit-btn action-styling">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $i++;
                                }?>
                            </tbody>
                        </table>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once'footer_dash.php'; ?>