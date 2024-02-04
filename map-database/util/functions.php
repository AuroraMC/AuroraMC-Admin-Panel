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

if(isset($_POST['addNew'])) {
    $id = filter_input(INPUT_POST, 'addNew', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("map.additions", $id)) {
        $redis->sAdd("map.additions", $id);
    }
}

if(isset($_POST['removeNew'])) {
    $id = filter_input(INPUT_POST, 'removeNew', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("map.additions", $id)) {
        $redis->sRem("map.additions", $id);
    }
}

if(isset($_POST['removeOld'])) {
    $id = filter_input(INPUT_POST, 'removeOld', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("map.removals", $id)) {
        $redis->sAdd("map.removals", $id);
    }
}

if(isset($_POST['addOld'])) {
    $id = filter_input(INPUT_POST, 'addOld', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("map.removals", $id)) {
        $redis->sRem("map.removals", $id);
    }
}