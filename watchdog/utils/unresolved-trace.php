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

if (isset($_POST["uuid"])) {
    $uuid2 = urldecode(filter_input(INPUT_POST, 'uuid', FILTER_SANITIZE_STRING));
    if ($sql = $mysqli->prepare("SELECT * FROM exceptions WHERE uuid = ? LIMIT 250")) {
        $sql->bind_param('s', $uuid2);
        $sql->execute();

        $uuid = null;
        $timestamp = null;
        $exception_name = null;
        $trace = null;
        $server = null;
        $proxy = null;
        $player_uuid = null;
        $player_name = null;
        $command = null;
        $server_data = null;
        $resolved = null;
        $issue = null;
        $other_occurrences = null;

        $sql->bind_result($uuid, $timestamp, $exception_name, $trace, $server, $proxy, $player_uuid, $player_name, $command, $server_data, $resolved, $issue, $other_occurrences);

        if ($sql->fetch()) {
            $sql->store_result();
            $sql->free_result();


            $response = array(
                "uuid" => $uuid,
                "timestamp" => $timestamp,
                "exception" => $exception_name,
                "trace" => $trace,
                "server" => $server,
                "proxy" => $proxy,
                "player_uuid" => (($player_uuid == null)?"N/A":$player_uuid),
                "player_name" => (($player_name == null)?"N/A":$player_name),
                "command" => (($command == null)?"N/A":$command),
                "server_data" => $server_data,
                "resolved" => $resolved,
                "issue" => (($issue == null)?"NONE":$issue),
                "other_occurrences" => count(json_decode($other_occurrences))
            );

            echo json_encode($response);
        } else {
            echo '{"error":"That exception does not exist!"}';
        }
    } else {
        echo '{"error":"An exception occurred when attempting to connect to the Database."}';
    }
}