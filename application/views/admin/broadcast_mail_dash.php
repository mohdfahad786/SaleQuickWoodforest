<?php
    include_once'header_bc_dash.php';
    include_once'sidebar_dash.php';
?>

<style>
    textarea:focus {
        border: 1px solid #2273dc !important;
    }
    .btn-group {
        width: 100% !important;
    }
    .btn-group button {
        width: 100% !important;
        text-align: left !important;
    }
    .waves-ripple {
        opacity: 0 !important;
    }
    .multiselect-container {
        max-width: 420px !important;
    }
    .btn.multiselect, .btn.multiselect:focus, .btn.multiselect:hover {
        white-space: pre-wrap;
    }
    .modal-body {
        color: #28a745 !important;
        font-size: 15px !important;
        padding: 15px 22px !important;
        font-family: AvenirNext-Medium !important;
    }
    .mce-container{
        border: 0px solid #ccc;
        border-radius: 5px !important;
        border-bottom: 0.5px solid #fff;
    }
    .mce-menubar{
        display: none;
    }
    .mce-notification{
        display: none;
    }
    span#mceu_30 {
        display: none;
    }
    label {
        font-weight: 600;
    }
    .multiselect-container>li>a>label:hover,
    .multiselect-container li.active a label {
        background-color: #e9ecef !important;
        color: #696ffb !important;
    }
    .multiselect-container>li>a>label {
        border-bottom: 1px solid #e9ecef !important;
    }
    .multiselect-container>li>a>label:hover {
        border-bottom: 1px solid #fff !important;
    }
    .input-group-addon {
        background-color: #fff !important;
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

            <div class="row" style="margin-bottom: 20px !important;">
                <div class="grid grid-chart edit-profile" style="width: 100% !important;">
                    <div class="grid-body d-flex flex-column">
                        <div class="mt-auto">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-title"><?php echo $meta; ?></div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-6 col-md-12 col-lg-12">
                                    <form method="post" id="framework_form">
                                        <div class="form-group">
                                            <label>Mail To</label>
                                            <select id="framework" name="framework[]" multiple class="form-control">
                                                <?php foreach($mail_arr as $mail) { ?>
                                                    <option value="<?= $mail['email'] ?>"><?= $mail['name'] ." -- ".$mail['email']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Subject</label>
                                            <input type="text" class="form-control" name="subject" id="subject" value="">
                                        </div>

                                        <div class="form-group" style="display: grid !important;">
                                            <label for="">Description</label>
                                            <textarea id="description" name="description" rows="4" cols="50" style="border: 1px solid rgba(0,0,0,.15) !important;"></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="">Footer Quote</label>
                                            <input type="text" class="form-control" name="footer_msg" id="footer_msg" value="Feel free to contact us any time with question and concerns.">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="">Footer Text</label>
                                            <input type="text" class="form-control" name="footer_text" id="footer_text" placeholder="e.g., Powered By etc" value="Powered By">
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Website (Name)</label>
                                                    <input type="text" class="form-control" name="website_name" id="website_name" value="SaleQuick.com">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Website (URL)</label>
                                                    <input type="text" class="form-control" name="website_link" id="website_link" placeholder="http or https://example.com" value="https://salequick.com">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-right">
                                            <div class="btn_loader" style="display: none;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></div>
                                            <input type="submit" id="mail_submit_btn" class="btn btn-info" name="submit" value="Send Mail" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea#description',
        height: 300,
        theme: "modern",
        // plugins: [
        //     "advlist autolink lists link image imagetools media charmap print preview hr anchor pagebreak",
        //     "searchreplace wordcount visualblocks visualchars code fullscreen",
        //     "insertdatetime media nonbreaking save table contextmenu directionality",
        //     "emoticons template paste textcolor colorpicker textpattern"
        // ],
        //toolbar: 'undo redo |  styleselect | bold italic |  fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media  | table',
        // toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image  | table",
        // toolbar2: "print preview media | forecolor backcolor emoticons",
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
        ],
    });

    $(document).ready(function(){
        // $('.multiselect-item.filter').find('span.input-group-addon').html('');
        // $('.multiselect-item.filter').find('span.input-group-addon').html('<i class="fa fa-search"></i>');

        $('#framework').multiselect({
            nonSelectedText: 'Select Merchant  ',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'All',
            includeSelectAllOption: true,
            numberDisplayed: 10,
            maxHeight: 240,
            enableHTML: true,
            templates: {
                // filter: '<div class="multiselect-item multiselect-filter"><div class="input-group input-group-sm p-1"><div class="input-group-prepend"><i class="input-group-text fa fa-search"></i></div><input class="form-control multiselect-search" type="text"></div></div>',
                filter: '<div class="multiselect-item filter"><div class="input-group"><div class="input-group-addon"><i class="input-group-text fa fa-search"></i></div><input class="form-control multiselect-search" type="text" placeholder="Search"></div></div>',
                filterClearBtn: '<div class="input-group-append"><button class="multiselect-clear-filter input-group-text" type="button"><i class="fa fa-times"></i></button></div>',
            }
        });

        $('#mail_submit_btn').on('click', function(){
            var framework = $('#framework').val();
            var subject = $('#subject').val();
            var website_link = $('#website_link').val();
            var website_name = $('#website_name').val();
            var description = $('#description').val();
            var editorContent = tinyMCE.get('description').getContent();
            console.log(website_link);
            if(framework == '') {
               alert('Mail To field is required');return false;
            } else if(subject == '') {
                alert('Subject field is required');return false;
            // } else if(description == '') {
            } else if (editorContent == '') {
                alert('Description field is required');return false;
            } else if (website_link != '') {
                var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
                if (pattern.test(website_link) == false) {
                    alert('Enter valid website URL format');return false;
                } else if (website_name == '') {
                    alert('Website (Name) is required');return false;
                }
            }
        })

        $('#framework_form').on('submit', function(event){
            event.preventDefault();
            $("input#mail_submit_btn").prop('disabled', true);
            $('.btn_loader').css('display', 'contents')
            var form_data = $(this).serialize();
            $.ajax({
                url:"<?= base_url('broadcast/send_mail') ?>",
                method:"POST",
                data:form_data,
                success:function(data) {
                    $('.msg_class').html('<div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> Mail sent successfully.</div>');
                    $("#framework_form")[0].reset();
                    $('#framework').multiselect('refresh');
                    $("input#mail_submit_btn").prop('disabled', false);
                    $('.btn_loader').css('display', 'none');
                }
            });
        });
    });
</script>

<?php include_once'footer_broadcast_dash.php'; ?>