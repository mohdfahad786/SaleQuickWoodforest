<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
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
    #drop_file_zone {
        background-color: #EEE;
        border: #999 5px dashed;
        width: 290px;
        height: 200px;
        padding: 8px;
        font-size: 18px;
        margin: auto;
        margin-bottom: 20px;
    }
    #drag_upload_file {
        width:50%;
        margin:0 auto;
    }
    #drag_upload_file p {
        text-align: center;
    }
    #drag_upload_file #selectfile {
        display: none;
    }
    .modal-body {
        font-size: 15px !important;
        padding: 15px 22px !important;
        font-family: AvenirNext-Medium !important;
    }
    .label_data {
        width: calc(100% - 40px) !important;
        display: inline-block !important;
    }
    .edit_single_label {
        padding: 4px 7px !important;
        height: 28px !important;
        max-height: 28px !important;
        border-radius: 20px;
        margin-right: 10px;
    }
    .edit_single_label i, #view_pdf i {
        font-size: 14px !important;
    }
    #view_pdf, .delete_pdf {
        height: 35px !important;
        max-height: 35px !important;
        padding: 8px 10px !important;
        border-radius: 20px;
        margin-right: 10px;
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
            
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto;">
                    <div class="grid grid-chart" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="form-title" style="margin: auto !important; margin-bottom: 20px !important;">Upload PDF for '<?php echo !empty($merchant->business_dba_name) ? $merchant->business_dba_name : $merchant->email; ?>'</div>
                                <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
                                    <div id="drag_upload_file">
                                        <p>Drop file here</p>
                                        <p>or</p>
                                        <p><input type="button" value="Select File" onclick="file_explorer();"></p>
                                        <input type="file" id="selectfile">
                                    </div>
                                </div>
                                <div class="progress" style="width: 290px;margin: auto;">
                                    <div class="progress-bar"></div>
                                </div>
                                <div id="uploadStatus" style="width: 290px;margin: auto;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-12 col-lg-12">
                    <div class="grid grid-chart" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                                <div class="form-title">All PDFs</div>
                                <table id="ongoing_notes_table" class="hover row-border pos-list-dtable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- <th>Document</th> -->
                                            <th>Label</th>
                                            <th>Created By</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($all_pdfs) {
                                            foreach($all_pdfs as $key => $val) {
                                                if($val['via'] == 'merchant_document') { ?>
                                                    <tr>
                                                        
                                                        <td>
                                                            <div style="width: 100%;">
                                                                <div class="label_data"><?php echo $val['pdf_label']; ?></div>
                                                                <div class="text-right" style="display: inline !important;">
                                                                    <button type="button" data-id="<?php echo $val['id']; ?>" class="btn btn-sm btn-primary edit_single_label" title="Edit">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $val['created_by'] ?></td>
                                                        <td><?php echo date("d F Y H:i:s", strtotime($val['updated_at'])); ?></td>
                                                        <td>
                                                            <a id="view_pdf" target="_blank" href="<?php echo base_url().'uploads/attachment/'.$val['file_name']; ?>" title="View" class="btn btn-sm btn-warning">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <button type="button" data-id="<?php echo $val['id']; ?>" title="Delete" class="btn btn-sm btn-danger delete_pdf"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>

                                                <?php } else { ?>
                                                    <!-- <tr>
                                                        <td><?php echo $val['pdf_label']; ?></td>
                                                        <td><?php echo $val['created_by'] ?></td>
                                                        <td><?php echo date("d F Y H:i:s", strtotime($val['updated_at'])); ?></td>
                                                        <td>
                                                            <a id="view_pdf" target="_blank" href="<?php echo base_url().'Merchant_document/pdf_document/'.$val['id'].'/'.$val['file_name']; ?>" title="View" class="btn btn-sm btn-warning"><i class="fa fa-eye" style="padding: 3px 0px !important;"></i></a>
                                                        </td>
                                                    </tr> -->
                                                    <tr>
                                                        
                                                        <td>Sub Merchant Agreement</td>
                                                        <td><?php echo $val['created_by'] ?></td>
                                                        <td><?php echo date("d F Y H:i:s", strtotime($val['updated_at'])); ?></td>
                                                        <td>
                                                            <a id="view_pdf" target="_blank" href="<?php echo base_url().'Merchant_document/sub_merchant_agreement/'.$val['id'].'/'.$val['file_name1']; ?>" title="View" class="btn btn-sm btn-warning"><i class="fa fa-eye" style="padding: 3px 0px !important;"></i></a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        
                                                        <td>Privacy Policy</td>
                                                        <td><?php echo $val['created_by'] ?></td>
                                                        <td><?php echo date("d F Y H:i:s", strtotime($val['updated_at'])); ?></td>
                                                        <td>
                                                            <a id="view_pdf" target="_blank" href="<?php echo base_url().'Merchant_document/terms_and_conditions/'.$val['id'].'/'.$val['file_name2']; ?>" title="View" class="btn btn-sm btn-warning"><i class="fa fa-eye" style="padding: 3px 0px !important;"></i></a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        
                                                        <td>Terms & Conditions</td>
                                                        <td><?php echo $val['created_by'] ?></td>
                                                        <td><?php echo date("d F Y H:i:s", strtotime($val['updated_at'])); ?></td>
                                                        <td>
                                                            <a id="view_pdf" target="_blank" href="<?php echo base_url().'Merchant_document/terms_and_conditions/'.$val['id'].'/'.$val['file_name3']; ?>" title="View" class="btn btn-sm btn-warning"><i class="fa fa-eye" style="padding: 3px 0px !important;"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }

                                        } else { ?>
                                            <tr><td colspan="6" style="text-align: center;">No records found</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="message_success_popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pdf_success_message">PDF Upload Successful</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 class="mb-4">Do you want to add label to this pdf?</h4>
                <input type="text" id="pdf_label" class="form-control" value="" placeholder="PDF Label">
                <input type="hidden" id="pdf_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save_pdf_label">Save</button>
                <button type="button" class="btn btn-secondary cancel_pdf_label">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_pdf_label_popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit PDF Label</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="text" id="edit_pdf_label" class="form-control" value="" placeholder="PDF Label">
                <input type="hidden" id="edit_pdf_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary update_pdf_label">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="message_error_popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="pdf_error_message"></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/new_assets/css/sweetalert.css">
<script src="<?php echo base_url(); ?>/new_assets/js/sweetalert.js"></script>

<script>
    var fileobj;
    function upload_file(e) {
        e.preventDefault();
        fileobj = e.dataTransfer.files[0];
        var file_name = fileobj.name;
        var ext = file_name.split('.').pop();
        // console.log(ext);return false;
        if(ext != "pdf"){
            alert('Only PDF file can be uploaded.');
            return false;
        }
        ajax_file_upload(fileobj);
    }
     
    function file_explorer() {
        document.getElementById('selectfile').click();
        document.getElementById('selectfile').onchange = function() {
            fileobj = document.getElementById('selectfile').files[0];
            ajax_file_upload(fileobj);
        };
    }
     
    function ajax_file_upload(file_obj) {
        if(file_obj != undefined) {
            var form_data = new FormData();                  
            form_data.append('file', file_obj);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            $(".progress-bar").width(percentComplete + '%');
                            $(".progress-bar").html(percentComplete+'%');
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                dataType: "json",
                url: "<?php echo base_url('merchant_document/all_upload_pdf_file/'.$merchant_id); ?>",
                contentType: false,
                processData: false,
                data: form_data,
                success:function(response) {
                    if(response.status == 200) {
                        $('.pdf_success_message').empty();
                        $('#pdf_id').val('');
                        $('#pdf_label').val('');
                        $('.pdf_success_message').html('<span style="color: #28a745 !important;"><strong>Success!</strong> '+response.message+'</span>');
                        $('#pdf_id').val(response.row_id);

                        $("#message_success_popup").modal('show');

                    } else if(response.status == 501) {
                        $('.pdf_error_message').empty();
                        $('.pdf_error_message').html('<span style="color: red !important;"><strong>Error!</strong> '+response.message+'</span>');
                        $("#message_error_popup").modal('show');

                    } else {
                        console.log(response);
                    }
                }
            });
        }
    }

    $(document).on('click', '.save_pdf_label', function() {
        var pdf_id = $('#pdf_id').val();
        var pdf_label = $('#pdf_label').val();
        var pdf_label_trim = (pdf_label != '') ? pdf_label.trim() : '';

        if(pdf_label_trim == '') {
            alert('Please enter PDF Label before saving it.');
            return false;

        } else {
            var post_data = {
                'pdf_label': pdf_label_trim,
                'pdf_id': pdf_id
            };

            $.ajax({
                type: 'POST',
                // dataType: "json",
                url: "<?php echo base_url('merchant_document/update_pdf_label'); ?>",
                data: post_data,
                success: function(data) {
                    // console.log(data);
                    if(data == 200) {
                        $('.save_pdf_label').text('Saved');
                        location.reload();

                    } else {
                        alert('Something went wrong. Please try again.');
                        return false;
                    }
                }
            })
        }
    })

    $(document).on('click', '.cancel_pdf_label', function() {
        location.reload();
    })

    $(document).on('click', '.edit_single_label', function() {
        var pdf_id = $(this).attr('data-id');
        // console.log(pdf_id);return false;
        $('#edit_pdf_id').val('');
        $('#edit_pdf_label').val('');
        $('#edit_pdf_id').val(pdf_id);

        $("#edit_pdf_label_popup").modal('show');
    })

    $(document).on('click', '.update_pdf_label', function() {
        var pdf_id = $('#edit_pdf_id').val();
        var pdf_label = $('#edit_pdf_label').val();
        var pdf_label_trim = (pdf_label != '') ? pdf_label.trim() : '';

        if(pdf_label_trim == '') {
            alert('Please enter PDF Label before saving it.');
            return false;

        } else {
            var post_data = {
                'pdf_label': pdf_label_trim,
                'pdf_id': pdf_id
            };

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('merchant_document/update_pdf_label'); ?>",
                data: post_data,
                success: function(data) {
                    // console.log(data);
                    if(data == 200) {
                        $('.update_pdf_label').text('Saved');
                        location.reload();

                    } else {
                        alert('Something went wrong. Please try again.');
                        return false;
                    }
                }
            })
        }
    })

    $(document).on('click', '.delete_pdf', function() {
        var pdf_id = $(this).attr('data-id');

        swal({
            title: '<span class="h4">Do you want to delete this pdf?</span>',
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-first ",
            confirmButtonText: "Delete",
            cancelButtonClass: "btn danger-btn ",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            html: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            // console.log(isConfirm);
            // console.log($('.merchant_delete_pass').val());
            if(isConfirm){
                $.ajax({
                    type: 'GET',
                    url: "<?php echo base_url('merchant_document/delete_pdf'); ?>/"+pdf_id,
                    success: function(data) {
                        // console.log(data);
                        if(data == 200) {
                            location.reload();

                        } else {
                            alert('Something went wrong. Please try again.');
                            return false;
                        }
                    }
                })
            }
        })
    })

    $(document).ready(function() {
        if($('#ongoing_notes_table').length) {
            $('#ongoing_notes_table').DataTable({
                "searching": false,
                "processing": true,
                "dom": 'lBfrtip', 
                "order": [],
                "destroy": true,
                responsive: true,
                language: {
                    oPaginate: {
                        sNext: '<i class="fa fa-angle-right"></i>',
                        sPrevious: '<i class="fa fa-angle-left"></i>',
                        sFirst: '<i class="fa fa-step-backward"></i>',
                        sLast: '<i class="fa fa-step-forward"></i>'
                    }
                }
            });
        }
    })
</script>

<?php include_once'footer_dash.php'; ?>