<?php
/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

include_once "../database/db-connect.php";
include_once "../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV" && $account_type != "RC" && $account_type != "QA") {
    header("Location: ../../login");
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home | Chat Filter Panel | The AuroraMC Network</title>

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
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

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
                <a class="nav-link" href="phrases">Phrases</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="replacements">Toxic Replacements</a>
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
                <a class="nav-link" href="core">Core Words</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="whitelist">Whitelist</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blacklist">Blacklist</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid" style="padding-top: 40px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <br>
            <h1><Strong>AuroraMC Network Chat Filter Admin Panel</Strong></h1>
            <br>
            <legend style="font-family: 'Helvetica';">Welcome!</legend>
            <hr>
            <p style="font-size: 17px; font-family: 'Helvetica'">Welcome to the AuroraMC Network's Chat Filter Admin Panel! Here, you can see and manage core words, toxic replacements, whitelisted and blacklisted words, and banned phrases.</p>
            <br>
            <legend style="font-family: 'Helvetica';">Filter Statistics</legend>
            <hr>
            <p><strong style="font-weight: bold">Number of core words:</strong> <?php
                echo count($redis->sMembers("filter.core"));
                ?></p>
            <p><strong style="font-weight: bold">Number of blacklisted words:</strong> <?php
                echo count($redis->sMembers("filter.blacklist"));
                ?></p>
            <p><strong style="font-weight: bold">Number of whitelisted words:</strong> <?php
                echo count($redis->sMembers("filter.whitelist"));
                ?></p>
            <p><strong style="font-weight: bold">Number of banned phrases:</strong> <?php
                echo count($redis->sMembers("filter.phrases"));
                ?></p>
            <p><strong style="font-weight: bold">Number of toxic replacements:</strong> <?php
                echo count($redis->sMembers("filter.replacements"));
                ?></p>
            <br>
            <br>
            <button type='button' class='btn btn-secondary' onclick='updateRules()'><i class='fas fa-pencil-alt'></i> Push Filter Update</button>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>
</body>
</html>