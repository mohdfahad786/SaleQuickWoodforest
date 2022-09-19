        
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
                  <h4><?php echo ($this->session->userdata('business_dba_name')) ?  $this->session->userdata('business_dba_name'): "-"; ?></h4>
                  <p><b>Telephone: </b> <?php echo ($this->session->userdata('m_business_number')) ?  $this->session->userdata('m_business_number'): "-"; ?></p>
                </div>
              </div>
              <div class="col">
                <div class="irm-info">
                  <h4>RECEIPT</h4>
                  <p>Customer Copy</p>
                  <p>INVOICE NO. <span><?php echo (isset($invoice_detail_receipt[0]->invoice_no) && !empty($invoice_detail_receipt[0]->invoice_no))? $invoice_detail_receipt[0]->invoice_no : "-"; ?></span></p>
                  <p>RECEIPT DATE <span><?php 

                  if(isset($invoice_detail_receipt[0]->date_c) && !empty($invoice_detail_receipt[0]->date_c))
                  {
                    if($this->session->userdata('time_zone') && $this->session->userdata('time_zone')!='America/Chicago')
                    {
                      $time_Zone=$this->session->userdata('time_zone');
                      date_default_timezone_set('America/Chicago');
                      $datetime = new DateTime($invoice_detail_receipt[0]->date_c);
                      $la_time = new DateTimeZone($time_Zone);
                      $datetime->setTimezone($la_time);
                      $invoice_detail_receipt[0]->date_c=$datetime->format('Y-m-d H:i:s');
                    }
                    echo date("M d Y", strtotime($invoice_detail_receipt[0]->date_c));
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
            
            <div class="col-md-6">

              <div class="irm-inv-to">
                <div class="irm-to-title"><span>Invoice To</span></div>
                <div class="irm-to-sign">
                  <!-- <pre><?php echo $invoice_detail_receipt[0]->sign; ?></pre> -->
                   <?php   
                   // $length=strlen($invoice_detail_receipt[0]->sign); 
                   //$invoice_detail_receipt[0]->sign= substr($invoice_detail_receipt[0]->sign,0,$length-1); 
                   //echo '<pre>'.$s.'</pre>';    
                   if($invoice_detail_receipt[0]->sign!="") { 
                    $base64_string=$invoice_detail_receipt[0]->sign; 
                    $img = str_replace('data:image/png;base64,', '', $base64_string);
                    $img = str_replace(' ', '+', $img);  
                    $img = base64_decode($img);
                    $file='signature_'.uniqid().'.png';
                    $success=file_put_contents('uploads/sign/'.$file, $img);
                     ?>
                  <img src="<?php echo  base_url('uploads/sign/'); ?><?php echo $file; ?>" style="width: auto; max-width: 100%; max-height: 170px; "/>
                                                    
                  <!-- <img src="<?=$invoice_detail_receipt[0]->sign?>" style="width:200px; height:auto; "/> -->
                   <?php }elseif($invoice_detail_receipt[0]->name!="") {  ?> 
                  <span ><?=$invoice_detail_receipt[0]->name?></span>
                  <?php  }else{ ?><b>--</b><?php } ?>
                
                </div>
                <div class="irm-to-sign">
                    <small>* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</small><br/>
                    <small>** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</small>
                </div>
              </div>
            </div>
            <div class="col-md-6">
            <table style="width: 100%;font-size: 14px;clear: both;margin: 0 auto" cellspacing="0">
                <!-- <thead>
                  <tr>
                    <td colspan="2" style="font-weight: 600;">All Items</td>
                  </tr>
                </thead> -->
                <tbody style="border-bottom: 1px solid #ddd;">
                  <?php

                  $itemLength=count(json_decode($invoice_detail_receipt_item[0]['quantity']));
                  // echo $itemLength;
                  for($i=0; $i<$itemLength;  $i++)
                   { 
                    //json_decode($myJSON);
                    $quantity=json_decode($invoice_detail_receipt_item[0]['quantity']);
                    $price=json_decode($invoice_detail_receipt_item[0]['price']);
                    $tax=json_decode($invoice_detail_receipt_item[0]['tax']);
                    $tax_id=json_decode($invoice_detail_receipt_item[0]['tax_id']);
                    $tax_per=json_decode($invoice_detail_receipt_item[0]['tax_per']);
                    $total_amount=json_decode($invoice_detail_receipt_item[0]['total_amount']);
                    $item_name=json_decode($invoice_detail_receipt_item[0]['item_name']);
                  ?>
                  <tr>
                    <td style="padding: 5px 1px;"><?=$item_name[$i]; ?></td>
                    <td style="padding: 5px 1px;text-align: right;font-weight: 600;min-width: 85px;">$ <?=number_format($total_amount[$i],2); ?></td>
                  </tr>
                <?php }?>
                  <!-- <tr>
                    <td style="padding: 5px 1px;">Burger </td>
                    <td style="padding: 5px 1px;text-align: right;font-weight: 600;">$3.45</td>
                  </tr> -->
                </tbody>
                <tfoot>
                  <tr>
                    <td style="padding: 5px 1px;">Subtotal : </td>
                    <td style="padding: 5px 1px;text-align: right;font-weight: 600;">
                      <?php
                        $subttl1=$invoice_detail_receipt[0]->amount;
                        $subttl2=$invoice_detail_receipt[0]->tax; 
                        // settype($subttl1,float);
                        // settype($subttl2,float);
                        echo '$ '.number_format(($subttl1 - $subttl2),2);
                      ?>
                    </td>
                  </tr>
                  <?php if($itemLength > 0 && $invoice_detail_receipt[0]->tax > 0 ) { ?>
                    <tr>
                      <td style="padding: 5px 1px;">Tax : </td>
                      <td style="padding: 5px 1px;text-align: right;font-weight: 600;">
                        <?php echo (isset($invoice_detail_receipt[0]->tax) && !empty($invoice_detail_receipt[0]->tax))? '$'.$invoice_detail_receipt[0]->tax : "-"; ?>
                      </td>
                    </tr>
                   <?php } ?>
                 
                  <!-- <tr>
                    <td style="padding: 5px 1px;">Total Amount : </td>
                    <td style="padding: 5px 1px;text-align: right;font-weight: 600;"><?php echo (isset($invoice_detail_receipt[0]->amount) && !empty($invoice_detail_receipt[0]->amount))? '$'.$invoice_detail_receipt[0]->amount : "-"; ?></td>
                  </tr> -->
                </tfoot>
              </table>
              <div class="irm-pay-detail">
                <div class="irm-pay-title"><span>Payment Details</span></div>
                <div class="irm-pay-detail">
                  <p><span>Total Amount :</span> <b class="srpttlAmt"><?php echo (isset($invoice_detail_receipt[0]->amount) && !empty($invoice_detail_receipt[0]->amount))? '$'.$invoice_detail_receipt[0]->amount : "-"; ?></b></p>
                  <p><span>Transaction ID :</span> <?php echo (isset($invoice_detail_receipt[0]->transaction_id) && !empty($invoice_detail_receipt[0]->transaction_id))? $invoice_detail_receipt[0]->transaction_id : "-"; ?></p>
                  <p><span>Reference :</span> <?php echo (isset($invoice_detail_receipt[0]->reference) && !empty($invoice_detail_receipt[0]->reference))? $invoice_detail_receipt[0]->reference : "-"; ?></p>
                  <p><span>Card Type :</span> <?php echo (isset($invoice_detail_receipt[0]->card_type) && !empty($invoice_detail_receipt[0]->card_type))? $invoice_detail_receipt[0]->card_type : "-"; ?></p>
                  <!-- <p><span>Card Type :</span> <?php echo (isset($invoice_detail_receipt[0]->card_type) && !empty($invoice_detail_receipt[0]->card_type))? $invoice_detail_receipt[0]->card_type : "-"; ?></p> -->
                  <p><span>Last 4 digits on card :</span> <?php echo (isset($invoice_detail_receipt[0]->card_no) && !empty($invoice_detail_receipt[0]->card_no))? substr ($invoice_detail_receipt[0]->card_no,-4) : "-"; ?></p>
                  <?php  if($invoice_detail_receipt[0]->name_card!='') { ?>
                  <p><span>Name on Card :</span> <?php echo (isset($invoice_detail_receipt[0]->name_card) && !empty($invoice_detail_receipt[0]->name_card))? ucfirst($invoice_detail_receipt[0]->name_card) : "-"; ?></p>
                  
                  <?php } ?>
                  <p ><span>Payment Status :</span> <i class="status_success" style="font-style: normal"> 
                  <?php 
                   if(!empty($invoice_detail_receipt[0]->status) && $invoice_detail_receipt[0]->status=='Chargeback_Confirm' ){
                      echo 'confirm'; 
                    }else if (!empty($invoice_detail_receipt[0]->status)  && $invoice_detail_receipt[0]->status!='') {
                       echo $invoice_detail_receipt[0]->status; 
                       }
                       else
                       { 

                         echo '-'; 
                       
                       }   ?>
                  </i></p>
                </div>
              </div>
            </div>
              <div class="col-12"></div>
              <?php if(count($refundData) > 0 ) { ?>
              <div class="col">
                <div class="irm-pay-title"><span>Refunded:</span></div>
                <div class="form-group " style="min-width: 60%; "> 
                  <!-- <label >Refunded:</label> -->
                  <span class="total__refunds">
                    <span class="total__refundth">Amount</span>
                    <span class="total__refundth">Date</span>
                  </span>
                  <?php 
                          $refundedAmt=0;
                          foreach($refundData as $rowdata) { 
                            
                            // DATE Convert According to  the  merchant Time Zone 
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
                      <?php $refundedAmt += $rowdata['amount'];  if($rowdata['amount']!="") { echo '$'.$rowdata['amount']; }else{ echo '$0'; }  ?>
                    </span> 
                    <span>
                    <?php echo date('M j,Y g:i a',strtotime($rowdata['add_date'])); ?>
                    </span>
                  </span>
                          <?php } ?>
                  
              </div>
            </div>
              <?php }else{  $refundedAmt=0; } ?>
             
              <?php
                // echo $refundedAmt .  $invoice_detail_receipt[0]->amount;
                // echo $invoice_detail_receipt[0]->status;
                     if(($invoice_detail_receipt[0]->status =='confirm' || $invoice_detail_receipt[0]->status == 'Chargeback_Confirm') &&   $refundedAmt != $invoice_detail_receipt[0]->amount   ){ 
                       ?>
            <div class="col">
              <div class="allpos__reftype">
                <div class="irm-pay-title"><span>Refund Type </span></div>
                <div class="irm-pay-detail custom-form">
                  <p>
                    <span class="custom-checkbox">
                      <input type="radio" id="allpos_fulref" class="radio-circle" value="1" name="allpos__reftypes" checked="">
                      <label for="allpos_fulref" class="inline-block">Full Refund  :</label>
                    </span>
                   <span> <input class="form-control fullRefund__amount" readonly name="amount" value="<?php echo $invoice_detail_receipt[0]->amount-$refundedAmt; ?>" style="height: auto !important; "  type="text"></span>
                  </p>
                  <p>
                    <span class="custom-checkbox">
                      <input type="radio" id="allpos_partref" class="radio-circle" value="0" name="allpos__reftypes" >
                      <label for="allpos_partref" class="inline-block">Partial Refund :</label>
                    </span>
                    <span><input class="form-control partRefund__amount" readonly name="amount" value="" style="height: auto !important; " data-max="<?php echo $invoice_detail_receipt[0]->amount-$refundedAmt; ?>"  type="text" onKeyPress="return isNumberKeyOnedc(this,event)" placeholder="Partial amount"></span>
                  </p>
                </div>
              </div>
            </div>
                     <?php } ?>
            <!-- <div class="col-12">
              <p style="font-size: 12px; color: #777; padding: 11px 15px 0; "> 
                I agree to pay the above total amount according to my card issuer agreement. I agree to SaleQuick's Terms &amp; Privacy Policy.
              </p>
            </div> -->

            <!-- <div class="row">
                <div class="col-12">
                  <div class="asteric-detail">
                    <p>* I AGREE TO PAY ABOVE TOTAL AMOUNT ACCORDING TO THE CARDHOLDER AGREEMENT (MERCHANT AGREEMENT IF CREDIT VOUCHER)</p>
                    <p>** IMPORTANT - PLEASE RETAIN THIS COPY FOR YOUR RECORDS</p>
                  </div>
                </div>
              </div>  -->



          </div>
        </div>
        <div class="modal-footer"> 
          <div class="col text-left p-0">
              <button type="button" id="receiptSSendRequestPdf" name="submit" class="btn btn-second">Save as PDF</button>
              <button type="button" id="receiptSSendRequestPrint" name="submit" class="btn btn-first">Print Receipt</button>
          </div>
          <div class="col-7 text-right p-0">

          <button type="submit" id="resend-recept" name="submit" onclick="resendreceipt(this,<?=$invoice_detail_receipt[0]->id; ?>)" class="btn btn-second " >Re-Send Receipt</button>
            <!-- <button type="button"  name="submit" class="btn btn-second" style="margin-right: 3px; ">Receipt Re-Send</button> -->
            <?php
                    if(($invoice_detail_receipt[0]->status =='confirm' || $invoice_detail_receipt[0]->status == 'Chargeback_Confirm') &&   $refundedAmt != $invoice_detail_receipt[0]->amount   ){ 
                      ?>
            <form id="sRefform" action="<?php echo base_url();  ?>pos/refund" method="post"  style=" display: inline; ">
            <input class="form-control" name="invoice_no" id="invoice_no" 
              value="<?php echo $invoice_detail_receipt[0]->invoice_no ?>"  readonly required type="hidden">
              <input class="form-control" name="amount" id="amount" 
              value="<?php echo  $invoice_detail_receipt[0]->amount; ?>"  readonly required type="hidden">
              <input class="form-control" name="transaction_id" id="transaction_id" 
              value="<?php echo $invoice_detail_receipt[0]->transaction_id ?>"  readonly required type="hidden">
              <input class="form-control" name="id" id="id" 
              value="<?php echo $invoice_detail_receipt[0]->id ?>"  readonly required type="hidden">
              <input class="form-control" name="refundfor" id="" 
        value="recurring"  type="hidden" required> 
             <!-- <button type="button" id="invoice_my" alt=<?=$invoice_detail_receipt[0]->id;?> name="submit" class="btn btn-first">Send Invoice</button> -->
            <button type="button" id="receiptSSendRequest" name="submit" class="btn btn-first">Send Refund Request</button>
            </form> 
                     <?php }?>
          </div>
        </div> 
<style type="text/css">
/*.transactioninv__form p:last-of-type {
  margin-bottom: 0;
}*/
.total__refunds{
  clear: both;
}
.total__refunds>span{
  max-width: 60%;
  width: auto;
  font-size: 12px;
  float: left;
  padding: 4px 7px;
  min-width: 90px;
}
span.total__refunds:first-of-type {
    margin-bottom: 0;
    font-weight: 600;
}
</style>
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
    
   $("#invoice_my").on('click',function(){
        //alert('helooo');
        var $this=$(this);
        var rowid=$this.attr('alt');
        $this.html('<span class="fa fa-spinner fa-spin"></span> Sending Invoice');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('merchant/invoice_my'); ?>',
            data: {'rowid':rowid },
            beforeSend:function(data){$("#invoice_my").attr("disabled",true);},
            success: function (data){
              if(data=='200')
              {
              $this.html('<span class="fa fa-check status_success"></span> Re-Sent Invoice!');
              setTimeout(function(){$("#invoice_my").removeAttr("disabled");$this.html('Re-Send Invoice')},2000);
              }
            }
        });
    });

});


function resendreceipt(el,rowid)
{
$this=$(el);
$this.html('<span class="fa fa-spinner fa-spin"></span> Re-Sending Receipt');
$.ajax({
type: 'POST',
url: '<?php echo base_url('merchant/re_receipt'); ?>', 
data: {'rowid':rowid ,'type':'request'},
beforeSend:function(data){$("#resend-recept").attr("disabled",true);},
success: function (data){
  //alert(data); 
 // console.log(data);
//$('#mydiv').html(data);
if(data=='200')
{
  
$this.html('<span class="fa fa-check status_success"></span> Re-Sent Receipt !!');
setTimeout(function(){$("#resend-recept").removeAttr("disabled"); $this.html('Re-Send Receipt')},2000);
}
else if(data=='500')
{
  $this.html('<span class="fa fa-check status_danger text-danger"></span> Somthing went Wrong!');
  setTimeout(function(){$("#resend-recept").removeAttr("disabled"); $this.html('Re-Send Receipt')},2000);
}
}
});
}

</script>