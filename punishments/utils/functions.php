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

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC" && $account_type != "APPEALS" && $account_type != "STAFF" && $account_type != "QA") {
    header("Location: ../../login");
    return;
}

if (isset($_POST['remove']) and isset($_POST['reason']) and isset($_POST['type']) and isset($_POST['uuid']) and isset($_POST['status'])) {
    $id = filter_input(INPUT_POST, 'remove', FILTER_SANITIZE_STRING);
    $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);
    $uuid = filter_input(INPUT_POST, 'uuid', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    $newstatus = (($status == 1)?5:(($status == 2)?4:6));
    $reason = urldecode($reason);
    $timestamp = round(microtime(true) * 1000);

    if ($sql = $mysqli->prepare("UPDATE punishments SET removal_reason = ?,remover='AuroraMC',removal_timestamp=?,status=? WHERE punishment_id = ?")) {
        $sql->bind_param('ssis',$reason, $timestamp, $newstatus, $id);
        $sql->execute();
        if ($type != 1) {
            //This is a ban, remove it from REDIS
            if ($redis->exists("bans." . $uuid)) {
                $current_ban = $redis->get("bans." . $uuid);
                $current_ban = explode(";", $current_ban);
                $code = $current_ban[5];
                if ($code == $id) {
                    if ($sql = $mysqli->prepare("SELECT * FROM punishments WHERE amc_id = (SELECT id FROM auroramc_players WHERE uuid = ?) AND (status = 1 OR status = 2 OR status = 3)")) {
                        $sql->bind_param('s', $uuid);
                        $sql->execute();
                        $result2 = $sql->get_result();
                        $numRows = $result2->num_rows;
                        $results = $result2->fetch_all(MYSQLI_ASSOC);
                        $result2->free_result();
                        $sql->free_result();

                        foreach ($results as $result) {
                            if ($sql2 = $mysqli->prepare("SELECT * FROM rules WHERE rule_id = ?")) {
                                $sql2->bind_param('i', $result['rule_id']);
                                $sql2->execute();    // Execute the prepared query.

                                $rule_name = null;
                                $description = null;
                                $weight = null;
                                $rule_type = null;
                                $requires_warning = null;
                                $active = null;

                                $sql2->bind_result($rule_id, $rule_name, $description, $weight, $requires_warning, $type, $active);
                                $sql2->fetch();
                                $sql2->store_result();
                                $sql2->free_result();
                                if ($rule_type != 1 and ((intval($result['expire']) > $timestamp) or intval($result['expire']) == -1) and $result['remover'] == null and $code != $result['punishment_id']) {
                                    //This is an active ban, add this one instead.
                                    $redis->set("ban." . $uuid, $rule_id . ";" . $result['notes'] . ';' . $result['status'] . ';' . $result['issued'] . ';' . $result['expire'] . ';' . $result['punishment_id']);

                                    if (intval($result['expire']) != -1) {
                                        $redis->expire("ban." . $uuid, (intval($result['expire']) - $timestamp)/1000);
                                    }

                                    return;
                                }
                            }
                        }
                        $redis->del("bans." . $uuid);
                    } else {
                        $redis->del("bans." . $uuid);
                    }
                }
            }
        }
    } else {
        echo 'error';
    }
}

if (isset($_POST['deny']) and isset($_POST['type']) and isset($_POST['uuid']) and ($account_type == "OWNER" || $account_type == "ADMIN" || $account_type == "SR_DEV" || $account_type == "RC" || $account_type == "STAFF")) {
    $id = filter_input(INPUT_POST, 'deny', FILTER_SANITIZE_STRING);
    $uuid = filter_input(INPUT_POST, 'uuid', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_NUMBER_INT);
    $timestamp = round(microtime(true) * 1000);

    if ($sql = $mysqli->prepare("UPDATE punishments SET status=4 WHERE punishment_id = ?")) {
        $sql->bind_param('s',$id);
        $sql->execute();
        if ($type != 1) {
            //This is a ban, remove it from REDIS
            if ($redis->exists("bans." . $uuid)) {
                $current_ban = $redis->get("bans." . $uuid);
                $current_ban = explode(";", $current_ban);
                $code = $current_ban[5];
                if ($code == $id) {
                    if ($sql = $mysqli->prepare("SELECT * FROM punishments WHERE amc_id = (SELECT id FROM auroramc_players WHERE uuid = ?) AND (status = 1 OR status = 2 OR status = 3)")) {
                        $sql->bind_param('s', $uuid);
                        $sql->execute();
                        $result2 = $sql->get_result();
                        $numRows = $result2->num_rows;
                        $results = $result2->fetch_all(MYSQLI_ASSOC);
                        $result2->free_result();
                        $sql->free_result();

                        foreach ($results as $result) {
                            if ($sql2 = $mysqli->prepare("SELECT * FROM rules WHERE rule_id = ?")) {
                                $sql2->bind_param('i', $result['rule_id']);
                                $sql2->execute();    // Execute the prepared query.

                                $rule_name = null;
                                $description = null;
                                $weight = null;
                                $rule_type = null;
                                $requires_warning = null;
                                $active = null;

                                $sql2->bind_result($rule_id, $rule_name, $description, $weight, $requires_warning, $type, $active);
                                $sql2->fetch();
                                $sql2->store_result();
                                $sql2->free_result();
                                if ($rule_type != 1 and ((intval($result['expire']) > $timestamp) or intval($result['expire']) == -1) and $result['remover'] == null and $code != $result['punishment_id']) {
                                    //This is an active ban, add this one instead.
                                    $redis->set("ban." . $uuid, $rule_id . ";" . $result['notes'] . ';' . $result['status'] . ';' . $result['issued'] . ';' . $result['expire'] . ';' . $result['punishment_id']);

                                    if (intval($result['expire']) != -1) {
                                        $redis->expire("ban." . $uuid, (intval($result['expire']) - $timestamp)/1000);
                                    }

                                    return;
                                }
                            }
                        }
                        if ($redis->sIsMember("bans", $uuid)) {
                            $redis->sRem("bans", $uuid);
                        }
                        $redis->del("bans." . $uuid);
                    } else {
                        $redis->del("bans." . $uuid);
                    }
                }
            } else {
                if ($redis->sIsMember("bans", $uuid)) {
                    $redis->sRem("bans", $uuid);
                }
            }
        }
    } else {
        echo 'error';
    }
}

if (isset($_POST['approve']) and isset($_POST['type']) and isset($_POST['uuid']) and ($account_type == "OWNER" || $account_type == "ADMIN" || $account_type == "SR_DEV" || $account_type == "RC" || $account_type == "STAFF")) {
    $id = filter_input(INPUT_POST, 'approve', FILTER_SANITIZE_STRING);
    $uuid = filter_input(INPUT_POST, 'uuid', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_NUMBER_INT);
    $timestamp = round(microtime(true) * 1000);

    if ($sql = $mysqli->prepare("UPDATE punishments SET status = 3 WHERE punishment_id = ?")) {
        $sql->bind_param('s',$id);
        $sql->execute();
        if ($type != 1) {
            //This is a ban, remove it from REDIS
            if ($redis->exists("bans." . $uuid)) {
                $current_ban = $redis->get("bans." . $uuid);
                $current_ban = explode(";", $current_ban);
                $code = $current_ban[5];
                if ($code == $id) {
                    $current_ban[2] = '3';
                    $ttl = $redis->ttl("bans." . $uuid);
                    $redis->set("bans." . $uuid, implode(";", $current_ban));
                    if ($ttl > 0) {
                        $redis->expire("bans." . $uuid,$ttl);
                    }
                }
            } else {
                if ($redis->sIsMember("bans", $uuid)) {
                    $redis->sRem("bans", $uuid);
                }
            }
        }
    } else {
        echo 'error';
    }
}
