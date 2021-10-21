<?php

include_once '../../database/db-connect.php';

if (isset($_POST['stat'], $_POST['time'])) {
    $stat = filter_input(INPUT_POST, 'stat', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);

    $query = "";

    switch ($stat) {
        case "GAME_PLAYER_TOTAL": {

        }
        case "NETWORK_PLAYER_TOTALS": {

        }
        case "NETWORK_PROXY_TOTALS": {

        }
        case "NETWORK_SERVER_TOTALS": {

        }
        case "UNIQUE_PLAYER_TOTALS": {

        }
        case "UNIQUE_PLAYER_JOINS": {

        }
        default: {
            return;
        }
    }
}