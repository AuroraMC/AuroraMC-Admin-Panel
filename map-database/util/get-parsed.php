<?php
/*
 * Copyright (c) 2024 Ethan P-B. All Rights Reserved.
 */

include_once "../../database/db-connect.php";
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

if ($sql = $mysqli->prepare("SELECT parse_id,map_id,map_name,map_author,game,build_server_maps.world_name,parse_number,parse_version,last_modified FROM maps INNER JOIN build_server_maps ON maps.map_id=build_server_maps.id WHERE parse_version = 'TEST'")) {
    $sql->execute();    // Execute the prepared query.
    $result2 = $sql->get_result();
    $numRows = $result2->num_rows;
    $results = $result2->fetch_all(MYSQLI_ASSOC);
    $result2->free_result();
    $sql->free_result();

    $maps = array();
    foreach ($results as $result) {
        if ($redis->sIsMember("map.additions", $result['map_id'])) {
            continue;
        }

        $map = array(
            "id" => $result['map_id'],
            "name" => $result['map_name'],
            "author" => $result['map_author'],
            "game" => $result['game'],
            "world_name" => $result['world_name'],
            "parse_number" => $result['parse_number']
        );
        $maps[] = $map;

    }
    echo json_encode($maps);
} else {
    echo '{"error":"An exception occurred when attempting to connect to the Database."}';
}