 
<?php

    foreach ($pay_report as $row) {
     
?>

      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
        <!-- <h4 class="modal-title">
          <i class="glyphicon glyphicon-user"></i> Payment Detail
        </h4>  -->
        <div class="irm-header-inner"> 
          <div class="row"> 
            <div class="col"> 
              <div class="irm-logo">
                <img src="<?php echo base_url()."logo/".$this->session->userdata('merchant_logo'); ?>" alt="logo">
              </div>
              <div class="irm-def">
                  <h4><?php echo ($this->session->userdata('business_dba_name')) ?  $this->session->userdata('business_dba_name'): ""; ?></h4>
                  <p><?php echo ($this->session->userdata('website')) ?  $this->session->userdata('website'): ""; ?></p>
                  <p><b>Telephone: </b> <?php echo ($this->session->userdata('m_business_number')) ?  $this->session->userdata('m_business_number'): ""; ?></p>
              </div>
            </div>
            <div class="col">
              <div class="irm-info">
                <h4>REFUND RECEIPT</h4>
                <p>Customer Copy</p>
                <p>INVOICE NO. <span><?php echo (isset($row->invoice_no) && !empty($row->invoice_no))? $row->invoice_no : "-"; ?></span></p>
                <p>REFUND DATE <span><?php 
                 if(isset($refundData[0]['add_date']) && !empty($refundData[0]['add_date']))
                 {
                   if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago')
                     {
                       $time_Zone=$this->session->userdata('time_zone');
                       date_default_timezone_set('America/Chicago');
                       $datetime = new DateTime($refundData[0]['add_date']);
                       $la_time = new DateTimeZone($time_Zone);
                       $datetime->setTimezone($la_time); 
                       $row->date_c=$datetime->format('Y-m-d H:i:s');
                     }
                     echo date("M d Y", strtotime($row->date_c));
                   }
                   else
                   {
                      echo '-';
                   }

               
                
                    ?></span></p>
              </div>
            </div>
          </div>
        </div>
      </div> 
      <div class="modal-body"> 
        <div class="row">
          <div class="col">
            <div class="irm-inv-to">
              <div class="irm-to-title"><span>Invoice To</span></div>
              <div class="irm-to-sign">
               <?php echo  $row->name; ?>
              </div>
              <div class="irm-to-sign">
                <img  src="<?php echo base_url(); ?>logo/<?php echo $row->sign; ?>" onerror="this.outerHTML ='-'" alt="-">
              </div>
              <div class="irm-to-sign">
              <small>* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</small><br/>
              <small>** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</small>
              </div>
              <!-- <div class="irm-to-status">
                <span>Payment Status: </span> 
                    <?php
                        if ($row->status == 'pending') 
                        {
                            echo '<span class="pos_Status_pend"> ' . ucfirst($row->status) . '  </span>';
                        } elseif ($row->status == 'confirm' || $row->status == 'Chargeback_Confirm') {
                            echo '<span class="pos_Status_c"> Paid </span>';
                        } elseif ($row->status == 'declined') {
                            echo '<span class="pos_Status_cncl"> ' . ucfirst($row->status) . ' </span>';
                        } elseif ($row->status == 'Refund') {
                            echo '<span class="status_refund"> Refund  </span>';
                        }
                    ?>
                </div> -->
            </div>
            <?php  if(count($refundData)){?>
            <div class="irm-inv-to">
              <div class="irm-to-title"><span>Refunded:</span></div>
              <div class="irm-to-sign">
              <?php 


          
                $ttlrefunded=0;
                foreach($refundData as $rowdata) {  
                  if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago')
                          {
                            $time_Zone=$this->session->userdata('time_zone');
                            date_default_timezone_set('America/Chicago');
                            $datetime = new DateTime($rowdata['add_date']);
                            $la_time = new DateTimeZone($time_Zone);
                            $datetime->setTimezone($la_time);
                            $rowdata['add_date']=$datetime->format('Y-m-d H:i:s');
                          }
                  
                  
                  ?>
                    <span class="total__refunds">
                      <span class="status_success">
                        $ 
                        <?php $refundAmount=$rowdata['amount']?$rowdata['amount']:$row->amount; echo number_format($refundAmount,2); 
                        $ttlrefunded += $rowdata['amount']?$rowdata['amount']:$row->amount;  ?>
                      </span> 
                      <span>On</span> 
                      <span>
                        <?php  if($rowdata['add_date']){ echo $newDate = date("F d, Y", strtotime($rowdata['add_date'])); }else{ echo '-'; } ?>
                      </span>
                    </span>
                  <?php  }
                    if(!$ttlrefunded)
                    {
                      $ttlrefunded=$row->amount;
                    }
                  ?>
              </div>
            </div>

            <?php }else{
               $ttlrefunded=0;
            } ?>


          </div>
          <div class="col">
            <div class="irm-pay-detail">

            <div class="recipt" style="clear: both;width: 100%;">
                      <?php   
                      if(isset($item) && count($item) >0 ){

                        $recipt='<table style="max-width: 555px;width: 100%;font-size: 14px;" cellspacing="0">';
                        $recipt.='<thead>
                                    <tr>
                                      <td colspan="5" style="font-weight: 600;     padding: 5px 7px; ">All Items</td>
                                    </tr>
                                  </thead><tbody>';
                            $i=1;
                            $subtotalamt=0;
                        foreach($item as $pos){
                            $recipt=$recipt.'<tr><td style="padding: 5px 1px;"></td><td style="padding: 5px 1px;">'.$pos['name'].'</td><td style="padding: 5px 1px;">'.$pos['quantity'].'</td><td style="padding: 5px 1px;">$'.number_format($pos['price'],2).'</td></tr>';
                            $subtotalamt=$subtotalamt+$pos['price']; 
                            $i++;
                                        
                        }
                        $recipt.='<tfoot style="border-top:1px solid lightgray;" ><tr><td style="padding: 5px 1px;"></td><td style="padding: 5px 1px;">Total : </td><td style="padding: 5px 1px;"></td><td style="padding: 5px 1px;">$'.number_format($subtotalamt,2).'</td></tr></tfoot></tbody>';
                        $recipt.="</table>";
                        echo $recipt;
                              }else{ $subtotalamt=0;}
                        ?>
                
            </div>

              <div class="irm-pay-title"><span>Payment Details</span></div>
              <div class="irm-pay-detail">

              <?php
                 if($row->transaction_type == 'split')
                 {   ?>
                 
                 <p><span>Sub Amount : </span> $<b ><?php  echo  $subtotalamt? number_format($subtotalamt,2):number_format($row->full_amount,2); ?></b></p>
                  <?php  if(isset($row->discount) && $row->discount!='0' && $row->discount!='' ){
                      //$DisAmount=($row->total_amount*(int) str_replace('$','',str_replace('%','',$row->discount)) )/100;
                      
                      $DisAmount = $row->tax + $row->total_amount - $row->full_amount;
                      if($DisAmount!=0)
                      {  ?>
                       
                      <p><span>Total Discount:</span>-$<b ><?php echo $DisAmount;  ?></b></p>
                    <?php   } } 

                    if(isset($item) && count($item) > 0  && $row->tax  > 0){ ?>
                          <p><span>Total Taxes :</span> $<b ><?php echo number_format($row->tax,2);  ?></b></p>
                    <?php }  ?> 

                    <p><span> Total Amount :</span> <b class="srpttlAmt"><?php echo (isset($row->full_amount) && !empty($row->full_amount)) ? '$ '. $row->full_amount : "-"; ?></b></p>
                    <?php if(isset($row->tip_amount) && !empty($row->tip_amount) && $row->tip_amount!=0) {?> 
                    <p><span>Total Tip :</span> $<b ><?php echo (isset($row->tip_amount) && !empty($row->tip_amount))? $row->tip_amount : "-"; ?></b></p>
                    <?php } ?>
                    <p><span>Split Amount :</span> <?= !empty($row->amount) ? '$ '.$row->amount : "-"; ?></p>
                    <p class="pos_Status_c"><span>Refunded Amount :</span> $<b class="srpttlAmt"><?php   $refund=$refundData[0]['amount']?$refundData[0]['amount']:$row->amount; echo number_format($refund,2);   ?></b></p>
                    <p><span>Transaction Id :</span> <?php echo $refundData[0]['transaction_id']?$refundData[0]['transaction_id']:'-'; ?></p>
                <?php }
                 else
                 {  ?>
                    <p><span>Sub Amount : </span> $<b ><?php  echo  number_format($row->total_amount,2); ?></b></p>
                    <?php  if(isset($row->discount) && $row->discount!='0' && $row->discount!='' ){
                        //$DisAmount=($row->total_amount*(int) str_replace('$','',str_replace('%','',$row->discount)) )/100;
                        $DisAmount=$row->tax+$row->total_amount-$row->amount;
                        if($DisAmount!=0)
                        {  ?>
                        <p><span>Total Discount:</span>-$<b ><?php echo $DisAmount;  ?></b></p>
                      <?php   } } 

                      if(isset($item) && count($item) > 0  && $row->tax  > 0){ ?>
                            <p><span>Total Taxes :</span> $<b ><?php echo number_format($row->tax,2);  ?></b></p>
                      <?php }  ?> 

                      <p><span> Total Amount :</span> <b class="srpttlAmt"><?php echo (isset($row->amount) && !empty($row->amount)) ? '$ '. number_format($row->amount,2) : "-"; ?></b></p>

                      <?php if(isset($row->tip_amount) && !empty($row->tip_amount) && $row->tip_amount!=0) {?> 
                      <p><span>Total Tip :</span> $<b ><?php echo (isset($row->tip_amount) && !empty($row->tip_amount))? $row->tip_amount : "-"; ?></b></p>
                      <?php } ?>
                      <p><span>Total Payable Amount :</span> $<b class="srpttlAmt"><?php echo (isset($row->amount) && !empty($row->amount) && $row->tax=='CNP' )? $row->amount+$row->tax :$row->amount; ?></b></p>
                      <p class="pos_Status_c"><span>Refunded Amount :</span> $<b class="srpttlAmt"><?php   $refund=$refundData[0]['amount']?$refundData[0]['amount']:$row->amount; echo number_format($refund,2);   ?></b></p>
                      <p><span>Transaction Id :</span> <?php echo $refundData[0]['transaction_id']?$refundData[0]['transaction_id']:'-'; ?></p>
               <?php   }
              ?>


                <!-- <p><span>Reference :</span> <?php echo (isset($row->reference) && !empty($row->reference))? $row->reference : "-"; ?></p> -->
                <?php 
                  if(isset($row->card_type) && !empty($row->card_type) && ( $row->c_type=='CNP' ||  $row->c_type=='CP' ) )
                  { ?>
                    <p><span>Card Type :</span> <?php echo (isset($row->card_type) && !empty($row->card_type))? $row->card_type : "-"; ?></p>
                    <p><span>Last 4 digits on card :</span> <?php echo (isset($row->card_no) && !empty($row->card_no))? substr($row->card_no,-4) : "-"; ?></p>
                    <?php if(isset($row->name) && !empty($row->name)) { ?>
                    <p><span>Customer Name :</span>  <?php echo (isset($row->name) && !empty($row->name))? ucfirst($row->name) : "-"; ?></p>
                    <?php }
                  }else if(isset($row->card_type) && !empty($row->card_type) && $row->card_type=='CHECK')
                  {  ?>
                  <p><span>Payment Mode :</span> <?php echo (isset($row->card_type) && !empty($row->card_type))? $row->card_type : "-"; ?></p>
                  <p><span>Check No:</span> <?php echo (isset($row->card_no) && !empty($row->card_no)) ? $row->card_no : "-"; ?></p>
                  <?php }
                  else 
                  { ?> 
                  <p><span>Payment Mode :</span> <?php echo (isset($row->card_type) && !empty($row->card_type))? $row->card_type : "-"; ?></p>
                  <?php }
                  ?>
                
              
              </div>
              



            </div>
          </div>
        </div>
       

      </div> 
      <div class="modal-footer"> 
          <div class="col-12">
            <div class="row">
              <div class="col text-right">
                <button type="button" id="receiptSSendRequestPdf" name="submit" class="btn btn-first">Save as PDF</button>
                <button type="button" id="receiptSSendRequestPrint" name="submit" class="btn btn-second">Print Receipt</button>
              </div>
            </div>
          </div>

        
      </div> 

<?php } ?>


<script>
$(document).ready(function(){
$("input[name=allpos__reftypes]").change(function(){
var vals=$(this).val(); 
console.log(vals)
if(parseInt(vals))
{
  $('.partRefund__amount').val('').attr('readonly','readonly');
}else{
  $('.partRefund__amount').val('').removeAttr('readonly').focus();

}
}); 
$(".partRefund__amount").on('blur',function(){
var valsM=parseFloat($(this).attr('data-max')); 
var newvals=parseFloat($(this).val()); 
if(newvals >= valsM)
{ 
  $(".partRefund__amount").css({'color': 'initial'}).val('');;
  $('#allpos_fulref').trigger('click');
}
}); 
$(".partRefund__amount").on('keyup',function(){
var valsM=parseFloat($(this).attr('data-max')); 
var newvals=parseFloat($(this).val());
$this=$(this);
if(newvals > valsM)
{ 
  // $('#transactioninv__fullrefund').trigger('click');
    $this.css({'color': '#d0021b'});
}
else{
  $this.css({'color': 'initial'});
}
}); 
});
function re_receipt(el,rowid)
 {
$this=$(el);
$this.html('<span class="fa fa-spinner fa-spin"></span> Receipt Re-Send');
  // alert(id); 
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url('merchant/re_receipt'); ?>',   //  re_receipt_pos
    data: {'rowid':rowid ,'type':'all_request'},
    success: function (data){
       
       //$('.bbg').html(data);
        if(data=='200')
        {
          // $('.rcptbtn').hide(); 
          $this.html('<span class="fa fa-check status_success"></span> Receipt Re-Send');
          setTimeout(function(){$this.html('Receipt Re-Send')},2000);
          // //alert('Receipt re-send Successfully ...'); 
          // $('.bbg').html('<span class="text-success"> Receipt re-send Successfully ...</span>');
        }
    }
  });
 }
</script>
