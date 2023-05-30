<?php
/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

include_once '../database/db-connect.php';
include_once "../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC" && $account_type != "APPEALS" && $account_type != "STAFF" && $account_type != "QA") {
    header("Location: ../../login");
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Punishments Database | The AuroraMC Network</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/navbar.css">

    <link rel="icon"
          type="image/png"
          href="../img/logo.png">
</head>
<body style="background-color: #23272A;color:white">
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="search">Search</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
        <a class="mx-auto" href="/">
            <img src="../img/logo.png" height="100px" width="100px"
                 style="margin-top:60px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-2 order-md-2">
        <ul class="navbar-nav mr-auto text-center">
            <li class="nav-item">
                <a class="nav-link" href="notes">Admin Notes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="approval">Approval System</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid" style="padding-top: 40px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <br>
            <h1><Strong>AuroraMC Network Punishment Database</Strong></h1>
            <br>
            <legend style="font-family: 'Helvetica';">Welcome!</legend>
            <hr>
            <p style="font-size: 17px; font-family: 'Helvetica'">Welcome to the AuroraMC Network's Punishment Database! Here, you can see all metrics, view active and expired punishments, and use the Approval System!</p>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <legend style="font-family: 'Helvetica';">All-Time Punishment Statistics</legend>
                        <hr>
                        <?php
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Total Punishments Issued:</strong> ', $punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 2")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $unprocessed_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Unprocessed Pending Punishments:</strong> ', $unprocessed_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 4")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $sm_denied_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Total Punishments SM Denied:</strong> ', $sm_denied_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 3 OR status = 6")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $sm_approved_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Total Punishments SM Approved:</strong> ', $sm_approved_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 1")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $forum_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Total Forum Report Punishments:</strong> ', $forum_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 2")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $honk_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Total HONK Punishments:</strong> ', $honk_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        ?>
                    </div>
                    <div class="col-4">
                        <legend style="font-family: 'Helvetica';">30 Day Punishment Statistics</legend>
                        <hr>
                        <?php
                        $timestamp = round(microtime(true) * 1000) - 2592000000;

                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Monthly Punishments Issued:</strong> ', $punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 4 AND  CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $sm_denied_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Monthly Punishments SM Denied:</strong> ', $sm_denied_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 3 OR status = 6 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $sm_approved_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Monthly Punishments SM Approved:</strong> ', $sm_approved_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 1 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $forum_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Monthly Forum Report Punishments:</strong> ', $forum_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 2 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $honk_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Monthly HONK Punishments:</strong> ', $honk_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        ?>
                    </div>
                    <div class="col-4">
                        <legend style="font-family: 'Helvetica';">24 Hour Punishment Statistics</legend>
                        <hr>
                        <?php
                        $timestamp = round(microtime(true) * 1000) - 86400000;

                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Daily Punishments Issued:</strong> ', $punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 4 AND  CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $sm_denied_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Daily Punishments SM Denied:</strong> ', $sm_denied_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 3 OR status = 6 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $sm_approved_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Daily Punishments SM Approved:</strong> ', $sm_approved_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 1 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $forum_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Daily Forum Report Punishments:</strong> ', $forum_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 2 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
                            $sql->bind_param('i', $timestamp);
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $honk_punishments = $results[0];
                            echo '<p><strong style="font-weight: bold">Daily HONK Punishments:</strong> ', $honk_punishments,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>