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

if ($sql = $mysqli->prepare("SELECT count(*) FROM exceptions")) {
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