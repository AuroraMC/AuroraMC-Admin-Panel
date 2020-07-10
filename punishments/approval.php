<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Approval System | Punishments Database | The AuroraMC Network</title>

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
            <li class="nav-item">
                <a class="nav-link" href="search/">Search</a>
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
                <a class="nav-link" href="notes">Admin Notes</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Approval System</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid" style="padding-top: 80px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12 ">
            <?php
            $weights = array("<Strong style='color:#00AA00;font-weight: bold'>Light</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Medium</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Heavy</Strong>", "<Strong style='font-weight: bold;color:#FFAA00'>Severe</Strong>", "<Strong style='font-weight: bold;color:#AA0000'>Extreme</Strong>");
            $types = array("<Strong style='color:#00AA00;font-weight: bold'>Chat</Strong>", "<Strong style='color:#55FF55;font-weight: bold'>Game</Strong>", "<Strong style='font-weight: bold;color:#FFFF55'>Misc</Strong>");
                include_once "../database/db-connect.php";
                    if ($sql = $mysqli->prepare("SELECT punishments.punishment_id,punishments.amc_id,punishments.rule_id,punishments.notes,punishments.punisher,punishments.issued,punishments.expire,punishments.status,punishments.evidence,punishments.suffix,punishments.removal_reason,punishments.remover,punishments.removal_timestamp,auroramc_players.name,auroramc_players.uuid FROM punishments INNER JOIN auroramc_players ON auroramc_players.id=punishments.amc_id WHERE status = 2 ORDER BY issued DESC")) {
                        $sql->execute();    // Execute the prepared query.
                        $result2 = $sql->get_result();
                        $numRows = $result2->num_rows;
                        $results = $result2->fetch_all(MYSQLI_ASSOC);
                        $result2->free_result();
                        $sql->free_result();
                        if ($numRows > 0) {
                            echo '<div class="container">
                                <div class="row">
                                    <h1 style="text-align: center;margin-right: auto;margin-left: auto">Unprocessed Pending Punishments</h1>
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
                            echo "<p style=\"text-align: center;padding-top: 20px;font:inherit\">There are currently no pending punishments.</p>";
                        }

                    } else {
                        echo "There has been an error connecting to the database. Please try again. 1";
                    }
                ?>

        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>