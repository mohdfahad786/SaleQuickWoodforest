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
    .dataTables_empty {
        text-align: center !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0em 0.5em !important;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        border:none !important;
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

            <form class="row" method="post" action="<?php echo base_url('dashboard/report'); ?>" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="daterangeFilter" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span><?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?></span>
                        <input name="start_date" id="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>" >
                        <input name="end_date" id="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >
                    </div>
                </div>
                <div class="table_custom_status_selector">
                    <select class="form-control"  name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <?php if (!empty($status) && isset($status)) {  ?>
                            <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?> >Pending</option>
                            <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?> >Confirm</option>
                            <option value="Chargeback_Confirm" <?php echo (($status == 'Chargeback_Confirm') ? 'selected' : "") ?> >Refund</option>
                        <?php } else { ?>
                            <option value="pending">Pending</option>
                            <option value="confirm">Confirm</option>
                            <option value="Chargeback_Confirm">Refund</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" id="btn-filter" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Merchant</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $i=1;
                            foreach($mem as $a_data) {
                                $count++; ?>
                                <tr>
                                    <td>
                                        <?php 
                                        $data = $this->admin_model->data_get_where_1('merchant', array('id' => $a_data['merchant_id'])); 
                                        foreach ($data as $view) { 
                                            echo $view['name'];
                                        } ?>
                                    </td>
                                    <td><?php echo $a_data['name'] ?></td>
                                    <td><?php echo $a_data['email'] ?></td>
                                    <td><?php echo $a_data['mobile'] ?></td>
                                    <td><?php echo $a_data['title'] ?></td>
                                    <td><?php echo $a_data['amount'] ?></td>
                                    <td><?php echo $a_data['payment_type'] ?></td>
                                    <td><?php echo $a_data['status'] ?></td>
                                    <td><?php echo $a_data['date'] ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['cid']; ?>" id="getUser" class="btn btn-sm btn-info"><i class="ti-eye"></i> View</button>
                                    </td>
                                </tr>
                                <?php $i++;
                            }?>
                        </tbody>
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
                <div id="modal-loader" style="display: none; text-align: center;">
                    <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>">
                </div>
                <div id="dynamic-content"></div>
            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
            </div> 
         </div> 
      </div>
</div>

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h4 class="modal-title"><i class="glyphicon glyphicon-user"></i> Payment Detail</h4>
            </div> 
            <div class="modal-body"> 
                <div id="modal-loader" style="display: none; text-align: center;">
                    <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>">
                </div>
                <div id="dynamic-content"></div>
            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
            </div> 
        </div> 
    </div>
</div>

<script>
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
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#daterangeFilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            $('#start_date').val(start.format('YYYY-MM-D'));
            $('#end_date').val(end.format('YYYY-MM-D'));
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

        $(document).on('click', '#getUser', function(e) {
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#dynamic-content').html(''); // leave it blank before ajax call
            $('#modal-loader').show();      // load ajax loader
            $.ajax({
                url: "<?php echo site_url('Admin/search_record_column_pos'); ?>",
                type: 'POST',
                data: 'id='+uid,
                dataType: 'html'
            })
            .done(function(data){
                console.log(data);
                $('#dynamic-content').html('');
                $('#dynamic-content').html(data); // load response
                $('#modal-loader').hide();      // hide ajax loader
            }) 
            .fail(function(){
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader').hide();
            });
        });

        $(document).on('click', '#getUserrecurring', function(e) {
            e.preventDefault();
            var uid = $(this).data('id');   // it will get id of clicked row
            $('#dynamic-content').html(''); // leave it blank before ajax call
            $('#modal-loader').show();      // load ajax loader
            $.ajax({
                url: "<?php echo base_url('admin/search_record_column_recurring'); ?>",
                type: 'POST',
                data: 'id='+uid,
                dataType: 'html'
            })
            .done(function(data){
                // console.log(data);
                $('#dynamic-content').html('');
                $('#dynamic-content').html(data); // load response
                $('#modal-loader').hide();      // hide ajax loader
            })
            .fail(function(){
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader').hide();
            });
        });
    });
</script>

<?php include_once'footer_dash.php'; ?>