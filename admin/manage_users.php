<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ltz';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if($conn->connect_errno){
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

    $sql = "SELECT id, first_name, last_name, username, premium, allow_access, is_logged_in, created_at FROM users ORDER BY created_at";

    $arr = array();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>LTZ: User Management</title>
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
                <h3><b>Users List</b> <small></small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Users <small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    This section lists all the user accounts in order of their creation date..
                    </p>
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>User</th>
                          <th>User-Name / Email</th>
                          <th>Login Status</th>
                          <th>Created at</th>
                          <th>Allowed / Blocked</th>
                          <th>Premium</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                            foreach ($arr as $row) {
                                echo "<tr>";
                                $name = "<a href='user.php?user_id=".$row['id']."'>" . $row['first_name'] . " " . $row['last_name'] . "</a>";
                                $user_name = $row['username'];
                                $created_at = $row['created_at'];
                                ($row['is_logged_in']) ? $login_status = "Logged In": $login_status = "Logged Out";
                                ($row['allow_access']) ? $access = "Allowed" : $access = "Blocked";
                                ($row['premium']) ? $premium = "Premium User" : $premium = "Normal User";

                                echo "<td>$name</td> <td>$user_name</td> <td>$login_status</td> <td>$created_at</td> <td>$access</td> <td>$premium</td>";
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
