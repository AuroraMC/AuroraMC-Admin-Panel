<?php

include_once '../socket-util.php';

if (isset($_POST['server'], $_POST['network'], $_POST['game'], $_POST['extradetails'])) {
    $server = filter_input(INPUT_POST, 'server', FILTER_SANITIZE_STRING);
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);
    $game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_STRING);
    $extra_details = filter_input(INPUT_POST, 'extradetails', FILTER_SANITIZE_STRING);

    $host = "auroramc.block2block.me";
    $port = 35567;
    $data = "createserver;". $network . ";" . $game . ";" . $server . ";" . $extra_details ."\r\n";

    socket_send($host, $port, $data);
}