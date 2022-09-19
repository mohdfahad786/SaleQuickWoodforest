<?php
    if (!empty($this->session->userdata('merchant_name'))) {
        header('Location:  '.  'https://salequick.com/merchant'  );
    }
    include_once'header_new.php';
?>
<!-- <script src="<?=base_url('assets/js/jquery.min.js')?>"></script> -->

<div id="wrapper">
    <div class="outer-page-wrapper ">
        <div class="login-register">
            <div class="log-reg-box-inner">
                <form class="row custom-form" action="<?php echo base_url('about/vts_demo');?>" method="post">
                    <div class="col-12">
                        <div class="logo-wrapper-outer clearfix">
                            <a href="<?php echo base_url(); ?>" class="logo-wrapper no-ajax">
                            <img src="https://salequick.com/front/images/logo-w.png" alt="Salequick">
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control decimal_number" name="amount" placeholder="Amount" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control decimal_number" name="tax" placeholder="Tax" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-first" value="Submit">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group text-center">
                            <p><?php echo ($this->session->flashdata('msg') ? $this->session->flashdata('msg') : ''); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once'footer_new.php'; ?>

<script>
    $('.decimal_number').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            alert('Please enter only decimal number');
            event.preventDefault();
        }

        var text = $(this).val();

        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
            alert('Please enter only decimal number');
            event.preventDefault();
        }
    });
</script>