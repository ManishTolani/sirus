<?php

error_reporting(0);
session_start();

if (isset($_SESSION['user_data']['id']) and !empty($_SESSION['user_data']['id'])) {
    require_once 'Database.php';
    $user_id = $_SESSION['user_data']['id'];
    $logoutUser = new Database('ltz');

    if ($logoutUser->check_connection()) {
        $logoutUser->logout($user_id);
        $_SESSION['user_data'] = False;

        session_destroy();

        $data = json_decode(file_get_contents("logs/data.json"), true);
        $data['users_online'] = $data['users_online'] - 1;

        $fh = fopen("logs/data.json", 'w') or die("Error opening output file");
        fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
        fclose($fh);
    }
}
header('Location: index.php');
?>
