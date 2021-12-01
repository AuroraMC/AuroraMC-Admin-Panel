<?php
/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

include_once '../../../database/db-connect.php';
include_once "../../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../../login");
}

if ($account_type != "OWNER") {
    header("Location: ../../../login");
}
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