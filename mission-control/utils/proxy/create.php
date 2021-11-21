<?php
if (isset($_POST['network'], $_POST['extradetails'])) {
    $network = filter_input(INPUT_POST, 'network', FILTER_SANITIZE_STRING);
    $extra_details = filter_input(INPUT_POST, 'extradetails', FILTER_SANITIZE_STRING);

    $host = "auroramc.block2block.me";
    $port = 35567;
    $data = "createproxy;". $network . ";" . $extra_details ."\r\n";

    socket_send($host, $port, $data);
}