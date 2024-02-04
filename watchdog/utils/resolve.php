<?php
/*
 * Copyright (c) 2023-2024 Ethan P-B. All Rights Reserved.
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
    $uuid = urldecode(filter_input(INPUT_POST, 'uuid', FILTER_SANITIZE_STRING));
    if ($sql = $mysqli->prepare("UPDATE exceptions SET resolved = TRUE WHERE uuid = ?")) {
        $sql->bind_param("s", $uuid);
        $sql->execute();
        echo "SUCCESS";
    } else {
        echo 'ERROR';
    }
} else {
    echo "A UUID was not provided.";
}

