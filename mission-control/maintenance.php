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
            <li class="nav-item">
                <a class="nav-link" href="server-manager">Server Manager</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Network Maintenance</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid" style="padding-top: 40px">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <br>
            <h1><Strong><u>Network Maintenance</u></Strong></h1>
            <br>
            <br>
            <div class="container">
                <div class="text-center">
                    <h2><u>Network</u></h2>
                </div>
                <div class="row">

                    <div class="col-sm-4">
                        <div class="card border-success text-center mx-xl-5">
                            <div class="card-header bg-success">
                                <p class="sm-card-title">Enable network monitoring</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <p style="font-weight:900;color:black;margin-bottom: 0;">PLEASE NOTE:</p><p style="color:black;margin-bottom: 0"> This action will start the creation of servers.</p>
                                <form name="enable"
                                      id="enable">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset style="width:100%">
                                            <select name="network" id="network" class="form-control"
                                                    onchange="networkChangeServerCreate(this.form.network.value)">
                                                <option value="MAIN">Main</option>
                                                <option value="ALPHA">Alpha</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="enable-button" class="btn btn-success"
                                            form="enable"
                                            onclick="enableNetwork(this.form.network.value);">
                                        <i class="fas fa-check"></i><br>Enable
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-danger text-center mx-xl-5">
                            <div class="card-header bg-danger">
                                <p class="sm-card-title">Disable network monitoring</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <p style="font-weight:900;color:black;margin-bottom: 0;">PLEASE NOTE:</p><p style="color:black;margin-bottom: 0"> This action will not close any open servers.</p>
                                <form name="disable"
                                      id="disable">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset style="width: 100%">
                                            <select name="network" id="network" class="form-control">
                                                <option value="MAIN">Main</option>
                                                <option value="ALPHA">Alpha</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="disable-button" class="btn btn-danger"
                                            form="disable"
                                            onclick="disableNetwork(this.form.network.value);">
                                        <i class="fas fa-times"></i><br>Disable
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-info text-center mx-xl-5">
                            <div class="card-header bg-info">
                                <p class="sm-card-title">Update main network</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <p style="color:black;margin-bottom: 0">In order to update the main network, please open the update modal.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="update-button" class="btn btn-info"
                                            data-toggle="modal"
                                            data-target="#updateModal">
                                        <i class="fas fa-upload"></i><br>Open Modal
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                                class="modal fade"
                                id="updateModal"
                                tabindex="-1"
                                aria-labelledby="updateModal"
                                aria-hidden="true"
                        >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel" style="color:black;">Update the main network</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color:black;margin-bottom: 0">Update the plugins on the main network. This action will trigger a network restart of all applicable servers. This action is irreversible.<br><br>
                                            Please input the build numbers as found on Jenkins. Any module you do not wish to update, please leave the field blank.</p>
                                        <br>
                                        <form name="update"
                                              id="update">
                                            <div class="md-form input-group input-group-lg">
                                                <fieldset>
                                                    <input type='text' name='core' id='core' placeholder="Core Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='lobby' id='lobby' placeholder="Lobby Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='engine' id='engine' placeholder="Engine Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='game' id='game' placeholder="Game Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='build' id='build' placeholder="Build Core Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='event' id='event' placeholder="Event Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='proxy' id='proxy' placeholder="Proxy Build Number"
                                                           class="form-control"/>
                                                </fieldset>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="button" class="btn btn-info"
                                                form="update"
                                                onclick="updateNetwork(this.form.core.value, this.form.lobby.value, this.form.engine.value, this.form.game.value, this.form.build.value, this.form.event.value, this.form.proxy.value);"><i class="fas fa-upload"></i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="text-center">
                    <h2><u>Alpha</u></h2>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card border-success text-center mx-xl-5">
                            <div class="card-header bg-success">
                                <p class="sm-card-title">Enable Alpha Network</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <p style="font-weight:900;color:black;margin-bottom: 0;">PLEASE NOTE:</p><p style="color:black;margin-bottom: 0"> This action enables the Alpha network and starts network monitoring with the already selected branch and build details.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="enable-alpha-button" class="btn btn-success"
                                            form="enable_alpha"
                                            onclick="enableAlpha(this.form.network.value, this.form.extra_details.value);">
                                        <i class="fas fa-check"></i><br>Enable
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-danger text-center mx-xl-5">
                            <div class="card-header bg-danger">
                                <p class="sm-card-title">Disable Alpha Network</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <p style="font-weight:900;color:black;margin-bottom: 0;">PLEASE NOTE:</p><p style="color:black;margin-bottom: 0"> This action will close any open server or connection node and disable network monitoring for the Alpha Network.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="disable-alpha-button" class="btn btn-danger"
                                            form="disable_alpha"
                                            onclick="disableAlpha(this.form.proxy.value, this.form.network.value);">
                                        <i class="fas fa-times"></i><br>Disable
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-info text-center mx-xl-5">
                            <div class="card-header  bg-info">
                                <p class="sm-card-title">Change Module Branch</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <p style="color:black;margin-bottom: 0">In order to update the Alpha network, please open the update modal.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="update-button" class="btn btn-info"
                                            data-toggle="modal"
                                            data-target="#alphaModal">
                                        <i class="fas fa-upload"></i><br>Open Modal
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                                class="modal fade"
                                id="alphaModal"
                                tabindex="-1"
                                aria-labelledby="updateModal"
                                aria-hidden="true"
                        >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel" style="color:black;">Update the alpha network</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color:black;margin-bottom: 0">Update the plugins on the alpha network. This action will trigger a network restart of all applicable servers. This action is irreversible.<br><br>
                                            Please input the build numbers and branches as found on Jenkins. It should be in the format <i>branch:build</i>. Any module you do not wish to update, please leave the field blank.</p>
                                        <br>
                                        <form name="update_alpha"
                                              id="update_alpha">
                                            <div class="md-form input-group input-group-lg">
                                                <fieldset>
                                                    <input type='text' name='core' id='core' placeholder="Core Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='lobby' id='lobby' placeholder="Lobby Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='engine' id='engine' placeholder="Engine Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='game' id='game' placeholder="Game Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='build' id='build' placeholder="Build Core Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='event' id='event' placeholder="Event Build Number"
                                                           class="form-control"/><br>
                                                    <input type='text' name='proxy' id='proxy' placeholder="Proxy Build Number"
                                                           class="form-control"/>
                                                </fieldset>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="button" class="btn btn-info"
                                                form="update_alpha"
                                                onclick="updateAlphaNetwork(this.form.core.value, this.form.lobby.value, this.form.engine.value, this.form.game.value, this.form.build.value, this.form.event.value, this.form.proxy.value);"><i class="fas fa-upload"></i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="text-center">
                    <h2><u>Games</u></h2>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card border-success text-center mx-xl-5">
                            <div class="card-header bg-success">
                                <p class="sm-card-title">Enable a game</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="enable_game"
                                      id="enable_game">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset style="width:100%">
                                            <select name="network" id="network" class="form-control">
                                                <option value="MAIN">Main</option>
                                                <option value="ALPHA">Alpha</option>
                                            </select><br>
                                            <select name="game" id="game" class="form-control">
                                                <optgroup label="Lobby Servers">
                                                    <option value="LOBBY">Lobby</option>
                                                </optgroup>
                                                <optgroup label="Game Servers">
                                                    <option value="CRYSTAL_QUEST">Crystal Quest</option>
                                                    <option value="MIXED_ARCADE">Mixed Arcade</option>
                                                </optgroup>
                                                <optgroup label="Misc Servers">
                                                    <option value="BUILD">Build</option>
                                                    <option value="EVENT">Event</option>
                                                    <option value="STAFF">Staff</option>
                                                </optgroup>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="enable-game-button" class="btn btn-success"
                                            form="enable_game"
                                            onclick="enableGame(this.form.game.value, this.form.network.value);">
                                        <i class="fas fa-check"></i><br>Enable
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-danger text-center mx-xl-5">
                            <div class="card-header bg-danger">
                                <p class="sm-card-title">Disable a game</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="disable_game"
                                      id="disable_game">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset style="width:100%">
                                            <select name="network" id="network" class="form-control">
                                                <option value="MAIN">Main</option>
                                                <option value="ALPHA">Alpha</option>
                                            </select><br>
                                            <select name="game" id="game" class="form-control">
                                                <optgroup label="Lobby Servers">
                                                    <option value="LOBBY">Lobby</option>
                                                </optgroup>
                                                <optgroup label="Game Servers">
                                                    <option value="CRYSTAL_QUEST">Crystal Quest</option>
                                                    <option value="MIXED_ARCADE">Mixed Arcade</option>
                                                </optgroup>
                                                <optgroup label="Misc Servers">
                                                    <option value="BUILD">Build</option>
                                                    <option value="EVENT">Event</option>
                                                    <option value="STAFF">Staff</option>
                                                </optgroup>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="disable-game-button" class="btn btn-danger"
                                            form="disable_game"
                                            onclick="disableGame(this.form.game.value, this.form.network.value);">
                                        <i class="fas fa-times"></i><br>Disable
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-info text-center mx-xl-5">
                            <div class="card-header  bg-info">
                                <p class="sm-card-title">Game Monitoring</p>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <form name="monitoring"
                                      id="monitoring">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset>
                                            <select name="network" id="network" class="form-control">
                                                <option value="MAIN">Main</option>
                                                <option value="ALPHA">Alpha</option>
                                            </select><br>
                                            <select name="game" id="game" class="form-control">
                                                <optgroup label="Lobby Servers">
                                                    <option value="LOBBY">Lobby</option>
                                                </optgroup>
                                                <optgroup label="Game Servers">
                                                    <option value="CRYSTAL_QUEST">Crystal Quest</option>
                                                    <option value="MIXED_ARCADE">Mixed Arcade</option>
                                                </optgroup>
                                                <optgroup label="Misc Servers">
                                                    <option value="BUILD">Build</option>
                                                    <option value="EVENT">Event</option>
                                                    <option value="STAFF">Staff</option>
                                                </optgroup>
                                            </select><br>
                                            <select name="enabled" id="enabled" class="form-control">
                                                <option value="true">Enable</option>
                                                <option value="false">Disabled</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="monitoring-button" class="btn btn-danger"
                                            form="monitoring"
                                            onclick="monitoringToggle(this.form.enabled.value, this.form.game.value, this.form.network.value);">
                                        <i class="fas fa-upload"></i><br>Change
                                    </button>
                                </div>
                            </div>
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