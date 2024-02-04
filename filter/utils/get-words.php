<?php
/*
 * Copyright (c) 2023-2024 Ethan P-B. All Rights Reserved.
 */

include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
    return;
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV" && $account_type != "RC" && $account_type != "QA") {
    header("Location: ../../login");
    return;
}

if (isset($_GET["type"])) {
    $type = urldecode(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING));
    $words = $redis->sMembers("filter." . $type);

    echo json_encode($words);
} else {
    echo '{"error":"You did not provide a valid word type."}';
}