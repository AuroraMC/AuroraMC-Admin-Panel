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

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV") {
    header("Location: ../../login");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home | Map Database | The AuroraMC Network</title>

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

    <script>
        // Basic example
        $(document).ready(function () {
            $('#dtParsed').DataTable({
                "pagingType": "full_numbers", // "simple" option for 'Previous' and 'Next' buttons only
                "autoWidth": true,
                "scrollY": "498px",
                "scrollCollapse": true,
                "ordering": false
            });
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
</head>

<body style="background-color: #23272A;color:white">
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
            <div class="container">
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
                            <?php
                            $additions = $redis->sMembers("map.additions");
                            $removals = $redis->sMembers("map.removals");

                            foreach ($additions as $addition) {
                                if ($sql = $mysqli->prepare("SELECT * FROM maps WHERE map_id = ? AND parse_version = 'TEST'")) {
                                    $sql->bind_param('s', $addition);
                                    $sql->execute();    // Execute the prepared query.
                                    $result2 = $sql->get_result();
                                    $numRows = $result2->num_rows;
                                    $results = $result2->fetch_all(MYSQLI_ASSOC);
                                    $result2->free_result();
                                    $sql->free_result();

                                    foreach ($results as $result) {
                                        if ($sql2 = $mysqli->prepare("SELECT world_name, gametype FROM build_server_maps WHERE id = ?")) {
                                            $sql2->bind_param('s', $result['map_id']);
                                            $sql2->execute();    // Execute the prepared query.

                                            $world_name = null;
                                            $game_type = null;

                                            $sql2->bind_result($world_name, $game_type);
                                            $sql2->fetch();
                                            $sql2->store_result();
                                            $sql2->free_result();

                                            echo '
                                                   <tr id="map-', $result['map_id'],'">
                                                    <td>', $result['map_id'], '</td>
                                                    <td>', $result['map_name'],'</td>
                                                    <td>', $result['map_author'], '</td>
                                                    <td>', $game_type, '</td>
                                                    <td>', $world_name, '</td>
                                                    <td><strong style="color:#00AA00;font-weight: bold">Addition</strong></td>
                                                    <td><button type="button" class="btn btn-danger" onclick=\'removeNewMap(', $result['map_id'], ')\'><i class="fas fa-trash-alt"></i> Remove From Update</button></td></tr>';
                                        } else {
                                            echo "There has been an error connecting to the database. Please try again. 2";
                                        }
                                    }
                                } else {
                                    echo "failed";
                                }
                            }
                            foreach ($removals as $addition) {
                                if ($sql = $mysqli->prepare("SELECT * FROM maps WHERE map_id = ? AND parse_version = 'LIVE'")) {
                                    $sql->bind_param('s', $addition);
                                    $sql->execute();    // Execute the prepared query.
                                    $result2 = $sql->get_result();
                                    $numRows = $result2->num_rows;
                                    $results = $result2->fetch_all(MYSQLI_ASSOC);
                                    $result2->free_result();
                                    $sql->free_result();


                                    foreach ($results as $result) {
                                        if ($sql2 = $mysqli->prepare("SELECT world_name, gametype FROM build_server_maps WHERE id = ?")) {
                                            $sql2->bind_param('i', $result['map_id']);
                                            $sql2->execute();    // Execute the prepared query.

                                            $world_name = null;
                                            $game_type = null;

                                            $sql2->bind_result($world_name, $game_type);
                                            $sql2->fetch();
                                            $sql2->store_result();
                                            $sql2->free_result();

                                            echo '
                                                   <tr id="map-', $result['map_id'],'">
                                                    <td>', $result['map_id'], '</td>
                                                    <td>', $result['map_name'],'</td>
                                                    <td>', $result['map_author'], '</td>
                                                    <td>', $game_type, '</td>
                                                    <td>', $world_name, '</td>
                                                    <td><strong style="color:#AA0000;font-weight: bold">Removal</strong></td>
                                                    <td><button type="button" class="btn btn-danger" onclick=\'addOldMap(', $result['map_id'], ')\'><i class="fas fa-trash-alt"></i> Remove From Update</button></td></tr>';
                                        } else {
                                            echo "There has been an error connecting to the database. Please try again. 2";
                                        }
                                    }
                                } else {
                                    echo "failed";
                                }
                            }
                            ?>
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