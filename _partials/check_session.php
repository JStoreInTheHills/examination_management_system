<?php

session_start();
// check to see if the session has been started and unset the active session.
if(isset($_SESSION['alogin']) || isset($_SESSION['role_id'])){
  unset($_SESSION['alogin']);
  unset($_SESSION['last_login_timestamp']);
  unset($_SESSION['role_id']);
  session_destroy(); // destroy session
}
