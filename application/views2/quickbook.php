<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <title><?php echo PAGE_TITLE;?></title>
      
        <!-- INTUIT -->
        <script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
        <!-- INTUIT -->





        <style>
            .widget-header
            {
                background-color: #494D6A !important;
                color: #fff !important;
            }
            .widget-header h4 {
                color: #fff !important;
            }
            .widget-header .icon-reorder
            {
                color: #fff !important;
            }
        </style>


	<style type="text/css">

	.select2-container.form-control{padding:0px 0px;}
	.select2-container .select2-choice{border: none;}
	input[type="checkbox"].error{-webkit-box-shadow: 0px 0px 0px 1px rgba(255,0,0,1);
	    -moz-box-shadow: 0px 0px 0px 1px rgba(255,0,0,1);
	    box-shadow: 0px 0px 0px 1px rgba(255,0,0,1);}
	.plane-error-text{display: none; color:#FF0000; text-align: center;}
	.selected-plan{float: right; font-weight: bold; color: #8B8B8B; font-size: 18px; display: none;}
#qb_connect_button{
    background-image: url('https://salequick.com/assets/img/qb_connect.png'); 
    background-size: contain;
    width: 100px;
    height: 33px;

}
	</style>

</head>





<div id="container"><!-- container start -->

  <div id="content"><!-- Content -->
    <div class="container"><!-- Container -->

      <div class="crumbs"><!-- crumbs -->
            <ul class="breadcrumb" id="breadcrumbs">
                    <li>
                            <i class="icon-home"></i>
                            <a href="<?php echo base_url();?>dashboard">Dashboard</a>
                    </li>
                    <li><a href="<?php echo base_url();?>orgsetting">Organization Setting</a></li>
                    <li>QuickBooks Connect</li>
            </ul>
	</div><!-- crumbs -->

       

        <div class="row"><!-- row -->

          <div class="col-md-12">
            <div class="widget box">


            
              <div class="widget-content">

                    <div style="display: none" class="" id="alertBox">
                        <i data-dismiss="alert" class="icon-remove close"></i>
                        <span id="response_message"></span>
                    </div>
                <form id="validate_orgfrm" class="form-horizontal row-border" novalidate="novalidate" action="#">

                   <!-- CONNECT TO INTUIT -->
                    
                   
                
                    <div class="form-group">
                        <label class="col-md-4 control-label">Connect app to QuickBooks: </label>
                        <div class="col-md-8">
                        <a href="<?php echo $redirect_url ?>">
                        <button type="button" id="qb_connect_button"></button> 
                        </a>
                        </div>
                    </div>
                   

                </form>
              </div>

            </div>

          </div>
        </div><!-- row -->

    </div><!-- Container -->
   </div><!-- Content -->
</div><!-- container end -->


</body>
</html>
