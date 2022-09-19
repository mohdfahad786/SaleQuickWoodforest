<?php
    include_once 'header_dash.php';
    include_once 'sidebar_dash.php';
  //  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  //header('Pragma: no-cache');
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
    .dt-vw-del-dpdwn {
        text-align: right !important;
    }
    div.dataTables_wrapper div.dataTables_processing {
        display: none !important;
    }
    table.dataTable > tbody > tr.child ul li {
        padding: 0px !important;
        margin-right: 50px !important;
    }
    .show_revenue {
        cursor: pointer;
    }
    .rev_td {
        /*text-align: center !important;*/
        background-color: rgba(105, 105, 105, 0.5) !important;
        border: 1px solid #fff !important;
    }
    .rev_td span {
        font-size: 10px !important;
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

            <div id="form_div" class="row" style="margin-bottom: 20px !important;">
            <form class="row" method="post" action="<?php echo base_url('AgentRevenue'); ?>" style="margin-bottom: 20px !important;">
                <div class="table_custom_range_selector" style="width: auto;margin-right: 10px;margin-left: 5px !important;">
                    <div id="inv_pos_list_daterange" class="form-control date-range-style" style="border: none !important;margin-top: 5px;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <span><?php echo ((isset($start_date) && !empty($start_date))?(date("F-d-Y", strtotime($start_date)) .' - '.date("F-d-Y", strtotime($end_date))):('<label class="placeholder">Select date range</label>')) ?></span>
                        <input name="start_date" id="start_date" type="hidden" value="<?php echo (isset($start_date) && !empty($start_date))? $start_date : '';?>" >
                        <input name="end_date" id="end_date" type="hidden" value="<?php echo (isset($end_date) && !empty($end_date))? $end_date : '';?>" >
                    </div>
                </div>
                <div class="table_custom_status_selector">
                    <select class="form-control"  name="status" id="status" style="border: none !important;color: rgb(110, 110, 110) !important;font-family: Avenir-Heavy !important;">
                        <option value="">Select Status</option>
                        <?php if (!empty($status) && isset($status)) {  ?>
                            <option value="confirm" <?php echo (($status == 'confirm') ? 'selected' : "") ?> >Paid</option>
                            <option value="Chargeback_Confirm" <?php echo (($status == 'Chargeback_Confirm') ? 'selected' : "") ?> >Refunded</option>
                            <option value="pending" <?php echo (($status == 'pending') ? 'selected' : "") ?> >Declined</option>
                        <?php } else { ?>
                            <option value="confirm">Paid</option>
                            <option value="Chargeback_Confirm">Refunded</option>
                            <option value="pending">Declined</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <button class="btn btn-rounded social-btn-outlined" id="btn-filter" type="submit" name="mysubmit" value="Search"><i class="mdi mdi-magnify medium"></i>Submit</button>
                </div>
            </form>
            </div>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="hover row-border pos-list-dtable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Card Type</th>
                                <th>Merchant</th>
                                <th>Card No</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="no-event"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($mem as $a_data) { ?>
                                <tr>
                                    <td><?php echo $a_data['transaction_id']; ?></td>
                                    <td><span class="card-type-image" ><?php echo $a_data['card_no'] ?></span></td>
                                    <td>Corporative Inc</td>
                                    <td><?php echo $a_data['card_no'] ?></td>
                                    <td class="show_revenue"><h5 class="no-margin text-bold text-danger">$<?php echo number_format($a_data['amount'],2); ?></h5></td>
                                    <td>
                                        <?php if($a_data['status']=='pending') {
                                            echo '<span class="badge badge-pink"> '.$a_data['status'].'  </span>';
                                        } elseif ($a_data['status']=='confirm') {
                                            echo '<span class="badge badge-success"> '.$a_data['status'] .' </span>';
                                        } elseif ($a_data['status']=='declined') {
                                            echo '<span class="badge badge-danger"> '.$a_data['status'] .' </span>';
                                        } elseif ($a_data['status']=='Chargeback_Confirm') {
                                            echo '<span class="badge badge-pink"> Refund</span>';
                                        } else {
                                            echo '<span class="badge badge-pink"> '.$a_data['status'] .' </span>';
                                        } ?>
                                    </td>
                                    <td><?php echo $a_data['date'] ?></td>
                                    <td></td>
                                </tr>
                                <tr class="hidden_row">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="rev_td"><span>Revenue</span><br>$5.40</td>
                                    <td class="rev_td"><span>Cost</span><br>$4.80</td>
                                    <td class="rev_td"><span>Profit</span><br>$0.60</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if($('#inv_pos_list_daterange').length){
            var inv_pos_list_daterange_config = {
                ranges: {
                    Today: [new Date, new Date],Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), new Date],"Last 30 Days": [moment().subtract(30, "days"), new Date],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],"Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                },opens: "right",alwaysShowCalendars: true,locale: {format: "YYYY-MM-DD"},
                startDate: (($("#inv_pos_list_daterange input[name='start_date']").val().length > 0) ? ($("#inv_pos_list_daterange input[name='start_date']").val()) : (setTransactionDefDate(),moment().subtract(30, "days").format("YYYY-MM-DD"))),
                    endDate: (($("#inv_pos_list_daterange input[name='end_date']").val().length > 0) ? ($("#inv_pos_list_daterange input[name='end_date']").val()) : moment().format("YYYY-MM-DD"))
            };
            // console.log(inv_pos_list_daterange_config)
            $('#inv_pos_list_daterange').daterangepicker(inv_pos_list_daterange_config, function(a, b) {
                $("#inv_pos_list_daterange input[name='start_date']").val( a.format("YYYY-MM-DD"));
                $("#inv_pos_list_daterange input[name='end_date']").val( b.format("YYYY-MM-DD"));
                $("#inv_pos_list_daterange span").html(a.format("MMMM-D-YYYY") + " - " + b.format("MMMM-D-YYYY"));
                // setTransactionDefDate($("#pos_list_daterange span").data().d1,$("#pos_list_daterange span").data().d2);
            });
        }
    })

    $(document).ready(function() {
        var dtTransactionsConfig={
            "processing": true,
            "pagingType": "full_numbers",
            "pageLength": 25,
            "dom": 'lBfrtip',
            "order": [[ 7, "desc" ]],
            responsive: true, 
            language: {
                search: '', searchPlaceholder: "Search",
                oPaginate: {
                    sNext: '<i class="fa fa-angle-right"></i>',
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                }
            }
        }
        $('#datatable').DataTable(dtTransactionsConfig);
    })

    $(function() {
        $(".hidden_row").hide();
        $(".show_revenue").click(function(event) {
            event.stopPropagation();
            var $this = $(this);
            $next_row = $this.parent().next();
            if($next_row.hasClass('visibled')) {
                // $next_row.css('display', 'none');
                $next_row.slideUp();
                $next_row.removeClass('visibled');
            } else {
                // $next_row.css('display', 'block');
                $next_row.slideToggle();
                $next_row.addClass('visibled');
            }
            // var $target = $(event.target);
            // if ( $target.closest("td").attr("colspan") > 1 ) {
            //     $target.slideUp();
            // } else {
            //     $target.closest("tr").next().find("p").slideToggle();
            // }
        });
    });
</script>

<?php include_once'footer_dash.php'; ?>