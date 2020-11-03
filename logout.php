<?php

session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 60*60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
unset($_SESSION['alogin']);
unset($_SESSION['last_login_timestamp']);
unset($_SESSION['role_id']);
session_destroy(); // destroy session

header("location:login");
?>
