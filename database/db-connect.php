<?php
/*
 * Copyright (c) 2021-2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

include_once 'db-config.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$redis = new Redis();
$redis->connect(REDIS_LOCATION, REDIS_PORT, REDIS_TIMEOUT, NULL, 0, 0);
$redis->auth(REDIS_PASSWORD);