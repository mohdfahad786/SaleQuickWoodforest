<header class="header-wraper">
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid mx-1200">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span> 
	      </button>
	      <a class="navbar-brand" href="<?php echo base_url('')?>">
	      	<img src="<?php echo base_url('assets/img/logo-w.png')?>" alt="logo">
	      </a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="<?php echo base_url('#howItWork')?>">How It Works</a></li>
	        <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Payment Solution
				<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="pos">In-Store & Mobile</a></li>
					<li><a href="invoice">Invoice</a></li>
					<li><a href="api">API</a></li>
				</ul>
			</li>
	        <li><a href="pricing">Pricing</a></li>
	        <li><a href="https://salequick.com/home#contactUs">Contact Us</a></li>
	       
	        
	        <?php 



if( $this->session->userdata('merchant_id')!='') { ?>




      <li><a href="<?=base_url('merchant')?>" class="btn btn-default btn-xs login_btn">Dashboard</a></li>
       <li><a href="<?= base_url('logout/merchant'); ?>" class="btn btn-default btn-xs">Sign Out</a></li>

<?php } else { ?>


       <li><a href="<?= base_url('login')?>" class="btn btn-default btn-xs login_btn">Log In</a></li>
       <li><a href="<?= base_url('signup'); ?>" class="btn btn-default btn-xs">Sign Up</a></li>

       <?php } ?>
	        
	        
	        
	        
	       
	      </ul>
	    </div>
	  </div>
	</nav>
</header>


