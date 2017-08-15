<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ltz';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if($conn->connect_errno){
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

    $sql = 'SELECT * from comments ORDER BY timestamp DESC';

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
    <title>DataTables | Gentelella</title>
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
                <h3>New Uploads <small></small></h3>
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
                          <th>From</th>
                          <th>Message</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                            foreach ($arr as $row) {
                                echo "<tr id=" . $id .">";
                                foreach ($row as $col) {
                                        $counter = $counter + 1;
                                        if($counter == 1) {
                                            $id = $col;
                                            continue;
                                        }
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
        <!-- /page content -->

        <!-- footer content -->
        <?php require('supportFiles/footer.php'); ?>
      </div>
    </div>

    <?php require('supportFiles/scripts.php'); ?>
  </body>
</html>
