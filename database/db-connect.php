<?php
include_once 'db-config.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$redis = new Redis();
$redis->connect(REDIS_LOCATION, REDIS_PORT, REDIS_TIMEOUT, NULL, 0, 0);
$redis->auth(REDIS_PASSWORD);