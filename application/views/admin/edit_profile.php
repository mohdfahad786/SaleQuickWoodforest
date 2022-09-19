<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">
  <link rel="shortcut icon" href="<?php echo base_url('merchant-panel'); ?>/assets/images/favicon_1.ico">
  <title>Admin | Subadmin</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans:400,500|Raleway:300,400,500,600">
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">    
  <link href="<?php echo base_url('merchant-panel'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>/new_assets/css/waves.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('merchant-panel'); ?>/graph/app.min.css" rel="stylesheet" />  
  <link href="<?php echo base_url(); ?>/new_assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="fixed-left">
  <?php 
  include_once 'top_bar.php';
  include_once 'sidebar.php';
  ?>
  <div id="wrapper"> 
    <div class="page-wrapper edit-profile"> 
      <div class="row">
        <div class="col-12">
          <div class="back-title m-title"> 
            <span><?php echo ($meta)?></span>
            <small style="color:red;"><?php echo validation_errors(); ?></small>
          </div>
        </div>
      </div>  
      <div class="row">
        <div class="col-12">
          <div class="card content-card">
            <div class="card-detail">
              <?php
              if(isset($msg))
              {
               echo '<span class="text-success" > '.$msg.'</span>';
             }
             echo form_open_multipart('profile/'.$loc, array('id' => "my_form",'autocomplete' => "off"));
             echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
             ?>  
             <div class="card-detail recurring__geninfo">
              <div class="row custom-form responsive-cols f-wrap f-auto">
                <div class="col-12 mx-253">
                  <div class="form-group">
                    <label for="">LOGO</label>
                    <div class="profile-updater">
                      <div class="profile-icon-outer">
                        <div class="profile-icon">
                          <?php if($mypic!=''){  ?>
                            <img src="<?php echo $upload_loc.'/'.$mypic; ?>" alt="user"/>
                          <?php }else{ ?>
                            <img src="https://salequick.com/logo/no-logo.png" alt="user">
                          <?php }?>
                        </div> 
                      </div>
                      <div class="upload-btn btn">
                        <span>Upload</span>
                        <span class="material-icons">camera_alt</span>
                      </div>
                      <input type="file" style="height: auto;" class="form-control" name="mypic" id="saleQuickPfIcon"  placeholder="Editor Image:" value="<?php echo (isset($mypic) && !empty($mypic)) ? $mypic : set_value('mypic');?>">
                    </div>
                  </div>
                </div>
                <div class="col mx-253">
                  <div class="form-group">
                    <label for="">User Name</label>
                    <input type="text" class="form-control" name="title" id="title"  required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
                  </div>
                </div>
                <div class="col mx-253">
                  <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="text" class="form-control" name="url" id="url"  required value="<?php echo (isset($url) && !empty($url)) ? $url : set_value('url');?>">
                  </div>
                </div>
                <div class="col mx-253">
                  <div class="form-group">
                    <label for="">Change Password</label>
                    <input type="password" class="form-control" name="cpsw" id="cpsw">
                    <input type="hidden" class="form-control" name="psw" id="psw"  value="<?php echo $psw ? $psw : set_value('psw');?>">
                  </div>
                </div>
              </div>
              <div class="row custom-form">
                <div class="col-12 text-right">
                  <div class="form-group">
                    <input type="submit" id="btn_login" name="mysubmit"  class="btn btn-first" value="Update" />
                  </div>
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
<script>
  var resizefunc = [];
</script> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<!-- Popper for Bootstrap -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script>
<script type="text/javascript">
  $(document)
  .on('change','#saleQuickPfIcon',function(e){
    console.log($(this).val())
    readURL(this);
  })
  .on('click','.upload-btn',function(e) {
    $('#saleQuickPfIcon').trigger('click');
  })
</script>
</body>
</html>