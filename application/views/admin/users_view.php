<?php
    include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>

<style>
	.custom_margin {
		margin-left: 15px;
	    margin-right: 15px;
	}
	select.form-control {
		border: none !important;
		border-bottom: 2px solid rgba(210, 223, 245) !important;
		border-radius: 0px !important;
	    height: 30px !important;
	}
</style>

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div id="load-block">
            <div class="load-main-block">
                <div class="text-center"><img class="loader-img" src="<?= base_url('new_assets/img/giphy.gif') ?>"></div>
            </div>
        </div>
        <div class="content-viewport d-none" id="base-contents">
            <div class="row">
                <div class="col-12 py-5-custom"></div>
            </div>

            <div class="row">
            	<div class="col-sm-6 col-md-6 col-lg-6" style="margin: auto;">
            		<div class="grid grid-chart" style="width: 100% !important;">
                        <div class="grid-body d-flex flex-column">
                            <div class="mt-auto">
                            	<div class="row">
                            		<div class="col-12 custom_margin">
                            			<div class="form-title" style="margin: auto !important; margin-bottom: 20px !important;"><?php echo $meta; ?></div>
                            		</div>
                            	</div>
                            	
                            	<form method="post" action="<?php echo base_url('users'); ?>" enctype="multipart/form-data">
	                            	<div class="row" style="margin-bottom: 20px;">
	                            		<div class="col-12 custom_margin">
	                            			<div class="row">
	                            				<div style="width: auto;margin-right: 20px;margin-top: 5px;">
	                            					<label>Select Year & Month</label>
	                            				</div>
	                            				<div>
	                            					<?php
	                            					$currentYear = date('Y');
	                            					$startYear=date('Y')-2;
	                            					?>
	                            					<select class="form-control" id="csv_year" name="csv_year" required style="margin-right: 10px;width: 80px">
	                            						<option value="">Year</option>
		                            					<?php //for ($i=$startYear; $i <= $currentYear ; $i++) { ?>
		                            					<?php for ($i=$currentYear; $i >= $startYear ; $i--) { ?>
		                            						<option value="<?=$i?>"><?=$i;?></option>
		                            					<?php } ?>
	                            					</select>
	                            				</div>
	                            				<div style="width: 20%">
	                            					<select class="form-control" id="csv_month" name="csv_month" required>
	                            						<option value="">Month</option>
	                            					</select>
	                            				</div>
	                            			</div>
	                            		</div>
	                            	</div>
	                            	<div class="row">
	                            		<div class="col-12 custom_margin">
                            				<div class="form-group row" style="margin-bottom: 20px !important;">
												<input type='file' name='file' required>
                            				</div>
	                            		</div>
	                            	</div>
	                            	<div class="row" style="margin-bottom: 20px;">
	                            		<div class="col-6">
											<input type="submit" value="Upload CSV" name="upload" class="btn btn-primary" style="width: 100%;">
	                            		</div>
	                            		<div class="col-6">
	                            			<button type="button" id="view_demo" class="btn btn-primary" data-toggle="modal" data-target="#viewModal" style="width: 100%;">View Format</button>
	                            		</div>
	                            	</div>
	                            	<div class="row">
	                            		<div class="col-12">
	                            			<a class="btn btn-primary" href="<?php echo base_url("uploads/CSVSampleFormat.csv"); ?>" style="width: 100%;padding: 0.7rem 0.75rem !important;">Download Format</a>
	                            		</div>
	                            	</div>
	                            </form>

                            </div>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">CSV Sample Format</h4>
            </div>
            <div class="modal-body">
                <div class="view_sample_img">
                	<img src="<?php echo base_url('new_assets/img/agent_csv_format.png'); ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).on('change', '#csv_year', function() {
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
		$('#csv_month').empty();
		var selected_year = $('#csv_year').val();
		var current_year = "<?php echo date('Y') ?>";
		var current_month = "<?php echo date('m') ?>";
		var current_end_month = current_month-1;
		// console.log(selected_year, current_year);

		var end_month = (selected_year == current_year) ? current_end_month : 12;
		// console.log(end_month);

		var month_dropdown = '<option value="">Month</option>';
		for (i = 1; i <= end_month; i++) {
            month_dropdown += '<option value="'+i+'">'+months[i-1]+'</option>';
        }
        $('#csv_month').html(month_dropdown);
	})
</script>

	<!-- <div class="navbar-header">
	<h3>Upload CSV File</h3>
	</div>
	<?php 
	if(isset($response)){
		echo $response;
	}
	?>
	<form method='post' action='' enctype="multipart/form-data">
		<input type='file' name='file' >
		<input type='submit' value='Upload' name='upload' class="btn btn-primary" >

	<a href="<?php echo base_url().'index.php/users/show';?>" class="btn btn-success" >Fetch Records</a>
	</form> -->

<?php include_once'footer_dash.php'; ?>