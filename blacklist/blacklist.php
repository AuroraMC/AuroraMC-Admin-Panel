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
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC" && $account_type != "APPEALS" && $account_type != "QA") {
    header("Location: ../login");
    return;
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blacklist | Username Blacklist Panel | The AuroraMC Network</title>

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

    <!-- MDBootstrap Datatables  -->
    <link href="../css/addons/datatables.min.css" rel="stylesheet">
    <!-- MDBootstrap Datatables  -->
    <script type="text/javascript" src="../js/addons/datatables.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">


    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono">

    <link href="https://fonts.googleapis.com/css2?family=Poppins" rel="stylesheet">

    <link rel="stylesheet" href="css/navbar.css">
    <script type="text/JavaScript" src="js/main.js"></script>

    <script src="https://kit.fontawesome.com/a06911b3f6.js" crossorigin="anonymous"></script>

    <link rel="icon"
          type="image/png"
          href="../img/logo.png">

    <style>
        .table-hover tbody tr:hover {
            color: white;
        }

        .pagination .page-item .page-link {
            color: white;
        }

        .pagination .page-item .page-link:hover {
            background-color: #343a40;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
            bottom: .5em;
        }
        table.dataTable {
            margin-bottom: 0;
        }
    </style>

</head>
<body style="background-color: #23272A;color:white" onload="onLoadBlacklist()">
<div class="ring" id="ring"><img src="https://gamelogs.auroramc.net/img/logo.png" width=130px>
    <span class="dot"></span>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item">
                <a class="nav-link" href="/blacklist/">Home</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
        <a class="mx-auto" href="/blacklist/">
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
                <a class="nav-link" href="#">View</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid" style="padding-top: 40px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12 ">
            <br>
            <div id="alerts-user"></div>
            <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="usersearch">
                <i class="fas fa-plus" aria-hidden="true"></i>
                <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Add Username"
                       aria-label="Search" name="user" style="color: white;" id="user">
            </form>
            <div class="container" id="content" style="display: none">
                <div class="row">
                    <h1 style="text-align: center;margin-right: auto;margin-left: auto">Active Blacklists</h1>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-dark table-hover table-sm table-striped white-text" cellspacing="0" style="color:white;display: table;text-align: center" id="dtHistory" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">Name</th>
                                <th class="th-sm">Remove</th>
                            </tr>
                            </thead>
                            <tbody id="table-values" style="color: white">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>