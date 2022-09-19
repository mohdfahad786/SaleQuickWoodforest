 
 

   <div class="table-responsive">
    
    <table class="table table-striped table-bordered">
   
   


    <thead>
    <tr>
    
   
  
    <th>Recurring </th>
     <th>Total Count</th>
     <th>Paid</th>
     <th>Unpaid</th>
   
   
  
    </tr>
   
    </thead>
    <tbody>
    <?php
  
    foreach ($pay_report as $row) {
    
    ?>
    <tr>
   
   
       
         <td><?php echo $row->recurring_type; ?></td>
          <td><?php echo $row->recurring_count; ?></td>
          <td><?php echo $row->recurring_count_paid; ?></td>
          <td><?php echo $row->recurring_count_remain; ?></td>
         
   
   </tr>
   <?php } ?>
      
    </tbody>



    
    </table>
      
    </div>
   
  