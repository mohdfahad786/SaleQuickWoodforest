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

<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/detect.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/fastclick.js"></script>
<script src="<?php echo base_url('new_assets/js/dashboard_js/core.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<script src="<?php echo base_url(); ?>/new_assets/js/waves.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/switchery/switchery.min.js"></script>

<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/new_assets/js/datatables.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('new_assets/js/dt_js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('new_assets/js/dt_js/dataTables.bootstrap4.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('new_assets/js/dt_js/dataTables.responsive.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('new_assets/js/dt_js/responsive.bootstrap4.min.js'); ?>"></script>

<!-- Custom main Js -->
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.app.js"></script>
<script src="<?php echo base_url('new_assets/js/dashboard_js/template.js') ?>"></script>
<script src="<?php echo base_url('new_assets/js/dashboard_js/dashboard.js') ?>"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url('merchant-panel'); ?>/assets/js/masking.js"></script>

<script>
    setTimeout(function(){ 
        window.dispatchEvent(new Event('resize'));
    }, 1500);

    $('#load-block').addClass('d-none');
    $('#base-contents').removeClass('d-none');
</script>

</body>
</html>