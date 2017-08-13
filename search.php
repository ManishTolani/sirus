<?php
    session_start();
    if( isset($_SESSION['user_data']['id']) and !empty($_SESSION['user_data']['id']) ){
        if( isset($_GET['keyword']) and !empty($_GET['keyword']) ) {
            require 'Database.php';
            $searchObject = new Database('ltz');
            $result = $searchObject->searchKeyword($_GET['keyword']);
            echo json_encode($result);
        }
    } else header("Location: index.php");
?>
