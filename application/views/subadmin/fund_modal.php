<div class="form-group">
  <label>Invoice No:</label>
  <p class="form-control-static"> 
    <?php 
      echo (isset($mem[0]['invoice_no']) && !empty($mem[0]['invoice_no']))?  $mem[0]['invoice_no'] : '-';
    ?>      
  </p>
</div>
<div class="form-group">
  <label>Email:</label>
  <p class="form-control-static">
    <?php 
    echo (isset($mem[0]['email_id']) && !empty($mem[0]['email_id']))? $mem[0]['email_id'] : '-';
    ?>       
  </p>
</div>
<div class="form-group">
  <label>Amount:</label>
  <p class="form-control-static">
    <?php echo (isset($mem[0]['email_id']) && !empty($mem[0]['email_id']))? '$'.number_format($mem[0]['amount'],2) : '-'; ?>      
  </p>
</div>