<?php
include_once'header_dash.php';
    include_once'nav_label.php';
    include_once'sidebar_dash.php';
?>
<!-- Start Page Content -->
<div id="wrapper"> 
    <div class="page-wrapper edit-profile">  
        <div class="row">
            <div class="col-12">
                <div class="back-title m-title "> 
                    <span><?php echo ($meta)?></span>
                </div>
            </div>
        </div>  
       <?php
            if(isset($msg))
            echo '<div class="row"> <div class="col-12"> <div class="back-title m-title "> <span>'. $msg.'</span> </div> </div> </div>'
        ?>
        <?php        
            echo form_open('merchant/'.$loc, array('id' => "my_form"));
            echo isset($bct_id) ? form_hidden('bct_id', $bct_id) : "";
        ?> 
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" id="btn_login" name="submit"  class="btn btn-first" value="Resend Confirm Link" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php echo form_close(); ?> 
    </div>
</div>
<?php
include_once'footer_new.php';
?>