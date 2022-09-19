<style>
    .modal-header {
        border-bottom: none !important;
    }
    .item-head {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 0px !important;
        color: #000 !important;
        font-family: AvenirNext-Medium !important;
    }
    .line-b4-head {
        height: 4px;
        width: 70px;
        background-color: #000;
    }
    .undergo-head {
        margin-bottom: 10px;
    }
    .payment-details-table tr td {
        height: 30px !important;
        font-size: 14px;
        font-weight: 400 !important;
        font-family: AvenirNext-Medium !important;
    }
    .payment-details-table tr td.left {
        color: rgb(105, 105, 105);
    }
    #dynamic-content .form-group label:not(.inline-block) {
        background: none !important;
        padding-bottom: 0px !important;
        font-family: Avenir-Black !important;
    }
    #dynamic-content .form-control-static {
        padding: 5px 7px !important;
        border-bottom: none !important;
        background-color: #fff !important;
    }
</style>
<!-- 1 -->

<div class="col-12">
    <div class="row">
        <div class="col-12">
            <div class="undergo-head">
                <span class="item-head">Payment Details</span>
                <div class="line-b4-head"></div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="padding: 0px 20px !important;">
<?php foreach ($pay_report as $row) { ?>
  <div class="form-group">
    <label >Invoice No:</label>
    <p class="form-control-static">
      <?php echo (isset($row->invoice_no) && !empty($row->invoice_no)) ? $row->invoice_no : "-"; ?>
      </p>
  </div>
  <div class="form-group">
    <label >Reference:</label>
    <p class="form-control-static">
      <?php echo (isset($row->reference) && !empty($row->reference)) ? $row->reference : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Name:</label>
    <p class="form-control-static">
      <?php echo (isset($row->name) && !empty($row->name)) ? $row->name : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Email:</label>
    <p class="form-control-static">
      <?php echo (isset($row->email_id) && !empty($row->email_id)) ? $row->email_id : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Phone:</label>
    <p class="form-control-static">
      <?php echo (isset($row->mobile_no) && !empty($row->mobile_no)) ? $row->mobile_no : "-"; ?>
    </p>
  </div>
<?php }?>
<!-- 2 -->
<?php
// print_r($item_name1 = json_decode($item['0']['item_name'],true));
// print_r( $weekNo=explode(",",$item_name1['item_name']) );
foreach ($item as $rowp) {
    $item_name = str_replace(array('\\', '/'), '', $rowp['item_name']);
    $quantity = str_replace(array('\\', '/'), '', $rowp['quantity']);
    $price = str_replace(array('\\', '/'), '', $rowp['price']);
    $tax = str_replace(array('\\', '/'), '', $rowp['tax']);
    $total_amount = str_replace(array('\\', '/'), '', $rowp['total_amount']);

    $item_name1 = json_decode($item_name);
    $quantity1 = json_decode($quantity);
    $price1 = json_decode($price);
    $tax1 = json_decode($tax);
    $total_amount1 = json_decode($total_amount);
    // print_r(array_merge($price1,$item_name1));
    //print_r(array_combine($price1,$item_name1));

    $i = 0;
    foreach ($item_name1 as $rowpp) {
        if ($item_name1[$i] != 'Labor') {
            if (number_format($total_amount1[$i], 2) != '0') { ?>
                <div class="form-group">
                  <label >Item Name:</label>
                  <p class="form-control-static">
                    <?php echo (!empty($item_name1[$i]) ? ($item_name1[$i]) : "-"); ?>
                  </p>
                </div>
                <div class="form-group">
                  <label >Quantity:</label>
                  <p class="form-control-static">
                    <?php echo (!empty($quantity1[$i]) ? ($quantity1[$i]) : "-"); ?>
                  </p>
                </div>
                <div class="form-group">
                  <label >Price:</label>
                  <p class="form-control-static">
                    $ <?php echo (!empty(number_format($price1[$i], 2)) ? (number_format($price1[$i], 2)) : "-"); ?>
                  </p>
                </div>
                <div class="form-group">
                  <label >Tax:</label>
                  <p class="form-control-static">
                    $ <?php echo (!empty($tax1[$i]) ? number_format($tax1[$i],2) : "-"); ?>
                  </p>
                </div>
                <div class="form-group">
                  <label >Total Amount:</label>
                  <p class="form-control-static">
                    $ <?php echo (!empty(number_format($total_amount1[$i], 2)) ? (number_format($total_amount1[$i], 2)) : "-"); ?>
                  </p>
                </div>
            <?php }
        }
        $i++;
    }

    $j = 0;
    $qun = 0;
    $prc = 0;
    $tax = 0;
    $total = 0;

    foreach ($item_name1 as $rowpp) {
        if ($item_name1[$j] == 'Labor') {
            $qun += $quantity1[$j];
            $prc += $price1[$j];
            $tax += $tax1[$j];
            $total += $total_amount1[$j];
        }?>
      <?php $j++;
    }
    $k = 0;
    foreach ($item_name1 as $rowpp) {
        if ($item_name1[$k] == 'Labor') {
            ?>
          <div class="form-group">
            <label >Item Name:</label>
            <p class="form-control-static">
              Labor
            </p>
          </div>
          <div class="form-group">
            <label >Item Name:</label>
            <p class="form-control-static">
              <?php echo (!empty($qun) ? ($qun) : "-"); ?>
            </p>
          </div>
          <div class="form-group">
            <label >Item Name:</label>
            <p class="form-control-static">
              $ <?php echo (!empty($prc) ? number_format($prc,2) : "-"); ?>
            </p>
          </div>
          <div class="form-group">
            <label >Item Name:</label>
            <p class="form-control-static">
              $ <?php echo (!empty($tax) ? number_format($tax,2) : "-"); ?>
            </p>
          </div>
          <div class="form-group">
            <label >Item Name:</label>
            <p class="form-control-static">
              <?php echo (!empty($total) ? number_format($total,2) : "-"); ?>
            </p>
          </div>
        <?php break;
            $k++;
        }
    }?> <?php
}
?>

<?php
foreach ($pay_report as $row) {
    ?>
  <div class="form-group">
    <label >Amount:</label>
    <p class="form-control-static">
      <span class="srpttlAmt"><?php echo (isset($row->amount) && !empty(number_format($row->amount, 2))) ? number_format($row->amount, 2) : "-"; ?>   </span>

    </p>
  </div>
  <div class="form-group">
    <label >Tax:</label>
    <p class="form-control-static">
      <?php echo (isset($row->tax) && !empty(number_format($row->tax, 2))) ? number_format($row->tax, 2) : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Title:</label>
    <p class="form-control-static">
      <?php echo (isset($row->title) && !empty($row->title)) ? $row->title : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Detail:</label>
    <p class="form-control-static">
      <?php echo (isset($row->detail) && !empty($row->detail)) ? $row->detail : "-"; ?>
    </p>
  </div>
  <!-- - -->
  <div class="form-group">
    <label >Url:</label>
    <p class="form-control-static">
      <?php echo (isset($row->url) && !empty($row->url)) ? $row->url : "-"; ?>
    </p>
  </div>
  <!-- - -->
  <div class="form-group">
    <label >Note:</label>
    <p class="form-control-static">
      <?php echo (isset($row->note) && !empty($row->note)) ? $row->note : "-"; ?>
    </p>
  </div>
  <!-- - -->
  <div class="form-group">
    <label >Due Date:</label>
    <p class="form-control-static">
      <?php echo (isset($row->due_date) && !empty($row->due_date)) ? $row->due_date : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Create Date:</label>
    <p class="form-control-static">
      <?php echo (isset($row->add_date) && !empty($row->add_date)) ? $row->add_date : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Payment date:</label>
    <p class="form-control-static">
      <?php echo (isset($row->payment_date) && !empty($row->payment_date)) ? $row->payment_date : "-"; ?>
    </p>
  </div>
<?php }?>

<?php if ($row->status == 'confirm') {?>
  <div class="form-group">

    <label >Refund:</label>
    <form class="form-control-static text-right" action="<?php echo base_url();?>pos/refund" method="post">
        <input class="form-control" name="invoice_no" id="invoice_no"
        value="<?php echo $row->invoice_no ?>"  readonly required type="hidden">
        <input class="form-control" name="amount" id="amount"
        value="<?php echo number_format($row->amount, 0); ?>"  readonly required type="hidden">
        <input class="form-control" name="transaction_id" id="transaction_id"
        value="<?php echo $row->transaction_id ?>"  readonly required type="hidden">
        <input class="form-control" name="id" id="id"
        value="<?php echo $row->id ?>"  readonly required type="hidden">
         <button type="button" id="receiptSSendRequest" name="submit" class="btn btn-second">Send Request</button>
    </form>
  </div>

<?php }?>

<?php if ($row->status == 'confirm' || $row->status == 'Chargeback_Confirm') {
    ?>
  <div class="form-group">
<div class="bbg"></div>
        <label >Receipt:</label>
      <p class="form form-control-static">
        <button type="submit" id="resend-recept" name="submit" onclick="resendreceipt(<?=$row->id;?>)" class="btn btn-second">Re-Send</button>
      </p>
</div>
<?php
}?>
<?php

$timezone = $this->session->userdata('time_zone');
if ($timezone == "") {$timezone = "America/Chicago";}
date_default_timezone_set($timezone);

$sessiondate = date('Y-m-d H:i:s');
$date = new DateTime($sessiondate, new DateTimeZone($timezone));
$date->format('Y-m-d H:i:s');
$date->setTimezone(new DateTimeZone('America/Chicago'));
$MtoServerdate = $date->format('Y-m-d H:i:s'); //   this date find after converting of according to  merchant`s time  zone
// echo $row->due_date;
?>

<?php if ($row->status == 'pending' && $MtoServerdate > $row->due_date) {?>
    <div class="col-12" style="margin-left: -4px !important;">
        <button type="submit" id="resend-invoice" name="submit" onclick="resendinvoice(<?=$row->id;?>)" class="btn btn-second">Re-Send</button>
        <div class="bbg"></div>
    </div>
<?php }?>
</div>



<script>
   function resendreceipt(rowid)
   {
    // alert(id);

        $.ajax({
              type: 'POST',
              url: '<?php echo base_url('merchant/re_receipt'); ?>',
              data: {'rowid':rowid ,'type':'request'},

              beforeSend:function(data){$("#resend-recept").attr("disabled",true);},
              success: function (data){
                  //data = JSON.parse(dataJson)
                  //console.log(data)
                  if(data=='200')
                  {
                    $('#resend-recept').hide();
                    //alert('Receipt re-send Successfully ...');
                    $('.bbg').html('<span class="text-success">Receipt re-send Successfully ...</span>');
                  }
              }
            });
   }

   function resendinvoice(rowid)
   {
    // alert(id);

        $.ajax({
              type: 'POST',
              url: '<?php echo base_url('merchant/re_invoice'); ?>',
              data: {'rowid':rowid },

              beforeSend:function(data){$("#resend-invoice").attr("disabled",true);},
              success: function (data){
                //alert(data);
                  //data = JSON.parse(dataJson)
                 //console.log(data)
                  //$('.bbg').html(data);
                  if(data=='200')
                  {
                    //alert('Receipt re-send Successfully ...');
                    $('#resend-invoice').hide();
                    $('.bbg').html('<span class="text-success">Invoice re-send Successfully ...</span>');
                  }

              }


            });
   }
</script>

