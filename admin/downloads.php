<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ltz';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if($conn->connect_errno){
        die("Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error);
    }

	$downloads = array();
	$sql = "SELECT files.file_name, files.file_type, files.file_size, downloads.start_time, downloads.end_time FROM downloads INNER JOIN files WHERE downloads.fileid = files.id";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($downloads, $row);
		}
	}

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>LTZ: Download Stats</title>
    <?php require('supportFiles/styles.php'); ?>
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
                <h3><b>Downloads</b> <small></small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Downloads List <small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    This section
                    </p>
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>File Name</th>
                          <th>File Type</th>
                          <th>File Size</th>
						  <th>Start Time</th>
						  <th>End Time</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                            $id = 0;
                            foreach ($downloads as $row) {
                                echo "<tr id=" . $id .">";
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
