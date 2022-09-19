<!-- 1 -->
<?php
foreach ($pay_report as $row) {
?>
  <div class="form-group">
    <label >Name:</label>
    <p class="form-control-static">
      <?php echo (isset($row->name) && !empty($row->name))? $row->name : "-"; ?>
      </p>
  </div>
  <div class="form-group">
    <label >Email:</label>
    <p class="form-control-static">
      <?php echo (isset($row->email_id) && !empty($row->email_id))? $row->email_id : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Phone:</label>
    <p class="form-control-static">
      <?php echo (isset($row->mobile_no) && !empty($row->mobile_no))? $row->mobile_no : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Amount:</label>
    <p class="form-control-static">
      <?php echo (isset($row->amount) && !empty($row->amount))? $row->amount : "-"; ?>
    </p>
  </div>
  <!-- 2 -->
  <div class="form-group">
    <label >Title:</label>
    <p class="form-control-static">
      <?php echo (isset($row->title) && !empty($row->title))? $row->title : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Detail:</label>
    <p class="form-control-static">
      <?php echo (isset($row->detail) && !empty($row->detail))? $row->detail : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Url:</label>
    <p class="form-control-static">
      <?php echo (isset($row->url) && !empty($row->url))? $row->url : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Date:</label>
    <p class="form-control-static">
      <?php echo (isset($row->add_date) && !empty($row->add_date))? $row->add_date : "-"; ?>
    </p>
  </div>
  <!-- 3 -->
    <div class="form-group">
    <label >Recurring:</label>
    <p class="form-control-static">
      <?php echo (isset($row->recurring_type) && !empty($row->recurring_type))? $row->recurring_type : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Total Count:</label>
    <p class="form-control-static">
      <?php //echo (isset($row->recurring_count) && !empty($row->recurring_count))? $row->recurring_count : "-"; ?>
      <?php echo (isset($row->recurring_count) && !empty($row->recurring_count) && $row->recurring_count >0 )? $row->recurring_count : "Constant"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Paid:</label>
    <p class="form-control-static">
      <?php echo (isset($row->recurring_count_paid) && !empty($row->recurring_count_paid))? $row->recurring_count_paid : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Unpaid:</label>
    <p class="form-control-static">
      <?php echo (isset($row->recurring_count_remain) && !empty($row->recurring_count_remain))? $row->recurring_count_remain : "-"; ?>
    </p>
  </div>
  <!-- 4 -->
  <div class="form-group">
    <label >Ip:</label>
    <p class="form-control-static">
      <?php echo (isset($row->ip_a) && !empty($row->ip_a))? $row->ip_a : "-"; ?>
    </p>
  </div>
  <div class="form-group">
    <label >Sign:</label>
    <p class="form-control-static">
      <img src="<?php echo $row->sign; ?>" onerror="this.outerHTML ='-'" alt="-">
    </p>
  </div>
<?php } ?>   