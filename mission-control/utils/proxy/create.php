<?php
/*
 * Copyright (c) 2021-2024 Ethan P-B. All Rights Reserved.
 */

include_once '../../../database/db-connect.php';
include_once "../../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV") {
    header("Location: ../../../login");
    return;
}
if (isset($_POST['network'], $_POST['extradetails'])) {
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);
    $extra_details = filter_input(INPUT_POST, 'extradetails', FILTER_SANITIZE_STRING);

    if ($network == "MAIN" && $account_type == "DEV") {
        echo "You do not have permission to manage servers on the main network.";
        return;
    }

    $host = "mc.supersecretsettings.dev";
    $port = 35567;
    $data = "createproxy;". $network . ";" . $extra_details ."\r\n";

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