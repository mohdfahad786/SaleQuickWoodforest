</div>
<script>
    var resizefunc = [];

    $(document).ready(function() {
        document.onreadystatechange = function () {
            var state = document.readyState
            if (state == 'interactive') {
                $('#load-block').addClass('d-none');
            } else if (state == 'complete') {
                // setTimeout(function(){ 
                //    // alert('hello');
                //     window.dispatchEvent(new Event('resize'));
                //     $('#load-block').addClass('d-none');
                //     $('#base-contents').removeClass('d-none');
                // }, 3000);

                setTimeout(function(){
                    // $('#load-block').addClass('d-none');
                    // $('#base-contents').removeClass('d-none');
                },1000);
            }
        }
    });
</script>

<!-- Plugins  --> 
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/popper.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script>
<script src="<?php echo base_url('new_assets/js/dashboard_js/core.js') ?>"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.slimscroll.js"></script> -->
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.blockUI.js"></script> -->
<script src="<?php echo base_url(); ?>/new_assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.js"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/multiselect/js/jquery.multi-select.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url('merchant-panel'); ?>/plugins/jquery-quicksearch/jquery.quicksearch.js"></script> -->
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/plugins/select2/select2.min.js" type="text/javascript"></script> -->
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/plugins/moment/moment.js"></script> -->
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script> -->
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/pages/jquery.form-advanced.init.js"></script> -->
<!-- <script src="<?php echo base_url('new_assets/js/jquery.tagsinput.js')?>"></script>  -->
<script type="text/javascript" src="<?php echo base_url(); ?>/new_assets/js/datatables.min.js"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script> -->

<!-- Custom main Js -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<!-- <script src="<?php echo base_url(); ?>/new_assets/js/jquery.circliful.js"></script> -->
<script src="<?php echo base_url('new_assets/js/dashboard_js/template.js') ?>"></script>
<script src="<?php echo base_url('new_assets/js/dashboard_js/dashboard.js') ?>"></script>
<!-- <script src="<?php echo base_url('merchant-panel'); ?>/assets/js/script.js"></script> -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>

<script>
    setTimeout(function(){ 
        window.dispatchEvent(new Event('resize'));
    }, 1500);

    $('#load-block').addClass('d-none');
    $('#base-contents').removeClass('d-none');
</script>

</body>
</html>