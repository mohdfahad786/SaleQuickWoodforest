
 <?php
  if (!empty($this->session->userdata('merchant_name')))
  {
      header('Location:  '.  'https://salequick.com/merchant'  );
  }
  include_once'header_new.php';
// include_once'nav.php';
// include_once'sidebar.php';

?>
<!-- Start Page Content -->
  <div id="wrapper"> 
    <div class="outer-page-wrapper ">    
      <div class="login-register">
        <div class="log-reg-box-inner">
          <form class="row custom-form" action="<?php echo base_url('login_admin/merchant');?>" method="post">
            <div class="col-12">
              <div class="logo-wrapper-outer clearfix">
                  <a  href="<?php echo base_url(); ?>" class="logo-wrapper no-ajax">
                    <img src="https://salequick.com/front/images/logo-w.png" alt="Salequick">
                  </a>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <input type="text" class="form-control"  name="username"  placeholder="Email" name=""  required>
                <input type="hidden" class="form-control" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" name="" required>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <button type="submit" name="btn_login" class="btn btn-first" value="Login">Login</button>
              </div> 
            </div>
            <div class="col-12">
              <div class="form-group text-center">
                <p><a class="no-ajax" href="<?php echo base_url('reset/merchant'); ?>">Forgot Password?</a></p>
              </div> 
            </div>
          </form>
          <div class="row">
            <div class="col-12">
              <div class="form-group text-center">
                <p class="register_link"><a class="no-ajax" href="<?php echo base_url('signup'); ?>" >Create New Account?</a></p>
                <p><?php echo $this->session->flashdata('msg'); ?></p>
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
