<?php
include_once'header_new.php';
// include_once'nav.php';
// include_once'sidebar.php';
?>

<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="outer-page-wrapper">    
      <div class="login-register">
        <div class="log-reg-box-inner">
          <form class="row custom-form" action="<?php echo base_url('reset/password');?>" method="post">
            <div class="col-12">
              <div class="logo-wrapper-outer clearfix">
                  <a href="<?php echo base_url(); ?>" class="logo-wrapper no-ajax">
                    <img src="<?php echo base_url('front/images/logo-w.png'); ?>" alt="Salequick">
                  </a>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <input type="password" id="password" class="form-control" name="password" placeholder="New Password" required>

                <input type="hidden" class="form-control" name="merchant_id" value="<?php echo $this->uri->segment(3); ?>"  required>
                <input type="hidden" class="form-control" name="token" value="<?php echo $this->uri->segment(4); ?>" required>

              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <input type="password" id="c_password" class="form-control" name="confirm_password" placeholder="Confirm Password"   required>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <button type="submit" class="btn btn-first" id="btn_login" name="btn_login" value="Reset">Reset</button>
              </div> 
            </div>
            <div class="col-12">
              <div class="form-group text-center clearfix  ">
                <a  href="<?php echo base_url('login'); ?>" class="forgot_pass_link no-ajax">Login ?</a>
                <?php echo '<p>'.$this->session->flashdata('msg') .'</p>'; ?>    
              </div>
            </div>
          </form>
        </div>
      </div> 
    </div>
  </div>
<!-- End Page Content -->

<script>
  $(document).on('click', '#btn_login', function() {
    var password = $('#password').val();
    var c_password = $('#c_password').val();
    // alert(password+','+c_password);return false;

    var regularExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;

    if(!regularExpression.test(password)) {
        alert("Password must contain a minimum of 8 characters, at least 1 number, at least one uppercase character and at least one lowercase character.");
        return false;
    }
    if(password != c_password) {
        alert('Password and Confirm Password must be same.');
        return false;
    }
  })
</script>

<?php
include_once'footer_new.php';
?>
