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
    .start_stop_show_inv {
        max-width: 121px;
        margin: 0 auto;
    }
    .start_stop_show_inv .switch.switch_type1 {
        margin: 0 15px 0 0;
    }
    .start_stop_show_inv .switch__label {
        color: #fff;
        line-height: 25px;
        padding-left: 7px;
    }
    .start_stop_show_inv .msg {
        color: #000 !important;
    }
    .start_stop_show_inv.active .stop {
        display: initial;
    }
    .start_stop_show_inv.active .start {
        display: none;
    }
    .start_stop_show_inv:not(.active) .stop {
        display: none;
    }
    .start_stop_show_inv:not(.active) .start {
        display: initial;
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
                    <a class="add-payment-link" href="<?php echo base_url('merchant/add_employee'); ?>"><i class="fa fa-plus"></i> Add Employee</a>
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
                                    <th width="16%">Email</th>
                                    <th width="12%">Phone</th>
                                    <th width="12%">Show Inv On App</th>
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
                                        <td><?php echo $a_data['email'] ?></td>
                                        <td><?php echo $a_data['mob_no'] ?></td>
                                        <td>
                                            <?php 
                                                $show_inv_status = ($a_data['show_inventory'] == 1) ? 'active' : '';
                                                $show_inv_checked = ($a_data['show_inventory'] == 1) ? 'checked' : '';
                                            ?>
                                            <span class="start_stop_show_inv <?php echo $show_inv_status ?>" rel="238"><label class="switch switch_type1" role="switch" style="z-index: 0 !important;"><input type="checkbox" class="switch__toggle" <?php echo $show_inv_checked ?> id="switchval_<?php echo $a_data['id']; ?>" value="<?php echo $a_data['id']; ?>"><span class="switch__label">|</span></label><span class="msg"><span class="stop">Off</span><span class="start">On</span></span></span>
                                        </td>
                                        <td>
                                            <a href="#" class="<?php if($a_data['status']=='active') { echo 'pos_Status_c'; } elseif( $a_data['status']=='block'){ echo 'pos_Status_cncl'; } ?>"><?php echo ucfirst($a_data['status']) ?></a>
                                        </td>
                                        <td>
                                            <div class="dropdown dt-vw-del-dpdwn">
                                                <button type="button" data-toggle="dropdown">
                                                    <i class="material-icons"> more_vert </i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item edit_users" href="<?php  echo base_url('merchant/edit_employee/' . $a_data['id']) ?>">Edit</a>
                                                    <a class="dropdown-item dt-delete-c-row" href="#" onclick="employee_delete(<?php echo $a_data['id'];?>)">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $i++;}?>
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
                url : "<?php echo base_url('merchant/employee_delete')?>/"+id,
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

    $(document).on('change','.start_stop_show_inv input[type="checkbox"]', function (e) {
        // stop - start ShowInv
        e.preventDefault();
        var m=$(this).val(); 
        var ShowInv=$(this).is(':checked');
        //alert(ShowInv); 
        $.ajax({
            url: "<?php  echo base_url('merchant/updateShowInvStatus'); ?>",
            type: 'POST',
            data: {id:m,ShowInv:ShowInv}
            //dataType: 'html'
        })
        .done(function(data){
            console.log(data);  
            if(data=='200'){
            }
        })
        .fail(function(){
            console.log(data); 
        });

        if($(this).is(':checked')){
            $(this).closest('.start_stop_show_inv').addClass('active');
        } else {
            $(this).closest('.start_stop_show_inv').removeClass('active');
        }
    })
</script>

<?php include_once'footer_dash.php'; ?>