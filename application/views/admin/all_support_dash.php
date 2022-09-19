<?php
	include_once 'header_dash.php';
	include_once 'sidebar_dash.php';
?>

<style>
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
			font-size: 25px !important;
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
    #allSupportExport{
        position: absolute;
        right: 15px;
    }
    #allSupportExport button.dt-button.buttons-collection{
        margin: 0 !important
    }
    #allSupportExport.reset-dataTable .dt-buttons {
        padding-top: 0px;
    }
    #allSupportExport table{
        display: none;
        width: 100%;
    }
    #allSupportExport div.dt-button-collection{
        left: auto !important;
        right: 0;
        display: block;
        margin-top: 0px !important;
    }
    /*.form_buttons {
        text-align: left !important;
        display: flex !important;
    }*/
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
                <div class="col-12 py-5-custom">
                    <!-- <h4 class="h4-custom">Dashboard</h4> -->
                </div>
            </div>

            <form class="row" method="post" action="<?php echo base_url('customer/all_support'); ?>" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span>
                            <?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?>
                        </span>
                        <input name="start_date" id="startDate" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>" >
                        <input name="end_date" id="endDate" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
                <div class="col form_buttons" style="text-align: right;">
                    <div id="allSupportExport" class="reset-dataTable"></div>
                </div>
            </form>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Message</th> 
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $i=1;
                            foreach($mem as $key => $a_data) {
                                $count++; ?>
                                <tr>
                                    <td><?php echo ($key+1) ?></td>
                                    <td><?php echo $a_data['name'] ?></td>
                                    <td><?php echo $a_data['phone'] ?></td>
                                    <td><?php echo $a_data['email'] ?></td>
                                    <td><?php echo $a_data['subject'] ?></td>
                                    <td><?php echo $a_data['add_date'] ?></td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#view-modall" data-id="<?php echo $a_data['id'];  ?>" id="getcredt" class="pos_Status_c badge-btn"><i class=" ti-eye "></i> View</a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="merchant_delete(<?php echo $a_data['id'];?>)"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="view-modall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h4 class="modal-title">
                    <i class="glyphicon glyphicon-user"></i>  Message
                </h4>
            </div>
            <div class="modal-body"> 
                <div id="modal-loader" class="text-center" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 44 44" stroke="#000"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="19.8669"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> <circle cx="22" cy="22" r="15.8844"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"></animate> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate> </circle> </g> </svg>
                </div>
                <div id="dynamic-content1">
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="input-group">
                                <textarea rows="3" class="form-control" name="message" id="message" type="text" readonly=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var dtConfigHiddenTable = {
        dom: 'Bfrtip', order: [],
        "buttons":
        [{
            extend: 'collection',
            text: '<span>Export List</span> <i class="fa fa-download"></i>',
            buttons: [
                {
                    extend: 'csv',
                    titleAttr: 'Download CSV report',
                    text: '<i class="fa fa-file-text-o" aria-hidden="true"></i> CSV Report'
                },
                {
                    extend: 'excelHtml5',
                    titleAttr: 'Download Excel report',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel Report',
                   
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    titleAttr: 'Download PDF report',
                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF Report',
                    
                }
            ]
        }]
    };

    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#daterangeFilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // console.log(start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));
            $('#startDate').val(start.format('YYYY-MM-D'));
            $('#endDate').val(end.format('YYYY-MM-D'));
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

    $(document).ready(function() {
        var dtTransactionsConfig={
            "processing": true,
            // "sAjaxSource":"data.php",
            "pagingType": "full_numbers",
            "pageLength": 25,
            "dom": 'lBfrtip',
            responsive: true, 
            language: {
                search: '', searchPlaceholder: "Search",
                oPaginate: {
                    sNext: '<i class="fa fa-angle-right"></i>',
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                }
            },
            "buttons": [{
                extend: 'collection',
                text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }]
        }
        $('#datatable').DataTable(dtTransactionsConfig);
        allSupportExportDataFn();
    });

    $(document).on('click', '#getcredt', function(e){
        e.preventDefault();
        // $('#getcredt').on("click", function () {
        //var tax =  $('#myid').val();
        var tax = $(this).data('id');   // it will get id of clicked row
        $.ajax({
            type: 'POST',
            url: "<?php  echo base_url('customer/search_record_credntl'); ?>",
            data: {id: tax},
            type:'post',
            success: function (dataJson) {
                data = JSON.parse(dataJson)
                console.log(data)
                $(data).each(function (index, element) {
                    $('#message').val(element.message);
                });
            }
        });
    });

    function merchant_delete(id) {
        if(confirm('Are you sure delete this data?')) {
            $.ajax({
                url : "<?php echo base_url('customer/merchant_delete')?>/"+id,
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

    function allSupportExportDataFn() {
        var start = $("#daterangeFilter #startDate").val();
        var end = $("#daterangeFilter #endDate").val();
        // console.log(start, end);return false;

        $.ajax({
            url     : "<?= base_url('customer/allSupportExportData'); ?>",
            success : function (data){
                var data = JSON.parse(data);
                // console.log(data);return false;
                convertDataIntoTableForm($('#allSupportExport'), data.mem);
            }
        });
    }

    function convertDataIntoTableForm($wraper, tableData){
        // console.log($wraper);return false;
        var allRow='';
        var newTable = $('<table class="exportTable"><thead><th>Name</th><th>Phone</th><th>Email</th><th>Service</th><th>Date</th></thead><tbody></tbody></table>');

        if(!tableData) {
            allRow='<tr><td colspan="5" align="center">No data</td></tr>';
        } else {
            if(typeof tableData != 'object') {
                jsonData = JSON.parse(tableData);
            } else {
                jsonData = tableData;
            }

            jsonData.forEach(function(rowData, i) {
                allRow+=
                    '<tr><td>'+rowData.name
                    +'</td><td>'+rowData.phone
                    +'</td><td>'+rowData.email
                    +'</td><td>'+rowData.subject
                    +'</td><td>'+rowData.add_date
                    +'</td></tr>';
                // console.log(allRow);
            });
        }
        // console.log($wraper.find('table'));return false;
        newTable.find('tbody').html(allRow);
        $wraper.html(newTable);
        $wraper.find('table#exportTable').DataTable(dtConfigHiddenTable);
    }
</script>

<?php include_once 'footer_dash.php'; ?>