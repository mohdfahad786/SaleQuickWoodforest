<?php
	include_once 'header_dash.php';
	include_once 'sidebar_dash.php';
?>

<style>
	.summary-grid-text-section h1 {
	    margin: 0 !important;
	}
	@media screen and (max-width: 1220px) {
        .summary-grid-text-section {
            width: 80px;
            height: 60px;
        }
        .grid-summary {
            border-radius: 15px !important;
        }
    }
    @media screen and (min-width: 1221px) {
        .summary-grid-text-section {
            width: 110px;
            height: 52px;
        }
        .grid-summary {
            border-radius: 15px !important;
        }
    }
    @media screen and (max-width: 1349px) {
        .summary-grid-text {
            font-size: 11px !important;
        }
    }
    .summary-grid-text {
        font-family: AvenirNext-Medium !important;
        font-weight: 500;
        color: rgb(184, 184, 184);
        font-size: 12px;
    }
    .summary-grid-status {
        font-size: 18px;
        color: rgb(62, 62, 62);
        font-weight: 600;
        font-family: Avenir-Heavy !important;
        margin-bottom: 0px !important;
    }
    .summary-grid-img-section {
        width: 54px;
        height: 54px;
        margin-top: 5px;
    }
    .summary-grid-img {
        width: 54px;
        height: 54px;
    }
    .summary-transaction-count {
        width: 100%
    }
    .head-count-val {
        color: #000 !important;
        font-family: 'Avenir-Heavy';
        font-weight: 600 !important;
        font-size: 24px !important;
    }
    @media screen and (min-width: 720px) {
        .summary-grid-padding {
            padding-right: 7.5px !important;
        }
    }
    .top_grid_link {
        background-color: #4c6ef5;
        padding: 2px 10px;
        border-radius: 10px;
    }
    .top_grid_btn {
        background-color: #4c6ef5;
        border-radius: 10px;
        border: none !important;
        padding: 0px 10px;
    }
    @media screen and (max-width: 640px) {
        .btn:not(.social-icon-btn).social-btn-outlined {
            width: 110px !important;
            font-size: 12px !important;
        }
        .summary-grid-img {
		    width: 35px;
		    height: 35px;
		}
		.head-count-val {
			font-size: 16px !important;
		}
		.summary-grid-status {
			font-size: 16px;
		}
		.summary-grid-text-section {
			height: 45px;
		}
    }
    @media screen and (max-width: 480px) {
    	.d-flex {
    		display: block !important;
    	}
    }
    @media screen and (max-width: 640px) {
        .btn.social-btn-outlined i.medium {
            margin-right: 10px !important;
        }
    }
    .dt-vw-del-dpdwn {
        text-align: right !important;
    }
    div.dataTables_wrapper div.dataTables_processing {
        display: none !important;
    }
    .badge-success {
        background-color: #28a745 !important;
        display: inline !important;
    }
    .badge-info {
        background-color: #857bff !important;
        display: inline !important;
    }
    .custom_btn_pd {
        padding: 4px 15px !important;
    }
    .custom_btn_pd_a {
        padding: 6px 15px !important;
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
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <p class="summary-grid-status">Gross</p>
                                    <small class="summary-grid-text">Payment Volume</small>
                                    
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-2.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="newtotalorders head-count-val">$0.00</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <p class="summary-grid-status">Total</p>
                                    <small class="summary-grid-text">Fee Captured</small>
                                    
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-1.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="totalpendingorders head-count-val" style="color: #000 !important;">$0.00</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 equel-grid summary-grid-padding">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <p class="summary-grid-status">Total</p>
                                    <small class="summary-grid-text">Payout</small>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-3.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="totalorders head-count-val" style="color: #000 !important;">$0.00</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 col-sm-6 equel-grid">
                    <div class="grid grid-summary">
                        <div class="grid-body text-gray top_grid_effect">
                            <div class="d-flex justify-content-between">
                                <div class="summary-grid-text-section">
                                    <p class="summary-grid-status">Total</p>
                                    <small class="summary-grid-text">Transactions</small>
                                </div>
                                <div class="summary-grid-img-section">
                                    <img class="summary-grid-img" src="<?php echo base_url('new_assets/img/new-icons/summary-img-4.png'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="totallate head-count-val" style="color: #000 !important;">0</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo (date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))) ?>
                        </span>
                        <input name="start_date" id="start_date" type="hidden">
                        <input name="end_date" id="end_date" type="hidden">
                    </div>
                </div>
                <div class="custom_employee_selector">
                    <select name="employee" class="form-control" id="employee" style="background-color: #f5f5fb !important;border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
            			<option value="">Select Merchant</option>
                  		<?php foreach ($merchants as $merchant) { ?>
                    		<option <?php echo (@$employee==$merchant['id'])?'selected="selected"':''?>  value="<?php echo $merchant['id']; ?>"><?php echo $merchant['name']; ?></option>
                  		<?php } ?>
      				</select>
                </div>
                <div class="table_custom_status_selector">
                    <select class="form-control" name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
		                <!-- <option <?php echo ($status=="pending")?'selected="selected"':''?> value="pending">Pending</option>
		                <option <?php echo ($status=="confirm")?'selected="selected"':''?> value="confirm">Confirm</option> -->
                        <option value="pending">Pending</option>
                        <option value="confirm">Confirm</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" id="btn-filter" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </div>
            <hr>

            <div class="row" style="margin-top: 20px !important;">
                <div class="col-12 equel-grid">
                    <div class="grid grid-chart">
                        <div class="grid-body d-flex flex-column h-100">
                            <form onsubmit="return validate(this);" method="post" action="<?php echo base_url('dashboard/funding_status_post');?>" >
                                <div class="row form-group" style="margin-bottom: 0px !important;">
                                    <div style="display:none" id="hideencheckbox"></div>
                                    <div class="col-12 text-right">
                                        <input class="form-control" id="funding_date" value="" name="date" type="hidden" autocomplete="off" placeholder="Select Date" required>
                                        <button class="btn btn-warning" type="submit" name="pendingSubmit" value="true" style="margin-right: 10px;"><i class="fa fa-pencil"></i> Pending</button>
                                        <button class="btn btn-success" type="submit" name="confirmSubmit" value="true" ><i class="fa fa-pencil"></i> Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table id="example" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th><input name="select_all" value="1" type="checkbox"></th>
                                <th>Gross Payments</th>
                      			<th>Merchant</th>
                      			<th>Account</th>
                      			<th>Fee Total</th> 
                      			<th>Payable/Hold Amount</th>
                      			<th>Status</th>
                      			<th>Funding Date</th> 
                      			<th>Details</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Payment Detail
        </h4> 
      </div> 
      <div class="modal-body"> 
       <div id="modal-loader" class="text-center modal-loader" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
      </div>
        <!-- content will be load here -->                          
        <div id="dynamic-content"></div>
      </div> 
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
      </div> 
    </div> 
  </div>
</div>

<div id="amount-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Change Status
        </h4> 
      </div> 
      <div class="modal-body"> 
        <!-- content will be load here -->                          
        <div id="amountdynamic-content">
            <form method="post" action="<?php echo base_url('dashboard/funding_status');?>" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label>Status</label>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 form-group">
                                <select class="form-control bder-radius" required="required" name="pstatus" id="pstatus">
                                    <option value="">-Select Status-<opton>
                                    <option value="pending">Pending<opton>
                                    <option value="confirm">Confirm<opton>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label>Payable Amount $</label>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 form-group">
                                <input type="text" class="form-control" readonly name="PayableAmount3" id="PayableAmount"  required value="">
                                <input type="hidden" class="form-control" readonly name="PayableAmount" id="PayableAmount2"  required value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label>Hold Amount</label>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 form-group">
                                <input type="text" class="form-control" name="Hold_Amount" id="Hold_Amount" required value="0">
                                <input type="hidden" class="form-control" name="date" id="popup_date"  required value="">
                                <input type="hidden" class="form-control" name="mid" id="popup_mearchent_id"  required value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h5><small><b>Previous Hold Amount</b></small></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Action</th>
                                    <th>Total Amount</th>
                                    <th>Hold Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                                <tbody id="holdrow">
                                    <div id="modal-loader" class="text-center modal-loader"  style="padding: 15px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/> </circle> </g> </svg>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-first" type="submit" name="mysubmit" value="Search"><i class="ti-pencil"></i> Submit</button>
                    </div>
                </div>
          </form>
        </div>
      </div> 
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
      </div> 
    </div> 
  </div>
</div>

<script>
    $("#Hold_Amount").on("keyup",function(){
        calcaulatHold($(this));
    });

    function dateFormatter(date) {
        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = year+'-'+month+'-'+day;
        return date;
    };

	$(function() {
        function dateFormatter(date) {
            var d = new Date(date);
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = year+'-'+month+'-'+day;
            return date;
        };

	    var start = moment().subtract(29, 'days');
	    var end = moment();

	    function cb(start, end) {
	        $('#daterangeFilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	        
            $('#start_date').val(start.format('YYYY-MM-D'));
            $('#end_date').val(end.format('YYYY-MM-D'));
	        $('#funding_date').val( dateFormatter(end.format('YYYY-MM-D')) );
	    }

	    $('#daterangeFilter').daterangepicker({
	        startDate: start,
	        endDate: end,
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, cb);

	    cb(start, end);
	});

    function getFundingReportSummaryFn() {
        // console.log('aaaa');
        var postData = {
            start_date : $('#start_date').val(),
            end_date : $('#end_date').val(),
            employee : $('#employee').val(),
            status : $('#status').val(),
        };
        $.ajax({
            url : "<?php echo base_url('dashboard/getFundingReportSummary'); ?>",
            type: "POST",
            dataType: "JSON",
            data: postData,
            success: function(data) {
                // location.reload();
                $('.newtotalorders').text(data.GrossPaymentVolume);
                $('.totalpendingorders').text(data.TotalFeeCaptured);
                $('.totalorders').text(data.TotalPayout);
                $('.totallate').text(data.TotalTransactions);
            }
        });
    }

    var table;
    $(document).ready(function() {
        var table_body = $('table#example > tbody');
        table_body.empty();
        table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
        table = $('#example').DataTable({
            pagingType: 'full_numbers',
            "pageLength": 25,
            "processing": true,
            "serverSide": true,
            "order": [[4,'desc']], //Initial no order.
            responsive: true, 
            dom: 'lBfrtip',
            language: {
                search: '', searchPlaceholder: "Search",
                oPaginate: {
                    sNext: '<i class="fa fa-angle-right"></i>',
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                }
            },
            buttons: [{
                extend: 'collection',
                text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }],
            "ajax": {
                "url": "<?=site_url('dashboard/getMerchantForFunding')?>",
                "type": "POST",
                "data": function ( data ) {
                    // console.log(data)
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
                    data.employee = $('#employee').val();
                    data.status = $('#status').val();
                }
            },
            drawCallback: function(){
                $('.paginate_button:not(.disabled):not(.active)', this.api().table().container())
                .on('click', function(){
                    table_body.empty();
                    table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
                });
            }
        });
        getFundingReportSummaryFn();
        
        $('#btn-filter').click(function(){
            table_body.empty();
            table_body.html('<tr><td colspan="7" style="text-align: center !important;">Processing</td></tr>');
            table.ajax.reload();
        });
        
        $('#btn-reset').click(function(){
            $('#form-filter')[0].reset();
            table.ajax.reload();
        });

        $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
            var $row = $(this).closest('tr');
            var data = table.row($row).data();
            var rowId = data[0];
            var index = $.inArray(rowId, rows_selected);
            if(this.checked && index === -1){
                rows_selected.push(rowId);
            } else if (!this.checked && index !== -1){
                rows_selected.splice(index, 1);
            }
            if(this.checked){
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }
            updateDataTableSelectAllCtrl(table);
            e.stopPropagation();
        });

        $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
            if(this.checked){
                // console.log(this);
                $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
                $('#example tbody input[type="checkbox"]:checked').trigger('click');
            }
            e.stopPropagation();
        });
    })

    function updateDataTableSelectAllCtrl(table){
        var $table             = table.table().node();
        var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);
    
        if($chkbox_checked.length === 0){
            chkbox_select_all.checked = false;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
            }
        } else if ($chkbox_checked.length === $chkbox_all.length){
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
            }
        } else {
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = true;
            }
        }
    }

    function stop_pak(id) {
        if(confirm('Are you sure Stop Recurring?')) {
            $.ajax({
                url : "<?php echo base_url('merchant/stop_recurring')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error  data');
                }
            });
        }
    }

    function start_pak(id) {
        if(confirm('Are you sure Start Recurring?')) {
            $.ajax({
                url : "<?php echo base_url('merchant/start_recurring')?>/"+id,
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

    var rows_selected = [];
    var globalPaybelAmount=0;
    function calcaulatHold(obj){
        var PayableAmount=globalPaybelAmount;    
        var holdamount=PayableAmount-$("#Hold_Amount").val();
        $(document).ready(function() {
            var PayableAmount=globalPaybelAmount;    
            var gHoldamount=PayableAmount-$("#Hold_Amount").val();
            $('#holdrow [type="checkbox"]').each(function(i, chk) {
                if (chk.checked) {
                    oblhod=parseFloat($(chk).data("amount"));
                    gHoldamount=oblhod+gHoldamount;
                    console.log(oblhod,holdamount);          
                }else{
                }
            });
            gHoldamount=parseFloat(gHoldamount);
            gHoldamount=gHoldamount.toFixed(2);
            $("#PayableAmount2").val(gHoldamount);
            gHoldamount=(gHoldamount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            $("#PayableAmount").val(gHoldamount);
        });
    }

    $(document).ready(function(){
        $(document).on('click', '#getUser', function(e){
            e.preventDefault();
            var uid = $(this).data('id');
            var date = $(this).data('date');
            $('#dynamic-content').html('');
            $('#modal-loader,.modal-loader').show();
            $.ajax({
                url: "<?php  echo base_url('dashboard/search_record_column2'); ?>",
                type: 'POST',
                data: 'id='+uid+"&date="+date,
                dataType: 'html'
            })
            .done(function(data){
                console.log(data);  
                $('#dynamic-content').html('');    
                $('#dynamic-content').html(data);
                $('#modal-loader,.modal-loader').hide();
            })
            .fail(function(){
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader,.modal-loader').hide();
            });
        });

        $(document).on('click', '#setamount', function(e){
            e.preventDefault();
            var amounnt = $(this).data('amount') ? $(this).data('amount') : 0;

            var holdAmount = $(this).data('holdamount') ? $(this).data('holdamount') : 0;
            holdAmount = parseFloat(holdAmount);
            globalPaybelAmount = amounnt;

            var cdate=$(this).data('date');
            var mid=$(this).data('mid');
            $("#Hold_Amount").val($(this).data('holdamount'));
            amounnt=parseFloat(amounnt);
            amounnt=amounnt.toFixed(2);
            amounnt2=(amounnt-holdAmount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");

            $("#PayableAmount").val(amounnt2);
            $("#PayableAmount2").val(amounnt-holdAmount);
            //$("#Hold_Amount").val(0);
            $("#popup_date").val(cdate);
            $("#popup_mearchent_id").val(mid);
            $('#dynamic-content').html('');
            $('#modal-loader,.modal-loader').show();
            
            $.ajax({
                url: "<?php  echo base_url('dashboard/get_holdamount'); ?>",
                type: 'POST',
                data: 'mid='+mid+'&cdate='+cdate+'&amounnt='+amounnt,
                dataType: 'html'
            })
            .done(function(data){
                $('#modal-loader,.modal-loader').hide();
                data = jQuery.parseJSON(data);    
                console.log(data);    
                $('#holdrow').html('');    
                $.each( data, function( key, value ) {
                    var amount=value['amount'];
                    var hold_amount=value['hold_amount'];
                    amount=(amount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                    hold_amount=(hold_amount + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                    $('#holdrow').append('<tr><td><input type="checkbox" onclick="calcaulatHold($(this));" data-amount="'+value['hold_amount']+'" value="'+value['id']+'" name="holdetext[]"></td><td>$'+amount+'</td><td>$'+hold_amount+'</td><td>'+value['date']+'</td><td>'+value['status']+'</td></tr>');
                });
                //$('#holdrow').html(data); // load response 
                console.log('done') 
            })
            .fail(function(){
                $('#modal-loader,.modal-loader').hide();
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                console.log('faail')
            });
        });

        $(document).on('click', '#getpos', function(e){
            e.preventDefault();
            var uid = $(this).data('id');
            $('#dynamic-content').html('');
            $('#modal-loader,.modal-loader').show();
            $.ajax({
                url: "<?php  echo base_url('dashboard/search_record_pos'); ?>",
                type: 'POST',
                data: 'id='+uid,
                dataType: 'html'
            })
            .done(function(data){
                console.log(data);  
                $('#dynamic-content').html('');    
                $('#dynamic-content').html(data);
                $('#modal-loader,.modal-loader').hide();
            })
            .fail(function(){
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader,.modal-loader').hide();
            });
        });
    });

    function validate(form) {
        if(rows_selected.length==0) {
            alert('Please select checkbox');
            return false;
        } else {
            $("#hideencheckbox").html(''); 
            $.each(rows_selected, function(index, rowId){
                $("#hideencheckbox").append($(rowId).attr("checked","checked"));      
            });
            return confirm('Do you really want to submit the form?');
        }
    }
</script>
<?php include_once'footer_dash.php'; ?>