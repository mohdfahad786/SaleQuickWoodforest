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
        min-height: 85px;
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
    hr {
         -moz-border-bottom-colors: none;
         -moz-border-image: none;
         -moz-border-left-colors: none;
         -moz-border-right-colors: none;
         -moz-border-top-colors: none;
         /*border-color: #EEEEEE -moz-use-text-color #FFFFFF;*/
         border-color: #E9E6E9;
         border-style: solid none;
         border-width: 1px 0;
         margin: 18px 0;
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
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
    .custom_card_header {
        background-color: #EDC41A;
    }
    .custom_card {
        border: 1px solid transparent !important;
        margin-top: 10px;
    }
    .custom_card_header:first-child {
        border-radius: 10px 10px !important;
    }
    .header_btn:not([class*='btn-inverse']):not(.component-flat) {
        box-shadow: 0px 0px 2px 0px transparent !important;
    }
    .card_action {
        color: #000 !important;
        padding-top: 10px;
    }
    .header_btn, .header_btn:hover, .card_action {
        text-decoration: none !important;
    }
    .header_btn span {
        color: #000 !important;
        font-family: 'Avenir-Heavy' !important;
    }
    .custom_body {
        background-color: #FCE0BA !important;
        border-radius: 10px !important;
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
            
            <div class="row mt-3 mb-3">
                <div class="col-6 text-right" style="display: flex !important;">
                    <!-- <span style="margin-right: 15px;padding: 10px 0;">Sort By</span>

                    <select id="sort_order" class="form-control" style="width: auto !important;">
                        <option value="new_to_old">Newest to Oldest</option>
                        <option value="old_to_new">Oldest to Newest</option>
                    </select> -->
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-primary" href="<?php echo base_url('merchant_document/add_ongoing_note/'.$merchant_id) ?>" style="padding: 10px 15px;border-radius: 20px;"><i class="fa fa-plus"></i> Add Note</a>
                </div>
            </div>

            <!-- <div class="notes_section row mt-2 mb-5">
                <?php if($ongoing_notes) {
                    foreach($ongoing_notes as $key => $val) { ?>
                        <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
                            <div class="card notes_card" style="background-color: lightyellow;">
                                <div class="card-body" style="padding: 25px !important;">
                                    <div style="display: flex !important;">
                                        <div style="width: calc(100% - 30px);">
                                            <h5 class="subject_head" data-id="<?php echo $val['id']; ?>" style="font-weight: 600 !important;"><?php echo (strlen($val['subject']) > 25) ? substr($val['subject'], 0, 25).'...' : $val['subject']; ?></h5>
                                        </div>
                                       
                                        <div class="dropdown dt-vw-del-dpdwn text-right">
                                            <button type="button" data-toggle="dropdown" aria-expanded="false"> <i class="material-icons"> more_vert </i> </button> 
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(45px, 31px, 0px);">
                                                <a href="<?php echo base_url('merchant_document/edit_ongoing_notes/'.$merchant_id.'/'.$val['id']); ?>" class="dropdown-item"><i class="fa fa-pencil"></i>Edit</a>
                                               
                                                <a class="dropdown-item" href="#" onClick="delNote(<?php echo $merchant_id.','.$val['id'];?>)"><i class="fa fa-trash"></i> Delete</a>
                                                <a href="javascript:void(0)" class="pdfModal dropdown-item" data-id="<?php echo $val['id'] ?>"><i class="fa fa-paperclip"></i>Attachment</a>

                                                <a href="<?php echo base_url('merchant_document/ongoing_sub_note/'.$merchant_id.'/'.$val['id'].'/'.$val['note_sr_id']); ?>" class="dropdown-item"><i class="fa fa-sticky-note-o"></i> Sub Note</a>
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
                                    <div>
                                        <p style="min-height: 42px;"><?php echo (strlen($val['note']) > 60) ? substr($val['note'], 0, 60).'...' : $val['note']; ?></p>
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
                        <h4>No notes found</h4>
                    </div>
                <?php } ?>
            </div> -->
            <table id="ongoing_notes_table" class="hover row-border pos-list-dtable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Subject</th>
                        <th scope="col">Note</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($ongoing_notes) {
                        foreach($ongoing_notes as $key => $val) { ?>
                            <tr>
                                <td style="font-weight: 600 !important;"><?php echo (strlen($val['subject']) > 25) ? substr($val['subject'], 0, 25).'...' : $val['subject']; ?></td>
                                <td><?php echo (strlen($val['note']) > 60) ? substr($val['note'], 0, 60).'...' : $val['note']; ?></td>
                                <td><strong><?php echo $val['created_by'] ?></strong></td>
                                <td><?php echo date('d F, Y h:i', strtotime($val['created_at'])); ?></td>
                                <td>
                                    <div class="dropdown dt-vw-del-dpdwn ">
                                        <button type="button" data-toggle="dropdown" aria-expanded="false"> <i class="material-icons"> more_vert </i> </button> 
                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(45px, 31px, 0px);">
                                            <a href="javascript:void(0)"  class="dropdown-item subject_head" id="<?php echo base_url('merchant_document/ongoing_sub_note_popup/'.$merchant_id.'/'.$val['id'].'/'.$val['note_sr_id']); ?>" data-id="<?php echo $val['id'] ?>"><i class="fa fa-eye"></i>View</a>

                                            <a href="<?php echo base_url('merchant_document/edit_ongoing_notes/'.$merchant_id.'/'.$val['id']); ?>" class="dropdown-item"><i class="fa fa-pencil"></i>Edit</a>
                                           
                                            <a class="dropdown-item" href="#" onClick="delNote(<?php echo $merchant_id.','.$val['id'];?>)"><i class="fa fa-trash"></i> Delete</a>
                                            <!-- <a href="javascript:void(0)" class="pdfModal dropdown-item" data-id="<?php echo $val['id'] ?>"><i class="fa fa-paperclip"></i>Attachment</a>

                                            <a href="<?php echo base_url('merchant_document/ongoing_sub_note/'.$merchant_id.'/'.$val['id'].'/'.$val['note_sr_id']); ?>" class="dropdown-item"><i class="fa fa-sticky-note-o"></i> Sub Note</a> -->
                                            <a href="<?php echo base_url('merchant_document/add_sub_ongoing_note/'.$merchant_id.'/'.$val['id'].'/'.$val['note_sr_id']); ?>" class="dropdown-item"><i class="fa fa-sticky-note-o"></i> Add Sub Note</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr><td><h4>No notes found</h4></td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <span class="close previewClose">&times;</span>
    <img class="modal-content" id="expand_image">
    <div id="caption"></div>
</div>

<div id="notes_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <!-- <div class="modal-dialog" style="min-width: 650px;"> -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px 20px !important;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body custom-form" style="padding: 20px !important;">
                <div class="row">
                    <div class="col-12 note_content" style="">
                    </div>
                </div>
                <hr size="5px" style="border-width: 0px 0 !important;border-top: 1px solid #E9E6E9 !important;">
                <h4 style="font-family: 'Avenir-Heavy' !important;">Attached Files</h4>    
                <div class="row pdf_section">
                </div>
                <div id="accordion">
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
        console.log(merchant_id);
        console.log(id);
        console.log(cid);
        console.log(nid);
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

    function delNote(merchant_id,id) {
        swal({
            title: "<span style='font-size: 21px;'>Alert</span>",
            text: "<span style='font-size: 16px;'>Are you sure to delete this ongoing note?</span>",
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
                    url : "<?php echo base_url('merchant_document/delete_ongoing_notes/') ?>/"+merchant_id+'/'+id,
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
        $('.modal-title').html('');
        $('.modal-title').html('Loading');

        $('.note_content').html('');
        $('.pdf_section').html('');
        $('#accordion').html('');
        $('#notes_modal').modal('show');

        var id = $(this).attr('data-id');
        // console.log(id);return false;

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Merchant_document/get_single_ongoing_note'); ?>",
            data: {'id': id},
            success: function (result) {
                var note_content = '';
                var result = JSON.parse(result);
                // console.log(result);
                // $('.note_content').html('');
                // $('.note_content').html();
                note_content += '<p style="margin-bottom: 5px !important;color: #3e3e3e !important;"><strong>On '+result.updated_at+',</strong></p>';
                note_content += '<p style="color: #3e3e3e !important;text-align: justify !important;">'+result.note+'</p>';
                note_content += '<p class="p_content_style">Created by: <strong>'+result.created_by+'</strong></p>';
                if(result.updated_by) {
                    note_content += '<p class="p_content_style">Updated by: <strong>'+result.updated_by+'</strong></p>';
                }

                $('.modal-title').html(result.subject);
                $('.note_content').html(note_content);

            }
        });
        var merchant_id= <?php echo $merchant_id ?>;
        // console.log(merchant_id);return false;

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Merchant_document/get_pdf/'); ?>"+id+'/'+merchant_id,
            data: "",
            success: function (result2) {
                // var note_content = '';
                var result2 = JSON.parse(result2);
                var pdf=JSON.parse(result2['pdf']);
                var pdf2=result2['pdf2'];

                var attachment1 = pdf2.attachment1;
                var attachment2 = pdf2.attachment2;
                // console.log(attachment1);return false;

                var pdf_html = '';

                // if( (attachment1 != '') || (attachment1 != 'null') ) {
                if(attachment1) {
                    // console.log('11');return false;
                    var pdfArr1 = attachment1.split(/\.(?=[^\.]+$)/);

                    var format1 = pdfArr1[1];
                    var fileName1 = pdfArr1[0];
                    
                    var shortName1 = fileName1.substr(0, 6) + "..." + format1;

                    pdf_html+='<div class="col-sm-2"><div class="card notes_card " style="background-color:#EBF5FB;"><div class="card-body" style="padding: 25px !important; "><div style="display: flex !important;"><a href="<?php echo base_url('uploads/attachment/') ?>'+attachment1+'" title="'+attachment1+'" target="_blank"><img src="<?php echo base_url('new_assets/img/pdf.png'); ?>" style="width: 50px;"></a></div></div></div><div class="card-footer notes_card_footer" style="padding: 5px 25px !important;"><div class="row"><div><a href="<?php echo base_url('uploads/attachment/') ?>'+attachment1+'" title="'+attachment1+'" target="_blank" style="margin-left:-5px;">'+shortName1+'</a></div></div></div></div>';
                }

                if(attachment2) {
                    var pdfArr2 = attachment2.split(/\.(?=[^\.]+$)/);

                    var format2 = pdfArr2[1];
                    var fileName2 = pdfArr2[0];
                    
                    var shortName2 = fileName2.substr(0, 6) + "..." + format2;

                    pdf_html+='<div class="col-sm-2"><div class="card notes_card " style="background-color:#EBF5FB;"><div class="card-body" style="padding: 25px !important; "><div style="display: flex !important;"><a href="<?php echo base_url('uploads/attachment/') ?>'+attachment2+'" title="'+attachment2+'" target="_blank"><img src="<?php echo base_url('new_assets/img/pdf.png'); ?>" style="width: 50px;"></a></div></div></div><div class="card-footer notes_card_footer" style="padding: 5px 25px !important;"><div class="row"><div><a href="<?php echo base_url('uploads/attachment/') ?>'+attachment2+'" title="'+attachment2+'" target="_blank" style="margin-left:-5px;">'+shortName2+'</a></div></div></div></div>';
                }

                if(pdf.length>0){
                    for (var i = 0; i < pdf.length; i++){
                        var obj = pdf[i];

                        for (var key in obj){
                            var pdfname = obj[key];

                            var pdfArr = pdfname.split(/\.(?=[^\.]+$)/);

                            var format = pdfArr[1];
                            if(format == 'pdf') {
                                var image = '<img src="<?php echo base_url('new_assets/img/pdf.png'); ?>" style="width: 50px;">';
                                var image_padding = 'padding: 25px !important;';
                            } else {
                                var image = '<img src="<?php echo base_url('uploads/attachment'); ?>/'+pdfname+'" style="height: 65px;">';
                                var image_padding = '';
                            }
                            var fileName = pdfArr[0];
                            
                            var shortName = fileName.substr(0, 6) + "..." + format;
                            // console.log(pdfname);
                            // var ind=pdfname.indexOf('_');
                            // var shortName=pdfname.substring(ind+1,20);
                            // var fullName=pdfname.substring(ind+1);
                            // console.log(shortName);

                            // document.querySelector('.pdf_section').innerHTML
                            pdf_html+='<div class="col-sm-2"><div class="card notes_card " style="background-color:#EBF5FB;"><div class="card-body" style="'+image_padding+'"><div style="display: flex !important;"><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+pdfname+'" target="_blank">'+image+'</a></div></div></div><div class="card-footer notes_card_footer" style="padding: 5px 25px !important;"><div class="row"><div><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+pdfname+'" target="_blank" style="margin-left:-5px;">'+shortName+'</a></div></div></div></div>';
                        }
                    }
                }
                $('.pdf_section').html(pdf_html);
            }
        });

        var myurl=$(this).attr('id');
        
        $.ajax({
            type: 'POST',
            url: myurl ,
            data: "",
            success: function (result3) {
                // var note_content = '';
                var result3 = JSON.parse(result3);
                // console.log('sub note url'+myurl);
                // console.log(result3[0]['subject']);
                // console.log(result3.length); return false;
                // var pdf=JSON.parse(result3['pdf']);
                var subhtml='';
                
                var pdfname = '';
                // console.log(result3);
                var ind='';
                var shortName='';
                var fullName='';
                if(result3.length>0){
                    for (var i = 0; i < result3.length; i++){
                        // var obj = pdf[i];

                        // for (var key in obj){
                        //     var pdfname = obj[key];
                        //     console.log(pdfname);
                        //     var ind=pdfname.indexOf('_');
                        //     var shortName=pdfname.substring(ind+1,18);
                        //     var fullName=pdfname.substring(ind+1);
                            // console.log(shortName);
                        var sid=result3[i]['id'];
                        
                        var li=myurl.lastIndexOf('/');
                        var note_sr_id=myurl.substring(li+1);
                        var editPath="edit_sub_ongoing_note/"+merchant_id+'/'+id+'/'+sid+'/'+note_sr_id;
                        var EditUrl="<?php echo base_url('Merchant_document/'); ?>"+editPath;
                        // console.log(EditUrl);
                        var delPath="delsubNote("+merchant_id+','+sid+','+id+','+note_sr_id+")";
                        // console.log(delPath);
                        subhtml+='<div class="card custom_card"><div class="card-header custom_card_header" id="headingOne"><h5 class="mb-0"><button class="btn btn-link header_btn" data-toggle="collapse" data-target="#collapseOne'+i+'" aria-expanded="true" aria-controls="collapseOne"><span id="subnoteHeading">'+(i+1)+') Sub Note Of '+result3[i]['subject'] +'</span></button><a class="card_action" href="javascript:void(0)" onClick='+delPath+' style="float:right; border:none;" title="Delete" ><i class="fa fa-trash"></i></a><a class="card_action" href="'+EditUrl+'" title="Edit" style="float:right; border:none;"><i class="fa fa-pencil"></i>&nbsp;&nbsp;</a></h5></div><div id="collapseOne'+i+'" class="custom_body collapse" aria-labelledby="headingOne" data-parent="#accordion"><div class="card-body"><b>'+result3[i]['created_at']+'</b><br/>'+result3[i]['sub_note']+'<br/><br/>By:'+result3[i]['created_by']+'<hr size="5px" style="border-top: 1px solid darkgray !important;"><div id="pdfBlock" class="row pdf_section'+i+'"></div></div></div></div>';
                        var pdfhtml='';
                            // console.log('sid'+sid);
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url('Merchant_document/get_pdf_subnotes_new/'); ?>"+id,
                            data: "",
                            success: function (res) {
                                var note_content = '';
                                var res = JSON.parse(res);
                                
                                for (var i = 0; i < res.length; i++){
                                    obj = JSON.parse(res[i]);
                                    // console.log("i="+i);
                                    for (var key in obj){
                                        // console.log(key+"i="+i);
                                        // console.log(obj[key]['attachment']);
                                        subPdfname=obj[key]['attachment'];
                                        var subPdfArr = subPdfname.split(/\.(?=[^\.]+$)/);

                                        var subFormat = subPdfArr[1];
                                        var subFileName = subPdfArr[0];

                                        if(subFormat == 'pdf') {
                                            var subImage = '<img src="<?php echo base_url('new_assets/img/pdf.png'); ?>" style="width: 50px;">';
                                            var sub_image_padding = 'padding: 25px !important;';
                                        } else {
                                            var subImage = '<img src="<?php echo base_url('uploads/attachment'); ?>/'+subPdfname+'" style="height: 65px;">';
                                            var sub_image_padding = '';
                                        }
                                        
                                        var subShortName = subFileName.substr(0, 6) + "..." + subFormat;

                                        pdfhtml+='<div class="col-sm-2 "><div class="card notes_card " style="background-color:#EBF5FB;"><div class="card-body" style="'+sub_image_padding+'"><div style="display: flex !important;"><a href="<?php echo base_url('uploads/attachment/') ?>'+subPdfname+'" title="'+subPdfname+'" target="_blank">'+subImage+'</a></div></div></div><div class="card-footer notes_card_footer" style="padding: 5px 25px !important;"><div class="row"><div><a href="<?php echo base_url('uploads/attachment/') ?>'+subPdfname+'" title="'+subPdfname+'" target="_blank" style="margin-left:-5px;">'+subShortName+'</a></div></div></div></div>';
                                    }
                            
                                    // console.log('pdf_section'+i);
                                    // console.log(pdfhtml);

                                    $('.pdf_section'+i).html(pdfhtml);
                                    // x++;
                                    pdfhtml='';        
                                }
                            }
                        });
                    }
                }
                $('#accordion').html(subhtml);
            }
        });
            
        //         var pdfhtml='';
        //                 // console.log('sid'+sid);
        //                 $.ajax({
        //                     type: 'POST',
        //                     url: "<?php echo base_url('Merchant_document/get_pdf_subnotes_new/'); ?>"+id,
        //                     data: "",
        //                     success: function (res) {
        //                     var note_content = '';
        //                     var res = JSON.parse(res);
                            
        //                     for (var i = 0; i < res.length; i++){
        //                         obj = JSON.parse(res[i]);
        //                         console.log("i="+i);
        //                         for (var key in obj){
        //                             // console.log(key+"i="+i);
        //                             // console.log(obj[key]['attachment']);
        //                             pdfname=obj[key]['attachment'];
        //                             //console.log(pdfname);
        //                             ind=pdfname.indexOf('_');
        //                             shortName=pdfname.substring(ind+1,20);
        //                             fullName=pdfname.substring(ind+1);
        //                             console.log(shortName);
        //                             pdfhtml+='<div class="col-sm-2 "><div class="card notes_card " style="background-color:#EBF5FB;"><div class="card-body" style="padding: 25px !important; "><div style="display: flex !important;"><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+fullName+'" target="_blank"><img src="<?php echo base_url('new_assets/img/pdf.png'); ?>" style="width: 50px;"></a></div></div></div><div class="card-footer notes_card_footer"><div class="row"><div><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+fullName+'" target="_blank" style="margin-left:-5px;">'+shortName+'...</a></div></div></div></div>';
        //                         }
                        
        //             console.log('pdf_section'+i);
        //             console.log(pdfhtml);

        //         $('.pdf_section'+i).html(pdfhtml);
        //         // x++;
        //         pdfhtml='';        
        //         }
                
        //         // subhtml='';
        //     }
        // });
    })

    $(document).on('click', '.pdfModal', function() {
        $('#pdf_modal').modal('show');
        $('.pdf_section').html('');
       // $('.modal-title').html('');

        $('.modal-title').html('Attached Files');
        var id = $(this).attr('data-id');
        var merchant_id= <?php echo $merchant_id ?>;
        // console.log(merchant_id);return false;

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Merchant_document/get_pdf/'); ?>"+id+'/'+merchant_id,
            data: "",
            success: function (result) {
                var note_content = '';
                var result = JSON.parse(result);
                // console.log(result);
                var pdf=JSON.parse(result['pdf']);
                for (var i = 0; i < pdf.length; i++){
                    var obj = pdf[i];
                    for (var key in obj){
                        var pdfname = obj[key];
                        console.log(pdfname);
                        var ind=pdfname.indexOf('_');
                        var shortName=pdfname.substring(ind+1,18);
                        var fullName=pdfname.substring(ind+1);
                        // console.log(shortName);

                        document.querySelector('.pdf_section').innerHTML='<div class="col-sm-2 "><div class="card notes_card " style="background-color:#EBF5FB;"><div class="card-body" style="padding: 25px !important; "><div style="display: flex !important;"><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+fullName+'" target="_blank"><img src="<?php echo base_url('new_assets/img/pdf.png'); ?>" style="width: 50px;"></a></div></div></div><div class="card-footer notes_card_footer"><div class="row"><div class="col-10"><strong><a href="<?php echo base_url('uploads/attachment/') ?>'+pdfname+'" title="'+fullName+'" target="_blank">'+shortName+'...</a></strong></div></div></div></div>'+document.querySelector('.pdf_section').innerHTML;
                    }
                }
            }
        });
    })

    $(document).on('change', '#sort_order', function() {
        $('.notes_section').empty();
        $('.notes_section').html('<div class="processing_note text-center"><p><i class="fa fa-spin fa-spinner"></i> Processing...</p></div>');
        // return false;
        var merchant_id = "<?php echo $merchant_id; ?>";
        var value = $(this).val();
        // console.log(value, merchant_id);return false;
        var post_data = {
            'merchant_id': merchant_id,
            'value': value
        };

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Merchant_document/sorted_ongoing_notes'); ?>",
            data: post_data,
            success: function (result) {
                var result = JSON.parse(result);
                if(result.status == 200) {
                    // console.log(result);return false;

                    $('.notes_section').empty();
                    $('.notes_section').html(result.content);
                
                } else {
                    $('.notes_section').empty();
                    $('.notes_section').html('<div class="processing_note text-center"><p>No notes found</p></div>');
                }
            }
        });
    })
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