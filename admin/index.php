<?php
	$dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ltz';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if($conn->connect_errno){
        echo 'Failed to connect to MySQL: (' . $conn->connect_errno . ') ' . $conn->connect_error;
    }

    $comments = array();
	$reqCount = 0;
	$sql = 'SELECT comments.timestamp, comments.title, comments.message, users.id, users.first_name, users.last_name
FROM comments INNER JOIN users WHERE comments.user_id = users.id LIMIT 5';
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($comments, $row);
		}
		$reqCount++;
	}

	$conn->close();
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <title>Hello!! Admin</title>

    <link href='vendors/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='vendors/font-awesome/css/font-awesome.min.css' rel='stylesheet'>
    <link href='vendors/nprogress/nprogress.css' rel='stylesheet'>
    <link href='vendors/iCheck/skins/flat/green.css' rel='stylesheet'>
    <link href='vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css' rel='stylesheet'>
    <link href='vendors/jqvmap/dist/jqvmap.min.css' rel='stylesheet'/>
    <link href='vendors/bootstrap-daterangepicker/daterangepicker.css' rel='stylesheet'>
    <link href='build/css/custom.min.css' rel='stylesheet'>
</head>

<body class='nav-md'>
    <div class='container body'>
        <div class='main_container'>
            <?php require('supportFiles/sidebar.php'); ?>
            <?php require('supportFiles/top_nav.php'); ?>

            <div class='right_col' role='main'>
                <!-- top tiles -->
                <div class='row tile_count'>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                        <span class='count_top'><i class='fa fa-user'></i> Total Users</span>
                        <div class='count' id='total_users'>0</div>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                        <span class='count_top'><i class='fa fa-clock-o'></i> Users Online</span>
                        <div class='count' id='online_users'>0</div>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                        <span class='count_top'><i class='fa fa-user'></i> Total Uploads</span>
                        <div class='count green' id='total_uploads'>0</div>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                        <span class='count_top'><i class='fa fa-user'></i> Total Downloads</span>
                        <div class='count' id='total_downloads'>0</div>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                        <span class='count_top'><i class='fa fa-user'></i> Accepted Uploads</span>
                        <div class='count' id='accepted_requests'>0</div>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                        <span class='count_top'><i class='fa fa-user'></i> Rejected Uploads</span>
                        <div class='count' id='rejected_requests'>0</div>
                    </div>
                </div>
                <!-- /top tiles -->

                <div class='row'>
                    <div class='col-md-8 col-sm-12 col-xs-12'>
                        <div class='dashboard_graph'>
                            <div class='row x_title'>
                                <div class='col-md-6'>
                                    <h3>Network Activities <small>Hourly Updates</small></h3>
                                </div>
                                <div class='col-md-6'>
                                    <div id='reportrange' class='pull-right' style='background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc'>
                                        <i class='glyphicon glyphicon-calendar fa fa-calendar'></i>
                                        <span>December 30, 2014 - January 28, 2015</span> <b class='caret'></b>
                                    </div>
                                </div>
                            </div>

                            <div id='chart_plot_01' class='demo-placeholder'></div><br />
                        </div><br />

                        <div style='width: 103%; margin-left: -10px'>
                            <div class='col-md-6 col-sm-6 col-xs-12'>
                                <div class='x_panel tile fixed_height_320 overflow_hidden'>
                                    <div class='x_title'>
                                        <h2>Storage Analysis</h2>
                                        <div class='clearfix'></div>
                                    </div>
                                    <div class='x_content'>
                                        <table class='' style='width:100%'>
                                            <tr>
                                                <th style='width:37%;'>
                                                    <p>Top 5</p>
                                                </th>
                                                <th>
                                                    <div class='col-lg-7 col-md-7 col-sm-7 col-xs-7'>
                                                        <p class=''>File Type</p>
                                                    </div>
                                                    <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5'>
                                                        <p class=''>Amount</p>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <canvas class='canvasDoughnut' height='140' width='140' style='margin: 15px 10px 10px 0'></canvas>
                                                </td>
                                                <td>
                                                    <table class='tile_info' id='storage_analysis_table'>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6 col-sm-6 col-xs-12'>
                                <div class='x_panel tile fixed_height_320'>
                                    <div class='x_title'>
                                        <h2>New Section</h2>
                                        <div class='clearfix'></div>
                                    </div>
                                    <div class='x_content'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-md-4 col-sm-4 col-xs-12'>
                        <div class='x_panel'>
                            <div class='x_title'>
                                <h2>User Requests <small><?php echo $reqCount; ?> new requests</small></h2>
                                <div class='clearfix'></div>
                            </div>
                            <div class='x_content'>
                                <div class='dashboard-widget-content'>

                                    <ul class='list-unstyled timeline widget'>
										<?php
				  							foreach ($comments as $row) {
												$user_link = "<a href='user.php?user_id=" . $row['id']."'>" . $row['first_name'] . " " . $row['last_name'] . "</a>";
				  								echo "<li><div class='block'><div class='block_content'>";
				  								echo "<h2 class='title'><a>" . $row['title'] . "</a></h2>";
												echo "<div class='byline'><span>" . $row['timestamp'] . "</span>";
												echo " by ". $user_link ."</div><br />";
												echo "<p class='excerpt'>" . $row['message'] . "</p>";
												echo "</div></div></li></li>";
				  						  	}
			    						?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <br />
            </div>

            <?php require('supportFiles/footer.php') ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src='vendors/jquery/dist/jquery.min.js'></script>
    <script src='js/custom/index.js'></script>
    <!-- Bootstrap -->
    <script src='vendors/bootstrap/dist/js/bootstrap.min.js'></script>
    <!-- FastClick -->
    <script src='vendors/fastclick/lib/fastclick.js'></script>
    <!-- NProgress -->
    <script src='vendors/nprogress/nprogress.js'></script>
    <!-- Chart.js -->
    <script src='vendors/Chart.js/dist/Chart.min.js'></script>
    <!-- gauge.js -->
    <script src='vendors/gauge.js/dist/gauge.min.js'></script>
    <!-- bootstrap-progressbar -->
    <script src='vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'></script>
    <!-- iCheck -->
    <script src='vendors/iCheck/icheck.min.js'></script>
    <!-- Skycons -->
    <script src='vendors/skycons/skycons.js'></script>
    <!-- Flot -->
    <script src='vendors/Flot/jquery.flot.js'></script>
    <script src='vendors/Flot/jquery.flot.pie.js'></script>
    <script src='vendors/Flot/jquery.flot.time.js'></script>
    <script src='vendors/Flot/jquery.flot.stack.js'></script>
    <script src='vendors/Flot/jquery.flot.resize.js'></script>
    <!-- Flot plugins -->
    <script src='vendors/flot.orderbars/js/jquery.flot.orderBars.js'></script>
    <script src='vendors/flot-spline/js/jquery.flot.spline.min.js'></script>
    <script src='vendors/flot.curvedlines/curvedLines.js'></script>
    <!-- DateJS -->
    <script src='vendors/DateJS/build/date.js'></script>
    <!-- bootstrap-daterangepicker -->
    <script src='vendors/moment/min/moment.min.js'></script>
    <script src='vendors/bootstrap-daterangepicker/daterangepicker.js'></script>

    <!-- Custom Theme Scripts -->
    <script src='build/js/custom.js'></script>
</body>

</html>
