<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ltz';

    if(isset($_POST['what']) && isset($_POST['id'])) {

        $conf = $_POST['what'];
        $file_id = $_POST['id'];

        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        if($conn->connect_errno){
            echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
        }

        $data = json_decode(file_get_contents("../logs/data.json"), true);

        $sql = "";
        if($conf == 'accept') {
            $sql = "UPDATE files SET confirmed=1 WHERE id='$file_id'";
            $data['accepted_requests'] += 1;
        } else {
            $sql = "UPDATE files SET confirmed='-1' WHERE id='$file_id'";
            $data['rejected_requests'] += 1;
        }

        if($conn->query($sql)) {
            echo "1";
            $fh = fopen("../logs/data.json", 'w') or die("Error opening output file");
            fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
            fclose($fh);
        } else {
            echo "0";
        }

        $conn->close();
    }
?>
