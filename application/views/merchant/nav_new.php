<!-- Top Bar Start -->
<div class="topbar">
    <form class="custom-form">
        <div class="form-group">
            <div class="toggle-sidebar">
                <span class="float-buttons"><i  class=" material-icons menu-icon">menu</i></span>
            </div>
        </div>
        <div class="form-group">
            <div class="notification-wrapper dropdown">
                <?php 
              
                if($this->session->userdata('merchant_user_type')=='merchant') {
                 $merchant_id=$this->session->userdata('merchant_id'); 

                 $time_Zone=$this->session->userdata('time_zone') ? $time_Zone=$this->session->userdata('time_zone') :'America/Chicago'; 
                 date_default_timezone_set($time_Zone); 
                  
                 $date=date('Y-m-d'); 

                  // due_date 
                 //$requestedPaidRecords=$this->db->query("SELECT * from pos where merchant_id='$merchant_id' AND  date_c < $date and (`status`='confirm' ||  `status`='Chargeback_Confirm' ) order by due_date DESC")->result_array(); 
                 
                 $requestedPaidRecords=$this->db->query("SELECT * from pos where merchant_id='$merchant_id' AND (`status`='confirm' OR `status`='Chargeback_Confirm' ) AND   date_c BETWEEN '2019-08-20' AND '$date'  order by id DESC limit 0,30 ")->result_array(); 
                 
                 foreach($requestedPaidRecords as $duedata){
                    $merchantId=$upd['merchant_id']=$duedata['merchant_id']?$duedata['merchant_id']:""; 
                    $upd['notification_type']='payment'; 
                    $upd['name']=$duedata['name'] ? $duedata['name']:"";     
                    $upd['mobile']=$duedata['mobile_no']?$duedata['mobile_no']:""; 
                    $upd['email']=$duedata['email_id']?$duedata['email_id']:""; 
                    $upd['card_type']=$duedata['card_type']?$duedata['card_type']:""; 
                    $date_c=$duedata['date_c']?$duedata['date_c']:""; 
                    $upd['card_expiry_month']=$duedata['expiry_month']?$duedata['expiry_month']:"";
                    $upd['card_expiry_year']=$duedata['expiry_year']?$duedata['expiry_year']:"";   
                    $upd['card_no']=$duedata['card_no']?$duedata['card_no']:"";
                    $upd['amount']=$duedata['amount']?$duedata['amount']:""; 
                    $upd['address']=$duedata['address']?$duedata['address']:""; 
                    $transaction_id=$upd['transaction_id']=$duedata['transaction_id']?$duedata['transaction_id']:""; 
                    $invoice_no=$upd['invoice_no']=$duedata['invoice_no']?$duedata['invoice_no']:""; 
                    $upd['transaction_date']=$duedata['payment_date']?$duedata['payment_date']:""; 
                    $upd['status']='unread'; 
                    $query = $this->db->query(" SELECT * FROM `notification` WHERE invoice_no='$invoice_no' AND transaction_id='$transaction_id'   AND  merchant_id='$merchantId'  ");
                    $noOfNotification=$query->num_rows();
                    $getnotification=$query->result_array();

                    if(count($getnotification) <= 0 || $noOfNotification <= 0)
                    {
                        $this->db->insert('notification',$upd);  
                    }
                    
                 }



                 $requestedRecords=$this->db->query("SELECT * from customer_payment_request where merchant_id='$merchant_id' AND   DATE_FORMAT(CONVERT_TZ(due_date, '-5:00', '+5:30'),'%Y-%m-%d') < $date and status='pending' order by due_date DESC")->result_array(); 
                 //echo count($requestedRecords);  echo "This Record"; die();
                 foreach($requestedRecords as $duedata){
                   
                    $merchantId=$upd['merchant_id']=$duedata['merchant_id']?$duedata['merchant_id']:""; 
                    $upd['notification_type']='late'; 
                    $upd['name']=$duedata['name'] ? $duedata['name']:"";     
                    $upd['mobile']=$duedata['mobile_no']?$duedata['mobile_no']:""; 
                    $upd['email']=$duedata['email_id']?$duedata['email_id']:""; 
                    $upd['card_type']=$duedata['card_type']?$duedata['card_type']:""; 
                    $date_c=$duedata['date_c']?$duedata['date_c']:""; 
                    $upd['card_expiry_month']="";
                    $upd['card_expiry_year']="";    
                    $upd['card_no']=$duedata['card_no']?$duedata['card_no']:"";
                    $upd['amount']=$duedata['amount']?$duedata['amount']:""; 
                    $upd['address']=$duedata['address']?$duedata['address']:""; 
                    $transaction_id=$upd['transaction_id']=$duedata['transaction_id']?$duedata['transaction_id']:""; 
                    $invoice_no=$upd['invoice_no']=$duedata['invoice_no']?$duedata['invoice_no']:""; 
                    $upd['transaction_date']=$duedata['due_date']?$duedata['due_date']:""; 
                    $upd['status']='unread'; 
                    //(EmpTown = 'London' AND EmpAge > 30) OR EmpTown = 'Swindon'  
                    $query = $this->db->query(" SELECT * FROM `notification` WHERE invoice_no='$invoice_no' AND    AND  merchant_id='$merchantId' ");
                    $noOfNotification=$query->num_rows();
                    $getnotification=$query->result_array();

                    if(count($getnotification) <= 0 || $noOfNotification <= 0)
                    {
                        $this->db->insert('notification',$upd);  
                    }
                    
                 }

                 if($this->session->userdata('merchant_id'))
                 {   
                     $table='notification'; 
                     $merchant_id=$this->session->userdata('merchant_id'); 
                     
                     $this->db->select('*');
                     $this->db->from($table);
                     $this->db->where('merchant_id',$merchant_id);
                     $this->db->where('status','unread');
                     $this->db->limit(100);

                     $this->db->order_by("transaction_date", "desc");
                     $query = $this->db->get();
                     $noOfNotification=$query->num_rows();
                     $notificationdata=$query->result_array();
 
                 }else{  $notificationdata=array();$noOfNotification=0;  }    


                 ?>
 


                <div class="noticfication-count float-buttons" data-toggle="<?php if(count($notificationdata)>0) echo 'dropdown'; ?>">
                    <img src="<?php echo base_url('new_assets/img/notification.png'); ?>" alt="notification">
                  <?php   if($noOfNotification >0) {
                        ?>
                    <span class="n-counts" style="font-size:10px; "><?php echo ($noOfNotification=='100')? '99+':$noOfNotification; ?></span>
                    <?php } ?>
                </div>
            
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="notification-content">
                        <div class="notification-header">
                            <span class="float-right clear-all-btn">
                                <a href="javascript:void(0)" onclick="clear_allnotification(<?php echo $merchant_id; ?>)" > Clear All </a>
                            </span>
                            <span>Notification</span>
                        </div>
                        

                         <?php  if(count($notificationdata)) { ?>
                         <div class="notification-body " >
                            <div class="no-notification-msg"> There is no notification!! </div>
                            <div class="notification-body-inner" >
                              
                         <?php  
                         
                         
                     if($noOfNotification > 0) {
                       
                             //echo $row[0]['name'];
                            //  echo $this->db->last_query();
                        //  print_r($notificationdata);  die;
                        
                         foreach($notificationdata  as $row) { 
                            
                                
                                if($row['name']!="")
                                {
                                $customer_name=$row['name'];
                                }
                                else if($row['name']=="" && $row['mobile']!="")
                                {
                                $customer_name=$row['mobile'];
                                }
                                elseif($row['name']=="" && $row['mobile']=="" && $row['email']!="" )
                                {
                                $customer_name=$row['email']; 
                                }
                                else
                                {
                                    $customer_name="No-name"; 
                                }
                              switch($row['notification_type'])
                             {
                                    case 'payment':
                                    $nmsg='<span>'.strtoupper($customer_name).'</span><span> $'.$row['amount'].'<span class="pos_Status_c"> Paid</span>';
                                     // $nmsg=strtoupper($row['invoice_no']).'  -  ( $'.$row['amount'].' <span class="pos_Status_c">Paid</span>)';
                                     // $color='pos_Status_c';  
                                    break; 
                                    case 'late':
                                    $nmsg='<span>'.strtoupper($customer_name).'</span><span> $'.$row['amount'].'<span class="pos_Status_cncl"> Late</span>';
                                    // $nmsg=strtoupper($row['invoice_no']).'  -  ($'.$row['amount'].' <span class="pos_Status_cncl">Late</span>)';
                                    // $color='pos_Status_cncl'; 
                                    break;

                                    default :
                                    $nmsg='you have No Notification here...';
                                    // $color=''; 
                                    break; 
                             }
                               //= 'payment'
                             ?>    <div class="notification-item">
                                        <a href="<?php echo base_url('merchant/readnotofication/').$row['id']; ?>"  class="dropdown-item ">
                                            <span class="notify-details"><?php echo   $nmsg; ?></span>
                                        </a>
                                    </div>
                                 <?php    }   } ?>
                                
                                </div>
                            </div>
                     <?php  }else{ ?>
                        <div class="notification-body " >
                            <div class="notification-item">
                                <a href="javascript:void(0);" class="dropdown-item">
                                   <small>You have No Notification here...</small>
                                </a>
                            </div>
                        </div>
                    <?php }   } ?>
                                    
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    var XMLHttpRequestObject = false;
    var base_url = '//salequick.com/';
    var base_url_no_index = '//salequick.com/';
</script>
<!-- Top Bar End --> 
<style>
  .notification-content .notification-body a .notify-details{
  margin-left: 0px;
  }
  .notify-details{text-align: right;}
  .notify-details >span:first-child {
  float: left;
  max-width: 134px;
  overflow: hidden;
  text-overflow: ellipsis;
  }
  .notify-details >span span {
  font-size: 11px;
  }
</style>

<script>
   function checknotification(NotiId)
   {
    
    $.ajax({
          type: 'POST',
          url: '<?php echo base_url('merchant/readnotofication'); ?>',
          data: {'id':NotiId },
          type:'post',
          success: function (dataJson){
              data = JSON.parse(dataJson)
              console.log(data)
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

   function clear_allnotification(merchantid)
   {
    $.ajax({
          type: 'POST',
          url: '<?php echo base_url('merchant/readallnotofication'); ?>',
          data: {'merchantid':merchantid },
          type:'post',
          success: function (data){
              //data = JSON.parse(dataJson)
              //console.log(data)
              if(data=='200')
              {
                 $('.notification-item').remove(); 
                 $('.n-counts').remove();
                 //$('.noticfication-count').data('toggle','rtgrtrt');
                 // $(".notification-wrapper .noticfication-count float-buttons").removeAttr("data-toggle");
              }
              
          }
        });
   }
 
</script>