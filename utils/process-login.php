<?php
include_once '../database/db-connect.php';
include_once 'functions.php';

sec_session_start(); // My custom secure way of starting a PHP session.

if (isset($_POST['username'], $_POST['p'], $_POST['code'])) {
    $email = $_POST['username'];
    $password = $_POST['p']; // The hashed password.
    $code = $_POST['code'];

    if (login($email, $password, $code, $mysqli, $redis) == true) {
        // Login success
        header('Location: ../');
    } else {
        // Login failed
        header('Location: ../login');
    }
} else {
    // The correct POST variables were not sent to this page.
    header('Location: ../login');
}
