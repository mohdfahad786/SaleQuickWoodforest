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
<h1> View All Customer Recurring  Payment Request </h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Dashboard</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
<div class="row">
<form method="post" action="<?php echo base_url('merchant/all_customer_request');?>" >
					     <div class="col-md-3 col-xs-12 form-group">
				      
	
<select class="form-control"  name="status" id="status">
   <option value="">Select Status</option>
    <option value="pending">Pending</option>
     <option value="confirm">Confirm</option>
   <!--   <option value="block">Block</option> -->
 
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
            <div class="col-md-2 col-xs-12 form-group">

</div>    

<div class="col-xs-12">
<div class="box">
<div class="box-header table-responsive">
 


   
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
<th>Name</th>
<th>Email id</th>
<th>Mobile No</th>
<th>Title</th>
<th>Amount</th>
<th>Type</th>

<th>Status</th>
<th>Date</th>
<th>Recurring Status</th>
<th>Action</th>
<!-- <th>Edit</th>
<th>Delete</th> -->
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
<td> <?php echo $a_data['name'] ?></td>
<td> <?php echo $a_data['email'] ?></td>
<td> <?php echo $a_data['mobile'] ?></td>
<td> <?php echo $a_data['title'] ?></td>
<td> <?php echo $a_data['amount'] ?></td>
<td> <?php echo $a_data['payment_type'] ?></td>
<td> <?php echo $a_data['status'] ?></td>
<td> <?php echo $a_data['date'] ?></td>
<td> <?php echo $a_data['recurring_payment'] ?></td>

            <td> <?php
if($a_data['recurring_payment']=='start'){

$data = array(
'id' => 'del-bt',
'content' => ' <a  >Stop</a>',
'onclick' => 'javascript:stop_pak('.$a_data['id'].')'
);
echo form_button($data);

}

elseif($a_data['recurring_payment']=='stop')
{

$data = array(
'id' => 'del-bt',
'content' => ' <a  >Start</a>',
'onclick' => 'javascript:start_pak('.$a_data['id'].')'
);
echo form_button($data);
}

?>     </td>

<!-- <td> <a id="edit-bt" href="<?php  echo base_url('merchant/edit_request/' . $a_data['id']) ?>"><i class="fa fa-pencil"></i> </a></td>
<td> <a ><i class="fa fa-remove"></i></a> </td> -->

<td>
            <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $a_data['id'];  ?>" id="getUser" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
            </td>



</tr>
<?php $i++;}?>
</tbody>
<input type="hidden" id="id" value="<?php echo $i-1;?>" />
</table>



 <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog"> 
                  <div class="modal-content"> 
                  
                       <div class="modal-header"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                            <h4 class="modal-title">
                              <i class="glyphicon glyphicon-user"></i> Payment Detail
                            </h4> 
                       </div> 
                       <div class="modal-body"> 
                       
                           <div id="modal-loader" style="display: none; text-align: center;">
                            <img src="<?php echo base_url("logo/ajax-loader.gif"); ?>">
                           </div>
                            
                           <!-- content will be load here -->                          
                           <div id="dynamic-content"></div>
                             
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        </div> 
                        
                 </div> 
              </div>
       </div><!-- /.modal -->    
    
    </div>


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
   
   <script>
$(document).ready(function(){
  
  $(document).on('click', '#getUser', function(e){
    
    e.preventDefault();
    
    var uid = $(this).data('id');   // it will get id of clicked row
    
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({

     url: "<?php  echo base_url('merchant/search_record_column'); ?>",

     
      type: 'POST',
      data: 'id='+uid,
      dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); // load response 
      $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
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