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
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stats">Statistics</a>
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
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <br>
            <h1><Strong>AuroraMC Network Mission Control</Strong></h1>
            <br>
            <legend style="font-family: 'Helvetica';">Welcome!</legend>
            <hr>
            <p style="font-size: 17px; font-family: 'Helvetica'">Welcome to AuroraMC Network's Misson Control! Here, you can see all network metrics, create and destroy servers, and conduct network maintenance!</p>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <legend style="font-family: 'Helvetica';">Main Network Stats</legend>
                        <hr>
                        <?php
                        include_once '../database/db-connect.php';

                        if ($sql = $mysqli->prepare("SELECT count(*) FROM servers WHERE network = 'MAIN'")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $servers = $results[0];
                            echo '<p><strong style="font-weight: bold">Servers Online:</strong> ', $servers,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM proxies WHERE network = 'MAIN'")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $proxies = $results[0];
                            echo '<p><strong style="font-weight: bold">Proxies Online:</strong> ', $proxies,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        echo '<p><strong style="font-weight: bold">Total Players Online:</strong> ', $redis->get('playercount.main'),'</p>';
                        ?>
                    </div>
                    <div class="col-4">
                        <legend style="font-family: 'Helvetica';">Alpha Network Statistics</legend>
                        <hr>
                        <?php
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM servers WHERE network = 'ALPHA'")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $servers = $results[0];
                            echo '<p><strong style="font-weight: bold">Servers Online:</strong> ', $servers,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM proxies WHERE network = 'ALPHA'")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $proxies = $results[0];
                            echo '<p><strong style="font-weight: bold">Proxies Online:</strong> ', $proxies,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        echo '<p><strong style="font-weight: bold">Total Players Online:</strong> ', $redis->get('playercount.alpha'),'</p>';
                        ?>
                    </div>
                    <div class="col-4">
                        <legend style="font-family: 'Helvetica';">Test Network Statistics</legend>
                        <hr>
                        <?php
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM servers WHERE network = 'TEST'")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $servers = $results[0];
                            echo '<p><strong style="font-weight: bold">Servers Online:</strong> ', $servers,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        if ($sql = $mysqli->prepare("SELECT count(*) FROM proxies WHERE network = 'TEST'")) {
                            $sql->execute();
                            $results2 = $sql->get_result();
                            $results = $results2->fetch_array(MYSQLI_NUM);
                            $results2->free_result();
                            $sql->free_result();
                            $proxies = $results[0];
                            echo '<p><strong style="font-weight: bold">Proxies Online:</strong> ', $proxies,'</p>';
                        } else {
                            echo 'An error occurred when trying to connect to the database. Please try again.';
                        }
                        echo '<p><strong style="font-weight: bold">Total Players Online:</strong> ', $redis->get('playercount.test'),'</p>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div> <!-- Gap at right side of form -->
    </div>
</div>

</body>
</html>