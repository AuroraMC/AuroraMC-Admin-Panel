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

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC" && $account_type != "APPEALS" && $account_type != "STAFF" && $account_type != "QA") {
    header("Location: ../login");
    return;
}

$daily = array();
$monthly = array();
$alltime = array();


// ALLTIME PUNISHMENT STATS
if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $alltime["issued"] = $results[0];
} else {
    $alltime["issued"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 2")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $alltime["pending"] = $results[0];
} else {
    $alltime["pending"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 4")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $alltime["denied"] = $results[0];
} else {
    $alltime["denied"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 3 OR status = 6")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $alltime["approved"] = $results[0];
} else {
    $alltime["approved"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 1")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $alltime["forums"] = $results[0];
} else {
    $alltime["forums"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 2")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $alltime["nova"] = $results[0];
} else {
    $alltime["nova"] = "ERROR";
}

// 30D PUNISHMENT STATS
$timestamp = round(microtime(true) * 1000) - 2592000000;
if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $monthly["issued"] = $results[0];
} else {
    $monthly["issued"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 4 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $monthly["denied"] = $results[0];
} else {
    $monthly["denied"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE (status = 3 OR status = 6) AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $monthly["approved"] = $results[0];
} else {
    $monthly["approved"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 1 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $monthly["forums"] = $results[0];
} else {
    $monthly["forums"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 2 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $monthly["nova"] = $results[0];
} else {
    $monthly["nova"] = "ERROR";
}

// 24HR PUNISHMENT STATS
$timestamp = round(microtime(true) * 1000) - 86400000;
if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $daily["issued"] = $results[0];
} else {
    $daily["issued"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE status = 4 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $daily["denied"] = $results[0];
} else {
    $daily["denied"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE (status = 3 OR status = 6) AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $daily["approved"] = $results[0];
} else {
    $daily["approved"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 1 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $daily["forums"] = $results[0];
} else {
    $daily["forums"] = "ERROR";
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM punishments WHERE suffix = 2 AND CONVERT(issued, UNSIGNED INTEGER) > ?")) {
    $sql->bind_param('i', $timestamp);
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $daily["nova"] = $results[0];
} else {
    $daily["nova"] = "ERROR";
}



$data = array(
    "daily" => $daily,
    "monthly" => $monthly,
    "alltime" => $alltime
);

echo json_encode($data);