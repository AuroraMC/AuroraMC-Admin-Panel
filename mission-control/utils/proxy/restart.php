<?php
if (isset($_POST['proxy'], $_POST['network'])) {
    $server = filter_input(INPUT_POST, 'proxy', FILTER_SANITIZE_STRING);
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);

    $host = "auroramc.block2block.me";
    $port = 35567;
    $data = "restartproxy;". $network . ";" . $server ."\r\n";

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