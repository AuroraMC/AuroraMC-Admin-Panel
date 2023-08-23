<?php
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

$additions = $redis->sMembers("map.additions");
$removals = $redis->sMembers("map.removals");

$additions_list = array();
$removals_list = array();

foreach ($additions as $addition) {
    if ($sql = $mysqli->prepare("SELECT parse_id,map_id,map_name,map_author,game,build_server_maps.world_name,parse_number,parse_version,last_modified FROM maps INNER JOIN build_server_maps ON maps.map_id=build_server_maps.id WHERE map_id = ? AND parse_version = 'TEST'")) {
        $sql->bind_param("s", $addition);
        $sql->execute();    // Execute the prepared query.
        $result2 = $sql->get_result();
        $numRows = $result2->num_rows;
        $results = $result2->fetch_all(MYSQLI_ASSOC);
        $result2->free_result();
        $sql->free_result();

        $result = $results[0];
            $map = array(
                "id" => $result['map_id'],
                "name" => $result['map_name'],
                "author" => $result['map_author'],
                "game" => $result['game'],
                "world_name" => $result['world_name'],
                "parse_number" => $result['parse_number']
            );
            $additions_list[] = $map;

    } else {
        echo '{"error":"An exception occurred when attempting to connect to the Database."}';
        return;
    }
}

if (count($additions_list) == 0) {
    $additions_list = "NONE";
}

foreach ($removals as $removal) {
    if ($sql = $mysqli->prepare("SELECT parse_id,map_id,map_name,map_author,game,build_server_maps.world_name,parse_number,parse_version,last_modified FROM maps INNER JOIN build_server_maps ON maps.map_id=build_server_maps.id WHERE map_id = ? AND parse_version = 'LIVE'")) {
        $sql->bind_param("s", $removal);
        $sql->execute();    // Execute the prepared query.
        $result2 = $sql->get_result();
        $numRows = $result2->num_rows;
        $results = $result2->fetch_all(MYSQLI_ASSOC);
        $result2->free_result();
        $sql->free_result();

        $result = $results[0];
        $map = array(
            "id" => $result['map_id'],
            "name" => $result['map_name'],
            "author" => $result['map_author'],
            "game" => $result['game'],
            "world_name" => $result['world_name'],
            "parse_number" => $result['parse_number']
        );
        $removals_list[] = $map;

    } else {
        echo '{"error":"An exception occurred when attempting to connect to the Database."}';
        return;
    }
}

if (count($removals_list) == 0) {
    $removals_list = "NONE";
}

$changes = array(
    "additions" => $additions_list,
    "removals" => $removals_list
);

echo json_encode($changes);
