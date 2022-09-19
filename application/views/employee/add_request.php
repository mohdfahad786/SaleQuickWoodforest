<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Merchant | Dashboard</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.2 -->
<?php
    $this->load->view('merchant/header');
    ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <?php
    $this->load->view('merchant/menu');
    ?>
  <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo ($meta)?> </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <section class="col-lg-10 connectedSortable">
        <div class="box box-info">
          <?php
    if(isset($msg))
    echo "<h4> $msg</h4>";
    
    echo form_open('merchant/'.$loc, array('id' => "my_form"));
    echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
    ?>
          <form>
            <div class="box-body">
			
			
 <div class="form-group">
                <label for="name">Email Id </label>
                <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$"  placeholder="Email Id:"
				value="<?php echo (isset($email) && !empty($email)) ? $email : set_value('email');?>" required>
               
            </div>
            


                <div class="form-group">
                <label for="name">Amount</label>
                <input type="text" class="form-control" name="amount" onKeyPress="return isNumberKey(event)" id="amount"  placeholder="Amount:" 
				required value="<?php echo (isset($amount) && !empty($amount)) ? $amount : set_value('amount');?>">
                </div>
                <div class="form-group">
                <label for="name">Title</label>
                <input type="text" class="form-control" name="title" id="title"  placeholder="Title:" 
				required value="<?php echo (isset($title) && !empty($title)) ? $title : set_value('title');?>">
              </div>

               <div class="form-group">
                <label for="name">Remark</label>
                <input type="text" class="form-control" name="remark" id="remark"  placeholder="Remark:" 
        required value="<?php echo (isset($remark) && !empty($remark)) ? $remark : set_value('remark');?>">
              </div>
				
				
				 
                
                
             
            
            <div class="box-footer clearfix">
              <input type="submit" id="btn_login" name="submit"  class="btn btn-primary" value="<?php echo $action ?>" />
            </div>
          </form>
          <?php echo form_close(); ?> </div>
      </section>
      
    </div>
  </section>
  <!-- /.content -->
</div>
  <script>


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>








<?php  $this->load->view('admin/footer'); ?>
</body></html>
