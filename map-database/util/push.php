<?php
/*
 * Copyright (c) 2021-2024 Ethan P-B. All Rights Reserved.
 */

include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV") {
    header("Location: ../../login");
    return;
}

$additions = $redis->sMembers("map.additions");
$removals = $redis->sMembers("map.removals");

foreach ($removals as $removal) {
    if ($sql = $mysqli->prepare("UPDATE maps SET parse_version = 'ARCHIVED' WHERE map_id = ? AND parse_version = 'LIVE'")) {
        $sql->bind_param('s', $removal);
        $sql->execute();    // Execute the prepared query.
    }
}

foreach ($additions as $addition) {
    if ($sql = $mysqli->prepare("SELECT count(*) FROM maps WHERE parse_version = 'LIVE' AND map_id = ?")) {
        $sql->bind_param('s', $addition);
        $sql->execute();
        $results2 = $sql->get_result();
        $results = $results2->fetch_array(MYSQLI_NUM);
        $results2->free_result();
        $sql->free_result();
        $maps = $results[0];
        if ($maps > 0) {
            if ($sql2 = $mysqli->prepare("DELETE FROM maps WHERE parse_version = 'LIVE' AND map_id = ?")) {
                $sql2->bind_param('s', $addition);
                $sql2->execute();
            }
        }
    }
    if ($sql3 = $mysqli->prepare("INSERT INTO maps(map_id, map_name, map_author, parse_number, parse_version, zip) SELECT map_id, map_name, map_author, parse_number, 'LIVE', zip from maps WHERE map_id = ? AND parse_version = 'TEST'")) {
        $sql3->bind_param('s', $addition);
        $sql3->execute();    // Execute the prepared query.
    }
}

$redis->del("map.additions");
$redis->del("map.removals");

    $host = "mc.supersecretsettings.dev";
    $port = 35567;
    $data = "updatemaps\r\n";

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