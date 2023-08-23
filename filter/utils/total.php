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

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV" && $account_type != "RC" && $account_type != "QA") {
    header("Location: ../../login");
    return;
}

$total_core = count($redis->sMembers("filter.core"));
$total_whitelist = count($redis->sMembers("filter.whitelist"));
$total_blacklist = count($redis->sMembers("filter.blacklist"));
$total_phrases = count($redis->sMembers("filter.phrases"));
$total_replacements = count($redis->sMembers("filter.replacements"));

$arr = array(
  "CORE" => $total_core,
    "WHITELIST" => $total_whitelist,
    "BLACKLIST" => $total_blacklist,
    "PHRASES" => $total_phrases,
    "REPLACEMENTS" => $total_replacements
);

echo json_encode($arr);