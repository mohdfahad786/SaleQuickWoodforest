<style>
    .page-title {
        width: 100%;
        text-align: center;
        margin-left: 17rem;
    }
    .header-fixed .t-header {
        z-index: 1 !important;
    }
    .header-fixed .sidebar {
        padding-top: 0px !important;
    }
    .t-header {
        background-color: #fff !important;
    }
    .sidebar-foot-div {
        padding: 5px 30px;
    }
    .sidebar-foot-hr {
        border-top: 1px solid rgba(0,0,0,.1);
    }
    .sidebar-foot-sm {
        color: #868e96;
        font-family: AvenirNext-Medium;
    }
    .sidebar-foot-md {
        color: rgb(105, 105, 105);
        font-size: 12px;
        font-weight: 400;
        font-family: AvenirNext-Medium;
    }
</style>
<nav class="t-header">
    <div class="t-header-content-wrapper">
        <div class="t-header-content">
            <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="page-title">
                <h4 class="h4-custom"><?php echo $meta; ?></h4>
            </div>
            <ul class="nav ml-auto" style="margin-top: -4px !important;">
                <?php if($this->session->userdata('merchant_user_type')=='merchant') {
                    $merchant_id=$this->session->userdata('merchant_id'); 
                    // $time_Zone=$this->session->userdata('time_zone') ? $time_Zone=$this->session->userdata('time_zone') :'America/Chicago'; 
                    // date_default_timezone_set($time_Zone);
                    $date=date('Y-m-d');
                 
                    // $requestedPaidRecords=$this->db->query("SELECT * from pos where merchant_id='$merchant_id' AND (`status`='confirm' OR `status`='Chargeback_Confirm' ) AND   date_c BETWEEN '2019-08-20' AND '$date'  order by id DESC limit 0,30 ")->result_array(); 
                 
                    // foreach($requestedPaidRecords as $duedata){
                    //     $merchantId=$upd['merchant_id']=$duedata['merchant_id']?$duedata['merchant_id']:""; 
                    //     $upd['notification_type']='payment'; 
                    //     $upd['name']=$duedata['name'] ? $duedata['name']:"";     
                    //     $upd['mobile']=$duedata['mobile_no']?$duedata['mobile_no']:""; 
                    //     $upd['email']=$duedata['email_id']?$duedata['email_id']:""; 
                    //     $upd['card_type']=$duedata['card_type']?$duedata['card_type']:""; 
                    //     $date_c=$duedata['date_c']?$duedata['date_c']:""; 
                    //     $upd['card_expiry_month']=$duedata['expiry_month']?$duedata['expiry_month']:"";
                    //     $upd['card_expiry_year']=$duedata['expiry_year']?$duedata['expiry_year']:"";   
                    //     $upd['card_no']=$duedata['card_no']?$duedata['card_no']:"";
                    //     $upd['amount']=$duedata['amount']?$duedata['amount']:""; 
                    //     $upd['address']=$duedata['address']?$duedata['address']:""; 
                    //     $transaction_id=$upd['transaction_id']=$duedata['transaction_id']?$duedata['transaction_id']:""; 
                    //     $invoice_no=$upd['invoice_no']=$duedata['invoice_no']?$duedata['invoice_no']:""; 
                    //     $upd['transaction_date']=$duedata['payment_date']?$duedata['payment_date']:""; 
                    //     $upd['status']='unread'; 
                    //     $query = $this->db->query(" SELECT * FROM `notification` WHERE invoice_no='$invoice_no' AND transaction_id='$transaction_id'   AND  merchant_id='$merchantId'  ");
                    //     // $noOfNotification=$query->num_rows();
                    //     $getnotification=$query->result_array();
                    //     $noOfNotification= count($getnotification);

                    //     if(count($getnotification) <= 0 || $noOfNotification <= 0) {
                    //         $this->db->insert('notification',$upd);
                    //     }
                    // }

                    // $requestedRecords=$this->db->query("SELECT * from customer_payment_request where merchant_id='$merchant_id' AND   DATE_FORMAT(CONVERT_TZ(due_date, '-5:00', '+5:30'),'%Y-%m-%d') < $date and status='pending' order by due_date DESC")->result_array();
                    // foreach($requestedRecords as $duedata) {
                    //     $merchantId=$upd['merchant_id']=$duedata['merchant_id']?$duedata['merchant_id']:""; 
                    //     $upd['notification_type']='late'; 
                    //     $upd['name']=$duedata['name'] ? $duedata['name']:"";     
                    //     $upd['mobile']=$duedata['mobile_no']?$duedata['mobile_no']:""; 
                    //     $upd['email']=$duedata['email_id']?$duedata['email_id']:""; 
                    //     $upd['card_type']=$duedata['card_type']?$duedata['card_type']:""; 
                    //     $date_c=$duedata['date_c']?$duedata['date_c']:""; 
                    //     $upd['card_expiry_month']="";
                    //     $upd['card_expiry_year']="";    
                    //     $upd['card_no']=$duedata['card_no']?$duedata['card_no']:"";
                    //     $upd['amount']=$duedata['amount']?$duedata['amount']:""; 
                    //     $upd['address']=$duedata['address']?$duedata['address']:""; 
                    //     $transaction_id=$upd['transaction_id']=$duedata['transaction_id']?$duedata['transaction_id']:""; 
                    //     $invoice_no=$upd['invoice_no']=$duedata['invoice_no']?$duedata['invoice_no']:""; 
                    //     $upd['transaction_date']=$duedata['due_date']?$duedata['due_date']:""; 
                    //     $upd['status']='unread'; 
                    //     //(EmpTown = 'London' AND EmpAge > 30) OR EmpTown = 'Swindon'  
                    //     $query = $this->db->query(" SELECT * FROM `notification` WHERE invoice_no='$invoice_no' AND  merchant_id='$merchantId' ");
                    //     // $noOfNotification=$query->num_rows();
                    //     $getnotification=$query->result_array();
                    //     $noOfNotification= count($getnotification);

                    //     if(count($getnotification) <= 0 || $noOfNotification <= 0) {
                    //         $this->db->insert('notification',$upd);  
                    //     }
                    // }

                    if($this->session->userdata('merchant_id')) {
                        $table='notification'; 
                        $merchant_id=$this->session->userdata('merchant_id'); 
                        $this->db->select('*');
                        $this->db->from($table);
                        $this->db->where('merchant_id',$merchant_id);
                        $this->db->where('status','unread');
                        $this->db->order_by("id", "desc");
                        $this->db->limit(100);
                        $this->db->order_by("transaction_date", "desc");
                        $query = $this->db->get();
                        // $noOfNotification=$query->num_rows();
                        $notificationdata=$query->result_array();
                        //print_r($notificationdata);
                        $noOfNotification= count($notificationdata);
 
                    } else {
                        $notificationdata = array();
                        $noOfNotification = 0;
                    } ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="notificationDropdown" data-toggle="<?php if(count($notificationdata)>0) echo 'dropdown'; ?>">
                            <?php echo ( (count($notificationdata)>0) ? '<i class="mdi mdi-bell mdi-2x" style="color: red;"></i>' : '<i class="mdi mdi-bell-outline mdi-2x" style="color: deepskyblue;"></i>' )  ; ?>
                        </a>
                        <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
                            <div class="dropdown-header">
                                <h6 class="dropdown-title">Notifications</h6>
                                <div class="row">
                                    <div class="col-sm-8 col-md-8 col-lg-8">
                                        <?php if($noOfNotification >0) { ?>
                                            <p class="dropdown-title-text"><?php echo ($noOfNotification=='100')? '99+':$noOfNotification; ?> unread notification</p>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <strong>
                                            <a href="javascript:void(0)" onclick="clear_allnotification(<?php echo $merchant_id; ?>)">Clear All</a>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-body">
                                <!-- Notification listing begin -->
                                <div class="dropdown-list">
                                    <div class="content-wrapper">
                                        <?php if($noOfNotification > 0) {
                                            foreach($notificationdata as $row) {
                                                if($row['name']!="") {
                                                    $customer_name=$row['name'];
                                                } else if($row['name']=="" && $row['mobile']!="") {
                                                    $customer_name=$row['mobile'];
                                                } elseif($row['name']=="" && $row['mobile']=="" && $row['email']!="" ) {
                                                    $customer_name=$row['email']; 
                                                } else {
                                                    $customer_name="No-name"; 
                                                }
                                                switch($row['notification_type']) {
                                                    case 'payment':
                                                        $nmsg = '<div class="col-sm-12 col-md-12 col-lg-12 notification-name">'.strtoupper($customer_name).'</div><div class="col-sm-12 col-md-12 col-lg-12"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 notification-amount">$'.$row['amount'].'</div><div class="col-sm-6 col-md-6 col-lg-6 text-right notification-status-paid">Paid</div></div></div>';
                                                        break;
                                                        case 'invoice':
                                                        $nmsg = '<div class="col-sm-12 col-md-12 col-lg-12 notification-name">'.strtoupper($customer_name).'</div><div class="col-sm-12 col-md-12 col-lg-12"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 notification-amount">$'.$row['amount'].'</div><div class="col-sm-6 col-md-6 col-lg-6 text-right notification-status-paid">Paid</div></div></div>';
                                                        break;

                                                         case 'linkpay':
                                                        $nmsg = '<div class="col-sm-12 col-md-12 col-lg-12 notification-name">'.strtoupper($customer_name).'</div><div class="col-sm-12 col-md-12 col-lg-12"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 notification-amount">$'.$row['amount'].'</div><div class="col-sm-6 col-md-6 col-lg-6 text-right notification-status-paid">Paid</div></div></div>';
                                                        break;

                                                    case 'late':
                                                        $nmsg = '<div class="col-sm-12 col-md-12 col-lg-12 notification-name">'.strtoupper($customer_name).'</div><div class="col-sm-12 col-md-12 col-lg-12"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 notification-amount">$'.$row['amount'].'</div><div class="col-sm-6 col-md-6 col-lg-6 text-right notification-status-late">Late</div></div></div>';
                                                        break;

                                                    default :
                                                        $nmsg = '<div class="col-sm-12 col-md-12 col-lg-12 notification-name"><strong>No Notifications</strong></div>';
                                                        break; 
                                                } ?>
                                                <a href="<?php echo base_url('merchant/readnotofication/').$row['id']; ?>" style="padding: 0px 0px !important;">
                                                    <div class="row notification-listing">
                                                        <?php echo $nmsg; ?>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12 notification-name">No Notifications</div>
                                            </div>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                                <!-- Notification listing end -->
                            </div>
                            <!-- <div class="dropdown-footer">
                                <a href="#">View All</a>
                            </div> -->
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<script type="text/javascript">
    var XMLHttpRequestObject = false;
    var base_url = '//salequick.com/';
    var base_url_no_index = '//salequick.com/';
</script>

<script>
    function checknotification(NotiId) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/readnotofication'); ?>',
            data: {'id':NotiId },
            type:'post',
            success: function (dataJson){
                data = JSON.parse(dataJson)
                // console.log(data)
                $('#saleChart').data('vals',data.item3);
                saleSummeryPdfTableConvertor($('#salesChartExportDt'),data.item3)
                var a=data.getDashboardData[0].TotalAmount;
                var b=data.getDashboardData[0].TotalAmountRe;
                var c=data.getDashboardData[0].TotalAmountPOS;
                // console.log(a+b+c)
                updateSaleOrderChart(a ,b ,c )
            }
        });
    }

    function clear_allnotification(merchantid) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/readallnotofication'); ?>',
            data: {'merchantid':merchantid },
            type:'post',
            success: function (data){
                //data = JSON.parse(dataJson)
                //console.log(data)
                if(data=='200') {
                    $('.notification-item').remove(); 
                    $('.n-counts').remove();
                    //$('.noticfication-count').data('toggle','rtgrtrt');
                    // $(".notification-wrapper .noticfication-count float-buttons").removeAttr("data-toggle");
                }
            }
        });
    }
</script>