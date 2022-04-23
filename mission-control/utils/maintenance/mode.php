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

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV") {
    header("Location: ../../../login");
}
if (isset($_POST['network'], $_POST['mode'])) {
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);
    $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);

    $host = "mc.supersecretsettings.dev";
    $port = 35567;
    $data = "maintenancemode;". $network . ";" . $mode . "\r\n";

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