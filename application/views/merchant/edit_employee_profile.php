<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>
<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="page-wrapper edit-profile">
      <?php
      
        
        if($this->session->flashdata('success'))
        {
         
         echo "<div class='row'> <div class='col-12'> <div class='card content-card text-success'> <div class='card-title'> ".$this->session->flashdata('success')."</div> </div> </div> </div>";
        }
        
      ?>
      <?php
        echo form_open(base_url().'merchant/edit_employee_profile', array('id' => "my_form",'autocomplete'=>"off",'enctype'=> "multipart/form-data"));
        
      ?>      
        
        <div class="row">
          <div class="col-12">
            <div class="card content-card">
              <div class="card-title">
                <div class="row">
                  <div class="col  fixed-col">
             
                  <?php //echo '$account_id_cnp '.$account_id_cnp.' acceptor_id_cnp '.$acceptor_id_cnp.' account_token_cnp'.$account_token_cnp.' application_id_cnp '.$application_id_cnp.' terminal_id'.$terminal_id;  ?> 
                    <div class="change-pass">
                      Name
                    </div>
                  </div>
                  <div class="col">
                    <div class="custom-form">
                      <div class="form-group">
                      <input type="hidden" class="form-control" name="pak_id" id='pak_id'   value="<?php echo (isset($employeedata) && !empty($employeedata)) ? $employeedata[0]->id : '';?>">
                      
                        <label for="">User Name</label>
                        <input type="text" class="form-control" name="name" id='name' style="text-transform: lowercase;" readonly required value="<?php echo (isset($employeedata) && !empty($employeedata)) ? $employeedata[0]->name : '';?>">
                      </div>
                    </div>      
                  </div>
                  <div class="col">
                    <div class="custom-form">
                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" id='email' style="text-transform: lowercase;"   required value="<?php echo (isset($employeedata) && !empty($employeedata)) ? $employeedata[0]->email : '';?>">
                      </div>
                    </div>      
                  </div>
                  <div class="col">
                    <div class="custom-form">
                      <div class="form-group">
                        <label for="">Mobile</label>
                        <input   type="text"  class="form-control"  name="mob_no" id="mob_no"  required value="<?php echo (isset($employeedata) && !empty($employeedata)) ? $employeedata[0]->mob_no :'';?>"  >
                      </div>
                      <!-- <div class="form-group">
                          <button class="btn btn-first pull-right">Update</button>
                      </div> -->
                    </div>      
                  </div>
                </div>
              </div>
            </div>
          </div> 
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card content-card">
              <div class="card-title">
                <div class="row">
                  <div class="col  fixed-col">
                    <div class="change-pass">
                      Change Password
                    </div>
                  </div>
                  <div class="col">
                    <div class="custom-form">
                      <div class="form-group">
                        <label for="">Old Password</label>
                        <input type="password" class="form-control" name="opsw" id="cpsw" value="" autocomplete="off"  >
                      </div>
                      <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" class="form-control"  autocomplete="off"  name="npsw" placeholder="New Password" >
                      </div>
                    </div>      
                  </div>
                  <div class="col">
                    <div class="custom-form" style=" margin-top: 80px; ">
                      <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control"  autocomplete="off" placeholder="Confirm Password"  name="cpsw" >
                      </div>
                      <div class="form-group">
                          <input type="submit" id="btn_login" name="mysubmit" value="Update" class="btn btn-first pull-right">
                      </div>
                    </div>      
                  </div>
                </div>
              </div>
            </div>
          </div> 
        </div>

       

        
      <?php echo form_close(); ?> 
    </div>
  </div>
<!-- End Page Content -->
<?php
include_once'footer_new.php';
?>