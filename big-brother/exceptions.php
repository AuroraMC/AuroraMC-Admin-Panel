<?php
/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

include_once "../database/db-connect.php";
include_once "../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV"  && $account_type != "DEV" && $account_type != "QA") {
    header("Location: ../login");
    return;
}

if (isset($_GET['uuid'])){
    $uuid = urldecode(filter_input(INPUT_GET, 'uuid', FILTER_SANITIZE_STRING));
} else {
    $uuid = null;
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home | Big Brother | The AuroraMC Network</title>

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

    <link rel="stylesheet" href="css/navbar.css">

    <script type="text/JavaScript" src="js/main.js"></script>

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
            margin-bottom: 0px;
        }
        .dataTables_wrapper {
            margin-left: auto;
            margin-right: auto;
            min-width: 100%;
        }
        /* width */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 7px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #00aaaa;
            border-radius: 7px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #33cccc;
        }
    </style>
</head>

<body style="background-color: #23272A;color:white" onload="onLoadExceptions(<?php echo (($uuid == null)?"false":"'" . $uuid . "'") ?>)">
<div class="ring" id="ring"><img src="https://gamelogs.auroramc.net/img/logo.png" width=130px>
    <span class="dot"></span>
</div>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item">
            <a class="nav-link" href="/big-brother/">Home</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
        <a class="mx-auto" href="/big-brother/">
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
                <a class="nav-link" href="/big-brother/exceptions">View Exceptions</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid" style="padding-top: 40px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <br>
            <div id="alerts-code"></div>
            <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="search">
                <i class="fas fa-search" aria-hidden="true"></i>
                <input class="form-control form-control-sm ml-3 w-75" type="text"
                       placeholder="Search by Exception UUID"
                       aria-label="Search" name="uuid" id="uuid" style="color: white;">
            </form>

            <?php if (isset($_GET['uuid'])) : ?>
                <div class="container" id="content" style="display: none;">
                    <div class="row"><h1 style="text-align: center;margin-right: auto;margin-left: auto"><span id="title"></span></h1></div>
                    <div class="row">
                        <div class="col-9" style="margin: auto;">
                            <pre id="trace" style="color: white;border: 2px solid #212121;border-radius: 5px;background-color: #212121; padding: 5px"></pre>
                        </div>
                        <div class="col-3">

                            <table class="table table-hover" style="color:white">
                                <thead>
                                <tr>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="table-values" style="color: white">
                                <tr><td><strong style="font-weight: bold">UUID:</strong> <span id="code"></span></td></tr>
                                <tr><td><strong style="font-weight: bold">Timestamp:</strong> <span id="timestamp"></span></td></tr>
                                <tr><td><strong style="font-weight: bold">Location:</strong> <span id="location"></span></td></tr>
                                <tr><td><strong style="font-weight: bold">Network:</strong> <span id="network"></span></td></tr>
                                <tr><td><strong style="font-weight: bold">Player:</strong> <span id="player"></span></td></tr>
                                <tr><td><strong style="font-weight: bold">Command Executed:</strong> <span id="command"></span></td></tr>
                                <tr><td><strong style="font-weight: bold">Attached Issue:</strong> <span id="issue"></span></td></tr>
                                <tr><td><strong style="font-weight: bold;">Server Data:</strong> <br><span id="server-data"></span></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="issue-modal"></div>
            <div style="display: flex;justify-content: center;align-items: center;">
                <div style="margin-left:auto;margin-right:auto;display: inline-block" id="buttons">
                </div>
            </div>
            <?php else: ?>
                <div class="container" style="display: none;" id="content">
                    <div class="row">
                        <h1 style="text-align: center;margin-right: auto;margin-left: auto">Unresolved Exceptions</h1>
                        <table class="table table-dark table-hover table-sm table-striped white-text"  cellspacing="0" style="color:white;" id="dtHistory">
                            <thead>
                            <tr>
                                <th class="th-sm">UUID</th>
                                <th class="th-sm">Timestamp</th>
                                <th class="th-sm">Exception</th>
                                <th class="th-sm">Location</th>
                                <th class="th-sm">Player</th>
                                <th class="th-sm">Command</th>
                                <th class="th-sm">View</th>
                            </tr>
                            </thead>
                            <tbody id="table-values" style="color: white">
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>
</body>
</html>