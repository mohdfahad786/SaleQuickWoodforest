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
                    <h4 class="h4-custom">View All Employee</h4>
                </div> -->
                <div class="col-12 py-5 py-5-custom text-right">
                    <a class="add-payment-link" href="<?php echo base_url('merchant/add_user'); ?>"><i class="fa fa-plus"></i> Add Employee</a>
                </div>
            </div>

            <?php $count = 0; ?>
            <div class="row">
                <div class="col-12">
                    <!-- <div class="reset-dataTable"> -->
                        <table id="dt_view_tax_list" class="hover row-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="7%">SR NO</th>
                                    <th>Name</th>
                                    <th width="15%">Auth Key</th>
                                    <th width="14%">Phone</th>
                                    <th width="15%">Create Date</th>
                                    <th width="15%">Address</th>
                                    <th width="10%">Status</th>
                                    <th width="5%" class="no-event"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach($mem as $a_data) {
                                    $count++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $a_data['name'] ?></td>
                                        <td><?php echo $a_data['auth_key'] ?></td>
                                        <td><?php echo $a_data['mob_no'] ?></td>
                                        <td><?php echo $a_data['created_on'] ?></td>
                                        <td><?php echo $a_data['address1'] ?></td>
                                        <td>
                                            <a href="#" class="<?php if($a_data['status']=='active') { echo 'pos_Status_c'; } elseif( $a_data['status']=='block'){ echo 'pos_Status_cncl'; } ?>"><?php echo ucfirst($a_data['status']) ?></a>
                                        </td>
                                        <td>
                                            <div class="dropdown dt-vw-del-dpdwn">
                                                <button type="button" data-toggle="dropdown">
                                                    <i class="material-icons"> more_vert </i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item edit_users" href="<?php  echo base_url('merchant/edit_user/' . $a_data['id']) ?>">Edit</a>
                                                    <a class="dropdown-item dt-delete-c-row" onclick="employee_delete(<?php echo $a_data['id'];?>)" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;
                                } ?>
                            </tbody>
                        </table>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function employee_delete(id) {
        if(confirm('Are you sure delete this Employee?')) {
            $.ajax({
                url : "<?php echo base_url('merchant/user_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }
</script>

<?php include_once'footer_dash.php'; ?>