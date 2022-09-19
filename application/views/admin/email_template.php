<!DOCTYPE html>
<html lang="en">
<head>
  <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin | Dashboard</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/modernizr.min.js"></script>
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
.bg-gray {
  background-color: #f2f2f2;
  padding: 15px;
  border-radius: 4px;
}
</style>
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
  <div id="wrapper">
    <div class="page-wrapper">
      <?php
      if(isset($msg))
      {
      echo '<span class="text-success">'.$msg.'</span>';
      }
      echo form_open_multipart('email_template/'.$loc, array('id' => "my_form"));
      echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
      ?> 
        <div class="row">
          <div class="col-12">
            <div class="back-title m-title"> 
              <span><?php echo $meta; ?></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card content-card">
              <div class="card-detail">
                <div class="form-group">
                  <p class="pt-2 pb-2 bg-gray">
                    Amount = [AMOUNT] , Tax = [TAX] , Invoice no = [INVOICE_NO] , date = [PAYMENT_DATE] , Signature =[SIGN] , Amount without tax =[TAMOUNT] ,  Merchant Email = [EMAIL] , Merchant Phone =[PHONE]
                  </p>
                </div>
                <div class="form-group">
                  <textarea id="editor1" class="ckeditor" name="templete" ><?php echo (isset($templete) && !empty($templete)) ? $templete : set_value('templete');?></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" id="btn_login" name="mysubmit"  class="btn btn-first" value="Update" />
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
<script type="text/javascript" src="<?php echo base_url('backup/assets/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript">
  CKEDITOR.replace( 'editor1', {
    fullPage: true,
    allowedContent: true,
    extraPlugins: 'wysiwygarea'
  });
</script>
 
<script>
  var resizefunc = [];
</script> 

<!-- Plugins  --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>/new_assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script>
<!-- Custom main Js -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> 
</body>
</html>