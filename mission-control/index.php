<?php
/*
 * Copyright (c) 2021-2024 Ethan P-B. All Rights Reserved.
 */

include_once '../database/db-connect.php';
include_once "../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV") {
    header("Location: ../login");
    return;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mission Control | The AuroraMC Network</title>

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
    <link rel="stylesheet" href="css/main.css">

    <script type="text/javascript" src="js/main.js"></script>

    <link rel="icon"
          type="image/png"
          href="../img/logo.png">
</head>
<body style="background-color: #23272A;color:white" onload="onLoad()">
<div class="ring" id="ring"><img src="https://gamelogs.auroramc.net/img/logo.png" width=130px>
    <span class="dot"></span>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stats">Statistics</a>
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
                <a class="nav-link" href="server-manager">Server Manager</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="maintenance">Network Maintenance</a>
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
                <h1><Strong>AuroraMC Network Mission Control</Strong></h1>
                <br>
                <legend style="font-family: 'Helvetica';">Welcome!</legend>
                <hr>
                <p style="font-size: 17px; font-family: 'Helvetica'">Welcome to AuroraMC Network's Misson Control! Here, you can see all network metrics, create and destroy servers, and conduct network maintenance!</p>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <legend style="font-family: 'Helvetica';">Main Network Stats</legend>
                            <hr>
                            <p><strong style="font-weight: bold">Servers Online:</strong> <span id="servers-main"></span></p>
                            <p><strong style="font-weight: bold">Proxies Online:</strong> <span id="proxies-main"></span></p>
                            <p><strong style="font-weight: bold">Total Players Online:</strong> <span id="players-main"></span></p>
                        </div>
                        <div class="col-4">
                            <legend style="font-family: 'Helvetica';">Alpha Network Statistics</legend>
                            <hr>
                            <p><strong style="font-weight: bold">Servers Online:</strong> <span id="servers-alpha"></span></p>
                            <p><strong style="font-weight: bold">Proxies Online:</strong> <span id="proxies-alpha"></span></p>
                            <p><strong style="font-weight: bold">Total Players Online:</strong> <span id="players-alpha"></span></p>
                        </div>
                        <div class="col-4">
                            <legend style="font-family: 'Helvetica';">Test Network Statistics</legend>
                            <hr>
                            <p><strong style="font-weight: bold">Servers Online:</strong> <span id="servers-test"></span></p>
                            <p><strong style="font-weight: bold">Proxies Online:</strong> <span id="proxies-test"></span></p>
                            <p><strong style="font-weight: bold">Total Players Online:</strong> <span id="players-test"></span></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <legend style="font-family: 'Helvetica';">Current Live Build Numbers</legend>
                            <hr>
                            <p><strong style="font-weight: bold">AuroraMC-Core:</strong> <span id="core"></span></p>
                            <p><strong style="font-weight: bold">AuroraMC-Lobby:</strong> <span id="lobby"></span></p>
                            <p><strong style="font-weight: bold">AuroraMC-Game-Engine:</strong> <span id="engine"></span></p>
                            <p><strong style="font-weight: bold">AuroraMC-Games:</strong> <span id="game"></span></p>
                            <p><strong style="font-weight: bold">AuroraMC-Build:</strong> <span id="build"></span></p>
                            <p><strong style="font-weight: bold">AuroraMC-Duels:</strong> <span id="duels"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>