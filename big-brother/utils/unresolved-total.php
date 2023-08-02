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
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV"  && $account_type != "DEV" && $account_type != "QA") {
    header("Location: ../../login");
}

if ($sql = $mysqli->prepare("SELECT count(*) FROM exceptions WHERE resolved = FALSE")) {
    $sql->execute();
    $results2 = $sql->get_result();
    $results = $results2->fetch_array(MYSQLI_NUM);
    $results2->free_result();
    $sql->free_result();
    $proxies = $results[0];
    echo $proxies;
} else {
    echo 'ERROR';
}