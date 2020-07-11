<?php
include_once '../../database/db-connect.php';
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