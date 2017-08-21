<?php
	$metaData = "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><meta charset='utf-8'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1'>";

	$indexPage = "<link href='vendors/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'><link href='vendors/font-awesome/css/font-awesome.min.css' rel='stylesheet'><link href='vendors/nprogress/nprogress.css' rel='stylesheet'><link href='vendors/iCheck/skins/flat/green.css' rel='stylesheet'><link href='vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css' rel='stylesheet'><link href='vendors/jqvmap/dist/jqvmap.min.css' rel='stylesheet'/><link href='vendors/bootstrap-daterangepicker/daterangepicker.css' rel='stylesheet'><link href='build/css/custom.min.css' rel='stylesheet'>";

	$otherPages = "<link href='vendors/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'><link href='vendors/font-awesome/css/font-awesome.min.css' rel='stylesheet'><link href='vendors/nprogress/nprogress.css' rel='stylesheet'><link href='vendors/iCheck/skins/flat/green.css' rel='stylesheet'><link href='vendors/datatables.net-bs/css/dataTables.bootstrap.min.css' rel='stylesheet'><link href='vendors/switchery/dist/switchery.min.css' rel='stylesheet'><link href='vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css' rel='stylesheet'><link href='vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css' rel='stylesheet'><link href='vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css' rel='stylesheet'><link href='vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css' rel='stylesheet'><link href='build/css/custom.min.css' rel='stylesheet'>";

	if($_SERVER['PHP_SELF'] == '/admin/index.php') {
		echo $metaData . $indexPage;
	} else {
		echo $metaData . $otherPages;
	}
?>
