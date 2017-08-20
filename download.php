<?php
    session_start();

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

    if(isset($_GET['file']) && isset($_GET['file_type']) && isset($_GET['file_id'])) {

        $file = $_GET['file'];
        $file_type = $_GET['file_type'];
        $file_id = $_GET['file_id'];
        $user_id = $_SESSION['user_data']['id'];
        $ip = getip();

        $dbHost = 'localhost';
    	$dbUsername = 'root';
    	$dbPassword = '';
    	$dbName = 'ltz';
    	//connect with the database
    	$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    	if($conn->connect_errno){
    		echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    	}

        $local_file = '/opt/lampp/htdocs/ltz/uploads/'. $_GET['file_type'] . '/' . $_GET['file'];
        $download_file = $_GET['file'];

        ignore_user_abort(true);
        set_time_limit(0);

        $download_rate = 250;

        if(file_exists($local_file) && is_file($local_file)) {
            header('Cache-control: private');
            header('Content-Type: application/octet-stream');
            header('Content-Length: '.filesize($local_file));
            header('Content-Disposition: filename='.$download_file);

            flush();
            $file = fopen($local_file, "r");

            while(!feof($file)) {

                print fread($file, round($download_rate * 1024));
                flush();
                sleep(1);
            }
            fclose($file);

            $conn->query("INSERT INTO `downloads` (fileid, userid, userip) VALUES ('$file_id', '$user_id', '$ip');");

            $data = json_decode(file_get_contents("logs/data.json"), true);
            $data['total_downloads'] += 1;

            $fh = fopen("logs/data.json", 'w') or die("Error opening output file");
            fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
            fclose($fh);
        }
        else {
            die('Error: The file '.$local_file.' does not exist!');
        }
    } else {
        header('HTTP/1.0 403 Forbidden');
        echo 'You don\'t have sufficient permissions to download this file.. Please contact the administrator!';
    }
?>
