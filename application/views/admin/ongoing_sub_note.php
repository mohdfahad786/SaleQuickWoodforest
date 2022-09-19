<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<style type="text/css">
    .notes_heading {
        color: #868e96;
        font-family: AvenirNext-Medium;
        font-weight: 600;
    }
    .notes_card {
        border: none !important;
        border-radius: 10px !important;
    }
    .subject_head {
        cursor: pointer;
    } 
    .notes_card_footer {
        background-color: transparent !important;
        border: none !important;
        padding: 25px !important;
        padding-top: 5px !important;
    }
    .note_content {
        min-height: 250px;
    }
    .p_content_style {
        margin-bottom: 5px !important;
        color: #3e3e3e !important;
    }
    .show_attachment {
        font-size: 20px;
    }
    /*expand image style*/
    #attachment_img {
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    #attachment_img:hover {opacity: 0.7;}

    /* The Modal (background) */
    #myModal .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    #myModal .modal-content {
        margin: auto;
        display: block;
        width: auto;
        height: 85vh;
        top: 10px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    #myModal .modal-content, #caption {  
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)} 
        to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
    }

    /* The Close Button */
    #myModal .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    #myModal .close:hover,
    #myModal .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        #myModal .modal-content {
            width: 100%;
        }
    }
    .new_to_old, .old_to_new {
        margin-left: 10px;
        text-transform: none !important;
    }
    .processing_note {
        height: 200px;
        margin: auto;
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
            <!-- <div class="container-fluid " style="background-color:transparent;"> 
                <div class="row">
                    <a href="<?php echo base_url('merchant_document/ongoing_notes/'.$merchant_id)?>" class="btn btn-light" style="border-radius: 20px;padding: 8px 10px;height: 35px;"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div> -->

            <div class="row mt-3 mb-3" style="margin-bottom: 20px;">
                <div class="col-6 text-right" style="display: flex !important;">
                    <!-- <span style="margin-right: 15px;padding: 10px 0;">Sort By</span>
                    <select id="sort_order" class="form-control" style="width: auto !important;">
                        <option value="new_to_old">Newest to Oldest</option>
                        <option value="old_to_new">Oldest to Newest</option>
                    </select> -->
                    <a href="<?php echo base_url('merchant_document/ongoing_notes/'.$merchant_id)?>" class="btn btn-light" style="border-radius: 20px;padding: 8px 10px;height: 35px;"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-primary" href="<?php echo base_url('merchant_document/add_sub_ongoing_note/'.$merchant_id.'/'.$creator_id.'/'.$note_sr_id) ?>" style="padding: 10px 15px;border-radius: 20px;"><i class="fa fa-plus"></i> Add Sub Note </a>
                </div>
            </div>
            
            <div class="notes_section row mt-2 mb-5">
                <?php if($ongoing_notes) {
                    foreach($ongoing_notes as $key => $val) { ?>
                        <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
                            <div class="card notes_card" style="background-color: lightyellow;">
                                <div class="card-body" style="padding: 25px !important;">
                                    <div style="display: flex !important;">
                                        <div style="width: calc(100% - 30px);">
                                            <h5 class="subject_head" data-id="<?php echo $val['id']; ?>" style="font-weight: 600 !important;">Sub Note Of : <?php echo (strlen($val['subject']) > 25) ? substr($val['subject'], 0, 25).'...' : $val['subject']; ?></h5>
                                        </div>
                                       
                                        <div class="dropdown dt-vw-del-dpdwn text-right">
                                                <button type="button" data-toggle="dropdown" aria-expanded="false"> <i class="material-icons"> more_vert </i> </button> 
                                             <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(45px, 31px, 0px);">
                                                    <a href="<?php echo base_url('merchant_document/edit_sub_ongoing_note/'.$merchant_id.'/'.$creator_id.'/'.$val['id'].'/'.$note_sr_id); ?>" title="Edit" class="dropdown-item"><i class="fa fa-pencil"></i>Edit</a>

                                                    <a class="dropdown-item" href="#" onClick="delsubNote(<?php echo $merchant_id.','.$val['id'].','.$creator_id.','.$note_sr_id;?>)"><i class="fa fa-trash"></i> Delete </a>
                                                    <a href="javascript:void(0)" class="pdfModal dropdown-item" data-id="<?php echo $val['id'] ?>"><i class="fa fa-paperclip"></i>Attachment</a>
                                                </div>
                                            </div>
                                        <?php if(!empty($val['attachment'])) {
                                            $ext = pathinfo($val['attachment'], PATHINFO_EXTENSION);
                                            if( ($ext == 'jpg') || ($ext == 'png') ||($ext == 'jpeg') ||($ext == 'gif') ) { ?>
                                                <div class="text-right" style="width: 30px;">
                                                    <a class="attachment_img" href="javascript:void(0)" data-src="<?php echo base_url().'uploads/attachment/'.$val['attachment']; ?>" data-alt="<?php echo $val['attachment']; ?>">
                                                        <i class="fa fa-paperclip"></i>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <div class="text-right" style="width: 30px;">
                                                    <a class="download_doc" href="javascript:void(0)" data-src="<?php echo base_url().'uploads/attachment/'.$val['attachment']; ?>">
                                                        <i class="fa fa-paperclip attachment_doc" data-src="<?php echo base_url().'uploads/attachment/'.$val['attachment']; ?>" data-alt="<?php echo $val['attachment']; ?>"></i>
                                                    </a>
                                                </div>
                                            <?php }
                                        } ?>

                                        <?php if(!empty($val['attachment2'])) {
                                            $ext2 = pathinfo($val['attachment2'], PATHINFO_EXTENSION);
                                            if( ($ext2 == 'jpg') || ($ext2 == 'png') ||($ext2 == 'jpeg') ||($ext2 == 'gif') ) { ?>
                                                <div class="text-right" style="width: 30px;">
                                                    <a class="attachment2_img" href="javascript:void(0)" data-src="<?php echo base_url().'uploads/attachment/'.$val['attachment2']; ?>" data-alt="<?php echo $val['attachment2']; ?>">
                                                        <i class="fa fa-paperclip"></i>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <div class="text-right" style="width: 30px;">
                                                    <a class="download2_doc" href="javascript:void(0)" data-src="<?php echo base_url().'uploads/attachment/'.$val['attachment2']; ?>">
                                                        <i class="fa fa-paperclip attachment2_doc" data-src="<?php echo base_url().'uploads/attachment/'.$val['attachment2']; ?>" data-alt="<?php echo $val['attachment2']; ?>"></i>
                                                    </a>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                    <p class="mb-3"><?php echo date('d F, Y h:i', strtotime($val['created_at'])); ?></p>
                                    <div style="min-height: 42px;">
                                        <p><?php echo (strlen($val['sub_note']) > 60) ? substr($val['sub_note'], 0, 60).'...' : $val['sub_note']; ?></p>
                                    </div>
                                </div>
                                <div class="card-footer notes_card_footer">
                                    <div class="row">
                                        <div class="col-10">By: <strong><?php echo $val['created_by'] ?></strong></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="col-12 text-center">
                        <h4>No sub notes found</h4>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <span class="close previewClose">&times;</span>
    <img class="modal-content" id="expand_image">
    <div id="caption"></div>
</div>

<div id="notes_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <!-- <div class="modal-dialog" style="min-width: 650px;"> -->
    <div class="modal-dialog col-sm-6 col-md-10 col-lg-8">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body custom-form">
                <div class="row">
                    <div class="col-12 note_content" style="">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pdf_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body custom-form">
                <div class="row pdf_section">
                </div>
            </div>
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
    function delsubNote(merchant_id,id,cid,nid) {
        swal({
            title: "<span style='font-size: 21px;'>Alert</span>",
            text: "<span style='font-size: 16px;'>Are you sure to delete this sub note?</span>",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn danger-btn",
            confirmButtonText: "Delete",
            cancelButtonClass: "btn btn-first",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo base_url('merchant_document/delete_sub_ongoing_notes/') ?>/"+merchant_id+'/'+id+'/'+cid+'/'+nid,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        if(data.status == '200'){
                            location.reload();
                        } else {
                            var msg = data.errorMsg;
                           alert(msg);
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

    $(document).on('click', '.subject_head', function() {
        $('#notes_modal').modal('show');
        $('.note_content').html('');
        $('.modal-title').html('');

        var subject_head = $(this).text();

        $('.modal-title').html('Loading');
        var id = $(this).attr('data-id');
        // console.log(id);return false;

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Merchant_document/get_single_ongoing_sub_note'); ?>",
            data: {'id': id},
            success: function (result) {
                var note_content = '';
                var result = JSON.parse(result);
                console.log(result);
                // $('.note_content').html('');
                // $('.note_content').html();
                note_content += '<p class="p_content_style">Created by: <strong>'+result.created_by+'</strong></p>';
                if(result.updated_by) {
                    note_content += '<p class="p_content_style">Updated by: <strong>'+result.updated_by+'</strong></p>';
                }
                note_content += '<p style="color: #3e3e3e !important;">On '+result.updated_at+'</p>';
                note_content += '<p style="margin-top: 20px;color: #3e3e3e !important;">'+result.sub_note+'</p>';

                $('.modal-title').html(subject_head);
                $('.note_content').html(note_content);
            }
        });
    })

    $(document).on('click', '.pdfModal', function() {
        $('#pdf_modal').modal('show');
        $('.pdf_section').html('');
       // $('.modal-title').html('');

        $('.modal-title').html('Attached Files');
        var sid = $(this).attr('data-id');//subnote autogenerated id
        var mid= <?php echo $creator_id;?>; //autogenerated id of merchant_ongoing notes
        // console.log(merchant_id);return false;

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Merchant_document/get_pdf_subnotes/'); ?>"+sid+'/'+mid,
            data: "",
            success: function (result) {
                var note_content = '';
                var result = JSON.parse(result);
                console.log(result);
                var pdf=JSON.parse(result['pdf']);
                for (var i = 0; i < pdf.length; i++){
                     
                        var obj = pdf[i];
                        for (var key in obj){
                            var pdfname = obj[key];
                            console.log(pdfname);
                            var ind=pdfname.indexOf('_');
                            var shortName=pdfname.substring(ind+1,18);
                            var fullName=pdfname.substring(ind+1);
                            console.log(fullName);
                          

                            document.querySelector('.pdf_section').innerHTML='<div class="col-sm-2 "><div class="card notes_card " style="background-color:#EBF5FB; " ><div class="card-body" style="padding: 25px !important; "><div style="display: flex !important;"><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+fullName+'" target="_blank"><img src="<?php echo base_url('new_assets/img/pdf.png'); ?>" style="width: 50px;"></a></div></div></div><div class="card-footer notes_card_footer"><div class="row"><div class="col-10"><strong><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+fullName+'" target="_blank">'+shortName+'</a></strong></div></div></div></div>'+document.querySelector('.pdf_section').innerHTML;
                        }
                }
                
            }
        });
    })

    // $(document).on('change', '#sort_order', function() {
    //     $('.notes_section').empty();
    //     $('.notes_section').html('<div class="processing_note text-center"><p><i class="fa fa-spin fa-spinner"></i> Processing...</p></div>');
    //     // return false;
    //     var merchant_id = "<?php echo $merchant_id; ?>";
    //     var value = $(this).val();
    //     // console.log(value, merchant_id);return false;
    //     var post_data = {
    //         'merchant_id': merchant_id,
    //         'value': value
    //     };

    //     $.ajax({
    //         type: 'POST',
    //         url: "<?php echo base_url('Merchant_document/sorted_ongoing_sub_notes'); ?>",
    //         data: post_data,
    //         success: function (result) {
    //             var result = JSON.parse(result);
    //             if(result.status == 200) {
    //                 // console.log(result);return false;

    //                 $('.notes_section').empty();
    //                 $('.notes_section').html(result.content);
                
    //             } else {
    //                 $('.notes_section').empty();
    //                 $('.notes_section').html('<div class="processing_note text-center"><p>No notes found</p></div>');
    //             }
    //         }
    //     });
    // })
</script>

<script>
    var modalImg = $('#expand_image');
    var captionText = $('#caption');

    $(document).on('click', 'a.attachment2_img', function(e) {
        $('#expand_image').attr('src', $(this).attr('data-src'));
        $('#caption').text($(this).attr('data-alt'));
        $('#myModal').modal('show');
    })

    $(document).on('click', '.previewClose', function(e) {
        $('#myModal').modal('hide');
    })

    $(document).on('click', 'a.download2_doc', function(e) {
        e.preventDefault();
        var download2_doc_path = $(this).attr('data-src');
        // window.location.href = download_doc_path;
        window.open(download2_doc_path, '_blank');
    });
</script>

<script>
    var modalImg = $('#expand_image');
    var captionText = $('#caption');

    $(document).on('click', 'a.attachment_img', function(e) {
        $('#expand_image').attr('src', $(this).attr('data-src'));
        $('#caption').text($(this).attr('data-alt'));
        $('#myModal').modal('show');
    })

    $(document).on('click', '.previewClose', function(e) {
        $('#myModal').modal('hide');
    })

    $(document).on('click', 'a.download_doc', function(e) {
        e.preventDefault();
        var download_doc_path = $(this).attr('data-src');
        // window.location.href = download_doc_path;
        window.open(download_doc_path, '_blank');
    });
</script>

<?php include_once'footer_dash.php'; ?>