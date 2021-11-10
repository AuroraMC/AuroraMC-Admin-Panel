<?php

include_once '../../database/db-connect.php';

if (isset($_POST['stat'], $_POST['time'])) {
    $stat = filter_input(INPUT_POST, 'stat', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);

    $games = ["CRYSTAL_QUEST"=>"Crystal Quest","LOBBY"=>"Lobby","BUILD"=>"Build Server", "EVENT"=>"Event Server", "STAFF"=>"Staff Server", "MIXED_ARCADE"=>"Mixed Arcade"];
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
            $timestamp = intval($split[0]);
            if ($timestamp/1000 >= time() + $dividor) {
                $redis->sRem("stat." . $stat2 . "." . $time, $stat2);
                continue;
            }
        }
        if ($splitIntoGames) {
            $statParsed[$split[2]][] = "{x:" . $split[0] . ",y:" . $split[1] . "}";
        } else {
            $statParsed[] = "{x:" . $split[0] . ",y:" . $split[1] . "}";
        }
    }

    if ($splitIntoGames) {
        $statsParsed = array();
        foreach ($statParsed as $game=>$stat2) {
            $statsParsed[] = "{
                name: '" . $games[$game] . "'',
                data: [" . join(",", $stat2) . "]}";
        }
        echo "[" . join(",",$statsParsed) . "]";
    } else {
        echo "[{
    name: '" . $xTitle[$stat] . "'',
    data: [" . join(",", $statParsed) . "]}]";
    }
}