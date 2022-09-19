<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content=" ">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
    <title>Admin | Subadmin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <!-- <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
    <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
    <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
</head>
<body class="fixed-left">
    <?php 
        include_once 'top_bar.php';
        include_once 'sidebar.php';
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
    </style>

    <div id="wrapper"> 
        <div class="page-wrapper edit-profile"> 
            <div class="row" style="padding: 0px 20px !important;">
                <div class="col-12">
                    <div class="back-title m-title"> 
                        <span>Broadcast Mail</span>
                        <small style="color:red;"><?php echo validation_errors(); ?></small>
                    </div>
                </div>
            </div>

            <div class="row" style="padding: 0px 20px !important;">
                <div class="col-12">
                    <div class="card content-card">
                        <div class="card-detail">
                            <div class="card-body">
                                <?php if(isset($msg)) {
                                    echo '<span class="text-success">'.$msg.'</span>';
                                } ?>
                                <!--<div class="msg_class"></div>-->
                                <div class="msg_class">
                                    
                                </div>
                                
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

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <style type="text/css">
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
    </style>
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
            //$('span#mceu_30').text('Powered by SaleQuick');

            $('#framework').multiselect({
                nonSelectedText: 'Select Merchant  ',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                allSelectedText: 'All', 
                includeSelectAllOption: true,
                numberDisplayed: 99,
                maxHeight: 200,
                enableHTML: true
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

    <script>
        var resizefunc = [];
    </script> 
    <!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script> -->
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
    <!-- Popper for Bootstrap -->
    <!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script> -->
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
    <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>new_assets/js/mdb.min.js"></script> -->
    <!-- Plugin file -->
    <script src="<?php echo base_url(); ?>/new_assets/js/datatables.min.js"></script>
    <script type="text/javascript">
        $(document)
        .on('change','#saleQuickPfIcon',function(e){
            console.log($(this).val())
            readURL(this);
        })
        .on('click','.upload-btn',function(e) {
            $('#saleQuickPfIcon').trigger('click');
        })

        $(document).ready(function() {
            $('.mdb-select').materialSelect();
        });
    </script>
</body>
</html>