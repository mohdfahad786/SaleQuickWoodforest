<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>QuickBooks Settings</title>
    <!-- INTUIT -->
    <script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
    <!-- INTUIT -->

    <style>
        .widget-header {
            background-color: #494D6A !important;
            color: #fff !important;
        }
        .widget-header h4 {
            color: #fff !important;
        }
        .widget-header .icon-reorder {
            color: #fff !important;
        }
        
        .select2-container.form-control{padding:0px 0px;}
        .select2-container .select2-choice{border: none;}
        input[type="checkbox"].error{-webkit-box-shadow: 0px 0px 0px 1px rgba(255,0,0,1);
            -moz-box-shadow: 0px 0px 0px 1px rgba(255,0,0,1);
            box-shadow: 0px 0px 0px 1px rgba(255,0,0,1);}
        .plane-error-text{display: none; color:#FF0000; text-align: center;}
        .selected-plan{float: right; font-weight: bold; color: #8B8B8B; font-size: 18px; display: none;}
        /*#qb_connect_button{
            background-image: url('https://salequick.com/HelloWorld/views/C2QB_green_btn_lg_default.png'); 
            background-size: contain;
            width: 100px;
            height: 33px;
        }*/
        .custom-check {
          display: block;
          position: relative;
          padding-left: 35px;
          margin-bottom: 12px;
          cursor: pointer;
          font-size: 22px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
        }
        
        /* Hide the browser's default checkbox */
        .custom-check input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
          height: 0;
          width: 0;
        }
        
        /* Create a custom checkbox */
        .checkmark {
          position: absolute;
          top: 0;
          left: 0;
          height: 25px;
          width: 25px;
          background-color: #eee;
          border-radius: 5px;
        }
        
        /* On mouse-over, add a grey background color */
        .custom-check:hover input ~ .checkmark {
          background-color: #ccc;
        }
        
        /* When the checkbox is checked, add a blue background */
        .custom-check input:checked ~ .checkmark {
          background-color: #2196F3;
        }
        
        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
          content: "";
          position: absolute;
          display: none;
        }
        
        /* Show the checkmark when checked */
        .custom-check input:checked ~ .checkmark:after {
          display: block;
        }
        
        /* Style the checkmark/indicator */
        .custom-check .checkmark:after {
          left: 9px;
          top: 5px;
          width: 5px;
          height: 10px;
          border: solid white;
          border-width: 0 3px 3px 0;
          -webkit-transform: rotate(45deg);
          -ms-transform: rotate(45deg);
          transform: rotate(45deg);
        }
    </style>
</head>

<body>
    <?php
        include_once'header_dash_list.php';
        include_once'nav_label.php';
        include_once'sidebar_dash.php';
    ?>
    <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
            <div class="content-viewport">
                <!-- Container -->
                     <!--     <div class="crumbs">-->
                     <!--           <ul class="breadcrumb" id="breadcrumbs">-->
                     <!--                   <li>-->
                     <!--                           <i class="icon-home"></i>-->
                     <!--                           <a href="<?php echo base_url();?>dashboard">Dashboard</a>-->
                     <!--                   </li>-->
                     <!--                   <li><a href="<?php echo base_url();?>orgsetting">Organization Setting</a></li>-->
                     <!--                   <li>QuickBooks Connect</li>-->
                     <!--           </ul>-->
                    	<!--</div>-->
                <div class="row"><!-- row -->
                    <div class="col-md-12">
                        <div class="widget box">
                            <div class="widget-content">
                                <div style="display: none" class="" id="alertBox">
                                    <i data-dismiss="alert" class="icon-remove close"></i>
                                    <span id="response_message"></span>
                                </div>
                                
                                <div class="grid grid-chart" style="width: 100% !important;margin-top: 20px;">
                                    <div class="grid-body d-flex flex-column">
                                        <div class="mt-auto" style="margin-top: 10px !important;">
                                            <form id="validate_orgfrm" class="form-horizontal row-border" novalidate="novalidate" action="#">
                                                <!-- CONNECT TO INTUIT -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label">Connect app to QuickBooks: </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <?php //print_r($data);
                                                        
                                                        // $status = 0;
                                                        if($status=='1'){
                                                        ?>
                                                            <div class="row">
                                                                <h2 id="connection_text" style="color:#007bff !important;">Connected</h2>
                                                            </div>
                                                            <div class="row">
                                                                <a href="<?= base_url().'quickbook/delete_connection/'.$merchant_id; ?>" id="btn_disconnect" class="btn btn-primary" style="width: 120px !important;border-radius:20px;margin-right: 5px;height: 35px !important;">Disconnect</a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="row">
                                                                <img src="<?= base_url('new_assets/img/qb_logo.svg') ?>" style="max-width: 350px;margin: 10px 0px !important;" />
                                                            </div>
                                                            <div class="row">
                                                                <a href="<?php echo $redirect_url ?>">
                                                                    <button type="button" id="qb_connect_button" class="btn btn-primary" style="border-radius:20px;">Connect to Quickbook</button>
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if($status=='1'){ ?>
                                <div class="grid grid-chart" style="width: 100% !important;margin-top: 20px;">
                                    <div class="grid-body d-flex flex-column">
                                        <div class="mt-auto" style="margin-top: 10px !important;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <h4 class="h4-custom">Other Connection Status</h4>
                                                        <div class="row" style="margin-top: 15px !important;">
                                                            <div class="col-4">
                                                                <label class="custom-check">Invoice
                                                                    <input id="inv_check" type="checkbox" <?= ($inv_status == '1') ? 'checked' : '' ?>>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="custom-check">POS
                                                                    <input id="pos_check" type="checkbox" <?= ($pos_status == '1') ? 'checked' : '' ?>>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="custom-check">VT
                                                                    <input id="vt_check" type="checkbox" <?= ($vt_status == '1') ? 'checked' : '' ?>>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="invoice_sync_area" style="display:none">
                                    <div class="row">
                                        <div class="col-12 py-5-custom">
                                             <h4 class="h4-custom">Old Invoice Data Sync</h4> 
                                        </div>
                                    </div>
                                    
                                    <form class="row" method="post" action="" style="margin-bottom: 20px !important;">
                                        <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                                            <div id="invoice_sync_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                                                <span>
                                                    <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                                                </span>
                                                <input name="invoice_start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                                <input name="invoice_end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="table_custom_status_selector">
                                            <select class="form-control" name="invoice_status" id="invoice_status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                                                <option value="all">Select Status</option>
                                                <option value="paid">Paid</option>
                                                <option value="pending">Pending</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-lg-2">
                                            <button class="btn btn-rounded social-btn-outlined" type="submit" name="invoice_sync_submit" value="Sync"><i class="mdi mdi-magnify medium"></i>Sync</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="pos_sync_area" style="display:none">
                                    <div class="row">
                                        <div class="col-12 py-5-custom">
                                             <h4 class="h4-custom">Old POS Data Sync</h4> 
                                        </div>
                                    </div>
                                    
                                    <form class="row" method="post" action="" style="margin-bottom: 20px !important;">
                                        <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                                            <div id="pos_sync_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                                                <span>
                                                    <?php echo ((isset($start_date) && !empty($start_date)) ? (date("F-d-Y", strtotime($start_date)) . ' - ' . date("F-d-Y", strtotime($end_date))) : ('<label class="placeholder">Select date range</label>')) ?>
                                                </span>
                                                <input name="pos_start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date)) ? $start_date : ''; ?>">
                                                <input name="pos_end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date)) ? $end_date : ''; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="table_custom_status_selector">
                                            <select class="form-control" name="pos_status" id="pos_status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                                                <option value="all">Select Status</option>
                                                <option value="paid">Paid</option>
                                                <option value="pending">Pending</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-lg-2">
                                            <button class="btn btn-rounded social-btn-outlined" type="submit" name="pos_sync_submit" value="Sync"><i class="mdi mdi-magnify medium"></i>Sync</button>
                                        </div>
                                    </form>
                                </div>
                                <?php } ?>     
                            </div>
                        </div>
                    </div>
                </div><!-- row -->
            </div><!-- Container -->
        </div><!-- Content -->
    </div><!-- container end -->
    
    <?php include_once'footer_dash_list.php'; ?>
    
    <script>
        function setSyncDefDate(){
            if($("#invoice_sync_daterange").length){
    			$("#invoice_sync_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
    			$("#invoice_sync_daterange input[name='invoice_start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
    			$("#invoice_sync_daterange input[name='invoice_end_date']").val( moment().format("YYYY-MM-DD"));
    		}
    		
    		if($("#pos_sync_daterange").length){
    			$("#pos_sync_daterange span").html(moment().subtract(30, "days").format("MMMM-D-YYYY") +'-'+ moment().format("MMMM-D-YYYY"));
    			$("#pos_sync_daterange input[name='pos_start_date']").val( moment().subtract(30, "days").format("YYYY-MM-DD"));
    			$("#pos_sync_daterange input[name='pos_end_date']").val( moment().format("YYYY-MM-DD"));
    		}
        }
		
		if($('#pos_sync_daterange').length){
			var invoice_sync_daterange_config = {
				ranges: {
						Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
						"Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
						"This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
				},opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
				startDate: (($("#pos_sync_daterange input[name='pos_start_date']").val().length > 0) ? ($("#pos_sync_daterange input[name='pos_start_date']").val()) : (setSyncDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
				endDate: (($("#pos_sync_daterange input[name='pos_end_date']").val().length > 0) ? ($("#pos_sync_daterange input[name='pos_end_date']").val()) : moment().format("YYYY-MM-DD"))
			};
			// console.log(pos_sync_daterange_config)
			$('#pos_sync_daterange').daterangepicker(invoice_sync_daterange_config, function(a, b) {
				$("#pos_sync_daterange input[name='pos_start_date']").val( a.format("YYYY-MM-DD"));
				$("#pos_sync_daterange input[name='pos_end_date']").val( b.format("YYYY-MM-DD"));
				$("#pos_sync_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
			});
		}
    </script>
    
    <script>
        $(document).ready(function () {
            if ($('#inv_check').is(':checked')) {
                $('.invoice_sync_area').removeClass('d-none');
            } else {
                $('.invoice_sync_area').addClass('d-none');
            }
            
            if ($('#pos_check').is(':checked') || $('#vt_check').is(':checked')) {
                $('.pos_sync_area').removeClass('d-none');
            } else {
                $('.pos_sync_area').addClass('d-none');
            }
        })
        
        
        // $(document).on('click', '#btn_disconnect', function() {
        //     var status = $('#conn_status').val();
        //     var merchant_id = "<?= $merchant_id ?>";
        //     console.log(status, merchant_id);
        //     var update_status = (status == '1') ? '0' : '1';
        //     $.ajax({
        //         url: "<?= base_url('quickbook/update_connection_status') ?>",
        //         type: "post",
        //         data: {'status': update_status, 'merchant_id': merchant_id},
        //         success: function(data) {
        //             console.log(data);
        //             if(data == '1') {
        //                 $('#conn_status').val('1');
        //                 $('#btn_disconnect').val('Disconnect');
        //                 $('#connection_text').text('Connected');
        //             } else {
        //                 $('#conn_status').val('0');
        //                 $('#btn_disconnect').val('Connect');
        //                 $('#connection_text').text('Disconnected');
        //             }
        //         }
        //     });
        // })
        
        $(document).on('click', '#inv_check', function() {
            var merchant_id = "<?= $merchant_id ?>";
            var update_pos_status = ($('#inv_check').is(':checked')) ? '1' : '0';
            // console.log(merchant_id, update_pos_status);
            $.ajax({
                url: "<?= base_url('quickbook/update_other_conn_status') ?>",
                type: "post",
                data: {'status': update_pos_status, 'merchant_id': merchant_id, 'checkbox_nm': 'inv_check'},
                success: function(data) {
                    if (data == '1') {
                        $('.invoice_sync_area').removeClass('d-none');
                    } else {
                        $('.invoice_sync_area').addClass('d-none');
                    }
                }
            });
        })
        
        $(document).on('click', '#pos_check', function() {
            var merchant_id = "<?= $merchant_id ?>";
            var update_pos_status = ($('#pos_check').is(':checked')) ? '1' : '0';
            // console.log(merchant_id, update_pos_status);
            $.ajax({
                url: "<?= base_url('quickbook/update_other_conn_status') ?>",
                type: "post",
                data: {'status': update_pos_status, 'merchant_id': merchant_id, 'checkbox_nm': 'pos_check'},
                success: function(data) {
                    if (data == '1') {
                        $('.pos_sync_area').removeClass('d-none');
                    } else {
                        $('.pos_sync_area').addClass('d-none');
                    }
                }
            });
        })
        
        $(document).on('click', '#vt_check', function() {
            var merchant_id = "<?= $merchant_id ?>";
            var update_pos_status = ($('#vt_check').is(':checked')) ? '1' : '0';
            // console.log(merchant_id, update_pos_status);
            $.ajax({
                url: "<?= base_url('quickbook/update_other_conn_status') ?>",
                type: "post",
                data: {'status': update_pos_status, 'merchant_id': merchant_id, 'checkbox_nm': 'vt_check'},
                success: function(data) {
                    if (data == '1') {
                        $('.pos_sync_area').removeClass('d-none');
                    } else {
                        $('.pos_sync_area').addClass('d-none');
                    }
                }
            });
        })
    </script>
</body>
</html>