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
            <br>
            <h1><Strong>Daily Metrics</Strong></h1>
            <br>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <legend style="font-family: 'Helvetica';">Network Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-player-totals/daily.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Game Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-game-player-totals/daily.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Games Started</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/games-started/daily.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Unique Player Joins</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/unique-player-joins/daily.php"></iframe>
                    </div>
                    <div class="col-6">
                        <legend style="font-family: 'Helvetica';">Network Server Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-server-totals/daily.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Network Proxy Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-proxy-totals/daily.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Avg. Players Per Game</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/players-per-game/daily.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Unique Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/unique-player-totals/daily.php"></iframe>
                    </div>
                </div>
            </div>
            <br>
            <h1><Strong>Weekly Metrics</Strong></h1>
            <br>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <legend style="font-family: 'Helvetica';">Network Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-player-totals/weekly.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Game Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-game-player-totals/weekly.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Games Started</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/games-started/weekly.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Unique Player Joins</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/unique-player-joins/weekly.php"></iframe>
                    </div>
                    <div class="col-6">
                        <legend style="font-family: 'Helvetica';">Network Server Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-server-totals/weekly.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Network Proxy Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-proxy-totals/weekly.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Avg. Players Per Game</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/players-per-game/weekly.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Unique Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/unique-player-totals/weekly.php"></iframe>
                    </div>
                </div>
            </div>
            <br>
            <h1><Strong>All-Time Statistics</Strong></h1>
            <br>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <legend style="font-family: 'Helvetica';">Network Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-player-totals/alltime.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Game Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-game-player-totals/alltime.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Games Started</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/games-started/alltime.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Unique Player Joins</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/unique-player-joins/alltime.php"></iframe>
                    </div>
                    <div class="col-6">
                        <legend style="font-family: 'Helvetica';">Network Server Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-server-totals/alltime.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Network Proxy Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/network-proxy-totals/alltime.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Avg. Players Per Game</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/players-per-game/alltime.php"></iframe>
                        <br>
                        <br>
                        <legend style="font-family: 'Helvetica';">Unique Player Totals</legend>
                        <hr>
                        <iframe width="600px" height="300px" scrolling="no" frameborder="0" src="utils/graphs/unique-player-totals/alltime.php"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>