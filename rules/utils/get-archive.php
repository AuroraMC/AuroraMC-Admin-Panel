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
    header("Location: ../../login");
    return;
}


if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC") {
    header("Location: ../../login");
    return;
}

$rules = array();
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_NUMBER_INT);
if ($sql = $mysqli->prepare("SELECT * FROM rules WHERE active = 0 ORDER BY type ASC, weight ASC, rule_id ASC")) {
    $sql->execute();    // Execute the prepared query.

    $id = null;
    $name = null;
    $description = null;
    $weight = null;
    $type = null;
    $requires_warning = null;
    $active = null;

    $sql->bind_result($id, $name, $description, $weight, $requires_warning, $type, $active);


    while ($sql->fetch()) {
        if ($active = 1) {
            $rules[] = array(
                "id" => $id,
                "name" => $name,
                "description" => $description,
                "weight" => intval($weight),
                "requires_warning" => $requires_warning,
                "type" => intval($type),
                "active" => $active
            );
        }
    }
    echo json_encode($rules);

} else {
    echo '{"error": "Something went wrong attempting to connect to the Database."}';
}