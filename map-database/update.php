<?php
/*
 * Copyright (c) 2021-2024 Ethan P-B. All Rights Reserved.
 */

include_once "../database/db-connect.php";
include_once "../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV") {
    header("Location: ../login");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Push Update | Map Database | The AuroraMC Network</title>

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

    <!-- MDBootstrap Datatables  -->
    <link href="../css/addons/datatables.min.css" rel="stylesheet">
    <!-- MDBootstrap Datatables  -->
    <script type="text/javascript" src="../js/addons/datatables.min.js"></script>

    <link rel="stylesheet" href="css/navbar.css">
    <script src="js/main.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script src="https://kit.fontawesome.com/a06911b3f6.js" crossorigin="anonymous"></script>

    <link rel="icon"
          type="image/png"
          href="../img/logo.png">
</head>

<body style="background-color: #23272A;color:white" onload="onLoadUpdate()">
<div class="ring" id="ring"><img src="https://gamelogs.auroramc.net/img/logo.png" width=130px>
    <span class="dot"></span>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item">
                <a class="nav-link" href="/map-database/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="parsed">Parsed Maps</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
        <a class="mx-auto" href="/map-database/">
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
                <a class="nav-link" href="live">Live Maps</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Push Update</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid" style="padding-top: 40px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <br>
            <h1><Strong>AuroraMC Network Map Database</Strong></h1>
            <br>
            <br>
            <div class="container" id="content" style="display: none;">
                <div class="row">
                    <h1 style="text-align: center;margin-right: auto;margin-left: auto">Pending Update</h1>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-dark table-hover table-sm table-striped white-text"  cellspacing="0" style="color:white" id="dtParsed" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">ID</th>
                                <th class="th-sm">Name</th>
                                <th class="th-sm">Author</th>
                                <th class="th-sm">Game Type</th>
                                <th class="th-sm">World Name</th>
                                <th class="th-sm">Change Type</th>
                                <th class="th-sm">Remove</th>
                            </tr>
                            </thead>
                            <tbody id="table-values" style="color: white">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-success" onclick="pushUpdate()" style="margin-left:50%;margin-right:50%;"><i class="fas fa-upload"></i> Push Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>
</body>
</html>