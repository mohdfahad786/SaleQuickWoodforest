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
                echo "<h5> $msg</h5>";
                echo form_open('merchant/'.$loc, array('id' => "my_form",'class'=>"row"));
                echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
              ?>
                <div class="col-12 pos_Status_cncl">
                  <?php echo validation_errors(); ?>
                </div>
               
              <!-- <div class="row"> -->
                <div class="col">
                  <div class="custom-form">
                    <div class="form-group">
                      <label for="">Email </label>
                      <input type="email" class="form-control"  <?php if($loc=='edit_employee')  {  echo 'readonly'; } ?> name="email" id="email" pattern="[ a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email:"  value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
                    </div>
                    <div class="form-group">
                      <label for="">User Name</label>
                      <input type="text" class="form-control" name="name" id="name"  placeholder="Name:"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                    </div>
                  </div>      
                </div>
                <div class="col">
                  <div class="custom-form" >
                    <div class="form-group">
                      <label for="">Phone number</label>
                      <input type="text" class="form-control" name="mobile" id="phone" onkeypress="return isNumberKey(event)" placeholder="Mobile No :" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required="">
                    </div>
                    <div class="form-group" >
                      <label for="">Update Password</label>
                      <?php if($loc=='edit_employee')  {?> 
                        <input type="hidden" class="form-control" name="password" id="password"  placeholder="Password:"  required value="<?php echo (isset($password) && !empty($password)) ? $password : set_value('password');?>">
                        <input type="password" class="form-control" name="cpsw" id="cpsw"  placeholder="Change Password:"  >
                      <?php
                      } 
                      elseif($loc=='add_employee')  {
                      ?>
                        <input type="text" class="form-control" name="password" id="password"  placeholder="Password:"  required >
                      <?php } ?>
                    </div>
                  </div>      
                </div>
                <?php if($loc=='edit_employee')  {?>  
                  <div class="col-12">
                    <div class="custom-form" >
                      <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-control"  name="status" id="status" required="">
                          <option value="active" <?php if($status=='active'){ echo 'selected'; } ?> > Active </option>
                          <option value="block" <?php if($status=='block'){ echo 'selected'; } ?> > Block </option>
                        </select>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <div class="col-12">
                  <div class="custom-form" >
                    <div class="form-group">
                      <input type="submit" id="btn_login" name="submit"  class="btn btn-first pull-right" value="<?php echo $action ?>" />
                      <!-- <button class="btn btn-first pull-right">Add New Employee</button> -->
                    </div>
                  </div>
                </div>
              <?php echo form_close(); ?> 
              <!-- </div> -->
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
