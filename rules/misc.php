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
    header("Location: ../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC") {
    header("Location: ../login");
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Misc Rules | Rules Committee Panel | The AuroraMC Network</title>

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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <script src="js/rules.js"></script>
    <link rel="stylesheet" href="css/navbar.css">

    <link rel="icon"
          type="image/png"
          href="../img/logo.png">
</head>

<body style="background-color: #23272A;color:white" onload="loadRules(3)">
<div class="ring" id="ring"><img src="https://gamelogs.auroramc.net/img/logo.png" width=130px>
    <span class="dot"></span>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item">
                <a class="nav-link" href="chat">Chat Rules</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="game">Game Rules</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
        <a class="mx-auto" href="/rules/">
            <img src="../img/logo.png" height="100px" width="100px"
                 style="margin-top:60px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-2 order-md-2">
        <ul class="navbar-nav mr-auto text-center">
            <li class="nav-item active">
                <a class="nav-link" href="#">Misc Rules</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archive">Archived Rules</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid" style="padding-top: 40px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <div id="content" style="display: none">
                <br>
                <h1><Strong>AuroraMC Network Rules Committee Admin Panel</Strong></h1>
                <br>
                <legend style="font-family: 'Helvetica';">Currently Active Misc Rules</legend>
                <br>
            </div>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
    <div>
        <div class="row">
            <div class="col-sm-1"></div> <!-- Gap at left side of form -->
            <div class="col-sm-10 col-xs-12">
                <div id="content2" style="display: none">
                    <table class="table table-dark table-striped white-text"  cellspacing="0" style="color:white" id="dtHistory" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="th-sm">Weight</th>
                            <th class="th-sm">Requires Warning</th>
                            <th style="min-width: 27rem">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="table-values">
                        </tbody>
                    </table>

                    <button type="button" class="btn btn-success" onclick="newrule(3)" style="margin-left:50%;margin-right:50%;"><i class="fas fa-plus"></i> Create Rule</button>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
            <div class="col-sm-1"></div> <!-- Gap at right side of form -->
        </div>
    </div>
</div>
</body>
</html>