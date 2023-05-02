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

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV") {
    header("Location: ../../login");
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
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <script type="text/javascript" src="js/main.js"></script>

    <script src="https://kit.fontawesome.com/ef00ee83f1.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/main.css">

    <link rel="icon"
          type="image/png"
          href="../img/logo.png">
</head>
<body style="background-color: #23272A;color:white">
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
        <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item">
                <a class="nav-link" href="/mission-control/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stats">Statistics</a>
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
            <li class="nav-item active">
                <a class="nav-link" href="#">Server Manager</a>
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
            <br>
            <h1><Strong><u>Server Manager</u></Strong></h1>
            <br>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card border-success text-center mx-xl-5">
                            <div class="card-header bg-success">
                                <p class="sm-card-title">Create a server</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="create_server"
                                      id="create_server">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset>
                                            <input type='text' name='server' id='server' placeholder="Server Name"
                                                   class="form-control"/><br>
                                            <select name="game" id="game" class="form-control">
                                                <optgroup label="Lobby Servers">
                                                    <option value="LOBBY">Lobby</option>
                                                </optgroup>
                                                <optgroup label="Game Servers">
                                                    <option value="CRYSTAL_QUEST">Crystal Quest</option>
                                                    <option value="PAINTBALL">Paintball</option>
                                                    <option value="BACKSTAB">Backstab</option>
                                                    <option value="DUELS">Duels</option>
                                                    <option value="ARCADE_MODE">Arcade Mode</option>
                                                </optgroup>
                                                <optgroup label="NuttersSMP">
                                                    <option value="SMP_OVERWORLD">Overworld</option>
                                                    <option value="SMP_NETHER">Nether</option>
                                                    <option value="SMP_END">he End</option>
                                                </optgroup>
                                                <optgroup label="Misc Servers">
                                                    <option value="BUILD">Build</option>
                                                    <option value="EVENT">Event</option>
                                                    <option value="STAFF">Staff</option>
                                                </optgroup>
                                            </select><br>
                                            <select name="network" id="network" class="form-control"
                                                    onchange="networkChangeServerCreate(this.form.network.value)">
                                                <?php if ($account_type != "DEV") : ?>
                                                    <option value="MAIN">Main</option>
                                                <?php endif; ?>
                                                <option value="ALPHA">Alpha</option>
                                                <option value="TEST">Test</option>
                                            </select>
                                            <div id="extra_create_server" style="visibility: hidden;display:none;">
                                                <br>
                                                <input type="text" name="extra_details" id="extra_details"
                                                       placeholder="Extra Details" class="form-control"/>
                                            </div>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="create-server-button" class="btn btn-success"
                                            form="create_server"
                                            onclick="serverCreate(this.form.server.value, this.form.network.value, this.form.game.value, this.form.extra_details.value);">
                                        <i class="fas fa-plus"></i><br>Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-warning text-center mx-xl-5">
                            <div class="card-header bg-warning">
                                <p class="sm-card-title">Restart a server</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="restart_server"
                                      id="restart_server">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset>
                                            <input type='text' name='server' id='server' placeholder="Server Name"
                                                   class="form-control"/><br>
                                            <select name="network" id="network" class="form-control">
                                                <?php if ($account_type != "DEV") : ?>
                                                    <option value="MAIN">Main</option>
                                                <?php endif; ?>
                                                <option value="ALPHA">Alpha</option>
                                                <option value="TEST">Test</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="restart-server-button" class="btn btn-warning"
                                            form="restart_server"
                                            onclick="serverRestart(this.form.server.value, this.form.network.value);">
                                        <i class="fas fa-sync-alt"></i><br>Restart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-danger text-center mx-xl-5">
                            <div class="card-header bg-danger">
                                <p class="sm-card-title">Close a server</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="close_server"
                                      id="close_server">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset>
                                            <input type='text' name='server' id='server' placeholder="Server Name"
                                                   class="form-control"/><br>
                                            <select name="network" id="network" class="form-control">
                                                <?php if ($account_type != "DEV") : ?>
                                                    <option value="MAIN">Main</option>
                                                <?php endif; ?>
                                                <option value="ALPHA">Alpha</option>
                                                <option value="TEST">Test</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="close-server-button" class="btn btn-danger"
                                            form="close_server"
                                            onclick="serverClose(this.form.server.value, this.form.network.value);">
                                        <i class="fas fa-times"></i><br>Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card border-success text-center mx-xl-5">
                            <div class="card-header bg-success">
                                <p class="sm-card-title">Create a proxy</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="create_proxy"
                                      id="create_proxy">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset style="width:100%">
                                            <select name="network" id="network" class="form-control"
                                                    onchange="networkChangeProxyCreate(this.form.network.value)">
                                                <?php if ($account_type != "DEV") : ?>
                                                    <option value="MAIN">Main</option>
                                                <?php endif; ?>
                                                <option value="ALPHA">Alpha</option>
                                                <option value="TEST">Test</option>
                                            </select>
                                            <div id="extra_create_proxy" style="visibility: hidden;display:none;">
                                                <br>
                                                <input type="text" name="extra_details" id="extra_details"
                                                       placeholder="Extra Details" class="form-control"/>
                                            </div>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="create-proxy-button" class="btn btn-success"
                                            form="create_proxy"
                                            onclick="proxyCreate(this.form.network.value, this.form.extra_details.value);">
                                        <i class="fas fa-plus"></i><br>Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-warning text-center mx-xl-5">
                            <div class="card-header bg-warning">
                                <p class="sm-card-title">Restart a proxy</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="restart_proxy"
                                      id="restart_proxy">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset>
                                            <input type='text' name='proxy' id='proxy' placeholder="Proxy UUID"
                                                   class="form-control"/><br>
                                            <select name="network" id="network" class="form-control">
                                                <?php if ($account_type != "DEV") : ?>
                                                    <option value="MAIN">Main</option>
                                                <?php endif; ?>
                                                <option value="ALPHA">Alpha</option>
                                                <option value="TEST">Test</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="restart-proxy-button" class="btn btn-warning"
                                            form="restart_proxy"
                                            onclick="proxyRestart(this.form.proxy.value, this.form.network.value);">
                                        <i class="fas fa-sync-alt"></i><br>Restart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-danger text-center mx-xl-5">
                            <div class="card-header  bg-danger">
                                <p class="sm-card-title">Close a proxy</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="close_proxy"
                                      id="close_proxy">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset>
                                            <input type='text' name='proxy' id='proxy' placeholder="Proxy UUID"
                                                   class="form-control"/><br>
                                            <select name="network" id="network" class="form-control">
                                                <?php if ($account_type != "DEV") : ?>
                                                    <option value="MAIN">Main</option>
                                                <?php endif; ?>
                                                <option value="ALPHA">Alpha</option>
                                                <option value="TEST">Test</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="close-proxy-button" class="btn btn-danger"
                                            form="close_proxy"
                                            onclick="proxyClose(this.form.proxy.value, this.form.network.value);">
                                        <i class="fas fa-times"></i><br>Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>