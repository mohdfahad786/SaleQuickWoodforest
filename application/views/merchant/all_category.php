<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    /*.action-styling {
        color: black !important;
        text-decoration: underline !important;
    }*/
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
    .btn_custom {
        height: 30px !important;
        max-height: 30px !important;
        padding: 4px 12px !important;
        text-transform: none !important;
        width: 85px !important;
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
                
                <div class="col-12  py-5-custom" >
                    <div class="col-12 text-right" >
                        <a class="add-payment-link" href="<?php echo base_url('inventory/add_category'); ?>"><i class="fa fa-plus"></i> Add Category</a>
                    </div>
                    <div class="col-6 ">
                        <a class="btn btn-second" href="<?php echo base_url('inventory/inventorymngt'); ?>">Back</a>
                    </div>

                
                </div>
            </div>

            <?php $count = 0; ?>
            <div class="row">
                <div class="col-12">
                    <!-- <div class="reset-dataTable"> -->
                        <table id="dt_view_tax_list" class="hover row-border" style="width:100%">


                            <thead>
                                <tr>
                                    <th width="15%">SR NO</th>
                                    <th width="30%">Name</th>
                                    <th width="30%">Code</th>
                                    <th class="no-event" data-priority="1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;
                                foreach($categories as $a_data) {
                                    $count++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucfirst($a_data['name']) ?></td>
                                        <td><?php echo ucfirst($a_data['code']) ?></td>
                                        <td>
                                            <a href="<?php echo site_url('inventory/edit_category/'.$a_data['id']) ?>" class="btn btn-sm btn-secondary btn_custom"><i class="fa fa-pencil"></i> Edit</a>
                                            <a href="#" onClick="del_category(<?php echo $a_data['id'];?>)" class="btn btn-sm btn-danger btn_custom"><i class="fa fa-trash"></i> Delete</a>
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
      
<div class="modal fade" id="message_popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?=base_url('new_assets/css/sweetalert.css')?>">
<script src="<?=base_url('new_assets/js/sweetalert.js')?>"></script>
<style type="text/css">
.sweet-alert .btn {
  padding: 5px 15px;
}
</style>
<script>
    function del_category(id) {
        swal({
            title: "<span style='font-size: 21px;'>Are you sure, want to delete this Category?</span>",
            text: "<span style='font-size: 16px;'>You will not be able to recover this info!</span>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn danger-btn",
            confirmButtonText: "Yes, remove it!",
            cancelButtonClass: "btn btn-first",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo base_url('Inventory/delete_category')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if(data.status == '200'){
                            location.reload();
                        } else {
                            var msg = data.errorMsg;
                            $("#message_popup.modal-body").html(msg);
                            $("#message_popup").modal('show');
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            } else {

            }
        })
    }
</script>

<?php include_once'footer_dash.php'; ?>