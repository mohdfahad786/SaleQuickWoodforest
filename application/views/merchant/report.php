<script src="<?php echo base_url('new_assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            type    : 'POST',
            url     : "<?= base_url('report/email_report_new'); ?>",
            data    : {'aaa' : 1},
            success : function (data){
                
            }
        });
    })
</script>

<?php include_once'footer_dash.php'; ?>