<?php

/*
 * Error Codes
 * -1  : Unknown Error
 * 99  : Mysql Link Error
 * 100 : Blocked by admin
 * 101 : Invalid username/password
 * 102 : User Exists
 * */

error_reporting(0);
session_start();

class Database
{
    private $host = "localhost", $username = "root", $password = "";
    private $link, $database;

    public function __construct($database) {
        $this->database = $database;
        $this->link = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }

	public function __destruct() {
		mysqli_close($this->link);
	}

    public function check_connection() {
        return mysqli_connect_errno() ? false : true;
    }

    public function login($username, $password) {
        $res = mysqli_query($this->link, "SELECT * FROM `users` WHERE username='$username' AND password='$password';");
        if ($res) {
            if (mysqli_num_rows($res) == 1) {
                $user = mysqli_fetch_assoc($res);
                if ($user['allow_access'] == 0) return [false, 100];
                $user_id = $user['id'];
                $_SESSION['user_data'] = $user;
                $ip = $this->get_client_ip();
                mysqli_query($this->link, "UPDATE `users` SET no_of_login=no_of_login+1, is_logged_in=1, last_ip='$ip' WHERE id=$user_id;");
                return [true];
            } else return [false, 101];
        } else return [false, 99];
    }

    public function signup($username, $password) {
        $username = htmlentities($username);
        $password = htmlentities($password);

        if ($this->is_user($username)) return [false, 102];
        $ip = $this->get_client_ip();
        $sql = "INSERT INTO users(username,password,last_ip) VALUES('$username', '$password', '$ip');";
        if (mysqli_query($this->link, $sql)) {
            $data = json_decode(file_get_contents("logs/data.json"), true);
			$data['total_users'] += 1;

            $fh = fopen("logs/data.json", 'w') or die("Error opening output file");
            fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
            fclose($fh);
			return mysqli_insert_id($this->link) ? [true] : [false, -1];
        } else return [false, 99];
    }

    public function logout($userid) {
        mysqli_query($this->link, "UPDATE `users` SET is_logged_in=0 WHERE id=$userid;");
    }

    public function forgot_password($email)
    {
        $sql = "SELECT id FROM users WHERE email='$email';";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) == 1) {
            $userid = mysqli_fetch_row($res)[0];
            $token = md5(uniqid($userid, true));
            if (mysqli_query($this->link, "UPDATE `users` SET auth_token='$token' WHERE id=$userid;")) {
                require_once 'mail/mail.php';
                $msg = "Dear User,<br /><br /><strong>Please use this <a href='http://creativesoul.com/activate.php?meth=rp&ui=$userid&ato=$token'>link</a> to reset your password. Alternately, you can copy & paste the link below in your browser:<br /> http://creativesoul.com/activate.php?ui=$userid&authto=$token<br />Feel free to contact us anytime. <br /><strong>Best,</strong><br /> Creative Soul Team<br />Note: This is a system generated e-mail, please do not reply to it.<br /><br />*** This message is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged information. If you have received this message in error, please notify the sender immediately and delete this message from your system ***";
                if (send_mail("activation", $email, "Recover Password", $msg)) return [true];
                else return [false, "Server Error, Please try after sometime"];
            } else return [false, "Database Error, Please try after sometime"];
        }
    }

    public function update_record($userid, $filename) {
        if( $this->is_user("",$userid) ){
            $ip = $this->get_client_ip();
            mysqli_query($this->link, "INSERT INTO `uploads`(userid, filename, ip) VALUES($userid, '$filename', '$ip');");
        } else return [false, 101];
    }

    public function logged_in() {
        return (isset($_SESSION['user_data']['id']) and !empty($_SESSION['user_data']['id'])) ? true : false;
    }

    public function is_user($email, $userid="") {
        return !empty($email) ? mysqli_num_rows(mysqli_query($this->link, "SELECT id FROM `users` WHERE username='$email';")) : mysqli_num_rows(mysqli_query($this->link, "SELECT id FROM `users` WHERE id='$userid';"));
    }

    public function get_client_ip() {
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

    public function updateProfile($fname, $lname)
    {
        ini_set('file_uploads','On');
        $fname = empty($fname) ? "New" : htmlentities($fname);
        $lname = empty($lname) ? "User" : htmlentities($lname);
        $id = $_SESSION['user_data']['id'];
        $sql = "UPDATE `users` SET first_name='$fname',last_name='$lname' WHERE id=$id;";
          mysqli_query($this->link, $sql);
        return mysqli_errno($this->link) ? false : true;
    }

    public function changePassword($curr, $new){
        $id = $_SESSION['user_data']['id'];
        $res = mysqli_query($this->link, "SELECT password FROM `users` WHERE id=$id");
        if( $res ){
            if( mysqli_num_rows($res) == 1 ){
                $pass = mysqli_fetch_assoc($res);
                if($pass['password']==$curr){
                    mysqli_query($this->link, "UPDATE `users` SET password='$new' WHERE id=$id;");
                    return mysqli_errno($this->link) ? false : true;
                }
            }
        }
    }

	public function runQuery($q) {
		mysqli_query( $this->link, $q );
		return mysqli_error_no($this->link) ? false : true;
	}

    public function searchKeyword($keywords){
    	$k = explode(" ", $keywords);
    	$searchStr = "";
    	foreach($k as $i) $searchStr .= $i."%";

            $sql = "SELECT id,file_name,file_type,uploaded,link FROM `files` WHERE file_name LIKE '$searchStr' AND confirmed = 1 ORDER BY uploaded DESC;";
            $res = mysqli_query($this->link, $sql);
            if( $res ){
                $a = [];
                while( $row = mysqli_fetch_assoc($res) ){
                    $a[] = $row;
                }
                return $a;
            }
        }
    }
?>
