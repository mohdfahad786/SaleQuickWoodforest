
<?php
foreach ($pay_report as $row) {
?>
  <div class="form-group">
    <label >Invoice No:</label>
    <p class="form-control-static">
      <?php echo (isset($row->invoice_no) && !empty($row->invoice_no))? $row->invoice_no : "-"; ?>
      </p>
  </div>
  <div class="form-group">
    <label >Ip:</label>
    <p class="form-control-static">
      <?php echo (isset($row->ip) && !empty($row->ip))? $row->ip : "-"; ?>
      </p>
  </div>
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
<?php } ?>
<?php   
foreach ($pay_report as $row) {
?>
    <div class="form-group">
    <label >Card No:</label>
    <p class="form-control-static">
      <?php echo (isset($row->card_no) && !empty($row->card_no))? $row->card_no : "-"; ?>
      </p>
    </div>
    <div class="form-group">
    <label >Cartd Type:</label>
    <p class="form-control-static">
      <?php echo (isset($row->card_type) && !empty($row->card_type))? $row->card_type : "-"; ?>
      </p>
    </div>
    <div class="form-group">
    <label >Transaction Id:</label>
    <p class="form-control-static">
      <?php echo (isset($row->transaction_id) && !empty($row->transaction_id))? $row->transaction_id : "-"; ?>
      </p>
    </div>
<?php } ?>
<?php
foreach ($pay_report as $row) {
?>
    <div class="form-group">
        <label >Signature:</label>
        <p class="form-control-static">
            <?php 
                if(isset($row->sign) && !empty($row->sign)){
            ?>
                <img style="width: 100%;" src="<?php echo base_url(); ?>logo/<?php echo $row->sign; ?>" >
            <?php }else{?>
                -
            <?php }?>
          </p>
    </div>
<?php } ?>