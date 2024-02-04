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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="js/main.js"></script>

    <link rel="icon"
          type="image/png"
          href="../img/logo.png">
</head>
<body style="background-color: #23272A;color:white" onload="loadGraphs()">
<div class="ring" id="ring"><img src="https://gamelogs.auroramc.net/img/logo.png" width=130px>
    <span class="dot"></span>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item">
                <a class="nav-link" href="/mission-control/">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Statistics</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
        <a class="mx-auto" href="/mission-control/">
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
        <div class="col-sm-1"></div> <!-- Gap at left side of form -->
        <div class="col-sm-10 col-xs-12">
            <div id="content" style="display: none;">
                <br>
                <h1><Strong><u>Daily Metrics</u></Strong></h1>
                <br>
                <br>
                <div class="container-flex">
                    <div class="row">
                        <div class="col-6">
                            <legend style="font-family: 'Helvetica';">Network Player Totals</legend>
                            <hr>
                            <div id="DAILY-NETWORK_PLAYER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Game Player Totals</legend>
                            <hr>
                            <div id="DAILY-GAME_PLAYER_TOTAL" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Games Started</legend>
                            <hr>
                            <div id="DAILY-GAMES_STARTED" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Unique Player Joins</legend>
                            <hr>
                            <div id="DAILY-UNIQUE_PLAYER_JOINS" style="max-height: 300px;max-width: 600px">
                            </div>
                        </div>
                        <div class="col-6">
                            <legend style="font-family: 'Helvetica';">Network Server Totals</legend>
                            <hr>
                            <div id="DAILY-NETWORK_SERVER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Network Proxy Totals</legend>
                            <hr>
                            <div id="DAILY-NETWORK_PROXY_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Avg. Players Per Game</legend>
                            <hr>
                            <div id="DAILY-PLAYERS_PER_GAME" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Unique Player Totals</legend>
                            <hr>
                            <div id="DAILY-UNIQUE_PLAYER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <h1><Strong><u>Weekly Metrics</u></Strong></h1>
                <br>
                <br>
                <div class="container-flex">
                    <div class="row">
                        <div class="col-6">
                            <legend style="font-family: 'Helvetica';">Network Player Totals</legend>
                            <hr>
                            <div id="WEEKLY-NETWORK_PLAYER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Game Player Totals</legend>
                            <hr>
                            <div id="WEEKLY-GAME_PLAYER_TOTAL" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Games Started</legend>
                            <hr>
                            <div id="WEEKLY-GAMES_STARTED" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Unique Player Joins</legend>
                            <hr>
                            <div id="WEEKLY-UNIQUE_PLAYER_JOINS" style="max-height: 300px;max-width: 600px">
                            </div>
                        </div>
                        <div class="col-6">
                            <legend style="font-family: 'Helvetica';">Network Server Totals</legend>
                            <hr>
                            <div id="WEEKLY-NETWORK_SERVER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Network Proxy Totals</legend>
                            <hr>
                            <div id="WEEKLY-NETWORK_PROXY_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Avg. Players Per Game</legend>
                            <hr>
                            <div id="WEEKLY-PLAYERS_PER_GAME" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Unique Player Totals</legend>
                            <hr>
                            <div id="WEEKLY-UNIQUE_PLAYER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <h1><Strong><u>All-Time Statistics</u></Strong></h1>
                <br>
                <br>
                <div class="container-flex">
                    <div class="row">
                        <div class="col-6">
                            <legend style="font-family: 'Helvetica';">Network Player Totals</legend>
                            <hr>
                            <div id="ALLTIME-NETWORK_PLAYER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Game Player Totals</legend>
                            <hr>
                            <div id="ALLTIME-GAME_PLAYER_TOTAL" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Games Started</legend>
                            <hr>
                            <div id="ALLTIME-GAMES_STARTED" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Unique Player Joins</legend>
                            <hr>
                            <div id="ALLTIME-UNIQUE_PLAYER_JOINS" style="max-height: 300px;max-width: 600px">
                            </div>
                        </div>
                        <div class="col-6">
                            <legend style="font-family: 'Helvetica';">Network Server Totals</legend>
                            <hr>
                            <div id="ALLTIME-NETWORK_SERVER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Network Proxy Totals</legend>
                            <hr>
                            <div id="ALLTIME-NETWORK_PROXY_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Avg. Players Per Game</legend>
                            <hr>
                            <div id="ALLTIME-PLAYERS_PER_GAME" style="max-height: 300px;max-width: 600px">
                            </div>
                            <br>
                            <br>
                            <legend style="font-family: 'Helvetica';">Unique Player Totals</legend>
                            <hr>
                            <div id="ALLTIME-UNIQUE_PLAYER_TOTALS" style="max-height: 300px;max-width: 600px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>