</div>
<script>
    var resizefunc = [];

    $(document).ready(function() {
        document.onreadystatechange = function () {
            var state = document.readyState
            if (state == 'interactive') {
                $('#load-block').addClass('d-none');
            } else if (state == 'complete') {
                setTimeout(function(){
                    $('#load-block').addClass('d-none');
                    $('#base-contents').removeClass('d-none');
                },1000);
            }
        }
    })
</script>
<!-- Plugins  -->
<script src="https://salequick.com/merchant-panel/assets/js/popper.min.js"></script>
<!-- <script src="https://salequick.com/merchant-panel/assets/js/bootstrap.min.js"></script> -->

<script src="https://salequick.com/merchant-panel/assets/js/detect.js"></script>
<script src="https://salequick.com/merchant-panel/assets/js/fastclick.js"></script>
<script src="<?php echo base_url('new_assets/js/dashboard_js/core.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.js"></script>
<script src="https://salequick.com/merchant-panel/assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url('new_assets/js/waves.js') ?>"></script>
<script src="https://salequick.com/merchant-panel/assets/js/jquery.nicescroll.js"></script>
<script src="https://salequick.com/merchant-panel/assets/js/jquery.scrollTo.min.js"></script>
<script src="https://salequick.com/merchant-panel/plugins/switchery/switchery.min.js"></script>
<script src="https://salequick.com/merchant-panel/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript" src="https://salequick.com/merchant-panel/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
<script src="<?php echo base_url('new_assets/js/select2.min.js')?>"></script>
<script src="https://salequick.com/merchant-panel/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
<script src="https://salequick.com/merchant-panel/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://salequick.com/merchant-panel/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url('new_assets/js/jquery.form-advanced.init.js')?>"></script>

<script src="<?php echo base_url('new_assets/js/jquery.tagsinput.js')?>"></script> 
<!-- <script src="<?php echo base_url('new_assets/js/jquery.app.js')?>"></script> 
<script type="text/javascript" src="<?php echo base_url('new_assets/js/datatables.min.js')?>"></script>-->

<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>







<script src="<?php echo base_url('new_assets/js/jquery.circliful.js')?>"></script>
<script src="<?php echo base_url('new_assets/js/colorScript.js')?>"></script>
<script src="https://salequick.com/merchant-panel/assets/js/masking.js"></script>

<script src="<?php echo base_url('new_assets/js/dashboard_js/template.js') ?>"></script>
<script src="<?php echo base_url('new_assets/js/dashboard_js/dashboard.js') ?>"></script>
<script src="<?php echo base_url('new_assets/js/script.js')?>"></script>

<script src="<?php echo base_url('new_assets/js/jquery.number.min.js') ?>"></script>

  <script src="<?php echo base_url('new_assets/js/jquery.maskMoney.min.js') ?>" type="text/javascript"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>-->
<script>
// $('.money').mask("#,##0.00", {reverse: true});
$('input.number').number(true, 2 );

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>

$(document).ready(function() {
    $('#dt_inv_pos_sale_list').DataTable({
        
        "processing": true,
					// "sAjaxSource":"data.php",
					"pagingType": "full_numbers",
					"pageLength": 25,
					"dom": 'lBfrtip', 
					"order": [],
					"ordering": false,
					// "order": [[ 7, "desc" ]],
					"destroy": true,
					responsive: true,
					language: {
						search: '', searchPlaceholder: "Search",
						oPaginate: {
							 sNext: '<i class="fa fa-angle-right"></i>',
							 sPrevious: '<i class="fa fa-angle-left"></i>',
							 sFirst: '<i class="fa fa-step-backward"></i>',
							 sLast: '<i class="fa fa-step-forward"></i>'
							 }
					 }   ,
					"buttons": [
						{
							extend: 'collection',
							text: '<span>Export List</span> <span class="material-icons"> arrow_downward</span>',
							buttons: [
							'copy',
							'excel',
							'csv',
							'pdf',
							'print'
							]
						}
					]
    });
} );

  $(function() {
    $('#money').maskMoney();
  })
  setTimeout(function(){ 
       // alert('hello');
        window.dispatchEvent(new Event('resize'));
    }, 3000);
</script>


</body>
</html>