<?php
/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC" && $account_type != "APPEALS" && $account_type != "QA") {
    header("Location: ../../../login");
}


if (isset($_POST['remove'])) {
    $name = filter_input(INPUT_POST, 'remove', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("usernamebans", strtolower($name))) {
        $redis->sRem("usernamebans", strtolower($name));
    }
}

if (isset($_POST['add'])) {
    $name = filter_input(INPUT_POST, 'add', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("usernamebans", strtolower($name))) {
        $redis->sAdd("usernamebans", strtolower($name));
    }
}