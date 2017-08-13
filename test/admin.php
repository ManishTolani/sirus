<?php
    session_start();
    if( isset($_SESSION['user_data']['id']) and !empty($_SESSION['user_data']['id']) ){

        $dbHost = 'localhost';
    	$dbUsername = 'root';
    	$dbPassword = '';
    	$dbName = 'ltz';

        /* Query to show files with unconfirmed status */
        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    	if($conn->connect_errno){
    		echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    	}

        $sql = "SELECT files.id, files.file_name, files.uploaded, files.ip, users.first_name, users.last_name, users.username FROM files INNER JOIN users WHERE files.confirmed = 0 ORDER BY files.uploaded DESC";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = array();
            while($row = $result->fetch_assoc()) {
                array_push($arr, $row);
            }
            print_r($arr);
        } else {
            echo "0 results";
        }

        $conn->close();


        /* Query to update status from unconfirmed to confirmed */
        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    	if($conn->connect_errno){
    		echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    	}

        $file_id = 3;
        $sql = "UPDATE files SET confirmed = 1 WHERE id='$file_id'";

        if($conn->query($sql)) {
            echo "Update Successfull";
        } else {
            echo "Error";
        }

        $conn->close();

        /* Query to fetch all the unread comments */
        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    	if($conn->connect_errno){
    		echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    	}

        $sql = "SELECT * from comments WHERE done_reading = 0";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $arr = array();
            while($row = $result->fetch_assoc()) {
                array_push($arr, $row);
            }
            print_r($arr);
        } else {
            echo "0 results";
        }

        $conn->close();

    } else header("Location: ../index.php");
?>
