
   
    <!-- jQuery UI 1.11.2 -->
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>" type="text/javascript"></script>    
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("assets/plugins/datatables/dataTables.bootstrap.js"); ?>" type="text/javascript"></script>  
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url("assets/plugins/morris/morris.min.js"); ?>" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url("assets/plugins/sparkline/jquery.sparkline.min.js"); ?>" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url("assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"); ?>" type="text/javascript"></script>
   <script src="<?php echo base_url("assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"); ?>" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url("assets/plugins/knob/jquery.knob.js"); ?>" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.js"); ?>" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="<?php echo base_url("assets/plugins/datepicker/bootstrap-datepicker.js"); ?>" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url("assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"); ?>" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url("assets/plugins/iCheck/icheck.min.js"); ?>" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url("assets/plugins/slimScroll/jquery.slimscroll.min.js"); ?>" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo base_url("assets/plugins/fastclick/fastclick.min.js"); ?>'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url("assets/dist/js/app.min.js"); ?>" type="text/javascript"></script>

	 <script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>