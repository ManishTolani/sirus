<?php
    if(isset($_GET['user_id'])) {
        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'ltz';

        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        if($conn->connect_errno){
            die("Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error);
        }

		$user_data = array();
        $sql = "SELECT * FROM users WHERE id=".$_GET['user_id'];
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            while($row = $result->fetch_assoc()) {
                $user_data = $row;
            }
        }

        $uploads = array();
        $sql = "SELECT id,file_name,file_type,file_size,uploaded FROM files WHERE userid=".$_GET['user_id'] . " LIMIT 5";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($uploads, $row);
            }
        }

        $downloads = array();
        $sql = "SELECT files.file_name, files.file_type, files.file_size, downloads.start_time, downloads.end_time FROM downloads INNER JOIN files WHERE downloads.userid=".$_GET['user_id'] . " LIMIT 5";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($downloads, $row);
            }
        }

        $comments = array();
        $sql = "SELECT timestamp, title, message FROM comments WHERE user_id=".$_GET['user_id'] . " LIMIT 5";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($comments, $row);
            }
        }

        $conn->close();
    } else {
        die("No user id passed!!");
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>LTZ: User info - <?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?></title>
    <?php require('supportFiles/styles.php'); ?>
    <link rel="stylesheet" href="css/custom/user.css" />
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php require('supportFiles/sidebar.php'); ?>
        <?php require('supportFiles/top_nav.php'); ?>

        <div class="right_col" role="main">
            <div class="row">
                <div class="col-md-3 col-xs-12 widget widget_tally_box" style="height: 88vh; display: flex; justify-content: center; align-items: center;">
                    <div class="x_panel fixed_height_390" style="vertical-align: middle;">
                      <div class="x_content">
                        <div class="flex">
                            <ul class="list-inline widget_profile_box">
                                <li><a><i class="fa fa-facebook"></i></a></li>
                                <li><img src="../images/avt.png" alt="..." class="img-circle profile_img"></li>
                                <li><a><i class="fa fa-twitter"></i></a></li>
                            </ul>
                        </div>
                        <h4 class="name"><b><?php echo $user_data['first_name'] . " " . $user_data['last_name']; ?></b></h4>
                        <div class="flex" style="text-align: center;">
                            <ul class="list-inline count2">
                                <li style="margin-right: 10px;"><h3><?php echo $user_data['total_uploads']; ?></h3><span>Uploads</span></li>
                                <li style="margin-left: 10px;"><h3><?php echo $user_data['total_downloads']; ?></h3><span>Downloads</span></li>
                            </ul>
                        </div>
                        <p style="margin-top: 10px;">

                        </p>
                      </div>
                    </div>
                </div>
                <div class="col-md-9 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><b>User Info</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="custom-table table-striped" style="width: 100%;">
                                <tr>
                                    <th style='vertical-align: middle'>Name: </th>
                                    <td><input type="text" disabled class="form-control" value="<?php
                                        echo $user_data['first_name'] . ' ' . $user_data['last_name'];
                                     ?>" /></td>
                                </tr>
                                <tr>
                                    <th style='vertical-align: middle'>Username: </th>
                                    <td><input type="text" disabled class="form-control" value="<?php
                                        echo $user_data['username'];
                                     ?>" /></td>
                                </tr>
                                <tr>
                                    <th style='vertical-align: middle'>Login Status: </th>
                                    <td><input type="text" disabled class="form-control" value="<?php
                                        $logged_in = 0;
                                        ($user_data['is_logged_in'] == 0) ? $logged_in='Away' : $logged_in='Logged In';
                                        echo $logged_in;
                                     ?>" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><b>User Activity</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="custom-table table-knobs">
                                <tr>
                                    <td>
                                        <div>Uploads</div>
                                        <input class="knob" data-width="100" data-height="120" data-angleOffset=270 data-linecap=round data-fgColor="#26B99A" value="<?php
                                            echo $user_data['total_uploads'];
                                         ?>">
                                    </td>
                                    <td>
                                        <div>Downloads</div>
                                        <input class="knob" data-width="100" data-height="120" data-angleOffset=270 data-linecap=round data-fgColor="#26B99A" value="<?php
                                            echo $user_data['total_downloads'];
                                         ?>">
                                    </td>
                                    <td>
                                        <div>Requests</div>
                                        <input class="knob" data-width="100" data-height="120" data-angleOffset=270 data-linecap=round data-fgColor="#26B99A" value="<?php
                                            echo 0;
                                         ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><b>Premium Details</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="custom-table table-striped">
                                <tr>
                                    <th>Premium: </th>
                                    <td><input type="checkbox" class="js-switch" <?php
                                        $premium = '';
                                        ($user_data['premium'] == 1) ? $premium = 'checked' : $premium = '';
                                        echo $premium;
                                     ?>/></td>
                                </tr>
                                <tr>
                                    <th>Starts: </th>
                                    <td><input type="text" id='date-input' value="05/12/2017" class="form-control" data-inputmask="'mask': '99/99/9999'" disabled></td>
                                </tr>
                                <tr>
                                    <th>Ends: </th>
                                    <td><input type="text" class="form-control" data-inputmask="'mask': '99/99/9999'" value="05/12/2018" disabled></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><b>Bandwidth Management</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="custom-table table-striped">
                                <tr>
                                    <td><table class="custom-table table-striped"><tr>
                                        <th>Limit Bandwidth: </th>
                                        <td><input type="checkbox" class="js-switch" /></td>
                                    </tr></table></td>
                                    <td>
                                        <table class="custom-table table-striped"><tr>
                                            <th>Limit Bandwidth To<br/> (in Mbps): </th>
                                            <td>
                                            <div style="height: 80px;">
                                            <input class="knob" data-width="100" data-height="120" data-angleOffset=-125 data-angleArc=250 data-fgColor="#34495E" data-rotation="anticlockwise" value=<?php echo $user_data['restrict_download_speed'];?> >
                                            </div></td>
                                        </tr></table>
                                    </td>
                                </tr>
                            </table><br />
                            <div style='text-align:right'>
                                <button class="btn btn-round" style='background-color: #26B99A; color: #fff;'> Save Changes </button>
                            </div>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><b>File Uploads</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-hover table-striped">
                              <thead>
                                <tr>
								  <th style="width: 50px;">#</th>
                                  <th>File Name</th>
                                  <th style="width: 100px;">File Type</th>
                                  <th style="width: 100px;">File Size</th>
                                  <th style="width: 150px;">Uploaded</th>
                                  <th style="width: 50px;">Action</th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php
                                    $id = 0;
									$par_count = 1;
                                    foreach ($uploads as $row) {
                                        $counter = 0;
                                        echo "<tr id=" . $id .">";
                                        foreach ($row as $col) {
												if($counter == 0) {
													echo "<td>" . $par_count++ . "</td>";
													$id = $col;
												} else {
													echo "<td> $col </td>";
												}
												$counter = $counter + 1;
                                            }

                                            echo "<td style='text-align: center; padding-top: 16px;'>
                                                <input type='hidden' value=" . $id . " />";
                                            echo "<a href='' style='position:relative; top: -7px;'><i class='fa fa-trash fa-lg'></i></a>";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                              </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><b>File Downlods</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
							<table class="table table-hover table-striped">
                              <thead>
                                <tr>
								  <th style="width: 50px;">#</th>
                                  <th>File Name</th>
                                  <th style="width: 100px;">File Type</th>
                                  <th style="width: 100px;">File Size</th>
                                  <th style="width: 150px;">Start Time</th>
                                  <th style="width: 150px;">End Time</th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php
									$par_count = 1;
                                    foreach ($downloads as $row) {
                                        $counter = 0;
                                        echo "<tr id=" . $id .">";
                                        foreach ($row as $col) {
                                                if($counter == 0) {
													echo "<td>" . $par_count++ . "</td>";
												}
												echo "<td> $col </td>";
												$counter = $counter + 1;
                                            }
                                        echo "</tr>";
                                    }
                                    ?>
                              </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><b>Requests</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                  <th style="width: 150px;">Date and Time</th>
                                  <th>Message</th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php
                                    foreach ($comments as $row) {
                                        echo "<tr>";
                                        echo "<td>" . $row['timestamp'] . "</td>";
										echo "<td><b>" . $row['title'] . "</b><br />" . $row['message'] . "</b></td>";
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

        <?php require('supportFiles/footer.php'); ?>
      </div>
    </div>
    <?php require('supportFiles/scripts.php'); ?>
  </body>
</html>
