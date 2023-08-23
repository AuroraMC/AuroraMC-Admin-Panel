<?php
/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

include_once '../../../database/db-connect.php';
include_once "../../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../../login");
    return;
}

if ($account_type != "OWNER") {
    header("Location: ../../../login");
    return;
}
if (isset($_POST['network'], $_POST['game'])) {
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);
    $game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_STRING);

    $host = "mc.supersecretsettings.dev";
    $port = 35567;
    $data = "enablegame;". $network . ";" . $game . "\r\n";

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