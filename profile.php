<?php
ini_set('display_errors', 'off');
session_start();

if( isset($_SESSION['user_data']['id']) and !empty($_SESSION['user_data']['id']) ) {
    require 'Database.php';

    // Profile
    if (isset($_GET['type']) and $_GET['type'] == 'profile') {
        if (isset($_GET['fname']) and isset($_GET['lname']) and !empty($_GET['fname']) and !empty($_GET['lname'])) {
            $profileObject = new Database('ltz');
            if ($profileObject->updateProfile($_GET['fname'], $_GET['lname'])) {
                $_SESSION['user_data']['first_name'] = $_GET['fname'];
                $_SESSION['user_data']['last_name'] = $_GET['lname'];
                echo "1";
            } else echo "0";
        }
    }

    // Password
    else if (isset($_GET['type']) and $_GET['type'] == 'password') {
        if (isset($_GET['curr']) and isset($_GET['new']) and isset($_GET['cnf'])) {
            if (!empty($_GET['curr']) and !empty($_GET['new']) and !empty($_GET['cnf'])) {
                $curr = htmlentities($_GET['curr']);
                $new = htmlentities($_GET['new']);
                $cnf = htmlentities($_GET['cnf']);
                if ($new == $cnf) {
                    $passwordObject = new Database('ltz');
                    if ($passwordObject->changePassword($_GET['curr'], $_GET['new'])) {
                        echo "1";
                    } else echo "0";
                }
            }
        }
    }
}
?>