<?php

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ltz';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if($conn->connect_errno){
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

    $comments = array();
	$sql = "SELECT timestamp, title, message FROM comments LIMIT 5";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($comments, $row);
		}
	}

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>LTZ: Messages and Content Requests</title>
    <?php require('supportFiles/styles.php'); ?>
    <style>

    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
          <?php require('supportFiles/sidebar.php'); ?>
          <?php require('supportFiles/top_nav.php'); ?>

          <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><b>New Uploads</b> <small></small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>File upload confirmation <small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    This section shows the recent file uploads yet to be confirmed..
                    </p>
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
  						<thead>
  						  <tr>
  							<th style="width: 150px;">Date and Time</th>
							<th>Message Title</th>
							<th>Message</th>
  						  </tr>
  						</thead>

  						<tbody>
  						  <?php
							foreach ($comments as $row) {
								echo "<tr>";
								foreach ($row as $col) {
									echo "<td> $col </td>";
								}
								echo "</tr>";
						  	}
  						  ?>
  						</tbody>
  					</table>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <?php require('supportFiles/footer.php'); ?>
      </div>
    </div>

    <?php require('supportFiles/scripts.php'); ?>
  </body>
</html>
