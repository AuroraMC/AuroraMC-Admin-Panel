<?php
/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

include_once '../database/db-connect.php';
include_once "../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC") {
    header("Location: ../../login");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chat Rules | Rules Committee Panel | The AuroraMC Network</title>

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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="js/rules.js"></script>
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
                <a class="nav-link" href="#">Chat Rules</a>
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
            <li class="nav-item">
                <a class="nav-link" href="misc">Misc Rules</a>
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
            <br>
            <h1><Strong>AuroraMC Network Rules Committee Admin Panel</Strong></h1>
            <br>
            <legend style="font-family: 'Helvetica';">Currently Active Chat Rules</legend>
            <br>
            <table class="table table-hover" style="color:white">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Weight</th>
                    <th>Requires Warning</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="table-values">
                <?php
                include_once "../database/db-connect.php";
                $weights = array("<Strong style='color:#00AA00;font-weight: bold'>Light</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Medium</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Heavy</Strong>", "<Strong style='font-weight: bold;color:#FFAA00'>Severe</Strong>", "<Strong style='font-weight: bold;color:#AA0000'>Extreme</Strong>");
                $requires_warnings = array("<Strong style='font-weight: bold'>No</Strong>","<Strong style='font-weight: bold'>Yes</Strong>");

                if ($sql = $mysqli->prepare("SELECT * FROM rules WHERE type = 1 AND active = 1 ORDER BY weight ASC, rule_id ASC")) {
                    $sql->execute();    // Execute the prepared query.

                    $id = null;
                    $name = null;
                    $description = null;
                    $weight = null;
                    $type = null;
                    $requires_warning = null;
                    $active = null;

                    $sql->bind_result($id,$name, $description, $weight, $requires_warning, $type, $active);
                    while ($sql->fetch()) {
                        if ($active = 1) {
                            echo "<tr id='", $id, "' style='color:white'><td id='", $id, "-id'>", $id, "</td><td id='", $id, "-name'>", $name, "</td><td id='", $id,"-description'>", $description, "</td><td id='", $id,"-weight'>", $weights[$weight - 1], "</td><td id='", $id,"-warning'>", $requires_warnings[$requires_warning], "</td><td><button type='button' class='btn btn-secondary' id='", $id,"-edit-name' onclick='startNameEdit(", $id,")'><i class='fas fa-pencil-alt'></i> Edit Name</button><button type='button' class='btn btn-secondary' id='", $id,"-edit-desc' onclick='startDescEdit(", $id,")'><i class='fas fa-pencil-alt'></i> Edit Description</button><button type='button' class='btn btn-secondary' id='", $id,"-toggle-warning' onclick='toggleWarning(", $id,")'><i class='fas fa-pencil-alt'></i> Toggle Warning</button><button type='button' class='btn btn-danger' id='", $id, "-archive' onclick='archive(", $id, ")'><i class='fas fa-trash-alt'></i> Archive</button></td></tr>";
                        }
                    }

                } else {
                    echo "ERROR";
                }

                ?>
                </tbody>
            </table>

            <button type="button" class="btn btn-success" onclick="newrule(1)" style="margin-left:50%;margin-right:50%;"><i class="fas fa-plus"></i> Create Rule</button>
            <br>
            <br>
            <br>
            <br>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>
</body>
</html>