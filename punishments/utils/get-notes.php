<?php
/*
 * Copyright (c) 2023 AuroraMC Ltd. All Rights Reserved.
 *
 * PRIVATE AND CONFIDENTIAL - Distribution and usage outside the scope of your job description is explicitly forbidden except in circumstances where a company director has expressly given written permission to do so.
 */

function username_to_uuid($username) {
    $profile = username_to_profile($username);
    if (is_array($profile) and isset($profile['id'])) {
        return $profile['id'];
    }
    return false;
}


/**
 * Get Profile (Username and UUID) from username
 *
 * @uses http://wiki.vg/Mojang_API#Username_-.3E_UUID_at_time
 *
 * @param  string      $username
 * @return array|bool  Array with id and name, false on failure
 */
function username_to_profile($username) {
    if (is_valid_username($username)) {
        $json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $username);
        if (!empty($json)) {
            $data = json_decode($json, true);
            if (is_array($data) and !empty($data)) {
                return $data;
            }
        }
    }
    return false;
}


/**
 * Get username from UUID
 *
 * @uses http://wiki.vg/Mojang_API#UUID_-.3E_Name_history
 *
 * @param  string       $uuid
 * @return string|bool  Username on success, false on failure
 */
function uuid_to_username($uuid) {
    $uuid = minify_uuid($uuid);
    if (is_string($uuid)) {
        $json = file_get_contents('https://api.mojang.com/user/profiles/' . $uuid . '/names');
        if (!empty($json)) {
            $data = json_decode($json, true);
            if (!empty($data) and is_array($data)) {
                $last = array_pop($data);
                if (is_array($last) and isset($last['name'])) {
                    return $last['name'];
                }
            }
        }
    }
    return false;
}


/**
 * Check if string is a valid Minecraft username
 *
 * @param  string $string to check
 * @return bool   Whether username is valid or not
 */
function is_valid_username($string) {
    return is_string($string) and strlen($string) >= 2 and strlen($string) <= 16 and ctype_alnum(str_replace('_', '', $string));
}


/**
 * Remove dashes from UUID
 *
 * @param  string       $uuid
 * @return string|bool  UUID without dashes (32 chars), false on failure
 */
function minify_uuid($uuid) {
    if (is_string($uuid)) {
        $minified = str_replace('-', '', $uuid);
        if (strlen($minified) === 32) {
            return $minified;
        }
    }
    return false;
}


/**
 * Add dashes to an UUID
 *
 * @param  string       $uuid
 * @return string|bool  UUID with dashes (36 chars), false on failure
 */
function format_uuid($uuid) {
    $uuid = minify_uuid($uuid);
    if (is_string($uuid)) {
        return substr($uuid, 0, 8) . '-' . substr($uuid, 8, 4) . '-' . substr($uuid, 12, 4) . '-' . substr($uuid, 16, 4) . '-' . substr($uuid, 20, 12);
    }
    return false;
}


include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../login");
    return;
}


$punishments = array();
if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "RC") {
    header("Location: ../login");
    return;
}


if (isset($_GET["user"])) {
    $raw_name = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
    $uuid = username_to_uuid($raw_name);
    if (!$uuid) {
        echo '{"error": "Could not find a player by that name."}';
        return;
    }
    $part1 = substr($uuid, 0, 8);
    $part2 = substr($uuid, 8, 4);
    $part3 = substr($uuid, 12, 4);
    $part4 = substr($uuid, 16, 4);
    $part5 = substr($uuid, 20, 12);
    $user = $part1 . "-" . $part2 . "-" . $part3 . "-" . $part4 . "-" . $part5;
    if ($sql = $mysqli->prepare("SELECT admin_notes.note_id,admin_notes.user_id,auroramc_players.name,auroramc_players.uuid,admin_notes.added_by,admin_notes.timestamp,admin_notes.note FROM admin_notes INNER JOIN auroramc_players ON auroramc_players.id=admin_notes.user_id WHERE (user_id = (SELECT id FROM auroramc_players WHERE uuid = ?)) ORDER BY timestamp DESC")) {
        $sql->bind_param('s', $user);
        $sql->execute();    // Execute the prepared query.
        $result2 = $sql->get_result();
        $numRows = $result2->num_rows;
        $results = $result2->fetch_all(MYSQLI_ASSOC);
        $result2->free_result();
        $sql->free_result();
        if ($numRows > 0) {
            $data = array();
            foreach ($results as $result) {
                if ($sql2 = $mysqli->prepare("SELECT name,uuid FROM auroramc_players WHERE id = ?")) {
                    $sql2->bind_param('i', $result['added_by']);
                    $sql2->execute();    // Execute the prepared query.

                    $punisher_name = null;
                    $punisher_uuid = null;

                    $sql2->bind_result($punisher_name, $punisher_uuid);
                    $sql2->fetch();
                    $sql2->store_result();
                    $sql2->free_result();
                    $data[] = array(
                        "note_id" => $result['note_id'],
                        "name" => $result['name'],
                        "uuid" => $user,
                        "note" => $result['note'],
                        "timestamp" => intval($result['timestamp']),
                        "weight" => intval($result['weight']),
                        "added_by" => $punisher_name,
                        "added_by_uuid" => $punisher_uuid,
                    );
                } else {
                    echo '{"error": "Something went wrong attempting to connect to the Database."}';
                    return;
                }
            }
            echo json_encode($data);
        } else {
            echo '{"error": "Notes for that user could not be found."}';
        }
    } else {
        echo '{"error": "Something went wrong attempting to connect to the Database."}';
    }
} else {
    echo '{"error": "No valid user was provided."}';
}



