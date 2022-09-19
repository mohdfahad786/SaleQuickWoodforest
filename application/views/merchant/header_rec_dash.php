<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <title>Merchant | Dashboard</title>
        <link rel="shortcut icon" href="https://salequick.com/merchant-panel/assets/images/favicon_1.ico">
        <!-- New Dashboard assets -->
        <link rel="stylesheet" href="<?php echo base_url('new_assets/css/dashboard_css/materialdesignicons.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('new_assets/css/dashboard_css/style_shared.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('new_assets/css/dashboard_css/style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('new_assets/css/dashboard_css/custom_style.css') ?>">
        <link href="<?php echo base_url('new_assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">

        <!-- Old Dashboard assets -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">
        
        <link href="<?php echo base_url('new_assets/css/waves.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('new_assets/css/select2.min.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('new_assets/css/bootstrap-tagsinput.css'); ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('new_assets/css/datatables.min.css'); ?>"/>
        <link href="https://salequick.com/merchant-panel/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="https://salequick.com/merchant-panel/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
        <link href="https://salequick.com/merchant-panel/plugins/jquery-circliful/css/jquery.circliful.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('new_assets/css/daterangepicker.css'); ?>" rel="stylesheet"/>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('new_assets/css/style.css'); ?>">
        
        <!-- <script src="<?php echo base_url('new_assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> -->
        
        <script src="<?php echo base_url('new_assets/js/app.min1.js'); ?>"></script>
        <script src="<?php echo base_url('new_assets/js/app.min2.js'); ?>"></script>
        <!-- <script src="<?php echo base_url('new_assets/js/jquery.inputmask.js');?>" ></script> -->
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>new_assets/css/cp_style_rec.css">
        
    </head>
    <body class="header-fixed">
        <?php include_once'nav_label.php'; ?>
        <div class="page-body">
            <?php if($this->session->flashdata('success')) { ?>
                <style>
                    .modal-body {
                        color: #28a745 !important;
                        font-size: 15px !important;
                        padding: 15px 22px !important;
						font-family: AvenirNext-Medium !important;
                    }
                </style>
                <div class="modal fade" id="message_popup" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <!-- <div class="form-title">Update Message</div> -->
                            </div>
                            <div class="modal-body">
                                <p><?php echo $this->session->flashdata('success'); ?></p>
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $("#message_popup").modal('show');
                        return false;
                    })
                </script>
            <?php } ?>

            <?php if($this->session->flashdata('error')) { ?>
                <style>
                    .modal-body {
                        color: red !important;
                        font-size: 15px !important;
						font-family: AvenirNext-Medium !important;
                    }
                </style>
                <div class="modal fade" id="message_popup" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <!-- <div class="form-title">Update Message</div> -->
                            </div>
                            <div class="modal-body">
                                <p><?php echo $this->session->flashdata('error'); ?></p>
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $("#message_popup").modal('show');
                        return false;
                    })
                </script>
            <?php } ?>

            <?php if($this->session->flashdata('msg')) { ?>
                <style>
                    .modal-body {
                        color: black !important;
                        font-size: 15px !important;
						font-family: AvenirNext-Medium !important;
                    }
                </style>
                <div class="modal fade" id="message_popup" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <!-- <div class="form-title">Update Message</div> -->
                            </div>
                            <div class="modal-body">
                                <p><?php echo $this->session->flashdata('msg'); ?></p>
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $("#message_popup").modal('show');
                        return false;
                    })
                </script>
            <?php } ?>

            <?php if(isset($msg)) { ?>
                <style>
                    .modal-body {
                        color: black !important;
                        font-size: 15px !important;
						font-family: AvenirNext-Medium !important;
                    }
                </style>
                <div class="modal fade" id="message_popup" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <!-- <div class="form-title">Update Message</div> -->
                            </div>
                            <div class="modal-body">
                                <p><?php echo $msg; ?></p>
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $("#message_popup").modal('show');
                        return false;
                    })
                </script>
            <?php } ?>

            <?php if(validation_errors()) { ?>
                <style>
                    .modal-body {
                        color: black !important;
                        font-size: 15px !important;
						font-family: AvenirNext-Medium !important;
                    }
                </style>
                <div class="modal fade" id="message_popup" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <!-- <div class="form-title">Update Message</div> -->
                            </div>
                            <div class="modal-body">
                                <p><?php echo validation_errors(); ?></p>
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $("#message_popup").modal('show');
                        return false;
                    })
                </script>
            <?php } ?>