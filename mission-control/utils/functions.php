<?php
/*
 * Copyright (c) 2021 AuroraMC Ltd. All Rights Reserved.
 */

include_once '../../database/db-connect.php';
include_once "../../utils/functions.php";

sec_session_start();

$account_type = login_check($mysqli);
if (!$account_type) {
    header("Location: ../../login");
}

if ($account_type != "OWNER" && $account_type != "ADMIN" && $account_type != "SR_DEV" && $account_type != "DEV") {
    header("Location: ../../login");
}

if (isset($_POST['stat'], $_POST['time'])) {
    $stat = filter_input(INPUT_POST, 'stat', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);

    $games = ["CRYSTAL_QUEST"=>"Crystal Quest","LOBBY"=>"Lobby","BUILD"=>"Build Server", "EVENT"=>"Event Server", "STAFF"=>"Staff Server", "RUN"=>"Run", "TAG"=>"Tag", "HOT_POTATO"=>"Hot Potato", "FFA"=>"FFA", "SPLEEF"=>"Spleef", "PAINTBALL"=>"Paintball", "BACKSTAB"=>"Backstab", "DUELS"=>"Duels"];
    $xTitle = ["NETWORK_PLAYER_TOTALS"=>"Online Players", "NETWORK_PROXY_TOTALS"=>"Proxies", "UNIQUE_PLAYER_TOTALS"=> "Total Unique Players", "UNIQUE_PLAYER_JOINS"=>"New Players Joined"];

    $query = "";

    $splitIntoGames = false;

    switch ($stat) {
        case "NETWORK_PLAYER_TOTALS":
        case "NETWORK_PROXY_TOTALS":
        case "UNIQUE_PLAYER_TOTALS":
        case "UNIQUE_PLAYER_JOINS":
            break;
        case "NETWORK_SERVER_TOTALS":
        case "GAMES_STARTED":
        case "GAME_PLAYER_TOTAL":
        CASE "PLAYERS_PER_GAME":
            $splitIntoGames = true;
            break;
        default: {
            return;
        }
    }

    $dividor = -1;

    $time = strtoupper($time);
    switch ($time) {
        case "DAILY": {
            $dividor = 86400;
            break;
        }
        case "WEEKLY": {
            $dividor = 86400 * 7;
            break;
        }
        case "ALLTIME": {
            break;
        }
        default: {
            return;
        }
    }


    $stats = $redis->sMembers("stat." . $stat . "." . $time);
    $statParsed = array();
    foreach ($stats as $stat2) {
        $split = explode(";", $stat2, 3);
        if ($dividor != -1) {
            $timestamp = floatval($split[0]);
            if (time() - ($timestamp/1000) >= $dividor) {
                $redis->sRem("stat." . $stat . "." . $time, $stat2);
                continue;
            }
        }
        if ($splitIntoGames) {
            $statParsed[$split[2]][] = "{\"x\":" . $split[0] . ",\"y\":" . $split[1] . "}";
        } else {
            $statParsed[] = "{\"x\":" . $split[0] . ",\"y\":" . $split[1] . "}";
        }
    }

    if ($splitIntoGames) {
        $statsParsed = array();
        foreach ($statParsed as $game=>$stat2) {
            $statsParsed[] = "{\"name\": \"" . $games[$game] . "\",\"data\": [" . join(",", $stat2) . "]}";
        }
        echo "[" . join(",",$statsParsed) . "]";
    } else {
        echo "[{\"name\": \"" . $xTitle[$stat] . "\",\"data\": [" . join(",", $statParsed) . "]}]";
    }
}