<?php
/*
 * Copyright (c) 2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */
include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../login");
    return;
}


$punishments = array();
if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC" && $account_type != "STAFF") {
    header("Location: ../login");
    return;
}


if (isset($_GET["code"])) {
    $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
    if ($sql = $mysqli->prepare("SELECT punishments.punishment_id,punishments.amc_id,rules.name AS rule_name, rules.type, rules.weight,punishments.notes,punishments.punisher,punishments.issued,punishments.expire,punishments.status,punishments.evidence,punishments.suffix,punishments.removal_reason,punishments.remover,punishments.removal_timestamp,auroramc_players.name,auroramc_players.uuid FROM punishments INNER JOIN auroramc_players ON auroramc_players.id=punishments.amc_id INNER JOIN rules ON punishments.rule_id = rules.rule_id WHERE punishment_id = ? ORDER BY issued DESC")) {
        $sql->bind_param('s', $code);
        $sql->execute();    // Execute the prepared query.
        $result2 = $sql->get_result();
        $numRows = $result2->num_rows;
        $results = $result2->fetch_all(MYSQLI_ASSOC);
        $result2->free_result();
        $sql->free_result();
        if ($numRows > 0) {
            $result = $results[0];
            if ($sql2 = $mysqli->prepare("SELECT name,uuid FROM auroramc_players WHERE id = ?")) {
                $sql2->bind_param('i', $result['punisher']);
                $sql2->execute();    // Execute the prepared query.

                $punisher_name = null;
                $punisher_uuid = null;

                $sql2->bind_result($punisher_name, $punisher_uuid);
                $sql2->fetch();
                $sql2->store_result();
                $sql2->free_result();
                $data = array(
                    "code" => $result['punishment_id'],
                    "status" => intval($result['status']),
                    "punished_name" => $result['name'],
                    "punished_uuid" => $result['uuid'],
                    "type" => intval($result['type']),
                    "weight" => intval($result['weight']),
                    "rule" => $result['rule_name'],
                    "notes" => $result['notes'],
                    "issued" => intval($result['issued']),
                    "expire" => intval($result['expire']),
                    "punisher_name" => $punisher_name,
                    "punisher_uuid" => $punisher_uuid,
                    "evidence" => (($result["evidence"] === null) ? "NONE" : ((str_starts_with($result["evidence"], "http://") || str_starts_with($result["evidence"], "https://"))?"":"http://") . $result["evidence"]),
                    "removal_reason" => (($result["removal_reason"] === null) ? "N/A" : $result["removal_reason"]),
                    "removal_timestamp" => (($result["removal_timestamp"] === null) ? "N/A" : intval($result["removal_timestamp"])),
                    "remover" => (($result["remover"] === null) ? "N/A" : $result["remover"]),
                );
                echo json_encode($data);
            } else {
                echo '{"error": "Something went wrong attempting to connect to the Database."}';
            }

        } else {
            echo '{"error": "That punishment could not be found."}';
        }
    } else {
        echo '{"error": "Something went wrong attempting to connect to the Database."}';
    }
} else {
    echo '{"error": "No valid code was provided."}';
}



