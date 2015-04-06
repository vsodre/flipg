<?php
include_once 'database.php';
include_once 'operations.php';
 
sec_session_start();
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // Secured password
 
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: ../protected_page.php');
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    //error
    echo 'Invalid Request';
}