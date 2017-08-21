<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ltz';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if($conn->connect_errno){
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

    $sql = "SELECT files.id, files.file_name, users.username, files.uploaded, files.file_type, files.file_size FROM files INNER JOIN users WHERE files.confirmed='0' ORDER BY files.uploaded DESC;";

    $arr = array();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $row['file_size'] = round(($row['file_size']/(1024*1024)), 2) . ' MB';
            array_push($arr, $row);
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>LTZ: New File Upload Requests</title>
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
                          <th>File Name</th>
                          <th>Uploaded By</th>
                          <th>Upload Time</th>
                          <th>File Type</th>
                          <th>File Size</th>
                          <th>Accept / Reject</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                            $id = 0;
                            foreach ($arr as $row) {
                                $counter = 0;
                                echo "<tr id=" . $id .">";
                                foreach ($row as $col) {
                                        $counter = $counter + 1;
                                        if($counter == 1) {
                                            $id = $col;
                                            continue;
                                        }
                                        echo "<td> $col </td>";
                                    }
                                    echo "
                                    <td>
                                        <input type='hidden' value=" . $id . " />
                                        <button type='button' class='response-button accept btn btn-success btn-xs'>Accept</button><button type='button' class='response-button reject btn btn-warning btn-xs '>Reject</button>
                                    </td>";
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
