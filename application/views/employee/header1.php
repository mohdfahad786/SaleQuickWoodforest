<link href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="<?php echo base_url("assets/dist/css/AdminLTE.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url("assets/dist/css/skins/_all-skins.min.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url("assets/plugins/iCheck/flat/blue.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo base_url("assets/plugins/morris/morris.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?php echo base_url("assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?php echo base_url("assets/plugins/datepicker/datepicker3.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker-bs3.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo base_url("assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"); ?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.css"); ?>" rel="stylesheet" type="text/css" />
 <!-- jQuery 2.1.3 -->
    <script src="<?php echo base_url("assets/plugins/jQuery/jQuery-2.1.3.min.js"); ?>"></script>
      <script src="<?php echo base_url("assets/plugins/jQuery/common.js"); ?>"></script>
       <script src="<?php echo base_url("assets/plugins/jQuery/student.js"); ?>"></script> 
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
      
        <a href="#" class="logo"><b>Merchnat Panel</b></a>
        
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <?php if($this->session->userdata('merchant_logo')!='') {?>
                  <img src="<?php echo base_url("logo/".$this->session->userdata('merchant_logo')); ?>" class="user-image" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
<?php }  else { ?>
                   <img src="<?php echo base_url("logo/") ?>/nologo.jpg" class="user-image" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
 <?php } ?>
                  <span class="hidden-xs"><?php echo  $session_id = $this->session->userdata('merchant_name'); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
  <?php if($this->session->userdata('merchant_logo')!='') {?>
             <img src="<?php echo base_url("logo/".$this->session->userdata('merchant_logo')); ?>" class="img-circle" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
<?php }  else { ?>
 <img src="<?php echo base_url("logo/") ?>/nologo.jpg" class="img-circle" alt="<?php echo  $session_id = $this->session->userdata('merchant_name'); ?>"/>
 <?php } ?>
                    <p>
                     <p><?php echo  $session_id = $this->session->userdata('merchant_name'); ?></p>
                    
                    </p>
                  </li>
                  <!-- Menu Body -->
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                   
                      <a href="<?php echo base_url('merchant'); ?>" class="btn btn-default btn-flat">Dashboard</a>
                      
                   
                    </div>
                   <script type="text/javascript">
var XMLHttpRequestObject = false;
var base_url = '<?php echo base_url(); ?>';
var base_url_no_index = '<?php echo base_url(); ?>';
</script>
<?php

if(isset($extraHeadContent))
echo $extraHeadContent;
?>
                    <div class="pull-right">
                      <a href="<?php echo base_url('logout/merchant'); ?>" class="btn btn-default btn-flat">Sign Out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
 <div class="col-lg-12 col-sm-12 col-xs-12" style="margin-left:50px;">
 
 
</div>
        </nav>
      </header>