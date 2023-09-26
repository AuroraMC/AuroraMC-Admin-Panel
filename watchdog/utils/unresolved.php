<?php
/*
 * Copyright (c) 2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

include_once "../../database/db-connect.php";
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV"  && $account_type != "DEV" && $account_type != "QA") {
    header("Location: ../../login");
    return;
}

if ($sql = $mysqli->prepare("SELECT * FROM exceptions WHERE resolved = FALSE LIMIT 250")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_all(MYSQLI_ASSOC);
    $results2->free_result();
    $sql->free_result();


    $traces = array();
    foreach ($results as $result) {
        $trace = array(
            "uuid" => $result["uuid"],
            "timestamp" => $result["timestamp"],
            "exception" => $result["exception_name"],
            "location" => $result["server_name"],
            "player_name" => (($result["player_name"] === null)?"N/A":$result["player_name"]),
            "player_uuid" => (($result["player"] === null)?"N/A":$result["player"]),
            "command" => (($result["command"] === null)?"N/A":$result["command"]),
            "other_occurrences" => count(json_decode($result["other_occurrences"]))
        );
        $traces[] = json_encode($trace);
    }
    echo json_encode($traces);
} else {
    echo '{"error":"An exception occurred when attempting to connect to the Database."}';
}