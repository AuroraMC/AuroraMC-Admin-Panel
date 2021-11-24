<?php
if (isset($_POST['data'])) {
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);

    $data = str_replace(";", " ", $data);

    $host = "auroramc.block2block.me";
    $port = 35567;
    $data = "updatenetwork;". $data . "\r\n";

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