<?php
include_once '../database/db-connect.php';
include_once 'functions.php';

sec_session_start(); // My custom secure way of starting a PHP session.

if (isset($_POST['username'], $_POST['p'])) {
    $email = $_POST['username'];
    $password = $_POST['p']; // The hashed password.

    if (login($email, $password, $mysqli) == true) {
        // Login success
        header('Location: ../');
    } else {
        // Login failed
        header('Location: ../login.php');
    }
} else {
    // The correct POST variables were not sent to this page.
    header('Location: ../login.php');
}
