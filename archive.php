<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Archived Rules | AuroraMC Network Rules Committee | Admin Panel</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="js/rules.js"></script>
</head>

<body style="background-color: #23272A;color:white">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="http://rules.auroramc.block2block.me/">AuroraMC Rules Committee - Admin Panel</a>

    <ul class="nav navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="chat">Chat Rules</a></li>
        <li class="nav-item"><a class="nav-link" href="game">Game Rules</a></li>
        <li class="nav-item"><a class="nav-link" href="misc">Misc Rules</a></li>
        <li class="nav-item active"><a class="nav-link" href="#">Archived Rules</a></li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div> <!-- Gap at left side of form -->
        <div class="col-sm-8 col-xs-12">
            <br>
            <h1><Strong>AuroraMC Network Rules Committee Admin Panel</Strong></h1>
            <br>
            <legend style="font-family: 'Helvetica';">Archived Rules</legend>
            <br>
            <table class="table table-hover" style="color:white">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Weight</th>
                    <th>Requires Warning</th>
                </tr>
                </thead>
                <tbody id="table-values">
                <?php
                include_once "database/db-connect.php";
                $weights = array("<p style='color:#00AA00'><Strong>Light</Strong></p>", "<p style='color:#55FF55'><Strong>Medium</Strong></p>","<p style='color:#FFFF55'><Strong>Heavy</Strong></p>","<p style='color:#FFAA00'><Strong>Severe</Strong></p>","<p style='color:#AA0000'><Strong>Extreme</Strong></p>");
                $types = array("<p style='color:#00AA00'><Strong>Chat</Strong></p>", "<p style='color:#55FF55'><Strong>Game</Strong></p>","<p style='color:#FFFF55'><Strong>Misc</Strong></p>");
                $requires_warnings = array("<Strong>No</Strong>","<Strong>Yes</Strong>");

                if ($sql = $mysqli->prepare("SELECT * FROM rules WHERE active = 0 ORDER BY type ASC, weight ASC, rule_id ASC")) {
                    $sql->execute();    // Execute the prepared query.

                    $id = null;
                    $name = null;
                    $description = null;
                    $weight = null;
                    $type = null;
                    $requires_warning = null;
                    $active = null;

                    $sql->bind_result($id, $name, $description, $weight, $requires_warning, $type, $active);
                    while ($sql->fetch()) {
                        if ($active = 1) {
                            echo "<tr id='", $id, "' style='color:white'><td id='", $id, "-id'>", $id, "</td><td id='", $id, "-name'>", $name, "</td><td id='", $id,"-description'>", $description, "</td><td id='", $id,"-type'>", $types[$type - 1], "</td><td id='", $id,"-weight'>", $weights[$weight - 1], "</td><td id='", $id,"-warning'>", $requires_warnings[$requires_warning], "</td></tr>";
                        }
                    }

                } else {
                    echo "ERROR";
                }

                ?>
                </tbody>
            </table>
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