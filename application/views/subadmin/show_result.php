 
 
<?php
foreach ($pay_report as $row) {
?>
<div class="form-group">
  <label >Name:</label>
  <p class="form-control-static">
    <?php echo (isset($row->name) && !empty($row->name)) ? $row->name : "-"; ?>
    </p>
</div>
<div class="form-group">
  <label >Email:</label>
  <p class="form-control-static">
    <?php echo (isset($row->email) && !empty($row->email)) ? $row->email : "-"; ?>
    </p>
</div>
<div class="form-group">
  <label >Phone:</label>
  <p class="form-control-static">
    <?php echo (isset($row->mob_no) && !empty($row->mob_no)) ? $row->mob_no : "-"; ?>
    </p>
</div>
<div class="form-group">
  <label >Auth key:</label>
  <p class="form-control-static">
    <?php echo (isset($row->auth_key) && !empty($row->auth_key)) ? $row->auth_key : "-"; ?>
    </p>
</div>
<?php } ?>
    <?php
  
    foreach ($pay_report as $row) {
    
    ?>
<div class="form-group">
  <label >Address1:</label>
  <p class="form-control-static">
    <?php echo (isset($row->address1) && !empty($row->address1)) ? $row->address1 : "-"; ?>
    </p>
</div>
<div class="form-group">
  <label >Address2:</label>
  <p class="form-control-static">
    <?php echo (isset($row->address2) && !empty($row->address2)) ? $row->address2 : "-"; ?>
    </p>
</div>
<div class="form-group">
  <label >State:</label>
  <p class="form-control-static">
    <?php echo (isset($row->state) && !empty($row->state)) ? $row->state : "-"; ?>
    </p>
</div>
<div class="form-group">
  <label >City:</label>
  <p class="form-control-static">
    <?php echo (isset($row->city) && !empty($row->city)) ? $row->city : "-"; ?>
    </p>
</div>
<?php } ?>
  