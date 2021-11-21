<?php
if (isset($_POST['server'], $_POST['network'])) {
    $server = filter_input(INPUT_POST, 'server', FILTER_SANITIZE_STRING);
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);

    $host = "auroramc.block2block.me";
    $port = 35567;
    $data = "closeserver;". $network . ";" . $server ."\r\n";

    socket_send($host, $port, $data);
}