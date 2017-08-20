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

	        file_put_contents("logs/data.json", json_encode($data,JSON_UNESCAPED_UNICODE));
	    }
	}
	header('Location: index.php');
?>
