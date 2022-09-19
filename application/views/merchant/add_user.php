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
                    echo form_open('merchant/'.$loc, array('id' => "my_form",'class' => 'row custom-form'));
                    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
                ?>
                <div class="col-12 pos_Status_cncl">
                    <?php echo validation_errors(); ?>
                </div>
                <!-- <div class="row custom-form"> -->
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Email </label>
                        <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email Id:" value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Phone number</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" pattern="[6789][0-9]{9}" maxlength="10" onKeyPress="return isNumberKey(event)"  placeholder="Mobile No :" value="<?php echo (isset($mobile) && !empty($mobile)) ? $mobile : set_value('mobile');?>" required>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">User Name</label>
                        <input type="text" class="form-control" name="name" id="name"  placeholder="Name:"  required value="<?php echo (isset($name) && !empty($name)) ? $name : set_value('name');?>">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group" >
                        <label for="">Domain Name</label>
                        <input type="text" class="form-control" name="domain_name" id="domain_name"  placeholder="Domain Name:"  required value="<?php echo (isset($domain_name) && !empty($domain_name)) ? $domain_name : set_value('domain_name');?>" >
                      </div>    
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address" id="address"  placeholder="Address:"   required value="<?php echo (isset($address) && !empty($address)) ? $address : set_value('$address');?>">
                      </div>   
                    </div>
                    <?php if($loc=='edit_user')  {?>  
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Auth Key</label>
                                <input type="text" class="form-control" name="auth_key" id="auth_key"  placeholder="Name:" 
                                        required value="<?php echo (isset($auth_key) && !empty($auth_key)) ? $auth_key : set_value('auth_key');?>" readonly>
                            </div>   
                        </div>
                    <?php } ?>
                    <?php if($loc=='edit_user')  {?>   
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <select class="form-control"  name="status" id="status" required="">
                                    <option value="active" <?php if($status=='active'){ echo 'selected'; } ?> > Active </option>
                                    <option value="block" <?php if($status=='block'){ echo 'selected'; } ?> > Block </option>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-12">
                      <div class="custom-form" >
                        <div class="form-group">
                            <input type="submit" id="btn_login" name="submit"  class="btn btn-first pull-right" value="<?php echo $action ?>" />
                        </div>
                      </div>
                    </div>
                <!-- </div> -->
                <?php echo form_close(); ?>
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
