<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $data = json_decode(file_get_contents("../logs/data.json"), true);
        echo json_encode($data);
    }
?>
