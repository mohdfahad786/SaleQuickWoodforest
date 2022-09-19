<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Merchant | Dashboard</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<?php $this->load->view('merchant/header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
        <link href="<?php echo base_url("assets/plugins/daterangepicker/bootstrap-datetimepicker.min.css"); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url("assets/js/calendar/jquery.calendars.picker.css"); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
<aside class="main-sidebar">
<?php $this->load->view('merchant/menu'); ?>
</aside>
<div class="content-wrapper">
<section class="content-header">
<h1> View All Payment Request </h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Dashboard</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
<div class="row">
<form method="post" action="<?php echo base_url('merchant/all_payment_request');?>" >
					     <div class="col-md-3 col-xs-12 form-group">
				      
	
<select class="form-control"  name="status" id="status">
   <option value="">Select Status</option>
    <option value="pending">Pending</option>
     <option value="confirm">Confirm</option>
      <option value="block">Block</option>
 
    </select>
					  
					  
                       </div>
                       
                       <div class="col-md-3 col-xs-12 form-group">
                       
                     <div class="input-group date datetimepicker" style="z-index:999">
      <input type="text" name="curr_payment_date" id="curr_payment_date"    class="form-control" autocomplete="off"  >
                       
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                       </div>
                  <div class="col-md-2 col-xs-12 form-group">
                      <input type="submit" name="mysubmit" class="btn btn-primary " value="Search" />              
					   </div>
					  </form> 
<div class="col-xs-12">
<div class="box">
<div class="box-header table-responsive">
 
<?php

echo form_open('merchant/bulk_action', array('id' => "my_form"));
echo isset($pak_id) ? form_hidden('pak_id', $pak_id) : "";
?>    

   
<?php
$count = 0;
if(isset($msg))
echo $msg;
?>

<div class="box-body ">
<table id="example2" class="table table-bordered table-hover">

<thead>
<tr>
<th><input type="checkbox" name="checkall" id="checkall" onClick="CheckAll()"  /></th>
<th>Sr.No.</th>
<th>Title</th>
<th>Amount</th>

<th>Status</th>
<th>Date</th>
<th>Edit</th>
<th>View</th>


</tr>
</thead>

<tbody>
<?php
$i=1;
	foreach($mem as $a_data)
{
$count++;
 
	?>
<tr>
<td><input type="checkbox" name="id[]" id="ids<?php echo $i?>" value="<?php echo $a_data['id']?>" /></td>
<td> <?php echo $i; ?></td>
<td> <?php echo $a_data['title'] ?></td>

<td> <?php echo $a_data['amount'] ?></td>


<td> <?php echo $a_data['status'] ?></td>
<td> <?php echo $a_data['date'] ?></td>
<td> <a id="edit-bt" href="<?php  echo site_url('merchant/edit_request/' . $a_data['id']) ?>"><i class="fa fa-pencil"></i> </a></td>
<td> <?php echo $a_data['status'] ?></td>



</tr>
<?php $i++;}?>
</tbody>
<input type="hidden" id="id" value="<?php echo $i-1;?>" />
</table>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>


   <?php echo form_close(); ?>
</div>

</div>
</div>
</div>
</div>
</section>
</div>
<?php $this->load->view('admin/sec_footer'); ?>
<script src="http://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url("assets/plugins/daterangepicker/moment.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/plugins/daterangepicker/bootstrap-datetimepicker.min.js"); ?>" type="text/javascript"></script>




<script type="text/javascript">
    $(function () {
        $('.datetimepicker').datetimepicker({
            locale: 'en',
            format: 'YYYY-MM-DD ',
            useCurrent: true,
            sideBySide: true,
            showTodayButton: true
        });
    });
</script>
     
 
 <script type="text/javascript">
   function CheckAll()
     {  
		   var post_count = document.getElementById('id').value;
		   var k ;
		   var j =0
		    for(k=1; k<=post_count;k++)
			   {
			     if(document.getElementById('checkall').checked==true)
	                 {
			              document.getElementById('ids'+k).checked=true;
						  j++;
			         }
				 else
				   {
				     document.getElementById('ids'+k).checked=false;
				   }	 
		       }9
	 }
 </script>
</body>
</html>