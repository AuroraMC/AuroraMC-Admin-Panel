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

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/navbar.css">

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
            <legend style="font-family: 'Helvetica';">Create a server</legend>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="card mx-xl-5">
                            <!-- Card body -->
                            <div class="card-body">
                                <form action="utils/create-server.php" method="post" name="create_server" id="create_server">
                                    <div class="md-form input-group input-group-lg">
                                        <fieldset>
                                            <input type='text' name='server' id='server' placeholder="Server Name" class="form-control" /><br>
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
                                            <select name="network" id="network" class="form-control" onchange="networkChangeServerCreate(this.form.network.value)">
                                                <option value="MAIN">Main</option>
                                                <option value="ALPHA">Alpha</option>
                                                <option value="TEST">Test</option>
                                            </select><br>
                                            <div id="extra_create_server" style="visibility: hidden;">
                                                <input type="text" name="extra_details" id="extra_details" placeholder="Extra Details" />
                                            </div>
                                        </fieldset>
                                    </div>
                                    <button type="button" class="btn btn-default" form="login_form" onclick="serverCreate(this.form.server.value, this.form.network.value, this.form.game.value, this.form.extra_details.value);">Create</button></div></div>
                        </form>
                    </div>
                </div>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>