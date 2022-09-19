 
 
      





   <div class="table-responsive">
    
    <table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th>Card No</th>
     <th>Amount</th>
     <th>Tax</th>
   
   
    
   
  
    </tr>
   
    </thead>
    <tbody>
    <?php
  
    foreach ($pay_report as $row) {
    
    ?>
    <tr>
     <td><?php echo $row->card_no; ?></td>
     <td><?php echo $row->amount; ?></td>
    <td><?php echo $row->tax; ?></td>

        
   
   </tr>
   <?php } ?>
      
    </tbody>
</table>

 <table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th>Fee </th>
       <th>Create Date</th>
   
   
   
    
   
  
    </tr>
   
    </thead>
    <tbody>
    <?php
  
    foreach ($pay_report as $row) {
    
    ?>
    <tr>
     <td><?php echo $row->fee; ?></td>
     <td><?php echo $row->date_c; ?></td>
  

        
   
   </tr>
   <?php } ?>
      
    </tbody>
</table>
<!-- <table class="table table-striped table-bordered">

    <thead>
    <tr>
   
 
       <th>Tax </th>
       <th>Tax Type </th>

  

   
  
    </tr>
   
    </thead>
    <tbody>
    <?php
    // print_r($item_name1 = json_decode($item['0']['item_name'],true));
    // print_r( $weekNo=explode(",",$item_name1['item_name']) ); 

    foreach ($item as $rowp) { 


$tax_per =  str_replace(array('\\', '/'), '', $rowp['tax_per']);
$tax_id =  str_replace(array('\\', '/'), '', $rowp['tax_id']);


  $tax_per1 = json_decode($tax_per);
   $tax_id1 = json_decode($tax_id);

 
  $i = 0; 
 foreach ($tax_id1 as $rowpp) {

        ?>
    
    
    <tr>
  
     <td><?php echo $tax_per1[$i]; ?></td>
     <td><?php echo $tax_id1[$i]; ?></td> 
      <td>
 <?php 
  $data = $this->admin_model->data_get_where_1('tax', array('id' => $tax_id1[$i])); 

  foreach ($data as $view) { 

    echo $view['title']; ?>
<?php 
  }
     ?></td>
    
   
   </tr>
   <?php $i++; } 
  

}   ?>
      
    </tbody>
</table> -->



      
    </div>
   
  