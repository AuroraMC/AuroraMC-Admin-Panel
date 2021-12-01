<?php
/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

function username_to_uuid($username) {
    $profile = username_to_profile($username);
    if (is_array($profile) and isset($profile['id'])) {
        return $profile['id'];
    }
    return false;
}


/**
 * Get Profile (Username and UUID) from username
 *
 * @uses http://wiki.vg/Mojang_API#Username_-.3E_UUID_at_time
 *
 * @param  string      $username
 * @return array|bool  Array with id and name, false on failure
 */
function username_to_profile($username) {
    if (is_valid_username($username)) {
        $json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $username);
        if (!empty($json)) {
            $data = json_decode($json, true);
            if (is_array($data) and !empty($data)) {
                return $data;
            }
        }
    }
    return false;
}


/**
 * Get username from UUID
 *
 * @uses http://wiki.vg/Mojang_API#UUID_-.3E_Name_history
 *
 * @param  string       $uuid
 * @return string|bool  Username on success, false on failure
 */
function uuid_to_username($uuid) {
    $uuid = minify_uuid($uuid);
    if (is_string($uuid)) {
        $json = file_get_contents('https://api.mojang.com/user/profiles/' . $uuid . '/names');
        if (!empty($json)) {
            $data = json_decode($json, true);
            if (!empty($data) and is_array($data)) {
                $last = array_pop($data);
                if (is_array($last) and isset($last['name'])) {
                    return $last['name'];
                }
            }
        }
    }
    return false;
}


/**
 * Check if string is a valid Minecraft username
 *
 * @param  string $string to check
 * @return bool   Whether username is valid or not
 */
function is_valid_username($string) {
    return is_string($string) and strlen($string) >= 2 and strlen($string) <= 16 and ctype_alnum(str_replace('_', '', $string));
}


/**
 * Remove dashes from UUID
 *
 * @param  string       $uuid
 * @return string|bool  UUID without dashes (32 chars), false on failure
 */
function minify_uuid($uuid) {
    if (is_string($uuid)) {
        $minified = str_replace('-', '', $uuid);
        if (strlen($minified) === 32) {
            return $minified;
        }
    }
    return false;
}


/**
 * Add dashes to an UUID
 *
 * @param  string       $uuid
 * @return string|bool  UUID with dashes (36 chars), false on failure
 */
function format_uuid($uuid) {
    $uuid = minify_uuid($uuid);
    if (is_string($uuid)) {
        return substr($uuid, 0, 8) . '-' . substr($uuid, 8, 4) . '-' . substr($uuid, 12, 4) . '-' . substr($uuid, 16, 4) . '-' . substr($uuid, 20, 12);
    }
    return false;
}

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
    <title>Search | Punishments Database | The AuroraMC Network</title>

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
    <script type="text/JavaScript" src="js/forms.js"></script>

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
            margin-bottom: 0px;
        }
    </style>

    <script>
        // Basic example
        $(document).ready(function () {
            $('#dtHistory').DataTable({
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
                <a class="nav-link" href="/punishments/">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="search">Search</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
        <a class="mx-auto" href="/punishments/">
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
        <div class="col-sm-8 col-xs-12 ">
            <?php
            $weights = array("<Strong style='color:#00AA00;font-weight: bold'>Light</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Medium</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Heavy</Strong>", "<Strong style='font-weight: bold;color:#FFAA00'>Severe</Strong>", "<Strong style='font-weight: bold;color:#AA0000'>Extreme</Strong>");
            $types = array("<Strong style='color:#00AA00;font-weight: bold'>Chat</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Game</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Misc</Strong>");
            if (isset($_GET['code'])) : ?>
                <br>
                <div id="alerts-code"></div>
                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="codesearch">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-75" type="text"
                           placeholder="Search by Punishment Code"
                           aria-label="Search" name="code" id="code" style="color: white;">
                </form>
                <?php
                include_once "../database/db-connect.php";
                $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
                if ($sql = $mysqli->prepare("SELECT punishments.punishment_id,punishments.amc_id,punishments.rule_id,punishments.notes,punishments.punisher,punishments.issued,punishments.expire,punishments.status,punishments.evidence,punishments.suffix,punishments.removal_reason,punishments.remover,punishments.removal_timestamp,auroramc_players.name,auroramc_players.uuid,punishments.evidence FROM punishments INNER JOIN auroramc_players ON auroramc_players.id=punishments.amc_id WHERE (punishment_id = ?) ORDER BY issued DESC")) {
                    $sql->bind_param('s', $code);
                    $sql->execute();    // Execute the prepared query.

                    $punishment_code = null;
                    $amc_id = null;
                    $rule_id = null;
                    $notes = null;
                    $punisher = null;
                    $issued = null;
                    $expire = null;
                    $status = null;
                    $evidence = null;
                    $suffix = null;
                    $removal_reason = null;
                    $remover = null;
                    $removal_timestamp = null;
                    $name = null;
                    $uuid = null;
                    $evidence = null;

                    $sql->bind_result($punishment_code, $amc_id, $rule_id, $notes, $punisher, $issued, $expire, $status, $evidence, $suffix, $removal_reason, $remover, $removal_timestamp, $name, $uuid, $evidence);
                    if ($sql->fetch()) {
                        $sql->store_result();
                        $sql->free_result();
                        if ($sql2 = $mysqli->prepare("SELECT * FROM rules WHERE rule_id = ?")) {
                            $sql2->bind_param('i', $rule_id);
                            $sql2->execute();    // Execute the prepared query.

                            $rule_name = null;
                            $description = null;
                            $weight = null;
                            $rule_type = null;
                            $requires_warning = null;
                            $active = null;

                            $sql2->bind_result($rule_id, $rule_name, $description, $weight, $requires_warning, $type, $active);
                            $sql2->fetch();
                            $sql2->store_result();
                            $sql2->free_result();
                            if ($sql3 = $mysqli->prepare("SELECT name,uuid FROM auroramc_players WHERE id = ?")) {
                                $sql3->bind_param('i', $punisher);
                                $sql3->execute();    // Execute the prepared query.

                                $punisher_name = null;
                                $punisher_uuid = null;

                                $sql3->bind_result($punisher_name, $punisher_uuid);
                                $sql3->fetch();
                                echo '<div class="container">
                                <div class="row"><h1 style="text-align: center;margin-right: auto;margin-left: auto">Punishment ', $code, ' ', (($status == 1 or $status == 2 or $status == 3) ? "<span class='badge badge-success'>ACTIVE</span>" : (($status == 4) ? "<span class='badge badge-danger'>SM DENIED</span>" : (($removal_reason != null) ? "<span class='badge badge-secondary'>REMOVED</span>" : "<span class='badge badge-secondary'>EXPIRED</span>"))) . ' ' . (($status == 2) ? "<span class='badge badge-secondary'>PENDING APPROVAL</span>" : (($status == 3 or $status == 6) ? "<span class='badge badge-success'>SM APPROVED</span>" : "")), '</h1></div>
                                <div class="row">
                                    <div class="col-6" style="margin: auto">
                                        <img class="img-fluid" style="margin: auto;display: block" width="30%"
                                            src="https://crafatar.com/renders/body/', $uuid, '?helm=true">
                                    </div>
                                    <div class="col-6">
                                    
                                        <table class="table table-hover" style="color:white">
                                            <thead>
                                                <tr>
                                                <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-values" style="color: white">
                                                   <tr><td><strong style="font-weight: bold">Punished User:</strong> ', $name, '</td></tr>
                                                    <tr><td><strong style="font-weight: bold">Type:</strong> ', (($status == 7) ? 'Warning' : (($type == 1) ? 'Mute' : 'Ban')) . ' (' . $types[$type - 1] . ')', '</td></tr>
                                                    <tr><td><strong style="font-weight: bold">Reason:</strong> ', $rule_name, ' - ', $notes, '</td></tr>
                                                    <tr><td><strong style="font-weight: bold">Weight:</strong> ', $weights[$weight - 1], '</td></tr>
                                                    <tr><td><strong style="font-weight: bold">Issued at:</strong> ', date('l jS F Y G:i:s T', intval($issued) / 1000), '</td></tr>
                                                    <tr><td><strong style="font-weight: bold">Length:</strong> ', (($expire == -1) ? 'Permanent' : (((intval($expire) - intval($issued)) / 3600000 >= 24) ? ((intval($expire) - intval($issued)) / 86400000) . ' days' : ((intval($expire) - intval($issued)) / 3600000) . ' hours')), '</td></tr>
                                                    <tr><td><strong style="font-weight: bold;">Issued by:</strong> ', $punisher_name, '<img style="height:50px" src="https://crafatar.com/renders/head/', $punisher_uuid, '?helm=true"></td></tr>
                                                    <tr><td><strong style="font-weight: bold;">Evidence:</strong> ', (($evidence != null)?"<a href='" . ((strpos($evidence, "http://") === 0 || strpos($evidence, "https://") === 0)?"":"http://") . $evidence . "' style='color: white'>CLICK HERE</a>":"N/A"), '</td></tr>';
                                if ($removal_reason != null) {
                                    echo '<tr><td><strong style="font-weight: bold">Removal Reason:</strong> ', $removal_reason, '</td></tr>
                                                      <tr><td><strong style="font-weight: bold">Removed at:</strong> ', date('l jS F Y G:i:s T', intval($removal_timestamp) / 1000), '</td></tr>
                                                      <tr><td><strong style="font-weight: bold">Removed By:</strong> ', $remover, '</td></tr>';
                                }
                                echo '</tbody>
                                        </table>   
                                        
                                        
                                    </div>
                                </div>
                            </div>';
                                if ($removal_reason == null and $status != 7) {
                                    echo '
<!-- The Modal -->
					<div class="modal fade" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
      
							    <!-- Modal Header -->
							    <div class="modal-header">
								    <h4 class="modal-title" style="color: black">Remove a punishment</h4>
								    <button type="button" class="close" data-dismiss="modal">×</button>
							    </div>
        
							    <!-- Modal body -->
							    <div class="modal-body">
								    <form method="post" name="login_form">
									    <fieldset>
									    <div class="md-form">
                                            <input type="text" id="removalReason" class="form-control">
                                            <label for="removalReason">Reason</label>
                                        </div>
									    <input type="button" value="Remove" onclick="removePunishment(\'', $punishment_code,'\', this.form.removalReason.value, ', $type,', \'', $uuid,'\',', $status,')" class="btn btn-success" data-dismiss="modal"/> 
								    </form>
							    </div>
        
							    <!-- Modal footer -->
							    <div class="modal-footer">
								    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							    </div>
                            </div>
						</div>
					</div>
					<div style="display: flex;justify-content: center;align-items: center;"><div style="margin-left:auto;margin-right:auto;display: inline-block">';
                                    if ($status == 2) {
                                        echo '<button type="button" class="btn btn-success" onclick="approvePunishment(\'', $code,'\', ', $type,', \'', $uuid,'\')"><i class="fas fa-thumbs-up"></i><br>Approve Punishment</button><button type="button" class="btn btn-warning" onclick="denyPunishment(\'', $code,'\', ', $type,', \'', $uuid,'\')"><i class="fas fa-thumbs-down"></i><br>Deny Punishment</button>';
                                    }
                                    echo '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal" ><i class="fas fa-minus"></i><br>Remove Punishment</button></div></div>';
                                }

                            } else {
                                echo '<p style="text-align: center;padding-top: 20px;font:inherit">That punishment ID was not found.</p>';
                            }
                        } else {
                            echo "There has been an error connecting to the database. Please try again. 2";
                        }
                    } else {
                        echo '<p style="text-align: center;padding-top: 20px;font:inherit">That punishment ID was not found.</p>';
                    }

                } else {
                    echo "There has been an error connecting to the database. Please try again. 1";
                }
            elseif (isset($_GET['user'])): ?>
                <br>
                <div id="alerts-user"></div>
                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="usersearch">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search by Username"
                           aria-label="Search" name="user" style="color: white;" id="user">
                </form>
                <?php
                include_once "../database/db-connect.php";
                $raw_name = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
                $uuid = username_to_uuid($raw_name);
                if (!$uuid) {
                    echo "<p style=\"text-align: center;padding-top: 20px;font:inherit\">That user does not exist.</p>";
                } else {
                    $part1 = substr($uuid, 0, 8);
                    $part2 = substr($uuid, 8, 4);
                    $part3 = substr($uuid, 12, 4);
                    $part4 = substr($uuid, 16, 4);
                    $part5 = substr($uuid, 20, 12);
                    $user = $part1 . "-" . $part2 . "-" . $part3 . "-" . $part4 . "-" . $part5;
                    if ($sql = $mysqli->prepare("SELECT punishments.punishment_id,punishments.amc_id,punishments.rule_id,punishments.notes,punishments.punisher,punishments.issued,punishments.expire,punishments.status,punishments.evidence,punishments.suffix,punishments.removal_reason,punishments.remover,punishments.removal_timestamp,auroramc_players.name FROM punishments INNER JOIN auroramc_players ON auroramc_players.id=punishments.amc_id WHERE (amc_id = (SELECT id FROM auroramc_players WHERE uuid = ?)) ORDER BY issued DESC")) {
                        $sql->bind_param('s', $user);
                        $sql->execute();    // Execute the prepared query.
                        $result2 = $sql->get_result();
                        $numRows = $result2->num_rows;
                        $results = $result2->fetch_all(MYSQLI_ASSOC);
                        $result2->free_result();
                        $sql->free_result();
                        if ($numRows > 0) {
                            echo '<div class="container">
                                <div class="row">
                                    <h1 style="text-align: center;margin-right: auto;margin-left: auto">', $raw_name,'\'s Punishment History</h1>
                                     <table class="table table-dark table-hover table-sm table-striped white-text"  cellspacing="0" style="color:white" id="dtHistory" width="100%">
                                            <thead>
                                                <tr>
                                                <th class="th-sm">Code</th>
                                                <th class="th-sm">Punished User</th>
                                                <th class="th-sm">Type</th>
                                                <th class="th-sm">Reason</th>
                                                <th class="th-sm">Weight</th>
                                                <th class="th-sm">Issued At</th>
                                                <th class="th-sm">Length</th>
                                                <th class="th-sm">Issued By</th>
                                                <th class="th-sm">Removal Reason</th>
                                                <th class="th-sm">Removed At</th>
                                                <th class="th-sm">Removed By</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-values" style="color: white">';
                            foreach ($results as $result) {
                                if ($sql2 = $mysqli->prepare("SELECT * FROM rules WHERE rule_id = ?")) {
                                    $sql2->bind_param('i', $result['rule_id']);
                                    $sql2->execute();    // Execute the prepared query.

                                    $rule_name = null;
                                    $description = null;
                                    $weight = null;
                                    $rule_type = null;
                                    $requires_warning = null;
                                    $active = null;

                                    $sql2->bind_result($rule_id, $rule_name, $description, $weight, $requires_warning, $type, $active);
                                    $sql2->fetch();
                                    $sql2->store_result();
                                    $sql2->free_result();
                                    if ($sql3 = $mysqli->prepare("SELECT name,uuid FROM auroramc_players WHERE id = ?")) {
                                        $sql3->bind_param('i', $result['punisher']);
                                        $sql3->execute();    // Execute the prepared query.

                                        $punisher_name = null;
                                        $punisher_uuid = null;

                                        $sql3->bind_result($punisher_name, $punisher_uuid);
                                        $sql3->fetch();
                                        $sql3->store_result();
                                        $sql3->free_result();
                                        echo '
                                                   <tr>
                                                    <td><a href="/punishments/search?code=', $result['punishment_id'],'" style="color:white;">', $result['punishment_id'], ' ', (($result['status'] == 1 or $result['status'] == 2 or $result['status'] == 3) ? "<span class='badge badge-success'>ACTIVE</span>" : (($result['status'] == 4) ? "<span class='badge badge-danger'>SM DENIED</span>" : (($result['removal_reason'] != null) ? "<span class='badge badge-secondary'>REMOVED</span>" : "<span class='badge badge-secondary'>EXPIRED</span>"))) . (($result['status'] == 2) ? "<span class='badge badge-secondary'>PENDING APPROVAL</span>" : (($result['status'] == 3 or $result['status'] == 6) ? "<span class='badge badge-success'>SM APPROVED</span>" : "")),'</a></td>
                                                    <td>', $result['name'], '<img style="height:50px" src="https://crafatar.com/renders/head/', $user, '?helm=true"></td>
                                                    <td>', (($result['status'] == 7) ? 'Warning' : (($type == 1) ? 'Mute' : 'Ban')) . ' (' . $types[$type - 1] . ')', '</td>
                                                    <td>', $rule_name, ' - ', $result['notes'], '</td>
                                                    <td>', $weights[$weight - 1], '</td>
                                                    <td>', date('l jS F Y G:i:s T', intval($result['issued']) / 1000), '</td>
                                                    <td>', (($result['expire'] == -1) ? 'Permanent' : (((intval($result['expire']) - intval($result['issued'])) / 3600000 >= 24) ? ((intval($result['expire']) - intval($result['issued'])) / 86400000) . ' days' : ((intval($result['expire']) - intval($result['issued'])) / 3600000) . ' hours')), '</td>
                                                    <td>', $punisher_name, '<img style="height:50px" src="https://crafatar.com/renders/head/', $punisher_uuid, '?helm=true"></td>';
                                        if ($result['removal_reason'] != null) {
                                            echo '<td>', $result['removal_reason'], '</td>
                                                      <td>', date('l jS F Y G:i:s T', intval($result['removal_timestamp']) / 1000), '</td>
                                                      <td>', $result['remover'], '</td></tr>';
                                        } else {
                                            echo '<td>N/A</td>
                                                      <td>N/A</td>
                                                      <td>N/A</td></tr>';
                                        }
                                    } else {
                                        echo '<p style="text-align: center;padding-top: 20px;font:inherit">That punishment ID was not found.</p>';
                                    }
                                } else {
                                    echo "There has been an error connecting to the database. Please try again. 2";
                                }
                            }
                            echo '</tbody>
                                        </table>   
                                        
                                        
                                    </div>
                            </div>';
                        } else {
                            echo "<p style=\"text-align: center;padding-top: 20px;font:inherit\">That user either doesn't have any punishments or has never joined the network.</p>";
                        }

                    } else {
                        echo "There has been an error connecting to the database. Please try again. 1";
                    }
                }
            elseif (isset($_GET['punisher'])) : ?>
                <br>
                <div id="alerts-punisher"></div>
                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="punishersearch">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search by Punisher"
                           aria-label="Search" name="punisher" style="color: white;" id="punisher">
                </form>
                <?php
                include_once "../database/db-connect.php";
                $raw_name = filter_input(INPUT_GET, 'punisher', FILTER_SANITIZE_STRING);
                $uuid = username_to_uuid($raw_name);
                if (!$uuid) {
                    echo "<p style=\"text-align: center;padding-top: 20px;font:inherit\">That user does not exist.</p>";
                } else {
                    $part1 = substr($uuid, 0, 8);
                    $part2 = substr($uuid, 8, 4);
                    $part3 = substr($uuid, 12, 4);
                    $part4 = substr($uuid, 16, 4);
                    $part5 = substr($uuid, 20, 12);
                    $user = $part1 . "-" . $part2 . "-" . $part3 . "-" . $part4 . "-" . $part5;
                    if ($sql = $mysqli->prepare("SELECT punishments.punishment_id,punishments.amc_id,punishments.rule_id,punishments.notes,punishments.punisher,punishments.issued,punishments.expire,punishments.status,punishments.evidence,punishments.suffix,punishments.removal_reason,punishments.remover,punishments.removal_timestamp,auroramc_players.name,auroramc_players.uuid FROM punishments INNER JOIN auroramc_players ON auroramc_players.id=punishments.amc_id WHERE (punisher = (SELECT id FROM auroramc_players WHERE uuid = ?)) ORDER BY issued DESC")) {
                        $sql->bind_param('s', $user);
                        $sql->execute();    // Execute the prepared query.
                        $result2 = $sql->get_result();
                        $numRows = $result2->num_rows;
                        $results = $result2->fetch_all(MYSQLI_ASSOC);
                        $result2->free_result();
                        $sql->free_result();
                        if ($numRows > 0) {
                            echo '<div class="container">
                                <div class="row">
                                    <h1 style="text-align: center;margin-right: auto;margin-left: auto">', $raw_name,'\'s Issued Punishments</h1>
                                     <table class="table table-dark table-hover table-sm table-striped white-text"  cellspacing="0" style="color:white" id="dtHistory" width="100%">
                                            <thead>
                                                <tr>
                                                <th class="th-sm">Code</th>
                                                <th class="th-sm">Punished User</th>
                                                <th class="th-sm">Type</th>
                                                <th class="th-sm">Reason</th>
                                                <th class="th-sm">Weight</th>
                                                <th class="th-sm">Issued At</th>
                                                <th class="th-sm">Length</th>
                                                <th class="th-sm">Issued By</th>
                                                <th class="th-sm">Removal Reason</th>
                                                <th class="th-sm">Removed At</th>
                                                <th class="th-sm">Removed By</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-values" style="color: white">';
                            foreach ($results as $result) {
                                if ($sql2 = $mysqli->prepare("SELECT * FROM rules WHERE rule_id = ?")) {
                                    $sql2->bind_param('i', $result['rule_id']);
                                    $sql2->execute();    // Execute the prepared query.

                                    $rule_name = null;
                                    $description = null;
                                    $weight = null;
                                    $rule_type = null;
                                    $requires_warning = null;
                                    $active = null;

                                    $sql2->bind_result($rule_id, $rule_name, $description, $weight, $requires_warning, $type, $active);
                                    $sql2->fetch();
                                    $sql2->store_result();
                                    $sql2->free_result();
                                    if ($sql3 = $mysqli->prepare("SELECT name,uuid FROM auroramc_players WHERE id = ?")) {
                                        $sql3->bind_param('i', $result['punisher']);
                                        $sql3->execute();    // Execute the prepared query.

                                        $punisher_name = null;
                                        $punisher_uuid = null;

                                        $sql3->bind_result($punisher_name, $punisher_uuid);
                                        $sql3->fetch();
                                        $sql3->store_result();
                                        $sql3->free_result();
                                        echo '
                                                   <tr>
                                                    <td><a href="/punishments/search?code=', $result['punishment_id'],'" style="color:white;">', $result['punishment_id'], ' ', (($result['status'] == 1 or $result['status'] == 2 or $result['status'] == 3) ? "<span class='badge badge-success'>ACTIVE</span>" : (($result['status'] == 4) ? "<span class='badge badge-danger'>SM DENIED</span>" : (($result['removal_reason'] != null) ? "<span class='badge badge-secondary'>REMOVED</span>" : "<span class='badge badge-secondary'>EXPIRED</span>"))) . (($result['status'] == 2) ? "<span class='badge badge-secondary'>PENDING APPROVAL</span>" : (($result['status'] == 3 or $result['status'] == 6) ? "<span class='badge badge-success'>SM APPROVED</span>" : "")),'</a></td>
                                                    <td>', $result['name'], '<img style="height:50px" src="https://crafatar.com/renders/head/', $result['uuid'], '?helm=true"></td>
                                                    <td>', (($result['status'] == 7) ? 'Warning' : (($type == 1) ? 'Mute' : 'Ban')) . ' (' . $types[$type - 1] . ')', '</td>
                                                    <td>', $rule_name, ' - ', $result['notes'], '</td>
                                                    <td>', $weights[$weight - 1], '</td>
                                                    <td>', date('l jS F Y G:i:s T', intval($result['issued']) / 1000), '</td>
                                                    <td>', (($result['expire'] == -1) ? 'Permanent' : (((intval($result['expire']) - intval($result['issued'])) / 3600000 >= 24) ? ((intval($result['expire']) - intval($result['issued'])) / 86400000) . ' days' : ((intval($result['expire']) - intval($result['issued'])) / 3600000) . ' hours')), '</td>
                                                    <td>', $punisher_name, '<img style="height:50px" src="https://crafatar.com/renders/head/', $punisher_uuid, '?helm=true"></td>';
                                        if ($result['removal_reason'] != null) {
                                            echo '<td>', $result['removal_reason'], '</td>
                                                      <td>', date('l jS F Y G:i:s T', intval($result['removal_timestamp']) / 1000), '</td>
                                                      <td>', $result['remover'], '</td></tr>';
                                        } else {
                                            echo '<td>N/A</td>
                                                      <td>N/A</td>
                                                      <td>N/A</td></tr>';
                                        }
                                    } else {
                                        echo '<p style="text-align: center;padding-top: 20px;font:inherit">That punishment ID was not found.</p>';
                                    }
                                } else {
                                    echo "There has been an error connecting to the database. Please try again. 2";
                                }
                            }
                            echo '</tbody>
                                        </table>   
                                        
                                        
                                    </div>
                            </div>';
                        } else {
                            echo "<p style=\"text-align: center;padding-top: 20px;font:inherit\">That user either doesn't have any punishments or has never joined the network.</p>";
                        }

                    } else {
                        echo "There has been an error connecting to the database. Please try again. 1";
                    }
                }
            else: ?>
                <br>
                <legend style="font-family: 'Helvetica',serif;">Search by Punishment Code</legend>
                <hr>
                <div id="alerts-code"></div>
                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="codesearch">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-75" type="text"
                           placeholder="Search by Punishment Code"
                           aria-label="Search" name="code" id="code" style="color: white;">
                </form>

                <br>
                <legend style="font-family: 'Helvetica',serif;">Search by Username</legend>
                <hr>
                <div id="alerts-user"></div>
                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="usersearch">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search by Username"
                           aria-label="Search" name="user" style="color: white;" id="user">
                </form>

                <br>
                <legend style="font-family: 'Helvetica',serif;">Search by Punisher</legend>
                <hr>
                <div id="alerts-punisher"></div>
                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" id="punishersearch">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search by Punisher"
                           aria-label="Search" name="punisher" style="color: white;" id="punisher">
                </form>
            <?php endif; ?>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>