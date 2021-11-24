<?php
include_once '../../database/db-connect.php';

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV") {
    header("Location: ../../login");
}
if (isset($_POST['server'], $_POST['network'])) {
    $server = filter_input(INPUT_POST, 'server', FILTER_SANITIZE_STRING);
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);

    if ($network == "MAIN" && $account_type == "DEV") {
        echo "You do not have permission to manage servers on the main network.";
        return;
    }

    $host = "auroramc.block2block.me";
    $port = 35567;
    $data = "restartserver;". $network . ";" . $server ."\r\n";

    if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === FALSE) {
        echo "Failed to initialise socket.";
    } else {
        if (($result = socket_connect($socket, $host, $port)) === false) {
            echo "Failed to create connection.";
        } else {
            socket_write($socket, $data, strlen($data));

            while (($out = socket_read($socket, 2048)) != "") {
                echo $out;
            }
        }
        socket_close($socket);
    }
}