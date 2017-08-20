<?php
	session_start();
	require('storageData.php');

    function getip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    if(!empty($_FILES) && isset($_SESSION) && isset($_SESSION['user_data'])) {

        $dbHost = 'localhost';
    	$dbUsername = 'root';
    	$dbPassword = '';
    	$dbName = 'ltz';

        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    	if($conn->connect_errno){
    		echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    	}

    	$ip = getip();
    	$targetDir = "/opt/lampp/htdocs/ltz/uploads/";

    	$fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $fileType = 'unknown';

        if( $ext === 'gif' || $ext === 'png' || $ext === 'jpg' || $ext === 'jpeg') {
            $fileType = "image";
        } else if($ext === 'mp4' || $ext === '3gp' || $ext === 'mkv' || $ext === 'avi') {
            $fileType = "video";
        } else if($ext === 'exe' || $ext === 'zip' || $ext === 'msi' || $ext === 'deb') {
            $fileType = "software";
        } else if($ext === 'mp3' || $ext === 'm4a') {
            $fileType = "music";
        }

        $targetDir = $targetDir . $fileType . "/";
        $targetFile = $targetDir.$fileName;
        $user_id = $_SESSION['user_data']['id'];

    	if( move_uploaded_file($_FILES['file']['tmp_name'] , $targetFile )){
            $data = json_decode(file_get_contents("logs/data.json"), true);
			$data['storage'] = check_storage();
			$data['total_uploads'] += 1;
            $data['new_upload_requests'] = (int)($data['total_uploads'] - ($data['accepted_requests'] + $data['rejected_requests']));

			file_put_contents("logs/data.json", json_encode($data,JSON_UNESCAPED_UNICODE));

            $conn->query("INSERT INTO `files` (file_name, file_type, userid, ip, file_size) VALUES('$fileName', '$fileType', '$user_id', '$ip', '$fileSize');");

            $conn->query("UPDATE users SET total_uploads=total_uploads+1 WHERE id=$user_id");
    	}
    	$conn->close();
    }
	else {
		echo "No file recieved";
        print_r($_SESSION);
	}
?>
