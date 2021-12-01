<?php
/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV" && $account_type != "RC" && $account_type != "QA") {
    header("Location: ../../../login");
}


if (isset($_POST['removecore'])) {
    $name = filter_input(INPUT_POST, 'removecore', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("filter.core", strtolower($name))) {
        $redis->sRem("filter.core", strtolower($name));
    }
}
if (isset($_POST['addcore'])) {
    $name = filter_input(INPUT_POST, 'addcore', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("filter.core", strtolower($name))) {
        $redis->sAdd("filter.core", strtolower($name));
    }
}

if (isset($_POST['removewhitelist'])) {
    $name = filter_input(INPUT_POST, 'removewhitelist', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("filter.whitelist", strtolower($name))) {
        $redis->sRem("filter.whitelist", strtolower($name));
    }
}
if (isset($_POST['addwhitelist'])) {
    $name = filter_input(INPUT_POST, 'addwhitelist', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("filter.whitelist", strtolower($name))) {
        $redis->sAdd("filter.whitelist", strtolower($name));
    }
}

if (isset($_POST['removeblacklist'])) {
    $name = filter_input(INPUT_POST, 'removeblacklist', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("filter.blacklist", strtolower($name))) {
        $redis->sRem("filter.blacklist", strtolower($name));
    }
}
if (isset($_POST['addblacklist'])) {
    $name = filter_input(INPUT_POST, 'addblacklist', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("filter.blacklist", strtolower($name))) {
        $redis->sAdd("filter.blacklist", strtolower($name));
    }
}

if (isset($_POST['removephrase'])) {
    $name = filter_input(INPUT_POST, 'removephrase', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("filter.phrases", strtolower($name))) {
        $redis->sRem("filter.phrases", strtolower($name));
    }
}
if (isset($_POST['addphrase'])) {
    $name = filter_input(INPUT_POST, 'addphrase', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("filter.phrases", strtolower($name))) {
        $redis->sAdd("filter.phrases", strtolower($name));
    }
}

if (isset($_POST['removereplacement'])) {
    $name = filter_input(INPUT_POST, 'removereplacement', FILTER_SANITIZE_STRING);
    if ($redis->sIsMember("filter.replacements", utf8_decode($name))) {
        $redis->sRem("filter.replacements", utf8_decode($name));
    }
}
if (isset($_POST['addreplacement'])) {
    $name = filter_input(INPUT_POST, 'addreplacement', FILTER_SANITIZE_STRING);
    if (!$redis->sIsMember("filter.replacements", utf8_decode($name))) {
        $redis->sAdd("filter.replacements", utf8_decode($name));
    }
}