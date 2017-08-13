<?php
error_reporting(0);
require 'Database.php';
session_start();

if (isset($_GET['method']) and isset($_GET['user']) and isset($_GET['pass'])) {
    if (!empty($_GET['method']) and !empty($_GET['user']) and !empty($_GET['pass'])) {
        $loginUser = new Database('ltz');
        if ($loginUser->check_connection()) {
            $method = htmlentities($_GET['method']);
            $user = htmlentities($_GET['user']);
            $pass = htmlentities($_GET['pass']);
            switch ($method) {
                case 'Login':
                    $loginStat = $loginUser->login($user, $pass);
                    if ($loginStat[0]) {
                        echo '1,Welcome Aboard!,0';

                        $data = json_decode(file_get_contents("logs/data.json"), true);
                        $data['users_online'] += 1;

                        $fh = fopen("logs/data.json", 'w') or die("Error opening output file");
                        fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
                        fclose($fh);

                    } else {
                        switch($loginStat[1]){
                            case 100:
                                echo "0,You\'re blocked by admin!";
                                break;
                            case 101:
                                echo "0,Invalid Email or Password!";
                                break;
                            case 103:
                                echo "0,Please verify your email address!";
                                break;
                            default:
                                echo "0,Internal Error! Try after sometime!";
                        }
                    }
                    break;

                case 'Signup':
                    $signupStat = $loginUser->signup($user, $pass);
                    if ($signupStat[0]) {
                        echo "1,Signed up successfully! Please Check your mail.,1";
                    } else {
                        switch($signupStat[1]) {
                            case 102:
                                echo "0,User Exists!";
                                break;
                            default:
                                echo "0,Internal Error! Try after sometime!";
                        }
                    }
                    break;
                default:
                    echo "0,Wrong Selection! Contact admin for more info.";
            }
        } else echo "0,No Connection";
    } else echo "0,Required fields are empty!";
}

?>
