   <div class="table-responsive">
    <table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th>Invoice No</th>
     <th>Reference</th>
    <th>Name</th>
    <th>Email </th>
    <th>Phone</th>
    </tr>
    </thead>
    <tbody>
    <?php
    
    foreach ($pay_report as $row) {
    
    ?>
    <tr>
     <td><?php echo $row->invoice_no; ?></td>
     <td><?php echo $row->reference; ?></td>
    <td><?php echo $row->name; ?></td>
     <td><?php echo $row->email_id; ?></td>
      <td><?php echo $row->mobile_no; ?></td>
   </tr>
   <?php } ?>
      
    </tbody>
</table>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th>Item Name</th>
     <th>Quantity</th>
      <th>Price </th>
       <th>Tax </th>
       <th>Total Amount </th>
    </tr>
    </thead>
    <tbody>
    <?php
    // print_r($item_name1 = json_decode($item['0']['item_name'],true));
    // print_r( $weekNo=explode(",",$item_name1['item_name']) ); 
    foreach ($item as $rowp) { 
 $item_name =  str_replace(array('\\', '/'), '', $rowp['item_name']);
$quantity =  str_replace(array('\\', '/'), '', $rowp['quantity']);
$price =  str_replace(array('\\', '/'), '', $rowp['price']);
$tax =  str_replace(array('\\', '/'), '', $rowp['tax']);
$total_amount =  str_replace(array('\\', '/'), '', $rowp['total_amount']);

$item_name1 = json_decode($item_name);
   $quantity1 = json_decode($quantity);
 $price1 = json_decode($price);
  $tax1 = json_decode($tax);
  $total_amount1 = json_decode($total_amount);
// print_r(array_merge($price1,$item_name1));
  //print_r(array_combine($price1,$item_name1));
 
  $i = 0; 
 foreach ($item_name1 as $rowpp) {

if($item_name1[$i]!='Labor') {
    
  if(number_format($total_amount1[$i],2)!='0') { 
        ?>
    <tr>
     <td><?php echo $item_name1[$i]; ?></td>
     <td><?php echo $quantity1[$i]; ?></td>
     <td><?php echo number_format($price1[$i],2); ?></td>
     <td><?php echo $tax1[$i]; ?></td>
     <td><?php echo number_format($total_amount1[$i],2); ?></td>
   </tr>
   <?php } } ?>
   <?php $i++; }
$j=0;
$qun = 0;
$prc = 0;
$tax = 0;
$total = 0;

 foreach ($item_name1 as $rowpp) {
  if($item_name1[$j]=='Labor'  ) { 
      $qun += $quantity1[$j];
      $prc += $price1[$j];
      $tax += $tax1[$j];
      $total += $total_amount1[$j];
      } ?>
   <?php $j++; }  
$k=0;
 foreach ($item_name1 as $rowpp) {
  if($item_name1[$k]=='Labor' ) {  ?>
 <tr>    
     <td>Labor</td>
     <td><?php echo $qun; ?></td>
     <td><?php echo $prc; ?></td>
     <td><?php echo $tax; ?></td>
     <td><?php echo $total; ?></td>
     </tr>
    <?php break; $k++; } } ?>

<?php }   ?>
      
    </tbody>
</table>
<table class="table table-striped table-bordered">
 <thead>
    <tr>
    <!--  <th>Fee</th>-->
    <!--<th>Swipe fee</th>-->
    <th>Amount</th>
    <th>Title</th>
    <th>Detail</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pay_report as $row) {
    ?>
    <tr>
    <!--<td><?php echo $row->fee; ?></td>-->
    <!--    <td><?php echo $row->s_fee; ?></td>-->
    <td><?php echo number_format($row->amount,2); ?></td>
        <td><?php echo $row->title; ?></td>
         <td><?php echo $row->detail; ?></td>
   </tr>
   <?php } ?>
      
    </tbody>
</table>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
     <th colspan="4">Url</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pay_report as $row) {
    ?>
    <tr>
          <td colspan="4"><?php echo $row->url; ?></td>
   </tr>
   <?php } ?>
    </tbody>
</table>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
     <th colspan="2">Note</th>
     <th colspan="2">Address</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pay_report as $row) {
    ?>
    <tr>
    <td colspan="2"><?php echo $row->note; ?></td>
    <td colspan="2"><?php echo $row->address; ?></td>
   </tr>
   <?php } ?>
    </tbody>
</table>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
     <th colspan="2">Card No</th>
      <th colspan="1">Card Type</th>
      <th colspan="1">Ip</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pay_report as $row) {
    ?>
    <tr>
    <td colspan="2"><?php echo $row->card_no; ?></td>
    <td colspan="1"><?php echo $row->card_type; ?></td>
    <td colspan="1"><?php echo $row->ip_a; ?></td>
   </tr>
   <?php } ?>
    </tbody>
</table>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
     <th colspan="2">Name On card</th>
      <th colspan="2">Transaction Id</th>
     
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pay_report as $row) {
    ?>
    <tr>
    <td colspan="2"><?php echo $row->name_card; ?></td>
   
    <td colspan="2"><?php echo $row->transaction_id; ?></td>
   </tr>
   <?php } ?>
    </tbody>
</table>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
     <th colspan="2">Address status</th>
      <th colspan="1">Zip Satus</th>
      <th colspan="1">Cvv Satus</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pay_report as $row) {
    ?>
    <tr>
    <td colspan="2"><?php echo $row->address_status; ?></td>
    <td colspan="1"><?php echo $row->zip_status; ?></td>
    <td colspan="1"><?php echo $row->cvv_status; ?></td>
   </tr>
   <?php } ?>
    </tbody>
</table>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th>Due Date</th>
    <th>Create Date</th>
    <th>Payment date</th>
     <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pay_report as $row) {
    ?>
    <tr>
   
    <td><?php echo $row->due_date; ?></td>
           <td><?php echo $row->add_date; ?></td>  
            <td><?php echo $row->payment_date; ?></td>
            <td> </td>
   
   </tr>
   <?php } ?>
      
    </tbody>

    <?php if($row->status =='confirm'){ ?>
    </table>
    
    <table class="table table-striped table-bordered">
    <thead>
    <tr>
     <th colspan="4">Refund</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td colspan="4">
      <form action="https://salequick.com/pos/refund" method="post">
        
        <input class="form-control" name="invoice_no" id="invoice_no" 
        value="<?php echo $row->invoice_no ?>"  readonly required type="hidden">
        <input class="form-control" name="amount" id="amount" 
        value="<?php echo number_format($row->amount,0); ?>"  readonly required type="hidden">
        <input class="form-control" name="transaction_id" id="transaction_id" 
        value="<?php echo $row->transaction_id ?>"  readonly required type="hidden">
        <input class="form-control" name="id" id="id" 
        value="<?php echo $row->id ?>"  readonly required type="hidden">
         <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light  btn-md btn-mds">Send Request</button>
    </form></td>
   </tr>
    </tbody>
</table>
    <?php } ?>
    
      
    </div>
   
  