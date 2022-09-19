 
 
      





   <div class="table-responsive">
    
    <table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th>Invoice No</th>
     <th>Reference</th>
    <th>Name</th>
    <th>Email</th>
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
       <th>Tax Type </th>
    <th>Total Amount</th>

   
  
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
$tax_id =  str_replace(array('\\', '/'), '', $rowp['tax_id']);
$total_amount =  str_replace(array('\\', '/'), '', $rowp['total_amount']);
$tax_per =  str_replace(array('\\', '/'), '', $rowp['tax_per']);

   $item_name1 = json_decode($item_name);
   $quantity1 = json_decode($quantity);
 $price1 = json_decode($price);
  $tax1 = json_decode($tax);
   $tax_id1 = json_decode($tax_id);
  $total_amount1 = json_decode($total_amount);
   $tax_per1 = json_decode($tax_per);

 
  $i = 0; 
 foreach ($item_name1 as $rowpp) {

        ?>
    
    
    <tr>
     <td><?php echo $item_name1[$i]; ?></td>
     <td><?php echo $quantity1[$i]; ?></td>
     <td><?php echo number_format($price1[$i],2); ?></td>
     <td><?php echo number_format($tax1[$i],2); ?></td>
      <td>
 <?php 
  $data = $this->admin_model->data_get_where_1('tax', array('id' => $tax_id1[$i])); 

  foreach ($data as $view) { 

    echo $view['title']; ?>&nbsp;(<?php echo $tax_per1[$i]; ?>%)
<?php 
  }
     ?></td>
     <td><?php echo number_format($total_amount1[$i],2); ?></td>
   
   </tr>
   <?php $i++; } 
  

}   ?>
      
    </tbody>
</table>
<table class="table table-striped table-bordered">


 <thead>
    <tr>
     <th>Fee</th>
    <th>Swipe fee</th>
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
    <td><?php echo number_format($row->fee,2); ?></td>
        <td><?php echo number_format($row->s_fee,2); ?></td>
        
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
     <th colspan="4">Note</th>
   
  
    </tr>
   
    </thead>
    <tbody>
    <?php
  
    foreach ($pay_report as $row) {
    
    ?>
    <tr>
    <td colspan="4"><?php echo $row->note; ?></td>
  
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

    
    </table>
      
    </div>
   
  