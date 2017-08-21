<?php
	$baseTemplate = "<script src='vendors/jquery/dist/jquery.min.js'></script><script src='vendors/bootstrap/dist/js/bootstrap.min.js'></script><script src='vendors/fastclick/lib/fastclick.js'></script><script src='vendors/nprogress/nprogress.js'></script><script src='vendors/iCheck/icheck.min.js'></script>";

	$table = "<script src='vendors/datatables.net/js/jquery.dataTables.min.js'></script><script src='vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'></script><script src='vendors/datatables.net-buttons/js/dataTables.buttons.min.js'></script><script src='vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'></script><script src='vendors/datatables.net-buttons/js/buttons.flash.min.js'></script><script src='vendors/datatables.net-buttons/js/buttons.html5.min.js'></script><script src='vendors/datatables.net-buttons/js/buttons.print.min.js'></script><script src='vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js'></script><script src='vendors/datatables.net-keytable/js/dataTables.keyTable.min.js'></script><script src='vendors/datatables.net-responsive/js/dataTables.responsive.min.js'></script><script src='vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'></script><script src='vendors/datatables.net-scroller/js/dataTables.scroller.min.js'></script>";

	$inputMasks = "<script src='vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'></script>";

	$flotgraph = "<script src='vendors/Flot/jquery.flot.js'></script>
    <script src='vendors/Flot/jquery.flot.pie.js'></script>
    <script src='vendors/Flot/jquery.flot.time.js'></script>
    <script src='vendors/Flot/jquery.flot.stack.js'></script>
    <script src='vendors/Flot/jquery.flot.resize.js'></script>
    <script src='vendors/flot.orderbars/js/jquery.flot.orderBars.js'></script>
    <script src='vendors/flot-spline/js/jquery.flot.spline.min.js'></script>
    <script src='vendors/flot.curvedlines/curvedLines.js'></script>";

	$date = "<script src='vendors/DateJS/build/date.js'></script>
    <script src='vendors/moment/min/moment.min.js'></script>
    <script src='vendors/bootstrap-daterangepicker/daterangepicker.js'></script>";

	$indexPage = "<script src='vendors/Chart.js/dist/Chart.min.js'></script><script src='vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'></script>";

	if($_SERVER['PHP_SELF'] == '/admin/index.php') {
		echo $baseTemplate . $indexPage . $flotgraph . $date . "<script src='build/js/custom.js'></script>";
	} else {
		echo $baseTemplate . $table . "<script src='vendors/switchery/dist/switchery.min.js'></script><script src='vendors/jquery-knob/dist/jquery.knob.min.js'></script><script src='vendors/pdfmake/build/vfs_fonts.js'></script><script src='js/custom/upload_requests.js'></script><script src='build/js/custom.js'></script>";
	}
?>
