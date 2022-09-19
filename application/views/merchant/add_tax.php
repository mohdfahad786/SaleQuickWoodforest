 <?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>

<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper update-emp">    
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title">
            <span class="material-icons"> arrow_back</span> <span><?php echo ($meta)?></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-title">
                <?php
                    if(isset($msg))
                    echo "<h4> $msg</h4>";
                    echo form_open('merchant/'.$loc, array('id' => "my_form",'class' => "row"));
                    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                ?>
                    <div class="col-12">
                        <?php //echo ($meta)?>
                    </div>
                    <div class="col">
                      <div class="custom-form">
                        <div class="form-group">
                          <label for="">Title</label>
                          <input type="text" class="form-control" name="title" id="title"  placeholder="Title"  required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
                        </div>
                      </div>      
                    </div>
                    <div class="col">
                      <div class="custom-form" >
                        <div class="form-group">
                          <label for="">Percentage</label>
                          <input type="text" class="form-control" name="percentage" id="percentage" maxlength="10" onKeyPress="return isNumberKeydc(event)"  placeholder="Percentage " value="<?php echo (isset($percentage) && !empty($percentage)) ? $percentage : set_value('percentage');?>" required>
                        </div>
                      </div>      
                    </div>
                    <div class="col-12">
                      <div class="custom-form" >
                        <div class="form-group">
                          <input type="submit" id="btn_login" name="submit"  class="btn btn-first pull-right" value="<?php echo $action ?>" />
                        </div>
                      </div>
                    </div>
                <?php echo form_close(); ?> 
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
<!-- End Page Content -->
<?php
include_once'footer_new.php';
?>
