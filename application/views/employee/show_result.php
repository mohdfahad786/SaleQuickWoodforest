 
 
      





   <div class="table-responsive">
    
    <table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th>Invoice No</th>
     <th>Reference</th>
    <th>Name</th>
    <th>Email id</th>
    <th>Mobile No</th>
   
    
   
  
    </tr>
   
    </thead>
    <tbody>
    <?php
	
    foreach ($pay_report as $row) {
    
    ?>
    <tr>
     <td><?php echo $row->payment_id; ?></td>
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
$total_amount =  str_replace(array('\\', '/'), '', $rowp['total_amount']);

   $item_name1 = json_decode($item_name);
   $quantity1 = json_decode($quantity);
 $price1 = json_decode($price);
  $tax1 = json_decode($tax);
  $total_amount1 = json_decode($total_amount);

 
  $i = 0; 
 foreach ($item_name1 as $rowpp) {

        ?>
    
    
    <tr>
     <td><?php echo $item_name1[$i]; ?></td>
     <td><?php echo $quantity1[$i]; ?></td>
     <td><?php echo $price1[$i]; ?></td>
     <td><?php echo $tax1[$i]; ?></td>
     <td><?php echo $total_amount1[$i]; ?></td>
   
   </tr>
   <?php $i++; } 
  

}   ?>
      
    </tbody>
</table>
<table class="table table-striped table-bordered">


 <thead>
    <tr>
    
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
    
    <td><?php echo $row->amount; ?></td>
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
   
  