<?php
include_once 'operations.php';
sec_session_start();
 
$_SESSION = array();
 
$params = session_get_cookie_params();
 
//Delete stored cookies
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
//End session
session_destroy();
header('Location: ../index.php');