<?php
include_once'header_new.php';
include_once'nav_new.php';
include_once'sidebar_new.php';
?>
<!-- Start Page Content -->
<div id="wrapper"> 

<!--<?php print_r($gettransaction);   ?>-->
  <div class="page-wrapper sales-summery">      
    <div class="row sales_date_range">
      <div class="col-12 custom-form">
        <div class="card content-card">
		    <div class="row">
		      	<div class="col-12">
		          	<div class="card-title">
		            	Notification    
		          	</div>
		          	<div class="card-detail">
		              	<div class="invRecptMdlWrapper ">
						  	<div class="modal-dialog modal-lg"> 
							    <div class="modal-content"> 
							      <div class="modal-header"> 
							        <div class="irm-header-inner">
							          <div class="row">
							            <div class="col">
							              <div class="irm-logo">
							                <img src="<?php echo base_url(); ?>logo/<?php echo $merchantdata[0]['logo']; ?>" alt="logo">
							              </div>
							              <div class="irm-def">
							                <h4><?php echo $merchantdata[0]['name']; ?></h4>
							                <p><b>Telephone: </b> <?php echo $merchantdata[0]['mob_no']; ?></p>
							              </div>
							            </div>
							            <div class="col">
							              <div class="irm-info">
							                <h4>RECEIPT</h4>
							                <p>Customer Copy</p>
							                <p>INVOICE NO. <span><?php echo $gettransaction['invoice_no']; ?></span></p>
							                <p>INVOICE DATE <span><?php echo $gettransaction['add_date']; ?></span></p>
							              </div>
							            </div>
							          </div>
							        </div>
							      </div> 
							      <div class="modal-body"> 
							        <div class="row">
							          <div class="col">
							            <div class="irm-inv-to">
							              <div class="irm-to-title"><span>Invoice To</span></div>
							              <div class="irm-to-sign">
										    <span><?php  if($gettransaction['name']!="")  echo $gettransaction['name'];  ?></span>
							                <img src="<?php echo $gettransaction['sign']; ?>" onerror="this.outerHTML ='-'" alt="-">
							              </div>
							              <div class="irm-to-status">
							                <span>Payment Status: </span>
							                    <span class="<?php if($gettransaction['transaction_id']!="") { echo 'pos_Status_c'; }else{ echo 'pos_Status_cncl'; }?>"> <?php if($gettransaction['transaction_id']!="") { echo 'Paid'; }else{ echo 'Unpaid'; } ?> </span>                </div>
							              </div>
							          </div>
							          <div class="col">
							            <div class="irm-pay-detail">
							              <div class="irm-pay-title"><span>Payment Details</span></div>
							              <div class="irm-pay-detail">
							                <p><span>Total Amount :</span> $<?php echo $gettransaction['amount'] ? $gettransaction['amount']:'0.00'; ?></p>
							                <p><span>Transaction ID :</span> <?php echo $gettransaction['transaction_id']; ?></p>
							                <p><span>Reference :</span><?php echo $gettransaction['reference'] ? $gettransaction['reference']:'-'; ?></p>
							                <p><span>Card Type :</span> <?php echo $gettransaction['card_type']; ?></p>
							              </div>
							            </div>
							          </div>
							        </div>
							       
							      </div> 
							      
								</div>
						  	</div>
						</div>
		          	</div>
		      	</div>
		    </div>
		</div>
	</div>
</div>

<?php
include_once'footer_new.php';
?>